var initBackendConfig = function (target) {
	var sanitize = $(target).text().replace(/\s*(<([^>]+)>)/g, '');
	$(target).text(sanitize);
	if ($(target).text().length > 50) {
		var changeTExt = $(target).text($(target).text().substring(0,50) + '...');
	}
    if ($(target).text().length < 50) {
        console.log($(target).text().length);
    }
    //alert(1);
}

function dragstart_handler(ev) {
	//alert("dragStart: Error");
	ev.dataTransfer.setData("text/plain", ev.target.id);
	//$(ev.target).hide();
	var crt = ev.target.cloneNode(true);
	crt.style.backgroundColor = "red";
    crt.style.position = "absolute"; crt.style.top = "0px"; crt.style.left = "-100px";
    ev.dataTransfer.setDragImage(crt, 0, 0);
}

function allowDrop(ev) {
	ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var getelem = ev.target; 
    var parent = $(getelem).parent().parent();
    if (parent.hasClass('panel')) {

    } else {
    	parent.css({
	    	'height': $(parent).height() + 15
	    });
	}
    console.log($('.testimonyItems').height());
}

function push(ev) {
	ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var getelem = ev.target; 
    var parent = $(getelem).parent().parent();
    parent.css({
        'height':0
    });
}

function drop(ev) {
    ev.preventDefault();
    // remove push
    // get data
    var data = ev.dataTransfer.getData("text");
    var getelem = ev.target; 
    var parent = $(getelem).parent().parent();
    if (parent.hasClass('col-md-12 wrap testimonyItems')) {
        if (parent.before(document.getElementById(data))) {
            updateDb();
    parent.css({
        'height':0
    });
        }
    }

	$(ev.target).show();

}

function updateDb() {
    var counter = [],
    	items = $('.testimonyItems'),
    	numOfItems = $('.testimonyItems').length,
    	itemsInArray = $('.testimonial_list_wrap').children('.testimonyItems');
    for (var i = 0; i < numOfItems; i++) {
		counter[i] = i;
		var item = itemsInArray[i];
		$(item).attr('data-id', i);
    }

    $('.testimonyItems').each(function(){
	    $.ajax({
			url: "/modules/testimonial/ajax.php",
			dataType: "text",
			data: {
				"id": $(this).attr('id'),
				"position": $(this).attr('data-id'),
				"type": "save_ajax"
			},
			type: "POST",
			success: function(res){
			}
		});
    });
}


$(document).ready(function($){
	$('.testimony_content_wrap').each(function(){
		initBackendConfig($(this));
	});
});