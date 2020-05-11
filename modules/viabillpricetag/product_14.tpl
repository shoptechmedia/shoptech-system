<!-- MODULE {$moduleName} -->
<script type="text/javascript">
  {if $pt_product}
  $('span.our_price_display').each(function(index) {
    var price = $(this).html();
    $(this).closest('div').find('div.ViaBill_pricetag_product').remove();
    $(this).parent().after(viaBillGetPrice(price, 'product', '0px', '0px'));
  });
  {/if}
</script>
<!-- /MODULE {$moduleName} -->
