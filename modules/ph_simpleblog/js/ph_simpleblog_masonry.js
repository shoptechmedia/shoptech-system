$(window).load(function()
{
	var $container = $('.simpleblog-posts');
	$container.isotope({
		itemSelector: '.simpleblog-post-item'
	});
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  	var target = $(e.target).attr("href")

  	if(target == '#idTab669'){
  		console.log('aa');
  		$container.isotope('layout');
  	}
  });

});