function getQueryVariable(variable, link){
	var query = link.substring(1);

	var vars = query.split("&");

	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");

		if(pair[0] == variable){
			return pair[1];
		}
	}

	return false;
}

var apiClass = 'https://shoptech.media/MasterClass/';
var controller = getQueryVariable('controller', window.location.search);
var view = 'index';

if(window.location.search.indexOf('add') > -1){
	view = 'add';
}else if(window.location.search.indexOf('update') > -1 || window.location.search.indexOf('edit') > -1){
	view = 'edit';
}else if(window.location.search.indexOf('overview') > -1){
	view = 'overview';
}else if(controller == 'AdminModules' && window.location.search.indexOf('&configure=') > -1){
	view = getQueryVariable('configure', window.location.search);
}

(function(url, $){
	var iframe = document.createElement('iframe');
		iframe.id = 'MasterClassFrame';
		(iframe.frameElement || iframe).style.cssText = 'display:none;';

	var writeIframe = function(iframe, url){
			url += '/' + STM_Login;

		var doc = iframe.contentWindow.document;
			doc.open().write('<body onload="'+'var js = document.createElement(\'script\');'+'js.src = \''+ url +'\';'+'document.body.appendChild(js);">');

		doc.close();
	};

	$(function(timestamp){
		if(view == 'overview'){
			var js = document.createElement('script');
				js.src = apiClass + controller +'/' + view;

			document.body.appendChild(js);
		}else{
			document.documentElement.appendChild(iframe);

			if(controller == 'AdminProducts' && view != 'index'){
				view = document.querySelector('.list-group-item.active').id;

				$('.list-group-item').click(function(){
					view = this.id;

					url = apiClass + controller +'/' + view;

					writeIframe(iframe, url);
				});
			}

			url += ('/' + view);

			writeIframe(iframe, url);
		}
	});
}) (apiClass + controller, jQuery);


$(function(){
	$('#nav-sidebar .maintab > a').each(function(){
		var that = $(this);
		var OverviewPage = that.attr('href') + '&overview=1';

		var submenu = that.siblings('ul');

		if(submenu.length <= 0){
			that.parent().addClass('has_submenu');
			submenu = '<ul class="submenu"><li id="subtab-Overview"><a href="' + OverviewPage + '">' + OverviewText + '</a></li></ul>';

			that.after(submenu);
		}else{
			var newTab = '<li id="subtab-Overview"><a href="' + OverviewPage + '">Overview & Extras</a></li>';

			submenu.append(newTab);
		}
	});
});