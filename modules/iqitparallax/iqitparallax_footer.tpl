<!-- Module PARALAX -->
{if !$parallax->width && $parallax->hook==2} 
<div class="container iqitparallax-container">
{/if}
<section id="parallax_block_center" class="parallax_block">
<div class="parallax-outer" style="background-image: url({$link->getMediaLink($image_path)|escape:'html'}); {if $parallax->width && $parallax->hook==1}   margin: 0 -500%; padding: 0.5em 500%; {/if}">
<div class="parallax-inner">

{if $parallax->body_paragraph}
<div class="container"><article class="rte">{$parallax->body_paragraph|stripslashes}</article>
	</div>{/if}
</div>
</div>
</section>
{if !$parallax->width && $parallax->hook==2} 
</div>
{/if}
<!-- /Module PARALAX -->
