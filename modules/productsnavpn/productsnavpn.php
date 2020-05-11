<?php

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class ProductsNavpn extends Module
{
	public function __construct()
	{
		$this->name = 'productsnavpn';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'IQIT-COMMERCE.COM';
		$this->bootstrap = true;

		parent::__construct();	

		$this->displayName = $this->l('Product page navigation arrows');
		$this->description = $this->l('Adds previous and next product links on product page ');
	}

	public function install()
	{
		return (parent::install() AND $this->registerHook('productnavs') AND  $this->registerHook('displayHeader'));
	}
	
	public function uninstall()
	{
		return (parent::uninstall());
	}
	
	public function hookDisplayHeader()
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'product')
			return;
		$this->context->controller->addCSS(($this->_path).'productsnavpn.css', 'all');
	}
	
	public function hookproductnavs($params) {

		$id_product = (int)Tools::getValue('id_product');
		if (!$id_product)
			return true;

		$id_product = (int) $id_product;
		$product = new Product($id_product, false, (int)Context::getContext()->language->id);


		if ((!isset($this->context->cookie->last_visited_category)) AND Validate::isLoadedObject($product)){
			$id_category_default = (int)$product->id_category_default;
		} else{
			$id_category_default = (int)$this->context->cookie->last_visited_category;
		}
		
		; 

        $position = $this->getPositionInCategory($id_product, $id_category_default);

        $previous = $this->getPreviousInCategory($position, $id_category_default);
        $next = $this->getNextInCategory($position, $id_category_default);


      

        $links = array();

        if (isset($next) && $next > 0) {
            $next = $this->context->link->getProductLink($next);
            $links['next'] = $next;
        }

        if (isset($previous) && $previous > 0) {
            $previous = $this->context->link->getProductLink($previous);
            $links['previous'] = $previous;
        }
				
		$this->context->smarty->assign($links);

	
		return $this->display(__FILE__, 'productsnavpn.tpl');
	}


	public function getPositionInCategory($id_product, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT position
            FROM `'._DB_PREFIX_.'category_product`
            WHERE id_category = '.(int)$id_category.'
            AND id_product = '.(int)$id_product);
        return (int) $result['position'];
    }

    public function getNextInCategory($position, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT cp.id_product as id_product
            FROM `'._DB_PREFIX_.'category_product` as cp
            RIGHT JOIN `'._DB_PREFIX_.'product` as p
            ON p.id_product=cp.id_product
            WHERE cp.id_category = '.(int)$id_category.'
            AND p.active = 1
            AND cp.position > '.(int)$position.' ORDER BY cp.position ASC');


        if (isset($result['id_product']))
            return (int) $result['id_product'];
    }

    public function getPreviousInCategory($position, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT cp.id_product  as id_product
            FROM `'._DB_PREFIX_.'category_product` as cp
            RIGHT JOIN `'._DB_PREFIX_.'product` as p
            ON p.id_product=cp.id_product
            WHERE cp.id_category = '.(int)$id_category.'
            AND p.active = 1
            AND cp.position < '.(int)$position.' ORDER BY cp.position DESC');
        if (isset($result['id_product']))
            return (int) $result['id_product'];
    }
	
	
	public function hookHome($params)
	{
		$this->context->cookie->last_visited_category = 2;	
	}
}