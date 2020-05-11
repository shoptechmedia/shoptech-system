<?php
/**
 * 2007-2016 PrestaShop
 *
 * thirty bees is an extension to the PrestaShop e-commerce software developed by PrestaShop SA
 * Copyright (C) 2017-2018 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.thirtybees.com for more information.
 *
 * @author    thirty bees <contact@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2017-2018 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  PrestaShop is an internationally registered trademark & property of PrestaShop SA
 */
/**
 * Class AdminNewsletterControllerCore
 *
 * @since 1.0.0
 */
class AdminNewsletterControllerCore extends AdminController
{

    public $name = 'newsletter';
    public $displayName = 'Current Contacts Registered in the Newsletter System';

    public $filters = [];
    /**
     * AdminNewsletterControllerCore constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';

        parent::__construct();
    }

    /**
     * @return array
     *
     * @since 1.0.0
     */
    protected function getOptionFields()
    {
        
    }

    /**
     * @since 1.0.0
     */
    public function setMedia()
    {
        parent::setMedia();

        $this->addJqueryUI('ui.datepicker');
        $this->addJS(
            [
                _PS_JS_DIR_.'vendor/d3.v3.min.js',
                __PS_BASE_URI__.$this->admin_webpath.'/themes/'.$this->bo_theme.'/js/vendor/nv.d3.min.js',
                _PS_JS_DIR_.'/admin/newsletter.js',
            ]
        );
        $this->addCSS(__PS_BASE_URI__.$this->admin_webpath.'/themes/'.$this->bo_theme.'/css/vendor/nv.d3.css');
    }

    /**
     * @since 1.0.0
     */
    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_title = $this->l('Newsletter');
        /*$this->page_header_toolbar_btn['switch_demo'] = [
            'desc' => $this->l('Demo mode', null, null, false),
            'icon' => 'process-icon-toggle-'.(Configuration::get('PS_DASHBOARD_SIMULATION') ? 'on' : 'off'),
            'help' => $this->l('This mode displays sample data so you can try your dashboard without real numbers.', null, null, false),
        ];*/

        parent::initPageHeaderToolbar();

        // Remove the last element on this controller to match the title with the rule of the others
        array_pop($this->meta_title);
    }

    public function DisplayList($data) {
        $fields_list = array(
            'id_customer' => array(
                'title' => $this->l('ID'),
                'width' => 40,
                'type' => 'text',
            ),
            'firstname' => array(
                'title' => $this->l('First Name'),
                'width' => 140,
                'type' => 'text',
            ),
            'lastname' => array(
                'title' => $this->l('Last Name'),
                'width' => 140,
                'type' => 'text',
            ),
            'email' => array(
                'title' => $this->l('Email'),
                'width' => 140,
                'type' => 'text',
            ),
        );
        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_customer';
        $helper->actions = array('edit', 'view');
        $helper->show_toolbar = false;
        $helper->title = $this->displayName;
        $helper->table = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminNewsletter');
        $helper->currentIndex = AdminController::$currentIndex;
        return $helper->generateList($data, $fields_list);
    }

    public function renderView()
    {
        $api = new Newsletter();
        $this->context->smarty->assign(
            [
            ]
        );
        if (Tools::getValue('render') === 'contacts') {
            $prepare = $api->getContactLists(null, 1, Tools::getValue('configurationOrderby'),Tools::getValue('configurationOrderway'), $this->filters);
            return $this->DisplayList($prepare);
        } else {
            return $this->createTemplate('controllers/newsletter/form.tpl')->fetch();
        }
         
    }

    /**
     * @since 1.0.0
     */
    public function postProcess()
    {
        if (Tools::isSubmit('submitFilternewsletter')){
            $this->filters['newsletterFilter_id_customer'] = Tools::getValue('newsletterFilter_id_customer');
            $this->filters['newsletterFilter_firstname'] = Tools::getValue('newsletterFilter_firstname');
            $this->filters['newsletterFilter_lastname'] = Tools::getValue('newsletterFilter_lastname');
            $this->filters['newsletterFilter_email'] = Tools::getValue('newsletterFilter_email');
        }

        if (Tools::isSubmit('submitResetnewsletter')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminNewsletter'));
        }
        parent::postProcess();
    }
}
