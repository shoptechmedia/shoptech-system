<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:38:59
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/tree/tree_toolbar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff49344ee98_12185391',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd24ee9023de8dc76d7cbe819d862d9e4d1c837ee' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/tree/tree_toolbar.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ff49344ee98_12185391 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="tree-actions pull-right">
	<?php if (isset($_smarty_tpl->tpl_vars['actions']->value)) {?>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['actions']->value, 'action');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['action']->value) {
?>
		<?php echo $_smarty_tpl->tpl_vars['action']->value->render();?>

	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	<?php }?>
</div><?php }
}
