<?php

if (!defined('_PS_VERSION_'))
    exit;


/**
 * Copyright (C) 2015 Christian Jensen
 *
 * This file is part of PiwikAnalyticsJS for prestashop.
 * 
 * PiwikAnalyticsJS for prestashop is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * PiwikAnalyticsJS for prestashop is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with PiwikAnalyticsJS for prestashop.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @author Christian M. Jensen
 * @link http://cmjnisse.github.io/piwikanalyticsjs-prestashop
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * 
 * 
 * Used for Prestashop version
 *  - 1.5.0.5
 *  - 1.5.0.13
 */
class PiwikAnalytics15Controller extends ModuleAdminController {

    public function __construct() {
        parent::__construct();
        $this->action = 'view';
        $this->display = 'content';
        $this->template = 'content.tpl';
        $this->tpl_folder = _PS_ROOT_DIR_ . '/modules/piwikanalyticsjs/views/templates/admin/';
    }

    public function initToolbar() {
        /* remove toolbar */
    }

    public function init() {
        if (Tools::getValue('ajax'))
            $this->ajax = '1';

        /* Server Params */
        $protocol_link = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
        $protocol_content = (isset($useSSL) && $useSSL && Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
        $this->context->link = new Link($protocol_link, $protocol_content);

        $this->timerStart = microtime(true);

        

        $http = ((bool) Configuration::get('PIWIK_CRHTTPS') ? 'https://' : 'http://');
        $PIWIK_HOST = Configuration::get('PIWIK_HOST');
        $PIWIK_SITEID = (int) Configuration::get('PIWIK_SITEID');

        $this->context->smarty->assign('help_link', 'https://github.com/cmjnisse/piwikanalyticsjs-prestashop/wiki');
        // PKHelper::CPREFIX . 'USRNAME'
        $user = Configuration::get('PIWIK_USRNAME');
        // PKHelper::CPREFIX . 'USRPASSWD'
        $passwd = Configuration::get('PIWIK_USRPASSWD');
        if ((!empty($user) && $user !== FALSE) && (!empty($passwd) && $passwd !== FALSE)) {
            $this->page_header_toolbar_btn['stats'] = array(
                'href' => $http . $PIWIK_HOST . 'index.php?module=Login&action=logme&login=' . $user . '&password=' . md5($passwd) . '&idSite=' . $PIWIK_SITEID,
                'desc' => $this->l('Piwik'),
                'target' => true
            );
        } else {
            $this->page_header_toolbar_btn['stats'] = array(
                'href' => $http . $PIWIK_HOST . 'index.php',
                'desc' => $this->l('Piwik'),
                'target' => true
            );
        }
        
            // Some controllers use the view action without an object
            if ($this->className)
                $this->loadObject(true);


            $PIWIK_TOKEN_AUTH = Configuration::get('PIWIK_TOKEN_AUTH');
            if ((empty($PIWIK_HOST) || $PIWIK_HOST === FALSE) ||
                    ($PIWIK_SITEID <= 0 || $PIWIK_SITEID === FALSE) ||
                    (empty($PIWIK_TOKEN_AUTH) || $PIWIK_TOKEN_AUTH === FALSE)) {

                $this->content .= "<h3 style=\"padding: 90px;\">{$this->l("You need to set 'Piwik host url', 'Piwik token auth' and 'Piwik site id', and save them before the dashboard can be shown here")}</h3>";
            } else {
                $this->content .= <<< EOF
<script type="text/javascript">
  function WidgetizeiframeDashboardLoaded() {
      var w = $('#content').width();
      var h = $('body').height();
      $('#WidgetizeiframeDashboard').width('100%');
      $('#WidgetizeiframeDashboard').height(h);
  }
</script>   
EOF;
                $lng = new LanguageCore($this->context->cookie->id_lang);

                if (_PS_VERSION_ < '1.6')
                    $this->content .= '<h3><a target="_blank" href="' . $this->page_header_toolbar_btn['stats']['href'] . '">' . $this->page_header_toolbar_btn['stats']['desc'] . '</a> | <a target="_blank" href="https://github.com/cmjnisse/piwikanalyticsjs-prestashop/wiki">' . $this->l('Help') . '</a></h3>';

                $DREPDATE = Configuration::get('PIWIK_DREPDATE');
                if ($DREPDATE !== FALSE && (strpos($DREPDATE, '|') !== FALSE)) {
                    list($period, $date) = explode('|', $DREPDATE);
                } else {
                    $period = "day";
                    $date = "today";
                }
                $this->content .= ''
                        . '<iframe id="WidgetizeiframeDashboard"  onload="WidgetizeiframeDashboardLoaded();" '
                        . 'src="' . $http
                        . $PIWIK_HOST . 'index.php'
                        . '?module=Widgetize'
                        . '&action=iframe'
                        . '&moduleToWidgetize=Dashboard'
                        . '&actionToWidgetize=index'
                        . '&idSite=' . $PIWIK_SITEID
                        . '&period=' . $period
                        . '&token_auth=' . $PIWIK_TOKEN_AUTH
                        . '&language=' . $lng->iso_code
                        . '&date=' . $date
                        . '" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="550px"></iframe>';
            }

        $this->context->smarty->assign(array(
            'content' => $this->content,
            'show_page_header_toolbar' => (isset($this->show_page_header_toolbar) ? $this->show_page_header_toolbar : ''),
            'page_header_toolbar_title' => (isset($this->page_header_toolbar_title) ? $this->page_header_toolbar_title : ''),
            'page_header_toolbar_btn' => (isset($this->page_header_toolbar_btn) ? $this->page_header_toolbar_btn : ''),
        ));
    }

}