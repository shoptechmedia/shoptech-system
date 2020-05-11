<?php

if (!defined('_PS_VERSION_')) {
	exit;
}

class noindex extends Module {

	public function __construct()
	{
		$this->name = 'noindex';
		$this->tab = 'No index No Follow Module';
		$this->author = 'Prestaspeed.dk';
		$this->version = 1.0;
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('No index No Follow Module');

		$this->description = $this->l('Add a No index No Follow in the header');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	public function install() {
		if (!parent::install()
        || !$this->registerHook('displayAddMetaTags')
        || !$this->registerHook('displayBackOfficeFooter')
        || !$this->registerHook('displayAfterTitle')
        || !Configuration::updateValue('is_noindex', true) ) {
			return false;
		}

		Configuration::updateValue('STM_MODULE_KEY', 0);

		return true;
	}

	public function uninstall() {
		if (!parent::uninstall()) {
			return false;
		}

		return true;
	}

	public function hookDisplayBackOfficeFooter($params)
	{
		$url = $this->context->link->getAdminLink('AdminModules');

		$id_tab = (int)Tab::getIdFromClassName('AdminModules');
		$id_employee = (int)$this->context->cookie->id_employee;
		$token = Tools::getAdminToken('AdminModules'.$id_tab.$id_employee);
		if (Configuration::get('is_noindex') != 0) {
	    	$content = '
	    		<style>
	    			div#noindex{
					    padding: 32px;
					    display: inline-block;
					    float: left;
					    font-size: 16px;
					    font-weight: 600;
				    }
				</style>
			';
			$content .= '<script>
				var url = "'.$url.'"+"&configure=noindex";
			</script>';

			$content .= '<script src="'.$this->_path . 'main.js?v='.time().'"></script>';
			return $content;
		} else {
		}

	}

	public function hookDisplayAfterTitle() {
		if (Configuration::get('is_noindex') != 0) {
			return '<meta name="robots" content="NOINDEX,NOFOLLOW"/>';
		}
	}

	public function getContent() {
		$output = null;
	    if (Tools::isSubmit('submitNoIndexModule'))
	    {
            Configuration::updateValue('is_noindex', $_POST['noindex']);
            $output .= $this->displayConfirmation($this->l('Settings updated'));
	    }

		return $output.$this->displayForm();
	}

	public function displayForm() {
		$helper = new HelperForm();

		$helper->show_toolbar = false;
		$helper->module = $this;
		$helper->default_form_language = $this->context->language->id;

		$helper->submit_action = 'submitNoIndexModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
			.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$helper->fields_value['noindex'] = Configuration::get('is_noindex');
		return $helper->generateForm(array($this->getConfigForm()));
	}

	protected function getConfigForm()
	{
		return array(
			'form' => array(
				'legend' => array(
				'title' => $this->l('Settings'),
				'icon' => 'icon-cogs',
				),
				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('No Index NO Follow'),
						'name' => 'noindex',
						'is_bool' => true,
						'desc' => $this->l('Add no index no follow to the header'),
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
			)
		);
	}

}