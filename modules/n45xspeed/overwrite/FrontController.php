<?php

$then = microtime(true);

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $proto = 'https' . ':' . '/' . '/';
} else {
    $proto = 'http' . ':' . '/' . '/';
}

if(version_compare(_PS_VERSION_, '1.6.0.0', '>=') && version_compare(_PS_VERSION_, '1.6.0.6', '<=')) {

    if (is_array($content))
        foreach ($content as $tpl)
            $html = $this->context->smarty->fetch($tpl);
    else
        $html = $this->context->smarty->fetch($content);

    $html = trim($html);

    if ($this->controller_type == 'front' && !empty($html) && $this->getLayout())
    {
        $dom_available = extension_loaded('dom') ? true : false;
        if ($dom_available)
            $html = Media::deferInlineScripts($html);
        $html = trim(str_replace(array('</body>', '</html>'), '', $html))."\n";
        $this->context->smarty->assign(array(
            'js_def' => Media::getJsDef(),
            'js_files' => array_unique($this->js_files),
            'js_inline' => $dom_available ? Media::getInlineScript() : array()
        ));
        $javascript = $this->context->smarty->fetch(_PS_ALL_THEMES_DIR_.'javascript.tpl');
        $template = $html.$javascript."\t</body>\n</html>";
    }
    else
        $template = $html;

} elseif (version_compare(_PS_VERSION_, '1.6.0.7', '>=')) {
    
    $html = '';
    $js_tag = 'js_def';
    $this->context->smarty->assign($js_tag, $js_tag);

    if (is_array($content)) {
        foreach ($content as $tpl) {
            $html .= $this->context->smarty->fetch($tpl);
        }
    } else {
        $html = $this->context->smarty->fetch($content);
    }

    $html = trim($html);

    if (in_array($this->controller_type, array('front', 'modulefront')) && !empty($html) && $this->getLayout()) {
        $live_edit_content = '';
        
        $dom_available = extension_loaded('dom') ? true : false;
        $defer = (bool)Configuration::get('PS_JS_DEFER');
        
        if ($defer && $dom_available) $html = Media::deferInlineScripts($html);
        $html = trim(str_replace(array('</body>', '</html>'), '', $html)) . "\n";
        
        $this->context->smarty->assign(array($js_tag => Media::getJsDef(), 'js_files' => $defer ? array_unique($this->js_files) : array(), 'js_inline' => ($defer && $dom_available) ? Media::getInlineScript() : array()));
        
        $javascript = $this->context->smarty->fetch(_PS_ALL_THEMES_DIR_ . 'javascript.tpl');
        
        if ($defer && (!isset($this->ajax) || ! $this->ajax)) {
            $template = $html.$javascript;
        } else {
            $template = preg_replace('/(?<!\$)'.$js_tag.'/', $javascript, $html);
        }

        $template .= $live_edit_content.((!isset($this->ajax) || ! $this->ajax) ? '</body></html>' : '');

                    } 
    else {
        $template = $html;
    }
}
else {
    $template = $this->context->smarty->fetch($content, null, null, null);
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$isLogged = isset($this->context->customer) ? $this->context->customer->isLogged() && Configuration::get('EXPRESSCACHE_LOGGEDIN_SKIP') : false;

$isMobile = !Configuration::get('EXPRESSCACHE_MOBILE') && $this->context->getMobileDevice() ? 1 : 0;        

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $proto = 'https' . ':' . '/' . '/';
} 
else {
    $proto = 'http' . ':' . '/' . '/';
}

$ignore_params_1 = array('refresh_cache', 'no_cache');
$ignore_params = Configuration::get('EXPRESSCACHE_URLVARS');
$ignore_params = explode(',', $ignore_params);
$ignore_params = array_merge($ignore_params, $ignore_params_1);

list($urlpart, $qspart) = array_pad(explode('?', $_SERVER['REQUEST_URI']), 2, '');
parse_str($qspart, $query);
foreach ($ignore_params as $i_param) {
    $i_param = trim($i_param);
    unset($query[$i_param]);
}

$queryString = http_build_query($query);
if ($queryString == '') {
    $url = $proto . $_SERVER['HTTP_HOST'] . $urlpart;
} 
else {
    $url = $proto . $_SERVER['HTTP_HOST'] . $urlpart . '?' . $queryString;
}

$cache_processed = false;

// $template = str_replace(array("\n", "\t"), '', $template);
$template = str_replace('http://', $proto, $template);

if(isset($_REQUEST['get_all_links'])){
    $re = '/<a(.*?)href="(.*?)"/s';

    preg_match_all($re, $template, $matches);

    echo json_encode($matches[2]);

    exit;
}

$cookie = new Cookie('psAdmin');

if (isset($_POST['rebuildCache']) || $cookie->id_employee){
    if (!isset($_GET['no_cache']) && !$isLogged && !Tools::isSubmit('submitNewsletter')) {
        $page_name = Dispatcher::getInstance()->getController();
        $c_controllers = explode(',', Configuration::get('EXPRESSCACHE_CONTROLLERS'));

        if (in_array($page_name, $c_controllers) && !isset($_GET['live_edit']) && !isset($_GET['live_configurator_token'])) {
            $page_id = md5($url);
            $page_url = $url;
            $id_langauge = (int)$this->context->language->id;
            $id_currency = (int)$this->context->currency->id;
            $id_country = (int)$this->context->country->id;
            $id_shop = (int)$this->context->shop->id;
            $entity_type = $page_name;

            $template = str_replace('> <', '><', $template);

            $entity_type_ids = array('id_product', 'id_category', 'id_manufacturer', 'id_cms', 'id_supplier');
            $id_entity = 0;

            foreach ($entity_type_ids as $entity_type_id) {
                 if(Tools::getValue($entity_type_id, 0)) {
                    $id_entity = Tools::getValue($entity_type_id);
                    break;
                 }
            }

            /*if (count($_POST) > 1) {
                Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("
                        UPDATE " . _DB_PREFIX_ . "express_cache set cache='NULL'
                        WHERE page_id = '" . $page_id . "' and id_language = " . $id_langauge . " and id_currency = " . $id_currency . " and id_country = " . $id_country . " and id_shop = " . $id_shop);
            } else {*/

                if (1 || !Configuration::get('EXPRESSCACHE_STORE_IN_DB')) {

                    if (Configuration::get('EXPRESSCACHE_STORAGE_LIMIT') > 0) {

                        $cache_db = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("
                                            SELECT sum(cache_size) as cache_size
                                            FROM " . _DB_PREFIX_ . "express_cache");
                        if ($cache_db['cache_size'] == NULL) {
                            $cache_db['cache_size'] = 0;
                        }

                        $cache_size = $cache_db['cache_size'];
                        
                        if ($cache_size > 0) {
                            
                            $cache_size = round($cache_db['cache_size'] / (1024 * 1024), 2);
                            if ($cache_size > Configuration::get('EXPRESSCACHE_STORAGE_LIMIT')) {
                                $last_cache = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT page_id, last_updated, cache FROM 
                                            " . _DB_PREFIX_ . "express_cache WHERE cache != 'NULL' ORDER BY last_updated");
                                
                                $del_page_id = $last_cache['page_id'];
                                $del_last_updated = $last_cache['last_updated'];
                                $file_to_delete = $last_cache['cache'];
                                Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("UPDATE " . _DB_PREFIX_ . "express_cache
                                            set cache='NULL', cache_size = 0 
                                            where page_id = '$del_page_id' and last_updated = '$del_last_updated'");
                                $cache_dir = _PS_MODULE_DIR_ . 'n45xspeed/cache/';
                                if(Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
                                    $cache_dir .= $id_shop.'/';
                                }
                                $dir_name = substr($file_to_delete, 0, 2);
                                $dir_name = substr($dir_name, 0, 1) . '/' . substr($dir_name, 1, 2) . '/';
                                unlink($cache_dir . $dir_name . $file_to_delete);
                            }
                        }
                    }
                    
                    $cache = $template;
                    
                    $filename = $page_id . $id_currency . $id_langauge . $id_country . $id_shop . $isMobile;
                    $cache_dir = _PS_MODULE_DIR_ . 'n45xspeed/cache/';
                    if(Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
                        $cache_dir .= $id_shop.'/';
                    }

                    $dir_name = substr($filename, 0, 2);
                    $dir_name = substr($dir_name, 0, 1) . '/' . substr($dir_name, 1, 2) . '/';

                    if (!file_exists($cache_dir . $dir_name)) {
                        mkdir($cache_dir . $dir_name, 0777, true);
                    }

                    if (Configuration::get('EXPRESSCACHE_GZIP')) {
                        $cache = gzdeflate($cache);
                    }

                    $cache_size = strlen($cache);

                    file_put_contents($cache_dir . $dir_name . $filename, $cache, LOCK_EX);
                    $cache = $filename;
                } else {
                    $cache_size = strlen($cache);
                    $cache = addslashes($template);
                }

                $now = microtime(true);
                $cache_time = round($now - ($this->express_start_time), 3);
                $cache_processed = true;

                Db::getInstance()->execute("INSERT INTO " . _DB_PREFIX_ . "express_cache 
                                        (page_id, page_url, id_currency, id_language, id_country, id_shop, 
                                            cache, cache_size, hits, miss, hit_time,
                                             miss_time, entity_type, id_entity, is_mobile, last_updated)
                                        VALUES ('$page_id', '$page_url', $id_currency, 
                                         $id_langauge, $id_country, $id_shop,'$cache', $cache_size,
                                         0, 1, 0, $cache_time, '$entity_type', $id_entity, $isMobile,
                                         '" . gmdate('Y-m-d H:i:s') . "')
                                         ON DUPLICATE KEY UPDATE miss = miss + 1,
                                                     last_updated ='" . gmdate('Y-m-d H:i:s') . "',
                                                     cache = '$cache', cache_size = $cache_size,
                                                     miss_time = ((miss_time*miss) + $cache_time) / (miss + 1)
                                        ");
            //}
        }
    }
}

if (isset($_POST['rebuildCache'])){
    echo $cache_processed;
    exit;
}

$html = $template;
$content = $html;

if (Configuration::get('ADVCACHEMGMT') && !Tools::getValue('live_edit', 0)) {
    if (!isset($cache_time)) {
        $now = microtime(true);
        $cache_time = round($now - ($this->express_start_time), 3);
    }

    $height = 'auto';
    $background_color = 'black';
    if (version_compare(_PS_VERSION_, '1.6.0', '>=')) {
        $height = 'auto';
        $background_color = 'rgb(52, 52, 52)';
    }

    $content.= '<div id="expresscache_liveeditor" style="display:none; background-color:000; background-color: rgba(0,0,0, 0.7); border-bottom: 1px solid #000; width:276px;height:' . $height . '; padding:10px; position:fixed;bottom:0;left:0;z-index:9999;">';
    $content.= '<span style="position: absolute;top: -38px;right: 0;background-color: rgba(0,0,0,0.7);padding: 10px 15px;cursor:pointer" class="donwuphideshow">&#5167;</span>';
    $content.= '<span style="color:red; float:left; padding: 8px; background-color: ' . $background_color . '; margin-left:10px; margin-bottom:10px">Ikke-cached side</span>';
    $content.= '<span style="color:white; float:left; padding: 8px; background-color: ' . $background_color . '; margin-left:10px; margin-bottom:10px">Load tid: ' . $cache_time . ' s</span>';

    if ($cache_processed) {
        $content.= '<input onclick="window.location.href=\'' . $url . '\'" type="submit" value="View Cached Page" name="no_cache" id="viewLivePage" class="exclusive" style="float: left;color:black; text-shadow: 0 -1px 0 #157402; margin-left:10px;">';
    } else {
        $content.= '<span style="float: left;color:white;padding: 8px; background-color: ' . $background_color . '; margin-left:10px;">Denne side er ikke cached endnu</span>';
    }

    $content.= '</div>';
}

$this->context->cookie->write();

echo $content;
