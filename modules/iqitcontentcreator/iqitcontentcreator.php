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

include_once(_PS_MODULE_DIR_.'iqitcontentcreator/models/IqitCreatorHtml.php');

class Iqitcontentcreator extends Module
{
	protected $config_form = false;
	private $pattern = '/^([A-Z_]*)[0-9]+/';
	private $spacer_size = '5';
	private $user_groups;

	public function __construct()
	{
		$this->name = 'iqitcontentcreator';
		$this->tab = 'front_office_features';
		$this->version = '1.2.1';
		$this->author = 'Prestaspeed.dk';
		$this->need_instance = 0;
		$this->controllers = array('editor');

		/**
		 * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
		 */

		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('IqitContentCreator - Unique homepage generator');
		$this->description = $this->l('Drag and drop responsive widget editor for homepage');

		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

		$this->config_name = 'iqitctcr';

		$this->defaults = array(
			'content' => '',
			'auto_cache' => true
			);
		
	}

	/**
	 * Don't forget to create update methods if needed:
	 * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
	 */
	public function install()
	{
		$this->setDefaults();
		$this->installSample();

		$success = parent::install() 
			&& $this->registerHook('header')
			&& $this->generateCss() 
			&& $this->createTables()
			&& $this->registerHook('actionObjectCategoryUpdateAfter')
            && $this->registerHook('actionObjectCategoryDeleteAfter')
            && $this->registerHook('actionObjectCategoryAddAfter')
            && $this->registerHook('actionObjectCmsUpdateAfter')
            && $this->registerHook('actionObjectCmsDeleteAfter')
            && $this->registerHook('actionObjectCmsAddAfter')
            && $this->registerHook('actionObjectSupplierUpdateAfter')
            && $this->registerHook('actionObjectSupplierDeleteAfter')
            && $this->registerHook('actionObjectSupplierAddAfter')
            && $this->registerHook('actionObjectManufacturerUpdateAfter')
            && $this->registerHook('actionObjectManufacturerDeleteAfter')
            && $this->registerHook('actionObjectManufacturerAddAfter')
            && $this->registerHook('actionObjectProductUpdateAfter')
            && $this->registerHook('actionObjectProductDeleteAfter')
            && $this->registerHook('actionObjectProductAddAfter')
			&& $this->registerHook('displayHome')
			&& $this->addTab()
			&& $this->registerHook('IqitContentCreator');

		return $success;	
	}

	public function uninstall()
	{
		foreach ($this->defaults as $default => $value)
				Configuration::deleteByName($this->config_name.'_'.$default);

		return parent::uninstall() && $this->deleteTables();
	}

	public function installSample()
	{
		$str = file_get_contents($this->getLocalPath().'creator_sample.csv');
				Configuration::updateValue($this->config_name.'_content', $str);
			
	}

	public function addTab()
	{
		$tab = new Tab();
		$tab->name = array();
		foreach (Language::getLanguages() as $language)
			$tab->name[$language['id_lang']] = 'IqitFronteditor';
		$tab->class_name = 'IqitFronteditor';        
  
		$tab->id_parent = -1;
		$tab->module = $this->name;
		if(!$tab->add())
			return false;
		return true;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* custom html */
		$res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'iqitcreator_html` (
			`id_html` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`id_shop` INT(11) UNSIGNED NOT NULL,
			INDEX (`id_html`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'iqitcreator_htmlc` (
			  `id_html` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL ,
			  PRIMARY KEY (`id_html`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* custom html lang */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'iqitcreator_htmlc_lang` (
			`id_html` INT(11) UNSIGNED NOT NULL,
			`id_lang` INT(11) UNSIGNED NOT NULL,
			`id_shop` INT(11) UNSIGNED NOT NULL,
			`html` text NULL,
			INDEX ( `id_html` , `id_lang`, `id_shop`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		return $res;
	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'iqitcreator_html`, `'._DB_PREFIX_.'iqitcreator_htmlc`, `'._DB_PREFIX_.'iqitcreator_htmlc_lang`;
		');
	}

	public function setDefaults()
	{
		foreach ($this->defaults as $default => $value)
		{
			Configuration::updateValue($this->config_name.'_'.$default, $value);
		}
	}

	/**
	 * Load the configuration form
	 */
	public function getContent()
	{
		/**
		 * If values have been submitted in the form, process.
		 */
		$output = '';
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;


		Media::addJsDef(array('iqitsearch_url' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name)); 

		$this->context->controller->addJS($this->_path.'js/back.js');
		$this->context->controller->addCSS($this->_path.'css/back.css');

		$this->context->controller->addJS($this->_path.'js/fontawesome-iconpicker.min.js');
		$this->context->controller->addCSS($this->_path.'css/fontawesome-iconpicker.min.css');

		$this->context->controller->addJS($this->_path.'js/spectrum.js');
		$this->context->controller->addCSS($this->_path.'css/spectrum.css');

		$this->context->controller->addJqueryUI('ui.sortable');
		//$this->context->controller->addJqueryPlugin('colorpicker');

		if (Tools::isSubmit('addCustomHtml') || (Tools::isSubmit('id_html')  && !Tools::isSubmit('submitAddHtml') && IqitCreatorHtml::htmlExists((int)Tools::getValue('id_html'))))
			return $this->renderAddHtmlForm();
		elseif(Tools::isSubmit('submitAddHtml') || Tools::isSubmit('delete_id_html'))
		{
			if(!Tools::isSubmit('back_to_configuration'))
			{
				if ($this->_postValidationHtml())
				{
					$this->_postProcessHtml();
				}
			
		}
		}

		elseif(Tools::isSubmit('importConfiguration'))
		{
			if(isset($_FILES['uploadConfig']) && isset($_FILES['uploadConfig']['tmp_name']))
			{
				$str = file_get_contents($_FILES['uploadConfig']['tmp_name']);
				Configuration::updateValue($this->config_name.'_content', $str);
				$this->generateCss();

				if (isset($errors) AND $errors!='')
					$output .= $this -> displayError($errors);
				else
					$output .= $this -> displayConfirmation($this->l('Configuration imported'));
			}
			else
				$output .= $this -> displayError($this->l('No config file'));	
		}

		elseif (Tools::isSubmit('exportConfiguration'))
		{
						
			$content = Configuration::get($this->config_name.'_content');
		

			$file_name = 'iqcreator_'.time().'.csv';
			$fd = fopen($this->getLocalPath().'export/'.$file_name, 'w+');
			file_put_contents($this->getLocalPath().'export/'.$file_name, print_r($content, true));
			fclose($fd);
			Tools::redirect(_PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/export/'.$file_name);
		}

		
		if (Tools::isSubmit('submitIqitcontentcreatorModule'))
			$this->_postProcess();
		
		$this->context->smarty->assign('module_dir', $this->_path);
		$output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

		$output .= '<div class="panel clearfix">
		<form class="pull-left" id="importForm" method="post" enctype="multipart/form-data" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importConfiguration&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">
		<div style="display:inline-block;"><input type="file" id="uploadConfig" name="uploadConfig" /></div>
	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Import').'</button>
		
		</form><a target="_blank" href="'.$this->context->link->getAdminLink('AdminModules', false).'&exportConfiguration&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">
		<button class="btn btn-default btn-lg pull-right"><span class="icon icon-share"></span> '.$this->l('Export').'</button>
		</a></div>';

		return $output.$this->renderHtmlContents().$this->renderForm();
	}

	/**
	 * Create the form that will be displayed in the configuration of your module.
	 */
	protected function renderForm()
	{
		$helper = new HelperForm();
		$this->updatePosition(Hook::getIdByName('Header'), 1, 200);

		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$helper->module = $this;
		$helper->default_form_language = $this->context->language->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitIqitcontentcreatorModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
			.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$content = Configuration::get($this->config_name.'_content');

		$content_format = array();

		if (isset($content) && ($content != 'null' || $content != ''))
		{
			$contenta = json_decode($content, true);
			
			if (is_array($contenta))
				$content_format = $this->buildSubmenuTree($contenta, false);
		}

			
			
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
			'languages' => $this->context->controller->getLanguages(),
			'manufacturers_select' => $this->renderManufacturersSelect(),
			'custom_html_select' => $this->renderCustomHtmlSelect(),
			'available_modules' => $this->getAvailableModules(),
			'fronteditor_link' => $this->context->link->getModuleLink('iqitcontentcreator','Editor', array(
				'iqit_fronteditor_token' => $this->getFrontEditorToken(),
				'admin_webpath' => $this->context->controller->admin_webpath,
				'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
				Tools::getValue('id_employee')
				)),
			'categories_select' => $this->renderCategoriesSelect(false),
			'images_formats' => ImageType::getImagesTypes('products'),
			'submenu_content' => htmlentities($content, ENT_COMPAT, 'UTF-8'),
			'submenu_content_format' => $content_format,
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
				'title' => $this->l('Hook displayHome content'),
				'icon' => 'icon-cogs',
				),
				'input' => array(
										array(
						'type' => 'switch',
						'label' => $this->l('Auto cache clear'),
						'name' => 'auto_cache',
						'is_bool' => true,
						'desc' => $this->l('If enabled module cache will be cleared after product or manufacturer create/edit/delete. If not it will be only clearad when you click save in iqitcontentcreator module. '),
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
							'type' => 'grid_creator',
							'label' => '',
							'col' => 12,
							'preffix_wrapper' => 'grid-submenu',
							'name' => 'grid_creator',
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
		$var = array();

		foreach ($this->defaults as $default => $value)
		{
				$var[$default] = Configuration::get($this->config_name.'_'.$default);
		}

		return $var;
	}

	/**
	 * Save form data.
	 */
	protected function _postProcess()
	{

		foreach ($this->defaults as $default => $value)
		{
			if($default == 'content'){
				Configuration::updateValue($this->config_name.'_'.$default, urldecode(Tools::getValue('submenu-elements')));
			}
			else
				Configuration::updateValue($this->config_name.'_'.$default, Tools::getValue($default));
		}

		$this->generateCss();

	}

	public function generateElementsCss($elements)
	{
		$css = ''.PHP_EOL;


		foreach ($elements as $key => $element)
		{	
			if(isset($element['row_s']))
			{
				if(isset($element['row_s']['bgw']) && $element['row_s']['bgw'])
					$css .= '#iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' .iqit-fullwidth-row{
					'.(isset($element['row_s']['bgc']) && $element['row_s']['bgc'] != '' ? 'background-color: '.$element['row_s']['bgc'].';' : '').'
					'.(isset($element['row_s']['bgi']) && $element['row_s']['bgi'] != '' ? 'background-image: url('.$element['row_s']['bgi'].'); background-repeat: '.$this->convertBgRepeat($element['row_s']['bgr']).';' : '').'

					'.(isset($element['row_s']['br_top_st']) && $element['row_s']['br_top_st'] != '' ? 'border-top-style: '.$this->convertBorderType($element['row_s']['br_top_st']).';' : '').'
					'.(isset($element['row_s']['br_top_wh']) && $element['row_s']['br_top_wh'] != '' ? 'border-top-width: '.$element['row_s']['br_top_wh'].'px;' : '').'
					'.(isset($element['row_s']['br_top_c']) && $element['row_s']['br_top_c'] != '' ? 'border-top-color: '.$element['row_s']['br_top_c'].'!important;' : '').'

					
					'.(isset($element['row_s']['p_t']) ? 'padding-top: '.$element['row_s']['p_t'].'px;' : '').'
					'.(isset($element['row_s']['p_b']) ? 'padding-bottom: '.$element['row_s']['p_b'].'px;' : '').'

					'.(isset($element['row_s']['br_bottom_st']) && $element['row_s']['br_bottom_st'] != '' ? 'border-bottom-style: '.$this->convertBorderType($element['row_s']['br_bottom_st']).';' : '').'
					'.(isset($element['row_s']['br_bottom_wh']) && $element['row_s']['br_bottom_wh'] != '' ? 'border-bottom-width: '.$element['row_s']['br_bottom_wh'].'px;' : '').'
					'.(isset($element['row_s']['br_bottom_c']) && $element['row_s']['br_bottom_c'] != '' ? 'border-bottom-color: '.$element['row_s']['br_bottom_c'].'!important;' : '').'	

					}
					';
				else	
					$css .= ' #iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].'{
						'.(isset($element['row_s']['bgc']) && $element['row_s']['bgc'] != '' ? 'background-color: '.$element['row_s']['bgc'].';' : '').'
						'.(isset($element['row_s']['bgi']) && $element['row_s']['bgi'] != '' ? 'background-image: url('.$element['row_s']['bgi'].'); background-repeat: '.$this->convertBgRepeat($element['row_s']['bgr']).';' : '').'

						'.(isset($element['row_s']['br_top_st']) && $element['row_s']['br_top_st'] != '' ? 'border-top-style: '.$this->convertBorderType($element['row_s']['br_top_st']).';' : '').'
						'.(isset($element['row_s']['br_top_wh']) && $element['row_s']['br_top_wh'] != '' ? 'border-top-width: '.$element['row_s']['br_top_wh'].'px;' : '').'
						'.(isset($element['row_s']['br_top_c']) && $element['row_s']['br_top_c'] != '' ? 'border-top-color: '.$element['row_s']['br_top_c'].';' : '').'

						'.(isset($element['row_s']['m_r']) ? 'margin-right: 0px;' : '').'
						'.(isset($element['row_s']['m_l']) ? 'margin-left: 0px;' : '').'

						'.(isset($element['row_s']['p_t']) ? 'padding-top: '.$element['row_s']['p_t'].'px;' : '').'
						'.(isset($element['row_s']['p_b']) ? 'padding-bottom: '.$element['row_s']['p_b'].'px;' : '').'

						'.(isset($element['row_s']['br_bottom_st']) && $element['row_s']['br_bottom_st'] != '' ? 'border-bottom-style: '.$this->convertBorderType($element['row_s']['br_bottom_st']).';' : '').'
						'.(isset($element['row_s']['br_bottom_wh']) && $element['row_s']['br_bottom_wh'] != '' ? 'border-bottom-width: '.$element['row_s']['br_bottom_wh'].'px;' : '').'
						'.(isset($element['row_s']['br_bottom_c']) && $element['row_s']['br_bottom_c'] != '' ? 'border-bottom-color: '.$element['row_s']['br_bottom_c'].';' : '').'	
					}
					';
			}
			if(isset($element['content_s']))
			{
				if(
				isset($element['content_s']['bg_color']) ||
				isset($element['content_s']['br_top_st']) ||
				isset($element['content_s']['br_right_st']) ||
				isset($element['content_s']['br_bottom_st']) ||
				isset($element['content_s']['br_left_st']) ||
				isset($element['content_s']['c_m_t']) ||
				isset($element['content_s']['c_m_t2']) ||
				isset($element['content_s']['c_m_r']) ||
				isset($element['content_s']['c_m_b']) ||
				isset($element['content_s']['c_m_l']) ||
				isset($element['content_s']['c_p_t']) ||
				isset($element['content_s']['c_p_r']) ||
				isset($element['content_s']['c_p_b']) ||
				isset($element['content_s']['c_p_l'])
				)
				$css .= '#iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner{
					'.(isset($element['content_s']['bg_color']) && $element['content_s']['bg_color'] != '' ? 'background-color: '.$element['content_s']['bg_color'].';' : '').'
					'.(isset($element['content_s']['br_top_st']) && $element['content_s']['br_top_st'] != '' ? 'border-top-style: '.$element['content_s']['br_top_st'].';' : '').'
					'.(isset($element['content_s']['br_top_wh']) && $element['content_s']['br_top_wh'] != '' ? 'border-top-width: '.$element['content_s']['br_top_wh'].'px;' : '').'
					'.(isset($element['content_s']['br_right_st']) && $element['content_s']['br_right_st'] != '' ? 'border-right-style: '.$element['content_s']['br_right_st'].';' : '').'
					'.(isset($element['content_s']['br_right_wh']) && $element['content_s']['br_right_wh'] != '' ? 'border-right-width: '.$element['content_s']['br_right_wh'].'px;' : '').'
					'.(isset($element['content_s']['br_bottom_st']) && $element['content_s']['br_bottom_st'] != '' ? 'border-bottom-style: '.$element['content_s']['br_bottom_st'].';' : '').'
					'.(isset($element['content_s']['br_bottom_wh']) && $element['content_s']['br_bottom_wh'] != '' ? 'border-bottom-width: '.$element['content_s']['br_bottom_wh'].'px;' : '').'
					'.(isset($element['content_s']['br_left_st']) && $element['content_s']['br_left_st'] != '' ? 'border-left-style: '.$element['content_s']['br_left_st'].';' : '').'
					'.(isset($element['content_s']['br_left_wh']) && $element['content_s']['br_left_wh'] != '' ? 'border-left-width: '.$element['content_s']['br_left_wh'].'px;' : '').'

					'.(isset($element['content_s']['br_top_c']) && $element['content_s']['br_top_c'] != '' ? 'border-top-color: '.$element['content_s']['br_top_c'].'!important;' : '').'
					'.(isset($element['content_s']['br_right_c']) && $element['content_s']['br_right_c'] != '' ? 'border-right-color: '.$element['content_s']['br_right_c'].'!important;' : '').'
					'.(isset($element['content_s']['br_bottom_c']) && $element['content_s']['br_bottom_c'] != '' ? 'border-bottom-color: '.$element['content_s']['br_bottom_c'].'!important;' : '').'	
					'.(isset($element['content_s']['br_left_c']) && $element['content_s']['br_left_c'] != '' ? 'border-left-color: '.$element['content_s']['br_left_c'].'!important;' : '').'

					'.(isset($element['content_s']['c_m_t']) ? 'margin-top: -10px;' : '').'
					'.(isset($element['content_s']['c_m_t2']) ? 'margin-top: -20px;' : '').'
					'.(isset($element['content_s']['c_m_r']) ? 'margin-right: -10px;' : '').'
					'.(isset($element['content_s']['c_m_b']) ? 'margin-bottom: -10px;' : '').'
					'.(isset($element['content_s']['c_m_l']) ? 'margin-left: -10px;' : '').'

					'.(isset($element['content_s']['c_p_t']) ? 'padding-top: 10px;' : '').'
					'.(isset($element['content_s']['c_p_r']) ? 'padding-right: 10px;' : '').'
					'.(isset($element['content_s']['c_p_b']) ? 'padding-bottom: 10px;' : '').'
					'.(isset($element['content_s']['c_p_l']) ? 'padding-left: 10px;' : '').'

				} '.PHP_EOL;

				if(
					isset($element['content_s']['legend_bg']) ||
					isset($element['content_s']['legend_txt']) 
				){
					$css .= '#iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner .iqit-legend-inner{
						'.(isset($element['content_s']['legend_bg']) && $element['content_s']['legend_bg'] != '' ? 'background-color: '.$element['content_s']['legend_bg'].';' : '').'
						'.(isset($element['content_s']['legend_txt']) && $element['content_s']['legend_txt'] != '' ? 'color: '.$element['content_s']['legend_txt'].';' : '').'

					}'.PHP_EOL;

					$css .= '#iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner .iqit-legend-inner .legend-arrow{
						'.(isset($element['content_s']['legend_bg']) && $element['content_s']['legend_bg'] != '' ? 'color: '.$element['content_s']['legend_bg'].';' : '').'

					}'.PHP_EOL;

				}

				if(	 isset($element['content_s']['title_bg']) || isset($element['content_s']['title_borderc']))
					$css .= '#columns .content-inner #iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner .title_block{
						'.(isset($element['content_s']['title_borderc']) && $element['content_s']['title_borderc'] != '' ? 'border-color: '.$element['content_s']['title_borderc'].' !important;' : '').'
						'.(isset($element['content_s']['title_bg']) && $element['content_s']['title_bg'] != '' ? 'background-color: '.$element['content_s']['title_bg'].' !important;' : '').'
						
					}'.PHP_EOL;

				if(	isset($element['content_s']['title_color']))
					$css .= '#columns .content-inner #iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner .title_block .title_block_txt{
						color: '.$element['content_s']['title_color'].' !important;
					}'.PHP_EOL;


				if(	isset($element['content_s']['title_colorh']))
					$css .= '#columns .content-inner #iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner .title_block a.title_block_txt:hover{
						color: '.$element['content_s']['title_colorh'].' !important;
					}'.PHP_EOL;


			}

			if(isset($element['content']['box_style']))
			{

				if(isset($element['content']['box_style']['pbx_bg']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover, .iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product .product-container{background-color: '.$element['content']['box_style']['pbx_bg'].'; }';

				if(isset($element['content']['box_style']['pbx_nc']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product a.product-name, 
				.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product a.product-name:link, 
				.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product  .old-price.product-price{color: '.$element['content']['box_style']['pbx_nc'].' !important; }';

				if(isset($element['content']['box_style']['pbx_pc']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product .price.product-price, .iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product .price.product-price {color: '.$element['content']['box_style']['pbx_pc'].' !important; }';

				if(isset($element['content']['box_style']['pbx_rc']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product div.star:after, .iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product div.star:after{color: '.$element['content']['box_style']['pbx_rc'].' !important; }';
				
				if((isset($element['content']['box_style']['pbx_sh']) && $element['content']['box_style']['pbx_sh'] == 2) ||
				   (isset($element['content']['box_style']['pbx_bg'])) ||
				   (isset($element['content']['box_style']['pbx_b_st']) && ($element['content']['box_style']['pbx_b_st'] != 0)))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product .product-container{
						padding: 9px;
					} ';

				if(isset($element['content']['box_style']['pbx_sh']) && $element['content']['box_style']['pbx_sh'] == 2)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .slick-active .ajax_block_product .product-container{
						-webkit-box-shadow: 0 0px 2px rgba(0, 0, 0, 0.12);
   						 -moz-box-shadow: 0 0px 2px rgba(0, 0, 0, 0.12);
    					box-shadow: 0 0px 2px rgba(0, 0, 0, 0.12);
             			 z-index: 3;
					} 
					.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover .product-container{
						 -webkit-box-shadow: none;
  			  			-moz-box-shadow: none;
  			 			 box-shadow: none;
					}';
				if(isset($element['content']['box_style']['pbx_sh']) && $element['content']['box_style']['pbx_sh'] == 1)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product .product-container{
						 -webkit-box-shadow: none;
  			  			-moz-box-shadow: none;
  			 			 box-shadow: none;
					} ';

				if(isset($element['content']['box_style']['pbx_b_st']) && $element['content']['box_style']['pbx_b_st'] != 6)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product .product-container{	
					'.(isset($element['content']['box_style']['pbx_b_st']) && $element['content']['box_style']['pbx_b_st'] != '' ? 'border-style: '.$this->convertBorderType($element['content']['box_style']['pbx_b_st']).'!important;;' : '').'
					'.(isset($element['content']['box_style']['pbx_b_wh']) && $element['content']['box_style']['pbx_b_wh'] != '' ? 'border-width: '.$element['content']['box_style']['pbx_b_wh'].'px!important;;' : '').'
					'.(isset($element['content']['box_style']['pbx_b_c']) && $element['content']['box_style']['pbx_b_c'] != '' ? 'border-color: '.$element['content']['box_style']['pbx_b_c'].'!important;' : '').'
				}
				.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover .product-container{
					border-color: transparent !important;
				}
				';

					if(isset($element['content']['box_style']['pbx_b_st']) && $element['content']['box_style']['pbx_b_st'] == 0)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product .product-container{	border: none !important;}';

				//hover

				if(isset($element['content']['box_style']['pbxh_bg']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover, .iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover .product-container{background-color: '.$element['content']['box_style']['pbxh_bg'].'; }';

				if(isset($element['content']['box_style']['pbxh_nc']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover a.product-name, .iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover a.product-name:link,
					.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover  .old-price.product-price{color: '.$element['content']['box_style']['pbxh_nc'].' !important; }';

				if(isset($element['content']['box_style']['pbxh_pc']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover .price.product-price , .iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover .price.product-price {color: '.$element['content']['box_style']['pbxh_pc'].' !important; }';

				if(isset($element['content']['box_style']['pbxh_rc']))
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover div.star:after, .iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover div.star:after{color: '.$element['content']['box_style']['pbxh_rc'].' !important; }';

		
				if(isset($element['content']['box_style']['pbxh_sh']) && $element['content']['box_style']['pbxh_sh'] == 2)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover{
						 -webkit-box-shadow: 0 1px 7px rgba(0, 0, 0, 0.15);
   							-moz-box-shadow: 0 1px 7px rgba(0, 0, 0, 0.15);
   						 box-shadow: 0 1px 7px rgba(0, 0, 0, 0.15);
             			 z-index: 3;
					} ';
				if(isset($element['content']['box_style']['pbxh_sh']) && $element['content']['box_style']['pbxh_sh'] == 1)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover {
						 -webkit-box-shadow: none;
  			  			-moz-box-shadow: none;
  			 			 box-shadow: none;
					} ';

				if(isset($element['content']['box_style']['pbxh_b_st']) && $element['content']['box_style']['pbxh_b_st'] != 6)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover {	
					'.(isset($element['content']['box_style']['pbxh_b_st']) && $element['content']['box_style']['pbxh_b_st'] != '' ? 'outline-style: '.$this->convertBorderType($element['content']['box_style']['pbxh_b_st']).'!important;;' : '').'
					'.(isset($element['content']['box_style']['pbxh_b_wh']) && $element['content']['box_style']['pbxh_b_wh'] != '' ? 'outline-width: '.$element['content']['box_style']['pbxh_b_wh'].'px!important;;' : '').'
					'.(isset($element['content']['box_style']['pbxh_b_c']) && $element['content']['box_style']['pbxh_b_c'] != '' ? 'outline-color: '.$element['content']['box_style']['pbxh_b_c'].'!important;' : '').'
				}';

					if(isset($element['content']['box_style']['pbxh_b_st']) && $element['content']['box_style']['pbxh_b_st'] == 0)
					$css .= '.iqitcontent-element-id-'.$element['elementId'].' .ajax_block_product:hover {	outline: none !important;}';


			}
			if(	isset($element['content']['dt']) && $element['content']['dt'])
			$css .= '#iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner .slick-dots{display: block !important;}
			#iqitcontentcreator .iqitcontent-element-id-'.$element['elementId'].' > .iqitcontent-column-inner .slick-slider.slick_carousel_style{margin-bottom: 20px;}'.PHP_EOL;

			if(isset($element['children']))
				$css .= $this->generateElementsCss($element['children']);	
		}

		return $css;
	}

	public function generateCss()
	{
		$css = '';
		$content = Configuration::get($this->config_name.'_content');

		if (strlen($content))
		{
			$content = $this->buildSubmenuTree(json_decode($content, true), false, true);
			$css .=  $this->generateElementsCss($content);
		}


		$css  = trim(preg_replace('/\s+/', ' ', $css));

		if (Shop::getContext() == Shop::CONTEXT_SHOP){
			$my_file = $this->local_path.'css/iqitcreator_s_'.(int)$this->context->shop->getContextShopID().'.css';
			$fh = fopen($my_file, 'w') or die("can't open file");
		fwrite($fh, $css);
		fclose($fh);
		}
		
		

		$this->clearCreatorCache(true);

		return true;

	}

	public function renderAddHtmlForm()
	{	

		$fields_form = array(
			'form' => array(
				'tab_name' => 'main_tab',
				'legend' => array(
					'title' => $this->l('Add custom html'),
					'icon' => 'icon-cogs',
					'id' => 'fff'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Name'),
						'name' => 'title',
						'desc' => $this->l('Custom html name, Only for backoffice purposes'),
						'lang' => false,
					),
					array(
					'type' => 'textarea',
					'label' => $this->l('Html content'),
					'name' => 'html',
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Custom html content which you can later select in creator'),
					'cols' => 60,
					'rows' => 30
				),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
				'buttons' => array(
				'button' => array(
					'name' => 'back_to_configuration',
					'type' => 'submit',
					'icon' => 'process-icon-back',
					'class' => 'btn btn-default pull-left',
					'title' => $this->l('Back')
					),)

			),
		);
		
		if (Tools::isSubmit('id_html') && IqitCreatorHtml::htmlExists((int)Tools::getValue('id_html')))
		{
			$tab = new IqitCreatorHtml((int)Tools::getValue('id_html'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_html');	
		}

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitAddHtml';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddHtmlFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'module_path' => $this->_path,
			'image_baseurl' => $this->_path.'images/'
		);


		$helper->override_folder = '/';

		return $helper->generateForm(array($fields_form));
	}

	public function getAddHtmlFieldsValues()
	{
		$fields = array();

		$fields['title'] = '';

		if (Tools::isSubmit('id_html') && IqitCreatorHtml::htmlExists((int)Tools::getValue('id_html')))
		{
			$html = new IqitCreatorHtml((int)Tools::getValue('id_html'));
			$fields['id_html'] = (int)Tools::getValue('id_html', $html->id);
			$fields['title'] = $html->title;
			
		}
		else
			$html = new IqitCreatorHtml();
		
		$languages = Language::getLanguages(false);

		foreach ($languages as $lang)
			$fields['html'][$lang['id_lang']] = Tools::getValue('html_'.(int)$lang['id_lang'], $html->html[$lang['id_lang']]);

		return $fields;
	}

	public function renderHtmlContents(){

		$shops = Shop::getContextListShopID();
		$tabs = array();

		$tabs = IqitCreatorHtml::getHtmls();

		$this->context->smarty->assign(
			array(
				'link' => $this->context->link,
				'tabs' => $tabs,
			)
		);

		return $this->display(__FILE__, 'listhtml.tpl');

	}

	private function _postValidationHtml()
	{
		$errors = array();

		/* Validation for tab */
		if (Tools::isSubmit('submitAddHtml'))
		{
			/* If edit : checks id_tab */
			if (Tools::isSubmit('id_html'))
			{
				if (!Validate::isInt(Tools::getValue('id_html')) && !IqitCreatorHtml::htmlExists(Tools::getValue('id_html')))
					$errors[] = $this->l('Invalid id_html');
			}

			if (!Tools::strlen(Tools::getValue('title')))
					$errors[] = $this->l('Title is not set');

			/* Checks title/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('html_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The html is not set');
		} 
		/* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_html') && (!Validate::isInt(Tools::getValue('delete_id_html')) || !IqitCreatorHtml::htmlExists((int)Tools::getValue('delete_id_html'))))
			$errors[] = $this->l('Invalid id_html');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));

			return false;
		}

		/* Returns if validation is ok */

		return true;
	}

	private function _postProcessHtml()
	{
		$errors = array();

		/* Processes tab */
		if (Tools::isSubmit('submitAddHtml'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_html'))
			{ 
				$tab = new IqitCreatorHtml((int)Tools::getValue('id_html'));
				if (!Validate::isLoadedObject($tab))
				{
					$this->_html .= $this->displayError($this->l('Invalid id_tab'));

					return false;
				}
			}
			else
				$tab = new IqitCreatorHtml();

			
			$tab->title = Tools::getValue('title');
		
			/* Sets each langue fields */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
				$tab->html[$language['id_lang']] = Tools::getValue('html_'.$language['id_lang']);
				
	

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_html'))
				{
					if (!$tab->add())
						$errors[] = $this->displayError($this->l('The html content could not be added.'));
				}
				/* Update */
				elseif (!$tab->update())
					$errors[] = $this->displayError($this->l('The html could not be updated.'));
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_html'))
		{
			$tab = new IqitCreatorHtml((int)Tools::getValue('delete_id_html'));
			$res = $tab->delete();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete.');
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}
			
		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitAddTab') && Tools::getValue('id_tab'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		elseif (Tools::isSubmit('submitAddTab'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
	}

	/**
	 * Add the CSS & JavaScript files you want to be added on the FO.
	 */
	public function hookHeader()
	{	
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		
			$this->putAssetsFiles();
	}

	public function putAssetsFiles()
	{
		$this->context->controller->addJS($this->_path.'/js/front.js');
		$this->context->controller->addCSS($this->_path.'/css/front.css');
		$this->context->controller->addCSS(_THEME_CSS_DIR_.'product_list.css');

		if (Shop::getContext() == Shop::CONTEXT_GROUP)
		$this->context->controller->addCSS(($this->_path).'css/iqitcreator_g_'.(int)$this->context->shop->getContextShopGroupID().'.css', 'all');
		elseif (Shop::getContext() == Shop::CONTEXT_SHOP)
		$this->context->controller->addCSS(($this->_path).'css/iqitcreator_s_'.(int)$this->context->shop->getContextShopID().'.css', 'all');
	}

	public function hookDisplayHome()
	{	
		$random = round(rand(1, max(3, 1)));
		
		if (!$this->isCached('iqitcontentcreator.tpl', $this->getCacheId('iqitcontentcreator|'.$random)))
		{

		$content = Configuration::get($this->config_name.'_content');


		if (strlen($content))
			$content = $this->buildSubmenuTree(json_decode($content, true), true);

		$imagesTypes = ImageType::getImagesTypes('products');
		$images = array();

		foreach ($imagesTypes as $image) {
			$images[$image['name']] = Image::getSize($image['name']);
			$images[$image['name']]['name'] = $image['name'];
		}
		$this->smarty->assign(array(
			'content' => $content,
			'manufacturerSize' => Image::getSize('mf_image'),
			'images_types' => $images,
			'this_path' => $this->_path

		));
		}
		return $this->display(__FILE__, 'iqitcontentcreator.tpl', $this->getCacheId('iqitcontentcreator|'.$random));

	}

	protected function getCacheId($name = null)
	{
		if ($name === null)
		$name = 'iqitcontentcreator';
		return parent::getCacheId($name);
	}

	public function renderManufacturersSelect()
	{
		$return_manufacturers = array();

		$manufacturers = Manufacturer::getManufacturers(false, $this->context->language->id);
		foreach ($manufacturers as $key=>$manufacturer)
		{
			$return_manufacturers[$key]['name'] = $manufacturer['name'];
			$return_manufacturers[$key]['id'] =  $manufacturer['id_manufacturer'];
		}
		return $return_manufacturers;
	}

	public function renderCustomHtmlSelect()
	{	
		$custom_html = array();
		$id_lang = (int)Context::getContext()->language->id;

		$custom_html = IqitCreatorHtml::getHtmls();
		return $custom_html;
	}

	public function renderCategoriesSelect($frontend)
	{
		$return_categories = array();

		$shops_to_get = Shop::getContextListShopID();

		foreach ($shops_to_get as $shop_id)
			$return_categories = $this->generateCategoriesOption2(Category::getNestedCategories(null, (int)$this->context->language->id, false), $frontend);

		return $return_categories;
	}

	public function customGetNestedCategories($shop_id, $root_category = null, $id_lang = false, $active = true, $groups = null, $use_shop_restriction = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
	{
		if (isset($root_category) && !Validate::isInt($root_category))
			die(Tools::displayError());

		if (!Validate::isBool($active))
			die(Tools::displayError());

		if (isset($groups) && Group::isFeatureActive() && !is_array($groups))
			$groups = (array)$groups;

			$result = Db::getInstance()->executeS('
							SELECT c.*, cl.*
				FROM `'._DB_PREFIX_.'category` c
				INNER JOIN `'._DB_PREFIX_.'category_shop` category_shop ON (category_shop.`id_category` = c.`id_category` AND category_shop.`id_shop` = "'.(int)$shop_id.'")
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category` AND cl.`id_shop` = "'.(int)$shop_id.'"
				WHERE 1 '.$sql_filter.' '.($id_lang ? 'AND `id_lang` = '.(int)$id_lang : '').'
				'.($active ? ' AND c.`active` = 1' : '').'
				'.(isset($groups) && Group::isFeatureActive() ? ' AND cg.`id_group` IN ('.implode(',', $groups).')' : '').'
				'.(!$id_lang || (isset($groups) && Group::isFeatureActive()) ? ' GROUP BY c.`id_category`' : '').'
				'.($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC').'
				'.($sql_sort == '' && $use_shop_restriction ? ', category_shop.`position` ASC' : '').'
				'.($sql_limit != '' ? $sql_limit : '')
			);

			$categories = array();
			$buff = array();

			if (!isset($root_category))
				$root_category = 1;

			foreach ($result as $row)
			{
				$current = &$buff[$row['id_category']];
				$current = $row;

				if ($row['id_category'] == $root_category)
					$categories[$row['id_category']] = &$current;
				else
					$buff[$row['id_parent']]['children'][$row['id_category']] = &$current;
			}

		return $categories;
	}

		private function generateCategoriesOption2($categories, $frontend)
	{
		$return_categories = array();

		foreach ($categories as $key => $category)
		{
				$shop = (object) Shop::getShop((int)$category['id_shop']);

				$return_categories[$key]['id'] =  (int)$category['id_category'];
				$return_categories[$key]['name'] = (!$frontend ? str_repeat('&nbsp;', $this->spacer_size * (int)$category['level_depth']) : '').$category['name'].' ('.$shop->name.')';
			
			if (isset($category['children']) && !empty($category['children']))
				$return_categories[$key]['children'] = $this->generateCategoriesOption2($category['children'], $frontend);
		}

		return $return_categories;
	}

	public function buildSubmenuTree(array $dataset, $frontend = false, $cssgenerator = false) 
	{
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

		$tree = array();
		foreach ($dataset as $id=>&$node) {
			if($cssgenerator)
			{

				//set style
				if(isset($node['content_s']['br_top_st']))
					$node['content_s']['br_top_st'] = $this->convertBorderType($node['content_s']['br_top_st']);

				if(isset($node['content_s']['br_right_st']))
					$node['content_s']['br_right_st'] = $this->convertBorderType($node['content_s']['br_right_st']);

				if(isset($node['content_s']['br_bottom_st']))
					$node['content_s']['br_bottom_st'] = $this->convertBorderType($node['content_s']['br_bottom_st']);

				if(isset($node['content_s']['br_left_st']))
					$node['content_s']['br_left_st'] = $this->convertBorderType($node['content_s']['br_left_st']);

			}
			if($frontend)
			{
				

				if(isset($node['content_s']['title'][$id_lang]) && $node['content_s']['title'][$id_lang]!='')
					$node['content_s']['title'] = $node['content_s']['title'][$id_lang];
				elseif(isset($node['content_s']['title'][$id_lang_default]) && $node['content_s']['title'][$id_lang_default]!='')
					$node['content_s']['title'] = $node['content_s']['title'][$id_lang_default];
				else
					unset($node['content_s']['title']);

				if(isset($node['content_s']['href'][$id_lang]) && $node['content_s']['href'][$id_lang]!='')
					$node['content_s']['href'] = $node['content_s']['href'][$id_lang];
				elseif(isset($node['content_s']['href'][$id_lang_default]) && $node['content_s']['href'][$id_lang_default]!='')
					$node['content_s']['href'] = $node['content_s']['href'][$id_lang_default];
				else
					unset($node['content_s']['href']);


				if(isset($node['content_s']['legend'][$id_lang]) && $node['content_s']['legend'][$id_lang]!='')
					$node['content_s']['legend'] = $node['content_s']['legend'][$id_lang];
				elseif(isset($node['content_s']['legend'][$id_lang_default]) && $node['content_s']['legend'][$id_lang_default]!='')
					$node['content_s']['legend'] = $node['content_s']['legend'][$id_lang_default];
				else
					unset($node['content_s']['legend']);

				if(isset($node['tabtitle'][$id_lang]) && $node['tabtitle'][$id_lang]!='')
					$node['tabtitle'] = $node['tabtitle'][$id_lang];
				elseif(isset($node['tabtitle'][$id_lang_default]) && $node['tabtitle'][$id_lang_default]!='')
					$node['tabtitle'] = $node['tabtitle'][$id_lang_default];
				else
					unset($node['tabtitle']);


			//set variouse links
				if(isset($node['contentType'])){


					switch ($node['contentType']) {
						case 1:
						if(isset($node['content']['ids']))
						{	
							$customhtml = new IqitCreatorHtml((int)$node['content']['ids'], $id_lang);

							if (Validate::isLoadedObject($customhtml))
							{
								$node['content']['ids'] = $customhtml->html;
							}
						}	
						break;
						case 4:

						if(isset($node['content']['ids']) && !empty($node['content']['ids'])){
							$node['content']['products'] = Product::getProductsProperties($id_lang, $this->getProducts($node['content']['ids']));
							$products = $node['content']['products'];

							$this->addColorsToProductList($node['content']['products']);

							$node['content']['productsimg'] = array();

							if($node['content']['view'] == 1 || $node['content']['view'] == 3)
							{
								$node['content']['line_lg'] = $this->convertGridSizeValue($node['content']['line_lg']);
								$node['content']['line_md'] = $this->convertGridSizeValue($node['content']['line_md']);
								$node['content']['line_sm'] = $this->convertGridSizeValue($node['content']['line_sm']);
								$node['content']['line_ms'] = $this->convertGridSizeValue($node['content']['line_ms']);
								$node['content']['line_xs'] = $this->convertGridSizeValue($node['content']['line_xs']);
							}

						}

						break;
						case 2:
						if(isset($node['content']['ids']))
						{	
							
							
							if($node['content']['ids'] == 'n')
							{
								if($node['content']['o'] == 1)
									$products = Product::getNewProducts($id_lang, 0, (int)$node['content']['limit']);
								else
									$products = Product::getNewProducts($id_lang, 0, (int)$node['content']['limit'], false, $node['content']['o'], $node['content']['ob']);
							}
							elseif($node['content']['ids'] == 's')
							{
								if($node['content']['o'] == 1)
									$products = Product::getPricesDrop($id_lang, 0, (int)$node['content']['limit']);
								else
									$products = Product::getPricesDrop($id_lang, 0, (int)$node['content']['limit'], false, $node['content']['o'], $node['content']['ob']);
							}
							elseif($node['content']['ids'] == 'b')
							{
								$products = ProductSale::getBestSales($id_lang, 0, (int)$node['content']['limit'], 'sales');
							}
							else
							{
								$category = new Category((int)$node['content']['ids'], $id_lang);
								if($node['content']['o'] == 1)
									$products = $category->getProducts($id_lang, 1, (int)$node['content']['limit'], null, null, false, true, true, (int)$node['content']['limit']);
								else
									$products = $category->getProducts($id_lang, 1, (int)$node['content']['limit'], $node['content']['o'], $node['content']['ob']);
							}
		
							$node['content']['products'] = $products;

							$this->addColorsToProductList($node['content']['products']);

							$node['content']['productsimg'] = array();
							
							if($node['content']['view'] == 1 || $node['content']['view'] == 3)
							{
								$node['content']['line_lg'] = $this->convertGridSizeValue($node['content']['line_lg']);
								$node['content']['line_md'] = $this->convertGridSizeValue($node['content']['line_md']);
								$node['content']['line_sm'] = $this->convertGridSizeValue($node['content']['line_sm']);
								$node['content']['line_ms'] = $this->convertGridSizeValue($node['content']['line_ms']);
								$node['content']['line_xs'] = $this->convertGridSizeValue($node['content']['line_xs']);
							}
						}
						break;
						case 6:
						if(isset($node['content']['source'][$id_lang]) && $node['content']['source'][$id_lang]!='')
							$node['content']['source'] = $node['content']['source'][$id_lang];
						elseif(isset($node['content']['source'][$id_lang_default]) && $node['content']['source'][$id_lang_default]!='')
							$node['content']['source'] = $node['content']['source'][$id_lang_default];
						else
							unset($node['content']['source']);

						if(isset($node['content']['href'][$id_lang]) && $node['content']['href'][$id_lang]!='')
							$node['content']['href'] = $node['content']['href'][$id_lang];
						elseif(isset($node['content']['href'][$id_lang_default]) && $node['content']['href'][$id_lang_default]!='')
							$node['content']['href'] = $node['content']['href'][$id_lang_default];
						else
							unset($node['content']['href']);

						break;
						case 7:
						if($node['content']['view'])
						{
							$node['content']['line_lg'] = $this->convertGridSizeValue($node['content']['line_lg']);
							$node['content']['line_md'] = $this->convertGridSizeValue($node['content']['line_md']);
							$node['content']['line_sm'] = $this->convertGridSizeValue($node['content']['line_sm']);
							$node['content']['line_ms'] = $this->convertGridSizeValue($node['content']['line_ms']);
							$node['content']['line_xs'] = $this->convertGridSizeValue($node['content']['line_xs']);
						}
						if (isset($node['content']['ids'][0]) && ($node['content']['ids'][0] == 0))
							$node['content']['manu'] = Manufacturer::getManufacturers(false, $this->context->language->id, true, false, false, false);
						break;
						case 9:
							$node['content']['module'] = $this->execModuleHook($node['content']['hook'], array(), $node['content']['id_module'], $id_shop);
						break;
					}

				}

			}

			if(!$frontend){
				if(isset($node['contentType']) && $node['contentType'] == 4 ){
					if(isset($node['content']['ids']) && !empty($node['content']['ids']))
						$node['content']['ids'] = $this->getProducts($node['content']['ids']);
				}
			}


				
			

	
			if ($node['parentId'] === 0) {
				$tree[$id] = &$node;
			} else {
				if (!isset($dataset[$node['parentId']]['children'])) 
					$dataset[$node['parentId']]['children'] = array();
				$dataset[$node['parentId']]['children'][$id] = &$node;
			}
			
		}
		

		$tree = $this->sortArrayTree($tree);
		return $tree;
	}
	
	public function sortArrayTree($passedTree)
	{
		usort($passedTree,array($this, 'sortByPosition'));

		foreach ($passedTree as $key => $subtree) {

			if( !empty( $subtree['children'] ) )
			{	
				$passedTree[$key]['children'] = $this->sortArrayTree($subtree['children']);
				
			}
		}	
		
		return $passedTree;
	}

	public function sortByPosition($a, $b) 
	{
		return $a['position'] - $b['position'];
	}

	public function convertGridSizeValue($value) 
	{
		switch ($value) {
			case 1:
			return 12;
			break;
			case 2:
			return 6;
			break;
			case 15:
			return 5;
			break;
			case 3:
			return 4;
			break;
			case 4:
			return 3;
			break;
			case 6:
			return 2;
			break;
			case 12:
			return 1;
			break;
		}
	}

	 public function getAvailableModules()
    {	
    	$id_shop = (int)Context::getContext()->shop->id;
    	$usableHooks = array('home', 'topcolumn', 'rightcolumn', 'leftcolumn', 'IqitContentCreator');

        $excludeModules = array('ratingsproductlist', 'themeeditor', 'ph_simpleblog', 'themeinstallator', 'pluginadder', 
        'pscleaner', 'revsliderprestashop', 'sekeywords','sendtoafriend', 'slidetopcontent', 'themeconfigurator', 'themeinstallator', 'trackingfront', 'watermark', 'videostab', 'yotpo', 'blocklayered', 'blocklayered_mod',
        'additionalproductstabs', 'addthisplugin', 'autoupgrade','sendtoafriend', 'bankwire', 'blockcart', 'blockcurrencies', 'blockcustomerprivacy', 'blocklanguages', 'blocksearch', 'blocksearch_mod', 'blocksharefb', 'blocktopmenu',
        'blockuserinfo', 'blockmyaccountfooter', 'carriercompare', 'cashondelivery','cheque', 'cookielaw', 'cronjobs', 'themeinstallator', 'crossselling', 'crossselling_mod', 'customcontactpage', 'dashactivity', 'dashgoals', 'dashproducts',
        'dashtrends', 'dateofdelivery', 'feeder','followup', 'gamification', 'ganalytics', 'gapi', 'graphnvd3', 'gridhtml', 'gsitemap', 'headerlinks', 'iqitcontentcreator', 'iqitcountdown', 'iqitpopup', 'iqitproducttags','iqitsizeguide', 'loyalty', 'mailalerts', 'manufacturertab', 'newsletter', 'onboarding', 'pagesnotfound', 'paypal', 'productcomments', 'productscategory',
        'productsmanufacturer', 'productsnavpn', 'producttooltip','referralprogram', 'statsbestcategories', 'statsbestcustomers', 'statsbestmanufacturers', 'statsbestproducts', 'statsbestsuppliers', 'statsbestvouchers', 'statscarrier', 'statscatalog', 'statscheckup',
        'statsdata', 'statsequipment', 'statsforecast','statslive', 'statsnewsletter', 'statsorigin', 'statspersonalinfos', 'statsproduct', 'statsregistrations', 'statssales', 'statssalesqty', 'statssearch', 'statsstock',
        'statsvisits', 'themeconfigurator', 'uecookie', 'blockwishlist', 'facebookslide', 'blockfooterhtml', 'productpageadverts', 'productpaymentlogos', 'footercontent', 'manufactuterslider');

  		$modules = Db::getInstance()->executeS('
		SELECT m.id_module, m.name
		FROM `'._DB_PREFIX_.'module` m
		'.Shop::addSqlAssociation('module', 'm').'
	    WHERE m.`name` NOT IN (\'' . implode("','", $excludeModules) . '\') ');
		
  		$modulesHooks = array();
		 foreach ($modules as $key => $module)
		 {	
		 	 $moduleInstance = Module::getInstanceByName($module['name']);

		 	 if(Validate::isLoadedObject($moduleInstance))
		 	  {
		 	 $flag = false;
		 	 $modules[$key]['hooks'] = '';
		 	 foreach ($usableHooks  as $hook) {
		 	 		
  					if($moduleInstance->isHookableOn($hook))
  					{	
  						if($flag)
  							$modules[$key]['hooks'] .= ',';	
  						
  						$modules[$key]['hooks'] .= $hook;
  						
  						$flag = true;
  					}
  				}
  			if($flag)
  				$modulesHook[$module['id_module']] =  $modules[$key];
  			}
		 }
      	
        return $modulesHook;
    }


    public function execModuleHook($hook_name, $hook_args = array(), $id_module = null, $id_shop = null)
	{
		// Check arguments validity
		if (($id_module && !is_numeric($id_module)) || !Validate::isHookName($hook_name))
			return false;
		
		// Check if hook exists
		if (!$id_hook = Hook::getIdByName($hook_name))
			return false;

		// Store list of executed hooks on this page
		Hook::$executed_hooks[$id_hook] = $hook_name;

		$live_edit = false;
		$context = Context::getContext();
		if (!isset($hook_args['cookie']) || !$hook_args['cookie'])
			$hook_args['cookie'] = $context->cookie;
		if (!isset($hook_args['cart']) || !$hook_args['cart'])
			$hook_args['cart'] = $context->cart;

		$retro_hook_name = Hook::getRetroHookName($hook_name);

		// Look on modules list
		$altern = 0;
		$output = '';

		$different_shop = false;
		if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID())
		{
			$old_context_shop_id = $context->shop->getContextShopID();
			$old_context = $context->shop->getContext();
			$old_shop = clone $context->shop;
			$shop = new Shop((int)$id_shop);
			if (Validate::isLoadedObject($shop))
			{
				$context->shop = $shop;
				$context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
				$different_shop = true;
			}
		}

			if (!($moduleInstance = Module::getInstanceById($id_module)))
				return false;

			// Check which / if method is callable
			$hook_callable = is_callable(array($moduleInstance, 'hook'.$hook_name));
			$hook_retro_callable = is_callable(array($moduleInstance, 'hook'.$retro_hook_name));

			if (($hook_callable || $hook_retro_callable) && Module::preCall($moduleInstance->name))
			{
				$hook_args['altern'] = ++$altern;


				// Call hook method
				if ($hook_callable)
					$display = $moduleInstance->{'hook'.$hook_name}($hook_args);
				elseif ($hook_retro_callable)
					$display = $moduleInstance->{'hook'.$retro_hook_name}($hook_args);
	
					$output .= $display;
			}
		

		if ($different_shop)
		{
			$context->shop = $old_shop;
			$context->shop->setContext($old_context, $shop->id);
		}

		return $output;
	}

	public function getProducts($ids)
	{		
	
			if(!isset($ids) || empty($ids))
				return;
			
			if(is_array($ids))
				$product_ids = join(',', $ids);
			else
				$product_ids = $ids;

			if (Group::isFeatureActive())
				{
					$sql_groups_join = '
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = product_shop.id_category_default
						AND cp.id_product = product_shop.id_product)
					LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.`id_category` = cg.`id_category`)';
					$groups = FrontController::getCurrentCustomerGroups();
					$sql_groups_where = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '='.(int)Group::getCurrent()->id);
				}

				$selected_products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
					SELECT DISTINCT p.id_product, pl.name, pl.link_rewrite, p.reference, i.id_image, m.`name` AS manufacturer_name, product_shop.show_price, product_shop.`id_category_default`, 
						cl.link_rewrite category, p.ean13, stock.out_of_stock, p.available_for_order, p.customizable, IFNULL(stock.quantity, 0) as quantity,
						product_shop.`unity`, product_shop.`unit_price_ratio`,
						DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
						DAY)) > 0 AS new
					FROM '._DB_PREFIX_.'product p
					'.Shop::addSqlAssociation('product', 'p').
					(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
					ON (p.`id_product` = pa.`id_product`)
					'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
					'.Product::sqlStock('p', 'product_attribute_shop', false, $this->context->shop) :  Product::sqlStock('p', 'product', false,
						$this->context->shop)).'
					LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (pl.id_product = p.id_product'.Shop::addSqlRestrictionOnLang('pl').')
					LEFT JOIN '._DB_PREFIX_.'category_lang cl ON (cl.id_category = product_shop.id_category_default'
						.Shop::addSqlRestrictionOnLang('cl').')
					LEFT JOIN '._DB_PREFIX_.'image i ON (i.id_product = p.id_product AND i.cover = 1)
					'.(Group::isFeatureActive() ? $sql_groups_join : '').'
					WHERE p.id_product IN ('.$product_ids.')
					AND pl.id_lang = '.(int)$this->context->language->id.'
					AND cl.id_lang = '.(int)$this->context->language->id.'
					AND product_shop.active = 1
					'.(Group::isFeatureActive() ? $sql_groups_where : '').
					' ORDER BY FIELD(p.id_product, '.$product_ids.')'
					);



				$tax_calc = Product::getTaxCalculationMethod();
				$final_products_list = array();

				foreach ($selected_products as &$selected_product)
				{
					$usetax = false;
					$selected_product['id_product'] = (int)$selected_product['id_product'];
					$selected_product['image'] = $this->context->link->getImageLink($selected_product['link_rewrite'],
						(int)$selected_product['id_product'].'-'.(int)$selected_product['id_image'], ImageType::getFormatedName('home'));
					$selected_product['link'] = $this->context->link->getProductLink((int)$selected_product['id_product'], $selected_product['link_rewrite'],
						$selected_product['category'], $selected_product['ean13']);
					if (($tax_calc == 0 || $tax_calc == 2)){
						$usetax = true;
						$selected_product['displayed_price'] = Product::getPriceStatic((int)$selected_product['id_product'], true, null);
						}
					elseif ($tax_calc == 1)
						$selected_product['displayed_price'] = Product::getPriceStatic((int)$selected_product['id_product'], false, null);
					$selected_product['price_without_reduction'] = Product::getPriceStatic(
				(int)$selected_product['id_product'],
				$usetax,
				((isset($selected_product['id_product_attribute']) && !empty($selected_product['id_product_attribute'])) ? (int)$selected_product['id_product_attribute'] : null),
				6,
				null,
				false,
				false
			);

					$selected_product['reduction'] = Product::getPriceStatic(
			(int)$selected_product['id_product'],
			$usetax,
			((isset($selected_product['id_product_attribute']) && !empty($selected_product['id_product_attribute'])) ? (int)$selected_product['id_product_attribute'] : null),
			6,
			null,
			true,
			true,
			1,
			true,
			null,
			null,
			null,
			$specific_prices
		);
					$selected_product['allow_oosp'] = Product::isAvailableWhenOutOfStock((int)$selected_product['out_of_stock']);

					if (!isset($final_products_list[$selected_product['id_product'].'-'.$selected_product['id_image']]))
						$final_products_list[$selected_product['id_product'].'-'.$selected_product['id_image']] = $selected_product;
				}

				return $final_products_list;
	
	}

	public function addColorsToProductList(&$products)
	{
	if (!is_array($products) || !count($products) || !file_exists(_PS_THEME_DIR_.'product-list-colors.tpl'))
		return;

	$products_need_cache = array();
	foreach ($products as &$product)
		$products_need_cache[] = (int)$product['id_product'];

		unset($product);

		$colors = false;
		if (count($products_need_cache))
			$colors = Product::getAttributesColorList($products_need_cache);

		foreach ($products as &$product)
		{
			$tpl = $this->context->smarty->createTemplate(_PS_THEME_DIR_.'product-list-colors.tpl');
			if (isset($colors[$product['id_product']]))
				$tpl->assign(array(
					'id_product' => $product['id_product'],
					'colors_list' => $colors[$product['id_product']],
					'link' => Context::getContext()->link,
					'img_col_dir' => _THEME_COL_DIR_,
					'col_img_dir' => _PS_COL_IMG_DIR_
					));

			if (!in_array($product['id_product'], $products_need_cache) || isset($colors[$product['id_product']]))
				$product['color_list'] = $tpl->fetch(_PS_THEME_DIR_.'product-list-colors.tpl');
			else
				$product['color_list'] = '';
		}
	}

	protected function getColorsListCacheId($id_product)
	{
		return Product::getColorsListCacheId($id_product);
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

	public function getFrontEditorToken()
	{
		return Tools::getAdminToken($this->name.(int)Tab::getIdFromClassName($this->name)
			.(is_object(Context::getContext()->employee) ? (int)Context::getContext()->employee->id :
				Tools::getValue('id_employee')));
	}

	public function checkEnvironment()
	{
		$cookie = new Cookie('psAdmin', '', (int)Configuration::get('PS_COOKIE_LIFETIME_BO'));
		return isset($cookie->id_employee) && isset($cookie->passwd) && Employee::checkPassword($cookie->id_employee, $cookie->passwd);
	}

	public function ajaxProcessSearchProducts()
    {

    $query = Tools::getValue('q', false);
        if (!$query or $query == '' or Tools::strlen($query) < 1) {
            die();
        }
        if ($pos = strpos($query, ' (ref:')) {
            $query = Tools::substr($query, 0, $pos);
        }

        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }

        // Excluding downloadable products from packs because download from pack is not supported
        $excludeVirtuals = false;
        $exclude_packs = false;

        $context = Context::getContext();

        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
        FROM `' . _DB_PREFIX_ . 'product` p
        ' . Shop::addSqlAssociation('product', 'p') . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int) $context->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image` image
        ON (image.`id_product` = p.`id_product` AND image.cover=1)
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $context->language->id . ')
        WHERE (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\') AND p.`active` = 1' .
            (!empty($excludeIds) ? ' AND p.id_product NOT IN (' . $excludeIds . ') ' : ' ') .
            ($excludeVirtuals ? 'AND NOT EXISTS (SELECT 1 FROM `' . _DB_PREFIX_ . 'product_download` pd WHERE (pd.id_product = p.id_product))' : '') .
            ($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '') .
            ' GROUP BY p.id_product';

        $items = Db::getInstance()->executeS($sql);

        if ($items && ($excludeIds || strpos($_SERVER['HTTP_REFERER'], 'AdminScenes') !== false)) {
            foreach ($items as $item) {
                echo trim($item['name']) . (!empty($item['reference']) ? ' (ref: ' . $item['reference'] . ')' : '') . '|' . (int) ($item['id_product']) . "\n";
            }
        } elseif ($items) {
            // packs
            $results = array();
            foreach ($items as $item) {
                // check if product have combination

                $product = array(
                    'id' => (int) ($item['id_product']),
                    'name' => $item['name'],
                    'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                    'image' => str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $item['id_image'], ImageType::getFormatedName('medium'))),
                );
                array_push($results, $product);
            }
            $results = array_values($results);
            echo Tools::jsonEncode($results);
        } else {
            Tools::jsonEncode(new stdClass);
        }
    }


	public function hookActionObjectCategoryAddAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectCategoryUpdateAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectCategoryDeleteAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectCmsUpdateAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectCmsDeleteAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectCmsAddAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectSupplierUpdateAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectSupplierDeleteAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectSupplierAddAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectManufacturerUpdateAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectManufacturerDeleteAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectManufacturerAddAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectProductUpdateAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectProductDeleteAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookActionObjectProductAddAfter($params)
    {
        $this->clearCreatorCache();
    }

    public function hookCategoryUpdate($params)
    {
        $this->clearCreatorCache();
    }

    public function clearCreatorCache($force_cache = false)
    {	
    	if ($force_cache || Configuration::get($this->config_name.'_auto_cache'))
			$this->_clearCache('*');
    }

}
