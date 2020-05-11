<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:38:59
  from "/home/shoptech/public_html/beta/modules/HolidaySale/views/templates/admin/form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff493301853_18072302',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ade40d859d3c79fd616e0d038fc95215ee020c11' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/HolidaySale/views/templates/admin/form.tpl',
      1 => 1574340421,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ff493301853_18072302 (Smarty_Internal_Template $_smarty_tpl) {
?>


<?php if (!$_smarty_tpl->tpl_vars['id_holiday_sale']->value) {?>
<div class="panel">
	<div class="panel-heading">
		<i class="icon-folder-close"></i>
		<?php echo smartyTranslate(array('s'=>'Holiday Sale Pages','mod'=>'HolidaySale'),$_smarty_tpl);?>

	</div>

	<div class="panel-body">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'page');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
?>
			<?php if ($_smarty_tpl->tpl_vars['page']->value) {?>
			<div class="holiday_item row">
				<span class="col-xs-2"><?php echo $_smarty_tpl->tpl_vars['page']->value['id_holiday_sale'];?>
</span>
				<span class="col-xs-4"><?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
</span>
				<span class="col-xs-3"><?php echo $_smarty_tpl->tpl_vars['page']->value['release_date'];?>
</span>
				<span class="col-xs-3">
					<a target="_blank" href="//<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
/holiday_sale/<?php echo $_smarty_tpl->tpl_vars['page']->value['id_holiday_sale'];?>
-<?php echo $_smarty_tpl->tpl_vars['page']->value['link_rewrite'];?>
"><?php echo smartyTranslate(array('s'=>'View','mod'=>'HolidaySale'),$_smarty_tpl);?>
</a> | 
					<a href="#" class="edit_holiday_page" data-id_holiday_sale="<?php echo $_smarty_tpl->tpl_vars['page']->value['id_holiday_sale'];?>
"><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'HolidaySale'),$_smarty_tpl);?>
</a> | 
					<a href="#" class="delete_holiday_page" data-id_holiday_sale="<?php echo $_smarty_tpl->tpl_vars['page']->value['id_holiday_sale'];?>
"><?php echo smartyTranslate(array('s'=>'Delete','mod'=>'HolidaySale'),$_smarty_tpl);?>
</a>
				</span>
			</div>
			<?php }?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	</div>

	<div class="panel-footer">
		<button type="submit" value="1" id="add_new_page" name="submitHolidaySale" class="btn btn-default pull-right">
			<i class="process-icon-new"></i> <?php echo smartyTranslate(array('s'=>'Add New','mod'=>'HolidaySale'),$_smarty_tpl);?>

		</button>
	</div>
</div>
<?php }?>

<?php echo '<script'; ?>
>
var id_holiday_sale = <?php echo $_smarty_tpl->tpl_vars['id_holiday_sale']->value;?>
;
<?php echo '</script'; ?>
><?php }
}
