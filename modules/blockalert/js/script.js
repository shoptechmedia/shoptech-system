$(function(){

	if(document.cookie.indexOf('CloseBlockAlert=1') > -1){
		$('#BlockAlert').remove();
	}else{
		$('#BlockAlert').fadeIn();
	}

	$('#CloseBlockAlert').click(function(){
		$('#BlockAlert').remove();

		document.cookie = 'CloseBlockAlert=1';
	});

});