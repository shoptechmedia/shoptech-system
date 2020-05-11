{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}
{if isset($onepagecheckout) AND $onepagecheckout}
	<script type="text/javascript">
		var myEv = {
			stopImmediatePropagation: function() {
				return true;
			},
			target: false
		};
	</script>
{/if}

<form action="{$payment_url|escape:'javascript':'UTF-8'}" method="post" id="pensopay{$type|escape:'htmlall':'UTF-8'}">
{foreach from=$fields item=field}
	<input type="hidden" name="{$field.name|escape:'htmlall':'UTF-8'}" value="{$field.value|escape:'htmlall':'UTF-8'}" />
{/foreach}
</form>
{if $imgs|@count gt 2}
<p class="payment_module pensopay imgf">
{else}
<p class="payment_module pensopay">
{/if}
{if !$no_print_link}
	{if isset($onepagecheckout) AND $onepagecheckout}
		<a name="pensopay{$type|escape:'htmlall':'UTF-8'}" style="height:auto" href="javascript:myEv.target=document.querySelector('a[name=\'pensopay{$type|escape:'htmlall':'UTF-8'}\']');_payment_module_handler(myEv) && $('#pensopay{$type|escape:'htmlall':'UTF-8'}').submit()">
	{else}
		<a style="height:auto" href="javascript:$('#pensopay{$type|escape:'htmlall':'UTF-8'}').submit()">
	{/if}
{/if}
{foreach from=$imgs item=img}
	<img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/{$img|escape:'htmlall':'UTF-8'}.png" alt="{l s='Pay with credit cards ' mod='pensopay'}" />
{/foreach}
		&nbsp;
		{$text|escape:'htmlall':'UTF-8'}
		&nbsp;
		{if isset($type) and $type eq 'viabill' and isset($cart_total)}
			<div class="viabill-pricetag" data-view="payment" data-price="{$cart_total|escape:'htmlall':'UTF-8'}" style="display: inline"></div>
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
{if !$no_print_link}
	</a>
{/if}
</p>
