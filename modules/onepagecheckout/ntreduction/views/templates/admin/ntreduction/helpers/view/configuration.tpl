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

<div class="panel-heading">
    <i class="fas fa-cogs"></i>
    &nbsp;{l s='Configuration' mod='ntreduction'}
</div>
<div id="config" class="panel form_config">
    <form id="ntreduction_columns_config" method='post' action='#'>
        <div>
            <p>
                {l s='You can choose the columns you want to display:' mod='ntreduction'}
            </p>
            <div class="display_columns">
                <div class="panel">
                    <div class="panel-heading">
                        &nbsp;{l s='Products' mod='ntreduction'}
                    </div>
                    <p>
                        <label>{l s='Photo' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_1" id="p_1_on" value="1" {if !in_array('p_1', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_1_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_1" id="p_1_off" value="0" {if in_array('p_1', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_1_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Name' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_2" id="p_2_on" value="1" {if !in_array('p_2', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_2_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_2" id="p_2_off" value="0" {if in_array('p_2', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_2_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Reference' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_3" id="p_3_on" value="1" {if !in_array('p_3', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_3_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_3" id="p_3_off" value="0" {if in_array('p_3', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_3_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_4" id="p_4_on" value="1" {if !in_array('p_4', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_4_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_4" id="p_4_off" value="0" {if in_array('p_4', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_4_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Price (Tax excl.)' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_price_no_tax" id="p_price_no_tax_on" value="1" {if !in_array('p_price_no_tax', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_price_no_tax_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_price_no_tax" id="p_price_no_tax_off" value="0" {if in_array('p_price_no_tax', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_price_no_tax_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Init price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_init_price" id="p_init_price_on" value="1" {if !in_array('p_init_price', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_init_price_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_init_price" id="p_init_price_off" value="0" {if in_array('p_init_price', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_init_price_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Margin after discount' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_margin_after_discount" id="p_margin_after_discount_on" value="1" {if !in_array('p_margin_after_discount', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_margin_after_discount_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_margin_after_discount" id="p_margin_after_discount_off" value="0" {if in_array('p_margin_after_discount', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_margin_after_discount_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Quantity' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_5" id="p_5_on" value="1" {if !in_array('p_5', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_5_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_5" id="p_5_off" value="0" {if in_array('p_5', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_5_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Last reduced price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_6" id="p_6_on" value="1" {if !in_array('p_6', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_6_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_6" id="p_6_off" value="0" {if in_array('p_6', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_6_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Current reduced price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_7" id="p_7_on" value="1" {if !in_array('p_7', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_7_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_7" id="p_7_off" value="0" {if in_array('p_7', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_7_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Next reduced price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p_8" id="p_8_on" value="1" {if !in_array('p_8', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_8_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p_8" id="p_8_off" value="0" {if in_array('p_8', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p_8_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                </div>
                <div class="panel">
                    <div class="panel-heading">
                        &nbsp;{l s='Period 1' mod='ntreduction'}
                    </div>
                    <p>
                        <label>{l s='Start date' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_1" id="p1_1_on" value="1" {if !in_array('p1_1', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_1_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_1" id="p1_1_off" value="0" {if in_array('p1_1', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_1_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='End date' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_2" id="p1_2_on" value="1" {if !in_array('p1_2', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_2_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_2" id="p1_2_off" value="0" {if in_array('p1_2', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_2_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='New price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_3" id="p1_3_on" value="1" {if !in_array('p1_3', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_3_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_3" id="p1_3_off" value="0" {if in_array('p1_3', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_3_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Discount price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_4" id="p1_4_on" value="1" {if !in_array('p1_4', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_4_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_4" id="p1_4_off" value="0" {if in_array('p1_4', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_4_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Discount amount' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_5" id="p1_5_on" value="1" {if !in_array('p1_5', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_5_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_5" id="p1_5_off" value="0" {if in_array('p1_5', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_5_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Discount percentage' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_6" id="p1_6_on" value="1" {if !in_array('p1_6', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_6_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_6" id="p1_6_off" value="0" {if in_array('p1_6', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_6_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Replacement' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_7" id="p1_7_on" value="1" {if !in_array('p1_7', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_7_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_7" id="p1_7_off" value="0" {if in_array('p1_7', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_7_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='On sale' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_8" id="p1_8_on" value="1" {if !in_array('p1_8', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_8_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_8" id="p1_8_off" value="0" {if in_array('p1_8', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_8_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Monday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_10" id="p1_10_on" value="1" {if !in_array('p1_10', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_10_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_10" id="p1_10_off" value="0" {if in_array('p1_10', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_10_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Tuesday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_11" id="p1_11_on" value="1" {if !in_array('p1_11', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_11_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_11" id="p1_11_off" value="0" {if in_array('p1_11', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_11_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Wednesday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_12" id="p1_12_on" value="1" {if !in_array('p1_12', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_12_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_12" id="p1_12_off" value="0" {if in_array('p1_12', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_12_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Thursday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_13" id="p1_13_on" value="1" {if !in_array('p1_13', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_13_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_13" id="p1_13_off" value="0" {if in_array('p1_13', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_13_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Friday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_14" id="p1_14_on" value="1" {if !in_array('p1_14', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_14_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_14" id="p1_14_off" value="0" {if in_array('p1_14', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_14_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Saturday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_15" id="p1_15_on" value="1" {if !in_array('p1_15', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_15_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_15" id="p1_15_off" value="0" {if in_array('p1_15', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_15_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Sunday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_16" id="p1_16_on" value="1" {if !in_array('p1_16', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_16_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_16" id="p1_16_off" value="0" {if in_array('p1_16', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_16_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Delete' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p1_9" id="p1_9_on" value="1" {if !in_array('p1_9', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_9_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p1_9" id="p1_9_off" value="0" {if in_array('p1_9', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p1_9_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                </div>
                <div class="panel">
                    <div class="panel-heading">
                        &nbsp;{l s='Period 2' mod='ntreduction'}
                    </div>
                    <p>
                        <label>{l s='Start date' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_1" id="p2_1_on" value="1" {if !in_array('p2_1', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_1_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_1" id="p2_1_off" value="0" {if in_array('p2_1', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_1_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='End date' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_2" id="p2_2_on" value="1" {if !in_array('p2_2', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_2_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_2" id="p2_2_off" value="0" {if in_array('p2_2', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_2_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='New price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_3" id="p2_3_on" value="1" {if !in_array('p2_3', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_3_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_3" id="p2_3_off" value="0" {if in_array('p2_3', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_3_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Discount price' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_4" id="p2_4_on" value="1" {if !in_array('p2_4', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_4_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_4" id="p2_4_off" value="0" {if in_array('p2_4', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_4_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Discount amount' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_5" id="p2_5_on" value="1" {if !in_array('p2_5', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_5_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_5" id="p2_5_off" value="0" {if in_array('p2_5', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_5_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Discount percentage' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_6" id="p2_6_on" value="1" {if !in_array('p2_6', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_6_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_6" id="p2_6_off" value="0" {if in_array('p2_6', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_6_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Replacement' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_7" id="p2_7_on" value="1" {if !in_array('p2_7', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_7_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_7" id="p2_7_off" value="0" {if in_array('p2_7', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_7_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='On sale' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_8" id="p2_8_on" value="1" {if !in_array('p2_8', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_8_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_8" id="p2_8_off" value="0" {if in_array('p2_8', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_8_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Monday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_10" id="p2_10_on" value="1" {if !in_array('p2_10', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_10_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_10" id="p2_10_off" value="0" {if in_array('p2_10', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_10_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Tuesday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_11" id="p2_11_on" value="1" {if !in_array('p2_11', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_11_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_11" id="p2_11_off" value="0" {if in_array('p2_11', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_11_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Wednesday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_12" id="p2_12_on" value="1" {if !in_array('p2_12', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_12_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_12" id="p2_12_off" value="0" {if in_array('p2_12', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_12_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Thursday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_13" id="p2_13_on" value="1" {if !in_array('p2_13', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_13_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_13" id="p2_13_off" value="0" {if in_array('p2_13', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_13_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Friday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_14" id="p2_14_on" value="1" {if !in_array('p2_14', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_14_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_14" id="p2_14_off" value="0" {if in_array('p2_14', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_14_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Saturday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_15" id="p2_15_on" value="1" {if !in_array('p2_15', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_15_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_15" id="p2_15_off" value="0" {if in_array('p2_15', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_15_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Sunday' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_16" id="p2_16_on" value="1" {if !in_array('p2_16', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_16_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_16" id="p2_16_off" value="0" {if in_array('p2_16', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_16_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                    <p>
                        <label>{l s='Delete' mod='ntreduction'}</label>
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="p2_9" id="p2_9_on" value="1" {if !in_array('p2_9', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_9_on">{l s='Yes' mod='ntreduction'}</label>
                            <input type="radio" name="p2_9" id="p2_9_off" value="0" {if in_array('p2_9', $columns_to_hide)}checked="checked"{/if}/>
                            <label class="t" for="p2_9_off">{l s='No' mod='ntreduction'}</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </p>
                </div>
                <div class="panel">
                    <div class="panel-heading">
                        &nbsp;{l s='Other' mod='ntreduction'}
                    </div>
                    <p>
                        <label>{l s='Display init price on your shop' mod='ntreduction'}</label>
                        {if $ps_version=='1.5'}
                            <span class="alert alert-info hint">
                                {l s='Only for 1.6' mod='ntreduction'}
                            </span>
                        {else}
                            <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="display_init_price" id="display_init_price_on" value="1" {if $display_init_price}checked="checked"{/if}/>
                                <label class="t" for="display_init_price_on">{l s='Yes' mod='ntreduction'}</label>
                                <input type="radio" name="display_init_price" id="display_init_price_off" value="0" {if !$display_init_price}checked="checked"{/if}/>
                                <label class="t" for="display_init_price_off">{l s='No' mod='ntreduction'}</label>
                                <a class="slide-button btn"></a>
                            </span>
                        {/if}
                    </p>
                    <p>
                        <label>{l s='Do not display products. Modification will apply on all the filtered products of the category. This is useful on category with a lots of products.' mod='ntreduction'}</label>
                        {if $ps_version=='1.5'}
                            <span class="alert alert-info hint">
                                {l s='Only for 1.6' mod='ntreduction'}
                            </span>
                        {else}
                            <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="hide_products" id="hide_products_on" value="1" {if $hide_products}checked="checked"{/if}/>
                                <label class="t" for="hide_products_on">{l s='Yes' mod='ntreduction'}</label>
                                <input type="radio" name="hide_products" id="hide_products_off" value="0" {if !$hide_products}checked="checked"{/if}/>
                                <label class="t" for="hide_products_off">{l s='No' mod='ntreduction'}</label>
                                <a class="slide-button btn"></a>
                            </span>
                        {/if}
                    </p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </form>
    <div class="panel-footer">
        <button id="ntreduction_columns_config_save" class="btn btn-default pull-right">
            <i class="far fa-save process_icon"></i> {l s='Save' mod='ntreduction'}
        </button>
    </div>
</div>
