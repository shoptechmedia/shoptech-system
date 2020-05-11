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
	<div class="form-group">
		<div class="col-lg-12">
			<a class="btn btn-default" href="#" id="show_hsd">
				<i class="icon-plus-sign"></i> {l s='Add a new specific price'}
			</a>
			<a class="hidden btn btn-default" href="#" id="hide_hsd">
				<i class="icon-remove text-danger"></i> {l s='Cancel new specific price'}
			</a>
		</div>
	</div>

	<div id="add_hs_discount" class="well clearfix hidden">
		<div class="col-lg-12">
			<div class="form-group">
				<label class="control-label col-lg-2">{l s='Campaigns'}</label>

				<div class="col-lg-9">
				{foreach $holidays as $holiday}
					{if $holiday.id_holiday_sale}
					<div class="row">
						<label class="col-lg-6">
							<input type="radio" class="hsd_assigned_holidays" name="hsd_assigned_holidays[]" value="{$holiday.id_holiday_sale}" data-release_date="{$holiday.release_date}" data-end_date="{$holiday.end_date}"/>

							{$holiday.name}
						</label>
					</div>
					{/if}
				{/foreach}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-lg-2" for="hsd_from">{l s='Available'}</label>

				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-4">
							<div class="input-group">
								<span class="input-group-addon">{l s='from'}</span>
								<input type="text" name="hsd_from" value="" style="text-align: center" id="hsd_from" readonly/>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="input-group">
								<span class="input-group-addon">{l s='to'}</span>
								<input type="text" name="hsd_to" value="" style="text-align: center" id="hsd_to" readonly/>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-lg-2" for="hsd_reduction">{l s='Apply a discount of'}</label>

				<div class="col-lg-4">
					<div class="row">
						<div class="col-lg-3">
							<input type="text" name="hsd_reduction" id="hsd_reduction" value="0.00"/>
						</div>

						<div class="col-lg-6">
							<select name="hsd_reduction_type" id="hsd_reduction_type">
								<option value="amount" selected="selected">{$currency->name|escape:'html':'UTF-8'}</option>
								<option value="percentage">{l s='%'}</option>
							</select>
						</div>

						<div class="col-lg-3">
							<select name="hsd_reduction_tax" id="hsd_reduction_tax">
								<option value="0">{l s='Tax excluded'}</option>
								<option value="1" selected="selected">{l s='Tax included'}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table id="hsds" class="table table-bordered">
			<thead>
				<tr>
					<th>{l s='Name'}</th>
					<th>{l s='Start'}</th>
					<th>{l s='End'}</th>
					<th>{l s='Reduction'}</th>
					<th>{l s='Type'}</th>
					<th>{l s='Tax'}</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				{foreach $hsds as $hsd}
				<tr>
					<td>{$hsd.holiday}</td>
					<td>{$hsd.hsd_from}</td>
					<td>{$hsd.hsd_to}</td>
					<td>{$hsd.hsd_reduction}</td>
					<td>{$hsd.hsd_reduction_type}</td>
					<td>{$hsd.hsd_reduction_tax}</td>
					<td>
						<a href="{$hsd.delete_link}" class="btn btn-default" class="delete_holiday_reduction"><i class="icon-trash"></i></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>

	<div class="panel-footer">
		<button type="submit" name="submitAddproduct" class="btn btn-default pull-right" disabled="disabled"><i class="process-icon-loading"></i> {l s='Save'}</button>

		<button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right" disabled="disabled"><i class="process-icon-loading"></i> {l s='Save and stay'}</button>
	</div>
</div>


<script type="text/javascript">
	var currencyName = '{$currency->name|escape:'html':'UTF-8'|@addcslashes:'\''}';

	$(document).ready(function(){
		$('#hsd_reduction_type').on('change', function() {
			if (this.value == 'percentage')
				$('#hsd_reduction_tax').hide();
			else
				$('#hsd_reduction_tax').show();
		});

		$('#show_hsd').click(function(){
			$('#hide_hsd').removeClass('hidden');
			$('#add_hs_discount').removeClass('hidden');

			$('#show_hsd').addClass('hidden');
		});

		$('#hide_hsd').click(function(){
			$('#hide_hsd').addClass('hidden');
			$('#add_hs_discount').addClass('hidden');

			$('#show_hsd').removeClass('hidden');
		});

		$('.hsd_assigned_holidays').on({
			change: function(){
				if(this.checked == true){
					var release_date = $(this).attr('data-release_date');
					var end_date = $(this).attr('data-end_date');

					$('#hsd_from').val(release_date);
					$('#hsd_to').val(end_date);
				}
			}
		});
	});
</script>