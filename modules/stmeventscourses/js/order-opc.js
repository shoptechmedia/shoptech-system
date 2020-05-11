if (!Date.now) {
	Date.now = function now() {
		return new Date().getTime();
	};
}

setTimeout(function(){
	$.each(cannotModifyProduct, function(id_product, parameters){
		$('[id^="product_' + id_product + '"]').find('.cart_quantity').html(parameters.q);

		if(parameters.i){
			$('[id^="product_' + id_product + '"] img').attr({
				src: parameters.i,
				width: 80
			});
		}
	});

	$('.deleteSTMCartItem').click(function(){
		var id_item = $(this).data('id_item');

		$.ajax({
			url: '/events',
			type: 'POST',
			data: {
				DeleteSTMCartItem: 1,
				id_item: id_item
			},

			success: function(){
				window.location.reload();
			}
		});

		$('.stm_item_' + id_item).remove();
	});
}, 1);