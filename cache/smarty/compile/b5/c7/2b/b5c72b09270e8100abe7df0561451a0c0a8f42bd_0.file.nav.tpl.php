<?php
/* Smarty version 3.1.31, created on 2020-04-21 11:00:23
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/nav.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ea817092dc4_96832113',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b5c72b09270e8100abe7df0561451a0c0a8f42bd' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/nav.tpl',
      1 => 1585646601,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ea817092dc4_96832113 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="side-tab-body p-0 border-0" id="sidemenu-Tab">
	<nav class="first-sidemenu">
		<ul class="resp-tabs-list hor_1">
			<li class="dashboard-slica <?php if ($_smarty_tpl->tpl_vars['isDashboard']->value) {?>resp-tab-active<?php }?>"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label"><?php echo smartyTranslate(array('s'=>'Dashboard'),$_smarty_tpl);?>
</span></li>
			<li class="newsletter-slica <?php if ($_smarty_tpl->tpl_vars['isNewsletter']->value) {?>resp-tab-active<?php }?>"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label"><?php echo smartyTranslate(array('s'=>'Newsletter'),$_smarty_tpl);?>
</span></li>
		</ul>
	</nav>
	<nav class="second-sidemenu">
		<ul class="resp-tabs-container hor_1">
			<li class="dashboard-slica <?php if ($_smarty_tpl->tpl_vars['isDashboard']->value) {?>resp-tab-content-active<?php }?>">
				<div class="row">
					<div class="col-md-12">
						<div class="panel sidetab-menu">
							<div class="panel-body tabs-menu-body p-0 border-0">
								<div class="tab-content">
									<div class="tab-pane active">
										<div class="side-menu p-0">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabs']->value, 't');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value) {
?>
												<?php if ($_smarty_tpl->tpl_vars['t']->value['active'] && $_smarty_tpl->tpl_vars['t']->value['id_parent'] == 0 && $_smarty_tpl->tpl_vars['t']->value['class_name'] != 'AdminNewsletter') {?>
												<div class="slide submenu <?php if ($_smarty_tpl->tpl_vars['t']->value['current']) {?>is-expanded<?php }?>">
													<a class="side-menu__item <?php if ($_smarty_tpl->tpl_vars['t']->value['current']) {?>active<?php }?>" <?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs'])) {?>data-toggle="slide"<?php }?> href="<?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs']) && isset($_smarty_tpl->tpl_vars['t']->value['sub_tabs'][0]['href'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value['sub_tabs'][0]['href'], ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value['href'], ENT_QUOTES, 'UTF-8', true);
}?>">
														<span class="side-menu__label"><?php echo $_smarty_tpl->tpl_vars['t']->value['name'];?>
</span><?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs'])) {?><i class="angle fa fa-angle-down"></i><?php }?>
													</a>

													<?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs'])) {?>
													<ul class="slide-menu submenu-list">
														<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['t']->value['sub_tabs'], 't2');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t2']->value) {
?>
															<?php if ($_smarty_tpl->tpl_vars['t2']->value['active']) {?>
															<li <?php if ($_smarty_tpl->tpl_vars['t2']->value['current']) {?> class="is-expanded"<?php }?>>
																<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['t2']->value['href'], ENT_QUOTES, 'UTF-8', true);?>
" class="slide-item <?php if ($_smarty_tpl->tpl_vars['t2']->value['current']) {?>active<?php }?>">
																	<?php if ($_smarty_tpl->tpl_vars['t2']->value['name'] == '') {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t2']->value['class_name'], ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t2']->value['name'], ENT_QUOTES, 'UTF-8', true);
}?>
																</a>
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
												<?php }?>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

										</div>

										<?php echo smartyHook(array('h'=>'displayAdminNavBarBeforeEnd'),$_smarty_tpl);?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>

			<li class="newsletter-slica <?php if ($_smarty_tpl->tpl_vars['isNewsletter']->value) {?>resp-tab-content-active<?php }?>">
				<div class="row">
					<div class="col-md-12">
						<div class="panel sidetab-menu">
							<div class="panel-body tabs-menu-body p-0 border-0">
								<div class="tab-content">
									<div class="tab-pane active">
										<div class="side-menu p-1">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabs']->value, 't');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value) {
?>
												<?php if ($_smarty_tpl->tpl_vars['t']->value['active'] && $_smarty_tpl->tpl_vars['t']->value['id_parent'] == 0 && $_smarty_tpl->tpl_vars['t']->value['class_name'] == 'AdminNewsletter') {?>
												<div class="slide submenu <?php if ($_smarty_tpl->tpl_vars['t']->value['current']) {?>is-expanded<?php }?>">
													<a class="side-menu__item <?php if ($_smarty_tpl->tpl_vars['t']->value['current']) {?>active<?php }?>" <?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs'])) {?>data-toggle="slide"<?php }?> href="<?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs']) && isset($_smarty_tpl->tpl_vars['t']->value['sub_tabs'][0]['href'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value['sub_tabs'][0]['href'], ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value['href'], ENT_QUOTES, 'UTF-8', true);
}?>">
														<span class="side-menu__label"><?php echo $_smarty_tpl->tpl_vars['t']->value['name'];?>
</span><?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs'])) {?><i class="angle fa fa-angle-down"></i><?php }?>
													</a>

													<?php if (count($_smarty_tpl->tpl_vars['t']->value['sub_tabs'])) {?>
													<ul class="slide-menu submenu-list">
														<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['t']->value['sub_tabs'], 't2');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t2']->value) {
?>
															<?php if ($_smarty_tpl->tpl_vars['t2']->value['active']) {?>
															<li <?php if ($_smarty_tpl->tpl_vars['t2']->value['current']) {?> class="is-expanded"<?php }?>>
																<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['t2']->value['href'], ENT_QUOTES, 'UTF-8', true);?>
" class="slide-item <?php if ($_smarty_tpl->tpl_vars['t2']->value['current']) {?>active<?php }?>">
																	<?php if ($_smarty_tpl->tpl_vars['t2']->value['name'] == '') {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t2']->value['class_name'], ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['t2']->value['name'], ENT_QUOTES, 'UTF-8', true);
}?>
																</a>
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
												<?php }?>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</nav>
</div><?php }
}
