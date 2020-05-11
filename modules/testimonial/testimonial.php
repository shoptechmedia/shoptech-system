<?php 

if (!defined('_PS_VERSION_')) {
	exit;
}

class testimonial extends Module
{

	protected $position_identifier = 'position_id';
	
	public function __construct()
	{
		$this->name = 'testimonial';
		$this->tab = 'testimonial';
		$this->author = 'Prestaspeed.dk';
		$this->version = '1.0.0';
		$this->bootstrap = true;

		parent::__construct();

		$this->description = $this->l('Testimonial Module');
		$this->displayName = $this->l('Testimonial Module');
		$this->confirmUninstall = $this->l('Are you sure to uninstall?');
		$this->langue_default_store = (int)Configuration::get('PS_LANG_DEFAULT');

		$this->stm_key = Configuration::get('STM_MODULE_KEY');
	}

	public function createdb() {
		Db::getInstance()->execute("CREATE TABLE IF NOT EXISTS "._DB_PREFIX_."testimonial (
			id int(30) AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(30) NOT NULL,
			affillation VARCHAR(30) NOT NULL,
			testimony LONGTEXT NOT NULL,
			position_id int(7) NOT NULL
		)");
	}

	public function hookDisplayRightColumn()
	{
		if(!$this->stm_key)
			return false;
	}

	public function displayOnFrontOffice() {
		if(!$this->stm_key)
			return false;

		$content = null;

		$this->context->controller->addCSS($this->_path . 'css/testimonials_main.css');

		$this->context->controller->addJS($this->_path . 'js/typeIt.js');
		$this->context->controller->addJS($this->_path . 'js/typed.js');
		$this->context->controller->addJS($this->_path . 'js/testimonials_main.js');

		$list_items = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."testimonial ORDER BY position_id ASC");

		$this->context->smarty->assign([
        	'lists' => $list_items,
    	]);

    	$content .= $this->display(__FILE__, 'testimonial.tpl');

		return $content;
	}

	public function hookDisplayHome()
	{
		if(!$this->stm_key)
			return false;

		$content = null;/**/
		return $content;
	}

	public function hookDisplayTop()
	{
		if(!$this->stm_key)
			return false;

		return $this->displayOnFrontOffice();
	}

	public function hookDisplayBeforeBodyClosingTag() {
		if(!$this->stm_key)
			return false;

		$content = null;
	}

	public function install() {
		if (!parent::install() 

		//|| !
		|| !$this->registerHook('displayTop')
		|| !$this->registerHook('displayRightColumn')
		|| !$this->registerHook('displayHome') 
		|| !$this->registerHook('displayBeforeBodyClosingTag') 

		/*|| !$this->addtab()*/  ) {
			return false;
		}

		Configuration::updateValue('STM_MODULE_KEY', 0);

		return true;
	}

	public function uninstall() {
		exec('curl -sS https://addons.shoptech.media/modules-api/uninstall -XPOST -d"product=' . $this->name . '&order=' . $this->stm_key . '"', $response);
		$response = Tools::jsonDecode($response[0]);

		if(!$response->success){
			return false;
		}

		Configuration::updateValue('STM_MODULE_KEY', 0);

		if (!parent::uninstall()

			/*|| !$this->deleteTab() */)
			return false;

		return true;
	}

	public function setAjaxJs() {
		$base = $_SERVER['SERVER_NAME'];
		$admindir = explode('/', _PS_ADMIN_DIR_);
		$login = end($admindir);
		$token = Tools::getAdminTokenLite('AdminModules');
		$id_for_edit = null;

		if (isset($_GET['testimonial_id'])) {
			$id_for_edit = $_GET['testimonial_id'];;
		}

		$js = '<script>
			$(document).ready(function($){
				var base_url = "'.$_SERVER['SERVER_NAME'].'";
				var module_name = "'. $this->name.'";
				var edit_for_id = "'.$id_for_edit.'";
				setInterval(function(){
					var getContents = $("#testimonial_content_ifr").contents().find(".mce-content-body").html();
					$("#testimonial_content").html(getContents);
					var check = $("#testimonial_content").html();
					//console.log(check);
				},1000);

				//alert(base_url+"/modules/"+module_name);
				$("#addTestimonial").click(function(){
					$.ajax({
						url: "/modules/testimonial/ajax.php",
						dataType: "text",
						data: {
							"name": $("#testimonial_name").val(),
							"affiliation": $("#testimonial_affiliate").val(),
							"testimonial_content": $("#testimonial_content").html(),
							"type": "add"
						},
						type: "POST",
						success: function(res){
							window.location.href = "index.php?controller=AdminModules&configure=testimonial&token='.$token.'";
							console.log(res);
						}
					});
					return false;
				});

				$("#editTestimonial").click(function(){
					$.ajax({
						url: "/modules/testimonial/ajax.php",
						dataType: "text",
						data: {
							"name": $("#testimonial_name").val(),
							"affiliation": $("#testimonial_affiliate").val(),
							"testimonial_content": $("#testimonial_content").html(),
							"type": "edit",
							"id": edit_for_id
						},
						type: "POST",
						success: function(res){
							window.location.href = "index.php?controller=AdminModules&configure=testimonial&token='.$token.'";
							console.log(res);
						}
					});
					return false;
				});

				$(".delete").click(function(){
					$.ajax({
						url: "/modules/testimonial/ajax.php",
						dataType: "text",
						data: {
							"name": $("#testimonial_name").val(),
							"affiliation": $("#testimonial_affiliate").val(),
							"testimonial_content": $("#testimonial_content").val(),
							"type": "delete",
							"id" : $(this).parent().find(".id").text(),
						},
						type: "POST",
						success: function(res){
							location.reload();
						}
					});
					return false;
				});
			});
		</script>';
		return $js;
	}

	public function admin_set_vars() {
		$content = null;
		$admindir = explode('/', _PS_ADMIN_DIR_);
		//$admindir_folder = array_pop((array_slice($admindir, -1))); 
		$list_items = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."testimonial ORDER BY position_id ASC");
		$this->context->smarty->assign([
			'tabs' => ['add'],
			'cur_url' => $_SERVER['REQUEST_URI'],
			'admin_base_url' => /*$_SERVER['SERVER_NAME']*/end($admindir),
			'token' => Tools::getAdminTokenLite('AdminModules'),
			'testimonials' => $list_items,
		]);

		if (isset($_GET['testimonial_id']) && $_GET['testimonial_id'] !== '' ) {
			$testimonial_id = $_GET['testimonial_id'];
			$get_current_testimonial = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."testimonial WHERE id = '$testimonial_id'");
			$this->context->smarty->assign([
				'cur_item' => $get_current_testimonial,
			]);
		}

		return;
	}

	public function displaymainRow() {
		$content = null;
	}

	public function setTinyMCE () {
		$js = "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>";
		$js .= "<script>
				  tinymce.init({
				    selector: '#testimonial_content',
				    theme: 'modern',
					plugins: [
					    'advlist autolink lists link hr anchor pagebreak',
					    'searchreplace wordcount visualchars code',
					    'insertdatetime nonbreaking save table contextmenu directionality',
					    'emoticons paste textcolor colorpicker textpattern codesample toc'
					],
					toolbar1: 'undo redo | styleselect | bold italic | bullist numlist outdent indent | link ',
					toolbar2: 'forecolor backcolor emoticons | codesample',
					image_advtab: true,
					templates: [
					    { title: 'Test template 1', content: 'Test 1' },
					    { title: 'Test template 2', content: 'Test 2' }
					  ],
					  content_css: [
					    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
					    '//www.tinymce.com/css/codepen.min.css'
					  ]
				  });
			  	</script>";
	  	return $js;
	}

	private function initList() {
		$list_items = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."testimonial ORDER BY position_id ASC");
		$this->fields_list = array(
	        'position_id' => array(
	            'title' => $this->l('Id'),
	            'width' => 140,
	            'type' => 'text',
                'orderby' => false,
	        ),
	        'name' => array(
	            'title' => $this->l('Name'),
	            'width' => 140,
	            'type' => 'text',
                'orderby' => false,
	        ),
	        'affillation' => array(
	            'title' => $this->l('Affillation'),
	            'width' => 140,
	            'type' => 'text',
                'orderby' => false,
	        ),
	        'testimony' => array(
	            'title' => $this->l('Testimony'),
	            'width' => 140,
	            'type' => 'text',
                'class' => 'testimony_content_wrap',
                'orderby' => false,
	        ),
            'position' => array(
                'title' => $this->l('Position'),
                'filter_key' => 'a!position_id',
                'position' => 'position',
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
	    );
	    $helper = new HelperList();
	     
	     
	    $helper->simple_header = false;
	    // Actions to be displayed in the "Actions" column
	    $helper->actions = array('edit', 'delete', 'view');
	     
	    $helper->identifier = 'id_testimonial';
        $helper->list_id = 'testimonial';
        $helper->_defaultOrderBy = 'position_id';
	    $helper->show_toolbar = true;
	    $helper->title = 'HelperList';
	    $helper->table = $this->name.'_testimonial';

	    $helper->token = Tools::getAdminTokenLite('AdminModules');
	    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
	    return $helper->generateList($list_items, $this->fields_list);
	}

	public function getContent() {
		$output = null;

		if(!$this->stm_key){
			if (Tools::isSubmit('submitActivateNoIndexModule')) {
				$this->stm_key = Tools::getValue('stm_key');

				exec('curl -sS https://addons.shoptech.media/modules-api/install -XPOST -d"product=' . $this->name . '&order=' . $this->stm_key . '"', $response);
				$response = Tools::jsonDecode($response[0]);

				if($response->success){
					Configuration::updateValue('STM_MODULE_KEY', $this->stm_key);

					$output .= $this->displayConfirmation($this->l('Settings updated'));
				}else{
					$this->uninstall();

					exit;
				}
			}else{
				$return = '
					<form action="" method="post">
						<input type="text" name="stm_key" value="" placeholder="STM Module Key" />

						<button name="submitActivateNoIndexModule" type="submit">Install</button>
					</form>
				';

				return $return;
			}
		}

		//$content = $this->initList();
		$content .= $this->createdb();
		$content .= $this->setAjaxJs();
		$content .= '<link rel="stylesheet" href="'.$this->_path . 'css/testimonials_main.css?v='.time().'"/>';
		$content .= $this->context->controller->addJs($this->_path . 'js/admin.js?v='.time());
		$content .= $this->setTinyMCE();
		$this->admin_set_vars();


		if (!isset($_GET['module_action'])) {
			$content .= $this->display(__FILE__, 'views/templates/admin/admintestimonial.tpl');
		}
		if (isset($_GET['module_action']) && $_GET['module_action'] == 'add') {
			$content .= $this->display(__FILE__, 'views/templates/admin/adminAddtestimonial.tpl');
		}
		if (isset($_GET['module_action']) && $_GET['module_action'] == 'delete') {
			$content .= $this->display(__FILE__, 'views/templates/admin/adminDeletetestimonial.tpl');
		}
		if (isset($_GET['module_action']) && $_GET['module_action'] == 'edit') {
			$content .= $this->display(__FILE__, 'views/templates/admin/adminEdittestimonial.tpl');
		}

		return $content;
	}

}