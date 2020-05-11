<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:58:00
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/geolocation/helpers/options/options.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0071807b859_92271570',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ebff293b4622d6f02241e39c6d15d10abb66bea3' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/geolocation/helpers/options/options.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0071807b859_92271570 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/modifier.replace.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4810974385ea00718060377_30036998', "field");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10159982575ea00718075c57_50771046', "input");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/options/options.tpl");
}
/* {block "field"} */
class Block_4810974385ea00718060377_30036998 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'field' => 
  array (
    0 => 'Block_4810974385ea00718060377_30036998',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'checkbox_table') {?>
		
		<div class="well margin-form" style="height: 300px; overflow-y: auto;">
			<table class="table" style="border-spacing : 0; border-collapse : collapse;">
				<thead>
					<tr>
						<th><input type="checkbox" name="checkAll" onclick="checkDelBoxes(this.form, 'countries[]', this.checked)" /></th>
						<th><?php echo smartyTranslate(array('s'=>'Name'),$_smarty_tpl);?>
</th>
					</tr>
				</thead>
				<tbody>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['list'], 'country');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['country']->value) {
?>
						<tr>
							<td><input type="checkbox" name="countries[]" value="<?php echo $_smarty_tpl->tpl_vars['country']->value[$_smarty_tpl->tpl_vars['field']->value['identifier']];?>
" <?php if (in_array(strtoupper($_smarty_tpl->tpl_vars['country']->value['iso_code']),$_smarty_tpl->tpl_vars['allowed_countries']->value)) {?>checked="checked"<?php }?> /></td>
							<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['country']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
						</tr>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

	<?php }
}
}
/* {/block "field"} */
/* {block "input"} */
class Block_10159982575ea00718075c57_50771046 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input' => 
  array (
    0 => 'Block_10159982575ea00718075c57_50771046',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'textarea_newlines') {?>
		<div class="col-lg-9">
			<textarea name=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 cols="<?php echo $_smarty_tpl->tpl_vars['field']->value['cols'];?>
" rows="<?php echo $_smarty_tpl->tpl_vars['field']->value['rows'];?>
"><?php echo htmlspecialchars(smarty_modifier_replace($_smarty_tpl->tpl_vars['field']->value['value'],';',"\n"), ENT_QUOTES, 'UTF-8', true);?>
</textarea>
		</div>
	<?php } else { ?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

	<?php }
}
}
/* {/block "input"} */
}
