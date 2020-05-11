{if isset($orderProducts) && count($orderProducts)}
    <section id="crossselling" class="page-product-box flexslider_carousel_block">
    	<h3 class="productscategory_h2 page-product-heading">
            {if $page_name == 'product'}
                {l s='Customers who bought this product also bought:' mod='crossselling_mod'}
            {else}
                {l s='We recommend' mod='crossselling_mod'}
            {/if}
        </h3>
        {include file="$tpl_dir./product-slider.tpl" products=$orderProducts id='crossseling_products_slider' crosseling=1}
    </section>
{/if}
{if isset($shoppingCart) && count($shoppingCart)}
<script type="text/javascript">
        $('.slick_carousel').slick({
  dots: true,
  accessibility: false,
  rtl: isRtl, 
  lazyLoad: 'progressive',
  infinite: false,
  speed: 600,
  slidesToShow: grid_size_lg,
  slidesToScroll: grid_size_lg,
  responsive: [
    {
      breakpoint: 1320,
      settings: {
        slidesToShow: grid_size_md,
        slidesToScroll: grid_size_md,
      }
    },
    {
      breakpoint: 1000,
      settings: {
        slidesToShow: grid_size_sm,
        slidesToScroll: grid_size_sm
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: grid_size_ms,
        slidesToScroll: grid_size_ms
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: grid_size_xs,
        slidesToScroll: grid_size_xs
      }
    }
  ]
});
</script>
{/if}