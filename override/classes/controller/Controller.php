<?php
abstract class Controller extends ControllerCore
{
    /*
    * module: n45xspeed
    * date: 2016-09-16 03:58:40
    * version: 2.6.4
    */
    public $express_start_time;
    /*
    * module: n45xspeed
    * date: 2016-09-16 03:58:40
    * version: 2.6.4
    */
    private function url_get_contents ($Url) {
        if (function_exists('curl_init')){ 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }
    }

    /*
    * module: n45xspeed
    * date: 2016-09-16 03:58:40
    * version: 2.6.4
    */
    public function run() {
        if (!Module::isInstalled('n45xspeed') || !Module::isEnabled('n45xspeed') || @$_COOKIE['deactivatedCache'] == 1){
            return parent::run();
        }

        if(file_exists(_PS_MODULE_DIR_ . '/n45xspeed/overwrite/Controller.php')){
            include_once(_PS_MODULE_DIR_ . '/n45xspeed/overwrite/Controller.php');
        }
    }
}
