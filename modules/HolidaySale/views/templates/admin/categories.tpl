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

<div class="panel">
	<div class="panel-heading">
		<i class="icon-folder-close"></i>
		{l s='Holiday Sale Discounts' mod='HolidaySale'}
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				{$categoryTree}
			</div>

			<div class="col-xs-12 col-sm-3">
				<div class="form-group">
					<p>{l s='Suppliers' mod='HolidaySale'}</p>

					<div style="max-width: 400px;">
						{$supplierTree}
					</div>
				</div>

				<div class="form-group">
					<p>{l s='Manufacturers' mod='HolidaySale'}</p>

					<div style="max-width: 400px;">
						{$manufacturerTree}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<h3 style="margin: 0 0 10px;"><input type="checkbox" id="selectAllProducts" /> {l s='Choose All Products' mod='HolidaySale'} <input type="text" id="productSearchFilter" /></h3>

				<div id="chooseProducts" class="scrollableOptions">
					{foreach $products as $product}
					{if {$product.id}}

						{if $product.default_on}
						<label class="productTree_item productTree_{$product.id} productTree_{$product.id}-0">
							<input class="productTree_checkbox" type="checkbox" value="{$product.id}-0" name="productTree[]" /> {$product.product_name} - {l s='All Combinations' mod='HolidaySale'}
						</label>
						{/if}

						<label class="productTree_item productTree_{$product.id} productTree_{$product.id}-{$product.id_product_attribute}">
							{$product_price = Tools::displayPrice(Product::getPriceStatic($product.id, true, null, 6, null, false, false))}

							<div class="col-xs-8">
								<input class="productTree_checkbox" type="checkbox" value="{$product.id}-{$product.id_product_attribute}" name="productTree[]" /> {$product.name}
							</div>

							<div class="col-xs-2"><span>{$product_price}</span></div>

							<a class="col-xs-2" data-id_product="{$product.id}" href="#">{l s='Delete Discount' mod='HolidaySale'}</a>
						</label>
					{/if}
					{/foreach}
				</div>
			</div>

			<div class="col-xs-12 col-sm-6">
				<h3 style="margin: 0 0 10px;">{l s='Selected Products' mod='HolidaySale'}</h3>

				<div id="selectedProducts" class="scrollableOptions">
					<div class="loading" style="display: none;"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<div class="form-group">
					<p>{l s='Customer Groups' mod='HolidaySale'}</p>

					<div style="max-width: 400px;">
						{$groupTree}
					</div>
				</div>

				<div class="form-group">
					<p>{l s='Currencies' mod='HolidaySale'}</p>

					<div style="max-width: 400px;">
						{$currencyTree}
					</div>
				</div>

				<div class="form-group">
					<p>{l s='Holiday Page' mod='HolidaySale'}</p>

					<select id="holiday_page" name="holiday_page">
						{foreach $pages as $page}
						<option value="{$page.id_holiday_sale}">{$page.title}</option>
						{/foreach}
					</select>
				</div>

				<div class="form-group">
					<p>{l s='Type' mod='HolidaySale'}</p>

					<select id="reduction_type" name="reduction_type">
						<option value="amount">{l s='Fixed Amount' mod='HolidaySale'}</option>
						<option value="price">{l s='Fixed Price' mod='HolidaySale'}</option>
						<option value="percentage">%</option>
					</select>
				</div>

				<div id="ActionRow">
					<p>&nbsp;</p>

					<button id="addDiscount" type="button" class="btn btn-primary">{l s='Add Discounts' mod='HolidaySale'}</button>
				</div>
			</div>

			<div class="col-xs-12 col-sm-3">
				<div class="form-group">
					<p>{l s='Countries' mod='HolidaySale'}</p>

					<div style="max-width: 400px;">
						{$countryTree}
					</div>
				</div>

				<div class="form-group">
					<p>{l s='With Tax?' mod='HolidaySale'}</p>

					<select id="with_tax" name="with_tax">
						<option value="1">{l s='Yes' mod='HolidaySale'}</option>
						<option value="0">{l s='No' mod='HolidaySale'}</option>
					</select>
				</div>

				<div class="form-group">
					<p>{l s='Starting From' mod='HolidaySale'}</p>

					<input type="text" id="starting_amount" name="starting_amount" value="">
				</div>

				<div class="form-group">
					<p>{l s='Amount' mod='HolidaySale'}</p>

					<input type="text" id="reduction_amount" name="reduction_amount" value="">
				</div>
			</div>
		</div>

	</div>
</div>

<div class="panel">
	<div class="panel-heading">
		<i class="icon-folder-close"></i>
		{l s='Clear Discounts' mod='HolidaySale'}
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="form-group col-lg-3">
				<select id="holiday_page2" name="holiday_page">
					{foreach $pages as $page}
					<option value="{$page.id_holiday_sale}">{$page.title}</option>
					{/foreach}
				</select>
			</div>

			<div class="form-group col-lg-3">
				<button id="clearDiscount" type="button" class="btn btn-primary">{l s='Delete Discounts' mod='HolidaySale'}</button>
			</div>
		</div>

	</div>
</div>