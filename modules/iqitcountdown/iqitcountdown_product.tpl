<div class="price-countdown-wrapper">
<div class="price-countdown price-countdown-product" {if !isset($specific_prices.to) || (isset($specific_prices.to) && $specific_prices.to=='0000-00-00 00:00:00')} style="display: none;"{/if} >
<strong class="price-countdown-title"><i class="icon icon-hourglass-start faa-tada animated"></i> {l s='Time left' mod='iqitcountdown'}:</strong>
<div class="count-down-timer" data-countdown="{if isset($specific_prices.to)}{$specific_prices.to}{/if}"> </div>
</div></div>




