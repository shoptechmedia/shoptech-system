window.addEventListener('load', function(){
	if(typeof id_holiday_sale == 'undefined'){
		return false;
	}

	if(id_holiday_sale > 0){
		document.getElementById('module_form').classList.add('open');
	}

	$('#add_new_page').on({
		click: function(e){
			e.preventDefault();

			document.getElementById('module_form').classList.add('open');
		}
	});

	$('.edit_holiday_page').click(function(e){
		e.preventDefault();

		let id_holiday_sale = $(this).data('id_holiday_sale');

		window.location.href = window.location.href + '&editHolidaySale&id_holiday_sale=' + id_holiday_sale;
	});

	$('.delete_holiday_page').on({
		click: function(e){
			e.preventDefault();

			let id_holiday_sale = $(this).data('id_holiday_sale');

			window.location.href = window.location.href + '&deleteHolidaySale&id_holiday_sale=' + id_holiday_sale;
		}
	});

	$('#module_form').attr('action', window.location.href);

	$('.mColorPicker').removeAttr('style');

	$('.delete_banner_image').on('click', function(){
		$('#banner_image_visual_aid').remove();
		$(this).remove();

		$.ajax({
			url: window.location.href,
			type: 'POST',
			data: {
				ajax: 1,
				delete_banner_image: 1
			}
		});
	});
});

function deleteTreeItem(id_product){
	$('.productTree_' + id_product + ' .productTree_checkbox').click();
}

var searchProducts = null;

function setSelectedProducts(){
	if(searchProducts != null)
		searchProducts.abort();

	var id_supplier = $('#HolidaySaleSuppliers').val();
	var id_manufacturer = $('#HolidaySaleManufacturer').val();
	var name_filter = $('#productSearchFilter').val();

	var categories = [];

	$('#HolidaySaleCategoryTree input[type="checkbox"]:checked').each(function(){
		categories.push(this.value);
	});

	$('#chooseProducts .productTree_checkbox:not(:checked)').prop('disabled', true);

	searchProducts = $.ajax({
		url: window.location.href,
		type: 'POST',
		dataType: 'json',
		data: {
			ajax: 1,
			getProducts: 1,
			id_supplier: id_supplier,
			id_manufacturer: id_manufacturer,
			categories: categories,
			name_filter: name_filter
		},

		success: function(products){

			$('#chooseProducts .productTree_item').addClass('hidden');

			$.each(products, function(i, product){
				$('#chooseProducts .productTree_' + product.id).removeClass('hidden');
				$('#chooseProducts .productTree_' + product.id + ' .productTree_checkbox').prop('disabled', false);
			});

		}
	});
}

function clickCheckboxes(checkboxes, i, callback){
	$(checkboxes[i]).click();

	if(checkboxes.length > i) {
		setTimeout(function(){
			clickCheckboxes(checkboxes, i+1, callback);
		}, 1);
	} else {
		callback();
	}
}

function DeleteDiscount(id, that) {
	$.fancybox.showLoading();

	$.ajax({
		url: window.location.href,
		type: 'POST',
		// dataType: 'json',
		data: {
			ajax: 1,
			DeleteDiscount: 1,
			id_specific_price: id
		},

		success: function(products){
			$(that).parent().remove();
			$.fancybox.hideLoading();
		}
	});
}

$(function(){
	var selectedProducts = $('#selectedProducts');

	$('.productTree_checkbox').on('click', function(){
		var t = this;
		var that = $(t);

		var id_product = this.value;

		var isChecked = that.prop('checked');

		if(isChecked){
			var product_name = that.parent().text();

			var selectedProduct = '';

				selectedProduct += '<label class="productTree_item active productTree_' + id_product + '">';

					selectedProduct += '<span onclick="deleteTreeItem(\'' + id_product + '\')" class="deleteTreeItem">x</span>';

					selectedProduct += product_name;

				selectedProduct += '</label>';


			selectedProducts.append(selectedProduct);
		}else{
			selectedProducts.find('.productTree_' + id_product).remove();
		}

	});

	$('#HolidaySaleManufacturer, #HolidaySaleSuppliers').change(setSelectedProducts);

	$('#HolidaySaleCategoryTree input[type="checkbox"]').click(setSelectedProducts);

	$(document).ajaxComplete(function(event, xhr){
		$('#HolidaySaleCategoryTree input[type="checkbox"]').unbind('click', setSelectedProducts).bind('click', setSelectedProducts);
	});

	$('#productSearchFilter').keyup(setSelectedProducts);

	$('#selectAllProducts').click(function(){
		var t = this;
		var that = $(t);

		that.prop('disabled', true);
		$('#addDiscount').prop('disabled', true);

		var isChecked = that.prop('checked');

		var checkboxes;

		if(isChecked)
			checkboxes = $('#chooseProducts .productTree_item:not(.hidden) .productTree_checkbox:not(:checked)');
		else
			checkboxes = $('#chooseProducts .productTree_item:not(.hidden) .productTree_checkbox:checked');

		selectedProducts.find('.loading').fadeIn();

		clickCheckboxes(checkboxes, 0, function(){
			that.prop('disabled', false);
			$('#addDiscount').prop('disabled', false);
			selectedProducts.find('.loading').fadeOut();
		});
	});

	$('#selectAllCustomers').click(function(){
		var t = this;
		var that = $(t);

		var isChecked = that.prop('checked');

		if(isChecked)
			$('#chooseCustomers .customerTree_item:not(.hidden) .customer_checkbox:not(:checked)').click();
		else
			$('#chooseCustomers .customerTree_item:not(.hidden) .customer_checkbox:checked').click();
	});

	$('#addDiscount').click(function(){

		var products = [];

		var id_holiday_sale = $('#holiday_page').val();
		var id_currency = $('#HolidaySaleCurrencies').val();
		var id_country = $('#HolidaySaleCountries').val();
		var id_group = $('#HolidaySaleGroups').val();

		var reduction_type = $('#reduction_type').val();
		var reduction_amount = $('#reduction_amount').val();
		var starting_amount = $('#starting_amount').val();
		var with_tax = $('#with_tax').val();

		$('.productTree_checkbox:checked').each(function(){
			products.push(this.value);
		});

		console.log(products);

		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'json',
			data: {
				ajax: 1,
				addDiscounts: 1,

				products: products,

				id_holiday_sale: id_holiday_sale,
				id_currency: id_currency,
				id_country: id_country,
				id_group: id_group,

				starting_amount: starting_amount,
				reduction_type: reduction_type,
				reduction_amount: reduction_amount,
				with_tax: with_tax
			},

			success: function(res){
				window.location.reload();
			}
		});

	});

	$('#clearDiscount').click(function(){

		var id_holiday_sale = $('#holiday_page2').val();

		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'json',
			data: {
				ajax: 1,
				clearDiscount: 1,
				id_holiday_sale: id_holiday_sale
			},

			success: function(res){
				window.location.reload();
			}
		});

	});

	$('.productTree_item a').click(function(e){

		e.preventDefault();

		var id_product = $(this).data('id_product');

		$.fancybox.showLoading();

		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'json',
			data: {
				ajax: 1,
				getDiscounts: 1,
				id_product: id_product
			},

			success: function(specificPrices){

				if(specificPrices.length > 0){
					var html = '<div class="ProductDiscounts bootstrap" style="width: 95%;">';

							html += '<div class="row">';

								html += '<div class="col-xs-6"><strong>Holiday</strong></div>';

								html += '<div class="col-xs-2"><strong>Discount</strong></div>';

								html += '<div class="col-xs-2"><strong>Type</strong></div>';

							html += '</div>';

						$.each(specificPrices, function(i, specificPrice) {
							html += '<div class="row">';

								html += '<div class="col-xs-6"><strong>' + specificPrice.holiday + '</strong></div>';

								html += '<div class="col-xs-2">' + specificPrice.reduction + '</div>';

								html += '<div class="col-xs-2">' + specificPrice.reduction_type + '</div>';

								html += '<div style="color: red;cursor: pointer;" onclick="DeleteDiscount(' + specificPrice.id + ', this)" class="col-xs-2">Delete</div>';

							html += '</div>';
						});

						html += '</div>';

					$.fancybox({
						type: 'html',
						content: html,
						autoSize: false,
						autoHeight: true,
						width: 700,
						leftRatio: 0.8,
						helpers:  {
							overlay : null
						}
					});
				}else{
					// var html = '<strong>There are no holiday discounts for this product</strong>';

					// setTimeout(function(){
						$.fancybox.close();
						$.fancybox.hideLoading();
					// }, 1500);
				}

				/*$.fancybox({
					type: 'html',
					content: html,
					autoSize: false,
					autoHeight: true,
					width: 700,
					leftRatio: 0.8,
					helpers:  {
						overlay : null
					}
				});*/
			}
		});

	});

});