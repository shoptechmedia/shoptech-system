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
<div id="block_footer_last_list">
	<p class="title_block">{l s='Last blog articles' mod='prestablog'}</p>
	<ul>
		{if $ListeBlocLastNews}
			{foreach from=$ListeBlocLastNews item=Item name=myLoop}
				<li>{dateFormat date=$Item.date full=1}<br/>
					{if isset($Item.link_for_unique)}<a href="{PrestaBlogUrl id=$Item.id_prestablog_news seo=$Item.link_rewrite titre=$Item.title}">{/if}
						<strong>{$Item.title|escape:'htmlall':'UTF-8'}</strong>
						{if $prestablog_config.prestablog_footlastnews_intro}<br /><span>{$Item.paragraph_crop|escape:'htmlall':'UTF-8'}</span>{/if}
					{if isset($Item.link_for_unique)}</a>{/if}
				</li>
				{if !$smarty.foreach.myLoop.last}{/if}
			{/foreach}
		{else}
			<li>{l s='No news' mod='prestablog'}</li>
		{/if}
	</ul>
	{if $prestablog_config.prestablog_footlastnews_showall}
		<p>
			<a href="{PrestaBlogUrl}" class="button_large">{l s='See all' mod='prestablog'}</a>
		</p>
	{/if}
</div>
<!-- /Module Presta Blog -->
