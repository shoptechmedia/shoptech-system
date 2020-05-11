{*
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 *
 *}
<!-- Module Presta Blog -->
{capture name=path}<a href="{PrestaBlogUrl}" >{l s='Blog' mod='prestablog'}</a>{if $SecteurName}{PrestaBlogContent return=$SecteurName}{/if}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h1>
    {if isset($prestablog_title_h1)}
        {$prestablog_title_h1|escape:'htmlall':'UTF-8'}<br>
    {/if}
    <span>{$NbNews|intval}
    {if $NbNews <> 1}
        {l s='articles' mod='prestablog'}
    {else}
        {l s='article' mod='prestablog'}
    {/if}
    {if isset($prestablog_categorie_obj)}
        {l s='in the categorie' mod='prestablog'}&nbsp;{$prestablog_categorie_obj->title|escape:'htmlall':'UTF-8'}
    {/if}
    </span>
</h1>

{if sizeof($news)}
	{include file="$prestablog_pagination"}
	<ul id="blog_list">
	{foreach from=$news item=news_item name=NewsName}
		<li>
			{if isset($news_item.image_presente)}
			<div class="block_gauche">
				{if isset($news_item.link_for_unique)}<a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}" class="product_img_link" title="{$news_item.title|escape:'htmlall':'UTF-8'}">{/if}
					<img src="{$prestablog_theme_upimg|escape:'html':'UTF-8'}thumb_{$news_item.id_prestablog_news|intval}.jpg?{$md5pic|escape:'htmlall':'UTF-8'}" alt="{$news_item.title|escape:'htmlall':'UTF-8'}" />
				{if isset($news_item.link_for_unique)}</a>{/if}
			</div>
			{/if}
			<div class="block_droite">
				<h3>
					{if isset($news_item.link_for_unique)}<a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}" title="{$news_item.title|escape:'htmlall':'UTF-8'}">{/if}{$news_item.title|escape:'htmlall':'UTF-8'}{if isset($news_item.link_for_unique)}</a>{/if}
				<br /><span class="date_blog-cat">{l s='Published :' mod='prestablog'}
						{dateFormat date=$news_item.date full=1}
						{if $prestablog_config.prestablog_comment_actif==1}
							{if $news_item.count_comments>0}| {$news_item.count_comments|intval} {if $news_item.count_comments>1}{l s='comments' mod='prestablog'}{else}{l s='comment' mod='prestablog'}{/if} {/if}
						{/if}
						{if $prestablog_config.prestablog_commentfb_actif==1}
							<script type="text/javascript">
							{literal}
							$(function(){
							   $.getJSON( "https://graph.facebook.com/v2.4/?fields=share{comment_count}&id={/literal}{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}{literal}", function( json ) {
							           $("#showcomments{/literal}{$news_item.id_prestablog_news|intval}{literal}").html(json.share.comment_count);
							   });
							});
							{/literal}
							</script>
							| <span id="showcomments{$news_item.id_prestablog_news|intval}"></span> {l s='comments' mod='prestablog'}
						{/if}
						{if sizeof($news_item.categories)} | {l s='Categories :' mod='prestablog'}
							{foreach from=$news_item.categories item=categorie key=key name=current}
								<a href="{PrestaBlogUrl c=$key titre=$categorie.link_rewrite}" class="categorie_blog">{$categorie.title|escape:'htmlall':'UTF-8'}</a>
								{if !$smarty.foreach.current.last},{/if}
							{/foreach}
						{/if}</span>
				</h3>
				<p class="blog_desc">
					{if $news_item.paragraph_crop!=''}
						{$news_item.paragraph_crop|escape:'htmlall':'UTF-8'}
					{/if}
				</p>
				{if isset($news_item.link_for_unique)}
					<p>
						<a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}" class="blog_link">{l s='Read more' mod='prestablog'}</a>
					</p>
				{/if}
			</div>
		</li>
	{/foreach}
	</ul>
	{include file="$prestablog_pagination"}
{else}
	<p class="warning">{l s='Empty' mod='prestablog'}</p>
{/if}
<!-- /Module Presta Blog -->
