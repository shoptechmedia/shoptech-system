{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}
{if $linkTitle && $linkHref}
    {assign var="assembled_link" value="<a href=\"`$linkHref`\">`$linkTitle`</a>"}
    {$generic|replace:'%link%':$assembled_link|escape:'html':'UTF-8'}
{else}
    {$generic|escape:'htmlall':'UTF-8'}
{/if}