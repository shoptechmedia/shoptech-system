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

include dirname(__FILE__).'/../../config/config.inc.php';
include dirname(__FILE__).'/../../header.php';
require_once dirname(__FILE__).'/pensopay.php';

if (_PS_VERSION_ >= '1.5.0.0') {
    die('Bad version');
}

$pensopay = new PensoPay();
$smarty = $pensopay->context->smarty;
$smarty->assign('status', Tools::getValue('status'));
$smarty->display(dirname(__FILE__).'/views/templates/front/fail.tpl');

include dirname(__FILE__).'/../../footer.php';
