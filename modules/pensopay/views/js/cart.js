/**
 * NOTICE OF LICENSE
 *
 *  @author    PensoPay A/S
 *  @copyright 2019 PensoPay
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
 *  E-mail: support@pensopay.com
 */

function handleTerms() {
    var $terms = jQuery('.terms-checkbox input');
    if ($terms.is(':checked')) {
        jQuery('button.mobilepay-checkout').attr('disabled', false);
    } else {
        jQuery('button.mobilepay-checkout').attr('disabled', true);
    }
}

jQuery(document).ready(function() {
    handleTerms();

    var $terms = jQuery('.terms-checkbox input');
    $terms.click(function() {
        handleTerms();
    });
});