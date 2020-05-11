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
include dirname(__FILE__).'/../../init.php';
require_once dirname(__FILE__).'/pensopay.php';

if (_PS_VERSION_ >= '1.5.0.0') {
    die('Bad version');
}

$json = Tools::file_get_contents('php://input');
/* HTTP_RAW_POST_DATA deprecated since PHP 5.6 */
if (!$json) {
    $json = $GLOBALS['HTTP_RAW_POST_DATA'];
}
$checksum = $_SERVER['HTTP_QUICKPAY_CHECKSUM_SHA256'];

$pensopay = new PensoPay();
$pensopay->validate($json, $checksum);
