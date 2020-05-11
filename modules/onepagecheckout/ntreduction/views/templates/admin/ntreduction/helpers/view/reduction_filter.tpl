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

<div class="panel">
    <div class="panel-heading">
        &nbsp;{l s='Filter' mod='ntreduction'}
    </div>
    <form id="ntreduction_config" method='post' action='#'>
        <div id="filter_columns">
            <div class="panel" id="categories">
                <div class="panel-heading">
                    &nbsp;{l s='Categories' mod='ntreduction'}
                </div>
                {$category_tree}
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <i class="fas fa-archive"></i>
                    &nbsp;{l s='Display' mod='ntreduction'}
                </div>
                <div>
                    <p id="customer_group">
                        <label for="reduction_group">{l s='Customer groups' mod='ntreduction'}</label>
                        <select name="reduction_group" id="reduction_group">
                            <option value="0">{l s='All groups' mod='ntreduction'}</option>
                            {foreach from=$groups item=group}
                                <option value="{$group.id_group|intval}">{$group.name|escape:'html':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </p>
                    <p id="currency">
                        <label for="reduction_currency">{l s='Currencies' mod='ntreduction'}</label>
                        <select name="reduction_currency" id="reduction_currency">
                            <option value="0">{l s='All currencies' mod='ntreduction'}</option>
                            {foreach from=$currencies item=curr}
                                <option value="{$curr.id_currency|intval}">{$curr.name|escape:'html':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </p>
                    <p id="countries">
                        <label for="reduction_country">{l s='Countries' mod='ntreduction'}</label>
                        <select name="reduction_country" id="reduction_country">
                            <option value="0">{l s='All countries' mod='ntreduction'}</option>
                            {foreach from=$countries item=country}
                                <option value="{$country.id_country|intval}">{$country.name|escape:'html':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </p>
                    <p id="displayed_products">
                        <label for="active">{l s='Displayed products' mod='ntreduction'}</label>
                        <select name="active" id="active">
                            <option value="1">{l s='Active: Yes' mod='ntreduction'}</option>
                            <option value="0">{l s='Active: No' mod='ntreduction'}</option>
                            <option value="2">{l s='Active: All' mod='ntreduction'}</option>
                        </select>
                        <select name="discounted" id="discounted">
                            <option value="2">{l s='With discount: All' mod='ntreduction'}</option>
                            <option value="1">{l s='With discount: Yes' mod='ntreduction'}</option>
                            <option value="0">{l s='With discount: No' mod='ntreduction'}</option>
                        </select>
                    </p>
                    <p id="suppliers_filter">
                        <label for="filter_supplier">{l s='Filter by supplier' mod='ntreduction'}</label>
                        <select name="filter_supplier[]" id="filter_supplier" multiple="multiple">
                            {*<option value="0">{l s='All supplier' mod='ntreduction'}</option>*}
                            {foreach from=$suppliers item=supplier}
                                <option value="{$supplier.id_supplier|intval}">{$supplier.name|escape:'html':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </p>
                    <p id="manufacturers_filter">
                        <label for="filter_manufacturer">{l s='Filter by manufacturer' mod='ntreduction'}</label>
                        <select name="filter_manufacturer[]" id="filter_manufacturer" multiple="multiple">
                            {*<option value="0">{l s='All manufacturer' mod='ntreduction'}</option>*}
                            {foreach from=$manufacturers item=manufacturer}
                                <option value="{$manufacturer.id_manufacturer|intval}">{$manufacturer.name|escape:'html':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </p>
                </div>
            </div>

            <div class="panel" id="priorities_list">
                <div class="panel-heading">
                    &nbsp;{l s='Priorities' mod='ntreduction'}
                </div>
                <div>
                    <select name="specificPricePriority[]">
                        <option value="id_shop" {if $specific_price_priorities.0 == 'id_shop'}selected="selected"{/if}>{l s='Shop' mod='ntreduction'}</option>
                        <option value="id_currency" {if $specific_price_priorities.0 == 'id_currency'}selected="selected"{/if}>{l s='Currency' mod='ntreduction'}</option>
                        <option value="id_country" {if $specific_price_priorities.0 == 'id_country'}selected="selected"{/if}>{l s='Country' mod='ntreduction'}</option>
                        <option value="id_group" {if $specific_price_priorities.0 == 'id_group'}selected="selected"{/if}>{l s='Group' mod='ntreduction'}</option>
                    </select>
                    &gt;
                    <select name="specificPricePriority[]">
                        <option value="id_shop" {if $specific_price_priorities.1 == 'id_shop'}selected="selected"{/if}>{l s='Shop' mod='ntreduction'}</option>
                        <option value="id_currency" {if $specific_price_priorities.1 == 'id_currency'}selected="selected"{/if}>{l s='Currency' mod='ntreduction'}</option>
                        <option value="id_country" {if $specific_price_priorities.1 == 'id_country'}selected="selected"{/if}>{l s='Country' mod='ntreduction'}</option>
                        <option value="id_group" {if $specific_price_priorities.1 == 'id_group'}selected="selected"{/if}>{l s='Group' mod='ntreduction'}</option>
                    </select>
                    &gt;
                    <select name="specificPricePriority[]">
                        <option value="id_shop" {if $specific_price_priorities.2 == 'id_shop'}selected="selected"{/if}>{l s='Shop' mod='ntreduction'}</option>
                        <option value="id_currency" {if $specific_price_priorities.2 == 'id_currency'}selected="selected"{/if}>{l s='Currency' mod='ntreduction'}</option>
                        <option value="id_country" {if $specific_price_priorities.2 == 'id_country'}selected="selected"{/if}>{l s='Country' mod='ntreduction'}</option>
                        <option value="id_group" {if $specific_price_priorities.2 == 'id_group'}selected="selected"{/if}>{l s='Group' mod='ntreduction'}</option>
                    </select>
                    &gt;
                    <select name="specificPricePriority[]">
                        <option value="id_shop" {if $specific_price_priorities.3 == 'id_shop'}selected="selected"{/if}>{l s='Shop' mod='ntreduction'}</option>
                        <option value="id_currency" {if $specific_price_priorities.3 == 'id_currency'}selected="selected"{/if}>{l s='Currency' mod='ntreduction'}</option>
                        <option value="id_country" {if $specific_price_priorities.3 == 'id_country'}selected="selected"{/if}{l s='Country' mod='ntreduction'}></option>
                        <option value="id_group" {if $specific_price_priorities.3 == 'id_group'}selected="selected"{/if}>{l s='Group' mod='ntreduction'}</option>
                    </select>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    &nbsp;{l s='Search' mod='ntreduction'}
                </div>
                <div id="product_search">
                    <p>
                        <input type="text" id="nt_reduction_search" name="nt_reduction_search" placeholder="{l s='Enter your search' mod='ntreduction'}" value=""/>
                    </p>
                </div>
            </div>
        </div>
    </form>
    <div class="panel-footer">
        <button id="nt_reduction_search_submit" class="btn btn-default pull-right">
            <i class="fas fa-search process_icon"></i> {l s='Filter' mod='ntreduction'}
        </button>
    </div>
</div>