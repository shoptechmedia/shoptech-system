<?php

class BlockAlert extends Module{
	public $currentDate;

	public $language;

	public $languages;

	public function __construct(){
		$this->name = 'blockalert';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'Prestaspeed.dk';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->templateDir = __DIR__ . '/templates';

		$this->displayName = $this->l('Block Alert');
		$this->description = $this->l('Display Alert Notification at the very top of your website');

	    $this->language = $this->context->language->id;

	    $this->currentDate = $this->context->language->date_format_lite;

		$this->languages = Language::getLanguages(false);

		foreach ($this->languages as $k => $language){
			$this->languages[$k]['is_default'] = (int) ($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
		}

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		if(!Configuration::get('blockalert'))
			$this->warning = $this->l('No name provided');
	}

	public function install(){
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (
			!parent::install() ||
			!$this->registerHook('displayAfterBodyOpeningTag') ||
			!$this->registerHook('displayHeader')
		)
			return false;

		return true;
	}

	public function uninstall(){
		if (
			!parent::uninstall()
		)
			return false;

		return true;
	}

	public function getContent(){
		$prefix = _DB_PREFIX_;
		$AlertDescription = [];

		if(Tools::isSubmit('submitBlockAlert')) {
			$AlertBGColor = Tools::getValue('AlertBGColor');
			$AlertTxtColor = Tools::getValue('AlertTxtColor');

			foreach ($this->languages as $language){
				$AlertDescription[ $language['id_lang'] ] = Tools::getValue('AlertDescription_' . $language['id_lang']);
			}

			Configuration::updateValue('BlockAlert_AlertDescription', $AlertDescription, true);
			Configuration::updateValue('BlockAlert_AlertBGColor', $AlertBGColor);
			Configuration::updateValue('BlockAlert_AlertTxtColor', $AlertTxtColor);

			header('Location: index.php?controller=AdminModules&token=' . Tools::getValue('token') . '&configure=' . Tools::getValue('configure') . '&conf=12');
			exit;
		}

		$form = $this->context->controller;

	    foreach($this->languages as $language){
	    	$AlertDescription[ $language['id_lang'] ] = Configuration::get('BlockAlert_AlertDescription', $language['id_lang']);
	    }

	    $form->fields_value = [
	    	'AlertDescription' => $AlertDescription,
	    	'AlertBGColor' => Configuration::get('BlockAlert_AlertBGColor'),
	    	'AlertTxtColor' => Configuration::get('BlockAlert_AlertTxtColor'),
	    	'configure' => Tools::getValue('configure'),
	    ];

		$input_fields = [];

		$input_fields[] = [
			'type'     => 'hidden',
			'name'     => 'configure'
		];

		$input_fields[] = [
			'type'     => 'textarea',
			'label'    => $this->l('Alert Description'),
			'name'     => 'AlertDescription',
			'autoload_rte' => true,
			'lang'	   => true
		];

		$input_fields[] = [
			'type'     => 'color',
			'label'    => $this->l('Alert Background Color'),
			'name'     => 'AlertBGColor'
		];

		$input_fields[] = [
			'type'     => 'color',
			'label'    => $this->l('Alert Text Color'),
			'name'     => 'AlertTxtColor'
		];

		$form->fields_form = [
			'tinymce' => true,
			'class' => 'hidden',
			'legend'  => [
				'title' => $this->l('Alert Notification Block'),
				'icon'  => 'icon-folder-close',
			],

			'input'   => $input_fields,

			'submit'  => [
				'title' => $this->l('Save'),
				'name'  => 'submitBlockAlert'
			]
		];

		return $form->renderForm();
	}

	public function hookDisplayAfterBodyOpeningTag($params) {
		if(Tools::getValue('content_only'))
			return false;

    	$AlertDescription = Configuration::get('BlockAlert_AlertDescription', Configuration::get('PS_LANG_DEFAULT'));

    	$AlertBGColor = Configuration::get('BlockAlert_AlertBGColor');
    	$AlertTxtColor = Configuration::get('BlockAlert_AlertTxtColor');

		$return = '
			<div style="display: none;background-color: ' . $AlertBGColor . ';color: ' . $AlertTxtColor . ';" class="clearfix" id="BlockAlert">
				' . $AlertDescription . '

				<button style="color: ' . $AlertTxtColor . ';" type="button" id="CloseBlockAlert"><span class="icon-close"></span></button>
			</div>
		';

		return $return;
	}

	public function hookDisplayHeader($params) {
		$this->context->controller->addCSS($this->_path.'css/style.css');
		$this->context->controller->addJS($this->_path.'js/script.js');
	}
}