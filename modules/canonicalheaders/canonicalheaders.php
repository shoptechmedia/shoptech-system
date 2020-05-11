<?php 

if (!defined('_PS_VERSION_')) {
	exit;
}

class canonicalheaders extends Module
{
	public function __construct()
	{
		$this->name = 'canonicalheaders';
		$this->tab = 'Canonical header';
		$this->author = 'Prestaspeed.dk';
		$this->version = 1.0;
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Canonical Headers');
		$this->description = $this->l('Add canonical links');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	public function installDb() {

		return Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'htttp_links (
			id_link int(30) Auto_INCREMENT PRIMARY KEY,
			link_address VARCHAR(100) NOT NULL,
			type int(10) NOT NULL,
			type_id VARCHAR(30) NOT NULL,
			store_id VARCHAR(30) NOT NULL
		)');

	}

	public function deleteDB() {
		return Db::getInstance()->execute('DROP TABLE '._DB_PREFIX_.'htttp_links');
	}

	public function install() {

		if (!parent::install() 

		|| !$this->registerHook('actionAdminControllerSetMedia')

        || !$this->registerHook('displayHeader') 

        || !$this->registerHook('actionProductUpdate') 

        || !$this->registerHook('backOfficeFooter')

        || !$this->registerHook('actionProductUpdate')

        || !$this->registerHook('displayBackOfficeHeader')

		|| !$this->registerHook('displayBeforeBodyClosingTag')

        || !$this->installDb() ) {

			return false;

		}

		return true;

	}



	public function uninstall() {
		if (!parent::uninstall() || !$this->deleteDB() ) {
			return false;
		}

		return true;
	}

	public function hookHeader() {
		$id = null;
		$type = null;
		$output = null;
		$base_url = $_SERVER['SERVER_NAME'];
		//$id = (int)Tools::getValue('id_product'); 
		$control = Tools::getValue('controller');
		if ($control == 'category') {
			$type = 2;
			$id = (int)Tools::getValue('id_category');
		} 

		if ($control == 'product') {
			$type = 1;
			$id = (int)Tools::getValue('id_product');
		}

		if ($control == 'cms') {
			$type = 3;
			$id = (int)Tools::getValue('id_cms');
		}
		$store_id = Shop::getContextShopID();
		$output = null;
	//a	$output .= Tools::getValue('controller');
		if ($id !== null && $id !== 0) {
			$check_link = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."htttp_links WHERE type = '$type' AND type_id = '$id' AND store_id = '$store_id'");
			foreach ($check_link as $val) {
				if (substr($val['link_address'], 0, 1) == '/' ) {
					$output .= '<link rel="canonical" href="http://' .$base_url . $val['link_address'] . '">';
				} else {
					$output .= '<link rel="canonical" href="'. $val['link_address'] . '">';
				}
			}
		}
	//	$output = (int)Tools::getValue('id_category'); 
		// $output .= Shop::getContextShopID();
		return $output;
	}

	public function HookBackOfficeFooter() {
		$text = $this->l('Add A Canonical Link');

		if (!Tools::getValue('id_product')) {
			$js_2 = '<script>
					$(document).ready(function(){
						$("<div class=\"col-lg-12\"><div class=\"addProd_clink_wrap col-lg-12\" style=\"margin-left: 4.8vw;margin-bottom: 10px;\"><label for=\"add_clink\" style=\"font-weight: 400;margin-right: 12px;text-decoration: none;font-size: 13px;color: #3586AE;background-color: #edf7fb; border: none;border-bottom: solid 1px #D8EDF7;padding: 0 5px;-webkit-border-radius: 3px;border-radius: 3px;\">Add A Canonical Link</label><input type=\"text\" name=\"add_clink\" id=\"add_clink\" style=\"width: 50%;display: inline-block;\" placeholder=\"You have to save this product first before using this feature\" disabled=\"disabled\"><span style=\"display: block;font-size: 11px;font-style: italic;opacity: .7;margin-left: 9vw;margin-top: 5px;\">Canonical links can be added with or without the site url, ex. \"http//www.example.com/t-shirts\" or \"/t-shirts\"</span><button class=\"btn tbn-default hidden\" id=\"link_save\">Save</button></div></div>").insertAfter($( "#product-informations #product-pack-container" ));
					});
				</script>';
		}

		if (Tools::getValue('id_product')) {

			$js = '

				<script>

					$(document).ready(function(){
						var text = "'.$text.'";

						var id = "' . (int)Tools::getValue('id_product') . '";

						var type = "1";

						var base_dir = "'.__PS_BASE_URI__.'";

						var store_id = "'.Shop::getContextShopID().'";

						$("<div class=\"form-group\"><label for=\"add_clink\">"+text+"</label><div class=\"input-group addProd_clink_wrap\"><input class=\"form-control\" type=\"text\" name=\"add_clink\" id=\"add_clink\"><button class=\"btn btn-info\" id=\"link_save\">Save</button></div><small>Canonical links can be added with or without the site url, ex. \"http//www.example.com/t-shirts\" or \"/t-shirts\"</small></div>").insertAfter($( "#product-informations #product-pack-container" ));

						$("#link_save").click(function(){

							$.ajax({

								url: base_dir + "modules/canonicalheaders/ajax.php",

								dataType: "text",

								data: {

									"id": id,

									"type": type,

									"store_id" : store_id,

									"link": $("#add_clink").val(),

								},

								type: "POST",

								success: function(res) {

									$("#link_save").text("Saved");

								}, error: function (){

									console.log(0);

								}

							});

							return false;

						});



						$(".panel-footer button").click(function(){

							$("#link_save").click();

						});



						$.ajax({

							url: base_dir + "modules/canonicalheaders/ajaxgetData.php",

							dataType: "text",

							data: {

								"id": id,

								"type": type,

								"store_id" : store_id,

							},

							type: "POST",

							success: function(res) {

								$("#add_clink").val(res);

							}, error: function (){

								console.log(0);

							}

						});

					});

				</script>

			';

		}



		if (Tools::getValue('id_category')) {

			$js = '

				<script>

					$(document).ready(function(){

						var text = "'.$text.'";

						var id = "' . (int)Tools::getValue('id_category') . '";

						var type = "2";

						var base_dir = "'.__PS_BASE_URI__.'";

						var store_id = "'.Shop::getContextShopID().'";

						$("<div class=\"form-group\"><label for=\"add_clink\">"+text+"</label><div class=\"input-group addProd_clink_wrap\"><input class=\"form-control\" type=\"text\" name=\"add_clink\" id=\"add_clink\"><button class=\"btn btn-info\" id=\"link_save\">Save</button></div><small>Canonical links can be added with or without the site url, ex. \"http//www.example.com/t-shirts\" or \"/t-shirts\"</small></div>").insertAfter($( "#category_form .form-wrapper > .form-group:nth-child(1)" ));

						$("#link_save").click(function(){

							$.ajax({

								url: base_dir + "modules/canonicalheaders/ajax.php",

								dataType: "text",

								data: {

									"id": id,

									"type": type,

									"store_id" : store_id,

									"link": $("#add_clink").val(),

								},

								type: "POST",

								success: function(res) {

									$("#link_save").text("Saved");

								}, error: function (){

									console.log(0);

								}

							});

							return false;

						});

						$(".panel-footer button").click(function(){

							$("#link_save").click();

						});

						$.ajax({

							url: base_dir + "modules/canonicalheaders/ajaxgetData.php",

							dataType: "text",

							data: {

								"id": id,

								"type": type,

								"store_id" : store_id,

							},

							type: "POST",

							success: function(res) {

								$("#add_clink").val(res);

							}, error: function (){

								console.log(0);

							}

						});

					});

				</script>

			';

		}	

		if (Tools::getValue('id_cms')) {

			$js = '

				<script>

					$(document).ready(function(){
						var text = "'.$text.'";

						var id = "' . (int)Tools::getValue('id_cms') . '";

						var type = "3";

						var base_dir = "'.__PS_BASE_URI__.'";

						var store_id = "'.Shop::getContextShopID().'";

						$("<div class=\"form-group\"><label for=\"add_clink\">"+text+"</label><div class=\"input-group addProd_clink_wrap\"><input class=\"form-control\" type=\"text\" name=\"add_clink\" id=\"add_clink\"><button class=\"btn btn-info\" id=\"link_save\">Save</button></div><small>Canonical links can be added with or without the site url, ex. \"http//www.example.com/t-shirts\" or \"/t-shirts\"</small></div>").insertAfter($( "#cms_form .form-wrapper > .form-group:nth-child(5)" ));

						$("#link_save").click(function(){

							$.ajax({

								url: base_dir + "modules/canonicalheaders/ajax.php",

								dataType: "text",

								data: {

									"id": id,

									"type": type,

									"store_id" : store_id,

									"link": $("#add_clink").val(),

								},

								type: "POST",

								success: function(res) {

									$("#link_save").text("Saved");

								}, error: function (){

									console.log(0);

								}

							});

							return false;

						});

						$(".panel-footer button").click(function(){

							$("#link_save").click();

						});

						$.ajax({

							url: base_dir + "modules/canonicalheaders/ajaxgetData.php",

							dataType: "text",

							data: {

								"id": id,

								"type": type,

								"store_id" : store_id,

							},

							type: "POST",

							success: function(res) {

								$("#add_clink").val(res);

							}, error: function (){

								console.log(0);

							}

						});

					});

				</script>

			';

		}	

		return $js.$js_2;
	}

	public function hookActionProductUpdate() {
		$content = null;
		return $content;
	}

	public function hookDisplayBeforeBodyClosingTag() {
		$text = $this->l('Add A Canonical Link');
		$url = $_SERVER['REQUEST_URI'];
		$url = explode('/', $url);
		$get_end_url = substr(end($url), 0, 1);
		if ($get_end_url !== 0 || !empty($get_end_url) || is_int($get_end_url)) {
		$js = '

			<script>

				$(document).ready(function(){
					var text = "'.$text.'";
					var id = "'.$get_end_url.'";
					var test = "' . (int)Tools::getValue('id_product') . '";

					var type = "1";

					var base_dir = "'.__PS_BASE_URI__.'";

					var store_id = "'.Shop::getContextShopID().'";

						var afterThisELem = $("#form_content #step5").find("h2");
						$("<div class=\"\"><div class=\"addProd_clink_wrap\" style=\"margin-bottom: 10px;\"><div style=\"\" style=\"font-weight: 400;margin-right: 12px;text-decoration: none;font-size: 13px;color: #3586AE;background-color: #edf7fb; border: none;border-bottom: solid 1px #D8EDF7;padding: 0 5px;-webkit-border-radius: 3px;border-radius: 3px;\">"+text+"</div><input style=\"width: 50%; display:inline-block;\" type=\"text\" name=\"add_clink\" id=\"add_clink\"><span style=\"display: block;font-size: 11px;font-style: italic;opacity: .7;margin-top: 5px;\">Canonical links can be added with or without the site url, ex. \"http//www.example.com/t-shirts\" or \"/t-shirts\"</span><button class=\"btn tbn-default hidden\" id=\"link_save\" style=\"display:none;\">Save</button></div></div>").insertAfter(afterThisELem);

						$("#link_save").click(function(){

							$.ajax({

								url: base_dir + "modules/canonicalheaders/ajax.php",

								dataType: "text",

								data: {

									"id": id,

									"type": type,

									"store_id" : store_id,

									"link": $("#add_clink").val(),

								},

								type: "POST",

								success: function(res) {

									$("#link_save").text("Saved");

								}, error: function (){

									console.log(0);

								}

							});

							return false;

						});

						$(".product-footer #submit").click(function(){

							$("#link_save").click();

						});

						$.ajax({

							url: base_dir + "modules/canonicalheaders/ajaxgetData.php",

							dataType: "text",

							data: {

								"id": id,

								"type": type,

								"store_id" : store_id,

							},

							type: "POST",

							success: function(res) {

								$("#add_clink").val(res);

							}, error: function (){

								console.log(0);

							}

						});

					});

			</script>

		';
		}

		return $js;

	}

}