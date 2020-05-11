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

		{l s='Events And Courses' mod='stmeventscourses'}
	</div>

	<div class="panel-body">
		<table class="event-table table">
			<tbody>
				<thead>
					<th>{l s='Event ID' mod='stmeventscourses'}</th>
					<th>{l s='Event Name' mod='stmeventscourses'}</th>
					<th>{l s='Course Name' mod='stmeventscourses'}</th>
					<th>{l s='Start Date' mod='stmeventscourses'}</th>
					<th>{l s='End Date' mod='stmeventscourses'}</th>
					<th>{l s='Actions' mod='stmeventscourses'}</th>
				</thead>
				{foreach $events as $event}
					{foreach $event['courses'] as $i => $course}
						{foreach $course.dates as $dc => $date}
						<tr>
							<td class="pointer">
								{if $i == 0 && $dc == 0}
									{$event.id_stm_event}
								{/if}
							</td>

							<td class="pointer">
								{if $i == 0 && $dc == 0}
									{$event.name}
								{/if}
							</td>

							<td class="pointer">
								{if $dc == 0}
									{$course.name}
								{/if}
							</td>

							<td class="pointer">{$date.start_date}</td>

							<td class="pointer">{$date.end_date}</td>

							<td class="pointer">
								{if $i == 0 && $dc == 0}
									<a target="_blank" href="/events/{$event.id_stm_event}-{$event.link_rewrite}">{l s='View'}</a> | 
									<a href="?controller=AdminModules&token={Tools::getValue('token')}&configure=stmeventscourses&editSTMEvent&id_stm_event={$event.id_stm_event}" class="edit_holiday_page">{l s='Edit'}</a> | 
									<a href="?controller=AdminModules&token={Tools::getValue('token')}&configure=stmeventscourses&deleteSTMEvent&id_stm_event={$event.id_stm_event}" class="delete_holiday_page">{l s='Delete'}</a>
								{/if}
							</td>
						</tr>
						{/foreach}
					{/foreach}
					<tr class="separator">
						<td colspan="15"></td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>

	<div class="panel-footer">
		<a href="?controller=AdminModules&token={Tools::getValue('token')}&configure=stmeventscourses&addSTMEvent" class="btn btn-default pull-right">
			<i class="process-icon-new"></i> Add New
		</a>
	</div>
</div>
{/if}