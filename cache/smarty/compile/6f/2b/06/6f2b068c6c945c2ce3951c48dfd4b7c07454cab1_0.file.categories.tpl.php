<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:38:59
  from "/home/shoptech/public_html/beta/modules/HolidaySale/views/templates/admin/categories.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff4934cc693_91027822',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6f2b068c6c945c2ce3951c48dfd4b7c07454cab1' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/HolidaySale/views/templates/admin/categories.tpl',
      1 => 1574858635,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ff4934cc693_91027822 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="panel">
	<div class="panel-heading">
		<i class="icon-folder-close"></i>
		<?php echo smartyTranslate(array('s'=>'Holiday Sale Discounts','mod'=>'HolidaySale'),$_smarty_tpl);?>

	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<?php echo $_smarty_tpl->tpl_vars['categoryTree']->value;?>

			</div>

			<div class="col-xs-12 col-sm-3">
				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Suppliers','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<div style="max-width: 400px;">
						<?php echo $_smarty_tpl->tpl_vars['supplierTree']->value;?>

					</div>
				</div>

				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Manufacturers','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<div style="max-width: 400px;">
						<?php echo $_smarty_tpl->tpl_vars['manufacturerTree']->value;?>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<h3 style="margin: 0 0 10px;"><input type="checkbox" id="selectAllProducts" /> <?php echo smartyTranslate(array('s'=>'Choose All Products','mod'=>'HolidaySale'),$_smarty_tpl);?>
 <input type="text" id="productSearchFilter" /></h3>

				<div id="chooseProducts" class="scrollableOptions">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
?>
					<?php ob_start();
echo $_smarty_tpl->tpl_vars['product']->value['id'];
$_prefixVariable1=ob_get_clean();
if ($_prefixVariable1) {?>

						<?php if ($_smarty_tpl->tpl_vars['product']->value['default_on']) {?>
						<label class="productTree_item productTree_<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
 productTree_<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
-0">
							<input class="productTree_checkbox" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
-0" name="productTree[]" /> <?php echo $_smarty_tpl->tpl_vars['product']->value['product_name'];?>
 - <?php echo smartyTranslate(array('s'=>'All Combinations','mod'=>'HolidaySale'),$_smarty_tpl);?>

						</label>
						<?php }?>

						<label class="productTree_item productTree_<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
 productTree_<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
">
							<?php $_smarty_tpl->_assignInScope('product_price', Tools::displayPrice(Product::getPriceStatic($_smarty_tpl->tpl_vars['product']->value['id'],true,null,6,null,false,false)));
?>

							<div class="col-xs-8">
								<input class="productTree_checkbox" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
" name="productTree[]" /> <?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>

							</div>

							<div class="col-xs-2"><span><?php echo $_smarty_tpl->tpl_vars['product_price']->value;?>
</span></div>

							<a class="col-xs-2" data-id_product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
" href="#"><?php echo smartyTranslate(array('s'=>'Delete Discount','mod'=>'HolidaySale'),$_smarty_tpl);?>
</a>
						</label>
					<?php }?>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</div>
			</div>

			<div class="col-xs-12 col-sm-6">
				<h3 style="margin: 0 0 10px;"><?php echo smartyTranslate(array('s'=>'Selected Products','mod'=>'HolidaySale'),$_smarty_tpl);?>
</h3>

				<div id="selectedProducts" class="scrollableOptions">
					<div class="loading" style="display: none;"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Customer Groups','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<div style="max-width: 400px;">
						<?php echo $_smarty_tpl->tpl_vars['groupTree']->value;?>

					</div>
				</div>

				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Currencies','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<div style="max-width: 400px;">
						<?php echo $_smarty_tpl->tpl_vars['currencyTree']->value;?>

					</div>
				</div>

				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Holiday Page','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<select id="holiday_page" name="holiday_page">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'page');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['page']->value['id_holiday_sale'];?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
</option>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					</select>
				</div>

				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Type','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<select id="reduction_type" name="reduction_type">
						<option value="amount"><?php echo smartyTranslate(array('s'=>'Fixed Amount','mod'=>'HolidaySale'),$_smarty_tpl);?>
</option>
						<option value="price"><?php echo smartyTranslate(array('s'=>'Fixed Price','mod'=>'HolidaySale'),$_smarty_tpl);?>
</option>
						<option value="percentage">%</option>
					</select>
				</div>

				<div id="ActionRow">
					<p>&nbsp;</p>

					<button id="addDiscount" type="button" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'Add Discounts','mod'=>'HolidaySale'),$_smarty_tpl);?>
</button>
				</div>
			</div>

			<div class="col-xs-12 col-sm-3">
				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Countries','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<div style="max-width: 400px;">
						<?php echo $_smarty_tpl->tpl_vars['countryTree']->value;?>

					</div>
				</div>

				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'With Tax?','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<select id="with_tax" name="with_tax">
						<option value="1"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'HolidaySale'),$_smarty_tpl);?>
</option>
						<option value="0"><?php echo smartyTranslate(array('s'=>'No','mod'=>'HolidaySale'),$_smarty_tpl);?>
</option>
					</select>
				</div>

				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Starting From','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<input type="text" id="starting_amount" name="starting_amount" value="">
				</div>

				<div class="form-group">
					<p><?php echo smartyTranslate(array('s'=>'Amount','mod'=>'HolidaySale'),$_smarty_tpl);?>
</p>

					<input type="text" id="reduction_amount" name="reduction_amount" value="">
				</div>
			</div>
		</div>

	</div>
</div>

<div class="panel">
	<div class="panel-heading">
		<i class="icon-folder-close"></i>
		<?php echo smartyTranslate(array('s'=>'Clear Discounts','mod'=>'HolidaySale'),$_smarty_tpl);?>

	</div>

	<div class="panel-body">
		<div class="row">
			<div class="form-group col-lg-3">
				<select id="holiday_page2" name="holiday_page">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'page');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['page']->value['id_holiday_sale'];?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>

			<div class="form-group col-lg-3">
				<button id="clearDiscount" type="button" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'Delete Discounts','mod'=>'HolidaySale'),$_smarty_tpl);?>
</button>
			</div>
		</div>

	</div>
</div><?php }
}
