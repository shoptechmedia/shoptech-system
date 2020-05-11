$(document).ready(function() {
$(window).scroll(function(){
		var windowHeight = $(window).height();
		var sidebarH = $(".sidebar-header").outerHeight();
        
        if(sidebarH-windowHeight<$(window).scrollTop()){
            if(!$(".sidebar-header").hasClass("sticky-sheader"))
                $(".sidebar-header").addClass("sticky-sheader");
        }
          if(sidebarH-windowHeight>=$(window).scrollTop()){
            if($(".sidebar-header").hasClass("sticky-sheader"))
                $(".sidebar-header").removeClass("sticky-sheader");
        }
    }); 
});



        