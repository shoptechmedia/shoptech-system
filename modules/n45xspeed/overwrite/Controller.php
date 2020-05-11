<?php

$then = microtime(true);

$cache = false;
$page_name = Dispatcher::getInstance()->getController();
$c_controllers = explode(',', Configuration::get('EXPRESSCACHE_CONTROLLERS'));
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$isLogged = isset($this->context->customer) ? $this->context->customer->isLogged() && Configuration::get('EXPRESSCACHE_LOGGEDIN_SKIP') : false;
$isMobile = !Configuration::get('EXPRESSCACHE_MOBILE') && $this->context->getMobileDevice() ? 1 : 0;

if(isset($_GET['getCacheTime488'])){
    $isAjax = false;
    $isMobile = 0;
}

$cache_row = false;
if (in_array($page_name, $c_controllers) && !isset($_POST['rebuildCache']) && !isset($_GET['refresh_cache']) && !isset($_GET['live_edit']) && !isset($_GET['no_cache']) && count($_POST) == 0 && !$isAjax && !$isLogged) {
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $proto = 'https' . ':' . '/' . '/';
    } else {
        $proto = 'http' . ':' . '/' . '/';
    }

    list($urlpart, $qspart) = array_pad(explode('?', $_SERVER['REQUEST_URI']), 2, '');

    parse_str($qspart, $query);

    $ignore_params = Configuration::get('EXPRESSCACHE_URLVARS');

    $ignore_params = explode(',', $ignore_params);

    foreach ($ignore_params as $i_param) {
        $i_param = trim($i_param);
        unset($query[$i_param]);
    }

    $queryString = http_build_query($query);
    if ($queryString == '') {
        $url = $proto . $_SERVER['HTTP_HOST'] . $urlpart;
    } else {
        $url = $proto . $_SERVER['HTTP_HOST'] . $urlpart . '?' . $queryString;
    }
    if(isset($_GET['getCacheTime488'])){
        $url = $proto . $_SERVER['HTTP_HOST'] . $urlpart;
    }

    $page_id = md5($url);
    $context = Context::getContext();
    
    $id_langauge = (int)$this->context->language->id;
    $id_country = (int)$this->context->country->id;
    $id_shop = (int)$this->context->shop->id;

    $this->context->cookie->id_currency = $this->context->country->id_currency;
    $currency = Tools::setCurrency($this->context->cookie);
    $id_currency = $currency->id;

    $cache_row = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("
                SELECT id_express_cache, cache, hits, miss, last_updated
                FROM " . _DB_PREFIX_ . "express_cache 
                WHERE page_id = '" . $page_id . "' and id_language = " . $id_langauge . " and id_currency = " . $id_currency . " and id_country = " . $id_country . " and id_shop = " . $id_shop . " and is_mobile = " . $isMobile);

    if ($cache_row != false) {                
        if ($cache_row[0]['cache'] != 'NULL') {
            $filename = $cache_row[0]['cache'];
            $cache_dir = _PS_MODULE_DIR_ . 'n45xspeed/cache/';
            if(Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
                $cache_dir .= $id_shop.'/';
            }
            $dir_name = substr($filename, 0, 2);
            $dir_name = substr($dir_name, 0, 1) . '/' . substr($dir_name, 1, 2) . '/';
            $cache_file = $cache_dir . $dir_name . $filename;
            if(file_exists($cache_file)) {
                $content = file_get_contents($cache_file);
                $last_updated = strtotime($cache_row[0]['last_updated']);
                $now = strtotime(gmdate('Y-m-d H:i:s'));
            } else {
                $cache_row = false;
            }
        } else {
            $cache_row = false;
        }
    }
}

if(isset($_GET['getCacheTime488'])){
    if(!$cache_row){
        echo 'Not Cached';
        exit;
    }
}

if ($cache_row) {
    $this->init();

    $this->context->cookie->write();
    if (Configuration::get('EXPRESSCACHE_GZIP') || !strstr($content, 'body')) {
        $content = gzinflate($content);
    }

    if($content == ''){
        $this->express_start_time = microtime(true);

        $display = parent::run();

        return;
    }

    $activehooks = unserialize(Configuration::get('EXPRESSCACHE_ACTIVEHOOKS'));

    if (is_array($activehooks)) {
         unset($activehooks[280]);

        foreach ($activehooks as $id_module => $hook_array) {
            if (is_array($hook_array)) {
                foreach ($hook_array as $hook_name) {
                    $hook_content = Hook::exec($hook_name, array(), $id_module, false, true, false, null);
                    $pattern = "/<!--\[hook $hook_name\] $id_module-->(.|\n)*?<!--\[hook $hook_name\] $id_module-->/";

                    $p_content = preg_replace($pattern, $hook_content, $content);

                    if(preg_last_error() === PREG_NO_ERROR){
                        $content = $p_content;
                    }

                    $p_content = preg_replace($pattern, $hook_content, $content);
                    if(preg_last_error() === PREG_NO_ERROR) {
                        $content = $p_content;
                    }
                }
            }
        }
    }

    if(isset($_REQUEST['get_all_links'])){
        $re = '/<a(.*?)href="(.*?)"/s';

        preg_match_all($re, $template, $matches);

        echo json_encode($matches[2]);

        exit;
    }

    $now = microtime(true);
    $id_express_cache = $cache_row[0]['id_express_cache'];
    $cache_time = round($now - $then, 3);

    if(isset($_GET['getCacheTime488'])){
        echo $cache_time;
        exit;
    }

    Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("
                    UPDATE " . _DB_PREFIX_ . "express_cache set hits = hits + 1, 
                    hit_time = ((hit_time*hits) + $cache_time) / (hits + 1)
                    WHERE id_express_cache = '" . $id_express_cache . "'");

    $cookie = new Cookie('psAdmin');
    if (Configuration::get('ADVCACHEMGMT') && $cookie->id_employee) {
        $hits = $cache_row[0]['hits'];
        $miss = $cache_row[0]['miss'];
        $last_updated = $cache_row[0]['last_updated'];
        $last_updated = round((time() - date('Z') - strtotime($last_updated)) / 60, 2);
        $height = 'auto';
        $background_color = 'black';
        if (version_compare(_PS_VERSION_, '1.6.0', '>=')) {
            $height = 'auto';
            $background_color = 'rgb(52, 52, 52)';
        }

        $content .= '<div id="expresscache_liveeditor" style="display:none;background-color:000; background-color: rgba(0,0,0, 0.7); border-bottom: 1px solid #000; width:276px;height:' . $height . '; padding:10px; position:fixed;bottom:0;left:0;z-index:9999;">';
        $content.= '<span style="position: absolute;top: -38px;right: 0;background-color: rgba(0,0,0,0.7);padding: 10px 15px;cursor:pointer;" class="donwuphideshow">&#5167;</span>';
        $content .= '<span style="color:lightgreen; float:left; padding: 8px; background-color: ' . $background_color . '; margin-left:10px; margin-bottom:10px">Cached Side</span>';
        $content .= '<span style="color:white; float:left; padding: 8px; background-color: ' . $background_color . '; margin-left:10px; margin-bottom:10px">Load tid: ' . $cache_time . ' s</span>';
        $content .= '<span style="color:white; float:left; padding: 8px; background-color: ' . $background_color . '; margin-left:10px; margin-bottom:10px">Opdateret: ' . $last_updated . ' mins ago</span>';
        $content .= '<span style="color:white; float:left; padding: 8px; background-color: ' . $background_color . '; margin-left:10px; margin-bottom:10px">Hits: ' . $hits . '</span>';
        $content .= '<span style="color:white; float:left; padding: 8px; background-color: ' . $background_color . '; margin-left:10px; margin-bottom:10px">Missede: ' . $miss . '</span>';
        $content .= "<form method='GET' style='float:left;margin-left:10px;'><input type='submit' name = 'refresh_cache' value='" . 'Genstart cache' . "' id='refreshCache' class='button' style='background: #333 none; color:#fff; border:1px solid #000; float:right; margin-right:20px;'>";
        $content .= '<input type="submit" value="Vis uden cache" name="no_cache" id="viewLivePage" class="exclusive" style="color:black;float:right; text-shadow: 0 -1px 0 #157402; margin-right:10px;">';
        $parts = parse_url($_SERVER['REQUEST_URI']);
        if (isset($parts['query'])) {
            
            parse_str($parts['query'], $query);

            foreach ($query as $key => $val) {
                $content.= '<input type="hidden" value="' . Tools::getValue($key) . '" name="' . $key . '">';
            }
        }

        $content.= '</form></div>';
    }

    if (Configuration::get('PS_TOKEN_ENABLE')) {
        $new_token = Tools::getToken(false);
        if(preg_match("/static_token[ ]?=[ ]?'([a-f0-9]{32})'/", $content, $matches)) {
            if(count($matches) > 1 && $matches[1] != '') {
                $old_token = $matches[1];
                $content = preg_replace("/$old_token/", $new_token, $content);
            }
        } else {
            $content = preg_replace('/name="token" value="[a-f0-9]{32}/', 'name="token" value="'.$new_token, $content);
            $content = preg_replace('/token=[a-f0-9]{32}"/', 'token='.$new_token.'"', $content);
            $content = preg_replace('/static_token[ ]?=[ ]?\'[a-f0-9]{32}/', 'static_token = \''.$new_token, $content);
        }
    }

    $serverUrl = '/' . '/' . $_SERVER['SERVER_NAME'];

    //$content = str_replace('</head>', '<link rel="dns-prefetch" href="' . $serverUrl . '"></head>', $content);

    echo $content;
} else {
    $this->express_start_time = microtime(true);

    $display = parent::run();
}