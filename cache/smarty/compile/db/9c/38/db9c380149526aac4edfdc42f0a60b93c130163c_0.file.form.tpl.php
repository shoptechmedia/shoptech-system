<?php
/* Smarty version 3.1.31, created on 2020-04-22 11:59:26
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/performance/helpers/form/form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0076e89cf15_39320368',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db9c380149526aac4edfdc42f0a60b93c130163c' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/performance/helpers/form/form.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0076e89cf15_39320368 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17823292805ea0076e84cee4_93265486', "input_row");
?>


	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10132713515ea0076e85af04_47748346', "input");
?>


	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19275564475ea0076e85fb50_37840474', "description");
?>


	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9771039985ea0076e865756_92583517', "other_input");
?>


	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1593062695ea0076e8947a3_85487907', "script");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/form/form.tpl");
}
/* {block "input_row"} */
class Block_17823292805ea0076e84cee4_93265486 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input_row' => 
  array (
    0 => 'Block_17823292805ea0076e84cee4_93265486',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'TB_CACHE_SYSTEM') {?>
<div id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_wrapper"<?php if ($_smarty_tpl->tpl_vars['cacheDisabled']->value) {?> style="display:none"<?php }?>><?php }?>
	<?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'smarty_caching_type' || $_smarty_tpl->tpl_vars['input']->value['name'] == 'smarty_clear_cache') {?>
	<div id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_wrapper"<?php if (isset($_smarty_tpl->tpl_vars['fields_value']->value['smarty_cache']) && !$_smarty_tpl->tpl_vars['fields_value']->value['smarty_cache']) {?> style="display:none"<?php }?>><?php }?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

		<?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'TB_CACHE_SYSTEM' || $_smarty_tpl->tpl_vars['input']->value['name'] == 'smarty_caching_type' || $_smarty_tpl->tpl_vars['input']->value['name'] == 'smarty_clear_cache') {?></div><?php }?>
	<?php
}
}
/* {/block "input_row"} */
/* {block "input"} */
class Block_10132713515ea0076e85af04_47748346 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input' => 
  array (
    0 => 'Block_10132713515ea0076e85af04_47748346',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php if ($_smarty_tpl->tpl_vars['input']->value['type'] == 'radio' && $_smarty_tpl->tpl_vars['input']->value['name'] == 'combination' && $_smarty_tpl->tpl_vars['input']->value['disabled']) {?>
			<div class="alert alert-warning">
				<?php echo smartyTranslate(array('s'=>'This feature cannot be disabled because it is currently in use.'),$_smarty_tpl);?>

			</div>
		<?php }?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

	<?php
}
}
/* {/block "input"} */
/* {block "description"} */
class Block_19275564475ea0076e85fb50_37840474 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'description' => 
  array (
    0 => 'Block_19275564475ea0076e85fb50_37840474',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

		<?php if ($_smarty_tpl->tpl_vars['input']->value['type'] == 'radio' && $_smarty_tpl->tpl_vars['input']->value['name'] == 'combination') {?>
			<ul>
				<li><?php echo smartyTranslate(array('s'=>'Combinations tab on product page'),$_smarty_tpl);?>
</li>
				<li><?php echo smartyTranslate(array('s'=>'Value'),$_smarty_tpl);?>
</li>
				<li><?php echo smartyTranslate(array('s'=>'Attribute'),$_smarty_tpl);?>
</li>
			</ul>
		<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type'] == 'radio' && $_smarty_tpl->tpl_vars['input']->value['name'] == 'feature') {?>
			<ul>
				<li><?php echo smartyTranslate(array('s'=>'Features tab on product page'),$_smarty_tpl);?>
</li>
				<li><?php echo smartyTranslate(array('s'=>'Feature'),$_smarty_tpl);?>
</li>
				<li><?php echo smartyTranslate(array('s'=>'Feature value'),$_smarty_tpl);?>
</li>
			</ul>
		<?php }?>
	<?php
}
}
/* {/block "description"} */
/* {block "other_input"} */
class Block_9771039985ea0076e865756_92583517 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'other_input' => 
  array (
    0 => 'Block_9771039985ea0076e865756_92583517',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php if ($_smarty_tpl->tpl_vars['key']->value == 'memcachedServers') {?>
			<div id="memcachedServers">
				<div id="formMemcachedServer">
					<div class="form-group">
						<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'IP Address'),$_smarty_tpl);?>
 </label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="memcachedIp"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Port'),$_smarty_tpl);?>
 </label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="memcachedPort" value="11211"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Weight'),$_smarty_tpl);?>
 </label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="memcachedWeight" value="1"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-9 col-lg-push-3">
							<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Add Server'),$_smarty_tpl);?>
" name="submitAddMemcachedServer" class="btn btn-default"/>
							<input type="button" value="<?php echo smartyTranslate(array('s'=>'Test Server'),$_smarty_tpl);?>
" id="testMemcachedServer" class="btn btn-default"/>
						</div>
					</div>
				</div>
				<?php if (isset($_smarty_tpl->tpl_vars['memcached_servers']->value) && $_smarty_tpl->tpl_vars['memcached_servers']->value) {?>
					<div class="form-group">
						<table class="table">
							<thead>
							<tr>
								<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</span></th>
								<th><span class="title_box"><?php echo smartyTranslate(array('s'=>'IP address'),$_smarty_tpl);?>
</span></th>
								<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'Port'),$_smarty_tpl);?>
</span></th>
								<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'Weight'),$_smarty_tpl);?>
</span></th>
								<th>&nbsp;</th>
							</tr>
							</thead>
							<tbody>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['memcached_servers']->value, 'server');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['server']->value) {
?>
								<tr>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['id_memcached_server'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['ip'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['port'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['weight'];?>
</td>
									<td>
										<a class="btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;deleteMemcachedServer=<?php echo $_smarty_tpl->tpl_vars['server']->value['id_memcached_server'];?>
" onclick="if (!confirm('<?php echo smartyTranslate(array('s'=>'Do you really want to remove the server %s:%s','sprintf'=>array($_smarty_tpl->tpl_vars['server']->value['ip'],$_smarty_tpl->tpl_vars['server']->value['port']),'js'=>1),$_smarty_tpl);?>
')) {return false;}"><i class="icon-minus-sign-alt"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
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
				<?php }?>
			</div>
		<?php } elseif ($_smarty_tpl->tpl_vars['key']->value == 'redisServers') {?>
			<div id="redisServers">
				<div class="form-group">
					<div class="col-lg-9 col-lg-push-3">
						<button id="addRedisServer" class="btn btn-default" type="button">
							<i class="icon-plus-sign-alt"></i>&nbsp;<?php echo smartyTranslate(array('s'=>'Add server'),$_smarty_tpl);?>

						</button>
					</div>
				</div>
				<div id="formRedisServer" style="display:none;">
					<div class="form-group">
						<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'IP Address'),$_smarty_tpl);?>
 </label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="redisIp" value="127.0.0.1"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Port'),$_smarty_tpl);?>
 </label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="redisPort" value="6379"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Auth'),$_smarty_tpl);?>
 </label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="redisAuth" value=""/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Database ID'),$_smarty_tpl);?>
 </label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="redisDb" value="0"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-9 col-lg-push-3">
							<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Add Server'),$_smarty_tpl);?>
" name="submitAddRedisServer" class="btn btn-default"/>
							<input type="button" value="<?php echo smartyTranslate(array('s'=>'Test Server'),$_smarty_tpl);?>
" id="testRedisServer" class="btn btn-default"/>
						</div>
					</div>
				</div>
				<?php if (isset($_smarty_tpl->tpl_vars['redis_servers']->value) && $_smarty_tpl->tpl_vars['redis_servers']->value) {?>
					<div class="form-group">
						<table class="table">
							<thead>
							<tr>
								<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</span></th>
								<th><span class="title_box"><?php echo smartyTranslate(array('s'=>'IP address'),$_smarty_tpl);?>
</span></th>
								<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'Port'),$_smarty_tpl);?>
</span></th>
								<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'Auth'),$_smarty_tpl);?>
</span></th>
								<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'Db'),$_smarty_tpl);?>
</span></th>
								<th>&nbsp;</th>
							</tr>
							</thead>
							<tbody>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['redis_servers']->value, 'server');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['server']->value) {
?>
								<tr>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['id_redis_server'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['ip'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['port'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['auth'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['server']->value['db'];?>
</td>
									<td>
										<a class="btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;deleteRedisServer=<?php echo $_smarty_tpl->tpl_vars['server']->value['id_redis_server'];?>
" onclick="if (!confirm('<?php echo smartyTranslate(array('s'=>'Do you really want to remove the server %s:%s','sprintf'=>array($_smarty_tpl->tpl_vars['server']->value['ip'],$_smarty_tpl->tpl_vars['server']->value['port']),'js'=>1),$_smarty_tpl);?>
')) {return false;}"><i class="icon-minus-sign-alt"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
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
				<?php }?>
			</div>
		<?php } elseif ($_smarty_tpl->tpl_vars['key']->value === 'dynamicHooks') {?>
			<div class="table-responsive-row clearfix">
				<table class="table meta">
					<thead>
						<tr class="nodrag nodrop">
							<th class="title_box">
								<span class="title_box">
									<?php echo smartyTranslate(array('s'=>'Module name'),$_smarty_tpl);?>

								</span>
							</th>
							<th>
								<span class="title_box">
									<?php echo smartyTranslate(array('s'=>'Hooks'),$_smarty_tpl);?>

								</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['moduleSettings']->value, 'module', false, 'idModule');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['idModule']->value => $_smarty_tpl->tpl_vars['module']->value) {
?>
							<tr>
								<td>
									<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['displayName'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

								</td>
								<td>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['module']->value['hooks'], 'enabled', false, 'hookName');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['hookName']->value => $_smarty_tpl->tpl_vars['enabled']->value) {
?>
										&nbsp;
										<span
												style="cursor: pointer"
												class="dynamic-hook label label-<?php if ($_smarty_tpl->tpl_vars['enabled']->value) {?>success<?php } else { ?>danger<?php }?>"
												data-id-module="<?php echo intval($_smarty_tpl->tpl_vars['idModule']->value);?>
"
												data-hook-name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['hookName']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
												data-enabled="<?php if ($_smarty_tpl->tpl_vars['enabled']->value) {?>true<?php } else { ?>false<?php }?>">
											<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['hookName']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

										</span>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

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
		<?php } elseif ($_smarty_tpl->tpl_vars['key']->value === 'controllerList') {?>
			<div class="form-group">
				<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Controllers'),$_smarty_tpl);?>
</label>
				<div class="col-lg-9">
					<div class="well">
						<div>
							<?php echo smartyTranslate(array('s'=>'Please specify the controllers for which you would like to enable full page caching.'),$_smarty_tpl);?>
<br />
							<?php echo smartyTranslate(array('s'=>'Please input each controller name, separated by a comma (",").'),$_smarty_tpl);?>
<br />
							<?php echo smartyTranslate(array('s'=>'You can also click the controller name in the list below, and even make a multiple selection by keeping the CTRL key pressed while clicking, or choose a whole range of filename by keeping the SHIFT key pressed while clicking.'),$_smarty_tpl);?>
<br />
							<?php echo $_smarty_tpl->tpl_vars['controllerList']->value;?>

						</div>
					</div>
				</div>
			</div>
		<?php }?>
	<?php
}
}
/* {/block "other_input"} */
/* {block "script"} */
class Block_1593062695ea0076e8947a3_85487907 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'script' => 
  array (
    0 => 'Block_1593062695ea0076e8947a3_85487907',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


	function showMemcached() {
		if ($('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'CacheMemcache' || $('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'CacheMemcached') {
			$('#memcachedServers').css('display', $('#TB_CACHE_ENABLED_on').is(':checked') ? 'block' : 'none');
			$('#ps_cache_fs_directory_depth').closest('.form-group').hide();
			$('#redisServers').hide();
			$('#memcachedServers').show();

		}
		else if ($('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'CacheFs') {
			$('#memcachedServers').hide();
			$('#redisServers').hide();
			$('#ps_cache_fs_directory_depth').closest('.form-group').css('display', $('#TB_CACHE_ENABLED_on').is(':checked') ? 'block' : 'none');
		} else if ($('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'CacheRedis') {
			$('#redisServers').css('display', $('#TB_CACHE_ENABLED_on').is(':checked') ? 'block' : 'none');
			$('#ps_cache_fs_directory_depth').closest('.form-group').hide();
			$('#redisServers').show();
			$('#memcachedServers').hide();
		} else {
			$('#memcachedServers').hide();
			$('#redisServers').hide();
			$('#ps_cache_fs_directory_depth').closest('.form-group').hide();
		}
	}

	function processDynamicHook($elem) {
		if (window.dynamicHooksBlocked) {
			setTimeout(function() {
				processDynamicHook($elem);
			}, 100);

			return;
		}

		window.dynamicHooksBlocked = true;
		$.ajax({
			url: '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
',
			method: 'POST',
			data: {
				ajax: true,
				action: 'updateDynamicHooks',
				idModule: parseInt($elem.attr('data-id-module'), 10),
				hookName: $elem.attr('data-hook-name'),
				status: ($elem.attr('data-enabled') === 'true') ? 'false' : 'true'
			},
			dataType: 'JSON',
			success: function() {
				showSuccessMessage('<?php echo smartyTranslate(array('s'=>'Hook successfully updated','js'=>1),$_smarty_tpl);?>
');
				var newStatus = !($elem.attr('data-enabled') === 'true');
				$elem.attr('data-enabled', (newStatus ? 'true' : 'false'));
				if (newStatus) {
					$elem.removeClass('label-danger').addClass('label-success');
				} else {
					$elem.removeClass('label-success').addClass('label-danger');
				}
			},
			error: function() {
				showErrorMessage('<?php echo smartyTranslate(array('s'=>'There was a problem while updating the hook','js'=>1),$_smarty_tpl);?>
');
			},
			complete: function() {
				window.dynamicHooksBlocked = false;
			}
		});
	}

	function showDynamicHooks() {
		window.dynamicHooksBlocked = false;
		$('.dynamic-hook').each(function() {
			$(this).click(function() {
				processDynamicHook($(this));
			});
		});
	}

	function position_exception_textchange() {
		var obj = $(this);
		var shopID = obj.attr('id').replace(/\D/g, '');
		var list = obj.closest('form').find('#em_list_' + shopID);
		var values = obj.val().split(',');
		var len = values.length;

		list.find('option').prop('selected', false);
		for (var i = 0; i < len; i++) {
			list.find('option[value="' + $.trim(values[i]) + '"]').prop('selected', true);
		}
	}

	function position_exception_listchange() {
		var obj = $(this);
		var shopID = obj.attr('id').replace(/\D/g, '');
		var val = obj.val();
		var str = '';
		if (val) {
			str = val.join(', ');
		}
		obj.closest('form').find('#em_text_' + shopID).val(str);
	}

	$(document).ready(function () {

		showMemcached();

		showDynamicHooks();

		$('input[name="cache_active"]').change(function () {
			$('#TB_CACHE_SYSTEM_wrapper').css('display', ($(this).val() == 1) ? 'block' : 'none');
			showMemcached();

			if ($('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'CacheFs') {
				$('#ps_cache_fs_directory_depth').focus();
			}
		});

		$('input[name="TB_CACHE_SYSTEM"]').change(function () {
			$('#cache_up').val(1);
			showMemcached();

			if ($('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'CacheFs') {
				$('#ps_cache_fs_directory_depth').focus();
			}
		});

		$('input[name="smarty_cache"]').change(function () {
			$('#smarty_caching_type_wrapper').css('display', ($(this).val() == 1) ? 'block' : 'none');
			$('#smarty_clear_cache_wrapper').css('display', ($(this).val() == 1) ? 'block' : 'none');
		});

		$('#addMemcachedServer').click(function () {
			$('#formMemcachedServer').show();
			return false;
		});

		$('#testMemcachedServer').click(function () {
			var host = $('input:text[name=memcachedIp]').val();
			var port = $('input:text[name=memcachedPort]').val();
			var type = $('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'CacheMemcached' ? 'memcached' : 'memcache';
			if (host && port) {
				$.ajax({
					url: 'index.php',
					data: {
						controller: 'adminperformance',
						token: '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
',
						action: 'test_server',
						sHost: host,
						sPort: port,
						type: type,
						ajax: true
					},
					context: document.body,
					dataType: 'json',
					async: false,
					success: function (data) {
						if (data && $.isArray(data)) {
							var color = data[0] != 0 ? 'green' : 'red';
							
							$('input:text[name=memcachedIp]').css('background', color);
							$('input:text[name=memcachedPort]').css('background', color);
						}
					}
				});
			}
			return false;
		});

		$('#addRedisServer').click(function () {
			$('#formRedisServer').show();
			return false;
		});

		$('#testRedisServer').click(function () {
			var host = $('input:text[name=redisIp]').val();
			var port = $('input:text[name=redisPort]').val();
			var auth = $('input:text[name=redisAuth]').val();
			var db = $('input:text[name=redisDb]').val();
			var type = $('input[name="TB_CACHE_SYSTEM"]:radio:checked').val() == 'redis';
			if (host && port) {
				$.ajax({
					url: 'index.php',
					data: {
						controller: 'adminperformance',
						token: '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
',
						action: 'test_redis_server',
						sHost: host,
						sPort: port,
						sDb: db,
						sAuth: auth,
						type: type,
						ajax: true
					},
					context: document.body,
					dataType: 'json',
					success: function (data) {
						if (data && $.isArray(data)) {
							var color = data[0] != 0 ? 'lightgreen' : 'red';
							$('#formRedisServerStatus').show();
							$('input:text[name=redisIp]').css('background', color);
							$('input:text[name=redisPort]').css('background', color);
							$('input:text[name=redisAuth]').css('background', color);
							$('input:text[name=redisDb]').css('background', color);
						}
					}
				});
			}
			return false;
		});

		$('input[name="smarty_force_compile"], input[name="smarty_cache"], input[name="smarty_clear_cache"], input[name="smarty_caching_type"], input[name="smarty_console"], input[name="smarty_console_key"]').change(function () {
			$('#smarty_up').val(1);
		});

		$('input[name="combination"], input[name="feature"], input[name="customer_group"]').change(function () {
			$('#features_detachables_up').val(1);
		});

		$('input[name="_MEDIA_SERVER_1_"], input[name="_MEDIA_SERVER_2_"], input[name="_MEDIA_SERVER_3_"]').change(function () {
			$('#media_server_up').val(1);
		});

		$('input[name="PS_CIPHER_ALGORITHM"]').change(function () {
			$('#ciphering_up').val(1);
		});

		$('input[name="TB_CACHE_ENABLED"]').change(function () {
			$('#cache_up').val(1);
		});

		$('form[id="configuration_form"] input[id^="em_text_"]').each(function(){
			$(this).change(position_exception_textchange).change();
		});
		$('form[id="configuration_form"] select[id^="em_list_"]').each(function(){
			$(this).change(position_exception_listchange);
		});
	});
	<?php
}
}
/* {/block "script"} */
}
