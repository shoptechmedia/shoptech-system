var HomeOptionsId = 'HomeOptions';
var Loaded = 0;
var HasHomeDelivery = false;
var prevIdCarrier = 0;

var Options = function(){
	var Row = document.createElement('tr');
		Row.id = HomeOptionsId;

	var Column = document.createElement('td');
		Column.colSpan = '4';

	$.each(STMHD_AREAS, function(i, arr){

		var extra = arr[1];
		var name = arr[0];

		var total_cost = formatCurrency(parseFloat(STMHD_SHIPPING_COST) + parseFloat(extra), currencyFormat, currencySign, currencyBlank);

		var area = document.createElement('label');
			area.innerHTML = arr[0] + '<span>' + (total_cost) + '</span>';

			area.addEventListener('click', function(){
				var t = this;

				$.ajax({
					url: window.location.href,
					type: 'POST',

					data: {
						addExtraShipping: 1,
						extraShipping: extra,
						extraShippingName: name
					},

					success: function(){
						SelectedHomeOption = name;
						$('#' + HomeOptionsId).find('.active').removeClass('active');
						t.className = 'active';

						ajaxCart.refresh();
						updateCarrierSelectionAndGift();
					}
				});
			});

			// alert(SelectedHomeOption);
			if(SelectedHomeOption == arr[0])
				area.className = 'active';

		Column.appendChild(area);

	});

		Row.appendChild(Column);

	return Row;

};

var HasHomeDelivery = function(){
	var postcode = $('#postcode').val();
	var HasHomeDelivery = false;

	$.each(STMHD_POSTAL_CODES, function(i, arr){

		if(postcode >= arr[0] && postcode <= arr[1])
			HasHomeDelivery = true;

	});

	$('.carrier_action > input').each(function(){
		var t = this;
		var that = $(t).parent().parent();
		var val = t.value;
		var HomeOptions = $('#' + HomeOptionsId).length;

		if (val.indexOf(STMHD_CARRIER) === 1){
			that.addClass('HomeDelivery');
		}
	});

	return HasHomeDelivery;
}

var updateCarrierSelectionAndGift = function() {
    var recyclablePackage = 0;
    var gift = 0;
    var giftMessage = '';
    var idCarrier = 0;

    if ($('input#recyclable:checked').length)
        recyclablePackage = 1;
    if ($('input#gift:checked').length) {
        gift = 1;
        giftMessage = encodeURIComponent($('textarea#gift_message').val());
    }

    // If ps default carrier selection is ON
    if (opc_default_ps_carriers) {
        var delivery_option_radio = $('.delivery_option_radio');
        var delivery_option_params = '';
        $.each(delivery_option_radio, function (i) {
            if ($(this).prop('checked'))
                delivery_option_params = $(delivery_option_radio[i]).val();
        });
        if (delivery_option_params != '') {
            idCarrier = Cart_intifier(delivery_option_params);
        }
    }else if ($('input[name=id_carrier]:checked').length) {
        idCarrier = $('input[name=id_carrier]:checked').val();
        checkedCarrier = idCarrier;
    }

    if(!HasHomeDelivery() && idCarrier.indexOf(STMHD_CARRIER) === 1){
    	idCarrier = 33780000;
    }

    if (typeof setPersonalDetailsCarrier == 'function')
        setPersonalDetailsCarrier(); // handle order review detail boxes (German law since 1.8.2012)

    var additionalParams = _getAdditionalUrlParams();
    if (orderOpcUrl.match(/\?/) === null)
        additionalParams = '?' + additionalParams.substr(1);

    $('#opc_delivery_methods-overlay').show();//fadeIn('fast');
    $('#opc_payment_methods-overlay').fadeIn();
    $.ajax({
        type:'POST',
        url:orderOpcUrl + additionalParams,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&method=updateCarrierAndGetPayments&id_carrier=' + idCarrier + '&recyclable=' + recyclablePackage + '&gift=' + gift + '&gift_message=' + giftMessage + '&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.hasError) {
                var errors = '';
                for (error in jsonData.errors)
                    //IE6 bug fix
                    if (error != 'indexOf')
                        errors += jsonData.errors[error] + "\n";
                alert(errors);
            }
            else {
                if (typeof updateCartSummary == 'function') updateCartSummary(jsonData.summary);
                // Estonian post24 and smartpost update
                updateCarrierList(jsonData.carrier_data); 
                
                if (onlyCartSummary == '0') {
                    updatePaymentMethods(jsonData);
                    updateHookShoppingCart(jsonData.summary.HOOK_SHOPPING_CART);
                    updateHookShoppingCartExtra(jsonData.summary.HOOK_SHOPPING_CART_EXTRA);
                }
                // todo: v pov. checkoute sa tu este updatuje carrierList a deliveryOptions, je to potrebne vobec??
                $('#opc_payment_methods-overlay').fadeOut('slow');
                $('#opc_delivery_methods-overlay').fadeOut('slow');

                if (onlyCartSummary == '0') {
                    setPaymentModuleHandler();
                }

                $('.DelayPopupForCarrier').addClass('hidden');
                $('#DelayPopupForCarrier_' + idCarrier).removeClass('hidden');

				if(!HasHomeDelivery()){
					$('.HomeDelivery').fadeOut();
					$('#' + HomeOptionsId).fadeOut();
				}else{
					$('.HomeDelivery').fadeIn();
					$('#' + HomeOptionsId).fadeIn();
				}
            }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to save carrier \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            $('#opc_payment_methods-overlay').fadeOut('slow');
            $('#opc_delivery_methods-overlay').fadeOut('slow');
        }
    });
}

// getPostCode();

$(document).ajaxComplete(function(event, xhr, settings){
	if(typeof settings.data != 'undefined' && settings.data.indexOf('zipCheck') > -1){
		updateCarrierSelectionAndGift();
	}

	if(typeof xhr.responseJSON != 'undefined' && typeof xhr.responseJSON.summary != 'undefined' && typeof xhr.responseJSON.summary.carrier != 'undefined'){
		var carrier = xhr.responseJSON.summary.carrier;

		if(carrier.id == STMHD_CARRIER){
			$('.carrier_action > input').each(function(){
				var t = this;
				var that = $(t).parent().parent();
				var val = t.value;
				var HomeOptions = $('#' + HomeOptionsId).length;

				if (val.indexOf(carrier.id) === 1 && HomeOptions < 1){
					that.after(Options);
				}
			});

		}else{
			$('#' + HomeOptionsId).remove();
		}
	}
});