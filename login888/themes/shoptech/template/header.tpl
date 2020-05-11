{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 lt-ie6 " lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html lang="fr" class="no-js ie9" lang="en"> <![endif]-->
<html lang="{$iso}">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="icon" type="image/x-icon" href="{$img_dir}favicon.ico" />
	<link rel="apple-touch-icon" href="{$img_dir}app_icon.png" />

	<meta name="robots" content="NOFOLLOW, NOINDEX">
	<title>{if $meta_title != ''}{$meta_title} • {/if}{$shop_name}</title>
	{if !isset($display_header_javascript) || $display_header_javascript}
	<script type="text/javascript">
		var help_class_name = '{$controller_name|@addcslashes:'\''}';
		var iso_user = '{$iso_user|@addcslashes:'\''}';
		var full_language_code = '{$full_language_code|@addcslashes:'\''}';
		var country_iso_code = '{$country_iso_code|@addcslashes:'\''}';
		var _PS_VERSION_ = '{$smarty.const._TB_VERSION_|@addcslashes:'\''}';
		var roundMode = {$round_mode|intval};
{if isset($shop_context)}
	{if $shop_context == Shop::CONTEXT_ALL}
		var youEditFieldFor = '{l s='This field will be modified for all your shops.' js=1}';
	{elseif $shop_context == Shop::CONTEXT_GROUP}
		var youEditFieldFor = '{l s='This field will be modified for all shops in this shop group:' js=1} <b>{$shop_name|@addcslashes:'\''}</b>';
	{else}
		var youEditFieldFor = '{l s='This field will be modified for this shop:' js=1} <b>{$shop_name|@addcslashes:'\''}</b>';
	{/if}
{else}
		var youEditFieldFor = '';
{/if}
		var autorefresh_notifications = '{$autorefresh_notifications|@addcslashes:'\''}';
		var new_order_msg = '{l s='A new order has been placed on your shop.' js=1}';
		var order_number_msg = '{l s='Order number:' js=1} ';
		var total_msg = '{l s='Total:' js=1} ';
		var from_msg = '{l s='From:' js=1} ';
		var see_order_msg = '{l s='View this order' js=1}';
		var new_customer_msg = '{l s='A new customer registered on your shop.' js=1}';
		var customer_name_msg = '{l s='Customer name:' js=1} ';
		var new_msg = '{l s='A new message was posted on your shop.' js=1}';
		var see_msg = '{l s='Read this message' js=1}';
		var token = '{$token|addslashes}';
		var token_admin_orders = '{getAdminToken tab='AdminOrders'}';
		var token_admin_customers = '{getAdminToken tab='AdminCustomers'}';
		var token_admin_customer_threads = '{getAdminToken tab='AdminCustomerThreads'}';
		var currentIndex = '{$currentIndex|@addcslashes:'\''}';
		var employee_token = '{getAdminToken tab='AdminEmployees'}';
		var choose_language_translate = '{l s='Choose language' js=1}';
		var default_language = '{$default_language|intval}';
		var admin_modules_link = '{$link->getAdminLink("AdminModules")|addslashes}';
		var tab_modules_list = '{if isset($tab_modules_list) && $tab_modules_list}{$tab_modules_list|addslashes}{/if}';
		var update_success_msg = '{l s='Update successful' js=1}';
		var errorLogin = '{l s='thirty bees was unable to log in to Addons. Please check your credentials and your Internet connection.' js=1}';
		var search_product_msg = '{l s='Search for a product' js=1}';
		var base_dir = '{$base_url}';

		var CacheRebuiltTxt = '{l s='Cache Genopbyg' js=1}';
		var RebuildCacheTxt = '{l s='Genopbyg Cache' js=1}';
		var RebuildingCacheTxt = '{l s='Opbygger Cache' js=1}';

		var VisibleToAllTxt = '{l s='Synlig for alle' js=1}';
		var VisibleToCurrentEmployeeTxt = '{l s='Synlig for Denne Medarbejder' js=1}';
		var DisabledTxt = '{l s='Deaktiveret' js=1}';
		var UpdateSettingsTxt = '{l s='Opdater indstillinger' js=1}';

		var ShowFrontLoadTimeTxt = '{l s='Vis Forside Loadtid' js=1}';
		var ClearCacheTxt = '{l s='Ryd cache' js=1}';
		var RebuildCacheTxt = '{l s='Genopbyg Cache' js=1}';

		var UpdatingTxt = '{l s='Opdatering' js=1}';
		var UpdatedTxt = '{l s='Opdateret' js=1}';
		var UpdateSettingsTxt = '{l s='Opdater indstillinger' js=1}';

		var ClearingCacheTxt = '{l s='Clearing Cache' js=1}';
		var CacheClearedTxt = '{l s='Cache Ryddet' js=1}';
		var ClearCacheTxt = '{l s='Ryd cache' js=1}';

		var ShowStatsTxt = '{l s='Vis Stats' js=1}';
			var CacheEntriesTxt = '{l s='Cache Entries' js=1}';
			var CacheHitsTxt = '{l s='Cache Hits' js=1}';
			var TimeSavedTxt = '{l s='Tid Sparet' js=1}';
			var SpaceUsedTxt = '{l s='Gemt Filer' js=1}';
	</script>
{/if}
{if isset($css_files)}
{foreach from=$css_files key=css_uri item=media}
	{if $css_uri == 'lteIE9'}
		<!--[if lte IE 9]>
		{foreach from=$css_files[$css_uri] key=css_uriie9 item=mediaie9}
		<link rel="stylesheet" href="{$css_uriie9|escape:'html':'UTF-8'}" type="text/css" media="{$mediaie9|escape:'html':'UTF-8'}" />
		{/foreach}
		<![endif]-->
	{else}
		<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
	{/if}
{/foreach}
{/if}

	{if (isset($js_def) && count($js_def) || isset($js_files) && count($js_files))}
		{include file=$smarty.const._PS_ALL_THEMES_DIR_|cat:"javascript.tpl"}
	{/if}

	{if isset($displayBackOfficeHeader)}
		{$displayBackOfficeHeader}
	{/if}
	{if isset($brightness)}
	<!--
		// @todo: multishop color
		<style type="text/css">
			div#header_infos, div#header_infos a#header_shopname, div#header_infos a#header_logout, div#header_infos a#header_foaccess {ldelim}color:{$brightness}{rdelim}
		</style>
	-->
	{/if}
</head>

<body class="app {$smarty.get.controller|escape|strtolower}">
    <!-- GLOBAL-LOADER -->
	<div id="global-loader">
		<img src="{$theme_path}/images/svgs/loader.svg" class="loader-img" alt="Loader">
	</div>

	<div class="page">
		<div class="page-main">

{if $display_header}
			<!-- HEADER -->
			<div class="header app-header">
				<div class="container-fluid">
					<div class="d-flex header-nav">
						<div class="color-headerlogo">
							<a class="header-desktop" href="{$default_tab_link|escape:'html':'UTF-8'}"></a>
							<a class="header-mobile" href="{$default_tab_link|escape:'html':'UTF-8'}"></a>
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

							{* Shop *}
							{if isset($is_multishop) && $is_multishop && $shop_list && (isset($multishop_context) && $multishop_context & Shop::CONTEXT_GROUP || $multishop_context & Shop::CONTEXT_SHOP)}
							<div id="shop_list" class="dropdown notifications">
								<a class="nav-link icon" data-toggle="dropdown">
									{l s='Shops'} <i class="angle fa fa-angle-down"></i>
								</a>
								<div id="orders_notif_wrapper" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									{$shop_list}
								</div>
							</div>
							{/if}

							{if count($quick_access) >= 0}
							<div id="header_quick" class="dropdown notifications">
								<a class="nav-link icon" data-toggle="dropdown">
									{l s='Quick Access'} <i class="angle fa fa-angle-down"></i>
								</a>
								<div id="orders_notif_wrapper" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
								{foreach $quick_access as $quick}
									<a href="{$quick.link|escape:'html':'UTF-8'}" class="dropdown-item mt-2 d-flex pb-3">
										{if isset($quick.icon)}
											<i class="icon-{$quick.icon} icon-fw"></i>
										{else}
											<i class="icon-chevron-right icon-fw"></i>
										{/if}

										{$quick.name}
									</a>
								{/foreach}
								</div>
							</div>
							{/if}

						    <div class="dropdown  header-fullscreen">
								<a class="nav-link icon full-screen-link nav-link-bg" id="fullscreen-button">
									<i class="fe fe-minimize" ></i>
								</a>
							</div><!-- FULL-SCREEN -->

							{if {$show_new_orders} == 1}
							<div  id="orders_notif" class="dropdown notifications">
								<a class="nav-link icon" data-toggle="dropdown">
									<i class="fe fe-bell"></i>
									<span id="orders_notif_number_wrapper" class="nav-unread badge badge-warning badge-pill"><span id="orders_notif_value">0</span></span>
								</a>
								<div id="orders_notif_wrapper" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<div id="list_orders_notif" class="list_notif">
										<span class="dropdown-item mt-2 d-flex pb-3 no_notifs">
											{l s='No new orders have been placed on your shop.'}
										</span>
									</div>
									{*<a href="#" class="dropdown-item mt-2 d-flex pb-3">
										<div class="notifyimg bg-info">
											<i class="fa fa-thumbs-o-up"></i>
										</div>
										<div>
											<h6 class="mb-1">Someone likes our posts.</h6>
											<div class="small text-muted">3 hours ago</div>
										</div>
									</a>*}
									<div class="border-top">
										<a href="index.php?controller=AdminOrders&amp;token={getAdminToken tab='AdminOrders'}" class="dropdown-item text-center">{l s='Show all orders'}</a>
									</div>
								</div>
							</div><!-- NOTIFICATIONS -->
							{/if}
							{if {$show_new_messages} == 1}
							<div id="customer_messages_notif" class="dropdown  message">
								<a class="nav-link icon text-center" data-toggle="dropdown">
									<i class="fe fe-mail"></i>
									<span id="customer_messages_notif_number_wrapper" class=" nav-unread badge badge-warning badge-pill"><span id="customer_messages_notif_value" >0</span></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<div id="list_customer_messages_notif" class="list_notif">
										<span class="dropdown-item mt-2 d-flex pb-3 no_notifs">
											{l s='No new messages have been posted on your shop.'}
										</span>
									</div>
									{*<a href="#" class="dropdown-item mt-2 d-flex pb-3">
										<div class="notifyimg bg-info">
											<i class="fa fa-thumbs-o-up"></i>
										</div>
										<div>
											<h6 class="mb-1">Someone likes our posts.</h6>
											<div class="small text-muted">3 hours ago</div>
										</div>
									</a>*}
									<div class="border-top">
										<a href="index.php?controller=AdminCustomerThreads&amp;token={getAdminToken tab='AdminCustomerThreads'}" class="dropdown-item text-center">{l s='Show all messages'}</a>
									</div>
								</div>
							</div><!-- MESSAGE-BOX -->
							{/if}
							<div class="dropdown header-user">
								<a href="#" class="nav-link icon" data-toggle="dropdown">
									<span><img class="avatar brround cover-image mb-0 ml-0" alt="profile-user" src="{$employee->getImage()}" /></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<div class=" dropdown-header noti-title text-center border-bottom p-3">
										<div class="header-usertext">
											<h5 class="mb-1">{$employee->firstname}&nbsp;{$employee->lastname}</h5>
										</div>
									</div>
									<a class="dropdown-item" href="{$link->getAdminLink('AdminEmployees')|escape:'html':'UTF-8'}&amp;id_employee={$employee->id|intval}&amp;updateemployee">
										<i class="mdi mdi-account-outline mr-2"></i> <span>{l s='My preferences'}</span>
									</a>
									<a id="header_logout" class="dropdown-item" href="{$login_link|escape:'html':'UTF-8'}&amp;logout">
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

						{if isset($displayBackOfficeTop)}{$displayBackOfficeTop}{/if}
					</div>
				</div>
			</div>
			<!-- HEADER END -->

			<!-- Sidebar menu-->
			<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar">
				{include file='nav.tpl'}
			</aside>
{/if}