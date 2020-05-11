<?php


if (!defined('_PS_VERSION_'))
	exit;

class FooterContent extends Module
{
	public function __construct()
	{
		$this->name = 'footercontent';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'IQIT-COMMERCE.COM';
		$this->need_instance = 0;
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Footer content module');
		$this->description = $this->l('A text-edit module for your footer.');
		$path = dirname(__FILE__);
		if (strpos(__FILE__, 'Module.php') !== false)
			$path .= '/../modules/'.$this->name;
		include_once $path.'/HtmlFooterContent.php';
	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('displayHeader')  || !$this->registerHook('displayAdditionalFooter'))
			return false;

		$res = Db::getInstance()->execute(
			'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'footercontent` (
			`id_content` int(10) unsigned NOT NULL auto_increment,
			`id_shop` int(10) unsigned NOT NULL,
			`width` int(10) unsigned NOT NULL,
			PRIMARY KEY (`id_content`))
			ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
		);

		if ($res)
			$res &= Db::getInstance()->execute(
				'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'footercontent_lang` (
				`id_content` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`body_title` varchar(255) NOT NULL,
				`body_paragraph` text NOT NULL,
				PRIMARY KEY (`id_content`, `id_lang`))
				ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
			);

		if ($res)
			foreach (Shop::getShops(false) as $shop)
				$res &= $this->createExampleContent($shop['id_shop']);

		if (!$res)
			$res &= $this->uninstall();

		return (bool)$res;
	}

	private function createExampleContent($id_shop)
	{
		$footercontent = new HtmlFooterContent();
		$footercontent->id_shop = (int)$id_shop;
		$footercontent->width = 12;
		foreach (Language::getLanguages(false) as $lang)
		{	
			$footercontent->body_title[$lang['id_lang']] = 'Lorem ipsum dolor sit amet';
			$footercontent->body_paragraph[$lang['id_lang']] = '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>';
		}

		return $footercontent->add();
	}

	public function uninstall()
	{
		$res = Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'footercontent`');
		$res &= Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'footercontent_lang`');

		if ($res == 0 || !parent::uninstall())
			return false;

		return true;
	}

	private function initForm()
	{
		$languages = Language::getLanguages(false);
		foreach ($languages as $k => $language)
			$languages[$k]['is_default'] = (int)$language['id_lang'] == Configuration::get('PS_LANG_DEFAULT');

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'footercontent';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->languages = $languages;
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = true;
		$helper->toolbar_scroll = true;
		$helper->toolbar_btn = $this->initToolbar();
		$helper->title = $this->displayName;
		$helper->submit_action = 'submitUpdatefootercontent';

		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->displayName,
				'image' => $this->_path.'logo.gif'
			),
			'submit' => array(
				'name' => 'submitUpdatefootercontent',
				'title' => $this->l('Save '),
				'class' => 'button pull-right'
			),
			'input' => array(
				array(
						'type' => 'select',
						'label' => $this->l('Width of content'),
						'name' => 'width',
						'options' => array(
							'query' => array(
							array(
								'id_option' => 3,
								'name' => $this->l('3/12')
								),
							array(
								'id_option' => 6,
								'name' => $this->l('6/12')
								),
							array(
								'id_option' => 9,
								'name' => $this->l('9/12')
								),
							array(
								'id_option' => 12,
								'name' => $this->l('12/12')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
					array(
					'type' => 'text',
					'label' => $this->l('Main title'),
					'name' => 'body_title',
					'lang' => true,
					'size' => 64,
					'desc' => $this->l('Title of block'),
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Html content'),
					'name' => 'body_paragraph',
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Content of the module'),
					'cols' => 60,
					'rows' => 30
				),
			)
		);

		return $helper;
	}

	private function initToolbar()
	{
		$this->toolbar_btn['save'] = array(
			'href' => '#',
			'desc' => $this->l('Save')
		);

		return $this->toolbar_btn;
	}

	public function getContent()
	{
		$this->_html = '';
		$this->postProcess();

		$helper = $this->initForm();

		$id_shop = (int)$this->context->shop->id;
		$footercontent = HtmlFooterContent::getByIdShop($id_shop);

		if (!$footercontent) //if footercontent ddo not exist for this shop => create a new example one
			$this->createExampleContent($id_shop);

		foreach ($this->fields_form[0]['form']['input'] as $input) //fill all form fields
		{
				$helper->fields_value[$input['name']] = $footercontent->{$input['name']};
		}


		$this->_html .= $helper->generateForm($this->fields_form);

		return $this->_html;
	}

	public function postProcess()
	{
		$errors = '';
		$id_shop = (int)$this->context->shop->id;

		if (Tools::isSubmit('submitUpdatefootercontent'))
		{
			$id_shop = (int)$this->context->shop->id;
			$footercontent = HtmlFooterContent::getByIdShop($id_shop);
			$footercontent->copyFromPost();
			if (empty($footercontent->id_shop))
				$footercontent->id_shop = (int)$id_shop;
			$footercontent->save();

			$this->_html .= $errors == '' ? $this->displayConfirmation($this->l('Settings updated successfully.')) : $errors;
			$this->_clearCache('footercontent.tpl');
			Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.(int)Tab::getIdFromClassName('AdminModules').(int)$this->context->employee->id));
		}

		return true;
	}


	public function hookDisplayFooter($params) {
		return $this -> hookdisplayAdditionalFooter($params);
	}

	public function hookdisplayAdditionalFooter($params) 	
	{
		if (!$this->isCached('footercontent.tpl', $this->getCacheId()))
		{
			 $id_shop = (int)$this->context->shop->id;
			$footercontent = HtmlFooterContent::getByIdShop($id_shop);
			if (!$footercontent)
				return;
			$footercontent = new HtmlFooterContent((int)$footercontent->id, $this->context->language->id);
			if (!$footercontent)
				return;

		
			$this->smarty->assign(
				array(
					'footercontent' => $footercontent,
					'default_lang' => (int)$this->context->language->id,
					'id_lang' => $this->context->language->id,
					)
				);
		}

		return $this->display(__FILE__, 'footercontent.tpl', $this->getCacheId());
	}

	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS(($this->_path).'css/footercontent.css', 'all');
	}
}