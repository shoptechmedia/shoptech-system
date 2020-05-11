<?php
/**
 *   AmbJoliSearch Module : Search for prestashop
 *
 *    @author    Ambris Informatique
 *    @copyright Copyright (c) 2013-2015 Ambris Informatique SARL
 *    @license   Commercial license
 *    @module     Advanced search (AmbJoliSearch)
 *    @file        ambjolisearch.php
 *    @subject     upgrade to 2.1.5
 *    Support by mail: support@ambris.com
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_2_3_0($object)
{
    $result = true;

    /* Column managment for the module */
    if (version_compare(_PS_VERSION_, '1.6.0.2', '>=') && version_compare(_PS_VERSION_, '1.7', '<')) {
        $controllers = array('jolisearch');
        $themes = Theme::getThemes();
        $theme_meta_value = array();
        foreach ($controllers as $controller) {
            $page = 'module-' . $object->name . '-' . $controller;
            $tmp = Db::getInstance()->getValue('SELECT * FROM ' . _DB_PREFIX_ . 'meta WHERE page="' . pSQL($page) . '"');
            if ((int) $tmp > 0) {
                continue;
            }

            $meta = new Meta();
            $meta->page = $page;
            $meta->configurable = 1;
            $meta->save();
            if ((int) $meta->id > 0) {
                foreach ($themes as $theme) {
                    $theme_meta_value[] = array(
                        'id_theme' => $theme->id,
                        'id_meta' => $meta->id,
                        'left_column' => (int) $theme->default_left_column,
                        'right_column' => (int) $theme->default_right_column,
                    );
                }
            }
        }

        if (count($theme_meta_value) > 0) {
            try {
                $result = Db::getInstance()->insert('theme_meta', $theme_meta_value);
            } catch (Exception $e) {
                $result = false;
            }
        }
    }
    return $result;
}
