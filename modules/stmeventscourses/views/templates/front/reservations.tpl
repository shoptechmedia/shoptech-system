<table class="table">
	<thead>
		<th>{l s='Event' mod='stmeventscourses'}</th>
		<th>{l s='Course' mod='stmeventscourses'}</th>
		<th>{l s='Start Date' mod='stmeventscourses'}</th>
		<th>{l s='End Date' mod='stmeventscourses'}</th>
		<th></th>
	</thead>
	<tbody>
	{foreach $reservations as $reservation}
		<tr>
			<td class="pointer">
				<a href="/events/{$reservation.id_stm_event}-{$reservation.link_rewrite}">{$reservation.event}</a>
			</td>
			<td class="pointer">{$reservation.name}</td>
			<td class="pointer">{$reservation.start_date}</td>
			<td class="pointer">{$reservation.end_date}</td>
			<td class="pointer" style="position: relative;">
				<a href="/events/{$reservation.id_stm_event}-{$reservation.link_rewrite}">{l s='Go To Event' mod='stmeventscourses'}</a>
				{if $reservation.cancelable}
					<div class="hidden STMPopup">
						<span class="STMClose fa fa-close"></span>

						{$availability = false}
						{foreach $reservation.dates as $date}
							{if $date.available_reservation > 0}
								{$availability = true}
							{/if}

							{if  $date.available_reservation > 0}
							<label>
								<input {if $date.id_reservation_date == $reservation.id_reservation_date}checked="checked"{/if} class="STMReschedule" type="radio" data-id_reservation="{$reservation.id_reservation}" data-available_reservation="{$date.available_reservation}" value="{$date.id_reservation_date}" />

								{l s='From' mod='stmeventscourses'} <strong>{$date.start_date}</strong>
								{l s='to' mod='stmeventscourses'} <strong>{$date.end_date}</strong>
							</label>
							{/if}
						{/foreach}

						<p><strong>{l s='Note: Please cancel reservation' mod='stmeventscourses'} {$reservation.cancelation_period} {l s='days before event' mod='stmeventscourses'}</strong></p>
					</div>

				 | <a class="STMShowPopup" href="javascript:;">{l s='Change Schedule' mod='stmeventscourses'}</a>
				{/if}
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>