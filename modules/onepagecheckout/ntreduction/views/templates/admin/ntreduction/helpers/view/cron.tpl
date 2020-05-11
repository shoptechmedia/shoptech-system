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
    <i class="far fa-clock"></i>
    &nbsp;{l s='Cron' mod='ntreduction'}
</div>
<div>
    <div class="panel">
        <p>
            {l s='To automaticaly update the "On sale" value of your products and activate/deactivate recurring discount, you must execute the following page every minute in CRON:' mod='ntreduction'}
        </p>
        <p>
            <a target="_blank" href="{$cron|escape:'html':'UTF-8'}">{$cron|escape:'html':'UTF-8'}</a>
        </p>
    </div>
    <p class="alert alert-warning warn">
        {l s='Warning: If you changed the "On sale" value in your product page, it will be changed back to its default value.' mod='ntreduction'}
    </p>
    <div class="panel">
        <form id="ntreduction_cron_config" method='post' action='#'>
            {if $multi_shop}
                <p class="alert alert-warning warn">
                    {l s='Warning: If you change the "No CRON" value while in multishop "All shops", it will change the value on all your shops.' mod='ntreduction'}
                </p>
            {/if}
            <p>{l s='If you cannot create a CRON, you can choose the "No CRON" option but your visitors may encounters a small delay while visiting your website.' mod='ntreduction'}</p>
            <p>{l s='If you can create a CRON, you should not choose the No CRON option. You will find more details in documentation.' mod='ntreduction'}</p>
            <p>
                <input type="checkbox" name="no_cron" id="no_cron" {if $nocron}checked="checked"{/if}/>
                <label for="no_cron">{l s='No CRON' mod='ntreduction'}</label>
            </p>
        </form>
    </div>
    <div class="panel-footer">
        <button id="ntreduction_cron_config_save" class="btn btn-default pull-right">
            <i class="far fa-save process_icon"></i> {l s='Save' mod='ntreduction'}
        </button>
    </div>
</div>