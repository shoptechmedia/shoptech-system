{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if isset($events) && $events}
	{*define numbers of product per line in other page for desktop*}

	<!-- Products list -->
	<ul class="product_list grid row">

	{foreach $events as $event}
		<li class="preload_element ajax_block_product col-xs-12 col-ms-6 col-sm-4 col-md-3 col-lg-15">
			<div class="product-container" itemscope>
				<div class="left-block">
					<div class="product-image-container">
						<a class="product_img_link" href="/events/{$event.id_stm_event}-{$event.link_rewrite}" title="{$event.name}" id="all_627">
							<img class="replace-2x img-responsive img_0 lazy" src="/upload/{$event.event_image}" alt="{$event.name}" title="{$event.name}" width="500" height="500">
						</a>
					</div>
				</div>

				<div class="right-block">
					<div  class="product-name-container">
						<a class="product-name" href="/events/{$event.id_stm_event}-{$event.link_rewrite}" title="{$event.name}">
							{$event.name}
						</a>
					</div>

					<div itemscope="" class="content_price">
						<span class="price product-price">
							{displayPrice price=Product::getPriceStatic($event.id_product)}
						</span>
					</div>

					<div class="button-container">
						<a class="button lnk_view btn" href="/events/{$event.id_stm_event}-{$event.link_rewrite}" title="{l s='View'}">
							<span>{l s='More' mod='stmeventscourses'}</span>
						</a>
					</div>
				
				</div>

			</div><!-- .product-container> -->
		
		</li>
	{/foreach}
	</ul>

{/if}