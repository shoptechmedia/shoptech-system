<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:57:54
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/themes/helpers/options/options.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0071271eb59_74716883',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e8756149cd779d9c4232c4a5b870c31ad9c64e17' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/themes/helpers/options/options.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0071271eb59_74716883 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6298836945ea007126d0003_13254316', "input");
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15349631645ea0071270fbd6_84425711', "footer");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/options/options.tpl");
}
/* {block "input"} */
class Block_6298836945ea007126d0003_13254316 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input' => 
  array (
    0 => 'Block_6298836945ea007126d0003_13254316',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'theme') {?>
    <?php if ($_smarty_tpl->tpl_vars['field']->value['can_display_themes']) {?>
      <div class="col-lg-12">
        <div class="row">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['themes'], 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
            <div class="col-sm-4 col-lg-3">
              <div class="theme-container">
                <h4 class="theme-title"><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</h4>
                <div class="thumbnail-wrapper">
                  <div class="action-wrapper">
                    <div class="action-overlay"></div>
                    <div class="action-buttons">
                      <div class="btn-group">
                        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminThemes'), ENT_QUOTES, 'UTF-8', true);?>
&amp;action=installTheme&amp;id_theme=<?php echo $_smarty_tpl->tpl_vars['theme']->value->id;?>
" class="btn btn-default">
                          <i class="icon-check"></i> <?php echo smartyTranslate(array('s'=>'Use this theme'),$_smarty_tpl);?>

                        </a>
                        <?php if (!$_smarty_tpl->tpl_vars['host_mode']->value) {?>
                          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-caret-down"></i>&nbsp;
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminThemes'), ENT_QUOTES, 'UTF-8', true);?>
&amp;deletetheme&amp;id_theme=<?php echo $_smarty_tpl->tpl_vars['theme']->value->id;?>
" title="Delete this theme" class="delete">
                                <i class="icon-trash"></i> <?php echo smartyTranslate(array('s'=>'Delete this theme'),$_smarty_tpl);?>

                              </a>
                            </li>
                          </ul>
                        <?php }?>
                      </div>
                    </div>
                  </div>
                  <img class="center-block img-thumbnail" src="../themes/<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
/preview.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
" />
                </div>
              </div>
            </div>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['not_installed'], 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
            <div class="col-sm-4 col-lg-3">
              <div class="theme-container">
                <h4 class="theme-title"><?php echo $_smarty_tpl->tpl_vars['theme']->value['name'];?>
</h4>
                <div class="thumbnail-wrapper">
                  <div class="action-wrapper">
                    <div class="action-overlay"></div>
                    <div class="action-buttons">
                      <div class="btn-group">
                        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminThemes'), ENT_QUOTES, 'UTF-8', true);?>
&amp;installThemeFromFolder&amp;theme_dir=<?php echo $_smarty_tpl->tpl_vars['theme']->value['directory'];?>
" class="btn btn-default">
                          <i class="icon-check"></i> <?php echo smartyTranslate(array('s'=>'Install this theme'),$_smarty_tpl);?>

                        </a>
                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-caret-down"></i>&nbsp;
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminThemes'), ENT_QUOTES, 'UTF-8', true);?>
&amp;deletetheme&amp;theme_dir=<?php echo $_smarty_tpl->tpl_vars['theme']->value['directory'];?>
" title="Delete this theme" class="delete">
                              <i class="icon-trash"></i> <?php echo smartyTranslate(array('s'=>'Delete this theme'),$_smarty_tpl);?>

                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <img class="center-block img-thumbnail" src="../themes/<?php echo $_smarty_tpl->tpl_vars['theme']->value['directory'];?>
/preview.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['theme']->value['name'];?>
" />
                </div>
              </div>
            </div>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

        </div>
      </div>
    <?php }?>
  <?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'code') {?>
    <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['grab_favicon_template'])) {?>
      <?php echo '<script'; ?>
 type="text/javascript">
        (function () {
          function resetRefreshButton(target) {
            target.innerHTML = '<i class="icon icon-download"></i> <span><?php echo smartyTranslate(array('s'=>'Download a new template','js'=>1),$_smarty_tpl);?>
</span>';
            target.disabled = false;
          }

          window.downloadNewFaviconTemplate = function (e) {
            var target = e.target;
            if (e.target.tagName !== 'BUTTON') {
              target = e.target.parentNode;
            }

            var i = target.querySelector('i');
            i.className = i.className.replace('icon-download', 'icon-refresh icon-spin');
            var span = target.querySelector('span');
            span.innerHTML = '<?php echo smartyTranslate(array('s'=>'Refreshing...','js'=>1),$_smarty_tpl);?>
';
            target.disabled = true;

            var request = new XMLHttpRequest();
            request.open('GET', currentIndex + '&ajax=1&action=refreshFaviconTemplate&controller=AdminThemes&token=' + token, true);
            request.onload = function() {
              if (request.status >= 200 && request.status < 400) {
                var response = request.responseText;
                try {
                  response = JSON.parse(response);
                  if (!response.hasError) {
                    document.getElementById('<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
').value = atob(response.template);
                    window.aces['<?php echo strtr($_smarty_tpl->tpl_vars['key']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'].setValue(atob(response.template), -1);
                    window.showSuccessMessage('<?php echo smartyTranslate(array('s'=>'Successfully refreshed the favicon template. Do not forget to click "Save" below.','js'=>1),$_smarty_tpl);?>
');
                  } else {
                   <?php if (@constant('_PS_MODE_DEV_')) {?>
                     window.showErrorMessage(response.error);
                   <?php }?>
                  }
                 } catch (e) {
                  window.showErrorMessage('<?php echo smartyTranslate(array('s'=>'Unable to refresh template','js'=>1),$_smarty_tpl);?>
');
                  <?php if (@constant('_PS_MODE_DEV_')) {?>
                    window.showErrorMessage(JSON.stringify(e));
                  <?php }?>

                  resetRefreshButton(target);
                }
              }

              resetRefreshButton(target);
            };

            request.onerror = function() {
              resetRefreshButton(target);
              window.showErrorMessage('<?php echo smartyTranslate(array('s'=>'Unable to refresh template','js'=>1),$_smarty_tpl);?>
');
            };

            request.send();
          };
        }());
      <?php echo '</script'; ?>
>
    <?php }?>
    <div class="ace-container col-lg-9">
      <div class="ace-editor" data-name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" id="ace<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
</div>
      <input type="hidden" id="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
">
      <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['grab_favicon_template'])) {?>
        <br />
        <button type="button" class="btn btn-default clearfix" onclick="downloadNewFaviconTemplate(event);"><i class="icon icon-download"></i> <span><?php echo smartyTranslate(array('s'=>'Download a new template'),$_smarty_tpl);?>
</span></button>
      <?php }?>
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
          window.aces = window.aces || [];
          window.aces['<?php echo strtr($_smarty_tpl->tpl_vars['key']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'] = editor;
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
  <?php } else { ?>
    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

  <?php }
}
}
/* {/block "input"} */
/* {block "footer"} */
class Block_15349631645ea0071270fbd6_84425711 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'footer' => 
  array (
    0 => 'Block_15349631645ea0071270fbd6_84425711',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <?php if (isset($_smarty_tpl->tpl_vars['categoryData']->value['after_tabs'])) {?>
    <?php $_smarty_tpl->_assignInScope('cur_theme', $_smarty_tpl->tpl_vars['categoryData']->value['after_tabs']['cur_theme']);
?>
    <div class="row row-padding-top">

      <div class="col-md-3">
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
" class="_blank">
          <img class="center-block img-thumbnail" src="../themes/<?php echo $_smarty_tpl->tpl_vars['cur_theme']->value['theme_directory'];?>
/preview.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['cur_theme']->value['theme_name'];?>
" />
        </a>
      </div>

      <div id="js_theme_form_container" class="col-md-9">
        <h2><?php echo $_smarty_tpl->tpl_vars['cur_theme']->value['theme_name'];?>
 <?php if (isset($_smarty_tpl->tpl_vars['cur_theme']->value['theme_version'])) {?><small>version <?php echo $_smarty_tpl->tpl_vars['cur_theme']->value['theme_version'];?>
</small><?php }?></h2>
        <?php if (isset($_smarty_tpl->tpl_vars['cur_theme']->value['author_name'])) {?>
        <p>
          <?php echo smartyTranslate(array('s'=>'Designed by %s','sprintf'=>$_smarty_tpl->tpl_vars['cur_theme']->value['author_name']),$_smarty_tpl);?>

        </p>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['cur_theme']->value['tc']) && $_smarty_tpl->tpl_vars['cur_theme']->value['tc']) {?>
        <hr />
        <h4><?php echo smartyTranslate(array('s'=>'Customize your theme'),$_smarty_tpl);?>
</h4>
        <div class="row">
          <div class="col-sm-8">
            <p><?php echo smartyTranslate(array('s'=>'Customize the main elements of your theme: sliders, banners, colors, etc.'),$_smarty_tpl);?>
</p>
          </div>
          <div class="col-sm-4">
            <a class="btn btn-default pull-right" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules'), ENT_QUOTES, 'UTF-8', true);?>
&amp;configure=themeconfigurator">
              <i class="icon icon-list-alt"></i>
              <?php echo smartyTranslate(array('s'=>'Theme Configurator'),$_smarty_tpl);?>

            </a>
          </div>
        </div>
        <?php }?>
        <hr />
        <h4><?php echo smartyTranslate(array('s'=>'Configure your theme'),$_smarty_tpl);?>
</h4>
        <div class="row">
          <div class="col-sm-8">
            <p><?php echo smartyTranslate(array('s'=>'Configure your theme\'s advanced settings, such as the number of columns you want for each page. This setting is mostly for advanced users.'),$_smarty_tpl);?>
</p>
          </div>
          <div class="col-sm-4">
            <a class="btn btn-default pull-right" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminThemes'), ENT_QUOTES, 'UTF-8', true);?>
&amp;updatetheme&amp;id_theme=<?php echo $_smarty_tpl->tpl_vars['cur_theme']->value['theme_id'];?>
">
              <i class="icon icon-cog"></i>
              <?php echo smartyTranslate(array('s'=>'Advanced settings'),$_smarty_tpl);?>

            </a>
          </div>
        </div>
      </div>
    </div>

  <?php }?>

  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>


<?php
}
}
/* {/block "footer"} */
}
