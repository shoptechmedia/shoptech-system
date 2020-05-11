{*
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 
 *}


<!-- Module Presta Blog -->
	<div id="idTabBlog">
		{if $listeNewsLinked}
			<h3>{l s='Related articles on blog' mod='prestablog'}</h3>
			<ul class="related_blog_product">
			{foreach from=$listeNewsLinked item=Item name=myLoop}
					<li>
						<a href="{$Item.url|escape:'html':'UTF-8'}">
							{if $Item.image_presente|intval == 1}<img src="{$prestablog_theme_upimg|escape:'html':'UTF-8'}adminth_{$Item.id|intval}.jpg?{$md5pic|escape:'htmlall':'UTF-8'}" alt="{$Item.title|escape:'htmlall':'UTF-8'}" class="lastlisteimg" />{/if}
							<strong>{$Item.title|escape:'htmlall':'UTF-8'}</strong>
						</a>
					</li>
				{if !$smarty.foreach.myLoop.last}{/if}
			{/foreach}
			</ul>
		{else}
			<p>{l s='No related articles on blog' mod='prestablog'}</p>
		{/if}
	</div>
<!-- /Module Presta Blog -->
