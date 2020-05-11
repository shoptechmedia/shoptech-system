<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @property Product $object
 */
class AdminProductsController extends AdminProductsControllerCore
{
	/**
	 * postProcess handle every checks before saving products information
	 *
	 * @return void
	 */
	public function postProcess()
	{
		if (!$this->redirect_after)
			parent::postProcess();

		if ($this->display == 'edit' || $this->display == 'add'){
	        if(file_exists(_PS_MODULE_DIR_ . '/n45xspeed/overwrite/AdminProductsController.php')){
	            include_once(_PS_MODULE_DIR_ . '/n45xspeed/overwrite/AdminProductsController.php');
	        }

			$this->addJqueryUI(array(
				'ui.core',
				'ui.widget'
			));

			$this->addjQueryPlugin(array(
				'autocomplete',
				'tablednd',
				'thickbox',
				'ajaxfileupload',
				'date',
				'tagify',
				'select2',
				'validate'
			));

			$this->addJS(array(
				_PS_JS_DIR_.'admin/products.js',
				_PS_JS_DIR_.'admin/attributes.js',
				_PS_JS_DIR_.'admin/price.js',
				_PS_JS_DIR_.'tiny_mce/tiny_mce.js',
				_PS_JS_DIR_.'admin/tinymce.inc.js',
				_PS_JS_DIR_.'admin/dnd.js',
				_PS_JS_DIR_.'jquery/ui/jquery.ui.progressbar.min.js',
				_PS_JS_DIR_.'vendor/spin.js',
				_PS_JS_DIR_.'vendor/ladda.js'
			));

			$this->addJS(_PS_JS_DIR_.'jquery/plugins/select2/select2_locale_'.$this->context->language->iso_code.'.js');
			$this->addJS(_PS_JS_DIR_.'jquery/plugins/validate/localization/messages_'.$this->context->language->iso_code.'.js');

			$this->addCSS(array(
				_PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.css'
			));
		}
	}
}
