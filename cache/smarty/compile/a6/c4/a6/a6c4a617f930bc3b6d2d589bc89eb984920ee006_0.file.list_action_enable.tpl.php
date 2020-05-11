<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:04:23
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/list/list_action_enable.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ffa8702e936_42162313',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a6c4a617f930bc3b6d2d589bc89eb984920ee006' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/list/list_action_enable.tpl',
      1 => 1585816547,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ffa8702e936_42162313 (Smarty_Internal_Template $_smarty_tpl) {
?>

<a class="list-action-enable<?php if (isset($_smarty_tpl->tpl_vars['ajax']->value) && $_smarty_tpl->tpl_vars['ajax']->value) {?> ajax_table_link<?php }
if ($_smarty_tpl->tpl_vars['enabled']->value) {?> action-enabled<?php } else { ?> action-disabled<?php }?>" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_enable']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if (isset($_smarty_tpl->tpl_vars['confirm']->value)) {?> onclick="return confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
');"<?php }?> title="<?php if ($_smarty_tpl->tpl_vars['enabled']->value) {
echo smartyTranslate(array('s'=>'Enabled'),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'Disabled'),$_smarty_tpl);
}?>">
	<i class="<?php if ($_smarty_tpl->tpl_vars['enabled']->value) {?>ion-checkmark<?php } else { ?>ion-close<?php }?>"></i>
</a>
<?php }
}
