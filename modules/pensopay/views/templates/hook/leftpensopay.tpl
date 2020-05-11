{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}

{if $doCenter}
  <center class="pensopay imgf">
{/if}

{foreach from=$ordering_list item=var_name}
  <img src="{$link->getMediaLink("`$module_dir|escape:'htmlall':'UTF-8'`views/img/`$var_name|escape:'htmlall':'UTF-8'`.png")}" alt="{l s='Pay with credit cards ' mod='pensopay'}" />
{/foreach}

{if $doCenter}
  </center>
{/if}
<br>
