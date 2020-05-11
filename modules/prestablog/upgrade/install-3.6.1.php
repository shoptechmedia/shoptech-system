<?php
/**
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 
 */

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_6_1($module)
{
	if (!Configuration::get('prestablog_nb_list_linkprod'))
		Configuration::updateValue('prestablog_nb_list_linkprod', 5);

	$id_tab = Tab::getIdFromClassName('AdminPrestaBlogAjax');
	if (empty ($id_tab))
		$module->registerAdminTab();

	Tools::clearCache();

	return true;
}
