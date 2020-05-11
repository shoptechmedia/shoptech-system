<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:57:55
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/duplicate_urls/duplicates.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea00713cda708_08087944',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '701753e316d50c12345c428aecf488890a360bce' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/duplicate_urls/duplicates.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea00713cda708_08087944 (Smarty_Internal_Template $_smarty_tpl) {
?>


<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
    <div class="panel">
        <div class="panel-heading">
            <i class="icon-link"></i> <?php echo smartyTranslate(array('s'=>'Duplicate URLs'),$_smarty_tpl);?>
 - <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

        </div>
        <?php $_smarty_tpl->_assignInScope('duplicates', $_smarty_tpl->tpl_vars['duplicates_languages']->value[$_smarty_tpl->tpl_vars['language']->value['id_lang']]);
?>
        <?php if (count($_smarty_tpl->tpl_vars['duplicates']->value)) {?>
            <div class="row table-responsive clearfix ">
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width:10%">
                                <span class="title_box"><?php echo smartyTranslate(array('s'=>'Type'),$_smarty_tpl);?>
</span>
                            </th>
                            <th style="width:10%">
                                <span class="title_box"><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</span>
                            </th>
                            <th style="width:10%">
                                <span class="title_box"><?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>
</span>
                            </th>
                            <th style="width:10%">
                                <span class="title_box"><?php echo smartyTranslate(array('s'=>'Type'),$_smarty_tpl);?>
</span>
                            </th>
                            <th style="width:10%">
                                <span class="title_box"><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</span>
                            </th>
                            <th style="width:10%">
                                <span class="title_box"><?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>
</span>
                            </th>
                            <th style="width:40%">
                                <span class="title_box"><?php echo smartyTranslate(array('s'=>'URL'),$_smarty_tpl);?>
</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['duplicates']->value, 'duplicate');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['duplicate']->value) {
?>
                            <tr>
                                <td>
                                    <span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['a_type'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                                </td>
                                <td>
                                    <span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['a_id'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['a_view'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
                                           class="btn btn-default"
                                           title="<?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>
">
                                            <i class="icon-pencil"></i> <?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>

                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['b_type'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                                </td>
                                <td>
                                    <span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['b_id'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['b_view'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
                                           class="btn btn-default"
                                           title="<?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>
">
                                            <i class="icon-pencil"></i> <?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>

                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['a_url'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['duplicate']->value['a_url'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</a>
                                </td>
                            </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <h2><?php echo smartyTranslate(array('s'=>'No duplicates found. Good job!'),$_smarty_tpl);?>
</h2>
        <?php }?>
    </div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

<?php }
}
