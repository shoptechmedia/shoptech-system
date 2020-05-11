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
		<link rel="icon" type="image/x-icon" href="{$img_dir}favicon.ico" />
		<link rel="apple-touch-icon" href="{$img_dir}app_icon.png" />

		<!-- TITLE -->
		<title>{$shop_name} {if $meta_title != ''}{if isset($navigationPipe)}{$navigationPipe|escape:'html':'UTF-8'}{else}&gt;{/if} {$meta_title}{/if} (thirty bees&trade;)</title>

		<!-- DASHBOARD CSS -->
		<link href="{$theme_path}/css/style.css" rel="stylesheet"/>
		<link href="{$theme_path}/css/color-skins/color1.css" rel="stylesheet"/>
		<link href="{$theme_path}/css/skins-modes.css" rel="stylesheet"/>

		<!-- SINGLE-PAGE CSS -->
		<link href="{$theme_path}/plugins/single-page/css/single-page.css" rel="stylesheet" type="text/css">

		<!--- FONT-ICONS CSS -->
		<link href="{$theme_path}/css/icons.css" rel="stylesheet"/>

		<script type="text/javascript" src="../js/admin/login.js?v={$smarty.const._PS_VERSION_|escape:'html':'UTF-8'}"></script>

	</head>

	<body class="app">

		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="{$theme_path}/images/svgs/loader.svg" class="loader-img" alt="Loader">
			</div>

			<div class="page h-100">
				<div class="">
				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto">
						<div class="text-center">
							<img src="{$theme_path}/images/brand/logo.png" class="header-brand-img" alt="">
						</div>
					</div>
					<div class="container-login100">