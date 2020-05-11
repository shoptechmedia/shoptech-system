<?php
/**
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class Iqitproducttags extends Module
{
	protected $config_form = false;

	public function __construct()
	{
		$this->name = 'iqitproducttags';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'IQIT-COMMERCE.COM';
		$this->need_instance = 0;

		/**
		 * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
		 */
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Iqitproducttags Show  tags on product page');
		$this->description = $this->l('Show definied products tags on product page');

		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	}

	/**
	 * Don't forget to create update methods if needed:
	 * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
	 */
	public function install()
	{
		Configuration::updateValue('iqittag_hook', 1);

		return parent::install() &&
			$this->registerHook('header') &&
			$this->registerHook('actionProductUpdate') &&
			$this->registerHook('actionProductDelete') &&
			$this->registerHook('displayHeader') &&
			$this->registerHook('extraRight') &&
			$this->registerHook('displayProductButtons');
	}

	public function uninstall()
	{
		Configuration::deleteByName('iqittag_hook');

		return parent::uninstall();
	}

	/**
	 * Load the configuration form
	 */
	public function getContent()
	{
		/**
		 * If values have been submitted in the form, process.
		 */
		if (Tools::isSubmit('submitIqitproducttagsModule'))
		$this->_postProcess();

		$this->context->smarty->assign('module_dir', $this->_path);

		return $this->renderForm();
	}

	/**
	 * Create the form that will be displayed in the configuration of your module.
	 */
	protected function renderForm()
	{
		$helper = new HelperForm();

		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$helper->module = $this;
		$helper->default_form_language = $this->context->language->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitIqitproducttagsModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
			.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
		);

		return $helper->generateForm(array($this->getConfigForm()));
	}

	/**
	 * Create the structure of your form.
	 */
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
						'type' => 'select',
						'label' => $this->l('Module hook'),
						'name' => 'iqittag_hook',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('hookDisplayProductButtons')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('hookExtraRight')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
			),
		);
	}

	/**
	 * Set values for the inputs.
	 */
	protected function getConfigFormValues()
	{
		return array(
			'iqittag_hook' => Configuration::get('iqittag_hook')
		);
	}

	/**
	 * Save form data.
	 */
	protected function _postProcess()
	{
		Configuration::updateValue('iqittag_hook', Tools::getValue('iqittag_hook'));
	}


	/**
	 * Add the CSS & JavaScript files you want to be added on the FO.
	 */
	public function hookHeader()
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'product')
			return;

		$this->context->controller->addCSS($this->_path.'/css/front.css');
	}


	public function hookDisplayProductButtons($params)
	{	
		if(Configuration::get('iqittag_hook'))
		{
		$id_product = (int)Tools::getValue('id_product');
		if (!$this->isCached('iqitproducttags.tpl', $this->getCacheId($id_product)))
		{	
			$tags = Tag::getProductTags($id_product);
			if(is_array($tags))
			$this->smarty->assign(array(
				'tags' => $tags[(int)Context::getContext()->language->id],
			));
		}
		return $this->display(__FILE__, 'iqitproducttags.tpl', $this->getCacheId($id_product));
		}
	}

	public function hookExtraRight($params)
	{	
		if(!Configuration::get('iqittag_hook'))
		{
		$id_product = (int)Tools::getValue('id_product');
		if (!$this->isCached('iqitproducttags.tpl', $this->getCacheId($id_product)))
		{	
			$tags = Tag::getProductTags($id_product);

			if(is_array($tags))
			$this->smarty->assign(array(
				'tags' => $tags[(int)Context::getContext()->language->id],
			));
		}
		return $this->display(__FILE__, 'iqitproducttags.tpl', $this->getCacheId($id_product));
		}
	}

	public function hookActionProductUpdate($params)
	{
		$this->_clearCache('iqitproducttags.tpl');
	}

	public function hookActionProductDelete($params)
	{
		$this->_clearCache('iqitproducttags.tpl');
	}

	public function getCacheId($id_product = null)
	{
		return parent::getCacheId().'|'.(int)$id_product;
	}

}
