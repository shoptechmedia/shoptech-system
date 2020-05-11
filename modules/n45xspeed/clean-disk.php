<?php define('_PS_MODE_DEV_', true);

require '../../config/config.inc.php';

/********* CLEAN NATIVE CACHE **********/

Tools::clearSmartyCache();

Tools::clearXMLCache();

foreach ([_PS_THEME_DIR_.'cache'] as $dir) {
	if (file_exists($dir)) {
		foreach (array_diff(scandir($dir), ['..', '.', 'index.php']) as $file) {
			Tools::deleteFile($dir.DIRECTORY_SEPARATOR.$file);
		}
	}
}

foreach ([_PS_THEME_DIR_.'cache/ie9'] as $dir) {
	if (file_exists($dir)) {
		foreach (array_diff(scandir($dir), ['..', '.', 'index.php']) as $file) {
			Tools::deleteFile($dir.DIRECTORY_SEPARATOR.$file);
		}
	}
}

Tools::generateIndex();

PageCache::flush();

if (function_exists('opcache_reset')) {
	opcache_reset();
}

/********* CLEAN NATIVE CACHE **********/


/********* CLEAN /img/tmp FOLDER **********/

$files = glob(_PS_TMP_IMG_DIR_); // get all file names
foreach($files as $file){ // iterate files
	if(is_file($file))
		unlink($file); // delete file
}

/********* CLEAN /img/tmp FOLDER **********/


/********* DELETE UNUSED PRODUCT IMAGES **********/

include __DIR__ . '/img.php';

/********* DELETE UNUSED PRODUCT IMAGES **********/