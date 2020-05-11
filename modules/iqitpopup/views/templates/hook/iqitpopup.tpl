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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div id="iqitpopup" class="hide_popup" data-height="{$height}px">
<div class="iqitpopup-close">
<!--<div class="iqit-close-checkbox">
 <div><input type="checkbox" class="checkbox" name="iqitpopup-checkbox" id="iqitpopup-checkbox" /></div>  <label for="iqitpopup-checkbox">{l s='Do not show again.' mod='iqitpopup'}</label></div> -->
<div class="iqit-close-popup"><span class="cross" title="{l s='Close window' mod='iqitpopup'}"></span></div>
</div>


<div class="iqitpopup-content">{$txt|stripslashes}</div>
{if $newsletter}
<div class="iqitpopup-newsletter-form">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
		<!-- <span class="promo-text">{l s='Sign up to receive latest news and updates direct to your inbox' mod='iqitpopup'}</span> -->
	</div>
	<div class="col-xs-12 col-sm-12">
	<form action="{$link->getPageLink('index', null, null, null, false, null, true)|escape:'html':'UTF-8'}" method="post">
			<div>
				<input class="inputNew form-control grey newsletter-input" type="text" name="name" size="18" placeholder="{l s='Enter your Name' mod='iqitpopup'}" value="" />
				<input class="inputNew form-control grey newsletter-input" type="text" name="email" size="18" placeholder="{l s='Enter your e-mail' mod='iqitpopup'}" value="" />
				<input type="checkbox" name="confirm" value="yes" id="confirm_form"><label for="confirm">Jeg accepterer <a href="#" id="terms_popup_toggle">betingelserne</a></label>
                <button type="submit" name="submitNewsletter" class="btn btn-default button button-medium iqit-btn-newsletter" disabled>
                    <span>{l s='JA TAK, SEND MIG E-BOGEN NU!' mod='iqitpopup'} 
				</span>
                </button>
				<input type="hidden" name="action" value="0" />
			</div>
		</form>
	</div>		</div></div>
	{/if}
</div> <!-- #layer_cart -->
<div id="iqitpopup-overlay hide_popup"></div>
<div class="" id="popup_toggle">
	<button class="btn btn_default">{l s='Get a free ebook now!' mod='iqitpopup'}</button>
</div>
<div class="terms_popup_wrap">
<div id="terms_popup">{$content}</div>
<button>{l s='close' mod='iqitpopup'}</button>
</div>
