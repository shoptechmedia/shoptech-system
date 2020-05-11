<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/modules/iqitfreedeliverycount/views/templates/hook/cart.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf56a23a2_33029025',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '35d9b02f6d0ad136635dffc9bb0a27741d2fb069' => 
    array (
      0 => '/home/shoptech/public_html/beta/modules/iqitfreedeliverycount/views/templates/hook/cart.tpl',
      1 => 1585125236,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf56a23a2_33029025 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="iqitfreedeliverycount iqitfreedeliverycount-detach hidden-detach clearfix <?php if ($_smarty_tpl->tpl_vars['free_ship_remaining']->value <= 0) {?>hidden<?php }?>">
<div clas="fd-table">
<div class="ifdc-icon fd-table-cell"><i class="icon icon-truck"></i></div>

<div class="ifdc-remaining  fd-table-cell"><?php echo smartyTranslate(array('s'=>'Spend','mod'=>'iqitfreedeliverycount'),$_smarty_tpl);?>
 <span class="ifdc-remaining-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['free_ship_remaining']->value)),$_smarty_tpl);?>
</span> <?php echo smartyTranslate(array('s'=>'more and get Free Shipping!','mod'=>'iqitfreedeliverycount'),$_smarty_tpl);?>
</div></div>
<?php if (isset($_smarty_tpl->tpl_vars['txt']->value) && $_smarty_tpl->tpl_vars['txt']->value != '') {?><div class="ifdc-txt"><div class="ifdc-txt-content"><?php echo $_smarty_tpl->tpl_vars['txt']->value;?>
</div></div><?php }?> 
</div>


<?php }
}
