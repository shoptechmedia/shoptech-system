<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2($object)
{


	Configuration::updateValue('additionalproductstabs_status', 0);
	

	return true;
}
