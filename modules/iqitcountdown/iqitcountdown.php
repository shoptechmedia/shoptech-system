<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class IqitCountDown extends Module
{
    protected $html = '';

    public function __construct()
    {
        $this->name = 'iqitcountdown';
        $this->tab = 'front_office_features';
        $this->version = '1.1';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Special price countdown');
        $this->description = $this->l('Show time to end of special price');

        $this->config_name = 'iqitfdc';
        $this->defaults = array(
            'bg_color' => '#F2F2F2',
            'txt_color' => '#777777',
            'timer_bg_color' => '#151515',
            'timer_bg_text' => '#ffffff',
            'show_hover' => 1,

        );
    }

    public function install()
    {
        $this->setDefaults();
        $this->generateCss();

        return parent::install() && $this->registerHook('displayCountDown') && $this->registerHook('top') && $this->registerHook('displayCountDownProduct') && $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->config_name . '_' . $default);
        }

        return parent::uninstall();
    }

    public function setDefaults()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::updateValue($this->config_name . '_' . $default, $value);
        }
    }

    public function hookDisplayCountDown($params)
    {
        if (!isset($params['product']['specific_prices']['to'])) {
            return;
        }

        $today = date("Y-m-d H:i:s");
        $date = $params['product']['specific_prices']['to'];

        if ($date > $today) {
            $this->smarty->assign(array(
                'specific_prices' => $params['product']['specific_prices'],
            ));

            return $this->display(__FILE__, 'iqitcountdown.tpl');
        } else {
            return;
        }

    }

    public function hookDisplayCountDownProduct($params)
    {

        if (isset($params['product']->specificPrice)) {
            $this->smarty->assign(array(
                'specific_prices' => $params['product']->specificPrice,
            ));
        }

        return $this->display(__FILE__, 'iqitcountdown_product.tpl');

    }

    public function hookDisplayHeader($params)
    {

        if (Configuration::get('PS_CATALOG_MODE')) {
            return;
        }

        $this->context->controller->addCss($this->_path . 'css/iqitcountdown.css', 'all');
        $this->context->controller->addJS($this->_path . 'js/count.js');
        $this->context->controller->addJS($this->_path . 'js/iqitcountdown.js');

        if (Shop::getContext() == Shop::CONTEXT_GROUP) {
            $this->context->controller->addCSS(($this->_path) . 'css/custom_g_' . (int) $this->context->shop->getContextShopGroupID() . '.css', 'all');
        } elseif (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $this->context->controller->addCSS(($this->_path) . 'css/custom_s_' . (int) $this->context->shop->getContextShopID() . '.css', 'all');
        }

        Media::addJsDef(array('countdownEnabled' => true));

    }

    public function hookTop($params)
    {
        return $this->display(__FILE__, 'iqitcountdown_top.tpl');
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        if (Tools::isSubmit('submitModule')) {
            $this->postProcess();
            $this->generateCss();
            $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        return $this->renderForm();
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
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
        . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
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
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Visibility on product list'),
                        'name' => 'show_hover',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Only on hover'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('Always'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Title text color'),
                        'name' => 'txt_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background color'),
                        'name' => 'bg_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Timer background color and icon color'),
                        'name' => 'timer_bg_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Timer text color'),
                        'name' => 'timer_bg_text',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    public function generateCss()
    {

        $css = '

        .price-countdown{
            background: ' . Configuration::get($this->config_name . '_bg_color') . ';
            color: ' . Configuration::get($this->config_name . '_txt_color') . ';
        }
  		.price-countdown .icon { color: ' . Configuration::get($this->config_name . '_timer_bg_color') . ';}
  		.price-countdown .count-down-timer span.countdown-time {  background: ' . Configuration::get($this->config_name . '_timer_bg_color') . '; color: ' . Configuration::get($this->config_name . '_timer_bg_text') . ';}
        ';

        if (Configuration::get($this->config_name . '_show_hover')) {
            $css .= '.product-image-container .price-countdown{display: none;}';
        }

        $css = trim(preg_replace('/\s+/', ' ', $css));

        if (Shop::getContext() == Shop::CONTEXT_GROUP) {
            $myFile = $this->local_path . "css/custom_g_" . (int) $this->context->shop->getContextShopGroupID() . ".css";
        } elseif (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $myFile = $this->local_path . "css/custom_s_" . (int) $this->context->shop->getContextShopID() . ".css";
        }

        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $css);
        fclose($fh);

    }
    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        $var = array();
        foreach ($this->defaults as $default => $value) {
            $var[$default] = Configuration::get($this->config_name . '_' . $default);
        }
        return $var;
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::updateValue($this->config_name . '_' . $default, (Tools::getValue($default)));
        }
    }

}
