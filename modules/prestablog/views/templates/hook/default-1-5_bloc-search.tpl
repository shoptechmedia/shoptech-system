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
<div class="block">
	<h4 class="title_block">{l s='Search on blog' mod='prestablog'}</h4>
	<div class="block_content">
		<form action="{PrestaBlogUrl}" method="post" id="prestablog_bloc_search">
			<input id="prestablog_search" type="text" value="{$prestablog_search_query|escape:'htmlall':'UTF-8'}" placeholder="{l s='Search on blog' mod='prestablog'}" name="prestablog_search" autocomplete="off">
			<input class="button button_search" type="submit" value="" name="submit_search">
		</form>
	</div>
</div>
<!-- /Module Presta Blog -->
