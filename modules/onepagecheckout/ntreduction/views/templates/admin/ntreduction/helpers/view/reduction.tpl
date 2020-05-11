{*
* 2013-2019 2N Technologies
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to contact@2n-tech.com so we can send you a copy immediately.
*
* @author    2N Technologies <contact@2n-tech.com>
* @copyright 2013-2019 2N Technologies
* @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*}

<div id="products_list">
    <table class="table panel">
        <thead>
            <tr>
                <th id="product_head" colspan="{$colspan_product|intval}">

                </th>
                <th class="p_init_price {if in_array('p_init_price', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p_init_price" id="p_reset_init_price_all" name="p_reset_init_price_all"/>
                </th>
                <th class="p1 p1_1 {if in_array('p1_1', $columns_to_hide)}hide{/if}">
                    <input type="text" class="datepicker from" id="p1_date_from_all" name="p1_date_from_all" value=""/>
                </th>
                <th class="p1 p1_2 {if in_array('p1_2', $columns_to_hide)}hide{/if}">
                    <input type="text" class="datepicker to" id="p1_date_to_all" name="p1_date_to_all" value=""/>
                </th>
                <th class="p1 p1_3 {if in_array('p1_3', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p1_price" id="p1_new_price_all" name="p1_new_price_all" value=""/> {$currencySign|escape:'html':'UTF-8'}
                </th>
                <th class="p1 p1_4 {if in_array('p1_4', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p1_price p1_unique_discount" id="p1_discount_price_all" name="p1_discount_price_all" value=""/> {$currencySign|escape:'html':'UTF-8'}
                </th>
                <th class="p1 p1_5 {if in_array('p1_5', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p1_price p1_unique_discount" id="p1_amount_all" name="p1_amount_all" value=""/> {$currencySign|escape:'html':'UTF-8'}
                </th>
                <th class="p1 p1_6 {if in_array('p1_6', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p1_price p1_unique_discount" id="p1_percentage_all" name="p1_percentage_all" value=""/> %
                </th>
                <th class="p1 p1_7 {if in_array('p1_7', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_replace" id="p1_replace_all" name="p1_replace_all"/>
                </th>
                <th class="p1 p1_8 {if in_array('p1_8', $columns_to_hide)}hide{/if}">
                    <select name="p1_on_sale_all" id="p1_on_sale_all" >
                        <option value="0">{l s='Default' mod='ntreduction'}</option>
                        <option value="1">{l s='Yes' mod='ntreduction'}</option>
                        <option value="2">{l s='No' mod='ntreduction'}</option>
                    </select>
                </th>
                <th class="p1 p1_10 day {if in_array('p1_10', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_day" id="p1_monday_all" name="p1_monday_all"/>
                </th>
                <th class="p1 p1_11 day {if in_array('p1_11', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_day" id="p1_tuesday_all" name="p1_tuesday_all"/>
                </th>
                <th class="p1 p1_12 day {if in_array('p1_12', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_day" id="p1_wednesday_all" name="p1_wednesday_all"/>
                </th>
                <th class="p1 p1_13 day {if in_array('p1_13', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_day" id="p1_thursday_all" name="p1_thursday_all"/>
                </th>
                <th class="p1 p1_14 day {if in_array('p1_14', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_day" id="p1_friday_all" name="p1_friday_all"/>
                </th>
                <th class="p1 p1_15 day {if in_array('p1_15', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_day" id="p1_saturday_all" name="p1_saturday_all"/>
                </th>
                <th class="p1 p1_16 day {if in_array('p1_16', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_day" id="p1_sunday_all" name="p1_sunday_all"/>
                </th>
                <th class="p1 p1_9 {if in_array('p1_9', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p1_delete" id="p1_delete_all" name="p1_delete_all"/>
                </th>

                <th class="p2 p2_1 {if in_array('p2_1', $columns_to_hide)}hide{/if}">
                    <input type="text" class="datepicker from" id="p2_date_from_all" name="p2_date_from_all" value=""/>
                </th>
                <th class="p2 p2_2 {if in_array('p2_2', $columns_to_hide)}hide{/if}">
                    <input type="text" class="datepicker to" id="p2_date_to_all" name="p2_date_to_all" value=""/>
                </th>
                <th class="p2 p2_3 {if in_array('p2_3', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p2_price" id="p2_new_price_all" name="p2_new_price_all" value=""/> {$currencySign|escape:'html':'UTF-8'}
                </th>
                <th class="p2 p2_4 {if in_array('p2_4', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p2_price p2_unique_discount" id="p2_discount_price_all" name="p2_discount_price_all" value=""/> {$currencySign|escape:'html':'UTF-8'}
                </th>
                <th class="p2 p2_5 {if in_array('p2_5', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p2_price p2_unique_discount" id="p2_amount_all" name="p2_amount_all" value=""/> {$currencySign|escape:'html':'UTF-8'}
                </th>
                <th class="p2 p2_6 {if in_array('p2_6', $columns_to_hide)}hide{/if}">
                    <input type="text" class="p2_price p2_unique_discount" id="p2_percentage_all" name="p2_percentage_all" value=""/> %
                </th>
                <th class="p2 p2_7 {if in_array('p2_7', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_replace" id="p2_replace_all" name="p2_replace_all"/>
                </th>
                <th class="p2 p2_8 {if in_array('p2_8', $columns_to_hide)}hide{/if}">
                    <select name="p2_on_sale_all" id="p2_on_sale_all" >
                        <option value="0">{l s='Default' mod='ntreduction'}</option>
                        <option value="1">{l s='Yes' mod='ntreduction'}</option>
                        <option value="2">{l s='No' mod='ntreduction'}</option>
                    </select>
                </th>
                <th class="p2 p2_10 day {if in_array('p2_10', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_day" id="p2_monday_all" name="p2_monday_all"/>
                </th>
                <th class="p2 p2_11 day {if in_array('p2_11', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_day" id="p2_tuesday_all" name="p2_tuesday_all"/>
                </th>
                <th class="p2 p2_12 day {if in_array('p2_12', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_day" id="p2_wednesday_all" name="p2_wednesday_all"/>
                </th>
                <th class="p2 p2_13 day {if in_array('p2_13', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_day" id="p2_thursday_all" name="p2_thursday_all"/>
                </th>
                <th class="p2 p2_14 day {if in_array('p2_14', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_day" id="p2_friday_all" name="p2_friday_all"/>
                </th>
                <th class="p2 p2_15 day {if in_array('p2_15', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_day" id="p2_saturday_all" name="p2_saturday_all"/>
                </th>
                <th class="p2 p2_16 day {if in_array('p2_16', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_day" id="p2_sunday_all" name="p2_sunday_all"/>
                </th>
                <th class="p2 p2_9 {if in_array('p2_9', $columns_to_hide)}hide{/if}">
                    <input type="checkbox" class="p2_delete" id="p2_delete_all" name="p2_delete_all"/>
                </th>
            </tr>
            <tr>
                <td id="product_title" colspan="{$colspan_product|intval}">
                    {l s='Products' mod='ntreduction'}
                </td>
                <td class="p_init_price {if in_array('p_init_price', $columns_to_hide)}hide{/if}">

                </td>
                <td id="period1_title" colspan="{$colspan_period_1|intval}">
                    {l s='Period 1' mod='ntreduction'}
                </td>
                <td id="period2_title" colspan="{$colspan_period_2|intval}">
                    {l s='Period 2' mod='ntreduction'}
                </td>
            </tr>
            <tr id="columns_title">
                <td class="p0 p_1 {if in_array('p_1', $columns_to_hide)}hide{/if}">
                    {l s='Photo' mod='ntreduction'}
                </td>
                <td class="p0 p_2 {if in_array('p_2', $columns_to_hide)}hide{/if}">
                    {l s='Name' mod='ntreduction'}
                </td>
                <td class="p0 p_3 {if in_array('p_3', $columns_to_hide)}hide{/if}">
                    {l s='Reference' mod='ntreduction'}
                </td>
                <td class="p0 p_4 {if in_array('p_4', $columns_to_hide)}hide{/if}">
                    {l s='Price' mod='ntreduction'}
                </td>
                <td class="p0 p_price_no_tax {if in_array('p_price_no_tax', $columns_to_hide)}hide{/if}">
                    {l s='Price (Tax excl.)' mod='ntreduction'}
                </td>
                <td class="p0 p_init_price {if in_array('p_init_price', $columns_to_hide)}hide{/if}">
                    {l s='Init price' mod='ntreduction'}
                </td>
                <td class="p0 p_margin_after_discount {if in_array('p_margin_after_discount', $columns_to_hide)}hide{/if}">
                    {l s='Margin after discount' mod='ntreduction'}
                </td>
                <td class="p0 p_5 {if in_array('p_5', $columns_to_hide)}hide{/if}">
                    {l s='Quantity' mod='ntreduction'}
                </td>
                <td class="p0 p_6 {if in_array('p_6', $columns_to_hide)}hide{/if}">
                    {l s='Last reduced price' mod='ntreduction'}
                </td>
                <td class="p0 p_7 {if in_array('p_7', $columns_to_hide)}hide{/if}">
                    {l s='Current reduced price' mod='ntreduction'}
                </td>
                <td class="p0 p_8 {if in_array('p_8', $columns_to_hide)}hide{/if}">
                    {l s='Next reduced price' mod='ntreduction'}
                </td>
                <td class="p_init_price p_reset_init_price {if in_array('p_init_price', $columns_to_hide)}hide{/if}">
                    {l s='Reset init price' mod='ntreduction'}
                </td>
                <td class="p1 p1_1 {if in_array('p1_1', $columns_to_hide)}hide{/if}">
                    {l s='Start date' mod='ntreduction'}
                </td>
                <td class="p1 p1_2 {if in_array('p1_2', $columns_to_hide)}hide{/if}">
                    {l s='End date' mod='ntreduction'}
                </td>
                <td class="p1 p1_3 {if in_array('p1_3', $columns_to_hide)}hide{/if}">
                    {l s='New price' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(Replace your current price for the chosen period)' mod='ntreduction'}</span>
                </td>
                <td class="p1 p1_4 {if in_array('p1_4', $columns_to_hide)}hide{/if}">
                    {l s='Discount price' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(New sell price. The discount amount will be computed for you)' mod='ntreduction'}</span>
                </td>
                <td class="p1 p1_5 {if in_array('p1_5', $columns_to_hide)}hide{/if}">
                    {l s='Discount amount' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(The amount to substract to your current price)' mod='ntreduction'}</span>
                </td>
                <td class="p1 p1_6 {if in_array('p1_6', $columns_to_hide)}hide{/if}">
                    {l s='Discount percentage' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(The percentage of your current price to substract)' mod='ntreduction'}</span>
                </td>
                <td class="p1 p1_7 {if in_array('p1_7', $columns_to_hide)}hide{/if}">
                    {l s='Replacement' mod='ntreduction'} <br/>
                    <span class="infos">{l s='The product price is updated in a permanent way. (No need of dates)' mod='ntreduction'}</span>
                </td>
                <td class="p1 p1_8 {if in_array('p1_8', $columns_to_hide)}hide{/if}">
                    {l s='On sale' mod='ntreduction'} <br/>
                    <span class="infos">{l s='Display the "on sale" icon on the product page and product listing. Appearance depend of your theme' mod='ntreduction'}</span>
                </td>
                <td class="p1 p1_10 day {if in_array('p1_10', $columns_to_hide)}hide{/if}">
                    {l s='Mo' mod='ntreduction'} <br/>
                </td>
                <td class="p1 p1_11 day {if in_array('p1_11', $columns_to_hide)}hide{/if}">
                    {l s='Tu' mod='ntreduction'} <br/>
                </td>
                <td class="p1 p1_12 day {if in_array('p1_12', $columns_to_hide)}hide{/if}">
                    {l s='We' mod='ntreduction'} <br/>
                </td>
                <td class="p1 p1_13 day {if in_array('p1_13', $columns_to_hide)}hide{/if}">
                    {l s='Th' mod='ntreduction'} <br/>
                </td>
                <td class="p1 p1_14 day {if in_array('p1_14', $columns_to_hide)}hide{/if}">
                    {l s='Fr' mod='ntreduction'} <br/>
                </td>
                <td class="p1 p1_15 day {if in_array('p1_15', $columns_to_hide)}hide{/if}">
                    {l s='Sa' mod='ntreduction'} <br/>
                </td>
                <td class="p1 p1_16 day {if in_array('p1_16', $columns_to_hide)}hide{/if}">
                    {l s='Su' mod='ntreduction'} <br/>
                </td>
                <td class="p1 p1_9 {if in_array('p1_9', $columns_to_hide)}hide{/if}">
                    {l s='Delete' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(Delete your discounts)' mod='ntreduction'}</span>
                </td>

                <td class="p2 p2_1 {if in_array('p2_1', $columns_to_hide)}hide{/if}">
                    {l s='Start date' mod='ntreduction'}
                </td>
                <td class="p2 p2_2 {if in_array('p2_2', $columns_to_hide)}hide{/if}">
                    {l s='End date' mod='ntreduction'}
                </td>
                <td class="p2 p2_3 {if in_array('p2_3', $columns_to_hide)}hide{/if}">
                    {l s='New price' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(Replace your current price for the chosen period)' mod='ntreduction'}</span>
                </td>
                <td class="p2 p2_4 {if in_array('p2_4', $columns_to_hide)}hide{/if}">
                    {l s='Discount price' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(New sell price. The discount amount will be computed for you)' mod='ntreduction'}</span>
                </td>
                <td class="p2 p2_5 {if in_array('p2_5', $columns_to_hide)}hide{/if}">
                    {l s='Discount amount' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(The amount to substract to your current price)' mod='ntreduction'}</span>
                </td>
                <td class="p2 p2_6 {if in_array('p2_6', $columns_to_hide)}hide{/if}">
                    {l s='Discount percentage' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(The percentage of your current price to substract)' mod='ntreduction'}</span>
                </td>
                <td class="p2 p2_7 {if in_array('p2_7', $columns_to_hide)}hide{/if}">
                    {l s='Replacement' mod='ntreduction'} <br/>
                    <span class="infos">{l s='The product price is updated in a permanent way. (No need of dates)' mod='ntreduction'}</span>
                </td>
                <td class="p2 p2_8 {if in_array('p2_8', $columns_to_hide)}hide{/if}">
                    {l s='On sale' mod='ntreduction'} <br/>
                    <span class="infos">{l s='Display the "on sale" icon on the product page and product listing. Appearance depend of your theme' mod='ntreduction'}</span>
                </td>
                <td class="p2 p2_10 day {if in_array('p2_10', $columns_to_hide)}hide{/if}">
                    {l s='Mo' mod='ntreduction'} <br/>
                </td>
                <td class="p2 p2_11 day {if in_array('p2_11', $columns_to_hide)}hide{/if}">
                    {l s='Tu' mod='ntreduction'} <br/>
                </td>
                <td class="p2 p2_12 day {if in_array('p2_12', $columns_to_hide)}hide{/if}">
                    {l s='We' mod='ntreduction'} <br/>
                </td>
                <td class="p2 p2_13 day {if in_array('p2_13', $columns_to_hide)}hide{/if}">
                    {l s='Th' mod='ntreduction'} <br/>
                </td>
                <td class="p2 p2_14 day {if in_array('p2_14', $columns_to_hide)}hide{/if}">
                    {l s='Fr' mod='ntreduction'} <br/>
                </td>
                <td class="p2 p2_15 day {if in_array('p2_15', $columns_to_hide)}hide{/if}">
                    {l s='Sa' mod='ntreduction'} <br/>
                </td>
                <td class="p2 p2_16 day {if in_array('p2_16', $columns_to_hide)}hide{/if}">
                    {l s='Su' mod='ntreduction'} <br/>
                </td>
                <td class="p2 p2_9 {if in_array('p2_9', $columns_to_hide)}hide{/if}">
                    {l s='Delete' mod='ntreduction'} <br/>
                    <span class="infos">{l s='(Delete your discounts)' mod='ntreduction'}</span>
                </td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>