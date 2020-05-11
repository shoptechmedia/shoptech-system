<?php
/**
 * 2010-2019 Bl Modules.
 *
 * If you wish to customize this module for your needs,
 * please contact the authors first for more information.
 *
 * It's not allowed selling, reselling or other ways to share
 * this file or any other module files without author permission.
 *
 * @author    Bl Modules
 * @copyright 2010-2019 Bl Modules
 * @license
 */

if (!defined('_PS_VERSION_')) {
    die('Not Allowed, Xmlfeeds');
}

class Xmlfeeds extends Module
{
    const CSS_VERSION = 9;

    public $tags_info = array();
    public $_html = false;
    public $shopLang = false;
    public $checkedInput = false;
    public $_html2 = false;
    public $moduleImgPath = false;
    public $googleCategories = array();
    public $googleCategoriesMap = array();
    public $rootFile = '';

    public function __construct()
    {
        $this->name = 'xmlfeeds';
        $this->full_name = $this->name.'_pro';
        $this->tab = 'export';
        $this->author = 'Bl Modules';
        $this->version = '2.6.0';
        $this->module_key = '3aa147ba51c7d9571b1838f24cfd131a';
        $this->moduleImgPath = '../modules/'.$this->name.'/views/img/';

        parent::__construct();

        $this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('XML feeds Pro');
        $this->description = $this->l('Export data from Prestashop database to XML');
        $this->confirmUninstall = $this->l('Are you sure you want to delete the module?');
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        if (!class_exists('XmlFeedInstall', false)) {
            include_once(dirname(__FILE__).'/XmlFeedInstall.php');
        }

        $xmlFeedInstall = new XmlFeedInstall();

         if (!$xmlFeedInstall->installModuleSql()) {
             return false;
         }

        @copy('../modules/'.$this->name.'/root_file/xml_feeds.php', '../xml_feeds.php');

        return true;
    }

    public function uninstall()
    {
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_block');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_feeds');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_fields');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_feeds_cache');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_statistics');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_affiliate_price');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_g_cat');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_product_list');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_product_list_product');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_product_settings_package');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blmod_xml_product_settings');

        return parent::uninstall();
    }

    public function loadModule()
    {
        include_once(dirname(__FILE__).'/googlecategory.php');
        include_once(dirname(__FILE__).'/ProductListAdmin.php');
        include_once(dirname(__FILE__).'/ProductSettingsAdmin.php');
        include_once(dirname(__FILE__).'/ProductSettings.php');
        include_once(dirname(__FILE__).'/XmlFeedsTools.php');
        include_once(dirname(__FILE__).'/FeedType.php');

        if (!class_exists('XmlFeedInstall', false)) {
            include_once(dirname(__FILE__).'/XmlFeedInstall.php');
        }
    }

    public function catchSaveAction()
    {
        $productListAdmin = new ProductListAdmin();
        $productSettingsAdmin = new ProductSettingsAdmin();

        $addProductList = Tools::getValue('add_product_list');
        $updateProductList = Tools::getValue('update_product_list');
        $deleteProductList = Tools::getValue('delete_product_list');
        $updateProductSettings = Tools::getValue('update_product_settings');
        $deleteProductSettingsPackage = Tools::getValue('delete_product_setting_package');
        $res = false;
        $actionName = $this->l('Updated successfully');

        if (!empty($addProductList)) {
            $res = $productListAdmin->insertNewProductList();
        }

        if (!empty($updateProductList)) {
            $res = $productListAdmin->updateProductList();
        }

        if (!empty($deleteProductList)) {
            $res = $productListAdmin->deleteProductList();
            $actionName = $this->l('Deleted successfully');
        }

        if (!empty($updateProductSettings)) {
            $res = $productSettingsAdmin->save();
        }

        if (!empty($deleteProductSettingsPackage)) {
            $res = $productSettingsAdmin->deleteProductSettingsPackage();
            $actionName = $this->l('Deleted successfully');
        }

        if ($res) {
            $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />'.$actionName.'</div>';
        }
    }

    public function getContent()
    {
        $this->loadModule();

        $this->shopLang = Configuration::get('PS_LANG_DEFAULT');
        $this->_html = '<br>';
        $tab = Tools::getValue('tab');
        $full_address_no_t = $this->getShopProtocol().$_SERVER['HTTP_HOST'].__PS_BASE_URI__.Tools::substr($_SERVER['PHP_SELF'], Tools::strlen(__PS_BASE_URI__)).'?tab='.$tab.'&configure='.Tools::getValue('configure');
        $token = '&token='.Tools::getValue('token');
        $this->_html .= '<link rel="stylesheet" type="text/css" href="../modules/xmlfeeds/views/css/style_admin.css?v='.self::CSS_VERSION.'" />';
        $this->_html .= '<link rel="stylesheet" type="text/css" href="../modules/xmlfeeds/views/css/xml_feeds.css?v='.self::CSS_VERSION.'" />';
        $this->_html .= '<script type="text/javascript" src="../modules/xmlfeeds/views/js/xml_feeds.js?v='.self::CSS_VERSION.'"></script>';
        $this->_html .= '<script type="text/javascript" src="../modules/xmlfeeds/views/js/search.js?v='.self::CSS_VERSION.'"></script>';
        $this->rootFile = $this->getShopProtocol().$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/'.$this->name.'/api/xml.php';

        $duplicateId = Tools::getValue('duplicate');

        if (!empty($duplicateId)) {
            $this->duplicateFeed($duplicateId, $full_address_no_t, $token);
        }

        if (_PS_VERSION_ >= 1.6) {
            $this->_html .= '
            <style>
                .blmod_module .bootstrap input[type="checkbox"] {
                    margin-top: 2px!important;
                }
            </style>';
        }

        if (_PS_VERSION_ >= 1.5) {
            $this->_html .= '
            <style>
                .blmod_module .conf img, .blmod_module .warn img, .blmod_module .error img, .alert img{
                    display: none;
                }
                .blmod_module .warn, .blmod_module .error, .blmod_module .conf {
                    padding-left: 40px;
                    padding-right: 0px;
                }
            </style>';
        } elseif (_PS_VERSION_ < 1.5) {
            $this->_html .= '
            <style>
            .blmod_module .row{
                background: #FFF;
            }
            .module_logo{
                margin-top: 0px!important;
                margin-bottom: 15px;
            }
            .blmod_module #content{
                border: 0px!important;
            }
            .blmod_module .order_table_order{
                width: 900px!important;
            }
            .blmod_module .order_table_date{
                font-size: 11px;
            }
            .order_table_order tr:hover, .order_table_logs tr:hover{
                background-color: #d9edf7!important;
            }
            .info_block_order_status .list_checkbox{
                margin-top: 4px;
            }
            .list_name img{
                margin-right: 4px;
            }
            .icon_menu_box{
                margin-right: 15px!important;
            }
            .blmod_module .pagination{
                margin-bottom: 10px;
            }
            </style>';
        }

        if (_PS_VERSION_ < 1.6) {
            $this->_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/views/css/style_admin_ps_old.css?v='.self::CSS_VERSION.'" type="text/css" />';
            $this->_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/views/css/admin-theme.css?v='.self::CSS_VERSION.'" type="text/css" />';
        }

        $this->_html .= '
		    <div class="xml_feed_module">';

        if (_PS_VERSION_ >= '1.5' && _PS_VERSION_ < '1.6') {
            $this->_html .= '<style>
            .xml_feed_module .conf img, .xml_feed_module .warn img, .xml_feed_module .error img {
                display: none;
            }
            </style>';
        }

        $this->_html .= '
		    <div class="blmod_module">
		        <div class="module_logo">
                    <img src="'.$this->moduleImgPath.'icon.png" />
		        </div>
		        <div class="module_title">
                    <h2>'.$this->displayName.'</h2>
                    <div class="module_version">'.$this->l('Version:').' '.$this->version.'</div>
		        </div>
		        <div class="clear_block"></div>';

        $this->_html .= '<div class="bootstrap">
			<div id="content" class="bootstrap content_blmod">
							<div class="bootstrap">';

        $this->catchSaveAction();

        $this->cleanCache();

        $POST = array();
        $POST['update_feeds_s'] = Tools::getValue('update_feeds_s');
        $POST['settings_cat'] = Tools::getValue('settings_cat');
        $POST['settings_prod'] = Tools::getValue('settings_prod');
        $POST['clear_cache'] = Tools::getValue('clear_cache');
        $POST['feeds_name'] = Tools::getValue('feeds_name');
        $POST['update_ga_cat'] = Tools::getValue('update_ga_cat');
        $POST['google_cat_map'] = Tools::getValue('google_cat_map');

        $is_product_feed = Tools::getValue('is_product_feed');
        $is_category_feed = Tools::getValue('is_category_feed');

        if (!empty($POST['clear_cache'])) {
            $this->deleteCache($POST['feeds_name']);
            $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Cache cleared successfully').'</div>';
        }

        if ((!empty($POST['update_feeds_s']) || !empty($POST['settings_cat']) || !empty($POST['settings_prod'])) && !empty($POST['feeds_name'])) {
            $POST['name'] = Tools::getValue('name', $this->l('Products feed'));
            $POST['status'] = Tools::getValue('status', 0);
            $POST['use_cache'] = Tools::getValue('use_cache', 0);
            $POST['cache_time'] = Tools::getValue('cache_time', 0);
            $POST['use_password'] = Tools::getValue('use_password', 0);
            $POST['password'] = Tools::getValue('password');
            $POST['cdata_status'] = Tools::getValue('cdata_status', 0);
            $POST['html_tags_status'] = Tools::getValue('html_tags_status', 0);
            $POST['one_branch'] = Tools::getValue('one_branch', 0);
            $POST['header_information'] = Tools::getValue('header_information');
            $POST['footer_information'] = Tools::getValue('footer_information');
            $POST['extra_feed_row'] = Tools::getValue('extra_feed_row');
            $POST['only_enabled'] = Tools::getValue('only_enabled', 0);
            $POST['split_feed'] = Tools::getValue('split_feed', 0);
            $POST['split_feed_limit'] = Tools::getValue('split_feed_limit', 50);
            $POST['categories'] = Tools::getValue('categories', 0);
            $POST['use_cron'] = Tools::getValue('use_cron', 0);
            $POST['only_in_stock'] = Tools::getValue('only_in_stock', 0);
            $POST['attribute_as_product'] = Tools::getValue('attribute_as_product', 0);
            $POST['manufacturers'] = Tools::getValue('manufacturers', 0);
            $POST['suppliers'] = Tools::getValue('suppliers', 0);
            $POST['price_from'] = Tools::getValue('price_from', false);
            $POST['price_to'] = Tools::getValue('price_to', false);
            $POST['price_with_currency'] = Tools::getValue('price_with_currency', 0);
            $POST['all_images'] = Tools::getValue('all_images', 0);
            $POST['currency_id'] = Tools::getValue('currency_id', 0);
            $POST['feed_generation_time'] = Tools::getValue('feed_generation_time', 0);
            $POST['feed_generation_time_name'] = Tools::getValue('feed_generation_time_name', '');
            $POST['split_by_combination'] = Tools::getValue('split_by_combination', '');
            $POST['product_list'] = Tools::getValue('product_list', '');
            $POST['product_list_status'] = Tools::getValue('product_list_status', '');
            $POST['shipping_country'] = Tools::getValue('shipping_country', 0);
            $POST['filter_discount'] = Tools::getValue('filter_discount', 0);
            $POST['filter_category_type'] = Tools::getValue('filter_category_type', 0);
            $POST['product_settings_package_id'] = Tools::getValue('product_settings_package_id', 0);

            $POST['price_range'] = $POST['price_from'].';'.$POST['price_to'];
            $POST['price_range'] = str_replace(',', '.', $POST['price_range']);

            $cat_list = false;
            $manufacturerList = false;
            $supplierList = false;
            $productList = false;

            $POST['categoryBox'] = Tools::getValue('categoryBox');

            if (!empty($POST['categoryBox'])) {
                $cat_list = implode(',', $POST['categoryBox']);
            }

            $POST['manufacturer'] = Tools::getValue('manufacturer');

            if (!empty($POST['manufacturer'])) {
                $manufacturerList = implode(',', $POST['manufacturer']);
            }

            $POST['supplier'] = Tools::getValue('supplier');

            if (!empty($POST['supplier'])) {
                $supplierList = implode(',', $POST['supplier']);
            }

            if (!empty($POST['product_list'])) {
                $productList = implode(',', $POST['product_list']);
            }

            $this->updateFeedsS(
                $POST['name'],
                $POST['status'],
                $POST['use_cache'],
                $POST['cache_time'],
                $POST['use_password'],
                $POST['password'],
                $POST['feeds_name'],
                $POST['cdata_status'],
                $POST['html_tags_status'],
                $POST['one_branch'],
                $POST['header_information'],
                $POST['footer_information'],
                $POST['extra_feed_row'],
                $POST['only_enabled'],
                $POST['split_feed'],
                $POST['split_feed_limit'],
                $cat_list,
                $POST['categories'],
                $POST['use_cron'],
                $POST['only_in_stock'],
                $POST['attribute_as_product'],
                $POST['manufacturers'],
                $manufacturerList,
                $POST['suppliers'],
                $supplierList,
                $POST['price_range'],
                $POST['price_with_currency'],
                $POST['all_images'],
                $POST['currency_id'],
                $POST['feed_generation_time'],
                $POST['feed_generation_time_name'],
                $POST['split_by_combination'],
                $productList,
                $POST['product_list_status'],
                $POST['shipping_country'],
                $POST['filter_discount'],
                $POST['filter_category_type'],
                $POST['product_settings_package_id']
            );
        }

        $delete_feed = Tools::getValue('delete_feed');

        if (!empty($delete_feed)) {
            $this->deleteFeed($delete_feed);
        }

        if ((!empty($POST['update_feeds_s']) || !empty($POST['settings_cat'])) && $is_category_feed) {
            $this->updateFields(2);
        }

        if ((!empty($POST['update_feeds_s']) || !empty($POST['settings_prod'])) && $is_product_feed) {
            $this->updateFields(1);
        }

        if (!empty($POST['update_ga_cat'])) {
            $this->updateGoogleCat($POST['google_cat_map']);
        }

        //page
        $this->pageStructure($full_address_no_t, $token);

        return $this->_html.'</div></div></div></div>';
    }

    public function installDefaultProductsValues($feedId = false, $feedMode = 'c')
    {
        $xmlFeedInstall = new XmlFeedInstall();

        if (empty($feedId)) {
            return false;
        }

        return $xmlFeedInstall->installDefaultFeedProductSettings($feedId, $feedMode);

    }

    public function installDefaultCategoriesValues($feedId = false)
    {
        $xmlFeedInstall = new XmlFeedInstall();

        if (empty($feedId)) {
            return false;
        }

        return $xmlFeedInstall->installDefaultFeedCategorySettings($feedId);
    }

    public function duplicateFeed($feedId = 0, $full_address_no_t = '', $token = '')
    {
        $feedId = (int)$feedId;

        if (empty($feedId)) {
            return false;
        }

        $xmlFeed = Db::getInstance()->getRow('
			SELECT f.*
			FROM '._DB_PREFIX_.'blmod_xml_feeds f
			WHERE f.id = "'.$feedId.'"
		');

        if (empty($xmlFeed)) {
            return false;
        }

        unset($xmlFeed['id']);
        $xmlFeed['name'] = $xmlFeed['name'].' duplicate';

        $result = Db::getInstance()->insert('blmod_xml_feeds', $xmlFeed);

        $newFeedId = Db::getInstance()->Insert_ID();

        if (empty($result) || empty($newFeedId)) {
            return false;
        }

        $xmlBlocks = Db::getInstance()->ExecuteS('
			SELECT b.*
			FROM '._DB_PREFIX_.'blmod_xml_block b
			WHERE b.category = "'.$feedId.'"
		');

        foreach ($xmlBlocks as $b) {
            $result = Db::getInstance()->insert(
                'blmod_xml_block',
                array(
                    'name' => $b['name'],
                    'value' => $b['value'],
                    'category' => $newFeedId,
                )
            );
        }

        $xmlFields = Db::getInstance()->ExecuteS('
			SELECT f.*
			FROM '._DB_PREFIX_.'blmod_xml_fields f
			WHERE f.category = "'.$feedId.'"
		');

        foreach ($xmlFields as $f) {
            $result = Db::getInstance()->insert(
                'blmod_xml_fields',
                array(
                    'name' => $f['name'],
                    'status' => $f['status'],
                    'title_xml' => $f['title_xml'],
                    'table' => $f['table'],
                    'category' => $newFeedId,
                )
            );
        }

        Tools::redirectAdmin($full_address_no_t.'&page='.$newFeedId.$token);
        die;
    }

    public function getBiggestImage()
    {
        $images = Db::getInstance()->getRow('
			SELECT `name`
			FROM '._DB_PREFIX_.'image_type
			WHERE `products` = "1"
			ORDER BY `width` DESC, `height` DESC
		');

        if (empty($images['name'])) {
            return false;
        }

        return $images['name'];
    }

    public function cleanCache()
    {
        $cache = Db::getInstance()->ExecuteS('
			SELECT f.cache_time, c.feed_id, c.feed_part, c.file_name, c.last_cache_time
			FROM '._DB_PREFIX_.'blmod_xml_feeds f
			LEFT JOIN '._DB_PREFIX_.'blmod_xml_feeds_cache c ON
			f.id = c.feed_id
			WHERE c.feed_id > 0
		');

        if (empty($cache)) {
            return true;
        }

        $now = date('Y-m-d h:i:s');

        foreach ($cache as $c) {
            $cache_period = date('Y-m-d h:i:s', strtotime($c['last_cache_time'].'+'.$c['cache_time'].' minutes'));

            if ($now > $cache_period && !empty($c['file_name'])) {
                $file_url = 'xml_files/'.$c['file_name'].'.xml';

                @unlink('../modules/xmlfeeds/xml_files/'.$c['file_name'].'.xml');

                if (!file_exists($file_url)) {
                    Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_feeds_cache WHERE feed_id = "'.$c['feed_id'].'" AND feed_part = "'.$c['feed_part'].'"');
                }
            }
        }
    }

    public function status($status = false, $disabled = false)
    {
        if ($disabled) {
            $disabled = 'disabled';
        } else {
            $disabled = '';
        }

        if (isset($status) && $status == 1) {
            $status_text = ' value = "1" checked '.$disabled.' /> <img src="'.$this->moduleImgPath.'enabled.gif" alt = "'.$this->l('Enabled').'" />'.$this->l('Enabled');
        } else {
            $status_text = ' value = "1" '.$disabled.'/> <img src="'.$this->moduleImgPath.'disabled.gif" alt = "'.$this->l('Disabled').'" />'.$this->l('Disabled');
        }

        return $status_text;
    }

    public function pageStructure($full_address_no_t = false, $token = false)
    {
        $page = Tools::getValue('page');
        $add_feed = Tools::getValue('add_feed');
        $statistics = Tools::getValue('statistics');
        $add_affiliate_price = Tools::getValue('add_affiliate_price');
        $googleCatAssign = Tools::getValue('google_cat_assign');
        $productListPage = Tools::getValue('product_list_page');
        $productSettingsPage = Tools::getValue('product_settings_page');
        $about_page = Tools::getValue('about_page');
        $width = '';

        if (empty($page) && empty($statistics) && empty($add_affiliate_price) && empty($add_feed)) {
            $page = $this->checkGetDefaultFeed();
        }

        if (_PS_VERSION_ < 1.5) {
            $width = ' style="width: 667px;"';
        }

        $this->_html .= '<div style="float: left; width: 260px; margin-right: 20px;">';
        $this->categories($full_address_no_t, $token, $page, $statistics, $add_affiliate_price, $add_feed, $about_page, $googleCatAssign, $productListPage, $productSettingsPage);
        $this->_html .= '</div>
			<div class="feed_settings_box"'.$width.'>';

        if (!empty($add_feed)) {
            $this->addNewFeed($add_feed, $full_address_no_t, $token);
        } elseif (!empty($statistics)) {
            $this->statisticsOne($statistics, $full_address_no_t, $token);
        } elseif (!empty($add_affiliate_price)) {
            $this->addAffiliatePrice($full_address_no_t, $token);
        } elseif (!empty($googleCatAssign)) {
            $this->assignGoogleCategoriesPage();
        } elseif (!empty($productListPage)) {
            $productList = new ProductListAdmin();
            $this->_html .= $productList->getContent($full_address_no_t, $token);
        }
        elseif (!empty($productSettingsPage)) {
            $productSettingsAdmin = new ProductSettingsAdmin();
            $this->_html .= $productSettingsAdmin->getContent($full_address_no_t, $token);
        }elseif (!empty($about_page)) {
            $this->aboutPage();
        } else {
            $this->feedsSettings($page);
        }

        $this->_html .= '</div>
			<div class="cb"></div>
		';
    }

    public function aboutPage()
    {
        $this->_html .= '<style type="text/css">
			.blmod_about a{
				color: #268CCD;
			}
			.blmod_about{
				line-height: 25px;
			}
			</style>
			<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-question-circle"></i> '.$this->l('About').'
                        </div>
                        <div class="row">
				<div class="blmod_about">
					<div style="float: right;">
						<a href="http://addons.prestashop.com/en/migration-tools/5732-XML-Feeds-Pro.html" target="_blank">
							<img style="border: 1px solid #CCCED7; padding: 0px;" alt="Bl Modules" title="Bl Modules home page" src="../modules/'.$this->name.'/views/img/blmod_logo.png" />
						</a>
					</div>
					<div style="float: left; width: 350px;">
						'.$this->l('Find more information at').'  <a href="http://addons.prestashop.com/en/5732-xml-feeds-pro.html" target="_blank">addons.prestashop.com</a><br/>
						'.$this->l('Module version:').' '.$this->version.'<br/>
					</div>
					<div class="cb"></div>
				</div>
			</div></div>';
    }

    public function checkGetDefaultFeed()
    {
        $feed = Db::getInstance()->getRow('
			SELECT `id`
			FROM '._DB_PREFIX_.'blmod_xml_feeds
			ORDER BY `id` DESC
		');

        if (!empty($feed['id'])) {
            return $feed['id'];
        }

        return false;
    }

    public function categories(
        $full_address_no_t,
       $token,
       $page = false,
       $statistics = false,
       $add_affiliate_price = false,
       $add_feed = false,
       $about_page = false,
       $isAssignCatPage = false,
       $product_list_page = false,
       $product_settings_page = false
    )
    {
        if (empty($page)) {
            $page = $statistics;
        }

        $style = 'color: #2EACCE;';

        $feeds = Db::getInstance()->ExecuteS('
			SELECT `id`, `name`, `feed_type`
			FROM '._DB_PREFIX_.'blmod_xml_feeds
			ORDER BY `id` ASC
		');

        $products = array();
        $categories = array();
        $add_affiliate = false;
        $add_feed_style1 = false;
        $add_feed_style2 = false;
        $assign_google_cat = false;
        $product_list = false;
        $product_settings = false;
        $style_about = false;

        if (!empty($product_settings_page)) {
            $product_settings = $style;
            $page = false;
        }

        if (!empty($product_list_page)) {
            $product_list = $style;
            $page = false;
        }

        if (!empty($add_affiliate_price)) {
            $add_affiliate = $style;
        }

        if (!empty($about_page)) {
            $style_about = $style;
            $page = false;
        }

        if (!empty($isAssignCatPage)) {
            $assign_google_cat = $style;
            $page = false;
        }

        if (!empty($feeds)) {
            foreach ($feeds as $f) {
                if ($f['feed_type'] == 1) {
                    $products[] = $f;
                } elseif ($f['feed_type'] == 2) {
                    $categories[] = $f;
                }
            }
        }

        if ($add_feed == 1) {
            $add_feed_style1 = $style;
        } elseif ($add_feed == 2) {
            $add_feed_style2 = $style;
        }

        $this->_html .= '<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-list-alt"></i> '.$this->l('XML Feeds').'
                        </div>
                        <div class="row">
								<i class="icon-cart-arrow-down menu-top-main-icon menu-top-item-icon"></i><span class="menu-top">'.$this->l('Product feeds').'</span><br/>';

        $this->_html .= '<div class="menu-top-feeds">';

        if (!empty($products)) {
            foreach ($products as $p) {
                $style_s = false;

                if ($page == $p['id']) {
                    $style_s = $style;
                }

                $this->_html .= '<div class="menu-top-item">
                    <a class="menu-top-item-title" style="'.$style_s.'" href="'.$full_address_no_t.'&page='.$p['id'].$token.'">'.$p['name'].'</a>
                    <a title="Statistics" class="menu-top-statistics" style="margin-left: 5px;" href="'.$full_address_no_t.'&statistics='.$p['id'].$token.'"><i class="icon-bar-chart"></i></a>
                    <a title="Duplicate feed" class="menu-top-duplicate" style="margin-left: 1px;" href="'.$full_address_no_t.'&duplicate='.$p['id'].$token.'"><i class="icon-copy"></i></a>
                    <a title="Delete feed" class="menu-top-delete" href="'.$full_address_no_t.'&delete_feed='.$p['id'].$token.'" onclick="return confirm(\''.$this->l('Are you sure you want to delete?').'\')"><i class="icon-trash"></i></a>
                </div>';
            }
        }

        $this->_html .= '</div>';

        $this->_html .= '<a class="menu-top-item mb15" style="'.$add_feed_style1.'" href="'.$full_address_no_t.'&add_feed=1'.$token.'"><i class="icon-plus-circle menu-top-item-icon"></i>'.$this->l('Add new feed').'</a><br>
								<a class="menu-top-item" style="'.$add_affiliate.'" href="'.$full_address_no_t.'&add_affiliate_price=1'.$token.'"><i class="icon-calculator menu-top-item-icon"></i>'.$this->l('Affiliate price').'</a><br>
								<a class="menu-top-item" style="display: inline-block; '.$assign_google_cat.'" href="'.$full_address_no_t.'&google_cat_assign=1'.$token.'"><i class="icon-plug menu-top-item-icon"></i>'.$this->l('Mapping category').'</a><br>
								<a class="menu-top-item" style="display: inline-block; '.$product_list.'" href="'.$full_address_no_t.'&product_list_page=1'.$token.'"><i class="icon-list menu-top-item-icon"></i>'.$this->l('Product list').'</a><br>
								<a class="menu-top-item" style="display: inline-block; '.$product_settings.'" href="'.$full_address_no_t.'&product_settings_page=1'.$token.'"><i class="icon-cogs menu-top-item-icon"></i>'.$this->l('Product settings').'</a>
							</div>
							<div>
								<hr/>
								<i class="icon-folder-open menu-top-main-icon menu-top-item-icon"></i><span class="menu-top">'.$this->l('Category feeds').'</span><br/>';

        $this->_html .= '<div class="menu-top-feeds">';

        if (!empty($categories)) {
            foreach ($categories as $c) {
                $style_s = false;

                if ($page == $c['id']) {
                    $style_s = $style;
                }

                $this->_html .= '<div class="menu-top-item">
                    <a title="Statistics" class="menu-top-item-title" style="'.$style_s.'" href="'.$full_address_no_t.'&page='.$c['id'].$token.'">'.$c['name'].'</a>
                    <a class="menu-top-statistics" style="margin-left: 5px;" href="'.$full_address_no_t.'&statistics='.$c['id'].$token.'"><i class="icon-bar-chart"></i></a>
                    <a title="Duplicate feed" class="menu-top-duplicate" style="margin-left: 1px;" href="'.$full_address_no_t.'&duplicate='.$c['id'].$token.'"><i class="icon-copy"></i></a>
                    <a title="Delete feed" class="menu-top-delete" href="'.$full_address_no_t.'&delete_feed='.$c['id'].$token.'" onclick="return confirm(\''.$this->l('Are you sure you want to delete?').'\')"><i class="icon-trash"></i></a>
                </div>';
            }
        }

        $this->_html .= '</div>';

        $this->_html .= '<a class="menu-top-item" style="'.$add_feed_style2.'" href="'.$full_address_no_t.'&add_feed=2'.$token.'"><i class="icon-plus-circle menu-top-item-icon"></i>'.$this->l('Add new feed').'</a>
								<hr/>
								<div class="menu-top-item">
								    <a style="'.$style_about.'" href = "'.$full_address_no_t.'&about_page=1'.$token.'"><i class="icon-info-circle menu-top-item-icon"></i>'.$this->l('About').'</a>
								</div>
							</div>
						</div><br/><br/>';
    }

    public function addAffiliatePrice($full_address_no_t, $token)
    {
        $POST = array();
        $post_url = $_SERVER['REQUEST_URI'];

        $delete_affiliate_price = Tools::getValue('delete_affiliate_price');

        if (!empty($delete_affiliate_price)) {
            $get_affiliate_name = Db::getInstance()->getRow('SELECT `affiliate_name` FROM '._DB_PREFIX_.'blmod_xml_affiliate_price WHERE affiliate_id = "'.htmlspecialchars($delete_affiliate_price, ENT_QUOTES).'"');

            if (!empty($get_affiliate_name['affiliate_name'])) {
                $get_affiliate_info = Db::getInstance()->ExecuteS('SELECT `file_name` FROM '._DB_PREFIX_.'blmod_xml_feeds_cache WHERE affiliate_name = "'.$get_affiliate_name['affiliate_name'].'"');
            }

            if (Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_affiliate_price WHERE affiliate_id = "'.htmlspecialchars($delete_affiliate_price, ENT_QUOTES).'"')) {
                //Delete feeds cache
                if (!empty($get_affiliate_info)) {
                    Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_feeds_cache WHERE affiliate_name = "'.$get_affiliate_name['affiliate_name'].'"');

                    foreach ($get_affiliate_info as $c) {
                        @unlink('../modules/xmlfeeds/xml_files/'.$c['file_name'].'.xml');
                    }
                }
            }

            $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Deleted successfully').'</div>';
        }

        $POST['add_affiliate_price'] = Tools::getValue('add_affiliate_price');

        if (!empty($POST['add_affiliate_price'])) {
            $POST['name'] = Tools::getValue('name');
            $POST['price'] = Tools::getValue('price');
            $POST['xml_name'] = Tools::getValue('xml_name');

            if (empty($POST['name']) || empty($POST['price']) || empty($POST['xml_name'])) {
                $this->_html .= '<div class="'.$this->setMessageStyle('warning').'"><img src="'.$this->moduleImgPath.'warning.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Please fill in all fields').'</div>';
            } else {
                $find_price = strpos(' '.$POST['price'], 'price');

                if (empty($find_price)) {
                    $this->_html .= '<div class="'.$this->setMessageStyle('warning').'"><img src="'.$this->moduleImgPath.'warning.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Please insert the prices constant, the word "price". I will replace it in the product price.').'</div>';
                } else {
                    Db::getInstance()->Execute('
						INSERT INTO '._DB_PREFIX_.'blmod_xml_affiliate_price
						(`affiliate_name`, `affiliate_formula`, `xml_name`)
						VALUE
						("'.htmlspecialchars($this->onSpecial($POST['name']), ENT_QUOTES).'", "'.htmlspecialchars($POST['price'], ENT_QUOTES).'", "'.htmlspecialchars($this->onSpecial($POST['xml_name']), ENT_QUOTES).'")
					');

                    $this->deleteCache(false, true);

                    $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Inserted successfully').'</div>';
                }
            }
        }

        $post_url = str_replace('delete_affiliate_price', 'delete_affiliate_price_done', $post_url);

        $this->_html .= '<form action="'.$post_url.'" method="post">
			<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-cog"></i> '.$this->l('Add new affiliate price').'
                        </div>
                        <div class="row">
					<table border="0" width="100%" cellpadding="3" cellspacing="0">
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'translation.gif" /></td>
							<td width="140"><b>'.$this->l('Affiliate name:').'</b></td>
							<td>
								<input style="max-width: 462px;" type="text" name="name" value="">
							</td>
						</tr>					
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'prefs.gif" /></td>
							<td width="140"><b>'.$this->l('Field name in xml:').'</b></td>
							<td>
								<input style="max-width: 462px;" type="text" name="xml_name" value="">
							</td>
						</tr>						
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'invoice.gif" /></td>
							<td width="140"><b>'.$this->l('Price formula:').'</b></td>
							<td>
								<input style="max-width: 462px;" type="text" name="price" value="">
								<div class="bl_comments price-formula-text">'.$this->l('[Words').' "<span>base_price</span>", "<span>sale_price</span>", "<span>tax_price</span>", "<span>shipping_price</span>", "<span>price_without_discount</span>" '.$this->l('will be replaced by appropriate product value. Example of a formula: sale_price - 15]').'</div>
							</td>
						</tr>
						</table>
						<center><input type="submit" name="add_affiliate_price" value="'.$this->l('Insert').'" class="button" /></center>';

        $prices = Db::getInstance()->ExecuteS('
			SELECT `affiliate_id`, `affiliate_name`, `affiliate_formula`, `xml_name`
			FROM '._DB_PREFIX_.'blmod_xml_affiliate_price
			ORDER BY affiliate_name ASC
		');

        if (!empty($prices)) {
            $this->_html .= '<br/><hr/><br/><ul class="bl_affiliate_prices_list">';

            foreach ($prices as $p) {
                $this->_html .= '<li>
					'.htmlspecialchars_decode($p['affiliate_name'], ENT_QUOTES).': <span style="color: #268CCD">'.htmlspecialchars_decode($p['affiliate_formula'], ENT_QUOTES).'</span>
					<a href="'.$full_address_no_t.'&add_affiliate_price=1&delete_affiliate_price='.$p['affiliate_id'].$token.'" onclick="return confirm(\''.$this->l('Are you sure you want to delete?').'\')">
						<img style="margin-bottom:2px;" alt="'.$this->l('Delete affiliate price').'" title="'.$this->l('Delete affiliate price').'" src="'.$this->moduleImgPath.'delete.gif"></a><br/>
					<div style="margin-bottom: 3px; margin-top: 3px;" class="bl_comments">&#60;'.$p['xml_name'].'&#62;...&#60;/'.$p['xml_name'].'&#62;</div>
					<div class="bl_comments">URL: '.$this->rootFile.'?id=<b>FEED_ID</b>&affiliate='.htmlspecialchars_decode($p['affiliate_name'], ENT_QUOTES).'</div>
				</li>';
            }

            $this->_html .= '</ul>';
        }

        $this->_html .= '
					</div>
					</div>
			</form>
		<br/>';
    }

    public function assignGoogleCategoriesPage()
    {
        $type = Tools::getValue('category_type');
        $list = array();
        $types = array(
            'google' => 'Google/Facebook',
            'fruugo' => 'Fruugo',
            'marktplaats' => 'Marktplaats',
        );
        $type = !empty($types[$type]) ? $type : 'google';

        $googleCategory = new GoogleCategoryBlMod($type);
        $this->googleCategories = $googleCategory->getList();
        $this->setGoogleCatMap($type);

        foreach ($this->googleCategories as $c) {
            $list[] = '"'.$c.'"';
        }

        $this->_html .= '
        <link rel="stylesheet" href="../modules/xmlfeeds/views/css/jquery-ui.css">
        <script src="../modules/xmlfeeds/views/js/jquery-ui.js"></script>
        <script type="text/javascript">
            var ga_cat_blmod = ['.implode(', ', $list).'];
         </script>';

        $this->_html .= '<div class="panel">
            <div class="panel-heading">
                <i class="icon-cog"></i> '.$this->l('Mapping category').'
            </div>
            <div class="row">
            <form style="border-bottom: solid 1px #EAEDEF; margin-bottom: 10px;" action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <input style="float: right;" class="button" type="submit" name="select_category_type" value="'.$this->l('Select').'">    
            <select style="float: left; width: 517px; margin-bottom: 15px; " name="category_type">';

            foreach ($types as $k => $t) {
                $this->_html .= '<option value="'.$k.'"'.($type == $k ? ' selected' : '').'>'.$t.'</option>';
            }

            $this->_html .= '</select>

            <div class="cb"><br></div>            
            </form>
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <input style="float: right;" type="submit" name="update_ga_cat" value="Update" class="button">            
            <div class="cb"><br></div>
            <div class="bl_comments">'.$this->l('[Please select category from suggestion list, enter at least 3 characters]').'</div>';

        $this->_html .= $this->categoriesTree(false, true);

        $this->_html .= '
            <input style="float: right;" type="submit" name="update_ga_cat" value="Update" class="button">
            <input type="hidden" name="category_type" value="'.$type.'"/>
            <div class="cb"><br></div>
            </form>
            </div></div>';
    }

    private function setGoogleCatMap($type)
    {
        $categoriesMap = Db::getInstance()->ExecuteS('
			SELECT `category_id`, `g_category_id`
			FROM '._DB_PREFIX_.'blmod_xml_g_cat
			WHERE `type` = "'.$type.'"
		');

        if (!empty($categoriesMap)) {
            foreach ($categoriesMap as $m) {
                $this->googleCategoriesMap[$m['category_id']] = array(
                    'id' => $m['g_category_id'],
                    'name' => isset($this->googleCategories[$m['g_category_id']]) ? $this->googleCategories[$m['g_category_id']] : '',
                );
            }
        }
    }

    public function updateGoogleCat($categories = array())
    {
        $type = htmlspecialchars(Tools::getValue('category_type'), ENT_QUOTES);

        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_g_cat WHERE type = "'.$type.'"');

        if (empty($categories)) {
            $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Google categories successfully removed').'</div>';
            return false;
        }

        $googleCategory = new GoogleCategoryBlMod($type);
        $googleCategories = $googleCategory->getList();

        foreach ($categories as $id => $n) {
            $gId = array_search($n, $googleCategories);

            if (empty($gId)) {
                continue;
            }

            Db::getInstance()->Execute('
                INSERT INTO '._DB_PREFIX_.'blmod_xml_g_cat
                (`category_id`, `g_category_id`, `type`)
                VALUE
                ("'.htmlspecialchars($id, ENT_QUOTES).'", "'.htmlspecialchars($gId, ENT_QUOTES).'", "'.$type.'")
            ');
        }

        $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Category map successfully updated').'</div>';

        return true;
    }

    public function addNewFeed($feed_type = 1, $full_address_no_t = '', $token = 0)
    {
        $feedTypeClass = new FeedType();
        $feedTypeList = $feedTypeClass->getAllTypes();
        $feed_type = (int)$feed_type;

        $POST = array();
        $POST['add_new_feed_insert'] = Tools::getValue('add_new_feed_insert');

        if (!empty($POST['add_new_feed_insert'])) {
            $POST['name'] = Tools::getValue('name');
            $POST['feed_type'] = Tools::getValue('feed_type');
            $POST['feed_mode'] = Tools::getValue('feed_mode');

            if (!empty($POST['name'])) {
                Db::getInstance()->Execute('
					INSERT INTO '._DB_PREFIX_.'blmod_xml_feeds
					(`name`, `status`, `feed_type`, `cache_time`, `cdata_status`, `html_tags_status`, `split_feed_limit`, `only_enabled`, `feed_generation_time_name`)
					VALUE
					("'.htmlspecialchars($POST['name'], ENT_QUOTES).'", "1", "'.htmlspecialchars($POST['feed_type'], ENT_QUOTES).'", "800", "1", "1", "500", "1", "created_at")
				');

                $new_id = Db::getInstance()->Insert_ID();

                if ($POST['feed_type'] == 1) {
                    $this->installDefaultProductsValues($new_id, $POST['feed_mode']);
                } else {
                    $this->installDefaultCategoriesValues($new_id);
                }

                Tools::redirectAdmin($full_address_no_t.'&page='.$new_id.$token);
            } else {
                $this->_html .= '<div class="'.$this->setMessageStyle('warning').'"><img src="'.$this->moduleImgPath.'warning.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Error, empty feed name').'</div>';
            }
        }

        $this->_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-cog"></i> '.$this->l('New XML feed').'
                        </div>
                        <div class="row">
					<table border="0" width="100%" cellpadding="3" cellspacing="0">
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'translation.gif" /></td>
							<td width="140"><b>'.$this->l('Feed name:').'</b></td>
							<td>
								<input style="max-width: 462px;" type="text" name="name" value="" autocomplete="off">
							</td>
						</tr>';

        if ($feed_type == 1) {
            $this->_html .= '<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'tab-tools.gif" /></td>
							<td width="140"><b>'.$this->l('Type:').'</b></td>
							<td>';

                            foreach ($feedTypeList as $feedId => $f) {
                                $this->_html .= '<label class="feed_type_icon">
									<img alt="'.$f['name'].' xml feed" title="'.$f['name'].' xml feed" src="../modules/'.$this->name.'/views/img/type_'.$feedId.'.png" />
									<input type="radio" name="feed_mode" value="'.$feedId.'"'.($feedId == 'c' ? ' checked="checked"' : '').'>'.$f['name'].'
								</label>';
                            }

                            $this->_html .= '<div class="cb"></div>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>';
        }

        $this->_html .= '</table>
						<input type="hidden" name="feed_type" value="'.$feed_type.'">
						<center><input style="text-align: center" type="submit" name="add_new_feed_insert" value="'.$this->l('Insert').'" class="button" /></center>
				</div></div>
			</form>
		<br/>';
    }

    public function statisticsOne($statistics, $full_address_no_t, $token)
    {
        $statistics = (int) $statistics;

        $order = Tools::getValue('order');
        $order_name = Tools::getValue('order_name');
        $page = Tools::getValue('page_no');

        $feed = Db::getInstance()->getRow('SELECT name, total_views FROM '._DB_PREFIX_.'blmod_xml_feeds WHERE id = "'.$statistics.'"');

        if ($order != 'asc') {
            $order = 'desc';
        }

        if (empty($order_name) || $order_name != 'affiliate_name' || $order_name != 'date' || $order_name != 'ip_address') {
            $order_name = 'id';
        }

        $pag = XmlFeedsTools::pagination($page, XmlFeedsTools::ITEM_IN_PAGE, $feed['total_views'], $full_address_no_t.'&statistics='.$statistics.'&order_name='.$order_name.'&order='.$order.$token.'&', 'page_no');

        $stat = Db::getInstance()->ExecuteS('
			SELECT `affiliate_name`, `date`, `ip_address`
			FROM '._DB_PREFIX_.'blmod_xml_statistics
			WHERE feed_id = "'.$statistics.'"
			ORDER BY '.$order_name.' '.$order.'
			LIMIT '.$pag[0].', '.$pag[1].'
		');

        if ($order == 'desc') {
            $order = 'asc';
        } else {
            $order = 'desc';
        }

        $order = '&order='.$order;

        $this->_html .= '<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-bar-chart"></i> '.$this->l('Statistics').'
                        </div>
                        <div class="row">
					<div>
						<table border="0" width="100%" cellpadding="3" cellspacing="0">
							<tr>
								<td width="20"><img src="'.$this->moduleImgPath.'translation.gif" /></td>
								<td width="100"><b>'.$this->l('Feed name:').'</b></td>
								<td>
									'.$feed['name'].'
								</td>
							</tr>							
							<tr>
								<td width="20"><img src="'.$this->moduleImgPath.'statsettings.gif" /></td>
								<td width="80"><b>'.$this->l('Total views:').'</b></td>
								<td>
									'.$feed['total_views'].'
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
						</table>
					</div>';

        if (!empty($stat)) {
            $this->_html .= '<div class="blmod_clicks_list">
							<div id="blmod_clicks_title" class="blmod_clicks_row blmod_clicks_title">
								<div class="blmod_clicks_ip"><a href="'.$full_address_no_t.'&statistics='.$statistics.'&order_name=ip_address'.$order.$token.'">'.$this->l('User IP').'</a></div>
								<div class="blmod_clicks_date"><a href="'.$full_address_no_t.'&statistics='.$statistics.'&order_name=date'.$order.$token.'">'.$this->l('Date').'</a></div>
								<div class="blmod_clicks_url"><a href="'.$full_address_no_t.'&statistics='.$statistics.'&order_name=affiliate_name'.$order.$token.'">'.$this->l('Affiliate').'</a></div>
								<div class="cb"></div>
							</div>';

            $nr = 0;
            $day_before = false;

            foreach ($stat as $s) {
                $next_day = false;
                $date_only = date('Y-m-d', strtotime($s['date']));

                $bg = $nr % 2;

                if ($bg == 0) {
                    $bg_table = 'blmod_click_bg_dark';
                } else {
                    $bg_table = '';
                }

                if ($date_only != $day_before && !empty($day_before)) {
                    $next_day = 'style="border-top: 1px solid #e6d2bd;"';
                }

                $s['affiliate_name'] = isset($s['affiliate_name']) ? $s['affiliate_name'] : '&nbsp;';
                $s['ip_address'] = isset($s['ip_address']) ? $s['ip_address'] : '&nbsp;';

                $this->_html .= '<div class="blmod_clicks_row '.$bg_table.'" '.$next_day.'>
									<div class="blmod_clicks_ip">'.$s['ip_address'].'</div>
									<div class="blmod_clicks_date">'.$s['date'].'</div>
									<div class="blmod_clicks_url">'.$s['affiliate_name'].'</div>
									<div class="cb"></div>
								</div>
								';
            }

            $this->_html .= '</div>';

            $this->_html .= '<div class="cb"></div><br/><div class="blmod_pagination">'.$pag[2].'</div>';
        }

        $this->_html .= '</div></div>';
    }

    public function feedsSettings($page)
    {
        $productListFeed = new ProductListAdmin();
        $productSettingsAdmin = new ProductSettingsAdmin();

        $s = Db::getInstance()->getRow('
			SELECT *
			FROM '._DB_PREFIX_.'blmod_xml_feeds
			WHERE id = "'.$page.'"
		');

        $s['name'] = isset($s['name']) ? $s['name'] : false;
        $s['status'] = isset($s['status']) ? $s['status'] : false;
        $s['use_cache'] = isset($s['use_cache']) ? $s['use_cache'] : false;
        $s['cache_time'] = !empty($s['cache_time']) ? $s['cache_time'] : 0;
        $s['use_password'] = isset($s['use_password']) ? $s['use_password'] : false;
        $s['password'] = !empty($s['password']) ? $s['password'] : false;
        $s['cdata_status'] = isset($s['cdata_status']) ? $s['cdata_status'] : false;
        $s['html_tags_status'] = isset($s['html_tags_status']) ? $s['html_tags_status'] : false;
        $s['one_branch'] = isset($s['one_branch']) ? $s['one_branch'] : false;
        $s['header_information'] = isset($s['header_information']) ? htmlspecialchars_decode($s['header_information'], ENT_QUOTES) : false;
        $s['footer_information'] = isset($s['footer_information']) ? htmlspecialchars_decode($s['footer_information'], ENT_QUOTES) : false;
        $s['extra_feed_row'] = isset($s['extra_feed_row']) ? htmlspecialchars_decode($s['extra_feed_row'], ENT_QUOTES) : false;
        $s['feed_type'] = isset($s['feed_type']) ? $s['feed_type'] : false;
        $s['only_enabled'] = isset($s['only_enabled']) ? $s['only_enabled'] : false;
        $s['split_feed'] = isset($s['split_feed']) ? $s['split_feed'] : false;
        $s['split_feed_limit'] = isset($s['split_feed_limit']) ? $s['split_feed_limit'] : false;
        $s['categories'] = isset($s['categories']) ? $s['categories'] : false;
        $s['cat_list'] = isset($s['cat_list']) ? $s['cat_list'] : false;
        $s['use_cron'] = isset($s['use_cron']) ? $s['use_cron'] : false;
        $s['last_cron_date'] = isset($s['last_cron_date']) ? $s['last_cron_date'] : '-';
        $s['only_in_stock'] = isset($s['only_in_stock']) ? $s['only_in_stock'] : false;
        $s['attribute_as_product'] = isset($s['attribute_as_product']) ? $s['attribute_as_product'] : false;
        $s['manufacturer'] = isset($s['manufacturer']) ? $s['manufacturer'] : false;
        $s['manufacturer_list'] = isset($s['manufacturer_list']) ? $s['manufacturer_list'] : false;
        $s['supplier'] = isset($s['supplier']) ? $s['supplier'] : false;
        $s['supplier_list'] = isset($s['supplier_list']) ? $s['supplier_list'] : false;
        $s['price_with_currency'] = isset($s['price_with_currency']) ? $s['price_with_currency'] : false;
        $s['feed_mode'] = isset($s['feed_mode']) ? $s['feed_mode'] : false;
        $s['all_images'] = isset($s['all_images']) ? $s['all_images'] : false;
        $s['currency_id'] = isset($s['currency_id']) ? $s['currency_id'] : false;
        $s['feed_generation_time'] = isset($s['feed_generation_time']) ? $s['feed_generation_time'] : false;
        $s['feed_generation_time_time'] = isset($s['feed_generation_time_time']) ? $s['feed_generation_time_time'] : '';
        $s['split_by_combination'] = isset($s['split_by_combination']) ? $s['split_by_combination'] : '';
        $s['product_list_status'] = isset($s['product_list_status']) ? $s['product_list_status'] : '';
        $s['product_list'] = isset($s['product_list']) ? explode(',', $s['product_list']) : '';
        $s['shipping_country'] = isset($s['shipping_country']) ? $s['shipping_country'] : '';
        $s['filter_discount'] = isset($s['filter_discount']) ? $s['filter_discount'] : 0;
        $s['filter_category_type'] = isset($s['filter_category_type']) ? $s['filter_category_type'] : 0;
        $s['product_settings_package_id'] = isset($s['product_settings_package_id']) ? $s['product_settings_package_id'] : 0;

        $priceFrom = false;
        $priceTo = false;

        if (!empty($s['price_range'])) {
            list($priceFrom, $priceTo) = explode(';', $s['price_range']);
        }

        if ($s['feed_type'] == '1') {
            $prices_affiliate = Db::getInstance()->ExecuteS('
				SELECT `affiliate_id`, `affiliate_name`, `affiliate_formula`, `xml_name`
				FROM '._DB_PREFIX_.'blmod_xml_affiliate_price
				ORDER BY affiliate_name ASC
			');
        }

        if ($s['use_password']) {
            $pass_in_link = '&password=XML_PASSWORD';
        } else {
            $pass_in_link = '';
        }

        $multistore_status = false;

        if (_PS_VERSION_ >= '1.5') {
            $multistore = Shop::getShops();

            if (count($multistore) > 1) {
                $multistore_status = true;
            }
        }

        $link = $this->rootFile.'?id='.$page.$pass_in_link.'&affiliate=affiliate_name';

        $showUrlFile = '';
        $showCronFile = 'style="display: none;"';

        if (!empty($s['use_cron'])) {
            $showUrlFile = 'style="display: none;"';
            $showCronFile = '';
        }

        $this->_html .= '<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-external-link"></i> '.$this->l('XML File').'
                        </div>
                        <div class="row">
				<table border="0" width="100%" cellpadding="1" cellspacing="0">
					<tr>
						<td>
						    <div id="url_file_box" '.$showUrlFile.'>
							<input id="feed_url" style="width: 98%; margin-bottom: 13px;" type="text" name="xml_link" value="'.$link.'" /><br/>
                            <small>CSV: <a href="' . $link . '&file_format=csv">' . $link . '&file_format=csv</a></small><br/><br/>
                            <small>TSV: <a href="' . $link . '&file_format=csv">' . $link . '&file_format=tsv</a></small><br/><br/>
								<a id="feed_url_open" class="xml_feed_kbd" style="margin-left: 0;" href="'.$link.'" target="_blank">'.$this->l('Open').'</a> <a id="feed_url_download" class="xml_feed_kbd" href="'.$link.'&download=1" target="_blank">'.$this->l('Download').'</a>';

        if ($multistore_status) {
            $this->_html .= '<div id="multistore_url" class="bl_comments" style="float: right; cursor: pointer; padding-right: 4px;">'.$this->l('[Show/Hide Multistore options]').'</div>';
        }

        $affiliatePriceCron = '';

        if (!empty($prices_affiliate)) {
            $this->_html .= '<div id="affiliate_price_url" class="bl_comments" style="cursor: pointer; float: right; padding-right: 10px;">'.$this->l('[Show/Hide affiliate price]').'</div><div class="cb"></div>';
            $this->_html .= '<div id="affiliate_price_url_list" style="margin-top: 15px; display:none;"><hr/>';

            foreach ($prices_affiliate as $p) {
                $affiliatePriceCron .= '<span id="affiliate-price-cron-button_'.$p['affiliate_id'].'" class="affiliate-price-cron-button">'.$p['affiliate_name'].'</span>';
                $link = $this->rootFile.'?id='.$page.$pass_in_link.'&affiliate='.$p['affiliate_name'];

                $this->_html .= '<input style="width: 98%; margin-bottom: 7px;" type="text" name="xml_link" value="'.$link.'" /><br/>
									<span style="color: #268CCD; font-size: 12px;">Affiliate '.$p['affiliate_name'].':</span> <a style="font-weight: bold; text-decoration: underline;" href="'.$link.'" target="_blank">'.$this->l('Open').'</a> | <a style="font-weight: bold; text-decoration: underline;" href="'.$link.'&download=1" target="_blank">'.$this->l('Download').'</a>
									<div class="bl_comments">'.$this->l('Affiliate price:').' '.$p['affiliate_formula'].', '.$this->l('price name:').' '.$p['xml_name'].'</div>
									<hr/>';
            }

            $this->_html .= '</div>';
        }

        if ($multistore_status) {
            $this->_html .= '<div id="multistore_url_list" style="margin-top: 15px; display:none;">';
            //$link = new Link();

            foreach ($multistore as $h) {
                $this->_html .= '<div><hr/>';
                //$this->_html .= $link->getBaseLink($h['id_shop']);
                $this->_html .= '<label for="multistore_'.$h['id_shop'].'"><input id="multistore_'.$h['id_shop'].'" class="multistore_url_checkbox" type="checkbox" name="status" value="'.$h['id_shop'].'"> '.$h['name'].'</label></div>';
            }

            $this->_html .= '</div>';
        }

        $currency = new CurrencyCore();
        $currencies = $currency->getCurrencies();
        $currencyActive = array();
        $currencyList = array();

        if (!empty($currencies)) {
            foreach ($currencies as $c) {
                if (in_array($c['id_currency'], $currencyActive)) {
                    continue;
                }

                $currencyList[] = array('id' => $c['id_currency'], 'name' => $c['name'].' ('.$c['sign'].')');
                $currencyActive[] = $c['id_currency'];
            }
        }

        $this->_html .= '</div>';

        if ($s['feed_type'] == '1') {
            $cronCommand = '19 */4 * * * /usr/bin/php -q '._PS_ROOT_DIR_.'/modules/xmlfeeds/api/xml.php '.$page;
            $cronXmlFile = $this->getShopProtocol().$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/xmlfeeds/xml_files/feed_'.$page.'.xml';

            $this->_html .= '<div id="cron_file_box" '.$showCronFile.'>
                <p><input id="cron_path" style="width: 98%;" type="text" value="'.$cronXmlFile.'" /><input id="cron_path_original" type="hidden" value="'.$cronXmlFile.'" /></p>
                <p style="font-size: 13px; margin-top: 8px;">'.$this->l('Last cron activity:').' '.$s['last_cron_date'].'</p>
                <div class="show_cron_install" style="cursor: pointer; color: #268CCD;">'.$this->l('[Show/hide cron installation instructions]').'</div>
                <div id="cron_install_instruction" style="display: none;">
                    <p><b>'.$this->l('Install cron from a server command line (shell)').'</b></p>
                    <p>'.$this->l('1) Execute crontab -e (cron edit page) command').'</p>
                    <p>'.$this->l('2) In a new line enter the cron command (this example is set to run every 5 hours
                       ').': </p>
                    <p><input id="cron_command" style="width: 98%;" type="text" value="'.$cronCommand.'" /><input id="cron_command_original" type="hidden" value="'.$cronCommand.'" /></p>
                    <p>'.$this->l('3) Save the cron (').'<kbd>Ctrl</kbd> + <kbd>X</kbd>'.$this->l(', answer by pressing').' <kbd>Y</kbd>'.
                $this->l(' to save changes and').' <kbd>Enter</kbd>'.$this->l(' to confirm)').'</p>
                    <p style="margin-top: 15px; margin-bottom: -7px;">Add affiliate price: '.$affiliatePriceCron.'</p>
                </div>
            </div>';
        }

        $this->_html .= '
						</td>
					</tr>
				</table>
			</div>
			</div>
			<div class="cb"></div>';

        $feed_mode_img = '';

        $countries = CountryCore::getCountries($this->shopLang);

        if (!empty($s['feed_mode'])) {
            $feed_mode_img = '<img class="feed_type_id" alt="Feed type" title="Feed type" src="../modules/'.$this->name.'/views/img/type_'.$s['feed_mode'].'.png" />';
        }

        $this->_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-cog"></i> '.$this->l('XML Feed settings').'
                        </div>
                        <div class="row">
				<table border="0" width="100%" cellpadding="3" cellspacing="0">
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'nav-home.gif" /></td>
						<td width="200"><b>'.$this->l('Feed id:').'</b></td>
						<td>
							<input style="width: 35px;" type="text" readonly="readonly" name="feed_id" value="'.$page.'">
							'.$feed_mode_img.'
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'translation.gif" /></td>
						<td width="200"><b>'.$this->l('Feed name:').'</b></td>
						<td>
							<input style="max-width: 462px;" type="text" name="name" value="'.$s['name'].'">
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'access.png" /></td>
						<td width="200"><b>'.$this->l('XML status:').'</b></td>
						<td>
							<label for="xmf_feed_status">
								<input id="xmf_feed_status" type="checkbox" name="status"';
        $this->_html .= $this->status($s['status']).'
							</label>	
						</td>
					</tr>					
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'tab-tools.gif" /></td>
						<td width="200"><b>'.$this->l('Add CDATA:').' </b></td>
						<td>
							<label for="cdata_status">
								<input id="cdata_status" type="checkbox" name="cdata_status"';
        $this->_html .= $this->status($s['cdata_status']).'
							</label>
						</td>
					</tr>					
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'page_white_text.png" /></td>
						<td width="200"><b>'.$this->l('Drop html tags:').'</b></td>
						<td>
							<label for="html_tags_status">
								<input id="html_tags_status" type="checkbox" name="html_tags_status"';
        $this->_html .= $this->status($s['html_tags_status']).'
							</label>
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'summary.png" /></td>
						<td width="200"><b>'.$this->l('XML in one branch:').'</b></td>
						<td>
							<label for="one_branch">
								<input id="one_branch" type="checkbox" name="one_branch"';
        $this->_html .= $this->status($s['one_branch']).'
							</label>
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'enabled.gif" /></td>
						<td width="200"><b>'.$this->l('Only enabled:').'</b></td>
						<td>
							<label for="only_enabled">
								<input id="only_enabled" type="checkbox" name="only_enabled"';
        $this->_html .= $this->status($s['only_enabled']).'
							</label>
						</td>
					</tr>';

        if ($s['feed_type'] == '1') {
            $this->_html .= '<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'tab-orders.gif" /></td>
							<td width="200"><b>'.$this->l('Only in stock:').'</b></td>
							<td>
								<label for="only_in_stock">
									<input id="only_in_stock" type="checkbox" name="only_in_stock"';
            $this->_html .= $this->status($s['only_in_stock']).'
								</label>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'supplier.gif" /></td>
							<td width="200"><b>'.$this->l('Shipping country:').' </b></td>
							<td>
                                <select name="shipping_country">
                                    <option value="0">'.$this->l('Default').'</option>';

                                    foreach ($countries as $c) {
                                        $selected = '';

                                        if ($s['shipping_country'] == $c['id_country']) {
                                            $selected = 'selected';
                                        }

                                        $this->_html .= '<option value="'.$c['id_country'].'" '.$selected.'>'.$c['name'].'</option>';
                                    }

                                    $this->_html .= '
                                </select>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'picture.gif" /></td>
							<td width="200"><b>'.$this->l('All images:').'</b></td>
							<td>
								<label for="all_images">
									<input id="all_images" type="checkbox" name="all_images"';
            $this->_html .= $this->status($s['all_images']).'
								</label>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'payment.gif" /></td>
							<td width="200"><b>'.$this->l('Price with currency:').'</b></td>
							<td>
								<label for="price_with_currency">
									<input id="price_with_currency" type="checkbox" name="price_with_currency"';
            $this->_html .= $this->status($s['price_with_currency']).'
								</label>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'AdminBackup.gif" /></td>
							<td width="200"><b>'.$this->l('Use cron:').' </b></td>
							<td>
							<label for="use_cron">
									<input id="use_cron" type="checkbox" name="use_cron"';
            $this->_html .= $this->status($s['use_cron']).'
							</label>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'multishop_config.png" /></td>
							<td width="200"><b>'.$this->l('Split by combination:').'</b></td>
							<td>
								<label for="split_by_combination">
									<input id="split_by_combination" type="checkbox" name="split_by_combination"';
            $this->_html .= $this->status($s['split_by_combination']).'
								</label>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'copy_files.gif" /></td>
							<td width="200"><b>'.$this->l('Split feed:').'</b></td>
							<td>
								<label for="split_feed">
									<input id="split_feed" type="checkbox" name="split_feed"';
            $this->_html .= $this->status($s['split_feed']).'
								</label>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'invoice.gif" /></td>
							<td width="200"><b>'.$this->l('Split feed limit:').'</b></td>
							<td>
								<input type="text" name="split_feed_limit" value="'.$s['split_feed_limit'].'" size="6">
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'dollar.gif" /></td>
							<td width="140"><b>'.$this->l('Currency:').'</b></td>
							<td>
								<select name="currency_id">
                                    <option value="">'.$this->l('Default').'</option>';
                                    foreach ($currencyList as $c) {
                                        $selected = '';

                                        if ($s['currency_id'] == $c['id']) {
                                            $selected = 'selected';
                                        }

                                        $this->_html .= '<option value="'.$c['id'].'" '.$selected.'>'.$c['name'].'</option>';
                                    }
                        $this->_html .= '
                                </select>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'gear_multi.png" /></td>
							<td width="140"><b>'.$this->l('Product settings:').'</b></td>
							<td>
								<select name="product_settings_package_id">
                                    <option value="">'.$this->l('None').'</option>';
                                    foreach ($productSettingsAdmin->getProductSettingsPackagesList() as $p) {
                                        $this->_html .= '<option value="'.$p['id'].'" '.(($s['product_settings_package_id'] == $p['id']) ? ' selected' : '').'>'.$p['name'].'</option>';
                                    }
                                $this->_html .= '
                                </select>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'cms.gif" /></td>
							<td width="140"><b>'.$this->l('Filter by price range:').'</b></td>
							<td>
								From <input class="price_range_field" type="text" name="price_from" value="'.$priceFrom.'">
								To <input class="price_range_field" type="text" name="price_to" value="'.$priceTo.'">
								<div class="bl_comments">'.$this->l('[Specify price range will be active]').'</div>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'manufacturers.gif" /></td>
							<td width="200"><b>'.$this->l('Filter by manufacturers:').'</b></td>
							<td>
								<script type="text/javascript">
								$(document).ready(function(){
									$(".manufacturers_list").hide();
									$(".manufacturers_list_button").show();

									$(".manufacturers_list_button").click(function(){
										$(".manufacturers_list").slideToggle();
									});
								});
								</script>
								<label for="manufacturers_status">
									<input id="manufacturers_status" type="checkbox" name="manufacturers"';
            $this->_html .= $this->status($s['manufacturer']).'
								</label>
								<span class="manufacturers_list_button" style="cursor: pointer; color: #268CCD; margin-left: 10px;">'.$this->l('[Show/Hide manufacturers]').'</span>
								<div class="manufacturers_list" style="display: none; margin-top:10px;">';
            $this->manufacturersList($s['manufacturer_list']);
            $this->_html .= '</div>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'profiles.png" /></td>
							<td width="200"><b>'.$this->l('Filter by suppliers:').'</b></td>
							<td>
								<script type="text/javascript">
								$(document).ready(function(){
									$(".supplier_list").hide();
									$(".supplier_list_button").show();

									$(".supplier_list_button").click(function(){
										$(".supplier_list").slideToggle();
									});
								});
								</script>
								<label for="supplier_status">
									<input id="supplier_status" type="checkbox" name="suppliers"';
            $this->_html .= $this->status($s['supplier']).'
								</label>
								<span class="supplier_list_button" style="cursor: pointer; color: #268CCD; margin-left: 10px;">'.$this->l('[Show/Hide suppliers]').'</span>
								<div class="supplier_list" style="display: none; margin-top:10px;">';
            $this->supplierList($s['supplier_list']);
            $this->_html .= '</div>
							</td>
						</tr>
						<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'tab-categories.gif" /></td>
							<td width="200"><b>'.$this->l('Filter by categories:').'</b></td>
							<td>
								<script type="text/javascript">
								$(document).ready(function(){									
									$(".categories_list").hide();
									$(".categories_list_button").show();

									$(".categories_list_button").click(function(){
										$(".categories_list").slideToggle();
									});									
								});
								</script>	
								<label for="products_categories">
									<input id="products_categories" type="checkbox" name="categories"';
            $this->_html .= $this->status($s['categories']).'
								</label>
								<span class="categories_list_button" style="cursor: pointer; color: #268CCD; margin-left: 10px;">'.$this->l('[Show/Hide categories]').'</span>
								<div class="categories_list" style="display: none; margin-top:10px;">
								<div style="display: none;">
                                    <label class="blmod_mr20">
                                        <input type="radio" name="filter_category_type" value="0" '.(empty($s['filter_category_type']) ? 'checked="checked"' : '').'> Filter by main category
                                    </label>
                                    <label class="">
                                        <input type="radio" name="filter_category_type" value="1" '.($s['filter_category_type'] == 1 ? 'checked="checked"' : '').'> Filter by all categories
                                    </label>
                                </div>';
            $this->categoriesTree($s['cat_list']);
            $this->_html .= '</div>
							</td>
						</tr>
						<tr>
                            <td width="20"><img src="'.$this->moduleImgPath.'product_list.png" /></td>
                            <td width="200"><b>'.$this->l('Filter by product lists:').'</b></td>
                            <td>
                                <script type="text/javascript">
								$(document).ready(function(){
									$(".product_list").hide();
									$(".product_list_button").show();

									$(".product_list_button").click(function(){
										$(".product_list").slideToggle();
									});
								});
								</script>
								<label for="product_list_status">
									<input id="product_list_status" type="checkbox" name="product_list_status"';
            $this->_html .= $this->status($s['product_list_status']).'
								</label>
								<span class="product_list_button" style="cursor: pointer; color: #268CCD; margin-left: 10px;">'.$this->l('[Show/Hide product lists]').'</span>
								<div class="product_list" style="display: none; margin-top:10px;">
                                    '.$productListFeed->getProductListSettingsPage($s['product_list']).'
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="20"><img src="'.$this->moduleImgPath.'arrow_up.png" /></td>
                            <td width="200"><b>'.$this->l('Filter by discount status:').'</b></td>
                            <td>
                                <label class="blmod_mr20">
                                    <input type="radio" name="filter_discount" value="0"'.($s['filter_discount'] == 0 ? ' checked="checked"' : '').'> '.$this->l('All').'
                                </label>
                                <label class="blmod_mr20">
                                    <input type="radio" name="filter_discount" value="1"'.($s['filter_discount'] == 1 ? ' checked="checked"' : '').'> '.$this->l('With discount').'
                                </label>
                                <label>
                                    <input type="radio" name="filter_discount" value="2"'.($s['filter_discount'] == 2 ? 'checked="checked"' : '').'> '.$this->l('Without discount').'
                                </label>
                            </td>
                        </tr>';
        }

        $this->_html .= '<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'comment.gif" /></td>
						<td width="200"><b>'.$this->l('Header rows:').'</b></td>
						<td>
							<textarea name="header_information" style="max-width: 470px; width: 100%; height: 60px;">'.$s['header_information'].'</textarea>
							<div class="bl_comments">'.$this->l('[Make sure that you have entered validate XML code]').'</div>
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'comment.gif" /></td>
						<td width="200"><b>'.$this->l('Footer rows:').'</b></td>
						<td>
							<textarea name="footer_information" style="max-width: 470px; width: 100%; height: 60px;">'.$s['footer_information'].'</textarea>
							<div class="bl_comments">'.$this->l('[Make sure that you have entered validate XML code]').'</div>
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'edit.gif" /></td>
						<td width="200"><b>'.$this->l('Extra feed rows:').'</b></td>
						<td>
							<textarea name="extra_feed_row" style="max-width: 470px; width: 100%; height: 60px;">'.$s['extra_feed_row'].'</textarea>
							<div class="bl_comments">'.$this->l('[Make sure that you have entered validate XML code]').'</div>
						</td>
					</tr>
					<tr>
							<td width="20"><img src="'.$this->moduleImgPath.'navigation.png" /></td>
							<td width="200"><b>'.$this->l('Feed generation time:').'</b></td>
							<td>
								<label for="feed_generation_time" style="margin-top: 4px;">
									<input id="feed_generation_time" type="checkbox" name="feed_generation_time"';
        $this->_html .= $this->status($s['feed_generation_time']).'
								</label>
								<input style="width: 175px; margin-left: 14px;" type="text" name="feed_generation_time_name" value="'.$s['feed_generation_time_name'].'" placeholder="Field name" size="6">
							</td>
						</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'database_gear.gif" /></td>
						<td width="200"><b>'.$this->l('Use cache:').'</b></td>
						<td>
							<label for="use_cache">
								<input id="use_cache" type="checkbox" name="use_cache"';
        $this->_html .= $this->status($s['use_cache']).'
							</label>
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'time.gif" /></td>
						<td width="200"><b>'.$this->l('Cache time:').'</b></td>
						<td>
							<input type="text" name="cache_time" value="'.$s['cache_time'].'" size="6"> '.$this->l('[min.]').'
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'nav-user.gif" /></td>
						<td width="200"><b>'.$this->l('Only with password:').'</b></td>
						<td>
							<label for="use_password">
								<input id="use_password" type="checkbox" name="use_password"';
        $this->_html .= $this->status($s['use_password']).'
							</label>
						</td>
					</tr>
					<tr>
						<td width="20"><img src="'.$this->moduleImgPath.'htaccess.gif" /></td>
						<td width="200"><b>'.$this->l('Password:').'</b></td>
						<td>
							<input type="password" name="password" value="'.$s['password'].'">';

        if ($s['use_password'] == 1 && empty($s['password'])) {
            $this->_html .= '<span style="color: RED;">'.$this->l('[Please set password]').'</span>';
        }

        $this->_html .= '</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
				<div style="text-align: center;">
				    <input type="submit" name="update_feeds_s" value="'.$this->l('Update').'" class="button" />
				    <input style="margin-left: 7px;" type="submit" name="clear_cache" value="'.$this->l('Clear cache').'" class="button" />
				</div>
				<input type="hidden" name="feeds_name" value="'.$page.'" />
			</div>
			</div>
			<br/>';

        if ($s['feed_type'] == '1') {
            $prod_id = $this->getRandProduct();

            if (empty($prod_id)) {
                $this->_html .= '<div class="'.$this->setMessageStyle('warning').'" style="width: 95%"><img src="'.$this->moduleImgPath.'warning.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('You do not have a product with attributes, consequently attribute options are not displayed').'</div>';
            }

            $this->productsXml($page);
        } elseif ($s['feed_type'] == '2') {
            $this->categoriesXml($page);
        }
    }

    public function recurseCategoryForIncludePref($indexedCategories, $categories, $current, $id_category = 1, $id_category_default = null, $selected = array(), $isGoogleCat = false)
    {
        $img_type = 'png';

        /*
         * For old PS version
         */
        global $done;

        static $irow;

        if (!isset($done[$current['infos']['id_parent']])) {
            $done[$current['infos']['id_parent']] = 0;
        }

        $done[$current['infos']['id_parent']] += 1;

        $categories[$current['infos']['id_parent']] = isset($categories[$current['infos']['id_parent']]) ? $categories[$current['infos']['id_parent']] : false;

        $todo = count($categories[$current['infos']['id_parent']]);
        $doneC = $done[$current['infos']['id_parent']];

        $level = $current['infos']['level_depth'] + 1;
        $img = $level == 1 ? 'lv1.'.$img_type : 'lv'.$level.'_'.($todo == $doneC ? 'f' : 'b').'.'.$img_type;
        $levelImg = '<img src="'.$this->moduleImgPath.''.$img.'" alt="" />';

        if ($level > 5) {
            $levelSpace = (($level - 2) * 24) - 12;
            $levelImg = '<div class="category-level" style="width: '.$levelSpace.'px;"><br></div>';
            $levelImg .= '<div class="category-level-'.($todo == $doneC ? 'f' : 'b').'"><br></div>';
        }

        $checked = false;

        if (in_array($id_category, $selected)) {
            $checked = 'checked="yes"';
        }

        $selectBox = '<td class="center">
				<input type="checkbox" id="categoryBox_'.$id_category.'" name="categoryBox[]" '.$checked.' value="'.$id_category.'" class="noborder">
			</td>';

        $selectBoxW = '';
        $inputField = '';

        if ($isGoogleCat) {
            $selectBox = '';
            $selectBoxW = 'width: 25px;';

            $googleCatValue = '';

            if (!empty($this->googleCategoriesMap[$id_category])) {
                $googleCatValue = $this->googleCategoriesMap[$id_category]['name'];
            }

            $inputField = '
                <div><input type="text" placeholder="'.$this->l('Enter category name').'" id="google_cat_map_'.$id_category.'" class="google_cat_map_blmod" name="google_cat_map['.$id_category.']" value="'.$googleCatValue.'"></div>
            <div style="clear: both;"></div>
            ';
        }

        $this->_html .= '<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
			'.$selectBox.'
			<td style="'.$selectBoxW.'">
				'.$id_category.'
			</td>
			<td>
				<div style="float: left;">'.$levelImg.'</div>
				<div style="float: left;">
				    <label style="line-height: 26px;" for="categoryBox_'.$id_category.'" class="t">'.Tools::stripslashes($current['infos']['name']).'</label>
				</div>
                <div style="clear: both;"></div>
				'.$inputField.'
			</td>
		</tr>';

        if (isset($categories[$id_category])) {
            foreach ($categories[$id_category] as $key => $row) {
                if ($key != 'infos') {
                    $this->recurseCategoryForIncludePref($indexedCategories, $categories, $categories[$id_category][$key], $key, null, $selected, $isGoogleCat);
                }
            }
        }
    }

    public static function getCategories($id_lang, $active = true, $order = true)
    {
        $result = Db::getInstance()->ExecuteS('
			SELECT *
			FROM `'._DB_PREFIX_.'category` c
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`
			WHERE `id_lang` = '.$id_lang.'
			'.($active ? 'AND `active` = 1' : '').'
			ORDER BY `name` ASC');

        if (!$order) {
            return $result;
        }

        $categories = array();

        foreach ($result as $row) {
            $categories[$row['id_parent']][$row['id_category']]['infos'] = $row;
        }

        return $categories;
    }

    public function supplierList($active = false)
    {
        $class = 'SupplierCore';

        if (!class_exists('SupplierCore', false)) {
            $class = 'Supplier';
        }

        $supplier = $class::getSuppliers();

        $this->_html .= '<div style = "margin: 10px;">
				<table cellspacing="0" cellpadding="0" class="table" id = "radio_div">
					<tr>
						<th><input type="checkbox" name="checkme" class="noborder" onclick="checkDelBoxes(this.form, \'supplier[]\', this.checked)"></th>
						<th>'.$this->l('ID').'</th>
						<th style="width: 400px">'.$this->l('Name').'</th>
					</tr>';

        $irow = 0;

        $activeList = explode(',', $active);

        if (!empty($supplier)) {
            foreach ($supplier as $m) {
                $checked = false;

                if (in_array($m['id_supplier'], $activeList)) {
                    $checked = 'checked="yes"';
                }

                $this->_html .= '<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
					<td class="center">
						<input type="checkbox" id="supplier_'.$m['id_supplier'].'" name="supplier[]" '.$checked.' value="'.$m['id_supplier'].'" class="noborder">
					</td>
					<td>
						'.$m['id_supplier'].'
					</td>
					<td>
						<label style="line-height: 26px; padding-left: 0px;" for="supplier_'.$m['id_supplier'].'" class="t">'.$m['name'].'
					</td>
				</tr>';
            }
        }

        $this->_html .= '</table>
				<div class="supplier_list_button" style="cursor: pointer; color: #268CCD; text-align: left; margin-top: 10px;">'.$this->l('[Hide]').'</div>
			</div>';
    }

    public function manufacturersList($active = false)
    {
        $class = 'ManufacturerCore';

        if (!class_exists('ManufacturerCore', false)) {
            $class = 'Manufacturer';
        }

        $manufacturers = $class::getManufacturers();

        $this->_html .= '<div style = "margin: 10px;">
				<table cellspacing="0" cellpadding="0" class="table" id = "radio_div">
					<tr>
						<th><input type="checkbox" name="checkme" class="noborder" onclick="checkDelBoxes(this.form, \'manufacturer[]\', this.checked)"></th>
						<th>'.$this->l('ID').'</th>
						<th style="width: 400px">'.$this->l('Name').'</th>
					</tr>';

        $irow = 0;

        $activeList = explode(',', $active);

        if (!empty($manufacturers)) {
            foreach ($manufacturers as $m) {
                $checked = false;

                if (in_array($m['id_manufacturer'], $activeList)) {
                    $checked = 'checked="yes"';
                }

                $this->_html .= '<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
					<td class="center">
						<input type="checkbox" id="manufacturer_'.$m['id_manufacturer'].'" name="manufacturer[]" '.$checked.' value="'.$m['id_manufacturer'].'" class="noborder">
					</td>
					<td>
						'.$m['id_manufacturer'].'
					</td>
					<td>
						<label style="line-height: 26px; padding-left: 0px;" for="manufacturer_'.$m['id_manufacturer'].'" class="t">'.$m['name'].'
					</td>
				</tr>';
            }
        }

        $this->_html .= '</table>
				<div class="manufacturers_list_button" style="cursor: pointer; color: #268CCD; text-align: left; margin-top: 10px;">'.$this->l('[Hide]').'</div>
			</div>';
    }

    public function categoriesTree($selected = false, $isGoogleCat = false)
    {
        if (_PS_VERSION_ >= '1.5') {
            $langId = $this->context->language->id;
        } else {
            /*
             * For old PS version
             */
            global $cookie;

            $langId = $cookie->id_lang;
        }

        if (!empty($selected)) {
            $sel_array = explode(',', $selected);
        } else {
            $sel_array = array();
        }

        $margin = 'margin: 10px;';
        $border = '';
        $hideMessage = '<div class="categories_list_button" style="cursor: pointer; color: #268CCD; text-align: left; margin-top: 10px;">'.$this->l('[Hide]').'</div>';
        $selectBox = '<th><input type="checkbox" name="checkme" class="noborder" onclick="checkDelBoxes(this.form, \'categoryBox[]\', this.checked)"></th>';

        if ($isGoogleCat) {
            $margin = '';
            $border = 'border: 0px; margin-top: 6px;';
            $hideMessage = '';
            $selectBox = '';
        }

        $this->_html .= '<div style = "'.$margin.'">
				<table cellspacing="0" cellpadding="0" class="table" id = "radio_div" style="'.$border.'">
					<tr>
						'.$selectBox.'
						<th>'.$this->l('ID').'</th>
						<th style="width: 400px">'.$this->l('Name').'</th>
					</tr>';

        $categories = Category::getCategories($langId, false);

        if (!empty($categories)) {
            $categories[0][1] = isset($categories[0][1]) ? $categories[0][1] : false;
            $this->recurseCategoryForIncludePref(null, $categories, $categories[0][1], 1, null, $sel_array, $isGoogleCat);
        }

        $this->_html .= '</table>
				'.$hideMessage.'
			</div>';
    }

    public function productsXml($page)
    {
        $this->_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-cog"></i> '.$this->l('XML Feed fields').'
                        </div>
                        <div class="row">';

        $this->_html .= $this->productsXmlSettings($page);
        $this->_html .= '
				<br/>		
				<input type="hidden" name="feeds_id" value="'.$page.'" />
				<input type="hidden" name="is_product_feed" value="1" />
				<div style="text-align: center;"><input type="submit" name="settings_prod" value="'.$this->l('Update').'" class="button" /></div>
			</div>
			</div>
		</form>';
    }

    public function categoriesXml($page)
    {
        $this->_html .= '
			<div class="panel">
                        <div class="panel-heading">
                            <i class="icon-cog"></i> '.$this->l('XML Feed fields').'
                        </div>
                        <div class="row">';

        $this->_html .= $this->categoriesXmlSettings($page);
        $this->_html .= '<br/>
				<input type="hidden" name="feeds_id" value="'.$page.'" />
				<input type="hidden" name="is_category_feed" value="1" />
				<div style="text-align: center;"><input type="submit" name="settings_cat" value="'.$this->l('Update').'" class="button" /></div>
			</div></div>
		</form>';
    }

    public function printBlock($block_name = false, $info = array(), $only_checkbox = false)
    {
        if (empty($info)) {
            return false;
        }

        $scroll = false;

        if (count($info) > 40) {
            $scroll = 'style="height: 850px; overflow-y: scroll;"';
        }

        $html = '<div class="table_name">'.$this->l($block_name).'</div>
			<div class="cb"></div>
			<div class="cn_table" '.$scroll.'>
				<div class="cn_top">
					<div class="cn_name">
						'.$this->l('Name').'
					</div>
					<div class="cn_status">
						'.$this->l('Status').'
					</div>';

        if (empty($only_checkbox)) {
            $html .= '
                <div class="cn_name_xml">
                    '.$this->l('Name in XML').'
                </div>';
        } else {
            $html .= '<div class="cb"></div>';
        }

        $html .= '</div>';

        $page = Tools::getValue('page');

        foreach ($info as $i) {
            $find = isset($this->tags_info[$i['name'].'+'.$i['table'].'+status']) ? $this->tags_info[$i['name'].'+'.$i['table'].'+status'] : false;
            $value = !empty($this->tags_info[$i['name'].'+'.$i['table']]) ? $this->tags_info[$i['name'].'+'.$i['table']] : (!empty($i['placeholder']) ? '' : $i['title']);

            $disable = false;
            $hideField = $this->hideField($i['name'], $i['table']);
            $compatibilityError = '';

            if ($hideField) {
                $disable = true;
                $find = 0;
                $compatibilityError = '<span class="error-incompatible" title="'.$this->l('Your Prestashop version incompatible').'">!</span>';

                Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_fields
                    WHERE category = "'.$page.'" AND `name` = "'.$i['name'].'" AND `table` = "'.$i['table'].'"');
            }

            $box_id = $i['name'].'_'.$i['table'].'_option';

            $html .= '<div class="cn_line">
				<div class="cn_name">
					'.$this->l(str_replace('_', ' ', $i['title'])).'
				</div>
				<div class="cn_status">
					<label for="'.$box_id.'">
						<input id="'.$box_id.'" type="checkbox" name="'.$i['name'].'+'.$i['table'].'+status"';
            $html .= $this->status($find, $disable).$compatibilityError.'
					</label>
				</div>';

            if (!empty($find)) {
                $this->checkedInput = true;
            }

            if (empty($i['only_checkbox'])) {
                $html .= '<div class="cn_name_xml">
					<input type="text" name="'.$i['name'].'+'.$i['table'].'" value="'.$value.'" size="30" '.(!empty($i['placeholder']) ? 'placeholder="'.$i['placeholder'].'"' : '').'/>
				</div>';
            } else {
                $html .= '<div class="cb"></div>';
            }

            $html .= '</div>';
        }

        $html .= '</div>
		<div class="cb"></div>';

        return $html;
    }

    public function productsXmlSettings($page_id = false)
    {
        $v = array();
        $b_name = array();
        $b_status = array();
        $lang_array = array();

        $settings = Db::getInstance()->getRow('
			SELECT one_branch
			FROM '._DB_PREFIX_.'blmod_xml_feeds
			WHERE id = "'.$page_id.'"
		');

        $disabled_branch_name = '';

        if (!empty($settings['one_branch'])) {
            $disabled_branch_name = 'disabled="disabled"';
        }

        $r = Db::getInstance()->ExecuteS('
			SELECT `name`, `status`, `title_xml`, `table`
			FROM '._DB_PREFIX_.'blmod_xml_fields
			WHERE category = "'.$page_id.'"
		');

        foreach ($r as $k) {
            $v[$k['name'].'+'.$k['table']] = isset($k['title_xml']) ? $k['title_xml'] : false;
            $v[$k['name'].'+'.$k['table'].'+status'] = isset($k['status']) ? $k['status'] : false;
        }

        if (!empty($v)) {
            $this->tags_info = $v;
        }

        $r_b = Db::getInstance()->ExecuteS('
			SELECT `name`, `value`, `status`, `category`
			FROM '._DB_PREFIX_.'blmod_xml_block
			WHERE category = "'.$page_id.'"
		');

        foreach ($r_b as $bl) {
            $b_name[$bl['name']] = isset($bl['value']) ? $bl['value'] : false;
            $b_status[$bl['name']] = isset($bl['status']) ? $bl['status'] : false;
        }

        $b_name['extra-product-rows'] = !empty($b_name['extra-product-rows']) ? htmlspecialchars_decode($b_name['extra-product-rows'], ENT_QUOTES) : false;

        $html = '
            <div class="cn_table">
                <div class="cn_top">
                    <div class="cn_name">
                        Block name
                    </div>
                    <div class="cn_status">
                        Status
                    </div>
                    <div class="cn_name_xml">
                        Name in XML
                    </div>
                </div>
                <div class="cn_line">
                    <div class="cn_name">'.$this->l('File name').'</div>
                    <div class="cn_status">
                        <label for="file-name">
                            <input id="file-name" type="checkbox" name="file-name+status"
                            '.$this->status($b_status['file-name'], false).'
                        </label>
                    </div>
                    <div class="cn_name_xml">
                        <input style="width: 217px;" type="text" name="file-name" value="'.$b_name['file-name'].'" />
                    </div>
                </div>
            </div>
			<div class="cb"></div>
			<div style="float: left; width: 360px;">'.$this->l('Product').'</div><div style="float: left;"><input style="width: 217px;" type="text" name="cat-block-name" value="'.$b_name['cat-block-name'].'"/></div>
			<div class="cb"></div>
			<div style="float: left; width: 360px;">'.$this->l('Description').'</div><div style="float: left;"><input style="width: 217px;" '.$disabled_branch_name.' type="text" name="desc-block-name" value="'.$b_name['desc-block-name'].'" /></div>
			<div class="cb"></div>
			<div style="float: left; width: 360px;">'.$this->l('Images').'</div><div style="float: left;"><input style="width: 217px;" '.$disabled_branch_name.' type="text" name="img-block-name" value="'.$b_name['img-block-name'].'"/></div>
			<div class="cb"></div>
			<div style="float: left; width: 360px;">'.$this->l('Default category').'</div><div style="float: left;"><input style="width: 217px;" '.$disabled_branch_name.' type="text" name="def_cat-block-name" value="'.$b_name['def_cat-block-name'].'"/></div>
			<div class="cb"></div>
			<div style="float: left; width: 360px;">'.$this->l('Attributes').'</div><div style="float: left;"><input style="width: 217px;" '.$disabled_branch_name.' type="text" name="attributes-block-name" value="'.$b_name['attributes-block-name'].'"/></div>
			<div class="cb"></div>
			<div style="float: left; width: 285px;">'.$this->l('Extra product rows').'</div>
			<div style="float: left;">
			    <textarea style="margin: 0; max-width: 411px; width: 100%; height: 69px;" name="extra-product-rows">'.$b_name['extra-product-rows'].'</textarea>
			    <div class="bl_comments">'.$this->l('[Make sure that you have entered validate XML code]').'</div>
			</div>
			<div class="cb"></div>
			<br/><br/>
		';

        $html .= $this->printBlock(
            'Product basic information',
            array(
                array('name' => 'product_url_blmod', 'title' => 'product_url', 'table' => 'bl_extra'),
                array('name' => 'product_url_utm_blmod', 'title' => 'product_url_utm_code', 'table' => 'bl_extra', 'placeholder' => 'Example: ?utm_source=shop&med=w'),
                array('name' => 'id_product', 'title' => 'id_product', 'table' => 'product'),
                array('name' => 'id_supplier', 'title' => 'id_supplier', 'table' => 'product'),
                array('name' => 'supplier_reference', 'title' => 'supplier_reference', 'table' => 'product'),
                array('name' => 'id_manufacturer', 'title' => 'id_manufacturer', 'table' => 'product'),
                array('name' => 'name', 'title' => 'manufacturer_name', 'table' => 'manufacturer'),
                array('name' => 'location', 'title' => 'location', 'table' => 'product'),
                array('name' => 'height', 'title' => 'height', 'table' => 'product'),
                array('name' => 'width', 'title' => 'width', 'table' => 'product'),
                array('name' => 'weight', 'title' => 'weight', 'table' => 'product'),
                array('name' => 'depth', 'title' => 'depth', 'table' => 'product'),
                array('name' => 'on_sale', 'title' => 'on_sale', 'table' => 'product'),
                array('name' => 'reference', 'title' => 'reference', 'table' => 'product'),
                array('name' => 'ean13', 'title' => 'ean-13 or jan barcode', 'table' => 'product'),
                array('name' => 'upc', 'title' => 'upc barcode', 'table' => 'product'),
                array('name' => 'active', 'title' => 'active', 'table' => 'product'),
                array('name' => 'date_add', 'title' => 'date_add', 'table' => 'product'),
                array('name' => 'date_upd', 'title' => 'date_upd', 'table' => 'product'),
                array('name' => 'condition', 'title' => 'condition', 'table' => 'product'),
                array('name' => 'available_for_order', 'title' => 'available_for_order', 'table' => 'product'),
                array('name' => 'unit', 'title' => 'unit', 'table' => 'bl_extra'),
                array('name' => 'unit_price', 'title' => 'unit_price', 'table' => 'bl_extra'),
                array('name' => 'unit_price_e_tax', 'title' => 'unit_price_excl_tax', 'table' => 'bl_extra'),
            )
        );

        $html .= $this->printBlock(
            'Prices, Tax',
            array(
                array('name' => 'price', 'title' => 'base price', 'table' => 'product'),
                array('name' => 'price_sale_blmod', 'title' => 'sale price', 'table' => 'bl_extra'),
                array('name' => 'price_wt_discount_blmod', 'title' => 'price without discount', 'table' => 'bl_extra'),
                array('name' => 'only_discount_blmod', 'title' => 'only discount', 'table' => 'bl_extra'),
                array('name' => 'discount_rate_blmod', 'title' => 'discount rate', 'table' => 'bl_extra'),
                array('name' => 'price_shipping_blmod', 'title' => 'shipping price', 'table' => 'bl_extra'),
                array('name' => 'wholesale_price', 'title' => 'wholesale price', 'table' => 'product'),
                array('name' => 'ecotax', 'title' => 'ecotax', 'table' => 'product'),
                array('name' => 'tax_rate', 'title' => 'tax rate', 'table' => 'bl_extra'),
            )
        );

        $html .= $this->printBlock(
            'Quantity',
            array(
                array('name' => 'quantity', 'title' => 'quantity', 'table' => 'product'),
                array('name' => 'quantity_discount', 'title' => 'quantity_discount', 'table' => 'product'),
                array('name' => 'out_of_stock', 'title' => 'out_of_stock', 'table' => 'product'),
            )
        );

        $feedType = 'category';
        $defaultImage = 'name_'.$feedType.'_default';

        $html .= $this->printBlock(
            'Categories',
            array(
                array('name' => 'id_category_default', 'title' => 'id_category_default', 'table' => 'product'),
                array('name' => 'id_category_all', 'title' => 'id_category_all', 'table' => 'bl_extra'),
                array('name' => 'name', 'title' => $defaultImage, 'table' => 'category_lang'),
                array('name' => 'category_url', 'title' => 'category_url', 'table' => 'bl_extra'),
                array('name' => 'product_categories_tree', 'title' => 'product_category_tree', 'table' => 'bl_extra'),
            )
        );

        //Attributes
        $prod_id = $this->getRandProduct();
        $att_array = array();

        if (!empty($prod_id)) {
            $product_class_name = 'ProductCore';

            if (!class_exists($product_class_name, false)) {
                $product_class_name = 'Product';
            }

            $product_class = new $product_class_name();

            $product_class->id = $prod_id;
            $attributes = $product_class->getAttributesGroups(Configuration::get('PS_LANG_DEFAULT'));

            if (!empty($attributes[0])) {
                foreach ($attributes[0] as $id => $val) {
                    $att_array[] = array('name' => $id, 'title' => $id, 'table' => 'bl_extra_att');
                }

                $html .= $this->printBlock('Attributes', $att_array);
            }
        }

        //Grouped attributes
        $html .= $this->getGroupedAttributesBox();

        //Product feature
        $html .= $this->productFeatureBox();

        //Get images
        $img_array = array();

        $images = Db::getInstance()->ExecuteS('
			SELECT id_image_type, name FROM
			'._DB_PREFIX_.'image_type
		');

        if (!empty($images)) {
            foreach ($images as $img) {
                $img_array[] = array('name' => $img['name'], 'title' => $img['name'], 'table' => 'img_blmod');
            }

            $html .= $this->printBlock('Image (cover)', $img_array);
        }

        $html .= $this->printBlock(
            'Descriptions',
            array(
                array('name' => 'description', 'title' => 'description', 'table' => 'product_lang'),
                array('name' => 'description_short', 'title' => 'description_short', 'table' => 'product_lang'),
                array('name' => 'link_rewrite', 'title' => 'link_rewrite', 'table' => 'product_lang'),
                array('name' => 'meta_description', 'title' => 'meta_description', 'table' => 'product_lang'),
                array('name' => 'meta_keywords', 'title' => 'meta_keywords', 'table' => 'product_lang'),
                array('name' => 'meta_title', 'title' => 'meta_title', 'table' => 'product_lang'),
                array('name' => 'name', 'title' => 'name', 'table' => 'product_lang'),
                array('name' => 'available_now', 'title' => 'available_now', 'table' => 'product_lang'),
                array('name' => 'available_later', 'title' => 'available_later', 'table' => 'product_lang'),
            )
        );

        $languages = Db::getInstance()->ExecuteS('
			SELECT id_lang, name FROM
			'._DB_PREFIX_.'lang
		');

        $langBlock = '';
        $this->checkedInput = false;

        if (!empty($languages)) {
            foreach ($languages as $lan) {
                $lang_array[] = array('name' => $lan['id_lang'], 'title' => $lan['name'], 'table' => 'lang', 'only_checkbox' => 1);
            }

            $langBlock = $this->printBlock('Languages', $lang_array, 1);
        }

        if (!$this->checkedInput) {
            $html .= '<div style="margin-bottom: 8px; margin-top: 5px;" class="bl_comments_warn">'.$this->l('[Descriptions block required one or more languages ("Languages" tab)]').'</div>';
        }

        $html .= $langBlock;

        return $html;
    }

    public function categoriesXmlSettings($page_id = false)
    {
        $b_name = array();
        $v = array();
        $lang_array = array();

        $settings = Db::getInstance()->getRow('
			SELECT one_branch
			FROM '._DB_PREFIX_.'blmod_xml_feeds
			WHERE id = "'.$page_id.'"
		');

        $disabled_branch_name = '';

        if (!empty($settings['one_branch'])) {
            $disabled_branch_name = 'disabled="disabled"';
        }

        $r = Db::getInstance()->ExecuteS('
			SELECT `name`, `status`, `title_xml`, `table`
			FROM '._DB_PREFIX_.'blmod_xml_fields
			WHERE category = "'.$page_id.'"
		');

        foreach ($r as $k) {
            $v[$k['name'].'+'.$k['table']] = isset($k['title_xml']) ? $k['title_xml'] : false;
            $v[$k['name'].'+'.$k['table'].'+status'] = isset($k['status']) ? $k['status'] : false;
        }

        $this->tags_info = $v;

        $r_b = Db::getInstance()->ExecuteS('
			SELECT `name`, `value`, `category`
			FROM '._DB_PREFIX_.'blmod_xml_block
			WHERE category = "'.$page_id.'"
		');

        foreach ($r_b as $bl) {
            $b_name[$bl['name']] = isset($bl['value']) ? $bl['value'] : false;
        }

        $html = '
			<div style="float: left; width: 190px; font-weight: bold;">'.$this->l('File name:').'</div><div style="float: left;"><input type="text" name="file-name" value="'.$b_name['file-name'].'" size="30"/></div>
			<div class="cb"></div>
			<div style="float: left; width: 190px; font-weight: bold;">'.$this->l('Category block name:').'</div><div style="float: left;"><input type="text" name="cat-block-name" value="'.$b_name['cat-block-name'].'" size="30"/></div>
			<div class="cb"></div>
			<div style="float: left; width: 190px; font-weight: bold;">'.$this->l('Description block name:').'</div><div style="float: left;"><input type="text" '.$disabled_branch_name.' name="desc-block-name" value="'.$b_name['desc-block-name'].'" size="30"/></div>
			<br/><br/>
		';

        $html .= $this->printBlock(
            'Category basic information',
            array(
                array('name' => 'id_category', 'title' => 'id_category', 'table' => 'category'),
                array('name' => 'id_parent', 'title' => 'id_parent', 'table' => 'category'),
                array('name' => 'level_depth', 'title' => 'level_depth', 'table' => 'category'),
                array('name' => 'active', 'title' => 'active', 'table' => 'category'),
                array('name' => 'date_add', 'title' => 'date_add', 'table' => 'category'),
                array('name' => 'date_upd', 'title' => 'date_upd', 'table' => 'category'),
            )
        );

        $html .= $this->printBlock(
            'Descriptions',
            array(
                array('name' => 'id_lang', 'title' => 'id_lang', 'table' => 'category_lang'),
                array('name' => 'name', 'title' => 'name', 'table' => 'category_lang'),
                array('name' => 'description', 'title' => 'description', 'table' => 'category_lang'),
                array('name' => 'link_rewrite', 'title' => 'link_rewrite', 'table' => 'category_lang'),
                array('name' => 'meta_title', 'title' => 'meta_title', 'table' => 'category_lang'),
                array('name' => 'meta_keywords', 'title' => 'meta_keywords', 'table' => 'category_lang'),
                array('name' => 'meta_description', 'title' => 'meta_description', 'table' => 'category_lang'),
            )
        );

        //get languages
        $languages = Db::getInstance()->ExecuteS('
			SELECT id_lang, name FROM
			'._DB_PREFIX_.'lang
		');

        if (!empty($languages)) {
            foreach ($languages as $lan) {
                $lang_array[] = array('name' => $lan['id_lang'], 'title' => $lan['name'], 'table' => 'lang', 'only_checkbox' => 1);
            }

            $html .= $this->printBlock('Descriptions languages', $lang_array, 1);
        }

        return $html;
    }

    public function updateFeedsS(
        $name,
        $status,
        $use_cache,
        $cache_time,
        $use_password,
        $password,
        $id,
        $cdata_status,
        $html_tags_status,
        $one_branch,
        $header_information,
        $footer_information,
        $extra_feed_row,
        $only_enabled,
        $split_feed,
        $split_feed_limit,
        $cat_list,
        $categories,
        $use_cron,
        $only_in_stock,
        $attribute_as_product,
        $manufacturer,
        $manufacturerList,
        $supplier,
        $supplierList,
        $priceRange,
        $priceWithCurrency,
        $all_images,
        $currencyId,
        $feed_generation_time,
        $feed_generation_time_name,
        $split_by_combination,
        $productList,
        $productListStatus,
        $shippingCountry,
        $filterDiscount,
        $filterCategoryType,
        $productSettingsPackageId
    ) {
        $cache_time = (int) $cache_time;
        $split_feed_limit = (int) $split_feed_limit;

        if (!empty($filterDiscount)) {
            $split_feed = 0;
        }

        $query = Db::getInstance()->Execute('
			UPDATE ' . _DB_PREFIX_ . 'blmod_xml_feeds SET
			name="' . htmlspecialchars($name, ENT_QUOTES) . '", status = "' . $status . '", use_cache = "' . $use_cache . '",
			cache_time = "' . htmlspecialchars($cache_time, ENT_QUOTES) . '", use_password = "' . $use_password . '",
			password = "' . htmlspecialchars($password, ENT_QUOTES) . '", cdata_status = "' . $cdata_status . '",
			html_tags_status = "' . $html_tags_status . '", one_branch = "' . $one_branch . '",
			header_information = "' . htmlspecialchars($header_information, ENT_QUOTES) . '",
			footer_information = "' . htmlspecialchars($footer_information, ENT_QUOTES) . '", extra_feed_row = "' . htmlspecialchars($extra_feed_row, ENT_QUOTES) . '",
			only_enabled = "' . $only_enabled . '", split_feed = "' . $split_feed . '", split_feed_limit = "' . $split_feed_limit . '",
			cat_list = "' . $cat_list . '", categories = "' . $categories . '", use_cron = "' . $use_cron . '", only_in_stock = "' . $only_in_stock . '",
			manufacturer_list = "' . $manufacturerList . '", manufacturer = "' . $manufacturer . '", supplier_list = "' . $supplierList . '", supplier = "' . $supplier . '",
			attribute_as_product = "' . $attribute_as_product . '", price_range = "' . $priceRange . '", price_with_currency = "' . $priceWithCurrency . '",
			all_images = "' . $all_images . '", currency_id = "' . $currencyId . '", feed_generation_time = "' . $feed_generation_time . '",
			feed_generation_time_name = "' . $this->onSpecial($feed_generation_time_name) . '", split_by_combination = "' . $split_by_combination . '",
			product_list = "' . $productList . '", product_list_status = "' . $productListStatus . '", shipping_country = "' . $shippingCountry . '",
			filter_discount = "' . $filterDiscount . '", filter_category_type = "'.$filterCategoryType.'", product_settings_package_id = "'.$productSettingsPackageId.'"
			WHERE id = "' . $id . '"
		');

        $error = Db::getInstance()->getMsgError();

        if (!empty($id)) {
            $this->deleteCache($id);
        }

        if ($query) {
            $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Feed settings successfully updated').'</div>';
        } else {
            $this->_html .= '<div class="'.$this->setMessageStyle('warning').'"><img src="'.$this->moduleImgPath.'warning.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('error, insert feed settings.').$error.'</div>';
        }
    }

    public function updateFields($type)
    {
        $post = array();
        $category = Tools::getValue('feeds_id');

        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_fields WHERE category = "'.$category.'"');
        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_block WHERE category = "'.$category.'"');

        if (!empty($category)) {
            $this->deleteCache($category);
        }

        $post['file-name'] = Tools::getValue('file-name');
        $post['cat-block-name'] = Tools::getValue('cat-block-name');
        $post['desc-block-name'] = Tools::getValue('desc-block-name');
        $post['file-name+status'] = Tools::getValue('file-name+status');
        $post['cat-block-name+status'] = Tools::getValue('cat-block-name+status');
        $post['desc-block-name+status'] = Tools::getValue('desc-block-name+status');

        $post['file-name'] = !empty($post['file-name']) ? $this->onSpecial($post['file-name']) : 'categories';
        $post['cat-block-name'] = !empty($post['cat-block-name']) ? $this->onSpecial($post['cat-block-name']) : 'category';
        $post['desc-block-name'] = !empty($post['desc-block-name']) ? $this->onSpecial($post['desc-block-name']) : 'description';

        if ($type == 2) {
            Db::getInstance()->Execute('
				INSERT INTO '._DB_PREFIX_.'blmod_xml_block
				(`name`, `value`, `status`, `category`)
				VALUE
				("file-name",  "'.htmlspecialchars($post['file-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['file-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("cat-block-name", "'.htmlspecialchars($post['cat-block-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['cat-block-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("desc-block-name", "'.htmlspecialchars($post['desc-block-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['desc-block-name+status'], ENT_QUOTES).'", "'.$category.'")
			');
        } elseif ($type == 1) {
            $post['img-block-name'] = Tools::getValue('img-block-name');
            $post['def_cat-block-name'] = Tools::getValue('def_cat-block-name');
            $post['attributes-block-name'] = Tools::getValue('attributes-block-name');
            $post['extra-product-rows'] = Tools::getValue('extra-product-rows');
            $post['img-block-name+status'] = Tools::getValue('img-block-name+status');
            $post['def_cat-block-name+status'] = Tools::getValue('def_cat-block-name+status');
            $post['attributes-block-name+status'] = Tools::getValue('attributes-block-name+status');

            $post['img-block-name'] = !empty($post['img-block-name']) ? $this->onSpecial($post['img-block-name']) : 'images';
            $post['def_cat-block-name'] = !empty($post['def_cat-block-name']) ? $this->onSpecial($post['def_cat-block-name']) : 'default_cat';
            $post['attributes-block-name'] = !empty($post['attributes-block-name']) ? $this->onSpecial($post['attributes-block-name']) : 'attributes';
            $post['extra-product-rows'] = !empty($post['extra-product-rows']) ? $post['extra-product-rows'] : false;

            Db::getInstance()->Execute('
				INSERT INTO '._DB_PREFIX_.'blmod_xml_block
				(`name`, `value`, `status`, `category`)
				VALUE
				("file-name", "'.htmlspecialchars($post['file-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['file-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("cat-block-name", "'.htmlspecialchars($post['cat-block-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['cat-block-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("desc-block-name", "'.htmlspecialchars($post['desc-block-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['desc-block-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("img-block-name", "'.htmlspecialchars($post['img-block-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['img-block-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("def_cat-block-name", "'.htmlspecialchars($post['def_cat-block-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['def_cat-block-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("attributes-block-name", "'.htmlspecialchars($post['attributes-block-name'], ENT_QUOTES).'", "'.htmlspecialchars($post['attributes-block-name+status'], ENT_QUOTES).'", "'.$category.'"),
				("extra-product-rows", "'.htmlspecialchars($post['extra-product-rows'], ENT_QUOTES).'", "1", "'.$category.'")
			');
        }

        $value = '';

        /*
         * We must get full post array, sorry but can't use PS Tool
         */
        $post = $_POST;

        foreach ($post as $id => $val) {
            $name = explode('+', $id);

            if (empty($name[1]) || (!empty($name[2]) && $name[1] != 'lang')) {
                continue;
            }

            $title = isset($val) ? $this->onSpecial($val, $name[0]) : false;
            $status = isset($post[$id.'+status']) ? $post[$id.'+status'] : 0;

            if ($name[1] == 'lang') {
                $status = !empty($post[$id]) ? $post[$id] : 0;
            }

            $value .= '("'.$name[0].'", "'.$status.'", "'.htmlspecialchars($title, ENT_QUOTES).'", "'.$name[1].'", "'.$category.'"),';
        }

        if (!empty($value)) {
            $value = trim($value, ',');

            $insert = Db::getInstance()->Execute('
				INSERT INTO '._DB_PREFIX_.'blmod_xml_fields
				(`name`, `status`, `title_xml`, `table`, `category`)
				VALUE
				'.$value.'
			');
        }

        if ($insert) {
            $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Feed fields successfully updated').'</div>';
        } else {
            $this->_html .= '<div class="'.$this->setMessageStyle('warning').'"><img src="'.$this->moduleImgPath.'warning.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('error, insert fields values').'</div>';
        }
    }

    public function deleteFeed($feed_id = false)
    {
        if (empty($feed_id)) {
            return false;
        }

        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_block WHERE category = "'.$feed_id.'"');
        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_feeds WHERE id = "'.$feed_id.'"');
        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_fields WHERE category = "'.$feed_id.'"');
        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_statistics WHERE feed_id = "'.$feed_id.'"');

        $this->deleteCache($feed_id);

        $this->_html .= '<div class="'.$this->setMessageStyle('confirm').'"><img src="'.$this->moduleImgPath.'ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Deleted successfully').'</div>';
    }

    public function deleteCache($feed_id = false, $all_feeds = false)
    {
        if (empty($feed_id) && empty($all_feeds)) {
            return false;
        }

        $where = false;

        if (!empty($feed_id)) {
            $where = ' WHERE feed_id = "'.$feed_id.'"';
        }

        $cache = Db::getInstance()->ExecuteS('SELECT file_name FROM '._DB_PREFIX_.'blmod_xml_feeds_cache'.$where);

        if (!empty($cache)) {
            foreach ($cache as $c) {
                @unlink('../modules/xmlfeeds/xml_files/'.$c['file_name'].'.xml');
            }
        }

        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_feeds_cache'.$where);
    }

    public function onSpecial($v, $fieldName = '')
    {
        if ($fieldName == 'product_url_utm_blmod') {
            return $v;
        }

        return preg_replace('/[^a-zA-Z0-9_:\/-]/', '_', $v);
    }

    public function getRandProduct()
    {
        $random_product = Db::getInstance()->getRow('
			SELECT id_product
			FROM `'._DB_PREFIX_.'product_attribute`
			WHERE id_product != "0"
		');

        if (!empty($random_product['id_product'])) {
            return $random_product['id_product'];
        }

        return false;
    }

    public function getGroupedAttributesBox()
    {
        $groups = AttributeGroupCore::getAttributesGroups($this->shopLang);

        if (empty($groups)) {
            return false;
        }

        $html = '';
        $groupRow = array();

        foreach ($groups as $val) {
            $defaultName = $val['name'];
            $val['name'] = $this->onSpecial($val['name']);
            $groupRow[] = array('name' => $val['id_attribute_group'], 'title' => $defaultName, 'table' => 'bl_extra_attribute_group',);
        }

        $html .= $this->printBlock('Grouped attributes', $groupRow);

        return $html;
    }

    public function productFeatureBox()
    {
        $featureRow = array();
        $features = $this->productFeatureList();

        if (empty($features)) {
            return false;
        }

        $html = '';

        foreach ($features as $val) {
            $defaultName = $val['name'];
            $val['name'] = $this->onSpecial($val['name']);
            $featureRow[] = array('name' => $val['id_feature'], 'title' => $defaultName, 'table' => 'bl_extra_feature',);
        }

        $html .= $this->printBlock('Feature', $featureRow);

        return $html;
    }

    public function productFeatureList()
    {
        if (!class_exists('FeatureCore')) {
            return false;
        }

        $featureClass = new FeatureCore();
        $features = $featureClass->getFeatures($this->shopLang, true);

        if (empty($features)) {
            return false;
        }

        return $features;
    }

    public function getPHPExecutableFromPath()
    {
        $paths = explode(PATH_SEPARATOR, getenv('PATH'));

        foreach ($paths as $path) {
            //For windows
            if (strstr($path, 'php.exe') && isset($_SERVER['WINDIR']) && file_exists($path) && is_file($path)) {
                return $path;
            } else {
                $php_executable = $path.DIRECTORY_SEPARATOR.'php'.(isset($_SERVER['WINDIR']) ? '.exe' : '');

                if (file_exists($php_executable) && is_file($php_executable)) {
                    return $php_executable;
                }
            }
        }

        return false;
    }

    public function hideField($field, $table)
    {
        $version = 0;

        if (_PS_VERSION_ < 1.4) {
            $version = 13;
        }

        $fields = array();

        $fields[13] = array(
            'condition-product' => 1,
            'available_for_order-product' => 1,
        );

        if (empty($fields[$version])) {
            return false;
        }

        if (!empty($fields[$version][$field.'-'.$table])) {
            return true;
        }

        return false;
    }

    /**
     * Set message box style by PS version.
     *
     * @param string $type
     *
     * @return string
     */
    public function setMessageStyle($type)
    {
        switch ($type) {
            case 'warning':
                if (_PS_VERSION_ >= '1.6') {
                    return 'alert alert-warning';
                }

                return 'warning warn';
            case 'confirm':
                if (_PS_VERSION_ >= '1.6') {
                    return 'alert alert-success';
                }

                return 'conf confirm';
        }

        return 'warning warn';
    }

    private function getShopProtocol()
    {
        if (method_exists('Tools', 'getShopProtocol')) {
            return Tools::getShopProtocol();
        }

        $protocol = (Configuration::get('PS_SSL_ENABLED') || (!empty($_SERVER['HTTPS'])
                && Tools::strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
        return $protocol;
    }
}
