<?php

class Customer extends CustomerCore
{
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    private static function isOpcModuleActive()
    {
        $opc_mod_script = _PS_MODULE_DIR_ . 'onepagecheckout/onepagecheckout.php';
        if (file_exists($opc_mod_script)) {
            require_once($opc_mod_script);
            $opc_mod = new OnePageCheckout();
            return $opc_mod->active;
        } else {
            return 0;
        }
    }
    static /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function customerExists($email, $return_id = false, $ignoreGuest = true)
    {
        if (!self::isOpcModuleActive())
            return parent::customerExists($email, $return_id, $ignoreGuest);
        if (!Validate::isEmail($email))
            die (Tools::displayError());
        if (Tools::isSubmit('submitAccount')) {
            return false;
        } else {
            return parent::customerExists($email, $return_id, $ignoreGuest);
        }
    }
    static /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function getLastTwoCustomerAddressIds($id_customer, $active = true)
    {
        if ($id_customer == 0)
            return 0;
        $query = '
                        SELECT `id_address`
                        FROM `' . _DB_PREFIX_ . 'address`
                        WHERE `id_customer` = ' . (int)($id_customer) . ' AND `deleted` = 0' . ($active ? ' AND `active` = 1' : '') .
            ' ORDER BY id_address DESC limit 2';
        $result = Db::getInstance()->ExecuteS($query);
        $ret    = array();
        foreach ($result AS $k => $address) {
            $ret[] = ($address["id_address"]);
        }
        return $ret;
    }
    static /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public function getFirstCustomerId($active = true)
    {
        $query = '
                        SELECT `id_customer`
                        FROM `' . _DB_PREFIX_ . 'customer`
                        WHERE `deleted` = 0' . ($active ? ' AND `active` = 1' : '') .
            ' ORDER BY id_customer ASC';
        $x = Db::getInstance()->getValue($query);
        return $x;
    }
    /*
    * module: onepagecheckout
    * date: 2017-10-10 09:35:11
    * version: 2.3.6
    */
    public static function customerHasAddress($id_customer, $id_address)
    {
        if (!self::isOpcModuleActive())
            return parent::customerHasAddress($id_customer, $id_address);
        if (!Tools::isSubmit('delete'))
            return true;
        else
            return parent::customerHasAddress($id_customer, $id_address);
    }
}
