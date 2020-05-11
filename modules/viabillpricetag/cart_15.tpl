<!-- MODULE {$moduleName} -->
<script type="text/javascript">
(function() {
  {if $pt_cart}
  $('#total_price').each(function(index) {
    var price = $(this).html();
    $(this).parent().find('div.viabill-pricetag-optional-styles').remove();
    $(this).parent().find('div.ViaBill_pricetag_basket').remove();
    $(this).parent().append(viaBillGetPrice(price, 'basket', '0px', '0px'));
  });
  var cartFunc = function(index) {
    var price = $(this).html();
    $(this).parent().find('div.viabill-pricetag-optional-styles').remove();
    $(this).parent().find('div.ViaBill_pricetag_basket').remove();
    $(this).parent().append(viaBillGetPrice(price, 'basket', '0px', '0px'));
    'vb' in window && vb.init();
  };
  if (typeof(ajaxCart) == 'undefined') {
    $('#cart_block_total').each(cartFunc);
  }
  else {
    if (window['viabill_handled'] == undefined) {
      window['viabill_handled'] = 1;
      var func = ajaxCart.updateCart;
      ajaxCart.updateCart = function(jsonData) {
	func(jsonData);
	$('#cart_block_total').each(cartFunc);
      }
    }
    $('#cart_block_total').each(cartFunc);
  }
  {/if}
  {if $pt_payment}
  $('#quickpayviabill').each(function(index) {
    var price = $('#total_price').html();
    if (!price)
      price = $('h4 span.price').html();
    var span = $(this).next().find('span:last-child');
    if (span.length)
      span.html(viaBillGetPrice(price, 'payment', '0px', '0px'));
    else
      $(this).next().find('a').append(viaBillGetPrice(price, 'payment', '0px', '0px'));
  });
  {/if}
})();
</script>
<!-- /MODULE {$moduleName} -->
