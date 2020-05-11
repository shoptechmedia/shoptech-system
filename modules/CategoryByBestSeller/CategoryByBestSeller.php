<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class CategoryByBestSeller extends Module{

	public $languages;

	public $language;

	public function __construct(){
		$this->name = 'CategoryByBestSeller';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'Prestaspeed.dk';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Category By Best Seller');
		$this->description = $this->l('Provide an option to sort products in category pages by Best Seller');

	    $this->language = $this->context->language->id;

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		if(!Configuration::get('CategoryByBestSeller'))
			$this->warning = $this->l('No name provided');
	}

	public function install(){
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (
			!parent::install() ||
			!$this->registerHook('header') ||
			!$this->registerHook('footer') ||
			!$this->registerHook('actionProductListOverride')
		)
			return false;

		Configuration::updateValue('STM_MODULE_KEY', 0);

		return true;
	}

	public function uninstall(){
		Configuration::updateValue('STM_MODULE_KEY', 0);

		if (
			!parent::uninstall()
		)
			return false;

		return true;
	}

	/*public function getContent(){
		$output = null;

		$this->languages = Language::getLanguages(false);

		foreach ($this->languages as $k => $language)
			$this->languages[$k]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));

		if (Tools::isSubmit('submit'.$this->name)){
		}

		return $output.$this->displayForm();
	}*/

	public function displayForm(){

	}

	public function hookActionProductListOverride($params){
		if(Configuration::get('PS_PRODUCTS_ORDER_BY') == 8){

			$order = (Configuration::get('PS_PRODUCTS_ORDER_WAY') == 1) ? 'DESC' : 'ASC';

			$front = in_array($this->context->controller->controller_type, array('front', 'modulefront'));
			$id_supplier = (int)Tools::getValue('id_supplier');

			$nb_days_new_product = Configuration::get('PS_NB_DAYS_NEW_PRODUCT');
			if (!Validate::isUnsignedInt($nb_days_new_product)) {
				$nb_days_new_product = 20;
			}

			$n = Configuration::get('PS_PRODUCTS_PER_PAGE');

			$pn = (int) Tools::getValue('p');
			$p = 0;

			if($pn){
				$p = 0 + ($n * $pn) - $n;
			}

			$sql  = '
					SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) AS quantity'.(Combination::isFeatureActive() ? ', IFNULL(product_attribute_shop.id_product_attribute, 0) AS id_product_attribute,
					product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity' : '').', pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, image_shop.`id_image` id_image,
					il.`legend` as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,
					DATEDIFF(product_shop.`date_add`, DATE_SUB("'.date('Y-m-d').' 00:00:00",
					INTERVAL '.(int)$nb_days_new_product.' DAY)) > 0 AS new, product_shop.price AS orderprice,
					op.total_sold
			';

			$sql .= '
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p
					ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').
				(Combination::isFeatureActive() ? ' LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop
				ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)$this->context->shop->id.')':'').'
				'.Product::sqlStock('p', 0).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$this->context->language->id.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$this->context->language->id.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
					ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int)$this->context->shop->id.')
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int)$this->context->language->id.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`

				LEFT JOIN (
					SELECT product_id as id_product, SUM(product_quantity) as total_sold FROM `'._DB_PREFIX_.'order_detail` od
					GROUP BY product_id
				) as op ON (op.id_product = p.id_product)
			';

			$sql .= '
				WHERE product_shop.`id_shop` = '.(int)$this->context->shop->id.'
					AND cp.`id_category` = '. (int) Tools::getValue('id_category')
				. ' AND product_shop.`active` = 1'
				.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
				.($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '');

			if(isset($_COOKIE['ProductsSortBy'])){
				if($_COOKIE['ProductsSortBy'] == 'date'){
					$sql .= '
						ORDER BY product_shop.`date_add` DESC
					';
				}elseif($_COOKIE['ProductsSortBy'] == 'price'){
					$sql .= '
						ORDER BY product_shop.price ASC
					';
				}else{
					$sql .= '
						ORDER BY op.total_sold ' . $order . '
					';
				}
			}else{
				if($_GET['id_category'] == '18'){
					$sql .= '
						ORDER BY product_shop.`date_add` DESC
					';
				}else{
					$sql .= '
						ORDER BY op.total_sold ' . $order . '
					';
				}
			}

			$all = Db::getInstance()->executeS($sql);

			$sql .= '
				LIMIT ' . $p . ', ' . $n;

			$products = Db::getInstance()->executeS($sql);

			if($_SERVER['HTTP_X_FORWARDED_FOR'] == '112.204.140.168'){
				//$products = array_slice($all, $p, Configuration::get('PS_PRODUCTS_PER_PAGE'));

				//print_r($products);
				//exit;
			}

			$all = count($all);

			//$offset = 0;

			//$products = array_slice($products, 0, Configuration::get('PS_PRODUCTS_PER_PAGE'));

			if($products){
				$products = Product::getProductsProperties($this->context->language->id, $products);
			}

			// Inform the hook was executed
			$params['hookExecuted'] = true;

			$params['catProducts'] = $products;

			$params['nbProducts'] = $all;
    	}
    }
}