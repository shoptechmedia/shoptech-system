/* Shows the live editor based on cookie */

function getCookie(name) {
	var value = "; " + document.cookie;
	var parts = value.split("; " + name + "=");
	if (parts.length == 2) return parts.pop().split(";").shift();
		return null;
}


function checkECCookie() {
	var myCookie = getCookie("expresscache_advcachemgmt");
	// console.log(myCookie);

	if (myCookie == null) {
		// do cookie doesn't exist stuff;
	} else {
		$(function() { $('#expresscache_liveeditor').show();});
	}
}

function loadElementsOnView($custom_selector){
	var $windowHeight = $(window).height();
	var $windowScroll = $(window).scrollTop();

	var $scrolledY = $windowScroll + $windowHeight;

	var $default_selector = '.preload_element, img[data-src]';

	if(typeof $custom_selector != 'undefined'){
		$default_selector = $custom_selector;
	}

	$($default_selector).each(function(){
		var $that = $(this);
		var $elemPosition = $that.offset();

		if($scrolledY <= $elemPosition.top)
			return;

		if(this.tagName == 'IMG'){
			var $realSource = $that.data('src');

			$that.attr('src', $realSource).removeAttr('data-src');
		}

		$that.animate({
			opacity: 1
		}, 20);
	});
}

checkECCookie();

$(document).ready(function(){
	$('.donwuphideshow').click(function(){
		var that = $(this);
		var parent = that.parent();
		var hasClass = parent.hasClass('closed');

		if(!hasClass){
			parent.addClass('closed');

			parent.animate({
				height:0,
				overflow:'visible',
				padding:0
			});

			that.html('&#5169;');
		}else{
			parent.removeClass('closed');

			parent.animate({
				height:183,
				overflow:'visible',
				padding:10
			});

			that.html('&#5167;');
		}
	});
});

$(window).bind('load scroll', function(){
	loadElementsOnView();
});