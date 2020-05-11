<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_8($object)
{	
	$module = Module::getInstanceByName('dashiqitnews');
	  if ($module instanceof Module) {

          $module->install();
    }
    
	return true;


}
