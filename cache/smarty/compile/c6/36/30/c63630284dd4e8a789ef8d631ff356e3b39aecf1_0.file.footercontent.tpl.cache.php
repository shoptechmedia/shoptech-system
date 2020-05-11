<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/modules/footercontent/footercontent.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf5d5c472_95913578',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c63630284dd4e8a789ef8d631ff356e3b39aecf1' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/footercontent/footercontent.tpl',
      1 => 1585125235,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf5d5c472_95913578 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '9993434895e9ebcf5d543c9_42159114';
?>
<!-- Module footercontent-->
<section id="footer_html_content" class="footer-block col-xs-12 col-sm-<?php echo $_smarty_tpl->tpl_vars['footercontent']->value->width;?>
">
	<div>
		<?php if ($_smarty_tpl->tpl_vars['footercontent']->value->body_title) {?><h4><?php echo stripslashes($_smarty_tpl->tpl_vars['footercontent']->value->body_title);?>
</h4><?php }?>
		
		<div class="<?php if ($_smarty_tpl->tpl_vars['footercontent']->value->body_title) {?>toggle-footer<?php }?> clearfix">
			<?php if ($_smarty_tpl->tpl_vars['footercontent']->value->body_paragraph) {?><article class="rte"><?php echo stripslashes($_smarty_tpl->tpl_vars['footercontent']->value->body_paragraph);?>
</article><?php }?>
		</div>	</div>
	</section>
<!-- /Module footer content-->
<?php }
}
