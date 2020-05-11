<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:38:59
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/tree/tree_node_folder_checkbox.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff49347d2c6_56650014',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd017ade54397ac4c95a54afe8e5f68b5d464a654' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/tree/tree_node_folder_checkbox.tpl',
      1 => 1585821159,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ff49347d2c6_56650014 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_escape')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/modifier.escape.php';
?>

<li class="tree-folder">
	<span class="tree-folder-name<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled']) && $_smarty_tpl->tpl_vars['node']->value['disabled'] == true) {?> tree-folder-name-disable<?php }?>">
		<?php if (isset($_smarty_tpl->tpl_vars['node']->value['id_category']) && $_smarty_tpl->tpl_vars['node']->value['id_category'] != $_smarty_tpl->tpl_vars['root_category']->value) {?>
		<input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['input_name']->value;?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['node']->value['id_category'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled']) && $_smarty_tpl->tpl_vars['node']->value['disabled'] == true) {?> disabled="disabled"<?php }?> />
		<?php }?>
		<i class="fa fa-folder"></i>
		<label class="tree-toggler"><?php if (isset($_smarty_tpl->tpl_vars['node']->value['name'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['node']->value['name'], ENT_QUOTES, 'UTF-8', true);
}
if (isset($_smarty_tpl->tpl_vars['node']->value['selected_childs']) && (int)$_smarty_tpl->tpl_vars['node']->value['selected_childs'] > 0) {?> <?php echo smartyTranslate(array('s'=>'(%s selected)','sprintf'=>$_smarty_tpl->tpl_vars['node']->value['selected_childs']),$_smarty_tpl);
}?></label>
	</span>
	<ul class="tree">
		<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['children']->value, 'UTF-8');?>

	</ul>
</li>
<?php }
}
