{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<script>
	var dashboard_ajax_url = '{$link->getAdminLink('AdminDashboard')}';
	var adminstats_ajax_url = '{$link->getAdminLink('AdminStats')}';
	var no_results_translation = '{l s='No result' js=1}';
	var dashboard_use_push = '{$dashboard_use_push|intval}';
	var read_more = '{l s='Read more' js=1}';
</script>

<!-- ROW -->
<div class="row">
	<div class="col-xl-4 col-lg-12 col-md-12">
		<div class="card overflow-hidden">
			<div class="card-body">
				<h6 class="mb-3">{l s='Orders'}</h6>
				<h4 class="mb-1"><span class="number-font counter">{$total_orders}</span></h4>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<div class="card overflow-hidden">
			<div class="card-body">
				<h6 class="mb-3">{l s='Visits'}</h6>
				<h4 class="mb-1"><span class="number-font counter">{$visits}</span></h4>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<div class="card overflow-hidden">
			<div class="card-body">
				<h6 class="mb-3">{l s='Conversion Rate'}</h6>
				<h4 class="mb-1"><span class="number-font counter">{$conversion}</span>%</h4>
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
					<h6 class="mb-2">{l s='Total Sales'}</h6>
					<h2 class="mb-1">{$CurrencySign}<span class="number-font counter">{$total_sales}</span></h2>
				</div>
				<div class="ml-auto">
					<span class="bg-primary-transparent icon-service text-primary"><i class="mdi mdi-account-multiple  fs-2"></i> </span>
				</div>
			</div>
		</div>
		<div class="card ">
			<div class="card-body d-flex">
				<div class="card-order">
					<h6 class="mb-2">{l s='In Cart'}</h6>
					<h2 class="mb-1">{$CurrencySign}<span class="number-font counter">{$in_cart}</span></h2>
				</div>
				<div class="ml-auto">
					<span class="bg-secondary-transparent icon-service text-secondary"><i class="mdi mdi-cube  fs-2"></i> </span>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body d-flex">
				<div class="card-order">
					<h6 class="mb-2">{l s='Total Profit'}</h6>
					<h2 class="mb-1">{$CurrencySign}<span class="number-font counter">{$total_profit}</span></h2>
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
				<div class="card-title">{l s='Sales Statistics'}</div>
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
				<div class="card-title mb-0">{l s='Best Selling Products'}</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap mb-0">
						<thead>
							<tr>
								<th>{l s='ID'}</th>
								<th>{l s='Product'}</th>
								<th>{l s='Total Sold'}</th>
								<th>{l s='Total Price'}</th>
							</tr>
						</thead>
						<tbody>
							{foreach $products_sold as $product}
							<tr>
								<td>{$product.id_product}</td>
								<td class="number-font1">{$product.name}</td>
								<td>{$product.totalQuantitySold}</td>
								<td>{$product.totalPriceSold}</td>
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!-- COL END -->
</div><!-- ROW-5 END -->