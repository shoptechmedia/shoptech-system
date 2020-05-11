<?php

if (!defined('_PS_VERSION_'))
    exit;

/**
 * Copyright (C) 2015 dh42
 *
 * This file is part of PiwikAnalyticsJS for prestashop.
 *
 * PiwikAnalyticsJS for prestashop is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PiwikAnalyticsJS for prestashop is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PiwikAnalyticsJS for prestashop.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @author dh42
 * @link https://dh42.com/free-prestashop-modules/prestashop-piwik-statistics/
 * @deprecated http://cmjnisse.github.io/piwikanalyticsjs-prestashop
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
class piwikanalyticsjs extends Module {

    private static $_isOrder = FALSE;
    protected $_errors = "";
    protected $piwikSite = FALSE;
    protected $default_currency = array();
    protected $currencies = array();

    /**
     * setReferralCookieTimeout
     */
    const PK_RC_TIMEOUT = 262974;

    /**
     * setVisitorCookieTimeout
     */
    const PK_VC_TIMEOUT = 569777;

    /**
     * setSessionCookieTimeout
     */
    const PK_SC_TIMEOUT = 30;

    public function __construct($name = null, $context = null) {
        $this->name = 'piwikanalyticsjs';
        $this->tab = 'analytics_stats';
        $this->version = '1.1.0';
        $this->author = 'dh42';
        $this->displayName = 'Piwik Web Analytics';

        $this->bootstrap = true;

        parent::__construct($name, ($context instanceof Context ? $context : NULL));

        require_once dirname(__FILE__) . '/PKHelper.php';

        //* warnings on module list page
        if ($this->id && !Configuration::get(PKHelper::CPREFIX . 'TOKEN_AUTH'))
            $this->warning = (isset($this->warning) && !empty($this->warning) ? $this->warning . ',<br/> ' : '') . $this->l('is not ready to roll you need to configure the auth token');
        if ($this->id && ((int) Configuration::get(PKHelper::CPREFIX . 'SITEID') <= 0))
            $this->warning = (isset($this->warning) && !empty($this->warning) ? $this->warning . ',<br/> ' : '') . $this->l('You have not yet set Piwik Site ID');
        if ($this->id && !Configuration::get(PKHelper::CPREFIX . 'HOST'))
            $this->warning = (isset($this->warning) && !empty($this->warning) ? $this->warning . ',<br/> ' : '') . $this->l('is not ready to roll you need to configure the Piwik server url');

        $this->description = $this->l('Piwik Web Analytics Javascript plugin');
        $this->confirmUninstall = $this->l('Are you sure you want to delete this plugin ?');

        self::$_isOrder = FALSE;
        $this->_errors = PKHelper::$errors = PKHelper::$error = "";

        if ($this->id) {
            if (version_compare(_PS_VERSION_, '1.5.0.13', "<="))
                PKHelper::$_module = & $this;
        }
    }

    /**
     * get content to display in the admin area
     * @global string $currentIndex
     * @return string
     */
    public function getContent() {
        if (Tools::getIsset('pkapicall')) {
            $this->__pkapicall();
            die();
        }

        if (version_compare(_PS_VERSION_, '1.5.0.4', "<=")) {
            $this->context->controller->addJquery(_PS_JQUERY_VERSION_);
            $this->context->controller->addJs($this->_path . 'js/jquery.alerts.js');
            $this->context->controller->addCss($this->_path . 'js/jquery.alerts.css');
        }

        if (version_compare(_PS_VERSION_, '1.5.2.999', "<="))
            $this->context->controller->addJqueryPlugin('fancybox', _PS_JS_DIR_ . 'jquery/plugins/');
        if (version_compare(_PS_VERSION_, '1.6.0.0', ">="))
            $this->context->controller->addJqueryPlugin('tagify', _PS_JS_DIR_ . 'jquery/plugins/');

        $_html = "";
        $_html .= $this->processFormsUpdate();
        if (Configuration::get(PKHelper::CPREFIX . 'TOKEN_AUTH') !== false)
            $this->piwikSite = PKHelper::getPiwikSite();
        else
            $this->piwikSite = false;
        $this->displayErrors(PKHelper::$errors);
        PKHelper::$errors = PKHelper::$error = "";
        $this->__setCurrencies();

        //* warnings on module configure page
        if ($this->id && !Configuration::get(PKHelper::CPREFIX . 'TOKEN_AUTH') && !Tools::getIsset(PKHelper::CPREFIX . 'TOKEN_AUTH')) /* avoid the same error message twice */
            $this->_errors .= $this->displayError($this->l('Piwik auth token is empty'));
        if ($this->id && ((int) Configuration::get(PKHelper::CPREFIX . 'SITEID') <= 0) && !Tools::getIsset(PKHelper::CPREFIX . 'SITEID')) /* avoid the same error message twice */
            $this->_errors .= $this->displayError($this->l('Piwik site id is lower or equal to "0"'));
        if ($this->id && !Configuration::get(PKHelper::CPREFIX . 'HOST'))
            $this->_errors .= $this->displayError($this->l('Piwik host cannot be empty'));

        $fields_form = array();

        $languages = Language::getLanguages(FALSE);
        foreach ($languages as $languages_key => $languages_value) {
            // is_default
            $languages[$languages_key]['is_default'] = ($languages_value['id_lang'] == (int) Configuration::get('PS_LANG_DEFAULT') ? true : false);
        }
        $helper = new HelperForm();
        if (version_compare(_PS_VERSION_, '1.6.0.0', "<"))
            $helper->base_folder = _PS_MODULE_DIR_ . 'piwikanalyticsjs/views/templates/helpers/form/';
        else
            $helper->module = $this;

        $helper->languages = $languages;
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->show_toolbar = false;
        $helper->toolbar_scroll = false;
        $helper->title = $this->displayName;
        $helper->submit_action = 'submitUpdate' . $this->name;

        $fields_form[0]['form']['legend'] = array(
            'title' => $this->displayName,
            'image' => $this->_path . 'logo.png'
        );

        if ($this->piwikSite !== FALSE) {
            $fields_form[0]['form']['input'][] = array(
                'type' => 'html',
                'name' => $this->l('Based on the settings you provided this is the info i get from Piwik!') . "<br>"
                . "<strong>" . $this->l('Name') . "</strong>: <i>{$this->piwikSite[0]->name}</i><br>"
                . "<strong>" . $this->l('Main Url') . "</strong>: <i>{$this->piwikSite[0]->main_url}</i><br>"
                . "<a href='#' onclick='return PiwikLookup();' title='{$this->l('Click here to open piwik site lookup wizard')}'>{$this->l('Configuration Wizard')}</a>"
            );
        } else {
            $fields_form[0]['form']['input'][] = array(
                'type' => 'html',
                'name' => "<a href='#' onclick='return PiwikLookup();' title='{$this->l('Click here to open piwik site lookup wizard')}'>{$this->l('Configuration Wizard')}</a>"
            );
        }

        $fields_form[0]['form']['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Piwik Host'),
            'name' => PKHelper::CPREFIX . 'HOST',
            'desc' => $this->l('Example: www.example.com/piwik/ (without protocol and with / at the end!)'),
            'hint' => $this->l('The host where piwik is installed.!'),
            'required' => true
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'switch',
            'is_bool' => true, //retro compat 1.5
            'label' => $this->l('Use proxy script'),
            'name' => PKHelper::CPREFIX . 'USE_PROXY',
            'desc' => $this->l('Whether or not to use the proxy insted of Piwik Host'),
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
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Proxy script'),
            'name' => PKHelper::CPREFIX . 'PROXY_SCRIPT',
            'hint' => $this->l('Example: www.example.com/pkproxy.php'),
            'desc' => sprintf($this->l('the FULL path to proxy script to use, build-in: [%s]'), self::getModuleLink($this->name, 'piwik')),
            'required' => false
        );
        if (function_exists('curl_version')) {
            $fields_form[0]['form']['input'][] = array(
                'type' => 'switch',
                'is_bool' => true,
                'label' => $this->l('Use cURL'),
                'name' => PKHelper::CPREFIX . 'USE_CURL',
                'desc' => $this->l('Whether or not to use cURL in Piwik API and proxy requests?'),
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
            );
        }
        $fields_form[0]['form']['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Piwik site id'),
            'name' => PKHelper::CPREFIX . 'SITEID',
            'desc' => $this->l('Example: 10'),
            'hint' => $this->l('You can find piwik site id by loggin to piwik installation.'),
            'required' => true
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Piwik token auth'),
            'name' => PKHelper::CPREFIX . 'TOKEN_AUTH',
            'desc' => $this->l('You can find piwik token by loggin to piwik installation. under API'),
            'required' => true
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Track visitors across subdomains'),
            'name' => PKHelper::CPREFIX . 'COOKIE_DOMAIN',
            'desc' => $this->l('The default is the document domain; if your web site can be visited at both www.example.com and example.com, you would use: "*.example.com" OR ".example.com" without the quotes')
            . '<br />'
            . $this->l('Leave empty to exclude this from the tracking code'),
            'hint' => $this->l('So if one visitor visits x.example.com and y.example.com, they will be counted as a unique visitor. (setCookieDomain)'),
            'required' => false
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Hide known alias URLs'),
            'name' => PKHelper::CPREFIX . 'SET_DOMAINS',
            'desc' => $this->l('In the "Outlinks" report, hide clicks to known alias URLs, Example: *.example.com')
            . '<br />'
            . $this->l('Note: to add multiple domains you must separate them with space " " one space')
            . '<br />'
            . $this->l('Note: the currently tracked website is added to this array automatically')
            . '<br />'
            . $this->l('Leave empty to exclude this from the tracking code'),
            'hint' => $this->l('So clicks on links to Alias URLs (eg. x.example.com) will not be counted as "Outlink". (setDomains)'),
            'required' => false
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'switch',
            'is_bool' => true, //retro compat 1.5
            'label' => $this->l('Enable client side DoNotTrack detection'),
            'name' => PKHelper::CPREFIX . 'DNT',
            'desc' => $this->l('So tracking requests will not be sent if visitors do not wish to be tracked.'),
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
        );

        if (Configuration::get(PKHelper::CPREFIX . 'TOKEN_AUTH') !== false)
            $image_tracking = PKHelper::getPiwikImageTrackingCode();
        else
            $image_tracking = array(
                'default' => $this->l('I need Site ID and Auth Token before i can get your image tracking code'),
                'proxy' => $this->l('I need Site ID and Auth Token before i can get your image tracking code')
            );
        $this->displayErrors(PKHelper::$errors);
        PKHelper::$errors = PKHelper::$error = "";
        $fields_form[0]['form']['input'][] = array(
            'type' => 'html',
            'name' => $this->l('Piwik image tracking code append one of them to field "Extra HTML" this will add images tracking code to all your pages') . "<br>"
            . "<strong>" . $this->l('default') . "</strong>:<br /><i>{$image_tracking['default']}</i><br>"
            . "<strong>" . $this->l('using proxy script') . "</strong>:<br /><i>{$image_tracking['proxy']}</i><br>"
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'textarea',
            'label' => $this->l('Extra HTML'),
            'name' => PKHelper::CPREFIX . 'EXHTML',
            'desc' => $this->l('Some extra HTML code to put after the piwik tracking code, this can be any html of your choice'),
            'rows' => 10,
            'cols' => 50,
        );

        $fields_form[0]['form']['input'][] = array(
            'type' => 'select',
            'label' => $this->l('Piwik Currency'),
            'name' => PKHelper::CPREFIX . 'DEFAULT_CURRENCY',
            'desc' => sprintf($this->l('Based on your settings in Piwik your default currency is %s'), ($this->piwikSite !== FALSE ? $this->piwikSite[0]->currency : $this->l('unknown'))),
            'options' => array(
                'default' => $this->default_currency,
                'query' => $this->currencies,
                'id' => 'iso_code',
                'name' => 'name'
            ),
        );

        $fields_form[0]['form']['input'][] = array(
            'type' => 'select',
            'label' => $this->l('Piwik Report date'),
            'name' => PKHelper::CPREFIX . 'DREPDATE',
            'desc' => $this->l('Report date to load by default from "Stats => Piwik Analytics"'),
            'options' => array(
                'default' => array('value' => 'day|today', 'label' => $this->l('Today')),
                'query' => array(
                    array('str' => 'day|today', 'name' => $this->l('Today')),
                    array('str' => 'day|yesterday', 'name' => $this->l('Yesterday')),
                    array('str' => 'range|previous7', 'name' => $this->l('Previous 7 days (not including today)')),
                    array('str' => 'range|previous30', 'name' => $this->l('Previous 30 days (not including today)')),
                    array('str' => 'range|last7', 'name' => $this->l('Last 7 days (including today)')),
                    array('str' => 'range|last30', 'name' => $this->l('Last 30 days (including today)')),
                    array('str' => 'week|today', 'name' => $this->l('Current Week')),
                    array('str' => 'month|today', 'name' => $this->l('Current Month')),
                    array('str' => 'year|today', 'name' => $this->l('Current Year')),
                ),
                'id' => 'str',
                'name' => 'name'
            ),
        );

        $fields_form[0]['form']['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Piwik User name'),
            'name' => PKHelper::CPREFIX . 'USRNAME',
            'desc' => $this->l('You can store your Username for Piwik here to make it easy to open piwik interface from your stats page with automatic login'),
            'required' => false,
            'autocomplete' => false,
        );
        $fields_form[0]['form']['input'][] = array(
            'type' => 'password',
            'label' => $this->l('Piwik User password'),
            'name' => PKHelper::CPREFIX . 'USRPASSWD',
            'desc' => $this->l('You can store your Password for Piwik here to make it easy to open piwik interface from your stats page with automatic login'),
            'required' => false,
            'autocomplete' => false,
        );

        $fields_form[0]['form']['submit'] = array(
            'title' => $this->l('Save'),
            'class' => 'btn btn-default'
        );



        $fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->displayName . ' ' . $this->l('Advanced'),
                'image' => $this->_path . 'logo.png'
            ),
            'input' => array(
                array(
                    'type' => 'html',
                    'name' => $this->l('In this section you can modify certain aspects of the way this plugin sends products, searches, category view etc.. to piwik')
                ),
                array(
                    'type' => 'switch',
                    'is_bool' => true, //retro compat 1.5
                    'label' => $this->l('Use HTTPS'),
                    'name' => PKHelper::CPREFIX . 'CRHTTPS',
                    'hint' => $this->l('ONLY enable this feature if piwik installation is accessible via https'),
                    'desc' => $this->l('use Hypertext Transfer Protocol Secure (HTTPS) in all requests from code to piwik, this only affects how requests are sent from proxy script to piwik, your visitors will still use the protocol they visit your shop with'),
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
                    'type' => 'html',
                    'name' => $this->l('in the next few inputs you can set how the product id is passed on to piwik')
                    . '<br />'
                    . $this->l('there are three variables you can use:')
                    . '<br />'
                    . $this->l('{ID} : this variable is replaced with id the product has in prestashop')
                    . '<br />'
                    . $this->l('{REFERENCE} : this variable is replaced with the unique reference you when adding adding/updating a product, this variable is only available in prestashop 1.5 and up')
                    . '<br />'
                    . $this->l('{ATTRID} : this variable is replaced with id the product attribute')
                    . '<br />'
                    . $this->l('in cases where only the product id is available it be parsed as ID and nothing else'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Product id V1'),
                    'name' => PKHelper::CPREFIX . 'PRODID_V1',
                    'desc' => $this->l('This template is used in case ALL three values are available ("Product ID", "Product Attribute ID" and "Product Reference")'),
                    'required' => false
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Product id V2'),
                    'name' => PKHelper::CPREFIX . 'PRODID_V2',
                    'desc' => $this->l('This template is used in case only "Product ID" and "Product Reference" are available'),
                    'required' => false
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Product id V3'),
                    'name' => PKHelper::CPREFIX . 'PRODID_V3',
                    'desc' => $this->l('This template is used in case only "Product ID" and "Product Attribute ID" are available'),
                    'required' => false
                ),
                array(
                    'type' => 'html',
                    'name' => "<strong>{$this->l('Piwik Cookies')}</strong>"
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Piwik Session Cookie timeout'),
                    'name' => PKHelper::CPREFIX . 'SESSION_TIMEOUT',
                    'required' => false,
                    'hint' => $this->l('this value must be set in minutes'),
                    'desc' => $this->l('Piwik Session Cookie timeout, the default is 30 minutes'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Piwik Visitor Cookie timeout'),
                    'name' => PKHelper::CPREFIX . 'COOKIE_TIMEOUT',
                    'required' => false,
                    'hint' => $this->l('this value must be set in minutes'),
                    'desc' => $this->l('Piwik Visitor Cookie timeout, the default is 13 months (569777 minutes)'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Piwik Referral Cookie timeout'),
                    'name' => PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT',
                    'required' => false,
                    'hint' => $this->l('this value must be set in minutes'),
                    'desc' => $this->l('Piwik Referral Cookie timeout, the default is 6 months (262974 minutes)'),
                ),
                array(
                    'type' => 'html',
                    'name' => "<strong>{$this->l('Piwik Proxy Script Authorization? if piwik is installed behind HTTP Basic Authorization (Both password and username must be filled before the values will be used)')}</strong>"
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Proxy Script Username'),
                    'name' => PKHelper::CPREFIX . 'PAUTHUSR',
                    'required' => false,
                    'autocomplete' => false,
                    'desc' => $this->l('this field along with password can be used if piwik installation is protected by HTTP Basic Authorization'),
                ),
                array(
                    'type' => 'password',
                    'label' => $this->l('Proxy Script Password'),
                    'name' => PKHelper::CPREFIX . 'PAUTHPWD',
                    'required' => false,
                    'autocomplete' => false,
                    'desc' => $this->l('this field along with username can be used if piwik installation is protected by HTTP Basic Authorization'),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default'
            )
        );

        if ($this->piwikSite !== FALSE) {

            $tmp = PKHelper::getMyPiwikSites(TRUE);
            $this->displayErrors(PKHelper::$errors);
            PKHelper::$errors = PKHelper::$error = "";
            $pksite_default = array('value' => 0, 'label' => $this->l('Choose Piwik site'));
            $pksites = array();
            foreach ($tmp as $pksid) {
                $pksites[] = array(
                    'pkid' => $pksid->idsite,
                    'name' => "{$pksid->name} #{$pksid->idsite}",
                );
            }
            unset($tmp, $pksid);

            $pktimezone_default = array('value' => 0, 'label' => $this->l('Choose Timezone'));
            $pktimezones = array();
            $tmp = PKHelper::getTimezonesList();
            $this->displayErrors(PKHelper::$errors);
            PKHelper::$errors = PKHelper::$error = "";
            foreach ($tmp as $key => $pktz) {
                if (!isset($pktimezones[$key])) {
                    $pktimezones[$key] = array(
                        'name' => $this->l($key),
                        'query' => array(),
                    );
                }
                foreach ($pktz as $pktzK => $pktzV) {
                    $pktimezones[$key]['query'][] = array(
                        'tzId' => $pktzK,
                        'tzName' => $pktzV,
                    );
                }
            }
            unset($tmp, $pktz, $pktzV, $pktzK);
            $fields_form[2]['form'] = array(
                'legend' => array(
                    'title' => $this->displayName . ' ' . $this->l('Advanced') . ' - ' . $this->l('Edit Piwik site'),
                    'image' => $this->_path . 'logo.png'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Piwik Site'),
                        'name' => 'SPKSID',
                        'desc' => sprintf($this->l('Based on your settings in Piwik your default site is %s'), $this->piwikSite[0]->idsite),
                        'options' => array(
                            'default' => $pksite_default,
                            'query' => $pksites,
                            'id' => 'pkid',
                            'name' => 'name'
                        ),
                        'onchange' => 'return ChangePKSiteEdit(this.value)',
                    ),
                    array(
                        'type' => 'html',
                        'name' => $this->l('In this section you can modify your settings in piwik just so you don\'t have to login to Piwik to do this') . "<br>"
                        . "<strong>" . $this->l('Currently selected name') . "</strong>: <i id='wnamedsting'>{$this->piwikSite[0]->name}</i><br>"
                        . "<input type=\"hidden\" name=\"PKAdminIdSite\" id=\"PKAdminIdSite\" value=\"{$this->piwikSite[0]->idsite}\" />"
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Piwik Site Name'),
                        'name' => 'PKAdminSiteName',
                        'desc' => $this->l('Name of this site in Piwik'),
                    ),
//                    array(
//                        'type' => 'text',
//                        'label' => $this->l('Site urls'),
//                        'name' => 'PKAdminSiteUrls',
//                    ),
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        'label' => $this->l('Ecommerce'),
                        'name' => 'PKAdminEcommerce',
                        'desc' => $this->l('Is this site an ecommerce site?'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        'label' => $this->l('Site Search'),
                        'name' => 'PKAdminSiteSearch',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
                    array(
                        'type' => (version_compare(_PS_VERSION_ , '1.6.0.0', '>=') ? 'tags':'text'),
                        'label' => $this->l('Search Keyword Parameters'),
                        'name' => 'PKAdminSearchKeywordParameters',
                    ),
                    array(
                        'type' => (version_compare(_PS_VERSION_ , '1.6.0.0', '>=') ? 'tags':'text'),
                        'label' => $this->l('Search Category Parameters'),
                        'name' => 'PKAdminSearchCategoryParameters',
                    ),
                    array(
                        'type' => (version_compare(_PS_VERSION_ , '1.6.0.0', '>=') ? 'tags':'text'),
                        'label' => $this->l('Excluded ip addresses'),
                        'name' => 'PKAdminExcludedIps',
                        'desc' => $this->l('ip addresses excluded from tracking, separated by comma ","'),
                    ),
                    array(
                        'type' => (version_compare(_PS_VERSION_ , '1.6.0.0', '>=') ? 'tags':'text'),
                        'label' => $this->l('Excluded Query Parameters'),
                        'name' => 'PKAdminExcludedQueryParameters',
                        'desc' => $this->l('please read: http://piwik.org/faq/how-to/faq_81/'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Timezone'),
                        'name' => 'PKAdminTimezone',
                        'desc' => sprintf($this->l('Based on your settings in Piwik your default timezone is %s'), $this->piwikSite[0]->timezone),
                        'options' => array(
                            'default' => $pktimezone_default,
                            'optiongroup' => array(
                                'label' => 'name',
                                'query' => $pktimezones,
                            ),
                            'options' => array(
                                'id' => 'tzId',
                                'name' => 'tzName',
                                'query' => 'query',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Currency'),
                        'name' => 'PKAdminCurrency',
                        'desc' => sprintf($this->l('Based on your settings in Piwik your default currency is %s'), $this->piwikSite[0]->currency),
                        'options' => array(
                            'default' => $this->default_currency,
                            'query' => $this->currencies,
                            'id' => 'iso_code',
                            'name' => 'name'
                        ),
                    ),
//                    array(
//                        'type' => 'text',
//                        'label' => $this->l('Website group'),
//                        'name' => 'PKAdminGroup',
//                        'desc' => sprintf('Requires plugin "WebsiteGroups" before it can be used from within Piwik'),
//                    ),
//                    array(
//                        'type' => 'text',
//                        'label' => $this->l('Website start date'),
//                        'name' => 'PKAdminStartDate',
//                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Excluded User Agents'),
                        'name' => 'PKAdminExcludedUserAgents',
                        'rows' => 10,
                        'cols' => 50,
                        'desc' => $this->l('please read: http://piwik.org/faq/how-to/faq_17483/'),
                    ),
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        'label' => $this->l('Keep URL Fragments'),
                        'name' => 'PKAdminKeepURLFragments',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
//                    array(
//                        'type' => 'text',
//                        'label' => $this->l('Site Type'),
//                        'name' => 'PKAdminSiteType',
//                    ),
                    array('type' => 'html', 'name' => "
<button onclick=\"return submitPiwikSiteAPIUpdate()\"
        id=\"submitUpdatePiwikAdmSite\" class=\"btn btn-default pull-left\"
        name=\"submitUpdatePiwikAdmSite\" value=\"1\" type=\"button\">
    <i class=\"process-icon-save\"></i>{$this->l('Save')}</button>"),
                ),
            );
        }
        $helper->fields_value = $this->getFormFields();
        $this->context->smarty->assign(array(
            'psversion' => _PS_VERSION_,
            /* piwik_site_lookup */
            'psl_CPREFIX' => PKHelper::CPREFIX,
            'psl_currentIndex' => $helper->currentIndex,
            'psl_token' => $helper->token,
            /* piwik_site_manager */
            'psm_currentIndex' => $helper->currentIndex,
            'psm_token' => $helper->token,
        ));
        return $this->_errors . $_html . $helper->generateForm($fields_form)
                . $this->display(__FILE__, 'views/templates/admin/piwik_site_manager.tpl')
                . $this->display(__FILE__, 'views/templates/admin/piwik_site_lookup.tpl');
    }

    private function __pkapicall() {
        $apiMethod = Tools::getValue('pkapicall');
        if (method_exists('PKHelper', $apiMethod) && isset(PKHelper::$acp[$apiMethod])) {
            $required = PKHelper::$acp[$apiMethod]['required'];
            // $optional = PKHelper::$acp[$apiMethod]['optional'];
            $order = PKHelper::$acp[$apiMethod]['order'];
            foreach ($required as $requiredOption) {
                if (!Tools::getIsset($requiredOption)) {
                    PKHelper::DebugLogger("__pkapicall():\n\t- Required parameter \"" . $requiredOption . '" is missing');
                    die(Tools::jsonEncode(array('error' => true, 'message' => sprintf($this->l('Required parameter "%s" is missing'), $requiredOption))));
                }
            }
            foreach ($order as & $value) {
                if (Tools::getIsset($value)) {
                    $value = Tools::getValue($value);
                } else {
                    $value = NULL;
                }
            }

            if (Tools::getIsset('httpUser'))
                PKHelper::$httpAuthUsername = Tools::getValue('httpUser');
            if (Tools::getIsset('httpPasswd'))
                PKHelper::$httpAuthPassword = Tools::getValue('httpPasswd');
            if (Tools::getIsset('piwikhost'))
                PKHelper::$piwikHost = Tools::getValue('piwikhost');

            PKHelper::DebugLogger("__pkapicall():\n\t- Call PKHelper::" . $apiMethod);
            $result = call_user_func_array(array('PKHelper', $apiMethod), $order);
            if ($result === FALSE) {
                $lastError = "";
                if (!empty(PKHelper::$errors))
                    $lastError = "\n" . PKHelper::$error;
                die(Tools::jsonEncode(array('error' => TRUE, 'message' => sprintf($this->l('Unknown error occurred%s'), $lastError))));
            } else {
                PKHelper::DebugLogger("__pkapicall():\n\t- Al good");
                if (is_array($result) && isset($result[0])) {
                    $message = $result;
                } else if (is_object($result)) {
                    $message = $result;
                } else
                    $message = (is_string($result) && !is_bool($result) ? $result : (is_array($result) ? implode(', ', $result) : TRUE));

                if (is_bool($message)) {
                    die(Tools::jsonEncode(array('error' => FALSE, 'message' => $this->l('Successfully Updated'))));
                } else {
                    die(Tools::jsonEncode(array('error' => FALSE, 'message' => $message)));
                }
            }
        } else {
            die(Tools::jsonEncode(array('error' => true, 'message' => sprintf($this->l('Method "%s" dos not exists in class PKHelper'), $apiMethod))));
        }
    }

    protected function getFormFields() {
        $PIWIK_PRODID_V1 = Configuration::get(PKHelper::CPREFIX . 'PRODID_V1');
        $PIWIK_PRODID_V2 = Configuration::get(PKHelper::CPREFIX . 'PRODID_V2');
        $PIWIK_PRODID_V3 = Configuration::get(PKHelper::CPREFIX . 'PRODID_V3');
        $PIWIK_PROXY_SCRIPT = Configuration::get(PKHelper::CPREFIX . 'PROXY_SCRIPT');
        $PIWIK_RCOOKIE_TIMEOUT = (int) Configuration::get(PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT');
        $PIWIK_COOKIE_TIMEOUT = (int) Configuration::get(PKHelper::CPREFIX . 'COOKIE_TIMEOUT');
        $PIWIK_SESSION_TIMEOUT = (int) Configuration::get(PKHelper::CPREFIX . 'SESSION_TIMEOUT');
        return array(
            PKHelper::CPREFIX . 'HOST' => Configuration::get(PKHelper::CPREFIX . 'HOST'),
            PKHelper::CPREFIX . 'SITEID' => Configuration::get(PKHelper::CPREFIX . 'SITEID'),
            PKHelper::CPREFIX . 'TOKEN_AUTH' => Configuration::get(PKHelper::CPREFIX . 'TOKEN_AUTH'),
            PKHelper::CPREFIX . 'SESSION_TIMEOUT' => ($PIWIK_SESSION_TIMEOUT != 0 ? (int) ($PIWIK_SESSION_TIMEOUT / 60) : (int) (self::PK_SC_TIMEOUT )),
            PKHelper::CPREFIX . 'COOKIE_TIMEOUT' => ($PIWIK_COOKIE_TIMEOUT != 0 ? (int) ($PIWIK_COOKIE_TIMEOUT / 60) : (int) (self::PK_VC_TIMEOUT)),
            PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT' => ($PIWIK_RCOOKIE_TIMEOUT != 0 ? (int) ($PIWIK_RCOOKIE_TIMEOUT / 60) : (int) (self::PK_RC_TIMEOUT)),
            PKHelper::CPREFIX . 'USE_PROXY' => Configuration::get(PKHelper::CPREFIX . 'USE_PROXY'),
            PKHelper::CPREFIX . 'EXHTML' => Configuration::get(PKHelper::CPREFIX . 'EXHTML'),
            PKHelper::CPREFIX . 'CRHTTPS' => Configuration::get(PKHelper::CPREFIX . 'CRHTTPS'),
            PKHelper::CPREFIX . 'DEFAULT_CURRENCY' => Configuration::get("PIWIK_DEFAULT_CURRENCY"),
            PKHelper::CPREFIX . 'PRODID_V1' => (!empty($PIWIK_PRODID_V1) ? $PIWIK_PRODID_V1 : '{ID}-{ATTRID}#{REFERENCE}'),
            PKHelper::CPREFIX . 'PRODID_V2' => (!empty($PIWIK_PRODID_V2) ? $PIWIK_PRODID_V2 : '{ID}#{REFERENCE}'),
            PKHelper::CPREFIX . 'PRODID_V3' => (!empty($PIWIK_PRODID_V3) ? $PIWIK_PRODID_V3 : '{ID}-{ATTRID}'),
            PKHelper::CPREFIX . 'COOKIE_DOMAIN' => Configuration::get(PKHelper::CPREFIX . 'COOKIE_DOMAIN'),
            PKHelper::CPREFIX . 'SET_DOMAINS' => Configuration::get(PKHelper::CPREFIX . 'SET_DOMAINS'),
            PKHelper::CPREFIX . 'DNT' => Configuration::get(PKHelper::CPREFIX . 'DNT'),
            PKHelper::CPREFIX . 'PROXY_SCRIPT' => empty($PIWIK_PROXY_SCRIPT) ? str_replace(array("http://", "https://"), '', self::getModuleLink($this->name, 'piwik')) : $PIWIK_PROXY_SCRIPT,
            PKHelper::CPREFIX . 'USRNAME' => Configuration::get(PKHelper::CPREFIX . 'USRNAME'),
            PKHelper::CPREFIX . 'USRPASSWD' => Configuration::get(PKHelper::CPREFIX . 'USRPASSWD'),
            PKHelper::CPREFIX . 'PAUTHUSR' => Configuration::get(PKHelper::CPREFIX . 'PAUTHUSR'),
            PKHelper::CPREFIX . 'PAUTHPWD' => Configuration::get(PKHelper::CPREFIX . 'PAUTHPWD'),
            PKHelper::CPREFIX . 'DREPDATE' => Configuration::get(PKHelper::CPREFIX . 'DREPDATE'),
            PKHelper::CPREFIX . 'USE_CURL' => Configuration::get(PKHelper::CPREFIX . 'USE_CURL'),
            /* stuff thats isset by ajax calls to Piwik API ---(here to avoid not isset warnings..!)--- */
            'PKAdminSiteName' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->name : ''),
            'PKAdminEcommerce' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->ecommerce : ''),
            'PKAdminSiteSearch' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->sitesearch : ''),
            'PKAdminSearchKeywordParameters' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->sitesearch_keyword_parameters : ''),
            'PKAdminSearchCategoryParameters' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->sitesearch_category_parameters : ''),
            'SPKSID' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->idsite : Configuration::get(PKHelper::CPREFIX . 'SITEID')),
            'PKAdminExcludedIps' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->excluded_ips : ''),
            'PKAdminExcludedQueryParameters' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->excluded_parameters : ''),
            'PKAdminTimezone' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->timezone : ''),
            'PKAdminCurrency' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->currency : ''),
            'PKAdminGroup' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->group : ''),
            'PKAdminStartDate' => '',
            'PKAdminSiteUrls' => '',
            'PKAdminExcludedUserAgents' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->excluded_user_agents : ''),
            'PKAdminKeepURLFragments' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->keep_url_fragment : 0),
            'PKAdminSiteType' => ($this->piwikSite !== FALSE ? $this->piwikSite[0]->type : 'website'),
        );
    }

    private function processFormsUpdate() {

        $_html = "";
        if (Tools::isSubmit('submitUpdate' . $this->name)) {
            if (Tools::getIsset(PKHelper::CPREFIX . 'HOST')) {
                $tmp = Tools::getValue(PKHelper::CPREFIX . 'HOST', '');
                if (!empty($tmp) && (filter_var($tmp, FILTER_VALIDATE_URL) || filter_var('http://' . $tmp, FILTER_VALIDATE_URL))) {
                    $tmp = str_replace(array('http://', 'https://', '//'), "", $tmp);
                    if (substr($tmp, -1) != "/") {
                        $tmp .= "/";
                    }
                    Configuration::updateValue(PKHelper::CPREFIX . 'HOST', $tmp);
                } else {
                    $_html .= $this->displayError($this->l('Piwik host cannot be empty'));
                }
            }
            if (Tools::getIsset(PKHelper::CPREFIX . 'SITEID')) {
                $tmp = (int) Tools::getValue(PKHelper::CPREFIX . 'SITEID', 0);
                Configuration::updateValue(PKHelper::CPREFIX . 'SITEID', $tmp);
                if ($tmp <= 0) {
                    $_html .= $this->displayError($this->l('Piwik site id is lower or equal to "0"'));
                }
            }
            if (Tools::getIsset(PKHelper::CPREFIX . 'TOKEN_AUTH')) {
                $tmp = Tools::getValue(PKHelper::CPREFIX . 'TOKEN_AUTH', '');
                Configuration::updateValue(PKHelper::CPREFIX . 'TOKEN_AUTH', $tmp);
                if (empty($tmp)) {
                    $_html .= $this->displayError($this->l('Piwik auth token is empty'));
                }
            }
            /* setReferralCookieTimeout */
            if (Tools::getIsset(PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT')) {
                // the default is 6 months
                $tmp = (int) Tools::getValue(PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT', self::PK_RC_TIMEOUT);
                $tmp = (int) ($tmp * 60); //* convert to seconds
                Configuration::updateValue(PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT', $tmp);
            }
            /* setVisitorCookieTimeout */
            if (Tools::getIsset(PKHelper::CPREFIX . 'COOKIE_TIMEOUT')) {
                // the default is 13 months
                $tmp = (int) Tools::getValue(PKHelper::CPREFIX . 'COOKIE_TIMEOUT', self::PK_VC_TIMEOUT);
                $tmp = (int) ($tmp * 60); //* convert to seconds
                Configuration::updateValue(PKHelper::CPREFIX . 'COOKIE_TIMEOUT', $tmp);
            }
            /* setSessionCookieTimeout */
            if (Tools::getIsset(PKHelper::CPREFIX . 'SESSION_TIMEOUT')) {
                // the default is 30 minutes
                $tmp = (int) Tools::getValue(PKHelper::CPREFIX . 'SESSION_TIMEOUT', self::PK_SC_TIMEOUT);
                $tmp = (int) ($tmp * 60); //* convert to seconds
                Configuration::updateValue(PKHelper::CPREFIX . 'SESSION_TIMEOUT', $tmp);
            }
            /*
             * @todo VALIDATE!!!, YES VALIDATE!!! thank you ...
             */
            if (Tools::getIsset(PKHelper::CPREFIX . 'USE_PROXY'))
                Configuration::updateValue(PKHelper::CPREFIX . 'USE_PROXY', Tools::getValue(PKHelper::CPREFIX . 'USE_PROXY'));
            if (Tools::getIsset(PKHelper::CPREFIX . 'USE_CURL'))
                Configuration::updateValue(PKHelper::CPREFIX . 'USE_CURL', Tools::getValue(PKHelper::CPREFIX . 'USE_CURL'));
            if (Tools::getIsset(PKHelper::CPREFIX . 'EXHTML'))
                Configuration::updateValue(PKHelper::CPREFIX . 'EXHTML', Tools::getValue(PKHelper::CPREFIX . 'EXHTML'), TRUE);
            if (Tools::getIsset(PKHelper::CPREFIX . 'COOKIE_DOMAIN'))
                Configuration::updateValue(PKHelper::CPREFIX . 'COOKIE_DOMAIN', Tools::getValue(PKHelper::CPREFIX . 'COOKIE_DOMAIN'));
            if (Tools::getIsset(PKHelper::CPREFIX . 'SET_DOMAINS'))
                Configuration::updateValue(PKHelper::CPREFIX . 'SET_DOMAINS', Tools::getValue(PKHelper::CPREFIX . 'SET_DOMAINS'));
            if (Tools::getIsset(PKHelper::CPREFIX . 'DNT'))
                Configuration::updateValue(PKHelper::CPREFIX . 'DNT', Tools::getValue(PKHelper::CPREFIX . 'DNT', 0));
            if (Tools::getIsset(PKHelper::CPREFIX . 'PROXY_SCRIPT'))
                Configuration::updateValue(PKHelper::CPREFIX . 'PROXY_SCRIPT', str_replace(array("http://", "https://", '//'), '', Tools::getValue(PKHelper::CPREFIX . 'PROXY_SCRIPT')));
            if (Tools::getIsset(PKHelper::CPREFIX . 'CRHTTPS'))
                Configuration::updateValue(PKHelper::CPREFIX . 'CRHTTPS', Tools::getValue(PKHelper::CPREFIX . 'CRHTTPS', 0));
            if (Tools::getIsset(PKHelper::CPREFIX . 'PRODID_V1'))
                Configuration::updateValue(PKHelper::CPREFIX . 'PRODID_V1', Tools::getValue(PKHelper::CPREFIX . 'PRODID_V1', '{ID}-{ATTRID}#{REFERENCE}'));
            if (Tools::getIsset(PKHelper::CPREFIX . 'PRODID_V2'))
                Configuration::updateValue(PKHelper::CPREFIX . 'PRODID_V2', Tools::getValue(PKHelper::CPREFIX . 'PRODID_V2', '{ID}#{REFERENCE}'));
            if (Tools::getIsset(PKHelper::CPREFIX . 'PRODID_V3'))
                Configuration::updateValue(PKHelper::CPREFIX . 'PRODID_V3', Tools::getValue(PKHelper::CPREFIX . 'PRODID_V3', '{ID}#{ATTRID}'));
            if (Tools::getIsset(PKHelper::CPREFIX . 'DEFAULT_CURRENCY'))
                Configuration::updateValue(PKHelper::CPREFIX . "DEFAULT_CURRENCY", Tools::getValue(PKHelper::CPREFIX . 'DEFAULT_CURRENCY', 'EUR'));

            if (Tools::getIsset(PKHelper::CPREFIX . 'USRNAME'))
                Configuration::updateValue(PKHelper::CPREFIX . "USRNAME", Tools::getValue(PKHelper::CPREFIX . 'USRNAME', ''));
            if (Tools::getIsset(PKHelper::CPREFIX . 'USRPASSWD') && Tools::getValue(PKHelper::CPREFIX . 'USRPASSWD', '') != "")
                Configuration::updateValue(PKHelper::CPREFIX . "USRPASSWD", Tools::getValue(PKHelper::CPREFIX . 'USRPASSWD', Configuration::get(PKHelper::CPREFIX . 'USRPASSWD')));

            if (Tools::getIsset(PKHelper::CPREFIX . 'PAUTHUSR'))
                Configuration::updateValue(PKHelper::CPREFIX . "PAUTHUSR", Tools::getValue(PKHelper::CPREFIX . 'PAUTHUSR', ''));
            if (Tools::getIsset(PKHelper::CPREFIX . 'PAUTHPWD') && Tools::getValue(PKHelper::CPREFIX . 'PAUTHPWD', '') != "")
                Configuration::updateValue(PKHelper::CPREFIX . "PAUTHPWD", Tools::getValue(PKHelper::CPREFIX . 'PAUTHPWD', Configuration::get(PKHelper::CPREFIX . 'PAUTHPWD')));

            if (Tools::getIsset(PKHelper::CPREFIX . 'DREPDATE'))
                Configuration::updateValue(PKHelper::CPREFIX . "DREPDATE", Tools::getValue(PKHelper::CPREFIX . 'DREPDATE', 'day|tody'));

            $_html .= $this->displayConfirmation($this->l('Configuration Updated'));
        }
        return $_html;
    }

    /* HOOKs */

    /**
     * hook into maintenance page.
     * @param array $params empty array
     * @return string
     * @since 0.8
     */
    public function hookdisplayMaintenance($params) {
        return $this->hookFooter($params);
    }

    /**
     * PIWIK don't track links on the same site eg.
     * if product is view in an iframe so we add this and makes sure that it is content only view
     * @param mixed $param
     * @return string
     */
    public function hookdisplayRightColumnProduct($param) {
        if ((int) Configuration::get(PKHelper::CPREFIX . 'SITEID') <= 0)
            return "";
        if ((int) Tools::getValue('content_only') > 0 && get_class($this->context->controller) == 'ProductController') { // we also do this in the tpl file.!
            return $this->hookFooter($param);
        }
    }

    /**
     * Search action
     * @param array $param
     */
    public function hookactionSearch($param) {
        if ((int) Configuration::get(PKHelper::CPREFIX . 'SITEID') <= 0)
            return "";
        $param['total'] = intval($param['total']);
        /* if multi pages in search add page number of current if set! */
        $page = "";
        if (Tools::getIsset('p')) {
            $page = " (" . Tools::getValue('p') . ")";
        }
        // $param['expr'] is not the searched word if lets say search is Snitmøntre then the $param['expr'] will be Snitmontre
        $expr = Tools::getIsset('search_query') ? htmlentities(Tools::getValue('search_query')) : $param['expr'];
        $this->context->smarty->assign(array(
            PKHelper::CPREFIX . 'SITE_SEARCH' => "_paq.push(['trackSiteSearch',\"{$expr}{$page}\",false,{$param['total']}]);"
        ));
    }

    /**
     * only checks that the module is registered in hook "footer",
     * this why we only appent javescript to the end of the page!
     * @param mixed $params
     */
    public function hookHeader($params) {
        if (!$this->isRegisteredInHook('footer'))
            $this->registerHook('footer');
    }

    public function hookOrderConfirmation($params) {
        if ((int) Configuration::get(PKHelper::CPREFIX . 'SITEID') <= 0)
            return "";

        $order = $params['objOrder'];
        if (Validate::isLoadedObject($order)) {

            $this->__setConfigDefault();

            $this->context->smarty->assign(PKHelper::CPREFIX . 'ORDER', TRUE);
            $this->context->smarty->assign(PKHelper::CPREFIX . 'CART', FALSE);


            $smarty_ad = array();
            foreach ($params['objOrder']->getProductsDetail() as $value) {
                $smarty_ad[] = array(
                    'SKU' => $this->parseProductSku($value['product_id'], (isset($value['product_attribute_id']) ? $value['product_attribute_id'] : FALSE), (isset($value['product_reference']) ? $value['product_reference'] : FALSE)),
                    'NAME' => $value['product_name'],
                    'CATEGORY' => $this->get_category_names_by_product($value['product_id'], FALSE),
                    'PRICE' => $this->currencyConvertion(
                            array(
                                'price' => (isset($value['total_price_tax_incl']) ? floatval($value['total_price_tax_incl']) : (isset($value['total_price_tax_incl']) ? floatval($value['total_price_tax_incl']) : 0.00)),
                                'conversion_rate' => (isset($params['objOrder']->conversion_rate) ? $params['objOrder']->conversion_rate : 0.00),
                            )
                    ),
                    'QUANTITY' => $value['product_quantity'],
                );
            }
            $this->context->smarty->assign(PKHelper::CPREFIX . 'ORDER_PRODUCTS', $smarty_ad);
            if (isset($params['objOrder']->total_paid_tax_incl) && isset($params['objOrder']->total_paid_tax_excl))
                $tax = $params['objOrder']->total_paid_tax_incl - $params['objOrder']->total_paid_tax_excl;
            else if (isset($params['objOrder']->total_products_wt) && isset($params['objOrder']->total_products))
                $tax = $params['objOrder']->total_products_wt - $params['objOrder']->total_products;
            else
                $tax = 0.00;
            $ORDER_DETAILS = array(
                'order_id' => $params['objOrder']->id,
                'order_total' => $this->currencyConvertion(
                        array(
                            'price' => floatval(isset($params['objOrder']->total_paid_tax_incl) ? $params['objOrder']->total_paid_tax_incl : (isset($params['objOrder']->total_paid) ? $params['objOrder']->total_paid : 0.00)),
                            'conversion_rate' => (isset($params['objOrder']->conversion_rate) ? $params['objOrder']->conversion_rate : 0.00),
                        )
                ),
                'order_sub_total' => $this->currencyConvertion(
                        array(
                            'price' => floatval($params['objOrder']->total_products_wt),
                            'conversion_rate' => (isset($params['objOrder']->conversion_rate) ? $params['objOrder']->conversion_rate : 0.00),
                        )
                ),
                'order_tax' => $this->currencyConvertion(
                        array(
                            'price' => floatval($tax),
                            'conversion_rate' => (isset($params['objOrder']->conversion_rate) ? $params['objOrder']->conversion_rate : 0.00),
                        )
                ),
                'order_shipping' => $this->currencyConvertion(
                        array(
                            'price' => floatval((isset($params['objOrder']->total_shipping_tax_incl) ? $params['objOrder']->total_shipping_tax_incl : (isset($params['objOrder']->total_shipping) ? $params['objOrder']->total_shipping : 0.00))),
                            'conversion_rate' => (isset($params['objOrder']->conversion_rate) ? $params['objOrder']->conversion_rate : 0.00),
                        )
                ),
                'order_discount' => $this->currencyConvertion(
                        array(
                            'price' => (isset($params['objOrder']->total_discounts_tax_incl) ?
                                    ($params['objOrder']->total_discounts_tax_incl > 0 ?
                                            floatval($params['objOrder']->total_discounts_tax_incl) : false) : (isset($params['objOrder']->total_discounts) ?
                                            ($params['objOrder']->total_discounts > 0 ?
                                                    floatval($params['objOrder']->total_discounts) : false) : 0.00)),
                            'conversion_rate' => (isset($params['objOrder']->conversion_rate) ? $params['objOrder']->conversion_rate : 0.00),
                        )
                ),
            );
            $this->context->smarty->assign(PKHelper::CPREFIX . 'ORDER_DETAILS', $ORDER_DETAILS);

            // avoid double tracking on complete order.
            self::$_isOrder = TRUE;
            return $this->display(__FILE__, 'views/templates/hook/jstracking.tpl');
        }
    }

    public function hookFooter($params) {
        if ((int) Configuration::get(PKHelper::CPREFIX . 'SITEID') <= 0)
            return "";

        if (self::$_isOrder)
            return "";

        if (_PS_VERSION_ < '1.5.6') {
            /* get page name the LAME way :) */
            if (method_exists($this->context->smarty, 'get_template_vars')) { /* smarty_2 */
                $page_name = $this->context->smarty->get_template_vars('page_name');
            } else if (method_exists($this->context->smarty, 'getTemplateVars')) {/* smarty */
                $page_name = $this->context->smarty->getTemplateVars('page_name');
            } else
                $page_name = "";
        }

        $this->__setConfigDefault();
        $this->context->smarty->assign(PKHelper::CPREFIX . 'ORDER', FALSE);

        /* cart tracking */
        if (!$this->context->cookie->PIWIKTrackCartFooter) {
            $this->context->cookie->PIWIKTrackCartFooter = time();
        }

        if (strtotime($this->context->cart->date_upd) >= $this->context->cookie->PIWIKTrackCartFooter) {
            $this->context->cookie->PIWIKTrackCartFooter = strtotime($this->context->cart->date_upd) + 2;
            $smarty_ad = array();

            $Currency = new Currency($this->context->cart->id_currency);
            foreach ($this->context->cart->getProducts() as $key => $value) {
                if (!isset($value['id_product']) || !isset($value['name']) || !isset($value['total_wt']) || !isset($value['quantity'])) {
                    continue;
                }

                $smarty_ad[] = array(
                    'SKU' => $this->parseProductSku($value['id_product'], (isset($value['id_product_attribute']) && $value['id_product_attribute'] > 0 ? $value['id_product_attribute'] : FALSE), (isset($value['reference']) ? $value['reference'] : FALSE)),
                    'NAME' => $value['name'] . (isset($value['attributes']) ? ' (' . $value['attributes'] . ')' : ''),
                    'CATEGORY' => $this->get_category_names_by_product($value['id_product'], FALSE),
                    'PRICE' => $this->currencyConvertion(
                            array(
                                'price' => $value['total_wt'],
                                'conversion_rate' => $Currency->conversion_rate,
                            )
                    ),
                    'QUANTITY' => $value['quantity'],
                );
            }

            if (count($smarty_ad) > 0) {
                $this->context->smarty->assign(PKHelper::CPREFIX . 'CART', TRUE);
                $this->context->smarty->assign(PKHelper::CPREFIX . 'CART_PRODUCTS', $smarty_ad);
                $this->context->smarty->assign(PKHelper::CPREFIX . 'CART_TOTAL', $this->currencyConvertion(
                                array(
                                    'price' => $this->context->cart->getOrderTotal(),
                                    'conversion_rate' => $Currency->conversion_rate,
                                )
                ));
            } else {
                $this->context->smarty->assign(PKHelper::CPREFIX . 'CART', FALSE);
            }

            unset($smarty_ad);
        } else {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'CART', FALSE);
        }

        $is404 = false;
        if (!empty($this->context->controller->errors)) {
            foreach ($this->context->controller->errors as $key => $value) {
                if ($value == Tools::displayError('Product not found'))
                    $is404 = true;
                if ($value == Tools::displayError('This product is no longer available.'))
                    $is404 = true;
            }
        }

        if (
                (strtolower(get_class($this->context->controller)) == 'pagenotfoundcontroller') ||
                (isset($this->context->controller->php_self) && ($this->context->controller->php_self == '404')) ||
                (isset($this->context->controller->page_name) && (strtolower($this->context->controller->page_name) == 'pagenotfound'))
        ) {
            $is404 = true;
        }

        $this->context->smarty->assign(array("PK404" => $is404));

        if (_PS_VERSION_ < '1.5.6')
            $this->_hookFooterPS14($params, $page_name);
        else if (_PS_VERSION_ >= '1.5')
            $this->_hookFooter($params);

        return $this->display(__FILE__, 'views/templates/hook/jstracking.tpl');
    }

    /**
     * add Prestashop !LATEST! specific settings
     * @param mixed $params
     * @since 0.4
     */
    private function _hookFooter($params) {
        /* product tracking */
        if (get_class($this->context->controller) == 'ProductController') {
            $products = array(array('product' => $this->context->controller->getProduct(), 'categorys' => NULL));
            if (isset($products) && isset($products[0]['product'])) {
                $smarty_ad = array();
                foreach ($products as $product) {
                    if (!Validate::isLoadedObject($product['product']))
                        continue;
                    if ($product['categorys'] == NULL)
                        $product['categorys'] = $this->get_category_names_by_product($product['product']->id, FALSE);
                    $smarty_ad[] = array(
                        /* (required) SKU: Product unique identifier */
                        'SKU' => $this->parseProductSku($product['product']->id, FALSE, (isset($product['product']->reference) ? $product['product']->reference : FALSE)),
                        /* (optional) Product name */
                        'NAME' => $product['product']->name,
                        /* (optional) Product category, or array of up to 5 categories */
                        'CATEGORY' => $product['categorys'], //$category->name,
                        /* (optional) Product Price as displayed on the page */
                        'PRICE' => $this->currencyConvertion(
                                array(
                                    'price' => Product::getPriceStatic($product['product']->id, true, false),
                                    'conversion_rate' => $this->context->currency->conversion_rate,
                                )
                        ),
                    );
                }
                $this->context->smarty->assign(array(PKHelper::CPREFIX . 'PRODUCTS' => $smarty_ad));
                unset($smarty_ad);
            }
        }

        /* category tracking */
        if (get_class($this->context->controller) == 'CategoryController') {
            $category = $this->context->controller->getCategory();
            if (Validate::isLoadedObject($category)) {
                $this->context->smarty->assign(array(
                    PKHelper::CPREFIX . 'category' => array('NAME' => $category->name),
                ));
            }
        }
    }

    /* Prestashop 1.4 only HOOKs */

    /**
     * add Prestashop 1.4 specific settings
     * @param mixed $params
     * @since 0.4
     */
    private function _hookFooterPS14($params, $page_name) {
        if (empty($page_name)) {
            /* we can't do any thing use full  */
            return;
        }

        if (strtolower($page_name) == "product" && isset($_GET['id_product']) && Validate::isUnsignedInt($_GET['id_product'])) {
            $product = new Product($_GET['id_product'], false, (isset($_GET['id_lang']) && Validate::isUnsignedInt($_GET['id_lang']) ? $_GET['id_lang'] : (isset($this->context->cookie->id_lang) ? $this->context->cookie->id_lang : NULL)));
            if (!Validate::isLoadedObject($product))
                return;
            $product_categorys = $this->get_category_names_by_product($product->id, FALSE);
            $smarty_ad = array(
                array(
                    /* (required) SKU: Product unique identifier */
                    'SKU' => $this->parseProductSku($product->id, FALSE, (isset($product->reference) ? $product->reference : FALSE)),
                    /* (optional) Product name */
                    'NAME' => $product->name,
                    /* (optional) Product category, or array of up to 5 categories */
                    'CATEGORY' => $product_categorys,
                    /* (optional) Product Price as displayed on the page */
                    'PRICE' => $this->currencyConvertion(
                            array(
                                'price' => Product::getPriceStatic($product->id, true, false),
                                'conversion_rate' => false,
                            )
                    ),
                )
            );
            $this->context->smarty->assign(array(PKHelper::CPREFIX . 'PRODUCTS' => $smarty_ad));
            unset($smarty_ad);
        }
        /* category tracking */
        if (strtolower($page_name) == "category" && isset($_GET['id_category']) && Validate::isUnsignedInt($_GET['id_category'])) {
            $category = new Category($_GET['id_category'], (isset($_GET['id_lang']) && Validate::isUnsignedInt($_GET['id_lang']) ? $_GET['id_lang'] : (isset($this->context->cookie->id_lang) ? $this->context->cookie->id_lang : NULL)));
            $this->context->smarty->assign(array(
                PKHelper::CPREFIX . 'category' => array('NAME' => $category->name),
            ));
        }
    }

    /**
     * search action
     * @param array $params
     * @since 0.4
     */
    public function hookSearch($params) {
        if ((int) Configuration::get(PKHelper::CPREFIX . 'SITEID') <= 0)
            return "";
        $this->hookactionSearch($params);
    }

    /* HELPERS */

    private function parseProductSku($id, $attrid = FALSE, $ref = FALSE) {
        if (Validate::isInt($id) && (!empty($attrid) && !is_null($attrid) && $attrid !== FALSE) && (!empty($ref) && !is_null($ref) && $ref !== FALSE)) {
            $PIWIK_PRODID_V1 = Configuration::get(PKHelper::CPREFIX . 'PRODID_V1');
            return str_replace(array('{ID}', '{ATTRID}', '{REFERENCE}'), array($id, $attrid, $ref), $PIWIK_PRODID_V1);
        } elseif (Validate::isInt($id) && (!empty($ref) && !is_null($ref) && $ref !== FALSE)) {
            $PIWIK_PRODID_V2 = Configuration::get(PKHelper::CPREFIX . 'PRODID_V2');
            return str_replace(array('{ID}', '{REFERENCE}'), array($id, $ref), $PIWIK_PRODID_V2);
        } elseif (Validate::isInt($id) && (!empty($attrid) && !is_null($attrid) && $attrid !== FALSE)) {
            $PIWIK_PRODID_V3 = Configuration::get(PKHelper::CPREFIX . 'PRODID_V3');
            return str_replace(array('{ID}', '{ATTRID}'), array($id, $attrid), $PIWIK_PRODID_V3);
        } else {
            return $id;
        }
    }

    public function displayErrors($errors) {
        if (!empty($errors)) {
            foreach ($errors as $key => $value) {
                $this->_errors .= $this->displayError($value);
            }
        }
    }

    /**
     * convert into default currentcy used in piwik
     * @param array $params
     * @return float
     * @since 0.4
     */
    private function currencyConvertion($params) {
        $pkc = Configuration::get("PIWIK_DEFAULT_CURRENCY");
        if (empty($pkc))
            return (float) $params['price'];
        if ($params['conversion_rate'] === FALSE || $params['conversion_rate'] == 0.00 || $params['conversion_rate'] == 1.00) {
            //* shop default
            return Tools::convertPrice((float) $params['price'], Currency::getCurrencyInstance((int) (Currency::getIdByIsoCode($pkc))));
        } else {
            $_shop_price = (float) ((float) $params['price'] / (float) $params['conversion_rate']);
            return Tools::convertPrice($_shop_price, Currency::getCurrencyInstance((int) (Currency::getIdByIsoCode($pkc))));
        }
        return (float) $params['price'];
    }

    /**
     * get category names by product id
     * @param integer $id product id
     * @param boolean $array get categories as PHP array (TRUE), or javacript (FAlSE)
     * @return string|array
     */
    private function get_category_names_by_product($id, $array = true) {
        $_categories = Product::getProductCategoriesFull($id, $this->context->cookie->id_lang);
        if (!is_array($_categories)) {
            if ($array)
                return array();
            else
                return "[]";
        }

        if ($array) {
            $categories = array();
            foreach ($_categories as $category) {
                $categories[] = $category['name'];
                if (count($categories) == 5)
                    break;
            }
        } else {
            $categories = '[';
            $c = 0;
            foreach ($_categories as $category) {
                $c++;
                $categories .= '"' . $category['name'] . '",';
                if ($c == 5)
                    break;
            }
            $categories = rtrim($categories, ',');
            $categories .= ']';
        }
        return $categories;
    }

    /**
     * get module link
     * @param string $module
     * @param string $controller
     * @return string
     * @since 0.4
     */
    public static function getModuleLink($module, $controller = 'default') {
        if (version_compare(_PS_VERSION_, '1.5.0.13', "<="))
            return Tools::getShopDomainSsl(true, true) . _MODULE_DIR_ . $module . '/' . $controller . '.php';
        else
            return Context::getContext()->link->getModuleLink($module, $controller);
    }

    private function __setConfigDefault() {

        $this->context->smarty->assign(PKHelper::CPREFIX . 'USE_PROXY', (bool) Configuration::get(PKHelper::CPREFIX . 'USE_PROXY'));

        //* using proxy script?
        if ((bool) Configuration::get(PKHelper::CPREFIX . 'USE_PROXY'))
            $this->context->smarty->assign(PKHelper::CPREFIX . 'HOST', Configuration::get(PKHelper::CPREFIX . 'PROXY_SCRIPT'));
        else
            $this->context->smarty->assign(PKHelper::CPREFIX . 'HOST', Configuration::get(PKHelper::CPREFIX . 'HOST'));

        $this->context->smarty->assign(PKHelper::CPREFIX . 'SITEID', Configuration::get(PKHelper::CPREFIX . 'SITEID'));

        $pkvct = (int) Configuration::get(PKHelper::CPREFIX . 'COOKIE_TIMEOUT'); /* no iset if the same as default */
        if ($pkvct != 0 && $pkvct !== FALSE && ($pkvct != (int) (self::PK_VC_TIMEOUT * 60))) {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'COOKIE_TIMEOUT', $pkvct);
        }
        unset($pkvct);

        $pkrct = (int) Configuration::get(PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT'); /* no iset if the same as default */
        if ($pkrct != 0 && $pkrct !== FALSE && ($pkrct != (int) (self::PK_RC_TIMEOUT * 60))) {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT', $pkrct);
        }
        unset($pkrct);

        $pksct = (int) Configuration::get(PKHelper::CPREFIX . 'SESSION_TIMEOUT'); /* no iset if the same as default */
        if ($pksct != 0 && $pksct !== FALSE && ($pksct != (int) (self::PK_SC_TIMEOUT * 60))) {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'SESSION_TIMEOUT', $pksct);
        }
        unset($pksct);

        $this->context->smarty->assign(PKHelper::CPREFIX . 'EXHTML', Configuration::get(PKHelper::CPREFIX . 'EXHTML'));

        $PIWIK_COOKIE_DOMAIN = Configuration::get(PKHelper::CPREFIX . 'COOKIE_DOMAIN');
        $this->context->smarty->assign(PKHelper::CPREFIX . 'COOKIE_DOMAIN', (empty($PIWIK_COOKIE_DOMAIN) ? FALSE : $PIWIK_COOKIE_DOMAIN));

        $PIWIK_SET_DOMAINS = Configuration::get(PKHelper::CPREFIX . 'SET_DOMAINS');
        if (!empty($PIWIK_SET_DOMAINS)) {
            $sdArr = explode(' ', Configuration::get(PKHelper::CPREFIX . 'SET_DOMAINS'));
            if (count($sdArr) > 1)
                $PIWIK_SET_DOMAINS = "['" . trim(implode("','", $sdArr), ",'") . "']";
            else
                $PIWIK_SET_DOMAINS = "'{$sdArr[0]}'";
            $this->context->smarty->assign(PKHelper::CPREFIX . 'SET_DOMAINS', (!empty($PIWIK_SET_DOMAINS) ? $PIWIK_SET_DOMAINS : FALSE));
            unset($sdArr);
        }else {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'SET_DOMAINS', FALSE);
        }
        unset($PIWIK_SET_DOMAINS);

        if ((bool) Configuration::get(PKHelper::CPREFIX . 'DNT')) {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'DNT', "_paq.push([\"setDoNotTrack\", true]);");
        }

        if (_PS_VERSION_ < '1.5' && $this->context->cookie->isLogged()) {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'UUID', $this->context->cookie->email);
        } else if ($this->context->customer->isLogged()) {
            $this->context->smarty->assign(PKHelper::CPREFIX . 'UUID', $this->context->customer->email);
        }
    }

    private function __setCurrencies() {
        $this->default_currency = array('value' => 0, 'label' => $this->l('Choose currency'));
        if (empty($this->currencies)) {
            foreach (Currency::getCurrencies() as $key => $val) {
                $this->currencies[$key] = array(
                    'iso_code' => $val['iso_code'],
                    'name' => "{$val['name']} {$val['iso_code']}",
                );
            }
        }
    }

    private function getConfigFields($form = FALSE) {
        $fields = array(
            PKHelper::CPREFIX . 'USE_PROXY', PKHelper::CPREFIX . 'HOST',
            PKHelper::CPREFIX . 'SITEID', PKHelper::CPREFIX . 'TOKEN_AUTH',
            PKHelper::CPREFIX . 'COOKIE_TIMEOUT', PKHelper::CPREFIX . 'SESSION_TIMEOUT',
            PKHelper::CPREFIX . 'DEFAULT_CURRENCY', PKHelper::CPREFIX . 'CRHTTPS',
            PKHelper::CPREFIX . 'PRODID_V1', PKHelper::CPREFIX . 'PRODID_V2',
            PKHelper::CPREFIX . 'PRODID_V3', PKHelper::CPREFIX . 'COOKIE_DOMAIN',
            PKHelper::CPREFIX . 'SET_DOMAINS', PKHelper::CPREFIX . 'DNT',
            PKHelper::CPREFIX . 'EXHTML', PKHelper::CPREFIX . 'RCOOKIE_TIMEOUT',
            PKHelper::CPREFIX . 'USRNAME', PKHelper::CPREFIX . 'USRPASSWD',
            PKHelper::CPREFIX . 'PAUTHUSR', PKHelper::CPREFIX . 'PAUTHPWD',
            PKHelper::CPREFIX . 'DREPDATE', PKHelper::CPREFIX . 'USE_CURL'
        );
        $defaults = array(
            0, "", 0, "", self::PK_VC_TIMEOUT, self::PK_SC_TIMEOUT, 'EUR', 0,
            '{ID}-{ATTRID}#{REFERENCE}', '{ID}#{REFERENCE}',
            '{ID}#{ATTRID}', Tools::getShopDomain(), '', 0,
            '', self::PK_RC_TIMEOUT, '', '', '', '', 'day|today', 0
        );
        $ret = array();
        if ($form)
            foreach ($fields as $key => $value)
                $ret[$value] = Configuration::get($value);
        else
            foreach ($fields as $key => $value)
                $ret[$value] = $defaults[$key];


        return $ret;
    }

    /* INSTALL / UNINSTALL */

    /**
     * Install the module
     * @return boolean false on install error
     */
    public function install() {
        /* create complete new page tab */
        $tab = new Tab();
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[(int) $lang['id_lang']] = 'Piwik Analytics';
        }
        $tab->module = 'piwikanalyticsjs';
        $tab->active = TRUE;

        if (method_exists('Tab', 'getInstanceFromClassName')) {
            if (version_compare(_PS_VERSION_, '1.5.0.5', ">=") && version_compare(_PS_VERSION_, '1.5.3.999', "<=")) {
                $tab->class_name = 'PiwikAnalytics15';
            } else if (version_compare(_PS_VERSION_, '1.5.0.13', "<=")) {
                $tab->class_name = 'AdminPiwikAnalytics';
            } else {
                $tab->class_name = 'PiwikAnalytics';
            }
            $AdminParentStats = TabCore::getInstanceFromClassName('AdminStats');
            if ($AdminParentStats == null || !($AdminParentStats instanceof Tab || $AdminParentStats instanceof TabCore) || $AdminParentStats->id == 0)
                $AdminParentStats = TabCore::getInstanceFromClassName('AdminParentStats');
        } else if (method_exists('Tab', 'getIdFromClassName')) {
            if (version_compare(_PS_VERSION_, '1.5.0.5', ">=") && version_compare(_PS_VERSION_, '1.5.3.999', "<=")) {
                $tab->class_name = 'PiwikAnalytics15';
            } else if (version_compare(_PS_VERSION_, '1.5.0.13', "<=")) {
                $tab->class_name = 'AdminPiwikAnalytics';
            } else {
                $tab->class_name = 'PiwikAnalytics';
            }
            $tmpId = TabCore::getIdFromClassName('AdminStats');
            if ($tmpId != null && $tmpId > 0)
                $AdminParentStats = new Tab($tmpId);
            else {
                $tmpId = TabCore::getIdFromClassName('AdminParentStats');
                if ($tmpId != null && $tmpId > 0)
                    $AdminParentStats = new Tab($tmpId);
            }
        }

        $tab->id_parent = (isset($AdminParentStats) && ($AdminParentStats instanceof Tab || $AdminParentStats instanceof TabCore) ? $AdminParentStats->id : -1);
        if ($tab->add())
            Configuration::updateValue(PKHelper::CPREFIX . 'TAPID', (int) $tab->id);
        else {
            $this->_errors[] = sprintf($this->l('Unable to create new tab "Piwik Analytics", Please forward tthe following info to the developer %s'), "<br/>"
                    . (isset($AdminParentStats) ? "isset(\$AdminParentStats): True" : "isset(\$AdminParentStats): False")
                    . "<br/>"
                    . "Type of \$AdminParentStats: " . gettype($AdminParentStats)
                    . "<br/>"
                    . "Class name of \$AdminParentStats: " . get_class($AdminParentStats)
                    . "<br/>"
                    . (($AdminParentStats instanceof Tab || $AdminParentStats instanceof TabCore) ? "\$AdminParentStats instanceof Tab: True" : "\$AdminParentStats instanceof Tab: False")
                    . "<br/>"
                    . (($AdminParentStats instanceof Tab || $AdminParentStats instanceof TabCore) ? "\$AdminParentStats->id: " . $AdminParentStats->id : "\$AdminParentStats->id: ?0?")
                    . "<br/>"
                    . (($AdminParentStats instanceof Tab || $AdminParentStats instanceof TabCore) ? "\$AdminParentStats->name: " . $AdminParentStats->name : "\$AdminParentStats->name: ?0?")
                    . "<br/>"
                    . (($AdminParentStats instanceof Tab || $AdminParentStats instanceof TabCore) ? "\$AdminParentStats->class_name: " . $AdminParentStats->class_name : "\$AdminParentStats->class_name: ?0?")
                    . "<br/>"
                    . "Prestashop version: " . _PS_VERSION_
                    . "<br/>"
                    . "PHP version: " . PHP_VERSION
            );
        }

        /* default values */
        foreach ($this->getConfigFields(FALSE) as $key => $value) {
            Configuration::updateValue($key, $value);
        }

        $install = (parent::install() && $this->registerHook('header') && $this->registerHook('footer') && $this->registerHook('displayBackOfficeHeader') && $this->registerHook('displayBackOfficeFooter') && $this->registerHook('actionSearch') && $this->registerHook('displayRightColumnProduct') && $this->registerHook('orderConfirmation') && $this->registerHook('displayMaintenance'));

        if($install){
            $tabs = [
                [
                    'id_parent' => 1,
                    'class_name' => 'PiwikAnalytics',
                    'active' => 1,
                    'name' => 'Dashboard',
                    'module' => 'piwikanalyticsjs'
                ],

                [
                    'id_parent' => 1,
                    'class_name' => 'PiwikAnalyticsVisitors',
                    'active' => 1,
                    'name' => 'Visitors',
                    'module' => 'piwikanalyticsjs'
                ],

                [
                    'id_parent' => 1,
                    'class_name' => 'PiwikAnalyticsBehaviour',
                    'active' => 1,
                    'name' => 'Behaviour',
                    'module' => 'piwikanalyticsjs'
                ],

                [
                    'id_parent' => 1,
                    'class_name' => 'PiwikAnalyticsAcquisition',
                    'active' => 1,
                    'name' => 'Acquisition',
                    'module' => 'piwikanalyticsjs'
                ],

                [
                    'id_parent' => 1,
                    'class_name' => 'PiwikAnalyticsEcommerce',
                    'active' => 1,
                    'name' => 'Ecommerce',
                    'module' => 'piwikanalyticsjs'
                ],

                [
                    'id_parent' => 1,
                    'class_name' => 'PiwikAnalyticsGoals',
                    'active' => 1,
                    'name' => 'Goals',
                    'module' => 'piwikanalyticsjs'
                ]
            ];

            foreach ($tabs as $fields) {
                $tab = new Tab();

                foreach ($fields as $name => $value) {
                    $tab->{$name} = $value;
                }

                $tab->add();
            }

            return $install;
        }else{
            return false;
        }
    }

    /**
     * Uninstall the module
     * @return boolean false on uninstall error
     */
    public function uninstall() {
        if (parent::uninstall()) {
            foreach ($this->getConfigFields(FALSE) as $key => $value) {
                Configuration::deleteByName($key);
            }

            try {
                if (method_exists('Tab', 'getInstanceFromClassName')) {
                    if (version_compare(_PS_VERSION_, '1.5.0.5', ">=") && version_compare(_PS_VERSION_, '1.5.3.999', "<="))
                        $AdminParentStats = Tab::getInstanceFromClassName('PiwikAnalytics15');
                    else if (version_compare(_PS_VERSION_, '1.5.0.4', "<="))
                        $AdminParentStats = Tab::getInstanceFromClassName('AdminPiwikAnalytics');
                    else
                        $AdminParentStats = Tab::getInstanceFromClassName('PiwikAnalytics');
                } else if (method_exists('Tab', 'getIdFromClassName')) {
                    if (version_compare(_PS_VERSION_, '1.5.0.5', ">=") && version_compare(_PS_VERSION_, '1.5.3.999', "<="))
                        $tmpId = Tab::getIdFromClassName('PiwikAnalytics15');
                    else if (version_compare(_PS_VERSION_, '1.5.0.4', "<="))
                        $tmpId = Tab::getIdFromClassName('AdminPiwikAnalytics');
                    else
                        $tmpId = Tab::getIdFromClassName('PiwikAnalytics');
                    if ($tmpId != null && $tmpId > 0)
                        $AdminParentStats = new Tab($tmpId);
                }
                if (isset($AdminParentStats) && ($AdminParentStats instanceof Tab || $AdminParentStats instanceof TabCore)) {
                    $AdminParentStats->delete();
                }
            } catch (Exception $ex) {

            }

            Db::getInstance()->delete(
                'tab',

                'id_parent = 1'
            );

            Configuration::deleteByName(PKHelper::CPREFIX . 'TAPID');

            return true;
        }

        return false;
    }

    public function refreshAnalytics($force = false){
        $prefix = _DB_PREFIX_;
        $aprefix = 'analytics_';
        $analytics_token = Configuration::get('PIWIK_TOKEN_AUTH');
        $analytics_host = Configuration::get('PIWIK_HOST');
        $dateRange = [
            date('Y-m-d', time() - (60 * 60 * 24 * 7) ),
            date('Y-m-d')
        ];

        $idSites = 1;

        $ordersToDelete = Db::getInstance()->ExecuteS("
            SELECT lc.idorder FROM {$aprefix}log_conversion as lc
            LEFT JOIN {$prefix}orders as o ON (lc.idorder = o.id_order)
            WHERE o.id_order IS NULL AND lc.buster > 0
        ");

        if($ordersToDelete){
            foreach ($ordersToDelete as $order) {
                $order = new Order($order['idorder']);
                $order->delete();
            }
        }


        $orders = Db::getInstance()->ExecuteS("
            SELECT o.id_order FROM {$prefix}orders as o
            LEFT JOIN {$aprefix}log_conversion as lc ON (lc.idorder = o.id_order)
            WHERE lc.idorder IS NULL
        ");

        if($orders){
            foreach ($orders as $order) {
                $order = new Order($order['id_order']);

                $url = 'https://' . $this->context->shop->domain_ssl . '/modules/' . $this->name . '/refreshAnalyticsCache.php?id_order=' . $order->id;

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                curl_exec($ch);

                curl_close($ch);

                $date = date('Y-m-d', strtotime($order->date_add));

                if(strtotime($date) < strtotime($dateRange[0])){
                    $dateRange[0] = $date;
                }
            }

            $dateRange = implode(',', $dateRange);

            $refresh_link = 'https://' . $analytics_host . '?module=API&method=CoreAdminHome.clearAnalyticsCache&period=range&idSites=' . $idSites . '&dates=' . $dateRange . '&token_auth=' . $analytics_token;

            $command = "curl -sS '{$refresh_link}'";

            exec($command);
        }elseif($force) {
            $dateRange = implode(',', $dateRange);

            $refresh_link = 'https://' . $analytics_host . '?module=API&method=CoreAdminHome.clearAnalyticsCache&period=range&idSites=' . $idSites . '&dates=' . $dateRange . '&token_auth=' . $analytics_token;

            $command = "curl -sS '{$refresh_link}'";

            exec($command);
        }

    }

    public function hookDisplayBackOfficeFooter($params){
        $this->refreshAnalytics();
    }

    public function hookDisplayBackOfficeHeader($params){
        $confirmation = '';

        if(Tools::isSubmit('refreshAnalytics')){
            $this->refreshAnalytics();

            header('Location: /login888/index.php?controller=' . Tools::getValue('controller') . '&token=' . Tools::getValue('token'));
            exit;
        }

        if( isset($this->context->controller->dh_support) )
            return;

        $this->context->controller->dh_support = 1;
        $this->context->controller->addJQuery();

        if (version_compare(@_PS_VERSION_,'1.6','<'))
            $this->context->controller->addJS($this->_path . '/dh42_15.js', 'all');
        else
            $this->context->controller->addJS($this->_path . '/dh42.js', 'all');

        return $confirmation;
    }
}
