{if $dropdowns}
<div class="STM_GroupP">

	<div class="STM_GroupP_Header">Vælg udgave</div>

	{foreach $dropdowns as $dropdown}
		<select class="STM_GroupP_Fields" name="{$dropdown.name}">
			<option value="0"> -- {$dropdown.label} -- </option>

			{foreach $dropdown.values as $label => $products}
				<option value="{$products}">{$label}</option>
			{/foreach}
		</select>
	{/foreach}

	{*<button type="button" class="btn btn-primary" id="STM_GroupP_Reset"><img src="/img/undo.png" alt=""/></button>*}

	<span class="clearfix"></span>

</div>
{/if}