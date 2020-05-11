<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:37:46
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules/content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff44aaec6e9_60127873',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5213c59f5f748df34d1aa60d54a64b535f95466d' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules/content.tpl',
      1 => 1587370767,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:controllers/modules/js.tpl' => 1,
    'file:controllers/modules/page.tpl' => 1,
  ),
),false)) {
function content_5e9ff44aaec6e9_60127873 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="app-content">
<?php if (isset($_smarty_tpl->tpl_vars['module_content']->value)) {?>
	<?php echo $_smarty_tpl->tpl_vars['module_content']->value;?>

<?php } else { ?>
	<?php if (!isset($_GET['configure'])) {?>
		<?php $_smarty_tpl->_subTemplateRender('file:controllers/modules/js.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<?php $_smarty_tpl->_subTemplateRender('file:controllers/modules/page.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<?php }
}?>
</div><?php }
}
