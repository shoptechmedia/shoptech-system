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
class PensopayCompleteModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        $id_cart = (int)Tools::getValue('id_cart');
        $id_module = (int)Tools::getValue('id_module');

        $key = Tools::getValue('key');
        //In one page checkout with guest checkout enabled,
        //the key will always be invalid because it is impossible to be known on checkout.
        $isOpcGuestFix = Configuration::get('PS_GUEST_CHECKOUT_ENABLED') && Module::isInstalled('onepagecheckout');
        if ($isOpcGuestFix) {
            $key = null;
        }
        $key2 = Tools::getValue('key2');
        if (!$id_module || (!$key && !$isOpcGuestFix)) {
            Tools::redirect('history.php');
        }
        for ($i = 0; $i < 10; $i++) {
            /* Wait for validation */
            $trans = Db::getInstance()->getRow('SELECT *
                FROM '._DB_PREFIX_.'pensopay_execution
                WHERE `id_cart` = '.$id_cart.'
                ORDER BY `id_cart` ASC');
            if ($trans && $trans['accepted']) {
                break;
            }
            sleep(1);
        }
        if ($trans && !$trans['accepted']) {
            $pensopay = new PensoPay();
            $setup = $pensopay->getSetup();
            $json = $pensopay->doCurl('payments/'.$trans['trans_id']);
            $vars = $pensopay->jsonDecode($json);
            $json = Tools::jsonEncode($vars);
            if ($vars->accepted == 1) {
                $checksum = $pensopay->sign($json, $setup->private_key);
                $pensopay->validate($json, $checksum);
            }
        }
        unset($this->context->cookie->id_cart);
        parent::init();
        $id_order = Order::getOrderByCartId($id_cart);
        if (!$id_order) {
            Tools::redirect('history.php');
        }
        $order = new Order($id_order);
        $customer = new Customer($order->id_customer);
        if ($key2) {
            $pensopay = new PensoPay();
            $trans = Db::getInstance()->getRow('SELECT *
                FROM '._DB_PREFIX_.'pensopay_execution
                WHERE `id_cart` = '.$id_cart.'
                ORDER BY `id_cart` ASC');
            $json = $trans['json'];
            $vars = $pensopay->jsonDecode($json);
            $query = parse_url($vars->link->continue_url, PHP_URL_QUERY);
            parse_str($query, $args);
            if ($args['key'] == $key) {
                $key = $customer->secure_key;
            }
            $this->context->cookie->id_customer = $customer->id;
        }
        if (!Validate::isLoadedObject($order) ||
                $customer->secure_key != $key) {
            Tools::redirect('history.php');
        }
        Tools::redirect(
            'index.php?controller=order-confirmation&id_cart='.$id_cart.
            '&id_module='.$id_module.
            '&id_order='.$id_order.
            '&key='.$key
        );
    }
}
