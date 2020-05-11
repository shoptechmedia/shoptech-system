	<!-- MODULE manufacturer Products -->
		{if isset($manufacturer_products) AND $manufacturer_products}
		<section class="page-product-box flexslider_carousel_block blockproductscategory">
	<h3 class="productscategory_h3 page-product-heading">{l s='Products from the same manufacturer' mod='productsmanufacturer'}</h3>
			{include file="$tpl_dir./product-slider.tpl" products=$manufacturer_products id='manufacturer_products_slider'}
			</section>
		{/if}
	<!-- /MODULE manufacturer Products -->