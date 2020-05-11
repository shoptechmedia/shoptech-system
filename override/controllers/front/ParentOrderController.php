<?php

class ParentOrderController extends ParentOrderControllerCore
{
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private $opc_enabled = false;
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function origInit()
    {
        parent::init();
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function origInitContent()
    {
        parent::initContent();
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function origSetMedia()
    {
        parent::setMedia();
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
    protected function _processCarrier()
    {
        if (!$this->isOpcModuleActive())
            return parent::_processCarrier();
        $reset = false;
        if (!$this->context->customer->id)
            $reset = true;
        if ($reset)
            $this->context->customer->id = 1; // hocijaka nenulova hodnota na osalenie _processCarrier v parentovi
        $_POST['delivery_option'][$this->context->cart->id_address_delivery] = Cart::desintifier(Tools::getValue("id_carrier"));
        $this->context->cart->id_carrier                                     = Cart::desintifier(Tools::getValue("id_carrier"), '');
        $result                                                              = parent::_processCarrier();
        if ($reset)
            $this->context->customer->id = null;
        return $result;
    }
}
