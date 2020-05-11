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

{extends file="helpers/form/form.tpl"}






{block name="label"}
{if $input.type != 'grid_creator'}
{$smarty.block.parent}
{/if}
{/block}

{block name="input_row"}
{if isset($input.hide) && $input.hide}<div style="display: none !important;">{/if}
{if isset($input.preffix_wrapper)}<div id="{$input.preffix_wrapper}" {if isset($input.wrapper_hidden) && $input.wrapper_hidden} class="hidden clearfix"{/if}>{/if}
{if isset($input.upper_separator) && $input.upper_separator}<hr>{/if}
{if isset($input.row_title)}
<div class="col-lg-9 col-lg-offset-3 row-title">{$input.row_title}</div>
{/if}
{$smarty.block.parent}
{if isset($input.separator) && $input.separator}<hr>{/if}
{if isset($input.suffix_a_wrapper) && $input.suffix_wrapper}</div>{/if}
{if isset($input.suffix_wrapper) && $input.suffix_wrapper}</div>{/if}
{if isset($input.hide) && $input.hide}</div>{/if}
{/block}


{block name="input"}
  	{if $input.type == 'grid_creator'}
	<input type="hidden" name="submenu-elements" id="submenu-elements" value="{$submenu_content}">

	<div id="column-content-sample" class="hidden">
		{include file="./column_content.tpl"}
	</div>

	<div id="row-content-sample" class="hidden">
		{include file="./row_content.tpl"}
	</div>

	<div id="tab-content-sample" class="hidden">
		{include file="./tab_content.tpl"}
	</div>


	<div class="preview-buttons">
		<label>{l s='View: ' mod='iqitcontentcreator'}</label> 
		<button type="button" class="btn btn-default switch-view-btn" data-preview-type="preview-p" ><i class="icon-mobile"></i> {l s='Phone' mod='iqitcontentcreator'}</button>
		<button type="button" class="btn btn-default switch-view-btn" data-preview-type="preview-t" ><i class="icon-tablet"></i> {l s='Tablet' mod='iqitcontentcreator'}</button>
		<button type="button" class="btn btn-default switch-view-btn active-preview" data-preview-type="preview-d" ><i class="icon-desktop"></i> {l s='Desktop' mod='iqitcontentcreator'}</button>
		<a href="{$link->getAdminLink('IqitFronteditor')}" class="btn btn-success" target="_blank"><i class="icon-arrows-alt"></i> {l s='Front Editor' mod='iqitcontentcreator'}</a>
	</div>	
	<div id="grid-creator-wrapper" class="preview-d">
	<div class="row grid_creator">
		<div class="col-xs-12 first-rows-wrapper" data-element-id="0">


			{foreach $submenu_content_format as $element}
				{include file="./submenu_content.tpl" node=$element frontEditor=0}               
			{/foreach}

			

		</div>
		<div id="buttons-sample">
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
				<div class="dragger-handle btn btn-danger"><i class="icon-arrows "></i> <span class="row-dragger-txt">{l s='Row' mod='iqitcontentcreator'}</span><span class="col-dragger-txt">{l s='Column' mod='iqitcontentcreator'}</span><span class="tabs-dragger-txt">{l s='Tabs' mod='iqitcontentcreator'}</span><span class="tab-dragger-txt">{l s='Tab' mod='iqitcontentcreator'}</span></div>
			</div>
	</div>
	</div>
	

	{elseif $input.type == 'image_upload'}
	<p> <input id="{$input.name}" type="text" name="{$input.name}" value="{$fields_value[$input.name]|escape:'html':'UTF-8'}"> </p>
	 <a href="filemanager/dialog.php?type=1&field_id={$input.name}" class="btn btn-default iframe-upload"  data-input-name="{$input.name}" type="button">{l s='Select image' mod='iqitcontentcreator'} <i class="icon-angle-right"></i></a>
	{elseif $input.type == 'custom_select'}
	{$input.choices}

	<script>
	$("#{$input.name} option").filter(function() {

    return $(this).val() == '{$fields_value[$input.name]}'; 
	}).prop('selected', true);
	</script>
	{elseif $input.type == 'icon_selector'}
	<div class="input-group col-lg-3">
            <input type="text" name="{$input.name}" class="icp icp-auto" id="{$input.name}" value="{$fields_value[$input.name]|escape:'html':'UTF-8'}">
            <span class="input-group-addon">{l s='Select icon' mod='iqitcontentcreator'}</span>
    </div>

	{elseif $input.type == 'border_generator'}
	
	<div class="col-xs-2">
	<select name="{$input.name}_type" id="{$input.name}_type">
		<option value="5" {if $fields_value[$input.name].type==5}selected{/if}>{l s='groove' mod='iqitcontentcreator'}</option>
		<option value="4" {if $fields_value[$input.name].type==4}selected{/if}>{l s='double' mod='iqitcontentcreator'}</option>
		<option value="3" {if $fields_value[$input.name].type==3}selected{/if}>{l s='dotted' mod='iqitcontentcreator'}</option>
		<option value="2" {if $fields_value[$input.name].type==2}selected{/if}>{l s='dashed' mod='iqitcontentcreator'}</option>
		<option value="1" {if $fields_value[$input.name].type==1}selected{/if}>{l s='solid' mod='iqitcontentcreator'}</option>
		<option value="0" {if $fields_value[$input.name].type==0}selected{/if}>{l s='none' mod='iqitcontentcreator'}</option>
	</select>
	</div>
	<div class="col-xs-2">
	<select name="{$input.name}_width" id="{$input.name}_width">
		{for $i=1 to 10}
  				  <option value="{$i}" {if $fields_value[$input.name].width == $i}selected{/if}>{$i}px</option>
		{/for}
	</select>
	</div>		
	<div class="col-xs-2">
	<div class="row">
	<div class="input-group">
	<input type="color" data-hex="true" class="color mColorPickerInput"	name="{$input.name}_color" value="{$fields_value[$input.name].color|escape:'html':'UTF-8'}" />
	</div>	</div>	</div>						
	
	{else}
		{$smarty.block.parent}
    {/if}
{/block}




