<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:57:59
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/maintenance/helpers/options/options.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea00717342d97_64851175',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'df298df9ef02327fac6703c08b538f9e60f1c165' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/maintenance/helpers/options/options.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea00717342d97_64851175 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19907748185ea007173334d0_10329153', "input");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/options/options.tpl");
}
/* {block "input"} */
class Block_19907748185ea007173334d0_10329153 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input' => 
  array (
    0 => 'Block_19907748185ea007173334d0_10329153',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'maintenance_ip') {?>
		<?php echo $_smarty_tpl->tpl_vars['field']->value['script_ip'];?>

		<div class="col-lg-9">
			<div class="row">
				<div class="col-lg-8">
					<input type="text"<?php if (isset($_smarty_tpl->tpl_vars['field']->value['id'])) {?> id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"<?php }?> size="<?php if (isset($_smarty_tpl->tpl_vars['field']->value['size'])) {
echo intval($_smarty_tpl->tpl_vars['field']->value['size']);
} else { ?>5<?php }?>" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" />
				</div>
				<div class="col-lg-1">
					<?php echo $_smarty_tpl->tpl_vars['field']->value['link_remove_ip'];?>

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
/* {/block "input"} */
}