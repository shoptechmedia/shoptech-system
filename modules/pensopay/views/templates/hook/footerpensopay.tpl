{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}

<section class="footer-block col-xs-12 col-sm-2 clearfix">
<h4>
	{l s='Payment methods' mod='pensopay'}
</h4>
<div class="block_content toggle-footer pensopay imgf">
{foreach from=$ordering_list item=var_name}
    <img src="{$link->getMediaLink("`$module_dir|escape:'htmlall':'UTF-8'`views/img/`$var_name|escape:'htmlall':'UTF-8'`.png")}" alt="{l s='Credit card' mod='pensopay'}" />
{/foreach}
</div>
</section>
