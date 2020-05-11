<?php
/* Smarty version 3.1.31, created on 2020-04-21 11:00:24
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/login/content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ea818a35341_84366874',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e425252fb0af91a188931aeb067afa1bec9b216' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/login/content.tpl',
      1 => 1585649161,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ea818a35341_84366874 (Smarty_Internal_Template $_smarty_tpl) {
?>

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
				<?php echo smartyTranslate(array('s'=>'Login'),$_smarty_tpl);?>

			</button>
		</div>
	</form>
</div><?php }
}
