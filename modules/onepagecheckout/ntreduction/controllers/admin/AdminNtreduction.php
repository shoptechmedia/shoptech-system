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

class AdminNtreductionController extends ModuleAdminController
{
    const PAGE = 'adminntreduction';

    public function __construct()
    {
        $this->display      = 'view';
        $this->table        = 'ntreduction';
        $this->className    = 'NtReduction';
        $this->deleted      = false;
        $this->bootstrap    = true;

        parent::__construct();

        if (version_compare(_PS_VERSION_, '1.6.0', '>=') === true) {
            $this->meta_title = array($this->l('2NT Reduction', self::PAGE));
        } else {
            $this->meta_title = $this->l('2NT Reduction', self::PAGE);
        }

        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);

        $this->addJqueryUI(array(
            'ui.slider',
            'ui.datepicker',
        ));

        $module_path    = $this->module->getPathUri();
        $version_script = '1.5';

        if (version_compare(_PS_VERSION_, '1.6.0', '>=') === true) {
            $version_script = '1.6';

            $this->addjQueryPlugin(array(
                'select2',
            ));
        } else {
            $this->addCSS(array(
                $module_path.'lib/select2/select2.min.css',
            ));

            $this->addJS(array(
                $module_path.'lib/select2/select2.min.js',
            ));
        }

        $this->addCSS(array(
            $module_path.'views/css/style_'.$version_script.'.css',
        ));

        $this->addCSS(array(
            $module_path.'views/css/fontawesome-all.css',
        ));

        $this->addJS(array(
            $module_path.'views/js/script_'.$version_script.'.js',
        ));

        $this->addJS(array(
            _PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.js',
            $module_path.'views/js/script.js',
        ));

        $this->addCSS(array(
            _PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.css',
            $module_path.'views/css/style.css',
        ));

        return true;
    }

    public function renderView()
    {
        $error_context_group = false;

        if (Shop::getContext() == Shop::CONTEXT_GROUP) {
            // Prestashop forbid product update when in group context
            $error_context_group = true;
        }

        if (Tools::isSubmit('display_reduction')) {
            $this->displayReduction();
        } elseif (Tools::isSubmit('export_reduction')) {
            $this->exportReduction();
        } elseif (Tools::isSubmit('ntreduction_cron_config_save')) {
            $this->saveConfigCron();
        } elseif (Tools::isSubmit('ntreduction_columns_config_save')) {
            $this->saveConfigColumns();
        } elseif (Tools::isSubmit('ntreduction_save')) {
            $this->saveReductions();
        }

        if (version_compare(_PS_VERSION_, '1.6.0', '>=') === true) {
            $helper = new HelperTreeCategories('categories-treeview');
            $helper->setRootCategory(Category::getRootCategory()->id_category)->setUseCheckBox(true);
            $category_tree = $helper->render();
            $version = '1.6';
        } else {
            $helper = new Helper();
            $category_tree = $helper->renderCategoryTree();
            $version = '1.5';
        }

        $ntr                        = new NtReduction();
        $id_lang                    = $this->context->language->id;
        $token                      = Tools::substr(Tools::encrypt($ntr->name.'/index'), 0, 10);
        $id_cat_root                = (int)Configuration::get('PS_ROOT_CATEGORY');
        $specific_price_priorities  = preg_split('/;/', Configuration::get('PS_SPECIFIC_PRICE_PRIORITIES'));
        $shops                      = Shop::getShops();
        $countries                  = Country::getCountries($id_lang);
        $groups                     = Group::getGroups($id_lang);
        $currencies                 = Currency::getCurrencies();
        $suppliers                  = Supplier::getSuppliers();
        $manufacturers              = Manufacturer::getManufacturers();
        $id_currency_default        = (int)Configuration::get('PS_CURRENCY_DEFAULT');
        $currency_default           = new Currency($id_currency_default);
        $columns_to_hide            = array();
        $shop_domain                = Tools::getCurrentUrlProtocolPrefix().Tools::getHttpHost();
        $nocron                     = Configuration::get('NTREDUCTION_NO_CRON');
        $hide_columns               = Configuration::get('NTREDUCTION_HIDE_COLUMNS');
        $colspan_product            = 11;
        $colspan_period_1           = 16;
        $colspan_period_2           = 16;
        $multi_shop                 = false;

        if ($hide_columns) {
            $columns_to_hide = explode(':', $hide_columns);
        }

        foreach ($columns_to_hide as $c_to_hide) {
            if (strpos($c_to_hide, 'p1_') !== false) {
                $colspan_period_1--;
            } elseif (strpos($c_to_hide, 'p2_') !== false) {
                $colspan_period_2--;
            } elseif (strpos($c_to_hide, 'p_') !== false) {
                $colspan_product--;
            }
        }

        $physic_path_modules    = realpath(_PS_ROOT_DIR_.'/modules').'/';
        $domain_use             = Tools::getHttpHost();
        $protocol               = Tools::getCurrentUrlProtocolPrefix();
        $shop_domain            = $protocol.$domain_use;
        $url_modules            = $shop_domain.__PS_BASE_URI__.'modules/';
        $documentation          = $url_modules.$ntr->name.'/readme_en.pdf';
        $documentation_name     = 'readme_en.pdf';
        $ajax_loader            = $url_modules.$ntr->name.'/views/img/ajax-loader.gif';

        if (Tools::file_exists_cache(
            $physic_path_modules.$ntr->name.'/readme_'.$this->context->language->iso_code.'.pdf'
        )) {
            $documentation      = $url_modules.$ntr->name.'/readme_'.$this->context->language->iso_code.'.pdf';
            $documentation_name = 'readme_'.$this->context->language->iso_code.'.pdf';
        }

        // Not use id_customer
        if ($specific_price_priorities[0] == 'id_customer') {
            unset($specific_price_priorities[0]);
        }

        $hide_products      = Configuration::get('NTREDUCTION_HIDE_PRODUCTS');
        $display_init_price = Configuration::get('DISPLAY_INIT_PRICE');
        $ajax_products_max  = floor(
            (NtReduction::INPUT_MAX - NtReduction::INPUT_REDUCTION) / NtReduction::INPUT_PRODUCT
        );

        $ads_url    = 'https://addons.prestashop.com/';
        $ads_var    = '?id_product=11404';

        if ($this->context->language->iso_code == 'fr') {
            $link_contact   = $ads_url.'fr/ecrire-au-developpeur'.$ads_var;
        } else {
            $link_contact   = $ads_url.'en/write-to-developper'.$ads_var;
        }

        $display_translate_tab  = true;
        $translate_lng          = array();
        $translate_files        = glob($physic_path_modules.$ntr->name.'/translations/*.php');

        foreach ($translate_files as $trslt_file) {
            $translate_lng[] = basename($trslt_file, '.php');
        }

        if (in_array($this->context->language->iso_code, $translate_lng)) {
            $display_translate_tab = false;
        }

        $cron = _PS_BASE_URL_.__PS_BASE_URI__.'modules/ntreduction/cron_on_sale.php?token='.$token;

        // Remove old export files
        $today          = date('Ymd');
        $export_path    = realpath(_PS_ROOT_DIR_.'/modules').'/'.$ntr->name.'/export/';

        foreach (glob($export_path.'*.csv') as $export_file_path) {
            $export_file    = basename($export_file_path, '.csv');
            $details        = explode('_', $export_file);

            if (isset($details[1]) && $details[1] < $today) {
                unlink($export_file_path);
            }
        }

        //multiboutique
        if (Shop::getContext() != Shop::CONTEXT_SHOP) {
            $multi_shop = true;
        }

        $this->tpl_view_vars = array(
            'specific_price_priorities' => array_values($specific_price_priorities),// Reindex array starting from 0
            'category_tree'             => $category_tree,
            'shops'                     => $shops,
            'countries'                 => $countries,
            'groups'                    => $groups,
            'currencies'                => $currencies,
            'suppliers'                 => $suppliers,
            'manufacturers'             => $manufacturers,
            'id_cat_root'               => $id_cat_root,
            'multi_shop'                => $multi_shop,
            'currencySign'              => $currency_default->sign,
            'admin_one_shop'            => count($this->context->employee->getAssociatedShops()) == 1,
            'cron'                      => $cron,
            'documentation'             => $documentation,
            'documentation_name'        => $documentation_name,
            'nocron'                    => $nocron,
            'columns_to_hide'           => $columns_to_hide,
            'display_init_price'        => $display_init_price,
            'hide_products'             => $hide_products,
            'ajax_products_max'         => $ajax_products_max,
            'ps_version'                => $version,
            'id_employee'               => $this->context->employee->id,
            'version'                   => $ntr->version,
            'link_contact'              => $link_contact,
            'display_translate_tab'     => $display_translate_tab,
            'ajax_loader'               => $ajax_loader,
            'colspan_product'           => $colspan_product,
            'colspan_period_1'          => $colspan_period_1,
            'colspan_period_2'          => $colspan_period_2,
            'error_context_group'       => $error_context_group,
        );

        return parent::renderView();
    }

    public function saveReductions()
    {
        $ntr            = new NtReduction();
        $error          = array();
        $error_all_p1   = array();
        $error_all_p2   = array();

        $from_default   = '0000-00-00 00:00:00';
        $to_default     = '0000-00-00 00:00:00';

        $ok = false;

        /******************* Check config values *******************/
        $id_country     = (int)Tools::getValue('reduction_country');
        $id_currency    = (int)Tools::getValue('reduction_currency');
        $id_group       = (int)Tools::getValue('reduction_group');
        $priorities     = Tools::getValue('specificPricePriority');

        //multiboutique
        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $id_shop        = (int)$this->context->shop->id;
            $id_shop_group  = (int)$this->context->shop->id_shop_group;
        } else {
            $id_shop        = 0;
            $id_shop_group  = 0;
        }

        $error_config = $ntr->validateConfig(
            $id_shop,
            $id_shop_group,
            $id_currency,
            $id_country,
            $id_group,
            $priorities
        );

        if (count($error_config) > 0) {
            die(Tools::jsonEncode(array('error' => $error_config)));
        }

        /***********************************************************/

        /****************** Check quantity values ******************/
        $quantities = Tools::getValue('quantity');

        if ($quantities) {
            foreach ($quantities as $id_product => $quantity) {
                $ntr->updateQuantities(Product::getProductName($id_product), $id_product, $quantity, $id_shop);
            }
        }
        /***********************************************************/

        /**************** Check all products values ****************/
        $reset_init_price_all   = Tools::getValue('p_reset_init_price_all');

        $p1_date_from_all       = Tools::getValue('p1_date_from_all');
        $p1_date_to_all         = Tools::getValue('p1_date_to_all');
        $p1_new_price_all       = str_replace(',', '.', Tools::getValue('p1_new_price_all'));
        $p1_discount_price_all  = str_replace(',', '.', Tools::getValue('p1_discount_price_all'));
        $p1_amount_all          = str_replace(',', '.', Tools::getValue('p1_amount_all'));
        $p1_percentage_all      = str_replace(',', '.', Tools::getValue('p1_percentage_all'));
        $p1_replace_all         = (bool)Tools::getValue('p1_replace_all');
        $p1_on_sale_all         = (int)Tools::getValue('p1_on_sale_all');
        $p1_monday_all          = (int)Tools::getValue('p1_monday_all');
        $p1_tuesday_all         = (int)Tools::getValue('p1_tuesday_all');
        $p1_wednesday_all       = (int)Tools::getValue('p1_wednesday_all');
        $p1_thursday_all        = (int)Tools::getValue('p1_thursday_all');
        $p1_friday_all          = (int)Tools::getValue('p1_friday_all');
        $p1_saturday_all        = (int)Tools::getValue('p1_saturday_all');
        $p1_sunday_all          = (int)Tools::getValue('p1_sunday_all');
        $p1_delete_all          = (bool)Tools::getValue('p1_delete_all');

        $p2_date_from_all       = Tools::getValue('p2_date_from_all');
        $p2_date_to_all         = Tools::getValue('p2_date_to_all');
        $p2_new_price_all       = str_replace(',', '.', Tools::getValue('p2_new_price_all'));
        $p2_discount_price_all  = str_replace(',', '.', Tools::getValue('p2_discount_price_all'));
        $p2_amount_all          = str_replace(',', '.', Tools::getValue('p2_amount_all'));
        $p2_percentage_all      = str_replace(',', '.', Tools::getValue('p2_percentage_all'));
        $p2_replace_all         = (bool)Tools::getValue('p2_replace_all');
        $p2_on_sale_all         = (int)Tools::getValue('p2_on_sale_all');
        $p2_monday_all          = (int)Tools::getValue('p2_monday_all');
        $p2_tuesday_all         = (int)Tools::getValue('p2_tuesday_all');
        $p2_wednesday_all       = (int)Tools::getValue('p2_wednesday_all');
        $p2_thursday_all        = (int)Tools::getValue('p2_thursday_all');
        $p2_friday_all          = (int)Tools::getValue('p2_friday_all');
        $p2_saturday_all        = (int)Tools::getValue('p2_saturday_all');
        $p2_sunday_all          = (int)Tools::getValue('p2_sunday_all');
        $p2_delete_all          = (bool)Tools::getValue('p2_delete_all');

        /* Check period 1 datas */
        if (empty($p1_delete_all)) {
            $error_all_p1 = $ntr->validateSpecificPrice(
                null,
                1,
                $p1_date_from_all,
                $p1_date_to_all,
                $p1_new_price_all,
                $p1_discount_price_all,
                $p1_amount_all,
                $p1_percentage_all,
                $p1_replace_all,
                $p1_on_sale_all
            );
        }

        /* Check period 2 datas */
        if (empty($p2_delete_all)) {
            $error_all_p2 = $ntr->validateSpecificPrice(
                null,
                2,
                $p2_date_from_all,
                $p2_date_to_all,
                $p2_new_price_all,
                $p2_discount_price_all,
                $p2_amount_all,
                $p2_percentage_all,
                $p2_replace_all,
                $p2_on_sale_all
            );
        }

        $error_all = array_merge($error_all_p1, $error_all_p2);

        if (count($error_all) > 0) {
            die(Tools::jsonEncode(array('error' => $error_all)));
        } else {
            $error_cross_date_all = $ntr->validateCrossingDate(
                null,
                $p1_date_from_all,
                $p2_date_from_all,
                $p1_date_to_all,
                $p2_date_to_all
            );
        }

        if (count($error_cross_date_all) > 0) {
            die(Tools::jsonEncode(array('error' => $error_cross_date_all)));
        }

        /***********************************************************/

        /*************** Check each products values ****************/

        // If no product is displayed
        if (Tools::isSubmit('hide_products')) {
            $list_id_cat    = (Tools::isSubmit('categoryBox'))?Tools::getValue('categoryBox'):array((int)Configuration::get('PS_ROOT_CATEGORY'));
            $active         = (int)Tools::getValue('active');
            $discounted     = (int)Tools::getValue('discounted');
            $suppliers      = (Tools::isSubmit('filter_supplier'))?Tools::getValue('filter_supplier'):array(0);
            $manufacturers  = (Tools::isSubmit('filter_manufacturer'))?Tools::getValue('filter_manufacturer'):array(0);
            $search         = Tools::getValue('nt_reduction_search');

            $reset_init_price       = array();

            $p1_id_specific_price   = array();
            $p1_id_ntreduction      = array();
            $p1_date_from           = array();
            $p1_date_to             = array();
            $p1_new_price           = array();
            $p1_discount_price      = array();
            $p1_amount              = array();
            $p1_percentage          = array();
            $p1_replace             = array();
            $p1_on_sale             = array();
            $p1_monday              = array();
            $p1_tuesday             = array();
            $p1_wednesday           = array();
            $p1_thursday            = array();
            $p1_friday              = array();
            $p1_saturday            = array();
            $p1_sunday              = array();
            $p1_delete              = array();

            $p2_id_specific_price   = array();
            $p2_id_ntreduction      = array();
            $p2_date_from           = array();
            $p2_date_to             = array();
            $p2_new_price           = array();
            $p2_discount_price      = array();
            $p2_amount              = array();
            $p2_percentage          = array();
            $p2_replace             = array();
            $p2_on_sale             = array();
            $p2_monday              = array();
            $p2_tuesday             = array();
            $p2_wednesday           = array();
            $p2_thursday            = array();
            $p2_friday              = array();
            $p2_saturday            = array();
            $p2_sunday              = array();
            $p2_delete              = array();

            $products = $ntr->getListProductSpecificPrice(
                $list_id_cat,
                $id_shop,
                $id_currency,
                $id_country,
                $id_group,
                $active,
                $search,
                $suppliers,
                $manufacturers,
                $this->context->employee->id,
                $discounted
            );

            if (!is_array($products) || !count($products)) {
                $error[] = $this->l('Error, no product found. Please check your filters.');

                die(Tools::jsonEncode(array('error' => $error)));
            }

            foreach ($products as $product) {
                $id_product = $product['id_product'];
                $period_1   = $product['period_1'];
                $period_2   = $product['period_2'];

                $reset_init_price[$id_product]      = $reset_init_price_all;

                $p1_id_specific_price[$id_product]  = 0;
                $p1_id_ntreduction[$id_product]     = 0;
                $p1_date_from[$id_product]          = $p1_date_from_all;
                $p1_date_to[$id_product]            = $p1_date_to_all;
                $p1_new_price[$id_product]          = $p1_new_price_all;
                $p1_discount_price[$id_product]     = $p1_discount_price_all;
                $p1_amount[$id_product]             = $p1_amount_all;
                $p1_percentage[$id_product]         = $p1_percentage_all;
                $p1_replace[$id_product]            = $p1_replace_all;
                $p1_on_sale[$id_product]            = $p1_on_sale_all;
                $p1_monday[$id_product]             = $p1_monday_all;
                $p1_tuesday[$id_product]            = $p1_tuesday_all;
                $p1_wednesday[$id_product]          = $p1_wednesday_all;
                $p1_thursday[$id_product]           = $p1_thursday_all;
                $p1_friday[$id_product]             = $p1_friday_all;
                $p1_saturday[$id_product]           = $p1_saturday_all;
                $p1_sunday[$id_product]             = $p1_sunday_all;
                $p1_delete[$id_product]             = $p1_delete_all;

                if (isset($period_1['id_specific_price'])) {
                    $p1_id_specific_price[$id_product] = $period_1['id_specific_price'];
                }

                if (isset($period_1['id_ntreduction'])) {
                    $p1_id_ntreduction[$id_product] = $period_1['id_ntreduction'];
                }

                $p2_id_specific_price[$id_product]  = 0;
                $p2_id_ntreduction[$id_product]     = 0;
                $p2_date_from[$id_product]          = $p2_date_from_all;
                $p2_date_to[$id_product]            = $p2_date_to_all;
                $p2_new_price[$id_product]          = $p2_new_price_all;
                $p2_discount_price[$id_product]     = $p2_discount_price_all;
                $p2_amount[$id_product]             = $p2_amount_all;
                $p2_percentage[$id_product]         = $p2_percentage_all;
                $p2_replace[$id_product]            = $p2_replace_all;
                $p2_on_sale[$id_product]            = $p2_on_sale_all;
                $p2_monday[$id_product]             = $p2_monday_all;
                $p2_tuesday[$id_product]            = $p2_tuesday_all;
                $p2_wednesday[$id_product]          = $p2_wednesday_all;
                $p2_thursday[$id_product]           = $p2_thursday_all;
                $p2_friday[$id_product]             = $p2_friday_all;
                $p2_saturday[$id_product]           = $p2_saturday_all;
                $p2_sunday[$id_product]             = $p2_sunday_all;
                $p2_delete[$id_product]             = $p2_delete_all;

                if (isset($period_2['id_specific_price'])) {
                    $p2_id_specific_price[$id_product] = $period_2['id_specific_price'];
                }

                if (isset($period_2['id_ntreduction'])) {
                    $p2_id_ntreduction[$id_product] = $period_2['id_ntreduction'];
                }
            }
        } else {
            $reset_init_price = Tools::getValue('reset_init_price');

            $p1_id_specific_price   = Tools::getValue('p1_id_specific_price');
            $p1_id_ntreduction      = Tools::getValue('p1_id_ntreduction');
            $p1_date_from           = Tools::getValue('p1_date_from');
            $p1_date_to             = Tools::getValue('p1_date_to');
            $p1_new_price           = str_replace(',', '.', Tools::getValue('p1_new_price'));
            $p1_discount_price      = str_replace(',', '.', Tools::getValue('p1_discount_price'));
            $p1_amount              = str_replace(',', '.', Tools::getValue('p1_amount'));
            $p1_percentage          = str_replace(',', '.', Tools::getValue('p1_percentage'));
            $p1_replace             = Tools::getValue('p1_replace');
            $p1_on_sale             = Tools::getValue('p1_on_sale');
            $p1_monday              = Tools::getValue('p1_monday');
            $p1_tuesday             = Tools::getValue('p1_tuesday');
            $p1_wednesday           = Tools::getValue('p1_wednesday');
            $p1_thursday            = Tools::getValue('p1_thursday');
            $p1_friday              = Tools::getValue('p1_friday');
            $p1_saturday            = Tools::getValue('p1_saturday');
            $p1_sunday              = Tools::getValue('p1_sunday');
            $p1_delete              = Tools::getValue('p1_delete');

            $p2_id_specific_price   = Tools::getValue('p2_id_specific_price');
            $p2_id_ntreduction      = Tools::getValue('p2_id_ntreduction');
            $p2_date_from           = Tools::getValue('p2_date_from');
            $p2_date_to             = Tools::getValue('p2_date_to');
            $p2_new_price           = str_replace(',', '.', Tools::getValue('p2_new_price'));
            $p2_discount_price      = str_replace(',', '.', Tools::getValue('p2_discount_price'));
            $p2_amount              = str_replace(',', '.', Tools::getValue('p2_amount'));
            $p2_percentage          = str_replace(',', '.', Tools::getValue('p2_percentage'));
            $p2_replace             = Tools::getValue('p2_replace');
            $p2_on_sale             = Tools::getValue('p2_on_sale');
            $p2_monday              = Tools::getValue('p2_monday');
            $p2_tuesday             = Tools::getValue('p2_tuesday');
            $p2_wednesday           = Tools::getValue('p2_wednesday');
            $p2_thursday            = Tools::getValue('p2_thursday');
            $p2_friday              = Tools::getValue('p2_friday');
            $p2_saturday            = Tools::getValue('p2_saturday');
            $p2_sunday              = Tools::getValue('p2_sunday');
            $p2_delete              = Tools::getValue('p2_delete');
        }

        if (!is_array($p1_date_from) || !count($p1_date_from)) {
            $error[] = $this->l('Error, no product found. Please check your filters and click on the "Filter" button');

            die(Tools::jsonEncode(array('error' => $error)));
        }

        foreach ($p1_date_from as $id_product => &$date_from) {
            if (isset($reset_init_price[$id_product]) || $reset_init_price_all) {
                $id_information = (int)Informations::getIdByProduct($id_product);
                $information = new Informations($id_information);
                $information->delete();
            }

            $product_name = Product::getProductName($id_product);

            $p1_replace[$id_product] = (empty($p1_replace[$id_product])) ? false : (bool)$p1_replace[$id_product];
            $p2_replace[$id_product] = (empty($p2_replace[$id_product])) ? false : (bool)$p2_replace[$id_product];

            $p1_on_sale[$id_product] = (empty($p1_on_sale[$id_product])) ? false : (bool)$p1_on_sale[$id_product];
            $p2_on_sale[$id_product] = (empty($p2_on_sale[$id_product])) ? false : (bool)$p2_on_sale[$id_product];

            $p1_monday[$id_product] = (empty($p1_monday[$id_product])) ? false : (bool)$p1_monday[$id_product];
            $p2_monday[$id_product] = (empty($p2_monday[$id_product])) ? false : (bool)$p2_monday[$id_product];

            $p1_tuesday[$id_product] = (empty($p1_tuesday[$id_product])) ? false : (bool)$p1_tuesday[$id_product];
            $p2_tuesday[$id_product] = (empty($p2_tuesday[$id_product])) ? false : (bool)$p2_tuesday[$id_product];

            $p1_wednesday[$id_product] = (empty($p1_wednesday[$id_product])) ? false : (bool)$p1_wednesday[$id_product];
            $p2_wednesday[$id_product] = (empty($p2_wednesday[$id_product])) ? false : (bool)$p2_wednesday[$id_product];

            $p1_thursday[$id_product] = (empty($p1_thursday[$id_product])) ? false : (bool)$p1_thursday[$id_product];
            $p2_thursday[$id_product] = (empty($p2_thursday[$id_product])) ? false : (bool)$p2_thursday[$id_product];

            $p1_friday[$id_product] = (empty($p1_friday[$id_product])) ? false : (bool)$p1_friday[$id_product];
            $p2_friday[$id_product] = (empty($p2_friday[$id_product])) ? false : (bool)$p2_friday[$id_product];

            $p1_saturday[$id_product] = (empty($p1_saturday[$id_product])) ? false : (bool)$p1_saturday[$id_product];
            $p2_saturday[$id_product] = (empty($p2_saturday[$id_product])) ? false : (bool)$p2_saturday[$id_product];

            $p1_sunday[$id_product] = (empty($p1_sunday[$id_product])) ? false : (bool)$p1_sunday[$id_product];
            $p2_sunday[$id_product] = (empty($p2_sunday[$id_product])) ? false : (bool)$p2_sunday[$id_product];

            /*** if there is all product value, we use it ***/
            $p1_date_from[$id_product] = ($p1_date_from_all != '') ? $p1_date_from_all : $p1_date_from[$id_product];
            $p1_date_to[$id_product] = ($p1_date_to_all != '') ? $p1_date_to_all : $p1_date_to[$id_product];
            $p1_replace[$id_product] = ($p1_replace_all)  ? $p1_replace_all : $p1_replace[$id_product];

            if ($p1_on_sale_all == 1) {
                $p1_on_sale[$id_product] = true;
            } elseif ($p1_on_sale_all == 2) {
                $p1_on_sale[$id_product] = false;
            }

            if ($p1_monday_all == 1) {
                $p1_monday[$id_product] = true;
            } elseif ($p1_on_sale_all == 2) {
                $p1_monday[$id_product] = false;
            }

            if ($p1_tuesday_all == 1) {
                $p1_tuesday[$id_product] = true;
            } elseif ($p1_tuesday_all == 2) {
                $p1_tuesday[$id_product] = false;
            }

            if ($p1_wednesday_all == 1) {
                $p1_wednesday[$id_product] = true;
            } elseif ($p1_wednesday_all == 2) {
                $p1_wednesday[$id_product] = false;
            }

            if ($p1_thursday_all == 1) {
                $p1_thursday[$id_product] = true;
            } elseif ($p1_thursday_all == 2) {
                $p1_thursday[$id_product] = false;
            }

            if ($p1_friday_all == 1) {
                $p1_friday[$id_product] = true;
            } elseif ($p1_friday_all == 2) {
                $p1_friday[$id_product] = false;
            }

            if ($p1_saturday_all == 1) {
                $p1_saturday[$id_product] = true;
            } elseif ($p1_saturday_all == 2) {
                $p1_saturday[$id_product] = false;
            }

            if ($p1_sunday_all == 1) {
                $p1_sunday[$id_product] = true;
            } elseif ($p1_sunday_all == 2) {
                $p1_sunday[$id_product] = false;
            }

            if ($p1_new_price_all != '') {
                $p1_new_price[$id_product] = $p1_new_price_all;
            }

            if ($p1_discount_price_all != '' || $p1_amount_all != '' || $p1_percentage_all != '') {
                $p1_discount_price[$id_product] = $p1_discount_price_all;
                $p1_amount[$id_product]         = $p1_amount_all;
                $p1_percentage[$id_product]     = $p1_percentage_all;
            }

            /* If there is reductions without date */
            if ($p1_new_price[$id_product] != ''
                || $p1_discount_price[$id_product] != ''
                || $p1_amount[$id_product] != ''
                || $p1_percentage[$id_product] != ''
            ) {
                if ($p1_date_from[$id_product] == '') {
                    $p1_date_from[$id_product] = $from_default;
                }

                if ($p1_date_to[$id_product] == '') {
                    $p1_date_to[$id_product] = $to_default;
                }
            }

            $p2_date_from[$id_product]  = ($p2_date_from_all != '') ? $p2_date_from_all : $p2_date_from[$id_product];
            $p2_date_to[$id_product]    = ($p2_date_to_all != '') ? $p2_date_to_all : $p2_date_to[$id_product];
            $p2_replace[$id_product]    = ($p2_replace_all)  ? $p2_replace_all : $p2_replace[$id_product];

            if ($p2_on_sale_all == 1) {
                $p2_on_sale[$id_product] = true;
            } elseif ($p2_on_sale_all == 2) {
                $p2_on_sale[$id_product] = false;
            }

            if ($p2_monday_all == 1) {
                $p2_monday[$id_product] = true;
            } elseif ($p2_monday_all == 2) {
                $p2_monday[$id_product] = false;
            }

            if ($p2_tuesday_all == 1) {
                $p2_tuesday[$id_product] = true;
            } elseif ($p2_tuesday_all == 2) {
                $p2_tuesday[$id_product] = false;
            }

            if ($p2_wednesday_all == 1) {
                $p2_wednesday[$id_product] = true;
            } elseif ($p2_wednesday_all == 2) {
                $p2_wednesday[$id_product] = false;
            }

            if ($p2_thursday_all == 1) {
                $p2_thursday[$id_product] = true;
            } elseif ($p2_thursday_all == 2) {
                $p2_thursday[$id_product] = false;
            }

            if ($p2_friday_all == 1) {
                $p2_friday[$id_product] = true;
            } elseif ($p2_friday_all == 2) {
                $p2_friday[$id_product] = false;
            }

            if ($p2_saturday_all == 1) {
                $p2_saturday[$id_product] = true;
            } elseif ($p2_saturday_all == 2) {
                $p2_saturday[$id_product] = false;
            }

            if ($p2_sunday_all == 1) {
                $p2_sunday[$id_product] = true;
            } elseif ($p2_sunday_all == 2) {
                $p2_sunday[$id_product] = false;
            }

            if ($p2_new_price_all != '') {
                $p2_new_price[$id_product]  = $p2_new_price_all;
            }

            if ($p2_discount_price_all != '' || $p2_amount_all != '' || $p2_percentage_all != '') {
                $p2_discount_price[$id_product] = $p2_discount_price_all;
                $p2_amount[$id_product]         = $p2_amount_all;
                $p2_percentage[$id_product]     = $p2_percentage_all;
            }

            /* If there is reductions without date */
            if ($p2_new_price[$id_product] != ''
                || $p2_discount_price[$id_product] != ''
                || $p2_amount[$id_product] != ''
                || $p2_percentage[$id_product] != ''
            ) {
                if ($p2_date_from[$id_product] == '') {
                    $p2_date_from[$id_product] = $from_default;
                }

                if ($p2_date_to[$id_product] == '') {
                    $p2_date_to[$id_product] = $to_default;
                }
            }
            /***************************************************/

            if (empty($p1_delete_all) && empty($p1_delete[$id_product])) {
                /* Check period 1 datas */
                $error_1 = $ntr->validateSpecificPrice(
                    $product_name,
                    1,
                    $p1_date_from[$id_product],
                    $p1_date_to[$id_product],
                    $p1_new_price[$id_product],
                    $p1_discount_price[$id_product],
                    $p1_amount[$id_product],
                    $p1_percentage[$id_product],
                    $p1_replace[$id_product],
                    $p1_on_sale[$id_product]
                );
                $error = array_merge($error, $error_1);
            }

            if (empty($p2_delete_all) && empty($p2_delete[$id_product])) {
                /* Check period 2 datas */
                $error_2 = $ntr->validateSpecificPrice(
                    $product_name,
                    2,
                    $p2_date_from[$id_product],
                    $p2_date_to[$id_product],
                    $p2_new_price[$id_product],
                    $p2_discount_price[$id_product],
                    $p2_amount[$id_product],
                    $p2_percentage[$id_product],
                    $p2_replace[$id_product],
                    $p2_on_sale[$id_product]
                );
                $error = array_merge($error, $error_2);
            }

            if (empty($p1_delete_all)
                && empty($p1_delete[$id_product])
                && empty($p2_delete_all)
                && empty($p2_delete[$id_product])
            ) {
                /* Check crossing dates */
                $error_3 = $ntr->validateCrossingDate(
                    $product_name,
                    $p1_date_from[$id_product],
                    $p2_date_from[$id_product],
                    $p1_date_to[$id_product],
                    $p2_date_to[$id_product]
                );

                $error = array_merge($error, $error_3);
            }
        }

        if (count($error) > 0) {
            die(Tools::jsonEncode(array('error' => $error)));
        } else {
            foreach ($p1_date_from as $id_product => $p_date_from) {
                $ok = true;
                $product_name = Product::getProductName($id_product);

                /*************** Set each products specific price values ****************/
                if ((!empty($p1_delete_all) || !empty($p1_delete[$id_product]))) {
                    $id_ntreduction = 0;
                    $p1_id_specific_price_int = 0;
                    $nt_id_specific_price = 0;

                    if (!empty($p1_id_specific_price[$id_product]) && $p1_id_specific_price[$id_product] != 0) {
                        $specificprice = new SpecificPrice($p1_id_specific_price[$id_product]);
                        $id_ntreduction = (int)Reduction::getIdReductionBySpecificPrice($specificprice->id);
                        $p1_id_specific_price_int = (int)$specificprice->id;

                        if (!$id_ntreduction) {
                            $specificprice->delete();
                        }
                    } elseif (!empty($p1_id_ntreduction[$id_product]) && $p1_id_ntreduction[$id_product] != 0) {
                        $id_ntreduction = (int)$p1_id_ntreduction[$id_product];
                    }

                    if ($id_ntreduction != 0) {
                        $nt_reduction           = new Reduction($id_ntreduction);
                        $nt_id_specific_price   = $nt_reduction->id_specific_price;

                        $nt_reduction->delete();

                        if ($nt_id_specific_price != 0
                            && (empty($p1_id_specific_price[$id_product]) || $p1_id_specific_price[$id_product] == 0)
                        ) {
                            $specificprice = new SpecificPrice($nt_id_specific_price);
                            $specificprice->delete();
                        }

                        if ($p1_id_specific_price_int != 0) {
                            $specificprice = new SpecificPrice($p1_id_specific_price_int);
                            $specificprice->delete();
                        }
                    }
                } elseif (empty($p1_delete_all) && empty($p1_delete[$id_product])) {
                    $error = $ntr->updateSpecificPrice(
                        $product_name,
                        $id_shop,
                        $id_shop_group,
                        $id_currency,
                        $id_country,
                        $id_group,
                        $priorities,
                        $id_product,
                        $p1_date_from[$id_product],
                        $p1_date_to[$id_product],
                        $p1_new_price[$id_product],
                        $p1_discount_price[$id_product],
                        $p1_amount[$id_product],
                        $p1_percentage[$id_product],
                        $p1_id_specific_price[$id_product],
                        $p1_id_ntreduction[$id_product],
                        $p1_replace[$id_product],
                        $p1_on_sale[$id_product],
                        $p1_monday[$id_product],
                        $p1_tuesday[$id_product],
                        $p1_wednesday[$id_product],
                        $p1_thursday[$id_product],
                        $p1_friday[$id_product],
                        $p1_saturday[$id_product],
                        $p1_sunday[$id_product]
                    );

                    if (count($error) > 0) {
                        die(Tools::jsonEncode(array('error' => $error)));
                    }
                }

                if ((!empty($p2_delete_all) || !empty($p2_delete[$id_product]))) {
                    $id_ntreduction             = 0;
                    $p2_id_specific_price_int   = 0;
                    $nt_id_specific_price       = 0;

                    if (!empty($p2_id_specific_price[$id_product]) && $p2_id_specific_price[$id_product] != 0) {
                        $specificprice = new SpecificPrice($p2_id_specific_price[$id_product]);
                        $id_ntreduction = (int)Reduction::getIdReductionBySpecificPrice($specificprice->id);
                        $p2_id_specific_price_int = (int)$specificprice->id;

                        if (!$id_ntreduction) {
                            $specificprice->delete();
                        }
                    } elseif (!empty($p2_id_ntreduction[$id_product]) && $p2_id_ntreduction[$id_product] != 0) {
                        $id_ntreduction = (int)$p2_id_ntreduction[$id_product];
                    }

                    if ($id_ntreduction != 0) {
                        $nt_reduction           = new Reduction($id_ntreduction);
                        $nt_id_specific_price   = $nt_reduction->id_specific_price;

                        $nt_reduction->delete();

                        if ($nt_id_specific_price != 0
                            && (empty($p2_id_specific_price[$id_product]) || $p2_id_specific_price[$id_product] == 0)
                        ) {
                            $specificprice = new SpecificPrice($nt_id_specific_price);
                            $specificprice->delete();
                        }

                        if ($p2_id_specific_price_int != 0) {
                            $specificprice = new SpecificPrice($p2_id_specific_price_int);
                            $specificprice->delete();
                        }
                    }
                } elseif (empty($p2_delete_all) && empty($p2_delete[$id_product])) {
                    $error = $ntr->updateSpecificPrice(
                        $product_name,
                        $id_shop,
                        $id_shop_group,
                        $id_currency,
                        $id_country,
                        $id_group,
                        $priorities,
                        $id_product,
                        $p2_date_from[$id_product],
                        $p2_date_to[$id_product],
                        $p2_new_price[$id_product],
                        $p2_discount_price[$id_product],
                        $p2_amount[$id_product],
                        $p2_percentage[$id_product],
                        $p2_id_specific_price[$id_product],
                        $p2_id_ntreduction[$id_product],
                        $p2_replace[$id_product],
                        $p2_on_sale[$id_product],
                        $p2_monday[$id_product],
                        $p2_tuesday[$id_product],
                        $p2_wednesday[$id_product],
                        $p2_thursday[$id_product],
                        $p2_friday[$id_product],
                        $p2_saturday[$id_product],
                        $p2_sunday[$id_product]
                    );

                    if (count($error) > 0) {
                        die(Tools::jsonEncode(array('error' => $error)));
                    }
                }
            }
        }

        if ($ok) {
            die(Tools::jsonEncode(array('ok' => 'ok')));
        } else {
            $error = $ntr->updateSpecificPrice(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            );
            die(Tools::jsonEncode(array('error' => $error)));
        }
    }

    public function saveConfigColumns()
    {
        $columns_to_hide = array();

        /* Product columns */
        if (!Tools::getValue('p_1')) {
            $columns_to_hide[] = 'p_1';
        }

        if (!Tools::getValue('p_2')) {
            $columns_to_hide[] = 'p_2';
        }

        if (!Tools::getValue('p_3')) {
            $columns_to_hide[] = 'p_3';
        }

        if (!Tools::getValue('p_4')) {
            $columns_to_hide[] = 'p_4';
        }

        if (!Tools::getValue('p_price_no_tax')) {
            $columns_to_hide[] = 'p_price_no_tax';
        }

        if (!Tools::getValue('p_margin_after_discount')) {
            $columns_to_hide[] = 'p_margin_after_discount';
        }

        if (!Tools::getValue('p_5')) {
            $columns_to_hide[] = 'p_5';
        }

        if (!Tools::getValue('p_6')) {
            $columns_to_hide[] = 'p_6';
        }

        if (!Tools::getValue('p_7')) {
            $columns_to_hide[] = 'p_7';
        }

        if (!Tools::getValue('p_8')) {
            $columns_to_hide[] = 'p_8';
        }

        if (!Tools::getValue('p_init_price')) {
            $columns_to_hide[] = 'p_init_price';
        }

        /* Period 1 columns */
        if (!Tools::getValue('p1_1')) {
            $columns_to_hide[] = 'p1_1';
        }

        if (!Tools::getValue('p1_2')) {
            $columns_to_hide[] = 'p1_2';
        }

        if (!Tools::getValue('p1_3')) {
            $columns_to_hide[] = 'p1_3';
        }

        if (!Tools::getValue('p1_4')) {
            $columns_to_hide[] = 'p1_4';
        }

        if (!Tools::getValue('p1_5')) {
            $columns_to_hide[] = 'p1_5';
        }

        if (!Tools::getValue('p1_6')) {
            $columns_to_hide[] = 'p1_6';
        }

        if (!Tools::getValue('p1_7')) {
            $columns_to_hide[] = 'p1_7';
        }

        if (!Tools::getValue('p1_8')) {
            $columns_to_hide[] = 'p1_8';
        }

        if (!Tools::getValue('p1_9')) {
            $columns_to_hide[] = 'p1_9';
        }

        if (!Tools::getValue('p1_10')) {
            $columns_to_hide[] = 'p1_10';
        }

        if (!Tools::getValue('p1_11')) {
            $columns_to_hide[] = 'p1_11';
        }

        if (!Tools::getValue('p1_12')) {
            $columns_to_hide[] = 'p1_12';
        }

        if (!Tools::getValue('p1_13')) {
            $columns_to_hide[] = 'p1_13';
        }

        if (!Tools::getValue('p1_14')) {
            $columns_to_hide[] = 'p1_14';
        }

        if (!Tools::getValue('p1_15')) {
            $columns_to_hide[] = 'p1_15';
        }

        if (!Tools::getValue('p1_16')) {
            $columns_to_hide[] = 'p1_16';
        }


        /* Period 2 columns */
        if (!Tools::getValue('p2_1')) {
            $columns_to_hide[] = 'p2_1';
        }

        if (!Tools::getValue('p2_2')) {
            $columns_to_hide[] = 'p2_2';
        }

        if (!Tools::getValue('p2_3')) {
            $columns_to_hide[] = 'p2_3';
        }

        if (!Tools::getValue('p2_4')) {
            $columns_to_hide[] = 'p2_4';
        }

        if (!Tools::getValue('p2_5')) {
            $columns_to_hide[] = 'p2_5';
        }

        if (!Tools::getValue('p2_6')) {
            $columns_to_hide[] = 'p2_6';
        }

        if (!Tools::getValue('p2_7')) {
            $columns_to_hide[] = 'p2_7';
        }

        if (!Tools::getValue('p2_8')) {
            $columns_to_hide[] = 'p2_8';
        }

        if (!Tools::getValue('p2_9')) {
            $columns_to_hide[] = 'p2_9';
        }

        if (!Tools::getValue('p2_10')) {
            $columns_to_hide[] = 'p2_10';
        }

        if (!Tools::getValue('p2_11')) {
            $columns_to_hide[] = 'p2_11';
        }

        if (!Tools::getValue('p2_12')) {
            $columns_to_hide[] = 'p2_12';
        }

        if (!Tools::getValue('p2_13')) {
            $columns_to_hide[] = 'p2_13';
        }

        if (!Tools::getValue('p2_14')) {
            $columns_to_hide[] = 'p2_14';
        }

        if (!Tools::getValue('p2_15')) {
            $columns_to_hide[] = 'p2_15';
        }

        if (!Tools::getValue('p2_16')) {
            $columns_to_hide[] = 'p2_16';
        }

        /* Other config */
        if (Tools::isSubmit('display_init_price')) {
            $display_init_price = Tools::getValue('display_init_price');
        } else {
            $display_init_price = 0;
        }

        if (Tools::isSubmit('hide_products')) {
            $hide_products = Tools::getValue('hide_products');
        } else {
            $hide_products = 0;
        }

        $clean_col = implode(':', $columns_to_hide);

        $res_hide_columns       = Configuration::updateValue('NTREDUCTION_HIDE_COLUMNS', $clean_col);
        $res_display_init_price = Configuration::updateValue('DISPLAY_INIT_PRICE', $display_init_price);
        $res_hide_products      = Configuration::updateValue('NTREDUCTION_HIDE_PRODUCTS', $hide_products);

        if (!$res_hide_columns || !$res_display_init_price || !$res_hide_products) {
            die(Tools::jsonEncode(array('result' => 'nok')));
        } else {
            die(Tools::jsonEncode(array('result' => 'ok')));
        }
    }

    public function saveConfigCron()
    {
        $success = true;
        $no_cron = Tools::isSubmit('no_cron');

        // If in All Shops (group is not authorized)
        if (Shop::getContext() != Shop::CONTEXT_SHOP) {
            $list_shops     = Shop::getContextListShopID();

            // We update no_cron in all shops
            foreach ($list_shops as $id_shop) {
                $id_shop_group = Shop::getGroupFromShop($id_shop);

                if (!Configuration::updateValue('NTREDUCTION_NO_CRON', $no_cron, false, $id_shop_group, $id_shop)) {
                    $success = false;
                }
            }
        } elseif (!$no_cron) {
            // If the current shop has no_cron disabled, no_cron is disabled in All Shops
            if (!Configuration::updateValue('NTREDUCTION_NO_CRON', $no_cron, false, 0, 0)) {
                $success = false;
            }
        }

        if (!$success || !Configuration::updateValue('NTREDUCTION_NO_CRON', $no_cron)) {
            die(Tools::jsonEncode(array('result' => 'nok')));
        } else {
            Configuration::updateValue('NTREDUCTION_LAST_UPDATE', '');
            die(Tools::jsonEncode(array('result' => 'ok')));
        }
    }

    public function exportReduction()
    {
        $ntr            = new NtReduction();
        $id_categories  = explode(',', Tools::getValue('id_categories'));
        $id_currency    = (int)Tools::getValue('id_currency');
        $id_country     = (int)Tools::getValue('id_country');
        $id_group       = (int)Tools::getValue('id_group');
        $active         = (int)Tools::getValue('active');
        $discounted     = (int)Tools::getValue('discounted');
        $suppliers      = explode(',', Tools::getValue('supplier'));
        $manufacturers  = explode(',', Tools::getValue('manufacturer'));
        $search         = Tools::getValue('search');
        $lines          = array();

        //multiboutique
        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $id_shop        = (int)$this->context->shop->id;
            //$id_shop_group  = (int)$this->context->shop->id_shop_group;
        } else {
            $id_shop        = 0;
            //$id_shop_group  = 0;
        }

        $products = $ntr->getListProductSpecificPrice(
            $id_categories,
            $id_shop,
            $id_currency,
            $id_country,
            $id_group,
            $active,
            $search,
            $suppliers,
            $manufacturers,
            $this->context->employee->id,
            $discounted
        );

        ksort($products);

        $lines[] = array(
            $ntr->l('Name', self::PAGE),
            $ntr->l('Reference', self::PAGE),
            $ntr->l('Price', self::PAGE),
            $ntr->l('Price (Tax excl.)', self::PAGE),
            $ntr->l('Init price', self::PAGE),
            $ntr->l('Margin after discount', self::PAGE),
            $ntr->l('Quantity', self::PAGE),
            $ntr->l('Last reduced price', self::PAGE),
            $ntr->l('Current reduced price', self::PAGE),
            $ntr->l('Next reduced price', self::PAGE),
            $ntr->l('Start date', self::PAGE),
            $ntr->l('End date', self::PAGE),
            $ntr->l('New price', self::PAGE),
            $ntr->l('Discount amount', self::PAGE),
            $ntr->l('Discount percentage', self::PAGE),
            $ntr->l('On sale', self::PAGE),
            $ntr->l('Monday', self::PAGE),
            $ntr->l('Tuesday', self::PAGE),
            $ntr->l('Wednesday', self::PAGE),
            $ntr->l('Thursday', self::PAGE),
            $ntr->l('Friday', self::PAGE),
            $ntr->l('Saturday', self::PAGE),
            $ntr->l('Sunday', self::PAGE),
            $ntr->l('Start date', self::PAGE),
            $ntr->l('End date', self::PAGE),
            $ntr->l('New price', self::PAGE),
            $ntr->l('Discount amount', self::PAGE),
            $ntr->l('Discount percentage', self::PAGE),
            $ntr->l('On sale', self::PAGE),
            $ntr->l('Monday', self::PAGE),
            $ntr->l('Tuesday', self::PAGE),
            $ntr->l('Wednesday', self::PAGE),
            $ntr->l('Thursday', self::PAGE),
            $ntr->l('Friday', self::PAGE),
            $ntr->l('Saturday', self::PAGE),
            $ntr->l('Sunday', self::PAGE),
        );

        foreach ($products as $product) {
            $id_currency_default    = (int)Configuration::get('PS_CURRENCY_DEFAULT');
            $margin_after_discount  = '';
            $init_price             = '';
            $last_reduced_price     = '';
            $current_reduced_price  = '';
            $next_reduced_price     = '';
            $p1_from                = '';
            $p1_to                  = '';
            $p1_price               = '';
            $p1_amount              = '';
            $p1_percentage          = '';
            $p1_on_sale             = 0;
            $p1_monday              = 0;
            $p1_tuesday             = 0;
            $p1_wednesday           = 0;
            $p1_thursday            = 0;
            $p1_friday              = 0;
            $p1_saturday            = 0;
            $p1_sunday              = 0;
            $p2_from                = '';
            $p2_to                  = '';
            $p2_price               = '';
            $p2_amount              = '';
            $p2_percentage          = '';
            $p2_on_sale             = 0;
            $p2_monday              = 0;
            $p2_tuesday             = 0;
            $p2_wednesday           = 0;
            $p2_thursday            = 0;
            $p2_friday              = 0;
            $p2_saturday            = 0;
            $p2_sunday              = 0;

            if ($product['init_price'] > 0) {
                $init_price = $product['init_price_clean'];
            }

            if ($product['margin_after_discount'] > 0) {
                $margin_after_discount = $product['margin_after_discount_clean'];
            }

            if ($product['last_reduced_price'] > 0) {
                $last_reduced_price = Tools::displayPrice($product['last_reduced_price'], $id_currency_default);
            }

            if ($product['current_reduced_price'] > 0) {
                $current_reduced_price = Tools::displayPrice($product['current_reduced_price'], $id_currency_default);
            }

            if ($product['next_reduced_price'] > 0) {
                $next_reduced_price = Tools::displayPrice($product['next_reduced_price'], $id_currency_default);
            }

            if (isset($product['period_1']['from'])) {
                $p1_from = $product['period_1']['from'];
            }

            if (isset($product['period_1']['to'])) {
                $p1_to = $product['period_1']['to'];
            }

            if (isset($product['period_1']['price']) && $product['period_1']['price'] > 0) {
                $p1_price = Tools::displayPrice($product['period_1']['price'], $id_currency_default);
            }

            if (isset($product['period_1']['reduction'])
                && isset($product['period_1']['reduction_type'])
                && $product['period_1']['reduction'] > 0
            ) {
                if ($product['period_1']['reduction_type'] == 'amount') {
                    $p1_amount = Tools::displayPrice($product['period_1']['reduction'], $id_currency_default);
                } elseif ($product['period_1']['reduction_type'] == 'percentage') {
                    $p1_percentage = $product['period_1']['reduction'].'%';
                }
            }

            if (isset($product['period_1']['on_sale'])) {
                $p1_on_sale = (int)$product['period_1']['on_sale'];
            }

            if (isset($product['period_1']['monday'])) {
                $p1_monday = (int)$product['period_1']['monday'];
            }

            if (isset($product['period_1']['tuesday'])) {
                $p1_tuesday = (int)$product['period_1']['tuesday'];
            }

            if (isset($product['period_1']['wednesday'])) {
                $p1_wednesday = (int)$product['period_1']['wednesday'];
            }

            if (isset($product['period_1']['thursday'])) {
                $p1_thursday = (int)$product['period_1']['thursday'];
            }

            if (isset($product['period_1']['friday'])) {
                $p1_friday = (int)$product['period_1']['friday'];
            }

            if (isset($product['period_1']['saturday'])) {
                $p1_saturday = (int)$product['period_1']['saturday'];
            }

            if (isset($product['period_1']['sunday'])) {
                $p1_sunday = (int)$product['period_1']['sunday'];
            }

            if (isset($product['period_2']['from'])) {
                $p2_from = $product['period_2']['from'];
            }

            if (isset($product['period_2']['to'])) {
                $p2_to = $product['period_2']['to'];
            }

            if (isset($product['period_2']['price']) && $product['period_2']['price'] > 0) {
                $p2_price = Tools::displayPrice($product['period_2']['price'], $id_currency_default);
            }

            if (isset($product['period_2']['reduction'])
                && isset($product['period_2']['reduction_type'])
                && $product['period_2']['reduction'] > 0
            ) {
                if ($product['period_2']['reduction_type'] == 'amount') {
                    $p2_amount = Tools::displayPrice($product['period_2']['reduction'], $id_currency_default);
                } elseif ($product['period_2']['reduction_type'] == 'percentage') {
                    $p2_percentage = Tools::displayPrice($product['period_2']['reduction'], $id_currency_default);
                }
            }

            if (isset($product['period_2']['on_sale'])) {
                $p2_on_sale = (int)$product['period_2']['on_sale'];
            }

            if (isset($product['period_2']['monday'])) {
                $p2_monday = (int)$product['period_2']['monday'];
            }

            if (isset($product['period_2']['tuesday'])) {
                $p2_tuesday = (int)$product['period_2']['tuesday'];
            }

            if (isset($product['period_2']['wednesday'])) {
                $p2_wednesday = (int)$product['period_2']['wednesday'];
            }

            if (isset($product['period_2']['thursday'])) {
                $p2_thursday = (int)$product['period_2']['thursday'];
            }

            if (isset($product['period_2']['friday'])) {
                $p2_friday = (int)$product['period_2']['friday'];
            }

            if (isset($product['period_2']['saturday'])) {
                $p2_saturday = (int)$product['period_2']['saturday'];
            }

            if (isset($product['period_2']['sunday'])) {
                $p2_sunday = (int)$product['period_2']['sunday'];
            }

            $lines[] = array(
                $product['name'],
                $product['reference'],
                $product['price_tax_incl_clean'],
                $product['price_tax_excl_clean'],
                $init_price,
                $margin_after_discount,
                $product['available_qt'],
                $last_reduced_price,
                $current_reduced_price,
                $next_reduced_price,
                $p1_from,
                $p1_to,
                $p1_price,
                $p1_amount,
                $p1_percentage,
                $p1_on_sale,
                $p1_monday,
                $p1_tuesday,
                $p1_wednesday,
                $p1_thursday,
                $p1_friday,
                $p1_saturday,
                $p1_sunday,
                $p2_from,
                $p2_to,
                $p2_price,
                $p2_amount,
                $p2_percentage,
                $p2_on_sale,
                $p2_monday,
                $p2_tuesday,
                $p2_wednesday,
                $p2_thursday,
                $p2_friday,
                $p2_saturday,
                $p2_sunday,
            );
        }

        $domain_use     = Tools::getHttpHost();
        $protocol       = Tools::getCurrentUrlProtocolPrefix();
        $shop_domain    = $protocol.$domain_use;
        $module_url     = $shop_domain.__PS_BASE_URI__.'modules/';

        $export_path    = realpath(_PS_ROOT_DIR_.'/modules').'/'.$ntr->name.'/export/';
        $filename       = 'export_'.date('Ymd').'.csv';
        $handle         = fopen($export_path.$filename, 'w');

        foreach ($lines as $line) {
            fputcsv($handle, $line, ';');
        }

        fclose($handle);

        die(Tools::jsonEncode(array('filepath' => $module_url.$ntr->name.'/export/'.$filename)));
    }

    public function displayReduction()
    {
        $ntr            = new NtReduction();
        $id_categories  = explode(',', Tools::getValue('id_categories'));
        $id_currency    = (int)Tools::getValue('id_currency');
        $id_country     = (int)Tools::getValue('id_country');
        $id_group       = (int)Tools::getValue('id_group');
        $active         = (int)Tools::getValue('active');
        $discounted     = (int)Tools::getValue('discounted');
        $suppliers      = explode(',', Tools::getValue('supplier'));
        $manufacturers  = explode(',', Tools::getValue('manufacturer'));
        $search         = Tools::getValue('search');
        $products       = array();

        //multiboutique
        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $id_shop        = (int)$this->context->shop->id;
            //$id_shop_group  = (int)$this->context->shop->id_shop_group;
        } else {
            $id_shop        = 0;
            //$id_shop_group  = 0;
        }

        if (!Configuration::get('NTREDUCTION_HIDE_PRODUCTS')) {
            $products = $ntr->getListProductSpecificPrice(
                $id_categories,
                $id_shop,
                $id_currency,
                $id_country,
                $id_group,
                $active,
                $search,
                $suppliers,
                $manufacturers,
                $this->context->employee->id,
                $discounted
            );

            ksort($products);
        }

        $id_currency_default    = (int)Configuration::get('PS_CURRENCY_DEFAULT');
        $currency_default       = new Currency($id_currency_default);
        $currency_sign          = $currency_default->sign;

        if ($id_currency) {
            $array_currency = Currency::getCurrency($id_currency);
            $currency_sign = $array_currency['sign'];
        }

        die(Tools::jsonEncode(array('products' => $products, 'currency_sign' => $currency_sign)));
    }

    public function initToolBarTitle()
    {
        $this->toolbar_title = $this->l('2NT Reduction', self::PAGE);
    }

    /**
     * assign default action in page_header_toolbar_btn smarty var, if they are not set.
     * uses override to specifically add, modify or remove items
     *
     */
    public function initPageHeaderToolbar()
    {
        if (version_compare(_PS_VERSION_, '1.6.0', '>=') === true) {
            if ($this->display == 'view') {
                    $this->page_header_toolbar_btn['save'] = array(
                        'href' => '#',
                        'desc' => $this->l('Save', self::PAGE)
                    );
            }
            parent::initPageHeaderToolbar();
        }
    }

    /**
     * assign default action in toolbar_btn smarty var, if they are not set.
     * uses override to specifically add, modify or remove items
     *
     */
    public function initToolbar()
    {
        if (version_compare(_PS_VERSION_, '1.6.0', '>=') !== true) {
            if ($this->display == 'view') {
                // Default save button - action dynamically handled in javascript
                $this->toolbar_btn['save'] = array(
                    'href' => '#',
                    'desc' => $this->l('Save', self::PAGE)
                );
            }
        }
    }
}
