<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/themes/shoptech/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf5c3e1e6_05595596',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5de7b44f6288550b2e2ca4c4d591ab8d1873162' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/header.tpl',
      1 => 1585576607,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./product-compare.tpl' => 2,
  ),
),false)) {
function content_5e9ebcf5c3e1e6_05595596 (Smarty_Internal_Template $_smarty_tpl) {
?>

<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value) && $_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value) && $_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value) && $_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value) && $_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<html<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value) && $_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>>
	<head>
		<meta charset="utf-8" />
		<title><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_title']->value, ENT_QUOTES, 'UTF-8', true);?>
</title>
		<?php if (isset($_smarty_tpl->tpl_vars['meta_description']->value) && $_smarty_tpl->tpl_vars['meta_description']->value) {?>
			<meta name="description" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_description']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['meta_keywords']->value) && $_smarty_tpl->tpl_vars['meta_keywords']->value) {?>
			<meta name="keywords" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_keywords']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php }?>
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="noindex,nofollow" />
		<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
		<meta name="apple-mobile-web-app-capable" content="yes" /> 
		<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $_smarty_tpl->tpl_vars['favicon_url']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['favicon_url']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />
		<?php if (isset($_smarty_tpl->tpl_vars['css_files']->value)) {?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['css_files']->value, 'media', false, 'css_uri');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['css_uri']->value => $_smarty_tpl->tpl_vars['media']->value) {
?>
				<?php if ($_smarty_tpl->tpl_vars['css_uri']->value == 'lteIE9') {?>
					<!--[if lte IE 9]>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['css_files']->value[$_smarty_tpl->tpl_vars['css_uri']->value], 'mediaie9', false, 'css_uriie9');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['css_uriie9']->value => $_smarty_tpl->tpl_vars['mediaie9']->value) {
?>
					<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['css_uriie9']->value, ENT_QUOTES, 'UTF-8', true);?>
" type="text/css" media="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mediaie9']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					<![endif]-->
				<?php } else { ?>
					<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['css_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
" type="text/css" media="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['media']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
				<?php }?>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['js_defer']->value) && !$_smarty_tpl->tpl_vars['js_defer']->value && isset($_smarty_tpl->tpl_vars['js_files']->value) && isset($_smarty_tpl->tpl_vars['js_def']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['js_def']->value;?>

			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['js_files']->value, 'js_uri');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->value) {
?>
			<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['js_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo '</script'; ?>
>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		<?php }?>
		<?php echo $_smarty_tpl->tpl_vars['HOOK_HEADER']->value;?>


		<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['font_include'])) {?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['warehouse_vars']->value['font_include'], 'font', false, NULL, 'fonts', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['font']->value) {
?>
				<link rel="stylesheet" href="http<?php if (Tools::usingSecureMode()) {?>s<?php }?>://<?php echo $_smarty_tpl->tpl_vars['font']->value;?>
" type="text/css" media="all" />
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		<?php }?>

		<!--[if lt IE 9]>
		<?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"><?php echo '</script'; ?>
>
		<![endif]-->
		<!--[if lte IE 9]>
		
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
flexibility.js"><?php echo '</script'; ?>
>

		<![endif]-->
		<meta property="og:title" content="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['meta_title']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
		<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'];
echo $_SERVER['REQUEST_URI'];?>
"/>
		<meta property="og:site_name" content="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
		
		<meta property="og:description" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_description']->value, ENT_QUOTES, 'UTF-8', true);?>
">
		<?php if ($_smarty_tpl->tpl_vars['page_name']->value == 'product') {?>
		<meta property="og:type" content="product">
		<?php if (isset($_smarty_tpl->tpl_vars['have_image']->value)) {?>
		<?php if ($_smarty_tpl->tpl_vars['have_image']->value[0]) {?><meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value->link_rewrite,$_smarty_tpl->tpl_vars['cover']->value['id_image'],'large_default');?>
"><?php }?>
		<?php } else { ?>
		<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" />
		<?php }?>
		<?php } else { ?>
		<meta property="og:type" content="website">
		<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" />
		<?php }?>
	</head>
	<body<?php if (isset($_smarty_tpl->tpl_vars['page_name']->value)) {?> id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> class="<?php if (!isset($_smarty_tpl->tpl_vars['page_name']->value) || (isset($_smarty_tpl->tpl_vars['page_name']->value) && $_smarty_tpl->tpl_vars['page_name']->value != 'index')) {?>not-index <?php }
if (isset($_smarty_tpl->tpl_vars['page_name']->value)) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true);
}
if (isset($_smarty_tpl->tpl_vars['body_classes']->value) && count($_smarty_tpl->tpl_vars['body_classes']->value)) {?> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['implode'][0][0]->smartyImplode(array('value'=>$_smarty_tpl->tpl_vars['body_classes']->value,'separator'=>' '),$_smarty_tpl);
}
if ($_smarty_tpl->tpl_vars['hide_left_column']->value) {?> hide-left-column<?php }
if ($_smarty_tpl->tpl_vars['hide_right_column']->value) {?> hide-right-column<?php }
if (!$_smarty_tpl->tpl_vars['hide_left_column']->value) {?> show-left-column<?php }
if (!$_smarty_tpl->tpl_vars['hide_right_column']->value) {?> show-right-column<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['content_only']->value) && $_smarty_tpl->tpl_vars['content_only']->value) {?> content_only<?php }?> lang_<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
  <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['is_rtl']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['is_rtl']) {?> is_rtl<?php }?> 	<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?> isLogged<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 1) {?> is-sidebar-header<?php }?>">
	<?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value) || !$_smarty_tpl->tpl_vars['content_only']->value) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['preloader']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['preloader']) {?>
	<div id="preloader">
	<div id="status">&nbsp;</div>
	</div>
	<?php }?>
	<?php echo smartyHook(array('h'=>'freeFblock'),$_smarty_tpl);?>

	<?php if (isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value) && $_smarty_tpl->tpl_vars['restricted_country_mode']->value) {?>
	<div id="restricted-country">
		<p><?php echo smartyTranslate(array('s'=>'You cannot place a new order from your country.'),$_smarty_tpl);
if (isset($_smarty_tpl->tpl_vars['geolocation_country']->value) && $_smarty_tpl->tpl_vars['geolocation_country']->value) {?> <span class="bold"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['geolocation_country']->value, ENT_QUOTES, 'UTF-8', true);?>
</span><?php }?></p>
	</div>
	<?php }?>

	<div id="page">
		<div class="header-container<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'])) {
if ($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 1) {?> sidebar-header<?php } elseif (($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 2 || $_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 3)) {?> inline-header<?php }
}
if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['cart_style']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['cart_style'] == 1) {?> alt-cart<?php }?>">
			<header id="header">
		
			
						<div class="banner">
					<div class="container">
						<div class="row">
							<?php echo smartyHook(array('h'=>"displayBanner"),$_smarty_tpl);?>

						</div>
					</div>
				</div>
					<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['top_width']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['top_width'] == 1 && $_smarty_tpl->tpl_vars['warehouse_vars']->value['top_bar']) {?>
				<div class="nav">
					<div class="container">
						<div class="row">
							<nav>
								<?php echo smartyHook(array('h'=>"displayNav"),$_smarty_tpl);?>

								<?php $_smarty_tpl->_subTemplateRender("file:./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

								<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['wishlist_status']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['wishlist_status']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('blockwishlist','mywishlist',array(),true);?>
" title="<?php echo smartyTranslate(array('s'=>'My wishlist'),$_smarty_tpl);?>
" class="wishlist_top_link pull-right"><i class="icon-heart-o"></i>  <?php echo smartyTranslate(array('s'=>'My wishlist'),$_smarty_tpl);?>
</a><?php }?>
							</nav>
						</div>
					</div>
				</div>
				<?php }?>
				<div>
					<div class="container container-header">
										<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['top_width']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['top_width'] == 0 && $_smarty_tpl->tpl_vars['warehouse_vars']->value['top_bar']) {?>
				<div class="nav">
						<div class="row">
							<nav>
								<?php echo smartyHook(array('h'=>"displayNav"),$_smarty_tpl);?>

								<?php $_smarty_tpl->_subTemplateRender("file:./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

								<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['wishlist_status']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['wishlist_status']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('blockwishlist','mywishlist',array(),true);?>
" title="<?php echo smartyTranslate(array('s'=>'My wishlist'),$_smarty_tpl);?>
" class="wishlist_top_link pull-right"><i class="icon-heart-o"></i>  <?php echo smartyTranslate(array('s'=>'My wishlist'),$_smarty_tpl);?>
</a><?php }?>
							</nav>
						</div>
					
				</div>
				<?php }?>
				<div id="desktop-header" class="desktop-header">
				<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style']) && ($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 2 || $_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 3)) {?>
				<div class="row <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 3) {?> header-aligned-right <?php } elseif ($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 2) {?>header-aligned-left<?php }?>">
					<div class="inline-table">
						<div class="inline-row">
							<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 2) {?>
							<div class="inline-cell display-menu">
								<div class="inline-cell-table">
									<div id="header_logo">
										<a href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value) && $_smarty_tpl->tpl_vars['force_ssl']->value) {
echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;
} else {
echo $_smarty_tpl->tpl_vars['base_dir']->value;
}?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
">
											<img class="logo img-responsive replace-2xlogo" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) {?>data-retinalogo="<?php echo $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value) && $_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }
if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value) && $_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?> alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
										</a>
									</div> 
									<?php echo smartyHook(array('h'=>'iqitMegaMenu'),$_smarty_tpl);?>

								</div></div>
								<div class="displayTop inline-cell">
									<?php if (isset($_smarty_tpl->tpl_vars['HOOK_TOP']->value)) {
echo $_smarty_tpl->tpl_vars['HOOK_TOP']->value;
}?>
								</div>

								<?php } else { ?>	
									<div class="inline-cell inline-cell-logo">
									<div id="header_logo">
										<a href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value) && $_smarty_tpl->tpl_vars['force_ssl']->value) {
echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;
} else {
echo $_smarty_tpl->tpl_vars['base_dir']->value;
}?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
">
											<img class="logo img-responsive replace-2xlogo" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) {?>data-retinalogo="<?php echo $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value) && $_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }
if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value) && $_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?> alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
										</a>
									</div> 
									
								</div>
								<div class="displayTop inline-cell display-menu">
								<div class="inline-cell-table">
								<?php echo smartyHook(array('h'=>'iqitMegaMenu'),$_smarty_tpl);?>

								<div class="inline-cell-noflex"><?php if (isset($_smarty_tpl->tpl_vars['HOOK_TOP']->value)) {
echo $_smarty_tpl->tpl_vars['HOOK_TOP']->value;
}?></div>
									</div>
								</div>

								<?php }?>

							</div>
						</div>
					</div>
					<?php } else { ?>
					<div class="row">
						<div id="header_logo" class="col-xs-12 col-sm-<?php echo 4+$_smarty_tpl->tpl_vars['warehouse_vars']->value['logo_width'];?>
 <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['logo_position']) && !$_smarty_tpl->tpl_vars['warehouse_vars']->value['logo_position']) {?> col-sm-push-<?php echo 4-$_smarty_tpl->tpl_vars['warehouse_vars']->value['logo_width']/2;?>
 centered-logo  <?php }?>">

							<a href="<?php if ($_smarty_tpl->tpl_vars['force_ssl']->value) {
echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;
} else {
echo $_smarty_tpl->tpl_vars['base_dir']->value;
}?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
">
								<img class="logo img-responsive replace-2xlogo" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) {?>data-retinalogo="<?php echo $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value) && $_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }
if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value) && $_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?> alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
							</a>
						</div>
						<?php if (isset($_smarty_tpl->tpl_vars['HOOK_TOP']->value)) {
echo $_smarty_tpl->tpl_vars['HOOK_TOP']->value;
}?>
						<?php echo smartyHook(array('h'=>'iqitMegaMenu'),$_smarty_tpl);?>

					</div>
					<?php }?>
					</div>

					<div class="mobile-condensed-header mobile-style mobile-style<?php echo $_smarty_tpl->tpl_vars['warehouse_vars']->value['mobile_header_style'];?>
 <?php if ($_smarty_tpl->tpl_vars['warehouse_vars']->value['mobile_header_search']) {?>mobile-search-expanded<?php }?>">
						
						<?php if ($_smarty_tpl->tpl_vars['warehouse_vars']->value['mobile_header_style'] == 1) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./mobile-header1.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php } elseif ($_smarty_tpl->tpl_vars['warehouse_vars']->value['mobile_header_style'] == 2) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./mobile-header2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php } elseif ($_smarty_tpl->tpl_vars['warehouse_vars']->value['mobile_header_style'] == 3) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./mobile-header3.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php }?>

						<?php echo smartyHook(array('h'=>'iqitMobileHeader'),$_smarty_tpl);?>


					</div>

				
					</div>
				</div>
				<div class="fw-pseudo-wrapper"> <div class="desktop-header"><?php echo smartyHook(array('h'=>'maxHeader'),$_smarty_tpl);?>
 </div>	</div>
			<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['header_style'] == 1) {?>
				<div class="sidebar-footer">
				<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_img_src']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['footer_img_src']) {?><div class="paymants_logos col-xs-12"><img class="img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getMediaLink($_smarty_tpl->tpl_vars['warehouse_vars']->value['image_path']), ENT_QUOTES, 'UTF-8', true);?>
" alt="footerlogo" /></div><?php }?>
					<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['copyright_text'])) {?><div class="col-xs-12 cpr-txt"> <?php echo $_smarty_tpl->tpl_vars['warehouse_vars']->value['copyright_text'];?>
  </div><?php }?>
             		 
             	</div>
             <?php }?>

			</header>

			<?php if ($_smarty_tpl->tpl_vars['page_name']->value == 'index') {?>
			<div class="fw-pseudo-wrapper fw-pseudo-wrapper-slider">
			<?php echo smartyHook(array('h'=>"displayTopColumn"),$_smarty_tpl);?>

			<?php echo smartyHook(array('h'=>'maxSlideshow'),$_smarty_tpl);?>
 
		</div>
			<?php }?>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['page_name']->value != 'index' && $_smarty_tpl->tpl_vars['page_name']->value != 'pagenotfound') {
if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['breadcrumb_width']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['breadcrumb_width'] == 0) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}?>
		<div class="columns-container">
			<div id="columns" class="container">


				
				<?php if ($_smarty_tpl->tpl_vars['page_name']->value != 'index' && $_smarty_tpl->tpl_vars['page_name']->value != 'pagenotfound') {?>
				<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['breadcrumb_width']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['breadcrumb_width'] == 1) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}?>
				<?php }?>
								<div class="fw-pseudo-wrapper">
				<?php if ($_smarty_tpl->tpl_vars['page_name']->value == 'index') {?>
				<?php echo smartyHook(array('h'=>'maxInfos'),$_smarty_tpl);?>
 
				<?php }?>
				<?php echo smartyHook(array('h'=>'maxInfos2'),$_smarty_tpl);?>
 
				
					</div>
				<div class="row content-inner">
					<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['left_on_phones']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['left_on_phones'] == 0) {?>
					<?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value) && !empty($_smarty_tpl->tpl_vars['left_column_size']->value)) {?>
					<div id="left_column" class="column col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['left_column_size']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>
</div>
					<?php }?>
					<?php }?>
					<?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value) && isset($_smarty_tpl->tpl_vars['right_column_size']->value)) {
$_smarty_tpl->_assignInScope('cols', (12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value));
} else {
$_smarty_tpl->_assignInScope('cols', 12);
}?>
					<div id="center_column" class="center_column col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['cols']->value);?>
 <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['left_on_phones']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['left_on_phones'] == 1) {?> col-sm-push-<?php echo intval($_smarty_tpl->tpl_vars['left_column_size']->value);
}?>">
						<?php }
}
}
