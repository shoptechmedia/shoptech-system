<h1>{$holiday->title}</h1>

<div class="content">
	{$holiday->holiday_description}
</div>

{if $holiday->use_countdown}
<div class="holiday_sale_countdown" data-start_date="{$holiday->release_date}" data-end_date="{$holiday->end_date}" data-end_text="{$holiday->ending_text}">
	<strong>{$holiday->countdown_text}</strong>

	<span class="day">{l s='Day' mod='HolidaySale'}</span>
	<span class="hour">{l s='Hour' mod='HolidaySale'}</span>
	<span class="min">{l s='Minute' mod='HolidaySale'}</span>
	<span class="sec">{l s='Second' mod='HolidaySale'}</span>
</div>
{/if}

{if $products}
<div class="content_sortPagiBar unvisible clearfix">
	<div class="sortPagiBar clearfix"> 
		{include file="$tpl_dir./product-sort.tpl"}

		{include file="$tpl_dir./nbr-product-page.tpl"}

		{hook h='aboveProductList'}

		<div class="top-pagination-content clearfix">
			{include file="$tpl_dir./pagination.tpl"}
		</div>
	</div>
</div>

{if !$holiday->hide_products}
{include file="./product-list.tpl" products=$products marker=$holiday->banner_image marker_font_color=$holiday->banner_image_font_color}
{/if}

<div class="content_sortPagiBar unvisible">
	<div class="bottom-pagination-content clearfix">
		{include file="$tpl_dir./pagination.tpl" paginationId='bottom'}
	</div>
</div>
{/if}

<style type="text/css">
	{if $holiday->page_background_color}
	#columns{
		background-color: {$holiday->page_background_color} !important;
	}
	{/if}

	{if $holiday->page_background_color}
	#columns .content-inner,
	.product-name,
	span.price.product-price,
	span.old-price.product-price{
		color: {$holiday->page_font_color} !important;
	}
	{/if}

	.content p{
		display: block;
	}
</style>