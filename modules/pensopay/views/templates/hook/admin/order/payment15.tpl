{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}
<br>
<fieldset class="pensopay-order-info">
    <legend>{$title|escape:'htmlall':'UTF-8'}</legend>

    <style type="text/css">
        .pensopay-order-info > div.panel-heading {
            text-align: center;
            height: 100% !important;
        }

        .pensopay-order-info > div > img {
            width: 160px;
            display: block;
            padding-top: 15px;
            margin: 0 auto;
        }
    </style>

    {if isset($errors) AND $errors}
        {if isset($error_text) AND $error_text}
            <p class="error alert-danger">{$error_text|escape:'htmlall':'UTF-8'}</p>
        {/if}
        {if isset($error_json) AND $error_json}
            <pre>{$error_json|escape:'html':'UTF-8'}</pre>
        {/if})
    {/if}

    {if !isset($fatal_error)}
        <table>
            <tbody>
            <tr>
                <th style="padding-right: 10px">{l s='PensoPay order ID:' mod='pensopay'}</th>
                {if isset($test_mode) AND $test_mode}
                    <td>{$order_id|escape:'htmlall':'UTF-8'} [{l s='test mode' mod='pensopay'}]</td>
                {else}
                    <td>{$order_id|escape:'htmlall':'UTF-8'}</td>
                {/if}
            </tr>
            <tr>
                <th>{l s='Transaction ID:' mod='pensopay'}</th>
                <td>{$transaction_id|escape:'htmlall':'UTF-8'}</td>
            </tr>
            <tr>
                <th>{l s='Acquirer:' mod='pensopay'}</th>
                <td>{$acquirer|escape:'htmlall':'UTF-8'}</td>
            </tr>
            <tr>
                <th>{l s='Card type:' mod='pensopay'}</th>
                <td>{$card_type|escape:'htmlall':'UTF-8'}</td>
            </tr>
            <tr>
                <th>{l s='Country:' mod='pensopay'}</th>
                <td>{$country|escape:'htmlall':'UTF-8'}</td>
            </tr>
            <tr>
                <th>{l s='Created:' mod='pensopay'}</th>
                <td>{$created|escape:'htmlall':'UTF-8'}</td>
            </tr>
            {if isset($fraud_remarks) AND $fraud_remarks}
                <tr>
                    <th>{l s='Fraud:' mod='pensopay'}</th>
                    {foreach from=$fraud_remarks item=fraud_remark}
                        <td class="alert-danger">{$fraud_remark|escape:'htmlall':'UTF-8'}</td>
                    {/foreach}
                </tr>
            {/if}
            </tbody>
        </table>
        <br>
        <table class="table">
            <thead>
            <tr>
                <th>{l s='Date' mod='pensopay'}</th>
                <th>{l s='Operation' mod='pensopay'}</th>
                <th>{l s='Amount' mod='pensopay'}</th>
            </tr>
            </thead>
            <tbody>
            {if isset($operations) AND $operations}
                {foreach from=$operations item=operation}
                    <tr>
                        <td>{$operation.date|escape:'htmlall':'UTF-8'}</td>
                        <td>{$operation.status|escape:'htmlall':'UTF-8'}</td>
                        <td style="text-align:right">{$operation.amount|escape:'htmlall':'UTF-8'}</td>
                    </tr>
                {/foreach}
            {/if}
            </tbody>
        </table>
        <br>
        <br>
        {if $resttocap > 0}
            <form action="{$url|escape:'html':'UTF-8'}" method="post" name="capture-cancel">
                <input type="hidden" name="qp_count" value="{$qp_count|escape:'htmlall':'UTF-8'}" />
                <b>{l s='Amount to capture:' mod='pensopay'}</b>
                <div>
                    <input style="width:auto;display:inline" type="text" name="acramount" value="{$resttocap_render|escape:'htmlall':'UTF-8'}" />
                    <input type="submit" class="button" name="qpcapture" value="{l s='Capture' mod='pensopay'}"
                           onclick="return confirm('{l s='Are you sure you want to capture the amount?' mod='pensopay'}')" />
                </div>
                <br>
            </form>
        {/if}

        {if $resttoref > 0}
            <form action="{$url|escape:'html':'UTF-8'}" method="post" name="capture-cancel">
                <input type="hidden" name="qp_count" value="{$qp_count|escape:'htmlall':'UTF-8'}" />
                <b>{l s='Amount to refund' mod='pensopay'} ({$resttoref_render|escape:'htmlall':'UTF-8'})</b>
                <div>
                    <input style="width:auto;display:inline" type="text" name="acramountref" id="acramountref" value="" />
                    <input type="submit" class="button" name="qprefund" value="{l s='Refund' mod='pensopay'}"
                           onclick="return confirm('{l s='Are you sure you want to refund the amount?' mod='pensopay'}')" />
                </div>
                <br>
            </form>
        {/if}

        {if $allowcancel}
            <form action="{$url|escape:'html':'UTF-8'}" method="post" name="capture-cancel">
                <input type="hidden" name="qp_count" value="{$qp_count|escape:'htmlall':'UTF-8'}" />
                <input type="submit" class="button" name="qpcancel" value="{l s='Cancel the transaction!' mod='pensopay'}"
                       onclick="return confirm('{l s='Are you sure you want cancel the transaction?' mod='pensopay'}')" />
            </form>
            <br>
        {/if}

        <a href="https://manage.quickpay.net" target="_blank" style="color: blue;">{l s='QuickPay manager' mod='pensopay'}</a>
    {else}
        <pre>{$fatal_error_text|escape:'htmlall':'UTF-8'}</pre>
    {/if}
</fieldset>
