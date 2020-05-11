// GLOBAL ACTIONS
$(function(){
	var AddDropdownForm = $('#AddDropdownForm');

	$('.eventTabs .list-group-item').on({
		click: function(e){
			e.preventDefault();

			var that = this;
			var target = $(that).attr('href');

			$('.eventTabs .list-group-item.active').removeClass('active');
			$('.event-tab-content.active').removeClass('active');

			this.classList.add('active');
			document.querySelector(target).classList.add('active');
		}
	});

	$('.ShowForm').click(function(){
		var target = $(this).data('target');

		$('#' + target).removeClass('hidden');
	});

	$('.CloseForm').click(function(){
		this.parentNode.parentNode.classList.add('hidden');

		AddDropdownForm.find('input, textarea').val('');
		AddDropdownForm.find('input[type="hidden"]').remove();
	});

	hideOtherLanguage(id_language);
});

// FOR DROPDOWN OPTIONS
$(function(){
	var AddDropdownForm = $('#AddDropdownForm');

	$('#saveDropdown').click(function(){
		var fields = AddDropdownForm.find('input, textarea');

		var data = {};

		fields.each(function(c, field){
			data[ this.name ] = this.value;
		});

		data.id_product = id_product;

		if(data.id_dropdown > 0){
			data.action = 'Dropdown-Edit';
		}else{
			data.action = 'Dropdown-New';
		}

		$.ajax({
			url: '/modules/customcombinations/save.php',
			type: 'POST',
			data: data,

			success: function(res){
				history.pushState(null, '', currentIndex + '&id_product=' + id_product + '&updateproduct=&token=' + token + '&key_tab=ModuleCustomcombinations');

				$('#RefreshDropdowns').click();

				AddDropdownForm.addClass('hidden');
				AddDropdownForm.find('input, textarea').val('');
				AddDropdownForm.find('input[type="hidden"]').remove();
			}
		});
	});

	$('.EditDropdown').bind('click', function(e){
		e.preventDefault();

		var href = this.href;
			href += '&ajax=1';

		$.ajax({
			url: href,

			success: function(res){
				var form = $(res).find('#AddDropdownForm .panel-body');
					form.find('.translatable-field.row').hide();
					form.find('.lang-' + id_language).show();

				var html = form.html();

				$('#AddDropdownForm .panel-body').html(html);
				$('#AddDropdownForm').removeClass('hidden');
			}
		});
	});

	$('.DeleteDropdown').bind('click', function(e){
		e.preventDefault();

		var href = this.href;

		$.ajax({
			url: href
		});
	});

	$('.Dropdown_Item_Use').click(function(){
		var t = this;
		var that = $(t);
		var checked = that.prop('checked');
		var id_dropdown = this.value;

		var action = 'Dropdown-Add-Product';

		if(!checked){
			var action = 'Dropdown-Delete-Product';
		}

		$.ajax({
			url: '/modules/customcombinations/save.php',
			type: 'POST',
			data: {
				action: action,
				id_product: id_product,
				id_dropdown: id_dropdown,
				id_lang: id_language
			}
		});
	});
});

// FOR COMBINATIONS
$(function(){
	var product_autocomplete_input = $('#product_autocomplete_input_4');
	var divGroupP = $('#divGroupP');
	var GroupProductList = $('#GroupProductList');

	var CombinationPanel = $('#CombinationPanel');

	var EditCombination = $('.EditCombination');
	var DeleteCombination = $('.DeleteCombination');

	var addAccessory = function (event, data, formatted) {
		if (typeof data === 'undefined') {
			return;
		}

		var productId = data[1];
		var productName = data[0];

		var invidGroupP = '<div class="form-control-static">';

				invidGroupP += '<h4>' + productName + '</h4>';

				invidGroupP += '<input type="hidden" class="GroupPField" name="id_sub_product" value="' + productId + '">';

				invidGroupP += '<div class="form-group">Visibility: ';

					invidGroupP += '<select class="dropdown GroupPField" name="visibility">';

						invidGroupP += '<option value="both" selected="selected">Overalt</option>';
						invidGroupP += '<option value="catalog">Oversigt</option>';
						invidGroupP += '<option value="search">Søgning</option>';
						invidGroupP += '<option value="none">Ingen steder</option>';

					invidGroupP += '</select>';

				invidGroupP += '</div>';

			invidGroupP += '</div>';

		divGroupP.append(invidGroupP);

		product_autocomplete_input.val('');
		product_autocomplete_input.prop('disabled', true);
	};

	product_autocomplete_input.autocomplete('ajax_products_list.php?exclude_packs=0&excludeVirtuals=0', {
		minChars: 1,
		autoFill: true,
		max: 20,
		matchContains: true,
		mustMatch: false,
		scroll: false,
		cacheLength: 0,

		formatItem: function (item) {
			return item[1] + ' - ' + item[0];
		}
	}).result(addAccessory);

	product_autocomplete_input.setOptions({
		extraParams: {
			excludeIds: 1
		}
	});

	EditCombination.click(function(){
		var t = this;
		var that = $(t);

		var id_value = that.data('id_value');

		divGroupP.append('<input class="GroupPField" type="hidden" name="id_value" value="' + id_value + '"/>');

		CombinationPanel.removeClass('hidden');

		$('html, body').scrollTop(0);
	});

	DeleteCombination.click(function(){
		var t = this;
		var that = $(t);
		var data = {};
			data.id_value = that.data('id_value');
			data.id_product = id_product;
			data.action = 'GroupProduct-Delete';

		console.log(data);

		$.ajax({
			url: '/modules/customcombinations/save.php',
			type: 'POST',
			data: data,

			success: function(res){
				$('#Combination-' + data.id_value).find('.name').text('');
			}
		});
	});

	$('#SaveCombination').click(function(){
		var GroupPFields = divGroupP.find('.GroupPField');

		var productName = divGroupP.find('h4').text();
		var data = {};

		GroupPFields.each(function(c, GroupPField){
			var name = GroupPField.name;
			var value = $(this).val();

			data[name] = value;
		});

		data.id_product = id_product;
		data.action = 'GroupProduct-New';

		$.ajax({
			url: '/modules/customcombinations/save.php',
			type: 'POST',
			data: data,
			dataType: 'json',

			success: function(name){
				divGroupP.html('');
				product_autocomplete_input.prop('disabled', false);
				CombinationPanel.addClass('hidden');

				$('#Combination-' + data.id_value).find('.name').text(name[id_language]);
			}
		});
	});
});