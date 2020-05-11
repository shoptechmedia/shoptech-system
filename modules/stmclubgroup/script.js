$(function(){
	if(typeof club_group != 'undefined'){
		var html = '<div id="STMClubGroup"><div class="container container-header"><a class="btn btn-default" href="' + club_group + '">' + ClubGroupTxt + '</a></div></div>';

		$('#header').prepend(html);
	}

	
});