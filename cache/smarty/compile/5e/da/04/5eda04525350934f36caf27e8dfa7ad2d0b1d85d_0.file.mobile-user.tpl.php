<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/themes/shoptech/mobile-user.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf5c5ec38_58521736',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5eda04525350934f36caf27e8dfa7ad2d0b1d85d' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/mobile-user.tpl',
      1 => 1585125217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf5c5ec38_58521736 (Smarty_Internal_Template $_smarty_tpl) {
?>


    <div class="mh-drop">
        <?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
        <p><?php echo smartyTranslate(array('s'=>'Hi'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_lastname;?>
</p>
        <ul>
            <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Manage my customer account'),$_smarty_tpl);?>
" rel="nofollow"><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('index');?>
?mylogout" title="<?php echo smartyTranslate(array('s'=>'Sign out'),$_smarty_tpl);?>
" rel="nofollow"><?php echo smartyTranslate(array('s'=>'Sign out'),$_smarty_tpl);?>
</a></li>
        </ul>
        <?php } else { ?>
        <p><?php echo smartyTranslate(array('s'=>'Please login or create account'),$_smarty_tpl);?>
</p>
        <ul>
            <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Log in'),$_smarty_tpl);?>
" rel="nofollow"><?php echo smartyTranslate(array('s'=>'Log in/Create account'),$_smarty_tpl);?>
</a></li>

        </ul>
        <?php }?>
    </div>
<?php }
}
