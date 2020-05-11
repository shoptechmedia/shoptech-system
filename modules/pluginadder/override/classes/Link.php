<?php
/*
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2015 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class Link extends LinkCore
{

    public function getRolloverImageLink($name, $id_product, $type = null)
    {
        if (!isset($id_product)) {
            return;
        }

        $cache_id = 'Link_getRolloverImageLink_' . (int) $id_product . '_' . $type;
        if (!Cache::isStored($cache_id)) {

            // Check if module is installed, enabled, customer is logged in and watermark logged option is on
            if (Configuration::get('WATERMARK_LOGGED') && (Module::isInstalled('watermark') && Module::isEnabled('watermark')) && isset(Context::getContext()->customer->id)) {
                $type .= '-' . Configuration::get('WATERMARK_HASH');
            }

            $id_image = Db::getInstance()->getRow('SELECT id_image FROM ' . _DB_PREFIX_ . 'image WHERE id_product = ' . $id_product . ' AND (cover = 0 or cover IS NULL) ORDER BY `position`');

            if (isset($id_image['id_image']) && $id_image['id_image']) {
                $id_image = $id_image['id_image'];

                $theme = ((Shop::isFeatureActive() && file_exists(_PS_PROD_IMG_DIR_ . Image::getImgFolderStatic($id_image) . $id_image . ($type ? '-' . $type : '') . '-' . (int) Context::getContext()->shop->id_theme . '.jpg')) ? '-' . Context::getContext()->shop->id_theme : '');
                if ($this->allow == 1) {
                    $uri_path = __PS_BASE_URI__ . $id_image . ($type ? '-' . $type : '') . $theme . '/' . $name . '.jpg';
                } else {
                    $uri_path = _THEME_PROD_DIR_ . Image::getImgFolderStatic($id_image) . $id_image . ($type ? '-' . $type : '') . $theme . '.jpg';
                }
                $ret = $this->protocol_content . Tools::getMediaServer($uri_path) . $uri_path;
                Cache::store($cache_id, $ret);
                return $ret;

            } else {
                Cache::store($cache_id, null);
                return;
            }

        }
        return Cache::retrieve($cache_id);

    }
}
