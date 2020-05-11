//

var sliderBuilder = function () {
	var that = this;
		var canvasWidth = $('.testimonial_slider').innerWidth(),
			elem = $('.testimonial');

		that.init = function() {
			that.getCanvas();
		}

		that.getCanvas = function() {
			that.addAttibute();
			that.loop($('.testimonial_slider .testimonial'), $('.text_display'));
			//that.blinker($('.blinker'), 800);
		}

		that.addTestimonialWidth = function () {
			setInterval(function(){
				canvasWidth = $('.testimonial_slider').innerWidth();
				$('.testimonial_slider_wrap').find('.testimonial').css({
					'width': canvasWidth,
				});
			}, 1000);
		}

		that.addAttibute = function () {
			that.addTestimonialWidth();
			$('.testimonial_slider').fadeIn();
			setInterval(function(){
				canvasWidth = $('.testimonial_slider').innerWidth();
			}, 1000);
		}

		that.getNextElem = function(elem) {
			var next = $(elem).next();
			return next;
		}

		that.getPrevElem = function(elem) {
			var prev = $(elem).prev();
			return prev;
		}

		that.showText = function (target, text, interval, callback, current) {
			setTimeout(function(){
				var nth = current + 1;
				var isTag;
				var user_text = $('.testimonial_slider > .testimonial:nth-child('+nth+') .user_wrap').html();
				$('.user_info').html(user_text);
				$('.text_display').typed({
				     strings: [text],
				     typeSpeed: 10
				});
				var time = setInterval(function(){
					if ($('.text_display').html().length >= text.length) {
						clearInterval(time);
			  			callback();
					}
				},1000);
			}, 1500);
	  	};

	  	that.hideText = function(display, target, interval, callback, current){
			setTimeout(function(){
		  		var sliceTextHIde = function() {
		  			var text = $('.text_display').html();
						callback(target, 'hello world', interval);
				}
				sliceTextHIde();
			}, 4000);
	  	};

	  	that.loop = function (init, target_elem) {
	  		var cur = 0;
	  		var prev = null;
	  		var slides = init.children('div');
	  		var get_slide_ln = slides.length;

	  		var displayCur = function(callback){
	  			if(cur == null)
	  				return;
	  			var slide = slides[cur];
	  			if(typeof callback == 'function'){
	  				$(slide).fadeIn('fast', callback);
	  			}else{
	  				$(slide).fadeIn();
	  			}
	  		};

	  		var hidePrev = function(callback){
	  			if(prev == null)
	  				return;
	  			var slide = slides[prev];
	  			if(typeof callback == 'function'){
	  				$(slide).fadeOut('fast', callback);
	  			}else{
	  				$(slide).fadeOut();
	  			}
	  		};

	  		var animate = function(){
	  			var slide = slides[cur];
	  			var text = $(slide).html();

				that.showText($(target_elem), text, 50, function(display, target, interval){
					that.hideText(display, target, 100, sswitch, cur);
				}, cur);
	  		};

	  		var sswitch = function(){
	  			prev = cur;
	  			if(cur == get_slide_ln - 1){
	  				cur = 0;
	  			}else{
	  				cur++;
	  			}
	  			animate();
	  		};
	  		animate();
	  	};
	  	that.blinker = function (elem, interval) {
	  		var blinker_timer = setInterval(function(){
	  			$(elem).fadeToggle(100);
	  		},interval);
	  	}

	  	that.sanitizeBackEndText = function (target) {
			var sanitize = $(target).text().replace(/\s*(<([^>]+)>)/g, '');
			$(target).text(sanitize);
			if ($(target).text().length > 50) {
				$(target).text($(target).text().substring(0,50) + '...');
			}
	  	}
}  

var sanitizeBackEndText = function (target) {
	var sanitize = $(target).text().replace(/\s*(<([^>]+)>)/g, '');
	$(target).text(sanitize);
	if ($(target).text().length > 50) {
		$(target).text($(target).text().substring(0,50) + '...');
	}
}

var AccessorySlideOverride = function() {
	var that = this, 
		slide = '',
		items = $('.iqitcarousel-product'),
		cur_item = $('.iqitcarousel-product.slick-active');

	that.init = function(){
		that.switchItem();
	}

	that.switchItem = function() {
		var i = 0;

		var numOfItems = $('#product #accesories-slick-slider .slick-track .slick-slide').length,
			numOfItems = numOfItems * 2,
			countChange = 33.33;

		if ($('#product #accesories-slick-slider .slick-track .slick-slide').length != 0) {
			var is_visible = setInterval(function(){
				if (countChange >= 299) {

					countChange = 33.33;
				} else {
					countChange+=33.33;
				}

				$('#product #accesories-slick-slider .slick-track .slick-slide').css({
		    		'transform': 'translate(0%, -'+ countChange+'%)',
				});
				console.log(countChange);
			}, 7000);
		}

	}

}

setTimeout(function(){
	var silder = new sliderBuilder();
		silder.init();
	if ($('div').hasClass('testimonial_list_wrap')) {
		//alert('dragStart: Initialize');
	}

	if ($('#product')) {
		var accesorrySlider = new AccessorySlideOverride();
		accesorrySlider.init();
	}
},100);
$(document).ready(function($){

});