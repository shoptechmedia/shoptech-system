{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}

{extends "$layout"}
{block name="content"}
    <section>
        <iframe src="{$src|escape:'javascript':'UTF-8'}" width="100%" height="650" ></iframe>
    </section>
    <script type="text/javascript">
        var poller = setInterval(pollPayment, 5000);

        function pollPayment() {
            jQuery.ajax('{$endpoint|escape:'javascript':'UTF-8'}', {
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (!obj.repeat) {
                        clearInterval(poller);
                    }
                    if (obj.error || obj.success) {
                        document.location = obj.redirect;
                    }
                }
            });
        }
    </script>
{/block}