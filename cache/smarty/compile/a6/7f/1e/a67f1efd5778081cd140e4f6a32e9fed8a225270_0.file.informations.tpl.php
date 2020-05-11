<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:34:51
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/cart_rules/informations.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebe3bde1d40_64825756',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a67f1efd5778081cd140e4f6a32e9fed8a225270' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/cart_rules/informations.tpl',
      1 => 1587461690,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebe3bde1d40_64825756 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="form-group">
	<label class="control-label col-lg-3 required">
		<span class="label-tooltip" data-toggle="tooltip"
		title="<?php echo smartyTranslate(array('s'=>'This will be displayed in the cart summary, as well as on the invoice.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Name'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-8">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
		<?php if (count($_smarty_tpl->tpl_vars['languages']->value) > 1) {?>
		<div class="">
			<div class="translatable-field lang-<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang'] != $_smarty_tpl->tpl_vars['id_lang_default']->value) {?>style="display:none"<?php }?>>
				<div class="input-group">
		<?php }?>
					<input class="form-control" id="name_<?php echo intval($_smarty_tpl->tpl_vars['language']->value['id_lang']);?>
" type="text"  name="name_<?php echo intval($_smarty_tpl->tpl_vars['language']->value['id_lang']);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'name',intval($_smarty_tpl->tpl_vars['language']->value['id_lang'])), ENT_QUOTES, 'UTF-8', true);?>
">
		<?php if (count($_smarty_tpl->tpl_vars['languages']->value) > 1) {?>

					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>

						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
						<li><a href="javascript:hideOtherLanguage(<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
);" tabindex="-1"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</a></li>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					</ul>
				</div>
			</div>
		</div>
		<?php }?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
		title="<?php echo smartyTranslate(array('s'=>'For your eyes only. This will never be displayed to the customer.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Description'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-8">
		<textarea name="description" rows="2" class="form-control textarea-autosize"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'description'), ENT_QUOTES, 'UTF-8', true);?>
</textarea>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
		title="<?php echo smartyTranslate(array('s'=>'This is the code users should enter to apply the voucher to a cart. Either create your own code or generate one by clicking on "Generate".'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Code'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<div class="input-group">
			<input class="form-control" type="text" id="code" name="code" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'code'), ENT_QUOTES, 'UTF-8', true);?>
" />
			<span class="input-group-btn">
				<a href="javascript:gencode(8);" class="btn btn-primary"><i class="icon-random"></i> <?php echo smartyTranslate(array('s'=>'Generate'),$_smarty_tpl);?>
</a>
			</span>
		</div>

		<span class="help-block"><?php echo smartyTranslate(array('s'=>'Caution! If you leave this field blank, the rule will automatically be applied to benefiting customers.'),$_smarty_tpl);?>
</span>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
		title="<?php echo smartyTranslate(array('s'=>'If the voucher is not yet in the cart, it will be displayed in the cart summary.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Highlight'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="highlight" id="highlight_on" value="1" <?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'highlight'))) {?>checked="checked"<?php }?>/>
			<label for="highlight_on"><?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
</label>
			<input type="radio" name="highlight" id="highlight_off" value="0"  <?php if (!intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'highlight'))) {?>checked="checked"<?php }?> />
			<label for="highlight_off"><?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
		title="<?php echo smartyTranslate(array('s'=>'Only applicable if the voucher value is greater than the cart total.'),$_smarty_tpl);?>

		<?php echo smartyTranslate(array('s'=>'If you do not allow partial use, the voucher value will be lowered to the total order amount. If you allow partial use, however, a new voucher will be created with the remainder.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Partial use'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="partial_use" id="partial_use_on" value="1" <?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'partial_use'))) {?>checked="checked"<?php }?> />
			<label class="t" for="partial_use_on"><?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
</label>
			<input type="radio" name="partial_use" id="partial_use_off" value="0"  <?php if (!intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'partial_use'))) {?>checked="checked"<?php }?> />
			<label class="t" for="partial_use_off"><?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
		title="<?php echo smartyTranslate(array('s'=>'Cart rules are applied by priority. A cart rule with a priority of "1" will be processed before a cart rule with a priority of "2".'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Priority'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-1">
		<input type="text" class="form-control input-mini" name="priority" value="<?php echo intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'priority'));?>
" />
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Status'),$_smarty_tpl);?>
</label>
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="active" id="active_on" value="1" <?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'active'))) {?>checked="checked"<?php }?> />
			<label class="t" for="active_on"><?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
</label>
			<input type="radio" name="active" id="active_off" value="0"  <?php if (!intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'active'))) {?>checked="checked"<?php }?> />
			<label class="t" for="active_off"><?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
	$(".textarea-autosize").autosize();
<?php echo '</script'; ?>
>
<?php }
}
