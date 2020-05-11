<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_0_3($object)
{	
	Configuration::updateValue('IQITSIZEGUIDE_sh_measure', 1);
	Configuration::updateValue('IQITSIZEGUIDE_sh_global', 0);
	$object->registerHook('actionAdminProductsControllerSaveAfter');
	return true;
}
