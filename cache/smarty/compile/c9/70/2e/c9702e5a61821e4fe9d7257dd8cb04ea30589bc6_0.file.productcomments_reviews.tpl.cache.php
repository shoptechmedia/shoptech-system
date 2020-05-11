<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/themes/shoptech/modules/productcomments/productcomments_reviews.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea7934706_67170176',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c9702e5a61821e4fe9d7257dd8cb04ea30589bc6' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/modules/productcomments/productcomments_reviews.tpl',
      1 => 1507620557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea19ea7934706_67170176 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '18119062365ea19ea7922a51_52522749';
?>

<?php if (isset($_smarty_tpl->tpl_vars['nbComments']->value) && $_smarty_tpl->tpl_vars['nbComments']->value > 0) {?>
	<div class="comments_note">
		<div class="star_content clearfix">
			<?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__smarty_section_i'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if (true) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= 5; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
				<?php if ($_smarty_tpl->tpl_vars['averageTotal']->value <= (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
					<div class="star"></div>
				<?php } else { ?>
					<div class="star star_on"></div>
				<?php }?>
			<?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>
		</div>
		<span class="nb-comments"><span><?php echo $_smarty_tpl->tpl_vars['nbComments']->value;?>
</span> <?php echo smartyTranslate(array('s'=>'Review(s)','mod'=>'productcomments'),$_smarty_tpl);?>
</span>
	</div>
	<?php } else { ?>
	<div class="comments_note">	
		<div class="star_content empty_comments clearfix">
<div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div>
			</div>
			</div>

<?php }
}
}
