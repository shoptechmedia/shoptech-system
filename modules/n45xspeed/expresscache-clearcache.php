<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/n45xspeed.php');

if (/*substr(Tools::encrypt('n45xspeed/index'),0,10) != Tools::getValue('token') ||*/ !Module::isInstalled('n45xspeed'))
        die('Bad token');


function rrmdir($dir) {
	if (is_dir($dir)) {
	    $objects = scandir($dir);
	    foreach ($objects as $object) {
	        if ($object != "." && $object != "..") {
	            if (filetype($dir . "/" . $object) == "dir") rrmdir($dir . "/" . $object);
	            else unlink($dir . "/" . $object);
	        }
	    }
	    reset($objects);
	    rmdir($dir);
	}
}


$context = Context::getContext();
$id_shop = (int)$context->shop->id;

//delete cached db rows

Db::getInstance()->execute("UPDATE " . _DB_PREFIX_ . "express_cache set cache='NULL', cache_size=0 where id_shop = {$id_shop}");

//delete cached files from the filesystem as well
$cache_dir = _PS_MODULE_DIR_ . 'n45xspeed/cache/';
$files = glob($cache_dir . '*');
 // get all file names
foreach ($files as $file) {
     // iterate files
    
    if (is_file($file)) unlink($file);
     // delete file
    elseif (is_dir($file)) rrmdir($file);
     //delete folder recur
    
}

echo 'Cache cleared';