{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}
<script type='text/javascript'>
    var o;

    var viabillInit = function() {
        o =document.createElement('script');
        o.type='text/javascript';
        o.async=true;
        o.id = 'viabillscript';
        o.src='https://pricetag.viabill.com/script/{$viabillId|escape:'html':'UTF-8'}}';
        var s=document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(o,s);
    };

    var viabillReset = function() {
        document.getElementById('viabillscript').remove();
        vb = null;
        pricetag = null;
        //Viabill changed their code we need this to force it to re-consider initialized iframes
        //As uninitialized
        document.querySelectorAll('div.viabill-pricetag-optional-styles:not([data-dynamic-price=""])').forEach(function(item) {
            item.classList.remove('viabill-pricetag-optional-styles');
        });
        viabillInit();
    };

    (function() {
        viabillInit();
    })();
</script>