<?php
/* Smarty version 3.1.31, created on 2020-04-21 11:00:24
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/login/footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ea818a5ca78_70314505',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ad3688e18a8dca7307687a5394abdac6d5151c13' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/login/footer.tpl',
      1 => 1585648804,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:error.tpl' => 1,
  ),
),false)) {
function content_5e9ea818a5ca78_70314505 (Smarty_Internal_Template $_smarty_tpl) {
?>

				</div>
				<!-- CONTAINER CLOSED -->
			</div>
		</div>
	</div>
	<!-- BACKGROUND-IMAGE CLOSED -->

	<!-- JQUERY SCRIPTS JS-->
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/js/vendors/jquery-3.2.1.min.js"><?php echo '</script'; ?>
>

	<!-- BOOTSTRAP SCRIPTS JS-->
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/js/vendors/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>

	<!-- SPARKLINE JS-->
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/js/vendors/jquery.sparkline.min.js"><?php echo '</script'; ?>
>

	<!-- CHART-CIRCLE JS-->
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/js/vendors/circle-progress.min.js"><?php echo '</script'; ?>
>

	<!-- RATING STAR JS-->
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/plugins/rating/rating-stars.js"><?php echo '</script'; ?>
>

	<!-- INPUT MASK JS-->
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/plugins/input-mask/input-mask.min.js"><?php echo '</script'; ?>
>

	<!-- CUSTOM JS-->
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/js/custom.js"><?php echo '</script'; ?>
>

<?php if (isset($_smarty_tpl->tpl_vars['php_errors']->value)) {?>
	<?php $_smarty_tpl->_subTemplateRender("file:error.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['modals']->value)) {?>
<div class="bootstrap">
	<?php echo $_smarty_tpl->tpl_vars['modals']->value;?>

</div>
<?php }?>

</body>
</html>
<?php }
}
