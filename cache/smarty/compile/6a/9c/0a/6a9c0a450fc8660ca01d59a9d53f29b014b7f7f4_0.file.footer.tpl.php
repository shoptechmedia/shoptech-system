<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/themes/shoptech/footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf5d376a7_57707709',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6a9c0a450fc8660ca01d59a9d53f29b014b7f7f4' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/footer.tpl',
      1 => 1585125217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf5d376a7_57707709 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (!$_smarty_tpl->tpl_vars['content_only']->value) {?>
					</div><!-- #center_column -->
						<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['left_on_phones']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['left_on_phones'] == 1) {?>
					<?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value) && !empty($_smarty_tpl->tpl_vars['left_column_size']->value)) {?>
					<div id="left_column" class="column col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['left_column_size']->value);?>
 col-sm-pull-<?php echo 12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>
</div>
					<?php }?>
					<?php }?>
					<?php if (isset($_smarty_tpl->tpl_vars['right_column_size']->value) && !empty($_smarty_tpl->tpl_vars['right_column_size']->value)) {?>
						<div id="right_column" class="col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['right_column_size']->value);?>
 column"><?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>
</div>
					<?php }?>
					</div><!-- .row -->
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			<!-- Footer -->
			<?php echo smartyHook(array('h'=>'footerTopBanner'),$_smarty_tpl);?>
 

			<div class="footer-container <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['f_wrap_width']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['f_wrap_width'] == 0) {?> container <?php }?>">
				<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_width']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_width'] == 1) {?>
				<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['footer1_status']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['footer1_status'] == 1) {?>
				<div class="footer-container-inner1">
				<footer id="footer1"  class="container">
					<div class="row"><?php echo smartyHook(array('h'=>'displayAdditionalFooter'),$_smarty_tpl);?>
</div>
				</footer>
				</div>
				<?php }?>
				<?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTER']->value)) {?>
				<div class="footer-container-inner">
				<footer id="footer"  class="container">
					<div class="row"><?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>
</div>
				</footer>
				</div>
				<?php }?>
				<?php } elseif (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_width']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_width'] == 0) {?>
				<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['footer1_status']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['footer1_status'] == 1) {?>
				<footer id="footer1"  class="container footer-container-inner1">
						
					<div class="row"><?php echo smartyHook(array('h'=>'displayAdditionalFooter'),$_smarty_tpl);?>
</div>
					
				</footer>
				<?php }?>
				<?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTER']->value)) {?>
				<footer id="footer"  class="container footer-container-inner">
						
					<div class="row"><?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>
</div>
					
				</footer>
				<?php }?>
				<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['second_footer']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['second_footer'] == 1) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style']) && ($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] != 1)) {?>
			<div class="footer_copyrights">
				<footer class="container clearfix">
					<div class="row">
						<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['copyright_text'])) {?><div class=" <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_img_src'])) {?>col-sm-6<?php } else { ?>col-sm-12<?php }?>"> <?php echo $_smarty_tpl->tpl_vars['warehouse_vars']->value['copyright_text'];?>
  </div><?php }?>

						<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_img_src']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_img_src']) {?><div class="paymants_logos col-sm-6"><img class="img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getMediaLink($_smarty_tpl->tpl_vars['warehouse_vars']->value['image_path']), ENT_QUOTES, 'UTF-8', true);?>
" alt="footerlogo" /></div><?php }?>



					</div>
				</footer></div>
				<?php }
}?>

			</div><!-- #footer -->
		</div><!-- #page -->
<?php }
if (!$_smarty_tpl->tpl_vars['content_only']->value) {?><div id="toTop" class="transition-300"></div>
<?php echo smartyHook(array('h'=>'belowFooter'),$_smarty_tpl);
}
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php if ($_smarty_tpl->tpl_vars['page_name']->value == 'index') {
echo '<script'; ?>
 type="application/ld+json">

{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
index.php?controller=search&search_query={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}

<?php echo '</script'; ?>
>
<?php }?><div id="pp-zoom-wrapper">
</div>
	</body>
</html><?php }
}
