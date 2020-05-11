<?php
/* Smarty version 3.1.31, created on 2020-04-21 11:00:24
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/login/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ea818a50226_78944286',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '10fa90ffc688b223390894f8ec322d54734a7406' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/login/header.tpl',
      1 => 1585648103,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ea818a50226_78944286 (Smarty_Internal_Template $_smarty_tpl) {
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Slica – Bootstrap Responsive Flat Admin Dashboard HTML5 Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin site template, html admin template,responsive admin template, admin panel template, bootstrap admin panel template, admin template, admin panel template, bootstrap simple admin template premium, simple bootstrap admin template, best bootstrap admin template, simple bootstrap admin template, admin panel template,responsive admin template, bootstrap simple admin template premium"/>
		<meta name="robots" content="NOFOLLOW, NOINDEX">

		<!--favicon -->
		<link rel="icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
favicon.ico" />
		<link rel="apple-touch-icon" href="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
app_icon.png" />

		<!-- TITLE -->
		<title><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['meta_title']->value != '') {
if (isset($_smarty_tpl->tpl_vars['navigationPipe']->value)) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['navigationPipe']->value, ENT_QUOTES, 'UTF-8', true);
} else { ?>&gt;<?php }?> <?php echo $_smarty_tpl->tpl_vars['meta_title']->value;
}?> (thirty bees&trade;)</title>

		<!-- DASHBOARD CSS -->
		<link href="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/css/style.css" rel="stylesheet"/>
		<link href="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/css/color-skins/color1.css" rel="stylesheet"/>
		<link href="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/css/skins-modes.css" rel="stylesheet"/>

		<!-- SINGLE-PAGE CSS -->
		<link href="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/plugins/single-page/css/single-page.css" rel="stylesheet" type="text/css">

		<!--- FONT-ICONS CSS -->
		<link href="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/css/icons.css" rel="stylesheet"/>

		<?php echo '<script'; ?>
 type="text/javascript" src="../js/admin/login.js?v=<?php echo htmlspecialchars(@constant('_PS_VERSION_'), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo '</script'; ?>
>

	</head>

	<body class="app">

		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/images/svgs/loader.svg" class="loader-img" alt="Loader">
			</div>

			<div class="page h-100">
				<div class="">
				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto">
						<div class="text-center">
							<img src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/images/brand/logo.png" class="header-brand-img" alt="">
						</div>
					</div>
					<div class="container-login100"><?php }
}
