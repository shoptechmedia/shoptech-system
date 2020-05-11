<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:46:07
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules_positions/form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff63f37f4e8_17469891',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4ac7a112be126c5ed1c65f0f2a9b32e5c5cca0b' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules_positions/form.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ff63f37f4e8_17469891 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>


<div class="leadin"><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6167626155e9ff63f34c849_50835762', "leadin");
?>
</div>

<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_submit']->value, ENT_QUOTES, 'UTF-8', true);?>
" id="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form" method="post" class="form-horizontal">
	<?php if ($_smarty_tpl->tpl_vars['display_key']->value) {?>
		<input type="hidden" name="show_modules" value="<?php echo $_smarty_tpl->tpl_vars['display_key']->value;?>
" />
	<?php }?>
	<div class="panel">
		<h3>
			<i class="icon-paste"></i>
			<?php echo smartyTranslate(array('s'=>'Transplant a module'),$_smarty_tpl);?>

		</h3>
		<div class="form-group">
			<label class="control-label col-lg-3 required"> <?php echo smartyTranslate(array('s'=>'Module'),$_smarty_tpl);?>
</label>
			<div class="col-lg-9">
				<select name="id_module" <?php if ($_smarty_tpl->tpl_vars['edit_graft']->value) {?> disabled="disabled"<?php }?>>
					<?php if (!$_smarty_tpl->tpl_vars['hooks']->value) {?>
						<option value="0"><?php echo smartyTranslate(array('s'=>'Please select a module'),$_smarty_tpl);?>
</option>
					<?php }?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['modules']->value, 'module');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['module']->value) {
?>
						<option value="<?php echo intval($_smarty_tpl->tpl_vars['module']->value->id);?>
"<?php if ($_smarty_tpl->tpl_vars['id_module']->value == $_smarty_tpl->tpl_vars['module']->value->id || (!$_smarty_tpl->tpl_vars['id_module']->value && $_smarty_tpl->tpl_vars['show_modules']->value == $_smarty_tpl->tpl_vars['module']->value->id)) {?> selected="selected"<?php }?>><?php echo stripslashes($_smarty_tpl->tpl_vars['module']->value->displayName);?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3 required"> <?php echo smartyTranslate(array('s'=>'Transplant to'),$_smarty_tpl);?>
</label>
			<div class="col-lg-9">
				<select name="id_hook"<?php if (!count($_smarty_tpl->tpl_vars['hooks']->value)) {?> disabled="disabled"<?php }?>>
					<?php if (!$_smarty_tpl->tpl_vars['hooks']->value) {?>
						<option value="0"><?php echo smartyTranslate(array('s'=>'Select a module above before choosing from available hooks'),$_smarty_tpl);?>
</option>
					<?php } else { ?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hooks']->value, 'hook');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['hook']->value) {
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
" <?php if ($_smarty_tpl->tpl_vars['id_hook']->value == $_smarty_tpl->tpl_vars['hook']->value['id_hook']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['hook']->value['name'];
if ($_smarty_tpl->tpl_vars['hook']->value['name'] != $_smarty_tpl->tpl_vars['hook']->value['title']) {?> (<?php echo $_smarty_tpl->tpl_vars['hook']->value['title'];?>
)<?php }?></option>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					<?php }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Exceptions'),$_smarty_tpl);?>
</label>
			<div class="col-lg-9">
				<div class="well">
					<div>
						<?php echo smartyTranslate(array('s'=>'Please specify the files for which you do not want the module to be displayed.'),$_smarty_tpl);?>
<br />
						<?php echo smartyTranslate(array('s'=>'Please input each filename, separated by a comma (",").'),$_smarty_tpl);?>
<br />
						<?php echo smartyTranslate(array('s'=>'You can also click the filename in the list below, and even make a multiple selection by keeping the Ctrl key pressed while clicking, or choose a whole range of filename by keeping the Shift key pressed while clicking.'),$_smarty_tpl);?>
<br />
						<?php if (!$_smarty_tpl->tpl_vars['except_diff']->value) {?>
							<?php echo $_smarty_tpl->tpl_vars['exception_list']->value;?>

						<?php } else { ?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['exception_list_diff']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
								<?php echo $_smarty_tpl->tpl_vars['value']->value;?>

							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<?php if ($_smarty_tpl->tpl_vars['edit_graft']->value) {?>
				<input type="hidden" name="id_module" value="<?php echo $_smarty_tpl->tpl_vars['id_module']->value;?>
" />
				<input type="hidden" name="id_hook" value="<?php echo $_smarty_tpl->tpl_vars['id_hook']->value;?>
" />
			<?php }?>
			<button type="submit" name="<?php if ($_smarty_tpl->tpl_vars['edit_graft']->value) {?>submitEditGraft<?php } else { ?>submitAddToHook<?php }?>" id="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form_submit_btn" class="btn btn-default pull-right"><i class="process-icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
</button>
		</div>
	</div>
</form>
<?php echo '<script'; ?>
 type="text/javascript">
	//<![CDATA
	function position_exception_textchange() {
		// TODO : Add & Remove automatically the "custom pages" in the "em_list_x"
		var obj = $(this);
		var shopID = obj.attr('id').replace(/\D/g, '');
		var list = obj.closest('form').find('#em_list_' + shopID);
		var values = obj.val().split(',');
		var len = values.length;

		list.find('option').prop('selected', false);
		for (var i = 0; i < len; i++)
			list.find('option[value="' + $.trim(values[i]) + '"]').prop('selected', true);
	}
	function position_exception_listchange() {
		var obj = $(this);
		var shopID = obj.attr('id').replace(/\D/g, '');
		var val = obj.val();
		var str = '';
		if (val)
			str = val.join(', ');
		obj.closest('form').find('#em_text_' + shopID).val(str);
	}
	$(document).ready(function(){
		$('form[id="hook_module_form"] input[id^="em_text_"]').each(function(){
			$(this).change(position_exception_textchange).change();
		});
		$('form[id="hook_module_form"] select[id^="em_list_"]').each(function(){
			$(this).change(position_exception_listchange);
		});
	});
	//]]>
<?php echo '</script'; ?>
>
<?php }
/* {block "leadin"} */
class Block_6167626155e9ff63f34c849_50835762 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'leadin' => 
  array (
    0 => 'Block_6167626155e9ff63f34c849_50835762',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "leadin"} */
}
