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

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'stm_events';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'stm_events (
    `id_stm_event` INT(11) NOT NULL AUTO_INCREMENT,
    `id_product` INT(11),
    `active` INT(11),
    `buy_pack` INT(11),
    `buy_one` INT(11),
    `youtube_video` TEXT,
    `streaming_start_time` DATETIME NOT NULL,
    `streaming_end_time` DATETIME NOT NULL,
    `streaming_url` TEXT,
    `venue` TEXT,
    `event_image` TEXT,
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `event_categories` TEXT,
    `cancelation_period` INT,
    PRIMARY KEY(`id_stm_event`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'stm_events_lang';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'stm_events_lang (
    `id_stm_event` INT(11),
    `id_lang` INT(11),
    `name` TEXT,
    `description` LONGTEXT,
    `meta_title` TEXT,
    `meta_description` LONGTEXT,
    `link_rewrite` TEXT
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'stm_tickets';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'stm_tickets (
    `id_stm_ticket` INT(11) NOT NULL AUTO_INCREMENT,
    `id_stm_event` INT(11),
    `id_product` INT(11),
    PRIMARY KEY(`id_stm_ticket`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'stm_reservations';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'stm_reservations (
    `id_reservation` INT(11) NOT NULL AUTO_INCREMENT,
    `id_cart` INT(11),
    `id_order_detail` INT(11),
    `id_reservation_date` INT(11),
    `id_customer` INT(11),
    PRIMARY KEY(`id_reservation`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'DROP TABLE IF EXISTS '._DB_PREFIX_.'stm_reservation_dates';
$sql[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'stm_reservation_dates (
    `id_reservation_date` INT(11) NOT NULL AUTO_INCREMENT,
    `id_product` INT(11),
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `available_reservation` INT(11),
    `deleted` TINYINT(11),
    PRIMARY KEY(`id_reservation_date`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';


foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        echo Db::getInstance()->getMsgError();
        return false;
    }
}
