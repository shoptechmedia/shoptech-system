<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:59:29
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/logs/helpers/list/list_header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea00771810d85_51764068',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '65b0bb29aa32e2717600a22cdeeaf1830dccc3f9' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/logs/helpers/list/list_header.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea00771810d85_51764068 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>




<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5930174675ea00771809865_80818937', "override_header");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/list/list_header.tpl");
}
/* {block "override_header"} */
class Block_5930174675ea00771809865_80818937 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'override_header' => 
  array (
    0 => 'Block_5930174675ea00771809865_80818937',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


	<div class="panel">
		<h3>
			<i class="icon-warning-sign"></i>
			<?php echo smartyTranslate(array('s'=>'Severity levels'),$_smarty_tpl);?>

		</h3>
		<p><?php echo smartyTranslate(array('s'=>'Meaning of severity levels:'),$_smarty_tpl);?>
</p>
		<ol>
			<li><span class="badge badge-success"><?php echo smartyTranslate(array('s'=>'Informative only'),$_smarty_tpl);?>
</span></li>
			<li><span class="badge badge-warning"><?php echo smartyTranslate(array('s'=>'Warning'),$_smarty_tpl);?>
</span></li>
			<li><span class="badge badge-danger"><?php echo smartyTranslate(array('s'=>'Error'),$_smarty_tpl);?>
</span></li>
			<li><span class="badge badge-critical"><?php echo smartyTranslate(array('s'=>'Major issue (crash)!'),$_smarty_tpl);?>
</span></li>
		</ol>
	</div>

<?php
}
}
/* {/block "override_header"} */
}
