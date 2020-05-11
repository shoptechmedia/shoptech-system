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

<div id="CombinationPanel" class="panel hidden">
	<div class="panel-body">
		<div class="form-group">
			<label class="control-label col-lg-3" for="product_autocomplete_input_4">
				<span class="label-tooltip" data-toggle="tooltip" title="" data-original-title="{l s='Start by typing the first letters of the product\'s name, then select the product from the drop-down list. Do not forget to save the product afterwards!'}">
					{l s='Products'}
				</span>
			</label>

			<div class="col-lg-5">
				<div id="ajax_choose_product">
					<div class="input-group">
						<input type="text" id="product_autocomplete_input_4" name="product_autocomplete_input_4" autocomplete="off" class="ac_input">

						<span class="input-group-addon"><i class="icon-search"></i></span>
					</div>
				</div>

				<div id="divGroupP">

				</div>
			</div>
		</div>
	</div>

	<div class="panel-footer">
		<a href="javascript:;" id="SaveCombination" class="btn btn-default pull-right">
			<i class="process-icon-new"></i> Save
		</a>
	</div>
</div>

<div class="panel">
	<div class="panel-body">
		<table class="table">
			<thead>
				<th>{l s='Product' mod='stmeventscourses'}</th>
				<th>{l s='Combination' mod='stmeventscourses'}</th>
				<th>{l s='Actions' mod='stmeventscourses'}</th>
			</thead>

			<tbody id="GroupProductList">
				{foreach $Combinations as $Combination}
				<tr id="Combination-{$Combination.id_combination}">
					<td class="name pointer">{$Combination.id_product} {$Combination.name}</td>

					<td class="pointer">
						{foreach $Combination.combination as $label => $value}
							<strong>{$label}</strong>: {$value} <br/>
						{/foreach}
					</td>

					<td class="pointer">
						<a href="javascript:;" class="EditCombination" data-id_value="{$Combination.id_combination}">Edit</a> |

						<a href="javascript:;" class="DeleteCombination" data-id_value="{$Combination.id_combination}">Delete</a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>