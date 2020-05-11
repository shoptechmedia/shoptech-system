<?php
/* Smarty version 3.1.31, created on 2020-04-21 12:29:25
  from "/home/shoptech/public_html/beta/themes/shoptech/mobile-header1.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ebcf5c52155_71281803',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '11cfe9c1b4070519b04947f0d34515e157813217' => 
    array (
      0 => '/home/shoptech/public_html/beta/themes/shoptech/mobile-header1.tpl',
      1 => 1585125217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ebcf5c52155_71281803 (Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="mh-sticky" class="not-sticked">
        <div class="mobile-main-wrapper">
        <div class="mobile-main-bar">

            <div class="mh-button mh-menu">
                <span id="mh-menu"><i class="icon-reorder mh-icon"></i></span>
            </div>
            <div  class="mh-button mh-search">
                <span id="mh-search" data-mh-search="1"><i class="icon-search mh-icon"></i></span> 
            </div>
            <div class="mobile-h-logo">
                <a href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value) && $_smarty_tpl->tpl_vars['force_ssl']->value) {
echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;
} else {
echo $_smarty_tpl->tpl_vars['base_dir']->value;
}?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
">
                    <img class="logo img-responsive replace-2xlogo" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) && $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo']) {?>data-retinalogo="<?php echo $_smarty_tpl->tpl_vars['warehouse_vars']->value['retina_logo'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value) && $_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }
if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value) && $_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?> alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
                </a>
            </div>
            <div  class="mh-button mh-user"> 
                <span id="mh-user"><i class="icon-user mh-icon "></i></span>
                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./mobile-user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            </div>
            <?php if (!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
            <div id="mh-cart-wrapper" class="mh-button mh-cart"> 
                <span id="mh-cart">
                    <i class="icon-shopping-cart mh-icon "></i>
                </span>
            </div>
            <?php }?>

        </div>
        </div>

        <div class="mh-dropdowns">
            <div class="mh-drop mh-search-drop">
                    <?php echo smartyHook(array('h'=>'iqitMobileSearch'),$_smarty_tpl);?>

            </div>
        </div>

    </div>
<?php }
}
