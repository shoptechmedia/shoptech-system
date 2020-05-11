<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/themes/shoptech/modules/blockcontactinfos/blockcontactinfos.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf5b13f01_29406458',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a0373fc55920fb0d651889be2a00a83af24ef60' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/modules/blockcontactinfos/blockcontactinfos.tpl',
      1 => 1507620557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf5b13f01_29406458 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_mailto')) require_once '/home/shoptech/public_html/beta/vendor/smarty/smarty/libs/plugins/function.mailto.php';
$_smarty_tpl->compiled->nocache_hash = '4449619975e9ebcf5b03aa6_81282414';
?>


<!-- MODULE Block contact infos -->
<section id="block_contact_infos" class="footer-block col-xs-12 col-sm-3">
	<div>
        <h4><?php echo smartyTranslate(array('s'=>'Store Information','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
</h4>
        <ul class="toggle-footer">
            <li>
                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_company']->value, ENT_QUOTES, 'UTF-8', true);?>

            </li>
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_address']->value != '') {?>
            	<li>
            		<i class="icon-map-marker"></i><?php echo nl2br($_smarty_tpl->tpl_vars['blockcontactinfos_address']->value);?>

            	</li>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value != '') {?>
            	<li>
            		<i class="icon-phone"></i><?php echo smartyTranslate(array('s'=>'Call us now:','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
 
            		<span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
            	</li>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_email']->value != '') {?>
            	<li>
            		<i class="icon-envelope-alt"></i><?php echo smartyTranslate(array('s'=>'Email:','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
 
            		<span><?php echo smarty_function_mailto(array('address'=>htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_email']->value, ENT_QUOTES, 'UTF-8', true),'encode'=>"hex"),$_smarty_tpl);?>
</span>
            	</li>
            <?php }?>
        </ul>
    </div>
</section>
<!-- /MODULE Block contact infos -->
<?php }
}
