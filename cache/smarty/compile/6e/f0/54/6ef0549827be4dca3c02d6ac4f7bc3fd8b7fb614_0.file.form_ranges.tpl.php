<?php
/* Smarty version 3.1.31, created on 2020-04-22 15:24:23
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/carrier_wizard/helpers/form/form_ranges.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0377792f724_10856062',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ef0549827be4dca3c02d6ac4f7bc3fd8b7fb614' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/carrier_wizard/helpers/form/form_ranges.tpl',
      1 => 1587558261,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0377792f724_10856062 (Smarty_Internal_Template $_smarty_tpl) {
?>




<?php echo '<script'; ?>
>
  var zones_nbr = <?php echo count($_smarty_tpl->tpl_vars['zones']->value)+3;?>
;
  <?php if (($_smarty_tpl->tpl_vars['currency_decimals']->value)) {?>
    var priceDisplayPrecision = <?php echo @constant('_PS_PRICE_DISPLAY_PRECISION_');?>
;
  <?php } else { ?>
    var priceDisplayPrecision = 0;
  <?php }?>
  var priceDatabasePrecision = <?php echo @constant('_TB_PRICE_DATABASE_PRECISION_');?>
;
<?php echo '</script'; ?>
>
<div id="zone_ranges" style="overflow:auto">
    <h4><?php echo smartyTranslate(array('s'=>'Ranges'),$_smarty_tpl);?>
</h4>
    <table id="zones_table" class="table table-vcenter" style="max-width:100%">
        <tbody>
            <tr class="range_inf">
                <td class="range_type"></td>
                <td class="border_left border_bottom range_sign">&gt;=</td>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ranges']->value, 'range', false, 'r');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['r']->value => $_smarty_tpl->tpl_vars['range']->value) {
?>
                <td class="border_bottom">
                    <div class="input-group fixed-width-md">
                        <span class="input-group-addon weight_unit"><?php echo $_smarty_tpl->tpl_vars['PS_WEIGHT_UNIT']->value;?>
</span>
                        <span class="input-group-addon price_unit"><?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
</span>
                        <input type="text"
                            name="range_inf[<?php echo intval($_smarty_tpl->tpl_vars['range']->value['id_range']);?>
]"
                            class="form-control"
                            value="<?php echo displayPriceValue(array('price'=>$_smarty_tpl->tpl_vars['range']->value['delimiter1']),$_smarty_tpl);?>
"
                            onkeyup="if (isArrowKey(event)) return;
                                     this.value = this.value.replace(/,/g, '.');"
                        />
                    </div>
                </td>
                <?php
}
} else {
?>

                <td class="border_bottom">
                    <div class="input-group fixed-width-md">
                        <span class="input-group-addon weight_unit"><?php echo $_smarty_tpl->tpl_vars['PS_WEIGHT_UNIT']->value;?>
</span>
                        <span class="input-group-addon price_unit"><?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
</span>
                        <input class="form-control" name="range_inf[<?php echo intval($_smarty_tpl->tpl_vars['range']->value['id_range']);?>
]" type="text" />
                    </div>
                </td>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </tr>
            <tr class="range_sup">
                <td class="range_type"></td>
                <td class="border_left range_sign">&lt;</td>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ranges']->value, 'range', false, 'r');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['r']->value => $_smarty_tpl->tpl_vars['range']->value) {
?>
                <td class="range_data">
                    <div class="input-group fixed-width-md">
                        <span class="input-group-addon weight_unit"><?php echo $_smarty_tpl->tpl_vars['PS_WEIGHT_UNIT']->value;?>
</span>
                        <span class="input-group-addon price_unit"><?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
</span>
                        <input type="text"
                            name="range_sup[<?php echo intval($_smarty_tpl->tpl_vars['range']->value['id_range']);?>
]"
                            class="form-control"
                            <?php if (isset($_smarty_tpl->tpl_vars['form_id']->value) && !$_smarty_tpl->tpl_vars['form_id']->value) {?>
                                value=""
                            <?php } else { ?>
                                value="<?php if (isset($_smarty_tpl->tpl_vars['change_ranges']->value) && $_smarty_tpl->tpl_vars['range']->value['id_range'] == 0) {?> <?php } else {
echo displayPriceValue(array('price'=>$_smarty_tpl->tpl_vars['range']->value['delimiter2']),$_smarty_tpl);
}?>"
                            <?php }?>
                            onkeyup="if (isArrowKey(event)) return;
                                     this.value = this.value.replace(/,/g, '.');"
                        />
                    </div>
                </td>
                <?php
}
} else {
?>

                <td class="range_data_new">
                    <div class="input-group fixed-width-md">
                        <span class="input-group-addon weight_unit"><?php echo $_smarty_tpl->tpl_vars['PS_WEIGHT_UNIT']->value;?>
</span>
                        <span class="input-group-addon price_unit"><?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
</span>
                        <input class="form-control" name="range_sup[<?php echo intval($_smarty_tpl->tpl_vars['range']->value['id_range']);?>
]" type="text" autocomplete="off" />
                    </div>
                </td>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </tr>
            <tr class="fees_all">
                <td class="border_top border_bottom border_bold">
                    <span class="fees_all">All</span>
                </td>
                <td style="">
                    <input type="checkbox" onclick="checkAllZones(this);" class="form-control">
                </td>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ranges']->value, 'range', false, 'r');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['r']->value => $_smarty_tpl->tpl_vars['range']->value) {
?>
                <td class="border_top border_bottom <?php if ($_smarty_tpl->tpl_vars['range']->value['id_range'] != 0) {?> validated <?php }?>"  >
                    <div class="input-group fixed-width-md">
                        <span class="input-group-addon currency_sign"><?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
</span>
                        <input class="form-control" type="text" <?php if (isset($_smarty_tpl->tpl_vars['form_id']->value) && !$_smarty_tpl->tpl_vars['form_id']->value) {?> disabled="disabled"<?php }?> autocomplete="off" />
                    </div>
                </td>
                <?php
}
} else {
?>

                <td class="border_top border_bottom">
                    <div class="input-group fixed-width-md">
                        <span class="input-group-addon currency_sign"><?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
</span>
                        <input class="form-control" type="text" autocomplete="off" />
                    </div>
                </td>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </tr>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['zones']->value, 'zone', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['zone']->value) {
?>
            <tr class="fees" data-zoneid="<?php echo $_smarty_tpl->tpl_vars['zone']->value['id_zone'];?>
">
                <td>
                    <label for="zone_<?php echo $_smarty_tpl->tpl_vars['zone']->value['id_zone'];?>
"><?php echo $_smarty_tpl->tpl_vars['zone']->value['name'];?>
</label>
                </td>
                <td class="zone">
                    <input class="form-control input_zone" id="zone_<?php echo $_smarty_tpl->tpl_vars['zone']->value['id_zone'];?>
" name="zone_<?php echo $_smarty_tpl->tpl_vars['zone']->value['id_zone'];?>
" value="1" type="checkbox" <?php if (isset($_smarty_tpl->tpl_vars['fields_value']->value['zones'][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]) && $_smarty_tpl->tpl_vars['fields_value']->value['zones'][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]) {?> checked="checked"<?php }?>/>
                </td>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ranges']->value, 'range', false, 'r');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['r']->value => $_smarty_tpl->tpl_vars['range']->value) {
?>
                <td>
                    <div class="input-group fixed-width-md">
                        <span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency_sign']->value;?>
</span>
                        <input type="text"
                            class="form-control"
                            name="fees[<?php echo intval($_smarty_tpl->tpl_vars['zone']->value['id_zone']);?>
][<?php echo intval($_smarty_tpl->tpl_vars['range']->value['id_range']);?>
]"
                            <?php if (!isset($_smarty_tpl->tpl_vars['fields_value']->value['zones'][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]) || (isset($_smarty_tpl->tpl_vars['fields_value']->value['zones'][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]) && !$_smarty_tpl->tpl_vars['fields_value']->value['zones'][$_smarty_tpl->tpl_vars['zone']->value['id_zone']])) {?>
                                disabled="disabled"
                            <?php }?>
                            <?php if (isset($_smarty_tpl->tpl_vars['price_by_range']->value[$_smarty_tpl->tpl_vars['range']->value['id_range']][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]) && $_smarty_tpl->tpl_vars['price_by_range']->value[$_smarty_tpl->tpl_vars['range']->value['id_range']][$_smarty_tpl->tpl_vars['zone']->value['id_zone']] && isset($_smarty_tpl->tpl_vars['fields_value']->value['zones'][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]) && $_smarty_tpl->tpl_vars['fields_value']->value['zones'][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]) {?>
                                value="<?php echo displayPriceValue(array('price'=>$_smarty_tpl->tpl_vars['price_by_range']->value[$_smarty_tpl->tpl_vars['range']->value['id_range']][$_smarty_tpl->tpl_vars['zone']->value['id_zone']]),$_smarty_tpl);?>
"
                            <?php } else { ?>
                                value=""
                            <?php }?>
                            onkeyup="if (isArrowKey(event)) return;
                                     this.value = this.value.replace(/,/g, '.');"
                        />
                    </div>
                </td>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            <tr class="delete_range">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ranges']->value, 'range', false, 'r', 'ranges', array (
  'first' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['r']->value => $_smarty_tpl->tpl_vars['range']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_ranges']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_ranges']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_ranges']->value['index'];
?>
                    <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_ranges']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_ranges']->value['first'] : null)) {?>
                        <td>&nbsp;</td>
                    <?php } else { ?>
                        <td>
                            <a href="#" onclick="delete_range();" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
</a>
                        </td>
                    <?php }?>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </tr>
        </tbody>
    </table>
</div>
<?php }
}
