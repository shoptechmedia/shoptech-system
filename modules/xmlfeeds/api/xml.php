<?php
/**
 * 2010-2018 Bl Modules.
 *
 * If you wish to customize this module for your needs,
 * please contact the authors first for more information.
 *
 * It's not allowed selling, reselling or other ways to share
 * this file or any other module files without author permission.
 *
 * @author    Bl Modules
 * @copyright 2010-2018 Bl Modules
 * @license
 */
define('_PS_MODE_DEV_', true);
require_once(dirname(__FILE__).'/../../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../../init.php'); //for cron unnecessary ??
require_once(_PS_ROOT_DIR_.'/modules/xmlfeeds/googlecategory.php');
require_once(_PS_MODULE_DIR_.'/xmlfeeds/ProductList.php');
require_once(_PS_MODULE_DIR_.'/xmlfeeds/ProductSettings.php');
require_once(_PS_MODULE_DIR_.'/xmlfeeds/FeedType.php');

const REPLACE_COMBINATION = 'BLMOD_REPLACE_COMBINATION;';

if (!defined('_PS_VERSION_')) {
    die('Not Allowed, api root');
}

$file_format = Tools::getValue('file_format');
if( !$file_format ){
    $file_format = 'xml';
}

/**
 * Reset currency id, for old PS
 */
global $cookie, $cart;

$cookie->id_cart = Configuration::get('PS_CURRENCY_DEFAULT');
$cart->id_currency = $cookie->id_cart;
$cookie->id_currency = $cookie->id_cart;

/**
 * Reset currency id, for new PS
 */
if (class_exists('Context', false)) {
    $context = Context::getContext();
    $context->currency = Configuration::get('PS_CURRENCY_DEFAULT');
}

$id = htmlspecialchars(Tools::getValue('id'), ENT_QUOTES);
$part = htmlspecialchars(Tools::getValue('part'), ENT_QUOTES);
$affiliate = htmlspecialchars(Tools::getValue('affiliate'), ENT_QUOTES);
$multistore = Tools::getValue('multistore');
$downloadAction = Tools::getValue('download');

if (!empty($argv[1])) {
    $id = $argv[1];
}

if (!empty($argv[2])) {
    $affiliate = $argv[2];
}

if (!empty($argv[3])) {
    $multistore = $argv[3];
}

if (!is_numeric($id)) {
    die('wrong id');
}

if ($affiliate == 'affiliate_name') {
    $affiliate = false;
}

if (!empty($multistore)) {
    $context->shop->id = (int)$multistore;
}

$check_affiliate = Db::getInstance()->getRow('SELECT `affiliate_name` FROM '._DB_PREFIX_.'blmod_xml_affiliate_price WHERE `affiliate_name` = "'.$affiliate.'"');

if (empty($check_affiliate['affiliate_name'])) {
    $affiliate_cache = false;
} else {
    $affiliate_cache = $affiliate;
}

$permissions = Db::getInstance()->getRow('
	SELECT f.*, c.file_name AS file_name_n, c.last_cache_time AS last_cache_time_n
	FROM '._DB_PREFIX_.'blmod_xml_feeds f
	LEFT JOIN '._DB_PREFIX_.'blmod_xml_feeds_cache c ON
	(f.id = c.feed_id AND c.feed_part = "'.$part.'" AND c.affiliate_name = "'.$affiliate_cache.'")
	WHERE f.id = "'.$id.'"
');

if (empty($permissions)) {
    die('empty settings');
}

$feed_name = 'archive_'.$id;

$permissions['use_cache'] = isset($permissions['use_cache']) ? $permissions['use_cache'] : false;
$permissions['cache_time'] = isset($permissions['cache_time']) ? $permissions['cache_time'] : false;
$permissions['last_cache_time'] = isset($permissions['last_cache_time_n']) ? $permissions['last_cache_time_n'] : '0000-00-00 00:00:00';
$permissions['use_password'] = isset($permissions['use_password']) ? $permissions['use_password'] : false;
$permissions['password'] = isset($permissions['password']) ? $permissions['password'] : false;
$permissions['status'] = isset($permissions['status']) ? $permissions['status'] : false;
$permissions['file_name'] = isset($permissions['file_name_n']) ? $permissions['file_name_n'] : false;
$permissions['html_tags_status'] = isset($permissions['html_tags_status']) ? $permissions['html_tags_status'] : false;
$permissions['one_branch'] = isset($permissions['one_branch']) ? $permissions['one_branch'] : false;
$permissions['header_information'] = isset($permissions['header_information']) ? htmlspecialchars_decode($permissions['header_information'], ENT_QUOTES) : false;
$permissions['footer_information'] = isset($permissions['footer_information']) ? htmlspecialchars_decode($permissions['footer_information'], ENT_QUOTES) : false;
$permissions['extra_feed_row'] = isset($permissions['extra_feed_row']) ? htmlspecialchars_decode($permissions['extra_feed_row'], ENT_QUOTES) : false;
$permissions['only_enabled'] = isset($permissions['only_enabled']) ? $permissions['only_enabled'] : false;
$permissions['split_feed'] = isset($permissions['split_feed']) ? $permissions['split_feed'] : false;
$permissions['split_feed_limit'] = isset($permissions['split_feed_limit']) ? $permissions['split_feed_limit'] : false;
$permissions['cat_list'] = isset($permissions['cat_list']) ? $permissions['cat_list'] : false;
$permissions['categories'] = isset($permissions['categories']) ? $permissions['categories'] : false;
$permissions['price_with_currency'] = isset($permissions['price_with_currency']) ? $permissions['price_with_currency'] : false;
$permissions['manufacturer_list'] = isset($permissions['manufacturer_list']) ? $permissions['manufacturer_list'] : false;
$permissions['manufacturer'] = isset($permissions['manufacturer']) ? $permissions['manufacturer'] : false;
$permissions['supplier_list'] = isset($permissions['supplier_list']) ? $permissions['supplier_list'] : false;
$permissions['supplier'] = isset($permissions['supplier']) ? $permissions['supplier'] : false;
$permissions['currency_id'] = isset($permissions['currency_id']) ? $permissions['currency_id'] : false;
$permissions['feed_generation_time'] = isset($permissions['feed_generation_time']) ? $permissions['feed_generation_time'] : false;
$permissions['feed_generation_time_name'] = isset($permissions['feed_generation_time_name']) ? $permissions['feed_generation_time_name'] : false;
$permissions['split_by_combination'] = isset($permissions['split_by_combination']) ? $permissions['split_by_combination'] : false;
$useCron = !empty($permissions['use_cron']) ? $permissions['use_cron'] : false;
$feed_type = isset($permissions['feed_type']) ? $permissions['feed_type'] : false;
$onlyInStock = !empty($permissions['only_in_stock']) ? $permissions['only_in_stock'] : false;
$priceRange = !empty($permissions['price_range']) ? $permissions['price_range'] : false;
$mode = !empty($permissions['feed_mode']) ? $permissions['feed_mode'] : false;
$allImages = !empty($permissions['all_images']) ? $permissions['all_images'] : false;
$productList = !empty($permissions['product_list']) ? $permissions['product_list'] : false;
$productListStatus = !empty($permissions['product_list_status']) ? $permissions['product_list_status'] : false;
$shippingCountry = !empty($permissions['shipping_country']) ? $permissions['shipping_country'] : false;
$filterDiscount = !empty($permissions['filter_discount']) ? $permissions['filter_discount'] : 0;
$filterCategoryType = !empty($permissions['filter_category_type']) ? $permissions['filter_category_type'] : 0;
$productSettingsPackageId = !empty($permissions['product_settings_package_id']) ? $permissions['product_settings_package_id'] : 0;
$taxRateList = array();

$priceRange = explode(';', $priceRange);
$priceRange = implode(';', $priceRange);

if ($useCron) {
    $permissions['split_feed'] = false;
}

if ($permissions['status'] != 1) {
    die('disabled');
}

if ($permissions['use_password'] == 1 && !empty($permissions['password']) && !$useCron) {
    $pass = Tools::getValue('password');

    if ($permissions['password'] != $pass) {
        die('wrong password');
    }
}

if (!$useCron) {
    insert_statistics($id, $affiliate);
}

$now = date('Y-m-d h:i:s');
$cache_period = date('Y-m-d h:i:s', strtotime($permissions['last_cache_time'].'+ '.$permissions['cache_time'].' minutes'));

function formatSVData($xml){
    $rows = [];
    $header = [];

    $c = 0;
    foreach ($xml->children() as $i => $item) {
        $hasChild = (count($item->children()) > 0) ? true:false;

        if(!$hasChild) {
        } else {
            $row = [];
            foreach ($item->children() as $name => $field) {
                $name = str_replace('__', ':', $name);

                if($c == 0){
                    $header[] = $name;
                }

                if(!empty($field)){
                    $field = (array) $field;

                    $value = '';
                    $count = 0;
                    foreach($field as $v){
                        if($count > 0)
                            $value .= ',';

                        $value .= (string) $v;

                        $count++;
                    }
                }else{
                    $value = (string) $field;
                }

                $value = str_replace("\n", '', $value);
                $value = str_replace("\t", '', $value);

                $row[$name] = $value;
            }

            $rows[] = $row;
        }

        $c++;
    }

    return array('rows' => $rows, 'header' => $header);
}

function createCSV($xml) {
    $rows = formatSVData($xml);

    foreach ($rows['header'] as $column) {
        echo $column;
        echo ";";
    }

    echo "\n";

    foreach ($rows['rows'] as $row) {

        foreach ($rows['header'] as $name) {
            echo @$row[$name];
            echo ";";
        }

        echo "\n";
    };
}

function createTSV($xml) {
    $rows = formatSVData($xml);

    foreach ($rows['header'] as $column) {
        echo $column;
        echo "\t";
    }

    echo "\n";

    foreach ($rows['rows'] as $row) {

        foreach ($rows['header'] as $name) {
            echo @$row[$name];
            echo "\t";
        }

        echo "\n";
    };
}

if(Tools::isSubmit('id_product'))
    $permissions['use_cache'] = false;

if ($permissions['use_cache'] && !$useCron) {
    $file_url = _PS_ROOT_DIR_.'/modules/xmlfeeds/xml_files/'.$permissions['file_name'].'.xml';

    if ($now < $cache_period) {
        if (!empty($permissions['file_name'])) {
            $xml = Tools::file_get_contents($file_url);
        }

        if (!empty($xml)) {
            header('Content-type: text/' . $file_format . ';charset:UTF-8');

            $download = Tools::getValue('download');

            if (!empty($downloadAction) || $file_format != 'xml') {
                header('Content-Disposition:attachment;filename='.$feed_name.'_feed.' . $file_format);
            }

            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . $xml;

            if($file_format != 'xml')
                $xml = simplexml_load_string($xml);

            if($file_format == 'xml')
                echo $xml;
            else if ($file_format == 'csv')
                createCSV($xml);
            else if ($file_format == 'tsv')
                createTSV($xml);

            die;
        }
    } else {
        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_feeds_cache WHERE `feed_id` = "'.$id.'" AND `affiliate_name` = "'.$affiliate_cache.'"');
        @unlink($file_url);
    }
}

if (!empty($permissions['cdata_status'])) {
    $pref_s = '<![CDATA[';
    $pref_e = ']]>';
} else {
    $pref_s = '';
    $pref_e = '';
}

$multistoreArray = array();
$multistoreString = false;

if (!empty($multistore)) {
    if ($multistore == 'auto') {
        $multistoreString = Context::getContext()->shop->id;
    } else {
        $multistoreArrayCheck = explode(',', $multistore);

        foreach ($multistoreArrayCheck as $m) {
            $mId = (int) $m;

            if (empty($mId)) {
                continue;
            }

            $multistoreArray[] = $mId;
        }

        $multistoreString = implode(',', $multistoreArray);
    }
}

function category($id = 0, $pref_s = '', $pref_e = '', $html_tags_status = false, $extra_feed_row = false, $one_branch = false, $only_enabled = false, $multistoreString = false)
{
    $block_name = array();
    $xml_name = array();
    $xml_name_l = array();
    $all_l_iso = array();

    $block_n = Db::getInstance()->ExecuteS('
		SELECT `name`, `value`
		FROM '._DB_PREFIX_.'blmod_xml_block
		WHERE category = "'.$id.'"
	');

    foreach ($block_n as $bn) {
        $block_name[$bn['name']] = $bn['value'];
    }

    $r = Db::getInstance()->ExecuteS('
		SELECT `name`, `status`, `title_xml`, `table`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND `table` != "lang" AND `table` != "category_lang" AND status = "1"
		ORDER BY `table` ASC
	');

    $field = '';

    if (!empty($r)) {
        foreach ($r as $f) {
            $field .= ' `'._DB_PREFIX_.$f['table'].'`.`'.$f['name'].'` AS '.$f['table'].'_'.$f['name'].' ,';
            $xml_name[$f['table'].'_'.$f['name']] = $f['title_xml'];
        }

        if (empty($field)) {
            exit;
        }

        $field = ','.trim($field, ',');
    }

    $where_only_actyve = '';

    if (!empty($only_enabled)) {
        $where_only_actyve = 'WHERE '._DB_PREFIX_.'category.active = "1"';
    }

    if (!empty($multistoreString)) {
        if (empty($where_only_actyve)) {
            $where_only_actyve = 'WHERE '._DB_PREFIX_.'category.id_shop_default IN ('.$multistoreString.')';
        } else {
            $where_only_actyve .= ' AND '._DB_PREFIX_.'category.id_shop_default IN ('.$multistoreString.')';
        }
    }

    $sql = '
		SELECT DISTINCT('._DB_PREFIX_.'category.id_category) AS cat_id '.$field.'
		FROM '._DB_PREFIX_.'category
		LEFT JOIN '._DB_PREFIX_.'category_group ON
		'._DB_PREFIX_.'category_group.id_category = '._DB_PREFIX_.'category.id_category '.
        $where_only_actyve;

    $xml_d = Db::getInstance()->ExecuteS($sql);

    //Language
    $l = Db::getInstance()->ExecuteS('
		SELECT `name`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND `table` = "lang"
	');

    $xml_lf = array();

    if (!empty($l)) {
        $l_where = '';
        $count_lang = count($l);

        foreach ($l as $ll) {
            $l_where .= 'OR '._DB_PREFIX_.'category_lang.id_lang='.$ll['name'].' ';
        }

        $l_where = trim($l_where, 'OR');

        $rl = Db::getInstance()->ExecuteS('
			SELECT `name`, `status`, `title_xml`
			FROM '._DB_PREFIX_.'blmod_xml_fields
			WHERE category = "'.$id.'" AND `table` = "category_lang" and status=1
		');

        $field = '';

        if (!empty($rl)) {
            foreach ($rl as $fl) {
                $field .= ' `'._DB_PREFIX_.'category_lang`.`'.$fl['name'].'`,';
                $xml_name_l[$fl['name']] = $fl['title_xml'];
            }

            $field = ','.trim($field, ',');
        }

        $xml_l = Db::getInstance()->ExecuteS('
			SELECT '._DB_PREFIX_.'category_lang.id_category, '._DB_PREFIX_.'lang.iso_code as blmodxml_l '.$field.'
			FROM '._DB_PREFIX_.'category_lang
			LEFT JOIN '._DB_PREFIX_.'lang ON
			'._DB_PREFIX_.'lang.id_lang = '._DB_PREFIX_.'category_lang.id_lang
			WHERE '.$l_where.'
			ORDER BY '._DB_PREFIX_.'category_lang.id_category ASC
		');

        foreach ($xml_l as $xll) {
            $id_cat = $xll['id_category'];
            $l_iso = $xll['blmodxml_l'];
            $all_l_iso[] = $l_iso;

            $lang_prefix = '-'.$l_iso;

            if ($count_lang < 2) {
                $lang_prefix = '';
            }

            if (empty($one_branch)) {
                $xml_lf[$id_cat.$l_iso] = '<'.$block_name['desc-block-name'].$lang_prefix.'>';
            } else {
                $xml_lf[$id_cat.$l_iso] = '';
            }

            foreach ($xll as $idl => $vall) {
                if ($idl == 'id_category' || $idl == 'blmodxml_l') {
                    continue;
                }

                $vall = isset($vall) ? $vall : false;

                if ($html_tags_status) {
                    $vall = strip_tags($vall);
                }

                $xml_lf[$id_cat.$l_iso] .= '<'.$xml_name_l[$idl].$lang_prefix.'>'.$pref_s.htmlspecialchars($vall).$pref_e.'</'.$xml_name_l[$idl].$lang_prefix.'>';
            }

            if (empty($one_branch)) {
                $xml_lf[$id_cat.$l_iso] .= '</'.$block_name['desc-block-name'].$lang_prefix.'>';
            }
        }

        $all_l_iso = array_unique($all_l_iso);
    }

    $xml = '<'.$block_name['file-name'].'>';
    $xml .= $extra_feed_row;

    foreach ($xml_d as $xdd) {
        $xml .= '<'.$block_name['cat-block-name'].'>';

        foreach ($xdd as $id => $val) {
            if ($id == 'cat_id') {
                continue;
            }

            $val = isset($val) ? $val : false;
            $xml .= '<'.$xml_name[$id].'>'.$pref_s.$val.$pref_e.'</'.$xml_name[$id].'>';
        }

        $id_cat = $xdd['cat_id'];

        if (!empty($all_l_iso)) {
            foreach ($all_l_iso as $iso) {
                $xml_lf[$id_cat.$iso] = isset($xml_lf[$id_cat.$iso]) ? $xml_lf[$id_cat.$iso] : false;
                $xml .= $xml_lf[$id_cat.$iso];
            }
        }

        $xml .= '</'.$block_name['cat-block-name'].'>';
    }

    $xml .= '</'.$block_name['file-name'].'>';

    return $xml;
}

function product(
    $permissions,
    $id,
    $pref_s,
    $pref_e,
    $html_tags_status,
    $extra_feed_row,
    $one_branch,
    $only_enabled,
    $split_feed_limit,
    $part,
    $categories,
    $cat_list,
    $multistoreString,
    $onlyInStock,
    $priceRange,
    $price_with_currency,
    $mode,
    $allImages,
    $affiliate,
    $currencyId,
    $feedGenerationTime,
    $feedGenerationTimeName,
    $splitByCombination,
    $productList,
    $productListStatus,
    $shippingCountry,
    $filterDiscount,
    $filterCategoryType,
    $productSettingsPackageId
) {
    global $currencyIso, $currencyIdConvert;

    $productListClass = new ProductList();
    $productSettings = new ProductSettings();

    $productSettingsList = $productSettings->getXmlByPackageId($productSettingsPackageId);

    $block_name = array();
    $block_status = array();
    $xml_name = array();
    $xml_name_l = array();
    $all_l_iso = array();
    $xml_cat_name = array();
    $xml_lf = array();
    $cover_i = array();
    $image_info = array();
    $priceFrom = false;
    $priceTo = false;

    $productId = htmlspecialchars(Tools::getValue('product_id'), ENT_QUOTES);

    if (!empty($priceRange)) {
        list($priceFrom, $priceTo) = explode(';', $priceRange);
    }

    $id_lang = Configuration::get('PS_LANG_DEFAULT');
    $url_type = Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://';

    $block_n = Db::getInstance()->ExecuteS('
		SELECT `name`, `value`, `status`
		FROM '._DB_PREFIX_.'blmod_xml_block
		WHERE category = "'.$id.'"
	');

    foreach ($block_n as $bn) {
        $block_name[$bn['name']] = $bn['value'];
        $block_status[$bn['name']] = $bn['status'];
    }

    $r = Db::getInstance()->ExecuteS('
		SELECT `name`, `status`, `title_xml`, `table`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND `table` != "lang" AND `table` != "img_blmod" AND `table` != "category_lang"
		AND `table` != "product_lang" AND `table` != "bl_extra" AND `table` != "bl_extra_att" AND status = "1"
		AND `table` != "bl_extra_feature" AND `table` != "bl_extra_attribute_group"
		ORDER BY `table` ASC
	');

    $field = '';

    foreach ($r as $f) {
        $field .= ' `'._DB_PREFIX_.$f['table'].'`.`'.$f['name'].'` AS '.$f['table'].'_'.$f['name'].' ,';
        $xml_name[$f['table'].'_'.$f['name']] = $f['title_xml'];
    }

    $extra_field = Db::getInstance()->ExecuteS('
		SELECT `name`, `title_xml`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND `table` = "bl_extra" AND status = "1"
	');

    if (empty($field) && empty($extra_field)) {
        die('empty field list');
    }

    if (!empty($field)) {
        $field = ','.trim($field, ',');
    }

    $where_only_active = '';
    $order = '';
    $limit = '';

    if (!empty($only_enabled)) {
        $where_only_active = 'WHERE '._DB_PREFIX_.'product.active = "1"';
    }

    if (!empty($split_feed_limit) && !empty($part)) {
        $order = ' ORDER BY '._DB_PREFIX_.'product.id_product ASC';
        $limit = ' LIMIT '.($split_feed_limit * --$part).','.$split_feed_limit;
    }

    $category_table = false;

    if (!empty($categories) && !empty($cat_list)) {
        if (empty($filterCategoryType)) {
            $category_table = '
                LEFT JOIN ' . _DB_PREFIX_ . 'category_product ON
                ' . _DB_PREFIX_ . 'category_product.id_product = ' . _DB_PREFIX_ . 'product.id_product ';

            $where_only_active .= whereType($where_only_active) . _DB_PREFIX_ . 'category_product.id_category IN (' . $cat_list . ')';
        } else {
            $category_table = 'INNER JOIN '._DB_PREFIX_.'category_product ON
                ('._DB_PREFIX_.'category_product.id_product = '._DB_PREFIX_.'product.id_product AND '._DB_PREFIX_.'category_product.id_category IN ('.$cat_list.'))';
        }
    }

    $multistoreJoin = '';
    $multistoreId = !empty($multistoreString) ? (int)$multistoreString : null;

    if (!empty($multistoreString)) {
        $multistoreJoin = ' INNER JOIN '._DB_PREFIX_.'product_shop ps ON
        (ps.id_product = '._DB_PREFIX_.'product.id_product AND ps.id_shop IN ('.$multistoreString.')) AND ps.`active` = "1" ';
    }

    if (!empty($permissions['manufacturer']) && !empty($permissions['manufacturer_list'])) {
        $where_only_active .= whereType($where_only_active)._DB_PREFIX_.'product.id_manufacturer IN ('.$permissions['manufacturer_list'].')';
    }

    if (!empty($permissions['supplier']) && !empty($permissions['supplier_list'])) {
        $where_only_active .= whereType($where_only_active)._DB_PREFIX_.'product.id_supplier IN ('.$permissions['supplier_list'].')';
    }

    if (!empty($productId)) {
        $where_only_active .= whereType($where_only_active)._DB_PREFIX_.'product.id_product = "'.$productId.'"';
    }

    if (!empty($productList) && !empty($productListStatus)) {
        $productListActive = $productListClass->getProductsByProductList($productList);
        $productListActive = !empty($productListActive) ? $productListActive : array('"none_id"');

        $where_only_active .= whereType($where_only_active)._DB_PREFIX_.'product.id_product IN ('.implode(',', $productListActive).')';
    }

    $sql = '
		SELECT DISTINCT('._DB_PREFIX_.'product.id_product) AS pro_id, '._DB_PREFIX_.'product.id_category_default AS blmod_cat_id, '._DB_PREFIX_.'product.price AS blmod_price'.$field.'
		FROM '._DB_PREFIX_.'product
		LEFT JOIN '._DB_PREFIX_.'manufacturer ON
		'._DB_PREFIX_.'manufacturer.id_manufacturer = '._DB_PREFIX_.'product.id_manufacturer
		'.$multistoreJoin.$category_table.$where_only_active.$order.$limit;

    $xmlWithoutKey = Db::getInstance()->ExecuteS($sql);

    $xml_d = array();

    foreach ($xmlWithoutKey as $p) {
        if(Tools::isSubmit('id_product') && $p['pro_id'] != Tools::getValue('id_product')){
            continue;
        }

        $xml_d[$p['pro_id']] = $p;
    }

    //Language
    $l = Db::getInstance()->ExecuteS('
		SELECT `name`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND `table` = "lang"
	');

    $googleCatMap = getGoogleCatMap($mode);
    $count_lang = 0;

    if (!empty($l)) {
        $count_lang = count($l);

        if ($count_lang < 2) {
            $id_lang = $l[0]['name'];
        }

        //Default category name
        $cat_name_status = Db::getInstance()->getRow('
			SELECT `name`, `status`, `title_xml`
			FROM '._DB_PREFIX_.'blmod_xml_fields
			WHERE category = "'.$id.'" AND `table` = "category_lang"
		');

        if (!empty($cat_name_status['status']) && !empty($cat_name_status['title_xml'])) {
            $l_where_cat = '';

            foreach ($l as $ll) {
                $l_where_cat .= 'OR c.`id_lang`='.$ll['name'].' ';
            }

            $l_where_cat = '('.trim($l_where_cat, 'OR').')';

            if (_PS_VERSION_ >= '1.5') {
                $l_where_cat .= ' AND id_shop = "'.(!empty($multistoreId) ? $multistoreId : "1").'"';
            }

            $cat_name = Db::getInstance()->ExecuteS('
				SELECT c.`id_category`, c.`name`, c.`id_lang`, l.iso_code
				FROM '._DB_PREFIX_.'category_lang c
				INNER JOIN '._DB_PREFIX_.'lang l ON
				l.id_lang = c.id_lang
				WHERE '.$l_where_cat.'
				ORDER BY c.`id_category`
			');

            if (!empty($cat_name)) {
                $cat_old = false;

                if ($count_lang < 2) {
                    foreach ($cat_name as $cn) {
                        if ($cat_old == $cn['id_category']) {
                            $xml_cat_name[$cn['id_category']] .= '<'.$cat_name_status['title_xml'].'>';
                        } else {
                            $xml_cat_name[$cn['id_category']] = '<'.$cat_name_status['title_xml'].'>';
                        }

                        if (!empty($googleCatMap[$cn['id_category']])) {
                            $cn['name'] = $googleCatMap[$cn['id_category']]['name'];
                        }

                        $xml_cat_name[$cn['id_category']] .= $pref_s.$cn['name'].$pref_e;
                        $xml_cat_name[$cn['id_category']] .= '</'.$cat_name_status['title_xml'].'>';

                        $cat_old = $cn['id_category'];
                    }
                } else {
                    foreach ($cat_name as $cn) {
                        if ($cat_old == $cn['id_category']) {
                            $xml_cat_name[$cn['id_category']] .= '<'.$cat_name_status['title_xml'].'-'.$cn['iso_code'].'>';
                        } else {
                            $xml_cat_name[$cn['id_category']] = '<'.$cat_name_status['title_xml'].'-'.$cn['iso_code'].'>';
                        }

                        if (!empty($googleCatMap[$cn['id_category']])) {
                            $cn['name'] = $googleCatMap[$cn['id_category']]['name'];
                        }

                        $xml_cat_name[$cn['id_category']] .= $pref_s.$cn['name'].$pref_e;
                        $xml_cat_name[$cn['id_category']] .= '</'.$cat_name_status['title_xml'].'-'.$cn['iso_code'].'>';

                        $cat_old = $cn['id_category'];
                    }
                }
            }
        } else {
            $xml_cat_name = array();
        }

        //Description
        $l_where = '';

        foreach ($l as $ll) {
            $l_where .= 'OR '._DB_PREFIX_.'product_lang.id_lang='.$ll['name'].' ';
        }

        $l_where = trim($l_where, 'OR');

        if (_PS_VERSION_ >= '1.5') {
            $l_where .= ' AND '._DB_PREFIX_.'product_lang.id_shop = "'.(!empty($multistoreId) ? $multistoreId : "1").'"';
        }

        $rl = Db::getInstance()->ExecuteS('
			SELECT `name`, `status`, `title_xml`
			FROM '._DB_PREFIX_.'blmod_xml_fields
			WHERE category = "'.$id.'" AND `table` = "product_lang" and status=1
		');

        $field = '';

        foreach ($rl as $fl) {
            $field .= ' `'._DB_PREFIX_.'product_lang`.`'.$fl['name'].'`,';
            $xml_name_l[$fl['name']] = $fl['title_xml'];
        }

        if (!empty($field)) {
            $field = ','.trim($field, ',');
        }

        $xml_l = Db::getInstance()->ExecuteS('
			SELECT '._DB_PREFIX_.'product_lang.id_product, '._DB_PREFIX_.'product_lang.description_short AS description_short_blmod, '._DB_PREFIX_.'lang.iso_code as blmodxml_l '.$field.'
			FROM '._DB_PREFIX_.'product_lang
			LEFT JOIN '._DB_PREFIX_.'lang ON
			'._DB_PREFIX_.'lang.id_lang = '._DB_PREFIX_.'product_lang.id_lang
			WHERE '.$l_where.'
			ORDER BY '._DB_PREFIX_.'product_lang.id_product ASC
		');

        $shortDescriptionList = array();

        if (!empty($xml_l) && !empty($field)) {
            foreach ($xml_l as $xll) {
                $id_cat = $xll['id_product'];
                $l_iso = $xll['blmodxml_l'];
                $all_l_iso[] = $l_iso;
                $lang_prefix = '-'.$l_iso;

                if ($count_lang < 2 && $mode != 'h') {
                    $lang_prefix = '';
                }

                if ($mode == 'h') {
                    $lang_prefix = getLanguageCodeLong(ltrim($lang_prefix, '-'));
                }

                $xml_lf[$id_cat.$l_iso] = '';

                foreach ($xll as $idl => $vall) {
                    if ($idl == 'id_product' || $idl == 'blmodxml_l' || ($mode != 'i' && $idl == 'description_short_blmod')) {
                        continue;
                    }

                    $vall = isset($vall) ? $vall : false;

                    if ($html_tags_status) {
                        $vall = strip_tags($vall);
                    }

                    if ($idl == 'name') {
                        if ($mode == 'i' && !empty($xml_d[$xll['id_product']]['manufacturer_name'])) {
                            $vall = $xml_d[$xll['id_product']]['manufacturer_name'].' '.$vall;
                        }

                        $vall .= REPLACE_COMBINATION.$idl;
                    }

                    if ($mode == 'i' && $idl == 'description_short_blmod') {
                        $shortDescriptionList[$xll['id_product']] = htmlspecialchars($vall);
                        continue;
                    }

                    if($idl == 'description'){
                        $vall = str_replace("\n", '', $vall);
                    }

                    $xml_lf[$id_cat.$l_iso] .= getDeepTagName($xml_name_l[$idl].$lang_prefix).'<![CDATA['.$vall.']]>'.getDeepTagName($xml_name_l[$idl].$lang_prefix, true);
                }

                if ($mode == 'r') {
                    $xml_lf[$id_cat.$l_iso] = '<Description><Language>'.$l_iso.'</Language>'.$xml_lf[$id_cat.$l_iso].'</Description>';
                }
            }

            $all_l_iso = array_unique($all_l_iso);
        }
    }

    //Images
    if (_PS_VERSION_ < '1.5') {
        $use_ps_images_class = false;
        $image_class_name = 'ImageCore';

        if (!class_exists($image_class_name, false)) {
            $image_class_name = 'Image';
        }

        $img_class = new $image_class_name();

        if (method_exists($img_class, 'getExistingImgPath')) {
            $use_ps_images_class = true;
        }
    } else {
        $use_ps_images_class = true;
    }

    if (_PS_VERSION_ > '1.5.3') {
        $image_class_name = 'Image';
    }

    $img_name_extra = false;

    if (_PS_VERSION_ >= '1.5.1' && _PS_VERSION_ < '1.3') {
        $img_name_extra = '_default';
    }

    $img = Db::getInstance()->ExecuteS('
		SELECT `name`, `title_xml`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND `table` = "img_blmod" AND status = "1"
	');

    $link_class = new Link();

    $product_class_name = 'ProductCore';

    if (!class_exists($product_class_name, false)) {
        $product_class_name = 'Product';
    }

    if (empty($allImages)) {
        $img_cover = Db::getInstance()->ExecuteS('
			SELECT `id_image`, `id_product`
			FROM '._DB_PREFIX_.'image
			WHERE cover = "1"
		');

        foreach ($img_cover as $c) {
            $cover_i[$c['id_product']] = $c['id_image'];
        }
    }

    $base_dir_img = _PS_BASE_URL_.__PS_BASE_URI__.'img/p/';

    if (!empty($block_status['file-name'])) {
        $xml = '<' . $block_name['file-name'] . '>';
    }

    if (!empty($feedGenerationTime) && !empty($feedGenerationTimeName)) {
        $xml .= '<'.$feedGenerationTimeName.'>'.date('Y-m-d H:i:s').'</'.$feedGenerationTimeName.'>';
    }

    $xml .= $extra_feed_row;

    //Get attributes
    $extra_attributes = Db::getInstance()->ExecuteS('
		SELECT `name`, `title_xml`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND `table` = "bl_extra_att" AND status = "1"
	');

    //Feature
    $featureEnable = false;
    $fieldFeature = array();
    $fieldGroupedAttributes = array();

    $extraFieldFeature = Db::getInstance()->ExecuteS('
		SELECT `name`, `title_xml`, `table`
		FROM '._DB_PREFIX_.'blmod_xml_fields
		WHERE category = "'.$id.'" AND (`table` = "bl_extra_feature" OR `table` = "bl_extra_attribute_group") AND status = "1"
	');

    if (!empty($extraFieldFeature)) {
        foreach ($extraFieldFeature as $f) {
            if ($f['table'] == 'bl_extra_feature') {
                $fieldFeature[$f['name']] = $f;
            } else if ($f['table'] == 'bl_extra_attribute_group') {
                $fieldGroupedAttributes[$f['name']] = $f;
            }
        }
    }

    if (method_exists($product_class_name, 'getFrontFeaturesStatic')) {
        $featureEnable = true;
    }

    //Shipping parameter
    $configuration = Configuration::getMultiple(
        array(
            'PS_LANG_DEFAULT',
            'PS_SHIPPING_FREE_PRICE',
            'PS_SHIPPING_HANDLING',
            'PS_SHIPPING_METHOD',
            'PS_SHIPPING_FREE_WEIGHT',
            'PS_CARRIER_DEFAULT',
            'PS_COUNTRY_DEFAULT',
        )
    );

    $shippingCountry = !empty($shippingCountry) ? $shippingCountry : $configuration['PS_COUNTRY_DEFAULT'];

    $defaultCountry = new Country($shippingCountry, $id_lang);
    $idZone = $defaultCountry->id_zone;

    $carrier = new Carrier($configuration['PS_CARRIER_DEFAULT']);

    $address = new Address();
    $address->id_country = $shippingCountry;
    $address->id_state = 0;
    $address->postcode = 0;

    $carrierTax = 0;

    if (_PS_VERSION_ >= '1.5') {
        $carrierTax = $carrier->getTaxCalculator($address)->getTotalRate();
    } elseif (class_exists('TaxManagerFactory', false)) {
        $tax_manager = TaxManagerFactory::getManager($address, $carrier->id_tax_rules_group);
        $carrierTax = $tax_manager->getTaxCalculator()->getTotalRate();
    }
    //END Shipping parameter

    $currencyIso = false;
    $currencyIdConvert = !empty($currencyId) ? $currencyId : false;
    $currencyId = !empty($currencyId) ? $currencyId : Configuration::get('PS_CURRENCY_DEFAULT');
    $feedCurrency = '';

    if (!empty($currencyId)) {
        $currencyClass = Currency::getCurrency($currencyId);
        $feedCurrency = ' '.$currencyClass['iso_code'];
    }

    if (!empty($price_with_currency) && !empty($feedCurrency)) {
        $currencyIso = $feedCurrency;
    }

    $availabilityName = getAvailabilityByMode($mode);
    $weightUnit = Configuration::get('PS_WEIGHT_UNIT');

    foreach ($xml_d as $xdd) {
        if (!empty($allImages)) {
            $img_all_images = Db::getInstance()->ExecuteS('
				SELECT `id_image`, `id_product`
				FROM '._DB_PREFIX_.'image
				WHERE id_product = "'.$xdd['pro_id'].'"
			');
        } else {
            $img_all_images[0]['id_image'] = isset($cover_i[$xdd['pro_id']]) ? $cover_i[$xdd['pro_id']] : false;
        }

        $product_class = new $product_class_name($xdd['pro_id'], false, $id_lang);
        $productQty = (int)$product_class->getQuantity($xdd['pro_id']);
        $salePrice = $product_class->getPriceStatic($xdd['pro_id'], true, null, 2);
        $basePrice = $product_class->price;
        $shippingPrice = getProductShippingCost($idZone, $product_class, $configuration, $carrier, $carrierTax);
        $priceWithoutDiscount = $product_class->getPriceStatic($xdd['pro_id'], true, null, 2, null, false, false);
        $combinationDefault = array();

        $id_shop = Context::getContext()->shop->id;

        if ($filterDiscount == 1 && number_format($salePrice, 2, '.', '') >= number_format($priceWithoutDiscount, 2, '.', '')) {
            continue;
        }

        if ($filterDiscount == 2 && number_format($salePrice, 2, '.', '') != number_format($priceWithoutDiscount, 2, '.', '')) {
            continue;
        }

        if ((!empty($priceFrom) && $salePrice < $priceFrom) || (!empty($priceTo) && $salePrice > $priceTo)) {
            continue;
        }

        if ($onlyInStock && $productQty < 1) {
            continue;
        }

        $xmlProduct = '<'.$block_name['cat-block-name'].'>';

        if (!empty($block_name['extra-product-rows'])) {
            $extraProductRows = htmlspecialchars_decode($block_name['extra-product-rows'], ENT_QUOTES);

            $extraProductRows = str_replace('{default_product_attribute}', $product_class->cache_default_attribute, $extraProductRows);

            $xmlProduct .= $extraProductRows;
        }

        foreach ($xdd as $id => $val) {
            if ($id == 'pro_id' || $id == 'blmod_cat_id' || $id == 'blmod_price' || $id == 'bl_extra_att') {
                continue;
            }

            if ($id == 'product_quantity') {
                $val = $productQty;
            }

            if ($id == 'product_id_category_default') {
                if (!empty($googleCatMap[$val])) {
                    $val = $googleCatMap[$val]['id'];
                }
            }

            $val = isset($val) ? $val : false;

            if ($id == 'product_available_for_order') {
                $val = $availabilityName['out'];

                if ($productQty > 0) {
                    $val = $availabilityName['in'];
                }
            }

            if ($id == 'product_price' || $id == 'product_wholesale_price' || $id == 'product_ecotax') {
                $val = getPriceFormat($val);
            }

            if ($id == 'product_price' && $mode == 'h') {
                $val = (int)($val * 100);
            }

            if ($id == 'product_weight' && $mode == 'r') {
                $val = (int)($val * 1000);
            }

            if ($id == 'product_reference' || $id == 'product_supplier_reference' || $id == 'product_quantity' || $id == 'product_ean13' || $id == 'product_id_product') {
                $valDefault = $val;
                $val = REPLACE_COMBINATION.str_replace('product_', '', $id);
                $combinationDefault[str_replace('product_', '', $id)] = $valDefault;
            }

            if ($id == 'product_price' && $mode == 'r') {
                $xmlProduct .= '<Price><Currency>'.$feedCurrency.'</Currency><VATRate>22</VATRate>';
            }

            if (($mode == 'g' || $mode == 'f') && $id == 'product_weight') {
                $val .= ' '.$weightUnit;
            }

            $xmlProduct .= getDeepTagName($xml_name[$id]).$pref_s.$val.$pref_e.getDeepTagName($xml_name[$id], true);

            if ($id == 'product_price' && $mode == 'r') {
                $xmlProduct .= '</Price>';
            }
        }

        if ($mode == 'g' || $mode == 'f') {
            if ((empty($xdd['manufacturer_name']) && empty($xdd['product_ean13'])) || (empty($xdd['manufacturer_name']) && empty($xdd['product_reference']))) {
                $xmlProduct .= '<g:identifier_exists>no</g:identifier_exists>';
            }
        }

        $id_cat = $xdd['pro_id'];
        $def_cat = isset($xdd['blmod_cat_id']) ? $xdd['blmod_cat_id'] : false;

        if (!empty($xml_lf)) {
            foreach ($all_l_iso as $iso) {
                $xml_lf[$id_cat.$iso] = isset($xml_lf[$id_cat.$iso]) ? $xml_lf[$id_cat.$iso] : false;
                $xmlProduct .= $xml_lf[$id_cat.$iso];
            }
        }

        $xmlImages = array();
        $xmlImagesUrl = array();
        $imageNumber = 0;
        $imageNumberReal = 0;

        if (!empty($img) && !empty($img_all_images[0]['id_image'])) {
            if (empty($one_branch)) {
                $xmlProduct .= getDeepTagName($block_name['img-block-name']);
            }

            if ($use_ps_images_class) {
                $xmlProduct .= REPLACE_COMBINATION.'image';
                foreach ($img as $i) {
                    foreach ($img_all_images as $all_img) {
                        $image_info['id_image'] = $all_img['id_image'];
                        $image_info['id_product'] = $xdd['pro_id'];

                        $link = new Link();
                        $img_dir_server = $link->getImageLink($product_class->link_rewrite, $image_info['id_product'].'-'.$image_info['id_image'], $i['name'].$img_name_extra);

                        if (!empty($img_dir_server) && Tools::substr($img_dir_server, 0, 4) != 'http') {
                            $img_dir_server = $url_type.$img_dir_server;
                        }

                        /**
                         * @var ImageCore
                         */
                        $img_class = new $image_class_name($image_info['id_image']);
                        $img_class->id = $image_info['id_image'];
                        $img_dir_file = _PS_PROD_IMG_DIR_.$img_class->getExistingImgPath().'-'.$i['name'].'.jpg';

                        if (file_exists($img_dir_file)) {
                            $imageNumberReal++;
                            if (empty($xmlImages[$image_info['id_image']])) {
                                $xmlImages[$image_info['id_image']] = '';
                            }

                            $imageNumber = $mode == 'h' ? $imageNumber+1 : '';

                            if ($imageNumberReal > 1 && ($mode == 'g' || $mode == 'f')) {
                                $i['title_xml'] = 'g:additional_image_link';
                            }

                            if ($mode == 'a') {
                                $img_dir_server = '<admarkt:image url="'.$img_dir_server.'"/>';
                            } else {
                                $img_dir_server = $pref_s.$img_dir_server.$pref_e;
                            }

                            if ($mode == 's' && $imageNumberReal > 1) {
                                $i['title_xml'] = 'additional_imageurl';
                            }

                            $xmlImages[$image_info['id_image']] .= getDeepTagName($i['title_xml'].$imageNumber).$img_dir_server.getDeepTagName($i['title_xml'].$imageNumber, true);
                            $xmlImagesUrl[] = $img_dir_server;
                        }
                    }
                }
            } else {
                foreach ($img as $i) {
                    foreach ($img_all_images as $all_img) {
                        $img_dir_file = $xdd['pro_id'] . '-' . $all_img['id_image'] . '-' . $i['name'] . '.jpg';

                        if (file_exists('img/p/' . $img_dir_file)) {
                            $img_dir = $base_dir_img . $img_dir_file;
                            $xmlProduct .= getDeepTagName($i['title_xml']) . $pref_s . $img_dir . $pref_e . getDeepTagName($i['title_xml'], true);
                        }
                    }
                }
            }

            if (empty($one_branch)) {
                $xmlProduct .= getDeepTagName($block_name['img-block-name'], true);
            }
        }

        if (!empty($xml_cat_name)) {
            if ((empty($one_branch) && $count_lang > 1) || $mode == 'x' || $mode == 'o') {
                $xmlProduct .= '<'.$block_name['def_cat-block-name'].'>';
            }

            $xmlProduct .= isset($xml_cat_name[$def_cat]) ? $xml_cat_name[$def_cat] : false;

            if ((empty($one_branch) && $count_lang > 1) || $mode == 'x' || $mode == 'o') {
                $xmlProduct .= '</'.$block_name['def_cat-block-name'].'>';
            }
        }

        $extraFieldByName = array();

        if (!empty($extra_field)) {
            $unitPriceRatio = $product_class->unit_price_ratio;

            if (empty($product_class->unit_price_ratio) || $product_class->unit_price_ratio < 0.00001) {
                $unitPriceRatio = 1;
            }

            foreach ($extra_field as $b_e) {
                if (empty($b_e['title_xml'])) {
                    continue;
                }

                $extraFieldByName[$b_e['name']] = $b_e['title_xml'];
            }

            foreach ($extra_field as $b_e) {
                if ($b_e['name'] == 'product_url_utm_blmod') {
                    continue;
                }

                if ($mode == 'r' && $b_e['name'] == 'price_sale_blmod') {
                    $xmlProduct .= '<Price><Currency>'.$feedCurrency.'</Currency>';
                }

                $xmlProduct .= getDeepTagName($b_e['title_xml']) . $pref_s;

                if ($b_e['name'] == 'price_shipping_blmod') {
                    $xmlProduct .= $shippingPrice;
                } elseif ($b_e['name'] == 'price_sale_blmod') {
                    $xmlProduct .= REPLACE_COMBINATION.'sale_blmod';
                    $combinationDefault['sale_blmod'] = getPriceFormat($salePrice);
                } elseif ($b_e['name'] == 'price_wt_discount_blmod') {
                    $xmlProduct .= getPriceFormat($priceWithoutDiscount);
                } elseif ($b_e['name'] == 'only_discount_blmod') {
                    $xmlProduct .= getPriceFormat($priceWithoutDiscount - $salePrice);
                } elseif ($b_e['name'] == 'discount_rate_blmod') {
                    $xmlProduct .= round((($priceWithoutDiscount - $salePrice) / $priceWithoutDiscount * 100), 0);
                } elseif ($b_e['name'] == 'product_url_blmod') {
                    $xmlProduct .= REPLACE_COMBINATION.'url';
                    $extraUrl = !empty($extraFieldByName['product_url_utm_blmod']) ? htmlspecialchars_decode($extraFieldByName['product_url_utm_blmod'], ENT_QUOTES) : '';
                    $combinationDefault['url'] = $link_class->getProductLink($product_class, null, null, null, $id_lang).$extraUrl;
                } elseif ($b_e['name'] == 'product_categories_tree') {
                    $xmlProduct .= getProductCategories($xdd['pro_id'], $id_lang, $def_cat);
                } elseif ($b_e['name'] == 'id_category_all') {
                    $xmlProduct .= getProductCategories($xdd['pro_id'], $id_lang, $def_cat, true);
                } elseif ($b_e['name'] == 'category_url') {
                    $xmlProduct .= $link_class->getCategoryLink($def_cat, null, $id_lang);
                } elseif ($b_e['name'] == 'unit') {
                    $xmlProduct .= $product_class->unity;
                } elseif ($b_e['name'] == 'unit_price') {
                    if (!empty($product_class->unity)) {
                        $xmlProduct .= getPriceFormat($salePrice / $unitPriceRatio);
                    } else {
                        $xmlProduct .= '';
                    }
                } elseif ($b_e['name'] == 'unit_price_e_tax') {
                    if (!empty($product_class->unity)) {
                        $xmlProduct .= getPriceFormat($product_class->price / $unitPriceRatio);
                    } else {
                        $xmlProduct .= '';
                    }
                } elseif ($b_e['name'] == 'tax_rate') {
                    $xmlProduct .= getProductTax($product_class->id_tax_rules_group);
                }

                $xmlProduct .= $pref_e . getDeepTagName($b_e['title_xml'], true);
            }
        }

        $attributesList = array();

        if (!empty($extra_attributes) || !empty($fieldGroupedAttributes)) {
            $attributesList = $product_class->getAttributesGroups($id_lang);
        }

        //Product feature
        if (!empty($featureEnable) && !empty($fieldFeature)) {
            $features = $product_class->getFrontFeaturesStatic($id_lang, $xdd['pro_id']);

            if (!empty($features)) {
                if ($mode == 'x') {
                    $xmlProduct .= '<TECHDATA>';
                }

                if ($mode == 'i') {
                    foreach ($features as $f) {
                        $xmlProduct .= '<s:attribute name="'.attributeName($f['name']).'">'.$pref_s.$f['value'].$pref_e.'</s:attribute>';
                    }
                }
               elseif ($mode == 'x') {
                    foreach ($features as $f) {
                        $xmlProduct .= '<PARAMETER name="'.attributeName($f['name']).'">'.$pref_s.$f['value'].$pref_e.'</PARAMETER>';
                    }
                }
               else {
                    $neededFieldFeature = $fieldFeature;
                    foreach ($features as $f) {
                        if (!empty($fieldFeature[$f['id_feature']])) {
                            if($f['id_feature'] == 14){
                                $f['value'] = substr(ucfirst($f['value']), 0, 1);;
                            }

                            $xmlProduct .= getDeepTagName($fieldFeature[$f['id_feature']]['title_xml']). $pref_s . $f['value'] . $pref_e . getDeepTagName($fieldFeature[$f['id_feature']]['title_xml'], true);

                            unset($neededFieldFeature[$f['id_feature']]);
                        }
                    }

                    foreach($neededFieldFeature as $f){
                        $xmlProduct .= getDeepTagName($f['title_xml']). $pref_s . '' . $pref_e . getDeepTagName($f['title_xml'], true);                        
                    }
               }

                if ($mode == 'x') {
                    $xmlProduct .= '</TECHDATA>';
                }
            }
        }

        $affiliate_prices = array();

        //Affiliate price
        if (!empty($affiliate)) {
            $affiliate_prices = Db::getInstance()->ExecuteS('
				SELECT `affiliate_name`, `affiliate_formula`, `xml_name`
				FROM '._DB_PREFIX_.'blmod_xml_affiliate_price
				WHERE `affiliate_name` = "'.$affiliate.'"
				ORDER BY affiliate_name ASC			
			');
        }

        if (!empty($affiliate_prices)) {
            $xmlProduct .= REPLACE_COMBINATION.'affiliate_price';
        }

        if (!empty($splitByCombination)) {
            $combinations = $product_class->getAttributesResume($id_lang, ' ', ', ');
        }

        if ($mode == 'h') {
            $xmlProduct .= '<Min_shipping>1</Min_shipping><Max_shipping>4</Max_shipping>';
        }

        if (!empty($productSettingsPackageId)) {
            $xmlProduct .= !empty($productSettingsList[$xdd['pro_id']]) ? $productSettingsList[$xdd['pro_id']] : $productSettingsList[ProductSettings::DEFAULT_SETTINGS_ID];
        }

        $prefix = _DB_PREFIX_;
        if (!empty($combinations)) {
            foreach ($combinations as $c) {
                if ($onlyInStock && $c['quantity'] < 1) {
                    continue;
                }

                $combinationProduct = replaceCombination($xmlProduct, $c, $xmlImages, $link_class, $product_class, $id_lang, $affiliate_prices, $shippingPrice, $mode);

                $combinationProduct .= getProductAttributeBranch($extra_attributes, $attributesList, $block_name, $one_branch, $c['id_product_attribute']);
                $combinationProduct .= getProductGroupedAttributeBranch($fieldGroupedAttributes, $attributesList, $c['id_product_attribute']);

                if(strpos($combinationProduct, '<product>') !== false){
                    $combinationProduct = str_replace('{id_product_attribute}', $c['id_product_attribute'], $combinationProduct);

                    $xml .= $combinationProduct;
                    $xml .= '</'.$block_name['cat-block-name'].'>';
                }
            }
        } else {
            if (!empty($affiliate_prices)) {
                $affiliatePrice = '';

                foreach ($affiliate_prices as $a_price) {
                    $affiliatePrice .= getDeepTagName($a_price['xml_name']).$pref_s.calculate_affiliate_prices($salePrice, $basePrice, $shippingPrice, $priceWithoutDiscount, $a_price['affiliate_formula']).$pref_e.getDeepTagName($a_price['xml_name'], true);
                }

                $xmlProduct = str_replace(REPLACE_COMBINATION.'affiliate_price', $affiliatePrice, $xmlProduct);
            }

            $xmlProduct .= getProductAttributeBranch($extra_attributes, $attributesList, $block_name, $one_branch);
            $xmlProduct .= getProductGroupedAttributeBranch($fieldGroupedAttributes, $attributesList);

            if(strpos($xmlProduct, '<product>') !== false){
                $xml .= replaceCombinationToEmpty($xmlProduct, $combinationDefault, $xmlImages, $product_class);

                if ($mode == 'h' && !empty($xmlImagesUrl)) {
                    $xml .= '<image_tree>'.implode('|', $xmlImagesUrl).'</image_tree>';
                }

                $xml .= '</'.$block_name['cat-block-name'].'>';
            }
        }
    }

    if (!empty($block_status['file-name'])) {
        $xml .= '</' . $block_name['file-name'] . '>';
    }

    return $xml;
}

function getProductTax($idTaxRulesGroup)
{
    global $taxRateList;

    if (isset($taxRateList[$idTaxRulesGroup])) {
        return $taxRateList[$idTaxRulesGroup];
    }

    $rate = Db::getInstance()->getValue('
        SELECT t.rate
        FROM '._DB_PREFIX_.'tax_rule tr
        LEFT JOIN '._DB_PREFIX_.'tax t ON
        t.id_tax = tr.id_tax
        WHERE tr.id_tax_rules_group = '.htmlspecialchars($idTaxRulesGroup, ENT_QUOTES).'
    ');

    $taxRateList[$idTaxRulesGroup] = $rate;

    return $rate;
}

function replaceCombination($xml, $combination, $images, $link_class, $product_class, $id_lang, $affiliate_prices, $shippingPrice, $mode)
{
    global $pref_s, $pref_e;

    $combinationCore = new CombinationCore();
    $combinationCore->id = $combination['id_product_attribute'];
    // $combinationImages = $combinationCore->getWsImages();
    $combinationImages = [];
    if(!Validate::isUnsignedId($product_class->id))
        return false;

    $combinationSalePrice = $product_class->getPriceStatic($product_class->id, true, $combination['id_product_attribute'], 2);
    $priceWithoutDiscount = $product_class->getPriceStatic($product_class->id, true, $combination['id_product_attribute'], 2, null, false, false);

    $xml = str_replace(REPLACE_COMBINATION.'quantity', (int)$combination['quantity'], $xml);
    $xml = str_replace(REPLACE_COMBINATION.'ean13', $combination['ean13'], $xml);
    $xml = str_replace(REPLACE_COMBINATION.'supplier_reference', $combination['supplier_reference'], $xml);
    $xml = str_replace(REPLACE_COMBINATION.'reference', $combination['reference'], $xml);
    $xml = str_replace(REPLACE_COMBINATION.'name', '', $xml);
    $xml = str_replace(REPLACE_COMBINATION.'url', $link_class->getProductLink($product_class, null, null, null, $id_lang, null, $combination['id_product_attribute']), $xml);
    $xml = str_replace(REPLACE_COMBINATION.'sale_blmod', getPriceFormat($combinationSalePrice), $xml);
    $xml = str_replace(REPLACE_COMBINATION.'id_product', $product_class->id, $xml);

    $imagesXml = '';
    $combinationImagesList = array();

    if (!empty($combinationImages)) {
        foreach ($combinationImages as $imageId) {
            if (empty($images[$imageId['id']])) {
                continue;
            }

            $combinationImagesList[] = $images[$imageId['id']];
        }

        if (!empty($combinationImagesList)) {
            foreach ($combinationImagesList as $c) {
                if ($mode == 's') {
                    $c = empty($imagesXml) ? str_replace('additional_imageurl>', 'image>', $c) : str_replace('image>', 'additional_imageurl>', $c);
                }

                $imagesXml .= $c;
            }
        }
    } else {
        if (!empty($images)) {
            foreach ($images as $i) {
                $imagesXml .= $i;
            }
        }
    }

    $xml = str_replace(REPLACE_COMBINATION.'image', $imagesXml, $xml);

    if (!empty($affiliate_prices)) {
        $affiliatePrice = '';

        foreach ($affiliate_prices as $a_price) {
            $affiliatePrice .= getDeepTagName($pref_s).calculate_affiliate_prices($combinationSalePrice, $product_class->price, $shippingPrice, $priceWithoutDiscount, $a_price['affiliate_formula']).$pref_e.getDeepTagName($a_price['xml_name'], true);
        }

        $xml = str_replace(REPLACE_COMBINATION.'affiliate_price', $affiliatePrice, $xml);
    }

    return $xml;
}

function replaceCombinationToEmpty($xml, $combination, $images, $product_class)
{
    $xml = str_replace(REPLACE_COMBINATION.'quantity', !empty($combination['quantity']) ? (int)$combination['quantity'] : 0, $xml);
    $xml = str_replace(REPLACE_COMBINATION.'ean13', !empty($combination['ean13']) ? $combination['ean13'] : '', $xml);
    $xml = str_replace(REPLACE_COMBINATION.'supplier_reference', !empty($combination['supplier_reference']) ? $combination['supplier_reference'] : '', $xml);
    $xml = str_replace(REPLACE_COMBINATION.'reference', !empty($combination['reference']) ? $combination['reference'] : '', $xml);
    $xml = str_replace(REPLACE_COMBINATION.'name', '', $xml);
    $xml = str_replace(REPLACE_COMBINATION.'url', !empty($combination['url']) ? $combination['url'] : '', $xml);
    $xml = str_replace(REPLACE_COMBINATION.'sale_blmod', getPriceFormat(!empty($combination['sale_blmod']) ? $combination['sale_blmod'] : 0), $xml);
    $xml = str_replace(REPLACE_COMBINATION.'id_product', $product_class->id, $xml);

    $imagesXml = '';

    if (!empty($images)) {
        foreach ($images as $image) {
            $imagesXml .= $image;
        }
    }

    $xml = str_replace(REPLACE_COMBINATION.'image', $imagesXml, $xml);

    return $xml;
}

function getProductGroupedAttributeBranch($fieldGroupedAttributes, $attributesList, $id_product_attribute = 0)
{
    global $pref_s, $pref_e;

    $xmlProduct = '';

    if (!empty($fieldGroupedAttributes) && !empty($attributesList)) {
        $attributeByGroup = array();

        foreach ($attributesList as $a) {
            if (empty($a['quantity'])) {
                // continue;
            }

            if (!empty($id_product_attribute)) {
                if ($id_product_attribute != $a['id_product_attribute']) {
                    continue;
                }
            }

            $attributeByGroup[$a['id_attribute_group']][] = $a['attribute_name'];
        }

        foreach ($fieldGroupedAttributes as $ag) {
            $attributeByGroup[$ag['name']] = !empty($attributeByGroup[$ag['name']]) ? $attributeByGroup[$ag['name']] : array();

            if(!$attributeByGroup[$ag['name']])
                continue;

            if(strpos($xmlProduct, getDeepTagName($ag['title_xml'])) !== false)
                continue;

            $xmlProduct .= getDeepTagName($ag['title_xml']).$pref_s.implode(', ', array_unique($attributeByGroup[$ag['name']])).$pref_e.getDeepTagName($ag['title_xml'], true);
        }
    }

    return $xmlProduct;
}

function getProductAttributeBranch($extra_attributes, $attributesList, $block_name, $one_branch, $id_product_attribute = 0)
{
    global $pref_s, $pref_e;

    $xmlProduct = '';

    if (!empty($extra_attributes) && !empty($attributesList)) {
        if (empty($one_branch)) {
            $xmlProduct .= '<'.$block_name['attributes-block-name'].'>';
        }

        $nr = 0;

        foreach ($attributesList as $ag) {
            if (!empty($id_product_attribute)) {
                if ($id_product_attribute != $ag['id_product_attribute']) {
                    continue;
                }
            }

            ++$nr;

            if (empty($one_branch)) {
                $xmlProduct .= '<'.$block_name['attributes-block-name'].'-'.$nr.'>';
            }

            foreach ($extra_attributes as $a) {
                $xmlProduct .= getDeepTagName($a['title_xml']).$pref_s.$ag[$a['name']].$pref_e.getDeepTagName($a['title_xml'], true);
            }

            if (empty($one_branch)) {
                $xmlProduct .= '</'.$block_name['attributes-block-name'].'-'.$nr.'>';
            }
        }

        if (empty($one_branch)) {
            $xmlProduct .= '</'.$block_name['attributes-block-name'].'>';
        }
    }

    return $xmlProduct;
}

function attributeName($n)
{
    $n = trim($n, ':');

    return $n;
}

function getPriceFormat($price = 0)
{
    global $currencyIso, $currencyIdConvert;

    $currency = new Currency($currencyIdConvert);

    if (!empty($currencyIdConvert)) {
        $price = $price * $currency->conversion_rate;
        // $price = Tools::convertPrice($price, $currencyIdConvert);
    }

    /*if($price < 299)
        return false;*/

    /*if(strpos($price, '.') !== false){
        $split = explode('.', $price);

        if(strlen($split[1]) < 2){
            $split[1] .= '0';
        }

        $price = $split[0] . substr($split[1], 0, 2);
    }else{
        $price .= '00';
    }*/

    return Tools::ps_round($price, 2).$currencyIso;
}

function whereType($type)
{
    if (!empty($type)) {
        return ' AND ';
    }

    return ' WHERE ';
}

function calculate_affiliate_prices($salePrice = 0, $basePrice = 0, $shippingPrice = 0, $priceWithoutDiscount = 0, $formula = false)
{
    if (empty($salePrice)) {
        return getPriceFormat('0.00');
    }

    if (empty($formula)) {
        return getPriceFormat('0.00');
    }

    list($shippingPrice) = explode(' ', $shippingPrice);

    $formula = str_replace('price_without_discount', $priceWithoutDiscount, $formula);
    $formula = str_replace('base_price', $basePrice, $formula);
    $formula = str_replace('sale_price', $salePrice, $formula);
    $formula = str_replace('shipping_price', $shippingPrice, $formula);
    $formula = str_replace('tax_price', ($salePrice - $basePrice), $formula);
    $formula = str_replace('price', $salePrice, $formula);

    $new_price = create_function(false, 'return '.$formula.';');

    return getPriceFormat(number_format($new_price(), 2, '.', ''));
}

function create_split_xml_product($only_enabled = false, $limit = 5000, $page = 1, $use_password = false, $password = false, $affiliate = false, $multistoreString = false)
{
    $where_only_actyve = '';

    if (!empty($only_enabled)) {
        $where_only_actyve = 'WHERE '._DB_PREFIX_.'product.active = "1"';
    }

    $sql = '
		SELECT COUNT('._DB_PREFIX_.'product.id_product) AS c
		FROM '._DB_PREFIX_.'product
		'.$where_only_actyve;

    $product_total = Db::getInstance()->getRow($sql);
    $parts = 1;

    if ($product_total['c'] > $limit) {
        $parts = ceil($product_total['c'] / $limit);
    }

    $pass_in_link = (!empty($use_password) && !empty($password)) ? '&password='.$password : '';

    if (!empty($affiliate)) {
        $pass_in_link .= '&affiliate='.$affiliate;
    }

    $multistoreUrl = !empty($multistoreString) ? '&multistore='.$multistoreString : '';

    $link = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/xmlfeeds/api/xml.php?id='.$page.$pass_in_link.$multistoreUrl.'&part=';

    $xml = '<feeds>';
    $xml .= '<feeds_total><![CDATA['.$parts.']]></feeds_total>';

    for ($i = 1; $i <= $parts; ++$i) {
        $xml .= '<feed_'.$i.'><![CDATA['.$link.$i.']]></feed_'.$i.'>';
    }

    $xml .= '</feeds>';

    return $xml;
}

$xml = '';

if ($feed_type == 1) {
    if (empty($part) && !empty($permissions['split_feed']) && !empty($permissions['split_feed_limit'])) {
        $xml = create_split_xml_product(
            $permissions['only_enabled'],
            $permissions['split_feed_limit'],
            $id,
            $permissions['use_password'],
            $permissions['password'],
            $affiliate,
            $multistoreString
        );
    } else {
        $xml = product(
            $permissions,
            $id,
            $pref_s,
            $pref_e,
            $permissions['html_tags_status'],
            $permissions['extra_feed_row'],
            $permissions['one_branch'],
            $permissions['only_enabled'],
            $permissions['split_feed_limit'],
            $part,
            $permissions['categories'],
            $permissions['cat_list'],
            $multistoreString,
            $onlyInStock,
            $priceRange,
            $permissions['price_with_currency'],
            $mode,
            $allImages,
            $affiliate,
            $permissions['currency_id'],
            $permissions['feed_generation_time'],
            $permissions['feed_generation_time_name'],
            $permissions['split_by_combination'],
            $productList,
            $productListStatus,
            $shippingCountry,
            $filterDiscount,
            $filterCategoryType,
            $productSettingsPackageId
        );
    }
} elseif ($feed_type == 2) {
    $xml = category(
        $id,
        $pref_s,
        $pref_e,
        $permissions['html_tags_status'],
        $permissions['extra_feed_row'],
        $permissions['one_branch'],
        $permissions['only_enabled'],
        $multistoreString
    );
}

$xml = $permissions['header_information'].$xml.$permissions['footer_information'];

if ($permissions['use_cache']) {
    if ($now > $cache_period) {
        if (empty($check_affiliate['affiliate_name'])) {
            $affiliate = false;
        }

        $create_name = '';

        if (empty($permissions['file_name'])) {
            $permissions['file_name'] = md5(md5(rand(99999, 99999999)));
            $create_name = 'file_name="'.$permissions['file_name'].'", ';
        }

        $affiliate_name = false;

        if (!empty($affiliate)) {
            $affiliate_name = '_'.$affiliate;
        }

        $file_url = _PS_ROOT_DIR_.'/modules/xmlfeeds/xml_files/'.$permissions['file_name'].$affiliate_name.'.xml';
        file_put_contents($file_url, $xml);

        if (file_exists($file_url)) {
            Db::getInstance()->Execute('
				INSERT INTO '._DB_PREFIX_.'blmod_xml_feeds_cache
				(`feed_id`, `feed_part`, `file_name`, `last_cache_time`, `affiliate_name`)
				VALUES
				("'.$id.'", "'.$part.'", "'.$permissions['file_name'].$affiliate_name.'", "'.$now.'", "'.$affiliate.'")
			');
        }
    }
}

if ($useCron) {
    $file_url = _PS_ROOT_DIR_.'/modules/xmlfeeds/xml_files/feed_'.$id.(!empty($affiliate) ? '_'.$affiliate : '').'.xml';
    file_put_contents($file_url, $xml);

    Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'blmod_xml_feeds SET `last_cron_date` = "'.date('Y-m-d H:i:s').'" WHERE id = "'.$id.'"');

    die('done');
}

function insert_statistics($feed_id = false, $affiliate = false)
{
    Db::getInstance()->Execute('
		INSERT INTO '._DB_PREFIX_.'blmod_xml_statistics
		(`feed_id`, `affiliate_name`, `date`, `ip_address`)
		VALUES
		("'.$feed_id.'", "'.$affiliate.'", "'.date('Y-m-d H:i:s').'", "'.get_ip().'")
	');

    Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'blmod_xml_feeds SET total_views = total_views + 1 WHERE id = "'.$feed_id.'"');
}

function getProductCategories($productId, $langId = false, $defaultCatId = 0, $returnId = false)
{
    $separator = ' > ';
    $list = array();
    $fieldName = 'name';

    if ($returnId) {
        $fieldName = 'id_category';
        $separator = ',';
    }

    if (!empty($defaultCatId)) {
        $categoryDefault = new Category($defaultCatId, $langId);
        $list = array();

        foreach ($categoryDefault->getAllParents() as $category) {
            if ($category->id_parent != 0 && !$category->is_root_category) {
                $list[] = $category->$fieldName;
            }
        }

        if (!$categoryDefault->is_root_category) {
            if ($category->id_parent != 0 && !$category->is_root_category) {
                $list[] = $categoryDefault->$fieldName;
            }
        }
    }

    if (!empty($list)) {
        return implode($separator, $list);
    }

    $categories = Db::getInstance()->executeS('
        SELECT DISTINCT(p.id_category), l.name
        FROM '._DB_PREFIX_.'category_product p
        LEFT JOIN '._DB_PREFIX_.'category c ON
        p.id_category = c.id_category
        LEFT JOIN '._DB_PREFIX_.'category_lang l ON
        (p.id_category = l.id_category AND l.id_lang = "'.$langId.'")
        WHERE p.id_product = "'.$productId.'" AND c.level_depth != "0"
        ORDER BY c.level_depth ASC
    ');

    if (empty($categories)) {
        return false;
    }

    foreach ($categories as $c) {
        $list[] = $c[$fieldName];
    }

    return implode($separator, $list);
}

function getProductShippingCost($idZone, $Product, $configuration, $carrier, $carrierTax)
{
    if ($carrier->getShippingMethod() == Carrier::SHIPPING_METHOD_WEIGHT) {
        $shipping_cost = $carrier->getDeliveryPriceByWeight($Product->weight, $idZone);
    } elseif ($carrier->getShippingMethod() == Carrier::SHIPPING_METHOD_PRICE) {
        $shipping_cost = $carrier->getDeliveryPriceByPrice($Product->price, $idZone);
    } elseif ($carrier->getShippingMethod() == Carrier::SHIPPING_METHOD_FREE) {
        return 0;
    }

    $shipping_cost *= 1 + ($carrierTax / 100);
    $shipping_cost += $carrier->shipping_handling ? $configuration['PS_SHIPPING_HANDLING'] : 0;

    return getPriceFormat($shipping_cost);
}

function getGoogleCatMap($mode)
{
    $feedType = new FeedType();
    $type = $feedType->getType($mode);

    if (empty($type['category_name'])) {
        return array();
    }

    $googleCategory = new GoogleCategoryBlMod($type['category_name']);
    $googleCategories = $googleCategory->getList();

    $categoriesMap = Db::getInstance()->ExecuteS('
        SELECT `category_id`, `g_category_id`
        FROM '._DB_PREFIX_.'blmod_xml_g_cat 
        WHERE type = "'.$type['category_name'].'"
    ');

    if (empty($categoriesMap)) {
        return array();
    }

    $googleCategoriesMap = array();

    foreach ($categoriesMap as $m) {
        if ($mode == 'a') {
            $googleCategoriesMap[$m['category_id']] = array(
                'id' => $m['g_category_id'],
                'name' => $m['g_category_id'],
            );

            continue;
        }

        $googleCategoriesMap[$m['category_id']] = array(
            'id' => $m['g_category_id'],
            'name' => isset($googleCategories[$m['g_category_id']]) ? $googleCategories[$m['g_category_id']] : '',
        );
    }

    return $googleCategoriesMap;
}

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function getAvailabilityByMode($mode = false)
{
    $names = array(
        's' => array(
            'in' => 'Available in store / Delivery 1 to 3 days',
            'out' => 'Delivery 4 to 10 days',
        ),
        'x' => array(
            'in' => '1',
            'out' => '0',
        ),
        'r' => array(
            'in' => 'INSTOCK',
            'out' => 'OUTOFSTOCK',
        ),
        'o' => array(
            'in' => 'Skladem',
            'out' => 'Skladem za 14 dní',
        ),
    );

    if (!empty($names[$mode])) {
        return $names[$mode];
    }

    return array(
        'in' => 'in stock',
        'out' => 'out of stock',
    );
}

function getLanguageCodeLong($code = '')
{
    $list = array(
        'lt' => 'lit',
        'en' => 'eng',
        'es' => 'spa',
        'ru' => 'rus',
        'fr' => 'fra',
        'lv' => 'lav',
    );

    return !empty($list[$code]) ? $list[$code] : $code;
}

function getDeepTagName($tag = '', $close = false)
{
    $tags = explode('/', $tag);
    $list = '';

    if ($close) {
        $tags = array_reverse($tags);
    }

    foreach ($tags as $t) {
        $list .= '<'.($close ? '/' : '').$t.'>';
    }

    return $list;
}

header('Content-type: text/' . $file_format . ';charset:UTF-8');

if (!empty($downloadAction) || $file_format != 'xml') {
    header('Content-Disposition:attachment;filename='.$feed_name.'_feed.' . $file_format);
}

$xml = '<?xml version="1.0" encoding="UTF-8"?>' . $xml;
if($file_format != 'xml')
    $xml = simplexml_load_string($xml);

if($file_format == 'xml')
    echo $xml;
else if ($file_format == 'csv')
    createCSV($xml);
else if ($file_format == 'tsv')
    createTSV($xml);
die;
