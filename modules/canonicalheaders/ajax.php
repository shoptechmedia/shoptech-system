<?php 

include '../../config/settings.inc.php';
include '../config/defines.inc.php';
include_once(dirname(__FILE__).'/../../config/config.inc.php');		

/**
* 
*/

$id = $_POST['id'];
$type = $_POST['type'];
$store_id = $_POST['store_id'];
$link = $_POST['link'];

$check_if_has_data = DB::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."htttp_links WHERE type = '$type' AND type_id = '$id'");

if (!$check_if_has_data) {
	DB::getInstance()->insert('htttp_links', [

		'link_address' => 	$link,

		'type' => $type,

		'type_id' => $id,

		'store_id' => $store_id

	]);
} else {
	DB::getInstance()->execute("UPDATE "._DB_PREFIX_."htttp_links SET link_address = '$link'  WHERE type = '$type' AND type_id = '$id'");
}