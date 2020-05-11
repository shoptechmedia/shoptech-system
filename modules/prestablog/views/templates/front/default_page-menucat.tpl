{*
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 
 *}

<!-- Module Presta Blog -->
<script type="text/javascript">
	{literal}
	( function($) {
		$(function() {
			$("div#menu-mobile, div#menu-mobile-close").click(function() {
				$("#prestablog_menu_cat nav").toggle();
			});
		});
	} ) ( jQuery );
	{/literal}
</script>
<div id="prestablog_menu_cat">
	<div id="menu-mobile"></div>
	<nav>
		{PrestaBlogContent return=$MenuCatNews}
	</nav>
</div>
<!-- Module Presta Blog -->
