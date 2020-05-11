<style type="text/css">
	.ticketRow{
		cursor: pointer;
	}

	#checkAll{
		margin-left: 7px;
		margin-top: 8px;
	}

	.ticket_color_code{
		border-radius: 50%;
		width: 5px;
		height: 5px;
		display: inline-block;
		top: -2px;
		position: relative;
	}

	.bootstrap .table tbody > .ticketRow td{
		line-height: 30px;
	}

	.bootstrap a.list-group-item-sub{
		background-color: #666;
		color: #fff;
		border-color: #fff #666;
	}

	.bootstrap a.list-group-item-sub.active{
		background-color: #333;
		border-color: #333;
	}
</style>

<div class="productTabs col-lg-2 col-md-3">
	<div class="list-group">
		<a class="list-group-item {if $page == 'all'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}">All ({$counts['all']})</a>
		{if $page == 'all'}
			<a class="list-group-item list-group-item-sub {if $status == 'open'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=open">Open ({$counts['all-open']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'pending'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=pending">Pending ({$counts['all-pending']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'answered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=answered">Answered ({$counts['all-answered']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'resolved'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=resolved">Resolved ({$counts['all-resolved']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'closed'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=closed">Closed ({$counts['all-closed']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'spam'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=spam">Spam ({$counts['all-spam']})</a>
		{/if}

		<a class="list-group-item {if $page == 'new'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page=new">New ({$counts['new']})</a>
		{if $page == 'new'}
			<a class="list-group-item list-group-item-sub {if $status == 'open'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=open">Open ({$counts['new-open']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'pending'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=pending">Pending ({$counts['new-pending']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'answered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=answered">Answered ({$counts['new-answered']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'resolved'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=resolved">Resolved ({$counts['new-resolved']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'closed'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=closed">Closed ({$counts['new-closed']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'spam'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=spam">Spam ({$counts['new-spam']})</a>
		{/if}

		<a class="list-group-item {if $page == 'unassigned'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page=unassigned">UnAssigned ({$counts['unassigned']})</a>
		{if $page == 'unassigned'}
			<a class="list-group-item list-group-item-sub {if $status == 'open'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=open">Open ({$counts['unassigned-open']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'pending'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=pending">Pending ({$counts['unassigned-pending']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'answered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=answered">Answered ({$counts['unassigned-answered']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'resolved'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=resolved">Resolved ({$counts['unassigned-resolved']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'closed'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=closed">Closed ({$counts['unassigned-closed']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'spam'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=spam">Spam ({$counts['unassigned-spam']})</a>
		{/if}

		<a class="list-group-item {if $page == 'unanswered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page=unanswered">UnAnswered ({$counts['unanswered']})</a>
		{if $page == 'unanswered'}
			<a class="list-group-item list-group-item-sub {if $status == 'open'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=open">Open ({$counts['unanswered-open']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'pending'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=pending">Pending ({$counts['unanswered-pending']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'answered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=answered">Answered ({$counts['unanswered-answered']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'resolved'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=resolved">Resolved ({$counts['unanswered-resolved']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'closed'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=closed">Closed ({$counts['unanswered-closed']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'spam'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=spam">Spam ({$counts['unanswered-spam']})</a>
		{/if}

		<a class="list-group-item {if $page == 'mytickets'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page=mytickets">My Tickets ({$counts['mytickets']})</a>
		{if $page == 'mytickets'}
			<a class="list-group-item list-group-item-sub {if $status == 'open'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=open">Open ({$counts['mytickets-open']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'pending'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=pending">Pending ({$counts['mytickets-pending']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'answered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=answered">Answered ({$counts['mytickets-answered']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'resolved'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=resolved">Resolved ({$counts['mytickets-resolved']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'closed'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=closed">Closed ({$counts['mytickets-closed']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'spam'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=spam">Spam ({$counts['mytickets-spam']})</a>
		{/if}

		<a class="list-group-item {if $page == 'starred'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page=starred">Starred ({$counts['starred']})</a>
		{if $page == 'starred'}
			<a class="list-group-item list-group-item-sub {if $status == 'open'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=open">Open ({$counts['starred-open']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'pending'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=pending">Pending ({$counts['starred-pending']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'answered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=answered">Answered ({$counts['starred-answered']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'resolved'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=resolved">Resolved ({$counts['starred-resolved']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'closed'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=closed">Closed ({$counts['starred-closed']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'spam'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=spam">Spam ({$counts['starred-spam']})</a>
		{/if}

		<a class="list-group-item {if $page == 'trashed'}active{/if}" hrefs="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page=trashed">Trashed ({$counts['trashed']})</a>
		{if $page == 'trashed'}
			<a class="list-group-item list-group-item-sub {if $status == 'open'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=open">Open ({$counts['trashed-open']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'pending'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=pending">Pending ({$counts['trashed-pending']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'answered'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=answered">Answered ({$counts['trashed-answered']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'resolved'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=resolved">Resolved ({$counts['trashed-resolved']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'closed'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=closed">Closed ({$counts['trashed-closed']})</a>
			<a class="list-group-item list-group-item-sub {if $status == 'spam'}active{/if}" href="index.php?controller=AdminTicketing&token={Tools::getValue('token')}&page={$page}&status=spam">Spam ({$counts['trashed-spam']})</a>
		{/if}
	</div>
</div>

<div class="panel col-md-9 col-lg-10">
	{include file="./all.tpl"}
</div>

<script type="text/javascript">
	var baseUrl = window.location.href;

	$('.ticket_is_starred').click(function(){
		var that = $(this);
		var isStarred = that.hasClass('icon-star');
		var id_ticket = that.data('id');

		var value = 0;

		if(isStarred){
			this.className = 'icon-star-empty ticket_is_starred';
			value = 0;
		}else{
			this.className = 'icon-star ticket_is_starred';
			value = 1;
		}

		$.ajax({
			url: baseUrl + '&action=isStarred',
			type: 'POST',
			data: {
				value: value,
				id_ticket: id_ticket
			}
		});
	});

	$('.ticketRow > td:not(.noclick)').click(function(){
		var t = this, that = $(t);
		var id_ticket = that.parent().data('id');

		$.fancybox({
			type: 'iframe',
			href: baseUrl + '&action=edit&id_ticket=' + id_ticket + '&content_only=1',
			width: 1320
		});
	});

	$('#checkAll').click(function(){
		var isChecked = $(this).prop('checked');

		$('.ticketRow .selectTicket').prop('checked', isChecked);
	});
</script>