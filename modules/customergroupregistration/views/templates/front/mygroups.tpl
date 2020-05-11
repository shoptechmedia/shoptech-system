{*
 * This file is part of module Customer Group Registration
 *
 *  @author    Bellini Services <bellini@bellini-services.com>
 *  @copyright 2007-2017 bellini-services.com
 *  @license   readme
 *
 * Your purchase grants you usage rights subject to the terms outlined by this license.
 *
 * You CAN use this module with a single, non-multi store configuration, production installation and unlimited test installations of PrestaShop.
 * You CAN make any modifications necessary to the module to make it fit your needs. However, the modified module will still remain subject to this license.
 *
 * You CANNOT redistribute the module as part of a content management system (CMS) or similar system.
 * You CANNOT resell or redistribute the module, modified, unmodified, standalone or combined with another product in any way without prior written (email) consent from bellini-services.com.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *}
 {capture name=path}
    <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
        {l s='My account' mod='customergroupregistration'}
    </a>
    <span class="navigation-pipe">
        {$navigationPipe}
    </span>
    <span class="navigation_page">
        {l s='My Groups' mod='customergroupregistration'}
    </span>
{/capture}
<div id="mygroups">
	<h2>{l s='My groups' mod='customergroupregistration'}</h2>

	{include file="$tpl_dir./errors.tpl"}

	<div id="customergroup_block_right" class="block blockcustomergroup">
	{if $groups && sizeof($groups) > 1}
	
		<form action="{$link->getModuleLink('customergroupregistration', 'mygroups', array(), true)}" method="post">	{* bellini: nothing to escape, fix the validator *}
		{if $cgr_mode == 0}
			<p>{l s='Select a new group from the list below' mod='customergroupregistration'}</p>
			<p>
				<select name="id_group" id="id_group">
					{foreach from=$groups item=g}
					<option value="{$g.id_group}" {if in_array($g.id_group, $customerGroup)} selected="selected"{/if}>{$g.name|escape:'htmlall':'UTF-8'}</option>	{* bellini: nothing else needs to be escaped *}
					{/foreach}
				</select>
			</p>
		{elseif $cgr_mode == 1}
			<p>{l s='Select one or more groups from the list below' mod='customergroupregistration'}</p>
			<p>
				<select name="id_group[]" id="id_group" multiple="multiple" size="5">
					{foreach from=$groups item=g}
					<option value="{$g.id_group}" {if in_array($g.id_group, $customerGroup)} selected="selected"{/if}>{$g.name|escape:'htmlall':'UTF-8'}</option>	{* bellini: nothing else needs to be escaped *}
					{/foreach}
				</select>
			</p>
		{/if}
			<input type="submit" name="submit" value="{l s='Update group' mod='customergroupregistration'}" class="button" />
		</form>
	{else}
		<p>{l s='No groups available' mod='customergroupregistration'}</p>
	{/if}
	</div>

	<ul class="footer_links clearfix">
		<li>
		<a class="btn btn-default button button-small" href="{$link->getPageLink('my-account', true)}">	{* bellini: nothing to escape, fix the validator *}
		    <span>
			<i class="icon-chevron-left"></i>{l s='Back to your account' mod='customergroupregistration'}
		    </span>
		</a>
	    </li>
		<li>
		<a class="btn btn-default button button-small" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">	{* bellini: nothing needs to be escaped *}
		    <span>
			<i class="icon-chevron-left"></i>{l s='Home' mod='customergroupregistration'}
		    </span>
		</a>
	    </li>
	</ul>
</div>
