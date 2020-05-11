<style type="text/css">
	#PostalCodes .row{
		margin-bottom: 5px;
	}

	#AddPostalCode{
		position: absolute;
		bottom: 9px;
		left: 67%;
	}
</style>

<div class="row">
	<div class="col-xs-10 col-sm-8" id="PostalCodes">
		{foreach $postal_codes as $postal_code}
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<input type="text" name="zip_range_min[]" value="{$postal_code[0]}" placeholder="Min" />
			</div>

			<div class="col-xs-12 col-sm-5">
				<input type="text" name="zip_range_max[]" value="{$postal_code[1]}" placeholder="Max" />
			</div>

			<div class="col-xs-12 col-sm-1">
				<button class="hidden RemovePostalCode" type="button" onclick="RemovePostalCode(this);">-</button>
			</div>
		</div>
		{/foreach}

		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<input type="text" name="zip_range_min[]" value="" placeholder="Min" />
			</div>

			<div class="col-xs-12 col-sm-5">
				<input type="text" name="zip_range_max[]" value="" placeholder="Max" />
			</div>

			<div class="col-xs-12 col-sm-1">
				<button class="hidden RemovePostalCode" type="button" onclick="RemovePostalCode(this);">-</button>
			</div>
		</div>
	</div>

	<div class="col-xs-2 col-sm-4" style="position: static;">
		<button id="AddPostalCode" type="button">+</button>
	</div>
</div>

<script type="text/javascript">

class _PostalCodes {

	constructor(){

		this.container = $('#PostalCodes');

		this.count = this.container.find('.row').length;

	}

	updateCount(){

		this.count = this.container.find('.row').length;

		if(this.count <= 1){
			$('.RemovePostalCode').addClass('hidden').prop('disabled', true);
		}else{
			$('.RemovePostalCode').removeClass('hidden').prop('disabled', false);
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

var PostalCodes = new _PostalCodes();
	PostalCodes.updateCount();

var RemovePostalCode = function(t){
	PostalCodes.remove(t);
}

var AddPostalCodeBtn = $('#AddPostalCode');

	AddPostalCodeBtn.on('click', function(){
		PostalCodes.add();
	});

</script>