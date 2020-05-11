<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:57:34
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/tax_rules/helpers/list/list_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea006fe517d21_27415037',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '209a13edc4af1ed75ead019a466fd805327a209f' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/tax_rules/helpers/list/list_content.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea006fe517d21_27415037 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_regex_replace')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/modifier.regex_replace.php';
?>

<tbody>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'tr', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['tr']->value) {
?>
		<tr
		<?php if ($_smarty_tpl->tpl_vars['position_identifier']->value) {?>id="tr_<?php echo $_smarty_tpl->tpl_vars['id_category']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['identifier']->value];?>
_<?php echo $_smarty_tpl->tpl_vars['tr']->value['position']['position'];?>
"<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tr']->value['color']) && $_smarty_tpl->tpl_vars['color_on_bg']->value) {?>style="background-color: <?php echo $_smarty_tpl->tpl_vars['tr']->value['color'];?>
"<?php }?> >
			<?php if ($_smarty_tpl->tpl_vars['bulk_actions']->value && $_smarty_tpl->tpl_vars['has_bulk_actions']->value) {?>
				<td class="text-center">
					<?php $_smarty_tpl->_assignInScope('bulkActionPossible', true);
?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list_skip_actions']->value, 'value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
						<?php if (in_array($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['identifier']->value],$_smarty_tpl->tpl_vars['value']->value) == true) {?>
							<?php $_smarty_tpl->_assignInScope('bulkActionPossible', false);
?>
						<?php }?>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					<?php if ($_smarty_tpl->tpl_vars['bulkActionPossible']->value == true) {?>
						<input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
Box[]" value="<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['identifier']->value];?>
" class="noborder" />
					<?php }?>
				</td>
			<?php }?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_display']->value, 'params', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['params']->value) {
?>
				<td
					<?php if (isset($_smarty_tpl->tpl_vars['params']->value['position'])) {?>
						id="td_<?php if ($_smarty_tpl->tpl_vars['id_category']->value) {
echo $_smarty_tpl->tpl_vars['id_category']->value;
} else { ?>0<?php }?>_<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['identifier']->value];?>
"
					<?php }?>
					class="<?php if (!$_smarty_tpl->tpl_vars['no_link']->value) {?>pointer<?php }
if (isset($_smarty_tpl->tpl_vars['params']->value['position']) && $_smarty_tpl->tpl_vars['order_by']->value == 'position') {?> dragHandle<?php }
if (isset($_smarty_tpl->tpl_vars['params']->value['align'])) {?> <?php echo $_smarty_tpl->tpl_vars['params']->value['align'];
}?>"

				<?php if ((!isset($_smarty_tpl->tpl_vars['params']->value['position']) && !$_smarty_tpl->tpl_vars['no_link']->value)) {?>
					onclick="document.location = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_index']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['identifier']->value, ENT_QUOTES, 'UTF-8', true);?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['identifier']->value], ENT_QUOTES, 'UTF-8', true);
if ($_smarty_tpl->tpl_vars['view']->value) {?>&amp;view<?php } else { ?>&amp;update<?php }
echo $_smarty_tpl->tpl_vars['table']->value;?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
'"><?php if (isset($_smarty_tpl->tpl_vars['params']->value['prefix'])) {
echo $_smarty_tpl->tpl_vars['params']->value['prefix'];
}?>
				<?php } else { ?>
					>
				<?php }?>
				<?php if (isset($_smarty_tpl->tpl_vars['params']->value['active'])) {?>
				    <?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>

				<?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['activeVisu'])) {?>
					<img src="../img/admin/<?php if ($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]) {?>enabled.gif<?php } else { ?>disabled.gif<?php }?>"
					alt="<?php if ($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]) {
echo smartyTranslate(array('s'=>'Enabled'),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'Disabled'),$_smarty_tpl);
}?>" title="<?php if ($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]) {
echo smartyTranslate(array('s'=>'Enabled'),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'Disabled'),$_smarty_tpl);
}?>" />
				<?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['position'])) {?>
					<?php if ($_smarty_tpl->tpl_vars['order_by']->value == 'position' && $_smarty_tpl->tpl_vars['order_way']->value != 'DESC') {?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]['position_url_down'];?>
" <?php if (!($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]['position'] != $_smarty_tpl->tpl_vars['positions']->value[count($_smarty_tpl->tpl_vars['positions']->value)-1])) {?>style="display: none;"<?php }?>>
							<img src="../img/admin/<?php if ($_smarty_tpl->tpl_vars['order_way']->value == 'ASC') {?>down<?php } else { ?>up<?php }?>.gif" alt="<?php echo smartyTranslate(array('s'=>'Down'),$_smarty_tpl);?>
" title="<?php echo smartyTranslate(array('s'=>'Down'),$_smarty_tpl);?>
" />
						</a>

						<a href="<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]['position_url_up'];?>
" <?php if (!($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]['position'] != $_smarty_tpl->tpl_vars['positions']->value[0])) {?>style="display: none;"<?php }?>>
							<img src="../img/admin/<?php if ($_smarty_tpl->tpl_vars['order_way']->value == 'ASC') {?>up<?php } else { ?>down<?php }?>.gif" alt="<?php echo smartyTranslate(array('s'=>'Up'),$_smarty_tpl);?>
" title="<?php echo smartyTranslate(array('s'=>'Up'),$_smarty_tpl);?>
" />
						</a>
					<?php } else { ?>
						<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]['position']+1;?>

					<?php }?>
				<?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['image'])) {?>
					<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>

				<?php } elseif ((isset($_smarty_tpl->tpl_vars['params']->value['icon']))) {?>
					<img src="../img/admin/<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>
" title="<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>
" />
	            <?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['price'])) {?>
					<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>

				<?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['float'])) {?>
					<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>

				<?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['type']) && $_smarty_tpl->tpl_vars['params']->value['type'] == 'date') {?>
					<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>

				<?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['type']) && $_smarty_tpl->tpl_vars['params']->value['type'] == 'datetime') {?>
					<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>

				<?php } elseif (isset($_smarty_tpl->tpl_vars['params']->value['callback'])) {?>
					<?php echo $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value];?>

				<?php } elseif (isset($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value])) {?>
					<?php if ($_smarty_tpl->tpl_vars['key']->value == 'behavior') {?>
						<?php if ($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value] == 0) {?>
							<?php echo smartyTranslate(array('s'=>'This tax only'),$_smarty_tpl);?>

						<?php } elseif ($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value] == 1) {?>
							<?php echo smartyTranslate(array('s'=>'Combine'),$_smarty_tpl);?>

						<?php } elseif ($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value] == 2) {?>
							<?php echo smartyTranslate(array('s'=>'One after another'),$_smarty_tpl);?>

						<?php }?>
					<?php } elseif ($_smarty_tpl->tpl_vars['key']->value == 'rate') {?>
						<?php echo sprintf("%.3f",$_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value]);?>
%
					<?php } elseif ($_smarty_tpl->tpl_vars['key']->value == 'zipcode') {?>
						<?php if ($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value] == '0 - 0') {?>
							--
						<?php } else { ?>
							<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value], ENT_QUOTES, 'UTF-8', true);?>

						<?php }?>
					<?php } else { ?>
						<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['key']->value], ENT_QUOTES, 'UTF-8', true);?>

					<?php }?>
				<?php } else { ?>
					--
				<?php }?>
				<?php if (isset($_smarty_tpl->tpl_vars['params']->value['suffix'])) {
echo $_smarty_tpl->tpl_vars['params']->value['suffix'];
}?>
				</td>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


		<?php if ($_smarty_tpl->tpl_vars['shop_link_type']->value) {?>
			<td <?php if ($_smarty_tpl->tpl_vars['name']->value != $_smarty_tpl->tpl_vars['tr']->value['shop_name']) {?>title="<?php echo $_smarty_tpl->tpl_vars['tr']->value['shop_name'];?>
"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['tr']->value['shop_short_name'])) {
echo $_smarty_tpl->tpl_vars['tr']->value['shop_short_name'];
} else {
echo $_smarty_tpl->tpl_vars['tr']->value['shop_name'];
}?></td>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['has_actions']->value) {?>
			<td class="text-right fixed-width-lg">
				<?php $_smarty_tpl->_assignInScope('compiled_actions', array());
?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['actions']->value, 'action', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['action']->value) {
?>
					<?php if (isset($_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['action']->value])) {?>
						<?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>
							<?php $_smarty_tpl->_assignInScope('action', $_smarty_tpl->tpl_vars['action']->value);
?>
						<?php }?>
						<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['compiled_actions']) ? $_smarty_tpl->tpl_vars['compiled_actions']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array[] = $_smarty_tpl->tpl_vars['tr']->value[$_smarty_tpl->tpl_vars['action']->value];
$_smarty_tpl->_assignInScope('compiled_actions', $_tmp_array);
?>
					<?php }?>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				<?php if (count($_smarty_tpl->tpl_vars['compiled_actions']->value) > 0) {?>
					<?php if (count($_smarty_tpl->tpl_vars['compiled_actions']->value) > 1) {?><div class="btn-group-action"><?php }?>
					<div class="btn-group pull-right">
						<?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['compiled_actions']->value[0],'/class\s*=\s*"(\w*)"/','class="$1 btn btn-default"');?>

						<?php if (count($_smarty_tpl->tpl_vars['compiled_actions']->value) > 1) {?>
						<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>&nbsp;
						</button>
							<ul class="dropdown-menu">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['compiled_actions']->value, 'action', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['action']->value) {
?>
								<?php if ($_smarty_tpl->tpl_vars['key']->value != 0) {?>
								<li>
									<?php echo $_smarty_tpl->tpl_vars['action']->value;?>

								</li>
								<?php }?>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</ul>
						<?php }?>
					</div>
					<?php if (count($_smarty_tpl->tpl_vars['compiled_actions']->value) > 1) {?></div><?php }?>
				<?php }?>
			</td>
		<?php }?>
		</tr>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</tbody>
<?php }
}
