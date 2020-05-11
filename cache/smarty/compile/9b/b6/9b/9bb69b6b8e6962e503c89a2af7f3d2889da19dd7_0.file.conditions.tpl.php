<?php
/* Smarty version 3.1.31, created on 2020-04-22 07:37:31
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/cart_rules/conditions.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9fca0b97a2b3_21004691',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9bb69b6b8e6962e503c89a2af7f3d2889da19dd7' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/cart_rules/conditions.tpl',
      1 => 1587461774,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9fca0b97a2b3_21004691 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
			title="<?php echo smartyTranslate(array('s'=>'Optional: The cart rule will be available to everyone if you leave this field blank.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Limit to a single customer'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<div class="input-group col-lg-12">
			<span class="btn btn-info"><i class="icon-user"></i></span>
			<input type="hidden" id="id_customer" name="id_customer" value="<?php echo intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'id_customer'));?>
" />
			<input type="text" id="customerFilter" class="form-control input-xlarge" name="customerFilter" value="<?php if ($_smarty_tpl->tpl_vars['customerFilter']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['customerFilter']->value, ENT_QUOTES, 'UTF-8', true);
} elseif (isset($_POST['customerFilter'])) {
echo htmlspecialchars($_POST['customerFilter'], ENT_QUOTES, 'UTF-8', true);
}?>" />
			<span class="btn btn-primary"><i class="icon-search"></i></span>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
			title="<?php echo smartyTranslate(array('s'=>'The default period is one month.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Valid'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<div class="row">
			<div class="col-lg-6">
				<div class="input-group">
					<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'From'),$_smarty_tpl);?>
</span>
					<input type="text" class="datepicker input-medium" name="date_from"
					value="<?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'date_from')) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'date_from'), ENT_QUOTES, 'UTF-8', true);
} else {
echo $_smarty_tpl->tpl_vars['defaultDateFrom']->value;
}?>" />
					<span class="input-group-addon"><i class="icon-calendar-empty"></i></span>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="input-group">
					<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'To'),$_smarty_tpl);?>
</span>
					<input type="text" class="datepicker input-medium" name="date_to"
					value="<?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'date_to')) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'date_to'), ENT_QUOTES, 'UTF-8', true);
} else {
echo $_smarty_tpl->tpl_vars['defaultDateTo']->value;
}?>" />
					<span class="input-group-addon"><i class="icon-calendar-empty"></i></span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
			title="<?php echo smartyTranslate(array('s'=>'You can choose a minimum amount for the cart either with or without the taxes and shipping.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Minimum amount'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<div class="row">
			<div class="col-lg-3">
				<input type="text" name="minimum_amount" value="<?php echo floatval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'minimum_amount'));?>
" />
			</div>
			<div class="col-lg-2">
				<select name="minimum_amount_currency">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['currencies']->value, 'currency');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->value) {
?>
					<option value="<?php echo intval($_smarty_tpl->tpl_vars['currency']->value['id_currency']);?>
"
					<?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'minimum_amount_currency') == $_smarty_tpl->tpl_vars['currency']->value['id_currency'] || (!$_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'minimum_amount_currency') && $_smarty_tpl->tpl_vars['currency']->value['id_currency'] == $_smarty_tpl->tpl_vars['defaultCurrency']->value)) {?>
						selected="selected"
					<?php }?>
					>
						<?php echo $_smarty_tpl->tpl_vars['currency']->value['iso_code'];?>

					</option>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
			<div class="col-lg-3">
				<select name="minimum_amount_tax">
					<option value="0" <?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'minimum_amount_tax') == 0) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Tax excluded'),$_smarty_tpl);?>
</option>
					<option value="1" <?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'minimum_amount_tax') == 1) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Tax included'),$_smarty_tpl);?>
</option>
				</select>
			</div>
			<div class="col-lg-4">
				<select name="minimum_amount_shipping">
					<option value="0" <?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'minimum_amount_shipping') == 0) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Shipping excluded'),$_smarty_tpl);?>
</option>
					<option value="1" <?php if ($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'minimum_amount_shipping') == 1) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Shipping included'),$_smarty_tpl);?>
</option>
				</select>
			</div>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
			title="<?php echo smartyTranslate(array('s'=>'The cart rule will be applied to the first "X" customers only.'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Total available'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<input class="form-control" type="text" name="quantity" value="<?php echo intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'quantity'));?>
" />
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip"
			title="<?php echo smartyTranslate(array('s'=>'A customer will only be able to use the cart rule "X" time(s).'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Total available for each user'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-9">
		<input class="form-control" type="text" name="quantity_per_user" value="<?php echo intval($_smarty_tpl->tpl_vars['currentTab']->value->getFieldValue($_smarty_tpl->tpl_vars['currentObject']->value,'quantity_per_user'));?>
" />
	</div>
</div>



<div class="form-group">
	<label class="control-label col-lg-3">
		<?php echo smartyTranslate(array('s'=>'Restrictions'),$_smarty_tpl);?>

	</label>
	<div class="col-lg-9">
		<?php if (count($_smarty_tpl->tpl_vars['countries']->value['unselected'])+count($_smarty_tpl->tpl_vars['countries']->value['selected']) > 1) {?>
			<p class="checkbox">
				<label>
					<input type="checkbox" id="country_restriction" name="country_restriction" value="1" <?php if (count($_smarty_tpl->tpl_vars['countries']->value['unselected'])) {?>checked="checked"<?php }?> />
					<?php echo smartyTranslate(array('s'=>'Country selection'),$_smarty_tpl);?>

				</label>
			</p>
			<span class="help-block"><?php echo smartyTranslate(array('s'=>'This restriction applies to the country of delivery.'),$_smarty_tpl);?>
</span>
			<div id="country_restriction_div">
				<br />
				<table class="table">
					<tr>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Unselected countries'),$_smarty_tpl);?>
</p>
							<select id="country_select_1" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['countries']->value['unselected'], 'country');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['country']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['country']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="country_select_add" class="btn  btn-default btn-block clearfix"><?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
 <i class="icon-arrow-right"></i></a>
						</td>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Selected countries'),$_smarty_tpl);?>
</p>
							<select name="country_select[]" id="country_select_2" class="input-large" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['countries']->value['selected'], 'country');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['country']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['country']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="country_select_remove" class="btn btn-default btn-block clearfix"><i class="icon-arrow-left"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
 </a>
						</td>
					</tr>
				</table>
			</div>
		<?php }?>

		<?php if (count($_smarty_tpl->tpl_vars['carriers']->value['unselected'])+count($_smarty_tpl->tpl_vars['carriers']->value['selected']) > 1) {?>
			<p class="checkbox">
				<label>
					<input type="checkbox" id="carrier_restriction" name="carrier_restriction" value="1" <?php if (count($_smarty_tpl->tpl_vars['carriers']->value['unselected'])) {?>checked="checked"<?php }?> />
					<?php echo smartyTranslate(array('s'=>'Carrier selection'),$_smarty_tpl);?>

				</label>
			</p>
			<div id="carrier_restriction_div">
				<br />
				<table class="table">
					<tr>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Unselected carriers'),$_smarty_tpl);?>
</p>
							<select id="carrier_select_1" class="input-large" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['carriers']->value['unselected'], 'carrier');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_reference']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="carrier_select_add" class="btn btn-default btn-block clearfix" ><?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
 <i class="icon-arrow-right"></i></a>
						</td>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Selected carriers'),$_smarty_tpl);?>
</p>
							<select name="carrier_select[]" id="carrier_select_2" class="input-large" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['carriers']->value['selected'], 'carrier');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_reference']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="carrier_select_remove" class="btn btn-default btn-block clearfix"><i class="icon-arrow-left"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
 </a>
						</td>
					</tr>
				</table>
			</div>
		<?php }?>

		<?php if (count($_smarty_tpl->tpl_vars['groups']->value['unselected'])+count($_smarty_tpl->tpl_vars['groups']->value['selected']) > 1) {?>
			<p class="checkbox">
				<label>
					<input type="checkbox" id="group_restriction" name="group_restriction" value="1" <?php if (count($_smarty_tpl->tpl_vars['groups']->value['unselected'])) {?>checked="checked"<?php }?> />
					<?php echo smartyTranslate(array('s'=>'Customer group selection'),$_smarty_tpl);?>

				</label>
			</p>
			<div id="group_restriction_div">
				<br />
				<table class="table">
					<tr>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Unselected groups'),$_smarty_tpl);?>
</p>
							<select id="group_select_1" class="input-large" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value['unselected'], 'group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="group_select_add" class="btn btn-default btn-block clearfix" ><?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
 <i class="icon-arrow-right"></i></a>
						</td>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Selected groups'),$_smarty_tpl);?>
</p>
							<select name="group_select[]" class="input-large" id="group_select_2" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value['selected'], 'group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="group_select_remove" class="btn btn-default btn-block clearfix" ><i class="icon-arrow-left"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
</a>
						</td>
					</tr>
				</table>
			</div>
		<?php }?>

		<?php if (count($_smarty_tpl->tpl_vars['cart_rules']->value['unselected'])+count($_smarty_tpl->tpl_vars['cart_rules']->value['selected']) > 0) {?>
			<p class="checkbox">
				<label>
					<input type="checkbox" id="cart_rule_restriction" name="cart_rule_restriction" value="1" <?php if (count($_smarty_tpl->tpl_vars['cart_rules']->value['unselected'])) {?>checked="checked"<?php }?> />
					<?php echo smartyTranslate(array('s'=>'Compatibility with other cart rules'),$_smarty_tpl);?>

				</label>
			</p>
			<div id="cart_rule_restriction_div">
				<br />
				<table  class="table">
					<tr>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Uncombinable cart rules'),$_smarty_tpl);?>
</p>
							<input id="cart_rule_select_1_filter" autocomplete="off" class="form-control uncombinable_search_filter" type="text" name="uncombinable_filter" placeholder="<?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>
" value="">
							<select id="cart_rule_select_1" class="jscroll" multiple="">
							</select>
							<a class="jscroll-next btn btn-default btn-block clearfix" href=""><?php echo smartyTranslate(array('s'=>'Next'),$_smarty_tpl);?>
</a>
							<a id="cart_rule_select_add" class="btn btn-default btn-block clearfix"><?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
 <i class="icon-arrow-right"></i></a>
						</td>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Combinable cart rules'),$_smarty_tpl);?>
</p>
							<input id="cart_rule_select_2_filter" autocomplete="off" class="form-control combinable_search_filter" type="text" name="combinable_filter" placeholder="<?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>
" value="">
							<select name="cart_rule_select[]" class="jscroll" id="cart_rule_select_2" multiple>
							</select>
							<a class="jscroll-next btn btn-default btn-block clearfix" href=""><?php echo smartyTranslate(array('s'=>'Next'),$_smarty_tpl);?>
</a>
							<a id="cart_rule_select_remove" class="btn btn-default btn-block clearfix" ><i class="icon-arrow-left"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
</a>
						</td>
					</tr>
				</table>
			</div>
		<?php }?>

			<p class="checkbox">
				<label>
					<input type="checkbox" id="product_restriction" name="product_restriction" value="1" <?php if (count($_smarty_tpl->tpl_vars['product_rule_groups']->value)) {?>checked="checked"<?php }?> />
					<?php echo smartyTranslate(array('s'=>'Product selection'),$_smarty_tpl);?>

				</label>
			</p>
			<div id="product_restriction_div">
				<br />
				<table id="product_rule_group_table" class="table">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product_rule_groups']->value, 'product_rule_group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product_rule_group']->value) {
?>
						<?php echo $_smarty_tpl->tpl_vars['product_rule_group']->value;?>

					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</table>
				<a href="javascript:addProductRuleGroup();" class="btn btn-default ">
					<i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Product selection'),$_smarty_tpl);?>

				</a>
			</div>

		<?php if (count($_smarty_tpl->tpl_vars['shops']->value['unselected'])+count($_smarty_tpl->tpl_vars['shops']->value['selected']) > 1) {?>
			<p class="checkbox">
				<label>
					<input type="checkbox" id="shop_restriction" name="shop_restriction" value="1" <?php if (count($_smarty_tpl->tpl_vars['shops']->value['unselected'])) {?>checked="checked"<?php }?> />
					<?php echo smartyTranslate(array('s'=>'Shop selection'),$_smarty_tpl);?>

				</label>
			</p>
			<div id="shop_restriction_div">
				<br/>
				<table class="table">
					<tr>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Unselected shops'),$_smarty_tpl);?>
</p>
							<select id="shop_select_1" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shops']->value['unselected'], 'shop');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['shop']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['shop']->value['id_shop']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="shop_select_add" class="btn btn-default btn-block clearfix" ><?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
 <i class="icon-arrow-right"></i></a>
						</td>
						<td>
							<p><?php echo smartyTranslate(array('s'=>'Selected shops'),$_smarty_tpl);?>
</p>
							<select name="shop_select[]" id="shop_select_2" multiple>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shops']->value['selected'], 'shop');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['shop']->value) {
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['shop']->value['id_shop']);?>
">&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
							<a id="shop_select_remove" class="btn btn-default btn-block clearfix" ><i class="icon-arrow-left"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
</a>
						</td>
					</tr>
				</table>
			</div>
		<?php }?>
	</div>
</div>
<?php }
}
