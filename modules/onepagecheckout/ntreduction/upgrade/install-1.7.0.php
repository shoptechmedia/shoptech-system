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

function upgrade_module_1_7_0($module)
{
    Db::getInstance()->execute(
        'ALTER TABLE `'._DB_PREFIX_.'ntreduction`
        ADD `monday` tinyint(1),
        ADD `tuesday` tinyint(1),
        ADD `wednesday` tinyint(1),
        ADD `thursday` tinyint(1),
        ADD `friday` tinyint(1),
        ADD `saturday` tinyint(1),
        ADD `sunday` tinyint(1),
        ADD `id_product` int(10) unsigned,
        ADD `id_shop` int(11) unsigned NOT NULL DEFAULT \'1\',
        ADD `id_currency` int(10) unsigned,
        ADD `id_country` int(10) unsigned,
        ADD `id_group` int(10) unsigned,
        ADD `id_customer` int(10) unsigned,
        ADD `id_product_attribute` int(10) unsigned,
        ADD `price` decimal(20,6),
        ADD `from_quantity` mediumint(8) unsigned,
        ADD `reduction` decimal(20,6),
        ADD `reduction_type` enum(\'amount\',\'percentage\'),
        ADD `from` datetime,
        ADD `to` datetime'
    );

    return $module;
}
