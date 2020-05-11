<?php
/**
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$sql = array();

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'holiday_sale';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'holiday_sale (
    `id_holiday_sale` INT(11) NOT NULL AUTO_INCREMENT,
    `id_shop` INT(11) NOT NULL,
    `banner_image` TEXT,
    `banner_image_font_color` TEXT,
    `page_background_color` TEXT,
    `page_font_color` TEXT,
    `use_countdown` INT(11),
    `hide_products` INT(11),
    `release_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    PRIMARY KEY(`id_holiday_sale`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'holiday_sale_lang';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'holiday_sale_lang (
    `id_holiday_sale` INT(11),
    `id_lang` INT(11),
    `title` TEXT,
    `meta_title` TEXT,
    `holiday_description` LONGTEXT,
    `meta_description` LONGTEXT,
    `link_rewrite` TEXT,
    `starting_text` TEXT,
    `ending_text` TEXT
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'holiday_sale_products';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'holiday_sale_products (
    `id_holiday_sale` INT(11),
    `id_product` INT(11),
    `id_specific_price` INT(11),
    `hsd_from` DATE NOT NULL,
    `hsd_to` DATE NOT NULL,
    `hsd_reduction` FLOAT,
    `hsd_reduction_type` TEXT,
    `hsd_reduction_tax` INT(11)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';


foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
