<style type="text/css">
	#main,
	#content.bootstrap{
		padding: 0;
		margin: 0;
	}

	h4{
		display: inline-block;
	}

	.bootstrap .ticketOptions .row,
	.ticket-reply {
		margin: 0 0;
		padding: 20px 0;
		border-top: 1px solid;
	}

	.bootstrap .ticketOptions .row:first-child,
	.ticket-reply:first-child {
		padding-top: 0;
		border-top: 0;
	}

	.thread{
		max-height: 550px;
		overflow-y: auto;
		overflow-x: hidden;
	}

	.list-toolbar-btn{
		position: relative;
	}

	.bootstrap .media, .bootstrap .message-item, .bootstrap .media-body{
		overflow: visible;
	}

	.bootstrap .media-body{
		float: right;
		width: calc(100% - 100px);
	}

	.bootstrap a.active{
		color: red;
	}
</style>

<div class="ticketOptions column col-xs-12 col-md-4">
	<h1>{$ticket.subject}</h1>

	<div class="row">
		<h4>{l s='Customer Information'}</h4>

		<p>
			- {$user.name}<br/>
			- {$user.email}
		</p>

		<h4>{l s='Total Replies'}</h4>
		<p>{$ticket.reply_count}</p>

		<h4>{l s='TimeStamp'}</h4>
		<p>{$ticket.date_add}</p>

		<h4>{l s='Channel'}</h4>
		<p>{$ticket.source}</p>
	</div>

	<div class="row">
		<h4>{l s='Agent'}</h4>
		<p>
			<select name="Ticket-Agent">
			{foreach $agents as $option}
				<option {if $option.id == $agent.id}selected{/if} value="{$option.id}">{$option.name}</option>
			{/foreach}
			</select>
		</p>

		<h4>{l s='Priority'}</h4>
		<p>
			<select name="Ticket-Priority">
			{foreach $priorities as $option}
				<option {if $option.id == $ticket.priority_id}selected{/if} value="{$option.id}">{$option.name}</option>
			{/foreach}
			</select>
		</p>

		<h4>{l s='Status'}</h4>
		<p>
			<select name="Ticket-Status">
			{foreach $statuses as $option}
				<option {if $option.id == $ticket.status_id}selected{/if} value="{$option.id}">{$option.name}</option>
			{/foreach}
			</select>
		</p>

		<h4>{l s='Type'}</h4>
		<p>
			<select name="Ticket-Type">
			{foreach $types as $option}
				<option {if $option.id == $ticket.type_id}selected{/if} value="{$option.id}">{$option.name}</option>
			{/foreach}
			</select>
		</p>

		<h4>{l s='Group'}</h4>
		<p>
			<select name="Ticket-Group">
			{foreach $groups as $option}
				<option {if $option.id == $ticket.group_id}selected{/if} value="{$option.id}">{$option.name}</option>
			{/foreach}
			</select>
		</p>

		<h4>{l s='Team'}</h4>
		<p>
			<select name="Ticket-Team">
			{foreach $teams as $option}
				<option {if $option.id == $ticket.team_id}selected{/if} value="{$option.id}">{$option.name}</option>
			{/foreach}
			</select>
		</p>
	</div>
</div>

<div class="column col-xs-12 col-md-8">
	<div class="thread panel">
		{foreach $thread as $reply}

		<div class="row ticket-reply thread-{$reply.id} {$reply.type}">
			<div class="message-item-initial media">
				<a href="javascript:;" class="avatar-lg pull-left"><i class="icon-user icon-3x"></i></a>

				<div class="media-body">
					<div class="row">
						<div class="col-sm-6">
							<h2>
								{$reply.user_name} <small>({$reply.user_email})</small>
							</h2>
						</div>

						<div class="col-sm-6">
							<p class="text-muted col-sm-8">Kunde siden: {$reply.created_at}</p>

							<a onclick="editReply('{$reply.id}')" class="list-toolbar-btn" href="javascript:;">
								<span class="label-tooltip" data-toggle="tooltip" title="Edit Thread" data-html="true" data-placement="top">
									<i class="icon-edit"></i>
								</span>
							</a>&nbsp;

							<a onclick="pinReply('{$reply.id}')" class="list-toolbar-btn {if $reply.is_bookmarked}active{/if}" href="javascript:;">
								<span class="label-tooltip" data-toggle="tooltip" title="Pin Thread" data-html="true" data-placement="top">
									<i class="icon-thumb-tack"></i>
								</span>
							</a>&nbsp;

							<a onclick="lockReply('{$reply.id}')" class="list-toolbar-btn {if $reply.is_locked}active{/if}" href="javascript:;">
								<span class="label-tooltip" data-toggle="tooltip" title="Lock Thread" data-html="true" data-placement="top">
									<i class="icon-lock"></i>
								</span>
							</a>&nbsp;

							<a onclick="forwardReply('{$reply.id}')" class="list-toolbar-btn" href="javascript:;">
								<span class="label-tooltip" data-toggle="tooltip" title="Forward" data-html="true" data-placement="top">
									<i class="icon-mail-forward"></i>
								</span>
							</a>&nbsp;

							<a onclick="deleteReply('{$reply.id}')" class="list-toolbar-btn" href="javascript:;">
								<span class="label-tooltip" data-toggle="tooltip" title="Delete Thread" data-html="true" data-placement="top">
									<i class="icon-trash"></i>
								</span>
							</a>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="message-item-initial-body">
								<div class="message-body">
									{$reply.message}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{/foreach}
	</div>

	<div class="panel">
		<div class="form-horizontal" id="ReplyForm">
			<h3>Dit svar til Roger Ekström </h3>

			<div class="row">
				<div class="media">
					<div class="pull-left">
						<span class="avatar-md"><i class="icon-user icon-3x"></i></span>
					</div>

					<div>
						<input type="hidden" id="id_thread" value="">
					</div>

					<div class="media-body">
						<div>
							<input type="hidden" id="msg_email" value="{$user.email}">
						</div>

						<div>
							<input type="hidden" id="subject" value="{$ticket.subject}">
						</div>

						<textarea class="autoload_rte" cols="30" rows="7" id="message"></textarea>
					</div>
				</div>
			</div>

			<div class="panel-footer">
				<button type="button" class="btn btn-default pull-right" id="submitReply"><i class="process-icon-mail-reply"></i> Send</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// <![CDATA[
		ThickboxI18nImage = "Image";
		ThickboxI18nOf = "of";
		ThickboxI18nClose = "Close";
		ThickboxI18nOrEscKey = "(or &quot;Esc&quot;)";
		ThickboxI18nNext = "Next &gt;";
		ThickboxI18nPrev = "&lt; Previous";
		tb_pathToImage = "../img/loadingAnimation.gif";
	//]]>

	var iso = 'en';
	var pathCSS = '/themes/shoptech/css/';
	var ad = '/login888';
</script>

<script type="text/javascript">
var forwarding = false;

var scrollToLastReply = function(){
	var d = $('.thread');
		d.scrollTop(d.prop("scrollHeight"));
};

var refreshThread = function(callback){
	$.ajax({
		url: window.location.href,

		success: function(res){
			var replies = $(res).find('.thread').html();

			$('.thread').html(replies);

			if(typeof callback == 'function')
				callback();

			scrollToLastReply();
		}
	});
}

var editReply = function(id_thread){
	var form = $('#ReplyForm');

	var thread = $('.thread-' + id_thread);
	var message = thread.find('.message-body').html();

	form.find('#id_thread').val(id_thread);

	tinyMCE.activeEditor.setContent(message);
	// tinymce.activeEditor.execCommand('mceInsertContent', false, message);
	// form.find('#message').html(message);
};

var pinReply = function(id_thread){
	$.ajax({
		url: window.location.href,
		type: 'POST',
		data: {
			ajax: 1,
			action: 'pinReply',
			id_thread: id_thread,
		},

		success: function() {
			refreshThread();
		}
	});
};

var lockReply = function(id_thread){
	$.ajax({
		url: window.location.href,
		type: 'POST',
		data: {
			ajax: 1,
			action: 'lockReply',
			id_thread: id_thread,
		},

		success: function() {
			refreshThread();
		}
	});
};

var forwardReply = function(id_thread){
	var form = $('#ReplyForm');
	var hidden_fields = form.find('#subject, #msg_email');

	hidden_fields.attr('type', 'text');

	form.find('#id_thread').val(id_thread);

	forwarding = true;
};

var deleteReply = function(id_thread){
	$.ajax({
		url: window.location.href,
		type: 'POST',
		data: {
			ajax: 1,
			action: 'deleteReply',
			id_thread: id_thread,
		},

		success: function() {
			refreshThread();
		}
	});
};

$(function(){
	var form = $('#ReplyForm');

	scrollToLastReply();

	tinySetup({
		editor_selector :"autoload_rte",

		setup : function(ed) {
			ed.on('init', function(ed)
			{
				if (typeof ProductMultishop.load_tinymce[ed.target.id] != 'undefined')
				{
					if (typeof ProductMultishop.load_tinymce[ed.target.id])
						tinyMCE.get(ed.target.id).hide();
					else
						tinyMCE.get(ed.target.id).show();
				}
			});

			ed.on('keydown', function(ed, e) {
				tinyMCE.triggerSave();
				textarea = $('#'+tinymce.activeEditor.id);
				var max = textarea.parent('div').find('span.counter').data('max');
				if (max != 'none')
				{
					count = tinyMCE.activeEditor.getBody().textContent.length;
					rest = max - count;
					if (rest < 0)
						textarea.parent('div').find('span.counter').html('<span style="color:red;">Maximum '+ max +' characters : '+rest+'</span>');
					else
						textarea.parent('div').find('span.counter').html(' ');
				}
			});
		}
	});


	$('.list-toolbar-btn').tooltip();

	$('.ticketOptions select').change(function(){
		var t = this;
		var that = $(t);
		var action = 'saveEdit';

		var subaction = t.name;

		$.ajax({
			url: window.location.href,

			type: 'POST',

			data: {
				ajax: 1,
				action: action,
				subaction: subaction,
				value: that.val()
			}
		});
	});

	$('#submitReply').click(function(e){
		e.preventDefault();

		var t = this;
		var that = $(t);

		var id_thread = form.find('#id_thread').val();
		var email = form.find('#msg_email').val();
		var subject = form.find('#subject').val();
		var message = tinymce.activeEditor.getContent();

		var action = 'saveReply';

		if(forwarding)
			action = 'forwardReply';

		$.ajax({
			url: window.location.href,
			type: 'POST',
			data: {
				ajax: 1,
				action: action,
				id_thread: id_thread,
				email: email,
				subject: subject,
				message: message,
				id_user: '{$agent.id}'
			},

			success: function() {
				refreshThread(function(){
					form.find('#id_thread').val('');
					form.find('#message').val('');
					form.find('#subject').val('');
					form.find('#msg_email').val('');
					tinyMCE.activeEditor.setContent('');
				});
			}
		});
	});
});
</script>