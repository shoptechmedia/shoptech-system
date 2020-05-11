<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:03:39
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules_positions/list_modules.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ffa5b9b0780_31590787',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a30711d6d64a0f23a02cbe8445d2311b92edcdc3' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/modules_positions/list_modules.tpl',
      1 => 1587542618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ffa5b9b0780_31590787 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>


<?php echo '<script'; ?>
 type="text/javascript">
	var come_from = 'AdminModulesPositions';
<?php echo '</script'; ?>
>

<div><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10431288705e9ffa5b925805_39018340', "leadin");
?>
</div>

<?php if (!$_smarty_tpl->tpl_vars['can_move']->value) {?>
					<p class="alert alert-warning">
						<?php echo smartyTranslate(array('s'=>'If you want to order/move the following data, please select a shop from the shop list.'),$_smarty_tpl);?>

					</p>
<?php }?>

<div class="row">
	<div class="col-lg-9">
		<div class="">
			<form class="panel well form-horizontal" id="position_filer">
				<div class="row">
					<div class="form-group col-lg-6 col-sm-12">
						<div class="col-lg-7">
							<select id="show_modules" class="filter" style="width: 100%;">
								<option value="all"><?php echo smartyTranslate(array('s'=>'Show'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'All modules'),$_smarty_tpl);?>
&nbsp;</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['modules']->value, 'module');
$_smarty_tpl->tpl_vars['module']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->iteration++;
$__foreach_module_0_saved = $_smarty_tpl->tpl_vars['module'];
?>
									<option value="<?php echo intval($_smarty_tpl->tpl_vars['module']->value->id);?>
"<?php if ($_smarty_tpl->tpl_vars['display_key']->value == $_smarty_tpl->tpl_vars['module']->value->id) {?> selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value->displayName, ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
$_smarty_tpl->tpl_vars['module'] = $__foreach_module_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
						</div>
					</div>
					<div class="form-group col-lg-6 col-sm-12">
						<label class="control-label col-lg-offset-1 col-lg-4" style="text-align: left"><?php echo smartyTranslate(array('s'=>'Search for a hook'),$_smarty_tpl);?>
</label>
						<div class="col-lg-7">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon icon-search"></i></div>
								<input type="text" class="form-control" id="hook_search" name="hook_search" placeholder="">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
							<p class="checkbox">
								<label class="control-label" for="hook_position">
									<input type="checkbox" id="hook_position"/>
									<?php echo smartyTranslate(array('s'=>'Display non-positionable hooks'),$_smarty_tpl);?>

								</label>
							</p>
					</div>
				</div>
			</form>
			<div id="modulePosition">
				<form method="post" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_submit']->value, ENT_QUOTES, 'UTF-8', true);?>
" >
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hooks']->value, 'hook');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['hook']->value) {
?>
					<section class="mt-4 card <?php if ($_smarty_tpl->tpl_vars['hook']->value['position'] == 0) {?>hook_position<?php }?>" <?php if ($_smarty_tpl->tpl_vars['hook']->value['position'] == 0) {?>style="display:none;"<?php }?>>
						<a name="<?php echo $_smarty_tpl->tpl_vars['hook']->value['name'];?>
"></a>
						<header class="card-header">
							<span class="card-title"><?php echo $_smarty_tpl->tpl_vars['hook']->value['name'];?>
</span><br/>

							<span class="badge badge-info ml-auto">
								<?php if ($_smarty_tpl->tpl_vars['hook']->value['module_count'] && $_smarty_tpl->tpl_vars['can_move']->value) {?>
								<input type="checkbox" id="Ghook<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
" onclick="hookCheckboxes(<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
, 0, this)"/>
								<?php }?>
								<?php echo $_smarty_tpl->tpl_vars['hook']->value['module_count'];?>
 <?php if ($_smarty_tpl->tpl_vars['hook']->value['module_count'] > 1) {
echo smartyTranslate(array('s'=>'Modules'),$_smarty_tpl);
} else {
echo smartyTranslate(array('s'=>'Module'),$_smarty_tpl);
}?>
							</span><br/>
						</header>

						<?php if (!empty($_smarty_tpl->tpl_vars['hook']->value['description'])) {?>
						<div class="panel-heading">
							<span class="card-subtitle"><?php echo $_smarty_tpl->tpl_vars['hook']->value['description'];?>
</span>
						</div>
						<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['hook']->value['module_count']) {?>
						<section class="module_list">
						<ul class="list-unstyled<?php if (count($_smarty_tpl->tpl_vars['hook']->value['modules']) > 1) {?> sortable<?php }?>">

							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hook']->value['modules'], 'module', false, 'position');
$_smarty_tpl->tpl_vars['module']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['position']->value => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->iteration++;
$__foreach_module_2_saved = $_smarty_tpl->tpl_vars['module'];
?>
							<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])) {?>
							<li id="<?php echo intval($_smarty_tpl->tpl_vars['hook']->value['id_hook']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['module']->value['instance']->id);?>
" class="card-body row module_position_<?php echo intval($_smarty_tpl->tpl_vars['module']->value['instance']->id);?>
 module_list_item<?php if ($_smarty_tpl->tpl_vars['can_move']->value && $_smarty_tpl->tpl_vars['hook']->value['module_count'] >= 2) {?> draggable<?php }?>">
								<div class="px-1">
									<input type="checkbox" id="mod<?php echo intval($_smarty_tpl->tpl_vars['hook']->value['id_hook']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['module']->value['instance']->id);?>
" class="modules-position-checkbox hook<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
" onclick="hookCheckboxes(<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
, 1, this)" name="unhooks[]" value="<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
_<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
"/>
								</div>
								<?php if (!$_smarty_tpl->tpl_vars['display_key']->value) {?>
								<div class="px-1 module_col_position<?php if ($_smarty_tpl->tpl_vars['can_move']->value && $_smarty_tpl->tpl_vars['hook']->value['module_count'] >= 2) {?> dragHandle<?php }?>" id="td_<?php echo intval($_smarty_tpl->tpl_vars['hook']->value['id_hook']);?>
_<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
">
									<span class="positions"><?php echo $_smarty_tpl->tpl_vars['module']->iteration;?>
</span>
									
								</div>
								<?php }?>
								<div class="px-2">
									<img width="57" src="../modules/<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->name;?>
/logo.png" alt="<?php echo stripslashes($_smarty_tpl->tpl_vars['module']->value['instance']->name);?>
" />
								</div>
								<div class="px-3">
									<span class="module_name">
										<?php echo stripslashes($_smarty_tpl->tpl_vars['module']->value['instance']->displayName);?>
 <?php if ($_smarty_tpl->tpl_vars['module']->value['instance']->version) {?>
										<small class="text-muted">&nbsp;-&nbsp;v<?php if (intval($_smarty_tpl->tpl_vars['module']->value['instance']->version) == $_smarty_tpl->tpl_vars['module']->value['instance']->version) {
echo sprintf('%.1f',$_smarty_tpl->tpl_vars['module']->value['instance']->version);
} else {
echo floatval($_smarty_tpl->tpl_vars['module']->value['instance']->version);
}?></small><?php }?>
									</span>
									<div class="module_description"><?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->description;?>
</div>
								</div>
								<div class="ml-auto">
									<!-- <div class="lab_modules_positions" for="mod<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
_<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
"></div> -->
									<div class="btn-group">
										<a class="btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;id_module=<?php echo intval($_smarty_tpl->tpl_vars['module']->value['instance']->id);?>
&amp;id_hook=<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
&amp;editGraft<?php if ($_smarty_tpl->tpl_vars['display_key']->value) {?>&amp;show_modules=<?php echo $_smarty_tpl->tpl_vars['display_key']->value;
}?>&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
">
											<i class="icon-pencil"></i>
											<?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>

										</a>
										<a class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>&nbsp;
										</a>
										<ul class="dropdown-menu">
											<li>
												<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;id_module=<?php echo intval($_smarty_tpl->tpl_vars['module']->value['instance']->id);?>
&amp;id_hook=<?php echo $_smarty_tpl->tpl_vars['hook']->value['id_hook'];?>
&amp;deleteGraft<?php if ($_smarty_tpl->tpl_vars['display_key']->value) {?>&amp;show_modules=<?php echo $_smarty_tpl->tpl_vars['display_key']->value;
}?>&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
">
													<i class="icon-minus-sign-alt"></i>
													<?php echo smartyTranslate(array('s'=>'Unhook'),$_smarty_tpl);?>

												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							<?php }?>
						<?php
$_smarty_tpl->tpl_vars['module'] = $__foreach_module_2_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

						</ul>
						</section>
	<?php } else { ?>
							<!-- <p><?php echo smartyTranslate(array('s'=>'No module was found for this hook.'),$_smarty_tpl);?>
</p> -->
	<?php }?>
					</section>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					<div id="unhook_button_position_bottom">
						<button type="submit" class="btn btn-default" name="unhookform">
							<i class="icon-minus-sign-alt"></i>
							<?php echo smartyTranslate(array('s'=>'Unhook the selection'),$_smarty_tpl);?>

						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="panel">
			<h3><i class="icon-eye-open"></i> <?php echo smartyTranslate(array('s'=>'Live Edit'),$_smarty_tpl);?>
</h3>
			<?php if ($_smarty_tpl->tpl_vars['live_edit']->value) {?>
				<p><?php echo smartyTranslate(array('s'=>'You have to select a shop to use Live Edit'),$_smarty_tpl);?>
</p>
			<?php } else { ?>
				<p><?php echo smartyTranslate(array('s'=>'Click here to be redirected to the front office of your shop where you can move and delete modules directly.'),$_smarty_tpl);?>
</p>
					<a class="btn btn-default _blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_live_edit']->value, ENT_QUOTES, 'UTF-8', true);?>
">
						<i class="icon-edit"></i>
						<?php echo smartyTranslate(array('s'=>'Run Live Edit'),$_smarty_tpl);?>

					</a>
			<?php }?>
		</div>
		<div class="panel" id="modules-position-selection-panel">
			<h3><i class="icon-check"></i> <?php echo smartyTranslate(array('s'=>'Selection'),$_smarty_tpl);?>
</h3>
			<p>
				<span id="modules-position-single-selection"><?php echo smartyTranslate(array('s'=>'1 module selected'),$_smarty_tpl);?>
</span>
				<span id="modules-position-multiple-selection">
					<span id="modules-position-selection-count"></span> <?php echo smartyTranslate(array('s'=>'modules selected'),$_smarty_tpl);?>

				</span>
			</p>
			<div class="text-center">
				<button class="btn btn-default"><i class="icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Unhook the selection'),$_smarty_tpl);?>
</button>
			</div>
		</div>
	</div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
	$('.sortable').sortable({
		forcePlaceholderSize: true
	}).bind('sortupdate', function(e, ui) {
		var ids = ui.item.attr('id').split('_');
		var way = (ui.start_index < ui.end_index)? 1 : 0;
		var data = ids[0]+'[]=';

		$.each(e.target.children, function(index, element) {
			data += '&'+ids[0]+'[]='+$(element).attr('id');
		});

		$.ajax({
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			async: false,
			url: currentIndex + '&token=' + token + '&' + 'rand=' + new Date().getTime(),
			data: data + '&action=updatePositions&id_hook='+ids[0]+'&id_module='+ids[1]+'&way='+way+'&ajax=1' ,
			success: function(data) {
				start = 0;

				$.each(e.target.children, function(index, element) {
					$(element).find('.positions').html(++start);
				});

				showSuccessMessage(update_success_msg);
			}
		});
	});
<?php echo '</script'; ?>
>
<?php }
/* {block "leadin"} */
class Block_10431288705e9ffa5b925805_39018340 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'leadin' => 
  array (
    0 => 'Block_10431288705e9ffa5b925805_39018340',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "leadin"} */
}
