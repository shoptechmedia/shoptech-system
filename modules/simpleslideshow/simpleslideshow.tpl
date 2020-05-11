<section id="ei-slider" class="loading_mainslider col-xs-12">
		{foreach from=$images item=image key=i}
		<div>
			{if isset($image.link) AND $image.link}<a href="{$image.link}">{/if}

				{if isset($image.name) AND $image.name}
				{assign var="imgLink" value="{$modules_dir}simpleslideshow/slides/{$image.name}"}
				<img data-lazy="{$link->getMediaLink($imgLink)|escape:'html'}"  alt="{$image.name}" class="img-responsive">
				{/if}	

				{if isset($image.link) AND $image.link}</a>{/if}
			</div>
			{/foreach}
</section><!-- ei-slider -->
