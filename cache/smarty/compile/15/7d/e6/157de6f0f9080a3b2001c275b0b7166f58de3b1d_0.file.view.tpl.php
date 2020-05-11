<?php
/* Smarty version 3.1.31, created on 2020-04-22 12:25:34
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/carrier_wizard/helpers/view/view.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea00d8e69c683_12788522',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '157de6f0f9080a3b2001c275b0b7166f58de3b1d' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/carrier_wizard/helpers/view/view.tpl',
      1 => 1587547532,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea00d8e69c683_12788522 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12212012965ea00d8e65fb82_42917562', "override_tpl");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/view/view.tpl");
}
/* {block "override_tpl"} */
class Block_12212012965ea00d8e65fb82_42917562 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'override_tpl' => 
  array (
    0 => 'Block_12212012965ea00d8e65fb82_42917562',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
>
	var labelNext = '<?php echo addslashes($_smarty_tpl->tpl_vars['labels']->value['next']);?>
';
	var labelPrevious = '<?php echo addslashes($_smarty_tpl->tpl_vars['labels']->value['previous']);?>
';
	var	labelFinish = '<?php echo addslashes($_smarty_tpl->tpl_vars['labels']->value['finish']);?>
';
	var	labelDelete = '<?php echo smartyTranslate(array('s'=>'Delete','js'=>1),$_smarty_tpl);?>
';
	var	labelValidate = '<?php echo smartyTranslate(array('s'=>'Validate','js'=>1),$_smarty_tpl);?>
';
	var validate_url = '<?php echo addslashes($_smarty_tpl->tpl_vars['validate_url']->value);?>
';
	var carrierlist_url = '<?php echo addslashes($_smarty_tpl->tpl_vars['carrierlist_url']->value);?>
';
	var nbr_steps = <?php echo count($_smarty_tpl->tpl_vars['wizard_steps']->value['steps']);?>
;
	var enableAllSteps = <?php if (intval($_smarty_tpl->tpl_vars['enableAllSteps']->value) == 1) {?>true<?php } else { ?>false<?php }?>;
	var delete_range_confirm = '<?php echo smartyTranslate(array('s'=>'Are you sure to delete this range ?','js'=>1),$_smarty_tpl);?>
';
	var currency_sign = '<?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
';
	var currency_iso_code = '<?php echo $_smarty_tpl->tpl_vars['currency_iso_code']->value;?>
';
	var PS_WEIGHT_UNIT = '<?php echo $_smarty_tpl->tpl_vars['PS_WEIGHT_UNIT']->value;?>
';
	var invalid_value = '<?php echo smartyTranslate(array('s'=>'One of the entered values is not valid','js'=>1),$_smarty_tpl);?>
';
	var negative_range = '<?php echo smartyTranslate(array('s'=>'At least one range is of zero size or negative','js'=>1),$_smarty_tpl);?>
';
	var overlapping_range = '<?php echo smartyTranslate(array('s'=>'Gaps or overlappings between ranges','js'=>1),$_smarty_tpl);?>
';
	var select_at_least_one_zone = '<?php echo smartyTranslate(array('s'=>'Please select at least one zone','js'=>1),$_smarty_tpl);?>
';
	var multistore_enable = '<?php echo $_smarty_tpl->tpl_vars['multistore_enable']->value;?>
';
<?php echo '</script'; ?>
>

<div class="row">
	<div class="col-sm-2">
		<?php echo $_smarty_tpl->tpl_vars['logo_content']->value;?>

	</div>
	<div class="col-sm-10">
		<div id="carrier_wizard" class="panel swMain">
			<ul class="panel-heading steps nbr_steps_<?php echo count($_smarty_tpl->tpl_vars['wizard_steps']->value['steps']);?>
">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['wizard_steps']->value['steps'], 'step', false, 'step_nbr');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['step_nbr']->value => $_smarty_tpl->tpl_vars['step']->value) {
?>
				<li>
					<a class="btn btn-default mr-1" href="#step-<?php echo $_smarty_tpl->tpl_vars['step_nbr']->value+1;?>
">
						<span class="stepNumber"><?php echo $_smarty_tpl->tpl_vars['step_nbr']->value+1;?>
</span>
						<span class="stepDesc">
							<?php echo $_smarty_tpl->tpl_vars['step']->value['title'];?>
<br />
							<?php if (isset($_smarty_tpl->tpl_vars['step']->value['desc'])) {?><small><?php echo $_smarty_tpl->tpl_vars['step']->value['desc'];?>
</small><?php }?>
						</span>
						<span class="chevron"></span>
					</a>
				</li>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</ul>

			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['wizard_contents']->value['contents'], 'content', false, 'step_nbr');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['step_nbr']->value => $_smarty_tpl->tpl_vars['content']->value) {
?>
				<div id="step-<?php echo $_smarty_tpl->tpl_vars['step_nbr']->value+1;?>
" class="step_container">
					<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

				</div>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</div>
	</div>
</div>
<?php
}
}
/* {/block "override_tpl"} */
}
