/**
 * 2010-2018 Bl Modules.
 *
 * If you wish to customize this module for your needs,
 * please contact the authors first for more information.
 *
 * It's not allowed selling, reselling or other ways to share
 * this file or any other module files without author permission.
 *
 * @author    Bl Modules
 * @copyright 2010-2018 Bl Modules
 * @license
 *
 */

$(document).ready(function()
{	
	$('#affiliate_price_url').click(function(){
		$('#affiliate_price_url_list').slideToggle('fast');
		$('#multistore_url_list').hide();
	});
	
	$('#multistore_url').click(function(){
		$('#multistore_url_list').slideToggle('fast');
		$('#affiliate_price_url_list').hide();
	});
	
	$('.multistore_url_checkbox').change(function() {
		var div_id = $(this).attr('id');
		var url = $('#feed_url').val().split('&multistore');
		
		if (div_id == 'all_multistore') {
			$('.multistore_url_checkbox').prop('checked', false);
			$('#all_multistore').prop('checked', true);
			$('#feed_url').val(url[0]);
			$('#feed_url_open').attr('href', url[0]);
			$('#feed_url_download').attr('href', url[0]+'&download=1');
		} else if (div_id == 'domain_multistore') {
			$('.multistore_url_checkbox').prop('checked', false);
			$('#domain_multistore').prop('checked', true);
			$('#feed_url').val(url[0]+'&multistore=auto');
            $('#feed_url_open').attr('href', url[0]+'&multistore=auto');
            $('#feed_url_download').attr('href', url[0]+'&multistore=auto&download=1');
		} else {
			$('#all_multistore').prop('checked', false);	
			$('#domain_multistore').prop('checked', false);
            $('.multistore_url_checkbox').not(this).prop('checked', false);

            var count_checked = $('.multistore_url_checkbox:checked').length;
			
			if (count_checked > 0) {
				url[0] = url[0]+'&multistore=';
				
				$('.multistore_url_checkbox:checked').each(function() {
				   url[0] = url[0]+this.value+',';
				});

                url[0] = url[0].slice(0,-1);

				$('#feed_url').val(url[0]);
                $('#feed_url_open').attr('href', url[0]);
                $('#feed_url_download').attr('href', url[0]+'&download=1');
			} else {
				$('#feed_url').val(url[0]);
                $('#feed_url_open').attr('href', url[0]);
                $('#feed_url_download').attr('href', url[0]+'&download=1');
			}
		}
	});

    $(".show_cron_install").click(function(){
        $("#cron_install_instruction").slideToggle();
    });

	$(".google_cat_map_blmod").autocomplete({
		minLength: 3,
		source: function( request, response ) {
			var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
			var select_el = ga_cat_blmod;
			var rep = [];

			for (var i = 0; i < select_el.length; i++) {
				var text = select_el[i];

				if (select_el[i] && (!request.term || matcher.test(text))) {
					rep.push({
						label: text,
						value: text,
						option: select_el[i]
					});
				}
			}

			response(rep);
		}
	});

	$("#product_list_menu").change(function() {
		$('body').css({'cursor':'progress'});
		$("#product_list_select").trigger( "click" );
	});

    $('.affiliate-price-cron-button').click(function() {
        var id = $(this).attr('id');
        var name = $(this).text();

        if ($(this).hasClass('affiliate-price-cron-button-active')) {
            $('#cron_path').val($('#cron_path_original').val());
            $('#cron_command').val($('#cron_command_original').val());
            $('.affiliate-price-cron-button').removeClass('affiliate-price-cron-button-active');

        	return false;
		}

        $('.affiliate-price-cron-button').removeClass('affiliate-price-cron-button-active');
        $('#'+id).addClass('affiliate-price-cron-button-active');

        $('#cron_path').val($('#cron_path_original').val().replace('.xml', '_'+name+'.xml'));
        $('#cron_command').val($('#cron_command_original').val()+' '+name);
    });

    $("#product_setting_package_id").change(function() {
        $('body').css({'cursor':'progress'});
        $("#product_setting_package_select").trigger( "click" );
    });
});