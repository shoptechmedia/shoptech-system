{*
* 2007-2016 PrestaShop
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

{* retro compatibility *}
{if !isset($title) && isset($page_header_toolbar_title)}
	{assign var=title value=$page_header_toolbar_title}
{/if}
{if isset($page_header_toolbar_btn)}
	{assign var=toolbar_btn value=$page_header_toolbar_btn}
{/if}

<div class="bootstrap">
	<div class="page-head">
		{block name=pageTitle}
		<div class="bg-white p-3 header-secondary row">
			<div class="col">
				<div class="d-flex">
					<h2 class="page-title">
						{if is_array($title)}{$title|end|strip_tags}{else}{$title|strip_tags}{/if}
					</h2>
				</div>
			</div>
			<div class="col col-auto">
				{foreach from=$toolbar_btn item=btn key=k}
				{if $k != 'back' && $k != 'modules-list'}
					<a id="page-header-desc-{$table}-{if isset($btn.imgclass)}{$btn.imgclass|escape}{else}{$k}{/if}" class="btn btn-default mt-1 mb-1  mt-sm-0" {if isset($btn.href)} href="{$btn.href|escape}"{/if} title="{if isset($btn.help)}{$btn.help}{else}{$btn.desc|escape}{/if}"{if isset($btn.js) && $btn.js} onclick="{$btn.js}"{/if}{if isset($btn.modal_target) && $btn.modal_target} data-target="{$btn.modal_target}" data-toggle="modal"{/if}{if isset($btn.help)} data-toggle="tooltip" data-placement="bottom"{/if}>
						{$btn.desc|escape}
					</a>
				{/if}
				{/foreach}

				{if isset($toolbar_btn['modules-list'])}
					<a id="page-header-desc-{$table}-{if isset($toolbar_btn['modules-list'].imgclass)}{$toolbar_btn['modules-list'].imgclass}{else}modules-list{/if}"  class="btn btn-default mt-1 mb-1  mt-sm-0" {if isset($toolbar_btn['modules-list'].href)}href="{$toolbar_btn['modules-list'].href}"{/if} title="{$toolbar_btn['modules-list'].desc}"{if isset($toolbar_btn['modules-list'].js) && $toolbar_btn['modules-list'].js} onclick="{$toolbar_btn['modules-list'].js}"{/if}>
						{$toolbar_btn['modules-list'].desc}
					</a>
				{/if}

				{if isset($help_link)}
					<a class="btn btn-danger mt-1 mb-1 mt-sm-0" href="{$help_link|escape}"><i class="fe fe-help-circle mr-1 mt-1"></i> Help</a>
				{/if}

				{if (isset($tab_modules_open) && $tab_modules_open) || isset($tab_modules_list)}
				<script type="text/javascript">
				//<![CDATA[
					var modules_list_loaded = false;
					{if isset($tab_modules_open) && $tab_modules_open}
						$(function() {
								$('#modules_list_container').modal('show');
								openModulesList();

						});
					{/if}
					{if isset($tab_modules_list)}
						$('.process-icon-modules-list').parent('a').unbind().bind('click', function (){
							$('#modules_list_container').modal('show');
							openModulesList();
						});
					{/if}
				//]]>
				</script>
				{/if}
			</div>
		</div>
		{/block}

		{block name=pageBreadcrumb}
		<!-- PAGE-HEADER -->
		<div class="page-header">
			<ol class="breadcrumb">
				{* Container *}
				{if $breadcrumbs2.container.name != ''}
				<li class="breadcrumb-item">
					{if $breadcrumbs2.container.href != ''}<a href="{$breadcrumbs2.container.href|escape}">{/if}
					{$breadcrumbs2.container.name|escape}
					{if $breadcrumbs2.container.href != ''}</a>{/if}
				</li>
				{/if}

				{* Current Tab *}
				{if $breadcrumbs2.tab.name != '' && $breadcrumbs2.container.name != $breadcrumbs2.tab.name}
				<li class="breadcrumb-item">
					{if $breadcrumbs2.tab.href != ''}<a href="{$breadcrumbs2.tab.href|escape}">{/if}
					{$breadcrumbs2.tab.name|escape}
					{if $breadcrumbs2.tab.href != ''}</a>{/if}
				</li>
				{/if}

				{* Action *}
				{*if $breadcrumbs2.action.name != ''}
				<li class="breadcrumb-item">
					{if $breadcrumbs2.action.href != ''}<a href="{$breadcrumbs2.action.href|escape}">{/if}
					{$breadcrumbs2.action.name|escape}
					{if $breadcrumbs2.action.href != ''}</a>{/if}
				</li>
				{/if*}
			</ol>
		</div>
		<!-- PAGE-HEADER END -->
		{/block}
	</div>
</div>
