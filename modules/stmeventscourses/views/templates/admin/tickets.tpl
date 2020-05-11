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

		{l s='Courses' mod='stmeventscourses'}
	</div>

	<div class="panel-body">
		<div class="form-wrapper" id="ticketForm">
			{$t = 0}
			{foreach $tickets as $ticket}
			<fieldset>
				<span data-id_product="{$ticket['id_product']}" class="STMClose DeleteTicket fa fa-close"></span>

				<input type="hidden" name="STMTickets[id_product][]" form="configuration_form" value="{$ticket['id_product']}">

				<div class="form-group stmeField">
					<label class="control-label col-lg-3 required">{l s='Name' mod='stmeventscourses'}</label>

					<div class="col-lg-9">
						<input type="text" name="STMTickets[name][]" form="configuration_form" value="{$ticket['name']}">
					</div>
				</div>

				<div class="form-group stmeField">
					<label class="control-label col-lg-3 required">{l s='Description' mod='stmeventscourses'}</label>

					<div class="col-lg-9">
						<textarea class="autoload_rte" name="STMTickets[description][]" form="configuration_form">
							{$ticket['description']}
						</textarea>
					</div>
				</div>

				<div class="form-group stmeField">
					<label class="control-label col-lg-3 required">{l s='Price' mod='stmeventscourses'}</label>

					<div class="col-lg-9">
						<input type="text" name="STMTickets[price][]" form="configuration_form" value="{$ticket['price']}">
					</div>
				</div>

				<div class="form-group stmeField">
					<label class="control-label col-lg-3 required">{l s='Cover' mod='stmeventscourses'}</label>

					<div class="col-lg-9">
						<input type="file" name="STMTickets[cover][]" form="configuration_form">

						<img src="{$ticket['cover']}" alt="">
					</div>
				</div>

				<div class="DateSection">
					<button class="AddDate" data-t="{$t}">{l s='Add Date' mod='stmeventscourses'}</button>

					{foreach $ticket['dates'] as $d => $date}
					<fieldset style="border: 1px solid;">
						<span data-id_reservation_date="{$date['id_reservation_date']}" class="STMClose DeleteDate fa fa-close"></span>

						<input type="hidden" name="STMTickets[STMDates][{$t}][id_reservation_date][]" form="configuration_form" value="{$date['id_reservation_date']}">

						<div class="form-group">
							<label class="control-label col-lg-3 required" id="all_722">{l s='Start Time' mod='stmeventscourses'}</label>

							<div class="col-lg-9" id="all_723">
								<div class="row" id="all_724">
									<div class="input-group col-lg-4" id="all_725">
										<input id="edit_reservation_start_date{$t}{$d}" type="text" data-hex="true" class="datetimepicker" name="STMTickets[STMDates][{$t}][reservation_start_date][]" value="{$date['start_date']}" form="configuration_form">

										<span class="input-group-addon" id="all_726">
											<i class="icon-calendar-empty" id="all_727"></i>
										</span>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3 required" id="all_722">{l s='End Time' mod='stmeventscourses'}</label>

							<div class="col-lg-9" id="all_723">
								<div class="row" id="all_724">
									<div class="input-group col-lg-4" id="all_725">
										<input id="edit_reservation_end_date{$t}{$d}" type="text" data-hex="true" class="datetimepicker" name="STMTickets[STMDates][{$t}][reservation_end_date][]" value="{$date['end_date']}" form="configuration_form">

										<span class="input-group-addon" id="all_726">
											<i class="icon-calendar-empty" id="all_727"></i>
										</span>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group stmeField">
							<label class="control-label col-lg-3 required">{l s='Available Reservations' mod='stmeventscourses'}</label>

							<div class="col-lg-9">
								<input type="text" name="STMTickets[STMDates][{$t}][available_reservation][]" form="configuration_form" value="{$date['available_reservation']}">
							</div>
						</div>
					</fieldset>
					{/foreach}
				</div>
			</fieldset>

			<span class="hidden">
				{$t++}
			</span>
			{/foreach}
		</div>
	</div>

	<div class="panel-footer">
		<button type="submit" for="configuration_form" id="saveSTMEvent" name="saveSTMEvent" class="btn btn-default pull-right">
			<i class="process-icon-save" id="all_825"></i> {l s='Save' mod='stmeventscourses'}
		</button>

		<a href="javascript:;" id="addTicket" class="btn btn-default pull-right">
			<i class="process-icon-new"></i> {l s='Add Ticket' mod='stmeventscourses'}
		</a>
	</div>
</div>