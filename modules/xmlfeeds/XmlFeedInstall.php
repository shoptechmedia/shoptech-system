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
    exit;
}

class XmlFeedInstall
{
    public function installModuleSql()
    {
        $sql_blmod_block = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_block
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
				`value` varchar(3000) CHARACTER SET utf8 DEFAULT NULL,
				`status` tinyint(1) NOT NULL DEFAULT "1",
				`category` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			)';
        $sql_blmod_block_res = Db::getInstance()->Execute($sql_blmod_block);

        $sql_blmod_block_val = 'INSERT INTO '._DB_PREFIX_.'blmod_xml_block
			(`id`, `name`, `value`, `status`, `category`)
			VALUES
			(49, "desc-block-name", "descriptions", 1, 2),
			(48, "cat-block-name", "category", 1, 2),
			(47, "file-name", "categories", 1, 2),
			(53, "img-block-name", "images", 1, 1),
			(52, "desc-block-name", "descriptions", 1, 1),
			(51, "cat-block-name", "product", 1, 1),
			(50, "file-name", "products", 1, 1),
			(54, "def_cat-block-name", "default_category", 1, 1),
			(55, "attributes-block-name", "attributes", 1, 1)';
        Db::getInstance()->Execute($sql_blmod_block_val);

        $sql_blmod_feeds = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_feeds
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
				`use_cache` tinyint(1) DEFAULT NULL,
				`cache_time` int(5) DEFAULT NULL,
				`use_password` tinyint(1) DEFAULT NULL,
				`password` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
				`status` tinyint(1) DEFAULT NULL,
				`cdata_status` tinyint(1) DEFAULT NULL,
				`html_tags_status` tinyint(1) DEFAULT NULL,
				`one_branch` tinyint(1) DEFAULT NULL,
				`header_information` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
				`footer_information` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
				`extra_feed_row` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
				`feed_type` tinyint(2) DEFAULT NULL,
				`only_enabled` tinyint(1) DEFAULT NULL,		
				`split_feed` tinyint(1) DEFAULT NULL,
				`split_feed_limit` int(6) DEFAULT NULL,
				`cat_list` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
				`categories` tinyint(1) DEFAULT NULL,
				`total_views` int(11) NOT NULL DEFAULT "0",
				`use_cron` tinyint(1) DEFAULT NULL,
				`last_cron_date` datetime DEFAULT NULL,
				`only_in_stock` tinyint(1) DEFAULT NULL,
				`manufacturer_list` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
				`manufacturer` tinyint(1) DEFAULT NULL,
				`supplier_list` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
				`supplier` tinyint(1) DEFAULT NULL,
				`attribute_as_product` tinyint(1) DEFAULT NULL,
				`price_range` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
				`price_with_currency` tinyint(1) DEFAULT NULL,
				`all_images` tinyint(1) DEFAULT NULL,
				`feed_mode` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
				`currency_id` int(11) NOT NULL DEFAULT "0",
				`feed_generation_time` tinyint(1) DEFAULT NULL,
				`feed_generation_time_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
				`split_by_combination` tinyint(1) DEFAULT NULL,
				`product_list` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
				`product_list_status` tinyint(1) DEFAULT NULL,
				`shipping_country` int(11) NOT NULL DEFAULT "0",
				`filter_discount` tinyint(2) NOT NULL DEFAULT "0",
				`filter_category_type` tinyint(1) NOT NULL DEFAULT "0",
				`product_settings_package_id` int(11) NOT NULL DEFAULT "0",
				PRIMARY KEY (`id`)
			)';
        $sql_blmod_feeds_res = Db::getInstance()->Execute($sql_blmod_feeds);

        $sql_blmod_feeds_val = 'INSERT INTO '._DB_PREFIX_.'blmod_xml_feeds
		(`id`, `name`, `use_cache`, `cache_time`, `use_password`, `password`, `status`, `cdata_status`, `html_tags_status`,
		`header_information`, `footer_information`, `extra_feed_row`, `feed_type`, `only_enabled`, `split_feed`,
		`split_feed_limit`, `feed_mode`)
		VALUES
		(1, "Products", 1, 800, 0, "", 1, 1, 1,"","", "", 1, 0, 0, 500, "c"),
		(2, "Categories", 1, 1440, 0, "", 1, 1, 1, "", "","", 2, 0, 0, 0, "")';
        Db::getInstance()->Execute($sql_blmod_feeds_val);

        $sql_blmod_fields = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_fields
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
				`status` tinyint(1) DEFAULT NULL,
				`title_xml` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
				`table` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
				`category` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			)';
        $sql_blmod_fields_res = Db::getInstance()->Execute($sql_blmod_fields);

        $sql_blmod_cache = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_feeds_cache
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`feed_id` int(11) NOT NULL,
				`feed_part` int(11) NOT NULL DEFAULT "0",
				`file_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
				`last_cache_time` datetime DEFAULT NULL,
				`affiliate_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
				PRIMARY KEY (`id`)
			)';
        $sql_blmod_cache_res = Db::getInstance()->Execute($sql_blmod_cache);

        $sql_blmod_statistics = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_statistics
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`feed_id` int(11) NOT NULL,
				`affiliate_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
				`date` datetime DEFAULT NULL,
				`ip_address` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
				PRIMARY KEY (`id`)
			)';
        $sql_blmod_statistics_res = Db::getInstance()->Execute($sql_blmod_statistics);

        $this->installDefaultFeedProductSettings(1);
        $this->installDefaultFeedCategorySettings(2);

        $sql_blmod_affliate_price = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_affiliate_price
			(
				`affiliate_id` int(11) NOT NULL AUTO_INCREMENT,
				`affiliate_name` varchar(255) CHARACTER SET utf8 NOT NULL,
				`affiliate_formula` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
				`xml_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,  
				PRIMARY KEY (`affiliate_id`)
			)';
        $sql_blmod_affliate_price_res = Db::getInstance()->Execute($sql_blmod_affliate_price);

        $sql = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_g_cat
			(
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `category_id` int(11) NOT NULL,
                `g_category_id` int(11) NOT NULL,
                `type` varchar(20) CHARACTER SET utf8 NOT NULL,
                PRIMARY KEY (`id`)
			)';
        $sql_blmod_google_cat_res = Db::getInstance()->Execute($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_product_list
            (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) CHARACTER SET utf8 NOT NULL,
                PRIMARY KEY (`id`)
            )';

        $sqlProductListRes = Db::getInstance()->Execute($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_product_list_product
            (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `product_list_id` int(11) NOT NULL,
                `product_id` int(11) NOT NULL,
                PRIMARY KEY (`id`)
            )';

        $sqlProductListProductRes = Db::getInstance()->Execute($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_product_settings_package
            (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) CHARACTER SET utf8 NOT NULL,
                PRIMARY KEY (`id`)
            )';

        $sqlProductSettingsPackageRes = Db::getInstance()->Execute($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blmod_xml_product_settings 
            (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `product_id` int(11) NOT NULL,
                `package_id` int(11) NOT NULL,
                `total_budget` varchar(255) CHARACTER SET utf8 NOT NULL,
                `daily_budget` varchar(255) CHARACTER SET utf8 NOT NULL,
                `cpc` varchar(255) CHARACTER SET utf8 NOT NULL,
                `price_type` varchar(255) CHARACTER SET utf8 NOT NULL,
                `xml_custom` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            )';

        $sqlProductSettingsRes = Db::getInstance()->Execute($sql);

        if (!$sql_blmod_block_res || !$sql_blmod_feeds_res ||!$sql_blmod_fields_res || !$sql_blmod_cache_res ||
            !$sql_blmod_statistics_res || !$sql_blmod_affliate_price_res || !$sql_blmod_google_cat_res ||
            !$sqlProductListRes || !$sqlProductListProductRes || !$sqlProductSettingsPackageRes || !$sqlProductSettingsRes) {
            return false;
        }

        return true;
    }

    public function installDefaultFeedProductSettings($feed_id = false, $feedMode = 'c')
    {
        $feedType = 'category';
        $defaultImage = $feedType.'_default_name';
        $sqlFeedType = 'feed_mode = "'.$feedMode.'"';
        $fields = array();
        $blocks = array();
        $options = array();
        $imageName = array();

        if ($feedMode == 'g') {
            $feedMode = 'f';
        }

        $fields['m'] = '
            ("product_url_blmod", 1, "loc", "bl_extra", "'.$feed_id.'"),
            ("date_upd", 1, "lastmod", "product", "'.$feed_id.'")';

        $fields['f'] = '
            ("name", 1, "g:title", "product_lang", "'.$feed_id.'"),
            ("description_short", 1, "g:description", "product_lang", "'.$feed_id.'"),
            ("large", 1, "g:image_link", "img_blmod", "'.$feed_id.'"),
            ("name", 1, "g:brand", "manufacturer", "'.$feed_id.'"),
            ("id_product", 1, "g:id", "product", "'.$feed_id.'"),
            ("price_sale_blmod", 1, "g:price", "bl_extra", "'.$feed_id.'"),
            ("product_url_blmod", 1, "g:link", "bl_extra", "'.$feed_id.'"),
            ("condition", 1, "g:condition", "product", "'.$feed_id.'"),
            ("ean13", 1, "g:gtin", "product", "'.$feed_id.'"),
            ("reference", 1, "g:mpn", "product", "'.$feed_id.'"),
            ("available_for_order", 1, "g:availability", "product", "'.$feed_id.'"),
            ("name", 1, "g:google_product_category", "category_lang", "'.$feed_id.'")';

        $fields['s'] = '
            ("name", 1, "name", "product_lang", "'.$feed_id.'"),
            ("large", 1, "image", "img_blmod", "'.$feed_id.'"),
            ("name", 1, "manufacturer", "manufacturer", "'.$feed_id.'"),
            ("id_product", 1, "id", "product", "'.$feed_id.'"),
            ("price_sale_blmod", 1, "price_with_vat", "bl_extra", "'.$feed_id.'"),
            ("product_url_blmod", 1, "link", "bl_extra", "'.$feed_id.'"),
            ("ean13", 1, "ean", "product", "'.$feed_id.'"),
            ("product_categories_tree", 1, "category", "bl_extra", "'.$feed_id.'"),
            ("reference", 1, "mpn", "product", "'.$feed_id.'"),
            ("available_for_order", 1, "availability", "product", "'.$feed_id.'")';

        $fields['i'] = '
            ("name", 1, "g:title", "product_lang", "'.$feed_id.'"),
            ("description", 1, "s:description", "product_lang", "'.$feed_id.'"),
            ("large", 1, "g:image_link", "img_blmod", "'.$feed_id.'"),
            ("name", 1, "g:brand", "manufacturer", "'.$feed_id.'"),
            ("id_product", 1, "g:id", "product", "'.$feed_id.'"),
            ("price_sale_blmod", 1, "g:price", "bl_extra", "'.$feed_id.'"),
            ("quantity", 1, "s:quantity", "product", "'.$feed_id.'"),
            ("product_url_blmod", 0, "g:link", "bl_extra", "'.$feed_id.'"),
            ("condition", 0, "g:condition", "product", "'.$feed_id.'"),
            ("ean13", 1, "g:gtin", "product", "'.$feed_id.'"),
            ("reference", 1, "g:mpn", "product", "'.$feed_id.'"),
            ("available_for_order", 0, "g:availability", "product", "'.$feed_id.'"),
            ("product_categories_tree", 1, "s:siroop_category", "bl_extra", "'.$feed_id.'")';

        $fields['x'] = '
            ("name", 1, "PRODUCT", "product_lang", "'.$feed_id.'"),
            ("description", 1, "DESCRIPTION_LONG", "product_lang", "'.$feed_id.'"),
            ("description_short", 1, "DESCRIPTION_SHORT", "product_lang", "'.$feed_id.'"),
            ("large", 1, "IMGURL", "img_blmod", "'.$feed_id.'"),
            ("name", 1, "MANUFACTURER", "manufacturer", "'.$feed_id.'"),
            ("id_product", 1, "PRODUCT_CODE", "product", "'.$feed_id.'"),
            ("price_sale_blmod", 1, "PRICE", "bl_extra", "'.$feed_id.'"),
            ("name", 1, "CATEGORY", "category_lang", "'.$feed_id.'"),
            ("quantity", 1, "STOCK_AMOUNT", "product", "'.$feed_id.'"),
            ("product_url_blmod", 1, "URL", "bl_extra", "'.$feed_id.'"),
            ("ean13", 1, "EAN", "product", "'.$feed_id.'"),
            ("available_for_order", 1, "AVAILABILITY", "product", "'.$feed_id.'")';

        $fields['r'] = '
            ("name", 1, "Title", "product_lang", "'.$feed_id.'"),
            ("description", 1, "Description", "product_lang", "'.$feed_id.'"),
            ("large", 1, "Imageurl1", "img_blmod", "'.$feed_id.'"),
            ("name", 1, "Manufacturer", "manufacturer", "'.$feed_id.'"),
            ("id_product", 1, "ProductId", "product", "'.$feed_id.'"),
            ("price", 1, "NormalPriceWithoutVAT", "product", "'.$feed_id.'"),
            ("name", 1, "Category", "category_lang", "'.$feed_id.'"),
            ("quantity", 1, "StockQuantity", "product", "'.$feed_id.'"),
            ("ean13", 1, "EAN", "product", "'.$feed_id.'"),
            ("reference", 1, "SkuId", "product", "'.$feed_id.'"),
            ("weight", 1, "PackageWeight", "product", "'.$feed_id.'"),
            ("available_for_order", 1, "StockStatus", "product", "'.$feed_id.'")';

        $fields['h'] = '
            ("name", 1, "Product_Name_", "product_lang", "'.$feed_id.'"),
            ("description", 1, "Description_", "product_lang", "'.$feed_id.'"),
            ("description_short", 1, "Short_description_", "product_lang", "'.$feed_id.'"),
            ("large", 1, "image", "img_blmod", "'.$feed_id.'"),
            ("id_product", 1, "Product_ID", "product", "'.$feed_id.'"),
            ("price", 1, "Base_price", "product", "'.$feed_id.'"),
            ("name", 1, "Category", "category_lang", "'.$feed_id.'"),
            ("quantity", 1, "Quantity", "product", "'.$feed_id.'"),
            ("ean13", 1, "EAN13", "product", "'.$feed_id.'"),
            ("reference", 1, "Product_code", "product", "'.$feed_id.'"),
            ("condition", 1, "Condition", "product", "'.$feed_id.'"),
            ("product_categories_tree", 1, "Category_tree", "bl_extra", "'.$feed_id.'"),
            ("width", 1, "Width", "product", "'.$feed_id.'"),
            ("height", 1, "Height", "product", "'.$feed_id.'"),
            ("depth", 1, "Depth", "product", "'.$feed_id.'"),
            ("weight", 1, "Weight", "product", "'.$feed_id.'")';

        $fields['a'] = '
            ("name", 1, "admarkt:title", "product_lang", "'.$feed_id.'"),
            ("description_short", 1, "admarkt:description", "product_lang", "'.$feed_id.'"),
            ("large", 1, "admarkt:media", "img_blmod", "'.$feed_id.'"),
            ("id_product", 1, "admarkt:id", "product", "'.$feed_id.'"),
            ("reference", 1, "admarkt:vendorId", "product", "'.$feed_id.'"),
            ("product_url_blmod", 1, "admarkt:url", "bl_extra", "'.$feed_id.'"),
            ("price_sale_blmod", 1, "admarkt:price", "bl_extra", "'.$feed_id.'"),
            ("name", 1, "admarkt:categoryId", "category_lang", "'.$feed_id.'")';

        $fields['o'] = '("name", 1, "NAME", "product_lang", "'.$feed_id.'"),
            ("description", 1, "DESCRIPTION", "product_lang", "'.$feed_id.'"),
            ("description_short", 1, "SHORT_DESCRIPTION", "product_lang", "'.$feed_id.'"),
            ("large", 1, "IMAGES", "img_blmod", "'.$feed_id.'"),
            ("name", 1, "MANUFACTURER", "manufacturer", "'.$feed_id.'"),
            ("price_sale_blmod", 1, "PRICE", "bl_extra", "'.$feed_id.'"),
            ("name", 1, "CATEGORY", "category_lang", "'.$feed_id.'"),
            ("quantity", 1, "STOCK/AMOUNT", "product", "'.$feed_id.'"),
            ("reference", 1, "CODE", "product", "'.$feed_id.'"),
            ("available_for_order", 1, "AVAILABILITY", "product", "'.$feed_id.'")';

        $fields['c'] = '
			("available_later", 1, "available_later", "product_lang", "'.$feed_id.'"),
            ("available_now", 1, "available_now", "product_lang", "'.$feed_id.'"),
            ("name", 1, "name", "product_lang", "'.$feed_id.'"),
            ("meta_title", 1, "meta_title", "product_lang", "'.$feed_id.'"),
            ("meta_keywords", 1, "meta_keywords", "product_lang", "'.$feed_id.'"),
            ("meta_description", 1, "meta_description", "product_lang", "'.$feed_id.'"),
            ("link_rewrite", 1, "link_rewrite", "product_lang", "'.$feed_id.'"),
            ("description_short", 1, "description_short", "product_lang", "'.$feed_id.'"),
            ("description", 1, "description", "product_lang", "'.$feed_id.'"),
            ("large_scene", 1, "large_scene", "img_blmod", "'.$feed_id.'"),
            ("thumb_scene", 1, "thumb_scene", "img_blmod", "'.$feed_id.'"),
            ("home", 1, "home", "img_blmod", "'.$feed_id.'"),
            ("category", 1, "category", "img_blmod", "'.$feed_id.'"),
            ("thickbox", 1, "thickbox", "img_blmod", "'.$feed_id.'"),
            ("small", 1, "small", "img_blmod", "'.$feed_id.'"),
            ("medium", 1, "medium", "img_blmod", "'.$feed_id.'"),
            ("large", 1, "large", "img_blmod", "'.$feed_id.'"),
            ("name", 1, "'.$defaultImage.'", "category_lang", "'.$feed_id.'"),
            ("out_of_stock", 1, "out_of_stock", "product", "'.$feed_id.'"),
            ("id_category_default", 1, "category_default_id", "product", "'.$feed_id.'"),
            ("quantity_discount", 1, "quantity_discount", "product", "'.$feed_id.'"),
            ("quantity", 1, "quantity", "product", "'.$feed_id.'"),
            ("ecotax", 1, "ecotax", "product", "'.$feed_id.'"),
            ("wholesale_price", 1, "wholesale_price", "product", "'.$feed_id.'"),
            ("price", 1, "price", "product", "'.$feed_id.'"),
            ("date_upd", 1, "date_upd", "product", "'.$feed_id.'"),
            ("date_add", 1, "date_add", "product", "'.$feed_id.'"),
            ("active", 1, "active", "product", "'.$feed_id.'"),
            ("on_sale", 1, "on_sale", "product", "'.$feed_id.'"),
            ("width", 1, "width", "product", "'.$feed_id.'"),
            ("height", 1, "height", "product", "'.$feed_id.'"),
            ("depth", 1, "depth", "product", "'.$feed_id.'"),
            ("weight", 1, "weight", "product", "'.$feed_id.'"),
            ("location", 1, "location", "product", "'.$feed_id.'"),
            ("name", 1, "manufacturer_name", "manufacturer", "'.$feed_id.'"),
            ("id_manufacturer", 1, "manufacturer_id", "product", "'.$feed_id.'"),
            ("id_product", 1, "product_id", "product", "'.$feed_id.'"),
            ("id_supplier", 1, "supplier_id", "product", "'.$feed_id.'"),
            ("price_shipping_blmod", 1, "price_shipping", "bl_extra", "'.$feed_id.'"),
            ("price_sale_blmod", 1, "price_sale", "bl_extra", "'.$feed_id.'"),
            ("product_url_blmod", 1, "product_url", "bl_extra", "'.$feed_id.'"),
            ("supplier_reference", 1, "supplier_reference", "product", "'.$feed_id.'"),
            ("ean13", 1, "ean13", "product", "'.$feed_id.'"),
            ("upc", 1, "upc", "product", "'.$feed_id.'"),
            ("reference", 1, "reference", "product", "'.$feed_id.'"),
            ("available_for_order", 1, "available_for_order", "product", "'.$feed_id.'")';

        $blocks['m'] = '("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "category", "1", "'.$feed_id.'"),
            ("file-name", "categories", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "url", "1", "'.$feed_id.'"),
            ("file-name", "urlset", "0", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'"),
            ("extra-product-rows", "'.htmlspecialchars('<changefreq>daily</changefreq><priority>0.9</priority>', ENT_QUOTES).'", "1", "'.$feed_id.'")';

        $blocks['f'] = '("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "category", "1", "'.$feed_id.'"),
            ("file-name", "categories", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "item", "1", "'.$feed_id.'"),
            ("file-name", "channel", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'")';

        $blocks['s'] = '("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "category", "1", "'.$feed_id.'"),
            ("file-name", "categories", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "product", "1", "'.$feed_id.'"),
            ("file-name", "products", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'")';

        $blocks['i'] = '("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "category", "1", "'.$feed_id.'"),
            ("file-name", "categories", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "item", "1", "'.$feed_id.'"),
            ("file-name", "channel", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'")';

        $blocks['x'] = '("desc-block-name", "DESCRIPTIONS", "1", "'.$feed_id.'"),
            ("cat-block-name", "CATEGORY", "1", "'.$feed_id.'"),
            ("file-name", "CATEGORIES", "1", "'.$feed_id.'"),
            ("img-block-name", "IMAGES", "1", "'.$feed_id.'"),
            ("desc-block-name", "DESCRIPTIONS", "1", "'.$feed_id.'"),
            ("cat-block-name", "SHOPITEM", "1", "'.$feed_id.'"),
            ("file-name", "SHOP", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "CATEGORIES", "1", "'.$feed_id.'"),
            ("attributes-block-name", "ATTRIBUTES", "1", "'.$feed_id.'")';

        $blocks['r'] = '("desc-block-name", "Description", "1", "'.$feed_id.'"),
            ("cat-block-name", "category", "1", "'.$feed_id.'"),
            ("file-name", "categories", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("desc-block-name", "Description", "1", "'.$feed_id.'"),
            ("cat-block-name", "Product", "1", "'.$feed_id.'"),
            ("file-name", "Products", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'")';

        $blocks['c'] = '("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "category", "1", "'.$feed_id.'"),
            ("file-name", "categories", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "product", "1", "'.$feed_id.'"),
            ("file-name", "products", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'")';

        $blocks['h'] = '("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "category", "1", "'.$feed_id.'"),
            ("file-name", "categories", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "PRODUCT", "1", "'.$feed_id.'"),
            ("file-name", "CATALOG", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'")';

        $blocks['a'] = '("desc-block-name", "descriptions", "1", "'.$feed_id.'"),
            ("cat-block-name", "admarkt:ad", "1", "'.$feed_id.'"),
            ("img-block-name", "images", "1", "'.$feed_id.'"),
            ("file-name", "products", "0", "'.$feed_id.'"),
            ("def_cat-block-name", "default_category", "1", "'.$feed_id.'"),
            ("attributes-block-name", "attributes", "1", "'.$feed_id.'")';

        $blocks['o'] = '("desc-block-name", "DESCRIPTIONS", "1", "'.$feed_id.'"),
            ("cat-block-name", "CATEGORY", "1", "'.$feed_id.'"),
            ("file-name", "CATEGORIES", "1", "'.$feed_id.'"),
            ("img-block-name", "IMAGES", "1", "'.$feed_id.'"),
            ("desc-block-name", "DESCRIPTIONS", "1", "'.$feed_id.'"),
            ("cat-block-name", "SHOPITEM", "1", "'.$feed_id.'"),
            ("file-name", "SHOP", "1", "'.$feed_id.'"),
            ("def_cat-block-name", "CATEGORIES", "1", "'.$feed_id.'"),
            ("attributes-block-name", "ATTRIBUTES", "1", "'.$feed_id.'")';

        $options['m'] = 'header_information = "'.htmlspecialchars('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> ', ENT_QUOTES).'",
			footer_information = "'.htmlspecialchars('</urlset>', ENT_QUOTES).'", one_branch = "1"';

        $options['f'] = 'header_information = "'.htmlspecialchars('<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">', ENT_QUOTES).'",
			footer_information = "'.htmlspecialchars('</rss>', ENT_QUOTES).'", one_branch = "1", price_with_currency = "1"';

        $options['s'] = 'one_branch = "1", html_tags_status = "0", feed_generation_time = "1", feed_generation_time_name = "created_at"';

        $options['i'] = 'header_information = "'.htmlspecialchars('<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:s="https://merchants.siroop.ch/" version="2.0">', ENT_QUOTES).'",
			footer_information = "'.htmlspecialchars('</rss>', ENT_QUOTES).'", one_branch = "1", price_with_currency = "1"';

        $options['x'] = 'all_images = "1"';

        $options['r'] = 'one_branch = "1", all_images = "0"';

        $options['h'] = 'one_branch = "1", all_images = "1"';

        $options['a'] = 'header_information = "'.htmlspecialchars('<admarkt:ads xmlns:admarkt="http://admarkt.marktplaats.nl/schemas/1.0">', ENT_QUOTES).'",
			footer_information = "'.htmlspecialchars('</admarkt:ads>', ENT_QUOTES).'", one_branch = "1", price_with_currency = "0", cdata_status = "0"';

        $options['o'] = 'all_images = "1", cdata_status = "0"';

        $imageName['c'] = 'image';
        $imageName['f'] = 'g:image_link';
        $imageName['i'] = 'g:image_link';
        $imageName['s'] = 'image';
        $imageName['x'] = 'IMGURL';
        $imageName['r'] = 'Imageurl1';
        $imageName['h'] = 'image';
        $imageName['a'] = 'admarkt:media';
        $imageName['o'] = 'IMAGE';

        $image = $this->getBiggestImage();

        $id_lang = Configuration::get('PS_LANG_DEFAULT');

        if (!empty($id_lang)) {
            $fields[$feedMode] .= ', ("'.$id_lang.'", "1", "'.$id_lang.'", "lang", "'.$feed_id.'")';
        }

        if (!empty($image) && !empty($imageName[$feedMode])) {
            $fields[$feedMode] .= ', ("'.$image.'", "1", "'.$imageName[$feedMode].'", "img_blmod", "'.$feed_id.'")';
        }

        $sql_blmod_fields_val = 'INSERT INTO '._DB_PREFIX_.'blmod_xml_fields
            (`name`, `status`, `title_xml`, `table`, `category`)
            VALUES '.trim($fields[$feedMode], ',');

        Db::getInstance()->Execute($sql_blmod_fields_val);

        $sql_blmod_block_val = 'INSERT INTO '._DB_PREFIX_.'blmod_xml_block
            (`name`, `value`, `status`, `category`)
            VALUES '.trim($blocks[$feedMode], ',');

        Db::getInstance()->Execute($sql_blmod_block_val);

        $options[$feedMode] = !empty($options[$feedMode]) ? $options[$feedMode].',' : false;

        $sql_blmod_option_val = 'UPDATE '._DB_PREFIX_.'blmod_xml_feeds SET '.$options[$feedMode].$sqlFeedType.' WHERE id = "'.$feed_id.'"';

        Db::getInstance()->Execute($sql_blmod_option_val);

        return true;
    }

    public function installDefaultFeedCategorySettings($feed_id)
    {
        $idLang = Configuration::get('PS_LANG_DEFAULT');

        $sql_blmod_fields_val = 'INSERT INTO '._DB_PREFIX_.'blmod_xml_fields
            (`name`, `status`, `title_xml`, `table`, `category`)
            VALUES
            ("meta_description", 1, "meta_description", "category_lang", "'.$feed_id.'"),
            ("meta_keywords", 0, "meta_keywords", "category_lang", "'.$feed_id.'"),
            ("meta_title", 0, "meta_title", "category_lang", "'.$feed_id.'"),
            ("link_rewrite", 0, "link_rewrite", "category_lang", "'.$feed_id.'"),
            ("description", 0, "description", "category_lang", "'.$feed_id.'"),
            ("name", 1, "name", "category_lang", "'.$feed_id.'"),
            ("id_lang", 1, "id_lang", "category_lang", "'.$feed_id.'"),
            ("date_upd", 0, "data_upd", "category", "'.$feed_id.'"),
            ("date_add", 0, "data_add", "category", "'.$feed_id.'"),
            ("active", 0, "active", "category", "'.$feed_id.'"),
            ("level_depth", 0, "level_depth", "category", "'.$feed_id.'"),
            ("id_parent", 1, "category_parent_id", "category", "'.$feed_id.'"),
            ("id_category", 1, "category_id", "category", "'.$feed_id.'"),
            ("'.$idLang.'", 1, "'.$idLang.'", "lang", "'.$feed_id.'")';

        Db::getInstance()->Execute($sql_blmod_fields_val);

        $sql_blmod_block_val = 'INSERT INTO '._DB_PREFIX_.'blmod_xml_block
            (`name`, `value`, `category`)
            VALUES
            ("desc-block-name", "descriptions", "'.$feed_id.'"),
            ("cat-block-name", "category", "'.$feed_id.'"),
            ("file-name", "categories", "'.$feed_id.'")';

        Db::getInstance()->Execute($sql_blmod_block_val);

        return true;
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
}