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

{if !$id_holiday_sale}
<div class="panel">
	<div class="panel-heading">
		<i class="icon-folder-close"></i>
		{l s='Holiday Sale Pages' mod='HolidaySale'}
	</div>

	<div class="panel-body">
		{foreach $pages as $page}
			{if $page}
			<div class="holiday_item row">
				<span class="col-xs-2">{$page.id_holiday_sale}</span>
				<span class="col-xs-4">{$page.title}</span>
				<span class="col-xs-3">{$page.release_date}</span>
				<span class="col-xs-3">
					<a target="_blank" href="//{$domain}/holiday_sale/{$page.id_holiday_sale}-{$page.link_rewrite}">{l s='View' mod='HolidaySale'}</a> | 
					<a href="#" class="edit_holiday_page" data-id_holiday_sale="{$page.id_holiday_sale}">{l s='Edit' mod='HolidaySale'}</a> | 
					<a href="#" class="delete_holiday_page" data-id_holiday_sale="{$page.id_holiday_sale}">{l s='Delete' mod='HolidaySale'}</a>
				</span>
			</div>
			{/if}
		{/foreach}
	</div>

	<div class="panel-footer">
		<button type="submit" value="1" id="add_new_page" name="submitHolidaySale" class="btn btn-default pull-right">
			<i class="process-icon-new"></i> {l s='Add New' mod='HolidaySale'}
		</button>
	</div>
</div>
{/if}

<script>
var id_holiday_sale = {$id_holiday_sale};
</script>