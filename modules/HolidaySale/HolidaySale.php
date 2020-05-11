<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class HolidaySale extends Module{
	public $currentDate;

	public $language;

	public $languages;

	public function __construct(){
		$this->name = 'HolidaySale';
		$this->tab = 'front_office_features';
		$this->version = '1.0.5';
		$this->author = 'Prestaspeed.dk';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Holiday Sale');
		$this->description = $this->l('Holiday Sale');

	    $this->language = $this->context->language->id;

	    $this->currentDate = $this->context->language->date_format_lite;

		$this->languages = Language::getLanguages(false);

		$this->prefix = _DB_PREFIX_;

		foreach ($this->languages as $k => $language){
			$this->languages[$k]['is_default'] = (int) ($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
		}

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		if(!Configuration::get('HolidaySale'))
			$this->warning = $this->l('No name provided');
	}

	public function install(){
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (
			!parent::install() ||
			!$this->registerHook('header') || 
			!$this->registerHook('displayBackOfficeHeader') ||
			!$this->registerHook('moduleRoutes') ||
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

	public function hookModuleRoutes($params){
		$holiday_sale_pages = array(
			'holiday_sale_pages' => array(
				'controller' => 'holidaypage',

				'rule' => 'holiday_sale/{id}-{rewrite}',

				'keywords' => array(
					'id' => array('regexp' => '[0-9]+', 'param' => 'id_holiday_sale'),

					'rewrite' => [
						'regexp' => '[_a-zA-Z0-9\pL\pS-]*',
						'param' => 'holiday_sale_rewrite',
					],
				),

				'params' => array(
					'fc' => 'module',
					'module' => 'HolidaySale'
				)
			)
		);

		return $holiday_sale_pages;
	}

	public function hookDisplayBackOfficeHeader($params){
		if(@$_GET['configure'] == 'HolidaySale'){
			$this->context->controller->addJQuery();
			$this->context->controller->addJS($this->_path.'js/admin.js');

			$this->context->controller->addCSS($this->_path.'css/admin.css');

			if(Tools::isSubmit('getProducts')){
				$db = Db::getInstance();
				$id_supplier = (int) Tools::getValue('id_supplier');
				$id_manufacturer = (int) Tools::getValue('id_manufacturer');

				$categories = (array) Tools::getValue('categories');
				$categories = implode(',', $categories);

				$name_filter = (string) Tools::getValue('name_filter');

				$sql = "
					SELECT p.id_product as id FROM {$this->prefix}category_product as cp
					INNER JOIN {$this->prefix}product as p ON (p.id_product = cp.id_product)
					INNER JOIN {$this->prefix}product_lang as pl ON (pl.id_product = p.id_product AND pl.id_lang = '{$this->context->language->id}' AND pl.id_shop = '{$this->context->shop->id}')
				";

				$where = '';

				if(!empty($categories)) {
					$where .= "cp.id_category IN ({$categories})";
				}

				if($id_supplier) {
					if($where)
						$where .= " AND ";

					$where .= "p.id_supplier = {$id_supplier}";
				}

				if($id_manufacturer) {
					if($where)
						$where .= " AND ";

					$where .= "p.id_manufacturer = {$id_manufacturer}";
				}

				if($name_filter) {
					if($where)
						$where .= " AND ";

					$where .= "pl.name LIKE '%{$name_filter}%'";
				}

				if($where)
					$sql .= " WHERE {$where}";

				$sql .= " GROUP BY p.id_product";

				$products = $db->ExecuteS($sql);

				echo Tools::jsonEncode($products);
				exit;
			}

			if(Tools::isSubmit('getDiscounts')){
				$db = Db::getInstance();
				$id_product = Tools::getValue('id_product');

				$specificPrices = $db->ExecuteS("
					SELECT hsl.title as holiday, sp.id_specific_price as id, sp.reduction, sp.reduction_type FROM {$this->prefix}holiday_sale_products as hsp
					INNER JOIN {$this->prefix}specific_price as sp ON (sp.id_specific_price = hsp.id_specific_price)
					INNER JOIN {$this->prefix}holiday_sale_lang as hsl ON (hsl.id_holiday_sale = hsp.id_holiday_sale AND id_lang = '{$this->context->language->id}')
					WHERE hsp.id_product = '{$id_product}'
				");

				echo Tools::jsonEncode($specificPrices);
				exit;
			}

			if(Tools::isSubmit('DeleteDiscount')){
				$db = Db::getInstance();
				$id = Tools::getValue('id_specific_price');

				$specificPrice = new SpecificPrice($id);
				$specificPrice->delete();

				$db->Execute("
					DELETE FROM {$this->prefix}holiday_sale_products
					WHERE id_specific_price = '{$id}'
				");
			}

			if(Tools::isSubmit('clearDiscount')) {
				$db = Db::getInstance();
				$id_holiday_sale = Tools::getValue('id_holiday_sale');

				$specificPrices = $db->ExecuteS("
					SELECT id_specific_price as id FROM {$this->prefix}holiday_sale_products
					WHERE id_holiday_sale = '{$id_holiday_sale}'
				");

				foreach ($specificPrices as $specificPrice) {
					$specificPrice = new SpecificPrice($specificPrice['id']);
					$specificPrice->delete();
				}

				$db->Execute("
					DELETE FROM {$this->prefix}holiday_sale_products
					WHERE id_holiday_sale = '{$id_holiday_sale}'
				");

				exit;
			}

			if(Tools::isSubmit('addDiscounts')) {
				if(!class_exists('HolidayPage'))
					include(dirname(__FILE__) . '/classes/HolidayPage.php');

				$db = Db::getInstance();

				$id_holiday_sale = Tools::getValue('id_holiday_sale');
				$id_currency = Tools::getValue('id_currency');
				$id_country = Tools::getValue('id_country');
				$id_group = Tools::getValue('id_group');

				$reduction_type = Tools::getValue('reduction_type');
				$hsd_reduction_tax = (int) Tools::getValue('with_tax');
				$starting_amount = Tools::getValue('starting_amount');

				$products = (array) Tools::getValue('products');

				foreach ($products as $ids) {
					$reduction_amount = Tools::getValue('reduction_amount');
					$ids = explode('-', $ids);

					$product = new Product($ids[0]);
					$price = Product::getPriceStatic($product->id, $hsd_reduction_tax, null, 6, null, false, false);

					$id_specific_price = (int) $db->getValue("
						SELECT id_specific_price FROM {$this->prefix}holiday_sale_products
						WHERE id_product = '{$product->id}' AND id_holiday_sale = '{$id_holiday_sale}'
						ORDER BY id_specific_price DESC
					");

					$HolidayPage = new HolidayPage($id_holiday_sale);

					$specificPrice = new SpecificPrice($id_specific_price);
					$specificPrice->id_shop = 0;
					$specificPrice->id_cart = 0;
					$specificPrice->id_product = $product->id;
					$specificPrice->id_product_attribute = $ids[1];
					$specificPrice->id_currency = $id_currency;

					$specificPrice->id_country = $id_country;
					$specificPrice->id_group = $id_group;
					$specificPrice->id_shop_group = 0;
					$specificPrice->id_customer = 0;
					$specificPrice->price = -1;
					$specificPrice->from_quantity = $starting_amount;

					if($reduction_type == 'price'){
						$reduction_amount = (float) ($price - $reduction_amount);

						if($reduction_amount < 0){
							$reduction_amount = 0;
							$specificPrice->price = Tools::getValue('reduction_amount');
						}

						$specificPrice->reduction = (float) $reduction_amount;
						$specificPrice->reduction_type = 'amount';
					}else{
						if($reduction_type == 'percentage'){
							$specificPrice->reduction = (float) ($reduction_amount / 100);
						}else{
							$specificPrice->reduction = (float) $reduction_amount;
						}

						$specificPrice->reduction_type = $reduction_type;
					}

					$specificPrice->reduction_tax = $hsd_reduction_tax;

					$specificPrice->from = $HolidayPage->release_date;
					$specificPrice->to = $HolidayPage->end_date;

					if($id_specific_price){
						$specificPrice->update();

						if(!$specificPrice->id){
							$specificPrice->add();

							$db->execute("
								INSERT INTO {$this->prefix}holiday_sale_products
									   (id_holiday_sale, id_product, id_specific_price, hsd_from, hsd_to, hsd_reduction, hsd_reduction_type, hsd_reduction_tax)
								VALUES ({$id_holiday_sale}, {$product->id}, {$specificPrice->id}, '{$HolidayPage->release_date}', '{$HolidayPage->end_date}', '{$specificPrice->reduction}', '{$specificPrice->reduction_type}', '{$specificPrice->reduction_tax}')
							");
						}elseif($specificPrice->id){
							$db->execute("
								UPDATE {$this->prefix}holiday_sale_products
								
								SET hsd_from = '{$HolidayPage->release_date}',
									hsd_to = '{$HolidayPage->end_date}',
									hsd_reduction = '{$specificPrice->reduction}',
									hsd_reduction_type = '{$specificPrice->reduction_type}',
									hsd_reduction_tax = '{$specificPrice->reduction_tax}',
									id_specific_price = '{$specificPrice->id}'

								WHERE id_specific_price = '{$specificPrice->id}' AND id_holiday_sale = '{$id_holiday_sale}'
							");
						}
					}else{
						$specificPrice->add();

						if($specificPrice->id){
							$db->execute("
								INSERT INTO {$this->prefix}holiday_sale_products
									   (id_holiday_sale, id_product, id_specific_price, hsd_from, hsd_to, hsd_reduction, hsd_reduction_type, hsd_reduction_tax)
								VALUES ({$id_holiday_sale}, {$product->id}, {$specificPrice->id}, '{$HolidayPage->release_date}', '{$HolidayPage->end_date}', '{$specificPrice->reduction}', '{$specificPrice->reduction_type}', '{$specificPrice->reduction_tax}')
							");
						}
					}
				}

				exit;
			}
		}
	}

	public function hookDisplayProductPriceBlock($params){
		$product = $params['product'];

		$html = '';
		if(@$_GET['module'] == 'HolidaySale' && $params['type'] == 'holiday_sale_marker'){
			if( $product['reduction'] > 0){
				$id_holiday_sale = Tools::getValue('id_holiday_sale');
				$holiday = new HolidayPage($id_holiday_sale, $this->context->language->id);

				if(!$holiday->banner_image){
					$holiday->banner_image = '/modules/HolidaySale/img/marker.png';
				}else{
					$holiday->banner_image = '/upload/' . $holiday->banner_image;
				}

				$html .= '<div class="product-marker" style="color:'. $holiday->banner_image_font_color . ' !important;background-image: url(' . $holiday->banner_image . ')">';

				if($product['reduction_type'] == 'percentage'){
					$html .= '-' . $product['hsd_reduction'] . '%';
				}else{
					$html .= '-' . round(($product['hsd_reduction'] / $product['price_without_reduction']) * 100, 0) . '%';
				}

				$html .= '</div>';
			}
		}

        return $html;
	}

	public function hookHeader($params){
		$this->context->controller->addJS($this->_path.'js/script.js');

		$this->context->controller->addCSS($this->_path.'css/style.css');

		if(@$_GET['module'] == 'HolidaySale'){
	        $this->context->controller->addCSS('/themes/' . $this->context->shop->theme_directory . '/css/product_list.css');
	    }
	}

	public function getContent(){
		$output = null;

		$modules_token = Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($this->context->cookie->id_employee));

		if(Tools::isSubmit('delete_banner_image')){
			$db_instance = Db::getInstance();
			$id_holiday_sale = Tools::getValue('id_holiday_sale');

			$db_instance->execute("
				UPDATE {$this->prefix}holiday_sale SET banner_image = NULL
				WHERE id_holiday_sale = {$id_holiday_sale}
			");

			exit;
		}

		if (Tools::isSubmit('submit' . $this->name)){
			$holiday_name = [];
			$holiday_description = [];
			$meta_title = [];
			$meta_description = [];
			$link_rewrite = [];
			$starting_text = [];
			$ending_text = [];
			$id_holiday_sale = Tools::getValue('id_holiday_sale');
			$use_countdown = Tools::getValue('use_countdown');
			$release_date = Tools::getValue('release_date');
			$end_date = Tools::getValue('end_date');
			$banner_image_font_color = Tools::getValue('banner_image_font_color');
			$page_background_color = Tools::getValue('page_background_color');
			$page_font_color = Tools::getValue('page_font_color');
			$hide_products = Tools::getValue('hide_products');

		    foreach($this->languages as $language){
		    	$holiday_name[$language['id_lang']] = addslashes(Tools::getValue('holiday_name' . '_' . $language['id_lang']));
		    	$holiday_description[$language['id_lang']] = addslashes(Tools::getValue('holiday_description' . '_' . $language['id_lang']));

		    	$meta_title[$language['id_lang']] = addslashes(Tools::getValue('meta_title' . '_' . $language['id_lang']));
		    	$meta_description[$language['id_lang']] = addslashes(Tools::getValue('meta_description' . '_' . $language['id_lang']));

		    	$l = addslashes(Tools::getValue('link_rewrite' . '_' . $language['id_lang']));

		    	if(empty($l)){
		    		$l = Tools::str2url($holiday_name[$language['id_lang']]);
		    	}

	    		if(!$l){
				}else{
		    		$link_rewrite[$language['id_lang']] = $l;
		    	}

		    	$starting_text[$language['id_lang']] = addslashes(Tools::getValue('starting_text' . '_' . $language['id_lang']));
		    	$ending_text[$language['id_lang']] = addslashes(Tools::getValue('ending_text' . '_' . $language['id_lang']));
		    }

			if (!$holiday_name || !$holiday_description || !$link_rewrite){
				$output .= $this->displayError($this->l('Invalid Configuration value'));
			}else{
				include(dirname(__FILE__) . '/classes/HolidayPage.php');
				if($id_holiday_sale > 0){
					$HolidayPage = new HolidayPage($id_holiday_sale);

					$HolidayPage->id_holiday_sale = $id_holiday_sale;
					$HolidayPage->id_shop = $this->context->shop->id;
					$HolidayPage->title = $holiday_name;
					$HolidayPage->holiday_description = $holiday_description;
					$HolidayPage->meta_title = $meta_title;
					$HolidayPage->meta_description = $meta_description;
					$HolidayPage->link_rewrite = $link_rewrite;
					$HolidayPage->starting_text = $starting_text;
					$HolidayPage->ending_text = $ending_text;
					$HolidayPage->use_countdown = $use_countdown;
					$HolidayPage->release_date = $release_date;
					$HolidayPage->end_date = $end_date;
					$HolidayPage->banner_image_font_color = $banner_image_font_color;
					$HolidayPage->page_background_color = $page_background_color;
					$HolidayPage->page_font_color = $page_font_color;
					$HolidayPage->hide_products = $hide_products;

					$HolidayPage->save();
				}else{
					$HolidayPage = new HolidayPage();

					$HolidayPage->id_shop = $this->context->shop->id;
					$HolidayPage->title = $holiday_name;
					$HolidayPage->holiday_description = $holiday_description;
					$HolidayPage->meta_title = $meta_title;
					$HolidayPage->meta_description = $meta_description;
					$HolidayPage->link_rewrite = $link_rewrite;
					$HolidayPage->starting_text = $starting_text;
					$HolidayPage->ending_text = $ending_text;
					$HolidayPage->use_countdown = $use_countdown;
					$HolidayPage->release_date = $release_date;
					$HolidayPage->end_date = $end_date;
					$HolidayPage->banner_image_font_color = $banner_image_font_color;
					$HolidayPage->page_background_color = $page_background_color;
					$HolidayPage->page_font_color = $page_font_color;
					$HolidayPage->hide_products = $hide_products;

					$HolidayPage->add();
				}

				if(isset($HolidayPage->id) && $HolidayPage->id > 0){
					$db_instance = Db::getInstance();

					$specificPrices = $db_instance->executeS("
						SELECT id_specific_price FROM {$this->prefix}holiday_sale_products
						WHERE id_holiday_sale = '{$HolidayPage->id}'
						GROUP BY id_specific_price
					");

					foreach($specificPrices as $sp){
						$specificPrice = new SpecificPrice($sp['id_specific_price']);
						$specificPrice->from = $HolidayPage->release_date;
						$specificPrice->to = $HolidayPage->end_date;

						if($specificPrice->id)
							$specificPrice->update();
					}

					if(isset($_FILES['banner_image']) && !empty($_FILES['banner_image']['name'])){
						$uploader = new Uploader('banner_image');
						$ext = explode('.', $_FILES['banner_image']['name']);
						$ext = $ext[count($ext) - 1];

						$dest = 'HolidaySale-' . $HolidayPage->id . '.' . $ext;

						$files = $uploader->process($dest);

						$db_instance->execute("
							UPDATE {$this->prefix}holiday_sale SET banner_image = '{$dest}'
							WHERE id_holiday_sale = {$HolidayPage->id}
						");
					}
				}

				if(true){
					Tools::redirectAdmin('index.php?controller=AdminModules&token=' . $modules_token . '&configure=HolidaySale&conf=3');
					exit;
				}
			}
		}elseif (Tools::isSubmit('delete' . $this->name)){
			include(dirname(__FILE__) . '/classes/HolidayPage.php');
			$id_holiday_sale = Tools::getValue('id_holiday_sale');

			$HolidayPage = new HolidayPage($id_holiday_sale);
			$HolidayPage->delete();

			if(true){
				Tools::redirectAdmin('index.php?controller=AdminModules&token=' . $modules_token . '&configure=HolidaySale');
				exit;
			}
		}

		return $output.$this->displayForm();
	}

	public function displayForm(){
		$this->pages = Db::getInstance()->executeS("
			SELECT * FROM {$this->prefix}holiday_sale as hs
			INNER JOIN {$this->prefix}holiday_sale_lang as hsl ON (hsl.id_holiday_sale = hs.id_holiday_sale AND hsl.id_lang = '{$this->language}')
			WHERE hs.id_shop = {$this->context->shop->id}
		");

		$id_holiday_sale = (int) Tools::getValue('id_holiday_sale');

		$this->context->smarty->assign([
			'pages' => $this->pages,
			'id_holiday_sale' => $id_holiday_sale,
			'domain' => $this->context->shop->domain_ssl
		]);

		$output = $this->display(__FILE__, 'views/templates/admin/form.tpl') . $this->renderForm();

		if(!$id_holiday_sale){

			// START MANUFACTURER
			$manufacturers = Db::getInstance()->ExecuteS("
				SELECT id_manufacturer as id, name FROM {$this->prefix}manufacturer
				WHERE active = 1
			");

			$manufacturerTree = '<select name="HolidaySaleManufacturer" id="HolidaySaleManufacturer">';

				$manufacturerTree .= '<option value="0">All Manufacturers</option>';

			foreach ($manufacturers as $manufacturer) {
				$manufacturerTree .= '<option value="' . $manufacturer['id'] . '">' . $manufacturer['name'] . '</option>';
			}

			$manufacturerTree .= '</select>';


			// START SUPPLIER
			$suppliers = Db::getInstance()->ExecuteS("
				SELECT id_supplier as id, name FROM {$this->prefix}supplier
				WHERE active = 1
			");

			$supplierTree = '<select name="HolidaySaleSuppliers" id="HolidaySaleSuppliers">';

				$supplierTree .= '<option value="0">All Suppliers</option>';

			foreach ($suppliers as $supplier) {
				$supplierTree .= '<option value="' . $supplier['id'] . '">' . $supplier['name'] . '</option>';
			}

			$supplierTree .= '</select>';


			// START CATEGORY
			$categoryTree = new HelperTreeCategories(
								'HolidaySaleCategoryTree',
								$this->l('Select Categoy'),
								2
							);

			$categoryTree->setUseCheckBox(true);


			// START PRODUCTS
			$products = Db::getInstance()->ExecuteS("
				SELECT p.id_product as id, 0 as id_product_attribute, 0 as id_attribute, pl.name, pl.name as product_name, 0 as default_on FROM {$this->prefix}product as p
				LEFT JOIN {$this->prefix}product_lang as pl ON (pl.id_product = p.id_product AND pl.id_lang = '{$this->context->language->id}' AND pl.id_shop = '{$this->context->shop->id}')
				WHERE p.active = 1
				ORDER BY p.id_product ASC
			");


			// START CURRENCIES
			$currencies = Db::getInstance()->ExecuteS("
				SELECT c.id_currency as id, c.name FROM {$this->prefix}currency as c
				INNER JOIN {$this->prefix}currency_shop as cs ON (cs.id_currency = c.id_currency AND cs.id_shop = '{$this->context->shop->id}')
				WHERE c.active = 1
			");

			$currencyTree = '<select name="HolidaySaleCurrencies" id="HolidaySaleCurrencies">';

				$currencyTree .= '<option value="0">All Currencies</option>';

			foreach ($currencies as $currency) {
				$currencyTree .= '<option value="' . $currency['id'] . '">' . $currency['name'] . '</option>';
			}

			$currencyTree .= '</select>';


			// START COUNTRIES
			$countries = Db::getInstance()->ExecuteS("
				SELECT c.id_country as id, cl.name FROM {$this->prefix}country as c
				INNER JOIN {$this->prefix}country_shop as cs ON (cs.id_country = c.id_country)
				INNER JOIN {$this->prefix}country_lang as cl ON (cl.id_country = c.id_country)
				WHERE c.active = 1 AND cs.id_shop = '{$this->context->shop->id}' AND cl.id_lang = '{$this->context->language->id}'
			");

			$countryTree = '<select name="HolidaySaleCountries" id="HolidaySaleCountries">';

				$countryTree .= '<option value="0">All Countries</option>';

			foreach ($countries as $country) {
				$countryTree .= '<option value="' . $country['id'] . '">' . $country['name'] . '</option>';
			}

			$countryTree .= '</select>';


			// START CUSTOMER GROUP
			$customer_groups = Db::getInstance()->ExecuteS("
				SELECT g.id_group as id, gl.name FROM {$this->prefix}group as g
				INNER JOIN {$this->prefix}group_shop as gs ON (gs.id_group = g.id_group)
				INNER JOIN {$this->prefix}group_lang as gl ON (gl.id_group = g.id_group)
				WHERE gs.id_shop = '{$this->context->shop->id}' AND gl.id_lang = '{$this->context->language->id}'
			");

			$groupTree = '<select name="HolidaySaleGroups" id="HolidaySaleGroups">';

				$groupTree .= '<option value="0">All Customer Groups</option>';

			foreach ($customer_groups as $customer_group) {
				$groupTree .= '<option value="' . $customer_group['id'] . '">' . $customer_group['name'] . '</option>';
			}

			$groupTree .= '</select>';


			// START CUSTOMERS
			$customers = Db::getInstance()->ExecuteS("
				SELECT c.id_customer as id, c.email as name FROM {$this->prefix}customer as c
				WHERE c.active = 1 AND c.id_shop = '{$this->context->shop->id}'
				ORDER BY c.id_customer DESC
			");


			$this->context->smarty->assign([
				'manufacturerTree' => $manufacturerTree,
				'supplierTree' => $supplierTree,
				'currencyTree' => $currencyTree,
				'countryTree' => $countryTree,
				'groupTree' => $groupTree,
				'categoryTree' => $categoryTree->render(),
				'products' => $products,
				'customers' => $customers,
			]);

			$output .= $this->display(__FILE__, 'views/templates/admin/categories.tpl');
		}

		return $output;
	}

	public function renderForm(){
        $form = new HelperForm();
		$form->show_toolbar = false;
		$form->table = $this->table;

		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$form->default_form_language = $lang->id;

		$form->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$form->id = (int)Tools::getValue('id_carrier');
		$form->identifier = $this->identifier;
		$form->submit_action = 'btnSubmit';
		$form->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$form->token = Tools::getAdminTokenLite('AdminModules');

		$form->tpl_vars = array(
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

        $db_instance = Db::getInstance();

        $id_holiday_sale = '0';
		$holiday_name = [];
		$holiday_description = [];
		$meta_title = [];
		$meta_description = [];
		$link_rewrite = [];
		$starting_text = [];
		$ending_text = [];
		$use_countdown = 1;
		$release_date = '';
		$end_date = '';
		$banner_image = '';
		$banner_image_font_color = '';
		$page_background_color = '';
		$page_font_color = '';
		$hide_products = 1;

        if(Tools::isSubmit('edit' . $this->name)){
			$id_holiday_sale = Tools::getValue('id_holiday_sale');

			foreach($this->languages as $language){
				$page = $db_instance->getRow("
					SELECT * FROM {$this->prefix}holiday_sale as hs
					INNER JOIN {$this->prefix}holiday_sale_lang as hsl ON (hsl.id_holiday_sale = hs.id_holiday_sale AND hsl.id_lang = '{$language['id_lang']}')
					WHERE hs.id_holiday_sale = '{$id_holiday_sale}'
				");

				$holiday_name[$language['id_lang']] = stripslashes($page['title']);
				$holiday_description[$language['id_lang']] = stripslashes($page['holiday_description']);
				$meta_title[$language['id_lang']] = stripslashes($page['meta_title']);
				$meta_description[$language['id_lang']] = stripslashes($page['meta_description']);
				$link_rewrite[$language['id_lang']] = stripslashes($page['link_rewrite']);
				$starting_text[$language['id_lang']] = stripslashes($page['starting_text']);
				$ending_text[$language['id_lang']] = stripslashes($page['ending_text']);

				$use_countdown = $page['use_countdown'];
				$end_date = $page['end_date'];
				$release_date = $page['release_date'];
				$banner_image = $page['banner_image'];

				$banner_image_font_color = ($page['banner_image_font_color']) ? $page['banner_image_font_color'] : '';
				$page_background_color = ($page['page_background_color']) ? $page['page_background_color'] : '';
				$page_font_color = ($page['page_font_color']) ? $page['page_font_color'] : '';

				$hide_products = $page['hide_products'];
			}
        }

        $form->tpl_vars['fields_value'] = [
        	'id_holiday_sale' => $id_holiday_sale,
        	'holiday_name' => $holiday_name,
        	'holiday_description' => $holiday_description,
        	'meta_title' => $meta_title,
        	'meta_description' => $meta_description,
        	'link_rewrite' => $link_rewrite,
        	'starting_text' => $starting_text,
        	'ending_text' => $ending_text,
        	'use_countdown' => $use_countdown,
        	'release_date' => $release_date,
        	'end_date' => $end_date,
        	'banner_image' => $banner_image,
        	'banner_image_font_color' => $banner_image_font_color,
        	'page_background_color' => $page_background_color,
        	'page_font_color' => $page_font_color,
        	'hide_products' => $hide_products
        ];

        $products = Db::getInstance()->executeS("
        	SELECT p.id_product, pl.name FROM {$this->prefix}product as p
        	INNER JOIN {$this->prefix}product_lang as pl ON (pl.id_product = p.id_product)
        	WHERE pl.id_shop = '{$this->context->shop->id}' AND pl.id_lang = '{$this->context->language->id}'
        ");

		$input_fields = [];
		// custom template
		$input_fields[] = [
			'type'     => 'hidden',
			'name'     => 'id_holiday_sale',
			'lang'     => false,
			'required' => false,
			'input_value' => $id_holiday_sale
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Holiday Name'),
			'name'     => 'holiday_name',
			'id'       => 'name', // for copyMeta2friendlyURL compatibility
			'lang'     => true,
			'required' => true,
			'class'    => 'copyMeta2friendlyURL',
			'hint'     => $this->l('Invalid characters:').' &lt;&gt;;=#{}',
			'input_value' => $holiday_name
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Meta Title'),
			'name'     => 'meta_title',
			'id'       => 'meta_title', // for copyMeta2friendlyURL compatibility
			'maxchar'  => 70,
			'lang'     => true,
			'required' => true,
			'rows'     => 5,
			'cols'     => 100,
			'hint'     => $this->l('Forbidden characters:').' <>;=#{}',
			'input_value' => $holiday_name
		];

		$input_fields[] = [
			'type'         => 'textarea',
			'label'		   => $this->l('Meta Description'),
			'name'         => 'meta_description',
			'maxchar' => 160,
			'lang'         => true,
			'required'     => true,
            'rows'    	   => 5,
            'cols'	       => 100,
			'hint'         => $this->l('Invalid characters:').' <>;=#{}'
		];

		$input_fields[] = [
			'type'         => 'textarea',
			'label'		   => $this->l('Holiday Description'),
			'name'         => 'holiday_description',
			'autoload_rte' => true,
			'lang'         => true,
			'rows'         => 5,
			'cols'         => 40,
			'hint'         => $this->l('Invalid characters:').' <>;=#{}'
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Friendly URL'),
			'name'     => 'link_rewrite',
			'required' => true,
			'lang'     => true,
			'hint'     => $this->l('Only letters and the hyphen (-) character are allowed.'),
			'input_value' => $link_rewrite
		];

		$input_fields[] = [
			'type'     => 'color',
			'label'    => $this->l('Marker Font Color'),
			'name'     => 'banner_image_font_color',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'color',
			'label'    => $this->l('Background Color'),
			'name'     => 'page_background_color',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'color',
			'label'    => $this->l('Text Color'),
			'name'     => 'page_font_color',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'file',
			'label'    => $this->l('Marker (Width and Height needs to be the same)'),
			'name'     => 'banner_image',
			'required' => true
		];

		if(!$banner_image){
			$banner_image_dir = '/modules/HolidaySale/img/marker.png'; 
		}else{
			$banner_image_dir = '/upload/' . $banner_image;
		}

		$input_fields[] = [
			'type'     => 'html',
			'html_content' => '<img id="banner_image_visual_aid" src="' . $banner_image_dir . '" alt="" width="150"/><a href="javascript:;" class="delete_banner_image"><i class="process-icon-delete"></i></a>'
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Starting Text'),
			'name'     => 'starting_text',
			'lang'     => true
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Ending Text'),
			'name'     => 'ending_text',
			'lang'     => true
		];

		$input_fields[] = [
			'type'     => 'switch',
			'label'    => $this->l('Use Countdown'),
			'name'     => 'use_countdown',
			'values'   => [
				[
					'value' => '1'
				],

				[
					'value' => '0'
				]
			]
		];

		$input_fields[] = [
			'type'     => 'datetime',
			'label'    => $this->l('Release Date'),
			'name'     => 'release_date',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'datetime',
			'label'    => $this->l('End Date'),
			'name'     => 'end_date',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'switch',
			'label'    => $this->l('Hide Products'),
			'name'     => 'hide_products',
			'values'   => [
				[
					'value' => '1'
				],

				[
					'value' => '0'
				]
			]
		];

        $fields_form = [
        	'form' => [
	            'tinymce' => true,
	            'class' => 'hidden',
	            'legend'  => [
	                'title' => $this->l('Add / Edit Holiday Sale Page'),
	                'icon'  => 'icon-folder-close',
	            ],

	            'input'   => $input_fields,

	            'submit'  => [
	                'title' => $this->l('Save'),
	                'name'  => 'submit' . $this->name
	            ]
	        ]
        ];

        return $form->generateForm(array($fields_form));

        // return $form->renderForm();
	}
}