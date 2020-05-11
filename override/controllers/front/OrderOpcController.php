<?php

class OrderOpcController extends OrderOpcControllerCore
{
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public $php_self = 'order-opc';
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public $isLogged;
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private $opc_templates_path;
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private $opc_config;
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private $inv_first_on;
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private $default_ps_carriers;
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function _assignOpcSettings()
    {
        $opc_module_file = _PS_MODULE_DIR_ . "onepagecheckout/onepagecheckout.php";
        if (file_exists($opc_module_file)) {
            require_once($opc_module_file);
            $opc_mod          = new OnePageCheckout();
            $this->opc_config = $opc_mod->_getAllOptionsValues();
            $this->context->smarty->assign("opc_config", $this->opc_config);
        }
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function _setExtraDivPaymentBlock()
    {
        $this->context->smarty->assign("add_extra_div", false);
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private $opcModuleActive = -1; // -1 .. not set, 0 .. inactive, 1 .. active
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function isOpcModuleActive()
    {
        if (Configuration::get('OPC_MOBILE_FALLBACK') && $this->context->getMobileDevice())
            return false;
        if (isset($this->context->cookie->express_checkout) && Configuration::get('OPC_PAYPAL_EXPRESS_FALLBACK'))
            return false;
        if ($this->opcModuleActive > -1)
            return $this->opcModuleActive;
        $opc_mod_script = _PS_MODULE_DIR_ . 'onepagecheckout/onepagecheckout.php';
        if (file_exists($opc_mod_script)) {
            require_once($opc_mod_script);
            $opc_mod               = new OnePageCheckout();
            $this->opcModuleActive = (Tools::getValue('opc-debug') == 1900)?true:((Tools::getValue('opc-debug') == 1901)?false:$opc_mod->active);
        } else {
            $this->opcModuleActive = 0;
        }
        return $this->opcModuleActive;
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function isPS15() {
        return version_compare(_PS_VERSION_, "1.6") < 0;
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function init()
    {
        if (!$this->isOpcModuleActive())
            return parent::init();

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (Tools::getIsset('id_carrier') && strpos(Tools::getValue('id_carrier'), ",")>0) {
            $_POST['id_carrier'] = Cart::intifier(Tools::getValue('id_carrier'));
        }    
            
        $this->opc_templates_path = _PS_MODULE_DIR_ . 'onepagecheckout/views/templates/front';
        $this->origInit();
        $this->_assignOpcSettings();
        if ($this->opc_config != null && $this->opc_config['goods_return_cms'] > 0) {
            $cms = new CMS((int)($this->opc_config['goods_return_cms']), (int)($this->context->language->id));
            $link_goods_return = $this->context->link->getCMSLink($cms, $cms->link_rewrite, true);
            if (!strpos($link_goods_return, '?'))
                $link_goods_return .= '?content_only=1';
            else
                $link_goods_return .= '&content_only=1';
            $this->context->smarty->assign("link_goods_return", $link_goods_return);
        }
        $this->_setInfoBlockContent();
        $this->_setExtraDivPaymentBlock();
        if ($this->nbProducts)
            $this->context->smarty->assign('virtual_cart', false);
        $this->context->smarty->assign('is_multi_address_delivery', $this->context->cart->isMultiAddressDelivery() || ((int)Tools::getValue('multi-shipping') == 1));
        $this->context->smarty->assign('open_multishipping_fancybox', (int)Tools::getValue('multi-shipping') == 1);
        $this->context->smarty->assign('order_process_type', Configuration::get('PS_ORDER_PROCESS_TYPE'));
        $this->context->smarty->assign('one_phone_at_least', (int)Configuration::get('PS_ONE_PHONE_AT_LEAST'));
        $this->inv_first_on = isset($this->opc_config) && isset($this->opc_config["invoice_first"]) && $this->opc_config["invoice_first"] == "1";
        $this->default_ps_carriers =isset($this->opc_config) && isset($this->opc_config["default_ps_carriers"]) && $this->opc_config["default_ps_carriers"] == "1";
        if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0)
            $this->isLogged = (bool)($this->context->customer->id && Customer::customerIdExistsStatic((int)$this->context->cookie->id_customer));
        if ($this->context->cart->nbProducts()) {
            if (Tools::isSubmit('ajax')) {
                if (Tools::isSubmit('method')) {
                    switch (Tools::getValue('method')) {
                        case 'updateMessage':
                            if (Tools::isSubmit('message')) {
                                $txtMessage = urldecode(Tools::getValue('message'));
                                $this->_updateMessage($txtMessage);
                                if (count($this->errors))
                                    die('{"hasError" : true, "errors" : ["' . implode('\',\'', $this->errors) . '"]}');
                                die(true);
                            }
                            break;
                        case 'updateCarrierAndGetPayments':
                            if ((Tools::isSubmit('delivery_option') || Tools::isSubmit('id_carrier')) && Tools::isSubmit('recyclable') && Tools::isSubmit('gift') && Tools::isSubmit('gift_message')) {
                                $this->_assignWrappingAndTOS();
                                CartRule::autoRemoveFromCart($this->context);
                                CartRule::autoAddToCart($this->context);
                                if ($this->_processCarrier()) {
                                    $carriers = $this->context->cart->simulateCarriersOutput();
                                    $return   = array_merge(array(
                                        'HOOK_TOP_PAYMENT'   => Hook::exec('displayPaymentTop'),
                                        'HOOK_PAYMENT'       => $this->_getPaymentMethods(),
                                        'carrier_data'       => $this->_getCarrierList(),
                                        'HOOK_BEFORECARRIER' => Hook::exec('displayBeforeCarrier', array('carriers' => $carriers))
                                    ),$this->getFormatedSummaryDetail());
                                    Cart::addExtraCarriers($return);
                                    die(Tools::jsonEncode($return));
                                } else
                                    $this->errors[] = Tools::displayError('Error occurred while updating cart.');
                                if (count($this->errors))
                                    die('{"hasError" : true, "errors" : ["' . implode('\',\'', $this->errors) . '"]}');
                                exit;
                            }
                            break;
                        case 'updateTOSStatusAndGetPayments':
                            if (Tools::isSubmit('checked')) {
                                $this->context->cookie->checkedTOS = (int)(Tools::getValue('checked'));
                                die(Tools::jsonEncode(array(
                                )));
                            }
                            break;
                        case 'updatePaymentsOnly':
                            die(Tools::jsonEncode(array(
                                'HOOK_TOP_PAYMENT' => Hook::exec('displayPaymentTop'),
                                'HOOK_PAYMENT'     => self::_getPaymentMethods()
                            )));
                            break;
                        case 'getCarrierList':
                            $this->context->smarty->assign('isVirtualCart', $this->context->cart->isVirtualCart());
                            $result = $this->_getCarrierList();
                            $result = array_merge($result, array(
                                'HOOK_TOP_PAYMENT'      => Hook::exec('displayPaymentTop'),
                                'HOOK_PAYMENT'          => $this->_getPaymentMethods(),
                            ), $this->getFormatedSummaryDetail());
                            die(Tools::jsonEncode($result));
                            break;
                        case 'editCustomer':
                            if (!$this->isLogged)
                                exit;
                            if (Tools::getValue('years'))
                                $this->context->customer->birthday = (int)Tools::getValue('years') . '-' . (int)Tools::getValue('months') . '-' . (int)Tools::getValue('days');
                            if (trim(Tools::getValue('customer_lastname')) == "")
                                $_POST['customer_lastname'] = ($this->inv_first_on)? Tools::getValue('lastname_invoice') : Tools::getValue('lastname');
                            if (trim(Tools::getValue('customer_firstname')) == "")
                                $_POST['customer_firstname'] = ($this->inv_first_on)? Tools::getValue('firstname_invoice') : Tools::getValue('firstname');
                            $this->errors                        = $this->context->customer->validateController();
                            $this->context->customer->newsletter = (int)Tools::isSubmit('newsletter');
                            $this->context->customer->optin      = (int)Tools::isSubmit('optin');
                            $return                              = array(
                                'hasError'    => !empty($this->errors),
                                'errors'      => $this->errors,
                                'id_customer' => (int)$this->context->customer->id,
                                'token'       => Tools::getToken(false)
                            );
                            if (!count($this->errors))
                                $return['isSaved'] = (bool)$this->context->customer->update();
                            else
                                $return['isSaved'] = false;
                            die(Tools::jsonEncode($return));
                            break;
                        case 'getAddressBlockAndCarriersAndPayments':
                            if ($this->context->customer->isLogged()) {
                                if (!Customer::getAddressesTotalById($this->context->customer->id))
                                    die(Tools::jsonEncode(array('no_address' => 1)));
                                if (file_exists(_PS_MODULE_DIR_ . 'blockuserinfo/blockuserinfo.php')) {
                                    include_once(_PS_MODULE_DIR_ . 'blockuserinfo/blockuserinfo.php');
                                    $blockUserInfo = new BlockUserInfo();
                                }
                                $this->context->smarty->assign('isVirtualCart', $this->context->cart->isVirtualCart());
                                $customer      = $this->context->customer;
                                $customer_info = array(
                                    "id"         => $customer->id,
                                    "email"      => $customer->email,
                                    "id_gender"  => $customer->id_gender,
                                    "birthday"   => $customer->birthday,
                                    "newsletter" => $customer->newsletter,
                                    "optin"      => $customer->optin,
                                    "is_guest"   => $customer->is_guest
                                );
                                $this->_processAddressFormat();
                                $this->_assignAddress();
                                $address_delivery = $this->context->smarty->tpl_vars['delivery']->value;
                                $address_invoice  = $this->context->smarty->tpl_vars['invoice']->value;
                                if (Configuration::get('VATNUMBER_MANAGEMENT') &&
                                    file_exists(_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php') &&
                                    !class_exists("VatNumber", false)
                                ) {
                                    include_once (_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php');
                                }
                                if (isset($address_delivery) && Configuration::get('VATNUMBER_MANAGEMENT') AND
                                    file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                                        VatNumber::isApplicable($address_delivery->id_country) &&
                                        Configuration::get('VATNUMBER_COUNTRY') != $address_delivery->id_country
                                )
                                    $allow_eu_vat_delivery = 1;
                                else
                                    $allow_eu_vat_delivery = 0;
                                if (isset($address_invoice) && Configuration::get('VATNUMBER_MANAGEMENT') AND
                                    file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                                        VatNumber::isApplicable($address_invoice->id_country) &&
                                        Configuration::get('VATNUMBER_COUNTRY') != $address_invoice->id_country
                                )
                                    $allow_eu_vat_invoice = 1;
                                else
                                    $allow_eu_vat_invoice = 0;
                                $wrapping_fees_tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
                                if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0) {
                                    $wrapping_fees = (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE'));
                                    $wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float)($wrapping_fees_tax->rate) / 100)));
                                } else {
                                    $wrapping_fees = $this->context->cart->getGiftWrappingPrice(false);
                                    $wrapping_fees_tax_inc = $wrapping_fees = $this->context->cart->getGiftWrappingPrice();
                                }
                                $return                = array_merge(array(
                                    'customer_info'         => $customer_info,
                                    'allow_eu_vat_delivery' => $allow_eu_vat_delivery,
                                    'allow_eu_vat_invoice'  => $allow_eu_vat_invoice,
                                    'customer_addresses'    => $this->context->smarty->tpl_vars['addresses']->value,
                                    'block_user_info'       => (isset($blockUserInfo) ? (method_exists($blockUserInfo,'hookTop') ? $blockUserInfo->hookTop(array()):$blockUserInfo->hookDisplayTop(array())) : ''),
                                    'carrier_data'          => $this->_getCarrierList(),
                                    'HOOK_TOP_PAYMENT'      => Hook::exec('displayPaymentTop'),
                                    'HOOK_PAYMENT'          => $this->_getPaymentMethods(),
                                    'no_address'            => 0,
                                    'gift_price'            => Tools::displayPrice(Tools::convertPrice(Product::getTaxCalculationMethod() == 1 ? $wrapping_fees : $wrapping_fees_tax_inc, new Currency((int)($this->context->cookie->id_currency))))
                                ), $this->getFormatedSummaryDetail());
                                die(Tools::jsonEncode($return));
                            }
                            die(Tools::displayError("Customer is not logged in, while he should be. Check please AuthController and cookies."));
                            break;
                        case 'makeFreeOrder':
                            
                            if (($id_order = $this->_checkFreeOrder()) && $id_order) {
                                $order = new Order((int)$id_order);
                                $email = $this->context->customer->email;
                                if ($this->context->customer->is_guest)
                                    $this->context->customer->logout(); // If guest we clear the cookie for security reason
                                die('freeorder:' . $order->reference . ':' . $email);
                            }
                            exit;
                            break;
                        case 'updateAddressesSelected':
                            $id_address_delivery = (int)(Tools::getValue('id_address_delivery'));
                            $id_address_invoice  = (int)(Tools::getValue('id_address_invoice'));
                            $address_delivery    = new Address((int)(Tools::getValue('id_address_delivery')));
                            $address_invoice     = ((int)(Tools::getValue('id_address_delivery')) == (int)(Tools::getValue('id_address_invoice')) ? $address_delivery : new Address((int)(Tools::getValue('id_address_invoice'))));
                            if (Configuration::get('VATNUMBER_MANAGEMENT') &&
                                file_exists(_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php') &&
                                !class_exists("VatNumber", false)
                            ) {
                                include_once (_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php');
                            }
                            if (isset($address_delivery) && Configuration::get('VATNUMBER_MANAGEMENT') &&
                                file_exists(_PS_MODULE_DIR_.'/vatnumber/vatnumber.php') &&
                                    VatNumber::isApplicable($address_delivery->id_country) &&
                                    Configuration::get('VATNUMBER_COUNTRY') != $address_delivery->id_country
                            )
                                $allow_eu_vat_delivery = 1;
                            else
                                $allow_eu_vat_delivery = 0;
                            if (isset($address_invoice) && Configuration::get('VATNUMBER_MANAGEMENT') AND
                                file_exists(_PS_MODULE_DIR_.'/vatnumber/vatnumber.php') &&
                                    VatNumber::isApplicable($address_invoice->id_country) &&
                                    Configuration::get('VATNUMBER_COUNTRY') != $address_invoice->id_country
                            )
                                $allow_eu_vat_invoice = 1;
                            else
                                $allow_eu_vat_invoice = 0;
                            $address_delivery = new Address((int)(Tools::getValue('id_address_delivery')));
                            $this->context->smarty->assign('isVirtualCart', $this->context->cart->isVirtualCart());
                            $address_invoice = ((int)(Tools::getValue('id_address_delivery')) == (int)(Tools::getValue('id_address_invoice')) ? $address_delivery : new Address((int)(Tools::getValue('id_address_invoice'))));
                            if (($address_delivery->id_customer && $address_delivery->id_customer != $this->context->customer->id) || ($address_invoice->id_customer && $address_invoice->id_customer != $this->context->customer->id))
                            {
                                $this->errors = "not_your_address";
                            }
                            if (!Address::isCountryActiveById((int)(Tools::getValue('id_address_delivery'))))
                                $this->errors[] = Tools::displayError('This address is not in a valid area.');
                            elseif (!Validate::isLoadedObject($address_delivery) || !Validate::isLoadedObject($address_invoice) || $address_invoice->deleted || $address_delivery->deleted)
                                $this->errors[] = Tools::displayError('This address is invalid.');
                            else {
                                $this->context->cart->id_address_delivery = (int)(Tools::getValue('id_address_delivery'));
                                $this->context->cart->id_address_invoice  = Tools::isSubmit('same') ? $this->context->cart->id_address_delivery : (int)(Tools::getValue('id_address_invoice'));
                                if (!$this->context->cart->update())
                                    $this->errors[] = Tools::displayError('An error occurred while updating your cart.');
                                CartRule::autoRemoveFromCart($this->context);
                                CartRule::autoAddToCart($this->context);
                                    $this->context->cart->setNoMultishipping(); // As the cart is no multishipping, set each delivery address lines with the main delivery address
                                if (!count($this->errors)) {
                                    $result = $this->_getCarrierList();
                                    $wrapping_fees_tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
                                    if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0) {
                                        $wrapping_fees = (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE'));
                                        $wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float)($wrapping_fees_tax->rate) / 100)));
                                    } else {
                                        $wrapping_fees = $this->context->cart->getGiftWrappingPrice(false);
                                        $wrapping_fees_tax_inc = $wrapping_fees = $this->context->cart->getGiftWrappingPrice();
                                    }
                                    $result                = array_merge($result, array(
                                        'allow_eu_vat_delivery' => $allow_eu_vat_delivery,
                                        'allow_eu_vat_invoice'  => $allow_eu_vat_invoice,
                                        'HOOK_TOP_PAYMENT'      => Hook::exec('displayPaymentTop'),
                                        'HOOK_PAYMENT'          => $this->_getPaymentMethods(),
                                        'gift_price'            => Tools::displayPrice(Tools::convertPrice(Product::getTaxCalculationMethod() == 1 ? $wrapping_fees : $wrapping_fees_tax_inc, new Currency((int)($this->context->cookie->id_currency)))),
                                        'carrier_data'          => $this->_getCarrierList()
                                    ), $this->getFormatedSummaryDetail());
                                    die(Tools::jsonEncode($result));
                                }
                            }
                            if (count($this->errors))
                                die(Tools::jsonEncode(array(
                                    'hasError' => true,
                                    'errors'   => $this->errors
                                )));
                            break;
                        case 'multishipping':
                            $this->_assignSummaryInformations();
                            $this->context->smarty->assign('product_list', $this->context->cart->getProducts());
                            if ($this->context->customer->id)
                                $this->context->smarty->assign('address_list', $this->context->customer->getAddresses($this->context->language->id));
                            else
                                $this->context->smarty->assign('address_list', array());
                            $this->setTemplate(_PS_THEME_DIR_ . 'order-address-multishipping-products.tpl');
                            $this->display();
                            die();
                            break;
                        case 'cartReload':
                            $this->_assignSummaryInformations();
                            if ($this->context->customer->id)
                                $this->context->smarty->assign('address_list', $this->context->customer->getAddresses($this->context->language->id));
                            else
                                $this->context->smarty->assign('address_list', array());
                            $this->context->smarty->assign('opc', true);
                            $this->setTemplate(_PS_THEME_DIR_ . 'shopping-cart.tpl');
                            $this->display();
                            die();
                            break;
                        case 'noMultiAddressDelivery':
                            $this->context->cart->setNoMultishipping();
                            die();
                            break;
                        case 'emailCheck':
                            if (Tools::isSubmit('cust_email')) {
                                $customer_email = Tools::getValue('cust_email');
                                $is_registered  = (Validate::isEmail($customer_email)) ? Customer::customerExists($customer_email) : 0;
                                $return         = array(
                                    'is_registered' => $is_registered
                                );
                                die(Tools::jsonEncode($return));
                            }
                            break;
                        case 'zipCheck':
                            if (Tools::isSubmit('id_country')) {
                                $id_country = Tools::getValue('id_country');
                                if ($id_country > 0) {
                                    $errors = array();
                                    $country         = new Country($id_country);
                                    $zip_code_format = $country->zip_code_format;
                                    if ($country->need_zip_code) {
                                        if (($postcode = Tools::getValue('postcode')) AND $zip_code_format) {
                                            $zip_regexp = '/^' . $zip_code_format . '$/ui';
                                            $zip_regexp = str_replace(' ', '( |)', $zip_regexp);
                                            $zip_regexp = str_replace('-', '(-|)', $zip_regexp);
                                            $zip_regexp = str_replace('N', '[0-9]', $zip_regexp);
                                            $zip_regexp = str_replace('L', '[a-zA-Z]', $zip_regexp);
                                            $zip_regexp = str_replace('C', $country->iso_code, $zip_regexp);
                                            if (!preg_match($zip_regexp, $postcode))
                                                $errors[] = '<strong>' . Tools::displayError('Zip/ Postal code') . '</strong> ' . Tools::displayError('is invalid.') . '<br />' . Tools::displayError('Must be typed as follows:') . ' ' . str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $zip_code_format)));
                                        } elseif ($zip_code_format)
                                            $errors[] = '<strong>' . Tools::displayError('Zip/ Postal code') . '</strong> ' . Tools::displayError('is required.');
                                        elseif ($postcode AND !preg_match('/^[0-9a-zA-Z -]{4,9}$/ui', $postcode))
                                            $errors[] = '<strong>' . Tools::displayError('Zip/ Postal code') . '</strong> ' . Tools::displayError('is invalid.') . '<br />' . Tools::displayError('Must be typed as follows:') . ' ' . str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $zip_code_format)));
                                    }
                                } //if($id_country>0)
                                $return = array(
                                    'is_ok'  => empty($errors),
                                    'errors' => $errors
                                );
                                die(Tools::jsonEncode($return));
                            }
                            break;
                        default:
                            throw new PrestaShopException('Unknown method "' . Tools::getValue('method') . '"');
                    }
                } else
                    throw new PrestaShopException('Method is not defined');
            }
        } elseif (Tools::isSubmit('ajax'))
            throw new PrestaShopException('Method is not defined');
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function addCssIfExists($path) {
        if (file_exists(_PS_MODULE_DIR_ . 'onepagecheckout/views/css/' . $path )) {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/' . $path );
            return true;
        } else {
            return false;
        }
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function setMedia()
    {
        if (!$this->isOpcModuleActive())
            return parent::setMedia();
        $this->origSetMedia();
        $custom_suffix = ($this->opc_config['use_custom_styling'] > 0)?"-custom":"";
        if ($this->opc_config['use_custom_styling'] == 0)
          $this->addCSS(_THEME_CSS_DIR_ . 'order-opc.css'); // Prestashop's default checkout styling
        $this->addCssIfExists('base'.$custom_suffix.'.css');
        if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/base'.$custom_suffix.'.css'))
            $this->addCssIfExists('themes/'. _THEME_NAME_ . '/base.css');
        if ($this->opc_config['three_column_opc'] > 0) {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/three-column'.$custom_suffix.'.css');
            if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/three-column'.$custom_suffix.'.css'))
                $this->addCssIfExists('themes/'. _THEME_NAME_ . '/three-column.css');
        } elseif ($this->opc_config['two_column_opc'] > 0) {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/two-column'.$custom_suffix.'.css');
            if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/two-column'.$custom_suffix.'.css'))
                $this->addCssIfExists('themes/'. _THEME_NAME_ . '/two-column.css');
        } else {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/single-column'.$custom_suffix.'.css');
            if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/single-column'.$custom_suffix.'.css'))
                $this->addCssIfExists('themes/'. _THEME_NAME_ . '/single-column.css');
        }
        if ($this->opc_config['responsive_layout'] > 0)
            $this->addCssIfExists('responsive.css');
        $this->addJS(_MODULE_DIR_ . 'onepagecheckout/views/js/jquery_cookie.js');
        $this->addJS(_MODULE_DIR_ . 'onepagecheckout/views/js/order-opc.js');
        $this->addJqueryPlugin('scrollTo');
        $this->addJS(_MODULE_DIR_ . 'onepagecheckout/views/js/statesManagement.js');
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function _setInfoBlockContent()
    {
        if (file_exists($this->opc_templates_path . "/info-block-content.tpl")) {
            $info_block_content = $this->context->smarty->fetch($this->opc_templates_path . "/info-block-content.tpl");
        } else {
            $info_block_content = "";
        }
        $this->context->smarty->assign("info_block_content", $info_block_content);
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function initContent()
    {
        $internal_referrer = isset($_SERVER['HTTP_REFERER']) && (strstr($_SERVER['HTTP_REFERER'], Dispatcher::getInstance()->createUrl('order-opc', $this->context->cookie->id_lang)));
        $upsell = @Module::getInstanceByName('upsell');
        if ($upsell && $upsell->active && !(Tools::getValue('skip_offers') == 1 || $internal_referrer)) {
            ParentOrderController::initContent(); // We need this to display the page properly (parent of overriden controller)
            $upsell->getUpsells();
            $this->template = $upsell->setTemplate('upsell-products.tpl');
        } else {
            if (!$this->isOpcModuleActive())
                return parent::initContent();
if ($this->context->cart->id_address_delivery > 0)
    $address_c = new Address($this->context->cart->id_address_delivery);
if ($this->isLogged && is_object($address_c) && $address_c->firstname == 'dummyvalue' && $address_c->lastname == 'dummyvalue') {
    $addresses_c = Customer::getLastTwoCustomerAddressIds( $this->context->customer->id);
    if (count($addresses_c)) {
        $address_new_id = array_shift($addresses_c);
        if ($address_new_id > 0) {
            $this->context->cart->id_address_delivery = $address_new_id;
            $this->context->cart->id_address_invoice = $address_new_id;
            $this->context->cart->update();
        }
    }
}
            $this->origInitContent();
            $this->_assignSummaryInformations();
            $this->_assignWrappingAndTOS();
            $selectedCountry = (int)(Configuration::get('PS_COUNTRY_DEFAULT'));
            if (Configuration::get('PS_RESTRICT_DELIVERED_COUNTRIES'))
                $countries = Carrier::getDeliveredCountries($this->context->language->id, true, true);
            else
                $countries = Country::getCountries($this->context->language->id, true);
            $free_shipping = false;
            foreach ($this->context->cart->getCartRules() as $rule)
                if ($rule['free_shipping'] && !$rule['carrier_restriction'])
                {
                    $free_shipping = true;
                    break;
                }
            $this->context->smarty->assign(array(
                'free_shipping' => $free_shipping,
                'isLogged' => $this->isLogged,
                'isGuest' => isset($this->context->cookie->is_guest) ? $this->context->cookie->is_guest : 0,
                'countries' => $countries,
                'sl_country' => isset($selectedCountry) ? $selectedCountry : 0,
                'PS_GUEST_CHECKOUT_ENABLED' => Configuration::get('PS_GUEST_CHECKOUT_ENABLED'),
                'errorCarrier' => Tools::displayError('You must choose a carrier before', false),
                'errorTOS' => Tools::displayError('You must accept the Terms of Service before', false),
                'isPaymentStep' => (bool)(Tools::getIsset('isPaymentStep') && Tools::getValue('isPaymentStep')),
                'genders' => Gender::getGenders(),
            ));
            
            $this->context->smarty->assign(array(
                'HOOK_CREATE_ACCOUNT_FORM' => Hook::exec('displayCustomerAccountForm'),
                'HOOK_CREATE_ACCOUNT_TOP' => Hook::exec('displayCustomerAccountFormTop')
            ));
            $years = Tools::dateYears();
            $months = Tools::dateMonths();
            $days = Tools::dateDays();
            $this->context->smarty->assign(array(
                'years' => $years,
                'months' => $months,
                'days' => $days,
            ));
            
            if ($this->isLogged)
                $this->context->smarty->assign('guestInformations', $this->_getGuestInformations());
            if ($this->context->cart->id_address_delivery > 0) {
                $def_address = new Address($this->context->cart->id_address_delivery);
                $def_country = $def_address->id_country;
                $def_state = $def_address->id_state;
            } else {
                $def_country = 0;
                $def_state = 0;
            }
            if ($this->context->cart->id_address_invoice > 0) {
                $def_address_invoice = new Address($this->context->cart->id_address_invoice);
                $def_country_invoice = $def_address_invoice->id_country;
                $def_state_invoice = $def_address_invoice->id_state;
            } else {
                $def_country_invoice = 0;
                $def_state_invoice = 0;
            }
            if ($this->context->cart->id_address_delivery > 0 && $this->context->cart->id_address_invoice > 0 &&
                $this->context->cart->id_address_delivery != $this->context->cart->id_address_invoice
            )
                $def_different_billing = 1;
            else
                $def_different_billing = 0;
            $this->context->smarty->assign('def_different_billing', $def_different_billing);
            $this->context->smarty->assign('def_country', $def_country);
            $this->context->smarty->assign('def_state', $def_state);
            $this->context->smarty->assign('def_country_invoice', $def_country_invoice);
            $this->context->smarty->assign('def_state_invoice', $def_state_invoice);
            if ($this->isLogged)
                $this->_assignAddress(); // ADDRESS
            $this->_assignCarrier();
            $this->_assignPayment();
            Tools::safePostVars();
            if (!$this->context->cart->isMultiAddressDelivery())
                $this->context->cart->setNoMultishipping(); // As the cart is no multishipping, set each delivery address lines with the main delivery address
            $summary = $this->context->cart->getSummaryDetails(null, true); // to force refresh on product.id_address_delivery
            $this->_assignSummaryInformations();
            $blocknewsletter = Module::getInstanceByName('blocknewsletter');
            $this->context->smarty->assign('newsletter', (bool)($blocknewsletter && $blocknewsletter->active));
            $this->context->smarty->assign('opc_templates_path', $this->opc_templates_path);
            $this->context->smarty->assign('twoStepCheckout', false); // TODO: hardcoded value!
            $online_country = new Country($this->opc_config['online_country_id']);
            if ($online_country->active)
                $this->context->smarty->assign('onlineCountryActive', true);
            if (Tools::isSubmit('cart-only')) {
                $this->context->smarty->assign('onlyCartSummary', '1');
                $this->context->smarty->assign('order_process_type', Configuration::get('PS_ORDER_PROCESS_TYPE'));
                $this->setTemplate('shopping-cart.tpl');
            } else {
                $this->setTemplate('order-opc.tpl');
            }
        }
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function _getTemplatePath() {
        return $this->opc_templates_path . '/';
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function setTemplate($template)
    {
        if (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/onepagecheckout/'.$template))
            $this->template = _PS_THEME_DIR_.'modules/onepagecheckout/'.$template;
        elseif (Tools::file_exists_cache($this->_getTemplatePath().$template))
            $this->template = $this->_getTemplatePath().$template;
        else
            throw new PrestaShopException("Template '$template'' not found");
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function _getGuestInformations()
    {
        if (!$this->isOpcModuleActive())
            return parent::_getGuestInformations();
        $customer         = $this->context->customer;
        $address_delivery = new Address($this->context->cart->id_address_delivery);
        if ($customer->birthday)
            $birthday = explode('-', $customer->birthday);
        else
            $birthday = array('0', '0', '0');
        $ret = array(
            'use_another_invoice_address' => (bool)((int)$this->context->cart->id_address_invoice != (int)$this->context->cart->id_address_delivery), # opc added
            'id_address_invoice'          => (int)$this->context->cart->id_address_invoice, # opc added
            'id_customer'                 => (int)$customer->id,
            'email'                       => Tools::htmlentitiesUTF8($customer->email),
            'customer_lastname'           => Tools::htmlentitiesUTF8($customer->lastname),
            'customer_firstname'          => Tools::htmlentitiesUTF8($customer->firstname),
            'newsletter'                  => (int)$customer->newsletter,
            'optin'                       => (int)$customer->optin,
            'id_address_delivery'         => (int)$this->context->cart->id_address_delivery,
            'company'                     => Tools::htmlentitiesUTF8($address_delivery->company),
            'lastname'                    => Tools::htmlentitiesUTF8($address_delivery->lastname),
            'firstname'                   => Tools::htmlentitiesUTF8($address_delivery->firstname),
            'vat_number'                  => Tools::htmlentitiesUTF8($address_delivery->vat_number),
            'dni'                         => Tools::htmlentitiesUTF8($address_delivery->dni),
            'address1'                    => Tools::htmlentitiesUTF8($address_delivery->address1),
            'address2'                    => Tools::htmlentitiesUTF8($address_delivery->address2),
            'postcode'                    => Tools::htmlentitiesUTF8($address_delivery->postcode),
            'city'                        => Tools::htmlentitiesUTF8($address_delivery->city),
            'other'                       => Tools::htmlentitiesUTF8($address_delivery->other),
            'phone'                       => Tools::htmlentitiesUTF8($address_delivery->phone),
            'phone_mobile'                => Tools::htmlentitiesUTF8($address_delivery->phone_mobile),
            'alias'                       => Tools::htmlentitiesUTF8($address_delivery->alias),
            'id_country'                  => (int)($address_delivery->id_country),
            'id_state'                    => (int)($address_delivery->id_state),
            'id_gender'                   => (int)$customer->id_gender,
            'sl_year'                     => $birthday[0],
            'sl_month'                    => $birthday[1],
            'sl_day'                      => $birthday[2]
        );
        if ($this->inv_first_on || ((int)$this->context->cart->id_address_invoice != (int)$this->context->cart->id_address_delivery)) {
            $address_invoice   = new Address((int)$this->context->cart->id_address_invoice);
            $customers_address = ((int)($this->context->cookie->id_customer) == $address_invoice->id_customer) ? true : false;
            $invoice           = array(
                'id_country_invoice' => (int)($address_invoice->id_country),
                'id_state_invoice'   => (int)($address_invoice->id_state),
            );
            if (Configuration::get('VATNUMBER_MANAGEMENT') &&
                file_exists(_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php') &&
                !class_exists("VatNumber", false)
            ) {
                include (_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php');
            }
            if (Configuration::get('VATNUMBER_MANAGEMENT') AND
                file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                    VatNumber::isApplicable($address_invoice->id_country) &&
                    Configuration::get('VATNUMBER_COUNTRY') != $address_invoice->id_country
            )
                $allow_eu_vat = 1;
            else
                $allow_eu_vat = 0;
            if ($customers_address) {
                $addr = array(
                    'company_invoice'      => Tools::htmlentitiesUTF8($address_invoice->company),
                    'lastname_invoice'     => Tools::htmlentitiesUTF8($address_invoice->lastname),
                    'firstname_invoice'    => Tools::htmlentitiesUTF8($address_invoice->firstname),
                    'vat_number_invoice'   => Tools::htmlentitiesUTF8($address_invoice->vat_number),
                    'dni_invoice'          => Tools::htmlentitiesUTF8($address_invoice->dni),
                    'address1_invoice'     => Tools::htmlentitiesUTF8($address_invoice->address1),
                    'address2_invoice'     => Tools::htmlentitiesUTF8($address_invoice->address2),
                    'postcode_invoice'     => Tools::htmlentitiesUTF8($address_invoice->postcode),
                    'city_invoice'         => Tools::htmlentitiesUTF8($address_invoice->city),
                    'other_invoice'        => Tools::htmlentitiesUTF8($address_invoice->other),
                    'phone_invoice'        => Tools::htmlentitiesUTF8($address_invoice->phone),
                    'phone_mobile_invoice' => Tools::htmlentitiesUTF8($address_invoice->phone_mobile),
                    'alias_invoice'        => Tools::htmlentitiesUTF8($address_invoice->alias),
                    'allow_eu_vat_invoice' => $allow_eu_vat
                );
            } else {
                $addr = array(
                );
            }
            $invoice = array_merge($invoice, $addr);
            $ret     = array_merge($ret, $invoice);
        }
        return $ret;
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function _assignCarrier()
    {
        if (!$this->isOpcModuleActive())
            return parent::_assignCarrier();
        $carriers = $this->context->cart->simulateCarriersOutput();
        if ($this->isLogged) {
            $address_delivery = new Address((int)($this->context->cart->id_address_delivery));
            if (!Address::isCountryActiveById((int)($this->context->cart->id_address_delivery)))
                unset($address_delivery);
            elseif (!Validate::isLoadedObject($address_delivery) OR $address_delivery->deleted)
                unset($address_delivery);
        }
        $oldMessage = Message::getMessageByCartId((int)($this->context->cart->id));
        $this->context->smarty->assign(array(
            'carriers'               => $carriers,
            'default_carrier'        => (int)(Configuration::get('PS_CARRIER_DEFAULT')),
            'HOOK_EXTRACARRIER'      => Hook::exec('displayCarrierList', array()),
            'HOOK_EXTRACARRIER_ADDR' => null,
            'oldMessage' => isset($oldMessage['message'])? $oldMessage['message'] : '',
            'HOOK_BEFORECARRIER'     => Hook::exec('displayBeforeCarrier', array(
                'carriers'             => $carriers,
                'checked'              => $this->context->cart->simulateCarrierSelectedOutput(),
                'delivery_option_list' => $this->context->cart->getDeliveryOptionList(),
                'delivery_option'      => $this->context->cart->getDeliveryOption(null, true)
            ))
        ));
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function _assignPayment()
    {
        if (!$this->isOpcModuleActive())
            return parent::_assignPayment();
        $this->context->smarty->assign(array(
            'HOOK_TOP_PAYMENT' => ($this->isLogged ? Hook::exec('displayPaymentTop') : ''),
            'HOOK_PAYMENT'     => $this->_getPaymentMethods()
        ));
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private $payment_mod_id = 0;
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function _genPaymentModId($matches)
    {
        return $matches[1] . ' id="opc_pid_' . $this->payment_mod_id++ . '"' . $matches[3];
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function _getPaymentMethods()
    {
        if (!$this->isOpcModuleActive())
            return parent::_getPaymentMethods();
        if ($this->context->cart->OrderExists()) {
            $ret = '<p class="warning">' . Tools::displayError('Error: this order has already been validated') . '</p>';
            return array("orig_hook" => $ret, "parsed_content" => $ret);
        }
        $ret              = "";
        $address_delivery = new Address($this->context->cart->id_address_delivery);
        $address_invoice  = ($this->context->cart->id_address_delivery == $this->context->cart->id_address_invoice ? $address_delivery : new Address($this->context->cart->id_address_invoice));
        if (!$this->context->cart->id_address_delivery || !$this->context->cart->id_address_invoice || !Validate::isLoadedObject($address_delivery) || !Validate::isLoadedObject($address_invoice) || $address_invoice->deleted || $address_delivery->deleted)
            $ret = '<p class="warning">' . Tools::displayError('Error: please choose an address') . '</p>';
        if (count($this->context->cart->getDeliveryOptionList()) == 0 && !$this->context->cart->isVirtualCart()) {
            if ($this->context->cart->isMultiAddressDelivery())
                $ret .= '<p class="warning">' . Tools::displayError('Error: There are no carriers available that deliver to some of your addresses') . '</p>';
            else
                $ret .= '<p class="warning">' . Tools::displayError('Error: There are no carriers available that deliver to this address') . '</p>';
        }
        if (!$this->context->cart->getDeliveryOption(null, false) && !$this->context->cart->isVirtualCart())
            $ret = '<p class="warning">' . Tools::displayError('Error: please choose a carrier') . '</p>';
        if (!$this->context->cart->id_currency)
            $ret .= '<p class="warning">' . Tools::displayError('Error: no currency has been selected') . '</p>';
        
        if (!$this->context->cart->checkQuantities())
            $ret .= '<p class="warning">' . Tools::displayError('An item in your cart is no longer available, you cannot proceed with your order.') . '</p>';
        
        $currency = Currency::getCurrency((int)$this->context->cart->id_currency);
        $minimalPurchase = Tools::convertPrice((float)Configuration::get('PS_PURCHASE_MINIMUM'), $currency);
        if ($this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS) < $minimalPurchase)
            $ret .= '<p class="warning">' . sprintf(
                Tools::displayError('A minimum purchase total of %s is required in order to validate your order.'),
                Tools::displayPrice($minimalPurchase, $currency)
            ) . '</p>';
        
        if (trim($ret) != "") {
            return array("orig_hook" => $ret, "parsed_content" => $ret);
        }
        $opc_config        = $this->context->smarty->tpl_vars["opc_config"]->value;
        $tmp_customer_id_1 = (isset($opc_config) && isset($opc_config["payment_customer_id"])) ? (int)$opc_config["payment_customer_id"] : 0;
        $reset_id_customer = false;
        if (!$this->context->cookie->id_customer) {
            $simulated_customer_id              = ($tmp_customer_id_1 > 0) ? $tmp_customer_id_1 : Customer::getFirstCustomerId();
            $this->context->cookie->id_customer = $simulated_customer_id;
            $reset_id_customer                  = true;
            if (!$this->context->customer->id) {
                $this->context->customer->id = $simulated_customer_id;
            }
        }
        $orig_context_country = $this->context->country;
        if (isset($address_invoice) && $address_invoice != null)
            $this->context->country = new Country($address_invoice->id_country);
        
        if ($this->context->cart->getOrderTotal() <= 0) {
            $return = $this->context->smarty->fetch($this->opc_templates_path . '/free-order-payment.tpl');
        } else {
            $ship2pay_support = (isset($opc_config) && isset($opc_config["ship2pay"]) && $opc_config["ship2pay"] == "1") ? true : false;
            if ($ship2pay_support) {
                $orig_id_carrier = $this->context->cart->id_carrier;
                $selected_carrier = Cart::desintifier($this->context->cart->simulateCarrierSelectedOutput());
                $selected_carrier = explode(",", $selected_carrier);
                $selected_carrier = $selected_carrier[0];
                $this->context->cart->id_carrier = $selected_carrier;
                $this->context->cart->update();
                $return = Hook::exec('displayPayment');
            } else
                $return = Hook::exec('displayPayment');
        }
        $this->context->country = $orig_context_country;
        # restore cookie's id_customer
        if ($reset_id_customer) {
            unset($this->context->cookie->id_customer);
            $this->context->customer->id        = null;
        }
        # fix Moneybookers relative path to images
        $return = preg_replace('|src="modules\/|', 'src="' . __PS_BASE_URI__ . 'modules/', $return);
        # OPCKT fix Paypal relative path to redirect script
        $return = preg_replace('|href="modules\/|', 'href="' . __PS_BASE_URI__ . 'modules/', $return);
        if (!$return) {
            $ret = '<p class="warning">' . Tools::displayError('No payment method is available') . '</p>';
            return array("orig_hook" => $ret, "parsed_content" => $ret);
        }
        $parsed_content        = "";
        $parse_payment_methods = (isset($opc_config) && isset($opc_config["payment_radio_buttons"]) && $opc_config["payment_radio_buttons"] == "1") ? true : false;
        if ($parse_payment_methods) {
            $content = $return;
            $payment_methods = array();
            $i               = 0;
            $tmp_return = preg_replace('/(<a[^>]*?)(?:class="[^>]*?")([^>]*?>(?:(?!<\/a>).)*?<img(?:(?!<\/a>).)*?<\/a>)/msi', "\\1 \\2", $content);
            if ($tmp_return != null) // NULL can be returned on backtrace limit exhaustion
            {
                $return = $tmp_return;
                $content = $return;
            }
            preg_match_all('/<a.*?>(?:(?!<\/a>).)*?<img[^>]*?src="(.*?)".*?\/?>((?:(?!<\/a>).)*?)<\/a>/ms', $content, $matches1, PREG_SET_ORDER);
            $tmp_return = preg_replace_callback('/(<(a))([^>]*?>(?:(?!<\/a>).)*?<img(?:(?!<\/a>).)*?<\/a>)/ms', array($this, "_genPaymentModId"), $return);
            if ($tmp_return == NULL) echo "ERRoR!";
            if ($tmp_return != null) // NULL can be returned on backtrace limit exhaustion
                $return = $tmp_return;
            preg_match_all('/<input [^>]*?type="image".*?src="(.*?)".*?>.*?<span.*?>(.*?)<\/span>/ms', $content, $matches2, PREG_SET_ORDER);
            $tmp_return = preg_replace_callback('/(<(input)[^>]*?type="image")(.*?<span.)/ms', array($this, "_genPaymentModId"), $return);
            if ($tmp_return != null)
                $return = $tmp_return;
            preg_match_all('/<a[^>]*?class="(.*?)".*?>(.*?)<\/a>/ms', $content, $matches3, PREG_SET_ORDER);
            $tmp_return = preg_replace_callback('/(<a[^>]*?class="(.*?)")([^>]*?>)/ms', array($this, "_genPaymentModId"), $return);
            if ($tmp_return != null)
                $return = $tmp_return;
            for ($k=0; $k<count($matches3);$k++) {
                $matches3[$k][3] =  $matches3[$k][1]; // IMG class of original module
                $matches3[$k][1] =  preg_replace('|.*?themes\/|', 'themes/',_THEME_IMG_DIR_).$matches3[$k][1].".png";
            }
            $matches = array_merge($matches1, $matches2, $matches3);
            foreach ($matches as $match) {
                $payment_methods[$i]['img']  = preg_replace('/(\r)?\n/m', " ", trim($match[1]));
                $payment_methods[$i]['desc'] = preg_replace('/\s/m', " ", trim($match[2])); // fixed for Auriga payment
                $payment_methods[$i]['link'] = "opc_pid_$i";
                if (isset($match[3])) { $payment_methods[$i]['class'] = trim($match[3]); }
                $i++;
            }
            $this->context->smarty->assign("payment_methods", $payment_methods);
            $parsed_content = $this->context->smarty->fetch($this->opc_templates_path . "/payment-methods.tpl");
            $parsed_content = str_replace("&amp;", "&", $parsed_content);
        }
        return array("orig_hook" => $return, "parsed_content" => $parsed_content);
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function _getCarrierList()
    {
        if (!$this->isOpcModuleActive())
            return parent::_getCarrierList();
        $address_delivery = new Address($this->context->cart->id_address_delivery);
        $cms             = new CMS(Configuration::get('PS_CONDITIONS_CMS_ID'), $this->context->language->id);
        $link_conditions = $this->context->link->getCMSLink($cms, $cms->link_rewrite, true);
        if (!strpos($link_conditions, '?'))
            $link_conditions .= '?content_only=1';
        else
            $link_conditions .= '&content_only=1';
        $free_shipping = false;
        foreach ($this->context->cart->getCartRules() as $rule)
            if ($rule['free_shipping'] && !$rule['carrier_restriction'])
            {
                $free_shipping = true;
                break;
            }
        $carriers              = $this->context->cart->simulateCarriersOutput();
        $delivery_option       = $this->context->cart->getDeliveryOption(null, false, false);
        $wrapping_fees_tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
        if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0) {
            $wrapping_fees = (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE'));
            $wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float)($wrapping_fees_tax->rate) / 100)));
        } else {
            $wrapping_fees = $this->context->cart->getGiftWrappingPrice(false);
            $wrapping_fees_tax_inc = $wrapping_fees = $this->context->cart->getGiftWrappingPrice();
        }
        $oldMessage = Message::getMessageByCartId((int)($this->context->cart->id));
        $vars                  = array(
            'free_shipping'               => $free_shipping,
            'checkedTOS'                  => (int)($this->context->cookie->checkedTOS),
            'recyclablePackAllowed'       => (int)(Configuration::get('PS_RECYCLABLE_PACK')),
            'giftAllowed'                 => (int)(Configuration::get('PS_GIFT_WRAPPING')),
            'cms_id'                      => (int)(Configuration::get('PS_CONDITIONS_CMS_ID')),
            'conditions'                  => (int)(Configuration::get('PS_CONDITIONS')),
            'link_conditions'             => $link_conditions,
            'recyclable'                  => (int)($this->context->cart->recyclable),
            'gift_wrapping_price'         => (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE')),
            'total_wrapping_cost'         => Tools::convertPrice($wrapping_fees_tax_inc, $this->context->currency),
            'total_wrapping_tax_exc_cost' => Tools::convertPrice($wrapping_fees, $this->context->currency),
            'delivery_option_list'        => $this->context->cart->getDeliveryOptionList(),
            'carriers'                    => $carriers,
            'checked'                     => $this->context->cart->simulateCarrierSelectedOutput(),
            'delivery_option'             => $delivery_option,
            'address_collection'          => $this->context->cart->getAddressCollection(),
            'opc'                         => true,
            'oldMessage'                  => isset($oldMessage['message'])? $oldMessage['message'] : '',
            'HOOK_BEFORECARRIER'          => Hook::exec('displayBeforeCarrier', array(
                'carriers'             => $carriers,
                'delivery_option_list' => $this->context->cart->getDeliveryOptionList(),
                'delivery_option'      => $delivery_option
            ))
        );
        Cart::addExtraCarriers($vars);
        $this->context->smarty->assign($vars);
        $order_carrier_tpl = ($this->default_ps_carriers)?'/order-carrier-def.tpl':'/order-carrier.tpl';
        if (!Address::isCountryActiveById((int)($this->context->cart->id_address_delivery)) && $this->context->cart->id_address_delivery != 0)
            $this->errors[] = Tools::displayError('This address is not in a valid area.');
        elseif ((!Validate::isLoadedObject($address_delivery) || $address_delivery->deleted) && $this->context->cart->id_address_delivery != 0)
            $this->errors[] = Tools::displayError('This address is invalid.');
        else {
            $result = array(
                'HOOK_BEFORECARRIER' => Hook::exec('displayBeforeCarrier', array(
                    'carriers'             => $carriers,
                    'delivery_option_list' => $this->context->cart->getDeliveryOptionList(),
                    'delivery_option'      => $this->context->cart->getDeliveryOption(null, true)
                )),
                'carrier_block'      => $this->context->smarty->fetch($this->opc_templates_path . $order_carrier_tpl)
            );
            Cart::addExtraCarriers($result);
            return $result;
        }
        if (count($this->errors))
            return array(
                'hasError'      => true,
                'errors'        => $this->errors,
                'carrier_block' => $this->context->smarty->fetch($this->opc_templates_path . $order_carrier_tpl)
            );
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function _processAddressFormat()
    {
        if (!$this->isOpcModuleActive())
            return parent::_processAddressFormat();
        $selectedCountry = (int)(Configuration::get('PS_COUNTRY_DEFAULT'));
        $address_delivery = new Address((int)$this->context->cart->id_address_delivery);
        $address_invoice  = new Address((int)$this->context->cart->id_address_invoice);
        $inv_adr_fields = AddressFormat::getOrderedAddressFields((int)$address_delivery->id_country, false, true);
        $dlv_adr_fields = AddressFormat::getOrderedAddressFields((int)$address_invoice->id_country, false, true);
        $inv_all_fields = array();
        $dlv_all_fields = array();
        foreach (array('inv', 'dlv') as $adr_type) {
            foreach (${$adr_type . '_adr_fields'} as $fields_line)
                foreach (explode(' ', $fields_line) as $field_item)
                    ${$adr_type . '_all_fields'}[] = trim($field_item);
            $this->context->smarty->assign($adr_type . '_adr_fields', ${$adr_type . '_adr_fields'});
            $this->context->smarty->assign($adr_type . '_all_fields', ${$adr_type . '_all_fields'});
        }
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function getFormatedSummaryDetail()
    {
        $result               = array('summary'         => $this->context->cart->getSummaryDetails(),
                                      'customizedDatas' => Product::getAllCustomizedDatas($this->context->cart->id, null, true)
        );
        $cart_product_context = Context::getContext()->cloneContext();
        foreach ($result['summary']['products'] as $key => &$product) {
            $product['quantity_without_customization'] = $product['quantity'];
            $product['quantity']                       = $product['cart_quantity']; // for compatibility with 1.2 themes
            if ($cart_product_context->shop->id != $product['id_shop'])
                $cart_product_context->shop = new Shop((int)$product['id_shop']);
            $product['price_without_specific_price'] = Product::getPriceStatic($product['id_product'],
                !Product::getTaxCalculationMethod(),
                $product['id_product_attribute'],
                2, null, false, false, 1, false, null, null, null, $null, true, true, $cart_product_context);
            if (Product::getTaxCalculationMethod())
                $product['is_discounted'] = $product['price_without_specific_price'] != $product['price'];
            else
                $product['is_discounted'] = $product['price_without_specific_price'] != $product['price_wt'];
            $product['price_without_quantity_discount'] = $product['price_without_specific_price'];
            if ($result['customizedDatas']) {
                if (isset($result['customizedDatas'][(int)$product['id_product']]))
                    foreach ($result['customizedDatas'][(int)$product['id_product']][(int)$product['id_product_attribute']] as $addresses)
                        foreach ($addresses as $customization)
                            $product['quantity_without_customization'] -= (int)$customization['quantity'];
            }
        }
        if ($result['customizedDatas'])
            Product::addCustomizationPrice($result['summary']['products'], $result['customizedDatas']);
        return $result;
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function _hookExecPaymentShip2pay($carrier)
    {
        $sql    = 'SELECT * FROM `' . _DB_PREFIX_ . 'shiptopay`';
        $result = Db::getInstance()->ExecuteS($sql);
        if (count($result) == 0) {
            return Module::hookExecPayment();
        } else {
            $hookArgs = array('cookie' => $this->context->cookie, 'cart' => $this->context->cart);
            $billing  = new Address((int)$this->context->cart->id_address_invoice);
            $output   = '';
            $sql      = '
    		SELECT distinct(stp.id_carrier),h.`id_hook`, m.`name`, hm.`position`
    		FROM `' . _DB_PREFIX_ . 'module_country` mc
    		LEFT JOIN `' . _DB_PREFIX_ . 'module` m ON m.`id_module` = mc.`id_module`
    		LEFT JOIN `' . _DB_PREFIX_ . 'hook_module` hm ON hm.`id_module` = m.`id_module`
    		LEFT JOIN `' . _DB_PREFIX_ . 'hook` h ON hm.`id_hook` = h.`id_hook`
    		LEFT JOIN `' . _DB_PREFIX_ . 'shiptopay` stp ON hm.`id_module` = stp.`id_payment`
    		WHERE h.`name` = \'displayPayment\'
    		AND stp.id_carrier=' . (int)$carrier . '
    		AND mc.id_country = ' . (int)$billing->id_country . '
    		AND m.`active` = 1
    		ORDER BY hm.`position`, m.`name` DESC';
            $result = Db::getInstance()->ExecuteS($sql);
            if ($result)
                foreach ($result AS $k => $module)
                    if (($moduleInstance = Module::getInstanceByName($module['name'])) AND is_callable(array($moduleInstance, 'hookpayment'))) {
                        $paymentCurrencies = Currency::checkPaymentCurrencies($moduleInstance->id);
                        $actualCurrencies = array();
                        foreach ($paymentCurrencies as $curr)
                            $actualCurrencies[] = $curr['id_currency'];
                        if (!$moduleInstance->currencies OR ($moduleInstance->currencies AND sizeof($paymentCurrencies) AND in_array((int)$this->context->currency->id, $actualCurrencies)))
                            $output .= call_user_func(array($moduleInstance, 'hookpayment'), $hookArgs);
                    }
            return $output;
        }
    }
}
