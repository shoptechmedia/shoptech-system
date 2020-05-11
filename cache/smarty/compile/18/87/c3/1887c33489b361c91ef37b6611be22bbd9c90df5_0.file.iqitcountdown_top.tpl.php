<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/modules/iqitcountdown/iqitcountdown_top.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf56d1cb4_27247507',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1887c33489b361c91ef37b6611be22bbd9c90df5' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/iqitcountdown/iqitcountdown_top.tpl',
      1 => 1585125236,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf56d1cb4_27247507 (Smarty_Internal_Template $_smarty_tpl) {
$_block_plugin1 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin1, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'iqitcountdown_days'));
$_block_repeat=true;
echo $_block_plugin1->addJsDefL(array('name'=>'iqitcountdown_days'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo smartyTranslate(array('s'=>'d.','mod'=>'iqitcountdown','js'=>1),$_smarty_tpl);
$_block_repeat=false;
echo $_block_plugin1->addJsDefL(array('name'=>'iqitcountdown_days'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
$_block_plugin2 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin2, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'iqitcountdown_hours'));
$_block_repeat=true;
echo $_block_plugin2->addJsDefL(array('name'=>'iqitcountdown_hours'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo smartyTranslate(array('s'=>'Hours','mod'=>'iqitcountdown','js'=>1),$_smarty_tpl);
$_block_repeat=false;
echo $_block_plugin2->addJsDefL(array('name'=>'iqitcountdown_hours'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
$_block_plugin3 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin3, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'iqitcountdown_minutes'));
$_block_repeat=true;
echo $_block_plugin3->addJsDefL(array('name'=>'iqitcountdown_minutes'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo smartyTranslate(array('s'=>'Min','mod'=>'iqitcountdown','js'=>1),$_smarty_tpl);
$_block_repeat=false;
echo $_block_plugin3->addJsDefL(array('name'=>'iqitcountdown_minutes'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
$_block_plugin4 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin4, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'iqitcountdown_seconds'));
$_block_repeat=true;
echo $_block_plugin4->addJsDefL(array('name'=>'iqitcountdown_seconds'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo smartyTranslate(array('s'=>'Sec','mod'=>'iqitcountdown','js'=>1),$_smarty_tpl);
$_block_repeat=false;
echo $_block_plugin4->addJsDefL(array('name'=>'iqitcountdown_seconds'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>




<?php }
}
