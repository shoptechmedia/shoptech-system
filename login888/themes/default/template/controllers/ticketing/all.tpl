<div class="panel-heading">
	{l s='Tickets'}
</div>

<div class="table-responsive-row clearfix">
	<form action="index.php?controller={Tools::getValue('controller')}&token={Tools::getValue('token')}" method="post">
		<table class="table">
			<thead>
				<tr class="nodrag nodrop">
					<th></th>
					<th>{l s='ID'}</th>
					<th>{l s='Subject'}</th>
					<th>{l s='Customer Name'}</th>
					<th>{l s='Customer Email'}</th>
					<th>{l s='Timestamp'}</th>
					<th>{l s='Type'}</th>
					<th>{l s='Replies'}</th>
					<th>{l s='Agent'}</th>
					<th>{l s='Source'}</th>
					<th></th>
				</tr>

				<tr class="nodrag nodrop">
					<th><input type="checkbox" id="checkAll"/></th>

					<th><input type="text" name="filter[id]" value="{$filter.id}" /></th>

					<th><input type="text" name="filter[subject]" value="{$filter.subject}" /></th>

					<th><input type="text" name="filter[customer_name]" value="{$filter.customer_name}" /></th>

					<th><input type="text" name="filter[customer_email]" value="{$filter.customer_email}" /></th>

					<th><input type="text" name="filter[timestamp]" value="{$filter.timestamp}" /></th>

					<th><input type="text" name="filter[type]" value="{$filter.type}" /></th>

					<th><input type="text" name="filter[replies]" value="{$filter.replies}" /></th>

					<th><input type="text" name="filter[agent]" value="{$filter.agent}" /></th>

					<th><input type="text" name="filter[source]" value="{$filter.source}" /></th>

					<th>
						<button type="submit" id="submitFilter" class="btn btn-default">
							<i class="icon-search"></i> Search
						</button>
					</th>
				</tr>
			</thead>

			<tbody>
				{foreach $tickets as $ticket}
				<tr class="ticketRow" data-id="{$ticket.id_ticket}">
					<td class="noclick" width="60">
						<span class="ticket_color_code" style="background-color: {$ticket.color_code};"></span>
						<input type="checkbox" class="selectTicket" name="selectTicket[]" value="{$ticket.id_ticket}">
						<a data-id="{$ticket.id_ticket}" class="{if $ticket.is_starred}icon-star{else}icon-star-empty{/if} ticket_is_starred" href="javascript:;"></a>
					</td>
					<td width="50" class="text-center">{$ticket.id_ticket}</td>
					<td>{$ticket.subject}</td>
					<td>{$ticket.name}</td>
					<td>{$ticket.email}</td>
					<td>{$ticket.date_add}</td>
					<td>{$ticket.type}</td>
					<td>{$ticket.reply_count|abs}</td>
					<td>{$ticket.agent}</td>
					<td>{$ticket.source}</td>
					<td class="noclick">
						<a href="javascript:;" class="btn btn-default">
							<i class="icon-search"></i> View
						</a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</form>
</div>