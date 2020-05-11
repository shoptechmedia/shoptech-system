<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_1($object)
{	

	Configuration::updateValue('iqitfdc_bg_color' , '#F2F2F2');
	Configuration::updateValue('iqitfdc_txt_color' ,'#777777');
	Configuration::updateValue('iqitfdc_timer_bg_color' , '#151515');
	Configuration::updateValue('iqitfdc_timer_bg_text', '#ffffff');
	Configuration::updateValue('iqitfdc_show_hover', '#ffffff');

	

	return true;
}
