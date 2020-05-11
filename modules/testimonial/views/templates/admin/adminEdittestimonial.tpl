<div class="panel">
	<a class="hidden redirect" href="index.php?controller=AdminModules&configure=testimonial&token={$token}"><button>a</button></a><!-- /index.php?controller=AdminModules&configure=testimonial&token={$token} -->
	<div class="add_testimonial">
		<form method="post">
			{foreach $cur_item as $item}
			<label for="name">{l s='Name' mod='testimonial'}:</label>
			<input type="text" name="name" value="{$item['name']}" placeholder="Name" id="testimonial_name">
			<label for="affiliation">{l s='Affiliation' mod='testimonial'}:</label>
			<input type="text" name="affiliation" value="{$item['affillation']}" placeholder="Affiliation" id="testimonial_affiliate">
			<label for="testimonial_content">{l s='Testimony' mod='testimonial'}:</label>
			<textarea name="testimonial_content" value="" id="testimonial_content" cols="50" rows="5">{$item['testimony']}</textarea>
			{/foreach}
		</form>
		<div class="panel-footer testimonial_btns">
			<a href="index.php?controller=AdminModules&configure=testimonial&token={$token}" class="btn btn-default"><i class="process-icon-cancel"></i> Cancel</a>
			<button type="submit" id="editTestimonial" class="btn btn-default pull-right"><i class="process-icon-save"></i>{l s='Update'  mod='testimonial'}</button>
		</div>
	</div>
</div>