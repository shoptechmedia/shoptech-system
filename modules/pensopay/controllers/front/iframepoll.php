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
class PensopayIframepollModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $context = Context::getContext();
        $isCancelled = $context->cookie->__isset(PensoPay::COOKIE_ORDER_CANCELLED);
        if ($isCancelled) {
            $context->cookie->__unset(PensoPay::COOKIE_ORDER_CANCELLED);
            $context->cookie->write();
        }

        $pensopay = new PensoPay();
        $pensopay->getSetup(); //init
        try {
            if ($isCancelled) { //Check if cancelled from iframe first
                $response =
                    [
                        'repeat' => 0,
                        'error' => 1,
                        'success' => 0,
                        'redirect' => $pensopay->getPageLink('order', 'step=3')
                    ];
                throw new \Exception(); //get out of here
            }

            $order_id = Tools::getValue('order_id');
            $data = $pensopay->doCurl('payments', array('order_id=' . $order_id), 'GET');
            $vars = $pensopay->jsonDecode($data);
            if (isset($vars[0])) {
                /** @var stdClass $transaction */
                $transaction = $vars[0];
                if (!empty($transaction->operations)) {
                    $err = false;
                    foreach ($transaction->operations as $operation) {
                        if (in_array($operation->type, [
                            'authorize',
                            'capture'])
                        ) {
                            if ($operation->qp_status_code == 20000) {
                                $continueurl = $context->cookie->__get(PensoPay::COOKIE_CONTINUEURL);
                                if (!empty($continueurl)) {
                                    $context->cookie->__unset(PensoPay::COOKIE_CONTINUEURL);
                                    $context->cookie->write();
                                }

                                $response =
                                    [
                                        'repeat' => 0,
                                        'error' => 0,
                                        'success' => 1,
                                        'redirect' => $continueurl
                                    ];
                                break;
                            } elseif ($operation->qp_status_code != 30100) { //If not waiting for 3d secure
                                $err = true;
                            }
                        }
                    }
                    if ($err) {
                        $response =
                            [
                                'repeat' => 0,
                                'error' => 1,
                                'success' => 0,
                                'redirect' => $pensopay->getPageLink('order', 'step=3')
                            ];
                    }
                }
            }
        } catch (Exception $e) {
        }

        if (empty($response)) {
            $response =
                [
                    'repeat' => 1,
                    'error' => 0,
                    'success' => 0,
                    'redirect' => ''
                ];
        }
        echo json_encode($response);
        exit;
    }
}
