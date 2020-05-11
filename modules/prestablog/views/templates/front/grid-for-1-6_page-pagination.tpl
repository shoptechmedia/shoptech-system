{*
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 *
 *}

<!-- Module Presta Blog -->
<!-- Pagination -->
{if isset($Pagination.NombreTotalPages) && $Pagination.NombreTotalPages > 1}
	<div class="prestablog_pagination">
		{if $Pagination.PageCourante > 1}
			<a href="{PrestaBlogUrl categorie=$prestablog_categorie_link_rewrite start=$Pagination.StartPrecedent p=$Pagination.PagePrecedente c=$prestablog_categorie m=$prestablog_month y=$prestablog_year}{$prestablog_search_query|escape:'htmlall':'UTF-8'}"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg></a>
		{else}
			<span class="disabled"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg></span>
		{/if}
		{foreach from=$Pagination.PremieresPages key=key_page item=value_page}
			{if ($Pagination.PageCourante == $key_page) || (!$Pagination.PageCourante && $key_page == 1)}
				<span class="current">{$key_page|intval}</span>
			{else}
				{if $key_page == 1}
					<a href="{PrestaBlogUrl categorie=$prestablog_categorie_link_rewrite c=$prestablog_categorie m=$prestablog_month y=$prestablog_year}{$prestablog_search_query|escape:'htmlall':'UTF-8'}">{$key_page|intval}</a>
				{else}
					<a href="{PrestaBlogUrl categorie=$prestablog_categorie_link_rewrite start=$value_page p=$key_page c=$prestablog_categorie m=$prestablog_month y=$prestablog_year}{$prestablog_search_query|escape:'htmlall':'UTF-8'}"
					>{$key_page|intval}</a>
				{/if}
			{/if}
		{/foreach}
		{if isset($Pagination.Pages) && $Pagination.Pages}
			<span class="more">...</span>
			{foreach from=$Pagination.Pages key=key_page item=value_page}
				{if !in_array($value_page, $Pagination.PremieresPages)}
					{if ($Pagination.PageCourante == $key_page) || (!$Pagination.PageCourante && $key_page == 1)}
						<span class="current">{$key_page|intval}</span>
					{else}
						<a href="{PrestaBlogUrl categorie=$prestablog_categorie_link_rewrite start=$value_page p=$key_page c=$prestablog_categorie m=$prestablog_month y=$prestablog_year}{$prestablog_search_query|escape:'htmlall':'UTF-8'}"
						>{$key_page|intval}</a>
					{/if}
				{/if}
			{/foreach}
		{/if}
		{if $Pagination.PageCourante < $Pagination.NombreTotalPages}
			<a href="{PrestaBlogUrl categorie=$prestablog_categorie_link_rewrite start=$Pagination.StartSuivant p=$Pagination.PageSuivante c=$prestablog_categorie m=$prestablog_month y=$prestablog_year}{$prestablog_search_query|escape:'htmlall':'UTF-8'}"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg></a>
		{else}
			<span class="disabled"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg></span>
		{/if}
	</div>
{/if}
<!-- /Pagination -->
<!-- /Module Presta Blog -->
