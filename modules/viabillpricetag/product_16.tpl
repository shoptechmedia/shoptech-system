<!-- MODULE {$moduleName} -->
{if $sameprice == 'OK'}
<script type="text/javascript">
  {if $pt_product}
  $('#our_price_display').each(function(index) {
    var price = $(this).html();
    $(this).closest('div').find('div.ViaBill_pricetag_product').remove();
    $(this).closest('div').append(viaBillGetPrice(price, 'product', '0px', '0px'));
  });
  {/if}
</script>
{/if}
{if $sameprice == 'DIF'}
<script type="text/javascript">
{if $pt_product}
 $('#our_price_display').each(function(index) {
    var price = $(this).html();
 
     $(this).closest('div').append('<div class="viabill-pricetag" data-view="list" data-dynamic-price="#our_price_display" data-dynamic-price-triggers="#attributes select, #attributes ul li.selected"></div>');
  });
 {/if}
</script>
{/if}
<!-- /MODULE {$moduleName} -->
