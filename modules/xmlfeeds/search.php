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

require(dirname(__FILE__).'/../../config/config.inc.php');

$s = Tools::getValue('s');

if (empty($s)) {
	die();
}

function highlight($needle, $haystack)
{
    $ind = stripos($haystack, $needle);
    $len = Tools::strlen($needle);

    if ($ind !== false) {
        return Tools::substr($haystack, 0, $ind) . '<span class="find_word">' . Tools::substr($haystack, $ind, $len) . '</span>' . highlight($needle, Tools::substr($haystack, $ind + $len));
    } else {
        return $haystack;
    }
}

$search_type = Tools::getValue('s_t');
$selected_products = trim(Tools::getValue('s_p'), ',');

$where_selected = false;
$moduleImgPath = '../modules/xmlfeeds/views/img/';

if (!empty($selected_products) && $selected_products != 'undefined') {
	$where_selected = ' AND l.id_product NOT IN ('.$selected_products.')';
}

if ($search_type == 'search_id') {
	$where = 'l.id_product = "'.$s.'"';
} else {
	$search_type = 'search_name';
	$where = 'l.name LIKE "%'.$s.'%"';
}

$id_lang = (int)(Configuration::get('PS_LANG_DEFAULT'));

$limit = 50;
$word_lenght = 100;

$products = Db::getInstance()->ExecuteS('
	SELECT DISTINCT(l.id_product), l.name, cl.name AS cat_name, i.id_image
	FROM '._DB_PREFIX_.'product_lang l
	LEFT JOIN '._DB_PREFIX_.'product p ON
	l.id_product = p.id_product
	LEFT JOIN '._DB_PREFIX_.'category_lang cl ON
	(p.id_category_default = cl.id_category AND cl.id_lang = "'.$id_lang.'")
	LEFT JOIN `'._DB_PREFIX_.'image` i ON
	(p.id_product = i.id_product AND i.`cover`= "1")
	WHERE '.$where.' AND l.id_lang = "'.$id_lang.'"'.$where_selected.'
	GROUP BY l.id_product
	ORDER BY l.name ASC
	LIMIT '.$limit
);

if (empty($products)) {
	return false;
}

echo '<ul class="search_list_autocomplite">';
$imageClassName = (!class_exists('ImageCore', false) || _PS_VERSION_ > '1.5.3') ?  'Image' : 'ImageCore';
$imgType = (_PS_VERSION_ >= '1.5.1') ? 'small_default' : 'small';
$url_type = Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://';
$image_info = array();

foreach ($products as $p) {
	if (Tools::strlen($p['name']) > $word_lenght) {
		$p['name'] = Tools::substr($p['name'], 0, $word_lenght) . '...';
	}

	$url = '';

	if ($search_type == 'search_name') {
		$p['name'] = highlight($s, $p['name']);
	}

	$cat_name = '';

	if (!empty($p['cat_name'])) {
		$cat_name = ', ' . $p['cat_name'];
	}

	$image_info['id_image'] = isset($p['id_image']) ? $p['id_image'] : false;
	$image_info['id_product'] = $p['id_product'];

	$product = new Product($p['id_product'], false, $id_lang);
    $imageClass = new $imageClassName($p['id_image']);
    $name = $imageClass->getExistingImgPath();
    $url = _PS_BASE_URL_._THEME_PROD_DIR_.$name.$imgType;

    if (!file_exists(_PS_PROD_IMG_DIR_.$name.$imgType)) {
        $url = _PS_BASE_URL_._THEME_PROD_DIR_.$name.'.jpg';
    }

	echo '<li class="search_p_list" id="search_p-'.$p['id_product'].'">
		<div class="search_drop_product" id="search_drop-'.$p['id_product'].'">
			<img src="'.$moduleImgPath.'delete.gif">
		</div>
		<div style="float: left;">
			<div style="float: left; width: 30px; margin-right: 2px;">
				<img style="width: 25px; height: 25px;" src="'.$url.'" />
			</div>
			<div style="float: left; width: 300px;" class="search_p_name">
				'.$p['name'] .'<br/>
				<span class="search_small_text">#'.$p['id_product'].$cat_name.'</span>
			</div>
		</div>
		<div class="blmod_cb"></div>
	</li>';
}

if (count($products) > $limit) {
	echo '<li>...</li>';
}

echo '</ul>';
die();
