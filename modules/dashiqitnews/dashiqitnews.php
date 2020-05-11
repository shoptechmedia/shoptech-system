<?php
/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class DashIqitNews extends Module
{
    protected static $colors = array('#1F77B4', '#FF7F0E', '#2CA02C');

    public function __construct()
    {
        $this->name = 'dashiqitnews';
        $this->tab = 'dashboard';
        $this->version = '1.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->push_filename = _PS_CACHE_DIR_ . 'push/activity';
        $this->allow_push = true;
        $this->push_time_limit = 180;

        parent::__construct();
        $this->displayName = $this->l('IQIT-COMMERCE news');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        return (parent::install()
            && $this->registerHook('dashboardZoneOne')
            && $this->updatePosition(Hook::getIdByName('dashboardZoneOne'), 0, 1)
        );
    }

    public function hookDashboardZoneOne($params)
    {
        $module = Module::getInstanceByName('themeeditor');
        if ($module instanceof Module) {

            $this->context->smarty->assign(
                array(
                    'current_version' => $module->version,
                )
            );
        }
        
        return $this->display(__FILE__, 'dashboard_zone_one.tpl');
    }

}
