<?php
/*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */

class IqitcontentcreatorEditorModuleFrontController extends ModuleFrontController
{

	public function __construct()
	{	
		parent::__construct();
		$this->context = Context::getContext();

		 $this->ssl = true;
		 $useSSL = $this->ssl;
		
		$columns = Context::getContext()->theme->hasColumns('index');
		$this->display_column_left = $columns['left_column']; 
		$this->display_column_right = $columns['right_column']; 


		include_once($this->module->getLocalPath().'iqitcontentcreator.php');
		
	}

	 public function initContent()
    {
        
    if (Tools::getValue('iqit_fronteditor_token') && Tools::getValue('iqit_fronteditor_token') == $this->module->getFrontEditorToken() && Tools::getIsset('id_employee') && $this->module->checkEnvironment()){
        
        parent::initContent();

  		$content = Configuration::get($this->module->config_name.'_content');

		$content_format = array();
		$content_front = array();

		$admin_link = _PS_BASE_URL_.__PS_BASE_URI__.Tools::getValue('admin_webpath').'/';


		if($content)
		{
			$content_format = $this->module->buildSubmenuTree(json_decode($content, true), false);
			$content_front =  $this->module->buildSubmenuTree(json_decode($content, true), true);
		}
		
		$languages = Language::getLanguages();
		foreach ($languages as $k => $language) {
            $languages[$k]['is_default'] = (int)($language['id_lang'] == $this->context->language->id);
        }

        	$imagesTypes = ImageType::getImagesTypes('products');
		$images = array();

		foreach ($imagesTypes as $image) {
			$images[$image['name']] = Image::getSize($image['name']);
			$images[$image['name']]['name'] = $image['name'];
		}
		
		$this->context->smarty->assign(array(
			'submenu_content' => htmlentities($content, ENT_COMPAT, 'UTF-8'),
			'submenu_content_format' => $content_format,
			'content_front' => $content_front,
			'defaultFormLanguage' => $this->context->language->id,
			'languages' => $languages,
			'admin_link' => $admin_link,
			'manufacturerSize' => Image::getSize('mf_image'),
			'images_types' => $images,
			'manufacturers_select' => $this->module->renderManufacturersSelect(),
			'custom_html_select' => $this->module->renderCustomHtmlSelect(),
			'available_modules' => $this->module->getAvailableModules(),
			'categories_select' => $this->module->renderCategoriesSelect(false),
			'id_language' => $this->context->language->id
		));

	Media::addJsDef(array('admin_fronteditor_ajax_urlf' => $admin_link)); 
	Media::addJsDef(array('search_url_editor' => $this->context->link->getPageLink('search', Tools::usingSecureMode())));

  	$this->setTemplate('fronteditor.tpl');
  	}
  	else
  		Tools::redirect('index.php'); 

    }

     public function setMedia()
    {
        parent::setMedia(); 

        $this->context->controller->addJS($this->module->getLocalPath().'js/back.js');
		$this->context->controller->addCSS($this->module->getLocalPath().'css/back.css');


		$this->context->controller->addJS($this->module->getLocalPath().'js/fontawesome-iconpicker.min.js');
		$this->context->controller->addCSS($this->module->getLocalPath().'css/fontawesome-iconpicker.min.css');

		$this->context->controller->addJS($this->module->getLocalPath().'js/spectrum.js');
		$this->context->controller->addCSS($this->module->getLocalPath().'css/spectrum.css');

		$this->context->controller->addCSS($this->module->getLocalPath().'css/fronteditor.css');
		$this->context->controller->addJS($this->module->getLocalPath().'js/fronteditor.js');
		
		Media::addJsDef(array('iqit_frontcreator' => true));	
		$this->context->controller->addJqueryUI('ui.sortable');
		$this->context->controller->addJqueryPlugin('autocomplete');
		$this->context->controller->addJqueryPlugin('fancybox');

		$this->module->putAssetsFiles();
    }
   



}
