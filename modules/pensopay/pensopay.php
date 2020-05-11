<?php
/**
 * NOTICE OF LICENSE
 *
 *  @author    PensoPay A/S
 *  @copyright 2019 PensoPay
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
 *  E-mail: support@pensopay.com
 */

class PensoPay extends PaymentModule
{
    protected $config_form = false;
    private $post_errors = array();

    const METHOD_REDIRECT = 0;
    const METHOD_IFRAME = 1;

    const MODE_VARIABLE = 'mode';
    const MODE_COMPLETE = 'complete';
    const MODE_CANCEL   = 'canceled';

    const COOKIE_CONTINUEURL = 'continue_url';
    const COOKIE_ORDER_CANCELLED = 'order_cancelled';

    /**
     * Prestashop >= 1.4.0.0
     * @var bool
     */
    private $v14;

    /**
     * Prestashop >= 1.5.0.0
     * @var bool
     */
    private $v15;

    /**
     * Prestashop >= 1.6.0.0
     * @var bool
     */
    private $v16;

    /**
     * Prestashop >= 1.7.0.0
     * @var bool
     */
    private $v17;

    private $renderedViabillProducts = array();

    public function __construct()
    {
        $this->name = 'pensopay';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.3';
        $this->v14 = _PS_VERSION_ >= '1.4.1.0';
        $this->v15 = _PS_VERSION_ >= '1.5.0.0';
        $this->v16 = _PS_VERSION_ >= '1.6.0.0';
        $this->v17 = _PS_VERSION_ >= '1.7.0.0';
        $this->author = 'PensoPay A/S';
        $this->module_key = 'b99f59b30267e81da96b12a8d1aa5bac';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('PensoPay');
        $this->description = $this->l('Payment via PensoPay');
        $this->confirmUninstall =
            $this->l('Are you sure you want to delete your settings?');

        /* Backward compatibility */
        if (!$this->v15) {
            $this->local_path = _PS_MODULE_DIR_.$this->name.'/';
            $this->back_file =
                $this->local_path.'backward_compatibility/backward.php';
            if (file_exists($this->back_file)) {
                require $this->back_file;
            }
        }

        if (!$this->v14) {
            $this->warning = $this->l('This module only works for PrestaShop 1.4, 1.5 and 1.6');
        }
    }

    public function varsObj($setup_var)
    {
        $vars = new StdClass();
        $keys = array(
                'glob_name',
                'var_name',
                'card_text',
                'def_val',
                'card_type_lock');
        $i = 0;
        foreach ($keys as $key) {
            $vars->$key = $setup_var[$i++];
        }
        return $vars;
    }

    public function checkLangFile()
    {
        if (isset($this->back_file)) {
            $src = Tools::file_get_contents($this->local_path.'translations/da.php');
            $dst = Tools::file_get_contents($this->local_path.'da.php');
            if ($src != $dst) {
                file_put_contents($this->local_path.'da.php', $src);
            }
        }
    }

    public function install()
    {
        include dirname(__FILE__).'/sql/install.php';
        $this->checkLangFile();

        if (!parent::install()) {
            return false;
        }
        $this->getSetup();
        foreach ($this->setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            if (!Configuration::updateValue($vars->glob_name, $vars->def_val)) {
                return false;
            }
        }
        return $this->registerHook('payment') &&
            $this->registerHook('header') &&
            $this->registerHook('leftColumn') &&
            $this->registerHook('footer') &&
            $this->registerHook('adminOrder') &&
            $this->registerHook('paymentReturn') &&
            $this->registerHook('PDFInvoice') &&
            $this->registerHook('postUpdateOrderStatus') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayProductPriceBlock') &&
            (!$this->v17 || $this->registerHook('paymentOptions')) &&
            (!$this->v17 || $this->registerHook('displayExpressCheckout')) &&
//            (!$this->v17 || $this->registerHook('displayCartTotalPriceLabel')) &&
            ($this->v17 || $this->registerHook('shoppingCartExtra'));
    }

    public function uninstall()
    {
        include dirname(__FILE__).'/sql/uninstall.php';

        if (!parent::uninstall()) {
            return false;
        }
        $this->getSetup();
        foreach ($this->setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            if (!Configuration::deleteByName($vars->glob_name)) {
                return false;
            }
        }
        return Configuration::deleteByName('_PENSOPAY_OVERLAY_CODE') &&
            Configuration::deleteByName('_PENSOPAY_ORDERING') &&
            Configuration::deleteByName('_PENSOPAY_HIDE_IMAGES');
    }

    public function getConf($name)
    {
        if (isset($this->orderShopId)) {
            $conf = Configuration::get($name, null, null, $this->orderShopId);
        } else {
            $conf = Configuration::get($name);
        }
        return $conf;
    }

    public function getSetup()
    {
        $this->setup_vars = array(
            array('_PENSOPAY_MERCHANT_ID', 'merchant_id',
                $this->l('PensoPay merchant ID'), '', ''),
            array('_PENSOPAY_PRIVATE_KEY', 'private_key',
                $this->l('PensoPay private key'), '', ''),
            array('_PENSOPAY_USER_KEY', 'user_key',
                $this->l('PensoPay user key'), '', ''),
            array('_PENSOPAY_ORDER_PREFIX', 'orderprefix',
                $this->l('Order prefix'), '000', ''),
            array('_PENSOPAY_GA_CLIENT_ID', 'ga_client_id',
                $this->l('Google analytics client ID'), '', ''),
            array('_PENSOPAY_GA_TRACKING_ID', 'ga_tracking_id',
                $this->l('Google analytics tracking ID'), '', ''),
            array('_PENSOPAY_STATEMENT_TEXT', 'statementtext',
                $this->l('Text on statement'), '', ''),
            array('_PENSOPAY_VIABILL_ID', 'viabillid',
                $this->l('Viabill ID'), '', ''),
            array('_PENSOPAY_TESTMODE', 'testmode',
                $this->l('Accept test payments'), 0, ''),
            array('_PENSOPAY_COMBINE', 'combine',
                $this->l('Creditcards combined window'), 0, ''),
            array('_PENSOPAY_AUTOGET', 'autoget',
                $this->l('Cards in payment window controlled by PensoPay'), 0, ''),
            array('_PENSOPAY_MOBILEPAY_CHECKOUT', 'mobilepaycheckout',
                $this->l('Add button for MobilePay Checkout'), 0, ''),
            array('_PENSOPAY_AUTOFEE', 'autofee',
                $this->l('Customer pays the card fee'), 0, ''),
            array('_PENSOPAY_API', 'api',
                $this->l('Activate API'), 1, ''),
            array('_PENSOPAY_SHOWCARDS', 'showcards',
                $this->l('Show card logos in left column'), 1, ''),
            array('_PENSOPAY_SHOWCARDSFOOTER', 'showcardsfooter',
                    $this->l('Show card logos in footer'), 1, ''),
            array('_PENSOPAY_AUTOCAPTURE', 'autocapture',
                    $this->l('Auto-capture payments'), 0, ''),
            array('_PENSOPAY_STATECAPTURE', 'statecapture',
                    $this->l('Capture payments in state'), 0, ''),
            array('_PENSOPAY_BRANDING', 'branding',
                    $this->l('Branding in payment window'), 0, ''),
            array('_PENSOPAY_FEE_TAX', 'feetax',
                    $this->l('Tax for card fee'), 0, ''),
            array('_PENSOPAY_PAYMETHOD_TAX', 'paymethod',
                $this->l('Payment method'), 0, ''),
            array('_PENSOPAY_VIABILL', 'viabill',
                    $this->l('ViaBill - buy now, pay whenever you want'), 0, 'viabill'),
            array('_PENSOPAY_DK', 'dk',
                    $this->l('Dankort'), 0, 'dankort'),
            array('_PENSOPAY_VISA', 'visa',
                    $this->l('Visa card'), 0, 'visa,visa-dk'),
            array('_PENSOPAY_VELECTRON', 'visaelectron',
                    $this->l('Visa Electron'), 0, 'visa-electron,visa-electron-dk'),
            array('_PENSOPAY_MASTERCARD', 'mastercard',
                    $this->l('MasterCard'), 0, 'mastercard,mastercard-dk'),
            array('_PENSOPAY_MASTERCARDDEBET', 'mastercarddebet',
                    $this->l('MasterCard Debet'), 0, 'mastercard-debet,mastercard-debet-dk'),
            array('_PENSOPAY_A_EXPRESS', 'express',
                    $this->l('American Express'), 0, 'american-express,american-express-dk'),
            array('_PENSOPAY_MOBILEPAY', 'mobilepay',
                    $this->l('MobilePay'), 0, 'mobilepay'),
            array('_PENSOPAY_SWISH', 'swish',
                    $this->l('Swish'), 0, 'swish'),
            array('_PENSOPAY_KLARNA', 'klarna',
                    $this->l('Klarna'), 0, 'klarna'),
            array('_PENSOPAY_FORBRUGS_1886', 'f1886',
                    $this->l('Forbrugsforeningen af 1886'), 0, 'fbg1886'),
            array('_PENSOPAY_DINERS', 'diners',
                    $this->l('Diners Club'), 0, 'diners,diners-dk'),
            array('_PENSOPAY_JCB', 'jcb',
                    $this->l('JCB'), 0, 'jcb'),
            array('_PENSOPAY_VISA_3D', 'visa_3d',
                    $this->l('Visa card (3D)'), 0, '3d-visa,3d-visa-dk'),
            array('_PENSOPAY_VELECTRON_3D', 'visaelectron_3d',
                    $this->l('Visa Electron (3D)'), 0, '3d-visa-electron,3d-visa-electron-dk'),
            array('_PENSOPAY_MASTERCARD_3D', 'mastercard_3d',
                    $this->l('MasterCard (3D)'), 0, '3d-mastercard,3d-mastercard-dk'),
            array('_PENSOPAY_MASTERCARDDEBET_3D', 'mastercarddebet_3d',
                    $this->l('MasterCard Debet (3D)'), 0, '3d-mastercard-debet,3d-mastercard-debet-dk'),
            array('_PENSOPAY_MAESTRO_3D', 'maestro_3d',
                    $this->l('Maestro (3D)'), 0, '3d-maestro,3d-maestro-dk'),
            array('_PENSOPAY_JCB_3D', 'jcb_3d',
                    $this->l('JCB (3D)'), 0, '3d-jcb'),
            array('_PENSOPAY_PAYPAL', 'paypal',
                    $this->l('PayPal'), 0, 'paypal'),
            array('_PENSOPAY_SOFORT', 'sofort',
                    $this->l('Sofort'), 0, 'sofort'),
            array('_PENSOPAY_APPLEPAY', 'applepay',
                    $this->l('Apple Pay'), 0, 'applepay'),
            array('_PENSOPAY_BITCOIN', 'bitcoin',
                    $this->l('Bitcoin'), 0, 'bitcoin'));
        $this->setup = new StdClass();
        $this->setup->lock_names = array();
        $this->setup->card_type_locks = array();
        $this->setup->card_texts = array();
        $this->setup->credit_cards = array();
        $credit_cards = array(
            'dk',
            'visa',
            'visaelectron',
            'express',
            'f1886',
            'mastercard',
            'mastercarddebet',
            'maestro',
            'diners',
            'jcb',
            'applepay'
        );
        $credit_cards2d = array(
            'visa_3d' => 'visa',
            'visaelectron_3d' => 'visaelectron',
            'mastercard_3d' => 'mastercard',
            'mastercarddebet_3d' => 'mastercarddebet',
            'maestro_3d' => 'maestro',
            'jcb_3d' => 'jcb'
        );
        $this->setup->secure_list = array(
            'visa' => 'visa_secure',
            'visaelectron' => 'visa_secure',
            'visa_3d' => 'visa_secure',
            'visaelectron_3d' => 'visa_secure',
            'mastercard' => 'mastercard_secure',
            'maestro' => 'mastercard_secure',
            'mastercarddebet' => 'mastercard_secure',
            'mastercard_3d' => 'mastercard_secure',
            'maestro_3d' => 'mastercard_secure',
            'mastercarddebet_3d' => 'mastercard_secure'
        );
        $all_cards = array_merge($credit_cards, array_keys($credit_cards2d));
        $this->setup->auto_ignore = array_keys($credit_cards2d);
        array_pop($this->setup->auto_ignore);
        $setup_vars = $this->sortSetup();
        $autoget = $this->getConf('_PENSOPAY_AUTOGET');
        $combine = $this->getConf('_PENSOPAY_COMBINE');
        foreach ($setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            $field = $vars->var_name;
            $this->setup->$field = $this->getConf($vars->glob_name);
            $this->setup->card_texts[$vars->var_name] = $vars->card_text;
            if ($vars->var_name == 'maestro_3d') {
                $this->setup->card_texts['maestro'] = $this->l('Maestro');
            }
            if (in_array($vars->var_name, $all_cards)) {
                if ($autoget && $combine) {
                    if (in_array($vars->var_name, $this->setup->auto_ignore)) {
                        $this->setup->$field = 0;
                    } else {
                        $this->setup->$field = 2;
                    }
                }
                if ($vars->var_name == 'applepay') {
                    $this->setup->$field = 2;
                }
                if ($this->setup->$field) {
                    $this->setup->credit_cards[$vars->var_name] = $vars->card_text;
                    $card_type_locks = explode(',', $vars->card_type_lock);
                    foreach ($card_type_locks as $name) {
                        $this->setup->card_type_locks[] = $name;
                        $this->setup->lock_names[$name] = $vars->var_name;
                    }
                }
            }
        }
        if ($this->setup->mobilepaycheckout) {
            $this->setup->mobilepay = 1;
        }

        return $this->setup;
    }

    public function sortSetup()
    {
        $ordering = Configuration::get('_PENSOPAY_ORDERING');
        if ($ordering) {
            $ordering_list = explode(',', $ordering);
        } else {
            $ordering_list = array();
        }
        $setup_dict = array();
        foreach ($this->setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            $setup_dict[$vars->var_name] = $setup_var;
        }
        $setup_vars = array();
        foreach ($ordering_list as $vars->var_name) {
            if (isset($setup_dict[$vars->var_name])) {
                $setup_vars[$vars->var_name] = $setup_dict[$vars->var_name];
            }
        }
        foreach ($setup_dict as $vars->var_name => $setup_var) {
            if (empty($setup_vars[$vars->var_name])) {
                $setup_vars[$vars->var_name] = $setup_var;
            }
        }
        return $setup_vars;
    }

    public function imagesSetup()
    {
        $hide_images = Configuration::get('_PENSOPAY_HIDE_IMAGES');
        if ($hide_images !== false) {
            $hide_images_list = explode(',', $hide_images);
        } else {
            $hide_images_list = array(
                'visa_secure',
                'visaelectron_secure',
                'mastercard_secure',
                'maestro_secure',
                'mastercarddebet_secure'
            );
        }
        $key_list = array();
        foreach ($hide_images_list as $hide_image) {
            $key_list[$hide_image] = $hide_image;
        }
        return $key_list;
    }

    public function getPageLink($name, $parm)
    {
        if ($this->v15) {
            $url = $this->context->link->getPageLink($name, true, null, $parm);
        } else {
            $url = Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://';
            $url .= $_SERVER['HTTP_HOST'].__PS_BASE_URI__.$name.'.php?'.$parm;
        }
        return $url;
    }

    public function getModuleLink($name, $parms = array())
    {
        if ($this->v15) {
            $url = $this->context->link->getModuleLink(
                $this->name,
                $name,
                $parms,
                true
            );
        } else {
            $url = Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://';
            $url .= $_SERVER['HTTP_HOST'].$this->_path.$name.'.php';
            if ($parms) {
                $key_values = array();
                foreach ($parms as $k => $v) {
                    $key_values[] = $k.'='.$v;
                }
                $url .= '?'.implode('&', $key_values);
            }
        }
        return $url;
    }

    public function addLog($message, $severity = 1, $error_code = null, $object_type = null, $object_id = null)
    {
        if ($this->v16) {
            PrestaShopLogger::addLog($message, $severity, $error_code, $object_type, $object_id);
        } else {
            Logger::addLog($message, $severity, $error_code, $object_type, $object_id);
        }
    }

    public function changeState()
    {
        $target = Tools::getValue('target');
        $this->getSetup();
        $hide_images_list = $this->imagesSetup();
        foreach ($this->setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            // Toggle value
            if ($target == $vars->var_name.'_on') {
                Configuration::updateValue($vars->glob_name, 0);
            }
            if ($target == $vars->var_name.'_off') {
                Configuration::updateValue($vars->glob_name, 1);
            }
            if ($target == $vars->var_name.'_hide') {
                unset($hide_images_list[$vars->var_name]);
            }
            if ($target == $vars->var_name.'_disp') {
                $hide_images_list[$vars->var_name] = $vars->var_name;
            }
            if ($target == $vars->var_name.'_hide_sec') {
                unset($hide_images_list[$vars->var_name.'_secure']);
            }
            if ($target == $vars->var_name.'_disp_sec') {
                $hide_images_list[$vars->var_name.'_secure'] = $vars->var_name.'_secure';
            }
        }
        Configuration::updateValue('_PENSOPAY_HIDE_IMAGES', implode(',', $hide_images_list));
    }

    public function updateCardsPosition()
    {
        $cards = Tools::getValue('cards');
        if ($cards) {
            Configuration::updateValue('_PENSOPAY_ORDERING', implode(',', $cards));
        }
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $this->checkLangFile();
        if (isset($this->warning)) {
            return $this->displayError($this->warning);
        }

        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
        if (isset($this->back_file) && !file_exists($this->back_file)) {
            $err = $this->l('This module requires the backward compatibility module.');
            if (!Module::isInstalled('backwardcompatibility')) {
                $err .= ' ' . $this->l('You can get the compatibility module for free from') . ' %link%';
            }
            $err .= ' ' . $this->l('You must configure the compatibility module.');

            $this->context->smarty->assign('generic', $err);
            $this->context->smarty->assign('linkTitle', 'http://addons.prestashop.com');
            $this->context->smarty->assign('linkHref', 'http://addons.prestashop.com');
            $err .= $this->display(__FILE__, 'admin/messages/generic.tpl');
            return $this->displayError($err);
        }

        $output = '';
        $row = Db::getInstance()->ExecuteS(
            'SHOW TABLES LIKE "'._DB_PREFIX_.'pensopay_execution"'
        );
        if (!$row) {
            // Not installed properly
            $this->install();
        }
        $this->getSetup();
        $this->postProcess();
        if ($this->v15) {
            if ($this->isRegisteredInHook(Hook::getIdByName('paymentTop'))) {
                $this->unRegisterHook('paymentTop');
            }
            if (!$this->isRegisteredInHook(Hook::getIdByName('header'))) {
                $this->registerHook('header');
            }
            if ($this->v17 && !$this->isRegisteredInHook(Hook::getIdByName('displayExpressCheckout'))) {
                $this->registerHook('displayExpressCheckout');
            }
            if (!$this->v17 && !$this->isRegisteredInHook(Hook::getIdByName('shoppingCartExtra'))) {
                $this->registerHook('shoppingCartExtra');
            }
//            if (!$this->v17 && !$this->isRegisteredInHook(Hook::getIdByName('displayCartTotalPriceLabel'))) {
//                $this->registerHook('displayCartTotalPriceLabel');
//            }
            if (!$this->isRegisteredInHook(Hook::getIdByName('displayProductPriceBlock'))) {
                $this->registerHook('displayProductPriceBlock');
            }
            if (!$this->isRegisteredInHook(Hook::getIdByName('displayHeader'))) {
                $this->registerHook('displayHeader');
            }
            $this->context->controller->addJqueryUI('ui.sortable');
        } else {
            // Old PrestaShop
            require $this->local_path . 'backward_compatibility/HelperForm.php';
            $this->context->smarty->assign('path', $this->_path);
            $output .= $this->context->smarty->fetch($this->local_path
                . 'views/templates/front/compatibility/jqueryui.tpl');
        }
        $output .= $this->displayErrors();
        if (Tools::getValue('submitPensopayModule') && !$this->post_errors) {
            $this->context->smarty->assign('message', $this->l('Settings updated'));
            $output .= $this->display(__FILE__, 'admin/messages/success.tpl');
        }

        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->clearCompiledTemplate($this->local_path . 'views/templates/hook/pensopay.tpl');
        $output .= $this->display(__FILE__, 'admin/configure.tpl');

        $output .= $this->renderForm();
        $output .= $this->previewPayment();
        $output .= $this->renderList();
        return $output;
    }

    protected function renderForm()
    {
        $helper = new HelperForm();

        if (empty($helper->context)) {
            $helper->context = $this->context;
            $helper->local_path = $this->local_path;
        }
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang =
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        if (!$helper->allow_employee_form_lang) {
            // For old 1.5 helper
            $helper->allow_employee_form_lang = 0;
        }

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitPensopayModule';
        if ($this->v15) {
            $helper->currentIndex =
                $this->context->link->getAdminLink('AdminModules', false).
                '&configure='.$this->name.
                '&tab_module='.$this->tab.
                '&module_name='.$this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $helper->tpl_vars = array(
                    'fields_value' => $this->getConfigFormValues(),
                    'languages' => $this->context->controller->getLanguages(),
                    'id_language' => $this->context->language->id,
                    );
        } else {
            $helper->currentIndex = 'index.php?tab='.Tools::getValue('tab').
                '&configure='.Tools::getValue('configure').
                '&tab_module='.Tools::getValue('tab_module').
                '&module_name='.Tools::getValue('module_name');
            $helper->token = Tools::getValue('token');
            $helper->tpl_vars = array(
                    'fields_value' => $this->getConfigFormValues(),
                    'languages' => Language::getLanguages(),
                    'id_language' => $this->context->language->id,
                    );
        }

        return $helper->generateForm(array($this->getConfigSettings()));
    }

    protected function renderList()
    {
        $setup = $this->setup;
        $setup_vars = $this->sortSetup();
        $hide_images_list = $this->imagesSetup();
        $cards = array();
        foreach ($setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            $field = $vars->var_name;
            if ($setup->autoget && in_array($vars->var_name, $setup->auto_ignore)) {
                continue;
            }
            if (!$vars->card_type_lock) {
                continue;
            }
            $card = array();
            $card['name'] = $vars->var_name;
            $card['image'] = $vars->var_name.'.png';
            if (isset($setup->secure_list[$vars->var_name])) {
                $card['image_secure'] = $setup->secure_list[$vars->var_name].'.png';
            } else {
                $card['image_secure'] = '';
            }
            $card['display'] = empty($hide_images_list[$vars->var_name]);
            $card['display_secure'] = empty($hide_images_list[$vars->var_name.'_secure']);
            $card['title'] = $vars->card_text;
            $card['status'] = $setup->$field;
            $cards[] = $card;
        }
        $change_url = $_SERVER['REQUEST_URI'];
        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'cards' => $cards,
                'change_url' => $change_url,
                'secure_key' => $this->secure_key,
                'image_baseurl' => $this->_path.'views/img/'
            )
        );

        if ($this->v16) {
            return $this->display(__FILE__, 'list.tpl');
        } elseif ($this->v15) {
            return $this->display(__FILE__, 'list15.tpl');
        } else {
            return $this->display(__FILE__, 'views/templates/hook/list15.tpl');
        }
    }

    protected function useCheckBox($vars)
    {
        return $vars->def_val !== '' &&
            $vars->var_name != 'orderprefix' &&
            $vars->var_name != 'statecapture' &&
            $vars->var_name != 'branding' &&
            $vars->var_name != 'feetax' &&
            $vars->var_name != 'paymethod';
    }

    protected function getConfigInput15($vars)
    {
        if ($this->useCheckBox($vars)) {
            $input = array(
                    'type' => 'select',
                    'name' => $vars->glob_name,
                    'label' => $vars->card_text,
                    'options' => array(
                        'query' =>  array(
                            array(
                                'id' => '0',
                                'name' => $this->l('No')
                                ),
                            array(
                                'id' => '1',
                                'name' => $this->l('Yes')
                                )
                            ),
                        'id' => 'id',
                        'name' => 'name'
                        )
                    );
        } else {
            $input = array(
                    'size' => strpos($vars->var_name, '_key') === false ? 10 : 60,
                    'type' => 'text',
                    'name' => $vars->glob_name,
                    'label' => $vars->card_text
                    );
        }
        return $input;
    }

    protected function getConfigInput($vars)
    {
        if (!$this->v16) {
            return $this->getConfigInput15($vars);
        }
        if ($this->useCheckBox($vars)) {
            $input = array(
                    'type' => 'switch',
                    'name' => $vars->glob_name,
                    'label' => $vars->card_text,
                    'values' => array(
                        array(
                            'id' => 'on',
                            'value' => '1',
                            'label' => $this->l('Yes'),
                            ),
                        array(
                            'id' => 'off',
                            'value' => '0',
                            'label' => $this->l('No'),
                            )
                        )
                    );
        } else {
            $input = array(
                    'col' => strpos($vars->var_name, '_key') === false ? 3 : 6,
                    'type' => 'text',
                    'name' => $vars->glob_name,
                    'label' => $vars->card_text
                    );
        }
        if ($vars->var_name == 'statementtext') {
            $input['desc'] = $this->l('Max. 22 ASCII characters. Only for Clearhaus.');
        }
        return $input;
    }

    protected function getStatesInput($vars)
    {
        $order_states = OrderState::getOrderStates($this->context->language->id);
        $query = array();
        $query[] = array('id' => 0,  'name' => $this->l('Never'));
        foreach ($order_states as $order_state) {
            $query[] = array(
                    'id' => $order_state['id_order_state'],
                    'name' => $order_state['name']
                    );
        }
        $input = array(
                'type' => 'select',
                'name' => $vars->glob_name,
                'label' => $vars->card_text,
                'options' => array(
                    'query' =>  $query,
                    'id' => 'id',
                    'name' => 'name'
                    )
                );
        return $input;
    }

    protected function getBrandingInput($vars)
    {
        $brandings = $this->getBrandings();
        if ($brandings === false) {
            $brandings = array();
        }
        $query = array();
        $query[] = array('id' => 0,  'name' => $this->l('Standard'));
        foreach ($brandings as $id => $name) {
            $query[] = array(
                    'id' => $id,
                    'name' => $name
                    );
        }
        $input = array(
                'type' => 'select',
                'name' => $vars->glob_name,
                'label' => $vars->card_text,
                'options' => array(
                    'query' =>  $query,
                    'id' => 'id',
                    'name' => 'name'
                    )
                );
        return $input;
    }

    protected function getFeeTaxInput($vars)
    {
        $taxes = array(0 => $this->l('None'));
        $rows = TaxRulesGroup::getTaxRulesGroups();
        foreach ($rows as $row) {
            $taxes[$row['id_tax_rules_group']] = $row['name'];
        }
        $query = array();
        foreach ($taxes as $id => $name) {
            $query[] = array(
                    'id' => $id,
                    'name' => $name
                    );
        }
        $input = array(
                'type' => 'select',
                'name' => $vars->glob_name,
                'label' => $vars->card_text,
                'options' => array(
                    'query' =>  $query,
                    'id' => 'id',
                    'name' => 'name'
                    )
                );
        return $input;
    }

    protected function getPaymethodInput($vars)
    {
        $methods = array(
            self::METHOD_REDIRECT => $this->l('Redirect'),
            self::METHOD_IFRAME   => $this->l('Iframe')
        );
        $query = array();
        foreach ($methods as $id => $name) {
            $query[] = array(
                'id' => $id,
                'name' => $name
            );
        }
        $input = array(
            'type' => 'select',
            'name' => $vars->glob_name,
            'label' => $vars->card_text,
            'options' => array(
                'query' =>  $query,
                'id' => 'id',
                'name' => 'name'
            )
        );
        return $input;
    }

    protected function getConfigSettings()
    {
        $inputs = array();
        foreach ($this->setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            if ($vars->card_type_lock) {
                continue;
            }
            if ($vars->var_name == 'statecapture') {
                $inputs[] = $this->getStatesInput($vars);
                continue;
            }
            if ($vars->var_name == 'branding') {
                $inputs[] = $this->getBrandingInput($vars);
                continue;
            }
            if ($vars->var_name == 'feetax') {
                $inputs[] = $this->getFeeTaxInput($vars);
                continue;
            }
            if ($vars->var_name == 'paymethod') {
                $inputs[] = $this->getPaymethodInput($vars);
                continue;
            }
            $inputs[] = $this->getConfigInput($vars);
        }
        $submit = array(
                'title' => $this->l('Save'),
                );
        $form = array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                    ),
                'input' => $inputs,
                'submit' => $submit,
                );
        return array('form' => $form);
    }

    protected function getConfigFormValues()
    {
        $setup = $this->setup;
        $values = array();
        foreach ($this->setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            $field = $vars->var_name;
            if ($this->useCheckBox($vars)) {
                $values[$vars->glob_name] = $setup->$field ? 1 : 0;
            } else {
                $values[$vars->glob_name] = $setup->$field;
            }
        }
        return $values;
    }

    public function displayErrors()
    {
        $out = '';
        foreach ($this->post_errors as $err) {
            $out .= $this->displayError($err);
        }
        return $out;
    }

    public function getGenericMessage($generic, $linkTitle, $linkHref)
    {
        $this->context->smarty->assign('generic', $generic);
        $this->context->smarty->assign('linkTitle', $linkTitle);
        $this->context->smarty->assign('linkHref', $linkHref);
        return $this->display(__FILE__, 'admin/messages/generic.tpl');
    }

    protected function postProcess()
    {
        if (Tools::getValue('action') == 'changeState') {
            $this->changeState();
            exit;
        }
        if (Tools::getValue('action') == 'previewPayment') {
            print $this->previewPayment();
            exit;
        }
        if (Tools::getValue('action') == 'updateCardsPosition') {
            $this->updateCardsPosition();
            exit;
        }
        if (Tools::getValue('submitPensopayModule')) {
            foreach ($this->setup_vars as $setup_var) {
                $vars = $this->varsObj($setup_var);
                if ($vars->card_type_lock) {
                    continue;
                }
                if (Tools::getValue($vars->glob_name, null) !== null) {
                    Configuration::updateValue(
                        $vars->glob_name,
                        Tools::getValue($vars->glob_name)
                    );
                }
            }
            // Read the new setup
            $setup = $this->getSetup();
            if (!$setup->merchant_id) {
                $this->post_errors[] = $this->l('Merchant ID is required.');
            }
            if (Tools::strlen($setup->orderprefix) != 3) {
                $this->post_errors[] = $this->l('Order prefix must be exactly 3 characters long.');
            }
            $txt = Tools::iconv('utf-8', 'ASCII', $setup->statementtext);
            if ($txt != $setup->statementtext) {
                $this->post_errors[] =
                    $this->l('Statement text must be 7-bit ASCII.');
            }
            if (Tools::strlen($txt) > 22) {
                $this->post_errors[] =
                    $this->l('Statement text must not be longer than 22 characters.');
            }
            $data = $this->doCurl('payments', array(), 'POST');
            $vars = $this->jsonDecode($data);
            if ($vars->message == 'Invalid API key') {
                $this->post_errors[] = $this->getGenericMessage(
                    $this->l('Invalid QuickPay user key. Check the key at') . ' %link%',
                    'https://manage.quickpay.net',
                    'https://manage.quickpay.net'
                );
            } elseif ($setup->autofee) {
                $fees = $this->getFees(100);
                if (!$fees) {
                    $this->post_errors[] = $this->getGenericMessage(
                        $this->l('Could not access fees via user key. Check access rights in') . ' %link%',
                        'https://manage.quickpay.net',
                        'https://manage.quickpay.net'
                    );
                }
            }
            $data = $this->doCurl('payments', array('order_id=0'), 'GET');
            $vars = $this->jsonDecode($data);
            if ($vars && Tools::substr($vars->message, 0, 14) == 'Not authorized') {
                $this->post_errors[] = $this->getGenericMessage(
                    $this->l('Could not access payments via user key. Check access rights in') . ' %link%',
                    'https://manage.quickpay.net',
                    'https://manage.quickpay.net'
                );
            }
        }
    }

    public function jsonDecode($data)
    {
        if ($this->v15) {
            return Tools::jsonDecode($data);
        } else {
            return call_user_func('json_decode', $data);
        }
    }

    public function getCurlHandle($resource, $fields = null, $method = null)
    {
        $ch = curl_init();
        $header = array();
        $header[] = 'Authorization: Basic '.
            call_user_func('base64_encode', ':'.$this->setup->user_key);
        $header[] = 'Accept-Version: v10';
        $url = 'https://api.quickpay.net/'.$resource;
        if ($method == null) {
            if ($fields) {
                $method = 'POST';
            } else {
                $method = 'GET';
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($fields) {
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $fields));
        }
        return $ch;
    }

    public function doCurl($resource, $fields = null, $method = null)
    {
        $ch = $this->getCurlHandle($resource, $fields, $method);
        $data = curl_exec($ch);
        if (!$data) {
            $this->qp_error = curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }

    public function getFees($amount)
    {
        $setup = $this->setup;
        $data = $this->doCurl('fees/formulas');
        $vars = $this->jsonDecode($data);
        if (!is_array($vars)) {
            return false;
        }
        $fields = array('amount='.$amount);
        $chs = array();
        $mh = curl_multi_init();
        // curl_multi_setopt($mh, CURLMOPT_PIPELINING, 1);
        foreach ($vars as $var) {
            $url = 'fees/'.$var->acquirer.'/'.$var->payment_method;
            $ch = $this->getCurlHandle($url, $fields);
            curl_multi_add_handle($mh, $ch);
            $chs[$var->acquirer][$var->payment_method] = $ch;
        }
        while (true) {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
            if ($running == 0) {
                break;
            }
        }
        $fees = array();
        foreach ($vars as $var) {
            $ch = $chs[$var->acquirer][$var->payment_method];
            curl_multi_remove_handle($mh, $ch);
            $data = curl_multi_getcontent($ch);
            $row = $this->jsonDecode($data);
            if (empty($row->payment_method)) {
                continue;
            }
            if (isset($setup->lock_names[$row->payment_method])) {
                $lock_name = $setup->lock_names[$row->payment_method];
            } elseif (isset($setup->lock_names['3d-'.$row->payment_method])) {
                $lock_name = $row->payment_method; // Maestro
            } else {
                continue;
            }
            if (isset($fees[$lock_name])) {
                if ($row->fee < $fees[$lock_name]) {
                    $fees[$lock_name.'_f'] = $fees[$lock_name];
                    $fees[$lock_name.'_3d_f'] = $fees[$lock_name.'_3d'];
                    $fees[$lock_name] = $row->fee;
                    $fees[$lock_name.'_3d'] = $row->fee;
                }
                if ($row->fee > $fees[$lock_name]) {
                    $fees[$lock_name.'_f'] = $row->fee;
                    $fees[$lock_name.'_3d_f'] = $row->fee;
                }
            } else {
                $fees[$lock_name] = $row->fee;
                $fees[$lock_name.'_3d'] = $row->fee;
            }
        }
        curl_multi_close($mh);
        return $fees;
    }

    public function getBrandings()
    {
        $brandings = array();
        $data = $this->doCurl('brandings');
        if (!$data) {
            return false;
        }
        $vars = $this->jsonDecode($data);
        if (!$vars || isset($vars->errors) || isset($vars->message)) {
            return false;
        }
        foreach ($vars as $var) {
            $brandings[$var->id] = $var->name;
        }
        return $brandings;
    }

    public function getOrderingList($setup, $setup_vars)
    {
        $ordering_list = array();
        $hide_images_list = $this->imagesSetup();
        foreach ($setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            $var_name = $vars->var_name;
            $field = $var_name;
            if (!$setup->autoget && $vars->var_name == 'applepay') {
                continue;
            }
            if (!$vars->card_type_lock || !$setup->$field) {
                continue;
            }
            if ($setup->autoget && in_array($var_name, $setup->auto_ignore)) {
                continue;
            }
            if (!in_array($var_name, $ordering_list) && empty($hide_images_list[$var_name])) {
                $ordering_list[] = $var_name;
            }
            if (isset($setup->secure_list[$var_name]) && empty($hide_images_list[$var_name.'_secure'])) {
                $ordering_list[] = $setup->secure_list[$var_name];
            }
        }
        return $ordering_list;
    }

    public function getIso3($iso_code)
    {
        $iso3 = array(
            'AF' => 'AFG', 'AX' => 'ALA', 'AL' => 'ALB', 'DZ' => 'DZA',
            'AS' => 'ASM', 'AD' => 'AND', 'AO' => 'AGO', 'AI' => 'AIA',
            'AQ' => 'ATA', 'AG' => 'ATG', 'AR' => 'ARG', 'AM' => 'ARM',
            'AW' => 'ABW', 'AU' => 'AUS', 'AT' => 'AUT', 'AZ' => 'AZE',
            'BS' => 'BHS', 'BH' => 'BHR', 'BD' => 'BGD', 'BB' => 'BRB',
            'BY' => 'BLR', 'BE' => 'BEL', 'BZ' => 'BLZ', 'BJ' => 'BEN',
            'BM' => 'BMU', 'BT' => 'BTN', 'BO' => 'BOL', 'BQ' => 'BES',
            'BA' => 'BIH', 'BW' => 'BWA', 'BV' => 'BVT', 'BR' => 'BRA',
            'IO' => 'IOT', 'BN' => 'BRN', 'BG' => 'BGR', 'BF' => 'BFA',
            'BI' => 'BDI', 'CV' => 'CPV', 'KH' => 'KHM', 'CM' => 'CMR',
            'CA' => 'CAN', 'KY' => 'CYM', 'CF' => 'CAF', 'TD' => 'TCD',
            'CL' => 'CHL', 'CN' => 'CHN', 'CX' => 'CXR', 'CC' => 'CCK',
            'CO' => 'COL', 'KM' => 'COM', 'CG' => 'COG', 'CD' => 'COD',
            'CK' => 'COK', 'CR' => 'CRI', 'CI' => 'CIV', 'HR' => 'HRV',
            'CU' => 'CUB', 'CW' => 'CUW', 'CY' => 'CYP', 'CZ' => 'CZE',
            'DK' => 'DNK', 'DJ' => 'DJI', 'DM' => 'DMA', 'DO' => 'DOM',
            'EC' => 'ECU', 'EG' => 'EGY', 'SV' => 'SLV', 'GQ' => 'GNQ',
            'ER' => 'ERI', 'EE' => 'EST', 'ET' => 'ETH', 'FK' => 'FLK',
            'FO' => 'FRO', 'FJ' => 'FJI', 'FI' => 'FIN', 'FR' => 'FRA',
            'GF' => 'GUF', 'PF' => 'PYF', 'TF' => 'ATF', 'GA' => 'GAB',
            'GM' => 'GMB', 'GE' => 'GEO', 'DE' => 'DEU', 'GH' => 'GHA',
            'GI' => 'GIB', 'GR' => 'GRC', 'GL' => 'GRL', 'GD' => 'GRD',
            'GP' => 'GLP', 'GU' => 'GUM', 'GT' => 'GTM', 'GG' => 'GGY',
            'GN' => 'GIN', 'GW' => 'GNB', 'GY' => 'GUY', 'HT' => 'HTI',
            'HM' => 'HMD', 'VA' => 'VAT', 'HN' => 'HND', 'HK' => 'HKG',
            'HU' => 'HUN', 'IS' => 'ISL', 'IN' => 'IND', 'ID' => 'IDN',
            'IR' => 'IRN', 'IQ' => 'IRQ', 'IE' => 'IRL', 'IM' => 'IMN',
            'IL' => 'ISR', 'IT' => 'ITA', 'JM' => 'JAM', 'JP' => 'JPN',
            'JE' => 'JEY', 'JO' => 'JOR', 'KZ' => 'KAZ', 'KE' => 'KEN',
            'KI' => 'KIR', 'KP' => 'PRK', 'KR' => 'KOR', 'KW' => 'KWT',
            'KG' => 'KGZ', 'LA' => 'LAO', 'LV' => 'LVA', 'LB' => 'LBN',
            'LS' => 'LSO', 'LR' => 'LBR', 'LY' => 'LBY', 'LI' => 'LIE',
            'LT' => 'LTU', 'LU' => 'LUX', 'MO' => 'MAC', 'MK' => 'MKD',
            'MG' => 'MDG', 'MW' => 'MWI', 'MY' => 'MYS', 'MV' => 'MDV',
            'ML' => 'MLI', 'MT' => 'MLT', 'MH' => 'MHL', 'MQ' => 'MTQ',
            'MR' => 'MRT', 'MU' => 'MUS', 'YT' => 'MYT', 'MX' => 'MEX',
            'FM' => 'FSM', 'MD' => 'MDA', 'MC' => 'MCO', 'MN' => 'MNG',
            'ME' => 'MNE', 'MS' => 'MSR', 'MA' => 'MAR', 'MZ' => 'MOZ',
            'MM' => 'MMR', 'NA' => 'NAM', 'NR' => 'NRU', 'NP' => 'NPL',
            'NL' => 'NLD', 'NC' => 'NCL', 'NZ' => 'NZL', 'NI' => 'NIC',
            'NE' => 'NER', 'NG' => 'NGA', 'NU' => 'NIU', 'NF' => 'NFK',
            'MP' => 'MNP', 'NO' => 'NOR', 'OM' => 'OMN', 'PK' => 'PAK',
            'PW' => 'PLW', 'PS' => 'PSE', 'PA' => 'PAN', 'PG' => 'PNG',
            'PY' => 'PRY', 'PE' => 'PER', 'PH' => 'PHL', 'PN' => 'PCN',
            'PL' => 'POL', 'PT' => 'PRT', 'PR' => 'PRI', 'QA' => 'QAT',
            'RE' => 'REU', 'RO' => 'ROU', 'RU' => 'RUS', 'RW' => 'RWA',
            'BL' => 'BLM', 'SH' => 'SHN', 'KN' => 'KNA', 'LC' => 'LCA',
            'MF' => 'MAF', 'PM' => 'SPM', 'VC' => 'VCT', 'WS' => 'WSM',
            'SM' => 'SMR', 'ST' => 'STP', 'SA' => 'SAU', 'SN' => 'SEN',
            'RS' => 'SRB', 'SC' => 'SYC', 'SL' => 'SLE', 'SG' => 'SGP',
            'SX' => 'SXM', 'SK' => 'SVK', 'SI' => 'SVN', 'SB' => 'SLB',
            'SO' => 'SOM', 'ZA' => 'ZAF', 'GS' => 'SGS', 'SS' => 'SSD',
            'ES' => 'ESP', 'LK' => 'LKA', 'SD' => 'SDN', 'SR' => 'SUR',
            'SJ' => 'SJM', 'SZ' => 'SWZ', 'SE' => 'SWE', 'CH' => 'CHE',
            'SY' => 'SYR', 'TW' => 'TWN', 'TJ' => 'TJK', 'TZ' => 'TZA',
            'TH' => 'THA', 'TL' => 'TLS', 'TG' => 'TGO', 'TK' => 'TKL',
            'TO' => 'TON', 'TT' => 'TTO', 'TN' => 'TUN', 'TR' => 'TUR',
            'TM' => 'TKM', 'TC' => 'TCA', 'TV' => 'TUV', 'UG' => 'UGA',
            'UA' => 'UKR', 'AE' => 'ARE', 'GB' => 'GBR', 'UM' => 'UMI',
            'US' => 'USA', 'UY' => 'URY', 'UZ' => 'UZB', 'VU' => 'VUT',
            'VE' => 'VEN', 'VN' => 'VNM', 'VG' => 'VGB', 'VI' => 'VIR',
            'WF' => 'WLF', 'EH' => 'ESH', 'YE' => 'YEM', 'ZM' => 'ZMB',
            'ZW' => 'ZWE',
        );
        if (isset($iso3[$iso_code])) {
            return $iso3[$iso_code];
        } else {
            return $iso_code;
        }
    }

    public function getIso2($iso_code)
    {
        $iso2 = array(
            'DNK' => 'DK', 'FIN' => 'FI', 'NOR' => 'NO'
        );
        if (isset($iso2[$iso_code])) {
            return $iso2[$iso_code];
        } else {
            return $iso_code;
        }
    }

    public function getDecimals($iso_code)
    {
        $iso_code = $this->getIso3($iso_code);
        $decimals = array(
            'BHD' => 3,
            'BIF' => 0,
            'BYR' => 0,
            'CLF' => 4,
            'CLP' => 0,
            'CVE' => 0,
            'DJF' => 0,
            'GNF' => 0,
            'IQD' => 3,
            'ISK' => 0,
            'JOD' => 3,
            'JPY' => 0,
            'KMF' => 0,
            'KRW' => 0,
            'KWD' => 3,
            'LYD' => 3,
            'MGA' => 1,
            'MRO' => 1,
            'OMR' => 3,
            'PYG' => 0,
            'RWF' => 0,
            'TND' => 3,
            'UGX' => 0,
            'UYI' => 0,
            'VND' => 0,
            'VUV' => 0,
            'XAF' => 0,
            'XOF' => 0,
            'XPF' => 0,
        );
        if (isset($decimals[$iso_code])) {
            return $decimals[$iso_code];
        }
        return 2;
    }

    public function fromQpAmount($amount, $currency)
    {
        $decimals = $this->getDecimals($currency->iso_code);
        return $amount / pow(10, $decimals);
    }

    public function toQpAmount($amount, $currency)
    {
        $decimals = $this->getDecimals($currency->iso_code);
        return Tools::ps_round($amount * pow(10, $decimals));
    }

    public function displayQpAmount($amount, $currency)
    {
        $amount = $this->fromQpAmount($amount, $currency);
        return Tools::displayPrice($amount, $currency);
    }

    public function fromUserAmount($amount, $currency)
    {
        $use_comma = strpos(Tools::displayPrice(1.23, $currency), ',') !== false;
        if ($use_comma) {
            $amount = str_replace('.', '', $amount);
            $amount = str_replace(',', '.', $amount);
        } else {
            $amount = str_replace(',', '', $amount);
        }
        return $amount;
    }

    public function toUserAmount($amount, $currency)
    {
        $use_comma = strpos(Tools::displayPrice(1.23, $currency), ',') !== false;
        if ($use_comma) {
            $amount = str_replace('.', ',', $amount);
        }
        return $amount;
    }

    public function hookDisplayProductPriceBlock($data)
    {
        try {
            if (!empty($data) && isset($data['product'])) { //v16 iframe condition mandatory
                $product = $data['product'];
                //Product can be either object or array here

                $type = Tools::getValue('controller');
                if ($type === 'product') {
                    $renderAt = 'after_price';
                } else {
                    $type = 'list';
                    if ($this->v17) {
                        $renderAt = 'unit_price';
                    } else {
                        $renderAt = 'after_price';
                    }
                }

                if (!empty($product)
                    && isset($data['type'])
                    && $data['type'] === $renderAt
                    && $this->isViabillValid()
                ) {
                    $productId = 0;
                    if (is_object($product)) {
                        if ($this->v17) {
                            $productId = $product->getId();
                        } elseif ($this->v16) {
                            $productId = $product->id;
                        }
                    } elseif (is_array($product)) { //<= v16
                        $productId = $product['id_product'];
                    }

                    //We need different conditions for version support so here goes:
                    if ($productId && !isset($this->renderedViabillProducts[$productId])) {
                        //do not repeat more than once per product
                        $this->renderedViabillProducts[$productId] = true;

                        $this->context->smarty->assign('type', $type);
                        $this->context->smarty->assign('price', round(Product::getPriceStatic($productId), 2));
                        return $this->display(__FILE__, 'viabill/pricetag.tpl');
                    }
                }
            }
        } catch (Exception $e) {
        }
    }

    public function isViabillValid()
    {
        return $this->getSetup()->viabill && !empty($this->getSetup()->viabillid);
    }

    protected function getPageName()
    {
        if ($this->v17) {
            return $this->context->controller->getPageName();
        }
        // Are we in a payment module
        $module_name = '';
        if (Validate::isModuleName(Tools::getValue('module'))) {
            $module_name = Tools::getValue('module');
        }

        if (!empty($this->page_name)) {
            $page_name = $this->page_name;
        } elseif (!empty($this->php_self)) {
            $page_name = $this->php_self;
        } elseif (Tools::getValue('fc') == 'module'
            && $module_name != ''
            && (Module::getInstanceByName($module_name) instanceof PaymentModule)
        ) {
            $page_name = 'module-payment-submit';
        } elseif (preg_match(
            '#^' . preg_quote($this->context->shop->physical_uri, '#') . 'modules/([a-zA-Z0-9_-]+?)/(.*)$#',
            $_SERVER['REQUEST_URI'],
            $m
        )) {
            // @retrocompatibility Are we in a module ?
            $page_name = 'module-' . $m[1] . '-' . str_replace(array('.php', '/'), array('', '-'), $m[2]);
        } else {
            $page_name = Dispatcher::getInstance()->getController();
            $page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_' . $page_name : $page_name);
        }

        return $page_name;
    }

    public function hookDisplayHeader()
    {
        if ($this->getPageName() === 'cart') {
            $this->context->controller->addCSS($this->_path.'/views/css/cart.css');
            $this->context->controller->addJS($this->_path.'/views/js/cart.js');
        }
        if ($this->isViabillValid()) {
            $this->context->smarty->assign('viabillId', $this->getSetup()->viabillid);
            return $this->display(__FILE__, 'viabill/init.tpl');
        }
    }

    public function hookHeader()
    {
        if ($this->v16) {
            $this->context->controller->addCSS($this->_path.'/views/css/front.css');
        } else {
            $this->context->controller->addCSS($this->_path.'/views/css/front15.css');
        }
    }

    public function hookPaymentTop()
    {
        $this->hookHeader();
    }


    public function makePayment($params, &$paymentOptions, $select_option = 0)
    {
        if (function_exists('stream_resolve_include_path') &&
            stream_resolve_include_path(
                _PS_MODULE_DIR_.'pensopay/pensopay.inc.php'
            )
        ) {
            include _PS_MODULE_DIR_.'pensopay/pensopay.inc.php';
        }
        $setup = $this->getSetup();
        $hide_images_list = $this->imagesSetup();
        $smarty = $this->context->smarty;
        $cart = $params['cart'];
        $invoice_address = new Address((int)$cart->id_address_invoice);
        $invoice_street = $invoice_address->address1;
        if ($invoice_address->address2) {
            $invoice_street .= ' '.$invoice_address->address2;
        }
        $country = new Country($invoice_address->id_country);
        if ($invoice_address->id) {
            $invoice_country_code = $this->getIso3($country->iso_code);
        } else {
            $invoice_country_code = 'DNK';
        }
        $delivery_address = new Address((int)$cart->id_address_delivery);
        $delivery_street = $delivery_address->address1;
        if ($delivery_address->address2) {
            $delivery_street .= ' '.$delivery_address->address2;
        }
        $customer = new Customer((int)$cart->id_customer);
        if ($customer->secure_key) {
            $key2 = 0;
        } else {
            $key2 = 1;
            $customer->secure_key = md5(uniqid(rand(), true));
        }
        $id_currency = (int)$cart->id_currency;
        $currency = new Currency($id_currency);

        $language = new Language($this->context->language->id);
        $cart_total = $this->toQpAmount($cart->getOrderTotal(), $currency);
        if (isset($cart->qpPreview)) {
            $cart_total = 10000;
        }
        $continueurl = $this->getModuleLink(
            'complete',
            array(
                'key' => $customer->secure_key,
                'key2' => $key2,
                'id_cart' => (int)$cart->id,
                'id_module' => (int)$this->id,
                'utm_nooverride' => 1
            )
        );
        if ($setup->paymethod == self::METHOD_IFRAME) {
            $cookies = Context::getContext()->cookie;
            $cookies->__set(self::COOKIE_CONTINUEURL, $continueurl);
            $cookies->write();
            $continueurl = $this->getModuleLink('iframeresponse');
            $cancelurl = $this->getModuleLink('iframeresponse', array(self::MODE_VARIABLE => self::MODE_CANCEL));
            $payment_url = $this->getModuleLink('iframe');
        } else {
            $cancelurl = $this->getPageLink('order', 'step=3');
            $payment_url = $this->getModuleLink('payment');
        }
        $callbackurl = $this->getModuleLink('validation');

        $html = '';

        if ($setup->autofee) {
            $fees = $this->getFees($cart_total);
        } else {
            $fees = false;
        }

        $order_id = $setup->orderprefix.(int)$cart->id;
        $done = false;
        $setup_vars = $this->sortSetup();
        foreach ($setup_vars as $setup_var) {
            $id_option = $setup_var[1];
            if ($select_option && $id_option != $select_option) {
                continue;
            }
            $vars = $this->varsObj($setup_var);
            $card_list = array($vars->var_name);
            $card_text = $vars->card_text;
            $field = $vars->var_name;
            if (!$setup->autoget && $vars->var_name == 'applepay') {
                continue;
            }
            if (!$vars->card_type_lock || !$setup->$field) {
                continue;
            }
            $card_type_lock = $vars->card_type_lock;
            if ($setup->combine &&
                    isset($setup->credit_cards[$vars->var_name])) {
                // Group these cards
                if ($done) {
                    continue;
                }
                $card_text = $this->l('credit card');
                $card_list = array_keys($setup->credit_cards);
                $card_type_lock = implode(',', $setup->card_type_locks);
                $done = true;
            }
            if ($setup->autoget && isset($setup->credit_cards[$vars->var_name])) {
                    $card_type_lock = '';
            }
            if ($vars->var_name == 'mobilepay' &&
                empty($cart->qpPreview) &&
                $invoice_country_code != 'DNK' &&
                $invoice_country_code != 'NOR' &&
                $invoice_country_code != 'FIN') {
                continue;
            }
            if ($vars->var_name == 'swish' &&
                empty($cart->qpPreview) &&
                $invoice_country_code != 'SWE') {
                continue;
            }
            if ($vars->var_name == 'viabill') {
                if (empty($cart->qpPreview) &&
                    $invoice_country_code != 'DNK') {
                    continue;
                }
                // Autofee does not work
                $amount = $cart_total;
                $autofee = 0;
            } elseif ($vars->var_name == 'klarna') {
                // Autofee does not work
                $amount = $cart_total;
                $autofee = 0;
            } else {
                $amount = $cart_total;
                $autofee = $setup->autofee;
            }
            $fee_texts = array();
            if ($card_list) {
                foreach ($card_list as $card_name) {
                    if ($autofee && ($card_name == 'mobilepay' || $card_name == 'swish')) {
                        $fee_text = array();
                        $fee_text['name'] = $this->l('Fee will be included in the payment window').
                            $fee_text['amount'] = '';
                        $fee_texts[] = $fee_text;
                        continue;
                    }
                    if (!empty($fees[$card_name])) {
                        $fee_text = array();
                        if ($card_name == 'viabill') {
                            $fee_text['name'] = $this->l('Fee for').
                                ' '.$this->l('ViaBill').":\xC2\xA0";
                        } else {
                            $fee_text['name'] = $this->l('Fee for').
                                ' '.$setup->card_texts[$card_name].":\xC2\xA0";
                        }
                        $fee_text['amount'] =
                            $this->displayQpAmount($fees[$card_name], $currency);
                        if (!empty($fees[$card_name.'_f'])) {
                            $fee_text['amount'] .= sprintf(
                                ' (%s: %s)',
                                $this->l('foreign'),
                                $this->displayQpAmount($fees[$card_name.'_f'], $currency)
                            );
                        }
                        $fee_texts[] = $fee_text;
                        if ($card_name == 'dk') {
                            $fee_texts = array();
                            $fee_text['name'] = $this->l('Fee for').
                                ' '.$this->l('Visa/Dankort').":\xC2\xA0";
                            if ($currency->iso_code != 'DKK' && isset($fees['visa'])) {
                                $fee_text['amount'] = $this->displayQpAmount($fees['visa'], $currency);
                            } else {
                                $fee_text['amount'] = $this->displayQpAmount($fees[$card_name], $currency);
                            }
                            $fee_texts[] = $fee_text;
                        }
                    }
                }
            }
            $images_list = array();
            foreach ($card_list as $card) {
                if (empty($hide_images_list[$card])) {
                    $images_list[] = $card;
                }
                if (isset($setup->secure_list[$card]) && empty($hide_images_list[$card.'_secure'])) {
                    $images_list[] = $setup->secure_list[$card];
                }
            }
            $smarty->assign('fees', $fee_texts);
            $branding = $setup->branding ? $setup->branding : '';
            $csum_fields = array(
                'amount'            => $amount,
                'autocapture'       => $setup->autocapture,
                'autofee'           => $autofee,
                'branding_id'       => $branding,
                'callback_url'      => $callbackurl,
                'cancel_url'        => $cancelurl,
                'continue_url'      => $continueurl,
                'currency'          => $currency->iso_code,
                'language'          => $language->iso_code,
                'merchant_id'       => $setup->merchant_id,
                'order_id'          => $order_id,
                'payment_methods'   => $card_type_lock,
                'text_on_statement' => $setup->statementtext,
            );
            $smarty_fields = array();
            foreach ($csum_fields as $key => $value) {
                $smarty_fields[] = array(
                    'name' => $key,
                    'value' => $value
                );
            }
            if ($select_option) {
                return $smarty_fields;
            }
            $fields = array(
                'fields'      => $smarty_fields,
                'payment_url' => $payment_url,
                'imgs'        => $images_list,
                'text'        => $this->l('Pay with').' '.$card_text,
                'type'        => $vars->var_name,
                'module_dir'  => $this->_path,
                'no_print_link'  => isset($params['no_print_link']) && $params['no_print_link'],
                'cart_total'  => $cart->getOrderTotal(true)
            );

            $smarty->assign($fields);
            if ($this->v17 && empty($cart->qpPreview)) {
                $parms = array('option' => $id_option, 'order_id' => $order_id);
                $tpl = 'module:pensopay/views/templates/hook/pensopay17.tpl';

                if ($this->setup->paymethod == self::METHOD_IFRAME) {
                    $moduleLink = $this->getModuleLink('iframe', $parms);
                } else {
                    $moduleLink = $this->getModuleLink('payment', $parms);
                }
                $newOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
                $newOption->setCallToActionText($fields['text'])
                    ->setAction($moduleLink)
                    ->setAdditionalInformation($this->fetch($tpl));
                $paymentOptions[] = $newOption;
            } else {
                if (Module::isInstalled('onepagecheckout')) {
                    $smarty->assign('onepagecheckout', true);
                }
                $html .= $this->display(__FILE__, 'views/templates/hook/pensopay.tpl');
            }
        }

        return $html;
    }

    public function previewPayment()
    {
        $params = array();
        $paymentOptions = array();
        $cart = new Cart();
        $cart->id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
        $cart->qpPreview = true;

        $params['cart'] = $cart;
        $params['no_print_link'] = true;

        $this->context->smarty->assign('title', $this->l('Payment preview'));
        $this->context->smarty->assign('html', $this->makePayment($params, $paymentOptions));
        $html = $this->display(__FILE__, 'views/templates/hook/preview.tpl');

        $this->context->smarty->assign('title', $this->l('Card logo preview'));
        $this->context->smarty->assign('html', $this->hookLeftColumn(false));
        $html .= $this->display(__FILE__, 'views/templates/hook/preview.tpl');
        return $html;
    }


    public function hookPayment($params)
    {
        $paymentOptions = array();
        return $this->makePayment($params, $paymentOptions);
    }


    public function hookPaymentOptions($params)
    {
        $paymentOptions = array();
        $this->makePayment($params, $paymentOptions);
        return $paymentOptions;
    }


    public function hookLeftColumn($doCenter = true)
    {
        $smarty = $this->context->smarty;

        $setup = $this->getSetup();
        $setup_vars = $this->sortSetup();
        if ($setup->showcards) {
            $ordering_list = $this->getOrderingList($setup, $setup_vars);
        } else {
            $ordering_list = array();
        }

        if ($ordering_list) {
            $smarty->assign(
                array(
                    'ordering_list' => $ordering_list,
                    'link' => $this->context->link,
                    'doCenter' => $doCenter
                )
            );
            return $this->display(__FILE__, 'views/templates/hook/leftpensopay.tpl');
        }
        return '';
    }

    public function hookRightColumn()
    {
        return $this->hookLeftColumn();
    }

    public function hookFooter()
    {
        $smarty = $this->context->smarty;

        $setup = $this->getSetup();
        if (!$setup->showcardsfooter) {
            return;
        }

        $setup_vars = $this->sortSetup();
        $ordering_list = $this->getOrderingList($setup, $setup_vars);

        if ($ordering_list) {
            $smarty->assign(
                array(
                    'ordering_list' => $ordering_list,
                    'link' => $this->context->link
                )
            );
            return $this->display(__FILE__, 'views/templates/hook/footerpensopay.tpl');
        }
        return '';
    }

    public function getBrand($vars)
    {
        if (empty($this->setup_vars)) {
            $this->getSetup();
        }
        $brand = $vars->metadata->brand;
        if (!$brand) {
            $brand = $vars->acquirer;
        }
        foreach ($this->setup_vars as $setup_var) {
            $vars = $this->varsObj($setup_var);
            $card_type_locks = explode(',', $vars->card_type_lock);
            if (in_array($brand, $card_type_locks)) {
                $text = explode(' ', $vars->card_text);
                $brand = $text[0];
                break;
            }
        }
        return $brand;
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        if ($this->v17) {
            $order = $params['order'];
        } else {
            $order = $params['objOrder'];
        }
        $state = $order->getCurrentState();
        if ($state == _PS_OS_ERROR_) {
            $status = 'callback';
            $msg = 'PensoPay: Confirmation failed';
            $this->addLog($msg, 2, 0, 'Order', $order->id);
        } else {
            $status = 'ok';
        }
        $this->smarty->assign('status', $status);
        if ($this->v17) {
            $url = $this->getPageLink('contact', 'file');
            $this->smarty->assign('shop_name', Configuration::get('PS_SHOP_NAME'));
            $this->smarty->assign('base_dir_ssl', $url);
        }
        $trans = Db::getInstance()->getRow(
            'SELECT *
            FROM '._DB_PREFIX_.'pensopay_execution
            WHERE `id_cart` = '.$order->id_cart.'
            ORDER BY `id_cart` ASC'
        );
        $json = $trans['json'];
        $vars = $this->jsonDecode($json);
        $query = parse_url($vars->link->continue_url, PHP_URL_QUERY);
        parse_str($query, $args);
        if (isset($args['key2']) && $args['key2']) {
            $this->context->customer->mylogout();
        }
        return $this->display(__FILE__, 'views/templates/hook/confirmation.tpl');
    }

    public function hookAdminOrder($params)
    {
        $order = new Order((int)$params['id_order']);
        if ($this->v15) {
            $this->orderShopId = $order->id_shop;
        }
        $setup = $this->getSetup();
        if (!$setup->api) {
            return '';
        }

        $currency = new Currency((int)$order->id_currency);
        $module = Db::getInstance()->getRow(
            'SELECT `module`
            FROM '._DB_PREFIX_.'orders
            WHERE `id_order` = '.(int)$params['id_order']
        );
        if ($module['module'] != 'pensopay') {
            return '';
        }
        $trans = Db::getInstance()->getRow(
            'SELECT *
            FROM '._DB_PREFIX_.'pensopay_execution
            WHERE `id_cart` = '.$order->id_cart.'
            ORDER BY `exec_id` ASC'
        );
        if ($trans) {
            $trans_id = $trans['trans_id'];
            $order_id = $trans['order_id'];
        } else {
            // Look for payment via API
            $order_id = $setup->orderprefix.(int)$order->id_cart;
            $json = $this->doCurl('payments', array('order_id='.$order_id), 'GET');
            $vars = $this->jsonDecode($json);
            $vars = reset($vars);
            if (empty($vars->id)) {
                return '';
            }
            $trans_id = $vars->id;
            $order_id = $vars->order_id;
        }

        $smarty = $this->context->smarty;

        $smarty->assign('img_path', $this->_path);
        $smarty->assign('title', $this->l('PensoPay API'));

        $double_post = false;
        $status_data = $this->doCurl('payments/'.$trans_id);
        if (!empty($status_data)) {
            $vars = $this->jsonDecode($status_data);
            if (!empty($vars->id) &&
                    Tools::getValue('qp_count') < count($vars->operations)) {
                $double_post = true;
            }
        }

        if (!$double_post && Tools::isSubmit('qpcapture')) {
            $amount = Tools::getValue('acramount');
            $amount = $this->fromUserAmount($amount, $currency);
            $amount = $this->toQpAmount($amount, $currency);
            $fields = array('amount='.$amount);
            $action_data = $this->doCurl('payments/'.$trans_id.'/capture', $fields);
        }

        if (!$double_post && Tools::isSubmit('qprefund')) {
            $amount = Tools::getValue('acramountref');
            $amount = $this->fromUserAmount($amount, $currency);
            $amount = $this->toQpAmount($amount, $currency);
            $fields = array('amount='.$amount);
            $action_data = $this->doCurl('payments/'.$trans_id.'/refund', $fields);
        }

        if (!$double_post && Tools::isSubmit('qpcancel')) {
            $action_data = $this->doCurl('payments/'.$trans_id.'/cancel', null, 'POST');
        }

        if (isset($action_data)) {
            $vars = $this->jsonDecode($action_data);
            if (isset($vars) && isset($vars->errors) && get_object_vars($vars->errors)) {
                $smarty->assign('errors', true);
                if (isset($vars->errors->amount) && $vars->errors->amount[0] == 'is too large') {
                    $smarty->assign('error_text', $this->l('Amount is too large'));
                } else {
                    $smarty->assign('error_json', print_r($this->jsonDecode($action_data), true));
                }
            } elseif (isset($vars) && isset($vars->message)) {
                $smarty->assign('errors', true);
                $smarty->assign('error_text', $vars->message);
            }
        }

        // Get status reply from pensopay
        $status_data = $this->doCurl('payments/'.$trans_id);
        if (empty($status_data)) {
            $smarty->assign('fatal_error', true);
            $smarty->assign('fatal_error_text', $this->curl_error);
            if ($this->v16) {
                return $this->display(__FILE__, 'admin/order/payment.tpl');
            }
            return $this->display(__FILE__, 'admin/order/payment15.tpl');
        }
        $vars = $this->jsonDecode($status_data);
        if (empty($vars->id)) {
            $smarty->assign('fatal_error', true);
            $smarty->assign('fatal_error_text', $vars->message);
            if ($this->v16) {
                return $this->display(__FILE__, 'admin/order/payment.tpl');
            }
            return $this->display(__FILE__, 'admin/order/payment15.tpl');
        }

        $smarty->assign('test_mode', $vars->test_mode);
        $smarty->assign('order_id', $order_id);
        $smarty->assign('transaction_id', $vars->id);
        $smarty->assign('acquirer', Tools::ucfirst($vars->acquirer) . ' ' . Tools::ucfirst($vars->facilitator));
        $smarty->assign('card_type', Tools::ucfirst($vars->metadata->brand) . ' ' . $this->l('[3D secure]'));
        $smarty->assign('country', $vars->metadata->country);
        $smarty->assign('created', Tools::displayDate(date('Y-m-d H:i:s', strtotime($vars->created_at)), null, true));

        if ($vars->metadata->fraud_suspected) {
            if (empty($vars->metadata->fraud_remarks)) {
                $vars->metadata->fraud_remarks[] = $this->l('Suspicious payment');
            }
            $smarty->assign('fraud_remarks', $vars->metadata->fraud_remarks);
        }

        $resttocap = - $vars->balance;
        $resttoref = 0;
        $allowcancel = true;
        $qp_count = count($vars->operations);
        $qp_total = $this->toQpAmount($order->total_paid, $currency);

        $smartyOperations = array();
        foreach ($vars->operations as $operation) {
            $smartyOperation = array(
                'date' => Tools::displayDate(date('Y-m-d H:i:s', strtotime($operation->created_at)), null, true)
            );

            switch ($operation->type) {
                case 'capture':
                    $resttoref += $operation->amount;
                    $resttocap -= $operation->amount;
                    $allowcancel = false;
                    $status = $this->l('Captured');
                    break;
                case 'authorize':
                    if ($operation->aq_status_code == 202) {
                        $resttocap = 0;
                        $status = $this->l('Waiting for approval');
                    } else {
                        if ($operation->amount > $qp_total) {
                            $resttocap = $qp_total;
                        } else {
                            $resttocap = $operation->amount;
                        }
                        $status = $this->l('Authorized');
                    }
                    break;
                case 'refund':
                    $resttoref -= $operation->amount;
                    $resttocap += $operation->amount;
                    $status = $this->l('Refunded');
                    break;
                case 'cancel':
                    $resttocap = 0;
                    $allowcancel = false;
                    $status = $this->l('Cancelled');
                    break;
                case 'session':
                    $resttocap += $operation->amount;
                    $status = $this->l('Pending');
                    break;
                default:
                    $status = $operation->type;
                    break;
            }
            if ($operation->qp_status_code != '20000') {
                $status .= ' [' . $this->l('Not approved!') . ']';
            }
            $smartyOperation['status'] = $status;
            $smartyOperation['amount'] = $this->displayQpAmount($operation->amount, $currency);
            $smartyOperations[] = $smartyOperation;
        }
        $smarty->assign('operations', $smartyOperations);

        if ($resttocap < 0) {
            $resttocap = 0;
        }
        $resttocap = $this->fromQpAmount($resttocap, $currency);
        if ($resttoref < 0) {
            $resttoref = 0;
        }
        $resttoref = $this->fromQpAmount($resttoref, $currency);

        if ($this->v15) {
            $url = 'index.php?controller='.Tools::getValue('controller');
            $url .= '&id_order='.Tools::getValue('id_order');
            $url .= '&vieworder&token='.Tools::getValue('token');
        } else {
            $url = 'index.php?tab='.Tools::getValue('tab');
            $url .= '&id_order='.Tools::getValue('id_order');
            $url .= '&vieworder&token='.Tools::getValue('token');
        }

        $smarty->assign('url', $url);
        $smarty->assign('resttocap', $resttocap);
        $smarty->assign('resttoref', $resttoref);
        $smarty->assign('allowcancel', $allowcancel);
        $smarty->assign('qp_count', $qp_count);
        $smarty->assign('resttocap_render', $this->toUserAmount($resttocap, $currency));
        $smarty->assign('resttoref_render', $this->toUserAmount($resttoref, $currency));

        if ($this->v16) {
            return $this->display(__FILE__, 'admin/order/payment.tpl');
        }
        return $this->display(__FILE__, 'admin/order/payment15.tpl');
    }


    public function hookPDFInvoice($params)
    {
        if ($this->v15) {
            $object = $params['object'];
            $order = new Order((int)$object->id_order);
        } else {
            $pdf = $params['pdf'];
            $order = new Order($params['id_order']);
        }
        $trans = Db::getInstance()->getRow(
            'SELECT *
            FROM '._DB_PREFIX_.'pensopay_execution
            WHERE `id_cart` = '.$order->id_cart.'
            ORDER BY `exec_id` ASC'
        );
        if (isset($trans['trans_id'])) {
            // $brand = $this->metadata->brand;
            $vars = $this->jsonDecode($trans['json']);
            if ($this->v15) {
                $smarty = $this->context->smarty;
                $smarty->assign('transaction_id', $trans['trans_id']);

                if (isset($vars->acquirer) && $vars->acquirer == 'viabill') {
                    $smarty->assign('viabill', true);
                }
                return $this->display(__FILE__, 'admin/order/pdf.tpl');
            } else {
                $encoding = $pdf->encoding();
                $old_str = Tools::iconv('utf-8', $encoding, $order->payment);
                $new_str = Tools::iconv(
                    'utf-8',
                    $encoding,
                    $order->payment.' TransID: '.$trans['trans_id']
                );
                $pdf->pages[1] = str_replace($old_str, $new_str, $pdf->pages[1]);
                if (isset($vars->acquirer) && $vars->acquirer == 'viabill') {
                    $pdf->Ln(14);
                    $width = 165;
                    $txt = Tools::iconv(
                        'utf-8',
                        $encoding,
                        'Det skyldige beløb kan alene betales med frigørende virkning til ViaBill, '.
                        'som fremsender særskilt opkrævning.'
                    );
                    $pdf->Cell($width, 3, $txt, 0, 2, 'L');
                    $txt = Tools::iconv(
                        'utf-8',
                        $encoding,
                        'Betaling kan ikke ske ved modregning af krav, der udspringer af andre retsforhold.'
                    );
                    $pdf->Cell($width, 3, $txt, 0, 2, 'L');
                }
            }
        }
    }

    public function hookPostUpdateOrderStatus($params)
    {
        $this->getSetup();
        $new_state = $params['newOrderStatus'];
        $order = new Order($params['id_order']);
        $capture_statue = Configuration::get('_PENSOPAY_STATECAPTURE');
        if ($capture_statue == $new_state->id) {
            $trans = Db::getInstance()->getRow(
                'SELECT *
                FROM '._DB_PREFIX_.'pensopay_execution
                WHERE `id_cart` = '.$order->id_cart.'
                ORDER BY `exec_id` ASC'
            );
            if ($trans) {
                $vars = $this->jsonDecode($trans['json']);
                $amount = $this->getAmount($vars);
                if ($amount) {
                    $currency = new Currency((int)$order->id_currency);
                    $amount_order = $this->toQpAmount($order->total_paid, $currency);
                    if ($amount > $amount_order) {
                        $amount = $amount_order;
                    }
                    $fields = array('amount='.$amount);
                    $this->doCurl('payments/'.$trans['trans_id'].'/capture', $fields);
                }
            }
        }
    }

    //<=1.6 below the total label
//    public function hookDisplayCartTotalPriceLabel($params)
//    {
//        $cart = $params['cart'];
//
//        if ($this->isViabillValid()) {
//            $smarty = $this->context->smarty;
//            $smarty->assign('type', 'basket');
//            $smarty->assign('price', round($cart->getOrderTotal(), 2));
//            return $this->display(__FILE__, 'viabill/pricetag.tpl');
//        }
//    }

    public function hookDisplayExpressCheckout($params)
    {
        $html = '';
        $cart = $params['cart'];

        if ($this->v17 && $this->isViabillValid()) {
            $smarty = $this->context->smarty;
            $smarty->assign('type', 'basket');
            $smarty->assign('price', round($cart->getOrderTotal(), 2));
            $html .= $this->display(__FILE__, 'viabill/pricetag.tpl');
        }

        if (!$this->v17) {
            return $html;
        }

        if (!$this->getConf('_PENSOPAY_MOBILEPAY_CHECKOUT')) {
            return $html;
        }
        $invoice_address = new Address((int)$cart->id_address_invoice);
        $country = new Country($invoice_address->id_country);
        if ($country->iso_code && !in_array($country->iso_code, array('DK', 'FI', 'NO'))) {
            return $html;
        }
        $prefix = $this->getConf('_PENSOPAY_ORDER_PREFIX');
        $order_id = $prefix.(int)$cart->id;
        $parms = array(
            'option' => 'mobilepay',
            'order_id' => $order_id,
            'mobilepay_checkout' => 1
        );


        $setup = $this->getSetup();
        if ($setup->paymethod == self::METHOD_IFRAME) {
            $payment_url = $this->getModuleLink('iframe', $parms);
        } else {
            $payment_url = $this->getModuleLink('payment', $parms);
        }

        $this->context->smarty->assign('payment_url', $payment_url);

        $conditionsFinder = new ConditionsToApproveFinder(
            $this->context,
            $this->getTranslator()
        );
        $this->context->smarty->assign('conditions_to_approve', $conditionsFinder->getConditionsToApproveForTemplate());
        return $html . $this->display(__FILE__, 'mobilepay.tpl');
    }

    public function hookShoppingCartExtra($params)
    {
        if ($this->v17) {
            return '';
        }
        return $this->hookDisplayExpressCheckout($params);
    }

    public function sign($data, $key)
    {
        return call_user_func('hash_hmac', 'sha256', $data, $key);
    }

    public function group($entries)
    {
        return "('".implode("','", $entries)."')";
    }

    public function payment()
    {
        $setup = $this->getSetup();
        $fields = array();
        $id_option = Tools::getValue('option');
        $order_id = Tools::getValue('order_id');
        $mobilepay_checkout = Tools::getValue('mobilepay_checkout');
        $id_cart = (int)Tools::substr($order_id, 3);
        $cart = new Cart($id_cart);
        if ($id_option) {
            $params = array('cart' => $cart);
            $paymentOptions = array();
            $sfields = $this->makePayment($params, $paymentOptions, $id_option);
            foreach ($sfields as $sfield) {
                $fields[] = $sfield['name'].'='.urlencode($sfield['value']);
            }
        } else {
            foreach ($_POST as $k => $v) {
                if ($v != '') {
                    $fields[] = $k.'='.urlencode($v);
                }
            }
        }
        $delivery_address = new Address($cart->id_address_delivery);
        $carrier = new Carrier($cart->id_carrier);
        $invoice_address = new Address((int)$cart->id_address_invoice);
        $invoice_street = $invoice_address->address1;
        if ($invoice_address->address2) {
            $invoice_street .= ' '.$invoice_address->address2;
        }
        $country = new Country($invoice_address->id_country);
        $invoice_country_code = $this->getIso3($country->iso_code);
        $delivery_address = new Address((int)$cart->id_address_delivery);
        $delivery_street = $delivery_address->address1;
        if ($delivery_address->address2) {
            $delivery_street .= ' '.$delivery_address->address2;
        }
        $country = new Country($delivery_address->id_country);
        $delivery_country = $this->getIso3($country->iso_code);
        $customer = new Customer((int)$cart->id_customer);
        $currency = new Currency((int)$cart->id_currency);
        $info = array(
            'variables[module_version]' => $this->version,
            'shopsystem[name]' => 'PrestaShop',
            'shopsystem[version]' => $this->version,
            'customer_email' => $customer->email,
            'google_analytics_client_id' => $setup->ga_client_id,
            'google_analytics_tracking_id' => $setup->ga_tracking_id
        );
        if ($setup->paymethod == self::METHOD_IFRAME) {
            $info['framed'] = true;
        }
        if ($mobilepay_checkout) {
            $info += array(
                'invoice_address_selection' => true,
                'shipping_address_selection' => true
            );
        }
        if ($invoice_address->id) {
            $info += array(
                'invoice_address[name]' => $invoice_address->firstname.' '.$invoice_address->lastname,
                'invoice_address[street]' => $invoice_street,
                'invoice_address[city]' => $invoice_address->city,
                'invoice_address[zip_code]' => $invoice_address->postcode,
                'invoice_address[country_code]' => $invoice_country_code,
                'invoice_address[phone_number]' => $invoice_address->phone,
                'invoice_address[mobile_number]' => $invoice_address->phone_mobile,
                'invoice_address[vat_no]' => $invoice_address->vat_number,
                'invoice_address[email]' => $customer->email,
                'shipping_address[name]' => $delivery_address->firstname.' '.$delivery_address->lastname,
                'shipping_address[street]' => $delivery_street,
                'shipping_address[city]' => $delivery_address->city,
                'shipping_address[zip_code]' => $delivery_address->postcode,
                'shipping_address[country_code]' => $delivery_country,
                'shipping_address[phone_number]' => $delivery_address->phone,
                'shipping_address[mobile_number]' => $delivery_address->phone_mobile,
                'shipping_address[vat_no]' => $delivery_address->vat_number,
                'shipping_address[email]' => $customer->email
            );
        }
        foreach ($info as $k => $v) {
            $fields[] = $k.'='.urlencode($v);
        }
        if (!in_array('payment_methods=paypal', $fields)) {
            $info = array(
                'shipping[amount]' => $this->toQpAmount($cart->getTotalShippingCost(), $currency),
                'shipping[vat_rate]' => $carrier->getTaxesRate($delivery_address) / 100,
            );
            foreach ($info as $k => $v) {
                $fields[] = $k.'='.urlencode($v);
            }
            foreach ($cart->getProducts() as $product) {
                $info = array(
                    'basket[][qty]' => $product['cart_quantity'],
                    'basket[][item_no]' => $product['id_product'],
                    'basket[][item_name]' => $product['name'],
                    'basket[][item_price]' => $this->toQpAmount($product['price_wt'], $currency),
                    'basket[][vat_rate]' => $product['rate'] / 100
                );
                foreach ($info as $k => $v) {
                    $fields[] = $k.'='.urlencode($v);
                }
            }
        }
        if (!Validate::isLoadedObject($cart)) {
            $msg = 'PensoPay: Payment error. Not a valid cart';
            $this->addLog($msg, 2, 0, 'Cart', $id_cart);
            die('Not a valid cart');
        }
        Db::getInstance()->Execute(
            'DELETE
            FROM '._DB_PREFIX_.'pensopay_execution
            WHERE `id_cart` = '.$id_cart
        );
        $json = $this->doCurl('payments', $fields);
        $vars = $saved_vars = $this->jsonDecode($json);
        if (empty($vars->id)) {
            // Payment already exists
            $json = $this->doCurl('payments', array('order_id='.$order_id), 'GET');
            $vars = $this->jsonDecode($json);
            if (isset($vars->message)) {
                if (isset($saved_vars->message)) {
                    $msg = 'PensoPay: Payment error: '.$saved_vars->message;
                    $this->addLog($msg, 2, 0, 'Cart', $id_cart);
                    die($saved_vars->message);
                } else {
                    $msg = 'PensoPay: Payment error: '.$vars->message;
                    $this->addLog($msg, 2, 0, 'Cart', $id_cart);
                    die($vars->message);
                }
            }
            $vars = reset($vars);
            if (empty($vars->id)) {
                if (empty($this->qp_error)) {
                    $msg = 'PensoPay: Payment error: '.$saved_vars->message;
                } else {
                    $msg = 'PensoPay: cURL error: '.$this->qp_error;
                }
                $this->addLog($msg, 2, 0, 'Cart', $id_cart);
                die($msg);
            }
            $this->doCurl('payments/'.$vars->id, $fields, 'PATCH');
        }
        $values = array($id_cart, $vars->id, $vars->order_id, 0, 0, pSql($json));
        Db::getInstance()->Execute(
            'INSERT INTO '._DB_PREFIX_.'pensopay_execution
            (`id_cart`, `trans_id`, `order_id`, `accepted`, `test_mode`, `json`)
            VALUES '.$this->group($values)
        );
        if ($vars->accepted) {
            // Already paid
            $msg = 'PensoPay: Payment notice: Already paid';
            $this->addLog($msg, 2, 0, 'Cart', $id_cart);
            $paid_url = $this->getModuleLink(
                'complete',
                array(
                    'key' => $customer->secure_key,
                    'id_cart' => (int)$cart->id,
                    'id_module' => (int)$this->id
                )
            );
            Tools::redirect($paid_url, '');
            return;
        }
        if ($currency->iso_code != $vars->currency) {
            /*
               $fields = array('currency' => $currency->iso_code);
               $res = $this->doCurl('payments/'.$vars->id, $fields, 'PATCH');
             */
            $msg = sprintf(
                'PensoPay: Payment error: Currency was changed from %s to %s',
                $vars->currency,
                $currency->iso_code
            );
            $this->addLog($msg, 2, 0, 'Cart', $id_cart);
            $cart->delete();
            $fail_url = $this->getModuleLink('fail', array('status' => 'currency'));
            Tools::redirect($fail_url, '');
            return;
        }
        $json = $this->doCurl('payments/'.$vars->id.'/link', $fields, 'PUT');
        $vars = $this->jsonDecode($json);
        if (isset($vars->message)) {
            $msg = 'PensoPay: Payment error: '.$vars->message;
            $this->addLog($msg, 2, 0, 'Cart', $id_cart);
            die($vars->message);
        }
        if ($setup->paymethod == self::METHOD_IFRAME) {
            return $vars->url;
        }
        Tools::redirect($vars->url, '');
    }

    public function addCustomer($vars, &$cart)
    {
        $query = parse_url($vars->link->continue_url, PHP_URL_QUERY);
        parse_str($query, $args);
        if (isset($args['key2']) && $args['key2']) {
            // New customer
            $customer = new Customer();
            $email = $vars->invoice_address->email;
            if (!$customer->getByEmail($email)) {
                // New customer
                $customer->email = $email;
                $name = explode(' ', $vars->invoice_address->name);
                $customer->lastname = array_pop($name);
                $customer->firstname = implode(' ', $name);
                $customer->passwd = Tools::encrypt(Tools::passwdGen(MIN_PASSWD_LENGTH, 'RANDOM'));
                $customer->is_guest = true;
                $customer->add();
            }
        } else {
            // Old customer
            $customer = new Customer((int)$cart->id_customer);
        }
        $cart->secure_key = $customer->secure_key;
        $cart->id_customer = $customer->id;
        $cart->id_currency = Currency::getIdByIsoCode($vars->currency);
        if ($vars->invoice_address) {
            $id_country = Country::getByIso($this->getIso2($vars->invoice_address->country_code));
            $address1 = $vars->invoice_address->street;
            $address1 .= ' '.$vars->invoice_address->house_number;
            $alias = 'mobilepay';
            if ($vars->invoice_address->house_extension) {
                $address1 .= ' '.$vars->invoice_address->house_extension;
            }
            $row = Db::getInstance()->getRow(
                'SELECT `id_address`
                FROM '._DB_PREFIX_.'address
                WHERE `alias` = "'.$alias.'"
                AND `id_customer` = "'.$customer->id.'"'
            );
            if ($row) {
                $address = new Address($row['id_address']);
            } else {
                $address = new Address();
            }
            $address->id_customer = $customer->id;
            $address->lastname = $customer->lastname;
            $address->firstname = $customer->firstname;
            $address->alias = $alias;
            $address->id_country = $id_country;
            $address->company = $vars->invoice_address->company_name;
            $address->vat_number = $vars->invoice_address->vat_no;
            $address->address1 = $address1;
            $address->postcode = $vars->invoice_address->zip_code;
            $address->city = $vars->invoice_address->city;
            $address->phone = $vars->invoice_address->phone_number;
            $address->phone_mobile = $vars->invoice_address->phone_number;
            if ($row) {
                $address->update();
            } else {
                $address->add();
            }
            $cart->id_address_invoice = $address->id;
            $cart->id_address_delivery = $address->id;
        }
        if ($vars->shipping_address) {
            $id_country = Country::getByIso($this->getIso2($vars->shipping_address->country_code));
            $address1 = $vars->shipping_address->street;
            $address1 .= ' '.$vars->shipping_address->house_number;
            $alias = 'mobilepay '.$this->l('delivery');
            if ($vars->shipping_address->house_extension) {
                $address1 .= ' '.$vars->shipping_address->house_extension;
            }
            $row = Db::getInstance()->getRow(
                'SELECT `id_address`
                FROM '._DB_PREFIX_.'address
                WHERE `alias` = "'.$alias.'"
                AND `id_customer` = "'.$customer->id.'"'
            );
            if ($row) {
                $address = new Address($row['id_address']);
            } else {
                $address = new Address();
            }
            $address->id_customer = $customer->id;
            $address->lastname = $customer->lastname;
            $address->firstname = $customer->firstname;
            $address->alias = $alias;
            $address->id_country = $id_country;
            $address->company = $vars->shipping_address->company_name;
            $address->vat_number = $vars->shipping_address->vat_no;
            $address->address1 = $address1;
            $address->postcode = $vars->shipping_address->zip_code;
            $address->city = $vars->shipping_address->city;
            $address->phone = $vars->shipping_address->phone_number;
            $address->phone_mobile = $vars->shipping_address->phone_number;
            if ($row) {
                $address->update();
            } else {
                $address->add();
            }
            $cart->id_address_delivery = $address->id;
        }
        Context::getContext()->cart = $cart;
        Context::getContext()->customer = $customer;
        // Update delivery cache
        $products = $cart->getProducts();
        foreach ($products as $product) {
            $cart->setProductAddressDelivery(
                $product['id_product'],
                $product['id_product_attribute'],
                $product['id_address_delivery'],
                $cart->id_address_delivery
            );
        }
        $cart->update();
        $this->context->cart = $cart;
    }

    public function validate($json, $checksum, $id_order_state = _PS_OS_PAYMENT_)
    {
        $this->getSetup();
        if ($checksum != $this->sign($json, $this->setup->private_key)) {
            $msg = 'PensoPay: Validate error. Checksum failed. Check private key in configuration';
            $this->addLog($msg, 2);
            die('Checksum failed');
        }

        $vars = $this->jsonDecode($json);
        if ($this->v16) {
            $brand = $this->getBrand($vars);
        } else {
            $brand = $this->displayName;
        }
        $accepted = $vars->accepted ? 1 : 0;
        $test_mode = $vars->test_mode ? 1 : 0;
        $id_cart = (int)Tools::substr($vars->order_id, 3);
        $cart = new Cart($id_cart);
        if (!empty($vars->link->invoice_address_selection)) {
            // MobilePay Checkout
            $this->addCustomer($vars, $cart);
        }
        if ($test_mode && !$this->setup->testmode) {
            $cart->delete();
            $msg = 'PensoPay: Validate error. Will not accept test payment!';
            $this->addLog($msg, 2, 0, 'Cart', $id_cart);
            if ($id_order_state == _PS_OS_ERROR_) {
                $fail_url = $this->getModuleLink('fail', array('status' => 'test'));
                Tools::redirect($fail_url, '');
            }
            die('Will not accept test payment!');
        }
        if (!Validate::isLoadedObject($cart)) {
            $msg = 'PensoPay: Validate error. Not a valid cart';
            $this->addLog($msg, 2, 0, 'Cart', $id_cart);
            die('Not a valid cart');
        }
        if ($cart->OrderExists() != 0) {
            die('Order already exists');
        }
        $currency = new Currency((int)$cart->id_currency);
        if ($currency->iso_code != $vars->currency) {
            $msg = sprintf(
                'PensoPay: Validation error: Currency was changed from %s to %s',
                $vars->currency,
                $currency->iso_code
            );
            $this->addLog($msg, 2, 0, 'Cart', $id_cart);
        }
        if ($this->v15) {
            Shop::setContext(Shop::CONTEXT_SHOP, $cart->id_shop);
            $customer = new Customer((int)$cart->id_customer);
            Context::getContext()->customer = $customer;
            Context::getContext()->currency = $currency;
        }
        $trans = Db::getInstance()->getRow(
            'SELECT *
            FROM '._DB_PREFIX_.'pensopay_execution
            WHERE `id_cart` = '.$id_cart.'
            ORDER BY `exec_id` ASC'
        );
        if ($trans['accepted']) {
            die('Order already accepted');
        }
        Db::getInstance()->Execute(
            'DELETE
            FROM '._DB_PREFIX_.'pensopay_execution
            WHERE `id_cart` = '.$cart->id
        );
        $values = array(
                $cart->id, $vars->id, $vars->order_id, $accepted,
                $test_mode, pSql($json));
        Db::getInstance()->Execute(
            'INSERT INTO '._DB_PREFIX_.'pensopay_execution
            (`id_cart`, `trans_id`, `order_id`, `accepted`, `test_mode`, `json`)
            VALUES '.$this->group($values)
        );
        $amount = $this->getAmount($vars);
        $fee = $this->getFee($vars);
        $fee = $this->fromQpAmount($fee, $currency);
        if ($this->v17) {
            $this->context->cart = $cart;
        }
        if ($accepted && $amount) {
            try {
                $amount_paid = $this->fromQpAmount($amount, $currency);
                $extra_vars = array(
                    'transaction_id' => $vars->id,
                    'cardtype' => $vars->metadata->brand
                );
                if ($this->setup->autofee && isset($vars->operations)) {
                    $this->addFee($cart, $fee);
                }
                if ($this->v17) {
                    smartyRegisterFunction(
                        $this->context->smarty,
                        'function',
                        'displayPrice',
                        array('Tools', 'displayPriceSmarty')
                    );
                }
                $total = $cart->getOrderTotal();
                $cart_total = $this->toQpAmount($total, $currency);
                if ($amount_paid == $cart_total) {
                    // Handle rounding problem e.g. with JPY
                    $amount_paid = $total;
                }
                if (!$this->validateOrder(
                    $cart->id,
                    $id_order_state,
                    $amount_paid,
                    $brand,
                    null,
                    $extra_vars,
                    null,
                    false,
                    $cart->secure_key
                )) {
                    $msg = 'PensoPay: Validate error. Unable to process order';
                    $this->addLog($msg, 2, 0, 'Cart', $id_cart);
                    die('Prestashop error - unable to process order..');
                }
            } catch (Exception $exception) {
                Db::getInstance()->Execute(
                    'UPDATE '._DB_PREFIX_.'pensopay_execution
                    SET `accepted` = 0
                    WHERE `id_cart` = '.$id_cart
                );
                $msg = 'PensoPay: Validate error. Exception ';
                $msg .= $exception->getMessage();
                $this->addLog($msg, 2, 0, 'Cart', $id_cart);
                die('Prestashop error - got exception.');
            }
            $id_order = Order::getOrderByCartId($cart->id);
            if ($id_order) {
                $order = new Order($id_order);
                $fields = array(
                    'variables[id_order]='.$order->id,
                    'variables[reference]='.$order->reference,
                );
                $this->doCurl('payments/'.$vars->id, $fields, 'PATCH');
            }
        }
    }

    public function getAmount($vars)
    {
        return (int)$vars->link->amount + (int)$vars->fee;
    }

    public function getFee($vars)
    {
        return (int)$vars->fee;
    }

    public function addFee(&$cart, $fee)
    {
        $id_lang = (int)$cart->id_lang;
        $txt = $this->l('Credit card fee', $this->name, $id_lang);
        $row = Db::getInstance()->getRow(
            'SELECT `id_product`
            FROM '._DB_PREFIX_.'product
            LEFT JOIN '._DB_PREFIX_.'product_lang
            USING (`id_product`)
            WHERE `name` = "'.$txt.'"'
        );
        if ($row) {
            SpecificPrice::deleteByProductId($row['id_product']);
            $product = new Product($row['id_product']);
            try {
                $cart->deleteProduct($row['id_product']);
            } catch (Exception $exception) {
                // Do nothing
            }
        } else {
            $product = new Product();
        }
        if ($this->v15) {
            $cache_entries = Cache::retrieveAll();
        }
        if ($fee <= 0) {
            return;
        }
        $product->name = array();
        $product->link_rewrite = array();
        foreach (Language::getLanguages(false) as $lang) {
            $id_lang = $lang['id_lang'];
            $product->name[$id_lang] = $this->l('Credit card fee', $this->name, $id_lang);
            $product->link_rewrite[$id_lang] = 'fee';
        }
        $product->active = 0;
        $product->price = $fee;
        $product->quantity = 100;
        $product->reference = $this->l('cardfee');
        $id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
        $currency = new Currency((int)$cart->id_currency);
        if ($currency->id != $id_currency && $currency->conversion_rate) {
            $product->price /= $currency->conversion_rate;
        }
        if ($this->v15) {
            $product->is_virtual = 1;
        }
        $product->id_tax_rules_group = $this->setup->feetax;
        if ($product->id_tax_rules_group) {
            $address = new Address($cart->id_address_delivery);
            $tax_manager = TaxManagerFactory::getManager($address, $product->id_tax_rules_group);
            $tax_calculator = $tax_manager->getTaxCalculator();
            $tax_rate = $tax_calculator->getTotalRate();
            if ($tax_rate) {
                $product->price /= (1 + $tax_rate / 100);
            }
        }
        $product->price = Tools::ps_round($product->price, 6);
        if ($this->v15) {
            if ($row) {
                $product->update();
            } else {
                Shop::setContext(Shop::CONTEXT_ALL, $cart->id_shop);
                $product->add();
                Shop::setContext(Shop::CONTEXT_SHOP, $cart->id_shop);
            }
            $rows = Group::getGroups($cart->id_lang);
            foreach ($rows as $row) {
                Db::getInstance()->Execute(
                    'INSERT IGNORE INTO `'._DB_PREFIX_.'product_group_reduction_cache`
                    (`id_product`, `id_group`, `reduction`)
                    VALUES ('.(int)$product->id.', '.$row['id_group'].', 0)'
                );
            }
            StockAvailable::setQuantity($product->id, 0, 100);
        } else {
            if ($row) {
                $product->update();
            } else {
                $product->add();
            }
        }
        $cart->updateQty(1, $product->id);
        if ($this->v15) {
            foreach ($cache_entries as $cache_id => $value) {
                $entry = explode('_', $cache_id);
                if ($entry[0] == 'getContextualValue') {
                    $entry[] = $product->id;
                    $entry[] = 0;
                    $cache_id = implode('_', $entry);
                    Cache::store($cache_id, $value);
                    $cache_id = implode('_', $entry).'_1';
                    Cache::store($cache_id, $value);
                    $entry[4] = CartRule::FILTER_ACTION_ALL_NOCAP;
                    $cache_id = implode('_', $entry);
                    Cache::store($cache_id, $value);
                    $cache_id = implode('_', $entry).'_1';
                    Cache::store($cache_id, $value);
                }
            }
            $cart->getPackageList(true); // Flush cache
        }
    }
}
