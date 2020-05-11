if (!Date.now) {
	Date.now = function now() {
		return new Date().getTime();
	};
}

$(function(){
	$('.STM_GroupP').each(function(){
		var STM_GroupP_Fields = $(this).find('.STM_GroupP_Fields');
		var default_id_product = id_product;

		var changedCombination = function(){

			var selectedIds = [];
			var SelectNum = 0;

			STM_GroupP_Fields.each(function(){
				var ids = $(this).val().split(',');

				if(ids.length > 1){
					SelectNum++;
				}

				$.each(ids, function(c, id){

					if(id > 0){
						selectedIds.push(id);
					}

				});
			});

			// STM_GroupP_Fields.find('option').prop('disabled', true);

			var scores = {};

			$.each(selectedIds, function(i, id){
				if(typeof scores[id] == 'undefined')
					scores[id] = 1;
				else
					scores[id]++;
			});

			$.each(scores, function(id, score){
				if(score != SelectNum){
					delete scores[id];
				}else{
					if(SelectNum == STM_GroupP_Fields.length){
						id_product = id;
					}else{
						id_product = default_id_product;
					}
				}
			});

			if(jQuery.isEmptyObject(scores)){
				id_product = default_id_product;

				$(this).siblings('.STM_GroupP_Fields').prop('selectedIndex', 0);

				STM_GroupP_Fields.find('option').css('display', 'inline');

				changedCombination();
			}else{
				STM_GroupP_Fields.find('option').each(function(){
					var option = $(this);
					var selected = option.parent().val();
					var ids = option.val().split(',');
					var display = 'none';

					if(ids == 0 || (selected != 0)){
						display = 'inline';
					}

					$.each(ids, function(c, id){

						if(typeof scores[id] != 'undefined') {
							display = 'inline';
						}

					});

					option.css('display', display);
				});
			}

			$('#product_page_product_id').val(id_product);
			$('#our_price_display').text(dropdown_prices[id_product]);
		};

		STM_GroupP_Fields.change(changedCombination);

		$(this).find('#STM_GroupP_Reset').click(function(){
			id_product = default_id_product;

			STM_GroupP_Fields.find('option').css('display', 'inline');
			STM_GroupP_Fields.prop('selectedIndex', 0);

			$('#our_price_display').text(dropdown_prices[id_product]);
		});
	});
});