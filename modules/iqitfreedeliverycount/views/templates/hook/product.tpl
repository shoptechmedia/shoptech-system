{*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="iqitfreedeliverycount iqitfreedeliverycount-product clearfix {if $free_ship_remaining <= 0}hidden{/if}">
<div clas="fd-table">
<div class="ifdc-icon fd-table-cell"><i class="icon icon-truck"></i></div>

<div class="ifdc-remaining  fd-table-cell">{l s='Spend' mod='iqitfreedeliverycount'} <span class="ifdc-remaining-price">{convertPrice price=$free_ship_remaining|floatval}</span> {l s='more and get Free Shipping!' mod='iqitfreedeliverycount'}</div></div>
{if isset($txt) && $txt != ''}<div class="ifdc-txt"><div class="ifdc-txt-content">{$txt nofilter}</div></div>{/if} {* HTML, cannot escape*}
</div>


