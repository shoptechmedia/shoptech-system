$(document).ready(function() {

    var iframe = document.querySelector('#WidgetizeiframeDashboard');

    if(iframe){
        iframe.style.overflow = 'hidden';
        iframe.scrolling = 'no';

        setInterval(function(){
        	if(iframe.contentWindow.document.body != null){
    	        var height = iframe.contentWindow.document.body.offsetHeight;

    	        $(iframe).css({
    	        	height: height
    	        });
            }
        }, 1000);
    }

    $('#refreshAnalytics').click(function(){
        var currentLocation = window.location.href;

        if(currentLocation.indexOf('refreshAnalytics') <= -1)
            clearLocation = currentLocation + '&refreshAnalytics=1';
        else
            clearLocation = currentLocation;

        window.location.href = clearLocation;
    });


    // 'https://' . $this->context->shop->domain_ssl . '/analytics/index.php
    $('.analytics_query').click(function(){
        var query = $(this).data('query');

        $.fancybox.open({
            type: 'iframe',

            href: 'https://' + window.location.hostname + '/analytics/index.php?' + query,

            width: 980,

            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
    });

});