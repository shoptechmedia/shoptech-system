<?php
/**
 *   AmbJoliSearch Module : Search for prestashop
 *
 *   @author    Ambris Informatique
 *   @copyright Copyright (c) 2013-2015 Ambris Informatique SARL
 *   @license   Commercial license
 *   @module     Advanced Search (AmbJoliSearch)
 *   @file       jolisearch.php
 *
 *   @subject    main controller
 *   Support by mail: support@ambris.com
 */

require_once _PS_ROOT_DIR_ . '/modules/ambjolisearch/classes/definitions.php';
require_once _PS_ROOT_DIR_ . '/modules/ambjolisearch/classes/AmbSearch.php';

class AmbjolisearchjolisearchModuleFrontController extends ModuleFrontController
{
    public $no_image_path;
    public $priorities;
    public $max_items;
    public $allow;


    public function initContent()
    {
        parent::initContent();

        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $this->module = Module::getInstanceByName('ambjolisearch');
            $this->searcher = new AmbSearch(true, $this->context, $this->module);

            $real_query = urldecode(Tools::getValue('search_query'));
            //$query = Tools::replaceAccentedChars(urldecode(Tools::getValue('search_query')));
            $query = urldecode(Tools::getValue('search_query'));
            
            /*if ($_SERVER['REMOTE_ADDR'] === '124.104.208.102') {
                print_r(urldecode(Tools::getValue('search_query')));
                exit;
            }*/

            $this->context->link = new JoliLink($this->context->link);

            if (empty($query)) {
                $results = array();
                $nb_products = 0;
                $categories = array();
            } else {
                $order_by = Tools::replaceAccentedChars(urldecode(Tools::getValue('orderby', 'position')));
                $order_way = Tools::replaceAccentedChars(urldecode(Tools::getValue('orderway', 'desc')));
                $id_lang = Tools::getValue('id_lang', $this->context->language->id);

                $product_per_page = isset($this->context->cookie->nb_item_per_page) ? (int) $this->context->cookie->nb_item_per_page : Configuration::get('PS_PRODUCTS_PER_PAGE');
                $this->productSort();
                $n = abs((int) (Tools::getValue('n', $product_per_page)));
                $p = abs((int) Tools::getValue('p', 1));

                $this->searcher->search($id_lang, $query, $p, $n, $order_by, $order_way);
                $results = $this->searcher->getResults();
                $nb_products = $this->searcher->getTotal();
                $categories = $this->searcher->getCategories();

                Hook::exec('actionSearch', array('expr' => $query, 'total' => $nb_products));

                if (version_compare(_PS_VERSION_, 1.6, '>=')) {
                    $this->addColorsToProductList($results);
                }

                $this->pagination($nb_products);
                $this->assignProductSort();
            }


            $this->context->smarty->assign(array(
                'products' => $results,
                // DEPRECATED (since to 1.4), not use this: conflict with block_cart module
                'search_products' => $results,
                'nbProducts' => $nb_products,
                'search_query' => $query,
                'real_query' => $real_query,
                'comparator_max_item' => Configuration::get('PS_COMPARATOR_MAX_ITEM'),
                'subcategories' => $categories,
                'show_cat_desc' => pSQL(Configuration::get(AJS_SHOW_CAT_DESC, 0)),
                'link' => $this->context->link,
                'request' => $this->context->link->getPaginationLink(false, false, false, true),
            ));


            if (version_compare(_PS_VERSION_, 1.6, '>=')) {
                $this->context->smarty->assign('homeSize', Image::getSize(ImageType::getFormatedName('home')));
                $this->context->smarty->assign('mediumSize', Image::getSize(ImageType::getFormatedName('medium')));
                $this->setTemplate('tosearch16.tpl');
            } else {
                $this->context->smarty->assign('homeSize', Image::getSize('home'));
                $this->context->smarty->assign('mediumSize', Image::getSize('medium'));
                $this->setTemplate('tosearch15.tpl');
            }
        } else {
            $this->search_string = Tools::getValue('s');
            if (!$this->search_string) {
                $this->search_string = Tools::getValue('search_query');
            }
            if (!$this->search_string) {
                $this->search_string = Tools::getValue('q');
            }
            $this->search_tag = Tools::getValue('tag');

            $this->context->smarty->assign(array(
                'search_string' => $this->search_string,
                'search_tag' => $this->search_tag,
            ));

            $this->doProductSearch('../../../modules/ambjolisearch/views/templates/front/search-1.7.tpl', array('entity' => 'jolisearch'));
        }
    }

    public function run()
    {
        if (Tools::getValue('ajax', false) == true) {
            // to respond using the same protocol as the caller page
            $this->ssl = Tools::usingSecureMode();
            $this->init();
            if ($this->checkAccess()) {
                $this->displayAjax();
            }
        } else {
            parent::run();
        }
    }

    public function displayAjax()
    {
        $iso_code = $this->context->language->iso_code;

        $this->module = Module::getInstanceByName('ambjolisearch');
        $this->searcher = new AmbSearch(true, $this->context, $this->module);

        $this->no_image_path = array();
        if (Tools::file_exists_cache(_PS_THEME_DIR_ . 'modules/' . $this->module->name . '/views/img/no-image.png')) {
            $img_path = ($this->ssl ? _PS_BASE_URL_SSL_ : _PS_BASE_URL_) . _PS_THEME_DIR_
            . 'modules/' . $this->module->name . '/views/img/no-image.png';
            $this->no_image_path['p'] = $img_path;
            $this->no_image_path['m'] = $img_path;
            $this->no_image_path['c'] = $img_path;
        } elseif (Tools::file_exists_cache(_PS_MODULE_DIR_ . $this->module->name . '/views/img/no-image.png')) {
            $img_path = ($this->ssl ? _PS_BASE_URL_SSL_ : _PS_BASE_URL_) . _MODULE_DIR_
            . $this->module->name . '/views/img/no-image.png';
            $this->no_image_path['p'] = $img_path;
            $this->no_image_path['m'] = $img_path;
            $this->no_image_path['c'] = $img_path;
        } else {
            $small = 'small';
            $default = 'default';
            $small_default = $small . '_' . $default . '.jpg';
            $this->no_image_path['p'] = _PS_IMG_ . "p/$iso_code-default-" . $small_default;
            $this->no_image_path['m'] = _PS_IMG_ . "m/$iso_code-default-" . $small_default;
            $this->no_image_path['c'] = _PS_IMG_ . "c/$iso_code-default-" . $small_default;
        }

        $this->allow = (int) Configuration::get('PS_REWRITING_SETTINGS');

        $this->max_items = array();
        $this->max_items['all'] = (int) Configuration::get(AJS_MAX_ITEMS_KEY);
        $this->max_items['manufacturers'] = (int) Configuration::get(AJS_MAX_MANUFACTURERS_KEY);
        $this->max_items['categories'] = (int) Configuration::get(AJS_MAX_CATEGORIES_KEY);

        $this->priorities = array();
        $this->priorities['products'] = (int) Configuration::get(AJS_PRODUCTS_PRIORITY_KEY);
        $this->priorities['manufacturers'] = (int) Configuration::get(AJS_MANUFACTURERS_PRIORITY_KEY);
        $this->priorities['categories'] = (int) Configuration::get(AJS_CATEGORIES_PRIORITY_KEY);
        asort($this->priorities);

        $this->compatibility = (int) Configuration::get(AJS_APPROXIMATIVE_SEARCH_AJAX);

        $real_query = urldecode(Tools::getValue('q'));
        //$query = Tools::replaceAccentedChars(urldecode(Tools::getValue('q')));
        $query = urldecode(Tools::getValue('q'));
        $id_lang = Tools::getValue('id_lang', $this->context->language->id);

        $this->searcher->search(
            $id_lang,
            $query,
            1,
            $this->max_items['all'],
            'position',
            'desc'
        );

        $search_results = $this->searcher->getResults(true);
        $total = $this->searcher->getTotal();
        $sr_categories = $this->searcher->getCategories();

        //$search_results = Product::getProductsProperties((int)$id_lang, $search_results);

        if ($total == 0) {
            die(Tools::jsonEncode(array(
                array(
                    'type' => 'no-results-found',
                ))));
        }

        $manufacturers = array();
        $categories = array();

        $price_display = Product::getTaxCalculationMethod();
        $show_price = (bool) Configuration::get(AJS_SHOW_PRICES)
            && (!(bool) Configuration::get('PS_CATALOG_MODE') && (bool) Group::getCurrent()->show_prices);
        $small = 'small';
        $default = 'default';

        foreach ($search_results as &$product) {
            $link = $this->context->link->getProductLink(
                $product['id_product'],
                $product['prewrite'],
                $product['crewrite']
            );
            $product['link'] = $link . '?search_query=' . $query . '&fast_search=fs';

            if (isset($product['imgid']) || $product['imgid'] != null) {
                $product['img'] = $this->context->link->getImageLink(
                    $product['prewrite'],
                    $product['imgid'],
                    $small . '_' . $default
                );
            } else {
                $product['img'] = $this->no_image_path['p'];
            }

            $product['type'] = 'product';

            $feats = array();

            if (pSQL(Configuration::get(AJS_SHOW_FEATURES, 0))) {
                foreach ($product['features'] as $feature) {
                    $feats[] = $feature['name'] . ': ' . $feature['value'];
                }
            }

            $product['feats'] = implode(', ', $feats);

            if ($show_price && isset($product['show_price']) && $product['show_price']) {
                if (!$price_display) {
                    $product['price'] = Tools::displayPrice(
                        $product['price'],
                        (int) $this->context->cookie->id_currency
                    );
                } else {
                    $product['price'] = Tools::displayPrice(
                        $product['price_tax_exc'],
                        (int) $this->context->cookie->id_currency
                    );
                }
            } else {
                $product['price'] = '';
            }

            if (isset($product['mname'])) {
                $manufacturers[$product['manid']] = $product['mname'];
            }

            foreach ($sr_categories as $category) {
                $categories[$category['id_category']] = $category['name'];
            }
        }

        $search_manufacturers = array();
        foreach ($manufacturers as $manid => $mname) {
            $manu = new Manufacturer();
            $manu->id = $manid;
            $search_manufacturers[] = array('type' => 'manufacturer',
                'man_id' => $manid,
                'man_name' => $mname,
                'img' => $this->getManufacturerImage($manu),
                'link' => $this->context->link->getManufacturerLink($manu, Tools::link_rewrite($mname))
                . '?search_query=' . $real_query . '&fast_search=fs');
            //'link' => $this->context->link->getManufacturerLink($manu->id));
        }

        $search_categories = array();
        foreach ($categories as $catid => $cname) {
            $cat = new Category($catid, $id_lang);

            $search_categories[] = array('type' => 'category',
                'cat_id' => $catid,
                'cat_name' => $cname,
                'img' => $this->getCategoryImage($cat, $id_lang),
                'link' => $this->context->link->getCategoryLink($cat, $cat->link_rewrite, $id_lang)
                . '?search_query=' . $real_query . '&fast_search=fs',
            );
        }

        $search = array(
            'products' => array(),
            'manufacturers' => array(),
            'suppliers' => array(),
            'categories' => array(),
        );
        if (count($search_manufacturers) > 0) {
            $search['manufacturers'] = array_slice($search_manufacturers, 0, $this->max_items['manufacturers']);
        }

        if (count($search_categories) > 0) {
            $search['categories'] = array_slice($search_categories, 0, $this->max_items['categories']);
        }

        if (count($search_results) + count($search['manufacturers'])
             + count($search['categories']) > $this->max_items['all']) {
            $search['products'] = array_slice(
                $search_results,
                0,
                $this->max_items['all'] - count($search['manufacturers']) - count($search['categories'])
            );
        } else {
            $search['products'] = $search_results;
        }

        if (Configuration::get(AJS_MORE_RESULTS_CONFIG)) {
            $params = array('search_query' => $real_query,
                'orderby' => 'position',
                'orderway' => 'desc',
                'p' => 1,
            );

            $joli_link = new JoliLink($this->context->link);
            $action = $joli_link->getModuleLink('ambjolisearch', 'jolisearch', $params);

            $this->priorities['more-results'] = 999;
            $search['more-results'] = array(array(
                'type' => 'more-results',
                'link' => $action,
            ));
        }

        $search_results = array();
        foreach (array_keys($this->priorities) as $key) {
            $search_results = array_merge($search_results, $search[$key]);
        }

        die(Tools::jsonEncode($search_results));
    }

    public static function find(
        $id_lang,
        $expr,
        $page_number = 1,
        $limit = 10,
        $order_by = 'position',
        $order_way = 'desc',
        $ajax = false,
        $use_cookie = true,
        Context $context = null,
        $return_ids = false
    ) {
        if (!$context) {
            $context = Context::getContext();
        }

        $searcher = new AmbSearch($use_cookie, $context, Module::getInstanceByName('ambjolisearch'));
        $searcher->search($id_lang, $expr, $page_number, $limit, $order_by, $order_way);
        //Charge la liste des ids produit correspondant aux critères

        if ($return_ids) {
            return $searcher->getResultIds();
            //Récupère la liste des ids produit
        } else {
            return $searcher->getResults($ajax);
            //Effectue la recherche sur la base des ids produit trouvés par search()
        }
    }

    private function getManufacturerImage($manufacturer)
    {
        $small = 'small';
        $default = 'default';
        $uri_path = '';
        if (Tools::file_exists_cache(
            _PS_IMG_DIR_ . 'm/' . $manufacturer->id . '-' . $small . '_' . $default . '.jpg'
        )) {
            return $this->context->link->protocol_content
            . Tools::getMediaServer($uri_path) . _PS_IMG_ . 'm/'
            . $manufacturer->id . '-' . $small . '_' . $default . '.jpg';
        } else {
            return $this->no_image_path['m'];
        }
    }

    private function getCategoryImage($category, $id_lang)
    {
        $small = 'small';
        $default = 'default';
        $id_image = file_exists(_PS_CAT_IMG_DIR_ . $category->id . '.jpg') ?
        (int) $category->id : Language::getIsoById($id_lang) . '-default';
        return $this->context->link->getCatImageLink($category->link_rewrite, $id_image, $small . '_' . $default);
    }

    public function setMedia()
    {
        parent::setMedia();

        if (Configuration::get('PS_COMPARATOR_MAX_ITEM')) {
            $this->addJS(_THEME_JS_DIR_ . 'products-comparison.js');
        }
    }

    public function assignProductSort()
    {
        $order_by_values  = array(0 => 'name', 1 => 'price', 2 => 'date_add', 3 => 'date_upd', 4 => 'position', 5 => 'manufacturer_name', 6 => 'quantity', 7 => 'reference');
        $order_way_values = array(0 => 'asc', 1 => 'desc');

        $orderBy  = Tools::strtolower(Tools::getValue('orderby', null));
        $orderWay = Tools::strtolower(Tools::getValue('orderway', null));
        $orderByDefault = '';
        $orderWayDefault = 'asc';

        if ($orderBy == null) {
            $orderBy = '';
        }

        $this->context->smarty->assign(array(
            'orderby' => $orderBy,
            'orderbydefault' => $orderByDefault,
        ));
    }
}
