<!-- MODULE {$moduleName} -->
<script type="text/javascript">
(function() {
  {if $pt_list}
  $('div.content_price span.price').each(function(index) {
    var price = $(this).html();
    $(this).closest('div').find('div.ViaBill_pricetag_list').remove();
    $(this).closest('div').append(viaBillGetPrice(price, 'list', '0px', '0px'));
  });
  {/if}
})();
</script>
<!-- /MODULE {$moduleName} -->
