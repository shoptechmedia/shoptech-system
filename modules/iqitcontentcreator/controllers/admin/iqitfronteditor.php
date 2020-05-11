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
class IqitFronteditorController extends ModuleAdminController
{

	public function __construct()
	{	
    $this->bootstrap = true;
    //$this->tpl_folder = 'iqitcontentcreator';

    $this->context = Context::getContext();
    $this->module = 'iqitcontentcreator'; 
    parent::__construct();
  }

  public function initContent()
  {
    //$this->setTemplate('feditorbackend.tpl');
    parent::initContent();
    
    $fronteditorlink = $this->context->link->getModuleLink('iqitcontentcreator','Editor', array(
        'iqit_fronteditor_token' => $this->module->getFrontEditorToken(),
        'admin_webpath' => $this->context->controller->admin_webpath,
        'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
        Tools::getValue('id_employee')
        ), true);
    $module_link = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&token='.Tools::getAdminTokenLite('AdminModules').'&module_name='.$this->module->name;

    $toolbar = '  <div id="preloader">
  <div id="status">&nbsp;</div>
  </div><div id="fronteditor-toolbar" class="clearfix">
    <div class="toolbar-action">
    <a href="'.$module_link.'" class="btn btn-danger iqlogo">
      <i class="icon-angle-left"></i>  Back to backend
    </a>
      </div>
       <div class="toolbar-action">
   <button type="button" class="btn btn-default switch-guides-btn">Toggle guides</button>
      </div>
    <div class="toolbar-action pull-right">
    <button type="button" class="btn btn-success update-fronteditor-action" ><i class="icon icon-save"></i> Update</button>
    </div>
    <div class="toolbar-action pull-right"><button type="button" class="btn btn-default switch-front-view-btn" data-preview-type="preview-d" ><i class="icon-desktop"></i> </button></div>
    <div class="toolbar-action pull-right"><button type="button" class="btn btn-default switch-front-view-btn" data-preview-type="preview-t" ><i class="icon-tablet"></i> </button></div>
    <div class="toolbar-action pull-right"><button type="button" class="btn btn-default switch-front-view-btn" data-preview-type="preview-p" ><i class="icon-mobile"></i> </button></div>
    <div class="toolbar-action pull-right">View</div>
  </div>';


    $content = $toolbar.'<iframe id="ffpreview" name="ffpreview" height="100%" width="100%" src="'.$fronteditorlink.'"> </iframe>';

    $this->context->smarty->assign(array(
        'content' => $content,
    ));
  }

  public function setMedia()
  {
    parent::setMedia(); 
    Media::addJsDef(array('admin_fronteditor_ajax_url' => $this->context->link->getAdminLink('IqitFronteditor'))); 
    $this->addCSS(array(
      _MODULE_DIR_.'iqitcontentcreator/css/bfronteditor.css',
      ));
     $this->addJS(array(
      _MODULE_DIR_.'iqitcontentcreator/js/bfronteditor.js',
      ));
  }

  public function ajaxProcessSaveEditor()
  { 
    Configuration::updateValue($this->module->config_name.'_content', urldecode(Tools::getValue('submenu_elements')));
    $this->module->generateCss();
  }







}
