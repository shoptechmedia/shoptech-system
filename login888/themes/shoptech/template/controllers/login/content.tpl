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
<div class="wrap-login100 p-6">
	<form action="#" id="login_form" method="post" class="login100-form validate-form">
		<span class="login100-form-title">
			Member Login
		</span>
		<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
			<input class="input100" type="text" name="email" id="email" placeholder="Email">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="zmdi zmdi-email" aria-hidden="true"></i>
			</span>
		</div>
		<div class="wrap-input100 validate-input" data-validate = "Password is required">
			<input class="input100" type="password" name="passwd" id="passwd" placeholder="Password">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="zmdi zmdi-lock" aria-hidden="true"></i>
			</span>
		</div>
		<div class="container-login100-form-btn">
			<button class="login100-form-btn btn-primary" name="submitLogin" type="submit" tabindex="6">
				{l s='Login'}
			</button>
		</div>
	</form>
</div>