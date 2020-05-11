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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div id="iqitsizeguide-show" class="buttons_bottom_block additional_button">{l s='Size guide' mod='iqitsizeguide'}</div>
<div id="iqitsizeguide">
	<span class="cross" title="{l s='Close window' mod='iqitsizeguide'}"></span>
	<div class="iqitsizeguide-content">
		<span class="page-heading">{l s='Size guide' mod='iqitsizeguide'}</span>
		<ul class="nav nav-tabs">
			{if isset($guide->description) && isset($guide->description) !=''}
			<li class="active"><a href="#iqitsizeguide-guide"  title="{$guide->title} " data-toggle="tab">{$guide->title}</a></li>
			{if $sh_global}<li><a href="#iqitsizeguide-global"  title="{l s='Guide' mod='iqitsizeguide'}" data-toggle="tab">{l s='Guide' mod='iqitsizeguide'}</a></li>{/if}
			{else}
			{if $sh_global}<li class="active"><a href="#iqitsizeguide-global"  title="{l s='Guide' mod='iqitsizeguide'}" data-toggle="tab">{l s='Guide' mod='iqitsizeguide'}</a></li>{/if}
			{/if}
			{if $sh_measure}<li><a href="#iqitsizeguide-how"  title="{l s='How to measure' mod='iqitsizeguide'}" data-toggle="tab">{l s='How to measure' mod='iqitsizeguide'}</a></li>{/if}
		</ul>
		<div class="tab-content">
			

			{if isset($guide->description) && isset($guide->description) !=''}
			
			<div id="iqitsizeguide-guide"  class="tab-pane rte fade active in">
				{$guide->description} 
			</div>

			{if $sh_global}
			<div id="iqitsizeguide-global"  class="tab-pane rte fade">
				{$global|stripslashes}
			</div>

			{/if}
			{else}
			{if $sh_global}
			<div id="iqitsizeguide-global"  class="tab-pane rte fade active in">
				{$global|stripslashes}
			</div>
			{/if}
			{/if}

			{if $sh_measure}
			<div id="iqitsizeguide-how"  class="tab-pane rte fade">
				{$howto|stripslashes}
			</div>
			{/if}

		</div>

	</div>

</div> <!-- #layer_cart -->
<div id="iqitsizeguide-overlay"></div>
