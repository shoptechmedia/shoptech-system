$(document).ready(function() {

    var addMenuHeight = 0;
    var alreadySticky = false;
    if ((typeof isStickMenu != 'undefined') && isStickMenu) {
    	if (typeof iqit_inlineh != 'undefined') {
    		addMenuHeight = $("#header").find('.container-header').first().outerHeight()-20; 
    	}
    	else
        	addMenuHeight = $("#iqitmegamenu-horizontal").outerHeight(); 
    } 

    var s = $("#center-layered-nav");
    var pos = s.offset();     

    $(window).scroll(function() {
    	var windowpos = $(window).scrollTop() + addMenuHeight;
    	if(!alreadySticky) {
    		if (windowpos >= pos.top) {
    			alreadySticky = true;
    			s.addClass("stick_layered").css( "top", addMenuHeight + "px" );;
    		} 
    		}
    		if(alreadySticky) { 
    			if (windowpos <= pos.top) {
    				alreadySticky = false;
    				s.removeClass("stick_layered"); 
    			}
    		}
    	});

    function getStickHeight(){

    }
});