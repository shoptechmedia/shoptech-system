        <section id="columnadverts" class="flexslider loading_mainslider">
        	<ul {if isset($slider) && $slider} id="columnadverts_slider"{else} id="columnadverts_list" {/if} >

        		{foreach from=$climages item=image key=i}
        		<li>
        			{if isset($image.link) AND $image.link}

        			<a href="{$image.link}">
        				{/if}
        				{if isset($image.name) AND $image.name}
        				{assign var="imgLink" value="{$modules_dir}columnadverts/slides/{$image.name}"}
        				<img src="{$link->getMediaLink($imgLink)|escape:'html'}"  alt="{$image.name}" class="img-responsive" >
        				{/if}	

        				{if isset($image.link) AND $image.link}
        			</a>    
        			{/if}</li>
        			{/foreach}
        		</ul><!-- ei-slider-large -->
        	</section><!-- ei-slider -->




