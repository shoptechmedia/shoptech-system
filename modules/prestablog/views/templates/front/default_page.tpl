{*
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 
 *}

<!-- Module Presta Blog START PAGE -->

{capture name=path}<a href="{PrestaBlogUrl}" >{l s='Blog' mod='prestablog'}</a>{if $SecteurName}{PrestaBlogContent return=$SecteurName}{/if}{/capture}

{if isset($tpl_filtre_cat) && $tpl_filtre_cat}{PrestaBlogContent return=$tpl_filtre_cat}{/if}
{if isset($tpl_menu_cat) && $tpl_menu_cat}{PrestaBlogContent return=$tpl_menu_cat}{/if}

{if isset($tpl_unique) && $tpl_unique}{PrestaBlogContent return=$tpl_unique}{/if}
{if isset($tpl_comment) && $tpl_comment}{PrestaBlogContent return=$tpl_comment}{/if}
{if isset($tpl_comment_fb) && $tpl_comment_fb}{PrestaBlogContent return=$tpl_comment_fb}{/if}

{if isset($tpl_slide) && $tpl_slide}{PrestaBlogContent return=$tpl_slide}{/if}
{if isset($tpl_cat) && $tpl_cat}{PrestaBlogContent return=$tpl_cat}{/if}
{if isset($tpl_all) && $tpl_all}{PrestaBlogContent return=$tpl_all}{/if}

<!-- /Module Presta Blog END PAGE -->
