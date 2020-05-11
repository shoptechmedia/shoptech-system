/*
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
*/
$(document).ready(function() {
	function getCookie(name) {
		var nameEQ = name + "=";

		var ca = document.cookie.split(';');

		for(var i=0;i < ca.length;i++) {
			var c = ca[i];

			while (c.charAt(0)==' ') c = c.substring(1,c.length);

			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}

		return null;
	}

	function eraseCookie(name) {   
		document.cookie = name+'=; Max-Age=-99999999;';  
	}

    $('#newsletter-input').on({
        focus: function() {
            if ($(this).val() == placeholder_blocknewsletter || $(this).val() == msg_newsl)
                $(this).val('');
        },
        blur: function() {
            if ($(this).val() == '')
                $(this).val(placeholder_blocknewsletter);
        }
    });

	var cssClass = 'alert alert-danger';
    if (typeof nw_error != 'undefined' && !nw_error)
		cssClass = 'alert alert-success';

    if (typeof msg_newsl != 'undefined' && msg_newsl && getCookie('bn_msg_newsl') != null)
	{
        $('#columns').prepend('<div class="clearfix"></div><p class="' + cssClass + '"> ' + alert_blocknewsletter + '<i class="icon icon-close newsletter-close"></i></p>');
		$('html, body').animate({scrollTop: $('#columns').offset().top}, 'slow');
		eraseCookie('bn_msg_newsl');
	}
    $('#columns').find('.newsletter-close').first().click(function() {
        $(this).parents('.alert').first().slideUp();
    });

});