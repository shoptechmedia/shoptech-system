<?php
/* Smarty version 3.1.31, created on 2020-04-21 11:00:23
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ea81703df26_98968300',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b0e28c771bcf73a9eb1cd218ee53fdbafc40bfdc' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/header.tpl',
      1 => 1585819525,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:nav.tpl' => 1,
  ),
),false)) {
function content_5e9ea81703df26_98968300 (Smarty_Internal_Template $_smarty_tpl) {
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 lt-ie6 " lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html lang="fr" class="no-js ie9" lang="en"> <![endif]-->
<html lang="<?php echo $_smarty_tpl->tpl_vars['iso']->value;?>
">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
favicon.ico" />
	<link rel="apple-touch-icon" href="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
app_icon.png" />

	<meta name="robots" content="NOFOLLOW, NOINDEX">
	<title><?php if ($_smarty_tpl->tpl_vars['meta_title']->value != '') {
echo $_smarty_tpl->tpl_vars['meta_title']->value;?>
 • <?php }
echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</title>
	<?php if (!isset($_smarty_tpl->tpl_vars['display_header_javascript']->value) || $_smarty_tpl->tpl_vars['display_header_javascript']->value) {?>
	<?php echo '<script'; ?>
 type="text/javascript">
		var help_class_name = '<?php echo addcslashes($_smarty_tpl->tpl_vars['controller_name']->value,'\'');?>
';
		var iso_user = '<?php echo addcslashes($_smarty_tpl->tpl_vars['iso_user']->value,'\'');?>
';
		var full_language_code = '<?php echo addcslashes($_smarty_tpl->tpl_vars['full_language_code']->value,'\'');?>
';
		var country_iso_code = '<?php echo addcslashes($_smarty_tpl->tpl_vars['country_iso_code']->value,'\'');?>
';
		var _PS_VERSION_ = '<?php echo addcslashes(@constant('_TB_VERSION_'),'\'');?>
';
		var roundMode = <?php echo intval($_smarty_tpl->tpl_vars['round_mode']->value);?>
;
<?php if (isset($_smarty_tpl->tpl_vars['shop_context']->value)) {?>
	<?php if ($_smarty_tpl->tpl_vars['shop_context']->value == Shop::CONTEXT_ALL) {?>
		var youEditFieldFor = '<?php echo smartyTranslate(array('s'=>'This field will be modified for all your shops.','js'=>1),$_smarty_tpl);?>
';
	<?php } elseif ($_smarty_tpl->tpl_vars['shop_context']->value == Shop::CONTEXT_GROUP) {?>
		var youEditFieldFor = '<?php echo smartyTranslate(array('s'=>'This field will be modified for all shops in this shop group:','js'=>1),$_smarty_tpl);?>
 <b><?php echo addcslashes($_smarty_tpl->tpl_vars['shop_name']->value,'\'');?>
</b>';
	<?php } else { ?>
		var youEditFieldFor = '<?php echo smartyTranslate(array('s'=>'This field will be modified for this shop:','js'=>1),$_smarty_tpl);?>
 <b><?php echo addcslashes($_smarty_tpl->tpl_vars['shop_name']->value,'\'');?>
</b>';
	<?php }
} else { ?>
		var youEditFieldFor = '';
<?php }?>
		var autorefresh_notifications = '<?php echo addcslashes($_smarty_tpl->tpl_vars['autorefresh_notifications']->value,'\'');?>
';
		var new_order_msg = '<?php echo smartyTranslate(array('s'=>'A new order has been placed on your shop.','js'=>1),$_smarty_tpl);?>
';
		var order_number_msg = '<?php echo smartyTranslate(array('s'=>'Order number:','js'=>1),$_smarty_tpl);?>
 ';
		var total_msg = '<?php echo smartyTranslate(array('s'=>'Total:','js'=>1),$_smarty_tpl);?>
 ';
		var from_msg = '<?php echo smartyTranslate(array('s'=>'From:','js'=>1),$_smarty_tpl);?>
 ';
		var see_order_msg = '<?php echo smartyTranslate(array('s'=>'View this order','js'=>1),$_smarty_tpl);?>
';
		var new_customer_msg = '<?php echo smartyTranslate(array('s'=>'A new customer registered on your shop.','js'=>1),$_smarty_tpl);?>
';
		var customer_name_msg = '<?php echo smartyTranslate(array('s'=>'Customer name:','js'=>1),$_smarty_tpl);?>
 ';
		var new_msg = '<?php echo smartyTranslate(array('s'=>'A new message was posted on your shop.','js'=>1),$_smarty_tpl);?>
';
		var see_msg = '<?php echo smartyTranslate(array('s'=>'Read this message','js'=>1),$_smarty_tpl);?>
';
		var token = '<?php echo addslashes($_smarty_tpl->tpl_vars['token']->value);?>
';
		var token_admin_orders = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminOrders'),$_smarty_tpl);?>
';
		var token_admin_customers = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomers'),$_smarty_tpl);?>
';
		var token_admin_customer_threads = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomerThreads'),$_smarty_tpl);?>
';
		var currentIndex = '<?php echo addcslashes($_smarty_tpl->tpl_vars['currentIndex']->value,'\'');?>
';
		var employee_token = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminEmployees'),$_smarty_tpl);?>
';
		var choose_language_translate = '<?php echo smartyTranslate(array('s'=>'Choose language','js'=>1),$_smarty_tpl);?>
';
		var default_language = '<?php echo intval($_smarty_tpl->tpl_vars['default_language']->value);?>
';
		var admin_modules_link = '<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getAdminLink("AdminModules"));?>
';
		var tab_modules_list = '<?php if (isset($_smarty_tpl->tpl_vars['tab_modules_list']->value) && $_smarty_tpl->tpl_vars['tab_modules_list']->value) {
echo addslashes($_smarty_tpl->tpl_vars['tab_modules_list']->value);
}?>';
		var update_success_msg = '<?php echo smartyTranslate(array('s'=>'Update successful','js'=>1),$_smarty_tpl);?>
';
		var errorLogin = '<?php echo smartyTranslate(array('s'=>'thirty bees was unable to log in to Addons. Please check your credentials and your Internet connection.','js'=>1),$_smarty_tpl);?>
';
		var search_product_msg = '<?php echo smartyTranslate(array('s'=>'Search for a product','js'=>1),$_smarty_tpl);?>
';
		var base_dir = '<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
';

		var CacheRebuiltTxt = '<?php echo smartyTranslate(array('s'=>'Cache Genopbyg','js'=>1),$_smarty_tpl);?>
';
		var RebuildCacheTxt = '<?php echo smartyTranslate(array('s'=>'Genopbyg Cache','js'=>1),$_smarty_tpl);?>
';
		var RebuildingCacheTxt = '<?php echo smartyTranslate(array('s'=>'Opbygger Cache','js'=>1),$_smarty_tpl);?>
';

		var VisibleToAllTxt = '<?php echo smartyTranslate(array('s'=>'Synlig for alle','js'=>1),$_smarty_tpl);?>
';
		var VisibleToCurrentEmployeeTxt = '<?php echo smartyTranslate(array('s'=>'Synlig for Denne Medarbejder','js'=>1),$_smarty_tpl);?>
';
		var DisabledTxt = '<?php echo smartyTranslate(array('s'=>'Deaktiveret','js'=>1),$_smarty_tpl);?>
';
		var UpdateSettingsTxt = '<?php echo smartyTranslate(array('s'=>'Opdater indstillinger','js'=>1),$_smarty_tpl);?>
';

		var ShowFrontLoadTimeTxt = '<?php echo smartyTranslate(array('s'=>'Vis Forside Loadtid','js'=>1),$_smarty_tpl);?>
';
		var ClearCacheTxt = '<?php echo smartyTranslate(array('s'=>'Ryd cache','js'=>1),$_smarty_tpl);?>
';
		var RebuildCacheTxt = '<?php echo smartyTranslate(array('s'=>'Genopbyg Cache','js'=>1),$_smarty_tpl);?>
';

		var UpdatingTxt = '<?php echo smartyTranslate(array('s'=>'Opdatering','js'=>1),$_smarty_tpl);?>
';
		var UpdatedTxt = '<?php echo smartyTranslate(array('s'=>'Opdateret','js'=>1),$_smarty_tpl);?>
';
		var UpdateSettingsTxt = '<?php echo smartyTranslate(array('s'=>'Opdater indstillinger','js'=>1),$_smarty_tpl);?>
';

		var ClearingCacheTxt = '<?php echo smartyTranslate(array('s'=>'Clearing Cache','js'=>1),$_smarty_tpl);?>
';
		var CacheClearedTxt = '<?php echo smartyTranslate(array('s'=>'Cache Ryddet','js'=>1),$_smarty_tpl);?>
';
		var ClearCacheTxt = '<?php echo smartyTranslate(array('s'=>'Ryd cache','js'=>1),$_smarty_tpl);?>
';

		var ShowStatsTxt = '<?php echo smartyTranslate(array('s'=>'Vis Stats','js'=>1),$_smarty_tpl);?>
';
			var CacheEntriesTxt = '<?php echo smartyTranslate(array('s'=>'Cache Entries','js'=>1),$_smarty_tpl);?>
';
			var CacheHitsTxt = '<?php echo smartyTranslate(array('s'=>'Cache Hits','js'=>1),$_smarty_tpl);?>
';
			var TimeSavedTxt = '<?php echo smartyTranslate(array('s'=>'Tid Sparet','js'=>1),$_smarty_tpl);?>
';
			var SpaceUsedTxt = '<?php echo smartyTranslate(array('s'=>'Gemt Filer','js'=>1),$_smarty_tpl);?>
';
	<?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['css_files']->value)) {
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
	<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

<?php }?>

	<?php if ((isset($_smarty_tpl->tpl_vars['js_def']->value) && count($_smarty_tpl->tpl_vars['js_def']->value) || isset($_smarty_tpl->tpl_vars['js_files']->value) && count($_smarty_tpl->tpl_vars['js_files']->value))) {?>
		<?php $_smarty_tpl->_subTemplateRender((@constant('_PS_ALL_THEMES_DIR_')).("javascript.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<?php }?>

	<?php if (isset($_smarty_tpl->tpl_vars['displayBackOfficeHeader']->value)) {?>
		<?php echo $_smarty_tpl->tpl_vars['displayBackOfficeHeader']->value;?>

	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['brightness']->value)) {?>
	<!--
		// @todo: multishop color
		<style type="text/css">
			div#header_infos, div#header_infos a#header_shopname, div#header_infos a#header_logout, div#header_infos a#header_foaccess {color:<?php echo $_smarty_tpl->tpl_vars['brightness']->value;?>
}
		</style>
	-->
	<?php }?>
</head>

<body class="app <?php echo strtolower(htmlspecialchars($_GET['controller'], ENT_QUOTES, 'UTF-8', true));?>
">
    <!-- GLOBAL-LOADER -->
	<div id="global-loader">
		<img src="<?php echo $_smarty_tpl->tpl_vars['theme_path']->value;?>
/images/svgs/loader.svg" class="loader-img" alt="Loader">
	</div>

	<div class="page">
		<div class="page-main">

<?php if ($_smarty_tpl->tpl_vars['display_header']->value) {?>
			<!-- HEADER -->
			<div class="header app-header">
				<div class="container-fluid">
					<div class="d-flex header-nav">
						<div class="color-headerlogo">
							<a class="header-desktop" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['default_tab_link']->value, ENT_QUOTES, 'UTF-8', true);?>
"></a>
							<a class="header-mobile" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['default_tab_link']->value, ENT_QUOTES, 'UTF-8', true);?>
"></a>
						</div><!-- Color LOGO -->

						<a href="#" data-toggle="sidebar" class="nav-link icon toggle"><i class="fe fe-align-justify"></i></a>

						<div class="">
							<form class="form-inline">
								<div class="search-element">
									<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
									<button class="btn btn-primary-color" type="submit"><i class="fe fe-search"></i></button>
								</div>
							</form>
						</div><!-- SEARCH -->
						<div class="d-flex order-lg-2 ml-auto header-right-icons header-search-icon">
							<div class="dropdown  search-icon">
								<a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch">
									<i class="fe fe-search"></i>
								</a>
							</div>

							
							<?php if (isset($_smarty_tpl->tpl_vars['is_multishop']->value) && $_smarty_tpl->tpl_vars['is_multishop']->value && $_smarty_tpl->tpl_vars['shop_list']->value && (isset($_smarty_tpl->tpl_vars['multishop_context']->value) && $_smarty_tpl->tpl_vars['multishop_context']->value&Shop::CONTEXT_GROUP || $_smarty_tpl->tpl_vars['multishop_context']->value&Shop::CONTEXT_SHOP)) {?>
							<div id="shop_list" class="dropdown notifications">
								<a class="nav-link icon" data-toggle="dropdown">
									<?php echo smartyTranslate(array('s'=>'Shops'),$_smarty_tpl);?>
 <i class="angle fa fa-angle-down"></i>
								</a>
								<div id="orders_notif_wrapper" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<?php echo $_smarty_tpl->tpl_vars['shop_list']->value;?>

								</div>
							</div>
							<?php }?>

							<?php if (count($_smarty_tpl->tpl_vars['quick_access']->value) >= 0) {?>
							<div id="header_quick" class="dropdown notifications">
								<a class="nav-link icon" data-toggle="dropdown">
									<?php echo smartyTranslate(array('s'=>'Quick Access'),$_smarty_tpl);?>
 <i class="angle fa fa-angle-down"></i>
								</a>
								<div id="orders_notif_wrapper" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['quick_access']->value, 'quick');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['quick']->value) {
?>
									<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['quick']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" class="dropdown-item mt-2 d-flex pb-3">
										<?php if (isset($_smarty_tpl->tpl_vars['quick']->value['icon'])) {?>
											<i class="icon-<?php echo $_smarty_tpl->tpl_vars['quick']->value['icon'];?>
 icon-fw"></i>
										<?php } else { ?>
											<i class="icon-chevron-right icon-fw"></i>
										<?php }?>

										<?php echo $_smarty_tpl->tpl_vars['quick']->value['name'];?>

									</a>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

								</div>
							</div>
							<?php }?>

						    <div class="dropdown  header-fullscreen">
								<a class="nav-link icon full-screen-link nav-link-bg" id="fullscreen-button">
									<i class="fe fe-minimize" ></i>
								</a>
							</div><!-- FULL-SCREEN -->

							<?php ob_start();
echo $_smarty_tpl->tpl_vars['show_new_orders']->value;
$_prefixVariable4=ob_get_clean();
if ($_prefixVariable4 == 1) {?>
							<div  id="orders_notif" class="dropdown notifications">
								<a class="nav-link icon" data-toggle="dropdown">
									<i class="fe fe-bell"></i>
									<span id="orders_notif_number_wrapper" class="nav-unread badge badge-warning badge-pill"><span id="orders_notif_value">0</span></span>
								</a>
								<div id="orders_notif_wrapper" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<div id="list_orders_notif" class="list_notif">
										<span class="dropdown-item mt-2 d-flex pb-3 no_notifs">
											<?php echo smartyTranslate(array('s'=>'No new orders have been placed on your shop.'),$_smarty_tpl);?>

										</span>
									</div>
									
									<div class="border-top">
										<a href="index.php?controller=AdminOrders&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminOrders'),$_smarty_tpl);?>
" class="dropdown-item text-center"><?php echo smartyTranslate(array('s'=>'Show all orders'),$_smarty_tpl);?>
</a>
									</div>
								</div>
							</div><!-- NOTIFICATIONS -->
							<?php }?>
							<?php ob_start();
echo $_smarty_tpl->tpl_vars['show_new_messages']->value;
$_prefixVariable5=ob_get_clean();
if ($_prefixVariable5 == 1) {?>
							<div id="customer_messages_notif" class="dropdown  message">
								<a class="nav-link icon text-center" data-toggle="dropdown">
									<i class="fe fe-mail"></i>
									<span id="customer_messages_notif_number_wrapper" class=" nav-unread badge badge-warning badge-pill"><span id="customer_messages_notif_value" >0</span></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<div id="list_customer_messages_notif" class="list_notif">
										<span class="dropdown-item mt-2 d-flex pb-3 no_notifs">
											<?php echo smartyTranslate(array('s'=>'No new messages have been posted on your shop.'),$_smarty_tpl);?>

										</span>
									</div>
									
									<div class="border-top">
										<a href="index.php?controller=AdminCustomerThreads&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomerThreads'),$_smarty_tpl);?>
" class="dropdown-item text-center"><?php echo smartyTranslate(array('s'=>'Show all messages'),$_smarty_tpl);?>
</a>
									</div>
								</div>
							</div><!-- MESSAGE-BOX -->
							<?php }?>
							<div class="dropdown header-user">
								<a href="#" class="nav-link icon" data-toggle="dropdown">
									<span><img class="avatar brround cover-image mb-0 ml-0" alt="profile-user" src="<?php echo $_smarty_tpl->tpl_vars['employee']->value->getImage();?>
" /></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<div class=" dropdown-header noti-title text-center border-bottom p-3">
										<div class="header-usertext">
											<h5 class="mb-1"><?php echo $_smarty_tpl->tpl_vars['employee']->value->firstname;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['employee']->value->lastname;?>
</h5>
										</div>
									</div>
									<a class="dropdown-item" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminEmployees'), ENT_QUOTES, 'UTF-8', true);?>
&amp;id_employee=<?php echo intval($_smarty_tpl->tpl_vars['employee']->value->id);?>
&amp;updateemployee">
										<i class="mdi mdi-account-outline mr-2"></i> <span><?php echo smartyTranslate(array('s'=>'My preferences'),$_smarty_tpl);?>
</span>
									</a>
									<a id="header_logout" class="dropdown-item" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['login_link']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;logout">
										<i class="mdi mdi-logout-variant mr-2"></i> <span>Logout</span>
									</a>
								</div>
							</div><!-- SIDE-MENU -->
							<div class="dropdown  header-fullscreen">
								<a class="nav-link icon sidebar-right-mobile" data-toggle="sidebar-right" data-target=".sidebar-right">
									<i class="fe fe-align-right" ></i>
								</a>
							</div><!-- Side menu -->
						</div>

						<?php if (isset($_smarty_tpl->tpl_vars['displayBackOfficeTop']->value)) {
echo $_smarty_tpl->tpl_vars['displayBackOfficeTop']->value;
}?>
					</div>
				</div>
			</div>
			<!-- HEADER END -->

			<!-- Sidebar menu-->
			<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar">
				<?php $_smarty_tpl->_subTemplateRender('file:nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			</aside>
<?php }
}
}
