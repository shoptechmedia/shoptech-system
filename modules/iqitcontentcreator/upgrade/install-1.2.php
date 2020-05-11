<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2($object)
{

	$content = Configuration::get($object->config_name.'_content');

	$tests = json_decode($content, true);

	foreach ($tests as $key => $test) {
			if (isset($test['contentType']) && ($test['contentType'] == 2 | $test['contentType'] == 4)){
				if (!isset($test['content']['itype']))
					$tests[$key]['content']['itype'] = 0;
				

			
				}	
		}

	Configuration::updateValue($object->config_name.'_content', json_encode($tests));

	return true;
}
