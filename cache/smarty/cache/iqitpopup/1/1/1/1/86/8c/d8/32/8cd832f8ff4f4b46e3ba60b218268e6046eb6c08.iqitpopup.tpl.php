<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/modules/iqitpopup/views/templates/hook/iqitpopup.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea7eeae60_30840998',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9182f1f15ce2406795150e8e96d0157e7e9aab3e' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/iqitpopup/views/templates/hook/iqitpopup.tpl',
      1 => 1508329166,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 31536000,
),true)) {
function content_5ea19ea7eeae60_30840998 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="iqitpopup" class="hide_popup" data-height="500px">
<div class="iqitpopup-close">
<!--<div class="iqit-close-checkbox">
 <div><input type="checkbox" class="checkbox" name="iqitpopup-checkbox" id="iqitpopup-checkbox" /></div>  <label for="iqitpopup-checkbox">Do not show again.</label></div> -->
<div class="iqit-close-popup"><span class="cross" title="Close window"></span></div>
</div>


<div class="iqitpopup-content"><p><strong><img src="https://cdn2.prestaspeed.dk/img/cms/prestaspeed-logo-1507639587.jpg" alt="" width="345" height="150" style="margin-left:auto;margin-right:auto;" /></strong></p>
<h3 style="text-transform:inherit;">Tilmeld dig og Få 10% rabat!</h3>
<p><em>Tilmeld dig vores nyhedsbrev og få en rabatkode allerede nu, du vil fremover modtage vores rabattilbud direkte i din email.</em></p></div>
<div class="iqitpopup-newsletter-form">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
		<!-- <span class="promo-text">Sign up to receive latest news and updates direct to your inbox</span> -->
	</div>
	<div class="col-xs-12 col-sm-12">
	<form action="//beta.shoptech.media/en/" method="post">
			<div>
				<input class="inputNew form-control grey newsletter-input" type="text" name="name" size="18" placeholder="Enter your Name" value="" />
				<input class="inputNew form-control grey newsletter-input" type="text" name="email" size="18" placeholder="Enter your e-mail" value="" />
				<input type="checkbox" name="confirm" value="yes" id="confirm_form"><label for="confirm">Jeg accepterer <a href="#" id="terms_popup_toggle">betingelserne</a></label>
                <button type="submit" name="submitNewsletter" class="btn btn-default button button-medium iqit-btn-newsletter" disabled>
                    <span>JA TAK, SEND MIG E-BOGEN NU! 
				</span>
                </button>
				<input type="hidden" name="action" value="0" />
			</div>
		</form>
	</div>		</div></div>
	</div> <!-- #layer_cart -->
<div id="iqitpopup-overlay hide_popup"></div>
<div class="" id="popup_toggle">
	<button class="btn btn_default">Get a free ebook now!</button>
</div>
<div class="terms_popup_wrap">
<div id="terms_popup"></div>
<button>close</button>
</div>
<?php }
}
