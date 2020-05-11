<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:57:34
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/tax_rules/helpers/list/list_action_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea006fe450740_71304104',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cc3bffa082ab14a5138e874d00cea7bd68e44989' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/tax_rules/helpers/list/list_action_edit.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea006fe450740_71304104 (Smarty_Internal_Template $_smarty_tpl) {
?>

<a onclick="loadTaxRule('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
'); return false;" href="#" class="btn btn-default">
	<i class="icon-pencil"></i> 
	<?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }
}
