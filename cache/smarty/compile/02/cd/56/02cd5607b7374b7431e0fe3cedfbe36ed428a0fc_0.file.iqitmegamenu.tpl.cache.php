<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/themes/shoptech/modules/iqitmegamenu/iqitmegamenu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf5d05779_16789113',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '02cd5607b7374b7431e0fe3cedfbe36ed428a0fc' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/modules/iqitmegamenu/iqitmegamenu.tpl',
      1 => 1507620557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./iqitmegamenu_vertical.tpl' => 2,
    'file:./front_submenu_content.tpl' => 2,
  ),
),false)) {
function content_5e9ebcf5d05779_16789113 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '4281083005e9ebcf5cbf160_44426055';
?>


<div  class="iqitmegamenu-wrapper col-xs-12 cbp-hor-width-<?php echo $_smarty_tpl->tpl_vars['menu_settings']->value['hor_width'];?>
  clearfix">
	<div id="iqitmegamenu-horizontal<?php if (isset($_smarty_tpl->tpl_vars['menu_settings_v']->value) && ($_smarty_tpl->tpl_vars['menu_settings_v']->value['ver_position'] == 6)) {?>-sidebar<?php }?>" class="iqitmegamenu <?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_s_transparent'] && $_smarty_tpl->tpl_vars['menu_settings']->value['hor_sticky']) {?> cbp-sticky-transparent<?php }?>" role="navigation">
		<div class="container">
			
			<?php if (isset($_smarty_tpl->tpl_vars['menu_settings_v']->value) && ($_smarty_tpl->tpl_vars['menu_settings_v']->value['ver_position'] == 2 || $_smarty_tpl->tpl_vars['menu_settings_v']->value['ver_position'] == 3)) {?>

				<div class="cbp-vertical-on-top <?php if ($_smarty_tpl->tpl_vars['menu_settings_v']->value['ver_position'] == 2) {?>cbp-homepage-expanded<?php }?>">
					<?php $_smarty_tpl->_subTemplateRender("file:./iqitmegamenu_vertical.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('ontop'=>1), 0, false);
?>
  
				</div>
			<?php }?>

			<?php if (isset($_smarty_tpl->tpl_vars['menu_settings_v']->value) && ($_smarty_tpl->tpl_vars['menu_settings_v']->value['ver_position'] == 6)) {?>
				<?php $_smarty_tpl->_subTemplateRender("file:./iqitmegamenu_vertical.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('notitle'=>1), 0, true);
?>
 
				<?php echo smartyHook(array('h'=>'displayAfterIqitMegamenu'),$_smarty_tpl);?>

			<?php } else { ?>

			<?php echo smartyHook(array('h'=>'displayAfterIqitMegamenu'),$_smarty_tpl);?>


			<?php echo '<script'; ?>
>
				var iqitsubmenucontent={};
				var iqitsubmenucontent_length=0;
			<?php echo '</script'; ?>
>

			<nav id="cbp-hrmenu" class="cbp-hrmenu cbp-horizontal <?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_width'] || $_smarty_tpl->tpl_vars['menu_settings']->value['hor_sw_width']) {?>cbp-hrsub-narrow<?php }?> <?php if (!$_smarty_tpl->tpl_vars['menu_settings']->value['hor_sw_width']) {?>cbp-hrsub-wide<?php }?> <?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_animation'] == 1) {?>cbp-fade<?php }?> <?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_animation'] == 2) {?>cbp-fade-slide-bottom<?php }?> <?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_animation'] == 3) {?>cbp-fade-slide-top<?php }?> <?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_s_arrow']) {?>cbp-arrowed<?php }?> <?php if (!$_smarty_tpl->tpl_vars['menu_settings']->value['hor_arrow']) {?> cbp-submenu-notarrowed<?php }?> <?php if (!$_smarty_tpl->tpl_vars['menu_settings']->value['hor_arrow']) {?> cbp-submenu-notarrowed<?php }?> <?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_center']) {?> cbp-menu-centered<?php }?> ">
				<ul>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['horizontal_menu']->value, 'tab');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->value) {
?>
					<li class="cbp-hrmenu-tab cbp-hrmenu-tab-<?php echo $_smarty_tpl->tpl_vars['tab']->value['id_tab'];?>
 <?php if ($_smarty_tpl->tpl_vars['tab']->value['active_label']) {?> cbp-onlyicon<?php }
if ($_smarty_tpl->tpl_vars['tab']->value['float']) {?> pull-right cbp-pulled-right<?php }?>">
<?php if ($_smarty_tpl->tpl_vars['tab']->value['url_type'] == 2) {?><a role="button" class="cbp-empty-mlink"><?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['tab']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['tab']->value['new_window']) {?>target="_blank"<?php }?>><?php }?>
							<span class="cbp-tab-title"><?php if ($_smarty_tpl->tpl_vars['tab']->value['icon_type'] && !empty($_smarty_tpl->tpl_vars['tab']->value['icon_class'])) {?> <i class="<?php echo $_smarty_tpl->tpl_vars['tab']->value['icon_class'];?>
 cbp-mainlink-icon"></i><?php }?>
							<?php if (!$_smarty_tpl->tpl_vars['tab']->value['icon_type'] && !empty($_smarty_tpl->tpl_vars['tab']->value['icon'])) {?> <img src="<?php echo $_smarty_tpl->tpl_vars['tab']->value['icon'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['tab']->value['title'];?>
" class="cbp-mainlink-iicon" /><?php }
if (!$_smarty_tpl->tpl_vars['tab']->value['active_label']) {
echo $_smarty_tpl->tpl_vars['tab']->value['title'];
}
if ($_smarty_tpl->tpl_vars['tab']->value['submenu_type']) {?> <i class="icon-angle-down cbp-submenu-aindicator"></i><?php }?></span>
							<?php if (!empty($_smarty_tpl->tpl_vars['tab']->value['label'])) {?><span class="label cbp-legend cbp-legend-main"><?php if (!empty($_smarty_tpl->tpl_vars['tab']->value['legend_icon'])) {?> <i class="<?php echo $_smarty_tpl->tpl_vars['tab']->value['legend_icon'];?>
 cbp-legend-icon"></i><?php }?> <?php echo $_smarty_tpl->tpl_vars['tab']->value['label'];?>

							<span class="cbp-legend-arrow"></span></span><?php }?>
						</a>

						<?php if ($_smarty_tpl->tpl_vars['tab']->value['submenu_type'] && !empty($_smarty_tpl->tpl_vars['tab']->value['submenu_content'])) {?>
						<div class="cbp-hrsub col-xs-<?php echo $_smarty_tpl->tpl_vars['tab']->value['submenu_width'];?>
">
							<div class="cbp-triangle-container">
								<div class="cbp-triangle-top"></div>
								<div class="cbp-triangle-top-back"></div>
							</div>

							<div class="cbp-hrsub-inner">
								<?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_s_width'] && !$_smarty_tpl->tpl_vars['menu_settings']->value['hor_width'] && !$_smarty_tpl->tpl_vars['menu_settings']->value['hor_sw_width']) {?>
									<div class="container">
								<?php }?>

								<?php if ($_smarty_tpl->tpl_vars['tab']->value['submenu_type'] == 1) {?>
									<div class="container-xs-height cbp-tabs-container">
										<div class="row row-xs-height">
											<div class="col-xs-2 col-xs-height">
												<ul class="cbp-hrsub-tabs-names cbp-tabs-names">
													<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab']->value['submenu_content_tabs'], 'innertab', false, NULL, 'innertabsnames', array (
  'first' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['innertab']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_innertabsnames']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_innertabsnames']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_innertabsnames']->value['index'];
?>
													<li class="innertab-<?php echo $_smarty_tpl->tpl_vars['innertab']->value->id;?>
 <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_innertabsnames']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_innertabsnames']->value['first'] : null)) {?>active<?php }?>">
														<a href="#<?php echo $_smarty_tpl->tpl_vars['innertab']->value->id;?>
-innertab-<?php echo $_smarty_tpl->tpl_vars['tab']->value['id_tab'];?>
" <?php if ($_smarty_tpl->tpl_vars['innertab']->value->url_type != 2) {?> data-link="<?php echo $_smarty_tpl->tpl_vars['innertab']->value->url;?>
" <?php }?>>
															<?php if ($_smarty_tpl->tpl_vars['innertab']->value->icon_type && !empty($_smarty_tpl->tpl_vars['innertab']->value->icon_class)) {?>
																<i class="<?php echo $_smarty_tpl->tpl_vars['innertab']->value->icon_class;?>
 cbp-mainlink-icon"></i>
															<?php }?>

															<?php if (!$_smarty_tpl->tpl_vars['innertab']->value->icon_type && !empty($_smarty_tpl->tpl_vars['innertab']->value->icon)) {?>
																<img src="<?php echo $_smarty_tpl->tpl_vars['innertab']->value->icon;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['innertab']->value->title;?>
" class="cbp-mainlink-iicon" />
															<?php }?>

															<?php echo $_smarty_tpl->tpl_vars['innertab']->value->title;?>


															<?php if (!empty($_smarty_tpl->tpl_vars['innertab']->value->label)) {?>
																<span class="label cbp-legend cbp-legend-inner">
																	<?php if (!empty($_smarty_tpl->tpl_vars['innertab']->value->legend_icon)) {?>
																		<i class="<?php echo $_smarty_tpl->tpl_vars['innertab']->value->legend_icon;?>
 cbp-legend-icon"></i>
																	<?php }?>

																	<?php echo $_smarty_tpl->tpl_vars['innertab']->value->label;?>


																	<span class="cbp-legend-arrow"></span>
																</span>
															<?php }?>
														</a>

														<i class="icon-angle-right cbp-submenu-it-indicator"></i>

														<span class="cbp-inner-border-hider"></span>
													</li>
													<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

												</ul>	
											</div>
								

											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab']->value['submenu_content_tabs'], 'innertab', false, NULL, 'innertabscontent', array (
  'first' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['innertab']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_innertabscontent']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_innertabscontent']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_innertabscontent']->value['index'];
?>
												<div role="tabpanel" class="col-xs-10 col-xs-height tab-pane cbp-tab-pane <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_innertabscontent']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_innertabscontent']->value['first'] : null)) {?>active<?php }?> innertabcontent-<?php echo $_smarty_tpl->tpl_vars['innertab']->value->id;?>
"  id="<?php echo $_smarty_tpl->tpl_vars['innertab']->value->id;?>
-innertab-<?php echo $_smarty_tpl->tpl_vars['tab']->value['id_tab'];?>
">

													<?php if (!empty($_smarty_tpl->tpl_vars['innertab']->value->submenu_content)) {?>
													<div class="clearfix">
														<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['innertab']->value->submenu_content, 'element');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['element']->value) {
?>
															<?php $_smarty_tpl->_subTemplateRender("file:./front_submenu_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['element']->value), 0, true);
?>
               
														<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

													</div>
													<?php }?>

												</div>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


										</div>
									</div>
								<?php } else { ?>

									<?php if (!empty($_smarty_tpl->tpl_vars['tab']->value['submenu_content'])) {?>

										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab']->value['submenu_content'], 'element', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['element']->value) {
?>

											<?php $_smarty_tpl->_subTemplateRender("file:./front_submenu_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['element']->value), 0, true);
?>


										<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


									<?php }?>

								<?php }?>

								<?php if ($_smarty_tpl->tpl_vars['menu_settings']->value['hor_s_width'] && !$_smarty_tpl->tpl_vars['menu_settings']->value['hor_width'] && !$_smarty_tpl->tpl_vars['menu_settings']->value['hor_sw_width']) {?>
									</div>
								<?php }?>

							</div>
						</div>
						<?php }?>
					</li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
			</nav>
			<?php }?>
		</div>

		<div id="iqitmegamenu-mobile">
			<div id="iqitmegamenu-shower" class="clearfix"><div class="container">
				<div class="iqitmegamenu-icon"><i class="icon-reorder"></i></div>
				<span><?php echo smartyTranslate(array('s'=>'Menu','mod'=>'iqitmegamenu'),$_smarty_tpl);?>
</span>
				</div>
			</div>
			<div class="cbp-mobilesubmenu">
				<div class="container">
					<ul id="iqitmegamenu-accordion" class="<?php if ($_smarty_tpl->tpl_vars['mobile_menu_style']->value) {?>iqitmegamenu-accordion<?php } else { ?>cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left<?php }?>">
						<?php if (!$_smarty_tpl->tpl_vars['mobile_menu_style']->value) {?>
							<li id="cbp-close-mobile">
								<i class="icon-chevron-left"></i>

								<?php echo smartyTranslate(array('s'=>'Hide','mod'=>'iqitmegamenu'),$_smarty_tpl);?>

							</li>
						<?php }?>  

						<?php echo $_smarty_tpl->tpl_vars['mobile_menu']->value;?>

					</ul>
				</div>
			</div>

			<?php if (!$_smarty_tpl->tpl_vars['mobile_menu_style']->value) {?>
				<div id="cbp-spmenu-overlay" class="cbp-spmenu-overlay"></div>
			<?php }?>
		</div>
	</div>
</div><?php }
}
