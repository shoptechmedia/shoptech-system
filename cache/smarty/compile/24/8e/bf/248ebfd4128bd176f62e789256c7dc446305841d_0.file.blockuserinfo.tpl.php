<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/themes/shoptech/modules/blockuserinfo/blockuserinfo.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf57db7c6_63532829',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '248ebfd4128bd176f62e789256c7dc446305841d' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/modules/blockuserinfo/blockuserinfo.tpl',
      1 => 1537263670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf57db7c6_63532829 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="header_user_info col-xs-12 col-sm-<?php echo 4-$_smarty_tpl->tpl_vars['warehouse_vars']->value['logo_width']/2;?>
">
	<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="account"><i class="icon-user"></i> <span><?php echo smartyTranslate(array('s'=>'Hi','mod'=>'blockuserinfo'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_firstname;?>
 </span></a> <span class="log-separator">/</span> 
		<a class="logout" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,NULL,"mylogout"), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Sign out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
 <i class="icon-signout"></i>
		</a>
	<?php } else { ?>
		<a class="login" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Login to your customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
			<i class="icon-signin"></i> <?php echo smartyTranslate(array('s'=>'Sign in','mod'=>'blockuserinfo'),$_smarty_tpl);?>

		</a>
	<?php }?>
</div><?php }
}
