
                <section id="ei-slider-fw-wrapper">
                <div id="ei-slider-fw" class="container loading_mainslider">
            
									
											{foreach from=$images item=image key=i}
											<div>
							{if isset($image.link) AND $image.link}

            <a href="{$image.link}">
		{/if}
							{if isset($image.name) AND $image.name}
							{assign var="imgLink" value="{$modules_dir}simpleslideshow/slides/{$image.name}"}
			<img src="{$link->getMediaLink($imgLink)|escape:'html'}"  alt="{$image.name}" class="img-responsive" >
		{/if}	
						
								{if isset($image.link) AND $image.link}
			</a>    
		{/if}</div>
                  	{/foreach}
                  
										
										



</div>
                </section><!-- ei-slider -->

 
				

