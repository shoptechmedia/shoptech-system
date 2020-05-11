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

function upgrade_module_3_6_0()
{
	Configuration::updateValue('prestablog_blocsearch_actif', 0);
	Configuration::updateValue('prestablog_nb_list_linkprod', 5);

	$sort_bloc_left = unserialize(Configuration::get('prestablog_sbl'));
	$sort_bloc_left[] = 'blocSearch';
	$sort_bloc_left = serialize($sort_bloc_left);
	Configuration::updateValue('prestablog_sbl', $sort_bloc_left, false, null, (int)Tools::getValue('id_shop'));
	Configuration::updateValue('prestablog_sbl', $sort_bloc_left);

	Tools::clearCache();

	return true;
}
