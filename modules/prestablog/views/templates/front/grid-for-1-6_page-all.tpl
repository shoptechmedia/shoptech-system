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
<h1>
    {if isset($prestablog_title_h1)}
        {$prestablog_title_h1|escape:'htmlall':'UTF-8'}<br>
    {/if}
    <span>{*$NbNews|intval*}
    {if $NbNews <> 1}
        {l s='SENESTE ARTIKLER' mod='prestablog'}
    {else}
        {l s='SENESTE ARTIKLER' mod='prestablog'}
    {/if}
    {if isset($prestablog_categorie_obj)}
        {l s='in the categorie' mod='prestablog'}&nbsp;{$prestablog_categorie_obj->title|escape:'htmlall':'UTF-8'}
    {/if}
    </span>
</h1>

{if sizeof($news)}
	{*include file="$prestablog_pagination"*}
	<ul id="blog_list">
	{foreach from=$news item=news_item name=NewsName}
		<li>
        	<div class="block_cont">
                <div class="block_top">
                {if isset($news_item.image_presente)}
                    {if isset($news_item.link_for_unique)}<a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}" title="{$news_item.title|escape:'htmlall':'UTF-8'}">{/if}
                        <img src="{$prestablog_theme_upimg|escape:'html':'UTF-8'}thumb_{$news_item.id_prestablog_news|intval}.jpg?{$md5pic|escape:'htmlall':'UTF-8'}" alt="{$news_item.title|escape:'htmlall':'UTF-8'}" />
                    {if isset($news_item.link_for_unique)}</a>{/if}
                {/if}
                {if sizeof($news_item.categories)}
                    <div class="categories_floatbox_wrap">
                        {foreach from=$news_item.categories item=categorie key=key name=current}
                            <a href="{PrestaBlogUrl c=$key titre=$categorie.link_rewrite}" class="categories_floatbox">{$categorie.title|escape:'htmlall':'UTF-8'}</a>
                            {if !$smarty.foreach.current.last}{/if}
                        {/foreach}
                    </div>
                {/if}
                </div>
                <div class="block_bas">
                    <h3>
                        {if isset($news_item.link_for_unique)}<a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}" title="{$news_item.title|escape:'htmlall':'UTF-8'}">{/if}{$news_item.title|escape:'htmlall':'UTF-8'|truncate:30:"...":true}{if isset($news_item.link_for_unique)}</a>{/if}
                    <br /><span class="date_blog-cat">{l s='Published :' mod='prestablog'}
                            {dateFormat date=$news_item.date full=1}
                            </span>
                    </h3>
                    <p class="blog_description">
                        <a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}">
                            {if $news_item.paragraph_crop!=''}
                                {$news_item.paragraph_crop|escape:'htmlall':'UTF-8'}
                            {/if}
                        </a>
                    </p>
                    {if isset($news_item.link_for_unique)}
                            <!-- <a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}" class="blog_link">{l s='Read more' mod='prestablog'}</a> -->
                            {if $prestablog_config.prestablog_comment_actif==1 && $news_item.count_comments>0}
                                <a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}#comment" class="comments"> {$news_item.count_comments|intval}</a>
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
                                <a href="{PrestaBlogUrl id=$news_item.id_prestablog_news seo=$news_item.link_rewrite titre=$news_item.title}#comment" id="showcomments{$news_item.id_prestablog_news|intval}" class="comments"></a>
                            {/if}
                    {/if}
                </div>
              </div>
		</li>
	{/foreach}
	</ul>
	{include file="$prestablog_pagination"}
{else}
	<p class="warning">{l s='Empty' mod='prestablog'}</p>
{/if}
<!-- /Module Presta Blog -->
