<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:05:17
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/carrier_wizard/helpers/form/form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ffabd13d707_54887818',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ddf16dfa0ceedbf08105c29863709ae114546c2f' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/carrier_wizard/helpers/form/form.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:controllers/carrier_wizard/helpers/form/form_ranges.tpl' => 1,
  ),
),false)) {
function content_5e9ffabd13d707_54887818 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2951808175e9ffabd119c67_43274409', "script");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18088531655e9ffabd11f358_34793075', "field");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/form/form.tpl");
}
/* {block "script"} */
class Block_2951808175e9ffabd119c67_43274409 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'script' => 
  array (
    0 => 'Block_2951808175e9ffabd119c67_43274409',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  var string_price = '<?php echo smartyTranslate(array('s'=>'Will be applied when the price is','js'=>1),$_smarty_tpl);?>
';
  var string_weight = '<?php echo smartyTranslate(array('s'=>'Will be applied when the weight is','js'=>1),$_smarty_tpl);?>
';
<?php
}
}
/* {/block "script"} */
/* {block "field"} */
class Block_18088531655e9ffabd11f358_34793075 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'field' => 
  array (
    0 => 'Block_18088531655e9ffabd11f358_34793075',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'zones') {?>
    <?php $_smarty_tpl->_subTemplateRender('file:controllers/carrier_wizard/helpers/form/form_ranges.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="new_range">
      <a href="#" onclick="add_new_range();" class="btn btn-default" id="add_new_range"><?php echo smartyTranslate(array('s'=>'Add new range'),$_smarty_tpl);?>
</a>
    </div>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'logo') {?>
    <?php if (!ini_get('file_uploads')) {?>
      <div class="alert alert-danger"><?php echo smartyTranslate(array('s'=>'File uploads have been turned off. Please ask your webhost to enable file uploads (%s).','sprintf'=>array('<code>file_uploads = on</code>')),$_smarty_tpl);?>
</div>
    <?php } else { ?>
      <div class="col-lg-9">
        <input id="carrier_logo_input" class="hide" type="file" onchange="uploadCarrierLogo();"
               name="carrier_logo_input"/>
        <input type="hidden" id="logo" name="logo" value=""/>
        <div class="dummyfile input-group">
          <span class="input-group-addon"><i class="icon-file"></i></span>
          <input id="attachement_filename" type="text" name="filename" readonly=""/>
          <span class="input-group-btn">
          <button id="attachement_fileselectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
            <i class="icon-folder-open"></i> <?php echo smartyTranslate(array('s'=>'Choose a file'),$_smarty_tpl);?>

          </button>
          </span>
        </div>
        <p class="help-block">
          <?php echo smartyTranslate(array('s'=>'Format:'),$_smarty_tpl);?>
 JPG, GIF, PNG. <?php echo smartyTranslate(array('s'=>'Filesize:'),$_smarty_tpl);?>
 <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['max_image_size']->value);?>
 <?php echo smartyTranslate(array('s'=>'MB max.'),$_smarty_tpl);?>

          <?php echo smartyTranslate(array('s'=>'Current size:'),$_smarty_tpl);?>
 <span id="carrier_logo_size"><?php echo smartyTranslate(array('s'=>'undefined'),$_smarty_tpl);?>
</span>.
        </p>
      </div>
    <?php }?>
  <?php }?>
  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php
}
}
/* {/block "field"} */
}
