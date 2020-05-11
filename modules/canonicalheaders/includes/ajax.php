<?php 
echo $_SERVER['SERVER_NAME'].'/config/config.inc.php';

include $_SERVER['SERVER_NAME'].'/config/config.inc.php';
include $_SERVER['SERVER_NAME']._MODULE_DIR_.'/canonicalheaders/canonicalheaders.php';
include $_SERVER['SERVER_NAME'].'/config/defines.inc.php';
include $_SERVER['SERVER_NAME'].'/config/settings.inc.php';
include $_SERVER['SERVER_NAME'].'/init.php';
echo $_POST['cats'] . ' ' . $_POST['link'];
Db::getInstance()->insert('htttp_links', [

	'link_address' => 	$_POST['link'],

	'type' => 2,

	'type_id' => $_POST['cats']

]);

$if_has_data_in_db = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."htttp_links WHERE type = 2 AND type_id = '".$_POST['cats']."'");

foreach ($if_has_data_in_db as $key) {
	echo $key;
}