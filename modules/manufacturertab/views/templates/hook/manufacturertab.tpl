{if isset($tabContent)}
	
	{if isset($warehouse_vars.product_tabs) && $warehouse_vars.product_tabs}
    <section class="page-product-box tab-pane fade" id="manufacturerTab">
    {else}
    <section class="page-product-box" id="manufacturerTab">
    <h3 class="page-product-heading">{l s='Brand' mod='manufacturertab'}</h3>
    {/if}

<div class="rte">{$tabContent}</div>
</section>
{/if}