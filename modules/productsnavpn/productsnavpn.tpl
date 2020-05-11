<div id="productsnavpn" class="pull-right"> 
    {if isset($previous)}
        <a href="{$previous}" title="{l s='Previous product' mod='iqitproductsnav'}">
            <i class="icon-angle-left"></i>
        </a>
    {/if}
    {if isset($next)}
        <a href="{$next}" title="{l s='Next product' mod='iqitproductsnav'}">
			<i class="icon-angle-right"></i>
        </a>
    {/if}
</div>