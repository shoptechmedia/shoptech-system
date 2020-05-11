<?php
/* Smarty version 3.1.31, created on 2020-04-21 11:00:22
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ea816f00704_94822965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7fbba62b968ef32c1674a557b17182e6fcec875d' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/content.tpl',
      1 => 1587105946,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page_header_toolbar.tpl' => 1,
  ),
),false)) {
function content_5e9ea816f00704_94822965 (Smarty_Internal_Template $_smarty_tpl) {
?>


<!-- CONTAINER -->
<div class="app-content">
	<div class="section">

		<?php $_smarty_tpl->_subTemplateRender('file:page_header_toolbar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


		<div class="row">
			<div class="col-lg-12">
				<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
					<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

				<?php }?>
			</div>
		</div>
	</div>
	<!-- CONTAINER END -->
</div><?php }
}
