if (!Date.now) {
	Date.now = function now() {
		return new Date().getTime();
	};
}

$(function(){
	$('.STMShowPopup').click(function(){
		var that = this;
		var $_that = $(that);

		$('.STMPopup').addClass('hidden');

		$('.STMReserve_default').prop('checked', false);

		var popup = that.parentNode.querySelector('.STMPopup');
			popup.classList.remove('hidden');

		$_that.parent().find('.STMReserve_default').prop('checked', true);
	});

	$('.STMClose').click(function(){
		var that = this;
		var $_that = $(that);

		that.parentNode.classList.add('hidden');
	});

	$('.STMReserveNow').click(function(){
		var STMPack = $(this).parentsUntil('.button-container').find('.STMPack');
		var isPack = STMPack.prop('checked');
		var idPack = STMPack.data('id_pack');

		if(isPack){
			var Dates = [];
			$(this).parent().find('.STMReserve:checked').each(function(){
				Dates.push(this.value);
			});

			$.ajax({
				url: window.location.href,
				type: 'GET',
				data: {
					STMReservationDate: Dates,
					id_product: idPack
				},

				success: function(res){
					console.log(res);
				}
			});

			var add = ajaxCart.add(idPack, 0, false, this, 1);
		}else{
			$(this).parent().find('.STMReserve').each(function(){
				var that = this;
				var $_that = $(that);
				var idProduct = $_that.data('id_product');
				var isChecked = $(this).prop('checked');

				if(isChecked){
					$.ajax({
						url: window.location.href,
						type: 'GET',
						data: {
							STMReservationDate: this.value,
							id_product: idProduct
						},

						success: function(res){
							console.log(res);
						}
					});

					var add = ajaxCart.add(idProduct, 0, false, this, 1);

					return false;
				}
			});
		}
	});

	$('.STMPack').click(function(){
		var isChecked = $(this).prop('checked');

		if(isChecked){
			$(this).parent().siblings('.STMAdditionalDates').removeClass('hidden');
		}else{
			$(this).parent().siblings('.STMAdditionalDates').addClass('hidden');
		}
	});

	$('.STMReschedule').click(function(){
		var id_reservation = $(this).data('id_reservation');
		var available_reservation = $(this).data('available_reservation');
		var id_reservation_date = $(this).val();

		window.location.href = '/reservations?STMReschedule=1&id_reservation=' + id_reservation + '&available_reservation=' + available_reservation + '&id_reservation_date=' + id_reservation_date;
	});

	$('.EventsDescription-more').click(function(){
		var t = this;
		var that = $(t);
		var EventsDescription = that.siblings('.EventsDescription');

		var hide = EventsDescription.hasClass('showAll');

		var originalTextContent = that.attr('originalTextContent');
		var alternateTextContent = that.attr('alternateTextContent');

		if(hide == true){
			EventsDescription.removeClass('showAll');
			that.children('span').text(originalTextContent);
		}else{
			EventsDescription.addClass('showAll');
			that.children('span').text(alternateTextContent);
		}
	});

	$('.STM_LOGIN_POPUP').click(function(e){
		e.preventDefault();

		var href = 'https://www.nail4you.dk/login?back=my-account&content_only=1';

		var content  = '';
			content += '<p>' + YouMustLogin + '</p>';
			content += '<a class="btn btn-default button button-small" href="/my-account"><span>OK</span></a>';

		$.fancybox({
			type: 'inline',
			content: content,
			height: '433px'
		});
	});
});

$(window).load(function(){
	$.uniform.restore(".STMReserve");
});