<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/themes/shoptech/product-slider.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea78a3229_39621049',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfd6e43b7bfb45fd2fae0b29cc1a224a9ceac413' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/product-slider.tpl',
      1 => 1585125217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea19ea78a3229_39621049 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '9227880045ea19ea779aeb5_77948868';
?>
	<?php if (isset($_smarty_tpl->tpl_vars['products']->value) && $_smarty_tpl->tpl_vars['products']->value) {?>
	<div class="block_content">
		<?php $_smarty_tpl->_assignInScope('nbItemsPerLine', 4);
?>
		<?php $_smarty_tpl->_assignInScope('nbLi', count($_smarty_tpl->tpl_vars['products']->value));
?>

		<?php if (isset($_smarty_tpl->tpl_vars['image_type']->value) && isset($_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value])) {?>  
			<?php $_smarty_tpl->_assignInScope('imageSize', $_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value]['name']);
?>
		<?php } else { ?>
			<?php $_smarty_tpl->_assignInScope('imageSize', 'home_default');
?> 
		<?php }?>

		<div <?php if (isset($_smarty_tpl->tpl_vars['id']->value) && $_smarty_tpl->tpl_vars['id']->value) {?> id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"<?php }?> <?php if (!isset($_smarty_tpl->tpl_vars['ar']->value)) {?> <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['carousel_style']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['carousel_style'] == 0) {?> class="alternative-slick-arrows" <?php }
}?> >
			<div class="slick_carousel <?php if (isset($_smarty_tpl->tpl_vars['iqitGenerator']->value)) {?>iqitcarousel<?php } else { ?>slick_carousel_defaultp<?php }?> slick_carousel_style " <?php if (isset($_smarty_tpl->tpl_vars['iqitGenerator']->value)) {?>data-slick='{<?php if ($_smarty_tpl->tpl_vars['dt']->value) {?>"dots": true, <?php }
if ($_smarty_tpl->tpl_vars['ap']->value) {?>"autoplay": true, <?php }?>"slidesToShow": <?php echo $_smarty_tpl->tpl_vars['line_lg']->value;?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['line_lg']->value;?>
, "responsive": [ 
					{ "breakpoint": 1320, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['line_md']->value;?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['line_md']->value;?>
}}, { "breakpoint": 1000, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['line_sm']->value;?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['line_sm']->value;?>
}}, { "breakpoint": 768, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['line_ms']->value;?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['line_ms']->value;?>
}}, { "breakpoint": 480, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['line_xs']->value;?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['line_xs']->value;?>
}} ]}'<?php }?> >
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product', false, NULL, 'homeFeaturedProducts', array (
  'first' => true,
  'last' => true,
  'iteration' => true,
  'total' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['total'];
?>
				<?php if (isset($_smarty_tpl->tpl_vars['colnb']->value)) {
if (((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['first'] : null))) {?><div class="iqitcarousel-product"><?php }
}?>
				<div class="ajax_block_product <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['first'] : null)) {?>first_item<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['last'] : null)) {?>last_item<?php } else { ?>item<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration'] : null)%$_smarty_tpl->tpl_vars['nbItemsPerLine']->value == 0) {?>last_item_of_line<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration'] : null)%$_smarty_tpl->tpl_vars['nbItemsPerLine']->value == 1) {?> <?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration'] : null) > ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['total']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['total'] : null)-((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['total']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['total'] : null)%$_smarty_tpl->tpl_vars['nbItemsPerLine']->value))) {?>last_line<?php }?>">
					<div class="product-container">
						
						<div class="product-image-container">
						<?php if ((isset($_smarty_tpl->tpl_vars['product']->value['quantity']) && $_smarty_tpl->tpl_vars['product']->value['quantity'] > 0) || (isset($_smarty_tpl->tpl_vars['product']->value['quantity_all_versions']) && $_smarty_tpl->tpl_vars['product']->value['quantity_all_versions'] > 0)) {?>
							<?php echo smartyHook(array('h'=>'displayProductAttributesPL','productid'=>$_smarty_tpl->tpl_vars['product']->value['id_product']),$_smarty_tpl);?>

						<?php }?>
						<a class="product_img_link"	href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" >
							<?php if (!isset($_smarty_tpl->tpl_vars['crosseling']->value)) {?>
								<?php $_smarty_tpl->_assignInScope('rolloverImage', ThemeEditor::getRolloverImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['imageSize']->value));
?> 
							<?php }?>
							<img class="replace-2x img-responsive lazy img_0 img_1e" 
							 
							<?php if ((isset($_smarty_tpl->tpl_vars['iqit_lazy_load']->value) && $_smarty_tpl->tpl_vars['iqit_lazy_load']->value == 1) || (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['iqit_lazy_load']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['iqit_lazy_load'] == 1)) {?>
							data-lazy="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],$_smarty_tpl->tpl_vars['imageSize']->value), ENT_QUOTES, 'UTF-8', true);?>
" 
							src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
blank.gif" 
							<?php } else { ?>
							src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],$_smarty_tpl->tpl_vars['imageSize']->value), ENT_QUOTES, 'UTF-8', true);?>
" 
							<?php }?>

							alt="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);
}?>" 

							<?php if (isset($_smarty_tpl->tpl_vars['image_type']->value) && isset($_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value])) {?>  width="<?php echo $_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value]['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value]['height'];?>
" <?php } elseif (isset($_smarty_tpl->tpl_vars['image_types']->value['home_default'])) {?> width="<?php echo $_smarty_tpl->tpl_vars['image_types']->value['home_default']['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['image_types']->value['home_default']['height'];?>
" <?php }
if (isset($_smarty_tpl->tpl_vars['homeSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['height'];?>
"<?php }?>  />

							<?php if (isset($_smarty_tpl->tpl_vars['rolloverImage']->value)) {?>

							<img class="replace-2x img-responsive lazy img_1 img-rollover" 
							data-rollover="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['rolloverImage']->value, ENT_QUOTES, 'UTF-8', true);?>
" 
							src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
blank.gif" 
							alt="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);
}?>" 

							<?php if (isset($_smarty_tpl->tpl_vars['image_type']->value) && isset($_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value])) {?>  width="<?php echo $_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value]['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['image_types']->value[$_smarty_tpl->tpl_vars['image_type']->value]['height'];?>
" <?php } elseif (isset($_smarty_tpl->tpl_vars['image_types']->value['home_default'])) {?> width="<?php echo $_smarty_tpl->tpl_vars['image_types']->value['home_default']['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['image_types']->value['home_default']['height'];?>
" <?php }
if (isset($_smarty_tpl->tpl_vars['homeSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['height'];?>
"<?php }?>  />
							<?php }?>


							<?php echo smartyHook(array('h'=>'displayCountDown','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);?>

						</a>
						<div class="product-flags">
						<?php if ((!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value && ((isset($_smarty_tpl->tpl_vars['product']->value['show_price']) && $_smarty_tpl->tpl_vars['product']->value['show_price']) || (isset($_smarty_tpl->tpl_vars['product']->value['available_for_order']) && $_smarty_tpl->tpl_vars['product']->value['available_for_order'])))) {?>
							<?php if (isset($_smarty_tpl->tpl_vars['product']->value['online_only']) && $_smarty_tpl->tpl_vars['product']->value['online_only']) {?>
								<span class="online-label <?php if (isset($_smarty_tpl->tpl_vars['product']->value['new']) && $_smarty_tpl->tpl_vars['product']->value['new'] == 1) {?>online-label2<?php }?>"><?php echo smartyTranslate(array('s'=>'Online only'),$_smarty_tpl);?>
</span>
							<?php }?>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['product']->value['on_sale']) && $_smarty_tpl->tpl_vars['product']->value['on_sale'] && isset($_smarty_tpl->tpl_vars['product']->value['show_price']) && $_smarty_tpl->tpl_vars['product']->value['show_price'] && !$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
							<?php } elseif (isset($_smarty_tpl->tpl_vars['product']->value['reduction']) && $_smarty_tpl->tpl_vars['product']->value['reduction'] && isset($_smarty_tpl->tpl_vars['product']->value['show_price']) && $_smarty_tpl->tpl_vars['product']->value['show_price'] && !$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
									<?php if ($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction_type'] == 'percentage') {?>
									<span class="sale-label">-<?php echo $_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']*100;?>
%</span>
								<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction_type'] == 'amount') {?>
									<span class="sale-label">-<?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {
echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['product']->value['price_without_reduction'])-floatval($_smarty_tpl->tpl_vars['product']->value['price'])),$_smarty_tpl);
} else {
echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['product']->value['price_without_reduction'])-floatval($_smarty_tpl->tpl_vars['product']->value['price_tax_exc'])),$_smarty_tpl);
}?></span>
								<?php }?>
							<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['product']->value['new']) && $_smarty_tpl->tpl_vars['product']->value['new'] == 1) {?>
								<span class="new-label"><?php echo smartyTranslate(array('s'=>'New'),$_smarty_tpl);?>
</span>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['product']->value['on_sale']) && $_smarty_tpl->tpl_vars['product']->value['on_sale'] && isset($_smarty_tpl->tpl_vars['product']->value['show_price']) && $_smarty_tpl->tpl_vars['product']->value['show_price'] && !$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
								<span class="sale-label"><?php echo smartyTranslate(array('s'=>'Sale!'),$_smarty_tpl);?>
</span>
						<?php }?>
					</div>
					<div class="functional-buttons functional-buttons-grid clearfix">
						<?php if (isset($_smarty_tpl->tpl_vars['quick_view']->value) && $_smarty_tpl->tpl_vars['quick_view']->value) {?>
						<div class="quickview col-xs-6">
							<a class="quick-view" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Quick view'),$_smarty_tpl);?>
">
								<?php echo smartyTranslate(array('s'=>'Quick view'),$_smarty_tpl);?>

							</a>
							</div>
						<?php }?>
						<?php echo smartyHook(array('h'=>'displayProductListFunctionalButtons','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);?>

						<?php if (isset($_smarty_tpl->tpl_vars['comparator_max_item']->value) && $_smarty_tpl->tpl_vars['comparator_max_item']->value) {?>
							<div class="compare col-xs-3">
								<a class="add_to_compare" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" title="<?php echo smartyTranslate(array('s'=>'Add to Compare'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Add to Compare'),$_smarty_tpl);?>
</a>
							</div>
						<?php }?>	
					</div>
			
					<?php if ((!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value && $_smarty_tpl->tpl_vars['PS_STOCK_MANAGEMENT']->value && ((isset($_smarty_tpl->tpl_vars['product']->value['show_price']) && $_smarty_tpl->tpl_vars['product']->value['show_price']) || (isset($_smarty_tpl->tpl_vars['product']->value['available_for_order']) && $_smarty_tpl->tpl_vars['product']->value['available_for_order'])))) {?>
						<?php if (isset($_smarty_tpl->tpl_vars['product']->value['available_for_order']) && $_smarty_tpl->tpl_vars['product']->value['available_for_order'] && !isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)) {?>
							<span class="availability availability-slidein <?php if ((isset($_smarty_tpl->tpl_vars['product']->value['quantity_all_versions']) && $_smarty_tpl->tpl_vars['product']->value['quantity_all_versions'] > 0)) {?>available-diff <?php }?>">
								<?php if ($_smarty_tpl->tpl_vars['product']->value['quantity'] <= 0) {?>
									<?php if ($_smarty_tpl->tpl_vars['PS_STOCK_MANAGEMENT']->value && $_smarty_tpl->tpl_vars['product']->value['allow_oosp']) {?>
										<?php if ($_smarty_tpl->tpl_vars['product']->value['available_later'] != '') {?><span class="out-of-stock"><?php echo $_smarty_tpl->tpl_vars['product']->value['available_later'];?>
</span><?php } else { ?><span class="availabile_product"><?php echo smartyTranslate(array('s'=>'Available'),$_smarty_tpl);?>
</span><?php }?>
									<?php } else { ?>
										<?php if ((isset($_smarty_tpl->tpl_vars['product']->value['quantity_all_versions']) && $_smarty_tpl->tpl_vars['product']->value['quantity_all_versions'] > 0)) {?>
											<span class="available-dif"><?php echo smartyTranslate(array('s'=>'Product available with different options'),$_smarty_tpl);?>
</span>
										<?php } else { ?>
											<span class="out-of-stock"><?php echo smartyTranslate(array('s'=>'Out of stock'),$_smarty_tpl);?>
</span>
										<?php }?>
									<?php }?>
								<?php } elseif ($_smarty_tpl->tpl_vars['PS_STOCK_MANAGEMENT']->value) {?>
									<span class="availabile_product"><?php if (isset($_smarty_tpl->tpl_vars['product']->value['available_now']) && $_smarty_tpl->tpl_vars['product']->value['available_now'] != '') {
echo $_smarty_tpl->tpl_vars['product']->value['available_now'];
} else {
echo smartyTranslate(array('s'=>'Available'),$_smarty_tpl);
}?></span>
								<?php }?>
							</span>
						<?php }?>
					<?php }?>
		
								<?php if (isset($_smarty_tpl->tpl_vars['product']->value['color_list'])) {?>
						<div class="color-list-container"><?php echo $_smarty_tpl->tpl_vars['product']->value['color_list'];?>
 </div>
					<?php }?>
					</div><!-- .product-image-container> -->
					<?php if (isset($_smarty_tpl->tpl_vars['product']->value['is_virtual']) && !$_smarty_tpl->tpl_vars['product']->value['is_virtual']) {
echo smartyHook(array('h'=>"displayProductDeliveryTime",'product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);
}?>
					<?php echo smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"weight"),$_smarty_tpl);?>

					<h5  class="product-name-container">
						<?php if (isset($_smarty_tpl->tpl_vars['product']->value['pack_quantity']) && $_smarty_tpl->tpl_vars['product']->value['pack_quantity']) {
echo (intval($_smarty_tpl->tpl_vars['product']->value['pack_quantity'])).(' x ');
}?>
					<a class="product-name" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" >
							<?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['name'],60,'...'), ENT_QUOTES, 'UTF-8', true);?>

						</a>
					</h5>
					<?php if (isset($_smarty_tpl->tpl_vars['product']->value['reference'])) {?><span class="product-reference"><?php echo $_smarty_tpl->tpl_vars['product']->value['reference'];?>
</span><?php }?>
						<?php if ((!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value && ((isset($_smarty_tpl->tpl_vars['product']->value['show_price']) && $_smarty_tpl->tpl_vars['product']->value['show_price']) || (isset($_smarty_tpl->tpl_vars['product']->value['available_for_order']) && $_smarty_tpl->tpl_vars['product']->value['available_for_order'])))) {?>
					<div class="content_price">
						<?php if (isset($_smarty_tpl->tpl_vars['product']->value['show_price']) && $_smarty_tpl->tpl_vars['product']->value['show_price'] && !isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)) {?>
							<span  class="price product-price">
								<?php echo smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"before_price"),$_smarty_tpl);?>

								<?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {
echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);
} else {
echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_tax_exc']),$_smarty_tpl);
}?>
							</span>
							
							<?php if (isset($_smarty_tpl->tpl_vars['product']->value['specific_prices']) && $_smarty_tpl->tpl_vars['product']->value['specific_prices'] && isset($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']) && $_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction'] > 0) {?>
								<?php echo smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"old_price"),$_smarty_tpl);?>

								<span class="old-price product-price">
									<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>$_smarty_tpl->tpl_vars['product']->value['price_without_reduction']),$_smarty_tpl);?>

								</span>
							<?php }?>
									<?php echo smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"price"),$_smarty_tpl);?>

									<?php echo smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"unit_price"),$_smarty_tpl);?>

									
						<?php }?>
					</div>
					<?php } elseif ($_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
					<?php } else { ?><div class="content_price">&nbsp;</div>
					<?php }?>
					<?php echo smartyHook(array('h'=>'displayProductListReviews','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);?>


					<?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['yotpo_stars']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['yotpo_stars'] == 1) {?>
					<div class="yotpo bottomLine" 
					data-appkey="<?php echo $_smarty_tpl->tpl_vars['yotpoAppkey']->value;?>
"
					data-domain="<?php echo $_smarty_tpl->tpl_vars['yotpoDomain']->value;?>
"
					data-product-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
"
					data-product-models=""
					data-name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" 
					data-url="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" 
					data-image-url="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'');?>
" 
					data-bread-crumbs="">
				</div> 
				<?php }?>
				
					<?php if (isset($_smarty_tpl->tpl_vars['product']->value['available_for_order']) && isset($_smarty_tpl->tpl_vars['product']->value['allow_oosp'])) {?>
					<div class="button-container">
						<?php if (($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'] == 0 || (isset($_smarty_tpl->tpl_vars['add_prod_display']->value) && ($_smarty_tpl->tpl_vars['add_prod_display']->value == 1))) && $_smarty_tpl->tpl_vars['product']->value['available_for_order'] && !isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value) && $_smarty_tpl->tpl_vars['product']->value['customizable'] != 2 && !$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
							<?php if ((!isset($_smarty_tpl->tpl_vars['product']->value['customization_required']) || !$_smarty_tpl->tpl_vars['product']->value['customization_required']) && ($_smarty_tpl->tpl_vars['product']->value['allow_oosp'] || $_smarty_tpl->tpl_vars['product']->value['quantity'] > 0)) {?>
								<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, null);?>add=1&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);
if (isset($_smarty_tpl->tpl_vars['static_token']->value)) {?>&amp;token=<?php echo $_smarty_tpl->tpl_vars['static_token']->value;
}
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
								<div class="pl-quantity-input-wrapper">
									<input type="text" name="qty" class="form-control qtyfield quantity_to_cart_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
"  value="<?php if (isset($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']) && $_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity'] > 1) {
echo intval($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']);
} else {
if (isset($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'])) {
echo intval($_smarty_tpl->tpl_vars['product']->value['minimal_quantity']);
} else { ?>1<?php }
}?>"/>
									<div class="quantity-input-b-wrapper">
										<a href="#" data-field-qty="quantity_to_cart_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" class="transition-300 pl_product_quantity_down">
											<span><i class="icon-caret-down"></i></span>
										</a>
										<a href="#" data-field-qty="quantity_to_cart_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" class="transition-300 pl_product_quantity_up ">
											<span><i class="icon-caret-up"></i></span>
										</a>
									</div>
								</div>
								<a class="button ajax_add_to_cart_button btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,NULL,$_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'default'),false), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
" data-id-product-attribute="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" data-minimal_quantity="<?php if (isset($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']) && $_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity'] >= 1) {
echo intval($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']);
} else {
if (isset($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'])) {
echo intval($_smarty_tpl->tpl_vars['product']->value['minimal_quantity']);
} else { ?>1<?php }
}?>">
									<span><?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
</span>
								</a>
							<?php } else { ?>
								<a  class="button lnk_view btn" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View'),$_smarty_tpl);?>
">
							<span><?php if ((isset($_smarty_tpl->tpl_vars['product']->value['customization_required']) && $_smarty_tpl->tpl_vars['product']->value['customization_required'])) {
echo smartyTranslate(array('s'=>'Customize'),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);
}?></span>
						</a>
							<?php }?>
							<?php } else { ?>
								<a class="button lnk_view btn" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View'),$_smarty_tpl);?>
">
							<span><?php if ((isset($_smarty_tpl->tpl_vars['product']->value['customization_required']) && $_smarty_tpl->tpl_vars['product']->value['customization_required'])) {
echo smartyTranslate(array('s'=>'Customize'),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);
}?></span>
						</a>
						<?php }?>
						<?php echo smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'after_price'),$_smarty_tpl);?>

					</div>
					<?php }?>
					
					</div><!-- .product-container> -->


					</div>
					<?php if (isset($_smarty_tpl->tpl_vars['colnb']->value)) {?>
					<?php if (((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['iteration'] : null)%$_smarty_tpl->tpl_vars['colnb']->value == 0) && !(isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['last'] : null)) {?></div><div class="iqitcarousel-product"><?php }?>
					<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homeFeaturedProducts']->value['last'] : null)) {?></div><?php }
}?>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</div>
			</div>
		</div>

<?php }
}
}
