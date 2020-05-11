<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:59:29
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/logs/helpers/options/options.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0077193afa0_26786639',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac6930f44015590845e12f37782195b67c91f7c4' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/logs/helpers/options/options.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0077193afa0_26786639 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6956860755ea007719284b9_97438872', "input");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/options/options.tpl");
}
/* {block "input"} */
class Block_6956860755ea007719284b9_97438872 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input' => 
  array (
    0 => 'Block_6956860755ea007719284b9_97438872',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'iframe') {?>
        <div class="row">
            <iframe id='iframe' style="border: none; width:100%; height: 300px; overflow-y: hidden" srcdoc="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['srcdoc'], ENT_QUOTES, 'UTF-8', true);?>
"></iframe>
        </div>
        <?php echo '<script'; ?>
>
            $('iframe').load(function() {
                var iframe = this;
                iframe.style.height = (iframe.contentWindow.document.body.offsetHeight + 50) + 'px';
                setInterval(function() {
                    iframe.style.height = (iframe.contentWindow.document.body.offsetHeight + 50) + 'px';
                }, 50);
            })
        <?php echo '</script'; ?>
>
    <?php } else { ?>
        <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php }
}
}
/* {/block "input"} */
}
