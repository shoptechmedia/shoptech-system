<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class customcombinations extends Module{
	public $currentDate;

	public $language;

	public $languages;

	public function __construct(){
		$this->name = 'customcombinations';
		$this->tab = 'front_office_features';
		$this->version = '0.9.0';
		$this->author = 'Prestaspeed.dk';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Flexible Custom Product Combinations');
		$this->description = $this->l('For creating custom product combinations');

	    $this->language = $this->context->language->id;

	    $this->currentDate = $this->context->language->date_format_lite;

		$this->languages = Language::getLanguages(false);

		foreach ($this->languages as $k => $language){
			$this->languages[$k]['is_default'] = (int) ($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
		}

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		$this->prefix = _DB_PREFIX_;
		$this->db_instance = Db::getInstance();

		if(!Configuration::get('customcombinations'))
			$this->warning = $this->l('No name provided');
	}

	public function install(){
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (
			!parent::install() ||
			!$this->registerHook('header') || 
			!$this->registerHook('displayBackOfficeHeader') ||
			!$this->registerHook('displayAdminProductsExtra') ||
			!$this->registerHook('actionProductAdd') ||
			!$this->registerHook('actionProductUpdate') ||
			!$this->registerHook('actionProductDelete') ||
			!$this->registerHook('displayProductPriceBlock')
		)
			return false;

		include(__DIR__ . '/sql/install.php');

		return true;
	}

	public function uninstall(){
		if (
			!parent::uninstall()
		)
			return false;

		include(__DIR__ . '/sql/uninstall.php');

		return true;
	}

	private function makeCombinations($arrays){
		$id_product = Tools::getValue('id_product');
		$result = array(array());

		foreach ($arrays as $property => $property_values) {
			$tmp = array();

			foreach ($result as $result_item) {
				foreach ($property_values as $property_value) {
					$tmp[] = array_merge($result_item, array($property => $property_value));
				}
			}

			$result = $tmp;
		}

		$Combinations = [];
		foreach ($result as $Combination) {
			$toString = '';
			foreach ($Combination as $label => $value) {
				$toString .= $label . ': ' . $value . ';';
			}

			if($toString){
				$product = $this->db_instance->getRow("
					SELECT pg.id_combination, pl.id_product, pg.id_sub_product, pl.name FROM {$this->prefix}product_group as pg
					LEFT JOIN {$this->prefix}product_lang as pl ON (pl.id_product = pg.id_sub_product AND pl.id_lang = '{$this->context->language->id}' AND pl.id_shop = '{$this->context->shop->id}')
					WHERE pg.id_main_group = '{$id_product}' AND pg.combination = '{$toString}'
				");

				$id_combination = $product['id_combination'];
				if(!$id_combination){
					$this->db_instance->insert(
						'product_group',

						[
							'id_main_group' => $id_product,
							'id_sub_product' => 0,
							'combination' => $toString
						]
					);

					$id_combination = $this->db_instance->Insert_ID();
				}

				$Combinations[] = [
					'id_combination' => $id_combination,
					'id_product' => $product['id_product'],
					'name' => $product['name'],
					'combination' => $Combination
				];
			}
		}

		return $Combinations;
	}

	public function hookDisplayAdminProductsExtra($params){
		$id_product = Tools::getValue('id_product');

		if(Tools::isSubmit('delete_dropdown')){
			$this->db_instance->delete('product_dropdown', 'id_dropdown=' . Tools::getValue('delete_dropdown'));

			header('Location: index.php?controller=AdminProducts&id_product=' . $id_product . '&updateproduct=&token=' . Tools::getValue('token') . '&key_tab=ModuleCustomcombinations');
			exit;
		}

		if(Tools::isSubmit('CleanCombinations')){
			$this->db_instance->Execute("
				DELETE FROM {$this->prefix}product_group
				WHERE id_main_group = '{$id_product}' AND id_sub_product = 0
			");

			header('Location: index.php?controller=AdminProducts&id_product=' . $id_product . '&updateproduct=&token=' . Tools::getValue('token') . '&key_tab=ModuleCustomcombinations');
			exit;
		}

		$dropdowns = $this->db_instance->ExecuteS("
			SELECT * FROM {$this->prefix}product_dropdown
		");

		$list_dropdown = [];
		foreach ($dropdowns as $dropdown) {
			$id_dropdown = $dropdown['id_dropdown'];
			$id_lang = $dropdown['id_lang'];

			if(!isset($list_dropdown[$id_dropdown])){
				$list_dropdown[$id_dropdown] = $dropdown;

				$list_dropdown[$id_dropdown]['label'] = [];
				$list_dropdown[$id_dropdown]['name'] = [];
				$list_dropdown[$id_dropdown]['options'] = $this->db_instance->ExecuteS("
					SELECT pdv.value FROM {$this->prefix}product_dropdown_value as pdv
					WHERE pdv.id_dropdown = '{$id_dropdown}'
				");

				$list_dropdown[$id_dropdown]['isInProduct'] = (bool) $this->db_instance->getValue("
					SELECT id_product FROM {$this->prefix}product_dropdown
					WHERE id_dropdown = '{$id_dropdown}' AND id_product = '{$id_product}' AND id_lang = '{$this->context->language->id}'
				");
			}

			if(!isset($list_dropdown[$id_dropdown]['label'][$id_lang]))
				$list_dropdown[$id_dropdown]['label'][$id_lang] = $dropdown['label'];

			if(!isset($list_dropdown[$id_dropdown]['name'][$id_lang]))
				$list_dropdown[$id_dropdown]['name'][$id_lang] = $dropdown['name'];
		}

		// MAKE COMBINATIONS START
		$AllOptions = $this->db_instance->ExecuteS("
			SELECT pdv.id_dropdown, pdv.id_main_group, pdv.id_value, pd.label, pdv.value FROM {$this->prefix}product_dropdown_value as pdv
			LEFT JOIN {$this->prefix}product_dropdown as pd ON (pd.id_dropdown = pdv.id_dropdown AND pd.id_lang = '{$this->context->language->id}')
			WHERE pd.id_product = {$id_product}
			ORDER BY pdv.id_dropdown ASC
		");

		$DropdownOptions = [];
		foreach ($AllOptions as $Option) {
			if(!$Option['label']){
				$Option['label'] = $this->db_instance->getValue("
					SELECT label FROM {$this->prefix}product_dropdown
					WHERE id_dropdown = '{$Option['id_dropdown']}' AND id_lang = '{$this->context->language->id}' AND label != ''
				");
			}

			$label = $Option['label'];

			$DropdownOptions[$label][] = $Option['value'];
		}

		$Combinations = $this->makeCombinations($DropdownOptions);
		// MAKE COMBINATIONS END


		$id_dropdown  = (int) Tools::getValue('edit_dropdown');
		$options = $this->db_instance->getValue("
			SELECT GROUP_CONCAT(pdv.value SEPARATOR ',') as options FROM {$this->prefix}product_dropdown_value as pdv
			WHERE pdv.id_dropdown = '{$id_dropdown}'
			GROUP BY pdv.id_dropdown
		");

		$options = explode(',', $options);
		$options = array_unique($options);
		$options = implode("\n", $options);

		$this->context->smarty->assign([
			'id_product' => $id_product,
			'languages' => $this->languages,
			'id_lang' => $this->context->language->id,
			'dropdowns' => $list_dropdown,
			'id_dropdown' => $id_dropdown,
			'name' => @$list_dropdown[$id_dropdown]['name'],
			'label' => @$list_dropdown[$id_dropdown]['label'],
			'dropdown_options' => $options,
			'Combinations' => $Combinations
		]);

		$output = '<script>var list_dropdowns = ' . Tools::jsonEncode($list_dropdown) . '</script>';

		$output .= '<div class="clearfix">';

			$output .= $this->display(__FILE__, 'views/templates/admin/tabs.tpl');

			$output .= '<div class="form-horizontal">';

				$output .= '<div id="Dropdown" class="event-tab-content active">';
					$output .= $this->display(__FILE__, 'views/templates/admin/dropdown.tpl');
				$output .= '</div>';

				$output .= '<div id="Combinations" class="event-tab-content">';
					$output .= $this->display(__FILE__, 'views/templates/admin/combinations.tpl');
				$output .= '</div>';

			$output .= '</div>';

			$time = time();
			$output .= '<script src="' . $this->_path . 'js/admin.js?v=' . $time . '"></script>';

		$output .= '</div>';

		return $output;
	}

	public function hookDisplayBackOfficeHeader($params){
		$this->context->controller->addCSS($this->_path.'css/admin.css');
	}

	public function hookHeader($params){
		if($this->context->controller->php_self == 'product') {
			$id_product = Tools::getValue('id_product');

			$id_main_product = $this->db_instance->getValue("
				SELECT id_main_group FROM {$this->prefix}product_group
				WHERE id_sub_product = '{$id_product}'
				ORDER BY id_main_group DESC
			");

			if($id_main_product){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: /index.php?controller=product&id_product={$id_main_product}");
				exit;
			}
		}

		$this->context->controller->addJS($this->_path.'js/script.js');

		$this->context->controller->addCSS($this->_path.'css/style.css');
	}

	public function hookDisplayProductPriceBlock($params){
		$id_product = Tools::getValue('id_product');

		if($params['type'] == 'price' && $id_product) {
			$id_product = Tools::getValue('id_product');

			$prices = [];
			$prices[$id_product] = Tools::displayPrice(Product::getPriceStatic($id_product));

			$dropdowns = $this->db_instance->ExecuteS("
				SELECT 0 as id_sub_product, pd.*, pdv.value FROM {$this->prefix}product_dropdown_value as pdv
				LEFT JOIN {$this->prefix}product_dropdown as pd ON (pdv.id_dropdown = pd.id_dropdown)
				WHERE pd.id_product = '{$id_product}' AND pd.id_lang = '{$this->context->language->id}'
				ORDER BY pd.id_dropdown ASC
			");

			$list_dropdown = [];
			foreach ($dropdowns as $dropdown) {
				$id_dropdown = $dropdown['id_dropdown'];
				$id_lang = $dropdown['id_lang'];
				$value = $dropdown['value'];

				$assignedProducts = $this->db_instance->getValue("
					SELECT GROUP_CONCAT(id_sub_product SEPARATOR ',') FROM {$this->prefix}product_group
					WHERE combination LIKE '%{$dropdown['label']}: {$dropdown['value']};%' AND id_sub_product > 0 AND id_main_group = '{$id_product}'
					GROUP BY id_main_group
				");

				if(!$assignedProducts)
					continue;

				if(!isset($list_dropdown[$id_dropdown])){
					$list_dropdown[$id_dropdown] = $dropdown;

					$list_dropdown[$id_dropdown]['label'] = '';
					$list_dropdown[$id_dropdown]['name'] = '';
					$list_dropdown[$id_dropdown]['values'] = [];
				}

				$list_dropdown[$id_dropdown]['label'] = $dropdown['label'];
				$list_dropdown[$id_dropdown]['name'] = $dropdown['name'];

				if(!isset($list_dropdown[$id_dropdown]['values'][$value]))
					$list_dropdown[$id_dropdown]['values'][$value] = '0' . (($assignedProducts) ? ',' . $assignedProducts : '');

				$assignedProducts = explode(',', $assignedProducts);
				foreach ($assignedProducts as $id_sub_product) {
					$prices[$id_sub_product] = Tools::displayPrice(Product::getPriceStatic((int) $id_sub_product));
				}

				unset($list_dropdown[$id_dropdown]['value']);
				unset($list_dropdown[$id_dropdown]['id_lang']);
			}

			$this->context->smarty->assign([
				'dropdowns' => $list_dropdown
			]);

			Media::AddJSDef([
				'dropdown_prices' => $prices
			]);

			return $this->display(__FILE__, 'views/templates/hook/prices.tpl');
		}
	}
}