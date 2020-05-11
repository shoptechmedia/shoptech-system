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

<!-- Module Presta Blog START PAGE -->

{capture name=path}<a href="{PrestaBlogUrl}" >{l s='Blog' mod='prestablog'}</a>{if $SecteurName}{PrestaBlogContent return=$SecteurName}{/if}{/capture}

<div class="first-section">
	{if isset($tpl_filtre_cat) && $tpl_filtre_cat}{PrestaBlogContent return=$tpl_filtre_cat}{/if}
	{if isset($tpl_menu_cat) && $tpl_menu_cat}{PrestaBlogContent return=$tpl_menu_cat}{/if}
	<div class="contain-box">
		{if isset($tpl_slide) && $tpl_slide}
			{*PrestaBlogContent return=$tpl_slide*}
			<div class="top_section_blog_latest">
				<ul>
					{foreach from=$getLatest item=latests}
						<li>
							<a href="{PrestaBlogUrl id=$latests.id_prestablog_news seo=$latests.link_rewrite titre=$latests.title}">
								<img src="{$prestablog_theme_upimg|escape:'html':'UTF-8'}{$latests.id_prestablog_news|intval}.jpg?{$md5pic|escape:'htmlall':'UTF-8'}">
							</a>
							<div class="top_section_blog_latestcontent">
								<div class="top_section_blog_latestcategory">
									 {foreach from=$latests.categories item=categorie key=key name=current}
			                            <a href="{PrestaBlogUrl c=$key titre=$categorie.link_rewrite}" class="categories_floatbox">{$categorie.title|escape:'htmlall':'UTF-8'}</a>
			                            {if !$smarty.foreach.current.last},{/if}
			                        {/foreach}
			                    	{*$latests.cattitle*}
			                    </div>
								<div class="top_section_blog_latesttitle">
									<a href="{PrestaBlogUrl id=$latests.id_prestablog_news seo=$latests.link_rewrite titre=$latests.title}">
										{$latests.title}
									</a>
								</div>
								<div class="top_section_blog_latestdate">{dateFormat date=$latests.date full=1}</div>
							</div>
						</li>
					{/foreach}
				</ul>
			</div>
		{/if}
	</div>
</div>

<div class="main-section">
	<div class="main-section-main">
		{if isset($tpl_unique) && $tpl_unique}{PrestaBlogContent return=$tpl_unique}{/if}
		{*if isset($tpl_comment) && $tpl_comment}{PrestaBlogContent return=$tpl_comment}{/if}
		{if isset($tpl_comment_fb) && $tpl_comment_fb}{PrestaBlogContent return=$tpl_comment_fb}{/if*}

		{if isset($tpl_cat) && $tpl_cat}{PrestaBlogContent return=$tpl_cat}{/if}
		{if isset($tpl_all) && $tpl_all}{PrestaBlogContent return=$tpl_all}{/if}
	</div>
	<div class="sidebar-blog">
		<div class="social_platforms">
			<div class="heading">{l s="Følg os på sociale medier"}</div>
			<ul class="social_medias">
				<li class="social_medias-facebook"><a href="{$facebook_page}" target="_blank">{l s="Like os på Facebook"}</a></li>
				<li class="social_medias-Instagram"><a href="{$insta_page}" target="_blank">{l s="Følg os på Instagram"}</a></li>
				<li class="social_medias-YouTube"><a href="{$youtube_page}" target="_blank">{l s="Abonner på YouTube"}</a></li>
			</ul>
		</div>
		{hook h="displayRightSidePrestablog"}
	</div>
</div>
<!-- /Module Presta Blog END PAGE -->
