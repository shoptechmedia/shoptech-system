<?php

if (!defined('_PS_VERSION_')){
    exit;
}

class HolidaySaleholidaypageModuleFrontController extends ModuleFrontController{
    public function init(){
        // Get category ID
        $this->prefix = _DB_PREFIX_;
        $id_holiday_sale = (int) Tools::getValue('id_holiday_sale');

        if (!$id_holiday_sale || !Validate::isUnsignedId($id_holiday_sale)) {
            $this->errors[] = Tools::displayError('Missing category ID');
        }else{
            $isOnShop = Db::getInstance()->getValue("SELECT id_holiday_sale FROM {$this->prefix}holiday_sale as hs WHERE hs.id_shop = {$this->context->shop->id}");

            if($isOnShop){
                // Instantiate category
                include(dirname(dirname(__DIR__)) . '/classes/HolidayPage.php');
                $this->holiday = new HolidayPage($id_holiday_sale, $this->context->language->id);
            }
        }

        parent::init();
    }

    public function initContent(){
        parent::initContent();

        $this->setTemplate('holiday_sale.tpl');

        $selected_products = Db::getInstance()->executeS("
            SELECT p.*, pl.*, m.name as manufacturer_name, hsp.id_product, i.id_image, hsp.hsd_from, hsp.hsd_to, hsp.hsd_reduction, hsp.hsd_reduction_type, hsp.hsd_reduction_tax, hsp.id_specific_price FROM {$this->prefix}holiday_sale_products as hsp
            LEFT JOIN {$this->prefix}product as p ON (p.id_product = hsp.id_product)
            LEFT JOIN {$this->prefix}product_lang as pl ON (pl.id_product = hsp.id_product AND pl.id_lang = {$this->context->language->id} AND pl.id_shop = {$this->context->shop->id})
            LEFT JOIN {$this->prefix}image as i ON (i.id_product = hsp.id_product AND i.cover = 1)
            LEFT JOIN {$this->prefix}manufacturer as m ON (m.id_manufacturer = p.id_manufacturer)
            WHERE hsp.id_holiday_sale = '{$this->holiday->id}'
            ORDER BY hsp.id_product DESC, hsp.id_specific_price DESC
        ");

        $products = Product::getProductsProperties($this->context->language->id, $selected_products);

        foreach($products as &$product) {
            $specificPriceReduction = 0;
            $useTax = $product['hsd_reduction_tax']; // Configuration::get('PS_TAX');
            $sp = new SpecificPrice($product['id_specific_price']);

            if(is_array($sp)){
                $discount = $sp['reduction'];
                $type = $sp['reduction_type'];
                $sp_price = $sp['price'];
            }else{
                $discount = $sp->reduction;
                $type = $sp->reduction_type;
                $sp_price = $sp->price;
            }

            $sql = new DbQuery();
            $sql->select('product_shop.`price`');
            $sql->from('product', 'p');
            $sql->innerJoin('product_shop', 'product_shop', '(product_shop.id_product=p.id_product AND product_shop.id_shop = '.(int) $this->context->shop->id.')');
            $sql->where('p.`id_product` = '.(int) $product['id_product']);

            $price = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

            if($useTax) {
                $address = new Address();
                $address->id_country = Configuration::get('PS_COUNTRY_DEFAULT');
                $address->id_state = 0;
                $address->postcode = 0;

                $taxManager = TaxManagerFactory::getManager($address, Product::getIdTaxRulesGroupByIdProduct((int) $product['id_product'], $context));
                $productTaxCalculator = $taxManager->getTaxCalculator();

                $price = $productTaxCalculator->addTaxes($price);
            }

            // Reduction
            $specificPriceReduction = 0;

            if ($type == 'amount') {
                $specificPriceReduction = $discount;
            } else {
                $specificPriceReduction = $price * $discount;
            }

            $price -= $specificPriceReduction;

            if ($sp_price > 0) {
                if($sp_price < $price){
                    $discount = $price - $sp_price;
                }

                $price = (float) $sp_price;
            }

            if($type == 'percentage'){
                $product['hsd_reduction'] = $discount * 100;
            }else{
                $product['hsd_reduction'] = ($discount / ($price + $discount) ) * 100;
            }

            $product['hsd_reduction'] = (int) round($product['hsd_reduction']);

            if($discount > 0) {
                $product['reduction_type'] = $product['hsd_reduction_type'];

                $product['reduction'] = $product['hsd_reduction'];
                $product['price'] = $price;
            } else {
                $product['price'] = $price;
                $product['reduction'] = 0;
            }
        }

        /*print_r($products);
        exit;*/

        $this->holiday->release_date = strtotime($this->holiday->release_date);
        $this->holiday->end_date = strtotime($this->holiday->end_date);

        $this->holiday->countdown_text = $this->holiday->starting_text;

        if($this->holiday->release_date < time()) {
            $this->holiday->countdown_text = $this->holiday->ending_text;
        }

        if($this->holiday->end_date < time()) {
            $this->holiday->hide_products = 1;
        }

        if(!$this->holiday->banner_image){
            $this->holiday->banner_image = '/modules/HolidaySale/img/marker.png';
        }else{
            $this->holiday->banner_image = '/upload/' . $this->holiday->banner_image;
        }

        $this->context->smarty->assign(
            [
                'tpl_dir2' => dirname(dirname(__DIR__)) . '/views/templates/front',
                'body_classes' => [$this->php_self.'-'.$this->holiday->id, $this->php_self.'-'.$this->holiday->link_rewrite],
                'holiday' => $this->holiday,
                'products' => $products,
                'meta_title' => $this->holiday->meta_title,
                'meta_description' => $this->holiday->meta_description
            ]
        );
    }
}