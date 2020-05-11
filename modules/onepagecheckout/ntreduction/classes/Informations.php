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

class Informations extends ObjectModel
{
    /** @var integer Informations ID */
    public $id_ntreduction_informations;

    /** @var int id_product */
    public $id_product;

    /** @var float price */
    public $init_price;

/**********************************************************/

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'ntreduction_informations',
        'primary' => 'id_ntreduction_informations',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'id_product'    =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'init_price'    =>  array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
        )
    );

    public static function getIdByProduct($id_product)
    {
        return Db::getInstance()->getValue(
            'SELECT id_ntreduction_informations
            FROM `'._DB_PREFIX_.'ntreduction_informations`
            WHERE id_product = '.(int)$id_product
        );
    }
}
