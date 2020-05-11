<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/modules/homesliderpro/views/templates/hook/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf553bc51_37166531',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd839b4efc751221aad2f20811fb2adc4adf7b20a' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/homesliderpro/views/templates/hook/header.tpl',
      1 => 1497495766,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf553bc51_37166531 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style type="text/css" class="slidersEverywhereStyle">


<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['configuration']->value, 'conf', false, 'hook', 'config', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['hook']->value => $_smarty_tpl->tpl_vars['conf']->value) {
?>
	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 {
		padding:<?php echo $_smarty_tpl->tpl_vars['conf']->value['media']['max']['tspace'];?>
px <?php echo $_smarty_tpl->tpl_vars['conf']->value['media']['max']['rspace'];?>
px <?php echo $_smarty_tpl->tpl_vars['conf']->value['media']['max']['bspace'];?>
px <?php echo $_smarty_tpl->tpl_vars['conf']->value['media']['max']['lspace'];?>
px;
		width:<?php echo $_smarty_tpl->tpl_vars['conf']->value['media']['max']['swidth'];?>
%;
		<?php if ($_smarty_tpl->tpl_vars['conf']->value['media']['max']['pos'] > 0) {?>
			<?php if ($_smarty_tpl->tpl_vars['conf']->value['media']['max']['pos'] == 1) {?>clear:both;<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['conf']->value['media']['max']['pos'] == 1) {?>float:left;<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['conf']->value['media']['max']['pos'] == 2) {?>margin:0 auto;clear:both;<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['conf']->value['media']['max']['pos'] == 3) {?>float:right;<?php }?>
		<?php }?>
	}

	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .slidetitle {
		background:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['titlebg'];?>
;
		color:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['titlec'];?>
;
	}

	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .slide_description {
		background:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['descbg'];?>
;
		color:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['descc'];?>
;
	}

	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-next, .SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-prev {
		background:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['arrowbg'];?>
;
		color:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['arrowc'];?>
;
	}

	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-next:hover, .SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-prev:hover {
		text-shadow:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['arrowg'];?>
;
	}
	
	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-pager-item {
		border-color:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['pagerbc'];?>
;
	}
	
	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-pager-item:hover {
		border-color:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['pagerhbc'];?>
;
		box-shadow:0 0 3px <?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['pagerhg'];?>
;
	}
	
	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-pager a {
		background-color:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['pagerc'];?>
;
	}
	
	.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 .se-pager a.se-pager-link.active {
		background-color:<?php echo $_smarty_tpl->tpl_vars['conf']->value['color']['pagerac'];?>
;
	}
	
	/** media queries **/

	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['conf']->value['media'], 'value', false, 'size');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['size']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
		<?php if ($_smarty_tpl->tpl_vars['size']->value != 'max') {?> 
			@media all and (max-width: <?php echo $_smarty_tpl->tpl_vars['size']->value;?>
px) {
				.SEslider.<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>
 {
					padding:<?php echo $_smarty_tpl->tpl_vars['value']->value['tspace'];?>
px <?php echo $_smarty_tpl->tpl_vars['value']->value['rspace'];?>
px <?php echo $_smarty_tpl->tpl_vars['value']->value['bspace'];?>
px <?php echo $_smarty_tpl->tpl_vars['value']->value['lspace'];?>
px;
					width:<?php echo $_smarty_tpl->tpl_vars['value']->value['swidth'];?>
%;
					<?php if ($_smarty_tpl->tpl_vars['value']->value['pos'] > 0) {?>
						<?php if ($_smarty_tpl->tpl_vars['value']->value['pos'] == 1) {?>float:left;<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['value']->value['pos'] == 2) {?>margin:0 auto;<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['value']->value['pos'] == 3) {?>float:right;<?php }?>
					<?php }?>
				}
			}
		<?php }?>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>



<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


/** rtl **/

<?php if ($_smarty_tpl->tpl_vars['rtlslide']->value) {?>
.SEslider, .SEslider * {
  direction: ltr !important;
}

.SEslider .slidetitle, .SEslider .slide_description {
  direction: rtl !important;
}

.SEslider .areaslide.block.transparent .areabuttcont {
	text-align:right;
}

<?php }?>

</style><?php }
}
