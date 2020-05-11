/**
* 2013-2014 2N Technologies
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to contact@2n-tech.com so we can send you a copy immediately.
*
* @author    2N Technologies <contact@2n-tech.com>
* @copyright 2013-2014 2N Technologies
* @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

$(document).ready( function ()
{
	init_datetimepicker();

    $('#filter_supplier').select2({
        width: 'resolve',// Force with to the original select with
        placeholder: placeholder_supplier,
    });

    $('#filter_manufacturer').select2({
        width: 'resolve',// Force with to the original select with
        placeholder: placeholder_manufacturer,
    });

    // Prevent browser suggestion
    $('#suppliers_filter input').each(function(){
        $(this).attr('autocomplete', 'new-supplier');
    });

    // Prevent browser suggestion
    $('#manufacturers_filter input').each(function(){
        $(this).attr('autocomplete', 'new-manufacturer');
    });

	$('#nt_tab a').click(function()
	{
		ntTab($(this));

        var id = $(this).attr('id');

        if (id != 'nt_tab1' && id != 'nt_tab3') {
            $('#products_list').hide();
        } else {
            $('#products_list').show();
        }
	});

	$(save_btn_id).click(function(){
        if (confirm(confirm_save_reduction)) {
            save_reduction();
        }
	});

	$('.form_config input').change(function()
	{
        var name    = $(this).attr('name');
        var value   = $(this).val();

        if (parseInt(value) === 0) {
            $('#ntreduction #products_list .'+name).addClass('hide');
			columns_to_hide.push(name);
        } else {
            $('#ntreduction #products_list .'+name).removeClass('hide');
			columns_to_hide.splice(columns_to_hide.indexOf(name), 1);
        }

        refresh_head_columns();
	});

	/*$('#categories').click(function(e){
		//we get the clicked element (not $(this) which is the block of all categories)
		var el= e.target||event.srcElement;

		if (el.type == 'checkbox') {
			load_product();
		}
	});

	$(check_all_categories).click(function(){
        setTimeout(function()
        {
           load_product();
        }, 1000); // Need to slow it down so that the boxes are checked when we load the products
	});

	$(uncheck_all_categories).click(function(){
		setTimeout(function()
        {
           load_product();
        }, 1000); // Need to slow it down so that the boxes are unchecked when we load the products
	});

	$('#reduction_shop').change(function(){
		load_product();
	});

	$('#reduction_currency').change(function(){
		load_product();
	});

	$('#reduction_country').change(function(){
		load_product();
	});

	$('#reduction_group').change(function(){
		load_product();
	});

	$('#active').change(function(){
		load_product();
	});

	$('#discounted').change(function(){
		load_product();
	});

	$('#filter_supplier').change(function(){
		load_product();
	});

	$('#filter_manufacturer').change(function(){
		load_product();
	});*/

	$('#nt_reduction_search_submit').click(function(){
		load_product();
	});

	$('#nt_reduction_search').keypress(function(e){
		var key = (e.keyCode ? e.keyCode : e.which);

		if (key == 13)
		{
			e.preventDefault();
			//load_product();
		}
	});

	$('.p1_unique_discount').change(function(){
		var value = $(this).val();

		if (value !== '') {
			$(this).parent().parent().find('.p1_unique_discount').val('');
			$(this).val(value);
		}
	});

	$('.p2_unique_discount').change(function(){
		var value = $(this).val();

		if (value !== '') {
			$(this).parent().parent().find('.p2_unique_discount').val('');
			$(this).val(value);
		}
	});

	$('#ntreduction_columns_config_save').click(function()
	{
		save_hide_columns();
	});

	$('#ntreduction_cron_config_save').click(function()
	{
		save_cron_config();
	});

    $('#ntreduction_export').click(function(){
        exportReduction();
    });

    refresh_head_columns();
});

function ntTab(tab)
{
	$('.tab').hide();
	$('#nt_tab a').removeClass('active');
	var tab_id = tab.attr('id');
	$('#'+tab_id+'_content').show();
	tab.addClass('active');
}

function init_datetimepicker()
{
	$('.datepicker').each(function(){
		$(this).datetimepicker('destroy');
	});

	$('.datepicker').off("click");

	var date_format = 'yy-mm-dd';
	var time_format = 'hh:mm:ss';
	var today       = new Date();
	var day         = today.getDate();//current day
	var month       = today.getMonth();//curent month
	var year        = today.getFullYear();//current year

	$('.p1 .datepicker.from').datetimepicker({
		dateFormat:     date_format,
		// Define a custom regional settings in order to use PrestaShop translation tools
		currentText:    current_text,
		closeText:      close_text,
		timeFormat:     time_format,
		timeOnlyTitle:  time_only_title,
		timeText:       time_text,
		hourText:       hour_text,
		minuteText:     minute_text,
		minDate:        new Date(year, month, day, 0, 0, 1),
		defaultDate:    0,
		hour:           0,
		minute:         0,
		second:         1
	});

	$('.p1 .datepicker.to').datetimepicker({
		dateFormat:     date_format,
		// Define a custom regional settings in order to use PrestaShop translation tools
		currentText:    current_text,
		closeText:      close_text,
		timeFormat:     time_format,
		timeOnlyTitle:  time_only_title,
		timeText:       time_text,
		hourText:       hour_text,
		minuteText:     minute_text,
		minDate:        new Date(year, month, day, 0, 0, 1),
		defaultDate:    0,
		hour:           23,
		minute:         59,
		second:         59
	});

	$('.p1 .datepicker.to').focus(function() {
		var m = month + 1;
		var d = day;

		if(m < 10)
			m = '0' + m;

		if(d < 10)
			d = '0' + d;

		if($(this).val() === '')
			$(this).val(year + '-' + m + '-' + d + ' 23:59:59');
	});

	$('.p1 .datepicker.from').focus(function()
	{
		var m = month + 1;
		var d = day;

		if(m < 10)
			m = '0' + m;

		if(d < 10)
			d = '0' + d;

		if($(this).val() === '')
			$(this).val(year + '-' + m + '-' + d + ' 00:00:01');
	});

	/****************************************************************************/
	$('.p2 .datepicker.from').datetimepicker({
		dateFormat:     date_format,
		// Define a custom regional settings in order to use PrestaShop translation tools
		currentText:    current_text,
		closeText:      close_text,
		timeFormat:     time_format,
		timeOnlyTitle:  time_only_title,
		timeText:       time_text,
		hourText:       hour_text,
		minuteText:     minute_text,
		minDate:        new Date(year, month, day, 0, 0, 1),
		defaultDate:    0,
		hour:           0,
		minute:         0,
		second:         1
	});

	$('.p2 .datepicker.to').datetimepicker({
		dateFormat:     date_format,
		// Define a custom regional settings in order to use PrestaShop translation tools
		currentText:    current_text,
		closeText:      close_text,
		timeFormat:     time_format,
		timeOnlyTitle:  time_only_title,
		timeText:       time_text,
		hourText:       hour_text,
		minuteText:     minute_text,
		minDate:        new Date(year, month, day, 0, 0, 1),
		defaultDate:    0,
		hour:           23,
		minute:         59,
		second:         59
	});

	$('.p2 .datepicker.to').focus(function()
	{
		var m = month + 1;
		var d = day;

		if(m < 10)
			m = '0' + m;

		if(d < 10)
			d = '0' + d;

		if($(this).val() === '')
			$(this).val(year + '-' + m + '-' + d + ' 23:59:59');
	});

	$('.p2 .datepicker.from').focus(function()
	{
		var m = month + 1;
		var d = day;

		if(m < 10)
			m = '0' + m;

		if(d < 10)
			d = '0' + d;

		if($(this).val() === '')
			$(this).val(year + '-' + m + '-' + d + ' 00:00:01');
	});
}

function refresh_head_columns()
{
	var colspan_product_columns = $('#columns_title .p0:visible').length;
	var colspan_period1_columns = $('#columns_title .p1:visible').length;
	var colspan_period2_columns = $('#columns_title .p2:visible').length;

	if (colspan_product_columns > 0) {
		$('#product_head').attr('colspan', colspan_product_columns);
		$('#product_title').attr('colspan', colspan_product_columns);
		$('#product_head').show();
		$('#product_title').show();
	} else {
		$('#product_head').hide();
		$('#product_title').hide();
	}

	if (colspan_period1_columns > 0) {
		$('#period1_title').attr('colspan', colspan_period1_columns);
		$('#period1_title').show();
	} else {
		$('#period1_title').hide();
    }

	if (colspan_period2_columns > 0) {
		$('#period2_title').attr('colspan', colspan_period2_columns);
		$('#period2_title').show();
	} else {
		$('#period2_title').hide();
    }
}

function load_product()
{
    var id_categories   = new Array();
	var id_currency     = $('#reduction_currency').val();
	var id_country      = $('#reduction_country').val();
	var id_group        = $('#reduction_group').val();
	var active          = $('#active').val();
	var discounted      = $('#discounted').val();
	var supplier        = $('#filter_supplier').val();
	var manufacturer    = $('#filter_manufacturer').val();
	var search          = $('#nt_reduction_search').val();

    if (!supplier) {
        supplier = 0;
    }

    if (!manufacturer) {
        manufacturer = 0;
    }

	$('#products_list th input:text').each(function(){
		$(this).val('');
	});

    $('#products_list th [type="checkbox"]').each(function() {
        $(this).attr("checked", false);
        $(this).prop("checked", false);
    });

    $('#p1_on_sale_all').val(0);
    $('#p2_on_sale_all').val(0);

	$('#products_list tbody').empty();

    if (hide_products) {
        return false;
    }

	if ($('#categories input:checked').length > 0) {
		$('#categories input:checked').each(function()
		{
            id_categories.push($(this).val());

		});
	} else {
        id_categories.push(id_cat_root);
	}

    display_content(id_categories, id_currency, id_country, id_group, active, search, supplier, manufacturer, discounted);
}

function display_content(id_categories, id_currency, id_country, id_group, active, search, supplier, manufacturer, discounted)
{
    $('#loader_container').show();

	$.post(
		admin_link_ntr,
		'display_reduction=1'
		+'&id_categories='+id_categories
        +'&id_currency='+id_currency
        +'&id_country='+id_country
        +'&id_group='+id_group
        +'&active='+active
        +'&discounted='+discounted
        +'&search='+search
        +'&supplier='+supplier
        +'&manufacturer='+manufacturer
        +'&id_employee='+id_employee,
		function(data)
		{
			if (data.products) {
				if (data.currency_sign) {
					currencySign = data.currency_sign;
				}

				$.each(data.products, function(key, p) {
                    var on_sale_p1, monday_p1, tuesday_p1, wednesday_p1, thursday_p1, friday_p1, saturday_p1, sunday_p1;
                    var on_sale_p2, monday_p2, tuesday_p2, wednesday_p2, thursday_p2, friday_p2, saturday_p2, sunday_p2;
					var product_table = '';

					var init_price              = p.init_price_clean;
					var margin_after_discount   = p.margin_after_discount_clean;
					var tr_class                = '';
					var tr_title                = p.name + ', ' + p.reference + ', ' + p.price_tax_incl_clean;
					var period_1                = p.period_1;
					var period_2                = p.period_2;
					var p1_amount               = '';
					var p1_percentage           = '';
					var p2_amount               = '';
					var p2_percentage           = '';

                    if (period_1.on_sale) {on_sale_p1 = 'checked="checked"';} else {on_sale_p1 = '';};
                    if (period_1.monday) {monday_p1 = 'checked="checked"';} else {monday_p1 = '';};
                    if (period_1.tuesday) {tuesday_p1 = 'checked="checked"';} else {tuesday_p1 = '';};
                    if (period_1.wednesday) {wednesday_p1 = 'checked="checked"';} else {wednesday_p1 = '';};
                    if (period_1.thursday) {thursday_p1 = 'checked="checked"';} else {thursday_p1 = '';};
                    if (period_1.friday) {friday_p1 = 'checked="checked"';} else {friday_p1 = '';};
                    if (period_1.saturday) {saturday_p1 = 'checked="checked"';} else {saturday_p1 = '';};
                    if (period_1.sunday) {sunday_p1 = 'checked="checked"';} else {sunday_p1 = '';};

                    if (period_2.on_sale) {on_sale_p2 = 'checked="checked"';} else {on_sale_p2 = '';};
                    if (period_2.monday) {monday_p2 = 'checked="checked"';} else {monday_p2 = '';};
                    if (period_2.tuesday) {tuesday_p2 = 'checked="checked"';} else {tuesday_p2 = '';};
                    if (period_2.wednesday) {wednesday_p2 = 'checked="checked"';} else {wednesday_p2 = '';};
                    if (period_2.thursday) {thursday_p2 = 'checked="checked"';} else {thursday_p2 = '';};
                    if (period_2.friday) {friday_p2 = 'checked="checked"';} else {friday_p2 = '';};
                    if (period_2.saturday) {saturday_p2 = 'checked="checked"';} else {saturday_p2 = '';};
                    if (period_2.sunday) {sunday_p2 = 'checked="checked"';} else {sunday_p2 = '';};

					if (p.init_price === 0) {
						init_price = '-';
                    }

					if (p.warning.combination || p.warning.from_quantity || p.warning.currency || p.warning.catalog_rule) {
						tr_class = 'red';
                    }

					if (p.warning.combination) {
						if (tr_title !== '') {
							tr_title += "\n" + warning_combination;
                        } else {
							tr_title += warning_combination;
                        }
					}

					if (p.warning.from_quantity) {
						if (tr_title !== '') {
							tr_title += "\n" + warning_from_quantity;
                        } else {
							tr_title += warning_from_quantity;
                        }
					}

					if (p.warning.currency) {
						if (tr_title !== '') {
							tr_title += "\n" + warning_currency;
                        } else {
							tr_title += warning_currency;
                        }
					}

					if(p.warning.catalog_rule) {
						if (tr_title !== '') {
							tr_title += "\n" + warning_catalog_rule;
                        } else {
							tr_title += warning_catalog_rule;
                        }
					}

					if (p.last_reduced_price === null) {
						p.last_reduced_price = '-';
                    }

					if (p.current_reduced_price === null) {
						p.current_reduced_price = '-';
                    }

					if (p.next_reduced_price === null) {
						p.next_reduced_price = '-';
                    }

					if (p.margin_after_discount === null) {
						margin_after_discount = '-';
                    }

					if (period_1.reduction > 0) {
						if (period_1.reduction_type === 'amount') {
							p1_amount = parseFloat(period_1.reduction);
                        } else {
							if (period_1.reduction_type === 'percentage') {
								p1_percentage = period_1.reduction;
                            }
						}
					}

					if (period_2.reduction > 0) {
						if (period_2.reduction_type === 'amount') {
							p2_amount = parseFloat(period_2.reduction);
                        } else {
							if (period_2.reduction_type === 'percentage') {
								p2_percentage = period_2.reduction;
                            }
						}
					}

					if (!period_1.id_specific_price)
						period_1.id_specific_price = '';
					if (!period_1.id_ntreduction)
						period_1.id_ntreduction = '';
					if (!period_1.from)
						period_1.from = '';
					if (!period_1.to)
						period_1.to = '';
					if (!period_1.price || period_1.price <= 0)
						period_1.price = '';

					if (!period_2.id_specific_price)
						period_2.id_specific_price = '';
					if (!period_2.id_ntreduction)
						period_2.id_ntreduction = '';
					if (!period_2.from)
						period_2.from = '';
					if (!period_2.to)
						period_2.to = '';
					if (!period_2.price || period_2.price <= 0)
						period_2.price = '';

					if ($('#products_list #product_id_'+p.id_product).length > 0)
						$('#products_list #product_id_'+p.id_product).parent().remove();

					product_table += '<tr title="' + tr_title + '" class="' + tr_class + '">';
						product_table += '<td class="p_1"><a href="' + p.front_link + '"><img src="' + p.cover + '"/></a></td>';
						product_table += '<td class="p_2" id="product_id_' + p.id_product + '">'+p.name+'</a></td>';
						product_table += '<td class="p_3"><a href="' + p.admin_link + '">'+p.reference+'</td>';
						product_table += '<td class="p_4">'+p.price_tax_incl_clean+'</td>';
						product_table += '<td class="p_price_no_tax">'+p.price_tax_excl_clean+'</td>';
                        product_table += '<td class="p_init_price">'+init_price+'</td>';
                        product_table += '<td class="p_margin_after_discount">'+margin_after_discount+'</td>';
                    if (p.change_quantity) {
						product_table += '<td class="p_5"><input type="text" value="'+p.available_qt+'" id="quantity_'+p.id_product+'" name="quantity['+p.id_product+']"/></td>';
                    } else {
						product_table += '<td class="p_5">'+p.available_qt+'</td>';
                    }

						product_table += '<td class="p_6">'+p.last_reduced_price+'</td>';
						product_table += '<td class="p_7">'+p.current_reduced_price+'</td>';
						product_table += '<td class="p_8">'+p.next_reduced_price+'</td>';
                        product_table += '<td class="p_init_price p_reset_init_price"><input type="checkbox" id="reset_init_price_'+p.id_product+'" name="reset_init_price['+p.id_product+']"/></td>';

						product_table += '<td class="p1 p1_1">';
							product_table += '<input value="'+period_1.from+'" type="text" class="datepicker from" id="p1_date_from_'+p.id_product+'" name="p1_date_from['+p.id_product+']"/>';
							product_table += '<input type="hidden" value="'+period_1.id_specific_price+'" id="p1_id_specific_price_'+p.id_product+'" name="p1_id_specific_price['+p.id_product+']" />';
							product_table += '<input type="hidden" value="'+period_1.id_ntreduction+'" id="p1_id_ntreduction_'+p.id_product+'" name="p1_id_ntreduction['+p.id_product+']" />';
						product_table += '</td>';
						product_table += '<td class="p1 p1_2"><input type="text" value="'+period_1.to+'" class="datepicker to" id="p1_date_to_'+p.id_product+'" name="p1_date_to['+p.id_product+']"/></td>';
						product_table += '<td class="p1 p1_3"><input class="p1_price" value="'+period_1.price+'" type="text" id="p1_new_price_'+p.id_product+'" name="p1_new_price['+p.id_product+']"/>'+currencySign+'</td>';
						product_table += '<td class="p1 p1_4"><input class="p1_price p1_unique_discount" value="" type="text" id="p1_discount_price_'+p.id_product+'" name="p1_discount_price['+p.id_product+']"/>'+currencySign+'</td>';
						product_table += '<td class="p1 p1_5"><input class="p1_price p1_unique_discount" value="'+p1_amount+'" type="text" id="p1_amount_'+p.id_product+'" name="p1_amount['+p.id_product+']"/>'+currencySign+'</td>';
						product_table += '<td class="p1 p1_6"><input class="p1_price p1_unique_discount" value="'+p1_percentage+'" type="text" id="p1_percentage_'+p.id_product+'" name="p1_percentage['+p.id_product+']"/> %</td>';
						product_table += '<td class="p1 p1_7"><input type="checkbox" class="p1_replace" id="p1_replace_'+p.id_product+'" name="p1_replace['+p.id_product+']" /></td>';
						product_table += '<td class="p1 p1_8"><input type="checkbox" class="p1_on_sale" id="p1_on_sale_'+p.id_product+'" name="p1_on_sale['+p.id_product+']" '+on_sale_p1+' /></td>';
						product_table += '<td class="p1 p1_10 day"><input type="checkbox" class="p1_monday" id="p1_monday_'+p.id_product+'" name="p1_monday['+p.id_product+']" '+monday_p1+' /></td>';
						product_table += '<td class="p1 p1_11 day"><input type="checkbox" class="p1_tuesday" id="p1_tuesday_'+p.id_product+'" name="p1_tuesday['+p.id_product+']" '+tuesday_p1+' /></td>';
						product_table += '<td class="p1 p1_12 day"><input type="checkbox" class="p1_wednesday" id="p1_wednesday_'+p.id_product+'" name="p1_wednesday['+p.id_product+']" '+wednesday_p1+' /></td>';
						product_table += '<td class="p1 p1_13 day"><input type="checkbox" class="p1_thursday" id="p1_thursday_'+p.id_product+'" name="p1_thursday['+p.id_product+']" '+thursday_p1+' /></td>';
						product_table += '<td class="p1 p1_14 day"><input type="checkbox" class="p1_friday" id="p1_friday_'+p.id_product+'" name="p1_friday['+p.id_product+']" '+friday_p1+' /></td>';
						product_table += '<td class="p1 p1_15 day"><input type="checkbox" class="p1_saturday" id="p1_saturday_'+p.id_product+'" name="p1_saturday['+p.id_product+']" '+saturday_p1+' /></td>';
						product_table += '<td class="p1 p1_16 day"><input type="checkbox" class="p1_sunday" id="p1_sunday_'+p.id_product+'" name="p1_sunday['+p.id_product+']" '+sunday_p1+' /></td>';
						product_table += '<td class="p1 p1_9"><input type="checkbox" class="p1_delete" id="p1_delete_'+p.id_product+'" name="p1_delete['+p.id_product+']" /></td>';

						product_table += '<td class="p2 p2_1">';
							product_table += '<input value="'+period_2.from+'" type="text" class="datepicker from" id="p2_date_from_'+p.id_product+'" name="p2_date_from['+p.id_product+']"/>';
							product_table += '<input type="hidden" value="'+period_2.id_specific_price+'" id="p2_id_specific_price_'+p.id_product+'" name="p2_id_specific_price['+p.id_product+']" />';
							product_table += '<input type="hidden" value="'+period_2.id_ntreduction+'" id="p2_id_ntreduction_'+p.id_product+'" name="p2_id_ntreduction['+p.id_product+']" />';
						product_table += '</td>';
						product_table += '<td class="p2 p2_2"><input value="'+period_2.to+'" type="text" class="datepicker to" id="p2_date_to_'+p.id_product+'" name="p2_date_to['+p.id_product+']"/></td>';
						product_table += '<td class="p2 p2_3"><input class="p2_price" value="'+period_2.price+'" type="text" id="p2_new_price_'+p.id_product+'" name="p2_new_price['+p.id_product+']"/>'+currencySign+'</td>';
						product_table += '<td class="p2 p2_4"><input class="p2_price p2_unique_discount" value="" type="text" id="p2_discount_price_'+p.id_product+'" name="p2_discount_price['+p.id_product+']"/>'+currencySign+'</td>';
						product_table += '<td class="p2 p2_5"><input class="p2_price p2_unique_discount" value="'+p2_amount+'" type="text" id="p2_amount_'+p.id_product+'" name="p2_amount['+p.id_product+']"/>'+currencySign+'</td>';
						product_table += '<td class="p2 p2_6"><input class="p2_price p2_unique_discount" value="'+p2_percentage+'" type="text" id="p2_percentage_'+p.id_product+'" name="p2_percentage['+p.id_product+']"/> %</td>';
						product_table += '<td class="p2 p2_7"><input type="checkbox" class="p2_replace" id="p2_replace_'+p.id_product+'" name="p2_replace['+p.id_product+']" /></td>';
						product_table += '<td class="p2 p2_8"><input type="checkbox" class="p2_on_sale" id="p2_on_sale_'+p.id_product+'" name="p2_on_sale['+p.id_product+']" '+on_sale_p2+' /></td>';
						product_table += '<td class="p2 p2_10 day"><input type="checkbox" class="p2_monday" id="p2_monday_'+p.id_product+'" name="p2_monday['+p.id_product+']" '+monday_p2+' /></td>';
						product_table += '<td class="p2 p2_11 day"><input type="checkbox" class="p2_tuesday" id="p2_tuesday_'+p.id_product+'" name="p2_tuesday['+p.id_product+']" '+tuesday_p2+' /></td>';
						product_table += '<td class="p2 p2_12 day"><input type="checkbox" class="p2_wednesday" id="p2_wednesday_'+p.id_product+'" name="p2_wednesday['+p.id_product+']" '+wednesday_p2+' /></td>';
						product_table += '<td class="p2 p2_13 day"><input type="checkbox" class="p2_thursday" id="p2_thursday_'+p.id_product+'" name="p2_thursday['+p.id_product+']" '+thursday_p2+' /></td>';
						product_table += '<td class="p2 p2_14 day"><input type="checkbox" class="p2_friday" id="p2_friday_'+p.id_product+'" name="p2_friday['+p.id_product+']" '+friday_p2+' /></td>';
						product_table += '<td class="p2 p2_15 day"><input type="checkbox" class="p2_saturday" id="p2_saturday_'+p.id_product+'" name="p2_saturday['+p.id_product+']" '+saturday_p2+' /></td>';
						product_table += '<td class="p2 p2_16 day"><input type="checkbox" class="p2_sunday" id="p2_sunday_'+p.id_product+'" name="p2_sunday['+p.id_product+']" '+sunday_p2+' /></td>';
						product_table += '<td class="p2 p2_9"><input type="checkbox" class="p2_delete" id="p2_delete_'+p.id_product+'" name="p2_delete['+p.id_product+']" /></td>';

					product_table += '</tr>';

					$('#products_list tbody').append(product_table);

				});

				$('.p1_unique_discount').change(function()
				{
					var value = $(this).val();
					if(value !== '')
					{
						$(this).parent().parent().find('.p1_unique_discount').val('');
						$(this).val(value);
					}
				});

				$('.p2_unique_discount').change(function()
				{
					var value = $(this).val();
					if(value !== '')
					{
						$(this).parent().parent().find('.p2_unique_discount').val('');
						$(this).val(value);
					}
				});

				$.each(columns_to_hide, function(k, c)
				{
					$('.' + c).addClass('hide');
				});

				init_datetimepicker();
			}

            // We wait 500ms before sizing the cells
            setTimeout(function()
            {
                $('#products_list tbody tr:first-child td').each(function(){
                    var cell_width = $(this).innerWidth();
                    var cell_number = $(this).index() + 1;

                    $('#columns_title td:nth-child('+cell_number+'n)').css({
                        'width': cell_width+'px',
                        'min-width': cell_width+'px',
                    });
                });

                //Check if title cell need more space than the product cell, even after we tried to limit it. If so, we adapt the product cell space
               $('#products_list tbody tr:first-child td').each(function(){
                    var cell_width = $(this).innerWidth();
                    var cell_number = $(this).index() + 1;
                    var title_cell_width = $('#columns_title td:nth-child('+cell_number+'n)').innerWidth();

                    if (title_cell_width > cell_width) {
                        $(this).css({
                            'width': title_cell_width+'px',
                            'min-width': title_cell_width+'px',
                        });
                        $('#columns_title td:nth-child('+cell_number+'n)').css({
                            'width': title_cell_width+'px',
                            'min-width': title_cell_width+'px',
                        });
                    }
                });
            }, 1000);

            $('#loader_container').hide();

		},"json"
	);
}

function save_reduction()
{
	var confirm_save = true;
	var confirm_date = false;

	$('#ntreduction .error').hide();
	$('#ntreduction .confirm').hide();

	if ($('.p1_delete:checked').length > 0 || $('.p2_delete:checked').length > 0) {
		confirm_save = confirm(delete_warning);

		if(!confirm_save)
			return;
	}

    var p1_date_from_all        = $('#p1_date_from_all').val();
    var p1_date_to_all          = $('#p1_date_to_all').val();
    var p1_new_price_all        = $('#p1_new_price_all').val();
    var p1_discount_price_all   = $('#p1_discount_price_all').val();
    var p1_amount_all           = $('#p1_amount_all').val();
    var p1_percentage_all       = $('#p1_percentage_all').val();

    var p2_date_from_all        = $('#p2_date_from_all').val();
    var p2_date_to_all          = $('#p2_date_to_all').val();
    var p2_new_price_all        = $('#p2_new_price_all').val();
    var p2_discount_price_all   = $('#p2_discount_price_all').val();
    var p2_amount_all           = $('#p2_amount_all').val();
    var p2_percentage_all       = $('#p2_percentage_all').val();

	$('#products_list tbody .p1_price').each(function(){
		if(($(this).val() !== '' || p1_new_price_all !== '' || p1_discount_price_all !== '' || p1_amount_all !== '' || p1_percentage_all !== '')
            && (p1_date_from_all === '' || p1_date_to_all === '')
        ) {
			var date_from   = $(this).parent().parent().find('.p1 .from');
			var date_to     = $(this).parent().parent().find('.p1 .to');
			var replace     = $(this).parent().parent().find('.p1_replace:checked');

			if((date_from.val() === '' || date_to.val() === '') && replace.length === 0 && !confirm_date)
				confirm_date = true;
		}
	});

	$('#products_list tbody .p2_price').each(function(){
		if(($(this).val() !== '' || p2_new_price_all !== '' || p2_discount_price_all !== '' || p2_amount_all !== '' || p2_percentage_all !== '')
            && (p2_date_from_all === '' || p2_date_to_all === '')
        ){
			var date_from   = $(this).parent().parent().find('.p2 .from');
			var date_to     = $(this).parent().parent().find('.p2 .to');
			var replace     = $(this).parent().parent().find('.p2_replace:checked');

			if((date_from.val() === '' || date_to.val() === '') && replace.length === 0)
			{
				confirm_date = true;
			}
		}
	});

	if (confirm_date) {
		confirm_save = confirm(date_warning);

		if(!confirm_save)
			return;
	}

	if (confirm_save) {
        var config = $('#ntreduction_config').serialize();
        var products_all = '';
        var products = '';
        var count_products = 1;

        if (hide_products) {
            config += '&hide_products='+hide_products;
        }

        // For all products
        products_all += $('#products_list thead :input').serialize();

        $('#products_list tbody tr').each(function() {
            products += '&' + $(this).find(':input').serialize();

            if (count_products >= ajax_products_max) {
                sendDatasReduction(config, products_all, products);

                products = '';
                count_products = 0;
            }

            count_products++;
        });

        //We send the rest even if count_products < ajax_products_max
        sendDatasReduction(config, products_all, products);
	}
}

function sendDatasReduction(config, products_all, products)
{
    $('#loader_container').show();

    $('#ntreduction .error').hide();
	$('#ntreduction .confirm').hide();

	$.post(
		admin_link_ntr,
		'ntreduction_save=1&' + config + '&' + products_all + products,
		function(data)
		{
			if (data) {
				$('#ntreduction .error').html('');

				if (data.error) {
					$.each( data.error, function( key, error ){
						$('#ntreduction .error').append('<p>'+error+'</p>');
					});

					$('#ntreduction .error').show();
				} else {
					$('#ntreduction .confirm').show();
					load_product();
				}

				init_datetimepicker();
			}

            $('#loader_container').hide();
		},"json"
	);
}

function save_hide_columns()
{
    $('#loader_container').show();

    $('#ntreduction .error').hide();
	$('#ntreduction .confirm').hide();

	$.post(
		admin_link_ntr,
		$("#ntreduction_columns_config").serialize() + '&ntreduction_columns_config_save=1',
		function(data)
		{
			if (data) {
				if (data.result !== 'ok') {
					$('#ntreduction .error').append('<p>'+hide_columns_error+'</p>');
					$('#ntreduction .error').show();
				} else {
					$('#ntreduction .confirm').show();
                }

                $('html, body').animate({
                    scrollTop: $('#ntreduction').position().top
                }, 1000);
			}

            $('#loader_container').hide();
		},"json"
	);
}

function save_cron_config()
{
    $('#loader_container').show();

    $('#ntreduction .error').hide();
	$('#ntreduction .confirm').hide();

	$.post(
		admin_link_ntr,
		$("#ntreduction_cron_config").serialize() + '&ntreduction_cron_config_save=1',
		function(data)
		{
			if (data) {
				if (data.result !== 'ok') {
					$('#ntreduction .error').append('<p>'+cron_config_error+'</p>');
					$('#ntreduction .error').show();
				} else {
					$('#ntreduction .confirm').show();
                }
			}

            $('#loader_container').hide();
		},"json"
	);
}

function exportReduction()
{
    var id_categories   = new Array();
	var id_currency     = $('#reduction_currency').val();
	var id_country      = $('#reduction_country').val();
	var id_group        = $('#reduction_group').val();
	var active          = $('#active').val();
	var discounted      = $('#discounted').val();
	var supplier        = $('#filter_supplier').val();
	var manufacturer    = $('#filter_manufacturer').val();
	var search          = $('#nt_reduction_search').val();

    if (!supplier) {
        supplier = 0;
    }

    if (!manufacturer) {
        manufacturer = 0;
    }

    if ($('#categories input:checked').length > 0) {
		$('#categories input:checked').each(function()
		{
            id_categories.push($(this).val());

		});
	} else {
        id_categories.push(id_cat_root);
	}

    $.post(
		admin_link_ntr,
		'export_reduction=1'
        +'&id_categories='+id_categories
        +'&id_currency='+id_currency
        +'&id_country='+id_country
        +'&id_group='+id_group
        +'&active='+active
        +'&discounted='+discounted
        +'&search='+search
        +'&supplier='+supplier
        +'&manufacturer='+manufacturer
        +'&id_employee='+id_employee,
		function(data)
		{
			if (data.filepath) {
				window.open(data.filepath);
			}
		},"json"
	);
}