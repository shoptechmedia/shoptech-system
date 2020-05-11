{*
 * Events And Courses
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @author    FMM Modules
 * @copyright Copyright 2017 © FMM Modules
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @category  FMM Modules
 * @package   eventsmanager
*}

{if $siblings}
<div class="block blockevents">
	<h4 class="title_block text-uppercase">
		<a href="/events/{$parent->id_category}-{$parent->link_rewrite}" title="{l s='Events' mod='stmeventscourses'}">{$parent->name}</a>
	</h4>

	<div class="block_content">
		<ul class="tree">
		{foreach $siblings as $sibling}
			<li>
				<a href="/event-category/{$sibling.id_category}-{$sibling.link_rewrite}">{$sibling.name}</a>
			</li>
		{/foreach}
		</ul>

		<div class="view_all">
			<a class="btn btn-default button button-small" style="{if $version > 1.6}float:right;{/if}margin-top:10px;" href="/events" title="{l s='Events' mod='stmeventscourses'}">
				<span >{l s='View All Events' mod='stmeventscourses'}</span>
			</a>
		</div>
	</div>
</div>

{/if}