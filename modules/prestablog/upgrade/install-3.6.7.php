<?php
/**
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 
 */

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_6_7()
{
	if (!Configuration::get('prestablog_thumb_linkprod_width'))
		Configuration::updateValue('prestablog_thumb_linkprod_width', 100);

	$languages = Language::getLanguages(true);

	$meta_title_config_lang = array();
	$meta_description_config_lang = array();
	$title_h1_config_lang = array();

	foreach ($languages as $language)
	{
		$meta_title_config_lang[(int)$language['id_lang']] = 'Blog';
		if (Configuration::get('prestablog_titlepageblog_'.(int)$language['id_lang']))
			$meta_title_config_lang[(int)$language['id_lang']] = Configuration::get('prestablog_titlepageblog_'.(int)$language['id_lang']);

		$meta_description_config_lang[(int)$language['id_lang']] = 'Blog';

		if (Configuration::get('prestablog_descpageblog_'.(int)$language['id_lang']))
			$meta_description_config_lang[(int)$language['id_lang']] = Configuration::get('prestablog_descpageblog_'.(int)$language['id_lang']);

		$title_h1_config_lang[(int)$language['id_lang']] = '';
		if (Configuration::get('prestablog_h1pageblog_'.(int)$language['id_lang']))
			$title_h1_config_lang[(int)$language['id_lang']] = Configuration::get('prestablog_h1pageblog_'.(int)$language['id_lang']);
	}

	Configuration::updateValue('prestablog_titlepageblog', $meta_title_config_lang);
	Configuration::updateValue('prestablog_descpageblog', $meta_description_config_lang);
	Configuration::updateValue('prestablog_h1pageblog', $title_h1_config_lang);

	Tools::clearCache();

	return true;
}
