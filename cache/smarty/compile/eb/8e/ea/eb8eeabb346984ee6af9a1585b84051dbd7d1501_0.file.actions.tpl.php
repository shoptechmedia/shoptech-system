<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:27:32
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/cart_rules/actions.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebc84a95e25_37106944',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb8eeabb346984ee6af9a1585b84051dbd7d1501' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/cart_rules/actions.tpl',
      1 => 1585579593,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebc84a95e25_37106944 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="form-group">
	<label class="control-label  col-lg-3"><?php echo smartyTranslate(array('s'=>'Free shipping'),$_smarty_tpl);?>
</label>
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="free_shipping" id="free_shipping_on" value="1" <?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'free_shipping'))) {?>checked="checked"<?php }?> />
			<label class="t" for="free_shipping_on">
				<?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>

			</label>
			<input type="radio" name="free_shipping" id="free_shipping_off" value="0"  <?php if (!intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'free_shipping'))) {?>checked="checked"<?php }?> />
			<label class="t" for="free_shipping_off">
				<?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>

			</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Apply a discount'),$_smarty_tpl);?>
</label>
	<div class="col-lg-9">
		<div class="radio">
			<label for="apply_discount_percent">
				<input type="radio" name="apply_discount" id="apply_discount_percent" value="percent" <?php if (floatval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_percent')) > 0) {?>checked="checked"<?php }?> />
				<?php echo smartyTranslate(array('s'=>'Percent (%)'),$_smarty_tpl);?>

			</label>
		</div>
		<div class="radio">
			<label for="apply_discount_amount">
				<input type="radio" name="apply_discount" id="apply_discount_amount" value="amount" <?php if (floatval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_amount')) > 0) {?>checked="checked"<?php }?> />
				<?php echo smartyTranslate(array('s'=>'Amount'),$_smarty_tpl);?>

			</label>
		</div>
		<div class="radio">
			<label for="apply_discount_off">
				<input type="radio" name="apply_discount" id="apply_discount_off" value="off" <?php if (!floatval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_amount')) > 0 && !floatval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_percent')) > 0) {?>checked="checked"<?php }?> />
				<i class="icon-remove color_danger"></i> <?php echo smartyTranslate(array('s'=>'None'),$_smarty_tpl);?>

			</label>
		</div>
	</div>
</div>

<div id="apply_discount_percent_div" class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Value'),$_smarty_tpl);?>
</label>
	<div class="col-lg-9">
		<div class="input-group col-lg-2">
			<span class="input-group-addon">%</span>
			<input type="text" id="reduction_percent" class="input-mini" name="reduction_percent" value="<?php echo floatval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_percent'));?>
" />
		</div>
		<span class="help-block"><i class="icon-warning-sign"></i> <?php echo smartyTranslate(array('s'=>'Does not apply to the shipping costs'),$_smarty_tpl);?>
</span>
	</div>
</div>

<div id="apply_discount_amount_div" class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Amount'),$_smarty_tpl);?>
</label>
	<div class="col-lg-7">
		<div class="row">
			<div class="col-lg-4">
				<input type="text" id="reduction_amount" name="reduction_amount" value="<?php echo floatval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_amount'));?>
" onchange="this.value = this.value.replace(/,/g, '.');" />
			</div>
			<div class="col-lg-4">
				<select name="reduction_currency" >
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['currencies']->value, 'currency');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->value) {
?>
					<option value="<?php echo intval($_smarty_tpl->tpl_vars['currency']->value['id_currency']);?>
" <?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_currency') == $_smarty_tpl->tpl_vars['currency']->value['id_currency'] || (!$_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_currency') && $_smarty_tpl->tpl_vars['currency']->value['id_currency'] == $_smarty_tpl->tpl_vars['defaultCurrency']->value)) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['currency']->value['iso_code'];?>
</option>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
			<div class="col-lg-4">
				<select name="reduction_tax" >
					<option value="0" <?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_tax') == 0) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Tax excluded'),$_smarty_tpl);?>
</option>
					<option value="1" <?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_tax') == 1) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Tax included'),$_smarty_tpl);?>
</option>
				</select>
			</div>
		</div>
	</div>
</div>

<div id="apply_discount_to_div" class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Apply a discount to'),$_smarty_tpl);?>
</label>
	<div class="col-lg-7">
		<p class="radio">
			<label for="apply_discount_to_order">
				<input type="radio" name="apply_discount_to" id="apply_discount_to_order" value="order"<?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_product')) == 0) {?> checked="checked"<?php }?> />
				 <?php echo smartyTranslate(array('s'=>'Order (without shipping)'),$_smarty_tpl);?>

			</label>
		</p>
		<p class="radio">
			<label for="apply_discount_to_product">
				<input type="radio" name="apply_discount_to" id="apply_discount_to_product" value="specific"<?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_product')) > 0) {?> checked="checked"<?php }?> />
				<?php echo smartyTranslate(array('s'=>'Specific product'),$_smarty_tpl);?>

			</label>
		</p>
		<p class="radio">
			<label for="apply_discount_to_cheapest">
				<input type="radio" name="apply_discount_to" id="apply_discount_to_cheapest" value="cheapest"<?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_product')) == -1) {?> checked="checked"<?php }?> />
				 <?php echo smartyTranslate(array('s'=>'Cheapest product'),$_smarty_tpl);?>

			</label>
		</p>
		<p class="radio">
			<label for="apply_discount_to_selection">
				<input type="radio" name="apply_discount_to" id="apply_discount_to_selection" value="selection"<?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_product')) == -2) {?> checked="checked"<?php }
if (count($_smarty_tpl->tpl_vars['product_rule_groups']->value) == 0) {?>disabled="disabled"<?php }?> />
				<?php echo smartyTranslate(array('s'=>'Selected product(s)'),$_smarty_tpl);
if (count($_smarty_tpl->tpl_vars['product_rule_groups']->value) == 0) {?>&nbsp;<span id="apply_discount_to_selection_warning" class="text-muted clearfix"><i class="icon-warning-sign"></i> <a href="#" id="apply_discount_to_selection_shortcut"><?php echo smartyTranslate(array('s'=>'You must select some products before'),$_smarty_tpl);?>
</a></span><?php }?>
			</label>
		</p>
	</div>
</div>

<div id="apply_discount_to_product_div" class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Product'),$_smarty_tpl);?>
</label>
	<div class="col-lg-9">
		<div class="input-group col-lg-5">
			<input type="text" id="reductionProductFilter" name="reductionProductFilter" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['reductionProductFilter']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
			<input type="hidden" id="reduction_product" name="reduction_product" value="<?php echo intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'reduction_product'));?>
" />
			<span class="input-group-addon"><i class="icon-search"></i></span>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Send a free gift'),$_smarty_tpl);?>
</label>
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="free_gift" id="free_gift_on" value="1" <?php if (intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'gift_product'))) {?>checked="checked"<?php }?> />
			<label class="t" for="free_gift_on">
				<?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>

			</label>
			<input type="radio" name="free_gift" id="free_gift_off" value="0" <?php if (!intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'gift_product'))) {?>checked="checked"<?php }?> />
			<label class="t" for="free_gift_off">
				<?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>

			</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>

<div id="free_gift_div" class="form-group">
	<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Search a product'),$_smarty_tpl);?>
</label>
	<div class="col-lg-9">
		<div class="input-group col-lg-5">
			<input type="text" id="giftProductFilter" value="<?php echo $_smarty_tpl->tpl_vars['giftProductFilter']->value;?>
" />
			<span class="input-group-addon"><i class="icon-search"></i></span>
		</div>
	</div>
</div>

<div id="gift_products_found" <?php if ($_smarty_tpl->tpl_vars['gift_product_select']->value == '') {?>style="display:none"<?php }?>>
	<div id="gift_product_list" class="form-group">
		<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Matching products'),$_smarty_tpl);?>
</label>
		<div class="col-lg-5">
			<select name="gift_product" id="gift_product" onclick="displayProductAttributes();" class="control-form">
				<?php echo $_smarty_tpl->tpl_vars['gift_product_select']->value;?>

			</select>
		</div>
	</div>
	<div id="gift_attributes_list" class="form-group" <?php if (!$_smarty_tpl->tpl_vars['hasAttribute']->value) {?>style="display:none"<?php }?>>
		<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Available combinations'),$_smarty_tpl);?>
</label>
		<div class="col-lg-5" id="gift_attributes_list_select">
			<?php echo $_smarty_tpl->tpl_vars['gift_product_attribute_select']->value;?>

		</div>
	</div>
</div>
<div id="gift_products_err" class="alert alert-warning" style="display:none"></div>
<?php }
}
