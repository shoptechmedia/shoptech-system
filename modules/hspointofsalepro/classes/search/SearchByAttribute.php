<?php
/**
 * RockPOS - Point of Sale for PrestaShop.
 *
 * @author    Hamsa Technologies
 * @copyright Hamsa Technologies
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

/**
 *
 */
class SearchByAttribute extends SearchAbstract
{

    /**
     * @return array
     *               array = (<pre>
     *               [0] => Array
     *               (
     *                  [id_product] => int
     *                  [reference] => string
     *                  [id_shop] => int
     *                  [name] => string
     *                  [id_product_attribute] => int
     *                  [position] => int
     *                  [quantity] => int
     *                  [combination] => string
     *                  [stock] => int/string
     *                  [item] => string (items / item),
     *                  [has_combinations] => boolean
     *               )
     *               )</pre>
     */
    public function search($is_with_image = false)
    {
        $product_query = new DbQuery();
        $product_query->select('DISTINCT p.`id_product`');
        $product_query->select('IF(p.`cache_default_attribute` > 0, 1, 0) AS `has_combinations`');
        $product_query->select('p.`reference` AS `reference`');
        $product_query->select('pl.`name` AS `name`');
        $product_query->select('stock.`quantity`');
        $product_query->from('product', 'p');
        $product_query->leftJoin('product_attribute', 'pa', 'pa.`id_product` = p.`id_product`');
        $product_query->join(Shop::addSqlAssociation('product', 'p'));
        $product_query->leftJoin(
            'product_lang',
            'pl',
            'p.`id_product` = pl.`id_product` AND pl.`id_lang` = ' . (int)$this->id_lang . ' AND pl.`id_shop` = ' . (int)$this->shop->id
        );
        $product_query->leftJoin(
            'product_attribute_combination',
            'pac',
            'pac.`id_product_attribute` = pa.`id_product_attribute`'
        );
        $product_query->leftJoin('attribute', 'a', 'a.`id_attribute` = pac.`id_attribute`');
        $product_query->leftJoin(
            'attribute_shop',
            'ats',
            'ats.`id_attribute` = a.`id_attribute` AND ats.`id_shop` = ' . (int)$this->shop->id
        );
        $product_query->leftJoin(
            'attribute_lang',
            'al',
            'al.`id_attribute` = a.`id_attribute` AND al.`id_lang` = ' . (int)$this->id_lang
        );
        $product_query->join(Product::sqlStock('p', 0, true, $this->shop));
        $product_visibilities = PosProduct::getProductVisibilities();
        $product_query->where(!empty($product_visibilities) ? 'p.`visibility` IN ("' . implode('","', $product_visibilities) . '")' : null);
        $product_query->where('al.`name` LIKE \'%' . pSQL($this->keyword) . '%\'');
        $product_query->where(!Configuration::get('POS_PRODUCT_INACTIVE') ? 'product_shop.`active` = 1' : null);
        if (Configuration::get('PS_STOCK_MANAGEMENT')) {
            $product_query->where(Configuration::get('POS_PRODUCT_OUT_OF_STOCK') ? null : 'stock.`quantity` > 0');
        }
        $is_with_image ? $product_query = $this->getWithImage($product_query) : null;

        return Db::getInstance()->executeS($product_query);
    }
}
