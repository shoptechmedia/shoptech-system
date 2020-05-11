<?php
/* Smarty version 3.1.31, created on 2020-04-22 16:31:32
  from "/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/dashboard/helpers/view/view.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ea0473467dcc5_11345838',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd04af7340810b56800c791615ce3486373146918' => 
    array (
      0 => '/home/shoptech/public_html/beta/login888/themes/shoptech/template/controllers/dashboard/helpers/view/view.tpl',
      1 => 1585751258,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ea0473467dcc5_11345838 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
>
	var dashboard_ajax_url = '<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminDashboard');?>
';
	var adminstats_ajax_url = '<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminStats');?>
';
	var no_results_translation = '<?php echo smartyTranslate(array('s'=>'No result','js'=>1),$_smarty_tpl);?>
';
	var dashboard_use_push = '<?php echo intval($_smarty_tpl->tpl_vars['dashboard_use_push']->value);?>
';
	var read_more = '<?php echo smartyTranslate(array('s'=>'Read more','js'=>1),$_smarty_tpl);?>
';
<?php echo '</script'; ?>
>

<!-- ROW -->
<div class="row">
	<div class="col-xl-4 col-lg-12 col-md-12">
		<div class="card overflow-hidden">
			<div class="card-body">
				<h6 class="mb-3"><?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
</h6>
				<h4 class="mb-1"><span class="number-font counter"><?php echo $_smarty_tpl->tpl_vars['total_orders']->value;?>
</span></h4>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<div class="card overflow-hidden">
			<div class="card-body">
				<h6 class="mb-3"><?php echo smartyTranslate(array('s'=>'Visits'),$_smarty_tpl);?>
</h6>
				<h4 class="mb-1"><span class="number-font counter"><?php echo $_smarty_tpl->tpl_vars['visits']->value;?>
</span></h4>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<div class="card overflow-hidden">
			<div class="card-body">
				<h6 class="mb-3"><?php echo smartyTranslate(array('s'=>'Conversion Rate'),$_smarty_tpl);?>
</h6>
				<h4 class="mb-1"><span class="number-font counter"><?php echo $_smarty_tpl->tpl_vars['conversion']->value;?>
</span>%</h4>
			</div>
		</div>
	</div>
</div>
<!-- END ROW -->

<!-- ROW-1 -->
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-5 col-xl-4">
		<div class="card">
			<div class="card-body d-flex">
				<div class="card-order">
					<h6 class="mb-2"><?php echo smartyTranslate(array('s'=>'Total Sales'),$_smarty_tpl);?>
</h6>
					<h2 class="mb-1"><?php echo $_smarty_tpl->tpl_vars['CurrencySign']->value;?>
<span class="number-font counter"><?php echo $_smarty_tpl->tpl_vars['total_sales']->value;?>
</span></h2>
				</div>
				<div class="ml-auto">
					<span class="bg-primary-transparent icon-service text-primary"><i class="mdi mdi-account-multiple  fs-2"></i> </span>
				</div>
			</div>
		</div>
		<div class="card ">
			<div class="card-body d-flex">
				<div class="card-order">
					<h6 class="mb-2"><?php echo smartyTranslate(array('s'=>'In Cart'),$_smarty_tpl);?>
</h6>
					<h2 class="mb-1"><?php echo $_smarty_tpl->tpl_vars['CurrencySign']->value;?>
<span class="number-font counter"><?php echo $_smarty_tpl->tpl_vars['in_cart']->value;?>
</span></h2>
				</div>
				<div class="ml-auto">
					<span class="bg-secondary-transparent icon-service text-secondary"><i class="mdi mdi-cube  fs-2"></i> </span>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body d-flex">
				<div class="card-order">
					<h6 class="mb-2"><?php echo smartyTranslate(array('s'=>'Total Profit'),$_smarty_tpl);?>
</h6>
					<h2 class="mb-1"><?php echo $_smarty_tpl->tpl_vars['CurrencySign']->value;?>
<span class="number-font counter"><?php echo $_smarty_tpl->tpl_vars['total_profit']->value;?>
</span></h2>
				</div>
				<div class="ml-auto">
					<span class="bg-danger-transparent icon-service text-danger"><i class="mdi mdi-poll-box  fs-2"></i> </span>
				</div>
			</div>
		</div>
	</div><!-- COL END -->
	<div class="col-sm-12 col-md-12 col-lg-7 col-xl-8">
		<div class="card">
			<div class="card-header">
				<div class="card-title"><?php echo smartyTranslate(array('s'=>'Sales Statistics'),$_smarty_tpl);?>
</div>
				<div class="card-options">
					<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
				</div>
			</div>
			<div class="card-body">
				<div class="mb-0">
					<canvas id="barChart" class="overflow-hidden"></canvas>
				</div>
			</div>
		</div>
	</div><!-- COL END -->
</div>
<!-- ROW-1 END -->

<!-- ROW-5 -->
<div class="row">
	<div class="col-12 col-sm-12">
		<div class="card ">
			<div class="card-header">
				<div class="card-title mb-0"><?php echo smartyTranslate(array('s'=>'Best Selling Products'),$_smarty_tpl);?>
</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap mb-0">
						<thead>
							<tr>
								<th><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</th>
								<th><?php echo smartyTranslate(array('s'=>'Product'),$_smarty_tpl);?>
</th>
								<th><?php echo smartyTranslate(array('s'=>'Total Sold'),$_smarty_tpl);?>
</th>
								<th><?php echo smartyTranslate(array('s'=>'Total Price'),$_smarty_tpl);?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products_sold']->value, 'product');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
?>
							<tr>
								<td><?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
</td>
								<td class="number-font1"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['product']->value['totalQuantitySold'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['product']->value['totalPriceSold'];?>
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
		</div>
	</div><!-- COL END -->
</div><!-- ROW-5 END --><?php }
}
