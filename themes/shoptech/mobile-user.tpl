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

    <div class="mh-drop">
        {if $is_logged}
        <p>{l s='Hi'} {$cookie->customer_firstname} {$cookie->customer_lastname}</p>
        <ul>
            <li><a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='Manage my customer account'}" rel="nofollow">{l s='My account'}</a></li>
            <li><a href="{$link->getPageLink('index')}?mylogout" title="{l s='Sign out'}" rel="nofollow">{l s='Sign out'}</a></li>
        </ul>
        {else}
        <p>{l s='Please login or create account'}</p>
        <ul>
            <li><a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='Log in'}" rel="nofollow">{l s='Log in/Create account'}</a></li>

        </ul>
        {/if}
    </div>
