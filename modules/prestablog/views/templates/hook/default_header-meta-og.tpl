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
{foreach from=$prestablog_fb_admins item=fbmoderator}
<meta property="fb:admins"			content="{$fbmoderator|escape:'html':'UTF-8'}" />
{/foreach}
<meta property="og:url"				content="{$prestablog_news_meta_url|escape:'html':'UTF-8'}" />
<meta property="og:image"			content="{$prestablog_news_meta_img|escape:'html':'UTF-8'}" />
<meta property="og:title"			content="{$prestablog_news_meta->title|escape:'htmlall':'UTF-8'}" />
<meta property="og:description"	content="{$prestablog_news_meta->paragraph|escape:'htmlall':'UTF-8'}" />
<!-- Module Presta Blog -->

