<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2($object)
{

	Configuration::updateValue('customcontactpage_show', 1);

	return true;
}
