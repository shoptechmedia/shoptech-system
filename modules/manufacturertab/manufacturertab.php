<?php

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class ManufacturerTab extends Module
{
	public function __construct()
	{
		$this->name = 'manufacturertab';
		$this->author = 'IQIT-COMMERCE.COM';
		if (version_compare(_PS_VERSION_, '1.4.0.0') >= 0)
			$this->tab = 'front_office_features';
		else
			$this->tab = 'Blocks';
		$this->version = '1.1';

		$this->bootstrap = true;
		parent::__construct();	

		$this->displayName = $this->l('Manufacturer tab on product page');
		$this->description = $this->l('Adds manufacturer information on product page');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	}
	
	public function install()
	{	
		
		if (!parent::install() 
			|| !$this->registerHook('productTab')
			|| !$this->registerHook('productTabContent') 
			|| !$this->registerHook('actionProductUpdate')
			|| !$this->registerHook('actionProductDelete')	
			|| !$this->registerHook('header'))
			return false;

		return true;
	}
	
	public function uninstall()
	{	
		return parent::uninstall();
	}
	
	public function hookProductTab($params) {

		if(isset($params['product']->id_manufacturer)) {
			$manufacturer_id = (int)$params['product']->id_manufacturer;
			$cache_id = 'manufacturertab|tab|'.$manufacturer_id;

			if (!$this->isCached('tab.tpl', $this->getCacheId($cache_id)))
			{  
				
				$manufacturer = new Manufacturer($manufacturer_id, $this->context->language->id);
				if(!empty($manufacturer->description) && isset($manufacturer->description)){
					$this->context->smarty->assign(array('showTab' => true));
				}
				
			}
			return $this->display(__FILE__, 'tab.tpl', $this->getCacheId($cache_id));
		}
		else return;

	}

		public function hookProductTabContent($params) {

		if(isset($params['product']->id_manufacturer)) {
			$manufacturer_id = (int)$params['product']->id_manufacturer;

			$cache_id = 'manufacturertab|tabcontent|'.$manufacturer_id;

			if (!$this->isCached('manufacturertab.tpl', $this->getCacheId($cache_id)))
			{  
				$manufacturer = new Manufacturer($manufacturer_id, $this->context->language->id);
				
				$manufacturer->description = Tools::nl2br(trim($manufacturer->description));
		
				if(!empty($manufacturer->description) && isset($manufacturer->description)){
					$this->context->smarty->assign(array('tabContent' => $manufacturer->description));
				}
			}
			return $this->display(__FILE__, 'manufacturertab.tpl', $this->getCacheId($cache_id));

		}
		else return;
		}

		public function hookActionProductUpdate($params)
		{
			$this->clearCache();
		}

		public function hookActionProductDelete($params)
		{
			$this->clearCache();
		}

		public function clearCache()
		{
			$this->_clearCache('tab.tpl');
			$this->_clearCache('manufacturertab.tpl');
		}
	}
