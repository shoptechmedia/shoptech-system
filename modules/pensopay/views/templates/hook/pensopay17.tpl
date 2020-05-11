{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}

{if $imgs|@count gt 2}
<p class="payment_module pensopay imgf">
{else}
<p class="payment_module pensopay">
{/if}
{foreach from=$imgs item=img}
            <img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/{$img|escape:'htmlall':'UTF-8'}.png" alt="{l s='Pay with credit cards ' mod='pensopay'}" />
{/foreach}

{if isset($type) and $type eq 'viabill' and isset($cart)}
	<div class="viabill-pricetag" data-view="payment" data-price="{$cart.totals.total.amount|escape:'htmlall':'UTF-8'}"></div>
{/if}

{if $fees|@count gt 0}
<span style="display:table">
{foreach from=$fees item=fee}
	<span style="display:table-row">
		<span style="display:table-cell">
			<i>
				{$fee.name|escape:'htmlall':'UTF-8'}
			</i>
		</span>
		<span style="display:table-cell">
				{$fee.amount|escape:'htmlall':'UTF-8'}
		</span>
	</span>
{/foreach}
</span>
{/if}
</p>
