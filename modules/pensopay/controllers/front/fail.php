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

class PensopayFailModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        Context::getContext()->smarty->assign(
            array(
                'status' => Tools::getValue('status'),
                'shop_name' => Configuration::get('PS_SHOP_NAME'),
            )
        );
        if (_PS_VERSION_ >= '1.7.0.0') {
            $this->setTemplate('module:pensopay/views/templates/front/fail17.tpl');
        } else {
            $this->setTemplate('fail.tpl');
        }
    }
}
