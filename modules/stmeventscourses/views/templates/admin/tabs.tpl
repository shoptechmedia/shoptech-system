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

<div class="eventTabs">
	<div class="list-group" id="all_388">
		<a class="list-group-item active" href="#Informations">{l s='Information' mod='stmeventscourses'}</a>
		<a class="list-group-item" href="#Tickets">{l s='Courses' mod='stmeventscourses'}</a>
		<a class="list-group-item" href="#Reservations">{l s='Reservations' mod='stmeventscourses'}</a>

		{if Tools::isSubmit('id_stm_event')}
		<a id="LinkToPack" href="{$link->getAdminLink('AdminProducts')}&id_product={$Event->id_product}&updateproduct" target="_blank">{l s='Pack Settings' mod='stmeventscourses'}</a>
		{/if}
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#LinkToPack').addClass('list-group-item');

		$('#LinkToPack').click(function(){
			window.location.href = this.href;
		});
	})
</script>