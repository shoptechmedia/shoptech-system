/**
 * Copyright (C) 2017-2019 thirty bees
 * Copyright (C) 2007-2016 PrestaShop SA
 *
 * thirty bees is an extension to the PrestaShop software by PrestaShop SA.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2017-2019 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   Academic Free License (AFL 3.0)
 * PrestaShop is an internationally registered trademark of PrestaShop SA.
 */

function checkForm()
{
	var is_category_selected = false;
	var is_filter_selected   = false;

	$('#categories-treeview input[type=checkbox]').each(
		function()
		{
			if ($(this).prop('checked'))
			{
				is_category_selected = true;
				return false;
			}
		}
	);

	$('.filter_list_item input[type=checkbox]').each(
		function()
		{
			if ($(this).prop('checked'))
			{
				is_filter_selected = true;
				return false;
			}
		}
	);

	if (!is_category_selected)
	{
		alert(translations['no_selected_categories']);
		$('#categories-treeview input[type=checkbox]').first().focus();
		return false;
	}

	if (!is_filter_selected)
	{
		alert(translations['no_selected_filters']);
		$('#filter_list_item input[type=checkbox]').first().focus();
		return false;
	}


	return true;
}

$(document).ready(
	function()
	{
		$('.ajaxcall').click(
			function()
			{
				if (this.legend == undefined)
					this.legend = $(this).html();

				if (this.running == undefined)
					this.running = false;

				if (this.running == true)
					return false;

				$('.ajax-message').hide();
				this.running = true;

				if (typeof(this.restartAllowed) == 'undefined' || this.restartAllowed)
				{
					$(this).html(this.legend+translations['in_progress']);
					$('#indexing-warning').show();
				}

				this.restartAllowed = false;
				var type = $(this).attr('rel');

				$.ajax(
				{
					url: this.href+'&ajax=1',
					context: this,
					dataType: 'json',
					cache: 'false',
					success: function(res)
					{
						this.running = false;
						this.restartAllowed = true;
						$('#indexing-warning').hide();
						$(this).html(this.legend);

						if (type == 'price')
							$('#ajax-message-ok span').html(translations['url_indexation_finished']);
						else
							$('#ajax-message-ok span').html(translations['attribute_indexation_finished']);

						$('#ajax-message-ok').show();
						return;
					},
					error: function(res)
					{
						this.restartAllowed = true;
						$('#indexing-warning').hide();

						if (type == 'price')
							$('#ajax-message-ko span').html(translations['url_indexation_failed']);
						else
							$('#ajax-message-ko span').html(translations['attribute_indexation_failed']);

						$('#ajax-message-ko').show();
						$(this).html(this.legend);
						this.running = false;
					}
				}
			);
			return false;
		});

		$('.ajaxcall-recurcive').each(
			function(it, elm)
			{
				$(elm).click(
					function()
					{
						if (this.cursor == undefined)
							this.cursor = 0;

						if (this.legend == undefined)
							this.legend = $(this).html();

						if (this.running == undefined)
							this.running = false;

						if (this.running == true)
							return false;

						$('.ajax-message').hide();

						this.running = true;

						if (typeof(this.restartAllowed) == 'undefined' || this.restartAllowed)
						{
							$(this).html(this.legend+translations['in_progress']);
							$('#indexing-warning').show();
						}

						this.restartAllowed = false;

						$.ajax(
						{
							url: this.href+'&ajax=1&cursor='+this.cursor,
							context: this,
							dataType: 'json',
							cache: 'false',
							success: function(res)
							{
								this.running = false;
								if (res.result)
								{
									this.cursor = 0;
									$('#indexing-warning').hide();
									$(this).html(this.legend);
									$('#ajax-message-ok span').html(translations['price_indexation_finished']);
									$('#ajax-message-ok').show();
									return;
								}
								this.cursor = parseInt(res.cursor);
								$(this).html(this.legend+translations['price_indexation_in_progress'].replace('%s', res.count));
								$(this).click();
							},
							error: function(res)
							{
								this.restartAllowed = true;
								$('#indexing-warning').hide();
								$('#ajax-message-ko span').html(translations['price_indexation_failed']);
								$('#ajax-message-ko').show();
								$(this).html(this.legend);

								this.cursor = 0;
								this.running = false;
							}
						});
						return false;
					}
				);
			}
		);

		if (typeof PS_LAYERED_INDEXED !== 'undefined' && PS_LAYERED_INDEXED)
		{
			$('#url-indexe').click();
			$('#full-index').click();
		}

		$('.sortable').sortable(
		{
			forcePlaceholderSize: true
		});

		$('.filter_list_item input[type=checkbox]').click(
			function()
			{
				var current_selected_filters_count = parseInt($('#selected_filters').html());

				if ($(this).prop('checked'))
					$('#selected_filters').html(current_selected_filters_count+1);
				else
					$('#selected_filters').html(current_selected_filters_count-1);
			}
		);

		if (typeof filters !== 'undefined')
		{
			filters = JSON.parse(filters);

			for (filter in filters)
			{
				$('#'+filter).attr("checked","checked");
				$('#selected_filters').html(parseInt($('#selected_filters').html())+1);
				$('select[name="'+filter+'_filter_type"]').val(filters[filter].filter_type);
				$('select[name="'+filter+'_filter_show_limit"]').val(filters[filter].filter_show_limit);
			}
		}

		$('.delete_banner_image').click(function(){
			$.ajax({
				url: window.location.href,
				type: 'POST',

				data: {
					delete_banner_image: 1
				}
			});

			this.parentNode.parentNode.remove();
		});

		$('delete_thumbnail_image').click(function(){
			$.ajax({
				url: window.location.href,
				type: 'POST',

				data: {
					delete_thumbnail_image: 1
				}
			});

			this.parentNode.parentNode.remove();
		});

		var body = document.body,
			html = document.documentElement;

		var next_page = 2;
		var ajax = false;
		var name_filter = '';

		var seoListBody = '#seoListBody';

		$(window).scroll(function(){
			var scroll = $(window).scrollTop();
			var height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);

			if(scroll > parseInt(height / 2) && !ajax){
				ajax = true;

				$.ajax({
					url: window.location.href,
					type: 'POST',
					data: {
						ajax: 1,
						page: next_page,
						name_filter: name_filter
					},

					success: function(res){
						var list = $(res).find(seoListBody).html();

						$(seoListBody).append(list);

						if(res){
							next_page++;
							ajax = false;
						}
					}
				});
			}
		});

		$('#submitFilterButtoncombination').click(function(){
			name_filter = $('#combinationFilter_name').val();

			$(seoListBody).html('');

			$.ajax({
				url: window.location.href,
				type: 'POST',
				data: {
					ajax: 1,
					name_filter: name_filter
				},

				success: function(res){
					var list = $(res).find(seoListBody).html();

					$(seoListBody).append(list);

					next_page = 2;
				}
			});

		});
	}
);
