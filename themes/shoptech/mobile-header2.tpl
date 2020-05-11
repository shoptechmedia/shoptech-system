{*
    * 2007-2014 PrestaShop
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
    *  @author PrestaShop SA <contact@prestashop.com>
    *  @copyright  2007-2014 PrestaShop SA
    *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
    *  International Registered Trademark & Property of PrestaShop SA
    *}
    <div id="mh-sticky" class="not-sticked">
        <div class="mobile-main-wrapper">
        <div class="mobile-main-bar">

            <div class="mobile-h-logo">
                <a href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{$shop_name|escape:'html':'UTF-8'}">
                    <img class="logo img-responsive replace-2xlogo" src="{$logo_url}" {if isset($warehouse_vars.retina_logo) and $warehouse_vars.retina_logo}data-retinalogo="{$warehouse_vars.retina_logo}" {/if} {if isset($logo_image_width) && $logo_image_width} width="{$logo_image_width}"{/if}{if isset($logo_image_height) && $logo_image_height} height="{$logo_image_height}"{/if} alt="{$shop_name|escape:'html':'UTF-8'}" />
                </a>
            </div>
            <div  class="mh-button mh-search">
                <span id="mh-search" data-mh-search="1"><i class="icon-search mh-icon"></i></span> 
            </div>
            <div  class="mh-button mh-user"> 
                <span id="mh-user"><i class="icon-user mh-icon "></i></span>
                {include file="$tpl_dir./mobile-user.tpl"}
            </div>
            {if !$PS_CATALOG_MODE}
            <div id="mh-cart-wrapper" class="mh-button mh-cart"> 
                <span id="mh-cart">
                    <i class="icon-shopping-cart mh-icon "></i>
                </span>
            </div>
            {/if}
            <div class="mh-button mh-menu">
                <span id="mh-menu"><i class="icon-reorder mh-icon"></i></span>
            </div>

        </div>
        </div>

        <div class="mh-dropdowns">
            <div class="mh-drop mh-search-drop">
                    {hook h='iqitMobileSearch'}
            </div>
        </div>

    </div>
