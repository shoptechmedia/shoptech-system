<?php

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class AdditionalProductsTabs extends Module
{
	public function __construct()
	{
		$this->name = 'additionalproductstabs';
		$this->author = 'IQIT-COMMERCE.COM';
		$this->tab = 'front_office_features';
		$this->version = '1.2';

		$this->bootstrap = true;
		parent::__construct();	

		$this->displayName = $this->l('Additional product page content block and tab');
		$this->description = $this->l('Adds contents block on product page');
		$path = dirname(__FILE__);
		if (strpos(__FILE__, 'Module.php') !== false)
			$path .= '/../modules/'.$this->name;
		include_once $path.'/AdditionalTabClass.php';
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	}
	
	public function install()
	{	
		$text = array($this->context->language->id => '<p class="info-paragraph-icon"><em class="icon-plane circle-icon"></em> We shipping worldwide... <a href="http://www.iqit-commerce.com">Read more</a></p><p class="info-paragraph-icon"><em class="icon-time circle-icon"></em> Delivery in 24h</p><p class="info-paragraph-icon"><em class="icon-umbrella circle-icon"></em> We have reinsurance program</p><p class="info-paragraph-icon"><em class="icon-trophy circle-icon"></em> Our shop is awarded for security</p>');
		$textt = array($this->context->language->id => 'Sample text');
		
		if (!parent::install() 
			|| !Configuration::updateValue('additionalproductstabs_text', $text, true)
			|| !Configuration::updateValue('additionalproductstabs_text_t', $textt, true)
			|| !Configuration::updateValue('additionalproductstabs_status', 0)
			|| !Configuration::updateValue('additionalproductstabs_title', array($this->context->language->id => 'Sample tab'))
			|| !$this->registerHook('productTab')
			|| !$this->registerHook('productTabContent') 
			|| !$this->registerHook('displayAdminProductsExtra')
			|| !$this->registerHook('actionProductUpdate')
			|| !$this->registerHook('actionProductDelete')	
			|| !$this->registerHook('header') || !$this->registerHook('productPageRight'))
			return false;

		$res = Db::getInstance()->execute(
			'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'additionalproductstabs` (
				`id_additionalproductstab` int(10) unsigned NOT NULL auto_increment,
				`id_shop` int(10) unsigned NOT NULL,
				`id_product` int(10) unsigned NOT NULL,
				`activeAdditionalTab` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_additionalproductstab`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
		);

		if ($res)
			$res &= Db::getInstance()->execute(
				'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'additionalproductstabs_lang` (
					`id_additionalproductstab` int(10) unsigned NOT NULL,
					`id_lang` int(10) unsigned NOT NULL,
					`titleAdditionalTab` varchar(255) NOT NULL,
					`contentAdditionalTab` text NOT NULL,
					PRIMARY KEY (`id_additionalproductstab`, `id_lang`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
		);


		if (!$res)
			$res &= $this->uninstall();

		return (bool)$res;
	}
	
	public function uninstall()
	{	
		$res = Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'additionalproductstabs`');
		$res &= Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'additionalproductstabs_lang`');

		if ($res == 0 || !parent::uninstall() || !Configuration::deleteByName('additionalproductstabs_status') || !Configuration::deleteByName('additionalproductstabs_text') || !Configuration::deleteByName('additionalproductstabs_title') || !Configuration::deleteByName('additionalproductstabs_text_t'))
			return false;

		return true;
	}
	
	public function getContent()
	{
		$html = '';
		// If we try to update the settings
		if (Tools::isSubmit('submitModule'))
		{	
			
			$message_trads = array();
			$message_trads_t = array();
			foreach ($_POST as $key => $value)
			{
				if (preg_match('/additionalproductstabs_text_/i', $key))
				{
					$id_lang = preg_split('/additionalproductstabs_text_/i', $key);
					$message_trads[(int)$id_lang[1]] = $value;
				}
				if (preg_match('/additionalproductstabs_text_t_/i', $key))
				{
					$id_lang = preg_split('/additionalproductstabs_text_t_/i', $key);
					$message_trads_t[(int)$id_lang[1]] = $value;
				}
			}
				
				Configuration::updateValue('additionalproductstabs_text', $message_trads, true);
				Configuration::updateValue('additionalproductstabs_text_t', $message_trads_t, true);
				Configuration::updateValue('additionalproductstabs_status', Tools::getValue('additionalproductstabs_status'));


				$languages = Language::getLanguages();
				$result = array();
				foreach ($languages as $language)
					$result[$language['id_lang']] = $_POST['additionalproductstabs_title_'.$language['id_lang']];
				Configuration::updateValue('additionalproductstabs_title', $result);

				$this->_clearCache('additionalproductstabs.tpl');
				$html .= $this->displayConfirmation($this->l('Configuration updated'));
			}

			$html .= $this->renderForm();

			return $html;
		}

		public function hookDisplayAdminProductsExtra($params) {

			if (Validate::isLoadedObject($product = new Product((int)Tools::getValue('id_product'))))
			{
				$var =  array();
				$id_shop = (int)$this->context->shop->id;
				$tab = AdditionalTabClass::getTab($id_shop, (int)Tools::getValue('id_product'));

				if(!empty($tab) && isset($tab->id)){
					foreach (Language::getLanguages(false) as $lang)
					{
						$var['titleAdditionalTab'][(int)$lang['id_lang']] = $tab->titleAdditionalTab[(int)$lang['id_lang']];
						$var['contentAdditionalTab'][(int)$lang['id_lang']] = $tab->contentAdditionalTab[(int)$lang['id_lang']];
					}
					$var['activeAdditionalTab'] = $tab->activeAdditionalTab;
				}


				$this->context->smarty->assign(array(
					'languages' => $this->context->controller->getLanguages(),
					'id_lang' => $this->context->language->id,
					'activeAdditionalTab' => (isset($var['activeAdditionalTab']) ? $var['activeAdditionalTab'] : 0),
					'titleAdditionalTab' => (!empty($var['titleAdditionalTab']) ? $var['titleAdditionalTab'] : ''),
					'contentAdditionalTab' => (!empty($var['contentAdditionalTab']) ? $var['contentAdditionalTab'] : '')
					));

				return $this->display(__FILE__, 'views/templates/admin/addtab.tpl');
			}
			else{
				return $this->displayError($this->l('You must save this product before adding tabs'));
			}
		}

		public function hookHeader()
		{	
			if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'product')
			return;
			$this->context->controller->addCSS(($this->_path).'additionalproductstabs.css', 'all');
		}

		public function hookproductPageRight($params)
		{	
			if (!$this->isCached('additionalproductstabs.tpl', $this->getCacheId()))
				$this->smarty->assign(array(
					'additionalproductstabs_text' => Configuration::get('additionalproductstabs_text', $this->context->language->id)

					));
			return $this->display(__FILE__, 'additionalproductstabs.tpl', $this->getCacheId());
		}

		public function hookProductTab($params) {
			
			if(!isset($params['product']))
				return; 

			$cache_id = 'additionalproductstabs|tab|'.(int)$params['product']->id;

			if (!$this->isCached('tab.tpl', $this->getCacheId($cache_id)))
			{  
				$id_shop = (int)$this->context->shop->id;
				$tab = AdditionalTabClass::getTab($id_shop, (int)$params['product']->id);
				if(!empty($tab) && isset($tab->id) && $tab->activeAdditionalTab){
					$this->context->smarty->assign(array('tabName' => $tab->titleAdditionalTab[$this->context->language->id]));
				}
				if(Configuration::get('additionalproductstabs_status'))
					$this->context->smarty->assign(array('tabNameGlobal' => Configuration::get('additionalproductstabs_title', $this->context->language->id)));
			}
			return $this->display(__FILE__, 'tab.tpl', $this->getCacheId($cache_id));
		}

		public function hookProductTabContent($params) {
			
			if(!isset($params['product']))
				return; 

			$cache_id = 'additionalproductstabs|tabcontent|'.(int)$params['product']->id;

			if (!$this->isCached('additionaltab.tpl', $this->getCacheId($cache_id)))
			{  
				$id_shop = (int)$this->context->shop->id;
				$tab = AdditionalTabClass::getTab($id_shop, (int)$params['product']->id);
				if(!empty($tab) && isset($tab->id) && $tab->activeAdditionalTab){
					$this->context->smarty->assign(array('tabContent' => $tab->contentAdditionalTab[$this->context->language->id]));
					$this->context->smarty->assign(array('tabName' => $tab->titleAdditionalTab[$this->context->language->id]));
				}
				if(Configuration::get('additionalproductstabs_status')){
					$this->context->smarty->assign(array('tabContentGlobal' => Configuration::get('additionalproductstabs_text_t', $this->context->language->id)));
					$this->context->smarty->assign(array('tabNameGlobal' => Configuration::get('additionalproductstabs_title', $this->context->language->id)));
					}
			}
			return $this->display(__FILE__, 'additionaltab.tpl', $this->getCacheId($cache_id));
		}



		public function renderForm()
		{
			$fields_form = array(
				'form' => array(
					'legend' => array(
						'title' => $this->l('Settings'),
						'icon' => 'icon-cogs'
						),
					'input' => array(
						array(
							'type' => 'textarea',
							'lang' => true,
							'autoload_rte' => true,
							'label' => $this->l('Product right block text'),
							'name' => 'additionalproductstabs_text',
							'desc' => $this->l('Same content for all products')	
							),
						array(
						'type' => 'switch',
						'label' => $this->l('Status of tab'),
						'name' => 'additionalproductstabs_status',
						'desc' => $this->l('Determine to show or not tab'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
						array(
						'type' => 'text',
						'label' => $this->l('Product tab title'),
						'name' => 'additionalproductstabs_title',
						'desc' => $this->l('Same title for all products'),
						'lang' => true,
						),
						array(
							'type' => 'textarea',
							'lang' => true,
							'autoload_rte' => true,
							'label' => $this->l('Product tab text'),
							'name' => 'additionalproductstabs_text_t',
							'desc' => $this->l('Same content for all products. Content per product you can set during product creation/edit')	
							),
						),
					'submit' => array(
						'title' => $this->l('Save')
						)
					),
				);

			$helper = new HelperForm();
			$helper->show_toolbar = false;
			$helper->table =  $this->table;
			$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
			$helper->default_form_language = $lang->id;
			$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
			$this->fields_form = array();

			$helper->identifier = $this->identifier;
			$helper->submit_action = 'submitModule';
			$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
			$helper->token = Tools::getAdminTokenLite('AdminModules');
			$helper->tpl_vars = array(
				'fields_value' => $this->getConfigFieldsValues(),
				'languages' => $this->context->controller->getLanguages(),
				'id_language' => $this->context->language->id
				);

			return $helper->generateForm(array($fields_form));
		}


		public function getConfigFieldsValues()
		{
			$var =  array();

			foreach (Language::getLanguages(false) as $lang)
			{
				$var['additionalproductstabs_text'][(int)$lang['id_lang']] = Tools::getValue('additionalproductstabs_text_'.(int)$lang['id_lang'], Configuration::get('additionalproductstabs_text', (int)$lang['id_lang']));
				$var['additionalproductstabs_text_t'][(int)$lang['id_lang']] = Tools::getValue('additionalproductstabs_text_t_'.(int)$lang['id_lang'], Configuration::get('additionalproductstabs_text_t', (int)$lang['id_lang']));

				$var['additionalproductstabs_title'][(int)$lang['id_lang']] = Tools::getValue('additionalproductstabs_title', Configuration::get('additionalproductstabs_title', (int)$lang['id_lang']));
			}	
			$var['additionalproductstabs_status'] = Tools::getValue('additionalproductstabs_status', Configuration::get('additionalproductstabs_status'));
				

			return $var;
		}

		public function hookActionProductUpdate($params)
		{
			$id_product = (int)Tools::getValue('id_product');
			$id_shop = (int)$this->context->shop->id;

			$tab = AdditionalTabClass::getTab($id_shop, $id_product);

			$tab->id_shop = $id_shop;
			$tab->id_product = $id_product;

			$tab->copyFromPost();

			if(!empty($tab) && isset($tab->id)){
				$tab->update();
			} else {
				if($tab->activeAdditionalTab)
					$tab->add();
			}

			$this->clearCache();
		}

		public function hookActionProductDelete($params)
		{
			$id_product = (int)Tools::getValue('id_product');
			$id_shop = (int)$this->context->shop->id;

			$tab = AdditionalTabClass::getTab($id_shop, $id_product);

			if(!empty($tab) && isset($tab->id))
				$tab->delete();

			$this->clearCache();
		}

		public function clearCache()
		{
			$this->_clearCache('tab.tpl');
			$this->_clearCache('additionaltab.tpl');
		}
	}
