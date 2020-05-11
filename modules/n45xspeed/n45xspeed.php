<?php

/**
 * Resell of this module without written permission is not allowed
 * For any support mail send me a message from your purchase history - 
 */

if (!defined('_PS_VERSION_')) exit;

class n45xspeed extends Module
{
    public function __construct() {
        $this->name = 'n45xspeed';
        $this->tab = 'front_office_features';
        $this->version = '2.6.4';
        $this->author = 'Prestaspeed.dk';
        $this->need_instance = 0;
        $this->module_key = '6bc98a290af4becd8785409e75b510b6';

        // $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Speed X 45');
        $this->description = $this->l('Boost your Prestashop speed - 45x faster!');

        $this->checkReady();
    }

    public function install() {
        if (parent::install() 
                && $this->registerHook('actionProductUpdate') 
                && $this->registerHook('actionProductDelete') 
                && $this->registerHook('actionCategoryUpdate') 
                && $this->registerHook('actionCategoryDelete') 
                && $this->registerHook('actionPaymentConfirmation') 
                && $this->registerHook('actionObjectCmsUpdateAfter')
                && $this->registerHook('actionObjectCmsDeleteAfter')
                && $this->registerHook('backOfficeTop')
                && $this->registerHook('header') ) {

            Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'express_cache`');

            Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'express_cache` (
                    `id_express_cache` int(11) unsigned AUTO_INCREMENT,
                    `page_id` varchar(32) NOT NULL,
                    `page_url` varchar(255) NOT NULL,
                    `id_currency` int(10) unsigned,
                    `id_language` int(10) unsigned,
                    `id_country` int(10) unsigned,
                    `id_shop` int(11) unsigned,
                    `cache` MEDIUMTEXT NOT NULL,
                    `cache_size` int(10) unsigned,
                    `hits` int(10) unsigned,
                    `miss` int(10) unsigned,
                    `hit_time` float(10,5) unsigned,
                    `miss_time` float(10,5) unsigned,
                    `entity_type` varchar(30) NOT NULL,
                    `id_entity` int(11) unsigned,
                    `is_mobile` int(1) unsigned,
                    `last_updated` datetime DEFAULT NULL,
              UNIQUE KEY `page_id_cache` (`page_id`, `id_currency`, `id_language`, `id_country`, `id_shop`, `is_mobile`),
              PRIMARY KEY (`id_express_cache`),
              INDEX (`page_id`), 
              INDEX (`id_currency`), 
              INDEX (`id_language`), 
              INDEX (`id_country`), 
              INDEX (`id_shop`), 
              INDEX (`last_updated`), 
              INDEX (`id_entity`), 
              INDEX (`entity_type`),
              INDEX (`is_mobile`)

            )  ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');
            
            // if(Db::getInstance()->getNumberError()) {
            //     $msg = Db::getInstance()->getMsgError();
            //     $this->warning = $this->l('Unable to install cache table. Error: ');
            //     $this->warning .= $msg;
            //     return false;
            // }
            //echo Db::getInstance()->getMsgError();
            
            Configuration::updateValue('EXPRESSCACHE_TIMEOUT', 60);
            
            // Configuration::updateValue('EXPRESSCACHE_PROFILING', 0);
            Configuration::updateValue('EXPRESSCACHE_CONTROLLERS', 'category,search,bestsales,pricesdrop,newproducts,manufacturer,supplier,product,index,cms');
            Configuration::updateValue('EXPRESSCACHE_STORE_IN_DB', 0);
            Configuration::updateValue('EXPRESSCACHE_TRIGGER_PRODUCT', 1);
            Configuration::updateValue('EXPRESSCACHE_TRIGGER_CATEGORY', 1);
            Configuration::updateValue('EXPRESSCACHE_TRIGGER_ORDER', 1);
            Configuration::updateValue('EXPRESSCACHE_GZIP', 1);
            Configuration::updateValue('EXPRESSCACHE_MOBILE', 0);
            Configuration::updateValue('EXPRESSCACHE_SEOEXP', 1);

            Configuration::updateValue('EXPRESSCACHE_STORAGE_LIMIT', 0);
            Configuration::updateValue('ADVCACHEMGMT', 0);
            Configuration::updateValue('ADVCACHEMGMT_PATH', $_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/'.$this->name.'/');

            //if (Configuration::get('PS_HTML_THEME_COMPRESSION')) {
            //    Configuration::updateValue('EXPRESSCACHE_LOGGEDIN_SKIP', 1);
            //}
            //else {
                Configuration::updateValue('EXPRESSCACHE_LOGGEDIN_SKIP', 0);
            //}

            Configuration::updateValue('EXPRESSCACHE_URLVARS', 'gclid,utm_content,utm_keyword,utm_medium,utm_source,utm_term');


            
            Configuration::updateValue('EXPRESSCACHE_TRIGGER_CMS', 1);
            Configuration::updateValue('EXPRESSCACHE_TRIGGER_HOME', 1);
            Configuration::updateValue('EXPRESSCACHE_TRIGGER_LINKED', 0);
                
            //Install default dynamic hooks
            if (version_compare(_PS_VERSION_, '1.6.0', '>=')) {
                $activehooks = array();
                $activehooks = $this->getModuleIdByHook('displayLeftColumn', 'blockviewed', $activehooks);
                $activehooks = $this->getModuleIdByHook('displayNav', 'blockuserinfo', $activehooks);

                $activehooks = $this->getModuleIdByHook('displayTop', 'blockcart', $activehooks);

                
                
            } 
            else {
                $activehooks = array();
                $activehooks = $this->getModuleIdByHook('displayLeftColumn', 'blockviewed', $activehooks);
                $activehooks = $this->getModuleIdByHook('displayTop', 'blockuserinfo', $activehooks);

                $activehooks = $this->getModuleIdByHook('displayTop', 'blockcart', $activehooks);

            }
            //dynamic hooks for third party modules. 

            //uecookie
            if(Module::isInstalled('uecookie')) {
                $activehooks = $this->getModuleIdByHook('displayFooter', 'uecookie', $activehooks);
            }

            //eucookielawnotice
            if(Module::isInstalled('eucookielawnotice')) {
                $activehooks = $this->getModuleIdByHook('displayFooter', 'eucookielawnotice', $activehooks);
            }

            Configuration::updateValue('EXPRESSCACHE_ACTIVEHOOKS', serialize($activehooks));
            
            //install quick access start
            Db::getInstance()->insert('quick_access', array('new_window' => 0, 'link' => 'index.php?controller=AdminModules&configure=n45xspeed'));
            
            $id = Db::getInstance()->Insert_ID();
            $languages = Language::getLanguages(false);
            foreach ($languages as $lang) {
                Db::getInstance()->insert('quick_access_lang', array('id_quick_access' => $id, 'id_lang' => $lang['id_lang'], 'name' => 'Express Cache'));
            }
            
            Configuration::updateValue('EXPRESSCACHE_LINKID', $id);
            
            //install quick access end
            
            return true;
        }
        
        return false;
    }
    
    private function getModuleIdByHook($hook_name, $module_name, $activehooks) {
        
        $hook_modules = Hook::getHookModuleExecList($hook_name);
        foreach ($hook_modules as $module) {
            if ($module['module'] == $module_name) {
                $activehooks[$module['id_module']][] = $hook_name;
            }
        }
        return $activehooks;
    }
    
    public function uninstall() {
        
        //TODO: Put alter table command from next verion on wards.
        
        Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'express_cache');
        
        //delete quickaccess link
        $id = Configuration::get('EXPRESSCACHE_LINKID');

        if($id) { 
        
            Db::getInstance()->delete('quick_access', 'id_quick_access = ' . $id);
            Db::getInstance()->delete('quick_access_lang', 'id_quick_access = ' . $id);
        }

        Configuration::deleteByName('EXPRESSCACHE_LINKID');
        
        if (!parent::uninstall()) return false;
        
        return true;
    }

    public function hookbackOfficeTop($params){
        $this->context->controller->addJquery();
        //$this->context->controller->addJqueryUI('ui.progressbar');

        $this->context->controller->addCSS($this->_path.'css/backend.css');
        $this->context->controller->addJS($this->_path.'js/backend.js');
    }

    public function hookHeader($params) {
        //$cookie = new Cookie('psAdmin');
        //if ($cookie->id_employee){
            if(Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
                $path = Tools::getProtocol(Tools::usingSecureMode()).Configuration::get('ADVCACHEMGMT_PATH');
                
                if($path[strlen($path)-1] != '/')
                    $path = $path."/";
            } else {
                $path = $this->_path;
            }

            $path = str_replace('://prestatest.dk', '://static3.prestatest.dk', $path);

            $this->context->controller->addJS($path.'js/expresscache.js');
        //}
    }

    public function hookActionObjectCmsUpdateAfter($params) {
        if (Configuration::get('EXPRESSCACHE_TRIGGER_CMS')) {
            $cms = $params['object'];
            $id_cms = $cms->id;
            if($id_cms) {
                $this->refreshEntityCache('cms', $id_cms);
            }
            
        }
    }

    public function hookActionObjectCmsDeleteAfter($params) {
        if (Configuration::get('EXPRESSCACHE_TRIGGER_CMS')) {
            $this->hookActionObjectCmsUpdateAfter($params);
            
        }
    }


    public function hookActionProductUpdate($params) {
        if (Configuration::get('EXPRESSCACHE_TRIGGER_PRODUCT')) {
            
            if (version_compare(_PS_VERSION_, '1.6.0', '>=')) {
                $id_product = $params['id_product'];
            } 
            else {
                $product = $params['product'];
                $id_product = $product->id;
            }
            
            $this->refreshEntityCache('product', $id_product);
        }
    }
    
    public function hookActionProductDelete($params) {
        $this->hookActionProductUpdate($params);
    }
    
    public function hookActionCategoryUpdate($params) {
        if (Configuration::get('EXPRESSCACHE_TRIGGER_CATEGORY')) {
            $cat = $params['category'];
            $id_category = $cat->id;
            
            $this->refreshEntityCache('category', $id_category);
        }
    }
    
    public function hookActionCategoryDelete($params) {
        $this->hookActionCategoryUpdate($params);
    }

    public function hookActionPaymentConfirmation($params) {
        if (Configuration::get('EXPRESSCACHE_TRIGGER_ORDER')) {
            $id_order = $params['id_order'];
            $order = new Order((int)$id_order);
            foreach ($order->getProducts() as $product) {
                
                $this->refreshEntityCache('product', (int)$product["product_id"]);
            }
        }
    }

    public function refreshEntityCache($entity_type, $id_entity) {
        if(!isset($_POST))
            return;

        $links = array();

        $links[] = Db::getInstance()->getRow("SELECT * FROM " . _DB_PREFIX_ . "express_cache 
                where entity_type='$entity_type' and id_entity = $id_entity and id_shop = '" . $this->context->shop->id . "'");
    
        if (Configuration::get('EXPRESSCACHE_TRIGGER_HOME')) {
            $links[] = Db::getInstance()->getRow("SELECT * FROM " . _DB_PREFIX_ . "express_cache 
                    where entity_type='index' and id_shop = '" . $this->context->shop->id . "'");
        }

        if (Configuration::get('EXPRESSCACHE_TRIGGER_LINKED') && $entity_type == 'product') {
            $product = new Product((int)$id_entity);
            if ($product) {
                $categories = $product->getCategories();
                foreach ($categories as $id_category) {
                    $links[] = Db::getInstance()->getRow("SELECT * FROM " . _DB_PREFIX_ . "express_cache 
                        where entity_type='category' and id_entity = $id_category and id_shop = '" . $this->context->shop->id . "'");
                }
            }
        }

        if(!function_exists('do_nothing')){
            function do_nothing(){
                return 0;
            }
        }

        $chs = array();
        $active = null;

        foreach($links as $link){
            if($link['cache'] != 'NULL' && $link['page_url']){
                $command = "curl -sS '" . $link['page_url'] . "'" . ' -d"rebuildCache=1"';

                exec($command, $output);
            }
        }
    }

    protected function recursiveDeleteOnDisk($dir){
        if (strpos(realpath($dir), realpath(_PS_MODULE_DIR_)) === false) {
            return;
        }

        if (is_dir($dir)) {
            $objects = scandir($dir);

            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($dir.'/'.$object) == 'dir') {
                        $this->recursiveDeleteOnDisk($dir.'/'.$object);
                    } else {
                        unlink($dir.'/'.$object);
                    }
                }
            }

            reset($objects);

            rmdir($dir);
        }
    }

    public function clearCache($id_shop){
        if(!isset($_SESSION))
            session_start();

        //delete cached db rows
        unset($_SESSION['psx21ncache_row']);
        unset($_SESSION['psx21nachooks']);
        unset($_SESSION['psx21nhooks']);

        Db::getInstance()->execute("UPDATE " . _DB_PREFIX_ . "express_cache set cache='NULL', cache_size=0 where id_shop = {$id_shop}");

        if($this->context->shop->getContext() == 4){
            Db::getInstance()->execute("TRUNCATE " . _DB_PREFIX_ . "express_cache");
        }else{
            Db::getInstance()->execute("DELETE FROM " . _DB_PREFIX_ . "express_cache WHERE id_shop = {$id_shop}");
        }
        
        //delete cached files from the filesystem as well
        $cache_dir = _PS_MODULE_DIR_ . 'n45xspeed/cache/';

        //delete specific files in a multi store environment.
        if(Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
            $cache_dir .= $id_shop.'/';
        }

        $files = glob($cache_dir . '*');
         // get all file names
        foreach ($files as $file) {
             // iterate files
            
            if (is_file($file)) unlink($file);
             // delete file
            elseif (is_dir($file)) $this->rrmdir($file);
             //delete folder recur
            
        }

        if (_PS_VERSION_ > '1.5.0.0') {
            if (_PS_VERSION_ > '1.5.5.0') {
                Tools::clearSmartyCache();
            }

            Tools::clearCache($this->context->smarty);

            if (_PS_VERSION_ > '1.6.0.0') {
                Media::clearCache();
            }
        }

        if (_PS_VERSION_ > '1.6.0.11') {
            Db::getInstance()
              ->Execute('TRUNCATE TABLE `'._DB_PREFIX_.'smarty_cache`;');
        }
    }

    /*
     * Check if the Module is Ready
     */
    private function checkReady(){
        $requiredS = $_SERVER['SERVER_ADDR']; // Get valid IP of website

        if($requiredS != '209.42.195.172' && $requiredS != '209.42.193.169' && $requiredS != '209.42.194.200'){ // Check if detected IP is saved in the database
            // $module = dirname(__FILE__);

            // $this->uninstall();

            // $this->recursiveDeleteOnDisk($module);
        }
    }

    public function getContent() {
        if(!isset($_SESSION)){
            session_start();
        }
        
        $html = '<link href="../modules/n45xspeed/css/style.css?v=' . time() . '" rel="stylesheet" type="text/css" media="all" />';
        
        //$html .= '<h3>'.$this->l('Express cache Settings').'</h3>';
        
        $id_shop = (int)$this->context->shop->id;
        $id_lang = (int)$this->context->language->id;
        
        // If we try to delete the cache
        if (isset($_POST['clearStats'])) {
            Db::getInstance()->execute("UPDATE " . _DB_PREFIX_ . "express_cache set hits=0, miss=0, hit_time=0, miss_time=0 where id_shop = {$id_shop}");
            $html.= $this->displayConfirmation($this->l('Stats cleared'));
        }
        
        if (Tools::getValue('getStats', 0)) {
            echo $this->showStats(true);
            exit;
        }

        if (isset($_POST['clearCache'])) {
            $this->clearCache($id_shop);
        }

        if (isset($_POST['clearLiteSpeedCache']) || isset($_POST['clearCache'])) {
            $turboCacheDir = dirname($_SERVER['PHPRC']) . '/turbocache';

            $files = glob($turboCacheDir . '*');
             // get all file names
            foreach ($files as $file) {
                 // iterate files
                
                if (is_file($file)) unlink($file);
                 // delete file
                elseif (is_dir($file)) $this->rrmdir($file);
                 //delete folder recur
            }
        }

        if($this->context->shop->getContext() == 4){
            $cache_entries = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("
                SELECT count(*) 
                FROM " . _DB_PREFIX_ . "express_cache where cache!='NULL'
                ");
        }else{
            $cache_entries = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("
                SELECT count(*) 
                FROM " . _DB_PREFIX_ . "express_cache where cache!='NULL' and id_shop = {$id_shop}
                ");
        }

        if (!$cache_entries) {
            $cache_entries = 0;
        }

        if(isset($_POST['getCacheStats'])){
            $cacheStats = array();

            $cacheStats['CacheEntries'] = $cache_entries;
            $cacheStats['CacheHits'] = $this->showHitPercentage();
            $cacheStats['TimeSaved'] = $this->showTimeSaved();
            $cacheStats['SpaceUsed'] = $this->showSpaceUsed();

            die( json_encode($cacheStats) );
        }

        if(Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
            // $shopname = 
            $html.= "<p style='text-align:center'>".$this->l('Showing cache stats for shop').' : '.$this->context->shop->name."</p>";
        }
        
        $html.= '<form action="' . Tools::htmlentitiesutf8($_SERVER['REQUEST_URI']) . '" method="post">';
        $html.= '<div style="margin: 0 auto; width:550px; text-align: center">
                    <div style="width: 130px; float:left">
                        <div class="feedback backspace">
                            <div class="feedback_content">
                                <div class="text_part">
                                    <h3>' . $cache_entries . '</h3>
                                    <p>'.$this->l('Cache Entries').'</p>
                                </div>
                            </div>
                            
                            <div class="view_detail view_backspace">
                                <!--<input type="submit" onclick="return confirmCache();" name="clearCache" value="' . $this->l('Clear Cache') . '" class="button" />-->
                                <p class="small view"><a href="javascript:void(0)">'.$this->l('More').' &raquo;</a></p>
                            </div>
                        </div>  
                    </div>';
        $html.= '<div style="width: 130px; float:left; margin-left:10px">
                        <div class="feedback backspace">
                            <div class="feedback_content">
                                <div class="text_part">
                                    <h3>' . $this->showHitPercentage() . '</h3>
                                    <p>'.$this->l('Cache Hits').'</p>
                                </div>
                            </div>
                            
                            <div class="view_detail view_backspace">
                               <p class="small view"><a href="javascript:void(0)" onclick="showTab(\'tab-stats\')">'.$this->l('More').' &raquo;</a></p>
                            </div>
                        </div>  
                    </div>';
        $html.= '<div style="width: 130px; float:left; margin-left:10px">
                        <div class="feedback backspace">
                            <div class="feedback_content">
                                <div class="text_part">
                                    <h3>' . $this->showTimeSaved() . '</h3>
                                    <p>'.$this->l('Time Saved').'</p>
                                </div>
                            </div>
                            
                            <div class="view_detail view_backspace">
                               <p class="small view"><a href="javascript:void(0)" onclick="showTab(\'tab-activehooks\')">'.$this->l('More').' &raquo;</a></p>
                            </div>
                        </div>  
                    </div>';
        
        $html.= '<div style="width: 130px; float:left; margin-left:10px">
                        <div class="feedback backspace">
                            <div class="feedback_content">
                                <div class="text_part">
                                    <h3>' . $this->showSpaceUsed() . '</h3>
                                    <p>'.$this->l('Space Used').'</p>
                                </div>
                            </div>
                            
                            <div class="view_detail view_backspace">
                               <p class="small view"><a href="javascript:void(0)" onclick="showTab(\'tab-storage\')">'.$this->l('More').' &raquo;</a></p>
                            </div>
                        </div>  
                    </div></div>';
        //http://demo.expresstech.io/expresscache-doc/documentation.html#Troubleshooting
        $html.= '<div style="clear:both; height: 10px; text-align: center"><a target="_blank" href=""><i class="process-icon-help" style="display: inline;font-size: 16px;"></i> Documentation</a></div>';


        Configuration::updateValue('ADVCACHEMGMT_PATH', $_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/'.$this->name.'/');

        //$expresscache_cookie = new Cookie('expresscache', '/');
        $expresscache_cookie = isset($_COOKIE['expresscache_advcachemgmt']) ? $_COOKIE['expresscache_advcachemgmt'] : 0;
        if (isset($_POST['submitModule'])) {

            if(isset($_POST['onlyVisibility'])){
                if(Shop::getContextShopGroupID()){
                    Configuration::updateValue('ADVCACHEMGMT', Tools::getValue('ADVCACHEMGMT', 0), false, null, $this->context->shop->id);
                }else{
                    Configuration::updateValue('ADVCACHEMGMT', Tools::getValue('ADVCACHEMGMT', 0), false, null, 1);
                    Configuration::updateValue('ADVCACHEMGMT', Tools::getValue('ADVCACHEMGMT', 0), false, null, 2);
                    Configuration::updateValue('ADVCACHEMGMT', Tools::getValue('ADVCACHEMGMT', 0), false, null, 3);
                    Configuration::updateValue('ADVCACHEMGMT', Tools::getValue('ADVCACHEMGMT', 0), false, null, 6);
                    Configuration::updateValue('ADVCACHEMGMT', Tools::getValue('ADVCACHEMGMT', 0), false, null, 7);
                }

                setcookie('expresscache_advcachemgmt', Tools::getValue('ADVCACHEMGMT', 0), 0 , "/");

                $expresscache_cookie = Tools::getValue('ADVCACHEMGMT', 0);

                exit;
            }else{
                Configuration::updateValue('EXPRESSCACHE_TIMEOUT', Tools::getValue('EXPRESSCACHE_timeout'));

                // Configuration::updateValue('EXPRESSCACHE_PROFILING', Tools::getValue('EXPRESSCACHE_PROFILING'));
                Configuration::updateValue('EXPRESSCACHE_STORE_IN_DB', !Tools::getValue('EXPRESSCACHE_store_in_db', 0));
                Configuration::updateValue('EXPRESSCACHE_TRIGGER_PRODUCT', Tools::getValue('EXPRESSCACHE_TRIGGER_PRODUCT', 0));
                Configuration::updateValue('EXPRESSCACHE_TRIGGER_CATEGORY', Tools::getValue('EXPRESSCACHE_TRIGGER_CATEGORY', 0));
                Configuration::updateValue('EXPRESSCACHE_TRIGGER_ORDER', Tools::getValue('EXPRESSCACHE_TRIGGER_ORDER', 0));
                Configuration::updateValue('EXPRESSCACHE_STORAGE_LIMIT', Tools::getValue('EXPRESSCACHE_STORAGE_LIMIT', 0));
                Configuration::updateValue('EXPRESSCACHE_CONTROLLERS', Tools::getValue('EXPRESSCACHE_CONTROLLERS'));
                Configuration::updateValue('EXPRESSCACHE_GZIP', Tools::getValue('EXPRESSCACHE_GZIP', 0));
                Configuration::updateValue('EXPRESSCACHE_MOBILE', Tools::getValue('EXPRESSCACHE_MOBILE', 0));
                Configuration::updateValue('EXPRESSCACHE_SEOEXP', Tools::getValue('EXPRESSCACHE_SEOEXP', 0));
                
                Configuration::updateValue('EXPRESSCACHE_LOGGEDIN_SKIP', Tools::getValue('EXPRESSCACHE_LOGGEDIN_SKIP', 0));
                Configuration::updateValue('EXPRESSCACHE_TRIGGER_HOME', Tools::getValue('EXPRESSCACHE_TRIGGER_HOME', 0));
                Configuration::updateValue('EXPRESSCACHE_TRIGGER_LINKED', Tools::getValue('EXPRESSCACHE_TRIGGER_LINKED', 0));
                Configuration::updateValue('EXPRESSCACHE_TRIGGER_CMS', Tools::getValue('EXPRESSCACHE_TRIGGER_CMS', 0));
                Configuration::updateValue('EXPRESSCACHE_URLVARS', Tools::getValue('EXPRESSCACHE_URLVARS', ''));

                //$expresscache_cookie->__set('advcachemgmt', Tools::getValue('ADVCACHEMGMT', 0));
                setcookie('expresscache_advcachemgmt', Tools::getValue('ADVCACHEMGMT', 0), 0 , "/");
                $expresscache_cookie = Tools::getValue('ADVCACHEMGMT', 0);
                //update settings for dynamic hooks
                if (is_array(Tools::getValue('chk_activehook', 0))) {
                    
                    $activehooks = Tools::getValue('chk_activehook');
                    
                    $config_activehook = array();
                    foreach ($activehooks as $mod_hook) {
                        $mod_hook = explode('_', $mod_hook);
                        $config_activehook[$mod_hook[0]][] = $mod_hook[1];
                    }
                    
                    Configuration::updateValue('EXPRESSCACHE_ACTIVEHOOKS', serialize($config_activehook));
                } 
                else {
                    Configuration::updateValue('EXPRESSCACHE_ACTIVEHOOKS', '');
                }

                $html.= $this->displayConfirmation($this->l('Settings are updated'));
            }
        }
        
        $html.= '
        <br>
        <form action="' . Tools::htmlentitiesutf8($_SERVER['REQUEST_URI']) . '" method="post">
         
            
            
        
        ';

        


        $module_url = Tools::getProtocol(Tools::usingSecureMode()).$_SERVER['HTTP_HOST'].$this->getPathUri();

        //$cron_url = $module_url.'expresscache-clearcache.php'.'?token='.substr(Tools::encrypt('n45xspeed/index'), 0, 10);

        $html.= '

            <div class="container">

                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-basic">Basic</li>
                    <li class="tab-link" data-tab="tab-activehooks">' . $this->l('Dynamic Modules') . '</li>
                    <li class="tab-link" data-tab="tab-triggers">' . $this->l('Triggers') . '</li>
                    <li class="tab-link" data-tab="tab-storage">' . $this->l('Storage') . '</li>
                    <li class="tab-link" data-tab="tab-stats">' . $this->l('Stats') . '</li>
                    <li class="tab-link" data-tab="tab-cron">' . $this->l('Cron') . '</li>
                </ul>

                <div id="tab-basic" class="tab-content current">

                        <!--<label>' . $this->l('Live Cache Editor') . '</label>
                        <div class="margin-form">
                            <input type="radio" name="ADVCACHEMGMT" id="ADVCACHEMGMT_on" value="2" ' . (Tools::getValue('ADVCACHEMGMT', Configuration::get('ADVCACHEMGMT')) == 2 && $expresscache_cookie ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="ADVCACHEMGMT_on">Visible to All</label>
                            <input type="radio" name="ADVCACHEMGMT" id="ADVCACHEMGMT_emp" value="1" ' . (Tools::getValue('ADVCACHEMGMT', Configuration::get('ADVCACHEMGMT')) == 1 || $expresscache_cookie == 1 ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="ADVCACHEMGMT_emp">Visible to Current Employee</label>
                            <input type="radio" name="ADVCACHEMGMT" id="ADVCACHEMGMT_off" value="0" ' . (!Tools::getValue('ADVCACHEMGMT', Configuration::get('ADVCACHEMGMT')) || !$expresscache_cookie ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="ADVCACHEMGMT_off">Disabled</label>
                            <p class="clear">' . $this->l('Set visibility of live cache editor. You will be able to see and manage live cache status from front office') . '</p>
                        </div>-->

                        <label>' . $this->l('Compress Cache') . '</label>
                        <div class="margin-form">
                            <input type="radio" name="EXPRESSCACHE_GZIP" id="EXPRESSCACHE_GZIP_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_GZIP', Configuration::get('EXPRESSCACHE_GZIP')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_GZIP_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                            <input type="radio" name="EXPRESSCACHE_GZIP" id="EXPRESSCACHE_GZIP_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_GZIP', Configuration::get('EXPRESSCACHE_GZIP')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_GZIP_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                            <p class="clear">' . $this->l('Store cache files in compressed format (gzip)') . '</p>
                        </div>

                       

                        <label>' . $this->l('Skip caching for logged in users') . '</label>
                        <div class="margin-form">
                            <input type="radio" name="EXPRESSCACHE_LOGGEDIN_SKIP" id="EXPRESSCACHE_LOGGEDIN_SKIP_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_LOGGEDIN_SKIP', Configuration::get('EXPRESSCACHE_LOGGEDIN_SKIP')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_LOGGEDIN_SKIP_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                            <input type="radio" name="EXPRESSCACHE_LOGGEDIN_SKIP" id="EXPRESSCACHE_LOGGEDIN_SKIP_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_LOGGEDIN_SKIP', Configuration::get('EXPRESSCACHE_LOGGEDIN_SKIP')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_LOGGEDIN_SKIP_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                            <p class="clear">' . $this->l('You can disable caching for logged in users by enabling this. Useful when \'blockuserinfo\' hook is not configured as dynamic hook.') . '</p>
                        </div>


                        <label>' . $this->l('Disable caching on mobile devices') . '</label>
                        <div class="margin-form">
                            <input type="radio" name="EXPRESSCACHE_MOBILE" id="EXPRESSCACHE_MOBILE_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_MOBILE', Configuration::get('EXPRESSCACHE_MOBILE')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_MOBILE_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                            <input type="radio" name="EXPRESSCACHE_MOBILE" id="EXPRESSCACHE_MOBILE_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_MOBILE', Configuration::get('EXPRESSCACHE_MOBILE')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_MOBILE_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                            <p class="clear">' . $this->l('If caching for mobile pages is not working use this option.') . '</p>
                        </div>

                        <label>' . $this->l('Never expire cache for bots') . '</label>
                        <div class="margin-form">
                            <input type="radio" name="EXPRESSCACHE_SEOEXP" id="EXPRESSCACHE_SEOEXP_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_SEOEXP', Configuration::get('EXPRESSCACHE_SEOEXP')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_SEOEXP_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                            <input type="radio" name="EXPRESSCACHE_SEOEXP" id="EXPRESSCACHE_SEOEXP_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_SEOEXP', Configuration::get('EXPRESSCACHE_SEOEXP')) ? 'checked="checked" ' : '') . '/>
                            <label class="t" for="EXPRESSCACHE_SEOEXP_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                            <p class="clear">' . $this->l('If a cache entry exist (even if timeout is over), serve the page to a search engine bot. Improves SEO.') . '</p>
                        </div>


                        <hr>
                        <!-- <p><label for="output">' . $this->l('Ignore URL variables') . '</label>
                         <input style="width: 40px; text-align: center" type="text" name="EXPRESSCACHE_timeout" value="' . Configuration::get('EXPRESSCACHE_TIMEOUT') . '"> minutes
                         </p>-->

                        <p><label for="output">' . $this->l('What to cache?') . '</label>
                            <textarea rows="5" cols="70" name="EXPRESSCACHE_CONTROLLERS">' . Configuration::get('EXPRESSCACHE_CONTROLLERS') . '</textarea>
                        </p>

                        <p><label for="output">' . $this->l('Ignore URL variables') . '</label>
                            <textarea rows="5" cols="70" name="EXPRESSCACHE_URLVARS">' . Configuration::get('EXPRESSCACHE_URLVARS') . '</textarea>
                        </p>

                        <!--<p><label for="output">' . $this->l('Store cache in filesystem ') . ' :</label>
                        <input type="checkbox" name="EXPRESSCACHE_store_in_db" 
                                    value="1" style="vertical-align: middle;" ' . (Configuration::get('EXPRESSCACHE_STORE_IN_DB') == 0 ? 'checked="checked"' : '') . ' /> page cache values are stored in database, by default. 
                        </p>-->
                        

                        <div class="margin-form">
                        <input type="submit" name="submitModule" value="' . $this->l('Update settings') . '" class="button" />
                        </div>
                </div>
                <div id="tab-activehooks" class="tab-content bootstrap">
                         
                        <div class="warn alert alert-warning">' . $this->l('Dynamic Hooks are executed even if the page is served from cache. 
                        This allows to show dynamic elements in a cached page.') . '</div>

                        <div class="warn alert alert-info">' . $this->l('CLEAR CACHE after you have changed any configuration below') . '</div>
                        ' . $this->showDynHooks() . '

                        

                                    
                        
                </div>
                
                <div id="tab-triggers" class="tab-content">

                    <label>' . $this->l('Refresh Cache on Product Updation') . '</label>
                    <div class="margin-form">
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_PRODUCT" id="EXPRESSCACHE_TRIGGER_PRODUCT_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_TRIGGER_PRODUCT', Configuration::get('EXPRESSCACHE_TRIGGER_PRODUCT')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_PRODUCT_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_PRODUCT" id="EXPRESSCACHE_TRIGGER_PRODUCT_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_TRIGGER_PRODUCT', Configuration::get('EXPRESSCACHE_TRIGGER_PRODUCT')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_PRODUCT_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                        <p class="clear">' . $this->l('Refreshes the corresponding cache if a product is updated or deleted') . '</p>
                    </div>
                    <div style="margin-left: 50px">
                    

                    <label>' . $this->l('Refresh Cache for Linked Categories') . '</label>
                    <div class="margin-form">
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_LINKED" id="EXPRESSCACHE_TRIGGER_LINKED_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_TRIGGER_LINKED', Configuration::get('EXPRESSCACHE_TRIGGER_LINKED')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_LINKED_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_LINKED" id="EXPRESSCACHE_TRIGGER_LINKED_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_TRIGGER_LINKED', Configuration::get('EXPRESSCACHE_TRIGGER_LINKED')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_LINKED_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                        <p class="clear">' . $this->l('Refreshes the categories cache when product is updated or deleted') . '</p>
                    </div>
                    </div>

                    <label>' . $this->l('Refresh Cache on Category Updation') . '</label>
                    <div class="margin-form">
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_CATEGORY" id="EXPRESSCACHE_TRIGGER_CATEGORY_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_TRIGGER_CATEGORY', Configuration::get('EXPRESSCACHE_TRIGGER_CATEGORY')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_CATEGORY_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_CATEGORY" id="EXPRESSCACHE_TRIGGER_CATEGORY_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_TRIGGER_CATEGORY', Configuration::get('EXPRESSCACHE_TRIGGER_CATEGORY')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_CATEGORY_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                        <p class="clear">' . $this->l('Refreshes the corresponding cache if a category is updated or deleted') . '</p>
                    </div>

                    <label>' . $this->l('Refresh Cache on Order Confirmation') . '</label>
                    <div class="margin-form">
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_ORDER" id="EXPRESSCACHE_TRIGGER_ORDER_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_TRIGGER_ORDER', Configuration::get('EXPRESSCACHE_TRIGGER_ORDER')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_ORDER_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_ORDER" id="EXPRESSCACHE_TRIGGER_ORDER_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_TRIGGER_ORDER', Configuration::get('EXPRESSCACHE_TRIGGER_ORDER')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_ORDER_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                        <p class="clear">' . $this->l('Refreshes the corresponding products cache when a order is confirmed') . '</p>
                    </div>

                    <label>' . $this->l('Refresh Home Page Cache') . '</label>
                    <div class="margin-form">
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_HOME" id="EXPRESSCACHE_TRIGGER_HOME_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_TRIGGER_HOME', Configuration::get('EXPRESSCACHE_TRIGGER_HOME')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_HOME_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_HOME" id="EXPRESSCACHE_TRIGGER_HOME_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_TRIGGER_HOME', Configuration::get('EXPRESSCACHE_TRIGGER_HOME')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_HOME_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                        <p class="clear">' . $this->l('Refreshes the home (index) page cache when a product / category / order / cms is updated or deleted') . '</p>
                    </div>

                    <label>' . $this->l('Refresh CMS Cache') . '</label>
                    <div class="margin-form">
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_CMS" id="EXPRESSCACHE_TRIGGER_CMS_on" value="1" ' . (Tools::getValue('EXPRESSCACHE_TRIGGER_CMS', Configuration::get('EXPRESSCACHE_TRIGGER_CMS')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_CMS_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
                        <input type="radio" name="EXPRESSCACHE_TRIGGER_CMS" id="EXPRESSCACHE_TRIGGER_CMS_off" value="0" ' . (!Tools::getValue('EXPRESSCACHE_TRIGGER_CMS', Configuration::get('EXPRESSCACHE_TRIGGER_CMS')) ? 'checked="checked" ' : '') . '/>
                        <label class="t" for="EXPRESSCACHE_TRIGGER_CMS_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
                        <p class="clear">' . $this->l('Refreshes the CMS page cache when a cms page is added, updated or deleted') . '</p>
                    </div>
                    
                    
                    


                    <div class="margin-form">
                        <input type="submit" name="submitModule" value="' . $this->l('Update settings') . '" class="button" />
                    </div>
                </div>

                <div id="tab-storage" class="tab-content">
                    <label for="output">' . $this->l('Cache storage limit') . '</label> 
                    <div class="margin-form">
                        
                        <input style="width: 40px; text-align: center" type="text" name="EXPRESSCACHE_STORAGE_LIMIT" value="' . Configuration::get('EXPRESSCACHE_STORAGE_LIMIT') . '"> MB
                        <p class="clear">' . $this->l('0 = No limit') . '</p>

                    </div>
                    <div class="margin-form">
                        <input type="submit" name="submitModule" value="' . $this->l('Update settings') . '" class="button" />
                    </div>
                    
                </div>

                <div id="tab-stats" class="tab-content">
                    
                    ' . $this->showStats(false) . '
                    
                </div>

                <div id="tab-cron" class="tab-content">
                    
                    '.$this->l('Clear all cache entries :').'<br>
                    <a href="'.$cron_url.'">'.$cron_url.'</a><br><br>
                    

                    
                </div>

            </div><!-- container -->
            </form>
        ' . "<script>
            function showTab(tab_id) {
                console.log(tab_id);
                // console.log('ul.tabs li[data-tab=\"' + tab_id + '\"]');
                var tab = $( 'ul.tabs li[data-tab=\"' + tab_id + '\"]' )[0];
                // console.log(tab);
                $(tab).trigger( 'click' );
            }

            function confirmCache() {
                return confirm('" . $this->l('Do you want to clear all cache entries?') . "');
            }
            $(document).ready(function(){
                $('ul.tabs li').click(function(){
                    var tab_id = $(this).attr('data-tab');

                    $('ul.tabs li').removeClass('current');
                    $('.tab-content').removeClass('current');

                    $(this).addClass('current');
                    $('#'+tab_id).addClass('current');
                });
            });
            </script>";
        //$this->context->cookie = $expresscache_cookie;
        return $html;
    }
    
    private function showDynHooks() {
        
        // if (Configuration::get('PS_HTML_THEME_COMPRESSION')) {
        //     return '<div class="error alert alert-danger">' . $this->l('You have enabled Minify HTML under Advance Parameters > Performance. This has disabled the support for Dynamic Hooks.') . '</div>';
        // }
        // var_dump(Cache::retrieve($cache_id));exit;
        Cache::clean('hook_module_list');
        $module_hooks = Hook::getHookModuleList();
        $html = '';
        $mod_hook_array = array();
        $modules = array();
        $activehooks = unserialize(Configuration::get('EXPRESSCACHE_ACTIVEHOOKS'));

        foreach ($module_hooks as $module_hook) {
            foreach ($module_hook as $m) {
                if (Module::isEnabled($m['name'])) {
                    $hook_name = Hook::getNameById($m['id_hook']);
                    //skip action based hooks since it Express Cache does hinder at that point.
                    if(strpos($hook_name, 'action') !== false || strpos($hook_name, 'action') === 0) {
                        continue;
                    }

                    //skip backoffice based hooks since it Express Cache does hinder at that point.
                    if(strpos($hook_name, 'displayAdminStats') !== false || strpos($hook_name, 'BackOffice') !== false) {
                        continue;
                    }


                    $checked = (isset($activehooks[$m['id_module']]) && in_array($hook_name, $activehooks[$m['id_module']])) ? ' checked' : '';
                    $mod_hook_array[$m['name']][] = '<span class="hook-name">
                        <input name="chk_activehook[]" type="checkbox" 
                            value="' . $m['id_module'] . '_' . $hook_name . '" ' . $checked . '> ' . $hook_name . '</span>';
                    $modules[$m['id_module']] = $m['name'];
                }
            }
        }
         
        //var_dump($mod_hook_array);
        //generate the HTML.
        $html = '<table class="table">';
        $html.= '<tr><th>' . $this->l('Module Name') . '</th><th>' . $this->l('Hooks') . '</th>';
        foreach ($mod_hook_array as $name => $hooks) {
            $html.= '<tr style="line-height:30px; ">';
            $all_hooks = implode(' ', $hooks);
            $html.= '<td >' . $name . '</td><td>' . $all_hooks . '</td>';
            $html.= '</tr>';
        }
        $html.= '</table>';
        $html.= '<div class="margin-form">
                        <input type="submit" name="submitModule" value="' . $this->l('Update settings') . '" class="button" />
                        </div>';
        return $html;
    }
    
    private function showStats($renderPartial) {
        
        $id_shop = (int)$this->context->shop->id;
        $where_shop = "";
        if ($id_shop) {
            $where_shop = " and id_shop = $id_shop ";
        }
        $html = '';
        //var_dump($this->context->shop);
        // $html .= $id_shop;
        $cache = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("
                        SELECT page_url, sum(hits) as hits, sum(miss) as miss, max(last_updated), is_mobile 
                        FROM " . _DB_PREFIX_ . "express_cache where (cache!='NULL' or cache_size>0 )
                        $where_shop group by page_url, is_mobile order by hits desc");
        
        // echo Db::getInstance()->getMsgError();exit;
        
        if (!$cache) {
            return $this->l('Cache is empty');
        }
        if (!$renderPartial) {
            $html .= '<input type="submit" name="clearStats" value="' . $this->l('Clear Stats') . '" class="button" />
                         ';
            
            $html.= '<input onclick="return refreshTheStats(); " type="submit" id="refreshStats" name="refreshStats" value="' . $this->l('Refresh Stats') . '" class="button" />
                        <br><br>';
        }
        $html.= '<table id="statsTable" class="table" style="width:90%;"><tr><th>' . $this->l('URL') . '</th><th>' . $this->l('Hits') . '</th><th>' . $this->l('Misses') . '</th></tr>';
        
        foreach ($cache as $c) {
            $html.= '<tr>';
            $html.= '<td>' . $c['page_url'] . ($c['is_mobile'] ? ' (Mobile)': '') .'</td> <td>' . $c['hits'] . '</td><td>' . $c['miss'] . '</td>';;
            $html.= '</tr>';
        }
        $html.= '</table>';
        if (!$renderPartial) {
            $html.= "<script>
                    function refreshTheStats() {
                        //alert(1);
                        $('#refreshStats').val('" . $this->l('Refreshing...') . "');
                        urlStats = addParamToURL('getStats', '1');
                        $.get(urlStats, function(data){
                            //alert(data);
                            $('#statsTable').html(data);
                            $('#refreshStats').val('" . $this->l('Refresh Stats') . "');
                        });
                        return false;
                    }

                    function addParamToURL(paramName, paramValue)
                    {
                        var url = window.location.href;
                        if (url.indexOf(paramName + '=') >= 0)
                        {
                            var prefix = url.substring(0, url.indexOf(paramName));
                            var suffix = url.substring(url.indexOf(paramName));
                            suffix = suffix.substring(suffix.indexOf('=') + 1);
                            suffix = (suffix.indexOf('&') >= 0) ? suffix.substring(suffix.indexOf('&')) : '';
                            url = prefix + paramName + '=' + paramValue + suffix;
                        }
                        else
                        {
                        if (url.indexOf('?') < 0)
                            url += '?' + paramName + '=' + paramValue;
                        else
                            url += '&' + paramName + '=' + paramValue;
                        }
                        return url;
                    }
                    </script>
                ";
        }
        return $html;
    }
    
    private function showHitPercentage() {
        
        // $html = '';
        $hits_miss = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("
                        SELECT sum(hits) as s_hits, sum(miss) as s_miss
                        FROM " . _DB_PREFIX_ . "express_cache where cache!='NULL'");
        if (($hits_miss['s_miss'] + $hits_miss['s_hits']) == 0) {
            return '0%';
        }
        
        $hitper = $hits_miss['s_hits'] / ($hits_miss['s_miss'] + $hits_miss['s_hits']);
        return round($hitper * 100, 2) . '%';
    }
    
    private function showTimeSaved() {
        $hits_miss = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("
                        SELECT sum(hits*hit_time) as s_hits, sum(hits*miss_time) as s_miss
                        FROM " . _DB_PREFIX_ . "express_cache where cache!='NULL'");
        
        $timesaved = round(abs($hits_miss['s_miss'] - $hits_miss['s_hits']), 2);
        return $this->secs_to_h($timesaved);
    }
    
    private function showSpaceUsed() {
        $cache = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("
                        SELECT sum(cache_size) as cache_size
                        FROM " . _DB_PREFIX_ . "express_cache");
        if ($cache['cache_size'] == NULL) {
            $cache['cache_size'] = 0;
        }
        $cache_size = $this->getSize($cache['cache_size']);
        
        return $cache_size;
    }
    
    private function getSize($bytes) {
        
        //$bytes = sprintf('%u', filesize($path));
        
        if ($bytes > 0) {
            $unit = intval(log($bytes, 1024));
            $units = array('B', 'KB', 'MB', 'GB');
            
            if (array_key_exists($unit, $units) === true) {
                return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }
        
        return $bytes;
    }
    
    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") $this->rrmdir($dir . "/" . $object);
                    else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
    
    private function secs_to_h($secs) {
        $units = array("yr" => 12 * 30 * 24 * 3600, "mo"=> 30 * 24 * 3600, "wk" => 7 * 24 * 3600, "days" => 24 * 3600, "hr" => 3600, "min" => 60, "s" => 1,);
        
        // specifically handle zero
        //if ( $secs == 0 ) return "0 s";
        if ($secs < 1) {
            return "$secs s";
        }
        $s = "";
        $plus = "";
        foreach ($units as $name => $divisor) {
            if ($quot = intval($secs / $divisor)) {
                if ($name != 's') {
                    $plus = "+";
                }
                
                $s.= "$quot$plus $name";
                $s.= (abs($quot) > 1 && $name != "s" ? "s" : "");
                 // . ", ";
                $secs-= $quot * $divisor;
                break;
            }
        }
        
        return substr($s, 0);
         //, -2);
        
    }
}
?>