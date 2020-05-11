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

<div id="AddDropdownForm" class="panel {if $id_dropdown == 0}hidden{/if}">
	<div class="panel-body">
		<input type="hidden" name="id_dropdown" value="{$id_dropdown}" />

		<div class="form-group">
			<label class="control-label col-lg-2 required">
				<span class="label-tooltip">
					{l s='Dropdown Label'}
				</span>
			</label>
			<div class="col-lg-5">
				{include file="controllers/products/input_text_lang.tpl"
					languages=$languages
					input_class="updateCurrentText"
					input_name="dropdown_label"
					input_value=$label
					required=true
				}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-2 required">
				<span class="label-tooltip">
					{l s='Dropdown Name'}
				</span>
			</label>
			<div class="col-lg-5">
				{include file="controllers/products/input_text_lang.tpl"
					languages=$languages
					input_class="updateCurrentText"
					input_name="dropdown_name"
					input_value=$name
					required=true
				}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-2 required">
				<span class="label-tooltip">
					{l s='Dropdown Options'}
				</span>
			</label>
			<div class="col-lg-5">
				<textarea name="dropdown_options" rows="10">{$dropdown_options}</textarea>
				<small>{l s='1 Option per line' mod='customcombinations'}</small>
			</div>
		</div>

	</div>

	<div class="panel-footer">
		<a href="javascript:;" class="btn btn-default CloseForm"><i class="process-icon-cancel"></i> {l s='Cancel'}</a>

		<button type="button" id="saveDropdown" class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s='Save'}</button>
	</div>
</div>

<div id="DropdownList" class="panel">
	<div class="panel-body">
		<table class="table">
			<thead>
				<th>{l s='ID'}</th>
				<th>{l s='Label'}</th>
				<th>{l s='Name'}</th>
				<th>{l s='Options'}</th>
				<th>{l s='Actions'}</th>
				<th>{l s='Use in Product?'}</th>
			</thead>
			<tbody>
				{foreach $dropdowns as $id_dropdown => $dropdown}
				<tr>
					<td class="pointer">{$id_dropdown}</td>

					<td class="pointer">{$dropdown.label.$id_lang}</td>

					<td class="pointer">{$dropdown.name.$id_lang}</td>

					<td class="pointer">
						{foreach $dropdown.options as $option}
							{$option['value']}<br/>
						{/foreach}
					</td>

					<td class="pointer">
						<a href="index.php?controller=AdminProducts&id_product={$id_product}&updateproduct=&token={Tools::getValue('token')}&key_tab=ModuleCustomcombinations&edit_dropdown={$id_dropdown}" class="EditDropdown">Edit</a> | 
						<a href="index.php?controller=AdminProducts&id_product={$id_product}&updateproduct=&token={Tools::getValue('token')}&key_tab=ModuleCustomcombinations&delete_dropdown={$id_dropdown}" class="DeleteDropdown">Delete</a>
					</td>

					<td class="pointer">
						<input type="checkbox" class="Dropdown_Item_Use" value="{$id_dropdown}" {if $dropdown.isInProduct}checked="checked"{/if}>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>

	<div class="panel-footer">
		<a href="javascript:;" data-target="AddDropdownForm" class="ShowForm btn btn-default pull-right">
			<i class="process-icon-new"></i> Add New
		</a>

		<a href="index.php?controller=AdminProducts&id_product={$id_product}&updateproduct=&token={Tools::getValue('token')}&key_tab=ModuleCustomcombinations&CleanCombinations=1" class="btn btn-default pull-right">
			<i class="process-icon-delete"></i> Clean Combinations
		</a>

		<a href="" class="btn btn-default pull-right">
			<i class="process-icon-new"></i> Generate Combinations
		</a>

		<button style="display: none;" type="submit" id="RefreshDropdowns" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-save"></i> Gem og bliv</button>
	</div>
</div>