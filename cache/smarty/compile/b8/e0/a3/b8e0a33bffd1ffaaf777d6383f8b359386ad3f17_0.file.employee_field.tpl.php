<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:59:29
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/logs/employee_field.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea00771831eb9_86390221',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8e0a33bffd1ffaaf777d6383f8b359386ad3f17' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/logs/employee_field.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea00771831eb9_86390221 (Smarty_Internal_Template $_smarty_tpl) {
?>

<span class="employee_avatar_small">
	<img class="imgm img-thumbnail" alt="" src="<?php echo $_smarty_tpl->tpl_vars['employee_image']->value;?>
" width="32" height="32" />
</span>
<?php echo $_smarty_tpl->tpl_vars['employee_name']->value;
}
}
