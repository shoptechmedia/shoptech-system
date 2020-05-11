<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/themes/shoptech/product-list-colors.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea75aaa94_98610294',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0ee0e152323da72075151cc8e27d52451d819771' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/product-list-colors.tpl',
      1 => 1585125217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea19ea75aaa94_98610294 (Smarty_Internal_Template $_smarty_tpl) {
?>


<?php if (isset($_smarty_tpl->tpl_vars['colors_list']->value)) {?>
<ul class="color_to_pick_list clearfix">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['colors_list']->value, 'color');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['color']->value) {
$_smarty_tpl->_assignInScope('img_color_exists', file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['color']->value['id_attribute'])).('.jpg')));
?><li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['color']->value['id_product'],null,null,null,null,null,$_smarty_tpl->tpl_vars['color']->value['id_product_attribute'],Configuration::get('PS_REWRITING_SETTINGS'),false,true), ENT_QUOTES, 'UTF-8', true);?>
"
			data-id="color_<?php echo intval($_smarty_tpl->tpl_vars['color']->value['id_product_attribute']);?>
"
			class="color_pick"
			<?php if (!$_smarty_tpl->tpl_vars['img_color_exists']->value && isset($_smarty_tpl->tpl_vars['color']->value['color']) && $_smarty_tpl->tpl_vars['color']->value['color']) {?> style="background:<?php echo $_smarty_tpl->tpl_vars['color']->value['color'];?>
;"<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['img_color_exists']->value) {?>style="background: url(<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;
echo intval($_smarty_tpl->tpl_vars['color']->value['id_attribute']);?>
.jpg) repeat;" <?php }?>
			></a></li><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</ul>
<?php }
}
}
