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

/**
 * @since 1.5.0
 */
class PensopayIframeModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $pensopay = new PensoPay();
        $payUrl = $pensopay->payment();
        if (empty($payUrl)) {
            return;
        } // we got redirected to a success/fail url here
        $this->context->smarty->assign(
            array(
                'src' => $payUrl,
                'order_id' => Tools::getValue('order_id'),
                'endpoint' => $pensopay->getModuleLink('iframepoll', array('order_id' => Tools::getValue('order_id')))
            )
        );
        if (_PS_VERSION_ >= '1.7.0.0') {
            $this->setTemplate('module:pensopay/views/templates/front/iframe.tpl');
        } else {
            $this->setTemplate('iframe16.tpl');
        }
    }
}
