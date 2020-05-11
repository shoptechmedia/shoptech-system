<?php
/* Smarty version 3.1.31, created on 2020-04-21 11:00:22
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/specific_price_rule/helpers/form/form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5e9ea816c0f6a2_11273676',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a195bf1f21e2cbd67e03ff48210bda61033533d5' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/specific_price_rule/helpers/form/form.tpl',
      1 => 1585579594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ea816c0f6a2_11273676 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3105718345e9ea816bd6f00_06171492', "other_fieldsets");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21050095845e9ea816bf8290_85533245', "script");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/form/form.tpl");
}
/* {block "other_fieldsets"} */
class Block_3105718345e9ea816bd6f00_06171492 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'other_fieldsets' => 
  array (
    0 => 'Block_3105718345e9ea816bd6f00_06171492',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="conditions">
	<div id="condition_group_list"></div>
</div>

<a class="btn btn-default" href="#" id="add_condition_group">
	<i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Add a new condition group'),$_smarty_tpl);?>

</a>
<div class="clearfix">&nbsp;</div>
<div class="panel" id="conditions-panel" style="display:none;">
	<h3><i class="icon-tasks"></i> <?php echo smartyTranslate(array('s'=>'Conditions'),$_smarty_tpl);?>
</h3>
	<div class="form-group">
		<label for="id_category" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Category'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div class="col-lg-8">
				<select id="id_category" name="id_category">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
					<option value="<?php echo intval($_smarty_tpl->tpl_vars['category']->value['id_category']);?>
">(<?php echo intval($_smarty_tpl->tpl_vars['category']->value['id_category']);?>
) <?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
			<div class="col-lg-1">
				<a class="btn btn-default" href="#" id="add_condition_category">
					<i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Add condition'),$_smarty_tpl);?>

				</a>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="id_manufacturer" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Manufacturer'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div class="col-lg-8">
				<select id="id_manufacturer" name="id_manufacturer">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['manufacturers']->value, 'manufacturer');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->value) {
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'];?>
"><?php echo $_smarty_tpl->tpl_vars['manufacturer']->value['name'];?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
			<div class="col-lg-1">
				<a class="btn btn-default" href="#" id="add_condition_manufacturer">
					<i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Add condition'),$_smarty_tpl);?>

				</a>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="id_supplier" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Supplier'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div class="col-lg-8">
				<select id="id_supplier" name="id_supplier">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['suppliers']->value, 'supplier');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['supplier']->value) {
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['supplier']->value['id_supplier'];?>
"><?php echo $_smarty_tpl->tpl_vars['supplier']->value['name'];?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
			<div class="col-lg-1">
				<a class="btn btn-default" href="#" id="add_condition_supplier">
					<i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Add condition'),$_smarty_tpl);?>

				</a>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="id_attribute_group" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Attributes'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div class="col-lg-4">
				<select id="id_attribute_group">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['attributes_group']->value, 'attribute_group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['attribute_group']->value) {
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['attribute_group']->value['id_attribute_group'];?>
"><?php echo $_smarty_tpl->tpl_vars['attribute_group']->value['name'];?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
			<div class="col-lg-4">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['attributes_group']->value, 'attribute_group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['attribute_group']->value) {
?>
					<select class="id_attribute" style="display:none;" id="id_attribute_<?php echo $_smarty_tpl->tpl_vars['attribute_group']->value['id_attribute_group'];?>
">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['attribute_group']->value['attributes'], 'attribute');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->value) {
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['attribute']->value['id_attribute'];?>
"><?php echo $_smarty_tpl->tpl_vars['attribute']->value['name'];?>
</option>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					</select>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</div>
			<div class="col-lg-1">
				<a class="btn btn-default" href="#" id="add_condition_attribute">
					<i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Add condition'),$_smarty_tpl);?>

				</a>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="id_feature" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Features'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div class="col-lg-4">
				<select id="id_feature">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['features']->value, 'feature');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->value) {
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['feature']->value['id_feature'];?>
"><?php echo $_smarty_tpl->tpl_vars['feature']->value['name'];?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</div>
			<div class="col-lg-4">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['features']->value, 'feature');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->value) {
?>
					<select class="id_feature_value" style="display:none;" id="id_feature_<?php echo $_smarty_tpl->tpl_vars['feature']->value['id_feature'];?>
">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['feature']->value['values'], 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id_feature_value'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['value'];?>
</option>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					</select>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</div>
			<div class="col-lg-1">
				<a class="btn btn-default" href="#" id="add_condition_feature">
					<i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Add condition'),$_smarty_tpl);?>

				</a>
			</div>
		</div>
	</div>
<?php if (!$_smarty_tpl->tpl_vars['is_multishop']->value) {?>
	<input type="hidden" name="id_shop" value="1" />
<?php }?>
</div>
<?php
}
}
/* {/block "other_fieldsets"} */
/* {block "script"} */
class Block_21050095845e9ea816bf8290_85533245 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'script' => 
  array (
    0 => 'Block_21050095845e9ea816bf8290_85533245',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

var current_id_condition_group = 0;
var last_condition_group = 0;
var conditions = new Array();

function toggle_condition_group(id_condition_group)
{
	$('.condition_group').removeClass('alert-info');
	$('.condition_group > table').removeClass('alert-info');
	$('#condition_group_'+id_condition_group+' > table').addClass('alert-info');
	$('#condition_group_'+id_condition_group).addClass('alert-info');
	current_id_condition_group = id_condition_group;
}

function add_condition(id_condition_group, type, value)
{
	var id_condition = id_condition_group+'_'+type+'_'+value;
	if (typeof conditions[id_condition] != 'undefined')
		return false;
	var condition = new Array();
	condition.type = type;
	condition.value = value;
	condition.id_condition_group = id_condition_group;
	conditions[id_condition] = condition;
	return id_condition;
}

function delete_condition(condition)
{
	delete conditions[condition];

	to_delete = $('#'+condition).prev();
	if ($(to_delete).children().hasClass('btn_delete_condition'))
		$(to_delete).remove();
	else
		$('#'+condition).next().remove();

	$('#'+condition).remove();
	return false;
}

function new_condition_group()
{
	$('#conditions-panel').show();
	var html = '';

	if (last_condition_group > 0)
		html += '<div class="row condition_separator text-center"><?php echo smartyTranslate(array('s'=>'OR'),$_smarty_tpl);?>
</div><div class="clearfix">&nbsp;</div>';

	last_condition_group++;
	html += '<div id="condition_group_'+last_condition_group+'" class="panel condition_group alert-info"><h3><i class="icon-tasks"></i> <?php echo smartyTranslate(array('s'=>'Condition group'),$_smarty_tpl);?>
 '+last_condition_group+'</h3>';
		html += '<table class="table alert-info"><thead><tr><th class="fixed-width-md"><span class="title_box"><?php echo smartyTranslate(array('s'=>'Type'),$_smarty_tpl);?>
</span></th><th><span class="title_box"><?php echo smartyTranslate(array('s'=>'Value'),$_smarty_tpl);?>
</span></th><th></th></tr></thead><tbody></tbody></table>';
		html += '</div>';
	$('#condition_group_list').append(html);
	toggle_condition_group(last_condition_group);
}

function appendConditionToGroup(html)
{
	if ($('#condition_group_'+current_id_condition_group+' table tbody tr').length > 0)
		$('#condition_group_'+current_id_condition_group+' table tbody').append('<tr><td class="text-center btn_delete_condition" colspan="3"><b><?php echo smartyTranslate(array('s'=>'AND','js'=>1),$_smarty_tpl);?>
</b></td></tr>');
	$('#condition_group_'+current_id_condition_group+' table tbody').append(html);
}

$(document).ready(function() {
	$('#leave_bprice_on').click(function() {
		if (this.checked)
			$('#price').attr('disabled', 'disabled');
		else
			$('#price').removeAttr('disabled');
	});

	$('#specific_price_rule_form').live('submit', function(e) {
		var html = '';
		for (i in conditions)
			html += '<input type="hidden" name="condition_group_'+conditions[i].id_condition_group+'[]" value="'+conditions[i].type+'_'+conditions[i].value+'" />';
		$('#conditions').append(html);
	});

	$('#id_feature').change(function() {
		$('.id_feature_value').hide();
		$('#id_feature_'+$(this).val()).show();
	});

	$('#id_attribute_group').change(function() {
		$('.id_attribute').hide();
		$('#id_attribute_'+$(this).val()).show();
	});

	$('#add_condition_category').click(function() {
		var id_condition = add_condition(current_id_condition_group, 'category', $('#id_category option:selected').val());
		if (!id_condition)
			return false;

		var html = '<tr id="'+id_condition+'"><td><?php echo smartyTranslate(array('s'=>'Category'),$_smarty_tpl);?>
</td><td>'+$('#id_category option:selected').html()+'</td><td><a href="#" onclick="delete_condition(\''+id_condition+'\');" class="btn btn-default"><i class="icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
</a></td></tr>';
		appendConditionToGroup(html);

		return false;
	});

	$('#add_condition_manufacturer').click(function() {
		var id_condition = add_condition(current_id_condition_group, 'manufacturer', $('#id_manufacturer option:selected').val());
		if (!id_condition)
			return false;

		var html = '<tr id="'+id_condition+'"><td><?php echo smartyTranslate(array('s'=>'Manufacturer'),$_smarty_tpl);?>
</td><td>'+$('#id_manufacturer option:selected').html()+'</td><td><a href="#" onclick="delete_condition(\''+id_condition+'\');" class="btn btn-default"><i class="icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
</a></td></tr>';
		appendConditionToGroup(html);

		return false;
	});

	$('#add_condition_supplier').click(function() {
		var id_condition = add_condition(current_id_condition_group, 'supplier', $('#id_supplier option:selected').val());
		if (!id_condition)
			return false;

		var html = '<tr id="'+id_condition+'"><td><?php echo smartyTranslate(array('s'=>'Supplier'),$_smarty_tpl);?>
</td><td>'+$('#id_supplier option:selected').html()+'</td><td><a href="#" onclick="delete_condition(\''+id_condition+'\');" class="btn btn-default"><i class="icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
</a></td></tr>';
		appendConditionToGroup(html);

		return false;
	});

	$('#add_condition_attribute').click(function() {
		var id_condition = add_condition(current_id_condition_group, 'attribute', $('#id_attribute_'+$('#id_attribute_group option:selected').val()+' option:selected').val());
		if (!id_condition)
			return false;

		var html = '<tr id="'+id_condition+'"><td><?php echo smartyTranslate(array('s'=>'Attribute'),$_smarty_tpl);?>
</td><td>'+$('#id_attribute_group option:selected').html()+': '+$('#id_attribute_'+$('#id_attribute_group option:selected').val()+' option:selected').html()+'</td><td><a href="#" onclick="delete_condition(\''+id_condition+'\');" class="btn btn-default"><i class="icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
</a></td></tr>';
		appendConditionToGroup(html);

		return false;
	});

	$('#add_condition_feature').click(function() {
		var id_condition = add_condition(current_id_condition_group, 'feature', $('#id_feature_'+$('#id_feature option:selected').val()+' option:selected').val());
		if (!id_condition)
			return false;

		var html = '<tr id="'+id_condition+'"><td><?php echo smartyTranslate(array('s'=>'Feature'),$_smarty_tpl);?>
</td><td>'+$('#id_feature option:selected').html()+': '+$('#id_feature_'+$('#id_feature option:selected').val()+' option:selected').html()+'</td><td><a href="#" onclick="delete_condition(\''+id_condition+'\');" class="btn btn-default"><i class="icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
</a></td></tr>';
		appendConditionToGroup(html);

		return false;
	});

	$('#add_condition_group').click(function() {
		new_condition_group();
		return false;
	});

	$('.condition_group').live('click', function() {
		var id = this.id.split('_');
		toggle_condition_group(id[2]);
		return false;
	});

	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['conditions']->value, 'condition_group', false, 'id_group_condition');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id_group_condition']->value => $_smarty_tpl->tpl_vars['condition_group']->value) {
?>
		new_condition_group();
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['condition_group']->value, 'condition');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['condition']->value) {
?>
			<?php if ($_smarty_tpl->tpl_vars['condition']->value['type'] == 'attribute') {?>
				$('#id_attribute_group option[value="<?php echo $_smarty_tpl->tpl_vars['condition']->value['id_attribute_group'];?>
"]').attr('selected', true);
				$('#id_attribute_<?php echo $_smarty_tpl->tpl_vars['condition']->value['id_attribute_group'];?>
 option[value="<?php echo $_smarty_tpl->tpl_vars['condition']->value['value'];?>
"]').attr('selected', true);
			<?php } elseif ($_smarty_tpl->tpl_vars['condition']->value['type'] == 'feature') {?>
				$('#id_feature option[value="<?php echo $_smarty_tpl->tpl_vars['condition']->value['id_feature'];?>
"]').attr('selected', true);
				$('#id_feature_<?php echo $_smarty_tpl->tpl_vars['condition']->value['id_feature'];?>
 option[value="<?php echo $_smarty_tpl->tpl_vars['condition']->value['value'];?>
"]').attr('selected', true);
			<?php } else { ?>
				$('#id_<?php echo $_smarty_tpl->tpl_vars['condition']->value['type'];?>
 option[value="<?php echo $_smarty_tpl->tpl_vars['condition']->value['value'];?>
"]').attr('selected', true);
			<?php }?>
			$('#add_condition_<?php echo $_smarty_tpl->tpl_vars['condition']->value['type'];?>
').click();
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	$('#id_attribute_group').change();
	$('#id_feature').change();
});
<?php
}
}
/* {/block "script"} */
}
