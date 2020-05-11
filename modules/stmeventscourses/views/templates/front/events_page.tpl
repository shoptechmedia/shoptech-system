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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<h1 class="page-heading product-listing">
	<span class="cat-name">{$page_title}</span>
</h1>

{$youtube_embed}

<p>
	<strong>{l s='Location' mod='stmeventscourses'}:</strong> {$event->venue}
</p>

<div class="event-description">
	{$event->description}
</div>

{if $event->buy_pack}
<h4 class="event-price">
	<strong>{l s='Price as Pack' mod='stmeventscourses'}: {displayPrice price=Product::getPriceStatic($event->id_product)}</strong>
</h4>

	{if $isLoggedin}
	<div style="position: relative;margin-bottom: 15px;">
		<a class="STMShowPopup btn btn-default button button-small">
			<span>{l s='Reserve Pack' mod='stmeventscourses'}</span>
		</a>

		<div class="hidden STMPopup STMForPack">
			<span class="STMClose fa fa-close"></span>

			<h4>{$ticket.name}</h4>

			{$availability = false}
			{foreach $ticket.dates as $index => $date}
				{if $date.available_reservation > 0}
					{$availability = true}
				{/if}

				{if  $date.available_reservation > 0}
				<label>
					<input class="STMReserve {if $index == 0}STMReserve_default{/if}" name="STMReserve-{$ticket.id_product}" type="radio" data-id_product="{$ticket.id_product}" data-available_reservation="{$date.available_reservation}" value="{$date.id_reservation_date}"/>

					{l s='From' mod='stmeventscourses'} <strong>{$date.start_date}</strong>
					{l s='to' mod='stmeventscourses'} <strong>{$date.end_date}</strong>
				</label>
				{/if}
			{/foreach}

			<label>
				<input type="hidden" class="STMPack" checked="checked" data-id_pack="{$event->id_product}">
			</label>

			{if $event->buy_pack}
				{foreach $tickets as $additionalTicket}

				{if $additionalTicket.id_product != $ticket.id_product}
				<div class="STMAdditionalDates">

					<h4>{$additionalTicket.name}</h4>

					{$additionalAvailability = false}
					{foreach $additionalTicket.dates as $index => $date}
						{if  $date.available_reservation > 0}
						<label>
							{$additionalAvailability = true}
							<input class="STMReserve {if $index == 0}STMReserve_default{/if}" name="STMReserve-{$additionalTicket.id_product}" type="radio" data-id_product="{$additionalTicket.id_product}" data-available_reservation="{$date.available_reservation}" value="{$date.id_reservation_date}" />

							{l s='From' mod='stmeventscourses'} <strong>{$date.start_date}</strong>
							{l s='to' mod='stmeventscourses'} <strong>{$date.end_date}</strong>
						</label>
						{/if}
					{/foreach}
				</div>
				{/if}

				{/foreach}
			{/if}

			<p><strong>{l s='Note: Please cancel reservation' mod='stmeventscourses'} {$event->cancelation_period} {l s='days before event' mod='stmeventscourses'}</strong></p>

			<a class="STMReserveNow btn btn-default button button-small">
				<span>{l s='Reserve' mod='stmeventscourses'}</span>
			</a>
		</div>
	</div>
	{/if}
{/if}

<div class="event-tickets">
	{foreach $tickets as $ticket}
	<div class="event-ticket">
		<img src="{$ticket.cover}" alt="{$ticket.name}"/>

		<div class="ticket-details">
			<h3>
				{$ticket.name}
			</h3>

			{if $ticket.description}
			<div class="EventsDescription">
				{$ticket.description}
			</div>
			{/if}

			<div class="button-container">
				{if !$ticket.isReserved}
				<div class="hidden STMPopup HideFor-{$ticket.id_product}">
					<span class="STMClose fa fa-close"></span>

					<h4>{$ticket.name}</h4>

					{$availability = false}
					{foreach $ticket.dates as $index => $date}
						{if $date.available_reservation > 0}
							{$availability = true}
						{/if}

						{if  $date.available_reservation > 0}
						<label>
							<input class="STMReserve {if $index == 0}STMReserve_default{/if}" name="STMReserve-{$ticket.id_product}" type="radio" data-id_product="{$ticket.id_product}" data-available_reservation="{$date.available_reservation}" value="{$date.id_reservation_date}"/>

							{l s='From' mod='stmeventscourses'} <strong>{$date.start_date}</strong>
							{l s='to' mod='stmeventscourses'} <strong>{$date.end_date}</strong>
						</label>
						{/if}
					{/foreach}

					<p><strong>{l s='Note: Please cancel reservation' mod='stmeventscourses'} {$event->cancelation_period} {l s='days before event' mod='stmeventscourses'}</strong></p>

					<a class="STMReserveNow btn btn-default button button-small">
						<span>{l s='Reserve' mod='stmeventscourses'}</span>
					</a>
				</div>
				{/if}

				{foreach $ticket.dates as $date}
					{if  $date.available_reservation > 0}
					<p>
						{l s='From' mod='stmeventscourses'} <strong>{$date.start_date}</strong>
						{l s='to' mod='stmeventscourses'} <strong>{$date.end_date}</strong>
					</p>
					{/if}
				{/foreach}

				{if $event->buy_one}
				<strong class="price">{displayPrice price=$ticket.price}</strong>
				{/if}

				{if !$ticket.isReserved && $availability}
				<a class="STMShowPopup btn btn-default button button-small HideFor-{$ticket.id_product}">
					<span>{l s='Reserve Course' mod='stmeventscourses'}</span>
				</a>
				{elseif !$isLoggedin}
				<a class="btn btn-default button button-small STM_LOGIN_POPUP" href="/my-account" style="color: red;">
					<span>{l s='Buy Now'}</span>
				</a>
				{/if}
			</div>

			{if $ticket.description}
			<a href="javscript:;" class="btn btn-default button button-small EventsDescription-more" alternateTextContent="{l s='Show Less' mod='stmeventscourses'}" originalTextContent="{l s='Show More' mod='stmeventscourses'}">
				<span>{l s='Show More' mod='stmeventscourses'}</span>
			</a>
			{/if}
		</div>
	</div>
	{/foreach}
</div>

<script type="text/javascript" data-keepinline="true">
	var YouMustLogin = '{l s='To buy tickets, signup or signin here' mod='stmeventscourses'}'
</script>