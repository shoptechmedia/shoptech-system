<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/modules/iqitcontentcreator/views/templates/hook/front_content_inner.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea7789318_87368245',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bbcb4d12bc1c9789e89ce33a5bc471dad8d0736f' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/iqitcontentcreator/views/templates/hook/front_content_inner.tpl',
      1 => 1507620557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea19ea7789318_87368245 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '16383757615ea19ea76d1097_38582395';
?>


	
			<?php if ($_smarty_tpl->tpl_vars['node']->value['type'] == 2) {?>

				<?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['title'])) {?>
					<?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['href'])) {?>
					<div class="title_block"><a class="title_block_txt" href="<?php echo $_smarty_tpl->tpl_vars['node']->value['content_s']['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['node']->value['content_s']['title'];?>
 <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['legend'])) {?><span class="label legend iqit-legend-inner"><?php echo $_smarty_tpl->tpl_vars['node']->value['content_s']['legend'];?>
<span class="legend-arrow"></span></span><?php }?></a></div>
					<?php } else { ?>
					<div class="title_block"><span class="title_block_txt"><?php echo $_smarty_tpl->tpl_vars['node']->value['content_s']['title'];?>
 <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['legend'])) {?><span class="label legend iqit-legend-inner"><?php echo $_smarty_tpl->tpl_vars['node']->value['content_s']['legend'];?>
<span class="legend-arrow"></span></span><?php }?></span></div>

					<?php }?>
				<?php }?>

				

				<?php if ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 1) {?>
				
					<?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['ids']) && $_smarty_tpl->tpl_vars['node']->value['content']['ids']) {?>
						<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['ids'];?>

					<?php }?>

				<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 2) {?>
				
					<?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['products'])) {?>
					
					
						<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view'] == 0) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'generatorGrid'=>"col-xs-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'])." col-ms-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'])." col-sm-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'])." col-md-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_md'])." col-lg-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_lg'])), 0, true);
?>

						<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['content']['view'] == 1) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-slider.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'ar'=>$_smarty_tpl->tpl_vars['node']->value['content']['ar'],'ap'=>$_smarty_tpl->tpl_vars['node']->value['content']['ap'],'dt'=>$_smarty_tpl->tpl_vars['node']->value['content']['dt'],'colnb'=>$_smarty_tpl->tpl_vars['node']->value['content']['colnb'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'iqitGenerator'=>1,'line_xs'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'],'line_ms'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'],'line_sm'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'],'line_md'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_md'],'line_lg'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_lg']), 0, true);
?>

						<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['content']['view'] == 2) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list-small.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'generatorGrid'=>"col-xs-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'])." col-ms-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'])." col-sm-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'])." col-md-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_md'])." col-lg-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_lg'])), 0, true);
?>

						<?php } else { ?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list-small.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'ar'=>$_smarty_tpl->tpl_vars['node']->value['content']['ar'],'ap'=>$_smarty_tpl->tpl_vars['node']->value['content']['ap'],'dt'=>$_smarty_tpl->tpl_vars['node']->value['content']['dt'],'colnb'=>$_smarty_tpl->tpl_vars['node']->value['content']['colnb'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'iqitGenerator'=>1,'line_xs'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'],'line_ms'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'],'line_sm'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'],'line_md'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_md'],'line_lg'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_lg']), 0, true);
?>

						<?php }?>
						
		
					<?php }?>

				<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 4) {?>

						<?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['ids'])) {?>
						<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view'] == 0) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'generatorGrid'=>"col-xs-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'])." col-ms-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'])." col-sm-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'])." col-md-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_md'])." col-lg-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_lg'])), 0, true);
?>

						<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['content']['view'] == 1) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-slider.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'ar'=>$_smarty_tpl->tpl_vars['node']->value['content']['ar'],'ap'=>$_smarty_tpl->tpl_vars['node']->value['content']['ap'],'dt'=>$_smarty_tpl->tpl_vars['node']->value['content']['dt'],'colnb'=>$_smarty_tpl->tpl_vars['node']->value['content']['colnb'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'iqitGenerator'=>1,'line_xs'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'],'line_ms'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'],'line_sm'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'],'line_md'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_md'],'line_lg'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_lg']), 0, true);
?>

						<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['content']['view'] == 2) {?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list-small.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'generatorGrid'=>"col-xs-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'])." col-ms-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'])." col-sm-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'])." col-md-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_md'])." col-lg-".((string)$_smarty_tpl->tpl_vars['node']->value['content']['line_lg'])), 0, true);
?>

						<?php } else { ?>
							<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list-small.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('image_types'=>$_smarty_tpl->tpl_vars['images_types']->value,'image_type'=>$_smarty_tpl->tpl_vars['node']->value['content']['itype'],'productimg'=>$_smarty_tpl->tpl_vars['node']->value['content']['productsimg'],'ar'=>$_smarty_tpl->tpl_vars['node']->value['content']['ar'],'ap'=>$_smarty_tpl->tpl_vars['node']->value['content']['ap'],'dt'=>$_smarty_tpl->tpl_vars['node']->value['content']['dt'],'colnb'=>$_smarty_tpl->tpl_vars['node']->value['content']['colnb'],'products'=>$_smarty_tpl->tpl_vars['node']->value['content']['products'],'iqitGenerator'=>1,'line_xs'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_xs'],'line_ms'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_ms'],'line_sm'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_sm'],'line_md'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_md'],'line_lg'=>$_smarty_tpl->tpl_vars['node']->value['content']['line_lg']), 0, true);
?>

						<?php }?>
					<?php }?>

				<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 5) {?>
					

					<ul class="manufacturers row">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['node']->value['content']['ids'], 'manufacturer');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->value) {
?>
							<?php ob_start();
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('myfile', "img/m/".$_prefixVariable1."-mf_image.jpg");
?>
							<?php if (file_exists($_smarty_tpl->tpl_vars['myfile']->value)) {?>
								<li class="transition-opacity-300">
									<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['manufacturer']->value);?>
">
										<img src="<?php echo $_smarty_tpl->tpl_vars['img_manu_dir']->value;
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
-mf_image.jpg" class="img-responsive logo_manufacturer " <?php if (isset($_smarty_tpl->tpl_vars['manufacturerSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['manufacturerSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['manufacturerSize']->value['height'];?>
"<?php }?> alt="Manufacturer - <?php echo $_smarty_tpl->tpl_vars['manufacturer']->value;?>
" />
									</a>
							</li>
							<?php }?>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					</ul>	

				<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 6) {?>

					<?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['source'])) {?>
			
						<a <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['href'])) {?>href="<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['href'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['window']) && $_smarty_tpl->tpl_vars['node']->value['content']['window'] == 1) {?>target="_blank"<?php }?> <?php }?>
					style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['source'];?>
')" class="iqit-banner-image">
						
							<img src="<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['source'];?>
" class="img-responsive banner-image" alt=" " />
					
						</a>
					<?php }?>

				<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 7) {?>
				<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {?><div class="iqitcarousel-wrapper"><?php }?>
				
					<div class="manufacturers row <?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {?>slick_carousel_style iqitcarousel<?php }?>"  <?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {?>data-slick='{<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['dt']) {?>"dots": true, <?php }
if ($_smarty_tpl->tpl_vars['node']->value['content']['ap']) {?>"autoplay": true, <?php }?>"slidesToShow": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_lg'];?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_lg'];?>
, "responsive": [ 
					{ "breakpoint": 1320, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_md'];?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_md'];?>
}}, { "breakpoint": 1000, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_sm'];?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_sm'];?>
}}, { "breakpoint": 768, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_ms'];?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_ms'];?>
}}, { "breakpoint": 480, "settings": { "slidesToShow": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_xs'];?>
, "slidesToScroll": <?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_xs'];?>
}} ]}'<?php }?>>
					<?php $_smarty_tpl->_assignInScope('iterator', 1);
?>

					
					<?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['manu'])) {?>
					

					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['node']->value['content']['manu'], 'manufacturer', false, NULL, 'manufacturerSlider', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['total'];
?>
				
								<?php ob_start();
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('myfile', "img/m/".$_prefixVariable2."-mf_image.jpg");
?>
									<?php if (file_exists($_smarty_tpl->tpl_vars['myfile']->value)) {?>
									<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {
if ($_smarty_tpl->tpl_vars['iterator']->value == 1 || ((($_smarty_tpl->tpl_vars['iterator']->value+1)%$_smarty_tpl->tpl_vars['node']->value['content']['colnb'] == 0))) {?><div class="iqitcarousel-man slick-slide"><?php }
}?>
										<div <?php if (!$_smarty_tpl->tpl_vars['node']->value['content']['view']) {?>class="iqitmanufacuter-logo col-xs-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_xs'];?>
 col-ms-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_ms'];?>
 col-sm-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_sm'];?>
 col-md-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_md'];?>
 col-lg-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_lg'];?>
"<?php } else { ?>class="iqitmanufacuter-logo"<?php }?>>
											<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer']);?>
">
												<img src="<?php echo $_smarty_tpl->tpl_vars['img_manu_dir']->value;
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
-mf_image.jpg" class="img-responsive logo_manufacturer transition-300" <?php if (isset($_smarty_tpl->tpl_vars['manufacturerSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['manufacturerSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['manufacturerSize']->value['height'];?>
"<?php }?> alt="Manufacturer - <?php echo $_smarty_tpl->tpl_vars['manufacturer']->value['name'];?>
" />
											</a>
										</div>
							<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {?>
									<?php if (($_smarty_tpl->tpl_vars['iterator']->value%$_smarty_tpl->tpl_vars['node']->value['content']['colnb'] == 0) && !(isset($_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last'] : null)) {?></div><?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last'] : null)) {?></div><?php }?>
							<?php }?>
							<?php $_smarty_tpl->_assignInScope('iterator', $_smarty_tpl->tpl_vars['iterator']->value+1);
?>
							
							<?php }?>
							
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>



					<?php } else { ?>

							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['node']->value['content']['ids'], 'manufacturer', false, NULL, 'manufacturerSlider', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['total'];
?>
								<?php ob_start();
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
$_prefixVariable3=ob_get_clean();
$_smarty_tpl->_assignInScope('myfile', "img/m/".$_prefixVariable3."-mf_image.jpg");
?>
								
									<?php if (file_exists($_smarty_tpl->tpl_vars['myfile']->value)) {?>
										<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {?>
											<?php if ($_smarty_tpl->tpl_vars['iterator']->value == 1 || ((($_smarty_tpl->tpl_vars['iterator']->value+1)%$_smarty_tpl->tpl_vars['node']->value['content']['colnb'] == 0))) {?><div class="iqitcarousel-man slick-slide"><?php }?>
										<?php }?>

										<div <?php if (!$_smarty_tpl->tpl_vars['node']->value['content']['view']) {?>class="iqitmanufacuter-logo col-xs-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_xs'];?>
 col-ms-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_ms'];?>
 col-sm-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_sm'];?>
 col-md-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_md'];?>
 col-lg-<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['line_lg'];?>
"<?php } else { ?>class="iqitmanufacuter-logo"<?php }?>>
											<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['manufacturer']->value);?>
">
												<img src="<?php echo $_smarty_tpl->tpl_vars['img_manu_dir']->value;
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
-mf_image.jpg" class="img-responsive logo_manufacturer transition-300" <?php if (isset($_smarty_tpl->tpl_vars['manufacturerSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['manufacturerSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['manufacturerSize']->value['height'];?>
"<?php }?> alt="Manufacturer - <?php echo $_smarty_tpl->tpl_vars['manufacturer']->value;?>
" />
											</a>
										</div>
							
							<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {?>
									<?php if (($_smarty_tpl->tpl_vars['iterator']->value%$_smarty_tpl->tpl_vars['node']->value['content']['colnb'] == 0) && !(isset($_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last'] : null)) {?></div><?php }?>
									
							<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_manufacturerSlider']->value['last'] : null)) {?></div><?php }?>
							<?php }?>
							<?php $_smarty_tpl->_assignInScope('iterator', $_smarty_tpl->tpl_vars['iterator']->value+1);
?>
							
							
							<?php }?>


							
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					<?php }?>
			
					</div><!--  .manufacturers row  -->
				<?php if ($_smarty_tpl->tpl_vars['node']->value['content']['view']) {?></div><!--  .iqitcarousel-wrapper --><?php }?>


				<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 8) {?>
					<?php echo smartyHook(array('h'=>$_smarty_tpl->tpl_vars['node']->value['content']['hook']),$_smarty_tpl);?>

				<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 9) {?>	
					<?php echo $_smarty_tpl->tpl_vars['node']->value['content']['module'];?>
 
				<?php }?>



			<?php }
}
}
