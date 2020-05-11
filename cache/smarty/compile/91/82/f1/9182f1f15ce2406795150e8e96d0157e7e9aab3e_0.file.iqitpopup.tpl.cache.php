<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/modules/iqitpopup/views/templates/hook/iqitpopup.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea7ee4ec7_71956200',
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
  'includes' => 
  array (
  ),
),false)) {
function content_5ea19ea7ee4ec7_71956200 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '13521865725ea19ea7ed5561_90053605';
?>


<div id="iqitpopup" class="hide_popup" data-height="<?php echo $_smarty_tpl->tpl_vars['height']->value;?>
px">
<div class="iqitpopup-close">
<!--<div class="iqit-close-checkbox">
 <div><input type="checkbox" class="checkbox" name="iqitpopup-checkbox" id="iqitpopup-checkbox" /></div>  <label for="iqitpopup-checkbox"><?php echo smartyTranslate(array('s'=>'Do not show again.','mod'=>'iqitpopup'),$_smarty_tpl);?>
</label></div> -->
<div class="iqit-close-popup"><span class="cross" title="<?php echo smartyTranslate(array('s'=>'Close window','mod'=>'iqitpopup'),$_smarty_tpl);?>
"></span></div>
</div>


<div class="iqitpopup-content"><?php echo stripslashes($_smarty_tpl->tpl_vars['txt']->value);?>
</div>
<?php if ($_smarty_tpl->tpl_vars['newsletter']->value) {?>
<div class="iqitpopup-newsletter-form">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
		<!-- <span class="promo-text"><?php echo smartyTranslate(array('s'=>'Sign up to receive latest news and updates direct to your inbox','mod'=>'iqitpopup'),$_smarty_tpl);?>
</span> -->
	</div>
	<div class="col-xs-12 col-sm-12">
	<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',null,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" method="post">
			<div>
				<input class="inputNew form-control grey newsletter-input" type="text" name="name" size="18" placeholder="<?php echo smartyTranslate(array('s'=>'Enter your Name','mod'=>'iqitpopup'),$_smarty_tpl);?>
" value="" />
				<input class="inputNew form-control grey newsletter-input" type="text" name="email" size="18" placeholder="<?php echo smartyTranslate(array('s'=>'Enter your e-mail','mod'=>'iqitpopup'),$_smarty_tpl);?>
" value="" />
				<input type="checkbox" name="confirm" value="yes" id="confirm_form"><label for="confirm">Jeg accepterer <a href="#" id="terms_popup_toggle">betingelserne</a></label>
                <button type="submit" name="submitNewsletter" class="btn btn-default button button-medium iqit-btn-newsletter" disabled>
                    <span><?php echo smartyTranslate(array('s'=>'JA TAK, SEND MIG E-BOGEN NU!','mod'=>'iqitpopup'),$_smarty_tpl);?>
 
				</span>
                </button>
				<input type="hidden" name="action" value="0" />
			</div>
		</form>
	</div>		</div></div>
	<?php }?>
</div> <!-- #layer_cart -->
<div id="iqitpopup-overlay hide_popup"></div>
<div class="" id="popup_toggle">
	<button class="btn btn_default"><?php echo smartyTranslate(array('s'=>'Get a free ebook now!','mod'=>'iqitpopup'),$_smarty_tpl);?>
</button>
</div>
<div class="terms_popup_wrap">
<div id="terms_popup"><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</div>
<button><?php echo smartyTranslate(array('s'=>'close','mod'=>'iqitpopup'),$_smarty_tpl);?>
</button>
</div>
<?php }
}
