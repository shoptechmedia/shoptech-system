/**
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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/


$(document).ready(function(){

   if(!$.totalStorage(iqitpopup_name)){
      $('#iqitpopup').addClass('showed-iqitpopup');
      $('#iqitpopup-overlay').addClass('showed-iqitpopupo');
   } 

   $(document).on('click', '#iqitpopup .cross, #iqitpopup-overlay', function(e){
      $('#popup_toggle button').removeClass('display_none');
   	$('#iqitpopup-overlay').removeClass('showed-iqitpopupo');
   	$('#iqitpopup').removeClass('showed-iqitpopup');
         $('#iqitpopup').toggleClass('hide_popup');
   	if($("#iqitpopup-checkbox").is(':checked'))
   	 iqitpopsetcook();
   });

   $('#popup_toggle button').click(function(e){
      $(this).addClass('display_none');
      if ($('#iqitpopup').hasClass('hide_popup')) {
         $('#iqitpopup').removeClass('hide_popup');
         $('#iqitpopup').addClass('showed-iqitpopup');
      } else {
         $('#iqitpopup').removeClass('showed-iqitpopup');
         $('#iqitpopup').toggleClass('hide_popup');
      }

   });

   $('#confirm_form').click(function(){
      if ($(this).is(':checked')) {
         $('.iqit-btn-newsletter').removeAttr('disabled');
      } else {
         $('.iqit-btn-newsletter').prop('disabled', true);
      }
   });

   $('#terms_popup_toggle').click(function(){
      var link = $(this).attr('data-target');
      $('.terms_popup_wrap').fadeIn(200);
   });

   $('.terms_popup_wrap button').click(function(){
      $('.terms_popup_wrap').fadeOut(200);
   });

});

$(document).on('click', ' #iqitpopup  .iqit-btn-newsletter', function(e){
    iqitpopsetcook();
    $('#iqitpopup-overlay').removeClass('showed-iqitpopupo');
   $('#iqitpopup').removeClass('showed-iqitpopup');
});




function iqitpopsetcook() {
   $.totalStorage(iqitpopup_name, true);
   var name = iqitpopup_name;
   var value = '1';
   var expire = new Date();
   expire.setDate(expire.getDate()+iqitpopup_time);
   document.cookie = name + "=" + escape(value) +";path=/;" + ((expire==null)?"" : ("; expires=" + expire.toGMTString()))
}
