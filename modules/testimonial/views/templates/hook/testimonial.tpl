<div class="testimonial_wrap">
	<div class="testimonial_title">
		<h1>{l s='What Our Customers says' mod='testimonial'}</h1>
	</div>
	<div class="testimonial_slider">
		{foreach $lists as $list}
			<div class="testimonial" id="{$list['id']}" style="display: none;">
				<div class="text_wrap">{htmlspecialchars_decode(stripslashes($list['testimony']))}</div>
				<p class="user_wrap">{$list['name']}, <span>{$list['affillation']}</span></p>
				
			</div>
		{/foreach}
		<div class="testimonial_slider_wrap">
			<div><span class="text_display"></span></div>
			<div class="user_info"></div>
		</div>
	</div>
</div>