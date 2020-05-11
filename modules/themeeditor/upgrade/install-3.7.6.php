<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_7_6($object)
{	
	Configuration::updateValue('thmedit_content_input_border', '1;1;#d6d4d4');
	return true;
}
