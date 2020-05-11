<section id="social_block_mod" class="social_block_mod footer-block col-xs-12 col-sm-3">
	<div>
		<h4>{l s='Follow us' mod='blocksocial_mod'}</h4>
		<ul class="toggle-footer clearfix">
			{if $facebook_url != ''}<li class="facebook"><a href="{$facebook_url}" class="transition-300" target="_blank" title="{l s='Facebook' mod='blocksocial_mod'}"></a></li>{/if}
			{if $twitter_url != ''}<li class="twitter"><a href="{$twitter_url}" class="transition-300" target="_blank" title="{l s='Twitter' mod='blocksocial_mod'}"></a></li>{/if}
			{if $google_url != ''}<li class="google"><a href="{$google_url}" class="transition-300" target="_blank" title="{l s='Google +' mod='blocksocial_mod'}"></a></li>{/if}
			{if $youtube_url != ''}<li class="youtube"><a href="{$youtube_url}" class="transition-300" target="_blank" title="{l s='Youtube' mod='blocksocial_mod'}"></a></li>{/if}
			{if $vimeo_url != ''}<li class="vimeo"><a href="{$vimeo_url}" class="transition-300" target="_blank" title="{l s='Vimeo' mod='blocksocial_mod'}"></a></li>{/if}
			{if $pinterest_url != ''}<li class="pinterest"><a href="{$pinterest_url}" class="transition-300" target="_blank" title="{l s='Pinterest' mod='blocksocial_mod'}"></a></li>{/if}
			{if $instagram_url != ''}<li class="instagram"><a href="{$instagram_url}" class="transition-300" target="_blank" title="{l s='Instagram' mod='blocksocial_mod'}"></a></li>{/if}
			{if $tumblr_url != ''}<li class="tumblr"><a href="{$tumblr_url}" target="_blank" class="transition-300" title="{l s='Tumblr' mod='blocksocial_mod'}"></a></li>{/if}
			{if $flickr_url != ''}<li class="flickr"><a href="{$flickr_url}" target="_blank" class="transition-300" title="{l s='Flickr' mod='blocksocial_mod'}"></a></li>{/if}
			{if $rss_url != ''}<li class="rss"><a href="{$rss_url}" target="_blank" class="transition-300" title="{l s='RSS' mod='blocksocial_mod'}"></a></li>{/if}
		</ul></div>
</section>
