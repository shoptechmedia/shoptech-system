<?php

class AddressController extends AddressControllerCore
{
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
    public function init()
    {
        if (Tools::isSubmit('partialSubmitAddress'))
            $this->auth = 0;
        parent::init();
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private function saveAddress($cart_id_address, $id_country, $id_state, $postcode, $city, $firstname, $lastname, $address1)
    {
        $dummy = "dummyvalue";
        if ($cart_id_address > 0) { // update existing one
            
            $tmp_addr          = new Address($cart_id_address);
            $tmp_addr->deleted = 0;
        } else { // create a new address 
            $tmp_addr            = new Address();
            $tmp_addr->alias     = "My Address";
            $tmp_addr->lastname  = $dummy;
            $tmp_addr->firstname = $dummy;
            $tmp_addr->address1  = $dummy;
            $tmp_addr->postcode  = $postcode;
            $tmp_addr->city      = $dummy;
        }
        if (trim($postcode) != "")
            $tmp_addr->postcode = $postcode;
        if (trim($city) != "")
            $tmp_addr->city = $city;
        if (trim($firstname) != "")
            $tmp_addr->firstname = $firstname;
        if (trim($lastname) != "")
            $tmp_addr->lastname = $lastname;
        if (trim($address1) != "")
            $tmp_addr->address1 = $address1;
        if (trim($id_country) == "")
            $id_country = (int)(Configuration::get('PS_COUNTRY_DEFAULT'));
        if (trim($id_country) != "") {
            $tmp_addr->id_country = $id_country;
            if (trim($id_state) != "")
                $tmp_addr->id_state = $id_state;
            else
                $tmp_addr->id_state = 0;
            if (Configuration::get('VATNUMBER_MANAGEMENT') AND
                file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                    !VatNumber::isApplicable($id_country)
            )
                $tmp_addr->vat_number = "";
            if ($cart_id_address > 0) {
                $tmp_addr->update();
            } else {
                $tmp_addr->add();
            }
            return $tmp_addr->id;
        } else
            return 0;
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function postProcess()
    {
        if (!$this->isOpcModuleActive())
            return parent::postProcess();
        $inv_first_on = (Configuration::get('OPC_INVOICE_FIRST') == "1");
        if (Tools::isSubmit('submitAddress') && Tools::isSubmit('ajax')) {
            if (Tools::isSubmit('type')) {
                if (Tools::getValue('type') == 'delivery') {
                    if (!$inv_first_on)
                        $id_address = isset($this->context->cart->id_address_delivery) ? (int)$this->context->cart->id_address_delivery : 0;
                    else
                        $id_address = (Tools::isSubmit('id_address') AND (int)Tools::getValue('id_address', 0) != $this->context->cart->id_address_invoice) ? (int)Tools::getValue('id_address', 0) : 0;
                }
                elseif (Tools::getValue('type') == 'invoice') {
                    if (!$inv_first_on)
                        $id_address = (Tools::isSubmit('id_address') AND (int)Tools::getValue('id_address', 0) != $this->context->cart->id_address_delivery) ? (int)Tools::getValue('id_address', 0) : 0;
                    else
                        $id_address = isset($this->context->cart->id_address_invoice) ? (int)$this->context->cart->id_address_invoice : 0;
                }
                else
                    exit;
            } else
                $id_address = (int)Tools::getValue('id_address', 0);
            if (Tools::getValue('alias') == Tools::getValue('default_alias') && Tools::getValue('address1') && trim(Tools::getValue('address1')) != "")
                $_POST['alias'] = Tools::substr(preg_replace('/[;#]/', '_', Tools::getValue('address1')),0,32);
            $address      = new Address();
            $this->errors = $address->validateController();
            if (Tools::getValue('type') == 'invoice' && isset($id_address) && $id_address > 0) {
                $this->context->cart->id_address_invoice = $id_address;
                $this->context->cart->update();
            }
            $address_old = new Address((int)$id_address);
            if (!sizeof($this->errors) && isset($id_address) && (int)$id_address > 0 && Validate::isLoadedObject($address_old) AND Customer::customerHasAddress((int)$this->context->cookie->id_customer, (int)$address_old->id)) {
                if ($address_old->isUsed() && $address_old->isDifferent($address)) {
                    $address_1              = new Address();
                    $_POST['alias']         = Tools::substr(preg_replace('/[;#]/', '_', Tools::getValue('address1')),0,32);
                    $this->errors           = $address_1->validateController();
                    $address_1->id_customer = (int)($this->context->cookie->id_customer);
                    if ((!Tools::getValue('phone') AND !Tools::getValue('phone_mobile')) ||
                        (!($country = new Country((int)$address_1->id_country)) OR !Validate::isLoadedObject($country)) ||
                        ($country->isNeedDni() AND (!Tools::getValue('dni') OR !Validate::isDniLite(Tools::getValue('dni')))) ||
                        ((int)($country->contains_states) AND !(int)($address_1->id_state))
                    ) { 
                    } elseif ($address_1->save()) {
                        $id_address = $address_1->id;
                        if (Tools::getValue('type') == 'delivery') {
                            if ($this->context->cart->id_address_delivery == $this->context->cart->id_address_invoice)
                                $this->context->cart->id_address_invoice = (int)($address_1->id);
                            $this->context->cart->id_address_delivery = (int)($address_1->id);
                            $this->context->cart->update();
                        }
                        if (Tools::getValue('type') == 'invoice') {
                            if ($this->context->cart->id_address_delivery == $this->context->cart->id_address_invoice)
                                $this->context->cart->id_address_delivery = (int)($address_1->id);
                            $this->context->cart->id_address_invoice = (int)($address_1->id);
                            $this->context->cart->update();
                        }
                    }
                }
            }
            $this->_processSubmitAddress($id_address, Tools::getValue('type'));
        } elseif (Tools::isSubmit('partialSubmitAddress')) { // called separately for delivery country/state change and invoice country/state change
            $is_separate_invoice_address = Tools::getValue('invoice_address');
            $is_separate_delivery_address = Tools::getValue('delivery_address');
            $type = Tools::getValue('type');
            $id_country = Tools::getValue('id_country');
            $id_state   = Tools::getValue('id_state');
            $postcode   = Tools::getValue('postcode');
            $city   = Tools::getValue('city');
            $firstname   = Tools::getValue('firstname');
            $lastname   = Tools::getValue('lastname');
            $addr1   = Tools::getValue('address1');
            $id_address_delivery      = 0;
            $id_address_invoice       = 0;
            $create_different_delivery_address = 0;
            $create_different_invoice_address = 0;
            $last_addr_id      = 0;
            $last_addr_ids_tmp = Customer::getLastTwoCustomerAddressIds($this->context->cart->id_customer);
            if ($id_country !== false && $id_state !== false) {
                
                if ($type == 'delivery' && isset($this->context->cart->id_address_delivery) && $this->context->cart->id_address_delivery > 0) {
                    $address_old1 = new Address((int)$this->context->cart->id_address_delivery);
                    $address1     = new Address();
                    $errors1      = $address1->validateController();
                    if (Validate::isLoadedObject($address_old1) && $address_old1->isUsed() && $address_old1->isDifferent($address1, true))
                        $create_different_delivery_address = 1;
                }
                if ($is_separate_invoice_address) {
                    if ($this->context->cart->id_address_delivery == $this->context->cart->id_address_invoice)
                        $create_different_invoice_address = 1;
                    if (isset($last_addr_ids_tmp) && $last_addr_ids_tmp != false && is_array($last_addr_ids_tmp) && count($last_addr_ids_tmp) > 0) {
                        foreach ($last_addr_ids_tmp as $item) {
                            if ($item != $this->context->cart->id_address_delivery) {
                                $last_addr_id = $item;
                                break;
                            }
                        }
                    }
                }
                if ($is_separate_delivery_address) {
                    if ($this->context->cart->id_address_delivery == $this->context->cart->id_address_invoice)
                        $create_different_delivery_address = 1;
                    if (isset($last_addr_ids_tmp) && $last_addr_ids_tmp != false && is_array($last_addr_ids_tmp) && count($last_addr_ids_tmp) > 0) {
                        foreach ($last_addr_ids_tmp as $item) {
                            if ($item != $this->context->cart->id_address_invoice) {
                                $last_addr_id = $item;
                                break;
                            }
                        }
                    }
                }
                if ($type == 'delivery')
                    $id_address_delivery = ($last_addr_id > 0 && $create_different_delivery_address) ? $last_addr_id : $this->saveAddress(($create_different_delivery_address) ? $last_addr_id : $this->context->cart->id_address_delivery, $id_country, $id_state, $postcode, $city, $firstname, $lastname, $addr1);
                else
                    $id_address_invoice =  ($last_addr_id > 0 && $create_different_invoice_address)  ? $last_addr_id : $this->saveAddress(($create_different_invoice_address)  ? $last_addr_id : $this->context->cart->id_address_invoice,  $id_country, $id_state, $postcode, $city, $firstname, $lastname, $addr1);
            }
            if ($id_address_delivery > 0) {
                $this->context->cart->id_address_delivery = $id_address_delivery;
                if ($is_separate_invoice_address == 0 && $is_separate_delivery_address == 0) {
                    $this->context->cart->id_address_invoice = $this->context->cart->id_address_delivery;
                }
            } elseif ($id_address_invoice > 0) {
                $this->context->cart->id_address_invoice = $id_address_invoice;
                if ($is_separate_invoice_address == 0 && $is_separate_delivery_address == 0) {
                    $this->context->cart->id_address_delivery = $this->context->cart->id_address_invoice;
                }
            }
            $this->context->cart->update();
            if (Configuration::get('VATNUMBER_MANAGEMENT') AND
                file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                    VatNumber::isApplicable($id_country) &&
                    Configuration::get('VATNUMBER_COUNTRY') != $id_country
            )
                $allow_eu_vat = 1;
            else
                $allow_eu_vat = 0;
            if (Tools::isSubmit('ajax')) {
                $return = array(
                    'hasError'            => !empty($this->errors),
                    'errors'              => $this->errors,
                    'id_address_delivery' => $this->context->cart->id_address_delivery,
                    'id_address_invoice'  => $this->context->cart->id_address_invoice,
                    'allow_eu_vat'        => $allow_eu_vat
                );
                die(Tools::jsonEncode($return));
            }
        } else {
            # assign pre-guessed address to this customer
            if (Tools::getValue('type') == 'invoice' &&
                (isset($this->context->cart->id_address_invoice) AND $this->context->cart->id_address_invoice != $this->context->cart->id_address_delivery) &&
                isset($this->context->cookie->id_customer) AND (int)$this->context->cookie->id_customer > 0
            ) {
                $address_a              = new Address($this->context->cart->id_address_invoice);
                $address_a->id_customer = (int)$this->context->cookie->id_customer;
                $address_a->save();
            }
            # then call original postProcess to make standard validations and save to DB
            parent::postProcess();
        }
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    protected function _processSubmitAddress($id_address, $type) // type is 'delivery' or 'invoice'
    {
        
        if (isset($id_address) && $id_address > 0)
            $address = new Address($id_address);
        else
            $address = new Address();
        $this->errors = $address->validateController();
        $fields_to_check = array("address2", "company", "vat_number", "phone", "phone_mobile", "other");
        foreach ($fields_to_check as $field1)
            if (Tools::getValue($field1) && trim(Tools::getValue($field1)) == "")
                $address->{$field1} = "";
        if (empty($this->errors)) // So that dummyvalue address doesn't get customer id assigned
            $address->id_customer = (int)$this->context->customer->id;
        if ($this->context->customer->isLogged() && !$this->isTokenValid())
            $this->errors[] = Tools::displayError('Invalid token');
        if (Configuration::get('PS_ONE_PHONE_AT_LEAST') && !Tools::getValue('phone') && !Tools::getValue('phone_mobile') && !Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && $type=='delivery')
            $this->errors[] = Tools::displayError('You must register at least one phone number');
        if ($address->id_country) {
            if (!($country = new Country($address->id_country)) || !Validate::isLoadedObject($country))
                throw new PrestaShopException('Country cannot be loaded with address->id_country');
            if ((int)$country->contains_states && !(int)$address->id_state)
                $this->errors[] = Tools::displayError('This country requires a state selection.');
            if (version_compare(_PS_VERSION_, "1.6.0") < 0 && $address->id_country == Country::getByIso('US')) {
                include_once(_PS_TAASC_PATH_ . 'AddressStandardizationSolution.php');
                $normalize         = new AddressStandardizationSolution;
                $address->address1 = $normalize->AddressLineStandardization($address->address1);
                $address->address2 = $normalize->AddressLineStandardization($address->address2);
            }
            $zip_code_format = $country->zip_code_format;
            if ($country->need_zip_code) {
                if (($postcode = trim(Tools::getValue('postcode'))) && $zip_code_format) {
                    if (!$country->checkZipCode($postcode))
                        $this->errors[] = sprintf(
                            Tools::displayError('Zip/Postal code is invalid. Must be typed as follows: %s'),
                            str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $country->zip_code_format)))
                        );
                } else if ($zip_code_format && !$this->context->cart->isVirtualCart())
                    $this->errors[] = Tools::displayError('Zip/Postal code is required.');
                else if ($postcode && !preg_match('/^[0-9a-zA-Z -]{4,9}$/ui', $postcode))
                    $this->errors[] = sprintf(
                        Tools::displayError('Zip/Postal code is invalid. Must be typed as follows: %s'),
                        str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $country->zip_code_format)))
                    );
            }
            
        }
        if (isset($id_address) && $id_address > 0)
            $alias_id_address = $id_address;
        else
            $alias_id_address = (int)Tools::getValue('id_address');
        if (!$this->context->customer->is_guest && Tools::getValue('alias')
            && (int)$this->context->customer->id > 0
            && Db::getInstance()->getValue('
				SELECT count(*)
				FROM ' . _DB_PREFIX_ . 'address
				WHERE `alias` = \'' . pSql(Tools::getValue('alias')) . '\'
				AND id_address != ' . $alias_id_address . '
				AND id_customer = ' . (int)$this->context->customer->id . '
				AND deleted = 0') > 0
        )
            $address->alias .= '_' . $alias_id_address;
        $this->errors = array_merge($this->errors, $address->validateFieldsRequiredDatabase());
        if ($this->errors) {
            if ($this->ajax) {
                $return = array(
                    'hasError'            => (bool)$this->errors,
                    'errors'              => $this->errors,
                    'id_address_delivery' => $this->context->cart->id_address_delivery,
                    'id_address_invoice'  => $this->context->cart->id_address_invoice
                );
                die(Tools::jsonEncode($return));
            } else {
                return;
            }
        }
        
        $this->context->cart->setNoMultishipping(); // As the cart is no multishipping, set each delivery address lines with the main delivery address
        $address->alias = preg_replace('/[!<>?=+@{}_$%]/', '', $address->alias);
        if ($address->save()) {
                $this->context->cart->autosetProductAddress();
            if ($this->ajax) {
                $return = array(
                    'hasError'            => (bool)$this->errors,
                    'errors'              => $this->errors,
                    'id_address_delivery' => $this->context->cart->id_address_delivery,
                    'id_address_invoice'  => $this->context->cart->id_address_invoice
                );
                die(Tools::jsonEncode($return));
            }
            if ($back = Tools::getValue('back')) {
                $mod = Tools::getValue('mod');
                Tools::redirect('index.php?controller=' . $back . ($mod ? '&back=' . $mod : ''));
            } else
                Tools::redirect('index.php?controller=addresses');
        }
        $this->errors[] = Tools::displayError('An error occurred while updating your address.');
    }
}
