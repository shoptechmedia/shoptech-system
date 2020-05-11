<style type="text/css">
	#Areas .row{
		margin-bottom: 5px;
	}

	#AddArea{
		position: absolute;
		bottom: 9px;
		left: 67%;
	}
</style>

<div class="row">
	<div class="col-xs-10 col-sm-8" id="Areas">
		{foreach $areas as $area}
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<input type="text" name="delivery_areas[]" value="{$area[0]}" placeholder="{l s='Area Name' mod='stmhomedelivery'}" />
			</div>

			<div class="col-xs-12 col-sm-5">
				<input type="text" name="delivery_costs[]" value="{$area[1]}" placeholder="{l s='Added Shipping Cost' mod='stmhomedelivery'}" />
			</div>

			<div class="col-xs-12 col-sm-1">
				<button class="hidden RemoveArea" type="button" onclick="RemoveArea(this);">-</button>
			</div>
		</div>
		{/foreach}

		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<input type="text" name="delivery_areas[]" value="" placeholder="{l s='Area Name' mod='stmhomedelivery'}" />
			</div>

			<div class="col-xs-12 col-sm-5">
				<input type="text" name="delivery_costs[]" value="" placeholder="{l s='Added Shipping Cost' mod='stmhomedelivery'}" />
			</div>

			<div class="col-xs-12 col-sm-1">
				<button class="hidden RemoveArea" type="button" onclick="RemoveArea(this);">-</button>
			</div>
		</div>
	</div>

	<div class="col-xs-2 col-sm-4" style="position: static;">
		<button id="AddArea" type="button">+</button>
	</div>
</div>

<script type="text/javascript">

class _Areas {

	constructor(){

		this.container = $('#Areas');

		this.count = this.container.find('.row').length;

	}

	updateCount(){

		this.count = this.container.find('.row').length;

		if(this.count <= 1){
			$('.RemoveArea').addClass('hidden').prop('disabled', true);
		}else{
			$('.RemoveArea').removeClass('hidden').prop('disabled', false);
		}

	}

	add (){

		var EmptyFields = this.container.find('.row:last-child').clone();
			EmptyFields.find('input').val('');

		this.container.append(EmptyFields);

		this.updateCount();

	}

	remove (t){
		$(t).parent().parent().remove();

		this.updateCount();
	}

}

var Areas = new _Areas();
	Areas.updateCount();

var RemoveArea = function(t){
	Areas.remove(t);
}

var AddAreaBtn = $('#AddArea');

	AddAreaBtn.on('click', function(){
		Areas.add();
	});

</script>