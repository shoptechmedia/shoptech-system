<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2_1($object)
{	
	Configuration::updateValue('iqitctcr_auto_cache', true);

	return true;
}
