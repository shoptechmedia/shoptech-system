<?php
/**
* 2013-2014 2N Technologies
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to contact@2n-tech.com so we can send you a copy immediately.
*
* @author    2N Technologies <contact@2n-tech.com>
* @copyright 2013-2014 2N Technologies
* @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once 'classes/Reduction.php';
include_once 'classes/Informations.php';

//use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;

class NtReduction extends Module
{
    const TAB_2NT               = 'NTModules';
    const NAME_TAB_2NT          = 'NT Modules';
    const TAB_MODULE            = 'AdminNtreduction';
    const NAME_TAB              = 'NtReduction';
    const INSTALL_SQL_FILE      = 'install.sql';
    const UNINSTALL_SQL_FILE    = 'uninstall.sql';
    const INPUT_PRODUCT         = 36;
    const INPUT_REDUCTION       = 44;
    const INPUT_MAX             = 1000;

    public function __construct()
    {
        $this->name             = 'ntreduction';
        $this->tab              = 'pricing_promotion';
        $this->version          = '2.2.1';
        $this->author           = '2N Technologies';
        $this->need_instance    = 0;
        $this->module_key       = 'a6d4b9c52f00dd81b0174530baa928f0';
        $this->secure_key       = Tools::encrypt($this->name);

        //The constructor must be called after the name has been set,
        //but before you try to use any functions like $this->l()
        parent::__construct();

        $this->displayName = $this->l('2N Technologies Reduction');
        $this->description = $this->l('Easy and fast massive discount');

        $this->tabs[] = array(
            'parent_class'  =>  self::TAB_2NT,
            'parent_name'   =>  self::NAME_TAB_2NT,
            'tab_class'     =>  self::TAB_MODULE,
            'tab_name'      =>  self::NAME_TAB,
        );

        if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
            $this->tabs[] = array(
                'parent_class'  =>  'AdminCatalog',
                'parent_name'   =>  self::NAME_TAB_2NT,
                'tab_class'     =>  self::TAB_MODULE.'Tab',
                'tab_name'      =>  self::NAME_TAB,
            );
        } else {
            $this->tabs[] = array(
                'parent_class'  =>  'AdminPriceRule',
                'parent_name'   =>  self::NAME_TAB_2NT,
                'tab_class'     =>  self::TAB_MODULE.'Tab',
                'tab_name'      =>  self::NAME_TAB,
            );
        }
    }

    /**
    * @see Module::install()
    */
    public function install()
    {
        // Install on tab
        $install_on_tab = true;

        /* Install on tab */
        foreach ($this->tabs as $tab) {
            if (!$this->installOnTab($tab['tab_class'], $tab['tab_name'], $tab['parent_class'], $tab['parent_name'])) {
                $install_on_tab = false;
            }
        }

        if (!$install_on_tab) {
            return false;
        }

        /* Create new data base table */
        $this->executeFile(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE);

        /* Install & config module if necessary */
        if (parent::install() == false
            || !$this->registerHook('displayHeader')
            || !$this->registerHook('actionObjectProductUpdateBefore')
            || !$this->registerHook('displayProductPriceBlock')
        ) {
            Tools::displayError('Error: there is a problem with your module installation');
            return false;
        }

        $columns_to_hide = array(
            'p1_10',
            'p1_11',
            'p1_12',
            'p1_13',
            'p1_14',
            'p1_15',
            'p1_16',
            'p2_10',
            'p2_11',
            'p2_12',
            'p2_13',
            'p2_14',
            'p2_15',
            'p2_16',
            'p_price_no_tax',
            'p_margin_after_discount'
        );

        //We initialize the configuration for all shops
        $shops = Shop::getShops();

        foreach ($shops as $shop) {
            if (!Configuration::updateValue(
                'NTREDUCTION_HIDE_COLUMNS',
                implode(':', $columns_to_hide),
                false,
                $shop['id_shop_group'],
                $shop['id_shop']
            )) {
                return false;
            }

            if (!Configuration::updateValue(
                'DISPLAY_INIT_PRICE',
                0,
                false,
                $shop['id_shop_group'],
                $shop['id_shop']
            )) {
                return false;
            }

            if (!Configuration::updateValue(
                'NTREDUCTION_HIDE_PRODUCTS',
                0,
                false,
                $shop['id_shop_group'],
                $shop['id_shop']
            )) {
                return false;
            }
        }

        return true;
    }

    /**
    * @see Module::uninstall()
    */
    public function uninstall()
    {
        /* Delete Back-office tab */
        foreach ($this->tabs as $tab) {
            $this->uninstallTab($tab['tab_class']);
        }

        /* Delete the data base table */
        //$this->executeFile(dirname(__FILE__).'/'.self::UNINSTALL_SQL_FILE);

        return parent::uninstall();
    }

    public function hookDisplayHeader()
    {
        /* Update reduction status only if "no cron" and last update > 1 minute */
        $id_shop        = $this->context->shop->id;
        $id_shop_group  = $this->context->shop->id_shop_group;

        if (Configuration::get('NTREDUCTION_NO_CRON', null, $id_shop_group, $id_shop) == 1) {
            $last_update = strtotime(Configuration::get('NTREDUCTION_LAST_UPDATE', null, $id_shop_group, $id_shop));

            if ($last_update == '' || $last_update < strtotime('-1 minute')) {
                if (Reduction::createDaysSpecificPrice()) {
                    Reduction::updateProductOnSale();
                    Configuration::updateValue(
                        'NTREDUCTION_LAST_UPDATE',
                        date('Y-m-d H:i:00'),
                        false,
                        $id_shop_group,
                        $id_shop
                    );
                }
            }
        }

        /* Add css */
        $this->context->controller->addCSS($this->_path.'views/css/front.css');
    }

    public function hookDisplayProductPriceBlock($params)
    {
        $page_name = Dispatcher::getInstance()->getController();

        if (Configuration::get(
            'DISPLAY_INIT_PRICE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        )
            && ((($params['type'] == 'unit_price') && $page_name != 'product')
            || ($params['type'] == 'weight' && $page_name == 'product'))
        ) {
            if (is_array($params['product'])) {
                $id_product = $params['product']['id_product'];
                $rate = $params['product']['rate'];
            } else {
                $id_product = $params['product']->id;
                $rate = (isset($params['product']->tax_rate))?$params['product']->tax_rate:$params['product']->rate;
            }

            $init_price = 0;

            $informations   = new Informations(Informations::getIdByProduct($id_product));
            $product        = new Product($id_product);

            if (!$rate) {
                // Tax
                $context = Context::getContext();
                $address = new Address();
                $address->id_country = (int)$context->country->id;
                $address->id_state = 0;
                $address->postcode = 0;

                $tax_manager = TaxManagerFactory::getManager(
                    $address,
                    Product::getIdTaxRulesGroupByIdProduct((int)$id_product, $context)
                );

                $product_tax_calculator = $tax_manager->getTaxCalculator();

                // Add Tax
                $init_price = $product_tax_calculator->addTaxes($informations->init_price);
            } elseif ($product->price != $informations->init_price && $informations->init_price && $rate) {
                $init_price = $informations->init_price + ($informations->init_price * $rate / 100);
            }

            if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
                /*$priceFormatter = new PriceFormatter();
                $this->smarty->assign('init_price', $priceFormatter->convertAndFormat($init_price));*/
                $this->smarty->assign('init_price_float', (float)$init_price);
                $this->smarty->assign('init_price', Tools::displayPrice((float)Tools::convertPrice($init_price)));
                $version_tpl = '_1.7';
            } else {
                $this->smarty->assign('init_price', $init_price);
                $version_tpl = '';
            }

            if ($page_name != 'product') {
                return $this->display(__FILE__, 'views/templates/front/front_list_product'.$version_tpl.'.tpl');
            } else {
                return $this->display(__FILE__, 'views/templates/front/front_product'.$version_tpl.'.tpl');
            }
        }
    }

    public function hookActionObjectProductUpdateBefore($params)
    {
        $product = new Product($params['object']->id);

        if ($product->price != $params['object']->price) {
            $id_information             = (int)Informations::getIdByProduct($product->id);
            $information                = new Informations($id_information);
            $information->id_product    = $product->id;
            $information->init_price    = $product->price;

            $information->save();
        }
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminNtreduction'));
    }

    public function uninstallTab($tab_class)
    {
        $img_tab_path   = _PS_ROOT_DIR_.'/img/t/';
        $module_path    = _PS_MODULE_DIR_.'/'.$this->name.'/';
        $id_tab         = Tab::getIdFromClassName($tab_class);

        if ($id_tab) {
            $tab        = new Tab((int)$id_tab);
            $id_parent  = $tab->id_parent;
            $parent_tab = new Tab((int)$id_parent);

            if (file_exists($img_tab_path.$tab->class_name.'.gif')) {
                unlink($img_tab_path.$tab->class_name.'.gif');
            }

            $tab->delete();

            if (Tab::getNbTabs($id_parent) <= 0 && $parent_tab->class_name == self::TAB_2NT) {
                $tab_parent = new Tab((int)$id_parent);
                $img        = $tab_parent->class_name.'.gif';

                if (file_exists($img_tab_path.$img)) {
                    unlink($img_tab_path.$img);
                }

                if (version_compare(_PS_VERSION_, '1.6', '<') && file_exists($module_path.$img)) {
                    unlink($module_path.$img);
                }

                $tab_parent->delete();
            }
        }
    }

    /**
    * Install the module in a tab
    *
    * @param string $module_name Module name
    * @param string $tab_parent_class Tab parent's class
    * @param string $tab_class Tab class
    * @param string $tab_name Tab name
    * @param string $old_tab_class old Tab class to remove
    * @return bool
    */
    public function installOnTab($tab_class, $tab_name, $tab_parent_class, $tab_parent_name = '')
    {
        $img_tab_path   = _PS_ROOT_DIR_.'/img/t/';
        $module_path    = _PS_MODULE_DIR_.'/'.$this->name.'/';

        if (version_compare(_PS_VERSION_, '1.6', '>')) {
            $logo_path = _PS_MODULE_DIR_.'/'.$this->name.'/views/img/tab_logo_grey.png';
        } else {
            $logo_path = _PS_MODULE_DIR_.'/'.$this->name.'/views/img/tab_logo_color.png';
        }

        $id_tab_parent = Tab::getIdFromClassName($tab_parent_class);

        /* If the parent tab does not exist yet, create it */
        if (!$id_tab_parent) {
            $tab_parent             = new Tab();
            $tab_parent->class_name = $tab_parent_class;
            $tab_parent->module     = $this->name;
            $tab_parent->id_parent  = 0;

            foreach (Language::getLanguages(false) as $lang) {
                $tab_parent->name[(int)$lang['id_lang']] = $tab_parent_name;
            }

            if (!$tab_parent->save()) {
                $this->_errors[] = (sprintf($this->l('Unable to create the "%s" tab'), $tab_parent_class));
                return false;
            }

            $id_tab_parent = $tab_parent->id;

            if (!file_exists($img_tab_path.$tab_parent_class.'.gif')) {
                if (!Tools::copy($logo_path, $img_tab_path.$tab_parent_class.'.gif')) {
                    $this->_errors[] = (sprintf($this->l('Unable to copy logo.gif in %s'), $img_tab_path));
                    return false;
                }
            }

            if (version_compare(_PS_VERSION_, '1.6', '<')) {
                if (!file_exists($module_path.$tab_parent_class.'.gif')) {
                    if (!Tools::copy($logo_path, $module_path.$tab_parent_class.'.gif')) {
                        $this->_errors[] = (sprintf($this->l('Unable to copy logo.gif in %s'), $module_path));
                        return false;
                    }
                }
            }
        }

        /* If the tab does not exist yet, create it */
        if (!Tab::getIdFromClassName($tab_class)) {
            $tab                = new Tab();
            $tab->class_name    = $tab_class;
            $tab->module        = $this->name;
            $tab->id_parent     = (int)$id_tab_parent;

            foreach (Language::getLanguages(false) as $lang) {
                $tab->name[(int)$lang['id_lang']] = $tab_name;
            }

            if (!$tab->save()) {
                $this->_errors[] = (sprintf($this->l('Unable to create the "%s" tab'), $tab_class));
                return false;
            }

            if (file_exists($logo_path)) {
                if (!file_exists($img_tab_path.$tab_class.'.gif')) {
                    if (!Tools::copy($logo_path, $img_tab_path.$tab_class.'.gif')) {
                        $this->_errors[] = (sprintf($this->l('Unable to copy logo.gif in %s'), $img_tab_path));
                        return false;
                    }
                }

                if (version_compare(_PS_VERSION_, '1.6', '<')) {
                    if (!file_exists($module_path.$tab_class.'.gif')) {
                        if (!Tools::copy($logo_path, $module_path.$tab_class.'.gif')) {
                            $this->_errors[] = (sprintf($this->l('Unable to copy logo.gif in %s'), $module_path));
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    public function getListProductSpecificPrice(
        $id_categories = array(),
        $id_shop = 0,
        $id_currency = 0,
        $id_country = 0,
        $id_group = 0,
        $active = 1,
        $search = '',
        $suppliers = array(),
        $manufacturers = array(),
        $id_employee = 0,
        $discounted = 2
    ) {
        $list_products          = array();
        $selected_cat           = array();
        $list_products_temp     = array();
        $context                = Context::getContext();
        $context->employee      = new Employee($id_employee);
        $id_root_cat            = Configuration::get('PS_ROOT_CATEGORY');
        $id_lang                = $context->language->id;
        $today                  = date('Y-m-d H:i:s');
        $admin_product_token    = Tools::getAdminTokenLite('AdminProducts', $context);
        $id_currency_default    = (int)Configuration::get('PS_CURRENCY_DEFAULT');

        if ($search != '' && (!isset($id_categories) || !is_array($id_categories) || !count($id_categories))) {
            $id_categories[] = $id_root_cat;
        } /*elseif ((!count($id_categories) || (count($id_categories) == 1
            && in_array($id_root_cat, $id_categories))) && $search == ''
        ) {
            return $list_products;
        }*/

        foreach ($id_categories as $id_category) {
            $category = new Category($id_category);

            if (!in_array($category->id, $selected_cat)) {
                $subcategories  = $category->getAllChildren($id_lang);
                $selected_cat[] = $category->id;

                foreach ($subcategories as $child) {
                    if (!in_array($child->id, $selected_cat)) {
                        $selected_cat[] = $child->id;
                    }
                }
            }
        }

        foreach ($selected_cat as $id_cat) {
            $list_products_temp[$id_cat] = Product::getProducts($id_lang, 0, 0, 'name', 'ASC', $id_cat);
        }

        foreach ($list_products_temp as $categories) {
            foreach ($categories as $product) {
                if ($search != '') {
                    $search = Tools::replaceAccentedChars($search);

                    if (stripos(Tools::replaceAccentedChars($product['name']), $search) === false
                        && stripos(Tools::replaceAccentedChars($product['reference']), $search) === false
                    ) {
                        continue;
                    }
                }

                if (($id_shop == 0 || $id_shop == $product['id_shop'])
                    && ($product['active'] == $active || $active == 2)
                    && (in_array($product['id_supplier'], $suppliers) || in_array(0, $suppliers))
                    && (in_array($product['id_manufacturer'], $manufacturers) || in_array(0, $manufacturers))
                ) {
                    $ignore_product = false;
                    $reduction_old  = self::getSpecificPriceByProductId(
                        $product['id_product'],
                        $id_shop,
                        $id_currency,
                        $id_country,
                        $id_group
                    );

                    if ($discounted != 2) {
                        if ($discounted == 1) {
                            $ignore_product = true;
                        } else {
                            $ignore_product = false;
                        }

                        foreach ($reduction_old as $reduc_old) {
                            if ($discounted == 1) {
                                // Only keep products with reduction
                                if ($reduc_old['to'] >= $today || $reduc_old['to'] == '0000-00-00 00:00:00') {
                                    $ignore_product = false;
                                }
                            } else {
                                // Only keep products without reduction
                                if ($reduc_old['to'] >= $today || $reduc_old['to'] == '0000-00-00 00:00:00') {
                                    $ignore_product = true;
                                }
                            }
                        }
                    }

                    if ($ignore_product) {
                        continue;
                    }

                    $wpte = $product['wholesale_price'];
                    $wpti = $product['wholesale_price'] + ($product['wholesale_price'] * $product['rate'] / 100);
                    $product_price_tax_incl = $product['price'] + ($product['price'] * $product['rate'] / 100);

                    $list_products[$product['id_product']] = $product;
                    $list_products[$product['id_product']]['wholesale_price_tax_incl'] = $wpti;
                    $list_products[$product['id_product']]['price_tax_incl'] = $product_price_tax_incl;
                    $list_products[$product['id_product']]['price_tax_incl_clean'] = Tools::displayPrice(
                        $product_price_tax_incl,
                        $id_currency_default
                    );
                    $list_products[$product['id_product']]['price_tax_excl'] = (float)$product['price'];
                    $list_products[$product['id_product']]['price_tax_excl_clean'] = Tools::displayPrice(
                        $product['price'],
                        $id_currency_default
                    );

                    $o_product  = new Product($product['id_product']);
                    $images     = Image::getImages($this->context->language->id, $o_product->id);

                    if (isset($images[0])) {
                        if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
                            $fomatted_name = ImageType::getFormattedName('small');
                        } else {
                            $fomatted_name = ImageType::getFormatedName('small');
                        }

                        $cover = $this->context->link->getImageLink(
                            $o_product->link_rewrite[$this->context->language->id],
                            $o_product->id.'-'.$images[0]['id_image'],
                            $fomatted_name
                        );
                    }

                    foreach ($images as $image) {
                        if ($image['cover']) {
                            if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
                                $fomatted_name = ImageType::getFormattedName('small');
                            } else {
                                $fomatted_name = ImageType::getFormatedName('small');
                            }

                            $cover = $this->context->link->getImageLink(
                                $o_product->link_rewrite[$this->context->language->id],
                                $o_product->id.'-'.$image['id_image'],
                                $fomatted_name
                            );
                        }
                    }

                    $informations       = new Informations(Informations::getIdByProduct($product['id_product']));
                    $default_category   = new Category($product['id_category_default']);

                    $init_price = $informations->init_price + ($informations->init_price * $product['rate'] / 100);

                    $list_products[$product['id_product']]['init_price']        = $init_price;
                    $list_products[$product['id_product']]['init_price_clean']  = Tools::displayPrice(
                        $init_price,
                        $id_currency_default
                    );
                    $list_products[$product['id_product']]['cover']             = $cover;
                    $list_products[$product['id_product']]['available_qt']      = 0;
                    $list_products[$product['id_product']]['change_quantity']   = true;

                    if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
                        $list_products[$product['id_product']]['admin_link'] = $this->getAdminLink(
                            'AdminProducts',
                            true
                        ).'&id_product='.$product['id_product'].'&updateproduct';
                        $default_category_name = $default_category->link_rewrite[$id_lang];
                    } else {
                        $list_products[$product['id_product']]['admin_link'] = $this->context->link->getAdminLink(
                            'AdminProducts'
                        ).'&id_product='.$product['id_product'].'&updateproduct&token='.$admin_product_token;
                        $default_category_name = $default_category->getName($id_lang);
                    }

                    $list_products[$product['id_product']]['front_link'] = $this->context->link->getProductLink(
                        new Product($product['id_product']),
                        $product['link_rewrite'],
                        $default_category_name
                    );

                    $list_products[$product['id_product']]['last_reduced_price']    = null;
                    $list_products[$product['id_product']]['current_reduced_price'] = null;
                    $list_products[$product['id_product']]['next_reduced_price']    = null;
                    $list_products[$product['id_product']]['margin_after_discount'] = null;

                    if ($id_shop == 0) {
                        $shops = Shop::getShops();

                        foreach ($shops as $shop) {
                            $available_qt = StockAvailable::getQuantityAvailableByProduct(
                                $product['id_product'],
                                null,
                                $shop['id_shop']
                            );
                            $list_products[$product['id_product']]['available_qt'] += $available_qt;
                        }
                    } else {
                        $available_qt = StockAvailable::getQuantityAvailableByProduct(
                            $product['id_product'],
                            null,
                            $id_shop
                        );
                        $list_products[$product['id_product']]['available_qt'] = $available_qt;
                    }

                    if ((bool)StockAvailable::dependsOnStock($product['id_product'], $id_shop)
                        || (bool)$this->productHasAttributes($product['id_product'], $id_shop)
                        || $id_shop == 0
                    ) {
                        $list_products[$product['id_product']]['change_quantity'] = false;
                    }

                    $list_products[$product['id_product']]['warning'] = self::checkHiddingSpecificPriceByProductId(
                        $product['id_product'],
                        $id_shop,
                        $id_country,
                        $id_group
                    );

                    $exist_period = array();

                    foreach ($reduction_old as $reduc_old) {
                        if (in_array($reduc_old['from'].$reduc_old['to'], $exist_period)) {
                            continue;
                        }

                        //Last reduced price
                        if ($reduc_old['to'] < $today && $reduc_old['to'] != '0000-00-00 00:00:00') {
                            $list_products[$product['id_product']]['last_reduced_price'] = $this->getReducedPrice(
                                $reduc_old,
                                $product_price_tax_incl
                            );
                        } elseif ($reduc_old['from'] <= $today
                            && ($reduc_old['to'] >= $today || $reduc_old['to'] == '0000-00-00 00:00:00')
                        ) {
                            //Current reduced price
                            $list_products[$product['id_product']]['current_reduced_price'] = $this->getReducedPrice(
                                $reduc_old,
                                $product_price_tax_incl
                            );

                            $crpf   = $this->getReducedPrice($reduc_old, $product_price_tax_incl, false);
                            $crptef = $crpf - ($crpf * $product['rate'] / 100);

                            $list_products[$product['id_product']]['current_reduced_price_float']           = $crpf;
                            $list_products[$product['id_product']]['current_reduced_price_tax_exlc_float']  = $crptef;

                            if ($wpte > 0) {
                                $margin_after_discount = round($wpte - $crptef, 2); //round(($crpf / $wpti), 2);
                                $list_products[$product['id_product']]['margin_after_discount'] = $margin_after_discount;
                                $list_products[$product['id_product']]['margin_after_discount_clean'] = Tools::displayPrice($margin_after_discount, $id_currency_default);
                            }
                        } elseif ($list_products[$product['id_product']]['next_reduced_price'] == null
                            && $reduc_old['from'] > $today
                        ) {
                            //Next reduced price
                            $list_products[$product['id_product']]['next_reduced_price'] = $this->getReducedPrice(
                                $reduc_old,
                                $product_price_tax_incl
                            );
                        }

                        if ($reduc_old['to'] >= $today || $reduc_old['to'] == '0000-00-00 00:00:00') {
                            if (!isset($list_products[$product['id_product']]['period_1'])
                                || !isset($list_products[$product['id_product']]['period_2'])
                            ) {
                                $reduc_old['on_sale']   = false;
                                $reduc_old['monday']    = false;
                                $reduc_old['tuesday']   = false;
                                $reduc_old['wednesday'] = false;
                                $reduc_old['thursday']  = false;
                                $reduc_old['friday']    = false;
                                $reduc_old['saturday']  = false;
                                $reduc_old['sunday']    = false;

                                if (!isset($reduc_old['id_ntreduction'])) {
                                    $reduc_old['id_ntreduction'] = (int)Reduction::getIdReductionBySpecificPrice(
                                        $reduc_old['id_specific_price']
                                    );
                                }

                                if ($reduc_old['id_ntreduction']) {
                                    $reduction_on_sale      = new Reduction($reduc_old['id_ntreduction']);
                                    $reduc_old['on_sale']   = (bool)$reduction_on_sale->on_sale;
                                    $reduc_old['monday']    = (bool)$reduction_on_sale->monday;
                                    $reduc_old['tuesday']   = (bool)$reduction_on_sale->tuesday;
                                    $reduc_old['wednesday'] = (bool)$reduction_on_sale->wednesday;
                                    $reduc_old['thursday']  = (bool)$reduction_on_sale->thursday;
                                    $reduc_old['friday']    = (bool)$reduction_on_sale->friday;
                                    $reduc_old['saturday']  = (bool)$reduction_on_sale->saturday;
                                    $reduc_old['sunday']    = (bool)$reduction_on_sale->sunday;
                                }

                                if ($reduc_old['reduction_type'] == 'percentage') {
                                    $reduc_old['reduction'] = $reduc_old['reduction'] * 100;
                                }
                            }

                            if (!isset($list_products[$product['id_product']]['period_1'])) {
                                $list_products[$product['id_product']]['period_1'] = $reduc_old;
                            } elseif (!isset($list_products[$product['id_product']]['period_2'])) {
                                $list_products[$product['id_product']]['period_2'] = $reduc_old;
                            }
                        }

                        $exist_period[$product['id_product']] = $reduc_old['from'].$reduc_old['to'];
                    }

                    if (!isset($list_products[$product['id_product']]['period_1'])) {
                        $list_products[$product['id_product']]['period_1'] = array();
                    }

                    if (!isset($list_products[$product['id_product']]['period_2'])) {
                        $list_products[$product['id_product']]['period_2'] = array();
                    }
                }
            }
        }

        return $list_products;
    }

    public function getReducedPrice($reduction, $price_tax_incl, $display_price = true)
    {
        $reduced_price = null;

        if ($reduction['price'] >= 0) {
            $reduced_price = $reduction['price'];
        } elseif ($reduction['reduction_type'] == 'amount') {
            $reduced_price = $price_tax_incl - $reduction['reduction'];
        } elseif ($reduction['reduction_type'] == 'percentage') {
            $reduced_price = $price_tax_incl - ($price_tax_incl * $reduction['reduction']);
        }

        if ($reduced_price != null && $display_price) {
            $reduced_price = Tools::displayPrice($reduced_price);
        }

        return $reduced_price;
    }

    /*
    * get current specific price for a product (for all combinations no specific customer)
    *
    * @param $id_product id of the product with specific price
    * @param $id_currency id of the currency with specific price
    * @param $id_country id of the country with specific price
    * @param $id_group id of the group with specific price
    *
    * @return array of specific price
    */
    public static function getSpecificPriceByProductId(
        $id_product,
        $id_shop = 0,
        $id_currency = 0,
        $id_country = 0,
        $id_group = 0
    ) {
        // From SpecificPrice _getScoreQuery
        $select     = '(';
        $priority   = SpecificPrice::getPriority($id_product);

        foreach (array_reverse($priority) as $k => $field) {
            if (!empty($field)) {
                if (!isset($$field)) {
                    $$field = 0; // Like for id_customer
                }

                $select .= ' IF (`'.bqSQL($field).'` = '.(int)$$field.', '.pow(2, $k + 1).', 0) + ';
            }
        }

        $score = rtrim($select, ' +') . ') AS `score`';

        $specific_reduction = (array)Db::getInstance()->executeS('
            SELECT *, '.$score.'
            FROM `'._DB_PREFIX_.'specific_price`
            WHERE `id_product` = '.(int)$id_product.'
            AND `id_product_attribute` = 0
            AND `id_customer` = 0
            AND `from_quantity` = 1
            AND (`id_shop` = '.(int)$id_shop.' OR `id_shop` = 0)
            AND `id_currency` = '.(int)$id_currency.'
            AND `id_country` = '.(int)$id_country.'
            AND `id_group` = '.(int)$id_group.'
            AND `id_specific_price` NOT IN (
                SELECT `id_specific_price`
                FROM `'._DB_PREFIX_.'ntreduction`
                WHERE `id_product` = '.(int)$id_product.'
                AND `id_product_attribute` = 0
                AND `id_customer` = 0
                AND `from_quantity` = 1
                AND (`id_shop` = '.(int)$id_shop.' OR `id_shop` = 0)
                AND `id_currency` = '.(int)$id_currency.'
                AND `id_country` = '.(int)$id_country.'
                AND `id_group` = '.(int)$id_group.'
                AND (
                    `monday` = 1
                    OR `tuesday` = 1
                    OR `wednesday` = 1
                    OR `thursday` = 1
                    OR `friday` = 1
                    OR `saturday` = 1
                    OR `sunday` = 1
                )
            )
            ORDER BY `score` DESC, `to` ASC, `from` ASC
        ');


        $days_reduction = (array)Db::getInstance()->executeS('
            SELECT *
            FROM `'._DB_PREFIX_.'ntreduction`
            WHERE `id_product` = '.(int)$id_product.'
            AND `id_product_attribute` = 0
            AND `id_customer` = 0
            AND `from_quantity` = 1
            AND (`id_shop` = '.(int)$id_shop.' OR `id_shop` = 0)
            AND `id_currency` = '.(int)$id_currency.'
            AND `id_country` = '.(int)$id_country.'
            AND `id_group` = '.(int)$id_group.'
            AND (
                `monday` = 1
                OR `tuesday` = 1
                OR `wednesday` = 1
                OR `thursday` = 1
                OR `friday` = 1
                OR `saturday` = 1
                OR `sunday` = 1
            )
            ORDER BY `to`, `from`
        ');
        $specific_prices = array_merge($specific_reduction, $days_reduction);

        $product    = new Product($id_product);
        $tax_rate   = $product->getTaxesRate();

        foreach ($specific_prices as &$specific_price) {
            if ($specific_price['price'] > 0) {
                $price = ($specific_price['price'] + ($specific_price['price'] * $tax_rate / 100));
                $specific_price['price'] = (float)self::displayFormattedPrice($price);
            }
        }

        return $specific_prices;
    }

    /*
    * check if there is specific price not handle by the module for the product
    *
    * @param $id_product id of the product with specific price
    * @param $id_currency id of the currency with specific price
    * @param $id_country id of the country with specific price
    * @param $id_group id of the group with specific price
    *
    * @return array of specific price
    */
    /*public static function checkHiddingSpecificPriceByProductId(
        $id_product,
        $id_shop = 0,
        $id_currency = 0,
        $id_country = 0,
        $id_group = 0
    )*/
    public static function checkHiddingSpecificPriceByProductId(
        $id_product,
        $id_shop = 0,
        $id_country = 0,
        $id_group = 0
    ) {
        $hidding_specific_price = array();

        $hidding_specific_price['combination'] = (int)Db::getInstance()->getValue(
            'SELECT count(`id_specific_price`)
            FROM `'._DB_PREFIX_.'specific_price`
            WHERE `id_product` = '.(int)$id_product.'
            AND `id_product_attribute` > 0
            AND `id_customer` = 0
            AND (`id_shop` = '.(int)$id_shop.' OR `id_shop` = 0)
            AND `id_group` = '.(int)$id_group.'
            AND `id_country` = '.(int)$id_country.'
            AND (`to` >= NOW() OR `to` = "0000-00-00 00:00:00")
            ORDER BY `to`, `from`'
        );

        $hidding_specific_price['from_quantity'] = (int)Db::getInstance()->getValue(
            'SELECT count(`id_specific_price`)
            FROM `'._DB_PREFIX_.'specific_price`
            WHERE `id_product` = '.(int)$id_product.'
            AND `from_quantity` > 1
            AND `id_customer` = 0
            AND (`id_shop` = '.(int)$id_shop.' OR `id_shop` = 0)
            AND `id_group` = '.(int)$id_group.'
            AND `id_country` = '.(int)$id_country.'
            AND (`to` >= NOW() OR `to` = "0000-00-00 00:00:00")
            ORDER BY `to`, `from`'
        );

        $hidding_specific_price['currency'] = (int)Db::getInstance()->getValue(
            'SELECT count(`id_specific_price`)
            FROM `'._DB_PREFIX_.'specific_price`
            WHERE `id_product` = '.(int)$id_product.'
            AND `id_currency` > 0
            AND `id_customer` = 0
            AND (`id_shop` = '.(int)$id_shop.' OR `id_shop` = 0)
            AND `id_group` = '.(int)$id_group.'
            AND `id_country` = '.(int)$id_country.'
            AND (`to` >= NOW() OR `to` = "0000-00-00 00:00:00")
            ORDER BY `to`, `from`'
        );

        $hidding_specific_price['catalog_rule'] = (int)Db::getInstance()->getValue(
            'SELECT count(`id_specific_price`)
            FROM `'._DB_PREFIX_.'specific_price`
            WHERE `id_product` = '.(int)$id_product.'
            AND `id_specific_price_rule` > 0
            AND `id_customer` = 0
            AND (`id_shop` = '.(int)$id_shop.' OR `id_shop` = 0)
            AND `id_group` = '.(int)$id_group.'
            AND `id_country` = '.(int)$id_country.'
            AND (`to` >= NOW() OR `to` = "0000-00-00 00:00:00")
            ORDER BY `to`, `from`'
        );

        return $hidding_specific_price;
    }

    /*
    * validate specific price values
    *
    * @param $product_name product name
    * @param $period period number
    * @param $from start date for specific price
    * @param $to end date for specific price
    * @param $new_price new price
    * @param $discount_price final price after discount
    * @param $amount reduction amount
    * @param $percentage reduction percentage
    *
    * @return array of specific price
    */
    public function validateSpecificPrice(
        $product_name,
        $period,
        $from,
        $to,
        $new_price,
        $discount_price,
        $amount,
        $percentage,
        $replace = false,
        $on_sale = false
    ) {
        $error = array();

        if ($product_name == null) {
            $product_name = $this->l('All products');
        }

        /* Check if datas are valid */
        if (!$replace && !$on_sale) {
            if ($from != '' && $from != '0000-00-00 00:00:00' && Validate::isDate($from) === false) {
                $error[] = $product_name.', '.$this->l('period').$period.' - '.$this->l('start date is invalid');
            }

            if ($to != '' && $to != '0000-00-00 00:00:00' && Validate::isDate($to) === false) {
                $error[] = $product_name.', '.$this->l('period').$period.' - '.$this->l('end date is invalid');
            }

            if ($discount_price != ''
                && (Validate::isUnsignedFloat($discount_price) === false || $discount_price <= 0)
            ) {
                $error[] = $product_name.', '.$this->l('period').$period.' - '.$this->l('discount price is invalid');
            }

            if ($amount != '' && (Validate::isUnsignedFloat($amount) === false || $amount <= 0)) {
                $error[] = $product_name.', '.$this->l('period').$period.' - '.$this->l('reduction amount is invalid');
            }

            if ($percentage != '') {
                if (Validate::isUnsignedFloat($percentage) === false) {
                    $error[] = $product_name.', '.$this->l('period').$period
                        .' - '.$this->l('reduction percentage is invalid');
                } elseif ($percentage <= 0 || $percentage >= 100) {
                    $error[] = $product_name.', '.$this->l('period').$period
                        .' - '.$this->l('reduction percentage is out of range');
                }
            }
        } else {
            if ($discount_price != '' && (Validate::isFloat($discount_price) === false || $discount_price == 0)) {
                $error[] = $product_name.', '.$this->l('period').$period.' - '.$this->l('discount price is invalid');
            }

            if ($amount != '' && (Validate::isFloat($amount) === false || $amount == 0)) {
                $error[] = $product_name.', '.$this->l('period').$period.' - '.$this->l('reduction amount is invalid');
            }

            if ($percentage != '') {
                if (Validate::isFloat($percentage) === false) {
                    $error[] = $product_name.', '.$this->l('period').$period
                        .' - '.$this->l('reduction percentage is invalid');
                } elseif ($percentage >= 100) {
                    $error[] = $product_name.', '.$this->l('period').$period
                        .' - '.$this->l('reduction percentage is out of range');
                }
            }
        }

        if ($new_price != '' && (Validate::isUnsignedFloat($new_price) === false || $new_price <= 0)) {
            $error[] = $product_name.', '.$this->l('period').$period.' - '.$this->l('new price is invalid');
        }

        if ($discount_price != '' && ($amount != '' || $percentage != '')) {
            $error[] = $product_name.', '.$this->l('period').$period
                .' - '.$this->l('you must choose between discount price, reduction amount and percentage reduction');
        } elseif ($amount != '' && ($discount_price != '' || $percentage != '')) {
            $error[] = $product_name.', '.$this->l('period').$period
                .' - '.$this->l('you must choose between discount price, reduction amount and percentage reduction');
        } elseif ($percentage != '' && ($discount_price != '' || $amount != '')) {
            $error[] = $product_name.', '.$this->l('period').$period
                .' - '.$this->l('you must choose between discount price, reduction amount and percentage reduction');
        }

        return $error;
    }

    /*
    * validate configuration values
    *
    * @param $id_shop id shop
    * @param $id_shop_group id shop group
    * @param $id_currency id currency
    * @param $id_country id country
    * @param $id_group id group
    * @param $priorities priorities
    *
    * @return array of specific price
    */
    public function validateConfig($id_shop, $id_shop_group, $id_currency, $id_country, $id_group, $priorities)
    {
        $error = array();

        if (!Validate::isUnsignedId($id_shop)) {
            $error[] = $this->l('Wrong shop id');
        }

        if (!Validate::isUnsignedId($id_shop_group)) {
            $error[] = $this->l('Wrong shop group id');
        }

        if (!Validate::isUnsignedId($id_currency)) {
            $error[] = $this->l('Wrong currency id');
        }

        if (!Validate::isUnsignedId($id_country)) {
            $error[] = $this->l('Wrong country id');
        }

        if (!Validate::isUnsignedId($id_group)) {
            $error[] = $this->l('Wrong group id');
        }

        if (!$priorities) {
            $error[] = $this->l('Please specify priorities');
        }

        return $error;
    }

    /*
    * validate configuration values
    *
    * @param $p1_date_from_all
    * @param $p2_date_from_all
    * @param $p1_date_to_all
    * @param $p2_date_to_all
    *
    * @return array of specific price
    */
    public function validateCrossingDate($product_name, $p1_date_from, $p2_date_from, $p1_date_to, $p2_date_to)
    {
        $error = array();
        $crossdate = false;

        if ($product_name == null) {
            $product_name = $this->l('All products');
        }

        if ($p1_date_from != '' && $p2_date_from != '' && $p1_date_to != '' && $p2_date_to != '') {
            /*if ($p1_date_from == '0000-00-00 00:00:00' && $p1_date_to == '0000-00-00 00:00:00') {
                $crossdate = true;
            }*/

            if ($p1_date_from <= $p2_date_from && $p2_date_from <= $p1_date_to) {
                $crossdate = true;
            }

            if ($p1_date_from <= $p2_date_to && $p2_date_to <= $p1_date_to) {
                $crossdate = true;
            }

            if ($p2_date_from <= $p1_date_from && $p1_date_from <= $p2_date_to) {
                $crossdate = true;
            }

            if ($p2_date_from <= $p1_date_to && $p1_date_to <= $p2_date_to) {
                $crossdate = true;
            }

            if ($crossdate) {
                $error[] = $product_name.', '.$this->l('crossing dates');
            }
        }

        return $error;
    }

    /*
    * update product quantities
    *
    * @param $product_name product name
    * @param $id_product id product
    * @param $quantity new quantity
    *
    * @return array of errors
    */
    public function updateQuantities($product_name, $id_product, $quantity, $id_shop)
    {
        $error = array();

        if ($product_name == '') {
            $error[] = $this->l('Error');
        }

        if (!count($error)) {
            if (!StockAvailable::setQuantity($id_product, 0, (int)$quantity, $id_shop)) {
                $error[] = $product_name.', '.$this->l('an error occurred while updating the product quantities');
            } else {
                Hook::exec(
                    'actionProductUpdate',
                    array('id_product' => $id_product, 'product' => new Product($id_product))
                );
            }
        }

        return $error;
    }

    /*
    * add or update specific price
    *
    * @param $product_name product name
    * @param $id_shop shop id
    * @param $id_currency currency id
    * @param $id_country country id
    * @param $id_group group id
    * @param $priorities specific price priorities
    * @param $id_product product id
    * @param $from start date for specific price
    * @param $to end date for specific price
    * @param $new_price new price
    * @param $discount_price discount price
    * @param $amount reduction amount
    * @param $percentage reduction percentage
    * @param $id_specific_price specific price id
    * @param $id_ntreduction ntreduction id
    * @param $replace if price must be replace
    * @param $on_sale if "on sale" must be display
    * @param $monday monday discount
    * @param $tuesday tuesday discount
    * @param $wednesday wednesday discount
    * @param $thursday thursday discount
    * @param $friday friday discount
    * @param $saturday saturday discount
    * @param $sunday sunday discount
    *
    * @return array of errors
    */
    public function updateSpecificPrice(
        $product_name,
        $id_shop,
        $id_shop_group,
        $id_currency,
        $id_country,
        $id_group,
        $priorities,
        $id_product,
        $from,
        $to,
        $new_price,
        $discount_price,
        $amount,
        $percentage,
        $id_specific_price = null,
        $id_ntreduction = null,
        $replace = false,
        $on_sale = false,
        $monday = false,
        $tuesday = false,
        $wednesday = false,
        $thursday = false,
        $friday = false,
        $saturday = false,
        $sunday = false
    ) {
        $error = array();
        $replace_price = 0;
        $price_after_reduction = 0;

        if ($product_name == '') {
            $error[] = $this->l('Error, unknown product');
        } elseif ($new_price == ''
            && $discount_price == ''
            && $amount == ''
            && $percentage == ''
            && ($from != '' && $to != '' || $replace)
            && !$on_sale
        ) {
            $error[] = $product_name.', '.$this->l('you must indicate new price, discount price, reduction amount or percentage reduction not just start and end date');
        } elseif ($id_product != '' && ($from != '' && $to != '' || $replace || $on_sale)) {
            $product = new Product($id_product);
            $tax_rate = $product->getTaxesRate();

            $produc_price_tax_incl = $product->price + ($product->price * $tax_rate / 100);

            if ($new_price != '') {
                $reduction = 0;
                $reduction_type = 'amount';
                $price_after_reduction = $new_price;
                $new_price = $new_price / (1 + $tax_rate / 100);
                $produc_price_tax_incl = $price_after_reduction;
            }

            if ($amount != '') {
                $reduction = $amount;
                $reduction_type = 'amount';
                $price_after_reduction = $produc_price_tax_incl - $amount;
            } elseif ($percentage != '') {
                $reduction = $percentage / 100;
                $reduction_type = 'percentage';
                $price_after_reduction = $produc_price_tax_incl - ($produc_price_tax_incl * $reduction);
            } elseif ($discount_price != '') {
                $price_after_reduction = $discount_price;
                $reduction_complete = $produc_price_tax_incl - $discount_price;
                $reduction = self::displayFormattedPrice($reduction_complete);
                $reduction_type = 'amount';
            }

            $replace_price = $price_after_reduction;

            if ($replace) {
                $product->price = (float)number_format($replace_price / (1 + $tax_rate / 100), 6, '.', '');

                /* update replace price */
                if (!$product->update()) {
                    $error[] = $product_name.', '.$this->l('An error occurred while updating the product price');
                }

                if ($id_specific_price != null) {
                    $id_nt_reduction = (int)Reduction::getIdReductionBySpecificPrice((int)$id_specific_price);

                    // delete in ntreduction
                    if ($id_nt_reduction) {
                        $reduction_on_sale = new Reduction($id_nt_reduction);
                        $reduction_on_sale->delete();
                    }

                    // delete specific price
                    $specific_price = new SpecificPrice($id_specific_price);
                    $specific_price->delete();
                }

                return $error;
            }

            if ($on_sale) {
                if ($new_price == '' && $discount_price == '' && $amount == '' && $percentage == '') {
                    $reduction = 0;
                    $reduction_type = 'amount';
                    $new_price = ($product->price + ($product->price * $tax_rate / 100)) / (1 + $tax_rate / 100);
                }

                if ($from == '') {
                    $from = '0000-00-00 00:00:00';
                }

                if ($to == '') {
                    $to = '0000-00-00 00:00:00';
                }
            }

            if ($new_price == '') {
                if ($price_after_reduction >= $produc_price_tax_incl) {
                    $error[] = $product_name.', '.$this->l('your discount must be lower than the current price.');
                } elseif ($price_after_reduction <= 0) {
                    $error[] = $product_name.', '.$this->l('your discount is invalid.');
                }
            }

            if (count($error) > 0) {
                return $error;
            }

            if ($monday == false
                && $tuesday == false
                && $wednesday == false
                && $thursday == false
                && $friday == false
                && $saturday == false
                && $sunday == false
            ) {
                if ($id_specific_price == null) {
                    $id_specific_price = (int)SpecificPrice::exists(
                        $id_product,
                        0,
                        $id_shop,
                        $id_group,
                        $id_country,
                        $id_currency,
                        0,
                        1,
                        $from,
                        $to
                    );

                    if ($id_specific_price) {
                        /* update specific price */
                        $specific_price = new SpecificPrice($id_specific_price);
                    } else {
                        /* Add new specific price */
                        $specific_price = new SpecificPrice();
                    }
                } else {
                    /* update specific price */
                    $specific_price = new SpecificPrice($id_specific_price);
                }

                /* If there is no changes */
                if ($specific_price->id_product == $id_product
                    && $specific_price->id_shop == $id_shop
                    && $specific_price->id_shop_group == $id_shop_group
                    && $specific_price->id_currency == $id_currency
                    && $specific_price->id_country == $id_country
                    && $specific_price->id_group == $id_group
                    && $specific_price->price == $new_price
                    && $specific_price->reduction == $reduction
                    && $specific_price->reduction_type == $reduction_type
                    && $specific_price->from == $from
                    && $specific_price->to == $to
                ) {
                    return $error;
                }

                if ($new_price == '') {
                    $new_price = -1;
                } else {
                    $new_price = Tools::ps_round($new_price, 6);
                }

                $specific_price->id_product             = (int)$id_product;
                $specific_price->id_product_attribute   = 0;
                $specific_price->id_shop                = (int)$id_shop;
                $specific_price->id_shop_group          = (int)$id_shop_group;
                $specific_price->id_currency            = (int)$id_currency;
                $specific_price->id_country             = (int)$id_country;
                $specific_price->id_group               = (int)$id_group;
                $specific_price->id_customer            = 0;
                $specific_price->price                  = (float)$new_price;
                $specific_price->from_quantity          = 1;
                $specific_price->reduction              = (float)$reduction;
                $specific_price->reduction_type         = $reduction_type;
                $specific_price->from                   = $from;
                $specific_price->to                     = $to;

                if ($id_specific_price == null) {
                    /* Add new specific price */
                    if (!$specific_price->add()) {
                        $error[] = $product_name.', '.$this->l('An error occurred while adding the specific price');
                    }
                } else {
                    /* update specific price */
                    if (!$specific_price->update()) {
                        $error[] = $product_name.', '.$this->l('An error occurred while updating the specific price');
                    }
                }

                if (!SpecificPrice::setSpecificPriority((int)$specific_price->id, $priorities)) {
                    $error[] = $product_name.', '.$this->l('An error occurred while setting priorities.');
                }

                $id_nt_reduction = (int)Reduction::getIdReductionBySpecificPrice((int)$specific_price->id);

                if ($id_nt_reduction) {
                    $reduction_on_sale = new Reduction($id_nt_reduction);
                } else {
                    $reduction_on_sale = new Reduction();
                    $reduction_on_sale->id_specific_price = (int)$specific_price->id;
                }
            } else {
                if ($id_specific_price != null && $id_specific_price != 0) {
                    $specific_price = new SpecificPrice($id_specific_price);
                    $specific_price->delete();
                }

                if ($new_price == '') {
                    $new_price = -1;
                }

                if ($id_ntreduction) {
                    $reduction_on_sale = new Reduction($id_ntreduction);
                    if ($id_specific_price == null || $id_specific_price == 0) {
                        $specific_price = new SpecificPrice($reduction_on_sale->id_specific_price);
                        $specific_price->delete();
                    }
                } else {
                    $reduction_on_sale = new Reduction();
                }

                $reduction_on_sale->id_specific_price       = 0;
                $reduction_on_sale->monday                  = (bool)$monday;
                $reduction_on_sale->tuesday                 = (bool)$tuesday;
                $reduction_on_sale->wednesday               = (bool)$wednesday;
                $reduction_on_sale->thursday                = (bool)$thursday;
                $reduction_on_sale->friday                  = (bool)$friday;
                $reduction_on_sale->saturday                = (bool)$saturday;
                $reduction_on_sale->sunday                  = (bool)$sunday;
                $reduction_on_sale->id_product              = (int)$id_product;
                $reduction_on_sale->id_product_attribute    = 0;
                $reduction_on_sale->id_shop                 = (int)$id_shop;
                $reduction_on_sale->id_currency             = (int)$id_currency;
                $reduction_on_sale->id_country              = (int)$id_country;
                $reduction_on_sale->id_group                = (int)$id_group;
                $reduction_on_sale->id_customer             = 0;
                $reduction_on_sale->price                   = (float)$new_price;
                $reduction_on_sale->from_quantity           = 1;
                $reduction_on_sale->reduction               = (float)$reduction;
                $reduction_on_sale->reduction_type          = $reduction_type;
                $reduction_on_sale->from                    = $from;
                $reduction_on_sale->to                      = $to;
            }

            if (!$reduction_on_sale->reduction_type) {
                $reduction_on_sale->reduction_type = 'amount';
            }

            $reduction_on_sale->on_sale = (bool)$on_sale;

            /* update ntreduction */
            if (!$reduction_on_sale->save()) {
                $error[] = $product_name.', '.$this->l('An error occurred while updating reduction values');
            } else {
                Hook::exec('actionProductUpdate', array('id_product' => $id_product, 'product' => $product));
            }
        } elseif (($new_price != '' || $discount_price != '' || $amount != '' || $percentage != '')
            && ($from == '' || $to == '' && !$replace)
        ) {
            $error[] = $product_name.', '.$this->l('You must indicate start and end date for all your reductions.');
        }

        return $error;
    }

    public static function displayFormattedPrice($price, $currency = null, Context $context = null)
    {
        if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
            /*$priceFormatter = new PriceFormatter();
            return $priceFormatter->convertAndFormat($price);*/
            //return Tools::displayPrice((float)Tools::convertPrice($price));
        }

        if (!is_numeric($price)) {
            return $price;
        }

        if (!$context) {
            $context = Context::getContext();
        }

        if ($currency === null) {
            $currency = $context->currency;
            // if you modified this function, don't forget to modify the
            // Javascript function formatCurrency (in tools.js)
        } elseif (is_int($currency)) {
            $currency = Currency::getCurrencyInstance((int)$currency);
        }

        if (is_array($currency)) {
            //$c_format = $currency['format'];
            $c_decimals = (int)$currency['decimals'] * _PS_PRICE_DISPLAY_PRECISION_;
        } elseif (is_object($currency)) {
            //$c_format = $currency->format;
            $c_decimals = (int)$currency->decimals * _PS_PRICE_DISPLAY_PRECISION_;
        } else {
            return false;
        }

        if (($is_negative = ($price < 0))) {
            $price *= -1;
        }

        $ret = number_format(Tools::ps_round($price, $c_decimals), $c_decimals, '.', '');

        if ($is_negative) {
            $ret = '-'.$ret;
        }

        return $ret;
    }

    public function executeFile($file_path)
    {
        /* Check if the file exists */
        if (!file_exists($file_path)) {
            return Tools::displayError('Error : no sql file !');
        /* Get file content*/
        } elseif (!$sql = Tools::file_get_contents($file_path)) {
            return Tools::displayError('Error : there is a problem with your install sql file !');
        }

        $sql_replace = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql_replace));

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute(trim($query))) {
                return Tools::displayError('Error : this query doesn\'t work ! '.$query);
            }
        }

        return true;
    }

    /**
    * Check if product has attributes combinations
    *
    * @return integer Attributes combinations number
    */
    public function productHasAttributes($id_product, $id_shop)
    {
        if (!Combination::isFeatureActive()) {
            return 0;
        }

        return Db::getInstance()->getValue(
            'SELECT COUNT(*)
            FROM `'._DB_PREFIX_.'product_attribute` pa
            JOIN `'._DB_PREFIX_.'product_attribute_shop` pas ON pa.`id_product_attribute` = pas.`id_product_attribute`
            WHERE pa.`id_product` = '.(int)$id_product.'
            AND pas.`id_shop` = '.(int)$id_shop
        );
    }

    /**
     * Use controller name to create a link
     *
     * @param string $controller
     * @param bool $with_token include or not the token in the url
     * @return string url
     */
    public function getAdminLink($controller, $with_token = true)
    {
        $id_lang = Context::getContext()->language->id;

        $params = $with_token ? array('token' => Tools::getAdminTokenLite($controller)) : array();
        return Dispatcher::getInstance()->createUrl($controller, $id_lang, $params, false);
    }
}
