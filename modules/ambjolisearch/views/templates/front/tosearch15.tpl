{*
* 20013-2015 Ambris
*
*	@author    Ambris Informatique
*	@copyright Copyright (c) 2013-2014 Ambris Informatique SARL
*	@license   Commercial license
*  International Registered Trademark & Property of PrestaShop SA
*}

<div id="search" class="search">


{capture name=path}{l s='Search' mod='ambjolisearch'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h1 {if (isset($instantSearch) && $instantSearch) || (isset($instant_search) && $instant_search)}id="instant_search_results"{/if}>
{l s='Search' mod='ambjolisearch'}&nbsp;{if $nbProducts > 0}"{if isset($real_query) && $real_query}{$real_query|escape:'htmlall':'UTF-8'}{elseif $search_tag}{$search_tag|escape:'htmlall':'UTF-8'}{elseif $ref}{$ref|escape:'htmlall':'UTF-8'}{/if}"{/if}
</h1>





{include file="$tpl_dir./errors.tpl"}
{if !$nbProducts}
	<p class="warning">
		{if isset($no_suitable_words) && $no_suitable_words}
			{l s='Your search has encountered an error. Searches only work with at least one word of at least %d characters. Please try again.' mod='ambjolisearch'  sprintf=$min_length|intval}
		{elseif isset($real_query) && $real_query}
			{l s='No results found for your search' mod='ambjolisearch' }&nbsp;"{if isset($real_query)}{$real_query|escape:'htmlall':'UTF-8'}{/if}"
		{elseif isset($search_tag) && $search_tag}
			{l s='No results found for your search' mod='ambjolisearch' }&nbsp;"{$search_tag|escape:'htmlall':'UTF-8'}"
		{else}
			{l s='Please type a search keyword.' mod='ambjolisearch' }
		{/if}
		{if (isset($instantSearch) && $instantSearch) || (isset($instant_search) && $instant_search)}<span class="close_link"><a href="#" class="closeinstantsearch" title="{l s='Return to previous page' mod='ambjolisearch'}">{l s='Return to previous page' mod='ambjolisearch' }</a></span>{/if}
	</p>
{else}
	<p class="warning">
		<span class="big">{if $nbProducts == 1}{l s='%d result has been found.' mod='ambjolisearch'  sprintf=$nbProducts|intval}{else}{l s='%d results have been found.' mod='ambjolisearch'  sprintf=$nbProducts|intval}{/if}</span>
		{if (isset($instantSearch) && $instantSearch) || (isset($instant_search) && $instant_search)}<span class="close_link"><a href="#" class="closeinstantsearch" title="{l s='Return to previous page' mod='ambjolisearch'}">{l s='Return to previous page' mod='ambjolisearch'}</a></span>{/if}
	</p>



	{if isset($subcategories) && count($subcategories)>0}
		<!-- Subcategories -->
		<div id="subcategories">
			<h3>{l s='Categories' mod='ambjolisearch'}</h3>
			<ul class="inline_list">
			{foreach from=$subcategories item=subcategory}
				<li class="clearfix">
					<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$subcategory.name|escape:'htmlall':'UTF-8'}" class="img">
						{if $subcategory.id_image}
							<img src="{$link->getCatImageLink($subcategory.link_rewrite, $subcategory.id_image, 'medium_default')|escape:'html'}" alt="" width="{$mediumSize.width|escape:'html':'UTF-8'}" height="{$mediumSize.height|escape:'html':'UTF-8'}" />
						{else}
							<img src="{$img_cat_dir|escape:'htmlall':'UTF-8'}default-medium_default.jpg" alt="" width="{$mediumSize.width|escape:'html':'UTF-8'}" height="{$mediumSize.height|escape:'html':'UTF-8'}" />
						{/if}
					</a>
					<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}" class="cat_name">{$subcategory.name|escape:'htmlall':'UTF-8'}</a>
					{if $subcategory.description && $show_cat_desc==1}
						<p class="cat_desc">{$subcategory.description|escape:'htmlall':'UTF-8'}</p>
					{/if}
				</li>
			{/foreach}
			</ul>
			<br class="clear"/>
		</div>
	{/if}







	{if !isset($instantSearch) || (isset($instantSearch) && !$instantSearch)}
		{if !isset($instant_search) || (isset($instant_search) && !$instant_search)}
			<div class="content_sortPagiBar">
				<div class="sortPagiBar">
					{include file="$tpl_dir./product-compare.tpl"}
					{include file="$tpl_dir./nbr-product-page.tpl"}
					{include file="$tpl_dir./product-sort.tpl"}
				</div>
			</div>
		{/if}
	{/if}

	{include file="$tpl_dir./product-list.tpl" products=$search_products}

	{if !isset($instantSearch) || (isset($instantSearch) && !$instantSearch)}
		{if !isset($instant_search) || (isset($instant_search) && !$instant_search)}
			<div class="content_sortPagiBar">
				<div class="sortPagiBar">
					{include file="$tpl_dir./product-compare.tpl"}
					{include file="$tpl_dir./pagination.tpl"}
				</div>
			</div>
		{/if}
	{/if}
{/if}


</div>