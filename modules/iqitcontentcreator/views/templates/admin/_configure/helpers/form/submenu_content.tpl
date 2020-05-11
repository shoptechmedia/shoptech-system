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


	{if $node.type==1}
	<div data-element-type="1" data-depth="{$node.depth}" data-element-id="{$node.elementId}" class="row menu_row menu_row_element menu-element {if $node.depth==0} first_rows{/if} menu-element-id-{$node.elementId}">
		{include file="./row_content.tpl" node=$node}
		{elseif $node.type==3}
		<div data-element-type="3" data-depth="{$node.depth}" data-element-id="{$node.elementId}" class="row menu_row menu_tabe menu_row_element menu-element menu-element-id-{$node.elementId}">
		{include file="./tab_content.tpl" node=$node}

		{elseif $node.type==2}
		<div data-element-type="2" data-depth="{$node.depth}" data-width-p="{$node.width_p}" data-width-t="{$node.width_t}" data-width-d="{$node.width_d}" data-contenttype="{$node.contentType}" data-element-id="{$node.elementId}" class="{if $node.width_p==13}phone-hidden{else}creator-col-xs-{$node.width_p}{/if} {if $node.width_t==13}tablet-hidden{else}creator-col-sm-{$node.width_t}{/if} {if $node.width_d==13}desktop-hidden{else}creator-col-md-{$node.width_d}{/if} menu_column menu-element menu-element-id-{$node.elementId}">
		{elseif $node.type==4}
		<div data-element-type="4" data-depth="{$node.depth}" data-width-p="{$node.width_p}" data-width-t="{$node.width_t}" data-width-d="{$node.width_d}" data-contenttype="{$node.contentType}" data-element-id="{$node.elementId}" class="{if $node.width_p==13}phone-hidden{else}creator-col-xs-{$node.width_p}{/if} {if $node.width_t==13}tablet-hidden{else}creator-col-sm-{$node.width_t}{/if} {if $node.width_d==13}desktop-hidden{else}creator-col-md-{$node.width_d}{/if} menu_column menu_tabs menu-element menu-element-id-{$node.elementId}">
			{/if}
		
			<div class="action-buttons-container">
				<button type="button" class="btn btn-default add-row-action" ><i class="icon icon-plus"></i> {l s='Row' mod='iqitcontentcreator'}</button>
				<button type="button" class="btn btn-default add-column-action" ><i class="icon icon-plus"></i> {l s='Column' mod='iqitcontentcreator'}</button>
				<button type="button" class="btn btn-default add-tabs-action" ><i class="icon icon-plus"></i> {l s='Tabs' mod='iqitcontentcreator'}</button>
				<button type="button" class="btn btn-default add-tab-action" ><i class="icon icon-plus"></i> {l s='Tab' mod='iqitcontentcreator'}</button>
				<button type="button" class="btn btn-default column-content-edit"><i class="icon-pencil"></i> {l s='Content' mod='iqitcontentcreator'}</button>
				<button type="button" class="btn btn-default duplicate-element-action" ><i class="icon icon-files-o"></i> </button>
				<button type="button" class="btn btn-default edit-row-action" ><i class="icon icon-wrench"></i></button>
				<button type="button" class="btn btn-danger remove-element-action" ><i class="icon-trash"></i> </button>
			</div>
			<div class="dragger-handle btn btn-danger"><i class="icon-arrows "></i></a> {if $node.type==1}{l s='Row' mod='iqitcontentcreator'}{elseif $node.type==2}{l s='Column' mod='iqitcontentcreator'} {elseif $node.type==3}{l s='Tab' mod='iqitcontentcreator'} {elseif $node.type==4}{l s='Tabs' mod='iqitcontentcreator'}{/if}</div>

			{if $node.type == 2 || $node.type == 4}
				{include file="./column_content.tpl" node=$node frontEditor=$frontEditor}
			{/if}

			
			{if $node.type==4}
				
				<ul class="nav nav-tabs nav-tabs-sortable">
				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{if $child.type==3}
							<li data-element-id="{$child.elementId}" data-element-type="3" class="iqitcontent-tab-li iqitcontent-tab-li-id-{$child.elementId}  {if $smarty.foreach.categoryTreeBranch.first} active{/if}"><a href="#iqitcontent-tab-id-{$child.elementId}"  data-toggle="tab">{foreach from=$languages item=language}
								{if $languages|count > 1}
								<span class="translatable-field lang-{$language.id_lang} langtab-{$language.id_lang}-{$child.elementId}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
									{if isset($child.tabtitle[$language.id_lang]) && $child.tabtitle[$language.id_lang] !=''}{$child.tabtitle[$language.id_lang]}{else}Tab {$child.elementId}{/if}
									{if $languages|count > 1}
								</span>
								{/if}
								{/foreach} <span class="dragger-handle-tab"><i class="icon-arrows "></i></span></a>

								</li> 
						{/if} 	
					{/foreach}
				{/if}
 				</ul>

 				<div class="tab-content">
				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{if $child.type==3}
							<div id="iqitcontent-tab-id-{$child.elementId}"  class="tab-pane  {if $smarty.foreach.categoryTreeBranch.first} active {/if}iqitcontent-element-id-{$child.elementId}">{include file="./submenu_content.tpl" node=$child frontEditor=$frontEditor}</div>
						{/if} 	
					{/foreach}
				{/if}
				</div> 

			{else}

				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{include file="./submenu_content.tpl" node=$child frontEditor=$frontEditor}
					{/foreach}
				{/if}

			{/if}


		</div>
