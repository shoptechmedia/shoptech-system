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

		{l s='Reservation Dates' mod='stmeventscourses'}
	</div>

	<div class="panel-body">
		<div class="form-wrapper" id="RDateForm">
			{foreach $dates as $date}
			<fieldset>
				<div class="form-group">
					<label class="control-label col-lg-3 required" id="all_723">Event Start</label>
					<div class="col-lg-9" id="all_724">

						<div class="row" id="all_725">
							<div class="input-group col-lg-4" id="all_726">
								<input id="reservation_start_date4" type="text" data-hex="true" class="datetimepicker hasDatepicker" name="STMDates[reservation_start_date][]" value="{$date['start_date']}" form="configuration_form">

								<span class="input-group-addon" id="all_727">
									<i class="icon-calendar-empty" id="all_728"></i>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 required" id="all_723">Event End</label>

					<div class="col-lg-9" id="all_724">
						<div class="row" id="all_725">
							<div class="input-group col-lg-4" id="all_726">
								<input id="reservation_end_date5" type="text" data-hex="true" class="datetimepicker hasDatepicker" name="STMDates[reservation_end_date][]" value="{$date['end_date']}" form="configuration_form">

								<span class="input-group-addon" id="all_727">
									<i class="icon-calendar-empty" id="all_728"></i>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group stmeField">
					<label class="control-label col-lg-3 required">Available Reservations</label>

					<div class="col-lg-9">
						<input type="text" name="STMDates[available_reservation][]" form="configuration_form" value="{$date['available_reservation']}">
					</div>
				</div>
			</fieldset>
			{/foreach}
		</div>
	</div>

	<div class="panel-footer">
		<button type="submit" for="configuration_form" name="saveSTMEvent" class="btn btn-default pull-right">
			<i class="process-icon-save" id="all_825"></i> {l s='Save' mod='stmeventscourses'}
		</button>

		<a href="javascript:;" id="addDate" class="btn btn-default pull-right">
			<i class="process-icon-new"></i> {l s='Add Date' mod='stmeventscourses'}
		</a>
	</div>
</div>