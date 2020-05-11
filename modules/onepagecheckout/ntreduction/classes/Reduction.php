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

class Reduction extends ObjectModel
{
    /** @var integer Reduction ID */
    public $id_ntreduction;

    /** @var int id specifique price */
    public $id_specific_price;

    /** @var bool on sale */
    public $on_sale;

    /** @var bool monday */
    public $monday;

    /** @var bool tuesday */
    public $tuesday;

    /** @var bool wednesday */
    public $wednesday;

    /** @var bool thursday */
    public $thursday;

    /** @var bool friday */
    public $friday;

    /** @var bool saturday */
    public $saturday;

    /** @var bool sunday */
    public $sunday;

    /** @var int id_product */
    public $id_product;

    /** @var int id_shop */
    public $id_shop;

    /** @var int id_currency */
    public $id_currency;

    /** @var int id_country */
    public $id_country;

    /** @var int id_group */
    public $id_group;

    /** @var int id_customer */
    public $id_customer;

    /** @var int id_product_attribute */
    public $id_product_attribute;

    /** @var float price */
    public $price;

    /** @var int from_quantity */
    public $from_quantity;

    /** @var float reduction */
    public $reduction;

    /** @var string reduction_type */
    public $reduction_type;

    /** @var string from */
    public $from;

    /** @var string to */
    public $to;

/**********************************************************/

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'ntreduction',
        'primary' => 'id_ntreduction',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'id_specific_price'     =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'on_sale'               =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'monday'                =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'tuesday'               =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'wednesday'             =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'thursday'              =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'friday'                =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'saturday'              =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sunday'                =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'id_product'            =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_shop'               =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_currency'           =>  array('type' => self::TYPE_INT),
            'id_country'            =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_group'              =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_customer'           =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_product_attribute'  =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'price'                 =>  array('type' => self::TYPE_FLOAT, 'validate' => 'isNegativePrice'),
            'from_quantity'         =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'reduction'             =>  array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'reduction_type'        =>  array('type' => self::TYPE_STRING, 'validate' => 'isReductionType'),
            'from'                  =>  array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            'to'                    =>  array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
        )
    );

    public function delete()
    {
        Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'product` p
            SET p.on_sale = 0
            WHERE p.id_product IN (
                SELECT s.id_product
                FROM `'._DB_PREFIX_.'ntreduction` n
                JOIN `'._DB_PREFIX_.'specific_price` s ON s.id_specific_price = n.id_specific_price
                WHERE p.id_product = s.id_product
                AND n.id_ntreduction = '.(int)$this->id_ntreduction.'
                AND n.on_sale = 1
                AND (
                    (s.from <= NOW() AND s.to >= NOW())
                    OR (s.from = "0000-00-00 00:00:00" AND s.to = "0000-00-00 00:00:00")
                )
            )'
        );

        parent::delete();
    }

    public static function getIdReductionBySpecificPrice($id_specific_price)
    {
        return Db::getInstance()->getValue(
            'SELECT id_ntreduction
            FROM `'._DB_PREFIX_.'ntreduction`
            WHERE id_specific_price = '.(int)$id_specific_price
        );
    }

    public static function createDaysSpecificPrice()
    {
        $day = date('w');
        $from = date('Y-m-d').' 00:00:01';
        $to = date('Y-m-d').' 23:59:59';
        $where_day = '';

        switch ($day) {
            case 0:
                $where_day = ' AND `sunday` = 1';
                break;
            case 1:
                $where_day = ' AND `monday` = 1';
                break;
            case 2:
                $where_day = ' AND `tuesday` = 1';
                break;
            case 3:
                $where_day = ' AND `wednesday` = 1';
                break;
            case 4:
                $where_day = ' AND `thursday` = 1';
                break;
            case 5:
                $where_day = ' AND `friday` = 1';
                break;
            case 6:
                $where_day = ' AND `saturday` = 1';
                break;

            default:
                break;
        }

        $days_reduction = (array)Db::getInstance()->executeS(
            'SELECT *
            FROM `'._DB_PREFIX_.'ntreduction`
            WHERE `id_specific_price` = 0
            '.$where_day.'
            AND (`from` <= NOW() OR `from` = "0000-00-00 00:00:00")
            AND (`to` >= NOW()  OR `to` = "0000-00-00 00:00:00")'
        );

        $id_product = 0;

        foreach ($days_reduction as $reduction) {
            $specific_price = new SpecificPrice();
            $nt_reduction = new Reduction((int)$reduction['id_ntreduction']);

            $specific_price->id_product = (int)$reduction['id_product'];
            $specific_price->id_product_attribute = (int)$reduction['id_product_attribute'];
            $specific_price->id_shop = (int)$reduction['id_shop'];
            $specific_price->id_currency = (int)$reduction['id_currency'];
            $specific_price->id_country = (int)$reduction['id_country'];
            $specific_price->id_group = (int)$reduction['id_group'];
            $specific_price->id_customer = (int)$reduction['id_customer'];
            $specific_price->price = (float)$reduction['price'];
            $specific_price->from_quantity = (int)$reduction['from_quantity'];
            $specific_price->reduction = (float)$reduction['reduction'];
            $specific_price->reduction_type = $reduction['reduction_type'];
            $specific_price->from = $from;
            $specific_price->to = $to;

            if (!$specific_price->add()) {
                return false;
            }

            $nt_reduction->id_specific_price = $specific_price->id;

            if (!$nt_reduction->update()) {
                return false;
            }

            $id_product = (int)$reduction['id_product'];
        }

        if ($id_product > 0) {
            Hook::exec(
                'actionProductUpdate',
                array('id_product' => $id_product, 'product' => new Product($id_product))
            );
        }

        return true;
    }

    public static function updateProductOnSale()
    {
        /* Update on_sale product for old specific price */
        $result0 = Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'product_shop` p
            SET p.on_sale = 0
            WHERE p.id_product IN (
                SELECT s.id_product
                FROM `'._DB_PREFIX_.'ntreduction` n
                JOIN `'._DB_PREFIX_.'specific_price` s ON s.id_specific_price = n.id_specific_price
                WHERE p.on_sale <> 0
                AND (p.id_shop = s.id_shop OR s.id_shop = 0)
                AND (s.from > NOW() OR s.to < NOW())
                AND (s.from <> "0000-00-00 00:00:00" AND s.to <> "0000-00-00 00:00:00")
            )'
        );

        $result1 = Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'product` p
            SET p.on_sale = 0
            WHERE p.id_product IN (
                SELECT s.id_product
                FROM `'._DB_PREFIX_.'ntreduction` n
                JOIN `'._DB_PREFIX_.'specific_price` s ON s.id_specific_price = n.id_specific_price
                WHERE p.on_sale <> 0
                AND (s.from > NOW() OR s.to < NOW())
                AND (s.from <> "0000-00-00 00:00:00" AND s.to <> "0000-00-00 00:00:00")
            )'
        );

        /* Delete old specific price in ntreducion */
        $result2 = Db::getInstance()->execute(
            'DELETE FROM `'._DB_PREFIX_.'ntreduction`
            WHERE id_specific_price IN (
                SELECT s.id_specific_price
                FROM `'._DB_PREFIX_.'specific_price` s
                WHERE (s.from > NOW() OR s.to < NOW())
                AND (s.from <> "0000-00-00 00:00:00" AND s.to <> "0000-00-00 00:00:00")
            )'
        );

        /* Update on_sale product for current specific price when on_sale is false but should be true */
        $result3 = Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'product_shop` p
            SET p.on_sale = 1
            WHERE p.id_product IN (
                SELECT s.id_product
                FROM `'._DB_PREFIX_.'ntreduction` n
                JOIN `'._DB_PREFIX_.'specific_price` s ON s.id_specific_price = n.id_specific_price
                WHERE p.on_sale <> n.on_sale
                AND (p.id_shop = s.id_shop OR s.id_shop = 0)
                AND n.on_sale = 1
                AND ((s.from <= NOW() AND s.to >= NOW())
                    OR (s.from = "0000-00-00 00:00:00" AND s.to = "0000-00-00 00:00:00"))
            )'
        );

        $result4 = Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'product` p
            SET p.on_sale = 1
            WHERE p.id_product IN (
                SELECT s.id_product
                FROM `'._DB_PREFIX_.'ntreduction` n
                JOIN `'._DB_PREFIX_.'specific_price` s ON s.id_specific_price = n.id_specific_price
                WHERE p.on_sale <> n.on_sale
                AND n.on_sale = 1
                AND ((s.from <= NOW() AND s.to >= NOW())
                    OR (s.from = "0000-00-00 00:00:00" AND s.to = "0000-00-00 00:00:00"))
            )'
        );

        /* Update on_sale product for current specific price when on_sale is true but should be false */
        $result5 = Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'product_shop` p
            SET p.on_sale = 0
            WHERE p.id_product IN (
                SELECT s.id_product
                FROM `'._DB_PREFIX_.'ntreduction` n
                JOIN `'._DB_PREFIX_.'specific_price` s ON s.id_specific_price = n.id_specific_price
                WHERE p.on_sale <> n.on_sale
                AND (p.id_shop = s.id_shop OR s.id_shop = 0)
                AND n.on_sale = 0
                AND ((s.from <= NOW() AND s.to >= NOW())
                    OR (s.from = "0000-00-00 00:00:00" AND s.to = "0000-00-00 00:00:00"))
            )'
        );

        $result6 = Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'product` p
            SET p.on_sale = 0
            WHERE p.id_product IN (
                SELECT s.id_product
                FROM `'._DB_PREFIX_.'ntreduction` n
                JOIN `'._DB_PREFIX_.'specific_price` s ON s.id_specific_price = n.id_specific_price
                WHERE p.on_sale <> n.on_sale
                AND n.on_sale = 0
                AND ((s.from <= NOW() AND s.to >= NOW())
                    OR (s.from = "0000-00-00 00:00:00" AND s.to = "0000-00-00 00:00:00"))
            )'
        );

        if (!$result0 || !$result1 || !$result2 || !$result3 || !$result4 || !$result5 || !$result6) {
            return false;
        }

        return true;
    }
}
