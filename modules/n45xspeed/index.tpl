{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{$time = time()}


			<!-- <div class="serviceinfo points">
			<ul>
				<li><span class="icon_span"><img src="{$img_dir}car.png"></span><span>Branchens længeste garanti - 3 år!</span></li>
				<li><span class="icon_span"><img src="{$img_dir}arrow.png"></span><span>Fantastik support fra eksperterne</span></li>
				<li><span class="icon_span"><img src="{$img_dir}box.png"></span><span>Gratis fragt ved <strong>1000 kr</strong></span></li>
			</ul>
		</div> -->
{if isset($HOOK_HOME_TAB_CONTENT) && $HOOK_HOME_TAB_CONTENT|trim}
    {if isset($HOOK_HOME_TAB) && $HOOK_HOME_TAB|trim}
        <ul id="home-page-tabs" class="nav nav-tabs clearfix">
			{$HOOK_HOME_TAB}
		</ul>
	{/if}
	<div class="tab-content">{$HOOK_HOME_TAB_CONTENT}</div>
{/if}
{if isset($HOOK_HOME) && $HOOK_HOME|trim}
	{$HOOK_HOME}
{/if}

{*<div class="trustpilot_sections">
	<div class="emaerket">
		<img src="{$img_dir}emaerket.png">
	</div>
	<div class="trustbadge">
		<img src="{$img_dir}miljoe-pakning-badge-100x100.png">
	</div>
	<div class="truspilotreviews">
		<img src="{$img_dir}t-maerket.png">
	</div>
</div>*}
<!-- 
		<span class="c_info">{l s='Fabriksparken 23 2600 Glostrup - København'}</span><span class="c_sparator">/</span>
		<span class="c_tnumber">{l s='CVR : 26 629 721'}</span><span class="c_sparator">/</span>
		<span class="c_tnumber">{l s='Telefonnummer : 53 54 40 43'}</span><span class="c_sparator">/</span>
		<span class="c_email">{l s='info@flashfotovideo.dk'}</span> -->