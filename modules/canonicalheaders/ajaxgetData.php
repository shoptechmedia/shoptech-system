<?php 

include '../../config/settings.inc.php';
include '../../config/defines.inc.php';
include_once(dirname(__FILE__).'/../../config/config.inc.php');		

/**
* 
*/

$id = $_POST['id'];
$type = $_POST['type'];
$store_id = $_POST['store_id'];

$check_if_has_data = DB::getInstance()->executeS("SELECT link_address FROM "._DB_PREFIX_."htttp_links WHERE type = '$type' AND type_id = '$id' AND store_id = '$store_id'");

if ($check_if_has_data) {
	foreach ($check_if_has_data as $data) {
		echo $data['link_address'];
	}
}