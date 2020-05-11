{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}

{extends file='customer/page.tpl'}

{block name='page_title'}
    {l s='Payment problem' mod='pensopay'}
{/block}

{block name='page_content'}

{if $status == 'currency'}
<p class="alert alert-warning warning">
	{l s='Your order on' mod='pensopay'} <strong>{$shop_name|escape:'htmlall':'UTF-8'}</strong> {l s='failed because the currency was changed.' mod='pensopay'}
</p>
<div class="box">
	{l s='Please fill the cart again.' mod='pensopay'}
	<br><br>
	{l s='For any questions or for further information, please contact our' mod='pensopay'} <a href="{$urls.pages.contact|escape:'javascript':'UTF-8'}">{l s='customer support' mod='pensopay'}</a>.
</div>
{/if}

{if $status == 'test'}
<p class="alert alert-warning warning">
	{l s='Your order on' mod='pensopay'} <strong>{$shop_name|escape:'htmlall':'UTF-8'}</strong> {l s='failed because a test card was used for payment.' mod='pensopay'}
</p>
<div class="box">
	{l s='Please fill the cart again.' mod='pensopay'}
	<br><br>
	{l s='For any questions or for further information, please contact our' mod='pensopay'} <a href="{$urls.pages.contact|escape:'javascript':'UTF-8'}">{l s='customer support' mod='pensopay'}</a>.
</div>
{/if}

{/block}
