<?php
/*
* 2007-2015 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_TB_VERSION_'))
	exit;

class stmhomedelivery extends Module {

	public function __construct(){
		$this->name = 'stmhomedelivery';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'Shoptech.Media';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;
		$this->error = [];

		parent::__construct();

		$this->displayName = $this->l('Home Delivery by Shoptech.Media');
		$this->description = $this->l('Deliver door to door to your customers');

		$this->language = $this->context->language->id;

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		$this->form = $this->context->controller;
		$this->db = Db::getInstance();
		$this->prefix = _DB_PREFIX_;

		// $this->allowed_view = $_SERVER['REMOTE_ADDR'] == '180.190.174.36';
		$this->allowed_view = true;

		$STMHD_CARRIER = (int) Configuration::get('STMHD_CARRIER');
		$id_reference = $this->db->getValue("
			SELECT id_reference FROM {$this->prefix}carrier
			WHERE id_carrier = '{$STMHD_CARRIER}'
		");

		$this->id_carrier = $this->db->getValue("
			SELECT id_carrier FROM {$this->prefix}carrier
			WHERE id_reference = '{$id_reference}' AND deleted = 0
			ORDER BY id_carrier DESC
		");

		if($this->allowed_view){
			// exit;
		}
	}

	public function install(){
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		try{
        	include(dirname(__FILE__) . '/sql/install.php');
        }catch (Exception $e){

        }

		if (
			!parent::install() ||
			!$this->registerHook('header') ||
			// !$this->registerHook('actionCartSummary') ||
			!$this->registerHook('actionValidateOrder') ||
			!$this->registerHook('displayCarrierList') ||
			!$this->registerHook('backOfficeHeader') ||
			!$this->registerHook('backOfficeTop')
		)
			return false;

		$this->db->Execute("ALTER TABLE `{$this->prefix}cart` ADD `extra_shipping` DECIMAL(10,2) NOT NULL AFTER `secure_key`;");
		$this->db->Execute("ALTER TABLE `{$this->prefix}cart` ADD `extra_shipping_name` VARCHAR(255) NOT NULL AFTER `secure_key`;");
		// Configuration::updateValue('DSD_API_SANDBOX', 1);

		return true;
	}

	public function uninstall(){
		if (
			!parent::uninstall()
		)
			return false;

		return true;
	}

	public function hookHeader($params){
		if($this->allowed_view){

			if(Tools::isSubmit('addExtraShipping')){
				$extraShipping = Tools::getValue('extraShipping', 0);
				$extraShippingName = Tools::getValue('extraShippingName');

				$this->db->Execute("
					UPDATE `{$this->prefix}cart`
					SET extra_shipping = '{$extraShipping}',
						extra_shipping_name = '{$extraShippingName}'
					WHERE id_cart = '{$this->context->cart->id}'
				");

				die(Tools::jsonEncode([]));
			}

			$STMHD_CARRIER = (int) $this->id_carrier;
			$postal_codes = Tools::jsonDecode(Configuration::get('STMHD_POSTAL_CODES'));
			$areas = Tools::jsonDecode(Configuration::get('STMHD_AREAS'));

			$this->context->controller->addJS($this->_path.'js/orderopc.js');
			$this->context->controller->addCSS($this->_path.'css/orderopc.css');

			$extraShipping = (float) $this->db->getValue("SELECT extra_shipping FROM `{$this->prefix}cart` WHERE id_cart = '{$this->context->cart->id}'");
			$extraShippingName = (string) $this->db->getValue("SELECT extra_shipping_name FROM `{$this->prefix}cart` WHERE id_cart = '{$this->context->cart->id}'");

			$carriers = $this->context->cart->simulateCarriersOutput();

			Media::addJsDef([
				'STMHD_SHIPPING_COST' => $carriers[0]['price'] - $extraShipping,
				'STMHD_CARRIER' => $STMHD_CARRIER,
				'STMHD_POSTAL_CODES' => $postal_codes,
				'STMHD_AREAS' => $areas,
				'SelectedHomeOption' => $extraShippingName
			]);

		}
	}

	public function getOrderShippingCost($cart, $shippingCost){

		$postal_codes = Tools::jsonDecode(Configuration::get('STMHD_POSTAL_CODES'));

		$extraShipping = (float) $this->db->getValue("SELECT extra_shipping FROM `{$this->prefix}cart` WHERE id_cart = '{$cart->id}'");
		$extraShippingName = (string) $this->db->getValue("SELECT extra_shipping_name FROM `{$this->prefix}cart` WHERE id_cart = '{$this->context->cart->id}'");

		foreach ($postal_codes as $postal_code) {
			if($postal_code[0] == $extraShippingName && $postal_code[1] == $extraShipping)
				return $shippingCost + $extraShipping;
		}

		return $shippingCost;
	}

	public function hookActionValidateOrder($params){
		if($this->allowed_view){
			$order = $params['order'];

			$extraShippingName = (string) $this->db->getValue("SELECT extra_shipping_name FROM `{$this->prefix}cart` WHERE id_cart = '{$order->id_cart}'");

			$address = new Address($order->id_address_delivery);
			$address->other = $this->l('Home Delivery') . ': ' . $extraShippingName;
			$address->update();
		}
	}

	public function hookBackOfficeHeader($params){
		if($this->allowed_view){
			
		}
	}

	public function hookBackOfficeTop($params){
		if($this->allowed_view){
			
		}
	}

	public function getContent(){

		if(Tools::isSubmit('submitstmhomedelivery')){
			$zip_range_min = Tools::getValue('zip_range_min', []);
			$zip_range_max = Tools::getValue('zip_range_max', []);

			$delivery_areas = Tools::getValue('delivery_areas', []);
			$delivery_costs = Tools::getValue('delivery_costs', []);

			$postal_codes = [];
			foreach ($zip_range_min as $i => $zip_min) {
				if(!$zip_min)
					continue;

				$zip_max = $zip_range_max[$i];

				$postal_codes[] = [
					$zip_min,
					$zip_max
				];
			}

			$areas = [];
			foreach ($delivery_areas as $i => $delivery_area) {
				if(!$delivery_area)
					continue;

				$delivery_cost = $delivery_costs[$i];

				$areas[] = [
					$delivery_area,
					$delivery_cost
				];
			}

			$id_carrier = Tools::getValue('STMHD_CARRIER', 0);
			Configuration::updateValue('STMHD_POSTAL_CODES', Tools::jsonEncode($postal_codes));
			Configuration::updateValue('STMHD_AREAS', Tools::jsonEncode($areas));
			Configuration::updateValue('STMHD_CARRIER', $id_carrier);

			if($id_carrier){
				$carrier = new Carrier($id_carrier);
				$carrier->shipping_external = 1;
				$carrier->need_range = 1;
				$carrier->external_module_name = $this->name;
				$carrier->update();
			}

	        if(isset($this->error)){
	        }else{
				header('Location: ' . $_SERVER['REQUEST_URI'] . '&configure=' . $this->name);
				exit;
			}
		}

		if($this->allowed_view)
			return $this->displayForm();
	}

	public function displayForm(){
		$STMHD_CARRIER = (int) $this->id_carrier;
		// echo $STMHD_CARRIER;
		// exit;

		$postal_codes = Tools::jsonDecode(Configuration::get('STMHD_POSTAL_CODES'));
		$areas = Tools::jsonDecode(Configuration::get('STMHD_AREAS'));

		$this->context->smarty->assign([
			'areas' => $areas,
			'postal_codes' => $postal_codes
		]);

        $form = new HelperForm();
		$form->show_toolbar = false;
		$form->table = $this->table;

		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$form->default_form_language = $lang->id;

		$this->fields_form = array();

		$form->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$form->id = '';
		$form->identifier = $this->identifier;
		$form->submit_action = 'btnSubmit';
		$form->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$form->token = Tools::getAdminTokenLite('AdminModules');

		$form->tpl_vars = array(
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		$input_fields = [];

        $input_fields['configure'] = [
        	'type' => 'hidden',
        	'name' => 'configure'
        ];

		$carriers = Carrier::getCarriers($lang->id);
		$input_fields['STMHD_CARRIER'] = [
			'type' => 'select',
			'label' => $this->l('Home Delivery Carrier'),
			'name' => 'STMHD_CARRIER',
			'tab' => 'zip_ranges',
			'required' => true,
			'options'   => [
				'id' => 'id_carrier',
				'name' => 'name',
				'query' => $carriers
			]
		];

		$input_fields[] = [
			'type'     => 'html',
			'label'    => $this->l('Insert Zip Range'),
			'html_content' => $this->display(__FILE__, 'views/templates/admin/postal_codes.tpl'),
			'required' => true,
			'tab' => 'zip_ranges'
		];

		$input_fields[] = [
			'type'         => 'html',
			'label'		   => $this->l('Areas'),
			'html_content' => $this->display(__FILE__, 'views/templates/admin/areas.tpl'),
			'tab' => 'areas'
		];

        $fields_form = [
        	'form' => [
	            'tinymce' => true,
	            'class' => 'hidden',
	            'legend'  => [
	                'title' => $this->l('Zip Code Range'),
	                'icon'  => 'icon-folder-close',
	            ],

	            'input'   => $input_fields,

				'tabs' => array(
					'zip_ranges' => $this->l('Postal Codes'),
					'areas' => $this->l('Areas'),
				),

	            'submit'  => [
	                'title' => $this->l('Save'),
	                'name'  => 'submit' . $this->name
	            ]
	        ]
        ];

		$form->tpl_vars['fields_value']['configure'] = $this->name;
		$form->tpl_vars['fields_value']['STMHD_CARRIER'] = $STMHD_CARRIER;

        return $form->generateForm(array($fields_form));
	}

}