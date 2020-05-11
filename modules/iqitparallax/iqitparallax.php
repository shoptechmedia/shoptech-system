<?php


if (!defined('_PS_VERSION_'))
	exit;

class IqitParallax extends Module
{
	public function __construct()
	{
		$this->name = 'iqitparallax';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'IQIT-COMMERCE.COM';
		$this->need_instance = 0;
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Paralax homepage module');
		$this->description = $this->l('A text-edit module for your homepage.');
		$path = dirname(__FILE__);
		if (strpos(__FILE__, 'Module.php') !== false)
			$path .= '/../modules/'.$this->name;
		include_once $path.'/ParallaxHomepage.php';
	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('displayHome') || !$this->registerHook('displayHeader')  || !$this->registerHook('footerTopBanner'))
			return false;



		Configuration::updateValue('iprlx_image', 'homepage_logo_');

		$res = Db::getInstance()->execute(
			'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'parallax` (
			`id_parallax` int(10) unsigned NOT NULL auto_increment,
			`id_shop` int(10) unsigned NOT NULL,
			`hook` int(10) unsigned NOT NULL,
			`width` int(10) unsigned NOT NULL,
			`body_home_logo_link` varchar(255) NULL,
			PRIMARY KEY (`id_parallax`))
			ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
		);

		if ($res)
			$res &= Db::getInstance()->execute(
				'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'parallax_lang` (
				`id_parallax` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`body_paragraph` text NOT NULL,
				PRIMARY KEY (`id_parallax`, `id_lang`))
				ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
			);

		if ($res)
			foreach (Shop::getShops(false) as $shop)
				$res &= $this->createExampleParallax($shop['id_shop']);

		if (!$res)
			$res &= $this->uninstall();

		return (bool)$res;
	}

	private function createExampleParallax($id_shop)
	{
		$parallax = new ParallaxHomepage();
		$parallax->id_shop = (int)$id_shop;
		$parallax->width = 1;
		$parallax->hook = 2;
		foreach (Language::getLanguages(false) as $lang)
		{
			$parallax->body_paragraph[$lang['id_lang']] = '<h1 style="text-align: center;"><span style="color: #ffffff;">The greatest theme for prestashop</span></h1>
<p style="text-align: center;"><span style="color: #ffffff;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span></p>
<p style="text-align: center;"><a class="button btn btn-default standard-checkout button-medium" href="#"><span style="padding: 5px 10px;">See more</span></a></p>';
		}

		return $parallax->add();
	}

	public function uninstall()
	{	
		Configuration::deleteByName('iprlx_image');
		$res = Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'parallax`');
		$res &= Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'parallax_lang`');

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
		$helper->name_controller = 'parallax';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->languages = $languages;
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = true;
		$helper->toolbar_scroll = true;
		$helper->toolbar_btn = $this->initToolbar();
		$helper->title = $this->displayName;
		$helper->submit_action = 'submitUpdateParallax';

		$file = dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$this->context->shop->id.'.jpg';
		$logo = (file_exists($file) ? '<img src="'.$this->_path.'img/'.Configuration::get('iprlx_image').(int)$this->context->shop->id.'.jpg">' : '');

		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->displayName,
				'image' => $this->_path.'logo.gif'
			),
			'submit' => array(
				'name' => 'submitUpdateParallax',
				'title' => $this->l('Save '),
				'class' => 'button pull-right'
			),
			'input' => array(
				array(
						'type' => 'select',
						'label' => $this->l('Hook'),
						'name' => 'hook',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('displayHome(Only homepage)')
								),
							array(
								'id_option' => 2,
								'name' => $this->l('footerTopBanner(All pages)')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
				array(
						'type' => 'select',
						'label' => $this->l('Width of paralax'),
						'name' => 'width',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Full width')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Content width')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
				array(
					'type' => 'textarea',
					'label' => $this->l('Html content'),
					'name' => 'body_paragraph',
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Module content, you can put any html you want'),
					'cols' => 60,
					'rows' => 30
				),
				array(
					'type' => 'file',
					'label' => $this->l('Background image'),
					'name' => 'body_homepage_logo',
					'display_image' => true,
					'image' => $logo,
					'delete_url' => 'index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteLogoImage=1'
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
		$parallax = ParallaxHomepage::getByIdShop($id_shop);

		if (!$parallax) //if parallax ddo not exist for this shop => create a new example one
			$this->createExampleParallax($id_shop);

		foreach ($this->fields_form[0]['form']['input'] as $input) //fill all form fields
		{
			if ($input['name'] != 'body_homepage_logo')
				$helper->fields_value[$input['name']] = $parallax->{$input['name']};
		}

		$file = dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg';
		$helper->fields_value['body_homepage_logo']['image'] = (file_exists($file) ? '<img src="'.$this->_path.'img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg">' : '');
		if ($helper->fields_value['body_homepage_logo'] && file_exists($file))
			$helper->fields_value['body_homepage_logo']['size'] = filesize($file) / 1000;

		$this->_html .= $helper->generateForm($this->fields_form);

		return $this->_html;
	}

	public function postProcess()
	{
		$errors = '';
		$id_shop = (int)$this->context->shop->id;
		// Delete logo image retrocompat 1.5
		if (Tools::isSubmit('deleteLogoImage') || Tools::isSubmit('deleteImage'))
		{
			if (!file_exists(dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg'))
				$errors .= $this->displayError($this->l('This action cannot be made.'));
			else
			{
				unlink(dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg');
				Configuration::updateValue('parallax_IMAGE_DISABLE', 1);
				$this->_clearCache('iqitparallax.tpl');
				Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.(int)Tab::getIdFromClassName('AdminModules').(int)$this->context->employee->id));
			}
			$this->_html .= $errors;
		}

		if (Tools::isSubmit('submitUpdateParallax'))
		{
			$id_shop = (int)$this->context->shop->id;
			$parallax = ParallaxHomepage::getByIdShop($id_shop);
			$parallax->copyFromPost();
			if (empty($parallax->id_shop))
				$parallax->id_shop = (int)$id_shop;
			$parallax->save();

			/* upload the image */
			if (isset($_FILES['body_homepage_logo']) && isset($_FILES['body_homepage_logo']['tmp_name']) && !empty($_FILES['body_homepage_logo']['tmp_name']))
			{
				Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);
				if (file_exists(dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg'))
					unlink(dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg');
				Configuration::updateValue('iprlx_image',md5('homepage_logo_'. time()));
				if ($error = ImageManager::validateUpload($_FILES['body_homepage_logo']))
					$errors .= $error;
				elseif (!($tmp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['body_homepage_logo']['tmp_name'], $tmp_name))
					return false;
				elseif (!ImageManager::resize($tmp_name, dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg'))
					$errors .= $this->displayError($this->l('An error occurred while attempting to upload the image.'));
				if (isset($tmp_name))
					unlink($tmp_name);
			}
			$this->_html .= $errors == '' ? $this->displayConfirmation($this->l('Settings updated successfully.')) : $errors;
			if (file_exists(dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg'))
			{
				list($width, $height, $type, $attr) = getimagesize(dirname(__FILE__).'/img/'.Configuration::get('iprlx_image').(int)$id_shop.'.jpg');
				Configuration::updateValue('parallax_IMAGE_DISABLE', 0);
			}
			$this->_clearCache('iqitparallax.tpl');
			Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.(int)Tab::getIdFromClassName('AdminModules').(int)$this->context->employee->id));
		}

		return true;
	}

	public function hookDisplayHome($params)
	{
		if (!$this->isCached('iqitparallax.tpl', $this->getCacheId()))
		{
			if(!$this->prepareHook(1))
				return;
		}

		return $this->display(__FILE__, 'iqitparallax.tpl', $this->getCacheId());
	}

	public function prepareHook($hook) {

			$id_shop = (int)$this->context->shop->id;
			$parallax = ParallaxHomepage::getByIdShop($id_shop);
			if (!$parallax)
				return false;
			$parallax = new ParallaxHomepage((int)$parallax->id, $this->context->language->id);
			if (!$parallax)
				return false;

			if($parallax->hook!=$hook)
				return false;
			$iprlx_image = Configuration::get('iprlx_image');

			$this->smarty->assign(
				array(
					'parallax' => $parallax,
					'default_lang' => (int)$this->context->language->id,
					'id_lang' => $this->context->language->id,
					'homepage_logo' => !Configuration::get('parallax_IMAGE_DISABLE') && file_exists('modules/parallax/img/'.$iprlx_image.(int)$id_shop.'.jpg'),
					'image_path' => $this->_path.'img/'.$iprlx_image.(int)$id_shop.'.jpg'
					)
				);
			return true;

	}
	public function hookFooterTopBanner($params) 	
	{
		if (!$this->isCached('iqitparallax_footer.tpl', $this->getCacheId()))
		{
			if(!$this->prepareHook(2))
				return;
		}

		return $this->display(__FILE__, 'iqitparallax_footer.tpl', $this->getCacheId());
	}

	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS(($this->_path).'css/iqitparallax.css', 'all');
	}
}