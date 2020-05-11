<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:56
  from "/home/shoptech/public_html/beta/modules/cookielaw/cookielaw.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea80207d1_20056827',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b956e39e6df0d3304f83a7f8bc7552b85cce44b' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/cookielaw/cookielaw.tpl',
      1 => 1585125236,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea19ea80207d1_20056827 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '5670249265ea19ea801c829_76067753';
?>
<div id="cookielaw" class="cookielaw">
<div class="container">
<a id="cookie_close" class="button btn btn-default button-small" href="#"><span><?php echo smartyTranslate(array('s'=>'Accept','mod'=>'cookielaw'),$_smarty_tpl);?>
</span></a>
<?php echo $_smarty_tpl->tpl_vars['cookielaw']->value->body_paragraph;?>

    </div>
</div><?php }
}
