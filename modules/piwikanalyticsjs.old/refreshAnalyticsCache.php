<?php

/**
 * Piwik - free/libre analytics platform
 * Piwik Proxy Hide URL
 *
 * @link http://piwik.org/faq/how-to/#faq_132
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// -----
// Important: read the instructions in README.md or at:
// https://github.com/piwik/piwik/tree/master/misc/proxy-hide-piwik-url#piwik-proxy-hide-url
// -----

/**
 * This file is modified to function with Prestashop module 
 * "piwikanalyticsjs and piwikanalytics"
 * By: Christian Jensen
 * https://github.com/cmjnisse/piwikanalyticsjs-prestashop
 * 
 * this file also serves as a template of how you may create 
 * your own script and place it elsewhere to serve as proxy
 * 
 * Note: that all changes to this file, in this location 
 * will be overridden when the module is updated.!
 */
// get Prestashop config loader
require dirname(__FILE__) . '/../../config/config.inc.php';
require dirname(__FILE__) . '/piwikanalyticsjs.php';
// get Piwik helper class
require dirname(__FILE__) . '/PKHelper.php';

$id_order = Tools::getValue('id_order');

$context = Context::getContext();

$module = new piwikanalyticsjs();

$prefix = _DB_PREFIX_;
$aprefix = 'analytics_';

$confirmation = '';
$analytics_token = Configuration::get('PIWIK_TOKEN_AUTH');
$analytics_host = Configuration::get('PIWIK_HOST');

$idSites = 1;

$order = new Order($id_order);

$context->customer = new Customer(2);

echo $module->hookOrderConfirmation([
    'objOrder' => $order
]);