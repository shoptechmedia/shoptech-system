$( document ).ready(function() {
	$html = '<li class="maintab has_submenu" id="maintab-AdminEvents" data-submenu="1">';
		$html += '<a href="' + admin_modules_link + '&configure=stmeventscourses" class="title" id="all_180">';
			$html += '<i class="icon-AdminDashboard" id="all_181"></i>';
			$html += '<span id="all_182">Events</span>';
		$html += '</a><ul class="submenu" id="all_183"><li id="subtab-AdminEvents"><a href="' + admin_modules_link + '&configure=stmeventscourses">Events</a></li><li id="subtab-AdminEventCategories"><a href="index.php?controller=AdminCategories&token=bc1d54aaecec0c87749bf9298dde9e3b&id_category=' + event_root_category + '">Event Kategorier</a></li></ul>';
	$html += '</li>';

	$('#nav-sidebar > .menu').append($html);
});