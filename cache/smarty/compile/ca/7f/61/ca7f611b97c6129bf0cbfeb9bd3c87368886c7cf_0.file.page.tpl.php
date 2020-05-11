<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:37:46
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules/page.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff44ab43c61_75975511',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ca7f611b97c6129bf0cbfeb9bd3c87368886c7cf' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules/page.tpl',
      1 => 1587370781,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:controllers/modules/list.tpl' => 1,
  ),
),false)) {
function content_5e9ff44ab43c61_75975511 (Smarty_Internal_Template $_smarty_tpl) {
?>


<?php if ($_smarty_tpl->tpl_vars['add_permission']->value == '1') {?>
  <div id="module_install" class="row" style="<?php if (!isset($_POST['downloadflag'])) {?>display: none;<?php }?>">
    <div class="panel col-lg-12">
      <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post"
            enctype="multipart/form-data" class="form-horizontal">
        <h3><?php echo smartyTranslate(array('s'=>'Add a new module'),$_smarty_tpl);?>
</h3>
        <?php if (!ini_get('file_uploads')) {?>
          <div class="alert alert-danger"><?php echo smartyTranslate(array('s'=>'File uploads have been turned off. Please ask your webhost to enable file uploads (%s).','sprintf'=>array('<code>file_uploads = on</code>')),$_smarty_tpl);?>
</div>
        <?php } else { ?>
          <p class="alert alert-info"><?php echo smartyTranslate(array('s'=>'The module must either be a Zip file (.zip) or a tarball file (.tar, .tar.gz, .tgz).'),$_smarty_tpl);?>
</p>
          <div class="form-group">
            <label for="file" class="control-label col-lg-3">
              <span class="label-tooltip" data-toggle="tooltip" title="<?php echo smartyTranslate(array('s'=>'Upload a module from your computer.'),$_smarty_tpl);?>
">
                <?php echo smartyTranslate(array('s'=>'Module file'),$_smarty_tpl);?>

              </span>
            </label>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-lg-7">
                  <input id="file" type="file" name="file" class="hide"/>
                  <div class="dummyfile input-group">
                    <span class="input-group-addon"><i class="icon-file"></i></span>
                    <input id="file-name" type="text" class="disabled" name="filename" readonly/>
                    <span class="input-group-btn">
                      <button id="file-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
                        <i class="icon-folder-open"></i> <?php echo smartyTranslate(array('s'=>'Choose a file'),$_smarty_tpl);?>

                      </button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-9 col-lg-push-3">
              <button class="btn btn-default" type="submit" name="download">
                <i class="icon-upload-alt"></i>
                <?php echo smartyTranslate(array('s'=>'Upload this module'),$_smarty_tpl);?>

              </button>
            </div>
          </div>
        </form>
      <?php }?>
    </div>
  </div>
<?php }
if (count($_smarty_tpl->tpl_vars['upgrade_available']->value)) {?>
  <div class="alert alert-info">
    <?php echo smartyTranslate(array('s'=>'An upgrade is available for some of your modules!'),$_smarty_tpl);?>

    <ul>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['upgrade_available']->value, 'module');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['module']->value) {
?>
        <li>
          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;anchor=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['anchor'], ENT_QUOTES, 'UTF-8', true);?>
"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['displayName'], ENT_QUOTES, 'UTF-8', true);?>
</b></a>
        </li>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

    </ul>
  </div>
<?php }?>
<div class="panel">
  <div class="panel-heading">
    <i class="icon-list-ul"></i>
    <?php echo smartyTranslate(array('s'=>'Modules list'),$_smarty_tpl);?>

  </div>
  <!--start sidebar module-->
  <div class="row">
    <div class="categoriesTitle col-md-3">
      <div class="list-group">
        <form id="filternameForm" method="post" class="list-group-item form-horizontal">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="icon-search"></i>
            </span>
            <input class="form-control" placeholder="<?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>
" type="text" value="" name="moduleQuicksearch"
                   id="moduleQuicksearch" autocomplete="off"/>
          </div>
        </form>
        <a class="categoryModuleFilterLink list-group-item <?php if (isset($_smarty_tpl->tpl_vars['categoryFiltered']->value['favorites'])) {?>active<?php }?>"
           href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;filterCategory=favorites"
           id="filter_favorite">
          <?php echo smartyTranslate(array('s'=>'Favorites'),$_smarty_tpl);?>
 <span id="favorite-count" class="badge pull-right"><?php echo $_smarty_tpl->tpl_vars['nb_modules_favorites']->value;?>
</span>
        </a>
        <a class="categoryModuleFilterLink list-group-item <?php if (count($_smarty_tpl->tpl_vars['categoryFiltered']->value) <= 0) {?>active<?php }?>"
           href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;unfilterCategory=yes"
           id="filter_all">
          <?php echo smartyTranslate(array('s'=>'All'),$_smarty_tpl);?>
 <span class="badge pull-right"><?php echo $_smarty_tpl->tpl_vars['nb_modules']->value;?>
</span>
        </a>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list_modules_categories']->value, 'module_category', false, 'module_category_key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['module_category_key']->value => $_smarty_tpl->tpl_vars['module_category']->value) {
?>
          <a class="categoryModuleFilterLink list-group-item <?php if (isset($_smarty_tpl->tpl_vars['categoryFiltered']->value[$_smarty_tpl->tpl_vars['module_category_key']->value])) {?>active<?php }?>"
             href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;<?php if (isset($_smarty_tpl->tpl_vars['categoryFiltered']->value[$_smarty_tpl->tpl_vars['module_category_key']->value])) {?>un<?php }?>filterCategory=<?php echo $_smarty_tpl->tpl_vars['module_category_key']->value;?>
"
             id="filter_<?php echo $_smarty_tpl->tpl_vars['module_category_key']->value;?>
">
            <?php echo $_smarty_tpl->tpl_vars['module_category']->value['name'];?>
 <span class="badge pull-right"><?php echo $_smarty_tpl->tpl_vars['module_category']->value['nb'];?>
</span>
          </a>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

      </div>
    </div>
    <div id="moduleContainer" class="col-md-9">
      <?php $_smarty_tpl->_subTemplateRender('file:controllers/modules/list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>
  </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
  $(document).ready(function () {
    $('#file-selectbutton').click(function (e) {
      $('#file').trigger('click');
    });
    $('#file-name').click(function (e) {
      $('#file').trigger('click');
    });
    $('#file').change(function (e) {
      var val = $(this).val();
      var file = val.split(/[\\/]/);
      $('#file-name').val(file[file.length - 1]);
    });
  });
<?php echo '</script'; ?>
><?php }
}
