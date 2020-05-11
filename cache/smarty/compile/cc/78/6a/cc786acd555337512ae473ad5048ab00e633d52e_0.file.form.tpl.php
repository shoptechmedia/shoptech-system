<?php
/* Smarty version 3.1.31, created on 2020-04-22 12:00:07
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/access/helpers/form/form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea00797d84b75_61572620',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cc786acd555337512ae473ad5048ab00e633d52e' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/access/helpers/form/form.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:toolbar.tpl' => 1,
  ),
),false)) {
function content_5ea00797d84b75_61572620 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php echo '<script'; ?>
 type="text/javascript">
  $(document).ready(function () {

    var id_tab_parentmodule = <?php echo intval($_smarty_tpl->tpl_vars['id_tab_parentmodule']->value);?>
;
    var id_tab_module = <?php echo intval($_smarty_tpl->tpl_vars['id_tab_module']->value);?>
;

    $('tr.child-' + id_tab_parentmodule + ' > td > input.view.' + id_tab_module).change(function () {

      if (!$(this).prop('checked')) {
        $('#table_module_2 thead th:eq(1) input').trigger('click');
        if ($('#table_module_2 thead th:eq(1) input').prop('checked'))
          $('#table_module_2 thead th:eq(1) input').trigger('click');
      }
    });

    $('tr.child-' + id_tab_parentmodule + ' > td > input.edit.' + id_tab_module).change(function () {

      if (!$(this).prop('checked')) {
        $('#table_module_2 thead th:eq(2) input').trigger('click');
        if ($('#table_module_2 thead th:eq(2) input').prop('checked'))
          $('#table_module_2 thead th:eq(2) input').trigger('click');
      }
    });

    $('div.productTabs').find('a').each(function () {
      $(this).attr('href', '#');
    });

    $('div.productTabs a').click(function () {
      var id = $(this).attr('id');
      $('.nav-profile').removeClass('selected');
      $(this).addClass('selected active');
      $(this).siblings().removeClass('active');
      $('.tab-profile').hide();
      $('.' + id).show();
    });

    $('.ajaxPower').change(function () {
      var tout = $(this).data('rel').split('||');
      var id_tab = tout[0];
      var id_profile = tout[1];
      var perm = tout[2];
      var enabled = $(this).is(':checked') ? 1 : 0;
      var tabsize = tout[3];
      var tabnumber = tout[4];
      var table = 'table#table_' + id_profile;

      if (perm == 'all' && $(this).parent().parent().hasClass('parent')) {
        if (enabled)
          $(this).parent().parent().parent().find('.child-' + id_tab + ' input[type=checkbox]').attr('checked', 'checked');
        else
          $(this).parent().parent().parent().find('.child-' + id_tab + ' input[type=checkbox]').removeAttr('checked');
        $.ajax({
          url: "<?php echo strtr($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminAccess'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",
          cache: false,
          data: {
            ajaxMode: '1',
            id_tab: id_tab,
            id_profile: id_profile,
            perm: perm,
            enabled: enabled,
            submitAddAccess: '1',
            addFromParent: '1',
            action: 'updateAccess',
            ajax: '1',
            token: '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminAccess'),$_smarty_tpl);?>
'
          },
          success: function (res, textStatus, jqXHR) {
            try {
              if (res == 'ok')
                showSuccessMessage("<?php echo smartyTranslate(array('s'=>'Update successful','js'=>1),$_smarty_tpl);?>
");
              else
                showErrorMessage("<?php echo smartyTranslate(array('s'=>'Update error','js'=>1),$_smarty_tpl);?>
");
            } catch (e) {
              jAlert('Technical error');
            }
          }
        });
      }
      perfect_access_js_gestion(this, perm, id_tab, tabsize, tabnumber, table);

      $.ajax({
        url: "<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminAccess'));?>
",
        cache: false,
        data: {
          ajaxMode: '1',
          id_tab: id_tab,
          id_profile: id_profile,
          perm: perm,
          enabled: enabled,
          submitAddAccess: '1',
          action: 'updateAccess',
          ajax: '1',
          token: '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminAccess'),$_smarty_tpl);?>
'
        },
        success: function (res, textStatus, jqXHR) {
          try {
            if (res == 'ok')
              showSuccessMessage("<?php echo smartyTranslate(array('s'=>'Update successful','js'=>1),$_smarty_tpl);?>
");
            else
              showErrorMessage("<?php echo smartyTranslate(array('s'=>'Update error','js'=>1),$_smarty_tpl);?>
");
          }
          catch (e) {
            jAlert('Technical error');
          }
        }
      });
    });

    $(".changeModuleAccess").change(function () {
      var tout = $(this).data('rel').split('||');
      var id_module = tout[0];
      var perm = tout[1];
      var id_profile = tout[2];
      var enabled = $(this).is(':checked') ? 1 : 0;
      var enabled_attr = $(this).is(':checked') ? true : false;
      var table = 'table#table_module_' + id_profile;

      if (id_module == -1)
        $(table + ' .ajax-ma-' + perm).each(function (key, value) {
          $(this).attr("checked", enabled_attr);
        });
      else if (!enabled)
        $(table + ' #ajax-ma-' + perm + '-master').each(function (key, value) {
          $(this).attr("checked", enabled_attr);
        });

      $.ajax({
        url: "<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminAccess'));?>
",
        cache: false,
        data: {
          ajaxMode: '1',
          id_module: id_module,
          perm: perm,
          enabled: enabled,
          id_profile: id_profile,
          changeModuleAccess: '1',
          action: 'updateModuleAccess',
          ajax: '1',
          token: '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminAccess'),$_smarty_tpl);?>
'
        },
        success: function (res, textStatus, jqXHR) {
          try {
            if (res == 'ok')
              showSuccessMessage("<?php echo smartyTranslate(array('s'=>'Update successful','js'=>1),$_smarty_tpl);?>
");
            else
              showErrorMessage("<?php echo smartyTranslate(array('s'=>'Update error','js'=>1),$_smarty_tpl);?>
");
          }
          catch (e) {
            jAlert('Technical error');
          }
        }
      });
    });

  });
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['show_toolbar']->value) {?>
  <?php $_smarty_tpl->_subTemplateRender("file:toolbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('toolbar_btn'=>$_smarty_tpl->tpl_vars['toolbar_btn']->value,'toolbar_scroll'=>$_smarty_tpl->tpl_vars['toolbar_scroll']->value,'title'=>$_smarty_tpl->tpl_vars['title']->value), 0, false);
?>

  <div class="leadin"><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12711716175ea00797cfb4b2_71609237', "leadin");
?>
</div>
<?php }?>
<div class="row">
  <div class="productTabs col-lg-2">
    <div class="tab list-group">
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['profiles']->value, 'profile');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['profile']->value) {
?>
        <a class="list-group-item nav-profile <?php if ($_smarty_tpl->tpl_vars['profile']->value['id_profile'] == $_smarty_tpl->tpl_vars['current_profile']->value) {?>active<?php }?>"
           id="profile-<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"
           href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;id_profile=<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['profile']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</a>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

    </div>
  </div>
  <form id="<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form" class="defaultForm form-horizontal col-lg-10"
        action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['submit_action']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
=1&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
"
        method="post" enctype="multipart/form-data">
    <?php if ($_smarty_tpl->tpl_vars['form_id']->value) {?>
      <input type="hidden" name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['identifier']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" id="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['identifier']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['form_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
    <?php }?>
    <?php $_smarty_tpl->_assignInScope('tabsize', count($_smarty_tpl->tpl_vars['tabs']->value));
?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabs']->value, 'tab');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->value) {
?>
      <?php if ($_smarty_tpl->tpl_vars['tab']->value['id_tab'] > $_smarty_tpl->tpl_vars['tabsize']->value) {?>
        <?php $_smarty_tpl->_assignInScope('tabsize', $_smarty_tpl->tpl_vars['tab']->value['id_tab']);
?>
      <?php }?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['profiles']->value, 'profile');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['profile']->value) {
?>
      <div class="profile-<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
 tab-profile"
           style="display:<?php if ($_smarty_tpl->tpl_vars['profile']->value['id_profile'] != $_smarty_tpl->tpl_vars['current_profile']->value) {?>none<?php }?>">
        <div class="row">
          <?php if ($_smarty_tpl->tpl_vars['profile']->value['id_profile'] != $_smarty_tpl->tpl_vars['admin_profile']->value) {?>
            <div class="col-lg-6">
              <div class="panel">
                <h3><?php echo smartyTranslate(array('s'=>'Menu'),$_smarty_tpl);?>
</h3>
                <table class="table" id="table_<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
">
                  <thead>
                    <tr>
                      <th></th>
                      <th>
                        <input type="checkbox" name="1"
                               class="viewall ajaxPower"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> data-rel="-1||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||view||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
"<?php } else { ?> disabled="disabled"<?php }?>/>
                        <?php echo smartyTranslate(array('s'=>'View'),$_smarty_tpl);?>

                      </th>
                      <th>
                        <input type="checkbox" name="1"
                               class="addall ajaxPower"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> data-rel="-1||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||add||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
"<?php } else { ?> disabled="disabled"<?php }?>/>
                        <?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>

                      </th>
                      <th>
                        <input type="checkbox" name="1"
                               class="editall ajaxPower"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> data-rel="-1||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||edit||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
"<?php } else { ?> disabled="disabled"<?php }?>/>
                        <?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>

                      </th>
                      <th>
                        <input type="checkbox" name="1"
                               class="deleteall ajaxPower"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> data-rel="-1||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||delete||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
"<?php } else { ?> disabled="disabled"<?php }?>/>
                        <?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>

                      </th>
                      <th>
                        <input type="checkbox" name="1"
                               class="allall ajaxPower"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> data-rel="-1||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||all||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
"<?php } else { ?> disabled="disabled"<?php }?>/>
                        <?php echo smartyTranslate(array('s'=>'All'),$_smarty_tpl);?>

                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!count($_smarty_tpl->tpl_vars['tabs']->value)) {?>
                      <tr>
                        <td colspan="6"><?php echo smartyTranslate(array('s'=>'No menu'),$_smarty_tpl);?>
</td>
                      </tr>
                    <?php } else { ?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabs']->value, 'tab');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->value) {
?>
                        <?php $_smarty_tpl->_assignInScope('access', $_smarty_tpl->tpl_vars['accesses']->value[$_smarty_tpl->tpl_vars['profile']->value['id_profile']]);
?>
                        <?php if (isset($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']])) {?>
                          <?php if (!$_smarty_tpl->tpl_vars['tab']->value['id_parent'] || $_smarty_tpl->tpl_vars['tab']->value['id_parent'] == -1) {?>
                            <?php $_smarty_tpl->_assignInScope('is_child', false);
?>
                            <?php $_smarty_tpl->_assignInScope('result_accesses', 0);
?>
                            <tr<?php if (!$_smarty_tpl->tpl_vars['is_child']->value) {?> class="parent"<?php }?>>
                              <td<?php if (!$_smarty_tpl->tpl_vars['is_child']->value) {?> class="bold"<?php }?>><?php if ($_smarty_tpl->tpl_vars['is_child']->value) {?> &raquo; <?php }?>
                                <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></td>
                              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['perms']->value, 'perm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['perm']->value) {
?>
                                <?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?>
                                  <td>
                                    <input type="checkbox"
                                           data-rel="<?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']]['id_tab']);?>
||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||<?php echo $_smarty_tpl->tpl_vars['perm']->value;?>
||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
"
                                           class="ajaxPower <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['perm']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']]['id_tab']);?>
"<?php if ($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']][$_smarty_tpl->tpl_vars['perm']->value] == 1) {?> checked="checked"<?php }?>/>
                                  </td>
                                <?php } else { ?>
                                  <td>
                                    <input type="checkbox"
                                           disabled="disabled"<?php if ($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']][$_smarty_tpl->tpl_vars['perm']->value] == 1) {?> checked="checked"<?php }?>/>
                                  </td>
                                <?php }?>
                                <?php $_smarty_tpl->_assignInScope('result_accesses', $_smarty_tpl->tpl_vars['result_accesses']->value+$_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']][$_smarty_tpl->tpl_vars['perm']->value]);
?>
                              <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                              <td>
                                <input type="checkbox"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> data-rel="<?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']]['id_tab']);?>
||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||all||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
" class="ajaxPower all <?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']]['id_tab']);?>
"<?php } else { ?> class="all <?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['tab']->value['id_tab']]['id_tab']);?>
" disabled="disabled"<?php }
if ($_smarty_tpl->tpl_vars['result_accesses']->value == 4) {?> checked="checked"<?php }?>/>
                              </td>
                            </tr>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabs']->value, 'child');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['child']->value) {
?>
                              <?php if ($_smarty_tpl->tpl_vars['child']->value['id_parent'] === $_smarty_tpl->tpl_vars['tab']->value['id_tab']) {?>
                                <?php if (isset($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']])) {?>
                                  <?php $_smarty_tpl->_assignInScope('is_child', true);
?>
                                  <?php $_smarty_tpl->_assignInScope('result_accesses', 0);
?>
                                  <tr class="child-<?php echo $_smarty_tpl->tpl_vars['child']->value['id_parent'];?>
">
                                    <td<?php if (!$_smarty_tpl->tpl_vars['is_child']->value) {?> class="bold"<?php }?>><?php if ($_smarty_tpl->tpl_vars['is_child']->value) {?> &raquo; <?php }
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['child']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['perms']->value, 'perm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['perm']->value) {
?>
                                      <?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?>
                                        <td>
                                          <input type="checkbox"
                                                 data-rel="<?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']]['id_tab']);?>
||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['perm']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
"
                                                 class="ajaxPower <?php echo $_smarty_tpl->tpl_vars['perm']->value;?>
 <?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']]['id_tab']);?>
"<?php if ($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']][$_smarty_tpl->tpl_vars['perm']->value] == 1) {?> checked="checked"<?php }?>/>
                                        </td>
                                      <?php } else { ?>
                                        <td>
                                          <input type="checkbox"
                                                 disabled="disabled"<?php if ($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']][$_smarty_tpl->tpl_vars['perm']->value] == 1) {?> checked="checked"<?php }?>/>
                                        </td>
                                      <?php }?>
                                      <?php $_smarty_tpl->_assignInScope('result_accesses', $_smarty_tpl->tpl_vars['result_accesses']->value+$_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']][$_smarty_tpl->tpl_vars['perm']->value]);
?>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                                    <td>
                                      <input type="checkbox"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> data-rel="<?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']]['id_tab']);?>
||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
||all||<?php echo intval($_smarty_tpl->tpl_vars['tabsize']->value);?>
||<?php echo intval(count($_smarty_tpl->tpl_vars['tabs']->value));?>
" class="ajaxPower all <?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']]['id_tab']);?>
"<?php } else { ?> class="all <?php echo intval($_smarty_tpl->tpl_vars['access']->value[$_smarty_tpl->tpl_vars['child']->value['id_tab']]['id_tab']);?>
" disabled="disabled"<?php }
if ($_smarty_tpl->tpl_vars['result_accesses']->value == 4) {?> checked="checked"<?php }?>/>
                                    </td>
                                  </tr>
                                <?php }?>
                              <?php }?>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                          <?php }?>
                        <?php }?>
                      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="panel">
                <h3><?php echo smartyTranslate(array('s'=>'Modules'),$_smarty_tpl);?>
</h3>
                <table class="table" id="table_module_<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
">
                  <thead>
                    <tr>
                      <th></th>
                      <th>
                        <input type="checkbox"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> class="changeModuleAccess" data-rel="-1||view||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"<?php } else { ?> disabled="disabled"<?php }?>/> <?php echo smartyTranslate(array('s'=>'View'),$_smarty_tpl);?>

                      </th>
                      <th>
                        <input type="checkbox"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> class="changeModuleAccess" data-rel="-1||configure||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"<?php } else { ?> disabled="disabled"<?php }?>/> <?php echo smartyTranslate(array('s'=>'Configure'),$_smarty_tpl);?>

                      </th>
                      <th>
                        <input type="checkbox"<?php if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> class="changeModuleAccess" data-rel="-1||uninstall||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"<?php } else { ?> disabled="disabled"<?php }?>/> <?php echo smartyTranslate(array('s'=>'Uninstall'),$_smarty_tpl);?>

                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!count($_smarty_tpl->tpl_vars['modules']->value)) {?>
                      <tr>
                        <td colspan="3"><?php echo smartyTranslate(array('s'=>'No modules are installed'),$_smarty_tpl);?>
</td>
                      </tr>
                    <?php } else { ?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['modules']->value[$_smarty_tpl->tpl_vars['profile']->value['id_profile']], 'module');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['module']->value) {
?>
                        <tr>
                          <td>&raquo; <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                          <td>
                            <input type="checkbox"
                                   value="1"<?php if ($_smarty_tpl->tpl_vars['module']->value['view'] == true) {?> checked="checked"<?php }
if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> class="ajax-ma-view changeModuleAccess" data-rel="<?php echo intval($_smarty_tpl->tpl_vars['module']->value['id_module']);?>
||view||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"<?php } else { ?> class="ajax-ma-view" disabled="disabled"<?php }?>/>
                          </td>
                          <td>
                            <input type="checkbox"
                                   value="1"<?php if ($_smarty_tpl->tpl_vars['module']->value['configure'] == true) {?> checked="checked"<?php }
if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> class="ajax-ma-configure changeModuleAccess" data-rel="<?php echo intval($_smarty_tpl->tpl_vars['module']->value['id_module']);?>
||configure||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"<?php } else { ?> class="ajax-ma-configure" disabled="disabled"<?php }?>/>
                          </td>
                          <td>
                            <input type="checkbox"
                                   value="1"<?php if ($_smarty_tpl->tpl_vars['module']->value['uninstall'] == true) {?> checked="checked"<?php }
if ($_smarty_tpl->tpl_vars['access_edit']->value == 1) {?> class="ajax-ma-uninstall changeModuleAccess" data-rel="<?php echo intval($_smarty_tpl->tpl_vars['module']->value['id_module']);?>
||uninstall||<?php echo intval($_smarty_tpl->tpl_vars['profile']->value['id_profile']);?>
"<?php } else { ?> class="ajax-ma-uninstall" disabled="disabled"<?php }?>/>
                          </td>
                        </tr>
                      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } else { ?>
            <div class="col-lg-12">
              <div class="panel">
                <?php echo smartyTranslate(array('s'=>'Administrator permissions cannot be modified.'),$_smarty_tpl);?>

              </div>
            </div>
          <?php }?>
        </div>
      </div>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

  </form>
</div>
<?php }
/* {block "leadin"} */
class Block_12711716175ea00797cfb4b2_71609237 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'leadin' => 
  array (
    0 => 'Block_12711716175ea00797cfb4b2_71609237',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "leadin"} */
}
