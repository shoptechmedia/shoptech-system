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
<span id="comment"></span>
<div id="prestablog-fb-comments">
	<div id="fb-root"></div>
	{literal}
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/{/literal}{$fb_comments_iso|escape:'html':'UTF-8'}{literal}/sdk.js#xfbml=1&version=v2.4{/literal}{if $fb_comments_apiId}&appId={$fb_comments_apiId|escape:'html':'UTF-8'}{/if}{literal}";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	{/literal}
	<div class="fb-comments" data-href="{$fb_comments_url|escape:'html':'UTF-8'}" data-numposts="{$fb_comments_nombre|intval}" data-width="100%" data-mobile="false"></div>
</div>
<!-- /Module Presta Blog -->
