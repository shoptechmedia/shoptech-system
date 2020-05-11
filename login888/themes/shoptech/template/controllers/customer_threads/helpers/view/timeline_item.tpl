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
<li>
	<time class="cbp_tmtime" datetime="{dateFormat date=$timeline_item.date full=0}"><span class="hidden ">{dateFormat date=$timeline_item.date full=0}</span><span class="font-weight-normal">{$timeline_item.date|substr:11:5}</span></time>

	<div class="cbp_tmicon bg-warning"><i class="zmdi zmdi-account"></i></div>

	<div class="cbp_tmlabel">
		<h2><a href="{$timeline_item.see_more_link|escape:'html':'UTF-8'}">{l s="Order #"}{$timeline_item.id_order|intval}</a></h2>

		<p class="text-sm">{$timeline_item.content|truncate:220|nl2br}</p>
	</div>
</li>