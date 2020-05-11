<?php
/* Smarty version 3.1.31, created on 2020-04-23 09:36:17
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/countries/helpers/form/form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea13761a685b3_18182174',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d2aa6e80bd31bc6c34199e8575918d0f5c415ab' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/countries/helpers/form/form.tpl',
      1 => 1587623776,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea13761a685b3_18182174 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21239436455ea13761a47535_79130426', "field");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7155479565ea13761a5db82_98710563', "input_row");
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7029757525ea13761a65f93_93121737', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/form/form.tpl");
}
/* {block "field"} */
class Block_21239436455ea13761a47535_79130426 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'field' => 
  array (
    0 => 'Block_21239436455ea13761a47535_79130426',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['input']->value['type'] == 'address_layout') {?>
		<div class="col-lg-9 px-0">
			<div class="form-group">
				<div class="col-lg-4 pl-0 pull-left">
					<textarea class="form-control" id="ordered_fields" name="address_layout" style="height:150px;"><?php echo $_smarty_tpl->tpl_vars['input']->value['address_layout'];?>
</textarea>
				</div>
				<div class="col-lg-8 pr-0 pull-right">
					<?php echo smartyTranslate(array('s'=>'Required fields for the address (click for more details):'),$_smarty_tpl);?>

					<?php echo $_smarty_tpl->tpl_vars['input']->value['display_valid_fields'];?>

				</div>
			</div>			
			<div class="d-inline-block w-100 mt-4">
				<div class="col-lg-12 px-0">
					<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'This will restore your last registered address format.'),$_smarty_tpl);?>
" data-html="true"><a id="useLastDefaultLayout" href="javascript:void(0)" onclick="resetLayout('<?php echo $_smarty_tpl->tpl_vars['input']->value['encoding_address_layout'];?>
', 'lastDefault');" class="btn btn-default">
						<?php echo smartyTranslate(array('s'=>'Use the last registered format'),$_smarty_tpl);?>
</a></span>
					<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'This will restore the default address format for this country.'),$_smarty_tpl);?>
" data-html="true"><a id="useDefaultLayoutSystem" href="javascript:void(0)" onclick="resetLayout('<?php echo $_smarty_tpl->tpl_vars['input']->value['encoding_default_layout'];?>
', 'defaultSystem');" class="btn btn-default">
						<?php echo smartyTranslate(array('s'=>'Use the default format'),$_smarty_tpl);?>
</a></span>
					<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'This will restore your current address format.'),$_smarty_tpl);?>
" data-html="true"><a id="useCurrentLastModifiedLayout" href="javascript:void(0)" onclick="resetLayout(lastLayoutModified, 'currentModified')" class="btn btn-default">
						<?php echo smartyTranslate(array('s'=>'Use my current modified format'),$_smarty_tpl);?>
</a></span>
					<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'This will delete the current address format'),$_smarty_tpl);?>
" data-html="true"><a id="eraseCurrentLayout" href="javascript:void(0)" onclick="resetLayout('', 'erase');" class="btn btn-default">
						<i class="icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear format'),$_smarty_tpl);?>
</a></span>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

	<?php }
}
}
/* {/block "field"} */
/* {block "input_row"} */
class Block_7155479565ea13761a5db82_98710563 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input_row' => 
  array (
    0 => 'Block_7155479565ea13761a5db82_98710563',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'standardization') {?>
		<div class="form-group" id="TAASC" style="display: none;">
			<label for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" class="control-label col-lg-3"><?php echo $_smarty_tpl->tpl_vars['input']->value['label'];?>
</label>
			<div class="col-lg-9">
				<span class="switch prestashop-switch fixed-width-lg">
					<input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_on" value="1" />
					<label for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_on">
						<?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>

					</label>
					<input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_off" value="0" checked="checked" />
					<label for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_off">
						<?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>

					</label>
					<a class="slide-button btn"></a>
				</span>
			</div>
		</div>
	<?php } else { ?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

	<?php }
}
}
/* {/block "input_row"} */
/* {block 'script'} */
class Block_7029757525ea13761a65f93_93121737 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'script' => 
  array (
    0 => 'Block_7029757525ea13761a65f93_93121737',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


	$(document).ready(function() {

		$('.addPattern').click(function() {
			addFieldsToCursorPosition($(this).attr("id"))
			lastLayoutModified = $("#ordered_fields").val();
		});

		$('#ordered_fields').keyup(function() {
			lastLayoutModified = $(this).val();
		});

		$('#need_zip_code_on, #need_zip_code_off').change(function() {
			disableZipFormat();
		});
		
		$('#iso_code').change(function() {
			disableTAASC();
		});				
		disableTAASC();
	});

	function addFieldsToCursorPosition(pattern) {
		$("#ordered_fields").replaceSelection(pattern + " ");
	}

	function resetLayout(defaultLayout, type) {
		if (confirm("<?php echo smartyTranslate(array('s'=>'Are you sure you want to restore the default address format for this country?','js'=>1),$_smarty_tpl);?>
"))
		$("#ordered_fields").val(unescape(defaultLayout.replace(/\+/g, " ")));
	}

	$('#custom-address-fields a').click(function (e) {
  		e.preventDefault();
  		$(this).tab('show')
	})

<?php
}
}
/* {/block 'script'} */
}
