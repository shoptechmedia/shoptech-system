<?php

if (!defined('_PS_VERSION_'))
	exit;

class ThemeEditor extends Module {
	
	private $systemFonts = array(
		array(
			'id_option' => 0,
			'name' => 'Arial'
			),
		array(
			'id_option' => 1,
			'name' => 'Georgia'
			),
		array(
			'id_option' => 2,
			'name' => 'Tahoma'
			),
		array(
			'id_option' => 3,
			'name' => 'Times New Roman'
			),
		array(
			'id_option' => 4,
			'name' => 'Verdana'
			)
		);
							        
	private $_html = '';
	private $user_groups;
	private $_postErrors = array();

	public function __construct() {
		$this->name = 'themeeditor';
		$this->tab = 'front_office_features';
		$this->version = '3.8.7';
		$this->author = 'IQIT-COMMERCE.COM';
		$this->need_instance = 0;
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Theme Editor module');
		$this->description = $this->l('Allows to change theme design');
	
		$this->configName = 'thmedit';

		$this->defaultsBorders  = array(
			'breadcrumb_border' => '1;0;#d6d4d4',
			'product_border_color' => '1;1;#EBEBEB',
			'product_h_border_color' => '1;1;#EBEBEB',
			'btn_small_border' => '1;0;#d6d4d4',
			'btn_medium_border' => '1;0;#d6d4d4',
			'btn_cart_border' => '1;0;#d6d4d4',
			'btn_cartp_border' => '1;0;#d6d4d4',
			'top_border_color' => '1;0;#d6d4d4',
			'top_bordert_color' => '1;0;#d6d4d4',
			'headerw_border_color' => '1;0;#d6d4d4',
			'header_inner_border_color' => '1;1;#d6d4d4',
			'mh_btn_border' => '1;1;#d6d4d4',
			'mh_dd_input_border' => '1;1;#d6d4d4',
			'cart_box_border' => '1;1;#d6d4d4',
			'content_headings_border' => '1;1;#d6d4d4',
			'content_block_border_c' => '0;0;#d6d4d4',
			'content_element_border_c' => '0;0;#d6d4d4',
			'footer1_inner_border_color' => '1;1;#d6d4d4',
			'footer1_border_color' => '1;1;#d6d4d4',
			'footer_inner_border_color' => '1;1;#d6d4d4',
			'footer_border_color' => '1;1;#d6d4d4',
			'footer_bordert_color' => '1;1;#d6d4d4',
			'footer1_border_title' => '1;1;#d6d4d4',
			'footer_border_title' => '1;1;#d6d4d4',
			//376
			'content_input_border' => '1;1;#d6d4d4',

		);

		$this->predefaults = array(
		'big_responsive' => 1,
		'ajax_popup' => 1,
		'yotpo_stars' => 0, 
		'preloader' => 0,
		'retina_logo' => '',
		'top_width' => 1,
		'footer_width' => 1,
		'content_margin' => 0,
		'left_on_phones' => 1,
		'breadcrumb_width' => 1,
		'breadcrumb_bg' => 'transparent',
		'breadcrumb_color' => '#777777',
		'force_boxed' => 0,
		'content_shadow' => 0,
		'global_bg_color' => '#ffffff',
		'global_bg_type' => 2,
		'global_bg_image' => '',
		'global_bg_pattern' => 0,
		'global_bg_repeat' => 0,
		'global_bg_position' => 0,
		'global_bg_fixed' => 0,

		'top_banner_color' => '#000000',

		'top_bg_color' => '#f8f8f8',
		'top_bg_type' => 2,
		'top_bg_image' => '',
		'top_bg_pattern' => 0,
		'top_bg_repeat' => 0,
		'top_bg_position' => 0,
		'top_ddown_bg' => '#ffffff',
		'top_ddown_color' => '#777777',
		'top_txt_color' => '#777777',
		'top_link_color' => '#777777',
		'top_link_h_color' => '#333333',

		'h_wrap_bg_color' => 'transparent',
		'h_wrap_bg_type' => 2,
		'h_wrap_bg_image' => '',
		'h_wrap_bg_pattern' => 0,
		'h_wrap_bg_repeat' => 0,
		'h_wrap_bg_position' => 0,

		'header_bg_color' => '#ffffff',
		'header_bg_type' => 2,
		'header_bg_image' => '',
		'header_bg_pattern' => 0,
		'header_bg_repeat' => 0,
		'header_bg_position' => 0,
		'header_input_text'	=> '#9c9b9b',
		'header_input_bg' => '#ffffff',
		'header_txt_color' => '#777777',
		'header_link_color' => '#777777',
		'header_link_h_color' => '#333333',
		'cart_style' => 0,
		'icon_size' => 14,
		'cart_icon' => 1,
		'cart_bg' => '#333333',
		'cart_txt' => '#ffffff',
		'cart2_bg' => '#eeeeee',
		'cart2_txt' => '#777777',
		'cart_box_bg' => '#ffffff',
		'cart_box_txt' => '#777777',
		'cart_box_txt_h' => '#333333',
		'cart_box2_bg' => '#f6f6f6',
		


		'c_wrap_bg_color' => 'transparent',
		'c_wrap_bg_type' => 2,
		'c_wrap_bg_image' => '',
		'c_wrap_bg_pattern' => 0,
		'c_wrap_bg_repeat' => 0,
		'c_wrap_bg_position' => 0,

		'content_bg_color' => '#ffffff',
		'content_bg_type' => 2,
		'content_bg_image' => '',
		'content_bg_pattern' => 0,
		'content_bg_repeat' => 0,
		'content_bg_position' => 0,
		'content_inner_border_color' => '#dddddd',
		'content_txt_color' => '#777777',
		'content_link_color' => '#777777',
		'content_link_h_color' => '#333333',
		'content_input_text'	=> '#9c9b9b',
		'content_input_bg' => '#ffffff',
		'content_input_select' => NULL,
		'content_tab_style' => 0,
		'content_headings_color' => '#777777',
		'content_box_bg' => '#f8f8f8',
		'content_box_color' => '#777777',
		'content_bgh_status' => 0,
		'content_bgh' => '#F3F3F3',
		'content_block_bg' => 'transparent',
		'content_element_bg' => 'transparent',
		
		'alertsuccess_bg' => '#55c65e',
		'alertsuccess_txt' => '#ffffff',
		'alertinfo_bg' => '#5192f3',
		'alertinfo_txt' => '#ffffff',
		'alertwarning_bg' => '#fe9126',
		'alertwarning_txt' => '#ffffff',
		'alertdanger_bg' => '#f3515c',
		'alertdanger_txt' => '#ffffff',

		'f_wrap_width' => 1,
		'f_wrap_bg_color' => '#ffffff',
		'f_wrap_bg_type' => 2,
		'f_wrap_bg_image' => '',
		'f_wrap_bg_pattern' => 0,
		'f_wrap_bg_repeat' => 0,
		'f_wrap_bg_position' => 0,
		'f_wrap_padding' => 0,

		'footer_bg_color' => '#f8f8f8',
		'footer_bg_type' => 2,
		'footer_bg_image' => '',
		'footer_bg_pattern' => 0,
		'footer_bg_repeat' => 0,
		'footer_bg_position' => 0,
		'footer_txt_color' => '#777777',
		'footer_link_color' => '#777777',
		'footer_link_h_color' => '#333333',
		'footer_input_text'	=> '#9c9b9b',
		'footer_input_bg' => '#ffffff',
		'footer_social_round' => 1,
		'footer_social_color' => '#ffffff',
		'footer_social_bg' => '#99999b',
		'footer_headings_color' => '#555454',
		'footer_bgh_status' => 0,
		'footer_bgh' => '#F3F3F3',
		'footer_ul_arrows' => 1,

		'footer1_status' => 1,
		'footer1_bg_color' => '#f8f8f8',
		'footer1_bg_type' => 2,
		'footer1_bg_image' => '',
		'footer1_bg_pattern' => 0,
		'footer1_bg_repeat' => 0,
		'footer1_bg_position' => 0,
		'footer1_txt_color' => '#777777',
		'footer1_link_color' => '#777777',
		'footer1_link_h_color' => '#333333',
		'footer1_headings_color' => '#555454',
		'footer1_bgh' => '#F3F3F3',

		'show_desc' => 0,
		'desc_style' => 1,
		'show_subcategories' => 0,
		'grid_size_lg' => 5,
		'grid_size_md' => 4,
		'grid_size_sm' => 3,
		'grid_size_ms' => 2,
		'grid_size_xs' => 1,
		'productlist_view' => 1,
		'product_hover' => 1,
		'show_condition' => 1,
		'product_names' => 0,
		'product_price_length' => 0,
		'product_colors' => 0,
		'product_reference' => 0,
		'product_grid_border' => 0,
		'product_grid_center' => 1,
		'product_box_h_status' => 0,
		'product_box_h_bg' => 'transparent',
		'product_box_h_txt' => '#777777',
		'product_box_h_txt_h' => '#333333',
		'product_box_h_price' => '#f13340',
		'functional_buttons' => 1,
		'functional_buttons_bg' => '#ffffff',
		'functional_buttons_txt' => '#777777',
		'functional_buttons_txt_h' => '#333333',
		'carousel_style' => 1,
		'car_color' => '#dddddd',
		'car_color_h' => '#333333',
		'car_bg' => '#f8f8f8',
		'car_bg_h' => '#B6B6B6',
		'top_pagination' => 1,
		'show_buttons' => 1,
		'show_qty_field' => 0,
		'show_on_hover' => 0,
		'product_right_block' => 1,
		'thumbs_position' => 0,
		'accesories_position' => 0,
		'product_tabs' => 1,
		'product_left_size' => 4,
		'product_center_size' => 8,
		'label_uppercase' => 1,
		'label_new_bg' => '#6ad4ff',
		'label_new_txt' => '#ffffff',
		'label_sale_bg' => '#f13340',
		'label_sale_txt' => '#ffffff',
		'label_online_bg' => '#ffffff',
		'label_online_txt' => '#777777',
		'label_stock_bg' => '#46B64F',
		'label_stock_txt' => '#ffffff',
		'label_ostock_bg' => '#ffffff',
		'label_ostock_txt' => '#ff7430',
		'price_color' => '#f13340',
		'stars_color' => '#f13340',
		'default_font_s' => 13,
		'heading_font_s' => 20,
		'subheading_font_s' => 16,
		'boxtitle_font_s' => 13,
		'fboxtitle_font_s' => 13,
		'mainmenu_font_s' => 14,
		'breadcrumb_font_s' => 11,
		'pname_font_s' => 13,
		'price_font_s' => 13,
		'labels_font_s' => 9,
		'buttons_font_s' => 12,
		'font_headings_type' => 1,
		'font_headings_link' => 'http://fonts.googleapis.com/css?family=Open+Sans:400,700',
		'font_headings_name' => '\'Open Sans\', sans-serif',
		'font_headings_namec' => '\'Open Sans\', sans-serif',
		'font_headings_default' => 1,
		'font_txt_type' => 2,
		'font_txt_link' => 'http://fonts.googleapis.com/css?family=Open+Sans:400,700',
		'font_txt_name' => '\'Open Sans\', sans-serif',
		'font_txt_namec' => '\'Open Sans\', sans-serif',
		'font_txt_default' => 1,
		'headings_uppercase' => 1,
		'headings_bold' => 0,
		'headings_italics' => 0,
		'headings_center' => 0,
		'btn_uppercase' => 1,	
		'btn_rounded' => 1,
		'btn_small_bg' => '#6f6f6f',
		'btn_small_txt' => '#ffffff',
		'btn_small_bg_h' => '#575757',
		'btn_small_txt_h' => '#ffffff',
		'btn_medium_bg' => '#43b754',
		'btn_medium_txt' => '#ffffff',
		'btn_medium_bg_h' => '#3aa04c',
		'btn_medium_txt_h' => '#ffffff',
		'btn_cart_bg' => '#6f6f6f',
		'btn_cart_txt' => '#ffffff',
		'btn_cart_bg_h' => '#575757',
		'btn_cart_txt_h' => '#ffffff',
		'btn_cartp_bg' => '#6f6f6f',
		'btn_cartp_txt' => '#ffffff',
		'btn_cartp_bg_h' => '#575757',
		'btn_cartp_txt_h' => '#ffffff',
		'top_bar' => 1,
		'logo_width' => 0,
		'logo_position' => 1,
		'header_padding' => 0,
		'header_style' => 0,
		'mobile_header_style' => 1,
		'mobile_header_sticky' => 1,
		'mobile_header_search' => 0,
		'mh_bg' => '#ffffff',
		'mh_logo_bg' => '#ffffff',
		'mh_icon_color' => '#777777',
		'mh_icon_a_color' => '#333',
		'mh_btn_a_bg' => '#F6F6F6',
		'mh_dd_bg' => '#ffffff',
		'mh_dd_txt' => '#777777',
		'mh_dd_input_bg' => '#ffffff',
		'mh_dd_input_txt' => '#777777',
		'header_width' => 0,
		'absolute_header_padding'=> 0,
		'header_absolute' => 0,
		'header_absolute_bg' => 'transparent',
		'header_absolute_w_bg' => 'rgba(0, 0, 0, 0.4)',
		'header_increase' => 0,
		'table_bg' => '#f8f8f8',
		'table_color' => '#777777',
		'ddown_bg' => '#ffffff',
		'ddown_color' => '#777777',
		'second_footer' => 1,
		'copyright_text' => '2014 Powered by iqit-commerce.com. All Rights Reserved',
		'footer_img_disable' => 0,
		'custom_css' => '',
		'custom_js' => '',
		'custom_font_include' => '',
		'carousel_dots' => 1,
		'carousel_auto' => 0,
		'carousel_load' => 1,
		'dot_color' => '#B0B0B0',
		'dot_a_color' => '#333333',
		'product_box_status' => 0,
		'product_box_bg' => 'transparent',
		'product_box_txt' => '#777777',
		'product_box_txt_h' => '#333333',
		'product_box_price' => '#f13340',
		'product_box_rating' => '#f13340',
		'product_box_h_rating' => '#f13340',
		'show_catimage' => 1,
		'subcats_grid_size_md' => 2,
		'subcats_grid_size_sm' => 15,
		'subcats_grid_size_xs' => 3,

		//373
		'bg_totop' => '#ffffff',
		'bgh_totop' => '#575757',
		'icon_totop' => '#666666',
		'iconh_totop' => '#ffffff',
		);

		$this->defaults = array_merge($this->predefaults, $this->defaultsBorders);
	}

	
	public function install() {
		if (parent::install() AND $this->registerHook('displayHeader') AND $this->registerHook('calculateGrid') AND $this->registerHook('displayAdminHomeQuickLinks')) {
			$this->setDefaults();
			return true;
		} else {
			return false;
		}
	}

	public function uninstall() {
		if (parent::uninstall())
		{
			foreach ($this->defaults as $default => $value) 
				Configuration::deleteByName($this->configName.'_'.$default);
			return true;
		}
		return false;	
	}

	public function setDefaults(){
		foreach ($this->defaults as $default => $value) {

			if($default == 'copyright_text')
			{
					$message_trads = array();
					foreach (Language::getLanguages(false) as $lang)
							$message_trads[(int)$lang['id_lang']] = '<p>2014 Powered by iqit-commerce.com. All Rights Reserved</p>';
					
			Configuration::updateValue($this->configName.'_'.$default, $message_trads, true);
			}
			else
			Configuration::updateValue($this->configName.'_'.$default, $value);
		}

		Configuration::updateValue('PS_QUICK_VIEW', 1);
	}

	public function getContent() {

		$this->context->controller->addJqueryPlugin('colorpicker');
		$this->context->controller->addCSS(($this->_path).'css/admin/admin.css');
		$this->context->controller->addJS(($this->_path).'js/admin/script.js');
		$this->context->controller->addJS(($this->_path).'js/admin/shBrushJScript.js');
	
		$errors = '';
		$id_shop = (int)$this->context->shop->id;

		if (Tools::isSubmit('save_editor')) {
			
			$this->registerHook('calculateGrid');

			foreach ($this->defaults as $default => $value) {

				if($default == 'custom_css')
				{
					if (isset($_POST[$default]))
						Configuration::updateValue($this->configName.'_'.$default, $_POST[$default]);			
				}
				elseif(array_key_exists($default, $this->defaultsBorders))
				{
					Configuration::updateValue($this->configName.'_'.$default, Tools::getValue($default.'_width').';'.Tools::getValue($default.'_type').';'.Tools::getValue($default.'_color'));
				}	
				elseif($default == 'copyright_text')
				{
					$message_trads = array();
					foreach ($_POST as $key => $value)
						if (preg_match('/copyright_text_/i', $key))
						{
							$id_lang = preg_split('/copyright_text_/i', $key);
							$message_trads[(int)$id_lang[1]] = $value;
						}
						Configuration::updateValue($this->configName.'_'.$default, $message_trads, true);
				}
				elseif($default == 'footer_img_disable')
				{
					if ($default == 'footer_img_disable' && isset($_FILES['footer_img_src']) && isset($_FILES['footer_img_src']['tmp_name']) && !empty($_FILES['footer_img_src']['tmp_name']))
					{
						Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);
						if (file_exists(dirname(__FILE__).'/img/footer_logo_'.(int)$id_shop.'.jpg'))
							unlink(dirname(__FILE__).'/img/footer_logo_'.(int)$id_shop.'.jpg');
						if ($error = ImageManager::validateUpload($_FILES['footer_img_src']))
							$errors .= $error;
						elseif (!($tmp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['footer_img_src']['tmp_name'], $tmp_name))
							return false;
						elseif (!ImageManager::resize($tmp_name, dirname(__FILE__).'/img/footer_logo_'.(int)$id_shop.'.jpg'))
							$errors .= $this->displayError($this->l('An error occurred while attempting to upload the image.'));
						if (isset($tmp_name))
							unlink($tmp_name);
					}
					if (file_exists(dirname(__FILE__).'/img/footer_logo_'.(int)$id_shop.'.jpg'))
					{
						Configuration::updateValue($this->configName.'_'.$default, 0);
					}
				}
				else
				Configuration::updateValue($this->configName.'_'.$default, (Tools::getValue($default)));
			}


			Configuration::updateValue('PS_QUICK_VIEW', (int)(Tools::getValue('PS_QUICK_VIEW')));


			$this->generateCss();

			if (isset($errors) AND $errors!='')
				$this->_html .= $this -> displayError($errors);
			else
				$this->_html .= $this -> displayConfirmation($this->l('Settings updated'));

		}

		elseif (Tools::isSubmit('reset_editor')) {
			
			$this->setDefaults();
			$this->generateCss();
			$this->_html .= $this -> displayConfirmation($this->l('Settings reset'));

		}

		// Delete logo image retrocompat 1.5
		elseif (Tools::isSubmit('deleteFooterImage'))
		{
			if (!file_exists(dirname(__FILE__).'/img/footer_logo_'.(int)$id_shop.'.jpg'))
				$errors .= $this->displayError($this->l('This action cannot be made.'));
			else
			{
				unlink(dirname(__FILE__).'/img/footer_logo_'.(int)$id_shop.'.jpg');
				Configuration::updateValue('footer_img_disable', 1);
				Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.(int)Tab::getIdFromClassName('AdminModules').(int)$this->context->employee->id));
			}
			$this->_html .= $errors;
		}

		elseif (Tools::isSubmit('exportConfiguration'))
		{
						
			$var =  array();

			foreach ($this->defaults as $default => $value) {

				if($default == 'copyright_text')
				{
					foreach (Language::getLanguages(false) as $lang)
						$var[$default][(int)$lang['id_lang']] = Tools::getValue($default.'_'.(int)$lang['id_lang'], Configuration::get($default, (int)$lang['id_lang']));
				}
				else
					$var[$default] = Configuration::get($this->configName.'_'.$default);
		}
			
		$var['PS_QUICK_VIEW'] = (int)Tools::getValue('PS_QUICK_VIEW', Configuration::get('PS_QUICK_VIEW'));

			$file_name = 'themeditor_'.time().'.csv';
			$fd = fopen($this->getLocalPath().$file_name, 'w+');
			file_put_contents($this->getLocalPath().'export/'.$file_name, print_r(serialize($var), true));
			fclose($fd);
			Tools::redirect(_PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/export/'.$file_name);
		}

		elseif (Tools::isSubmit('importConfiguration'))
		{

			if(isset($_FILES['uploadConfig']) && isset($_FILES['uploadConfig']['tmp_name']))
			{
				$str = file_get_contents($_FILES['uploadConfig']['tmp_name']);
				$arr = unserialize($str);


				foreach ($arr as $default => $value) {
					if($default == 'copyright_text')
					{
						$message_trads = array();
						foreach ($_POST as $key => $value)
							if (preg_match('/copyright_text_/i', $key))
							{
								$id_lang = preg_split('/copyright_text_/i', $key);
								$message_trads[(int)$id_lang[1]] = $value;
							}
							Configuration::updateValue($this->configName.'_'.$default, $message_trads, true);
						}

						elseif($default == 'PS_QUICK_VIEW')
						Configuration::updateValue('PS_QUICK_VIEW', $value);

						elseif($default != 'footer_img_disable')
							Configuration::updateValue($this->configName.'_'.$default, $value);

					}

					$this->generateCss();

					if (isset($errors) AND $errors!='')
						$this->_html .= $this -> displayError($errors);
					else
						$this->_html .= $this -> displayConfirmation($this->l('Configuration imported'));
				}
				else
					$this->_html .= $this -> displayError($this->l('No config file'));				

			}


		$this->_html .= '<div class="panel clearfix">
		<form class="pull-left" id="importForm" method="post" enctype="multipart/form-data" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importConfiguration&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">
		<div style="display:inline-block;"><input type="file" id="uploadConfig" name="uploadConfig" /></div>
	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Import configuration').'</button>
		
		</form>

		


		<a href="'.$this->context->link->getAdminLink('AdminModules', false).'&exportConfiguration&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">
		<button class="btn btn-default btn-lg pull-right"><span class="icon icon-share"></span> '.$this->l('Export configuration(Export only saved settigns, save before export)').'</button>
		</a></div>';
		$this->_html .= $this->renderForm();

		return $this->_html;
	}


	public function renderForm()
	{

		$fields_form_main = array(
			'form' => array(
				'tab_name' => 'main_tab',
				'legend' => array(
					'title' => $this->l('Main configuration'),
					'icon' => 'icon-edit'
					),
				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('Big resolution'),
						'label' => $this->l('Enable media query for screens with min-width 1320px '),
						'name' => 'big_responsive',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Ajax pop-up'),
						'name' => 'ajax_popup',
						'desc' => $this->l('Ajax pop up after add to cart'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Quick view'),
						'name' => 'PS_QUICK_VIEW',
						'desc' => $this->l('Quick view popup'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Yotpo stars'),
						'name' => 'yotpo_stars',
						'is_bool' => true,
						'desc' => $this->l('Show yotpo module product ratings on product list pages'),
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Page preloader'),
						'name' => 'preloader',
						'desc' => $this->l('Show preloader until page is fully loaded'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					 array(
						'type' => 'background_image',
						'desc' => $this->l('Retina ready logo should be twice bigger than logo updated in prefrences > themes'),
						'label' => $this->l('Retina ready logo'),
						'name' => 'retina_logo',	
						'size' => 30,
					),
					)
				),
			);
			
			$globalFields = $this->globalFormFields('global');
			
			$fields_form_global_design = array(
			'form' => array(
				'tab_name' => 'globa_design_tab',
				'legend' => array(
					'title' => $this->l('Global design options'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('Content margin'),
						'name' => 'content_margin',
						'desc' => $this->l('Add 20px margin on top and bottom of content'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'select',
						'label' => $this->l('Container width and boxed design'),
						'name' => 'force_boxed',
						'desc' => $this->l('if you set "boxed design" Top bar, footer slider will be set to content width no matter individual style'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 3,
								'name' => $this->l('100% container width')
								),
							array(
								'id_option' => 2,
								'name' => $this->l('90% container width')
								),
							array(
								'id_option' => 1,
								'name' => $this->l('Force boxed design')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Default')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Content shadow'),
						'name' => 'content_shadow',
						'desc' => $this->l('Enable this only with force boxed design, it will add shadow to boxed content'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'select',
						'label' => $this->l('Left column position on phones'),
						'name' => 'left_on_phones',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Below main content')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Above main content')
								)
							),                           
    						'id' => 'id_option',                        
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'select',
						'label' => $this->l('Breadcrumb width'),
						'name' => 'breadcrumb_width',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Content width')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Full width')
								)
							),                          
    						'id' => 'id_option',                       
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Breadcrumb bottom border'),
						'name' => 'breadcrumb_border',
						),
					array(
						'type' => 'color',
						'label' => $this->l('Breadcrumb background color'),
						'name' => 'breadcrumb_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Breadcrumb text color'),
						'name' => 'breadcrumb_color',
						'separator' => true,
						'size' => 30,
					),
						array(
						'type' => 'link_url',
						'label' => $this->l('Columns configuration'),
						'desc' => $this->l('Configure columns for each shop page'),
						'name' => 'column_url',
						'separator' => true,
						'url' => 'index.php?tab=AdminThemes&id_theme='.$this->context->shop->id_theme.'&updatetheme&token='.Tools::getAdminTokenLite('AdminThemes'),
						),
						$globalFields['bg_color'],
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],
												array(
						'type' => 'switch',
						'label' => $this->l('Fixed positon background'),
						'name' => 'global_bg_fixed',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
										
					)
				),
			);
			$fields_form_productslist = array(
			'form' => array(
				'tab_name' => 'productslist_tab',
				'legend' => array(
					'title' => $this->l('Product lists and sliders'),
					'icon' => 'icon-edit'
					),
			'input' => array(
					array(
						'type' => 'select',
						'row_title' => $this->l('General'),
						'label' => $this->l('Product name length'),
						'name' => 'product_names',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('Three line')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('Two line')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('One line')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'select',
						'label' => $this->l('Price length'),
						'name' => 'product_price_length',
						'desc' => $this->l('How much lines preserve for price in product grid. Two line option maybe helpfull when you use EU law module with tax labels or large font size for price'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 1,
								'name' => $this->l('Two line')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('One line')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Product reference'),
						'desc' => $this->l('Show product reference on product list'),
						'name' => 'product_reference',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'select',
						'label' => $this->l('Product colors on grid view'),
						'name' => 'product_colors',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('Show')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('Show only on hover')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Hide')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Center product box'),
						'name' => 'product_grid_center',
						'desc' => $this->l('Center align of product name, price, ratings, buttons'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Lazy load'),
						'name' => 'carousel_load',
						'desc' => $this->l('Load images only when needed(only when they are visible on viewport). It  maybe improve performance'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Functional buttons'),
						'upper_separator' => true,
						'name' => 'functional_buttons',
						'desc' => $this->l('Quick view, compare and wishlist on product grid and sliders'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'color',
						'label' => $this->l('Functional buttons background color'),
						'name' => 'functional_buttons_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Functional buttons link color'),
						'name' => 'functional_buttons_txt',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Functional buttons link hover color'),
						'name' => 'functional_buttons_txt_h',
						'size' => 30,
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show add cart buttons'),
						'name' => 'show_buttons',
						'desc' => $this->l('Show add cart button on product listings'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Show quantity field'),
						'name' => 'show_qty_field',
						'desc' => $this->l('Show quantity selector next to add cart'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Show additional info only on hover'),
						'name' => 'show_on_hover',
						'separator' => true,
						'desc' => $this->l('Show product ratings and add cart button only on hover'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'select',
						'row_title' => $this->l('Product  carousels'),
						'label' => $this->l('Product carousel style'),
						'name' => 'carousel_style',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Next/Prev arrows on products line')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Next/Prev arrows on block title line')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'color',
						'label' => $this->l('Carousel arrow color'),
						'name' => 'car_color',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Carousel arrow hover color'),
						'name' => 'car_color_h',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Carousel arrow bg'),
						'name' => 'car_bg',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Carousel arrow hover bg'),
						'name' => 'car_bg_h',
						'size' => 30,
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Carousel dots'),
						'name' => 'carousel_dots',
						'desc' => $this->l('Shows dots navigation below carousels'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'color',
						'label' => $this->l('Dot color'),
						'name' => 'dot_color',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Dot active color'),
						'name' => 'dot_a_color',
						'size' => 30,
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Autoplay'),
						'name' => 'carousel_auto',
						'desc' => $this->l('Auto slide of products carousels'),
						'is_bool' => true,
							'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						
					array(
						'type' => 'select',
						'row_title' => $this->l('Grid size'),
						'label' => $this->l('Product grid size for large desktops'),
						'name' => 'grid_size_lg',
						'desc' => $this->l('Note: Each column enabled decrease this value by 1. After modifications of this values maybe needed change of home_default image size'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 6,
								'name' => $this->l('6 products')
								),
								array(
								'id_option' => 5,
								'name' => $this->l('5 products')
								),
								array(
								'id_option' => 4,
								'name' => $this->l('4 products')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('3 products')
								),
								array(
								'id_option' => 2,
								'name' => $this->l('2 products')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'select',
						'label' => $this->l('Product grid size for small desktops and tablets landscape'),
						'name' => 'grid_size_md',
						'desc' => $this->l('Note: Each column enabled decrease this value by 1. After modifications of this values maybe needed change of home_default image size'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 5,
								'name' => $this->l('5 products')
								),
								array(
								'id_option' => 4,
								'name' => $this->l('4 products')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('3 products')
								),
								array(
								'id_option' => 2,
								'name' => $this->l('2 products')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'select',
						'label' => $this->l('Product grid size for tablets portrait'),
						'name' => 'grid_size_sm',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 4,
								'name' => $this->l('4 products')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('3 products')
								),
								array(
								'id_option' => 2,
								'name' => $this->l('2 products')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'select',
						'label' => $this->l('Product grid size for phone landscape'),
						'name' => 'grid_size_ms',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 3,
								'name' => $this->l('3 products')
								),
								array(
								'id_option' => 2,
								'name' => $this->l('2 products')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('1 products')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'select',
						'label' => $this->l('Product grid size for phone portrait'),
						'name' => 'grid_size_xs',
						'separator' => true,
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('2 products')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('1 products')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'select',
						'row_title' => $this->l('Product box - normal'),
						'label' => $this->l('Product box-shadow'),
						'name' => 'product_grid_border',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 3,
								'name' => $this->l('Enabled')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Disabled')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Product border'),
						'name' => 'product_border_color',
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Product box colors'),
						'name' => 'product_box_status',
						'desc' => $this->l('Enable product color  options'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'color',
						'label' => $this->l('Product box background color'),
						'name' => 'product_box_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Product box text color'),
						'name' => 'product_box_txt',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Product box hover text color'),
						'name' => 'product_box_txt_h',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Product box price color'),
						'name' => 'product_box_price',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Product box rating stars'),
						'name' => 'product_box_rating',
						'size' => 30,
					),

						array(
						'type' => 'select',
						'upper_separator' => true,
						'row_title' => $this->l('Product box - hover'),
						'label' => $this->l('Product hover box-shadow'),
						'name' => 'product_hover',
						'desc' => $this->l('Adds box-shadow to product on hover'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 1,
								'name' => $this->l('Enabled')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Disabled')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'border_generator',
						'label' => $this->l('Product hover border'),
						'name' => 'product_h_border_color',
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Diffrent colors on hover'),
						'name' => 'product_box_h_status',
						'desc' => $this->l('Enable product hover color  options'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'color',
						'label' => $this->l('Hovered product box background color'),
						'name' => 'product_box_h_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Hovered product box text color'),
						'name' => 'product_box_h_txt',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Hovered product box hover text color'),
						'name' => 'product_box_h_txt_h',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Hovered product box price color'),
						'name' => 'product_box_h_price',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Hovered product box rating stars'),
						'name' => 'product_box_h_rating',
						'size' => 30,
					),
						
						)
				),
			);	

			$fields_form_products = array(
			'form' => array(
				'tab_name' => 'products_tab',
				'legend' => array(
					'title' => $this->l('Category page and Product page'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('Show category image'),
						'name' => 'show_catimage',
						'row_title' => $this->l('Category page'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Show description of category'),
						'name' => 'show_desc',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'select',
						'label' => $this->l('Category description style'),
						'name' => 'desc_style',
						'desc' => $this->l('You can choose style of category description if enabled'),
						'options' => array(
							'query' => array(
							array(
								'id_option' => 2,
								'name' => $this->l('Description below product list')
								),
							array(
								'id_option' => 1,
								'name' => $this->l('Description below image and above product list')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Description inside image - above product list')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Show subcategories thumbs'),
						'name' => 'show_subcategories',
						'desc' => $this->l('Show subcategories images on category page below description'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),

					array(
						'type' => 'select',
						'label' => $this->l('Subcategorie per line - desktop'),
						'name' => 'subcats_grid_size_md',
						'desc' => $this->l('How many subcategories images per line to show'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('6')
								),
								array(
								'id_option' => 15,
								'name' => $this->l('5')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('4')
								),
								array(
								'id_option' => 4,
								'name' => $this->l('3')
								),
								array(
								'id_option' => 6,
								'name' => $this->l('2')
								),
								array(
								'id_option' => 12,
								'name' => $this->l('1')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),

					array(
						'type' => 'select',
						'label' => $this->l('Subcategorie per line - tablet'),
						'name' => 'subcats_grid_size_sm',
						'desc' => $this->l('How many subcategories images per line to show'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('6')
								),
								array(
								'id_option' => 15,
								'name' => $this->l('5')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('4')
								),
								array(
								'id_option' => 4,
								'name' => $this->l('3')
								),
								array(
								'id_option' => 6,
								'name' => $this->l('2')
								),
								array(
								'id_option' => 12,
								'name' => $this->l('1')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),

					array(
						'type' => 'select',
						'label' => $this->l('Subcategorie per line - mobile'),
						'name' => 'subcats_grid_size_xs',
						'desc' => $this->l('How many subcategories images per line to show'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('6')
								),
								array(
								'id_option' => 15,
								'name' => $this->l('5')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('4')
								),
								array(
								'id_option' => 4,
								'name' => $this->l('3')
								),
								array(
								'id_option' => 6,
								'name' => $this->l('2')
								),
								array(
								'id_option' => 12,
								'name' => $this->l('1')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					
					array(
						'type' => 'select',
						'label' => $this->l('Default product list view'),
						'name' => 'productlist_view',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('Table view')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('Grid view')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('List view')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Display top pagination'),
						'name' => 'top_pagination',
						'desc' => $this->l('Possibility to hide top pagination on category pages'),
						'is_bool' => true,
							'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),			
						array(
						'type' => 'switch',
						'label' => $this->l('Show product condition on product page'),
						'name' => 'show_condition',
						'row_title' => $this->l('Product  page'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Right block on product page'),
						'desc' => $this->l('In this block you can show product page adverts module, additionaltab module, product accessories and hook "HOOK_EXTRA_RIGHT"'),
						'name' => 'product_right_block',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'select',
						'label' => $this->l('Product image thumbs'),
						'name' => 'thumbs_position',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Vertical scroll(on the left of main image)')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Horizontal scroll(below main image)')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'select',
						'label' => $this->l('Accesories position'),
						'name' => 'accesories_position',
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Right block(right block have to be enabled)')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Below products description')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Show tabs'),
						'desc' => $this->l('You can decide to show product description, features etc as tabs or not'),
						'name' => 'product_tabs',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'select',
						'label' => $this->l('Product page image container width(grid)'),
						'name' => 'product_left_size',
						'desc' => '<strong>'.$this->l('Value from this field + value from field below must be equal to 12').'</strong>',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 7,
								'name' => '7'
								),
								array(
								'id_option' => 6,
								'name' => '6'
								),
								array(
								'id_option' => 5,
								'name' => '5'
								),
							array(
								'id_option' => 4,
								'name' => '4'
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'select',
						'label' => $this->l('Product page info container width(grid)'),
						'name' => 'product_center_size',
						'desc' => '<strong>'.$this->l('Value from this field + value from field above must be equal to 12').'</strong> '.$this->l('Additionl right column enabled will automaticly decrease this value by 3'),
						'separator' => true,
						'options' => array(
							'query' => array(
								array(
								'id_option' => 8,
								'name' => '8'
								),
								array(
								'id_option' => 7,
								'name' => '7'
								),
							array(
								'id_option' => 6,
								'name' => '6'
								),
							array(
								'id_option' => 5,
								'name' => '5'
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Labels letter uppercase'),
						'row_title' => $this->l('Labels, prices, ratings'),
						'name' => 'label_uppercase',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),	
					array(
						'type' => 'color',
						'label' => $this->l('New product label background'),
						'name' => 'label_new_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('New product label text color'),
						'name' => 'label_new_txt',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Sale product label background'),
						'name' => 'label_sale_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Sale product label text color'),
						'name' => 'label_sale_txt',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Online product label background'),
						'name' => 'label_online_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Online product label text color'),
						'name' => 'label_online_txt',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('In stock product label background'),
						'name' => 'label_stock_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('In stock product label text color'),
						'name' => 'label_stock_txt',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Out of stock product label background'),
						'name' => 'label_ostock_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Out of stock product label text color'),
						'name' => 'label_ostock_txt',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Product price color'),
						'name' => 'price_color',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Product rating stars color'),
						'name' => 'stars_color',
						'desc' => $this->l('Apply only to productcomments module, not Yotpo module'),
						'size' => 30,
					),
					)
				),
			);

			$fields_form_fonts = array(
			'form' => array(
				'tab_name' => 'fonts_tab',
				'legend' => array(
					'title' => $this->l('Fonts and Typo'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Page heading font size'),
						'name' => 'heading_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Page Subheading font size'),
						'name' => 'subheading_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Block title font size'),
						'name' => 'boxtitle_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Footer block title font size'),
						'name' => 'fboxtitle_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Breadcrumb font size'),
						'name' => 'breadcrumb_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Product lists product name size'),
						'name' => 'pname_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Product price size on product lists'),
						'name' => 'price_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Product labels size(sale, new, etc)'),
						'name' => 'labels_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Buttons font size'),
						'name' => 'buttons_font_s',
						'suffix'=> 'px',
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Default font size'),
						'name' => 'default_font_s',
						'suffix'=> 'px',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('Font-face custom font include'),
						'desc' => $this->l(''),
						'class' => 'customfontinclude',
						'desc_infof' => true,
						'name' => 'custom_font_include',
						),
					array(
						'type' => 'select',
						'label' => $this->l('Headings font type'),
						'name' => 'font_headings_type',
						'desc' => $this->l('You can choose beteween google fonts and system fonts'),
						'row_title' => $this->l('Headings fonts'),
						'options' => array(
							'query' => array(
							array(
								'id_option' => 3,
								'name' => $this->l('Custom font')
								),
							array(
								'id_option' => 1,
								'name' => $this->l('Google fonts')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('System font')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'text',
						'label' => $this->l('Google font url'),
						'desc' => $this->l('Example: http://fonts.googleapis.com/css?family=Open+Sans:400,700 ').'Add 400 and 700 font weigh if exist. If you need adds latin-ext or cyrilic too. <a href="https://www.google.com/fonts" target="_blank">'.$this->l('Check google font database').'</a>',
						'name' => 'font_headings_link',
						'preffix_wrapper' => 'heading_google_wrapper',
						'wrapper_hidden' => true,
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Google font family'),
						'name' => 'font_headings_name',
						'desc' => $this->l('Example: \'Open Sans\', sans-serif '),
						'suffix_wrapper' => true,
						'size' => 30,
					),
					array(
						'type' => 'select',
						'label' => $this->l('System font'),
						'name' => 'font_headings_default',
						'preffix_wrapper' => 'heading_default_wrapper',
						'suffix_wrapper' => true,
						'wrapper_hidden' => true,
						'options' => array(
							'query' => $this->systemFonts,                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
					array(
						'type' => 'text',
						'label' => $this->l('Custom font'),
						'name' => 'font_headings_namec',
						'preffix_wrapper' => 'heading_custom_wrapper',
						'desc' => $this->l('Example: \'Open Sans\', sans-serif '),
						'suffix_wrapper' => true,
						'wrapper_hidden' => true,
						'size' => 30,
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Headings uppercase letters'),
						'name' => 'headings_uppercase',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Headings bold font'),
						'name' => 'headings_bold',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Headings italics font'),
						'name' => 'headings_italics',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Center main headings'),
						'name' => 'headings_center',
						'is_bool' => true,
						'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'select',
						'label' => $this->l('Normal text font type'),
						'name' => 'font_txt_type',
						'row_title' => $this->l('Normal text fonts'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('Same as header')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('Custom font')
								),
							array(
								'id_option' => 1,
								'name' => $this->l('Google fonts')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('System font')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'text',
						'label' => $this->l('Google font url'),
						'desc' => $this->l('Example: http://fonts.googleapis.com/css?family=Open+Sans:400,700 ').'Add 400 and 700 font weigh if exist.  If you need adds latin-ext or cyrilic too. <a href="https://www.google.com/fonts" target="_blank">'.$this->l('Check google font database').'</a>',
						'name' => 'font_txt_link',
						'preffix_wrapper' => 'txt_google_wrapper',
						'wrapper_hidden' => true,
						'size' => 30,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Google font family'),
						'name' => 'font_txt_name',
						'desc' => $this->l('Example: \'Open Sans\', sans-serif '),
						'separator' => true,
						'suffix_wrapper' => true,
						'size' => 30,
					),
						array(
						'type' => 'text',
						'label' => $this->l('Custom font'),
						'name' => 'font_txt_namec',
						'preffix_wrapper' => 'txt_custom_wrapper',
						'desc' => $this->l('Example: \'Open Sans\', sans-serif '),
						'suffix_wrapper' => true,
						'wrapper_hidden' => true,
						'size' => 30,
						),
					array(
						'type' => 'select',
						'label' => $this->l('System font'),
						'name' => 'font_txt_default',
						'separator' => true,
						'preffix_wrapper' => 'txt_default_wrapper',
						'suffix_wrapper' => true,
						'wrapper_hidden' => true,
						'options' => array(
							'query' => $this->systemFonts,                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
										)
				),
			);
			
			$fields_form_buttons = array(
			'form' => array(
				'tab_name' => 'buttons_tab',
				'legend' => array(
					'title' => $this->l('Buttons'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('Rounded corners'),
						'name' => 'btn_rounded',
						'desc' => $this->l('Rounded corners of all buttons'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Buttons uppercase letters'),
						'name' => 'btn_uppercase',
						'is_bool' => true,
						'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Default button border'),
						'name' => 'btn_small_border',
					),
					array(
						'type' => 'color',
						'label' => $this->l('Default button background'),
						'name' => 'btn_small_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Default button text color'),
						'name' => 'btn_small_txt',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Default button hover background'),
						'name' => 'btn_small_bg_h',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Default button hover text color'),
						'name' => 'btn_small_txt_h',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Action/confirm button border'),
						'name' => 'btn_medium_border',
					),
					array(
						'type' => 'color',
						'label' => $this->l('Action/confirm button background'),
						'name' => 'btn_medium_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Action/confirm button text color'),
						'name' => 'btn_medium_txt',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Action/confirm button hover background'),
						'name' => 'btn_medium_bg_h',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Action/confirm button hover text color'),
						'name' => 'btn_medium_txt_h',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Add to cart button border'),
						'name' => 'btn_cart_border',
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart button background'),
						'name' => 'btn_cart_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart button text color'),
						'name' => 'btn_cart_txt',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart button hover background'),
						'name' => 'btn_cart_bg_h',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart button text hover'),
						'name' => 'btn_cart_txt_h',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Add to cart product page button border'),
						'name' => 'btn_cartp_border',
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart product page button background'),
						'name' => 'btn_cartp_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart product page button text color'),
						'name' => 'btn_cartp_txt',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart product page button hover background'),
						'name' => 'btn_cartp_bg_h',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Add to cart product page button text hover'),
						'name' => 'btn_cartp_txt_h',
					
						'size' => 30,
					),
					)
				),
			);
			
			$globalFields = $this->globalFormFields('top');

			$fields_form_topbar = array(
			'form' => array(
				'tab_name' => 'topbar_tab',
				'legend' => array(
					'title' => $this->l('Top bar'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'color',
						'label' => $this->l('Top banner background color'),
						'name' => 'top_banner_color',
						'size' => 30,
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Enable top bar(top navigation)'),
						'name' => 'top_bar',
						'desc' => $this->l('Place where languages, compare and wishlist is showed'),
						'is_bool' => true,
						'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'select',
						'label' => $this->l('Top nav width'),
						'name' => 'top_width',
						'desc' => $this->l('Choose width of top menu links bar'),
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Full width')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Content width')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
						array(
							'type' => 'border_generator',
							'label' => $this->l('Border top'),
							'name' => 'top_bordert_color',
						),
						array(
							'type' => 'border_generator',
							'label' => $this->l('Border bottom'),
							'name' => 'top_border_color',
						),
						$globalFields['bg_color'],
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],

						$globalFields['txt_color'],
						$globalFields['link_color'],
						$globalFields['link_h_color'],
						
						array(
						'type' => 'color',
						'label' => $this->l('Dropdown background color'),
						'name' => 'top_ddown_bg',
						'desc' => $this->l('Languages and curriences'),
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Dropdown text color'),
						'name' => 'top_ddown_color',
						'desc' => $this->l('Languages and curriences'),
						'size' => 30,
					),
					)
				),
			);
				
			

			$globalFields = $this->globalFormFields('h_wrap');

			$fields_form_headerw = array(
			'form' => array(
				'tab_name' => 'headerw_tab',
				'legend' => array(
					'title' => $this->l('Header wrapper'),
					'icon' => 'icon-edit'
					),

				'input' => array(
						$globalFields['bg_color'],
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],
						array(
						'type' => 'border_generator',
						'label' => $this->l('Border'),
						'name' => 'headerw_border_color',
					),
					)
				),
			);

			$globalFields = $this->globalFormFields('header');

			$fields_form_header = array(
			'form' => array(
				'tab_name' => 'header_tab',
				'legend' => array(
					'title' => $this->l('Header'),
					'icon' => 'icon-edit'
					),
				

				'input' => array(
					array(
						'type' => 'select',
						'label' => $this->l('Mobile header style'),
						'name' => 'mobile_header_style',
						'row_title' => $this->l('Mobile header'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 1,
								'name' => $this->l('Style 1')
								),
								array(
								'id_option' => 2,
								'name' => $this->l('Style 2')
								),
								array(
								'id_option' => 3,
								'name' => $this->l('Style 3')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Sticky mobile header'),
						'name' => 'mobile_header_sticky',
						'desc' => $this->l('Header on mobile devices will be sticky to top when scroll down'),
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Expanded search on mobile'),
						'name' => 'mobile_header_search',
						'desc' => $this->l('If enable search input will be visible directly, without click on search icon'),
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'color',
						'label' => $this->l('Mobile header bg'),
						'name' => 'mh_bg',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Mobile logo background(only in style 3)'),
						'name' => 'mh_logo_bg',
						'size' => 30,
						),
						array(
						'type' => 'border_generator',
						'label' => $this->l('Mobile border bottom and button border(only in style 3)'),
						'name' => 'mh_btn_border',
						),
						array(
						'type' => 'color',
						'label' => $this->l('Mobile icon color'),
						'name' => 'mh_icon_color',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Mobile active/hover icon'),
						'name' => 'mh_icon_a_color',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Mobile active/hover btn backgrund(only in style 3)'),
						'name' => 'mh_btn_a_bg',
						'size' => 30,
						),
							array(
						'type' => 'color',
						'label' => $this->l('Mobile search and user dropdown bg color'),
						'name' => 'mh_dd_bg',
						'size' => 30,
						),
								array(
						'type' => 'color',
						'label' => $this->l('Mobile search and user dropdown text color'),
						'name' => 'mh_dd_txt',
						'size' => 30,
						),
							array(
						'type' => 'color',
						'label' => $this->l('Mobile search input bg'),
						'name' => 'mh_dd_input_bg',
						'size' => 30,
						),
							array(
						'type' => 'color',
						'label' => $this->l('Mobile search input text'),
						'name' => 'mh_dd_input_txt',
						'size' => 30,
						),
						array(
						'type' => 'border_generator',
						'label' => $this->l('Mobile search input border'),
						'name' => 'mh_dd_input_border',
						'separator' => true,
						),
						array(
						'type' => 'select',
						'label' => $this->l('Header style'),
						'name' => 'header_style',
						'row_title' => $this->l('Desktop header'),
						'desc' => $this->l('If set as sidebar, then header is moved to left side of browser. In iqitmegamenu you have to set vertical menu status as sidebar and use it instead of horizontal'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 3,
								'name' => $this->l('Inline(menu on right)')
								),
								array(
								'id_option' => 2,
								'name' => $this->l('Inline(menu next to logo)')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('As sidebar')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Default')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'select',
						'label' => $this->l('Icons style'),
						'name' => 'cart_style',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('Just icons - variant-3')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('Icons with label below - variant-2')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Default(variant-1)')
								)
							),                           
    						'id' => 'id_option',  
    						'desc' => $this->l('Search you can define in blocksearch_mod module configuration. '),                         
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'text',
						'label' => $this->l('Icon size'),
						'desc' => $this->l('Size of blockcart, search and user(it is not affecting on variant 1)'),     
						'name' => 'icon_size',
						),
						array(
						'type' => 'select',
						'label' => $this->l('Header width'),
						'name' => 'header_width',
						'desc' => $this->l('Header container width(except sidebar header)'),
						'separator' => true,
						'options' => array(
							'query' => array(
								array(
								'id_option' => 1,
								'name' => $this->l('Full width')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Default - Inherit width from global container')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Additional 20 px bottom padding'),
						'name' => 'header_padding',
						'desc' => $this->l('Beteween menu and header container. This option is helpfull with background image'),
						'is_bool' => true,
						'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
						array(
						'type' => 'switch',
						'row_title' => $this->l('Absolute header on index page'),
						'label' => $this->l('Enable slider under header'),
						'name' => 'header_absolute',
						'desc' => $this->l('!IMPORTANT: Enable this option only if you use some slider module in full width mode, for good effect slider height should be at lest 600px height. Background of header should be transparent or semi-transparent( rgba(0, 0, 0, 0.3) )'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
							array(
						'type' => 'color',
						'label' => $this->l('Header wrapper background color'),
						'name' => 'header_absolute_w_bg',
						'desc' => $this->l('Background color if absolute header is enabled. Transparent color generator http://www.css3maker.com/css-3-rgba.html'),
						'size' => 30,
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Additional 20 px bottom padding(only in absolute header)'),
						'name' => 'absolute_header_padding',
						'desc' => $this->l('Beteween menu and header container. This option is helpfull with background image'),
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
							array(
						'type' => 'color',
						'label' => $this->l('Header background color'),
						'name' => 'header_absolute_bg',
						'desc' => $this->l('Background color if absolute header is enabled. Transparent color generator http://www.css3maker.com/css-3-rgba.html'),
						'size' => 30,
						'separator' => true,
						),

						array(
						'type' => 'text',
						'label' => $this->l('Header height increase'),
						'name' => 'header_increase',
						'suffix' => 'px',
						'desc' => $this->l('I more than 0, increase header with filled pixels. It will also increse place for logo. You can also decrease header size by minus value'),
						'size' => 20,   
						),
						array(
						'type' => 'select',
						'label' => $this->l('Logo container width'),
						'name' => 'logo_width',
						'desc' => $this->l('I you want use bigger logo change this value'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 0,
								'name' => $this->l('Grid size - 4(normal)')
								),
								array(
								'id_option' => 2,
								'name' => $this->l('Grid size - 6(large)')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'select',
						'label' => $this->l('Logo position'),
						'name' => 'logo_position',
						'desc' => $this->l('Works only with default header style'),
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Left')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Center')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
						$globalFields['bg_color'],
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],
						array(
							'type' => 'border_generator',
							'label' => $this->l('Inner border'),
							'desc' => $this->l('For example border of search input'),
							'name' => 'header_inner_border_color',
						),
						$globalFields['input_text'],
						$globalFields['input_bg'],
						$globalFields['txt_color'],
						$globalFields['link_color'],
						$globalFields['link_h_color'],
						array(
						'type' => 'select',
						'label' => $this->l('Cart icon'),
						'name' => 'cart_icon',
						'upper_separator' => true,
						'row_title' => $this->l('Cart'),
						'desc' => $this->l('Icon style'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('Bag icon')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('Cart icon')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('No icon(not allowed in variant-2)')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'color',
						'label' => $this->l('Cart title bg(or qty cirtcle bg in variant-2)'),
						'name' => 'cart_bg',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Cart title text(or icon color in variant-2)'),
						'name' => 'cart_txt',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Cart info bg(or qty cirtcle txt in variant-2)'),
						'name' => 'cart2_bg',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Cart info text'),
						'name' => 'cart2_txt',
						'size' => 30,
						'separator' => true,
						),
						array(
						'type' => 'color',
						'row_title' => $this->l('Cart block(box)'),
						'label' => $this->l('Cart box background color'),
						'desc' => $this->l('Cart box is shown when you hover on cart'),
						'name' => 'cart_box_bg',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Cart box text color'),
						'desc' => $this->l('Cart box is shown when you hover on cart'),
						'name' => 'cart_box_txt',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Cart box hover text'),
						'desc' => $this->l('Cart box is shown when you hover on cart'),
						'name' => 'cart_box_txt_h',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Cart box button container background'),
						'desc' => $this->l('Cart box is shown when you hover on cart'),
						'name' => 'cart_box2_bg',
						'size' => 30,
						),
						array(
						'type' => 'border_generator',
						'label' => $this->l('Cart box border color'),
						'desc' => $this->l('Cart box is shown when you hover on cart'),
						'name' => 'cart_box_border',
						),
					)
				),
			);
			
		$globalFields = $this->globalFormFields('c_wrap');
			
			$fields_form_contentw = array(
			'form' => array(
				'tab_name' => 'contentw_tab',
				'legend' => array(
					'title' => $this->l('Content wrapper'),
					'icon' => 'icon-edit'
					),

				'input' => array(
						$globalFields['bg_color'],
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],
					)
				),
			);

			$globalFields = $this->globalFormFields('content');

			$fields_form_content = array(
			'form' => array(
				'tab_name' => 'content_tab',
				'legend' => array(
					'title' => $this->l('Content'),
					'icon' => 'icon-edit'
					),

				'input' => array(
						$globalFields['bg_color'],
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],
						$globalFields['inner_border_color'],
						$globalFields['txt_color'],
						$globalFields['link_color'],
						$globalFields['link_h_color'],
						$globalFields['input_text'],
						$globalFields['input_bg'],
						array(
							'type' => 'border_generator',
							'label' => $this->l('Input border'),
							'name' => 'content_input_border',
						),
						/**
						array(
						'type' => 'select',
						'label' => $this->l('Select box and radio buttons color'),
						'name' => 'content_input_select',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 1,
								'name' => $this->l('White')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Black')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
						**/
						array(
						'type' => 'select',
						'label' => $this->l('Tabs style'),
						'separator' => true,
						'name' => 'content_tab_style',
						'desc' => $this->l('Headings color'),
						'options' => array(
							'query' => array(
								array(
								'id_option' => 1,
								'name' => $this->l('Without border')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('With border')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
						
						array(
						'type' => 'color',
						'label' => $this->l('Headings color'),
						'name' => 'content_headings_color',
						'size' => 30,
					),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Headings and block title bottom border'),
						'name' => 'content_headings_border',
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Headings and block title background status'),
						'name' => 'content_bgh_status',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'color',
						'label' => $this->l('Headings and block title background color'),
						'name' => 'content_bgh',
						'separator' => true,
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Columns block background'),
						'name' => 'content_block_bg',
						'size' => 30,
						'desc' => $this->l('Background color of blocks in sidebar'),
					),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Columns block border color'),
						'separator' => true,
						'name' => 'content_block_border_c',
						'desc' => $this->l('Border of entire block. For example if enabled all blocks in left column hook will have a border'),
					),				
					array(
						'type' => 'color',
						'label' => $this->l('Text elements background'),
						'name' => 'content_element_bg',
						'size' => 30,
						'desc' => $this->l('Background color of blocks like tabs, category description, product buy area'),						
					),
					array(
						'type' => 'border_generator',
						'label' => $this->l('Text elements background'),
						'separator' => true,
						'name' => 'content_element_border_c',
						'desc' => $this->l('Border of blocks like product buy area'),
					),

					array(
						'type' => 'color',
						'label' => $this->l('Table heading background'),
						'name' => 'table_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Table heading text color'),
						'name' => 'table_color',
						'size' => 30,
						'separator' => true,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Box background'),
						'desc' => $this->l('For example background of form or table footer'),
						'name' => 'content_box_bg',
						'size' => 30,
					),
					array(
						'type' => 'color',
						'label' => $this->l('Box background text color'),
						'name' => 'content_box_color',
						'size' => 30,
						'separator' => true,
					),
						array(
						'type' => 'color',
						'label' => $this->l('Dropdown background color'),
						'name' => 'ddown_bg',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Dropdown text color'),
						'name' => 'ddown_color',
						'size' => 30,
						'separator' => true,
					),
						array(
						'type' => 'color',
						'label' => $this->l('Background color'),
						'name' => 'alertsuccess_bg',
						'row_title' => $this->l('Alert succces'),
						'size' => 30,
					),
						array(
						'type' => 'color',
						'label' => $this->l('Text color'),
						'name' => 'alertsuccess_txt',
						'size' => 30,
						'separator' => true,
					),
						array(
						'type' => 'color',
						'label' => $this->l('Background color'),
						'name' => 'alertinfo_bg',
						'row_title' => $this->l('Alert info'),
						'size' => 30,
					),
						array(
						'type' => 'color',
						'label' => $this->l('Text color'),
						'name' => 'alertinfo_txt',
						'size' => 30,
						'separator' => true,
					),

						array(
						'type' => 'color',
						'label' => $this->l('Background color'),
						'name' => 'alertwarning_bg',
						'row_title' => $this->l('Alert warning'),
						'size' => 30,
					),
						array(
						'type' => 'color',
						'label' => $this->l('Text color'),
						'name' => 'alertwarning_txt',
						'size' => 30,
						'separator' => true,
					),

						array(
						'type' => 'color',
						'label' => $this->l('Background color'),
						'name' => 'alertdanger_bg',
						'row_title' => $this->l('Alert danger'),
						'size' => 30,
					),
						array(
						'type' => 'color',
						'label' => $this->l('Text color'),
						'name' => 'alertdanger_txt',
						'size' => 30,
						'separator' => true,
					),

					)
				),
			);

			$file = dirname(__FILE__).'/img/footer_logo_'.(int)$this->context->shop->id.'.jpg';
			$footerlogo = (file_exists($file) ? '<img src="'.$this->_path.'img/footer_logo_'.(int)$this->context->shop->id.'.jpg">' : '');


			$globalFields = $this->globalFormFields('f_wrap');
			
			$fields_form_footerw = array(
			'form' => array(
				'tab_name' => 'footerw_tab',
				'legend' => array(
					'title' => $this->l('Footer wrapper'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('Additional top and bottom 20px padding'),
						'name' => 'f_wrap_padding',
						'is_bool' => true,
						'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Circle')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Square')
								)
							),
						),
						array(
						'type' => 'select',
						'label' => $this->l('Footer wrapper width'),
						'name' => 'f_wrap_width',
						'desc' => $this->l('Choose width of footer'),
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Full width')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Content width')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),

						$globalFields['bg_color'],
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],
					)
				),
			);

			$globalFields = $this->globalFormFields('footer');
			$globalFields1 = $this->globalFormFields('footer1');

			$fields_form_footer = array(
			'form' => array(
				'tab_name' => 'footer_tab',
				'legend' => array(
					'title' => $this->l('Footer'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'select',
						'label' => $this->l('Footer width'),
						'name' => 'footer_width',
						'desc' => $this->l('Choose width of both footers'),
						'options' => array(
							'query' => array(array(
								'id_option' => 1,
								'name' => $this->l('Full width')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Content width')
								)
							),                           
    						'id' => 'id_option',                           
    						'name' => 'name'
    						)
						),
						array(
						'type' => 'switch',
						'label' => $this->l('Footer links ul arrrows'),
						'name' => 'footer_ul_arrows',
						'separator' => true,
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('On')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Off')
								)
							),
						),

						array(
						'type' => 'switch',
						'row_title' => $this->l('First(additional) footer'),
						'label' => $this->l('Enable additional footer'),
						'desc' => $this->l('If enabled there is additonal row with modules'),
						'name' => 'footer1_status',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Circle')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Square')
								)
							),
						),
						$globalFields1['bg_color'],
						$globalFields1['bg_type'],
						$globalFields1['bg_image'],
						$globalFields1['bg_repeat'],
						$globalFields1['bg_position'],
						$globalFields1['bg_pattern'],
						array(
							'type' => 'border_generator',
							'label' => $this->l('Border top'),
							'name' => 'footer1_border_color',
						),
						array(
							'type' => 'border_generator',
							'label' => $this->l('Inner border'),
							'name' => 'footer1_inner_border_color',
						),
						array(
							'type' => 'border_generator',
							'label' => $this->l('Footer block title color border'),
							'name' => 'footer1_border_title',
						),
							array(
						'type' => 'color',
						'label' => $this->l('Footer block title color'),
						'size' => 30,
						'name' => 'footer1_headings_color',
						),
							array(
						'type' => 'color',
						'label' => $this->l('Footer block title background color'),
						'name' => 'footer1_bgh',
						'separator' => true,
						'size' => 30,
					),
						$globalFields1['txt_color'],
						$globalFields1['link_color'],
						$globalFields1['link_h_color'],

						array(
						'type' => 'color',
						'row_title' => $this->l('Main footer'),
						'upper_separator' => true,
						'label' => $this->l('Background color'),
						'size' => 30,
						'name' => 'footer_bg_color',
						),
						$globalFields['bg_type'],
						$globalFields['bg_image'],
						$globalFields['bg_repeat'],
						$globalFields['bg_position'],
						$globalFields['bg_pattern'],
						array(
							'type' => 'border_generator',
							'label' => $this->l('Border top'),
							'name' => 'footer_bordert_color',
						),
						array(
							'type' => 'border_generator',
							'label' => $this->l('Border bottom'),
							'name' => 'footer_border_color',
						),
						array(
							'type' => 'border_generator',
							'label' => $this->l('Inner border'),
							'name' => 'footer_inner_border_color',
						),
						$globalFields['txt_color'],
						$globalFields['link_color'],
						$globalFields['link_h_color'],
						$globalFields['input_text'],
						$globalFields['input_bg'],

						array(
							'type' => 'border_generator',
							'label' => $this->l('Footer block title color border'),
							'row_title' => $this->l('Footer block titles'),
						'upper_separator' => true,
							'name' => 'footer_border_title',
						),
						array(
						'type' => 'color',
						'label' => $this->l('Footer block title color'),
						'size' => 30,
						'name' => 'footer_headings_color',
						),

						
						array(
						'type' => 'switch',
						'label' => $this->l('Footer block title background status'),
						'name' => 'footer_bgh_status',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'color',
						'label' => $this->l('Footer block title background color'),
						'name' => 'footer_bgh',
						'separator' => true,
						'size' => 30,
					),
						array(
						'type' => 'switch',
						'row_title' => $this->l('Social icons'),
						'label' => $this->l('Circle or squre social icons'),
						'desc' => $this->l('If enabled circle icons, if disabled square icons'),
						'name' => 'footer_social_round',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Circle')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Square')
								)
							),
						),
						array(
						'type' => 'color',
						'label' => $this->l('Footer social icon text color'),
						'name' => 'footer_social_color',
						'size' => 30,
						),
						array(
						'type' => 'color',
						'label' => $this->l('Footer social icon background color'),
						'name' => 'footer_social_bg',
						'separator' => true,
						'size' => 30,
						),
					array(
						'type' => 'switch',
						'label' => $this->l('Show copyrights and payments logos'),
						'name' => 'second_footer',
						'is_bool' => true,
						'separator' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
					array(
						'type' => 'textarea',
						'label' => $this->l('Copyright text'),
						'name' => 'copyright_text',
						'autoload_rte' => true,
						'lang' => true,
						'cols' => 60,
						'rows' => 30
						),
					array(
					'type' => 'file',
					'label' => $this->l('Footer image'),
					'name' => 'footer_img_src',
					'display_image' => true,
					'image' => $footerlogo,
					'delete_url' => 'index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteFooterImage=1'
				),
						array(
						'type' => 'color',
						'row_title' => $this->l('Back to top button'),
						'upper_separator' => true,
						'label' => $this->l('Background color'),
						'size' => 30,
						'name' => 'bg_totop',
						),
						array(
						'type' => 'color',
						'label' => $this->l('Icon color'),
						'size' => 30,
						'name' => 'icon_totop',
						),
						array(
						'type' => 'color',
						'label' => $this->l('Hover background color'),
						'size' => 30,
						'name' => 'bgh_totop',
						),
						array(
						'type' => 'color',
						'label' => $this->l('Hover Icon color'),
						'size' => 30,
						'name' => 'iconh_totop',
						),


					)
				),
			);

			

			$fields_form_custom = array(
			'form' => array(
				'tab_name' => 'custom_tab',
				'legend' => array(
					'title' => $this->l('Custom CSS and JS code'),
					'icon' => 'icon-edit'
					),

				'input' => array(
					array(
						'type' => 'textarea',
						'label' => $this->l('Custom CSS code'),
						'id' =>'codeEditor',
						'name' => 'custom_css',
						),
					array(
						'type' => 'textarea',
						'label' => $this->l('Custom JS code'),
						'name' => 'custom_js',
						'cols' => 60,
						'rows' => 15,
						),
					)
				),
			);




			$fields_form_save = array(
			'form' => array(
				'tab_name' => 'save_tab',
				'legend' => array(
					'title' => $this->l('Save configuration'),
					'icon' => 'icon-save'
					),
				'submit' => array(
					'name' => 'save_editor',
					'class' => 'btn btn-default pull-right',
					'title' => $this->l('Save')
					),
				'buttons' => array(
				'button' => array(
					'name' => 'reset_editor',
					'type' => 'submit',
					'icon' => 'process-icon-refresh',
					'class' => 'btn btn-default pull-left',
					'title' => $this->l('Reset to default')
					),)
				),
			);
		
		if (Shop::isFeatureActive())
			$fields_form['form']['description'] = $this->l('The modifications will be applied to').' '.(Shop::getContext() == Shop::CONTEXT_SHOP ? $this->l('shop').' '.$this->context->shop->name : $this->l('all shops'));
		

		$helper = new HelperForm();
		$helper->show_toolbar = true;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;		
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
			);

		
		return $helper->generateForm(array($fields_form_main, $fields_form_global_design, $fields_form_productslist, $fields_form_products, $fields_form_fonts, $fields_form_buttons, $fields_form_topbar, $fields_form_headerw, $fields_form_header, $fields_form_contentw, $fields_form_content, $fields_form_footerw, $fields_form_footer, $fields_form_custom,  $fields_form_save));
	}

	public function getConfigFieldsValues()
	{

		$var =  array();

		foreach ($this->defaults as $default => $value) {

		if($default == 'copyright_text')
		{
			foreach (Language::getLanguages(false) as $lang)
			$var[$default][(int)$lang['id_lang']] =  Configuration::get($this->configName.'_'.$default, (int)$lang['id_lang']);
		}
		elseif(array_key_exists($default, $this->defaultsBorders))
		{
			$tmpborder =  explode(';', Configuration::get($this->configName.'_'.$default));
				
				$var[$default]['width'] = $tmpborder[0];
				$var[$default]['type'] = $tmpborder[1];
				$var[$default]['color'] = $tmpborder[2];
		}
		else
		$var[$default] = Configuration::get($this->configName.'_'.$default);
		}
			

		$var['PS_QUICK_VIEW'] = (int)Tools::getValue('PS_QUICK_VIEW', Configuration::get('PS_QUICK_VIEW'));

		return $var;

	}


	public function globalFormFields($section)
	{

		$var =  array(
			'bg_color' => array(
						'type' => 'color',
						'label' => $this->l('Background color'),
						'name' => $section.'_bg_color',
						'size' => 30,
					),
			'bg_type' => array(
						'type' => 'select',
						'label' => $this->l('Background image type'),
						'name' => $section.'_bg_type',
						'options' => array(
							'query' => array(
								array(
								'id_option' => 2,
								'name' => $this->l('No image')
								),
								array(
								'id_option' => 1,
								'name' => $this->l('Custom image')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Patterns')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
						),
			'bg_image' => array(
						'type' => 'background_image',
						'label' => $this->l('Custom background image'),
						'name' => $section.'_bg_image',
						'selector' => $section,
						'preffix_wrapper' => $section.'_bg_image_wrapper',
						'wrapper_hidden' => true,
						'size' => 30,
					),
			'bg_repeat' =>  array(
						'type' => 'select',
						'label' => $this->l('Background repeat'),
						'name' => $section.'_bg_repeat',
						'options' => array(
							'query' => array(array(
								'id_option' => 3,
								'name' => $this->l('Repeat XY')
								),
							array(
								'id_option' => 2,
								'name' => $this->l('Repeat X')
								),
							array(
								'id_option' => 1,
								'name' => $this->l('Repeat Y')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('No repeat')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
					),
			'bg_position' =>  array(
						'type' => 'select',
						'label' => $this->l('Background position'),
						'name' => $section.'_bg_position',
						'suffix_wrapper' => true,
							'separator' => true,
						'options' => array(
							'query' => array(
							array(
								'id_option' => 2,
								'name' => $this->l('Left')
								),
							array(
								'id_option' => 1,
								'name' => $this->l('Center')
								),
							array(
								'id_option' => 0,
								'name' => $this->l('Right')
								)
							),                           
    						'id' => 'id_option',                          
    						'name' => 'name'
    						)
					),
			'bg_pattern' => array(
						'type' => 'background_pattern',
						'label' => $this->l('Background pattern'),
						'name' => $section.'_bg_pattern',
						'preffix_wrapper' => $section.'_bg_pattern_wrapper',
						'wrapper_hidden' => true,
						'suffix_wrapper' => true,
							'separator' => true,
						'size' => 30,
					),
			'txt_color' => array(
						'type' => 'color',
						'label' => $this->l('Text color'),
						'name' => $section.'_txt_color',
						'size' => 30,
					),
			'link_color' => array(
						'type' => 'color',
						'label' => $this->l('Link color'),
						'name' => $section.'_link_color',
						'size' => 30,
					),
			'link_h_color' => array(
						'type' => 'color',
						'label' => $this->l('Link hover color'),
						'name' => $section.'_link_h_color',
						'size' => 30,
					),
			'border' =>  array(
						'type' => 'switch',
						'label' => $this->l('Border status'),
						'name' => $section.'_border',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
			'inner_border' =>  array(
						'type' => 'switch',
						'label' => $this->l('Inner border status'),
						'name' => $section.'_inner_border',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
								),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
								)
							),
						),
			'border_color' => array(
						'type' => 'color',
						'label' => $this->l('Border color'),
						'name' => $section.'_border_color',
						'size' => 30,
					),
			'inner_border_color' => array(
						'type' => 'color',
						'label' => $this->l('Inner border color'),
						'name' => $section.'_inner_border_color',
						'size' => 30,
					),
			'input_text' => array(
						'type' => 'color',
						'label' => $this->l('Input text'),
						'name' => $section.'_input_text',
						'size' => 30,
					),
			'input_bg' => array(
						'type' => 'color',
						'label' => $this->l('Input background'),
						'name' => $section.'_input_bg',
						'size' => 30,
					),
		);
		return $var;

	}

	public function generateCss() {
		$css = '';

		$css .= Configuration::get($this->configName.'_custom_font_include');

		if(!(Configuration::get($this->configName.'_big_responsive')))
			$css .= '@media (min-width: 1000px) {.container{ max-width: 1010px !important; }} ';

		if((Configuration::get($this->configName.'_content_margin')))
			$css .= 'body{padding: 20px 0;}  ';

		$css .= '.breadcrumb{background: '.Configuration::get($this->configName.'_breadcrumb_bg').'!important; color: '.Configuration::get($this->configName.'_breadcrumb_color').'!important; 
		'.$this->convertBorder(Configuration::get($this->configName.'_breadcrumb_border'), 'bottom').'
		}  
		.breadcrumb a, .breadcrumb a:link {color: '.Configuration::get($this->configName.'_breadcrumb_color').'!important; }
		';
		if(Configuration::get($this->configName.'_force_boxed') == 2)
			$css .= '.container {
						max-width: 90% !important;  
					}';

		if(Configuration::get($this->configName.'_force_boxed') == 3)
			$css .= '.container {
						max-width: 100% !important;  
					}';

		if(Configuration::get($this->configName.'_force_boxed') == 1)
			$css .= '
	#page {margin: 0 auto; }

		#page { max-width: 100%; }
		@media (min-width: 480px) {  #page {max-width: 100%; }}
		@media (min-width: 768px) { #page {max-width: 90%; }}
		@media (min-width: 1000px) and (max-width: 1319px) {  #page {max-width: 1010px; }}
		@media (min-width: 1320px) { #page {max-width: 1270px; }}
		';
		if(Configuration::get($this->configName.'_force_boxed') == 1 && !Configuration::get($this->configName.'_big_responsive'))
				$css .= '@media (min-width: 1320px) { #page {max-width: 1010px; }}';

		if((Configuration::get($this->configName.'_content_shadow')))
			$css .= '#page{
				-webkit-box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
-moz-box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
			} ';

		if(!(Configuration::get($this->configName.'_top_pagination')))
			$css .= '.top-pagination-content{display: none !important;}  ';

		if(!(Configuration::get($this->configName.'_show_buttons')))
			$css .= '.slick_carousel .button-container, ul.product_list.grid .button-container{display: none !important;}  ';
		if(!(Configuration::get($this->configName.'_show_qty_field')))
			$css .= '.pl-quantity-input-wrapper{display: none !important;}  ';

		if(!(Configuration::get($this->configName.'_show_catimage')))
			$css .= '.content_scene_cat{display: none !important;}  ';
		
		

	      $productborder = Configuration::get($this->configName.'_product_border_color');
	      $productborderexplode = explode(';', $productborder);

	      $producthborder = Configuration::get($this->configName.'_product_h_border_color');
	      $producthborderexplode = explode(';', $producthborder);

	    //products box normal
		if(Configuration::get($this->configName.'_product_box_status'))
			$css .= '
			.ajax_block_product:hover, .ajax_block_product .product-container{background-color: '.Configuration::get($this->configName.'_product_box_bg').'; }
			.ajax_block_product .ajax_block_product:hover a, .ajax_block_product:hover a:link 
			{color: '.Configuration::get($this->configName.'_product_box_txt').' }

			.ajax_block_product a.product-name, .ajax_block_product:hover a.product-name:link
			{color: '.Configuration::get($this->configName.'_product_box_txt').' !important; }
			
			.ajax_block_product a.product-name:hover
			{color: '.Configuration::get($this->configName.'_product_box_txt_h').' !important; }

			.ajax_block_product .price.product-price {color: '.Configuration::get($this->configName.'_product_box_price').'!important; }
			.ajax_block_product div.star:after {color: '.Configuration::get($this->configName.'_product_box_rating').'!important; }
			.product_list.list .ajax_block_product{    margin-bottom: 10px;}
			.product_list.list .ajax_block_product .product-container{    padding: 20px 10px;}
			';
			  
		//products box hover
		if(Configuration::get($this->configName.'_product_box_h_status'))
			$css .= '
			.ajax_block_product:hover, .ajax_block_product:hover .product-container{background-color: '.Configuration::get($this->configName.'_product_box_h_bg').'; }
			.ajax_block_product:hover, .ajax_block_product:hover a, .ajax_block_product:hover a:link 
			{color: '.Configuration::get($this->configName.'_product_box_h_txt').' }

			.ajax_block_product:hover a.product-name, .ajax_block_product:hover a.product-name:link
			{color: '.Configuration::get($this->configName.'_product_box_h_txt').' !important; }
			
			.ajax_block_product:hover a.product-name:hover
			{color: '.Configuration::get($this->configName.'_product_box_h_txt_h').' !important; }

			.ajax_block_product:hover .price.product-price {color: '.Configuration::get($this->configName.'_product_box_h_price').'!important; }
			.ajax_block_product:hover div.star:after {color: '.Configuration::get($this->configName.'_product_box_h_rating').'!important; }
			';


		if($producthborderexplode[1])
		
		$css .= '
	 .ajax_block_product:hover{outline: '.$producthborderexplode[0].'px '.$this->convertBorderType($producthborderexplode[1]).' '.$producthborderexplode[2].'!important;}
	ul.product_list.grid > li {margin-top: -9px; padding-top:9px;} 
 .product_list.list .ajax_block_product:hover .product-container, .product_list_small .ajax_block_product:hover .product-container {
    border-color: transparent !important; }
  .product_list.list .ajax_block_product:hover + li .product-container, .product_list_small .ajax_block_product:hover .product-container {
    border-color: transparent !important; }
		';

		if((Configuration::get($this->configName.'_show_on_hover')))
			$css .= '
			.slick_carousel .button-container, ul.product_list.grid .button-container,
			ul.product_list.grid  .comments_note,  .slick_carousel .comments_note,
			.slick_carousel .bottomLine .result_status, ul.product_list.grid .bottomLine .result_status{visibility: hidden;}  

			.slick_carousel .ajax_block_product .hovered .button-container, ul.product_list.grid .ajax_block_product .hovered .button-container,
			ul.product_list.grid .ajax_block_product .hovered .comments_note,  .slick_carousel .ajax_block_product .hovered .comments_note,
			.slick_carousel .ajax_block_product .hovered .bottomLine .result_status, ul.product_list.grid .ajax_block_product .hovered .bottomLine .result_status{visibility: visible;}   
			';
		if(!(Configuration::get($this->configName.'_functional_buttons')))
				$css .= '.slick_carousel .functional-buttons, ul.product_list.grid .functional-buttons{display: none !important;}  ';

			$css .= '.slick_carousel .functional-buttons, ul.product_list.grid .functional-buttons{ background-color: '.Configuration::get($this->configName.'_functional_buttons_bg').'; } 
			.slick_carousel .functional-buttons a, .slick_carousel .functional-buttons a:link, ul.product_list.grid .functional-buttons a, ul.product_list.grid .functional-buttons a:link { color: '.Configuration::get($this->configName.'_functional_buttons_txt').' !important; }
			.slick_carousel .functional-buttons a:hover, ul.product_list.grid .functional-buttons a:hover{ color: '.Configuration::get($this->configName.'_functional_buttons_txt_h').' !important; }
			';

		if($productborderexplode[1] || Configuration::get($this->configName.'_product_grid_border') == 3 || Configuration::get($this->configName.'_product_box_status'))
			$css .= '
			ul.product_list.grid > li, .product_list_small .ajax_block_product, .slick_carousel .ajax_block_product{
				padding: 6px;
			}
			ul.product_list.grid > li .product-container, .product_list_small .ajax_block_product .product-container, .slick_carousel .ajax_block_product .product-container {
				border: '.$productborderexplode[0].'px '.$this->convertBorderType($productborderexplode[1]).' '.$productborderexplode[2].' !important;
  				padding: 9px;
			}
			ul.product_list, .product_list_small.row{
				margin-left: -5px;
  				margin-right: -5px;
			}
			ul.product_list.grid > li:hover .product-container, .product_list_small .ajax_block_product:hover .product-container, .slick_carousel .ajax_block_product:hover .product-container{
				border-color: transparent !important;
			}

	

			';

			if(Configuration::get($this->configName.'_product_grid_border') == 3)
			$css .= '
			ul.product_list.grid > li .product-container, .product_list_small .ajax_block_product .product-container, .slick_carousel .slick-active .product-container{
			  -webkit-box-shadow: 0 0px 2px rgba(0, 0, 0, 0.12);
  			  -moz-box-shadow: 0 0px 2px rgba(0, 0, 0, 0.12);
  			  box-shadow: 0 0px 2px rgba(0, 0, 0, 0.12);
              z-index: 3;
              }
              ul.product_list.grid > li:hover .product-container, .product_list_small .ajax_block_product:hover .product-container, .slick_carousel .ajax_block_product:hover .product-container{
              -webkit-box-shadow: none;
              -moz-box-shadow: none;
              box-shadow: none;
              }
			';

		if(!Configuration::get($this->configName.'_product_grid_center'))
			$css .= '
			.slick_carousel .ajax_block_product, ul.product_list.grid > li{text-align: left;}
			.is_rtl .slick_carousel .ajax_block_product, .is_rtl ul.product_list.grid > li{text-align: right;}
			.slick_carousel .ajax_block_product .star_content, ul.product_list.grid > li .star_content{margin: 0;}
			';

		if(Configuration::get($this->configName.'_product_names') == 1)
			$css .= '.slick_carousel .product-name-container, ul.product_list.grid .product-name-container, .product_list_small .product-name-container{
				height: '.((Configuration::get($this->configName.'_pname_font_s')+4)*2).'px;}';
		elseif(Configuration::get($this->configName.'_product_names') == 2)
			$css .= '.slick_carousel .product-name-container, ul.product_list.grid .product-name-container, .product_list_small .product-name-container{
				height: '.((Configuration::get($this->configName.'_pname_font_s')+4)*3).'px;}';
		else
			$css .= '.slick_carousel .product-name-container, ul.product_list.grid .product-name-container, .product_list_small .product-name-container{
				height: '.((Configuration::get($this->configName.'_pname_font_s')+4)).'px;}';

		if(Configuration::get($this->configName.'_product_price_length'))
			$css .= 'ul.product_list.grid .content_price{ white-space: normal; height: '.((Configuration::get($this->configName.'_price_font_s')+8)*2).'px;}';
				

		if(Configuration::get($this->configName.'_product_colors')==1)
			$css .= '.ajax_block_product .hovered .color-list-container, .ajax_block_product:hover .color-list-container{display: block !important;}';
		if(Configuration::get($this->configName.'_product_colors')==2)
			$css .= '.ajax_block_product .color-list-container{display: block !important;}';

		if(Configuration::get($this->configName.'_product_reference'))
			$css .= '.slick_carousel .product-reference, ul.product_list.grid .product-reference{
				height: '.((Configuration::get($this->configName.'_default_font_s')+5)).'px; display: block;}';
		else
			$css .= '.slick_carousel .product-reference, ul.product_list.grid .product-reference{display: none !important;}';


		//carousel
			$css .= '
			.slick-prev, .slick-next{ color: '.Configuration::get($this->configName.'_car_color').' !important; }
			.slick-prev:hover, .slick-next:hover{ color: '.Configuration::get($this->configName.'_car_color_h').' !important;  }
		';
         
			$css .= '
			.slick-prev, .slick-next{ background: '.Configuration::get($this->configName.'_car_bg').' !important;  }
			.slick-prev:hover, .slick-next:hover{ background: '.Configuration::get($this->configName.'_car_bg_h').' !important;  }
		';


		if(!Configuration::get($this->configName.'_show_condition'))
			$css .= '#product_condition{ display: none; }';


		//labels
		$css .= '
		.new-label{color: '.Configuration::get($this->configName.'_label_new_txt').' !important; background: '.Configuration::get($this->configName.'_label_new_bg').' !important;} 
		.sale-label, .price-percent-reduction, #reduction_percent, #reduction_amount{color: '.Configuration::get($this->configName.'_label_sale_txt').' !important; background: '.Configuration::get($this->configName.'_label_sale_bg').' !important;}  
		.online-label{color: '.Configuration::get($this->configName.'_label_online_txt').' !important; background: '.Configuration::get($this->configName.'_label_online_bg').' !important;}   
		#availability_value, .cart_avail .label-success, .availabile_product{color: '.Configuration::get($this->configName.'_label_stock_txt').' !important; background: '.Configuration::get($this->configName.'_label_stock_bg').' !important;} 
		ul.product_list .availability span.out-of-stock, .slick_carousel .availability span.out-of-stock, #availability_statut #availability_value.warning_inline, #availability_value.label-warning, #availability_value.label-danger ,
		#last_quantities, ul.product_list .availability .available-dif, .slick_carousel .availability .available-dif
		{color: '.Configuration::get($this->configName.'_label_ostock_txt').' !important; background: '.Configuration::get($this->configName.'_label_ostock_bg').' !important;}   
		.price.product-price, .our_price_display, .special-price{color: '.Configuration::get($this->configName.'_price_color').' !important; }
		div.star:after{color: '.Configuration::get($this->configName.'_stars_color').' !important;}  

		.yotpo .yotpo-bottomline .icon-star, .yotpo .yotpo-bottomline .icon-half-star, .yotpo .yotpo-bottomline .icon-empty-star, 
.yotpo-stars .icon-star, .yotpo-stars .icon-empty-star, .yotpo-stars .yotpo-icon-star, .yotpo-stars .yotpo-icon-empty-star, .yotpo-stars .yotpo-icon-half-star,  .yotpo-stars .icon-half-star{color: '.Configuration::get($this->configName.'_stars_color').' !important;}  
		';

		if(!(Configuration::get($this->configName.'_label_uppercase')))
			$css .= '.new-label, .sale-label, .online-label, ul.product_list .availability span, .slick_carousel .availability span{text-transform: none !important;}  ';

		//buttons
		if(!(Configuration::get($this->configName.'_btn_rounded')))
			$css .= '.btn, .box-info-product .exclusive{-webkit-border-radius: 0px !important; -moz-border-radius: 0px !important; border-radius: 0px !important;}  ';

		if(!(Configuration::get($this->configName.'_btn_uppercase')))
			$css .= '.btn, .shopping_cart > a:first-child span.cart_name, .box-info-product .exclusive{text-transform: none !important;}  ';

		

		$css .='
		.button.button-small{
		'.$this->convertBorder(Configuration::get($this->configName.'_btn_small_border'), 'all', 0, '!important').'
		color: '.Configuration::get($this->configName.'_btn_small_txt').' !important; background: '.Configuration::get($this->configName.'_btn_small_bg').' !important;}
		.button.button-small:hover{color: '.Configuration::get($this->configName.'_btn_small_txt_h').'!important; background: '.Configuration::get($this->configName.'_btn_small_bg_h').'!important;}

		.button.button-medium{
		'.$this->convertBorder(Configuration::get($this->configName.'_btn_medium_border'), 'all', 0, '!important').'
		color: '.Configuration::get($this->configName.'_btn_medium_txt').' !important; background: '.Configuration::get($this->configName.'_btn_medium_bg').'!important;}
		.button.button-medium:hover{color: '.Configuration::get($this->configName.'_btn_medium_txt_h').'!important; background: '.Configuration::get($this->configName.'_btn_medium_bg_h').' !important;}

		.button.ajax_add_to_cart_button, .button.lnk_view{
		'.$this->convertBorder(Configuration::get($this->configName.'_btn_cart_border'), 'all', 0, '!important').'
		color: '.Configuration::get($this->configName.'_btn_cart_txt').' !important; background: '.Configuration::get($this->configName.'_btn_cart_bg').' !important;}
		.button.ajax_add_to_cart_button:hover, .button.lnk_view:hover{color: '.Configuration::get($this->configName.'_btn_cart_txt_h').' !important; background: '.Configuration::get($this->configName.'_btn_cart_bg_h').'!important;}
		.box-info-product .exclusive{
		'.$this->convertBorder(Configuration::get($this->configName.'_btn_cartp_border'), 'all', 0, '!important').'
		color: '.Configuration::get($this->configName.'_btn_cartp_txt').'!important; background: '.Configuration::get($this->configName.'_btn_cartp_bg').' !important;}
		.box-info-product .exclusive:hover{color: '.Configuration::get($this->configName.'_btn_cartp_txt_h').' !important; background: '.Configuration::get($this->configName.'_btn_cartp_bg_h').'!important;}
		';




		//font

		$css .= '
		.page-heading, .pb-center-column h1{font-size: '.Configuration::get($this->configName.'_heading_font_s').'px; line-height: '.(Configuration::get($this->configName.'_heading_font_s')+6).'px; } 
		.page-subheading{font-size: '.Configuration::get($this->configName.'_subheading_font_s').'px; line-height: '.Configuration::get($this->configName.'_subheading_font_s').'px;} 
		.nav-tabs > li > a, .block .title_block, .block h4, h3.page-product-heading{font-size: '.Configuration::get($this->configName.'_boxtitle_font_s').'px; line-height: '.Configuration::get($this->configName.'_boxtitle_font_s').'px;}
		.footer-container #footer1 h4, .footer-container #footer1 h4 a,
		.footer-container #footer h4, .footer-container #footer h4 a{font-size: '.Configuration::get($this->configName.'_fboxtitle_font_s').'px; line-height: '.Configuration::get($this->configName.'_fboxtitle_font_s').'px;}
		body, .form-control{font-size: '.Configuration::get($this->configName.'_default_font_s').'px; line-height: '.(Configuration::get($this->configName.'_default_font_s')+4).'px;} 
		
		#center-layered-nav .layered_filter_center .layered_subtitle_heading, #center-layered-nav .layeredSortBy{font-size: '.Configuration::get($this->configName.'_default_font_s').'px;} 
		.pb-center-column .product-title{ font-size: '.(Configuration::get($this->configName.'_default_font_s')-2).'px;}
		.product-name{ font-size: '.(Configuration::get($this->configName.'_pname_font_s')).'px; line-height:'.(Configuration::get($this->configName.'_pname_font_s')+4).'px; }
		.price.product-price{ font-size: '.(Configuration::get($this->configName.'_price_font_s')).'px;}
		.online-label, .new-label, .sale-label, ul.product_list .availability span, .slick_carousel .availability span{ font-size: '.(Configuration::get($this->configName.'_labels_font_s')).'px;}
		.breadcrumb{ font-size: '.(Configuration::get($this->configName.'_breadcrumb_font_s')).'px;}
		.btn{ font-size: '.(Configuration::get($this->configName.'_buttons_font_s')).'px;  line-height: '.(Configuration::get($this->configName.'_buttons_font_s')+3).'px;}
		';




		if(!(Configuration::get($this->configName.'_headings_uppercase')))
			$css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .nav-tabs > li > a, .mmtitle, .block .title_block, .block h4 {text-transform: none !important;}  ';

		if((Configuration::get($this->configName.'_headings_bold')))
			$css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .nav-tabs > li > a, .mmtitle, .block .title_block, .block h4{font-weight: bold;}  ';

		if((Configuration::get($this->configName.'_headings_italics')))
			$css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .nav-tabs > li > a, .mmtitle, .block .title_block, .block h4{font-style:italic}  ';

		if((Configuration::get($this->configName.'_headings_center')))
			$css .= '#index .block .title_block, #index .block h4, #grid-creator-wrapper .title_block, .page-heading, h3.page-product-heading, #editorial_block_center h1, #editorial_block_center h2{text-align: center;}  
			.nav-tabs > li{float: none !important; display: inline-block; }
			.page-heading .page-heading{float: none;}
			.is_rtl .page-heading .page-heading, .is_rtl .page-heading span.heading-counter{float: none;}
			.page-heading span.heading-counter{display: block; float: none; margin-top: 4px; font-size:'.(Configuration::get($this->configName.'_default_font_s')-1).'px;}
			.product-title {text-align: center; margin-bottom: 15px; font-size:'.(Configuration::get($this->configName.'_default_font_s')-1).'px;}
			.product-title  p {display: inline;}
			.product-title h1{border: none !important; margin: 0px; padding-bottom: 4px;}
			.imglog{position: absolute; right: 20px; top: 50%; margin-top: -15px;}
			#order-opc .page-heading.step-num span{position: static; line-height: 0px;}
			.pb-center-column{margin-top: -15px;}
			.product-title .productlistRating {text-align: center;}
			.product-title .productlistRating .star {display:inline-block!important; float: none !important; margin: 0px -1px; top: 1px;}
			.product-title .productlistRating .nb-comments{margin-left: 2px;}
			.nav-tabs{text-align: center;}
			.product-title .yotpo.bottomLine{
				text-align: center
			}
			.product-title .standalone-bottomline{
				display: inline-block;
			}
			.product-title .yotpo .yotpo-stars{
				margin-right: 3px;
			}
			';
		
		
		

		$font_headings_type = Configuration::get($this->configName.'_font_headings_type');
		$font_headings_name = Configuration::get($this->configName.'_font_headings_name');
		$font_headings_namec = Configuration::get($this->configName.'_font_headings_namec');
		$font_headings_default = Configuration::get($this->configName.'_font_headings_default');

		$font_txt_type = Configuration::get($this->configName.'_font_txt_type');
		$font_txt_name = Configuration::get($this->configName.'_font_txt_name');
		$font_txt_default = Configuration::get($this->configName.'_font_txt_default');
		$font_txt_namec = Configuration::get($this->configName.'_font_txt_namec');


		if($font_txt_type==2)
		{	
			if($font_headings_type == 3)
			$css .= 'body{font-family: '.$font_headings_namec.' !important;}  ';
			if($font_headings_type == 1)
			$css .= 'body{font-family: '.$font_headings_name.' !important;}  ';
			if($font_headings_type == 0)
			$css .= 'body{font-family: '.$this->systemFonts[$font_headings_default]['name'].', Arial, Helvetica, sans-serif !important;}  ';
		}
		else
		{	
			if($font_txt_type==3)
			$css .= 'body, .page-heading span.heading-counter, #center-layered-nav .layered_subtitle_heading{font-family: '.$font_txt_namec.' !important;}  ';
			if($font_txt_type==1)
			$css .= 'body, .page-heading span.heading-counter, #center-layered-nav .layered_subtitle_heading{font-family: '.$font_txt_name.' !important;}  ';
			if($font_txt_type==0)
			$css .= 'body, .page-heading span.heading-counter, #center-layered-nav .layered_subtitle_heading{font-family: '.$this->systemFonts[$font_txt_default]['name'].', Arial, Helvetica, sans-serif !important;}  ';

			if($font_headings_type==3)
			$css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .block .title_block, .nav-tabs > li > a, #textbannersmodule .txttitle, .cbp-hrmenu .cbp-tab-title, .cbp-vertical-title, .cbp-hrmenu .cbp-hrsub-inner .cbp-column-title, .cbp-hrmenu .cbp-hrsub-tabs-names li a, .cbp-hrmenu.cbp-vertical > ul > li > a, .cbp-hrmenu.cbp-vertical > ul > li .span.cbp-main-link, #iqitmegamenu-mobile #iqitmegamenu-shower, #iqitmegamenu-accordion.cbp-spmenu > li > a{font-family: '.$font_headings_namec.' !important;}  ';
			if($font_headings_type==1)
			$css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .block .title_block, .nav-tabs > li > a, #textbannersmodule .txttitle, .cbp-hrmenu .cbp-tab-title, .cbp-vertical-title, .cbp-hrmenu .cbp-hrsub-inner .cbp-column-title, .cbp-hrmenu .cbp-hrsub-tabs-names li a, .cbp-hrmenu.cbp-vertical > ul > li > a, .cbp-hrmenu.cbp-vertical > ul > li .span.cbp-main-link, #iqitmegamenu-mobile #iqitmegamenu-shower, #iqitmegamenu-accordion.cbp-spmenu > li > a{font-family: '.$font_headings_name.' !important;}  ';
			if($font_headings_type==0)
			$css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .block .title_block, .nav-tabs > li > a,  #textbannersmodule .txttitle, .cbp-hrmenu .cbp-tab-title, .cbp-vertical-title, .cbp-hrmenu .cbp-hrsub-inner .cbp-column-title, .cbp-hrmenu .cbp-hrsub-tabs-names li a, .cbp-hrmenu.cbp-vertical > ul > li > a, .cbp-hrmenu.cbp-vertical > ul > li .span.cbp-main-link, #iqitmegamenu-mobile #iqitmegamenu-shower, #iqitmegamenu-accordion.cbp-spmenu > li > a{font-family: '.$this->systemFonts[$font_headings_default]['name'].', Arial, Helvetica, sans-serif !important;}  ';
		}

		//Main background

		$global_bg_color = Configuration::get($this->configName.'_global_bg_color');
		$global_bg_type = Configuration::get($this->configName.'_global_bg_type');

		$css .= 'body{background-color: '.$global_bg_color.' !important;} ';

		if($global_bg_type==1)
		{
			$global_bg_image = Configuration::get($this->configName.'_global_bg_image');
			$global_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_global_bg_repeat'));
			$global_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_global_bg_position'));
			$css .= 'body{
				background-image: url(' . $global_bg_image . ') !important;
				background-repeat: '.$global_bg_repeat.' !important;
				background-position: '.$global_bg_position.' !important;
			} ';

		}
		elseif($global_bg_type==0)
		{
			$global_bg_pattern = Configuration::get($this->configName.'_global_bg_pattern');
			$css .= 'body{background-image: url(../images/patterns/' . $global_bg_pattern . '.png) !important;} ';
		}
				if (Configuration::get($this->configName.'_global_bg_fixed')) {
				$css .= 'body{background-attachment:fixed;}';
				}

		//Top nav

		$top_bg_color = Configuration::get($this->configName.'_top_bg_color');
		$top_bg_type = Configuration::get($this->configName.'_top_bg_type');

		$css .= 'header .banner{background-color: '.Configuration::get($this->configName.'_top_banner_color').' !important;} ';
		$css .= 'header .nav{background-color: '.$top_bg_color.' !important;} ';

		if($top_bg_type==1)
		{
			$top_bg_image = Configuration::get($this->configName.'_top_bg_image');
			$top_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_top_bg_repeat'));
			$top_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_top_bg_position'));
			$css .= 'header .nav{
				background-image: url(' . $top_bg_image . ') !important;
				background-repeat: '.$top_bg_repeat.' !important;
				background-position: '.$top_bg_position.' !important;
			} ';

		}
		elseif($top_bg_type==0)
		{
			$top_bg_pattern = Configuration::get($this->configName.'_top_bg_pattern');
			$css .= 'header .nav{background-image: url(../images/patterns/' . $top_bg_pattern . '.png) !important;} ';
		}


		$css .= '
		header .nav{color: '.Configuration::get($this->configName.'_top_txt_color').' !important;}
		header .nav a, header .nav a:link, #slidetopcontentShower, .bt_compare, #languages-block-top div.current, #currencies-block-top div.current{color: '.Configuration::get($this->configName.'_top_link_color').' !important;} 
		header .nav a:hover, #slidetopcontentShower:hover, .bt_compare:hover, #languages-block-top div.current:hover, #currencies-block-top div.current:hover{color: '.Configuration::get($this->configName.'_top_link_h_color').' !important;}  
		';




		$css .= 'header .nav{'.$this->convertBorder(Configuration::get($this->configName.'_top_border_color'), 'bottom').'
		'.$this->convertBorder(Configuration::get($this->configName.'_top_bordert_color'), 'top').'
		} ';	

		$css .= '
		#languages-block-top div.current.active div, #languages-block-top div.current.active, #languages-block-top ul, #languages-block-top a, #languages-block-top a:link,
		#currencies-block-top div.current.active div, #currencies-block-top div.current.active, #currencies-block-top ul, #currencies-block-top a, #currencies-block-top a:link
		{color: '.Configuration::get($this->configName.'_top_ddown_color').' !important;  background-color: '.Configuration::get($this->configName.'_top_ddown_bg').' !important;}  ';


		//h_wrap 

		$h_wrap_bg_color = Configuration::get($this->configName.'_h_wrap_bg_color');
		$h_wrap_bg_type = Configuration::get($this->configName.'_h_wrap_bg_type');

		$css .= '.header-container{background-color: '.$h_wrap_bg_color.' !important;} ';

		if($h_wrap_bg_type==1)
		{
			$h_wrap_bg_image = Configuration::get($this->configName.'_h_wrap_bg_image');
			$h_wrap_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_h_wrap_bg_repeat'));
			$h_wrap_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_h_wrap_bg_position'));
			$css .= '.header-container{
				background-image: url(' . $h_wrap_bg_image . ') !important;
				background-repeat: '.$h_wrap_bg_repeat.' !important;
				background-position: '.$h_wrap_bg_position.' !important;
			} ';

		}
		elseif($h_wrap_bg_type==0)
		{
			$h_wrap_bg_pattern = Configuration::get($this->configName.'_h_wrap_bg_pattern');
			$css .= '.header-container{background-image: url(../images/patterns/' . $h_wrap_bg_pattern . '.png) !important;} ';
		}


		//header

		$header_bg_color = Configuration::get($this->configName.'_header_bg_color');
		$header_bg_type = Configuration::get($this->configName.'_header_bg_type');

		$css .= '.container-header, .sticky-header{background-color: '.$header_bg_color.' !important;} ';

		if($header_bg_type==1)
		{
			$header_bg_image = Configuration::get($this->configName.'_header_bg_image');
			$header_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_header_bg_repeat'));
			$header_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_header_bg_position'));
			$css .= '.container-header, .sticky-header{
				background-image: url(' . $header_bg_image . ') !important;
				background-repeat: '.$header_bg_repeat.' !important;
				background-position: '.$header_bg_position.' !important;
			} ';

		}
		elseif($header_bg_type==0)
		{
			$header_bg_pattern = Configuration::get($this->configName.'_header_bg_pattern');
			$css .= '.container-header, .sticky-header{background-image: url(../images/patterns/' . $header_bg_pattern . '.png) !important;} ';
		}

		if(Configuration::get($this->configName.'_header_style') == 1){
			$css .= '
			@media (min-width: 1000px){

			.header-container{
				'.$this->convertBorder(Configuration::get($this->configName.'_headerw_border_color'), 'right', 0, '!important').'	
			}
			.is_rtl .header-container{
				'.$this->convertBorder(Configuration::get($this->configName.'_headerw_border_color'), 'left', 0, '!important').'
				border-right: none !important;	
			}
			}
			';
		}
		else{
				$css .= '.header-container{
				'.$this->convertBorder(Configuration::get($this->configName.'_headerw_border_color'), 'bottom', 0, '!important').'	
		}';

			$header_width = Configuration::get($this->configName.'_header_width');

			if ($header_width == 1) {
				$css .=  '.container-header, .nav .container{max-width: 100% !important;}';
			}

		}
	

		$css .= '.container-header .form-control{color: '.Configuration::get($this->configName.'_header_input_text').' !important; background: '.Configuration::get($this->configName.'_header_input_bg').' !important;
		'.$this->convertBorder(Configuration::get($this->configName.'_header_inner_border_color'), 'all', 0, '!important').'	
		}
		.search-cat-selector .selector span:after{
				'.$this->convertBorder(Configuration::get($this->configName.'_header_inner_border_color'), 'right', 0).'	
		}
		.is_rtl #search_block_top .search-cat-selector .selector span{
				'.$this->convertBorder(Configuration::get($this->configName.'_header_inner_border_color'), 'left', 0).'	
		}
		#search_block_top .search-cat-selector .selector span{color: '.Configuration::get($this->configName.'_header_input_text').' !important;}
#search_block_top .form-control:-moz-placeholder {
  color: '.Configuration::get($this->configName.'_header_input_text').' !important;}
#search_block_top  .form-control::-moz-placeholder {
  color: '.Configuration::get($this->configName.'_header_input_text').' !important;}
#search_block_top  .form-control:-ms-input-placeholder {
  color: '.Configuration::get($this->configName.'_header_input_text').' !important; }
#search_block_top  .form-control::-webkit-input-placeholder {
  color: '.Configuration::get($this->configName.'_header_input_text').' !important; }
		#search_block_top .button-search:before{color: '.Configuration::get($this->configName.'_header_input_text').' !important; }
		 ';

		
		if(!(Configuration::get($this->configName.'_header_inner_border')))
				$css .= '.container-header .form-control{border: none; !important;} ';

		$css .= '
		.container-header{color: '.Configuration::get($this->configName.'_header_txt_color').';}
		.header_user_info, .header_user_info a, .header_user_info a:link {color: '.Configuration::get($this->configName.'_header_link_color').'}
		.header_user_info a:hover {color: '.Configuration::get($this->configName.'_header_link_h_color').'} ';

		$cart_style = Configuration::get($this->configName.'_cart_style');
		$icon_size = Configuration::get($this->configName.'_icon_size');
		
		if ($cart_style == 2)
			$css .= '
		.header_user_info a, .iqit-search-shower-i{font-size: 0px; line-height: 0;}
		#shopping_cart_container .more_info .ajax_cart_total, #shopping_cart_container .more_info .ajax_cart_no_product{display: none !important;}
		.header_user_info > a:first-child:before, .iqit-search-shower-i .icon-search, #shopping_cart_container .shopping_cart > a:first-child span.cart_name{margin-bottom: 0px; }
		.inline-header.alt-cart .iqit-search-shower, .inline-header.alt-cart #shopping_cart_container, .inline-header.alt-cart .header_user_info{
			min-width: '.($icon_size + floor($icon_size/2) + 5).'px;
			max-width:  '.($icon_size + floor($icon_size/2) + 10).'px;
		}
		';
		
		if ($cart_style == 1 || $cart_style == 2)
			$css .= '
			.header_user_info > a:first-child:before{ font-size: '.($icon_size).'px; line-height: '.($icon_size + 3).'px;}
			#shopping_cart_container .shopping_cart > a:first-child span.cart_name:before{font-size: '.($icon_size - 3).'px; line-height: '.($icon_size + 3).'px;}
			.iqit-search-shower-i .icon-search{font-size: '.($icon_size - 1).'px; line-height: '.($icon_size + 3).'px;}
			';

		//cart
		if(!(Configuration::get($this->configName.'_cart_icon')))
			$css .= '.shopping_cart > a:first-child span.cart_name:before{ display: none; !important;} ';

		if((Configuration::get($this->configName.'_cart_icon')==2))
			$css .= '.shopping_cart > a:first-child span.cart_name:before{ content: "\\e605"; font-family: "warehousefont";} 
			.mh-button .icon-shopping-cart:before{ content: "\\e605"; font-family: "warehousefont";} 
			';

		$css .= '.shopping_cart > a:first-child span.cart_name, .shopping_cart > a:first-child span.cart_name:before{color: '.Configuration::get($this->configName.'_cart_txt').' ; background: '.Configuration::get($this->configName.'_cart_bg').';}
		.alt-cart .more_info .ajax_cart_quantity{color: '.Configuration::get($this->configName.'_cart2_bg').' ; background: '.Configuration::get($this->configName.'_cart_bg').';}';
		$css .= '.shopping_cart .more_info{color: '.Configuration::get($this->configName.'_cart2_txt').' ; background: '.Configuration::get($this->configName.'_cart2_bg').';} ';




		$cartborder = Configuration::get($this->configName.'_cart_box_border');
		$cartborderexplode = explode(';', $cartborder);

		$css .= '#header .cart_block{color: '.Configuration::get($this->configName.'_cart_box_txt').' ; background: '.Configuration::get($this->configName.'_cart_box_bg').';} 
		#header .cart_block a, #header .cart_block a:link{color: '.Configuration::get($this->configName.'_cart_box_txt').' ;} 
		#header .cart_block a:hover{color: '.Configuration::get($this->configName.'_cart_box_txt_h').' ;} 
		#header .cart_block{
		'.$this->convertBorder($cartborder, 'all').'
		} 
		#header .cart_block *{border-color: '.$cartborderexplode[2].';} 
		';
		$css .= '.cart_block .cart-buttons{background: '.Configuration::get($this->configName.'_cart_box2_bg').';} ';

		if((Configuration::get($this->configName.'_header_padding')))
			$css .= '.container-header{padding-bottom: 20px;}  ';


		if(Configuration::get($this->configName.'_header_absolute'))
			{
			
			if(Configuration::get($this->configName.'_header_style') == 0 || Configuration::get($this->configName.'_header_style') == 2 || Configuration::get($this->configName.'_header_style') == 3)
			$css .= '
			@media screen and (min-width: 768px){
			#index #header{position: absolute; top: 0px; left: 0px; width: 100%;}
			#index .header-container{position: relative;}
			#index #header{background-color: '.Configuration::get($this->configName.'_header_absolute_w_bg').' !important;} 
			#index .container-header, #index .sticky-header{background-color: '.Configuration::get($this->configName.'_header_absolute_bg').' !important;}
			}';

			if(Configuration::get($this->configName.'_header_style') == 1)
			$css .= '
			@media screen and (min-width: 1000px){
			#index.is-sidebar-header .columns-container{
				margin-left: 0px;
			}
			#index .sidebar-header{background-color: '.Configuration::get($this->configName.'_header_absolute_w_bg').' !important;} 
			#index .container-header, #index .sticky-header{background-color: '.Configuration::get($this->configName.'_header_absolute_bg').' !important;}

			}';

			if(Configuration::get($this->configName.'_absolute_header_padding') && Configuration::get($this->configName.'_header_style') == 0)
			$css .= '#index  .container-header{padding-bottom: 20px;}  ';
		}

		if(Configuration::get($this->configName.'_header_increase')){
			$val = Configuration::get($this->configName.'_header_increase');
	
			$css .= '
			@media (min-width: 768px) {
				header .row #header_logo{height: '.(140+$val).'px;}
				header .row #header_logo img{max-height: '.(100+$val).'px;}
			#header .shopping_cart{padding-top: '.((140+$val)/2-28).'px;}
			#header .cart_block{top: '.((140+$val)/2).'px;}
			#search_block_top_content{height: '.(140+$val).'px!important;}
			}
			';
			if($val > 0 )
				$css .= '@media (min-width: 768px) { .alt-cart .iqit-search-shower, .alt-cart #shopping_cart_container, .alt-cart .header_user_info{margin-top: '.(40 + $val/2).'px!important;}}';
			else
				$css .= '@media (min-width: 768px) { .alt-cart .iqit-search-shower, .alt-cart #shopping_cart_container, .alt-cart .header_user_info{margin-top: '.(abs(40 + $val/2)).'px!important;}}';
		}

		$css .= '
		.mobile-main-wrapper{ background: '.Configuration::get($this->configName.'_mh_bg').';}
		.mobile-condensed-header{ '.$this->convertBorder(Configuration::get($this->configName.'_mh_btn_border'), 'bottom', 0, '').' }
		#mh-sticky > .mobile-h-logo{ background: '.Configuration::get($this->configName.'_mh_logo_bg').';}
		header .mh-button > span { color: '.Configuration::get($this->configName.'_mh_icon_color').';}
		header .mh-button > span:hover,  header .mh-button.active > span { color: '.Configuration::get($this->configName.'_mh_icon_a_color').'; }
		.mobile-style3 .mh-button > span:hover,  .mobile-style3 .mh-button.active > span { background: '.Configuration::get($this->configName.'_mh_btn_a_bg').'; }
		.mobile-style3 .mh-button{ '.$this->convertBorder(Configuration::get($this->configName.'_mh_btn_border'), 'right', 0, '').' }
		header .mobile-condensed-header .mh-drop{ background: '.Configuration::get($this->configName.'_mh_dd_bg').';  color: '.Configuration::get($this->configName.'_mh_dd_txt').'; }
		header .mobile-condensed-header .mh-drop a, header .mobile-condensed-header .mh-drop a:link, header .mobile-condensed-header .mh-drop a:hover{ background: '.Configuration::get($this->configName.'_mh_dd_bg').';  color: '.Configuration::get($this->configName.'_mh_dd_txt').'; }
		.mh-search-module .form-control{color: '.Configuration::get($this->configName.'_mh_dd_input_txt').' !important; background: '.Configuration::get($this->configName.'_mh_dd_input_bg').' !important;
		'.$this->convertBorder(Configuration::get($this->configName.'_mh_dd_input_border'), 'all', 0, '!important').'	
		}
		.mh-search-module .search-cat-selector .selector span:after{
				'.$this->convertBorder(Configuration::get($this->configName.'_mh_dd_input_border'), 'right', 0).'	
		}
		.is_rtl .mh-search-module .search-cat-selector .selector span{
				'.$this->convertBorder(Configuration::get($this->configName.'_mh_dd_input_border'), 'left', 0).'	
		}
		.mh-search-module .search-cat-selector .selector span{color: '.Configuration::get($this->configName.'_mh_dd_input_txt').' !important;}
.mh-search-module .form-control:-moz-placeholder {
  color: '.Configuration::get($this->configName.'_mh_dd_input_txt').' !important;}
.mh-search-module  .form-control::-moz-placeholder {
  color: '.Configuration::get($this->configName.'_mh_dd_input_txt').' !important;}
.mh-search-module  .form-control:-ms-input-placeholder {
  color: '.Configuration::get($this->configName.'_mh_dd_input_txt').' !important; }
.mh-search-module  .form-control::-webkit-input-placeholder {
  color: '.Configuration::get($this->configName.'_mh_dd_input_txt').' !important; }
		.mh-search-module .button-search:before{color: '.Configuration::get($this->configName.'_mh_dd_input_txt').' !important; }


		';
		
		

		$c_wrap_bg_color = Configuration::get($this->configName.'_c_wrap_bg_color');
		$c_wrap_bg_type = Configuration::get($this->configName.'_c_wrap_bg_type');

		$css .= '.columns-container{background-color: '.$c_wrap_bg_color.' !important;} ';

		if($c_wrap_bg_type==1)
		{
			$c_wrap_bg_image = Configuration::get($this->configName.'_c_wrap_bg_image');
			$c_wrap_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_c_wrap_bg_repeat'));
			$c_wrap_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_c_wrap_bg_position'));
			$css .= '.columns-container{
				background-image: url(' . $c_wrap_bg_image . ') !important;
				background-repeat: '.$c_wrap_bg_repeat.' !important;
				background-position: '.$c_wrap_bg_position.' !important;
			} ';

		}
		elseif($c_wrap_bg_type==0)
		{
			$c_wrap_bg_pattern = Configuration::get($this->configName.'_c_wrap_bg_pattern');
			$css .= '.columns-container{background-image: url(../images/patterns/' . $c_wrap_bg_pattern . '.png) !important;} ';
		}

		//content


		$content_bg_color = Configuration::get($this->configName.'_content_bg_color');
		$content_bg_type = Configuration::get($this->configName.'_content_bg_type');

		$css .= '#columns, body.content_only{background-color: '.$content_bg_color.' !important;} body.content_only{background-image: none !important;} ';

		if($content_bg_type==1)
		{
			$content_bg_image = Configuration::get($this->configName.'_content_bg_image');
			$content_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_content_bg_repeat'));
			$content_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_content_bg_position'));
			$css .= '#columns, body.content_only{
				background-image: url(' . $content_bg_image . ') !important;
				background-repeat: '.$content_bg_repeat.' !important;
				background-position: '.$content_bg_position.' !important;
			} ';

		}
		elseif($content_bg_type==0)
		{
			$content_bg_pattern = Configuration::get($this->configName.'_content_bg_pattern');
			$css .= '#columns, body.content_only{background-image: url(../images/patterns/' . $content_bg_pattern . '.png) !important;} ';
		}


			$content_headings_border = Configuration::get($this->configName.'_content_headings_border');
			$content_headings_borderexplode = explode(';', $content_headings_border);
			


			$css .= '#columns .content-inner .block .title_block, #columns .content-inner .block h4 {
				'.$this->convertBorder($content_headings_border, 'bottom', 0, '!important').'

			}
			.page-heading{
				'.$this->convertBorder($content_headings_border, 'bottom').'
				border-color: '.$content_headings_borderexplode[2].'!important;
			}
			';
			
			

			$css .= '
			.not-index #columns .content-inner #center_column *,
			#index #columns .content-inner #center_column > div > section, 
			#index #columns .content-inner #center_column > div > div,
			#index #columns .content-inner #center_column > div > section *,
			#index #columns .content-inner #center_column > div > div:not(#iqitcontentcreator) * ,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > div,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > section,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > div *,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > section *,
			#columns .content-inner #right_column *,  #columns .content-inner .form-control, #product_comments_block_tab div.comment .comment_details, #product_comments_block_tab div.comment{border-color: '.Configuration::get($this->configName.'_content_inner_border_color').';}  
			#quantity_wanted_p input{border-color: '.Configuration::get($this->configName.'_content_inner_border_color').' !important;}  
			#columns .content-inner .nav-tabs > li > a{border-color: transparent !important;}
			#columns .content-inner #thumbs_list li a{border-color: '.$content_bg_color.';}  
			#columns .content-inner #thumbs_list li a:hover, #columns .content-inner #thumbs_list li a.shown{border-color: '.Configuration::get($this->configName.'_content_inner_border_color').' !important;} 
			#columns .content-inner .nav-tabs > li.active > a, #columns .content-inner .nav-tabs > li.active > a:hover, #columns .content-inner .nav-tabs > li.active > a:focus, #columns .content-inner .nav-tabs > li > a:hover{ border-color: '.Configuration::get($this->configName.'_content_inner_border_color').'!important;} ';
			$css .= '
			body.content_only *,  body.content_only .form-control, #product_comments_block_tab div.comment .comment_details, #product_comments_block_tab div.comment{border-color: '.Configuration::get($this->configName.'_content_inner_border_color').';}  
			#quantity_wanted_p input{border-color: '.Configuration::get($this->configName.'_content_inner_border_color').' !important;}  
			body.content_only .nav-tabs > li > a{border-color: transparent;}
			body.content_only #thumbs_list li a{border-color: '.$content_bg_color.';}  
			body.content_only #thumbs_list li a:hover, body.content_only #thumbs_list li a.shown{border-color: '.Configuration::get($this->configName.'_content_inner_border_color').';} 
			body.content_only .nav-tabs > li.active > a, body.content_only .nav-tabs > li.active > a:hover, body.content_only .nav-tabs > li.active > a:focus
			, body.content_only .nav-tabs > li > a:hover{ border-color: '.Configuration::get($this->configName.'_content_inner_border_color').'; border-bottom-color: transparent;} ';
			
			$css .= '.form-control, #quantity_wanted_p input, .form-control.grey, div.checker span, div.radio span, .delivery_options td{color: '.Configuration::get($this->configName.'_content_input_text').'; background-color: '.Configuration::get($this->configName.'_content_input_bg').';} 

			.button-qty{
				background-color: '.Configuration::get($this->configName.'_content_input_text').'; color: '.Configuration::get($this->configName.'_content_input_bg').';
			}
			';
			$css .= '#columns .content-inner, body.content_only, #layer_cart, #thumbs_list .slick-prev, #thumbs_list .slick-next{color: '.Configuration::get($this->configName.'_content_txt_color').' !important; }  

	
			.not-index #columns .content-inner #center_column a, .not-index #columns .content-inner #center_column a:link,
			#index #columns .content-inner #center_column > div > section a, 
			#index #columns .content-inner #center_column > div > div:not(#iqitcontentcreator) a,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > div a,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > section a,
			#index #columns .content-inner #center_column > div > section a:link,
			#index #columns .content-inner #center_column > div > div:not(#iqitcontentcreator) a:link,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > div a:link,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > section a:link,

			#columns .content-inner #right_column a, #columns .content-inner #right_column a:link, 
			#columns .content-inner #left_column .block a, #columns .content-inner #left_column .block a:link, 
			body.content_only a, body.content_only a:link{color: '.Configuration::get($this->configName.'_content_link_color').'  }  

			.not-index #columns .content-inner #center_column a:hover,
			#index #columns .content-inner #center_column > div > section a:hover, 
			#index #columns .content-inner #center_column > div > div:not(#iqitcontentcreator) a:hover,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > div a:hover,
			#index #columns .content-inner #center_column > div > #iqitcontentcreator .iqitcontent-column-inner > section a:hover,
			#columns .content-inner #right_column a:hover, 
			#columns .content-inner #left_column .block a:hover, 
			body.content_only a:hover{color: '.Configuration::get($this->configName.'_content_link_h_color').' }  

			#columns .content-inner .block .title_block, #columns .content-inner .block h4,
			#columns .content-inner .block .title_block a, #columns .content-inner .block h4 a,
			#columns .content-inner .nav-tabs > li > a, .pb-center-column h1, .page-heading, h3.page-product-heading
			{color: '.Configuration::get($this->configName.'_content_headings_color').' !important; }  
			
			body.content_only .block .title_block, body.content_only .block h4,
			body.content_only .block .title_block a, body.content_only .block h4 a,
			body.content_only .nav-tabs > li > a, .pb-center-column h1, .page-heading, h3.page-product-heading
			{color: '.Configuration::get($this->configName.'_content_headings_color').' !important; }  
			';
			$css .= '#columns .content-inner #center_column .form-control{
				'.$this->convertBorder(Configuration::get($this->configName.'_content_input_border'), 'all').'
			}';

			/**
			if(!Configuration::get($this->configName.'_content_input_select'))
				$css .= 'div.selector, div.selector span, div.checker span, div.radio span, div.uploader, div.uploader span.action, div.button, div.button span
			{
				background-image: url(../images/black_uniform.png);
				color: #6b6b6b !important;
				text-shadow: none !important;
			}

			.form-control option{background:  #1F1F1F !important; color: #6b6b6b !important}
						';
			**/
			if(Configuration::get($this->configName.'_content_tab_style'))
			{
				$css .= '
					.nav-tabs{
						padding: 10px 0px 12px;
					}
					
					#columns .content-inner .nav-tabs > li.active > a, #columns .content-inner .nav-tabs > li.active > a:hover, #columns .content-inner .nav-tabs > li.active > a:focus, #columns .content-inner .nav-tabs > li > a:hover{
					border: none;
					  opacity: 1;
					  background: none !important;
				}
				#columns .content-inner .nav-tabs > li > a{
				padding: 0px;
				margin: 0px;
				border: none; opacity: 0.5;
			  -webkit-transition: color 0.3s ease;
  transition: color 0.3s ease;}
    #columns .content-inner .nav-tabs > li{
  padding: 0px 15px;
	}

				.tab-content > .page-product-box.tab-pane, #product .tab-content > .tab-pane{border: none; padding-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-top: 10px;}
				';
			}


		$css .= '.box, #facebook_block, #cmsinfo_block, .table tfoot tr, .ph_simpleblog .simpleblog-posts .post-content, ul.step li.step_done{background:'.Configuration::get($this->configName.'_content_box_bg').' ; color:'.Configuration::get($this->configName.'_content_box_color').' ;}   ';

		$css .= '.table > thead > tr > th{background:'.Configuration::get($this->configName.'_table_bg').' ; color:'.Configuration::get($this->configName.'_table_color').' ;}   ';
		
			$css .= '
		#center-layered-nav .layered_filter_center .active.layered_subtitle_heading,
		#center-layered-nav .layered_filter_center .active.layered_subtitle_heading div,
		#center-layered-nav .layered_filter_center > ul, #center-layered-nav a, #center-layered-nav:link{color: '.Configuration::get($this->configName.'_ddown_color').' !important; background-color: '.Configuration::get($this->configName.'_ddown_bg').' !important;}  ';
		


		if(Configuration::get($this->configName.'_content_bgh_status'))
			$css .= '
			#columns .content-inner .block .title_block, 
			#columns .content-inner .block h4,
			.pb-center-column .product-title h1,
			.page-heading, .product-title-center,
			h3.page-product-heading{ background:'.Configuration::get($this->configName.'_content_bgh').' ;  padding: 12px; }
			#order-opc .page-heading.step-num{ background:'.Configuration::get($this->configName.'_content_bgh').' ; }
			#columns .content-inner .nav-tabs > li > a{color:'.Configuration::get($this->configName.'_content_txt_color').' !important ;  }
			#columns #center-layered-nav .layered_subtitle_heading {padding: 0px !important; background: none !important; color:'.Configuration::get($this->configName.'_content_txt_color').' !important ; }
			#columns #center-layered-nav .layeredSortBy {padding: 0px !important; padding-right: 10px !important; background: none !important; color:'.Configuration::get($this->configName.'_content_txt_color').' !important ; }
			#columns .content-inner .nav-tabs > li.active > a{ background:'.Configuration::get($this->configName.'_content_bgh').'; color:'.Configuration::get($this->configName.'_content_headings_color').' !important ;  }
			.alternative-slick-arrows .slick-next{right: 5px;}
			.alternative-slick-arrows .slick-prev{right: 35px;}
			';

		
		if(!Configuration::get($this->configName.'_carousel_dots'))
			$css .= '.slick_carousel_style .slick-dots{display: none !important;} .slick-slider.slick_carousel_style{margin-bottom: 0px;}';
		
		

		$css .= '.slick-dots li button{
			background-color: '.Configuration::get($this->configName.'_dot_color').';
		}
		.slick-dots li.slick-active button{
			background-color: '.Configuration::get($this->configName.'_dot_a_color').';
		}';

		$content_block_border_c = Configuration::get($this->configName.'_content_block_border_c');
		$content_block_border_cexplode = explode(';', $content_block_border_c);

		if($content_block_border_cexplode[1])
			$css .= '#left_column .block, #right_column .block{ '.$this->convertBorder($content_block_border_c , 'all', 0, '!important').'}
			';

		$blocksbg = Configuration::get($this->configName.'_content_block_bg');
		
		if($content_block_border_cexplode[1] || ($blocksbg != '' && $blocksbg != 'transparent'))
			$css .= '#left_column .block_content, #right_column .block_content{padding: 0px 12px;}
		#left_column .block .title_block, #right_column .block .title_block{ padding: 12px;}
		#columnadverts{margin-bottom: 20px;}
		#left_column #standardtweets_module, #right_column #standardtweets_module{border:none !important;}
		#left_column .layeredSortBy, #right_column .layeredSortBy{display: block; margin-bottom: 10px;}
		#left_column #layered_form > div, #right_column #layered_form > div{padding: 0px 12px;}
		#left_column #layered_form .title_block, #right_column #layered_form .title_block{padding: 4px 5px 4px 0px; background: none;
		font-size: '.Configuration::get($this->configName.'_default_font_s').'px; line-height: '.(Configuration::get($this->configName.'_default_font_s')+4).'px;
		}
		.blockmanufacturer{padding-bottom: 12px;}
			';

		if($blocksbg != '' && $blocksbg != 'transparent')
			$css .= '#left_column .block, #right_column .block{ background-color: '.$blocksbg .';}';

		$blockselementsbg = Configuration::get($this->configName.'_content_element_bg');
		$content_element_border_c = Configuration::get($this->configName.'_content_element_border_c');
		$content_element_border_cexplode = explode(';', $content_element_border_c);

		if($blockselementsbg != 'transparent' && $blockselementsbg != ''){
			$css .= '.primary_block{
				    margin-left: 0px;
   					margin-right: 0px;
   					padding-top: 10px;
   					background-color: '.$blockselementsbg.';
			}
			#cms .rte{
			padding: 10px;
			}
			.cat_desc_container, #product .product-tabs-container .page-product-box, .table tbody > tr > td, #order-opc #login_form, #cms .rte{
				background-color: '.$blockselementsbg.';
			}
			';
			if($content_element_border_cexplode[1])
			$css .= '.primary_block, #cms .rte{ '.$this->convertBorder($content_element_border_c , 'all', 0, '!important').'}
		';
		}

		

		

		//alerts
		
		$css .= '.alert-success{background-color: '.Configuration::get($this->configName.'_alertsuccess_bg').' !important; color: '.Configuration::get($this->configName.'_alertsuccess_txt').' !important;} ';
		$css .= '.alert-info{background-color: '.Configuration::get($this->configName.'_alertinfo_bg').' !important; color: '.Configuration::get($this->configName.'_alertinfo_txt').' !important;} ';	
		$css .= '.alert-warning{background-color: '.Configuration::get($this->configName.'_alertwarning_bg').' !important; color: '.Configuration::get($this->configName.'_alertwarning_txt').' !important;} ';	
		$css .= '.alert-danger{background-color: '.Configuration::get($this->configName.'_alertdanger_bg').' !important; color: '.Configuration::get($this->configName.'_alertdanger_txt').' !important;} ';		

		//f_wrap 

		$f_wrap_bg_color = Configuration::get($this->configName.'_f_wrap_bg_color');
		$f_wrap_bg_type = Configuration::get($this->configName.'_f_wrap_bg_type');

		$css .= '.footer-container{background-color: '.$f_wrap_bg_color.' !important;} ';

		if($f_wrap_bg_type==1)
		{
			$f_wrap_bg_image = Configuration::get($this->configName.'_f_wrap_bg_image');
			$f_wrap_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_f_wrap_bg_repeat'));
			$f_wrap_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_f_wrap_bg_position'));
			$css .= '.footer-container{
				background-image: url(' . $f_wrap_bg_image . ') !important;
				background-repeat: '.$f_wrap_bg_repeat.' !important;
				background-position: '.$f_wrap_bg_position.' !important;
			} ';

		}
		elseif($f_wrap_bg_type==0)
		{
			$f_wrap_bg_pattern = Configuration::get($this->configName.'_f_wrap_bg_pattern');
			$css .= '.footer-container{background-image: url(../images/patterns/' . $f_wrap_bg_pattern . '.png) !important;} ';
		}

		if(Configuration::get($this->configName.'_f_wrap_padding'))
			$css .= '.footer-container{padding-top: 20px; padding-bottom: 20px;} ';
		if(Configuration::get($this->configName.'_second_footer'))
			$css .= '.footer-container{padding-bottom: 0px;} ';

		

		//footer
		$footer1_bg_color = Configuration::get($this->configName.'_footer1_bg_color');
		$footer1_bg_type = Configuration::get($this->configName.'_footer1_bg_type');

		$css .= '.footer-container .footer-container-inner1{background-color: '.$footer1_bg_color.' !important;} ';
		$css .= '.footer-container .footer-container-inner1{border-bottom-color: '.$footer1_bg_color.' !important; } ';


		if($footer1_bg_type==1)
		{
			$footer1_bg_image = Configuration::get($this->configName.'_footer1_bg_image');
			$footer1_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_footer1_bg_repeat'));
			$footer1_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_footer1_bg_position'));
			$css .= '.footer-container .footer-container-inner1{
				background-image: url(' . $footer1_bg_image . ') !important;
				background-repeat: '.$footer1_bg_repeat.' !important;
				background-position: '.$footer1_bg_position.' !important;
			} ';

		}
		elseif($footer1_bg_type==0)
		{
			$footer1_bg_pattern = Configuration::get($this->configName.'_footer1_bg_pattern');
			$css .= '.footer-container .footer-container-inner1{background-image: url(../images/patterns/' . $footer1_bg_pattern . '.png) !important;} ';
		}

		

		$css .= '
			.footer-container .footer-container-inner1{
			'.$this->convertBorder(Configuration::get($this->configName.'_footer1_border_color'), 'top').'

			} 
			.footer-container #footer1 h4{
				'.$this->convertBorder(Configuration::get($this->configName.'_footer1_border_title'), 'bottom').'
			}
			.footer-container #footer1 .bullet li{
				'.$this->convertBorder(Configuration::get($this->configName.'_footer1_inner_border_color'), 'top').'
			}

			.footer-container #footer h4{
				'.$this->convertBorder(Configuration::get($this->configName.'_footer_border_title'), 'bottom').'
			}
			.footer-container #footer .bullet li{
				'.$this->convertBorder(Configuration::get($this->configName.'_footer_inner_border_color'), 'top').'
			}
			#footer  input[type="text"]{
			'.$this->convertBorder(Configuration::get($this->configName.'_footer_inner_border_color'), 'all').'
		}
		';

		$css .= '.footer-container .footer-container-inner1, .footer-container .footer-container-inner1 #block_contact_infos > div ul li i{color: '.Configuration::get($this->configName.'_footer1_txt_color').' !important; }  

			.footer-container .footer-container-inner1 a, .footer-container .footer-container-inner1 a:link, .footer-container .footer-container-inner1 .bullet li a:before{color: '.Configuration::get($this->configName.'_footer1_link_color').' !important; }  
			.footer-container .footer-container-inner1 a:hover{color: '.Configuration::get($this->configName.'_footer1_link_h_color').' !important; }  

			.footer-container .footer-container-inner1 h4, .footer-container .footer-container-inner1 h4 a, .footer-container .footer-container-inner1 h4 a:link, .footer-container .footer-container-inner1 h4 a:hover{color: '.Configuration::get($this->configName.'_footer1_headings_color').' !important; }  
			';



		//mainfooter 
		$footer_bg_color = Configuration::get($this->configName.'_footer_bg_color');
		$footer_bg_type = Configuration::get($this->configName.'_footer_bg_type');

		$css .= '.footer-container .footer-container-inner{background-color: '.$footer_bg_color.' !important;} ';
		$css .= '.footer-container .footer-container-inner{
			'.$this->convertBorder(Configuration::get($this->configName.'_footer_border_color'), 'bottom').'
			'.$this->convertBorder(Configuration::get($this->configName.'_footer_bordert_color'), 'top').'

		 } ';

		if($footer_bg_type==1)
		{
			$footer_bg_image = Configuration::get($this->configName.'_footer_bg_image');
			$footer_bg_repeat = $this->convertBgRepeat(Configuration::get($this->configName.'_footer_bg_repeat'));
			$footer_bg_position = $this->convertBgPosition(Configuration::get($this->configName.'_footer_bg_position'));
			$css .= '.footer-container .footer-container-inner{
				background-image: url(' . $footer_bg_image . ') !important;
				background-repeat: '.$footer_bg_repeat.' !important;
				background-position: '.$footer_bg_position.' !important;
			} ';

		}
		elseif($footer_bg_type==0)
		{
			$footer_bg_pattern = Configuration::get($this->configName.'_footer_bg_pattern');
			$css .= '.footer-container .footer-container-inner{background-image: url(../images/patterns/' . $footer_bg_pattern . '.png) !important;} ';
		}

			

		 if(Configuration::get($this->configName.'_footer_bgh_status'))
			$css .= '
			.footer-container .footer-container-inner h4{ background:'.Configuration::get($this->configName.'_footer_bgh').' ;  padding: 10px !important; margin-bottom: 10px !important; }
			.footer-container .footer-container-inner1 h4{ background:'.Configuration::get($this->configName.'_footer1_bgh').' ;  padding: 10px !important; margin-bottom: 10px !important; }';

			$css .= '#footer .form-control{color: '.Configuration::get($this->configName.'_footer_input_text').' ; background-color: '.Configuration::get($this->configName.'_footer_input_bg').' ;} 
			#footer #newsletter_block_left .form-group .button-small{color: '.Configuration::get($this->configName.'_footer_input_text').' !important;}

			 ';
			$css .= '.footer-container .footer-container-inner, .footer-container .footer-container-inner #block_contact_infos > div ul li i{color: '.Configuration::get($this->configName.'_footer_txt_color').' !important; }  

			.footer-container .footer-container-inner a, .footer-container .footer-container-inner a:link, .footer-container .footer-container-inner .bullet li a:before{color: '.Configuration::get($this->configName.'_footer_link_color').' !important; }  
			.footer-container .footer-container-inner a:hover{color: '.Configuration::get($this->configName.'_footer_link_h_color').' !important; }  

			.footer-container .footer-container-inner h4, .footer-container .footer-container-inner h4 a, .footer-container .footer-container-inner h4 a:link, .footer-container .footer-container-inner h4 a:hover{color: '.Configuration::get($this->configName.'_footer_headings_color').' !important; }  
			';

			if (!(Configuration::get($this->configName.'_footer_ul_arrows')))
			{
				$css .= '.footer-container #footer .bullet li a, .footer-container #footer1 .bullet li a{
					padding-left:0px;
				}
				.footer-container #footer .bullet li a:before, .footer-container #footer1 .bullet li a:before{
					display: none !important;
				}';

			}
	

		if(Configuration::get($this->configName.'_footer_width') && !Configuration::get($this->configName.'_f_wrap_width'))
		{ $css .= '.footer-container {padding-left: 0px; padding-right: 0px;} ';}

		
		if(!Configuration::get($this->configName.'_footer_social_round'))
			$css .= '.social_block_mod li a{
				-webkit-border-radius: 0px !important; 
				-moz-border-radius: 0px !important;
				-ms-border-radius: 0px !important;
				-o-border-radius: 0px !important;
				border-radius: 0px !important; 
			} ';

		$css .= '.social_block_mod li a{background-color: '.Configuration::get($this->configName.'_footer_social_bg').' !important; }
		.social_block_mod li a:before{ color: '.Configuration::get($this->configName.'_footer_social_color').' !important;}
		 ';

		  $css .= '
		 #toTop{
		 background-color: '.Configuration::get($this->configName.'_bg_totop').';
		 color: '.Configuration::get($this->configName.'_icon_totop').';
		 }
		 #toTop:hover{
		 background-color: '.Configuration::get($this->configName.'_bgh_totop').';
		 color: '.Configuration::get($this->configName.'_iconh_totop').';
		 }
		 ';
		 


		$css .= Configuration::get($this->configName.'_custom_css');

		$css  = trim(preg_replace('/\s+/', ' ', $css));
	
		
		if (Shop::getContext() == Shop::CONTEXT_GROUP)
			$myFile = $this->local_path . "css/themeeditor_g_".(int)$this->context->shop->getContextShopGroupID().".css";
		elseif (Shop::getContext() == Shop::CONTEXT_SHOP)
			$myFile = $this->local_path . "css/themeeditor_s_".(int)$this->context->shop->getContextShopID().".css";
		
		
		
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $css);
		fclose($fh);



		$js = Configuration::get($this->configName.'_custom_js');

		if (Shop::getContext() == Shop::CONTEXT_GROUP)
			$myFile = $this->local_path . "js/front/themeeditor_g_".(int)$this->context->shop->getContextShopGroupID().".js";
		elseif (Shop::getContext() == Shop::CONTEXT_SHOP)
			$myFile = $this->local_path . "js/front/themeeditor_s_".(int)$this->context->shop->getContextShopID().".js";
		
		
		
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $js);
		fclose($fh);

	}
	
	public function convertBorderType($type) 
	{
			$border_type = 'none';

			switch($type) {
				case 5 :
					$border_type = 'groove';
					break;
				case 4 :
					$border_type = 'double';
					break;
				case 3 :
					$border_type = 'dotted';
					break;
				case 2 :
					$border_type = 'dashed';
					break;
				case 1 :
					$border_type = 'solid';
					break;
				default :
					$border_type = 'none';
			}

		return $border_type;
	}


	public function convertBorder($value, $position, $triangle = 0, $important = '') 
	{
			$tmpborder =  explode(';', $value);
				
			$width = $tmpborder[0];
			$type = $tmpborder[1];
			$color = $tmpborder[2];



			switch($type) {
				case 5 :
					$border_type = 'groove';
					break;
				case 4 :
					$border_type = 'double';
					break;
				case 3 :
					$border_type = 'dotted';
					break;
				case 2 :
					$border_type = 'dashed';
					break;
				case 1 :
					$border_type = 'solid';
					break;
				default :
					$border_type= 'none';
			}

			$border_code = '';

			if(isset($color) && $color!='')
			{
				if($triangle == 1)
				{
					$border_code = 'left: '.-$width.'px; border-bottom: '.(12+$width).'px '.$border_type.' '.$color.'; border-left: '.(12+$width).'px '.$border_type.' transparent; border-right: '.(12+$width).'px '.$border_type.' transparent;';
				}
				elseif($triangle == 2)
				{
					$border_code = 'left: '.-(12+$width).'px; border-right: '.(12+$width).'px '.$border_type.' '.$color.'; border-bottom: '.(12+$width).'px '.$border_type.' transparent; border-left: '.(12+$width).'px '.$border_type.' transparent;';
				}
				else{
				if($position=='side')
				{ 
					$border_code = 'border-left: '.$width.'px '.$border_type.' '.$color.$important.';'.PHP_EOL;
					$border_code .= 'border-right: '.$width.'px '.$border_type.' '.$color.$important.';';
				}
				elseif($position=='all')
					$border_code = 'border: '.$width.'px '.$border_type.' '.$color.$important.';';
				else
					$border_code = 'border-'.$position.': '.$width.'px '.$border_type.' '.$color.$important.';';
			}
			}

			return  $border_code;
	}
	public function convertBgRepeat($value) {

			switch($value) {
				case 3 :
					$repeat_option = 'repeat';
					break;
				case 2 :
					$repeat_option = 'repeat-x';
					break;
				case 1 :
					$repeat_option = 'repeat-y';
					break;
				default :
					$repeat_option = 'no-repeat';
			}
			return  $repeat_option;
	}


	public function convertBgPosition($value) {

			switch($value) {
				case 2 :
					$position_option = 'left top';
					break;
				case 1 :
					$position_option = 'center top';
					break;
				default :
					$position_option = 'right top';
			}
			return  $position_option;
	}

	public function hookdisplayAdminHomeQuickLinks() {
		echo '<li id="themeeditor_block">
		<a  style="background:#F8F8F8 url(../modules/themeeditor/qllogo.png) no-repeat 50% 20px" href="index.php?controller=adminmodules&configure=themeeditor&token='.Tools::getAdminTokenLite('AdminModules').'">
		<h4>Theme Editor Module</h4>
		<p>Customize your theme</p>
		</a>
		</li>';
	}

	public function hookCalculateGrid($params) {

		$inc = 0;
		if ((Context::getContext()->theme->hasLeftColumn($this->context->controller->php_self)))
			$inc++;
		if ((Context::getContext()->theme->hasRightColumn($this->context->controller->php_self)))
			$inc++;

		switch ($params['size']) {
			case 'large':
			$grid = Configuration::get($this->configName.'_grid_size_lg') - $inc;
			break;
			case 'medium':
			$grid = Configuration::get($this->configName.'_grid_size_md') - $inc;
			break; 
			case 'small':
			$grid = Configuration::get($this->configName.'_grid_size_sm');
			break; 
			case 'mediumsmall':
			$grid = Configuration::get($this->configName.'_grid_size_ms');
			break;
			case 'xtrasmall':
			$grid = Configuration::get($this->configName.'_grid_size_xs');
			break;
		}

		if($grid==5)
			$grid=15;
		else
			$grid=(12/$grid);

		return $grid;
	}

	public function hookHeader($params) {

		if (isset($_SERVER['HTTP_USER_AGENT']) && 
			(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
			header('X-UA-Compatible: IE=edge,chrome=1');
		
		

			$font_headings_type = Configuration::get($this->configName.'_font_headings_type');
			$font_headings_link = str_replace(array('http://','https://'), '', Configuration::get($this->configName.'_font_headings_link'));

			$font_txt_type = Configuration::get($this->configName.'_font_txt_type');
			$font_txt_link = str_replace(array('http://','https://'), '', Configuration::get($this->configName.'_font_txt_link')); 

			$fonts = array();
			if($font_txt_type==2)
			{	
				if($font_headings_type==1)
				$fonts[0] = $font_headings_link;
			}
			else
			{
				if($font_txt_type==1)
				$fonts[1] = $font_txt_link;
				if($font_headings_type==1)
				$fonts[0] = $font_headings_link;
			}
				
	
			
			$id_shop = (int)$this->context->shop->id;
			$preloader = Configuration::get($this->configName.'_preloader');

			$lazyload = Configuration::get($this->configName.'_carousel_load');
			$product_tabs = Configuration::get($this->configName.'_product_tabs');
			$header_style =	Configuration::get($this->configName.'_header_style');
			$mobile_header_style = Configuration::get($this->configName.'_mobile_header_style');
			$mobile_header_sticky = Configuration::get($this->configName.'_mobile_header_sticky');

			$cart_style =	Configuration::get($this->configName.'_cart_style');
			if($cart_style == 2)
				$cart_style = 1;
			if($header_style == 2 || $header_style == 3)
				$cart_style = 1;

			$inc = 0;
				if ((Context::getContext()->theme->hasLeftColumn($this->context->controller->php_self)))
			$inc++;
				if ((Context::getContext()->theme->hasRightColumn($this->context->controller->php_self)))
			$inc++;

			$grid_size_sm = Configuration::get($this->configName.'_grid_size_sm') - $inc;

			if($grid_size_sm == 0)
				$grid_size_sm = 1;
			
			$yotpo = Configuration::get($this->configName.'_yotpo_stars');
			if (!Module::isEnabled('yotpo'))
				$yotpo = 0;

			$wishlist = true;
			if (!Module::isEnabled('blockwishlist'))
				$wishlist = false;

			$thumbs_position = Configuration::get($this->configName.'_thumbs_position');

			$theme_settings = array(
				'ajax_popup' => (Configuration::get($this->configName.'_ajax_popup')),
				'yotpo_stars' => $yotpo,
				'preloader' => $preloader,
				'wishlist_status' => $wishlist,
				'small_default' => Image::getSize('small_default'),
				'mobile_header_style' => $mobile_header_style,
				'mobile_header_sticky' => $mobile_header_sticky,
				'mobile_header_search' => Configuration::get($this->configName.'_mobile_header_search'),
				'header_style' => $header_style,
				'cart_style' => $cart_style,
				'retina_logo' => Configuration::get($this->configName.'_retina_logo'),
				'is_rtl' => $this->context->language->is_rtl,
				'top_width' => (Configuration::get($this->configName.'_top_width')),
				'footer_width' => (Configuration::get($this->configName.'_footer_width')),
				'f_wrap_width' => (Configuration::get($this->configName.'_f_wrap_width')),
				'left_on_phones' => (Configuration::get($this->configName.'_left_on_phones')),
				'breadcrumb_width' => (Configuration::get($this->configName.'_breadcrumb_width')),
				'product_right_block' => (Configuration::get($this->configName.'_product_right_block')),
				'accesories_position' => Configuration::get($this->configName.'_accesories_position'),
				'thumbs_position' => $thumbs_position,
				'product_tabs' => $product_tabs,
				'productlist_view' => (Configuration::get($this->configName.'_productlist_view')),
				'show_desc' => (Configuration::get($this->configName.'_show_desc')),
				'desc_style' => (Configuration::get($this->configName.'_desc_style')),
				'show_subcategories' => (Configuration::get($this->configName.'_show_subcategories')),
				'footer_img_src' => file_exists('modules/themeeditor/img/footer_logo_'.(int)$id_shop.'.jpg'),
				'image_path' => $this->_path.'img/footer_logo_'.(int)$id_shop.'.jpg',
				'font_include' => $fonts, 
				'grid_size_lg' => Configuration::get($this->configName.'_grid_size_lg') - $inc,
				'grid_size_md' => Configuration::get($this->configName.'_grid_size_md') - $inc,
				'grid_size_sm' => $grid_size_sm,
				'grid_size_ms' => Configuration::get($this->configName.'_grid_size_ms'),
				'grid_size_xs' => Configuration::get($this->configName.'_grid_size_xs'),
				'subcats_grid_size_md' =>  Configuration::get($this->configName.'_subcats_grid_size_md'),
				'subcats_grid_size_sm' => Configuration::get($this->configName.'_subcats_grid_size_sm'),
				'subcats_grid_size_xs' => Configuration::get($this->configName.'_subcats_grid_size_xs'),
				'product_left_size' => Configuration::get($this->configName.'_product_left_size'),
				'product_center_size' => Configuration::get($this->configName.'_product_center_size'),
				'headings_center' => Configuration::get($this->configName.'_headings_center'),
				'logo_width' => Configuration::get($this->configName.'_logo_width'),
				'logo_position' => Configuration::get($this->configName.'_logo_position'),
				'footer1_status' => Configuration::get($this->configName.'_footer1_status'),
				'second_footer' => (Configuration::get($this->configName.'_second_footer')),
				'iqit_lazy_load' => $lazyload,
				'carousel_style' => (Configuration::get($this->configName.'_carousel_style')),
				'top_bar' => (Configuration::get($this->configName.'_top_bar')),
				'copyright_text' => Configuration::get($this->configName.'_copyright_text', $this->context->language->id),
				);

				Media::addJsDef(array('iqit_carousel_auto' => (bool)Configuration::get($this->configName.'_carousel_auto')));

				if ($thumbs_position)
					Media::addJsDef(array('iqit_thumbs_position' => true));	
				else
					Media::addJsDef(array('iqit_thumbs_position' => false));	

				if($lazyload){
					Media::addJsDef(array('iqit_carousel_load' => 'ondemand'));
					Media::addJsDef(array('iqit_lazy_load' => true));					
				}
				else
				{
					Media::addJsDef(array('iqit_carousel_load' => 'progressive'));
					Media::addJsDef(array('iqit_lazy_load' => false));	
				}

				if($header_style == 1){
					Media::addJsDef(array('iqit_sidebarh' => true));	
					$this->context->controller->addCSS(($this->_path).'css/options/hsidebar.css', 'all');
					$this->context->controller->addJS(($this->_path).'js/front/sidebarh.js');	
				}
				elseif ($header_style == 2 || $header_style == 3){
					$this->context->controller->addCSS(($this->_path).'css/options/inlineh.css', 'all');
					Media::addJsDef(array('iqit_sidebarh' => false));
					Media::addJsDef(array('iqit_inlineh' => true));
				}
				else
					Media::addJsDef(array('iqit_sidebarh' => false));

				
				Media::addJsDef(array('iqit_mobile_header_style' => (int)$mobile_header_style)); 
				Media::addJsDef(array('iqit_mobile_header_sticky' => (bool)$mobile_header_sticky)); 


				if(Configuration::get($this->configName.'_show_qty_field'))
					Media::addJsDef(array('iqit_qtycart' => true));


				if($cart_style == 1 || $cart_style == 2)
					$this->context->controller->addCSS(($this->_path).'css/options/acart.css', 'all');
				

				

				if(Configuration::get($this->configName.'_product_hover')==1)
					$this->context->controller->addCSS(($this->_path).'css/options/hover.css', 'all');

				if(!Configuration::get($this->configName.'_big_responsive'))
					$this->context->controller->addCSS(($this->_path).'css/options/remove_lg.css', 'all');			
	
				if($preloader)
				{
					$this->context->controller->addJS(($this->_path).'js/front/preloader.js');	
					$this->context->controller->addCSS(($this->_path).'css/options/preloader.css', 'all');
					Media::addJsDef(array('isPreloaderEnabled' => true));
				}
				else
					Media::addJsDef(array('isPreloaderEnabled' => false));

				$this->context->controller->addJS(($this->_path).'js/front/script.js');	

				$this->context->smarty->assign('warehouse_vars', $theme_settings);

				if (Shop::getContext() == Shop::CONTEXT_GROUP)
				$this->context->controller->addCSS(($this->_path) . 'css/themeeditor_g_'.(int)$this->context->shop->getContextShopGroupID().'.css', 'all');
				elseif (Shop::getContext() == Shop::CONTEXT_SHOP)
				$this->context->controller->addCSS(($this->_path) . 'css/themeeditor_s_'.(int)$this->context->shop->getContextShopID().'.css', 'all');
				$this->context->controller->addCSS(($this->_path) . 'css/yourcss.css', 'all');


				if (Shop::getContext() == Shop::CONTEXT_GROUP)
				$this->context->controller->addJS(($this->_path) . 'js/front/themeeditor_g_'.(int)$this->context->shop->getContextShopGroupID().'.js');
				elseif (Shop::getContext() == Shop::CONTEXT_SHOP)
				$this->context->controller->addJS(($this->_path) . 'js/front/themeeditor_s_'.(int)$this->context->shop->getContextShopID().'.js');

	}


	public static function getRolloverImageLink($name, $id_product, $type = null)
	{
		if (!isset($id_product)) {
			return;
		}

		if(method_exists('Link','getRolloverImageLink'))
		{
			return Context::getContext()->link->getRolloverImageLink($name, $id_product, $type);
		}
		else return;
		
	}

}
