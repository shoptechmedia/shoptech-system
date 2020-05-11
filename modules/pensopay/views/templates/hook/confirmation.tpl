{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}

{if $status == 'ok'}
<p>{l s='Your order on' mod='pensopay'} <span class="bold">{$shop_name|escape:'htmlall':'UTF-8'}</span> {l s='is complete.' mod='pensopay'}
	<br><br><span class="bold">{l s='Your order will be sent very soon.' mod='pensopay'}</span>
	<br><br>{l s='For any questions or for further information, please contact our' mod='pensopay'} <a href="{$base_dir_ssl|escape:'htmlall':'UTF-8'}contact-form.php">{l s='customer support' mod='pensopay'}</a>.
</p>

{else}

<p class="alert alert-warning warning">{l s='Your order on' mod='pensopay'} <strong>{$shop_name|escape:'htmlall':'UTF-8'}</strong> {l s='failed because the payment was not confirmed.' mod='pensopay'}
	<br><br>{l s='For any questions or for further information, please contact our' mod='pensopay'} <a href="{$base_dir_ssl|escape:'htmlall':'UTF-8'}contact-form.php">{l s='customer support' mod='pensopay'}</a>.
</p>
{/if}
