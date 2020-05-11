<!-- Testimonial Admin Module -->
<div class="panel col-md-12">
	<div class="testimonial_tabs col-md-12 pull-right">
		<div class="title col-md-1">
			<p><strong>{l s='Testimonials' mod='testimonial'}</strong></p>
		</div>
		<div class="action_wrap col-md-9">
			{foreach $tabs as $tab}
			<a href="{$cur_url}&module_action={$tab}">{l s='add new' mod='testimonial'}</a>
			{/foreach}
		</div>
	</div>
	<div class="testimonial_list_wrap">
		<div class="col-md-12 wrap title_tabs">
			<div class="col-md-1 width-small text-center"></div>
			<div class="col-md-2">{l s='Name' mod='testimonial'}</div>
			<div class="col-md-2">{l s='Affillation' mod='testimonial'}</div>
			<div class="col-md-5 ">{l s='Testimony' mod='testimonial'}</div>
			<div class="col-md-1">{l s='Action' mod='testimonial'}</div>
		</div>

		{foreach $testimonials as $testimonial}
		<div class="col-md-12 wrap testimonyItems"><!--  draggable="true" ondragstart="dragstart_handler(event);" ondragover="allowDrop(event)" ondrop="drop(event)" id="{$testimonial['id']}" ondragleave="push(event)" data-id="{$testimonial['position']}" -->
			<form method="post">
				<div class="col-md-2 width-small text-center"><input type="checkbox"><!-- <div class="drag_icon"><i class="fa fa-arrows" aria-hidden="true"></i></div> --></div>
				<div class="col-md-2">{$testimonial['name']}</div>
				<div class="col-md-2">{$testimonial['affillation']}</div>
				<div class="col-md-5 testimony_content_wrap">{$testimonial['testimony']}</div>
			</form>
			<button class="btn btn-default delete">{l s='Delete' mod='testimonial'}</button><a href="{$cur_url}&module_action=edit&testimonial_id={$testimonial['id']}" class="btn btn-default edit">{l s='Edit' mod='testimonial'}</a>
		</div>
		{/foreach}
	</div>
</div>