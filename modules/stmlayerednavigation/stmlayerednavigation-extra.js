var getSelectedFilters = function(){
    var selected_filters = window.location.href.split('#')[1];

	if(!selected_filters){
		selected_filters = window.location.search.split('=')[1];
	}

	return selected_filters;
}

var hideEditButton = function(){
	var selected_filters = getSelectedFilters();

	if(!selected_filters){
		$('#editLayeredCombination').fadeOut();
	}else{
		$('#editLayeredCombination').fadeIn();
	}
}

var editLayeredCombination = function(){
	var id_category_layered = $('[name="id_category_layered"]').val();
    var selected_filters = getSelectedFilters();

	if(!selected_filters)
		return false;

	$.fancybox.showLoading();

    $.ajax({
    	url: '/modules/stmlayerednavigation/stmlayerednavigation-combinations.php?id_category_layered=' + id_category_layered + '&selected_filters=' + selected_filters,
    	dataType: 'json',

    	success: function(res){
    		if(res.status == 1){
				window.open(res.link, "_blank");
    		}

			$.fancybox.hideLoading();
    	}
    });
};

$(function(){
	var originalBanner = $('#category-banner img').attr('srcset');
	var originalDescription = $('#category-description').html();

	hideEditButton();

	$(document).ajaxComplete(function(event, ajax){
		var response = ajax.responseJSON;
		var banner = response.combination_banner;
		var thumbnail = response.combination_thumbnail;
		var description = response.combination_description;
		var url = response.current_friendly_url;

		if(banner) {
			$('#category-banner img').attr({
				srcset: banner
			});
		}else{
			$('#category-banner img').attr({
				srcset: originalBanner
			});
		}

		if(description) {
			$('#category-description').html(description);
		}else{
			$('#category-description').html(originalDescription);
		}

		if(typeof url != 'undefined' && url.length == 0){
			window.history.pushState({href: window.location.pathname}, '', window.location.pathname);
		}

		hideEditButton();
	});
});