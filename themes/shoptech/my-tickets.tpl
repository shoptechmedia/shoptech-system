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

<script type="text/javascript" data-keepinline>
    // <![CDATA[
        ThickboxI18nImage = "Image";
        ThickboxI18nOf = "of";
        ThickboxI18nClose = "Close";
        ThickboxI18nOrEscKey = "(or &quot;Esc&quot;)";
        ThickboxI18nNext = "Next &gt;";
        ThickboxI18nPrev = "&lt; Previous";
        tb_pathToImage = "../img/loadingAnimation.gif";
    //]]>

    var iso = 'en';
    var pathCSS = '/themes/shoptech/css/';
    var ad = '/login888';
</script>

<h1 class="page-heading">
    {l s='My tickets'}
</h1>

<div class="row">
    {if isset($tickets)}
	<ul class="tickets col-xs-12">
        {foreach $tickets as $ticket}
        <li class="ticket">
            <a style="display: block;" href="/my-tickets?id={$ticket.id_ticket}">
                <strong>{$ticket.subject}</strong><br/>
                <small>{l s='assigned to by'} {$ticket.agent} {l s='on'} {$ticket.created_at}</small>
            </a>
        </li>
        {/foreach}
	</ul>

    {elseif isset($threads)}

    <div class="threads col-xs-12">
        
        {foreach $threads as $thread}
        <article class="thread">

            <h4>
                {$thread.user_name} <small>{l s='replied on'} {$thread.created_at}</small>
            </h4>

            {$thread.message}

            <p></p>

        </article>
        {/foreach}

    </div>

    <hr>

    <form action="?id={Tools::getValue('id')}" method="post" class="col-xs-12">
        <input type="hidden" name="submitReply" value="1">

        <div>
            <textarea name="thread_reply" class="hidden autoload_rte"></textarea>
        </div><br>

        <div class="text-right">
            <button class="btn btn-default button button-small" type="submit">
                <span>{l s='Submit'} <i class="icon-chevron-right right"></i></span>
            </button>
        </div><br>

    </form>

    {/if}
</div>

{if isset($tickets)}
<ul class="footer_links clearfix">
    <li><a class="btn btn-default button button-small" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{l s='Home'}"><span><i class="icon-chevron-left"></i> {l s='Home'}</span></a></li>
</ul>
{elseif isset($threads)}
<ul class="footer_links clearfix">
    <li><a class="btn btn-default button button-small" href="/my-tickets" title="{l s='My Tickets'}"><span><i class="icon-chevron-left"></i> {l s='My Tickets'}</span></a></li>
</ul>
{/if}