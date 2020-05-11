<?php
/* Smarty version 3.1.31, created on 2020-04-22 12:00:08
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/list/list_action_details.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0079877e616_45416962',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8aad4e5a628502dd2615557320c81dd4f2eb0b4' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/list/list_action_details.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0079877e616_45416962 (Smarty_Internal_Template $_smarty_tpl) {
?>


<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" id="details_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['action'], ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="">
	<i class="icon-eye-open"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }
}
