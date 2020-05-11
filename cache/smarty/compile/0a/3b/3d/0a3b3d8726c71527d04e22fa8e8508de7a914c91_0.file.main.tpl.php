<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:57:17
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/translations/helpers/view/main.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea006edaab163_04440070',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a3b3d8726c71527d04e22fa8e8508de7a914c91' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/translations/helpers/view/main.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea006edaab163_04440070 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16194242145ea006eda77378_34327735', "override_tpl");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/view/view.tpl");
}
/* {block "override_tpl"} */
class Block_16194242145ea006eda77378_34327735 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'override_tpl' => 
  array (
    0 => 'Block_16194242145ea006eda77378_34327735',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php echo '<script'; ?>
 type="text/javascript">
    function chooseTypeTranslation(id_lang) {
      getE('translation_lang').value = id_lang;
      document.getElementById('typeTranslationForm').submit();
    }

    function addThemeSelect() {
      var list_type_for_theme = ['front', 'modules', 'pdf', 'mails'];
      var type = $('select[name=type]').val();

      $('select[name=theme]').hide();
      for (i = 0; i < list_type_for_theme.length; i++)
        if (list_type_for_theme[i] == type) {
          $('select[name=theme]').show();
          if (type == 'front')
            $('select[name=theme]').children('option[value=""]').attr('disabled', true)
          else
            $('select[name=theme]').children('option[value=""]').attr('disabled', false)
        }
        else
          $('select[name=theme]').val('<?php echo $_smarty_tpl->tpl_vars['theme_default']->value;?>
');
    }

    $(document).ready(function () {
      addThemeSelect();
      $('select[name=type]').change(function () {
        addThemeSelect();
      });

      $('#translations-languages a').click(function (e) {
        e.preventDefault();
        $(this).parent().addClass('active').siblings().removeClass('active');
        $('#language-button').html($(this).html() + ' <span class="caret"></span>');
      });

      $('#modify-translations').click(function (e) {
        var lang = $('#translations-languages li.active').data('type');

        if (lang == null)
          return !alert('<?php echo smartyTranslate(array('s'=>'Please select your language!'),$_smarty_tpl);?>
');

        chooseTypeTranslation($('#translations-languages li.active').data('type'));
      });
    });
  <?php echo '</script'; ?>
>
  <form method="get" action="index.php" id="typeTranslationForm" class="form-horizontal">
    <div class="panel">
      <h3>
        <i class="icon-file-text"></i>
        <?php echo smartyTranslate(array('s'=>'Modify translations'),$_smarty_tpl);?>

      </h3>
      <p class="alert alert-info">
        <?php echo smartyTranslate(array('s'=>'Here you can modify translations for every line of text inside thirty bees.'),$_smarty_tpl);?>
<br/>
        <?php echo smartyTranslate(array('s'=>'First, select a type of translation (such as "Back office" or "Installed modules"), and then select the language you want to translate strings in.'),$_smarty_tpl);?>

      </p>
      <div class="form-group">
        <input type="hidden" name="controller" value="AdminTranslations"/>
        <input type="hidden" name="lang" id="translation_lang" value="0"/>
        <label class="control-label col-lg-3" for="type"><?php echo smartyTranslate(array('s'=>'Type of translation'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <select name="type" id="type">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['translations_type']->value, 'array', false, 'type');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['type']->value => $_smarty_tpl->tpl_vars['array']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['array']->value['name'];?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3" for="theme"><?php echo smartyTranslate(array('s'=>'Select your theme'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <select name="theme" id="theme">
            <?php if (!$_smarty_tpl->tpl_vars['host_mode']->value) {?>
              <option value=""><?php echo smartyTranslate(array('s'=>'Core (no theme selected)'),$_smarty_tpl);?>
</option>
            <?php }?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['themes']->value, 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
"
                      <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value == $_smarty_tpl->tpl_vars['theme']->value->id) {?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3" for="language-button"><?php echo smartyTranslate(array('s'=>'Select your language'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <button type="button" id="language-button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <?php echo smartyTranslate(array('s'=>'Language'),$_smarty_tpl);?>
 <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" id="translations-languages">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
              <li data-type="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
"><a href="#"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</a></li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </ul>
        </div>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
"/>
      </div>
      <div class="panel-footer">
        <button type="button" class="btn btn-default pull-right" id="modify-translations">
          <i class="process-icon-edit"></i> <?php echo smartyTranslate(array('s'=>'Modify'),$_smarty_tpl);?>

        </button>
      </div>
    </div>
  </form>
  <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_submit']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post" enctype="multipart/form-data"
        class="form-horizontal">
    <div class="panel">
      <h3>
        <i class="icon-download"></i>
        <?php echo smartyTranslate(array('s'=>'Add / Update a language'),$_smarty_tpl);?>

      </h3>
      <div id="submitAddLangContent" class="form-group">
        <p class="alert alert-info">
          <?php echo smartyTranslate(array('s'=>'You can add or update a language directly from the thirty bees website here.'),$_smarty_tpl);?>
<br/>
          <?php echo smartyTranslate(array('s'=>'If you choose to update an existing language pack, all of your previous customizations in the theme named "community-theme-default" will be lost. This includes front office expressions and default email templates.'),$_smarty_tpl);?>

        </p>
        <?php if ($_smarty_tpl->tpl_vars['packs_to_update']->value || $_smarty_tpl->tpl_vars['packs_to_install']->value) {?>
          <label class="control-label col-lg-3"
                 for="params_import_language"><?php echo smartyTranslate(array('s'=>'Please select the language you want to add or update'),$_smarty_tpl);?>
</label>
          <div class="col-lg-9">
            <div class="row">
              <div class="col-lg-6">
                <select id="params_import_language" name="params_import_language" class="chosen">
                  <optgroup label="<?php echo smartyTranslate(array('s'=>'Update a language'),$_smarty_tpl);?>
">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['packs_to_update']->value, 'lang_pack');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['lang_pack']->value) {
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['iso_code'];?>
|<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['version'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['name'];?>
</option>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                  </optgroup>
                  <optgroup label="<?php echo smartyTranslate(array('s'=>'Add a language'),$_smarty_tpl);?>
">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['packs_to_install']->value, 'lang_pack');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['lang_pack']->value) {
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['iso_code'];?>
|<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['version'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['name'];?>
</option>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                  </optgroup>
                </select>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <p class="text-danger"><?php echo smartyTranslate(array('s'=>'Cannot connect to the thirty bees website to get the language list.'),$_smarty_tpl);?>
</p>
        <?php }?>
      </div>
      <div class="panel-footer">
        <button type="submit" name="submitAddLanguage" class="btn btn-default pull-right">
          <i class="process-icon-cogs"></i> <?php echo smartyTranslate(array('s'=>'Add or update a language'),$_smarty_tpl);?>

        </button>
      </div>
    </div>
  </form>
  <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_submit']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post" enctype="multipart/form-data"
        class="form-horizontal">
    <div class="panel">
      <h3>
        <i class="icon-download"></i>
        <?php echo smartyTranslate(array('s'=>'Import a language pack manually'),$_smarty_tpl);?>

      </h3>
      <p class="alert alert-info">
        <?php echo smartyTranslate(array('s'=>'If the language file format is ISO_code.gzip (e.g. "us.gzip"), and the language corresponding to this package does not exist, it will automatically be created.'),$_smarty_tpl);?>

        <?php echo smartyTranslate(array('s'=>'Warning: This will replace all of the existing data inside the destination language.'),$_smarty_tpl);?>

      </p>
      <div class="form-group">
        <label for="importLanguage" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Language pack to import'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <div class="form-group">
            <div class="col-lg-12">
              <?php if (!ini_get('file_uploads')) {?>
                <div class="alert alert-danger"><?php echo smartyTranslate(array('s'=>'File uploads have been turned off. Please ask your webhost to enable file uploads (%s).','sprintf'=>array('<code>file_uploads = on</code>')),$_smarty_tpl);?>
</div>
              <?php } else { ?>
                <input id="importLanguage" type="file" name="file" class="hide"/>
                <div class="dummyfile input-group">
                  <span class="input-group-addon"><i class="icon-file"></i></span>
                  <input id="file-name" type="text" class="disabled" name="filename" readonly/>
                  <span class="input-group-btn">
                    <button id="file-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
                      <i class="icon-folder-open"></i> <?php echo smartyTranslate(array('s'=>'Add file'),$_smarty_tpl);?>

                    </button>
                  </span>
                </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="selectThemeForImport" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Select your theme'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <select name="theme[]" id="selectThemeForImport" <?php if (count($_smarty_tpl->tpl_vars['themes']->value) > 1) {?>multiple="multiple"<?php }?> >
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['themes']->value, 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
 &nbsp;</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
      </div>
      <div class="panel-footer">
        <button type="submit" name="submitImport" class="btn btn-default pull-right"><i
                  class="process-icon-upload"></i> <?php echo smartyTranslate(array('s'=>'Import'),$_smarty_tpl);?>
</button>
      </div>
    </div>
  </form>
  <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_submit']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post" enctype="multipart/form-data"
        class="form-horizontal">
    <div class="panel">
      <h3>
        <i class="icon-upload"></i>
        <?php echo smartyTranslate(array('s'=>'Export a language'),$_smarty_tpl);?>

      </h3>
      <p class="alert alert-info">
        <?php echo smartyTranslate(array('s'=>'Export data from one language to a file (language pack).'),$_smarty_tpl);?>
<br/>
        <?php echo smartyTranslate(array('s'=>'Select which theme you would like to export your translations to.'),$_smarty_tpl);?>

      </p>
      <div class="form-group">
        <label class="control-label col-lg-3" for="iso_code"><?php echo smartyTranslate(array('s'=>'Language'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <select name="iso_code" id="iso_code">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3" for="export-theme"><?php echo smartyTranslate(array('s'=>'Select your theme'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <select name="theme" id="export-theme">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['themes']->value, 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
"
                      <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value == $_smarty_tpl->tpl_vars['theme']->value->id) {?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
      </div>
      <div class="panel-footer">
        <button type="submit" name="submitExport" class="btn btn-default pull-right"><i
                  class="process-icon-download"></i> <?php echo smartyTranslate(array('s'=>'Export'),$_smarty_tpl);?>
</button>
      </div>
    </div>
  </form>
  <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_submit']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post" class="form-horizontal">
    <div class="panel">
      <h3>
        <i class="icon-copy"></i>
        <?php echo smartyTranslate(array('s'=>'Copy'),$_smarty_tpl);?>

      </h3>
      <p class="alert alert-info">
        <?php echo smartyTranslate(array('s'=>'Copies data from one language to another.'),$_smarty_tpl);?>
<br/>
        <?php echo smartyTranslate(array('s'=>'Warning: This will replace all of the existing data inside the destination language.'),$_smarty_tpl);?>
<br/>
        <?php echo smartyTranslate(array('s'=>'If necessary'),$_smarty_tpl);?>
, <b><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_create_language']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="btn btn-link"><i
                    class="icon-external-link-sign"></i> <?php echo smartyTranslate(array('s'=>'you must first create a new language.'),$_smarty_tpl);?>
</a></b>.
      </p>
      <div class="form-group">
        <label class="control-label col-lg-3 required" for="fromLang"> <?php echo smartyTranslate(array('s'=>'From'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <select name="fromLang" id="fromLang">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
        <div class="col-lg-4">
          <select name="fromTheme">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['themes']->value, 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
"
                      <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value == $_smarty_tpl->tpl_vars['theme']->value->id) {?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3" for="toLang"><?php echo smartyTranslate(array('s'=>'To'),$_smarty_tpl);?>
</label>
        <div class="col-lg-4">
          <select name="toLang" id="toLang">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
        <div class="col-lg-4">
          <select name="toTheme">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['themes']->value, 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
"
                      <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value == $_smarty_tpl->tpl_vars['theme']->value->id) {?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </select>
        </div>
      </div>
      <div class="form-group">
        <p class="col-lg-12 text-muted required">
          <span class="text-danger">*</span>
          <?php echo smartyTranslate(array('s'=>'Language files must be complete to allow copying of translations.'),$_smarty_tpl);?>

        </p>
      </div>
      <div class="panel-footer">
        <button type="submit" name="submitCopyLang" class="btn btn-default pull-right"><i
                  class="process-icon-duplicate"></i> <?php echo smartyTranslate(array('s'=>'Copy'),$_smarty_tpl);?>
</button>
      </div>
    </div>
  </form>
  <?php echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function () {
      $('#file-selectbutton').click(function (e) {
        $('#importLanguage').trigger('click');
      });

      $('#file-name').click(function (e) {
        $('#importLanguage').trigger('click');
      });

      $('#importLanguage').change(function (e) {
        if ($(this)[0].files !== undefined) {
          var files = $(this)[0].files;
          var name = '';

          $.each(files, function (index, value) {
            name += value.name + ', ';
          });

          $('#file-name').val(name.slice(0, -2));
        }
        else // Internet Explorer 9 Compatibility
        {
          var name = $(this).val().split(/[\\/]/);
          $('#file-name').val(name[name.length - 1]);
        }
      });
    });
  <?php echo '</script'; ?>
>
<?php
}
}
/* {/block "override_tpl"} */
}
