<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/modules/iqitcontentcreator/views/templates/hook/iqitcontentcreator.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea76435b1_66743623',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '981be2ed0580180f50d6c43d19e3cead262f16f5' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/iqitcontentcreator/views/templates/hook/iqitcontentcreator.tpl',
      1 => 1507620557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./front_content.tpl' => 1,
  ),
),false)) {
function content_5ea19ea76435b1_66743623 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '20111131395ea19ea763b590_38126886';
?>



	<div id="iqitcontentcreator" class="block">
	<?php if (!empty($_smarty_tpl->tpl_vars['content']->value)) {?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['content']->value, 'element');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['element']->value) {
?>
			<?php $_smarty_tpl->_subTemplateRender("file:./front_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['element']->value,'frontEditor'=>0), 0, true);
?>
               
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	<?php }?>
</div>


							<?php }
}
