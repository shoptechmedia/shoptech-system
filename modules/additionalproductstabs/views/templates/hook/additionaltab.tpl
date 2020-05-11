{if isset($tabContent)}

	
	{if isset($warehouse_vars.product_tabs) && $warehouse_vars.product_tabs}
   		<section class="page-product-box tab-pane fade" id="additionalTab">
    {else}
    	<section class="page-product-box" id="additionalTab">
    	<h3 class="page-product-heading">{$tabName}</h3>
    {/if}


<div class="rte">{$tabContent}</div>
</section>
{/if}

{if isset($tabContentGlobal)}

{if isset($warehouse_vars.product_tabs) && $warehouse_vars.product_tabs}
   		<section class="page-product-box tab-pane fade" id="additionalTabGlobal">
    {else}
    	<section class="page-product-box" id="additionalTabGlobal">
    	<h3 class="page-product-heading">{$tabNameGlobal}</h3>
    {/if}


<div class="rte">{$tabContentGlobal}</div>
</section>
{/if}