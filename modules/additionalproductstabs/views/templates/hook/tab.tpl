{if isset($warehouse_vars.product_tabs) && $warehouse_vars.product_tabs}	
	{if isset($tabName)}
		<li><a href="#additionalTab" data-toggle="tab">{$tabName}</a></li>
	{/if}

	{if isset($tabNameGlobal)}
		<li><a href="#additionalTabGlobal" data-toggle="tab">{$tabNameGlobal}</a></li>
	{/if}
{/if}