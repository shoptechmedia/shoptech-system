<div class="side-tab-body p-0 border-0" id="sidemenu-Tab">
	<nav class="first-sidemenu">
		<ul class="resp-tabs-list hor_1">
			<li class="dashboard-slica {if $isDashboard}resp-tab-active{/if}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">{l s='Dashboard'}</span></li>
			<li class="newsletter-slica {if $isNewsletter}resp-tab-active{/if}"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">{l s='Newsletter'}</span></li>
		</ul>
	</nav>
	<nav class="second-sidemenu">
		<ul class="resp-tabs-container hor_1">
			<li class="dashboard-slica {if $isDashboard}resp-tab-content-active{/if}">
				<div class="row">
					<div class="col-md-12">
						<div class="panel sidetab-menu">
							<div class="panel-body tabs-menu-body p-0 border-0">
								<div class="tab-content">
									<div class="tab-pane active">
										<div class="side-menu p-0">
											{foreach $tabs as $t}
												{if $t.active && $t.id_parent == 0 && $t.class_name != 'AdminNewsletter'}
												<div class="slide submenu {if $t.current}is-expanded{/if}">
													<a class="side-menu__item {if $t.current}active{/if}" {if $t.sub_tabs|@count}data-toggle="slide"{/if} href="{if $t.sub_tabs|@count && isset($t.sub_tabs[0].href)}{$t.sub_tabs[0].href|escape:'html':'UTF-8'}{else}{$t.href|escape:'html':'UTF-8'}{/if}">
														<span class="side-menu__label">{$t.name}</span>{if $t.sub_tabs|@count}<i class="angle fa fa-angle-down"></i>{/if}
													</a>

													{if $t.sub_tabs|@count}
													<ul class="slide-menu submenu-list">
														{foreach from=$t.sub_tabs item=t2}
															{if $t2.active}
															<li {if $t2.current} class="is-expanded"{/if}>
																<a href="{$t2.href|escape:'html':'UTF-8'}" class="slide-item {if $t2.current}active{/if}">
																	{if $t2.name eq ''}{$t2.class_name|escape:'html':'UTF-8'}{else}{$t2.name|escape:'html':'UTF-8'}{/if}
																</a>
															</li>
															{/if}
														{/foreach}
													</ul>
													{/if}
												</div>
												{/if}
											{/foreach}
										</div>

										{hook h='displayAdminNavBarBeforeEnd'}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>

			<li class="newsletter-slica {if $isNewsletter}resp-tab-content-active{/if}">
				<div class="row">
					<div class="col-md-12">
						<div class="panel sidetab-menu">
							<div class="panel-body tabs-menu-body p-0 border-0">
								<div class="tab-content">
									<div class="tab-pane active">
										<div class="side-menu p-1">
											{foreach $tabs as $t}
												{if $t.active && $t.id_parent == 0 && $t.class_name == 'AdminNewsletter'}
												<div class="slide submenu {if $t.current}is-expanded{/if}">
													<a class="side-menu__item {if $t.current}active{/if}" {if $t.sub_tabs|@count}data-toggle="slide"{/if} href="{if $t.sub_tabs|@count && isset($t.sub_tabs[0].href)}{$t.sub_tabs[0].href|escape:'html':'UTF-8'}{else}{$t.href|escape:'html':'UTF-8'}{/if}">
														<span class="side-menu__label">{$t.name}</span>{if $t.sub_tabs|@count}<i class="angle fa fa-angle-down"></i>{/if}
													</a>

													{if $t.sub_tabs|@count}
													<ul class="slide-menu submenu-list">
														{foreach from=$t.sub_tabs item=t2}
															{if $t2.active}
															<li {if $t2.current} class="is-expanded"{/if}>
																<a href="{$t2.href|escape:'html':'UTF-8'}" class="slide-item {if $t2.current}active{/if}">
																	{if $t2.name eq ''}{$t2.class_name|escape:'html':'UTF-8'}{else}{$t2.name|escape:'html':'UTF-8'}{/if}
																</a>
															</li>
															{/if}
														{/foreach}
													</ul>
													{/if}
												</div>
												{/if}
											{/foreach}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</nav>
</div>