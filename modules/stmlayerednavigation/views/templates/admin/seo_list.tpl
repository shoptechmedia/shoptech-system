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

{if !$id_holiday_sale}
<div class="panel">
	<div class="panel-heading">
		<i class="icon-folder-close"></i>

		{l s='SEO Category' mod='stmlayerednavigation'}
	</div>

	<div class="panel-body">
		<table class="seoList table">
			<thead>
				<tr>
					<th colspan="3">{l s='Combination' mod='stmlayerednavigation'}</th>
					<th></th>
				</tr>
				<tr class="nodrag nodrop filter row_hover">
					<th colspan="3" class="center">
						<input class="form-control" type="text" class="filter" id="combinationFilter_name" value="">
					</th>

					<th class="actions">
						<span class="pull-right">
							<button type="button" id="submitFilterButtoncombination" name="submitFilter" class="btn btn-default">
								<i class="icon-search"></i> Søg
							</button>
						</span>
					</th>
				</tr>
			</thead>

			<tbody id="seoListBody">
				{foreach $combinations as $combination}
				<tr>
					<td colspan="3" class="name pointer">
						{foreach $combination.name as $item}
							<strong>{$item}</strong>
						{/foreach}
					</td>

					<td class="actions">
						<a class="btn btn-default pull-right" href="?controller=AdminModules&token={Tools::getValue('token')}&configure=stmlayerednavigation&edit_seo_template=1&id_layered_filter={$combination.id_layered_filter}&id_combination={$combination.id_combination}">
							<i class="icon-pencil"></i> Edit
						</a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>
{/if}