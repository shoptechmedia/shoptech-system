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
	*  @author    PrestaShop SA <contact@prestashop.com>
	*  @copyright 2007-2014 PrestaShop SA
	*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
	*  International Registered Trademark & Property of PrestaShop SA
	*}

	
			{if $node.type==2}

				{if isset($node.content_s.title)}
					{if isset($node.content_s.href)}
					<div class="title_block"><a class="title_block_txt" href="{$node.content_s.href}">{$node.content_s.title} {if isset($node.content_s.legend)}<span class="label legend iqit-legend-inner">{$node.content_s.legend}<span class="legend-arrow"></span></span>{/if}</a></div>
					{else}
					<div class="title_block"><span class="title_block_txt">{$node.content_s.title} {if isset($node.content_s.legend)}<span class="label legend iqit-legend-inner">{$node.content_s.legend}<span class="legend-arrow"></span></span>{/if}</span></div>

					{/if}
				{/if}

				

				{if $node.contentType==1}
				
					{if isset($node.content.ids) && $node.content.ids}
						{$node.content.ids}
					{/if}

				{elseif $node.contentType==2}
				
					{if isset($node.content.products)}
					
					
						{if $node.content.view==0}
							{include file="$tpl_dir./product-list.tpl" image_types=$images_types image_type=$node.content.itype productimg=$node.content.productsimg products=$node.content.products generatorGrid="col-xs-{$node.content.line_xs} col-ms-{$node.content.line_ms} col-sm-{$node.content.line_sm} col-md-{$node.content.line_md} col-lg-{$node.content.line_lg}"}
						{elseif $node.content.view==1}
							{include file="$tpl_dir./product-slider.tpl" image_types=$images_types image_type=$node.content.itype productimg=$node.content.productsimg ar=$node.content.ar ap=$node.content.ap  dt=$node.content.dt colnb=$node.content.colnb products=$node.content.products iqitGenerator=1 line_xs=$node.content.line_xs line_ms=$node.content.line_ms line_sm=$node.content.line_sm line_md=$node.content.line_md line_lg=$node.content.line_lg}
						{elseif $node.content.view==2}
							{include file="$tpl_dir./product-list-small.tpl" image_types=$images_types image_type=$node.content.itype productimg=$node.content.productsimg products=$node.content.products generatorGrid="col-xs-{$node.content.line_xs} col-ms-{$node.content.line_ms} col-sm-{$node.content.line_sm} col-md-{$node.content.line_md} col-lg-{$node.content.line_lg}"}
						{else}
							{include file="$tpl_dir./product-list-small.tpl" image_types=$images_types image_type=$node.content.itype productimg=$node.content.productsimg ar=$node.content.ar ap=$node.content.ap  dt=$node.content.dt colnb=$node.content.colnb products=$node.content.products  iqitGenerator=1 line_xs=$node.content.line_xs line_ms=$node.content.line_ms line_sm=$node.content.line_sm line_md=$node.content.line_md line_lg=$node.content.line_lg}
						{/if}
						
		
					{/if}

				{elseif $node.contentType==4}

						{if isset($node.content.ids)}
						{if $node.content.view==0}
							{include file="$tpl_dir./product-list.tpl" image_types=$images_types image_type=$node.content.itype  productimg=$node.content.productsimg products=$node.content.products generatorGrid="col-xs-{$node.content.line_xs} col-ms-{$node.content.line_ms} col-sm-{$node.content.line_sm} col-md-{$node.content.line_md} col-lg-{$node.content.line_lg}"}
						{elseif $node.content.view==1}
							{include file="$tpl_dir./product-slider.tpl" image_types=$images_types image_type=$node.content.itype productimg=$node.content.productsimg ar=$node.content.ar ap=$node.content.ap  dt=$node.content.dt colnb=$node.content.colnb products=$node.content.products iqitGenerator=1 line_xs=$node.content.line_xs line_ms=$node.content.line_ms line_sm=$node.content.line_sm line_md=$node.content.line_md line_lg=$node.content.line_lg}
						{elseif $node.content.view==2}
							{include file="$tpl_dir./product-list-small.tpl" image_types=$images_types image_type=$node.content.itype productimg=$node.content.productsimg products=$node.content.products generatorGrid="col-xs-{$node.content.line_xs} col-ms-{$node.content.line_ms} col-sm-{$node.content.line_sm} col-md-{$node.content.line_md} col-lg-{$node.content.line_lg}"}
						{else}
							{include file="$tpl_dir./product-list-small.tpl" image_types=$images_types image_type=$node.content.itype productimg=$node.content.productsimg ar=$node.content.ar ap=$node.content.ap  dt=$node.content.dt colnb=$node.content.colnb products=$node.content.products  iqitGenerator=1 line_xs=$node.content.line_xs line_ms=$node.content.line_ms line_sm=$node.content.line_sm line_md=$node.content.line_md line_lg=$node.content.line_lg}
						{/if}
					{/if}

				{elseif $node.contentType==5}
					

					<ul class="manufacturers row">
						{foreach from=$node.content.ids item=manufacturer}
							{assign var="myfile" value="img/m/{$manufacturer|escape:'htmlall':'UTF-8'}-mf_image.jpg"}
							{if file_exists($myfile)}
								<li class="transition-opacity-300">
									<a href="{$link->getmanufacturerLink($manufacturer)}">
										<img src="{$img_manu_dir}{$manufacturer|escape:'htmlall':'UTF-8'}-mf_image.jpg" class="img-responsive logo_manufacturer " {if isset($manufacturerSize)} width="{$manufacturerSize.width}" height="{$manufacturerSize.height}"{/if} alt="Manufacturer - {$manufacturer}" />
									</a>
							</li>
							{/if}
						{/foreach}
					</ul>	

				{elseif $node.contentType==6}

					{if isset($node.content.source)}
			
						<a {if isset($node.content.href)}href="{$node.content.href}" {if isset($node.content.window) && $node.content.window == 1}target="_blank"{/if} {/if}
					style="background-image: url('{$node.content.source}')" class="iqit-banner-image">
						
							<img src="{$node.content.source}" class="img-responsive banner-image" alt=" " />
					
						</a>
					{/if}

				{elseif $node.contentType==7}
				{if $node.content.view}<div class="iqitcarousel-wrapper">{/if}
				
					<div class="manufacturers row {if $node.content.view}slick_carousel_style iqitcarousel{/if}"  {if $node.content.view}data-slick='{literal}{{/literal}{if $node.content.dt}"dots": true, {/if}{if $node.content.ap}"autoplay": true, {/if}"slidesToShow": {$node.content.line_lg}, "slidesToScroll": {$node.content.line_lg}, "responsive": [ 
					{ "breakpoint": 1320, "settings": { "slidesToShow": {$node.content.line_md}, "slidesToScroll": {$node.content.line_md}}}, { "breakpoint": 1000, "settings": { "slidesToShow": {$node.content.line_sm}, "slidesToScroll": {$node.content.line_sm}}}, { "breakpoint": 768, "settings": { "slidesToShow": {$node.content.line_ms}, "slidesToScroll": {$node.content.line_ms}}}, { "breakpoint": 480, "settings": { "slidesToShow": {$node.content.line_xs}, "slidesToScroll": {$node.content.line_xs}}} ]{literal}}{/literal}'{/if}>
					{assign var="iterator" value=1}

					
					{if isset($node.content.manu)}
					

					{foreach from=$node.content.manu item=manufacturer name=manufacturerSlider}
				
								{assign var="myfile" value="img/m/{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}-mf_image.jpg"}
									{if file_exists($myfile)}
									{if $node.content.view}{if $iterator == 1 || ((($iterator + 1)%$node.content.colnb == 0))}<div class="iqitcarousel-man slick-slide">{/if}{/if}
										<div {if !$node.content.view}class="iqitmanufacuter-logo col-xs-{$node.content.line_xs} col-ms-{$node.content.line_ms} col-sm-{$node.content.line_sm} col-md-{$node.content.line_md} col-lg-{$node.content.line_lg}"{else}class="iqitmanufacuter-logo"{/if}>
											<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer)}">
												<img src="{$img_manu_dir}{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}-mf_image.jpg" class="img-responsive logo_manufacturer transition-300" {if isset($manufacturerSize)} width="{$manufacturerSize.width}" height="{$manufacturerSize.height}"{/if} alt="Manufacturer - {$manufacturer.name}" />
											</a>
										</div>
							{if $node.content.view}
									{if ($iterator%$node.content.colnb == 0) && !$smarty.foreach.manufacturerSlider.last}</div>{/if}
									{if $smarty.foreach.manufacturerSlider.last}</div>{/if}
							{/if}
							{assign var="iterator" value=$iterator + 1}
							
							{/if}
							
						{/foreach}


					{else}

							{foreach from=$node.content.ids item=manufacturer name=manufacturerSlider}
								{assign var="myfile" value="img/m/{$manufacturer|escape:'htmlall':'UTF-8'}-mf_image.jpg"}
								
									{if file_exists($myfile)}
										{if $node.content.view}
											{if $iterator == 1 || ((($iterator + 1)%$node.content.colnb == 0))}<div class="iqitcarousel-man slick-slide">{/if}
										{/if}

										<div {if !$node.content.view}class="iqitmanufacuter-logo col-xs-{$node.content.line_xs} col-ms-{$node.content.line_ms} col-sm-{$node.content.line_sm} col-md-{$node.content.line_md} col-lg-{$node.content.line_lg}"{else}class="iqitmanufacuter-logo"{/if}>
											<a href="{$link->getmanufacturerLink($manufacturer)}">
												<img src="{$img_manu_dir}{$manufacturer|escape:'htmlall':'UTF-8'}-mf_image.jpg" class="img-responsive logo_manufacturer transition-300" {if isset($manufacturerSize)} width="{$manufacturerSize.width}" height="{$manufacturerSize.height}"{/if} alt="Manufacturer - {$manufacturer}" />
											</a>
										</div>
							
							{if $node.content.view}
									{if ($iterator%$node.content.colnb == 0) && !$smarty.foreach.manufacturerSlider.last}</div>{/if}
									
							{if $smarty.foreach.manufacturerSlider.last}</div>{/if}
							{/if}
							{assign var="iterator" value=$iterator + 1}
							
							
							{/if}


							
						{/foreach}
					{/if}
			
					</div><!--  .manufacturers row  -->
				{if $node.content.view}</div><!--  .iqitcarousel-wrapper -->{/if}


				{elseif $node.contentType==8}
					{hook h=$node.content.hook}
				{elseif $node.contentType==9}	
					{$node.content.module} 
				{/if}



			{/if}
