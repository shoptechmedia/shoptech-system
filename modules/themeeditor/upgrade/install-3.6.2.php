<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_6_2($object)
{	
	Configuration::updateValue('thmedit_content_block_bg', 'transparent');
	Configuration::updateValue('thmedit_content_element_bg', 'transparent');
	Configuration::updateValue('thmedit_content_element_border_c', '0;0;#d6d4d4');
	return true;
}
