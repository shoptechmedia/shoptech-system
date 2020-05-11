var text = '<div id="noindex">You have No Index No Follow in your header. Please remove them <a href="'+url+'" style="color:#bf0005;">here</a> before going live</div>';
jQuery(document).ready(function($){
	$(".admindashboard .page-head .page-title").after(text);
});