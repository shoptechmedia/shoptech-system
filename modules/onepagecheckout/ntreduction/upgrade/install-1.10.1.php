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

function upgrade_module_1_10_1($module)
{
    $module->registerHook('actionObjectProductUpdateBefore');

    //We initialize the configuration for all shops
    $shops = Shop::getShops();

    foreach ($shops as $shop) {
        $hide_columns = Configuration::get('NTREDUCTION_HIDE_COLUMNS', null, $shop['id_shop_group'], $shop['id_shop']);

        if ($hide_columns) {
            $columns_to_hide = explode(':', $hide_columns);
        }

        $columns_to_hide[] = 'p_init_price';

        if (!Configuration::updateValue(
            'NTREDUCTION_HIDE_COLUMNS',
            implode(':', $columns_to_hide),
            false,
            $shop['id_shop_group'],
            $shop['id_shop']
        )) {
            return false;
        }

        if (!Configuration::updateValue('DISPLAY_INIT_PRICE', 0, false, $shop['id_shop_group'], $shop['id_shop'])) {
            return false;
        }
    }

    Db::getInstance()->execute(
        'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ntreduction_informations` (
            `id_ntreduction_informations` int(10) unsigned NOT NULL auto_increment,
            `id_product` int(10) unsigned,
            `init_price` decimal(20,6),
            PRIMARY KEY (`id_ntreduction_informations`)
        ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8;'
    );

    return $module;
}