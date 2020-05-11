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

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once _PS_MODULE_DIR_ . 'iqitsizeguide/models/SizeGuideIqit.php';

class IqitSizeGuide extends Module
{
    protected $config_form = false;
    private $_html = '';

    public function __construct()
    {
        $this->name = 'iqitsizeguide';
        $this->tab = 'front_office_features';
        $this->version = '1.0.3';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->need_instance = 0;
        $this->module_key = '';

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Size guide chart');
        $this->description = $this->l('Show popup with size guide ');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

        $this->config_name = 'IQITSIZEGUIDE';
        $this->defaults = array(
            'width' => 850,
            'height' => 550,
            'hook' => 0,
            'productl_size' => 0,
            'attribute_size' => 0,
            'sh_measure' => 1,
            'sh_global' => 0,
            'content' => 'Content of newsletter popup',
            'global' => 'Content of newsletter popup',
        );
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        if (parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayProductButtons') &&
            $this->registerHook('displayAdminProductsExtra') &&
            $this->registerHook('actionProductUpdate') &&
            $this->registerHook('actionAdminProductsControllerSaveAfter') &&
            $this->registerHook('actionProductDelete') &&
            $this->registerHook('actionUpdateQuantity') &&
            $this->registerHook('displayProductAttributesPL') &&
            $this->registerHook('displayProductSizeGuide') &&
            $this->registerHook('actionValidateOrder') &&
            $this->registerHook('extraLeft') &&
            $this->registerHook('extraRight') &&
            $this->createTables()) {

            $this->setDefaults();
            $this->generateCss();
            return true;
        } else {
            return false;
        }

    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->config_name . '_' . $default);
        }

        return parent::uninstall() && $this->deleteTables();
    }

    /**
     * Creates tables
     */
    protected function createTables()
    {
        /* guides */
        $res = (bool) Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitsizeguide` (
				`id_iqitsizeguide_guides` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_iqitsizeguide_guides`, `id_shop`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');

        /* guides configuration */
        $res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitsizeguide_guides` (
			  `id_iqitsizeguide_guides` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
			  PRIMARY KEY (`id_iqitsizeguide_guides`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');

        /* guides lang configuration */
        $res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitsizeguide_guides_lang` (
			  `id_iqitsizeguide_guides` int(10) unsigned NOT NULL,
			  `id_lang` int(10) unsigned NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  PRIMARY KEY (`id_iqitsizeguide_guides`,`id_lang`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');

        /* guides product association */
        $res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitsizeguide_product` (
				`id_product` int(10) unsigned NOT NULL,
				`id_guide` int(10) unsigned NOT NULL,
				 PRIMARY KEY (`id_product`)
				) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');

        return $res;
    }

    /**
     * deletes tables
     */
    protected function deleteTables()
    {
        $guides = $this->getGuides();
        foreach ($guides as $guide) {
            $to_del = new SizeGuideIqit($guide['id_guide']);
            $to_del->delete();
        }

        return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'iqitsizeguide`, `' . _DB_PREFIX_ . 'iqitsizeguide_guides`, `' . _DB_PREFIX_ . 'iqitsizeguide_product`, `' . _DB_PREFIX_ . 'iqitsizeguide_guides_lang`;
		');
    }

    public function setDefaults()
    {
        foreach ($this->defaults as $default => $value) {
            if ($default == 'content') {
                $message_trads = array();
                foreach (Language::getLanguages(false) as $lang) {
                    $message_trads[(int) $lang['id_lang']] = '<div class="row clearfix">
<div class="col-xs-12 col-sm-6"><img src="http://placehold.it/350x400" alt="" /></div>
<div class="col-xs-12 col-sm-6">
<h4>Measure this way</h4>
<p>Create some text guide how to measure. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus iaculis eget lectus sit amet venenatis. Nullam sem lorem, egestas eget metus a, consequat sagittis dui. Curabitur risus justo, cursus id metus vitae, efficitur scelerisque metus. Praesent est risus, eleifend in laoreet id</p>
<p>Create some text guide how to measure. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus iaculis eget lectus sit amet venenatis. Nullam sem lorem, egestas eget metus a, consequat sagittis dui. Curabitur risus justo, cursus id metus vitae, efficitur scelerisque metus. Praesent est risus, eleifend in laoreet id</p>
</div>
</div>
<div class="row clearfix" style="border-top: 1px solid #cecece; margin-top: 20px; padding-top: 20px;">
<div class="col-xs-12 col-sm-6"><img src="http://placehold.it/350x200" alt="" /></div>
<div class="col-xs-12 col-sm-6">
<h4>Measure this way</h4>
<p>Create some text guide how to measure. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus iaculis eget lectus sit amet venenatis. Nullam sem lorem, egestas eget metus a, consequat sagittis dui. Curabitur risus justo, cursus id metus vitae, efficitur scelerisque metus. Praesent est risus, eleifend in laoreet id</p>
</div>
</div>';
                }

                Configuration::updateValue($this->config_name . '_' . $default, $message_trads, true);
            } elseif ($default == 'global') {
                $message_trads = array();
                foreach (Language::getLanguages(false) as $lang) {
                    $message_trads[(int) $lang['id_lang']] = 'size guide visible to all products';
                }

                Configuration::updateValue($this->config_name . '_' . $default, $message_trads, true);
            } else {
                Configuration::updateValue($this->config_name . '_' . $default, $value);
            }

        }
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $this->context->controller->addJS($this->_path . 'js/back.js');
        $this->context->controller->addCSS($this->_path . 'css/back.css');

        if (Tools::isSubmit('submitGuide') || Tools::isSubmit('delete_id_guide')) {
            if ($this->_postValidation()) {
                $this->_postProcess();
                $this->_html .= $this->renderForm();
                $this->_html .= $this->renderList();
            } else {
                $this->_html .= $this->renderAddForm();
            }

        } elseif (Tools::isSubmit('addGuide') || (Tools::isSubmit('id_guide') && $this->guideExists((int) Tools::getValue('id_guide')))) {
            return $this->renderAddForm();
        } elseif (Tools::isSubmit('submitiqitsizeguideModule')) {
            $this->_postProcess2();

            $this->context->smarty->assign('module_dir', $this->_path);
            $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');

            $this->_html .= $output . $this->renderForm() . $this->renderList();
        } else {

            $this->context->smarty->assign('module_dir', $this->_path);
            $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');

            $this->_html .= $output . $this->renderForm() . $this->renderList();
        }
        return $this->_html;
    }

    private function _postValidation()
    {
        $errors = array();

        /* Validation for guide */
        if (Tools::isSubmit('submitGuide')) {
            /* If edit : checks id_guide */
            if (Tools::isSubmit('id_guide')) {
                if (!Validate::isInt(Tools::getValue('id_guide')) && !$this->guideExists(Tools::getValue('id_guide'))) {
                    $errors[] = $this->l('Invalid id_guide');
                }

            }
            /* Checks title/description/*/
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                if (Tools::strlen(Tools::getValue('title_' . $language['id_lang'])) > 255) {
                    $errors[] = $this->l('The title is too long.');
                }

            }

            /* Checks title/description for default lang */
            $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
            if (Tools::strlen(Tools::getValue('title_' . $id_lang_default)) == 0) {
                $errors[] = $this->l('The title is not set.');
            }

        }
        /* Validation for deletion */
        elseif (Tools::isSubmit('delete_id_guide') && (!Validate::isInt(Tools::getValue('delete_id_guide')) || !$this->guideExists((int) Tools::getValue('delete_id_guide')))) {
            $errors[] = $this->l('Invalid id_guide');
        }

        /* Display errors if needed */
        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));

            return false;
        }

        /* Returns if validation is ok */

        return true;
    }

    private function _postProcess()
    {
        $errors = array();

        /* Processes guide */
        if (Tools::isSubmit('submitGuide')) {
            /* Sets ID if needed */
            if (Tools::getValue('id_guide')) {
                $guide = new SizeGuideIqit((int) Tools::getValue('id_guide'));
                if (!Validate::isLoadedObject($guide)) {
                    $this->_html .= $this->displayError($this->l('Invalid id_guide'));

                    return false;
                }
            } else {
                $guide = new SizeGuideIqit();
            }

            $guide->active = 1;

            /* Sets each langue fields */
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                $guide->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
                $guide->description[$language['id_lang']] = Tools::getValue('description_' . $language['id_lang']);

            }

            /* Processes if no errors  */
            if (!$errors) {
                /* Adds */
                if (!Tools::getValue('id_guide')) {
                    if (!$guide->add()) {
                        $errors[] = $this->displayError($this->l('The guide could not be added.'));
                    }

                }
                /* Update */
                elseif (!$guide->update()) {
                    $errors[] = $this->displayError($this->l('The guide could not be updated.'));
                }

                $this->clearCache();
            }
        } /* Deletes */
        elseif (Tools::isSubmit('delete_id_guide')) {
            $guide = new SizeGuideIqit((int) Tools::getValue('delete_id_guide'));
            $res = $guide->delete();
            $this->clearCache();
            if (!$res) {
                $this->_html .= $this->displayError('Could not delete.');
            } else {
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=1&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
            }

        }

        /* Display errors if needed */
        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
        } elseif (Tools::isSubmit('submitGuide') && Tools::getValue('id_guide')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
        } elseif (Tools::isSubmit('submitGuide')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=3&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
        }

    }

    public function renderList()
    {
        $guides = $this->getGuides();

        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'guides' => $guides,
            )
        );

        return $this->display(__FILE__, 'list.tpl');
    }

    public function renderAddForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Guide informations'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                    ),

                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'table_creator',
                        'label' => $this->l('Generate table and add to editor'),
                        'name' => 'table_creator',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        if (Tools::isSubmit('id_guide') && $this->guideExists((int) Tools::getValue('id_guide'))) {
            $guide = new SizeGuideIqit((int) Tools::getValue('id_guide'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_guide');
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitGuide';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code,
            ),
            'fields_value' => $this->getAddFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'module_path' => $this->_path,
            'image_baseurl' => $this->_path . 'images/',
        );

        $helper->override_folder = '/';

        return $helper->generateForm(array($fields_form));
    }

    public function getGuides($active = null)
    {
        $this->context = Context::getContext();
        $id_shop = $this->context->shop->id;
        $id_lang = $this->context->language->id;

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_iqitsizeguide_guides` as id_guide, hssl.`title`, hssl.`description`
			FROM ' . _DB_PREFIX_ . 'iqitsizeguide hs
			LEFT JOIN ' . _DB_PREFIX_ . 'iqitsizeguide_guides hss ON (hs.id_iqitsizeguide_guides = hss.id_iqitsizeguide_guides)
			LEFT JOIN ' . _DB_PREFIX_ . 'iqitsizeguide_guides_lang hssl ON (hss.id_iqitsizeguide_guides = hssl.id_iqitsizeguide_guides)
			WHERE id_shop = ' . (int) $id_shop . '
			AND hssl.id_lang = ' . (int) $id_lang
        );
    }

    public function getAddFieldsValues()
    {
        $fields = array();

        if (Tools::isSubmit('id_guide') && $this->guideExists((int) Tools::getValue('id_guide'))) {
            $guide = new SizeGuideIqit((int) Tools::getValue('id_guide'));
            $fields['id_guide'] = (int) Tools::getValue('id_guide', $guide->id);
        } else {
            $guide = new SizeGuideIqit();
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields['title'][$lang['id_lang']] = Tools::getValue('title_' . (int) $lang['id_lang'], $guide->title[$lang['id_lang']]);
            $fields['description'][$lang['id_lang']] = Tools::getValue('description_' . (int) $lang['id_lang'], $guide->description[$lang['id_lang']]);
        }

        return $fields;
    }

    public function guideExists($id_guide)
    {
        $req = 'SELECT hs.`id_iqitsizeguide_guides` as id_guide
				FROM `' . _DB_PREFIX_ . 'iqitsizeguide` hs
				WHERE hs.`id_iqitsizeguide_guides` = ' . (int) $id_guide;
        $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

        return ($row);
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitiqitsizeguideModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
        . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'module_path' => $this->_path,
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }
    public function getAttributes()
    {
        $attributes = AttributeGroup::getAttributesGroups($this->context->language->id);

        $selectAttributes = array();

        foreach ($attributes as $attribute) {
            $selectAttributes[$attribute['id_attribute_group']]['id_option'] = $attribute['id_attribute_group'];
            $selectAttributes[$attribute['id_attribute_group']]['name'] = $attribute['name'];
        }

        return $selectAttributes;
    }
    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {

        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Show avaiable size on product list'),
                        'name' => 'productl_size',
                        'desc' => $this->l('Enable or disable avaiable sizes on product list'),
                        'options' => array(
                            'query' => array(array(
                                'id_option' => 1,
                                'name' => $this->l('Show'),
                            ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('Do not show'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'attribute_checboxes',
                        'label' => $this->l('Select attribute which you consider as size'),
                        'name' => 'attribute_size',
                        'desc' => $this->l('You need to select attribute which is consider as size'),
                        'options' => array(
                            'query' => $this->getAttributes(),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),

                    array(
                        'type' => 'select',
                        'label' => $this->l('Hook'),
                        'name' => 'hook',
                        'desc' => $this->l('Note: If you want to use custom hook you have to add in product.tpl in place which you want to show it'),
                        'options' => array(
                            'query' => array(array(
                                'id_option' => 1,
                                'name' => $this->l('Custom Hook'),
                            ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('displayProductButtons'),
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('extraLeft'),
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->l('extraRight'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Width'),
                        'name' => 'width',
                        'suffix' => 'px',
                        'desc' => $this->l('Popup window width.'),
                        'size' => 20,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Height of main content'),
                        'name' => 'height',
                        'suffix' => 'px',
                        'desc' => $this->l('Popup window height.'),
                        'size' => 20,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show how to measure tab'),
                        'name' => 'sh_measure',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('How to measure tab'),
                        'name' => 'content',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 60,
                        'rows' => 30,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show global size guide'),
                        'name' => 'sh_global',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Global size guide'),
                        'name' => 'global',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 60,
                        'rows' => 30,
                    ),
                    array(
                        'type' => 'table_creator',
                        'label' => $this->l('Generate table and add to editor'),
                        'name' => 'table_creator',
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

        foreach ($this->defaults as $default => $value) {

            if ($default == 'content' || $default == 'global') {
                foreach (Language::getLanguages(false) as $lang) {
                    $var[$default][(int) $lang['id_lang']] = Configuration::get($this->config_name . '_' . $default, (int) $lang['id_lang']);
                }

            } elseif ($default == 'newval') {
                $var[$default] = 1;
            } elseif ($default == 'attribute_size') {
                $selected_sizes = $this->unserializeSizes(Configuration::get($this->config_name . '_' . $default));
                if (is_array($selected_sizes)) {
                    $var[$default] = $selected_sizes;
                } else {
                    $var[$default] = array();
                }

            } else {
                $var[$default] = Configuration::get($this->config_name . '_' . $default);
            }

        }
        return $var;

    }

    /**
     * Save form data.
     */
    protected function _postProcess2()
    {
        foreach ($this->defaults as $default => $value) {
            if ($default == 'content') {
                $message_trads = array();
                foreach ($_POST as $key => $value) {
                    if (preg_match('/content_/i', $key)) {
                        $id_lang = preg_split('/content_/i', $key);
                        $message_trads[(int) $id_lang[1]] = $value;
                    }
                }

                Configuration::updateValue($this->config_name . '_' . $default, $message_trads, true);
            } elseif ($default == 'global') {
                $message_trads = array();
                foreach ($_POST as $key => $value) {
                    if (preg_match('/global_/i', $key)) {
                        $id_lang = preg_split('/global_/i', $key);
                        $message_trads[(int) $id_lang[1]] = $value;
                    }
                }

                Configuration::updateValue($this->config_name . '_' . $default, $message_trads, true);
            } elseif ($default == 'newval') {
                if (Tools::getValue($default)) {
                    Configuration::updateValue($this->config_name . '_' . $default, mt_rand(1, 40000));
                }

            } elseif ($default == 'attribute_size') {
                Configuration::updateValue($this->config_name . '_' . $default, $this->serializeSizes(Tools::getValue($default)));
            } else {
                Configuration::updateValue($this->config_name . '_' . $default, (Tools::getValue($default)));
            }

        }
        $this->_clearCache('iqitsizeguide.tpl');
        $this->generateCss();
    }

    public function clearCache()
    {
        $this->_clearCache('iqitsizeguide.tpl');
    }

    public function serializeSizes($array)
    {
        return (string) implode(',', $array);
    }

    public function unserializeSizes($string)
    {
        return explode(',', $string);
    }
    public function generateCss()
    {
        $css = '';

        $css .= '
		#iqitsizeguide{ width: ' . (int) Configuration::get($this->config_name . '_width') . 'px; height: ' . ((int) Configuration::get($this->config_name . '_height')) . 'px; }
		@media (max-width: ' . ((int) Configuration::get($this->config_name . '_width') + 40) . 'px) {#iqitsizeguid{  width: 70%; height: 65%;}}
		@media (max-height: ' . ((int) Configuration::get($this->config_name . '_height') + 80) . 'px) {#iqitsizeguid{ width: 70%; height: 65%;}}

		';
        if (Shop::getContext() == Shop::CONTEXT_GROUP) {
            $my_file = $this->local_path . 'css/iqitsizeguide_g_' . (int) $this->context->shop->getContextShopGroupID() . '.css';
        } elseif (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $my_file = $this->local_path . 'css/iqitsizeguide_s_' . (int) $this->context->shop->getContextShopID() . '.css';
        }

        $fh = fopen($my_file, 'w') or die("can't open file");
        fwrite($fh, $css);
        fclose($fh);
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        if ($this->context->controller->php_self == 'product') {
            $this->context->controller->addJS($this->_path . '/js/front.js');
            $this->context->controller->addCSS($this->_path . '/css/front.css');
            if (Shop::getContext() == Shop::CONTEXT_GROUP) {
                $this->context->controller->addCSS(($this->_path) . 'css/iqitsizeguide_g_' . (int) $this->context->shop->getContextShopGroupID() . '.css', 'all');
            } elseif (Shop::getContext() == Shop::CONTEXT_SHOP) {
                $this->context->controller->addCSS(($this->_path) . 'css/iqitsizeguide_s_' . (int) $this->context->shop->getContextShopID() . '.css', 'all');
            }

        }
        $this->context->controller->addCSS($this->_path . '/css/platributes.css');

    }

    public function hookDisplayAdminProductsExtra($params)
    {

        if (Validate::isLoadedObject($product = new Product((int) Tools::getValue('id_product')))) {
            $guides = $this->getGuides();

            $this->context->smarty->assign(array(
                'guides' => $this->getGuides(),
                'selectedGuide' => (int) SizeGuideIqit::getProductGuide((int) Tools::getValue('id_product')),
            ));

            return $this->display(__FILE__, 'views/templates/admin/addtab.tpl');
        } else {
            return $this->displayError($this->l('You must save this product before adding tabs'));
        }
    }
    public function hookdisplayProductAttributesPL($params)
    {
        $cache_id = 'iqitsizeguide|combination|' . $params['productid'];

        if (!$this->isCached('combinations.tpl', $this->getCacheId($cache_id))) {

            if (!Configuration::get($this->config_name . '_productl_size')) {
                return;
            }

            $productid = (int) $params['productid'];
            $combinations = $this->getAttributeCombinations($productid, $this->context->language->id);

            $avaiable_sizes = array();
            $checked_sizes = array();

            $size_attr = $this->unserializeSizes(Configuration::get($this->config_name . '_attribute_size'));
            if (!is_array($size_attr)) {
                return;
            }

            foreach ($combinations as $combination) {
                if (($combination['quantity'] > 0 || !Configuration::get('PS_STOCK_MANAGEMENT')) && in_array($combination['id_attribute_group'], $size_attr)) {
                    if (!in_array($combination['id_attribute'], $checked_sizes)) {
                        $avaiable_sizes[$combination['id_product_attribute']]['attribute_name'] = $combination['attribute_name'];
                        $checked_sizes[] = $combination['id_attribute'];
                    }

                }

            }
            $this->smarty->assign('combinations', $avaiable_sizes);
        }
        return $this->display(__FILE__, 'combinations.tpl', $this->getCacheId($cache_id));
    }

    public function hookdisplayProductListReviews($params)
    {
        $prodtid = (int) $params['product']['id_product'];

        return $this->hookdisplayProductAttributesPL($prodtid);

    }

    public function hookActionUpdateQuantity()
    {
        $this->_clearcache('combinations.tpl');
    }

    public function hookActionValidateOrder()
    {
        $this->_clearcache('combinations.tpl');
    }

    public function hookActionProductUpdate($params)
    {
        $this->_clearcache('combinations.tpl');

    }

    public function hookActionAdminProductsControllerSaveAfter($params)
    {
        $this->_clearcache('combinations.tpl');

        $id_product = (int) Tools::getValue('id_product');
        $id_guide = (int) Tools::getValue('id_iqitsizeguide');

        if ($id_guide) {
            SizeGuideIqit::assignProduct($id_product, $id_guide);
        } else {
            SizeGuideIqit::unassignProduct($id_product);
        }

    }

    public function hookActionProductDelete($params)
    {
        $this->_clearcache('combinations.tpl');

        $id_product = (int) Tools::getValue('id_product');
        SizeGuideIqit::unassignProduct($id_product);
    }

    public function hookDisplayProductSizeGuide($params)
    {
        if ($this->context->controller->php_self != 'product' || Configuration::get($this->config_name . '_hook') != 1) {
            return;
        }

        return $this->_prepareHook($params);
    }

    public function _prepareHook($params)
    {

        $product = (int) Tools::getValue('id_product');

        $id_guide = SizeGuideIqit::getProductGuide((int) Tools::getValue('id_product'));
        $sh_global = Configuration::get($this->config_name . '_sh_global');

        if ($id_guide || $sh_global) {
            if ($id_guide) {
                $guide = new SizeGuideIqit((int) $id_guide, $this->context->language->id);
                $cache_id = 'iqitsizeguide|' . (int) $id_guide;
            } else {
                $cache_id = 'iqitsizeguide';
            }

            if (!$this->isCached('iqitsizeguide.tpl', $this->getCacheId($cache_id))) {
                if ($id_guide) {
                    $this->smarty->assign(
                        array(
                            'guide' => $guide,
                        )
                    );
                }

                $this->smarty->assign(
                    array(
                        'howto' => Configuration::get($this->config_name . '_content', $this->context->language->id),
                        'sh_measure' => Configuration::get($this->config_name . '_sh_measure'),
                        'sh_global' => $sh_global,
                        'global' => Configuration::get($this->config_name . '_global', $this->context->language->id),
                    )

                );

            }
            return $this->display(__FILE__, 'iqitsizeguide.tpl', $this->getCacheId($cache_id));
        }
    }

    public function hookDisplayProductButtons($params)
    {
        if ($this->context->controller->php_self != 'product' || Configuration::get($this->config_name . '_hook') != 0) {
            return;
        }

        return $this->_prepareHook($params);
    }

    public function hookExtraLeft($params)
    {
        if ($this->context->controller->php_self != 'product' || Configuration::get($this->config_name . '_hook') != 2) {
            return;
        }

        return $this->_prepareHook($params);
    }

    public function hookExtraRight($params)
    {
        if ($this->context->controller->php_self != 'product' || Configuration::get($this->config_name . '_hook') != 3) {
            return;
        }

        return $this->_prepareHook($params);
    }

    public function getAttributeCombinations($id_product, $id_lang, $groupByIdAttributeGroup = true)
    {
        if (!Combination::isFeatureActive()) {
            return array();
        }
        $sql = 'SELECT pa.*, product_attribute_shop.*, ag.`id_attribute_group`, ag.`is_color_group`, agl.`name` AS group_name, al.`name` AS attribute_name,
					a.`id_attribute`
				FROM `' . _DB_PREFIX_ . 'product_attribute` pa
				' . Shop::addSqlAssociation('product_attribute', 'pa') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute` a ON a.`id_attribute` = pac.`id_attribute`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ' . (int) $id_lang . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ' . (int) $id_lang . ')
				WHERE pa.`id_product` = ' . (int) $id_product . '
				GROUP BY pa.`id_product_attribute`' . ($groupByIdAttributeGroup ? ',ag.`id_attribute_group`' : '') . '
				ORDER BY pa.`id_product_attribute`';
        $res = Db::getInstance()->executeS($sql);
        //Get quantity of each variations
        foreach ($res as $key => $row) {
            $cache_key = $row['id_product'] . '_' . $row['id_product_attribute'] . '_quantity';
            if (!Cache::isStored($cache_key)) {
                Cache::store(
                    $cache_key,
                    StockAvailable::getQuantityAvailableByProduct($row['id_product'], $row['id_product_attribute'])
                );
            }
            $res[$key]['quantity'] = Cache::retrieve($cache_key);
        }
        return $res;
    }

}
