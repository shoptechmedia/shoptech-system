<?php
/* Smarty version 3.1.31, created on 2020-04-22 10:38:59
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/uploader/simple.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ff4933b4710_44613996',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a974f08591697cebab6187403aa37cf404ff910a' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/helpers/uploader/simple.tpl',
      1 => 1586338202,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ff4933b4710_44613996 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (isset($_smarty_tpl->tpl_vars['files']->value) && count($_smarty_tpl->tpl_vars['files']->value) > 0) {?>
  <?php $_smarty_tpl->_assignInScope('show_thumbnail', false);
?>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['files']->value, 'file');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['file']->value) {
?>
    <?php if (isset($_smarty_tpl->tpl_vars['file']->value['image']) && $_smarty_tpl->tpl_vars['file']->value['type'] == 'image') {?>
      <?php $_smarty_tpl->_assignInScope('show_thumbnail', true);
?>
    <?php }?>
  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

  <?php if ($_smarty_tpl->tpl_vars['show_thumbnail']->value) {?>
    <div class="form-group">
      <div class="col-lg-12" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-images-thumbnails">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['files']->value, 'file');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['file']->value) {
?>
          <?php if (isset($_smarty_tpl->tpl_vars['file']->value['image']) && $_smarty_tpl->tpl_vars['file']->value['type'] == 'image') {?>
            <div>
              <?php echo $_smarty_tpl->tpl_vars['file']->value['image'];?>

              <?php if (isset($_smarty_tpl->tpl_vars['file']->value['size'])) {?><p><?php echo smartyTranslate(array('s'=>'File size'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['file']->value['size'];?>
kb</p><?php }?>
              <?php if (isset($_smarty_tpl->tpl_vars['file']->value['delete_url'])) {?>
                <p>
                  <a class="btn btn-default" href="<?php echo $_smarty_tpl->tpl_vars['file']->value['delete_url'];?>
">
                    <i class="icon-trash"></i> <?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>

                  </a>
                </p>
              <?php }?>
            </div>
          <?php }?>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

      </div>
    </div>
  <?php }
}
if (!ini_get('file_uploads')) {?>
  <div class="alert alert-danger"><?php echo smartyTranslate(array('s'=>'File uploads have been turned off. Please ask your webhost to enable file uploads (%s).','sprintf'=>array('<code>file_uploads = on</code>')),$_smarty_tpl);?>
</div>
<?php } elseif (isset($_smarty_tpl->tpl_vars['max_files']->value) && count($_smarty_tpl->tpl_vars['files']->value) >= $_smarty_tpl->tpl_vars['max_files']->value) {?>
  <div class="alert alert-danger">No uploads</div>

  <div class="row">
    <div class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'You have reached the limit (%s) of files to upload, please remove files to continue uploading','sprintf'=>$_smarty_tpl->tpl_vars['max_files']->value),$_smarty_tpl);?>
</div>
  </div>
<?php } else { ?>
  <div class="form-group">
    <div class="col-sm-6">
      <?php if (!ini_get('file_uploads')) {?>
        <div class="alert alert-danger"><?php echo smartyTranslate(array('s'=>'File uploads have been turned off. Please ask your webhost to enable file uploads (%s).','sprintf'=>array('<code>file_uploads = on</code>')),$_smarty_tpl);?>
</div>
      <?php } else { ?>
        <input id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
" type="file"
               name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true);
if (isset($_smarty_tpl->tpl_vars['multiple']->value) && $_smarty_tpl->tpl_vars['multiple']->value) {?>[]<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['multiple']->value) && $_smarty_tpl->tpl_vars['multiple']->value) {?> multiple="multiple"<?php }?>
               class="d-none"/>
        <div class="dummyfile input-group">
          <input id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-name" type="text" name="filename" readonly/>

          <span class="input-group-btn">

          <button id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
            <i class="icon-folder-open"></i> <?php if (isset($_smarty_tpl->tpl_vars['multiple']->value) && $_smarty_tpl->tpl_vars['multiple']->value) {
echo smartyTranslate(array('s'=>'Add files'),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'Add file'),$_smarty_tpl);
}?>
          </button>

            <?php if ((!isset($_smarty_tpl->tpl_vars['multiple']->value) || !$_smarty_tpl->tpl_vars['multiple']->value) && isset($_smarty_tpl->tpl_vars['files']->value) && count($_smarty_tpl->tpl_vars['files']->value) == 1 && isset($_smarty_tpl->tpl_vars['files']->value[0]['download_url'])) {?>
              <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['files']->value[0]['download_url'], ENT_QUOTES, 'UTF-8', true);?>
" class="btn btn-default">
              <i class="icon-cloud-download"></i>
                <?php if (isset($_smarty_tpl->tpl_vars['size']->value)) {
echo smartyTranslate(array('s'=>'Download current file (%skb)','sprintf'=>$_smarty_tpl->tpl_vars['size']->value),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'Download current file'),$_smarty_tpl);
}?>
            </a>
            <?php }?>
        </span>
        </div>
      <?php }?>
    </div>
  </div>
  <?php echo '<script'; ?>
 type="text/javascript">
    <?php if (isset($_smarty_tpl->tpl_vars['multiple']->value) && isset($_smarty_tpl->tpl_vars['max_files']->value)) {?>
    var <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
_max_files = <?php echo $_smarty_tpl->tpl_vars['max_files']->value-count($_smarty_tpl->tpl_vars['files']->value);?>
;
    <?php }?>

    $(document).ready(function () {
      $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-selectbutton').click(function (e) {
        $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').trigger('click');
      });

      $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-name').click(function (e) {
        $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').trigger('click');
      });

      $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-name').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
      });

      $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-name').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
      });

      $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-name').on('drop', function (e) {
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
')[0].files = files;
        $(this).val(files[0].name);
      });

      $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').change(function (e) {
        if ($(this)[0].files !== undefined) {
          var files = $(this)[0].files;
          var name = '';

          $.each(files, function (index, value) {
            name += value.name + ', ';
          });

          $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-name').val(name.slice(0, -2));
        }
        else // Internet Explorer 9 Compatibility
        {
          var name = $(this).val().split(/[\\/]/);
          $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-name').val(name[name.length - 1]);
        }
      });

      if (typeof <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
_max_files !== 'undefined') {
        $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').closest('form').on('submit', function (e) {
          if ($('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
')[0].files.length > <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
_max_files) {
            e.preventDefault();
            alert('<?php echo smartyTranslate(array('s'=>sprintf('You can upload a maximum of %s files',$_smarty_tpl->tpl_vars['max_files']->value)),$_smarty_tpl);?>
');
          }
        });
      }
    });
  <?php echo '</script'; ?>
>
<?php }
}
}
