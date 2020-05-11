<?php
/* Smarty version 3.1.31, created on 2020-04-23 16:56:55
  from "/home/shoptech/public_html/beta/modules/iqitcontentcreator/views/templates/hook/front_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea19ea76ca284_22622846',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6d24fa54713c322e6a80ef315ce748bce49cd12f' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/iqitcontentcreator/views/templates/hook/front_content.tpl',
      1 => 1545374870,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./front_content_inner.tpl' => 1,
    'file:./front_content.tpl' => 4,
  ),
),false)) {
function content_5ea19ea76ca284_22622846 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '19195918175ea19ea7648076_98051134';
?>


	
	<?php if ($_smarty_tpl->tpl_vars['node']->value['type'] == 1) {?>
	<div class="row iqitcontent_row iqitcontent-element <?php if ($_smarty_tpl->tpl_vars['node']->value['depth'] == 0) {?> first_rows<?php }?> iqitcontent-element-id-<?php echo $_smarty_tpl->tpl_vars['node']->value['elementId'];?>
 <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['prlx']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['prlx']) {?>parallax-row<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['padd']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['padd']) {?>nopadding-row<?php }?> <?php if (!isset($_smarty_tpl->tpl_vars['node']->value['row_s']['bgw']) || !$_smarty_tpl->tpl_vars['node']->value['row_s']['bgw']) {?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['valign']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['valign']) {?>valign-center-row<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['bgh']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['bgh']) {?>fullheight-row<?php }?> <?php }
if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['bgw']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['bgw'] == 2) {?>fullwidth-row-container<?php }?>">
	<?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['bgw']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['bgw']) {?><div class="<?php if ($_smarty_tpl->tpl_vars['node']->value['row_s']['bgw'] == 2) {?>iqit-fullwidth-content<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['row_s']['bgw'] == 1) {?>iqit-fullwidth<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['prlx']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['prlx']) {?>parallax-row<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['padd']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['padd']) {?>nopadding-row<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['valign']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['valign']) {?>valign-center-row<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['bgh']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['bgh']) {?>fullheight-row<?php }?> iqit-fullwidth-row clearfix"><?php }?> 
		

	<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['type'] == 2) {?>
		<div  class="<?php if ($_smarty_tpl->tpl_vars['node']->value['width_p'] == 13) {?>hidden-xs<?php } else { ?>col-xs-<?php echo $_smarty_tpl->tpl_vars['node']->value['width_p'];
}?> <?php if ($_smarty_tpl->tpl_vars['node']->value['width_t'] == 13) {?>hidden-sm<?php } else { ?>col-sm-<?php echo $_smarty_tpl->tpl_vars['node']->value['width_t'];
}?> <?php if ($_smarty_tpl->tpl_vars['node']->value['width_d'] == 13) {?>hidden-md hidden-lg<?php } else { ?>col-md-<?php echo $_smarty_tpl->tpl_vars['node']->value['width_d'];
}?> iqitcontent-column iqitcontent-element iqitcontent-element-id-<?php echo $_smarty_tpl->tpl_vars['node']->value['elementId'];?>
 <?php if ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 0) {?>empty-column<?php }?> <?php if ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 6) {?>banner-column<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['iheight']) && $_smarty_tpl->tpl_vars['node']->value['content']['iheight'] == 1) {?>fullheight-banner<?php }?>" >
			<div class="iqitcontent-column-inner <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['title'])) {?>iqitcolumn-have-title<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['title_bg'])) {?>iqitcolumn-title-bg<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['ar'])) {
if ($_smarty_tpl->tpl_vars['node']->value['content']['ar'] == 1) {?>alternative-slick-arrows<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['content']['ar'] == 2) {?>hide-slick-arrows<?php }
}?> ">
	<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['type'] == 4) {?>
		<div  class="<?php if ($_smarty_tpl->tpl_vars['node']->value['width_p'] == 13) {?>hidden-xs<?php } else { ?>col-xs-<?php echo $_smarty_tpl->tpl_vars['node']->value['width_p'];
}?> <?php if ($_smarty_tpl->tpl_vars['node']->value['width_t'] == 13) {?>hidden-sm<?php } else { ?>col-sm-<?php echo $_smarty_tpl->tpl_vars['node']->value['width_t'];
}?> <?php if ($_smarty_tpl->tpl_vars['node']->value['width_d'] == 13) {?>hidden-md hidden-lg<?php } else { ?>col-md-<?php echo $_smarty_tpl->tpl_vars['node']->value['width_d'];
}?> iqitcontent-column iqitcontent-tabs iqitcontent-element iqitcontent-element-id-<?php echo $_smarty_tpl->tpl_vars['node']->value['elementId'];?>
 <?php if ($_smarty_tpl->tpl_vars['node']->value['contentType'] == 0) {?>empty-column<?php }?>" >
			<div class="iqitcontent-column-inner <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['title'])) {?>iqitcolumn-have-title<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content_s']['title_bg'])) {?>iqitcolumn-title-bg<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['node']->value['content']['ar'])) {
if ($_smarty_tpl->tpl_vars['node']->value['content']['ar'] == 1) {?>alternative-slick-arrows<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['content']['ar'] == 2) {?>hide-slick-arrows<?php }
}?>">
	<?php }?>
		

		<?php $_smarty_tpl->_subTemplateRender("file:./front_content_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['node']->value), 0, false);
?>




			<?php if ($_smarty_tpl->tpl_vars['node']->value['type'] == 2 || $_smarty_tpl->tpl_vars['node']->value['type'] == 1 || $_smarty_tpl->tpl_vars['node']->value['type'] == 4) {?>
			
				<?php if (isset($_smarty_tpl->tpl_vars['node']->value['children']) && count($_smarty_tpl->tpl_vars['node']->value['children']) > 0) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['node']->value['children'], 'child', false, NULL, 'categoryTreeBranch', array (
  'first' => true,
  'last' => true,
  'index' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['child']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['total'];
?>
						<?php if ($_smarty_tpl->tpl_vars['child']->value['type'] == 3) {?>
						<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['first'] : null)) {?>  <ul class="nav nav-tabs"><?php }?> 
							<li><a href="#iqitcontent-tab-id-<?php echo $_smarty_tpl->tpl_vars['child']->value['elementId'];?>
"  <?php if (isset($_smarty_tpl->tpl_vars['child']->value['tabtitle'])) {?>title="<?php echo $_smarty_tpl->tpl_vars['child']->value['tabtitle'];?>
"<?php }?> data-toggle="tab"><?php if (isset($_smarty_tpl->tpl_vars['child']->value['tabtitle'])) {
echo $_smarty_tpl->tpl_vars['child']->value['tabtitle'];
} else {
echo smartyTranslate(array('s'=>'Set tab title','mod'=>'iqitcontentcreator'),$_smarty_tpl);
}?></a></li>
						<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last'] : null)) {?>  </ul> <?php }?> 
						<?php }?>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['node']->value['children'], 'child', false, NULL, 'categoryTreeBranch', array (
  'first' => true,
  'last' => true,
  'index' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['child']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['total'];
?>
						<?php if ($_smarty_tpl->tpl_vars['child']->value['type'] == 3) {?>
						<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['first'] : null)) {?>  <div class="tab-content"><?php }?> 
							<?php $_smarty_tpl->_subTemplateRender("file:./front_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['child']->value,'icount'=>$_smarty_tpl->tpl_vars['i']->value), 0, true);
?>

						<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last'] : null)) {?>  </div> <?php }?> 
						<?php } else { ?>
							<?php $_smarty_tpl->_subTemplateRender("file:./front_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['child']->value), 0, true);
?>

						<?php }?>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				<?php }?>
			
			<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['type'] == 3) {?>
			
				<?php if (isset($_smarty_tpl->tpl_vars['node']->value['children']) && count($_smarty_tpl->tpl_vars['node']->value['children']) > 0) {?>
				<div id="iqitcontent-tab-id-<?php echo $_smarty_tpl->tpl_vars['node']->value['elementId'];?>
"  class="tab-pane  iqitcontent-element-id-<?php echo $_smarty_tpl->tpl_vars['node']->value['elementId'];?>
 clearfix <?php if ($_smarty_tpl->tpl_vars['icount']->value == 0) {?> active <?php }?>">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['node']->value['children'], 'child', false, NULL, 'categoryTreeBranch', array (
  'first' => true,
  'last' => true,
  'index' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['child']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['total'];
?>
						<?php $_smarty_tpl->_subTemplateRender("file:./front_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['child']->value), 0, true);
?>

					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</div>
				<?php }?>

			<?php }?>



		<?php if ($_smarty_tpl->tpl_vars['node']->value['type'] == 2 || $_smarty_tpl->tpl_vars['node']->value['type'] == 4) {?></div><?php }?>
		



		<?php if (isset($_smarty_tpl->tpl_vars['node']->value['row_s']['bgw']) && $_smarty_tpl->tpl_vars['node']->value['row_s']['bgw']) {?></div><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['node']->value['type'] == 1 || $_smarty_tpl->tpl_vars['node']->value['type'] == 2 || $_smarty_tpl->tpl_vars['node']->value['type'] == 4) {?></div><?php }
}
}
