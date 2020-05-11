<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/themes/shoptech/modules/ph_recentposts/views/templates/hook/recent.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea737e834_63662125',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '22a9c4a76b49f312f73d9031f1c20fcde726f012' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/modules/ph_recentposts/views/templates/hook/recent.tpl',
      1 => 1507620557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./types/".((string)$_smarty_tpl->tpl_vars[\'post_type\']->value)."/thumbnail.tpl' => 1,
    'file:./types/".((string)$_smarty_tpl->tpl_vars[\'post_type\']->value)."/title.tpl' => 1,
    'file:./types/".((string)$_smarty_tpl->tpl_vars[\'post_type\']->value)."/description.tpl' => 1,
    'file:./types/".((string)$_smarty_tpl->tpl_vars[\'post_type\']->value)."/meta.tpl' => 1,
  ),
),false)) {
function content_5ea19ea737e834_63662125 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_cycle')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/modifier.date_format.php';
if (isset($_smarty_tpl->tpl_vars['recent_posts']->value) && count($_smarty_tpl->tpl_vars['recent_posts']->value)) {
$_smarty_tpl->_assignInScope('is_category', false);
?> 
<section class="ph_simpleblog simpleblog-recent block">
	<p class="title_block">
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('ph_simpleblog','list'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Recent posts','mod'=>'ph_recentposts'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Recent posts','mod'=>'ph_recentposts'),$_smarty_tpl);?>
</a>
	</p>
	<div class="row simpleblog-posts" itemscope itemtype="http://schema.org/Blog">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recent_posts']->value, 'post');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
?>

				<div class="simpleblog-post-item simpleblog-post-type-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['post_type'], ENT_QUOTES, 'UTF-8', true);?>

				<?php if ($_smarty_tpl->tpl_vars['blogLayout']->value == 'grid' && $_smarty_tpl->tpl_vars['columns']->value == '3') {?>
					col-md-4 col-sm-6 col-xs-12 col-ms-12 <?php echo smarty_function_cycle(array('values'=>"first-in-line,second-in-line,last-in-line"),$_smarty_tpl);?>

				<?php } elseif ($_smarty_tpl->tpl_vars['blogLayout']->value == 'grid' && $_smarty_tpl->tpl_vars['columns']->value == '4') {?>
					col-md-3 col-sm-6 col-xs-12 col-ms-12 <?php echo smarty_function_cycle(array('values'=>"first-in-line,second-in-line,third-in-line,last-in-line"),$_smarty_tpl);?>

				<?php } elseif ($_smarty_tpl->tpl_vars['blogLayout']->value == 'grid' && $_smarty_tpl->tpl_vars['columns']->value == '2') {?>
					col-md-6 col-sm-6 col-xs-12 col-ms-12 <?php echo smarty_function_cycle(array('values'=>"first-in-line,last-in-line"),$_smarty_tpl);?>

				<?php } else { ?>
				col-md-12
				<?php }?>" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

					<div class="post-item">
						<?php $_smarty_tpl->_assignInScope('post_type', $_smarty_tpl->tpl_vars['post']->value['post_type']);
?>

						
						

						<?php if ($_smarty_tpl->tpl_vars['post_type']->value != 'post' && file_exists(((string)$_smarty_tpl->tpl_vars['tpl_path']->value)."./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/thumbnail.tpl")) {?>
							<?php $_smarty_tpl->_subTemplateRender("file:./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/thumbnail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php } else { ?>
							<?php if (isset($_smarty_tpl->tpl_vars['post']->value['banner']) && Configuration::get('PH_BLOG_DISPLAY_THUMBNAIL')) {?>
							<div class="post-thumbnail">
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['url'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Permalink to','mod'=>'ph_recentposts'),$_smarty_tpl);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
">
									<?php if ($_smarty_tpl->tpl_vars['blogLayout']->value == 'full') {?>
										<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['banner_wide'], ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
" class="img-responsive" itemprop="image" />
									<?php } else { ?>
										<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['banner_thumb'], ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
" class="img-responsive" itemprop="image"/>
									<?php }?>
								</a>
							</div><!-- .post-thumbnail -->
							<?php }?>
						<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['post_type']->value != 'post' && file_exists(((string)$_smarty_tpl->tpl_vars['tpl_path']->value)."./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/title.tpl")) {?>
							<?php $_smarty_tpl->_subTemplateRender("file:./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/title.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php } else { ?>
							<div class="post-title">
								<h2 itemprop="headline">
									<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['url'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Permalink to','mod'=>'ph_recentposts'),$_smarty_tpl);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
">
										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['title'], ENT_QUOTES, 'UTF-8', true);?>

									</a>
								</h2>
							</div><!-- .post-title -->
						<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['post_type']->value != 'post' && file_exists(((string)$_smarty_tpl->tpl_vars['tpl_path']->value)."./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/description.tpl")) {?>
							<?php $_smarty_tpl->_subTemplateRender("file:./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/description.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php } else { ?>
							<?php if (Configuration::get('PH_BLOG_DISPLAY_DESCRIPTION')) {?>
							<div class="post-content" itemprop="text">
								<?php echo strip_tags($_smarty_tpl->tpl_vars['post']->value['short_content']);?>


								<?php if (Configuration::get('PH_BLOG_DISPLAY_MORE')) {?>
								<div class="post-read-more">
									<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['url'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Read more','mod'=>'ph_recentposts'),$_smarty_tpl);?>
">
										<?php echo smartyTranslate(array('s'=>'Read more','mod'=>'ph_recentposts'),$_smarty_tpl);?>
 <i class="icon icon-chevron-right"></i>
									</a>
								</div><!-- .post-read-more -->
								<?php }?>
							</div><!-- .post-content -->	
							<?php }?>
						<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['post_type']->value != 'post' && file_exists(((string)$_smarty_tpl->tpl_vars['tpl_path']->value)."./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/meta.tpl")) {?>
							<?php $_smarty_tpl->_subTemplateRender("file:./types/".((string)$_smarty_tpl->tpl_vars['post_type']->value)."/meta.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php } else { ?>
							<div class="post-additional-info post-meta-info">
								<?php if (Configuration::get('PH_BLOG_DISPLAY_DATE')) {?>
									<span class="post-date">
										<i class="icon icon-calendar"></i> <time itemprop="datePublished" datetime="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['post']->value['date_add'],'c');?>
"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['post']->value['date_add'],Configuration::get('PH_BLOG_DATEFORMAT'));?>
</time>
									</span>
								<?php }?>

								<?php if ($_smarty_tpl->tpl_vars['is_category']->value == false && Configuration::get('PH_BLOG_DISPLAY_CATEGORY')) {?>
									<span class="post-category">
										<i class="icon icon-tags"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['post']->value['category_url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['category'], ENT_QUOTES, 'UTF-8', true);?>
" rel="category"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['category'], ENT_QUOTES, 'UTF-8', true);?>
</a>
									</span>
								<?php }?>

								<?php if (isset($_smarty_tpl->tpl_vars['post']->value['author']) && !empty($_smarty_tpl->tpl_vars['post']->value['author']) && Configuration::get('PH_BLOG_DISPLAY_AUTHOR')) {?>
									<span class="post-author">
										<i class="icon icon-user"></i> <span itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['author'], ENT_QUOTES, 'UTF-8', true);?>
</span>
									</span>
								<?php }?>
							</div><!-- .post-additional-info post-meta-info -->
						<?php }?>
					</div><!-- .post-item -->
				</div><!-- .simpleblog-post-item -->

			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</div><!-- .row -->
</section><!-- .ph_simpleblog.recent -->
<?php }
}
}
