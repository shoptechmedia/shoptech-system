<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:04:23
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/options/options.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ffa870f8df5_02219546',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a126167450edb9747773b6f79aac12e39291759c' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/options/options.tpl',
      1 => 1587127092,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ffa870f8df5_02219546 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_counter')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/function.counter.php';
if (!is_callable('smarty_modifier_escape')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_replace')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/modifier.replace.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>


<div class="leadin"><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10791425525e9ffa86f33475_96904175', "leadin");
?>
</div>

<?php echo '<script'; ?>
 type="text/javascript">
	id_language = Number(<?php echo $_smarty_tpl->tpl_vars['current_id_lang']->value;?>
);
	<?php if (isset($_smarty_tpl->tpl_vars['tabs']->value) && count($_smarty_tpl->tpl_vars['tabs']->value)) {?>
		var helper_tabs= <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['tabs']->value);?>
;
		var unique_field_id = '<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_';
	<?php }
echo '</script'; ?>
>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8849330405e9ffa86f3d495_17789769', "defaultOptions");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20328999235e9ffa870f8279_15856575', "after");
?>

<?php }
/* {block "leadin"} */
class Block_10791425525e9ffa86f33475_96904175 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'leadin' => 
  array (
    0 => 'Block_10791425525e9ffa86f33475_96904175',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "leadin"} */
/* {block "label"} */
class Block_11098496125e9ffa87026bd7_93693715 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

									<?php if (isset($_smarty_tpl->tpl_vars['field']->value['title']) && isset($_smarty_tpl->tpl_vars['field']->value['hint'])) {?>
										<label class="control-label col-lg-3<?php if (isset($_smarty_tpl->tpl_vars['field']->value['required']) && $_smarty_tpl->tpl_vars['field']->value['required'] && $_smarty_tpl->tpl_vars['field']->value['type'] != 'radio') {?> required<?php }?>">
											<?php if (!$_smarty_tpl->tpl_vars['categoryData']->value['hide_multishop_checkbox'] && $_smarty_tpl->tpl_vars['field']->value['multishop_default'] && empty($_smarty_tpl->tpl_vars['field']->value['no_multishop_checkbox'])) {?>
											<input type="checkbox" name="multishopOverrideOption[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="1"<?php if (!$_smarty_tpl->tpl_vars['field']->value['is_disabled']) {?> checked="checked"<?php }?> onclick="toggleMultishopDefaultValue(this, '<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')"/>
											<?php }?>
											<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="
												<?php if (is_array($_smarty_tpl->tpl_vars['field']->value['hint'])) {?>
													<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['hint'], 'hint');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['hint']->value) {
?>
														<?php if (is_array($_smarty_tpl->tpl_vars['hint']->value)) {?>
															<?php echo $_smarty_tpl->tpl_vars['hint']->value['text'];?>

														<?php } else { ?>
															<?php echo $_smarty_tpl->tpl_vars['hint']->value;?>

														<?php }?>
													<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

												<?php } else { ?>
													<?php echo $_smarty_tpl->tpl_vars['field']->value['hint'];?>

												<?php }?>
											" data-html="true">
												<?php echo $_smarty_tpl->tpl_vars['field']->value['title'];?>

											</span>
										</label>
									<?php } elseif (isset($_smarty_tpl->tpl_vars['field']->value['title'])) {?>
										<label class="control-label col-lg-3">
											<?php if (!$_smarty_tpl->tpl_vars['categoryData']->value['hide_multishop_checkbox'] && $_smarty_tpl->tpl_vars['field']->value['multishop_default'] && empty($_smarty_tpl->tpl_vars['field']->value['no_multishop_checkbox'])) {?>
											<input type="checkbox" name="multishopOverrideOption[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="1"<?php if (!$_smarty_tpl->tpl_vars['field']->value['is_disabled']) {?> checked="checked"<?php }?> onclick="checkMultishopDefaultValue(this, '<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')" />
											<?php }?>
											<?php echo $_smarty_tpl->tpl_vars['field']->value['title'];?>

										</label>
									<?php }?>
								<?php
}
}
/* {/block "label"} */
/* {block "input"} */
class Block_12791064925e9ffa87036fa4_09387207 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

									<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'select') {?>
										<div class="col-lg-9">
											<?php if ($_smarty_tpl->tpl_vars['field']->value['list']) {?>
												<select class="form-control fixed-width-xxl <?php if (isset($_smarty_tpl->tpl_vars['field']->value['class'])) {
echo $_smarty_tpl->tpl_vars['field']->value['class'];
}?>" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"<?php if (isset($_smarty_tpl->tpl_vars['field']->value['js'])) {?> onchange="<?php echo $_smarty_tpl->tpl_vars['field']->value['js'];?>
"<?php }?> id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['field']->value['size'])) {?> size="<?php echo $_smarty_tpl->tpl_vars['field']->value['size'];?>
"<?php }?>>
													<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['list'], 'option', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['option']->value) {
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['field']->value['identifier']];?>
"<?php if ($_smarty_tpl->tpl_vars['field']->value['value'] == $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['field']->value['identifier']]) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['option']->value['name'];?>
</option>
													<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

												</select>
											<?php } elseif (isset($_smarty_tpl->tpl_vars['field']->value['empty_message'])) {?>
												<?php echo $_smarty_tpl->tpl_vars['field']->value['empty_message'];?>

											<?php }?>
										</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'bool') {?>
										<div class="col-lg-9">
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="1" <?php if ($_smarty_tpl->tpl_vars['field']->value['value']) {?> checked="checked"<?php }
if (isset($_smarty_tpl->tpl_vars['field']->value['js']['on'])) {?> <?php echo $_smarty_tpl->tpl_vars['field']->value['js']['on'];
}
if (isset($_smarty_tpl->tpl_vars['field']->value['disabled']) && (bool)$_smarty_tpl->tpl_vars['field']->value['disabled']) {?> disabled="disabled"<?php }?>>
													<span class="custom-control-label">
														<?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>

													</span>
												</label>

												<label class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="0" <?php if ($_smarty_tpl->tpl_vars['field']->value['value']) {?> checked="checked"<?php }
if (isset($_smarty_tpl->tpl_vars['field']->value['js']['on'])) {?> <?php echo $_smarty_tpl->tpl_vars['field']->value['js']['on'];
}
if (isset($_smarty_tpl->tpl_vars['field']->value['disabled']) && (bool)$_smarty_tpl->tpl_vars['field']->value['disabled']) {?> disabled="disabled"<?php }?>>
													<span class="custom-control-label">
														<?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>

													</span>
												</label>
											</div>
										</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'radio') {?>
										<div class="custom-controls-stacked col-lg-12">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['choices'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['field']->value['value']) {?> checked="checked"<?php }
if (isset($_smarty_tpl->tpl_vars['field']->value['js'][$_smarty_tpl->tpl_vars['k']->value])) {?> <?php echo $_smarty_tpl->tpl_vars['field']->value['js'][$_smarty_tpl->tpl_vars['k']->value];
}?>>

												<span class="custom-control-label">
													<?php echo $_smarty_tpl->tpl_vars['v']->value;?>

												</span>
											</label>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

										</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'checkbox') {?>

										<div class="custom-controls-stacked col-lg-12">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['choices'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
											<label class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['field']->value['value']) {?> checked="checked"<?php }
if (isset($_smarty_tpl->tpl_vars['field']->value['js'][$_smarty_tpl->tpl_vars['k']->value])) {?> <?php echo $_smarty_tpl->tpl_vars['field']->value['js'][$_smarty_tpl->tpl_vars['k']->value];
}?>>

												<span class="custom-control-label">
													<?php echo $_smarty_tpl->tpl_vars['v']->value;?>

												</span>
											</label>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

										</div>

									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'text') {?>
										<div class="col-lg-9"><?php if (isset($_smarty_tpl->tpl_vars['field']->value['suffix'])) {?><div class="input-group<?php if (isset($_smarty_tpl->tpl_vars['field']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['field']->value['class'];
}?>"><?php }?>
											<input class="form-control <?php if (isset($_smarty_tpl->tpl_vars['field']->value['class'])) {
echo $_smarty_tpl->tpl_vars['field']->value['class'];
}?>"
												   type="<?php echo $_smarty_tpl->tpl_vars['field']->value['type'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['field']->value['id'])) {?>
												   id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"<?php }?>
												   size="<?php if (isset($_smarty_tpl->tpl_vars['field']->value['size'])) {
echo intval($_smarty_tpl->tpl_vars['field']->value['size']);
} else { ?>5<?php }?>"
												   name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"
												   value="<?php if (isset($_smarty_tpl->tpl_vars['field']->value['no_escape']) && $_smarty_tpl->tpl_vars['field']->value['no_escape']) {
echo smarty_modifier_escape($_smarty_tpl->tpl_vars['field']->value['value'], 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);
}?>"
												   <?php if (isset($_smarty_tpl->tpl_vars['field']->value['placeholder']) && $_smarty_tpl->tpl_vars['field']->value['placeholder']) {?>placeholder="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['placeholder'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>
												   <?php if (isset($_smarty_tpl->tpl_vars['field']->value['autocomplete']) && !$_smarty_tpl->tpl_vars['field']->value['autocomplete']) {?>autocomplete="off"<?php }?>
												/>
											<?php if (isset($_smarty_tpl->tpl_vars['field']->value['suffix'])) {?>
											<span class="btn btn-primary">
												<?php echo strval($_smarty_tpl->tpl_vars['field']->value['suffix']);?>

											</span>
											<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['field']->value['suffix'])) {?></div><?php }?>
										</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'password') {?>
										<div class="col-lg-9"><?php if (isset($_smarty_tpl->tpl_vars['field']->value['suffix'])) {?><div class="input-group<?php if (isset($_smarty_tpl->tpl_vars['field']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['field']->value['class'];
}?>"><?php }?>
											<input class="form-control" type="<?php echo $_smarty_tpl->tpl_vars['field']->value['type'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['field']->value['id'])) {?> id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"<?php }?> size="<?php if (isset($_smarty_tpl->tpl_vars['field']->value['size'])) {
echo intval($_smarty_tpl->tpl_vars['field']->value['size']);
} else { ?>5<?php }?>" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value=""<?php if (isset($_smarty_tpl->tpl_vars['field']->value['autocomplete']) && !$_smarty_tpl->tpl_vars['field']->value['autocomplete']) {?> autocomplete="off"<?php }?> />
											<?php if (isset($_smarty_tpl->tpl_vars['field']->value['suffix'])) {?>
											<span class="input-group-addon">
												<?php echo strval($_smarty_tpl->tpl_vars['field']->value['suffix']);?>

											</span>
											<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['field']->value['suffix'])) {?></div><?php }?>
										</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'textarea') {?>
										<div class="col-lg-9">
											<textarea class="form-control textarea-autosize" name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" cols="<?php echo intval($_smarty_tpl->tpl_vars['field']->value['cols']);?>
" rows="<?php echo intval($_smarty_tpl->tpl_vars['field']->value['rows']);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
										</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'code') {?>
									<div class="ace-container col-lg-9">
										<div class="ace-editor" data-name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" id="ace<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
</div>
										<input type="hidden" id="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
">
									</div>
										<?php echo '<script'; ?>
>
											(function () {
												function initAce() {
													if (typeof ace === 'undefined') {
														setTimeout(initAce, 100);
														return;
													}
													var editor = ace.edit("ace<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
");
													editor.setTheme("ace/theme/xcode");
													editor.getSession().setMode("ace/mode/<?php if (isset($_smarty_tpl->tpl_vars['field']->value['mode'])) {
echo strtr($_smarty_tpl->tpl_vars['field']->value['mode'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));
} else { ?>javascript<?php }?>");
													editor.setOptions({
														fontSize: <?php if (isset($_smarty_tpl->tpl_vars['field']->value['fontSize'])) {
echo intval($_smarty_tpl->tpl_vars['field']->value['fontSize']);
} else { ?>14<?php }?>,
														minLines: <?php if (isset($_smarty_tpl->tpl_vars['field']->value['minLines'])) {
echo intval($_smarty_tpl->tpl_vars['field']->value['minLines']);
} else { ?>10<?php }?>,
														maxLines: <?php if (isset($_smarty_tpl->tpl_vars['field']->value['maxLines'])) {
echo intval($_smarty_tpl->tpl_vars['field']->value['maxLines']);
} else { ?>10<?php }?>,
														showPrintMargin: <?php if (isset($_smarty_tpl->tpl_vars['field']->value['showPrintMargin']) && $_smarty_tpl->tpl_vars['field']->value['showPrintMargin']) {?>true<?php } else { ?>false<?php }?>,
														enableBasicAutocompletion: <?php if (isset($_smarty_tpl->tpl_vars['field']->value['enableBasicAutocompletion']) && $_smarty_tpl->tpl_vars['field']->value['enableBasicAutocompletion']) {?>true<?php } else { ?>false<?php }?>,
														enableSnippets: <?php if (isset($_smarty_tpl->tpl_vars['field']->value['enableSnippets']) && $_smarty_tpl->tpl_vars['field']->value['enableSnippets']) {?>true<?php } else { ?>false<?php }?>,
														enableLiveAutocompletion: <?php if (isset($_smarty_tpl->tpl_vars['field']->value['enableLiveAutocompletion']) && $_smarty_tpl->tpl_vars['field']->value['enableLiveAutocompletion']) {?>true<?php } else { ?>false<?php }?>
													});
													var input_name = $('#ace<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
').attr('data-name');
													$('#' + input_name).val(editor.getValue());
													editor.on('change', function () {
														$('#' + input_name).val(editor.getValue());
													});
												}

												initAce();
											})();
										<?php echo '</script'; ?>
>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'file') {?>
										<div class="col-lg-9"><?php echo $_smarty_tpl->tpl_vars['field']->value['file'];?>
</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'color') {?>
										<div class="col-lg-2">
											<div class="input-group">
												<input type="color" size="<?php echo $_smarty_tpl->tpl_vars['field']->value['size'];?>
" data-hex="true" <?php if (isset($_smarty_tpl->tpl_vars['field']->value['class'])) {?>class="form-control <?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
" <?php } else { ?>class="form-control color mColorPickerInput"<?php }?> name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['field']->value['class'])) {
echo $_smarty_tpl->tpl_vars['field']->value['class'];
}?>" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" />
											</div>
							            </div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'price') {?>
										<div class="col-lg-9">
											<div class="input-group fixed-width-lg">
												<span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency_left_sign']->value;
echo $_smarty_tpl->tpl_vars['currency_right_sign']->value;?>
 <?php echo smartyTranslate(array('s'=>'(tax excl.)'),$_smarty_tpl);?>
</span>
                                                <input type="text" class="form-control"
                                                    size="<?php if (isset($_smarty_tpl->tpl_vars['field']->value['size'])) {
echo intval($_smarty_tpl->tpl_vars['field']->value['size']);
} else { ?>5<?php }?>"
                                                    name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"
                                                    value="<?php echo displayPriceValue(array('price'=>$_smarty_tpl->tpl_vars['field']->value['value']),$_smarty_tpl);?>
"
                                                    onkeyup="if (isArrowKey(event)) return;
                                                             this.value = this.value.replace(/,/g, '.');"
                                                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value['placeholder']) && $_smarty_tpl->tpl_vars['field']->value['placeholder']) {?>placeholder="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['placeholder'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>
                                                />
											</div>
										</div>
									<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'textLang' || $_smarty_tpl->tpl_vars['field']->value['type'] == 'textareaLang' || $_smarty_tpl->tpl_vars['field']->value['type'] == 'selectLang') {?>
										<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'textLang') {?>
											<div class="ml-0 col-lg-9">
												<div class="ml-0 row">
												<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['languages'], 'value', false, 'id_lang');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id_lang']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
													<?php if (count($_smarty_tpl->tpl_vars['field']->value['languages']) > 1) {?>
													<div class="input-group translatable-field lang-<?php echo $_smarty_tpl->tpl_vars['id_lang']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['id_lang']->value != $_smarty_tpl->tpl_vars['current_id_lang']->value) {?>style="display:none;"<?php }?>>
													<?php }?>
														<input type="text" class="form-control" 
															name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['id_lang']->value;?>
"
															value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
"
															<?php if (isset($_smarty_tpl->tpl_vars['field']->value['class'])) {?>class="<?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
"<?php }?>
														/>
													<?php if (count($_smarty_tpl->tpl_vars['field']->value['languages']) > 1) {?>
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
															<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
																<?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang'] == $_smarty_tpl->tpl_vars['id_lang']->value) {
echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];
}?>
															<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

															<span class="caret"></span>
														</button>
														<ul class="dropdown-menu">
															<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
															<li>
																<a href="javascript:hideOtherLanguage(<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
);"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</a>
															</li>
															<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

														</ul>
													</div>
													<?php } else { ?>
													</div>
													<?php }?>
												<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

												</div>
											</div>
										<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'textareaLang') {?>
											<div class="col-lg-9">
												<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['languages'], 'value', false, 'id_lang');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id_lang']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
													<div class="row translatable-field lang-<?php echo $_smarty_tpl->tpl_vars['id_lang']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['id_lang']->value != $_smarty_tpl->tpl_vars['current_id_lang']->value) {?>style="display:none;"<?php }?>>
														<div id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['id_lang']->value;?>
" class="col-lg-9" >
															<textarea class="form-control textarea-autosize" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['id_lang']->value;?>
"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['value']->value,'\r\n',"\n");?>
</textarea>
														</div>
														<div class="col-lg-2">
															<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
																	<?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang'] == $_smarty_tpl->tpl_vars['id_lang']->value) {
echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];
}?>
																<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

																<span class="caret"></span>
															</button>
															<ul class="dropdown-menu">
																<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
																<li>
																	<a href="javascript:hideOtherLanguage(<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
);"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</a>
																</li>
																<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

															</ul>
														</div>

													</div>
												<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

												<?php echo '<script'; ?>
 type="text/javascript">
													$(document).ready(function() {
														$(".textarea-autosize").autosize();
													});
												<?php echo '</script'; ?>
>
											</div>
										<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'selectLang') {?>
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
												<div id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
" style="display: <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang'] == $_smarty_tpl->tpl_vars['current_id_lang']->value) {?>block<?php } else { ?>none<?php }?>;" class="col-lg-9">
													<select class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo mb_strtoupper($_smarty_tpl->tpl_vars['language']->value['iso_code'], 'UTF-8');?>
">
														<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['list'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
															<option value="<?php if (isset($_smarty_tpl->tpl_vars['v']->value['cast'])) {
echo $_smarty_tpl->tpl_vars['v']->value['cast'][$_smarty_tpl->tpl_vars['v']->value[$_smarty_tpl->tpl_vars['field']->value['identifier']]];
} else {
echo $_smarty_tpl->tpl_vars['v']->value[$_smarty_tpl->tpl_vars['field']->value['identifier']];
}?>"
																<?php if ($_smarty_tpl->tpl_vars['field']->value['value'][$_smarty_tpl->tpl_vars['language']->value['id_lang']] == $_smarty_tpl->tpl_vars['v']->value['name']) {?> selected="selected"<?php }?>>
																<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>

															</option>
														<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

													</select>
												</div>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

										<?php }?>
									<?php }?>
									<?php if (isset($_smarty_tpl->tpl_vars['field']->value['desc']) && !empty($_smarty_tpl->tpl_vars['field']->value['desc'])) {?>
									<div class="col-lg-9 col-lg-offset-3">
										<div class="help-block">
											<?php if (is_array($_smarty_tpl->tpl_vars['field']->value['desc'])) {?>
												<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['desc'], 'p');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['p']->value) {
?>
													<?php if (is_array($_smarty_tpl->tpl_vars['p']->value)) {?>
														<span id="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value['text'];?>
</span><br />
													<?php } else { ?>
														<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
<br />
													<?php }?>
												<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

											<?php } else { ?>
												<?php echo $_smarty_tpl->tpl_vars['field']->value['desc'];?>

											<?php }?>
										</div>
									</div>
									<?php }?>
								<?php
}
}
/* {/block "input"} */
/* {block "field"} */
class Block_14121888955e9ffa870367f2_10640277 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


								<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12791064925e9ffa87036fa4_09387207', "input", $this->tplIndex);
?>

								<?php if ($_smarty_tpl->tpl_vars['field']->value['is_invisible']) {?>
								<div class="col-lg-9 col-lg-offset-3">
									<p class="alert alert-warning row-margin-top">
										<?php echo smartyTranslate(array('s'=>'You can\'t change the value of this configuration field in the context of this shop.'),$_smarty_tpl);?>

									</p>
								</div>
								<?php }?>
								<?php
}
}
/* {/block "field"} */
/* {block "footer"} */
class Block_20439300425e9ffa870d26f0_29797432 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

				<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['submit']) || isset($_smarty_tpl->tpl_vars['categoryData']->value['buttons'])) {?>
					<div class="panel-footer">
						<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['submit']) && !empty($_smarty_tpl->tpl_vars['categoryData']->value['submit'])) {?>
							<button type="<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['submit']['type'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['submit']['type'];
} else { ?>submit<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['submit']['id'])) {?>id="<?php echo $_smarty_tpl->tpl_vars['categoryData']->value['submit']['id'];?>
"<?php }?> class="btn btn-default pull-right" name="<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['submit']['name'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['submit']['name'];
} else { ?>submitOptions<?php echo $_smarty_tpl->tpl_vars['table']->value;
}?>"><i class="process-icon-<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['submit']['imgclass'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['submit']['imgclass'];
} else { ?>save<?php }?>"></i> <?php echo $_smarty_tpl->tpl_vars['categoryData']->value['submit']['title'];?>
</button>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['buttons'])) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categoryData']->value['buttons'], 'btn', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['btn']->value) {
?>
							<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['href']) && trim($_smarty_tpl->tpl_vars['btn']->value['href']) != '') {?>
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['btn']->value['href'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['id'])) {?>id="<?php echo $_smarty_tpl->tpl_vars['btn']->value['id'];?>
"<?php }?> class="btn btn-default<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['btn']->value['class'];
}?>" <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['js']) && $_smarty_tpl->tpl_vars['btn']->value['js']) {?> onclick="<?php echo $_smarty_tpl->tpl_vars['btn']->value['js'];?>
"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['btn']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['btn']->value['icon'];?>
" ></i> <?php }
echo $_smarty_tpl->tpl_vars['btn']->value['title'];?>
</a>
							<?php } else { ?>
								<button type="<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['type'])) {
echo $_smarty_tpl->tpl_vars['btn']->value['type'];
} else { ?>button<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['id'])) {?>id="<?php echo $_smarty_tpl->tpl_vars['btn']->value['id'];?>
"<?php }?> class="<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['class'])) {
echo $_smarty_tpl->tpl_vars['btn']->value['class'];
} else { ?>btn btn-default<?php }?>" name="<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['name'])) {
echo $_smarty_tpl->tpl_vars['btn']->value['name'];
} else { ?>submitOptions<?php echo $_smarty_tpl->tpl_vars['table']->value;
}?>"<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['js']) && $_smarty_tpl->tpl_vars['btn']->value['js']) {?> onclick="<?php echo $_smarty_tpl->tpl_vars['btn']->value['js'];?>
"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['btn']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['btn']->value['icon'];?>
" ></i> <?php }
echo $_smarty_tpl->tpl_vars['btn']->value['title'];?>
</button>
							<?php }?>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

						<?php }?>
					</div>
				<?php }?>
			<?php
}
}
/* {/block "footer"} */
/* {block "defaultOptions"} */
class Block_8849330405e9ffa86f3d495_17789769 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'defaultOptions' => 
  array (
    0 => 'Block_8849330405e9ffa86f3d495_17789769',
  ),
  'label' => 
  array (
    0 => 'Block_11098496125e9ffa87026bd7_93693715',
  ),
  'field' => 
  array (
    0 => 'Block_14121888955e9ffa870367f2_10640277',
  ),
  'input' => 
  array (
    0 => 'Block_12791064925e9ffa87036fa4_09387207',
  ),
  'footer' => 
  array (
    0 => 'Block_20439300425e9ffa870d26f0_29797432',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (isset($_smarty_tpl->tpl_vars['table_bk']->value) && $_smarty_tpl->tpl_vars['table_bk']->value == $_smarty_tpl->tpl_vars['table']->value) {
$_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'table_count', null, null);
echo smarty_function_counter(array('name'=>'table_count'),$_smarty_tpl);
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
}
$_smarty_tpl->_assignInScope('table_bk', $_smarty_tpl->tpl_vars['table']->value ,false ,2);
?>
<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
" id="<?php if ($_smarty_tpl->tpl_vars['table']->value == null) {?>configuration_form<?php } else {
echo $_smarty_tpl->tpl_vars['table']->value;?>
_form<?php }
$_prefixVariable1=$_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_count');
if (isset($_prefixVariable1) && $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_count')) {?>_<?php echo intval($_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_count'));
}?>" method="post" enctype="multipart/form-data" class="form-horizontal">
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['option_list']->value, 'categoryData', false, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value => $_smarty_tpl->tpl_vars['categoryData']->value) {
?>
		<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['top'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['top'];
}?>
		<div class="panel mb-4 <?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['class'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['class'];
}?>" id="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_fieldset_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
">
			
			<div class="card-header">
				<i class="mr-1 <?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['icon'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['icon'];
} else { ?>icon-cogs<?php }?>"></i>
				<h3 class="card-title"><?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['title'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['title'];
} else {
echo smartyTranslate(array('s'=>'Options'),$_smarty_tpl);
}?></h3>
			</div>

			

			<?php if ((isset($_smarty_tpl->tpl_vars['categoryData']->value['description']) && $_smarty_tpl->tpl_vars['categoryData']->value['description'])) {?>
				<div class="alert alert-info"><?php echo $_smarty_tpl->tpl_vars['categoryData']->value['description'];?>
</div>
			<?php }?>
			
			<?php if ((isset($_smarty_tpl->tpl_vars['categoryData']->value['info']) && $_smarty_tpl->tpl_vars['categoryData']->value['info'])) {?>
				<div><?php echo $_smarty_tpl->tpl_vars['categoryData']->value['info'];?>
</div>
			<?php }?>

			<?php if (!$_smarty_tpl->tpl_vars['categoryData']->value['hide_multishop_checkbox'] && $_smarty_tpl->tpl_vars['use_multishop']->value) {?>
			<div class="well clearfix">
				<label class="control-label col-lg-3">
					<i class="icon-sitemap"></i> <?php echo smartyTranslate(array('s'=>'Multistore'),$_smarty_tpl);?>

				</label>
				<div class="col-lg-9">
					<span class="switch prestashop-switch fixed-width-lg">
						<input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_multishop_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_multishop_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
_on" value="1" onclick="toggleAllMultishopDefaultValue($('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_fieldset_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
'), true)"/><label for="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_multishop_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
_on"><?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
</label><input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_multishop_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_multishop_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
_off" value="0" checked="checked" onclick="toggleAllMultishopDefaultValue($('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_fieldset_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
'), false)"/><label for="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_multishop_<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
_off"><?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
</label>
						<a class="slide-button btn"></a>
					</span>
					<div class="row">
						<div class="col-lg-12">
							<p class="help-block">
								<strong><?php echo smartyTranslate(array('s'=>'Check / Uncheck all'),$_smarty_tpl);?>
</strong><br />
								<?php echo smartyTranslate(array('s'=>'You are editing this page for a specific shop or group. Click "Yes" to check all fields, "No" to uncheck all.'),$_smarty_tpl);?>
<br />
 								<?php echo smartyTranslate(array('s'=>'If you check a field, change its value, and save, the multistore behavior will not apply to this shop (or group), for this particular parameter.'),$_smarty_tpl);?>

							</p>
						</div>
					</div>
				</div>
			</div>
			<?php }?>

			<div class="card-body form-wrapper">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categoryData']->value['fields'], 'field', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['field']->value) {
?>
					<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'hidden') {?>
						<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
" />
					<?php } else { ?>
						<div class="form-group<?php if (isset($_smarty_tpl->tpl_vars['field']->value['form_group_class'])) {?> <?php echo $_smarty_tpl->tpl_vars['field']->value['form_group_class'];
}?>"<?php if (isset($_smarty_tpl->tpl_vars['tabs']->value) && isset($_smarty_tpl->tpl_vars['field']->value['tab'])) {?> data-tab-id="<?php echo $_smarty_tpl->tpl_vars['field']->value['tab'];?>
"<?php }?>>
							<div id="conf_id_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['field']->value['is_invisible']) {?> class="isInvisible"<?php }?>>
								<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11098496125e9ffa87026bd7_93693715', "label", $this->tplIndex);
?>

								<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14121888955e9ffa870367f2_10640277', "field", $this->tplIndex);
?>

							</div>
						</div>
				<?php }?>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</div><!-- /.form-wrapper -->

			<?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['bottom'])) {
echo $_smarty_tpl->tpl_vars['categoryData']->value['bottom'];
}?>
			<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20439300425e9ffa870d26f0_29797432', "footer", $this->tplIndex);
?>

		</div>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	<?php echo smartyHook(array('h'=>'displayAdminOptions'),$_smarty_tpl);?>

	<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)) {?>
		<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'hookName', 'hookName', null);?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
Options<?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
		<?php echo smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

	<?php } elseif (isset($_GET['controller'])) {?>
		<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'hookName', 'hookName', null);?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
Options<?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
		<?php echo smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

	<?php }?>
</form>
<?php
}
}
/* {/block "defaultOptions"} */
/* {block "after"} */
class Block_20328999235e9ffa870f8279_15856575 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'after' => 
  array (
    0 => 'Block_20328999235e9ffa870f8279_15856575',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "after"} */
}
