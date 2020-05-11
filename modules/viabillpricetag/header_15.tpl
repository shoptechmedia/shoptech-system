<!-- MODULE {$moduleName} -->
<script type="text/javascript">
  function viaBillGetPrice(price, type, padding, margin)
  {
    var re = /(\D*)(\d*)(\D*)(\d*)(\D*)(\d*)(\D*)(\d*)(\D*)/;
    var m = price.match(re);
    var newDiv;

    if (m) {
      m.shift();
      if (m[6] == ',' || m[6] == '.')
	price = parseFloat(m[1] + m[3] + m[5] + '.' + m[7]);
      else if (m[4] == ',' || m[4] == '.')
	price = parseFloat(m[1] + m[3] + '.' + m[5]);
      else if (m[2] == ',' || m[2] == '.')
	price = parseFloat(m[1] + '.' + m[3]);
    }
    newDiv = '<div padding="' + padding + '" margin="' + margin + '" class="ViaBill_pricetag_' + type +
      '" price="' + price + '"></div>';
    return newDiv;
  }

{$pt_tagCode}
</script>
<style type="text/css">
  .viabill-pricetag-optional-styles { margin-bottom:10px; float:right; clear:both; white-space:normal }
   body#product #center_column .viabill-pricetag-optional-styles { width:{$pt_style} !important }
  .payment_module .viabill-pricetag-optional-styles { float:none }
  .payment_module .viabill-pricetag-optional-styles img { margin:0px }
  .vb-float-left { text-align:left }
  

</style>
<!-- /MODULE {$moduleName} -->
