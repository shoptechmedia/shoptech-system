<?php

if(isset($_REQUEST['checkProgress'])){
	die(!file_exists(__DIR__ . '/cron_running'));

}elseif(file_exists(__DIR__ . '/cron_running')){
	die('Rebuild is already running');
}

include(__DIR__ . '/../../../config/config.inc.php');

include(__DIR__ . '/../n45xspeed.php');

if (!Module::isInstalled('n45xspeed'))
        die('Bad token');

$n45xspeed = new n45xspeed();
$context = Context::getContext();
$shop = $context->shop;

$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';

$proto = (!$is_https) ? 'http' : 'https';
$domain = (!$is_https) ? $shop->domain : $shop->domain_ssl;
$physical_uri = $shop->physical_uri;
$virtual_uri = $shop->virtual_uri;

$base_uri = $proto . '://' . $domain . $physical_uri . $virtual_uri;

$base_uri = trim($base_uri, '/');

$crontab = __DIR__ . '/crontab.txt';

if(isset($_REQUEST['scheduleIn'])){

	if(isset($_GET['debug'])){
		$time = time() + (60);
	}else{
		$time = time() + (60 * 60 * $_REQUEST['scheduleIn']);
	}

	file_put_contents($crontab, $time);

}elseif(isset($_REQUEST['executeScheduledCron'])){
	if(file_exists($crontab)){
		$time = file_get_contents($crontab);

		if(!empty($time)){
			if(time() >= $time){
				file_put_contents($crontab, '');

				$command = "curl -sS '" . $base_uri . "/modules/n45xspeed/rebuild-cache.php' > /dev/null 2>/dev/null &";

				exec($command, $output);
			}
		}
	}
}else{
	$command = "curl -sS '" . $base_uri . "/modules/n45xspeed/rebuild-cache.php' > /dev/null 2>/dev/null &";

	exec($command, $output);
}