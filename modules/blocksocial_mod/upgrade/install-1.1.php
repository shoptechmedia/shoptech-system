<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_1($object)
{
	$object->registerHook('displayNav');
	Configuration::updateValue('bsmod_hook', 0);

	return true;
}
