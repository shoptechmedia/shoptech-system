<!-- MODULE {$moduleName} -->
<script type="text/javascript">
(function() {
  {if $pt_list}
  $('div.right_block span.price').each(function(index) {
    var price = $(this).html();
    $(this).after(viaBillGetPrice(price, 'list', '0px', '0px'));
  });
  {/if}
})();
</script>
<!-- /MODULE {$moduleName} -->
