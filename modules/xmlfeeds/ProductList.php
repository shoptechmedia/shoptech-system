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

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductList
{
    public function getProductsByProductList($productList)
    {
        $products = array();

        $result = Db::getInstance()->executeS('
			SELECT DISTINCT(lp.product_id)
			FROM `'._DB_PREFIX_.'blmod_xml_product_list_product` lp
			WHERE lp.product_list_id IN ('.$productList.')
		');

        foreach ($result as $p) {
            $products[] = $p['product_id'];
        }

        return $products;
    }
}
