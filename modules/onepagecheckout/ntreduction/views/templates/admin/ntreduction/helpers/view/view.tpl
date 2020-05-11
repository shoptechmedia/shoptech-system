{*
* 2013-2014 2N Technologies
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
* @copyright 2013-2014 2N Technologies
* @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*}

{if $error_context_group}
    <div class="error alert alert-danger">
        {l s='Products cannot be updated in shop group context' mod='ntreduction'}
    </div>
{else}
<script type="text/javascript">
    var admin_link_ntr              = "{$link->getAdminLink('AdminNtreduction')|escape:'javascript':'UTF-8'}";
	var currencySign                = "{$currencySign|escape:'html':'UTF-8'}";
	var current_text                = "{l s='Now' mod='ntreduction'}";
	var close_text                  = "{l s='Done' mod='ntreduction'}";
	var time_only_title             = "{l s='Choose Time' mod='ntreduction'}";
	var time_text                   = "{l s='Time' mod='ntreduction'}";
	var hour_text                   = "{l s='Hour' mod='ntreduction'}";
	var minute_text                 = "{l s='Minute' mod='ntreduction'}";
	var delete_warning              = "{l s='Do you really want to delete all check reductions ?' mod='ntreduction'}";
	var date_warning                = "{l s='Do you really want save reductions without dates ?' mod='ntreduction'}";
	var double_discount_warning     = "{l s='You must choose between new price, discount price, reduction amount and percentage reduction' mod='ntreduction'}";
	var warning_combination         = "{l s='Be careful : A specific price is already applied on a combination of this product' mod='ntreduction'}";
	var warning_from_quantity       = "{l s='Be careful : A specific price is already applied for a quantity greater than 1' mod='ntreduction'}";
	var warning_currency            = "{l s='Be careful : A specific price is already applied for a specific currency' mod='ntreduction'}";
	var warning_catalog_rule        = "{l s='Be careful : A specific price is already applied by a catalog price rule' mod='ntreduction'}";
	var hide_columns_error          = "{l s='An error occur during the config of the columns. Please try again.' mod='ntreduction'}";
	var cron_config_error           = "{l s='An error occur during the configuration of the CRON. Please try again.' mod='ntreduction'}";
	var export_error                = "{l s='An error occur during the export of your reductions. Please try again.' mod='ntreduction'}";
    var confirm_save_reduction      = "{l s='Do you want to save your reductions?' mod='ntreduction'}";
    var placeholder_supplier        = "{l s='Click to select suppliers' mod='ntreduction'}";
    var placeholder_manufacturer    = "{l s='Click to select manufacturers' mod='ntreduction'}";
	var id_cat_root                 = "{$id_cat_root|intval}";
	var ajax_products_max           = {$ajax_products_max|intval};
	var hide_products               = {$hide_products|intval};
	var id_employee                 = {$id_employee|intval};
	var columns_to_hide             = new Array();

	{foreach from=$columns_to_hide item=columns}
		columns_to_hide.push("{$columns|escape:'html':'UTF-8'}");
	{/foreach}
</script>
{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
<div id="ntreduction">
    {if $multi_shop}
        <div class="alert alert-warning warn">
            {l s='Be carefull, you are in multishop context !' mod='ntreduction'}
        </div>
    {/if}
    <div id="result">
        <div class="error alert alert-danger"></div>
        <div class="confirm alert alert-success"><p>{l s='Your datas are saved' mod='ntreduction'}</p></div>
    </div>
	<div class="clear"></div>
    <div class="sidebar navigation col-md-2">
		<nav id="nt_tab" class="list-group">
			<a id="nt_tab1" class="list-group-item active"><i class="fas fa-barcode"></i></i>&nbsp;{l s='Reduction' mod='ntreduction'}</a>
			<a id="nt_tab2" class="list-group-item"><i class="far fa-clock"></i>&nbsp;{l s='Cron' mod='ntreduction'}</a>
			<a id="nt_tab3" class="list-group-item"><i class="fas fa-cogs"></i>&nbsp;{l s='Configuration' mod='ntreduction'}</a>
			<a id="nt_tab4" class="list-group-item"><i class="fas fa-book"></i>&nbsp;{l s='Documentation' mod='ntreduction'}</a>
			<a id="nt_tab5" class="list-group-item"><i class="fas fa-envelope"></i>&nbsp;{l s='Contact' mod='ntreduction'}</a>
            {if $display_translate_tab}
			<a id="nt_tab6" class="list-group-item"><i class="fas fa-globe"></i>&nbsp;Help us translate into your language</a>
            {/if}
		</nav>
		<nav class="list-group">
            <a id="nt_request" class="list-group-item" href="{$link_contact|escape:'html':'UTF-8'}" target="_blank">
                <i class="far fa-lightbulb"></i>&nbsp;{l s='Request feature' mod='ntreduction'}
            </a>
			<a id="nt_version" class="list-group-item">
                <i class="fas fa-info"></i>&nbsp;{l s='Version' mod='ntreduction'} {$version|escape:'html':'UTF-8'}
            </a>
		</nav>
	</div>
    <div>
		<div id="nt_tab2_content" class="panel tab col-md-10">
			{include file="./cron.tpl"}
		</div>
		<div id="nt_tab3_content" class="panel tab col-md-10">
			{include file="./configuration.tpl"}
		</div>
		<div id="nt_tab4_content" class="panel tab col-md-10">
			{include file="./documentation.tpl"}
		</div>
		<div id="nt_tab5_content" class="panel tab col-md-10">
			{include file="./contact.tpl"}
		</div>
		<div id="nt_tab6_content" class="panel tab col-md-10">
			{include file="./translate.tpl"}
		</div>
		<div id="nt_tab1_content" class="tab col-md-10">
			{include file="./reduction_filter.tpl"}
		</div>
		<div class="clear"></div>
	</div>
    <div>
        <button id="ntreduction_export" class="btn btn-default pull-left">
            <i class="fas fa-download process_icon"></i> {l s='Export' mod='ntreduction'}
        </button>
        <div class="clear"></div>
    </div>
    <div>
        {include file="./reduction.tpl"}
    </div>
    <div class="clear"></div>
    <div id="loader_container">
        <div id="grey_background"></div>
        <img id="loader" src="{$ajax_loader|escape:'html':'UTF-8'}"/>
    </div>
</div>
{/if}