<?php
/* Smarty version 3.1.31, created on 2020-04-23 08:25:46
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/localization/content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea126dac58de8_38824089',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '91ffb19b70a97be1dc6da79c55c7aab0d3e38085' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/localization/content.tpl',
      1 => 1587619544,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea126dac58de8_38824089 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="app-content">
<?php if (isset($_smarty_tpl->tpl_vars['localization_form']->value)) {
echo $_smarty_tpl->tpl_vars['localization_form']->value;
}
if (isset($_smarty_tpl->tpl_vars['localization_options']->value)) {
echo $_smarty_tpl->tpl_vars['localization_options']->value;
}?>
</div>

<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function() {
		$('#PS_CURRENCY_DEFAULT').change(function(e) {
			alert('Before changing the default currency, we strongly recommend that you enable maintenance mode because any change on default currency requires manual adjustment of the price of each product');
		});
	});
<?php echo '</script'; ?>
><?php }
}
