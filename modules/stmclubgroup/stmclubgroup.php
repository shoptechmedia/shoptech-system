<?php

if (!defined('_PS_VERSION_')) {
	exit;
}

class stmclubgroup extends Module {

	public function __construct()
	{
		$this->name = 'stmclubgroup';
		$this->tab = 'Customer Club Groups';
		$this->author = 'Prestaspeed.dk';
		$this->version = 1.0;
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Customer Club Groups');

		$this->description = $this->l('Assign Customers Groups to Categories');

		$this->db = Db::getInstance();
		$this->prefix = _DB_PREFIX_;

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		// $this->registerHook('displayBackOfficeHeader');
		// exit;
	}

	public function install() {
		if (!parent::install()
		|| !$this->registerHook('actionAuthentication')
		|| !$this->registerHook('actionCustomerAccountAdd')
		|| !$this->registerHook('header')
		|| !$this->registerHook('displayCustomerAccountFormTop')
		|| !$this->registerHook('displayBackOfficeHeader')
		) {
			return false;
		}

		$this->db->Execute("ALTER TABLE `{$this->prefix}group` ADD `id_category` INT NOT NULL DEFAULT '0' AFTER `id_group`");

		return true;
	}

	public function uninstall() {
		if (!parent::uninstall()) {
			return false;
		}

		return true;
	}

	private function getCategories(&$categoryDropdown, $id_parent = 2, $depth = 0){
		$categories = $this->db->ExecuteS("
			SELECT cl.id_category, cl.name FROM {$this->prefix}category as c
			LEFT JOIN {$this->prefix}category_lang as cl ON (c.id_category = cl.id_category AND cl.id_lang = '{$this->context->language->id}' AND cl.id_shop = '{$this->context->shop->id}')
			WHERE c.active = 1 AND c.id_parent = '{$id_parent}'
			ORDER BY c.id_category ASC
		");

		$pre_name = '';

		for($i = 0; $i < $depth; $i++){
			$pre_name .= '---';
		}

		foreach ($categories as $category) {
			$name = $pre_name . ' ' . $category['name'];

			if($this->id_category == $category['id_category'])
				$categoryDropdown .= '<option selected="selected" value="' . $category['id_category'] . '">' . $name . '</option>';
			else
				$categoryDropdown .= '<option value="' . $category['id_category'] . '">' . $name . '</option>';

			$this->getCategories($categoryDropdown, $category['id_category'], $depth + 1);
		}
	}

	public function hookDisplayBackOfficeHeader($params){
		$controller = Tools::getValue('controller');
		$id_group = Tools::getValue('id_group');

		if(Tools::isSubmit('standardClubCategory')){

			$id_category = (int) Tools::getValue('standardClubCategory');

			$this->db->update(
				'group',

				[
					'id_category' => $id_category
				],

				"id_group = '{$id_group}'"
			);

		}

		if($controller == 'AdminGroups' && $id_group){
			$this->context->controller->addJQuery();
			$this->context->controller->addJS($this->_path.'admin.js');

			$this->id_category = (int) $this->db->getValue("
				SELECT id_category FROM {$this->prefix}group
				WHERE id_group = '{$id_group}'
			");

			$categoryDropdown = '';

			$categories = $this->db->ExecuteS("
				SELECT cl.id_category, cl.name FROM {$this->prefix}category as c
				LEFT JOIN {$this->prefix}category_lang as cl ON (c.id_category = cl.id_category AND cl.id_lang = '{$this->context->language->id}' AND cl.id_shop = '{$this->context->shop->id}')
				WHERE c.active = 1 AND c.id_category > 2 AND c.id_parent = 2
				ORDER BY c.id_category ASC
			");

			$categoryDropdown .= '<div class="form-group">';

				$categoryDropdown .= '<label class="control-label col-lg-3">';

					$categoryDropdown .= '<span>';

						$categoryDropdown .= $this->l('Membership Page');

					$categoryDropdown .= '</span>';

				$categoryDropdown .= '</label>';

				$categoryDropdown .= '<div class="col-lg-2">';

					$categoryDropdown .= '<select name="standardClubCategory" class="fixed-width-xl">';

						$categoryDropdown .= '<option value="0"> </option>';

						$this->getCategories($categoryDropdown);

					$categoryDropdown .= '</select>';

				$categoryDropdown .= '</div>';

			$categoryDropdown .= '</div>';

			Media::addJSDef([
				'categoryDropdown' => $categoryDropdown
			]);
		}
	}

	public function hookHeader($params)
	{
		$this->context->controller->addJS($this->_path.'script.js');
		$this->context->controller->addCSS($this->_path.'style.css');

		$id_category = (int) $this->db->getValue("
			SELECT id_category FROM {$this->prefix}group
			WHERE id_group = '{$this->context->customer->id_default_group}'
		");

		if($id_category) {
			$club_group = $this->context->link->getCategoryLink($id_category);

			Media::addJSDef([
				'club_group' => $club_group,
				'ClubGroupTxt' => $this->l('Visit Club')
			]);
		}
	}

	public function hookActionCustomerAccountAdd($params)
	{
		$customer = $params['newCustomer'];
		$POST = $params['_POST'];

		$club_group = $POST['club_group'];

		$id_default_group = (int) $this->db->getValue("
			SELECT id_group FROM {$this->prefix}group_lang
			WHERE name = '{$club_group}' AND id_lang = '{$this->context->language->id}'
		");

		$customer->id_default_group = $id_default_group;

		$customer->updateGroup([3, $id_default_group]);
		$customer->update();

		$id_category = (int) $this->db->getValue("
			SELECT id_category FROM {$this->prefix}group
			WHERE id_group = '{$id_default_group}'
		");

		if($id_category){
			$link = $this->context->link->getCategoryLink($id_category);

			header('Location: ' . $link);
			exit;
		}
	}

	public function hookActionAuthentication($params)
	{
		$customer = $params['customer'];

		$id_category = (int) $this->db->getValue("
			SELECT id_category FROM {$this->prefix}group
			WHERE id_group = '{$customer->id_default_group}'
		");

		if($id_category){
			$link = $this->context->link->getCategoryLink($id_category);

			header('Location: ' . $link);
			exit;
		}
	}

	public function hookDisplayCustomerAccountFormTop($params){
		if($this->context->controller->php_self == 'order-opc')
			return false;

		$html = '';

		$club_groups = $this->db->ExecuteS("
			SELECT id_group, name FROM {$this->prefix}group_lang
			WHERE id_lang = '{$this->context->language->id}' AND id_group > 2
		");

		$html .= '<div id="club_groups" class="account_creation">';

			$html .= '<h3 class="page-subheading">';
				$html .= $this->l('Choose Club Group');
			$html .= '</h3>';

			$html .= '<div class="required text form-group">';

				$html .= '<label for="club_group">' . $this->l('Club Groups') . ' <sup>*</sup></label>';

				$html .= '<input type="text" class="form-control" id="club_group" name="club_group" value="">';

			$html .= '</div>';

		$html .= '</div>';

		return $html;
	}
}