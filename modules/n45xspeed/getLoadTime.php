<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/n45xspeed.php');

if (!Module::isInstalled('n45xspeed'))
        die('Bad token');

$n45xspeed = new n45xspeed();

$shops = Shop::getCompleteListOfShopsID();
$langs = Language::getLanguages();
$link = new Link();

function getLoadTime($url){
    $getContents = file_get_contents($url . '?getCacheTime488=1');

    return $getContents;
}

$loadTime = 'Not Cached';
foreach($shops as $shop){
    $shopObj = new ShopUrl($shop);
    $shopUrl = $shopObj->getURL();
    $parsedUrl = parse_url($shopUrl);

    if(strpos(_PS_VERSION_, '1.5.') === 0){
        $newLoadTime = getLoadTime($shopUrl . 'index.php');

        if($newLoadTime != 'Not Cached'){
            $loadTime = $newLoadTime;
            break;
        }
    }

    $newLoadTime = getLoadTime($shopUrl);

    if($newLoadTime != 'Not Cached'){
        $loadTime = $newLoadTime;
        break;
    }

    foreach($langs as $lang){
        $newLoadTime = getLoadTime($shopUrl . $lang['iso_code'] . '/');

        if($newLoadTime != 'Not Cached'){
            $loadTime = $newLoadTime;
            break;
        }
    }
}

print_r($loadTime);