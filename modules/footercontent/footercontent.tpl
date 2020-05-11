<!-- Module footercontent-->
<section id="footer_html_content" class="footer-block col-xs-12 col-sm-{$footercontent->width}">
	<div>
		{if $footercontent->body_title}<h4>{$footercontent->body_title|stripslashes}</h4>{/if}
		
		<div class="{if $footercontent->body_title}toggle-footer{/if} clearfix">
			{if $footercontent->body_paragraph}<article class="rte">{$footercontent->body_paragraph|stripslashes}</article>{/if}
		</div>	</div>
	</section>
<!-- /Module footer content-->
