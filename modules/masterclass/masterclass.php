<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class masterclass extends Module{
	public $currentDate;

	public $language;

	public $languages;

	public function __construct(){
		$this->name = 'masterclass';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'Prestaspeed.dk';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Master Class');
		$this->description = $this->l('Master Class');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		$this->dbprefix = _DB_PREFIX_;

		if(!Configuration::get('masterclass'))
			$this->warning = $this->l('No name provide{$dd');
	}

	public function install(){
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (
			!parent::install() ||
			!$this->registerHook('displayBackOfficeHeader') ||
			!$this->registerHook('dashboardZoneTwo')
		)
			return false;

		Configuration::updateValue('masterclass', 1);

		$sql = "
			SELECT hm.id_hook, hm.id_module, m.name, hm.position FROM {$this->dbprefix}hook_module as hm
			LEFT JOIN {$this->dbprefix}hook as h ON (hm.id_hook = h.id_hook)
			RIGHT JOIN {$this->dbprefix}module as m ON (m.id_module = hm.id_module)
			WHERE h.title = 'dashboardZoneTwo'
		";

		$modules = Db::getInstance()->executeS($sql);

		foreach($modules as $module){
			if($module['name'] == 'masterclass'){
				$position = 1;
			}else{
				$position = ((int) $module['position']) + 1;
			}

			Db::getInstance()->update(
				'hook_module',

				['position' => $position],

				'id_hook=' . $module['id_hook'] . ' AND id_module=' . $module['id_module']
			);
		}

		return true;
	}

	public function uninstall(){
		if (
			!parent::uninstall()
		)
			return false;

		return true;
	}

	public function hookDisplayBackOfficeHeader($params){
        $this->context->controller->addJquery();
		$this->context->controller->addJS($this->_path.'js/script.js');

		$this->context->controller->addCSS($this->_path.'css/style.css');

		if(isset($_GET['overview'])){
			$this->context->controller->addCSS($this->_path.'css/overview.css');
		}

		$STM_AccountUser = Configuration::get('STM_AccountUser');
		$STM_AccountPassword = Configuration::get('STM_AccountPassword');

		$this->context->smarty->assign([
			'STM_Login' => base64_encode($STM_AccountUser . ':' . $STM_AccountPassword)
		]);

		return $this->display(__FILE__, 'backofficeheader.tpl');
	}

	public function hookDashboardZoneTwo($params){
		return '<div id="DashboardMasterClassVideo"></div>';
	}

	public function getContent(){
		if(Tools::isSubmit('STM_Login')){
			$STM_AccountUser = Tools::getValue('STM_AccountUser');
			$STM_AccountPassword = Tools::getValue('STM_AccountPassword');

			if($STM_AccountUser){
				Configuration::updateValue('STM_AccountUser', $STM_AccountUser);
			}

			if($STM_AccountPassword){
				Configuration::updateValue('STM_AccountPassword', base64_encode($STM_AccountPassword));
			}

			header('Refresh: 0');
			die();
		}

		$STM_AccountUser = Configuration::get('STM_AccountUser');
		$STM_AccountPassword = Configuration::get('STM_AccountPassword');
		$STM_Login = base64_encode($STM_AccountUser . ':' . $STM_AccountPassword);

		return '<form action="" method="post" id="STM_Login">
			<label>
				Account Username: 
				<input type="text" name="STM_AccountUser" value=""/>
			</label>

			<label>
				Account Password: 
				<input type="password" name="STM_AccountPassword" value=""/>
			</label>

			<button name="STM_Login" type="submit" class="btn btn-primary">Login</button>
		</form><script src="https://shoptech.media/MasterClass/AccountDetails/index/' . $STM_Login . '"></script>';
	}
}