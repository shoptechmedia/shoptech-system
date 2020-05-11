<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:59:27
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/import/modal_import_progress.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0076f5869f6_49346339',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f569024769a0c243bc8022843058edfd64430e87' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/import/modal_import_progress.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0076f5869f6_49346339 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="modal-body">
	<div class="alert alert-warning" id="import_details_stop" style="display:none;">
		Aborting, please wait...
	</div>
	<p id="import_details_progressing">
		Importing your data...
	</p>
	<div class="alert alert-success" id="import_details_finished" style="display:none;">
		Data imported!
		<br/>
		Look at your listings to make sure it's all there as you wished.
	</div>
	<div id="import_messages_div" style="max-height:250px; overflow:auto;">
		<div class="alert alert-danger" id="import_details_error" style="display:none;">
			Errors occurred:<br/><ul></ul>
		</div>
		<div class="alert alert-warning" id="import_details_post_limit" style="display:none;">
			Warning, the current import MAY require a PHP setting update, to allow more
			data to be transferred. If the current import stops before the end, you should increase your PHP "post_max_size" setting to
			<span id="import_details_post_limit_value">16MB</span> at least, and try again.
		</div>
		<div class="alert alert-warning" id="import_details_warning" style="display:none;">
			Some errors were detected. Please check the details:<br/><ul></ul>
		</div>
		<div class="alert alert-info" id="import_details_info" style="display:none;">
			We made the following adjustments:<br/><ul></ul>
		</div>
	</div>

	<div id="import_validate_div" style="margin-top:17px;">
		<div class="pull-right" id="import_validation_details" default-value="Validating data...">
			&nbsp;
		</div>
		<div class="progress active progress-striped" style="display: block; width: 100%">
			<div class="progress-bar progress-bar-info" role="progressbar" style="width: 0%" id="validate_progressbar_done">
				<span><span id="validate_progression_done">0</span>% Validated</span>
			</div>
			<div class="progress-bar progress-bar-info" role="progressbar" id="validate_progressbar_next" style="opacity: 0.5 ;width: 0%">
				<span class="sr-only">Processing next page...</span>
			</div>
		</div>
	</div>

	<div id="import_progress_div" style="display:none;">
		<div class="pull-right" id="import_progression_details" default-value="Importing data...">
			&nbsp;
		</div>
		<div class="progress active progress-striped" style="display: block; width: 100%">
			<div class="progress-bar progress-bar-info" role="progressbar" style="width: 0%" id="import_progressbar_done2">
				<span>Linking accessories...</span>
			</div>
			<div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%" id="import_progressbar_done">
				<span><span id="import_progression_done">0</span>% Imported</span>
			</div>
			<div class="progress-bar progress-bar-success progress-bar-stripes active" role="progressbar" id="import_progressbar_next" style="opacity: 0.5 ;width: 0%">
				<span class="sr-only">Processing next page...</span>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<div class="input-group pull-right">
			<button type="button" class="btn btn-primary" tabindex="-1" id="import_continue_button" style="display: none;">
				<?php echo smartyTranslate(array('s'=>"Ignore warnings and continue?"),$_smarty_tpl);?>

			</button>
			&nbsp;
			<button type="button" class="btn btn-default" tabindex="-1" id="import_stop_button">
				<?php echo smartyTranslate(array('s'=>"Abort import"),$_smarty_tpl);?>

			</button>
			&nbsp;
			<button type="button" class="btn btn-success" data-dismiss="modal" tabindex="-1" id="import_close_button" style="display: none;">
				<?php echo smartyTranslate(array('s'=>"Close"),$_smarty_tpl);?>

			</button>
		</div>
	</div>
</div>
<?php }
}
