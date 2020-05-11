{*
* NOTICE OF LICENSE
* Written by PensoPay A/S
* Copyright 2019
* license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* E-mail: support@pensopay.com
*}
<table>
    <tr>
        <td style="width: 100%; text-align: right">{l s='PensoPay transaction ID:' mod='pensopay'} {$transaction_id|escape:'htmlall':'UTF-8'}</td>
    </tr>
</table>
{if isset($viabill) AND $viabill}
    <br>
    Det skyldige beløb kan alene betales med frigørende virkning til ViaBill, som fremsender særskilt opkrævning.
    <br>
    Betaling kan ikke ske ved modregning af krav, der udspringer af andre retsforhold.
{/if}