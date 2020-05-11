<div class="bootstrap">
	<nav id="{if $employee->bo_menu}nav-sidebar{else}nav-topbar{/if}" role="navigation">
		{if !$tab}
			<div class="mainsubtablist" style="display:none;"></div>
		{/if}

		<style type="text/css">

		{if $smarty.get.controller === 'AdminNewsletter'}
			.maintab {
				display: none;
			}

			.isrealmenuforShop, .isRealNewsletterMenu {
				display: block !important;
			}
		{/if}
			
		</style>

		<ul class="menu">
			<li class="searchtab">
				{include file="search_form.tpl" id="header_search" show_clear_btn=1}
			</li>
			<li class="maintab {if $smarty.get.controller === 'AdminDashboard'}active{/if} has_submenu isrealmenuforShop" id="maintab-AdminDashboard">
				<a href="{$shop_dashboard}" class="title" >
					<i class="icon-AdminDashboard"></i>
					<span>Shop</span>
				</a>
			</li>
			{foreach $tabs as $t}
				{if $t.active}
				<li class="maintab {if $t.current}active{/if} {if $t.sub_tabs|@count}has_submenu{/if}" id="maintab-{$t.class_name}" data-submenu="{$t.id_tab}">
					<a href="{if $t.sub_tabs|@count && isset($t.sub_tabs[0].href)}{$t.sub_tabs[0].href|escape:'html':'UTF-8'}{else}{$t.href|escape:'html':'UTF-8'}{/if}" class="title" >
						<i class="icon-{$t.class_name}"></i>
						<span>{if $t.name eq ''}{$t.class_name|escape:'html':'UTF-8'}{else}{$t.name|escape:'html':'UTF-8'}{/if}</span>
					</a>
					{if $t.sub_tabs|@count}
						<ul class="submenu">
						{foreach from=$t.sub_tabs item=t2}
							{if $t2.active}
							<li id="subtab-{$t2.class_name|escape:'html':'UTF-8'}" {if $t2.current} class="active"{/if}>
								<a href="{$t2.href|escape:'html':'UTF-8'}">
									{if $t2.name eq ''}{$t2.class_name|escape:'html':'UTF-8'}{else}{$t2.name|escape:'html':'UTF-8'}{/if}
								</a>
							</li>
							{/if}
						{/foreach}
						</ul>
					{/if}
				</li>
				{/if}
			{/foreach}
			<li class="maintab {if $smarty.get.controller === 'AdminNewsletter'}active{/if} has_submenu isRealNewsletterMenu newslettermaindashboard" id="maintab-AdminNewsletter">
				<a href="{$newsletter_dashboard}" class="title" >
					<i class="icon-AdminNewsletter"></i>
					<span>Newsletter</span>
				</a>
			</li>
			<li class="maintab {if $smarty.get.render === 'contacts'}active{/if} has_submenu isRealNewsletterMenu" id="maintab-AdminNewsletter">
				<a href="{$newsletter_dashboard}&render=contacts" class="title" >
					<i class="icon-AdminNewsletter"></i>
					<span>Contacts</span>
				</a>
			</li>
			<li class="maintab {if $smarty.get.render === 'segments'}active{/if} has_submenu isRealNewsletterMenu" id="maintab-AdminNewsletter">
				<a href="{$newsletter_dashboard}&render=segments" class="title" >
					<i class="icon-AdminNewsletter"></i>
					<span>Segments</span>
				</a>
			</li>
			<li class="maintab {if $smarty.get.render === 'campaigns'}active{/if} has_submenu isRealNewsletterMenu" id="maintab-AdminNewsletter">
				<a href="{$newsletter_dashboard}&render=campaigns" class="title" >
					<i class="icon-AdminNewsletter"></i>
					<span>Campaigns</span>
				</a>
			</li>
			<li class="maintab {if $smarty.get.render === 'emails'}active{/if} has_submenu isRealNewsletterMenu" id="maintab-AdminNewsletter">
				<a href="{$newsletter_dashboard}&render=emails" class="title" >
					<i class="icon-AdminNewsletter"></i>
					<span>Emails</span>
				</a>
			</li>
			<li class="maintab {if $smarty.get.render === 'reports'}active{/if} has_submenu isRealNewsletterMenu" id="maintab-AdminNewsletter">
				<a href="{$newsletter_dashboard}&render=reports" class="title" >
					<i class="icon-AdminNewsletter"></i>
					<span>Reports</span>
				</a>
			</li>
		</ul>
		<span class="menu-collapse">
			<i class="icon-align-justify icon-rotate-90"></i>
		</span>
		{hook h='displayAdminNavBarBeforeEnd'}
	</nav>
</div>
