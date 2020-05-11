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
<div class="block">
	<h4 class="title_block">{l s='Mest læste artikler' mod='prestablog'}</h4>
	<div class="block_content" id="prestablog_lastliste">
		{if $ListeBlocLastNews}
			{foreach from=$ListeBlocLastNews item=Item name=myLoop}
				<p>
					{if isset($Item.link_for_unique)}<a href="{PrestaBlogUrl id=$Item.id_prestablog_news seo=$Item.link_rewrite titre=$Item.title}" class="left">{/if}
						{assign var=real_date value=" "|explode:$Item.date}
						<span class="guide">{l s="Guides"}</span><span class="date">{$real_date[0]}</span>
						<br>
						<strong>{$Item.title|escape:'htmlall':'UTF-8'}</strong>

						{if $prestablog_config.prestablog_lastnews_showintro}<br /><span>{$Item.paragraph_crop|escape:'htmlall':'UTF-8'}</span>{/if}

					{if isset($Item.link_for_unique)}</a>{/if}

					{if isset($Item.link_for_unique)}<a href="{PrestaBlogUrl id=$Item.id_prestablog_news seo=$Item.link_rewrite titre=$Item.title}" class="right">{/if}

						{if isset($Item.image_presente) && $prestablog_config.prestablog_lastnews_showthumb}
							<img src="{$prestablog_theme_upimg|escape:'html':'UTF-8'}{$Item.id_prestablog_news|intval}.jpg?{$md5pic|escape:'htmlall':'UTF-8'}" alt="{$Item.title|escape:'htmlall':'UTF-8'}" class="lastlisteimg" />
						{/if}
					{if isset($Item.link_for_unique)}</a>{/if}
				</p>
				{if !$smarty.foreach.myLoop.last}{/if}
			{/foreach}
		{else}
			<p>{l s='No news' mod='prestablog'}</p>
		{/if}
		{*if $prestablog_config.prestablog_lastnews_showall}<a href="{PrestaBlogUrl}" class="button_large">{l s='See all' mod='prestablog'}</a>{/if*}
	</div>
</div>
<!-- /Module Presta Blog -->
