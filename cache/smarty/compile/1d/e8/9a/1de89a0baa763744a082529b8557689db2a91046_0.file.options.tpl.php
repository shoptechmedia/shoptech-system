<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:57:53
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/preferences/helpers/options/options.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea007110e9e97_19443925',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1de89a0baa763744a082529b8557689db2a91046' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/preferences/helpers/options/options.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea007110e9e97_19443925 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16655119685ea007110dd3d7_79019271', "input");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/options/options.tpl");
}
/* {block "input"} */
class Block_16655119685ea007110dd3d7_79019271 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input' => 
  array (
    0 => 'Block_16655119685ea007110dd3d7_79019271',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'disabled') {?>
		<?php echo $_smarty_tpl->tpl_vars['field']->value['disabled'];?>

	<?php } else { ?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

	<?php }
}
}
/* {/block "input"} */
}
