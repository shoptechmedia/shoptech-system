<?php
class Hook extends HookCore
{
    
    
    
	public static function getNameById($hook_id) {
        $cache_id = 'hook_namebyid_' . $hook_id;
        if (!Cache::isStored($cache_id)) Cache::store($cache_id, Db::getInstance()->getValue('
                SELECT `name`
                FROM `' . _DB_PREFIX_ . 'hook`
                WHERE `id_hook` = ' . (int)$hook_id));
        return Cache::retrieve($cache_id);
    }
    
    
	public static function exec($hook_name, $hook_args = array(), $id_module = null, $array_return = false, $check_exceptions = true, $use_push = false, $id_shop = null) {
        
        if (!Module::isInstalled('n45xspeed') || !Module::isEnabled('n45xspeed')) {
            return parent::exec($hook_name, $hook_args, $id_module, $array_return, $check_exceptions, $use_push, $id_shop);
        }
        
        $activehooks = unserialize(Configuration::get('EXPRESSCACHE_ACTIVEHOOKS'));
        
        $found = false;
        if (is_array($activehooks)) {
            foreach ($activehooks as $hook_arr) {
                
                if (is_array($hook_arr) && in_array($hook_name, $hook_arr)) {
                    $found = true;
                    break;
                }
            }
        }
        
        if (!$found) {
            return parent::exec($hook_name, $hook_args, $id_module, $array_return, $check_exceptions, $use_push, $id_shop);
        }
        
        if (!$module_list = Hook::getHookModuleExecList($hook_name)) return '';
        
        if ($array_return) {
            $return = array();
        } 
        else {
            $return = '';
        }
        
        if (!$id_module) {
            foreach ($module_list as $m) {
                
                $data = parent::exec($hook_name, $hook_args, $m['id_module'], $array_return, $check_exceptions, $use_push, $id_shop);
                if (isset($data)) {
                    if (is_array($data)) {
                        $data = array_shift($data);
                    }
                    if (is_array($data)) {
                        $return[$m['module']] = $data;
                    } 
                    else {
                        $data_wrapped = '<!--[hook ' . $hook_name . '] ' . $m['id_module'] . '-->' . $data . '<!--[hook ' . $hook_name . '] ' . $m['id_module'] . '-->';
                        
                        if ($array_return) {
                            
                            $return[$m['module']] = $data_wrapped;
                        } 
                        else {
                            $return.= $data_wrapped;
                        }
                    }
                }
            }
        } 
        else {
            $return = parent::exec($hook_name, $hook_args, $id_module, $array_return, $check_exceptions, $use_push, $id_shop);
        }
        
        return $return;
    }
}
?>
