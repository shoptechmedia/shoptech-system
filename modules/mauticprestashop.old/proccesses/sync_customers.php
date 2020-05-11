<?php 

//require_once (dirname(__FILE__) . '../lib/api/vendor/autoload.php');
include '../../../config/settings.inc.php';
include '../../../config/defines.inc.php';
include '../../../config/config.inc.php';
include_once '../lib/api/vendor/autoload.php';

function mautic_auth($reauthorize = false)
{
    $settings = array(
        'baseUrl' => Configuration::get('MAUTICPRESTASHOP_BASE_URL'),
        'version' => 'OAuth1a',
        'clientKey' => Configuration::get('MAUTICPRESTASHOP_CLIENT_KEY'),
        'clientSecret' => Configuration::get('MAUTICPRESTASHOP_CLIENT_SECRET'),
        'callback' => Tools::getProtocol() . Tools::safeOutput(Tools::getServerName()) . __PS_BASE_URI__ . '/modules/mauticprestashop/authorization.php'
    );
    if (Tools::getIsset('back')) {
        $settings['callback'] .= '?back=' . urlencode(Tools::getValue('back'));
    }

    if ($reauthorize != true) {
        $accessTokenData = Tools::unSerialize(Configuration::get('MAUTICPRESTASHOP_ACCESS_TOKEN_DATA'), false);
        if (!$accessTokenData && !is_array($accessTokenData)) {
            
        } else {
            $settings['accessToken'] = $accessTokenData['access_token'];
            $settings['accessTokenSecret'] = $accessTokenData['access_token_secret'];
        }
    }
    $auth = new Mautic\Auth\ApiAuth();
    return $auth->newAuth($settings);
}

$customers = new Customer();

$customers_array = [];

foreach ($customer->getCustomers(true) as  $value) {
	$customers_array[$value['email']] = [];
	$customers_array[$value['email']]['email'] = $value['email'];
}

$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("
	SELECT o.id_order, o.id_cart, o.total_paid, o.date_add as order_date, o.id_customer, c.company, c.firstname, c.lastname, c.email, c.date_add as signup_date FROM "._DB_PREFIX_."orders as o
	INNER JOIN "._DB_PREFIX_."customer as c ON (o.id_customer = c.id_customer AND c.newsletter = 1)
	WHERE o.id_shop = ".$_POST['id_shop']."
	AND o.id_lang = ".$_POST['id_lang']."
");

foreach ($result as $value) {
	$customers_array[$value['email']]['id_order'] .= $value['id_order'].',';
	$customers_array[$value['email']]['id_cart'] .= $value['id_cart'].',';
	$customers_array[$value['email']]['total_paid'] += $value['total_paid'];
	$customers_array[$value['email']]['order_date'] .= strtotime($value['order_date']).',';
	$customers_array[$value['email']]['id_customer'] = $value['id_customer'];
	$customers_array[$value['email']]['company'] = $value['company'];
	$customers_array[$value['email']]['firstname'] = $value['firstname'];
	$customers_array[$value['email']]['lastname'] = $value['lastname'];
	$customers_array[$value['email']]['email'] = $value['email'];
	$customers_array[$value['email']]['signup_date'] = strtotime($value['signup_date']);

	$orderDetailList = new OrderDetail();
	$orderdetail = $orderDetailList->getList($value['id_order']);
	$product_ids = [];
	$purchases = [];
	foreach ($orderdetail as $detail) {
		$customers_array[$value['email']]['product_ids'][] = $detail['product_id'];
		//$product_ids[] = $detail['product_id'];
		$purchases[$detail['product_id']]['max_purchase'] += $detail['total_price_tax_incl'];
	}
	//$customers_array[$value['email']]['product_ids'][] = implode(',', $product_ids);
}

$auth = mautic_auth();
$api = new Mautic\MauticApi();
$contactApi = $api->newApi('contacts', $auth, Configuration::get('MAUTICPRESTASHOP_BASE_URL'));
$contacts = $contactApi->getList();
$fieldlist = $contactApi->getFieldList();
foreach ($customers_array as $key => $customer_data) {
	$check = [];

	$customer_data['id_order'] = substr($customer_data['id_order'], 0, -1);
	$customer_data['id_cart'] = substr($customer_data['id_cart'], 0, -1);
	$customer_data['order_date'] = substr($customer_data['order_date'], 0, -1);
	$customer_data['product_ids'] = implode(',', $customer_data['product_ids']);
	$customer_data['total_paid'] = ($customer_data['total_paid'] == '0') ? 'Purchases are at 0 at the moment.' : $customer_data['total_paid'];

	foreach ($contacts['contacts'] as $key => $value) {
	    if ($customer_data['email'] === $value['fields']['core']['email']['value']) {
	        $check[] = 0;
	    } else {
	        $check[] = 1;
	    }
	}
	$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("
		SELECT c.newsletter as newsletter, c.company FROM "._DB_PREFIX_."customer as c
		WHERE c.newsletter = 1
		AND id_customer = ".$customer_data['id_customer']."
	");
	if (!in_array(0, $check)) {
	    if ($result['newsletter'] > 0) {
	        $data = array(
	            'firstname' => $customer_data['firstname'],
	            'lastname'  => $customer_data['lastname'],
	            'email'     => $customer_data['email'],
	            'order_ids'     => $customer_data['id_order'],
	            'cart'     => $customer_data['id_cart'],
	            'total_purchases'     => $customer_data['total_paid'],
	            'order_date'     => $customer_data['order_date'],
	            'id_customer'     => $customer_data['id_customer'],
	            'products'     => $customer_data['product_ids'],
	            'signup_date'     => $customer_data['signup_date'],
	            /*'ipAddress' => $_SERVER['REMOTE_ADDR']*/
	        );
	        $addcontact = $contactApi->create($data);
	        print_r($addcontact);
		    $imported += 1;
	    }
	}
}
/*echo $imported;*/
/*$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("
	SELECT o.id_order, o.id_cart, o.total_paid, o.date_add as order_date, o.id_customer, c.company, c.firstname, c.lastname, c.email, c.date_add as signup_date FROM "._DB_PREFIX_."orders as o
	INNER JOIN "._DB_PREFIX_."customer as c ON (o.id_customer = c.id_customer AND c.newsletter = 1)
	WHERE o.id_shop = ".$_POST['id_shop']."
	AND o.id_lang = ".$_POST['id_lang']."
");*/

exit;

/*$auth = mautic_auth();
$api = new Mautic\MauticApi();
$contactApi = $api->newApi('contacts', $auth, Configuration::get('MAUTICPRESTASHOP_BASE_URL'));
$contacts = $contactApi->getList();

$imported = 0;

foreach ($customer->getCustomers(true) as  $customer_data) {
	$check = [];
	foreach ($contacts['contacts'] as $key => $value) {
	    if ($customer_data['email'] === $value['fields']['core']['email']['value']) {
	        $check[] = 0;
	    } else {
	        $check[] = 1;
	    }
	}
	$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("
		SELECT c.newsletter as newsletter, c.company FROM "._DB_PREFIX_."customer as c
		WHERE c.newsletter = 1
		AND id_customer = ".$customer_data['id_customer']."
	");
	if (!in_array(0, $check)) {
	    if ($result['newsletter'] > 0) {
	        $data = array(
	            'firstname' => $customer_data['firstname'],
	            'lastname'  => $customer_data['lastname'],
	            'email'     => $customer_data['email'],
	            'ipAddress' => $_SERVER['REMOTE_ADDR'],
	        );
	        $addcontact = $contactApi->create($data);
		    $imported += 1;
	    }

	}
}

echo $imported;*/


