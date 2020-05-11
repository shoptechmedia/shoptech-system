<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_3($object)
{

			Configuration::updateValue('thmedit_alertsuccess_bg', '#55c65e');
			Configuration::updateValue('thmedit_alertsuccess_txt', '#ffffff');
			Configuration::updateValue('thmedit_alertinfo_bg', '#5192f3');
			Configuration::updateValue('thmedit_alertinfo_txt', '#ffffff');
			Configuration::updateValue('thmedit_alertwarning_bg', '#fe9126');
			Configuration::updateValue('thmedit_alertwarning_txt', '#ffffff');
			Configuration::updateValue('thmedit_alertdanger_bg', '#f3515c');
			Configuration::updateValue('thmedit_alertdanger_txt', '#ffffff');
			Configuration::updateValue('thmedit_footer1_status', 0);
			Configuration::updateValue('thmedit_footer1_bg_color', '#f8f8f8');
			Configuration::updateValue('thmedit_footer1_bg_type', 2);
			Configuration::updateValue('thmedit_footer1_bg_image', '');
			Configuration::updateValue('thmedit_footer1_bg_pattern', 0);
			Configuration::updateValue('thmedit_footer1_bg_repeat', 0);
			Configuration::updateValue('thmedit_footer1_bg_position', 0);
			Configuration::updateValue('thmedit_footer1_inner_border', 1);
			Configuration::updateValue('thmedit_footer1_inner_border_color', '#dddddd');
			Configuration::updateValue('thmedit_footer1_border', 1);
			Configuration::updateValue('thmedit_footer1_border_color', '#dddddd');
			Configuration::updateValue('thmedit_footer1_txt_color', '#777777');
			Configuration::updateValue('thmedit_footer1_link_color', '#777777');
			Configuration::updateValue('thmedit_footer1_link_h_color', '#333333');
			Configuration::updateValue('thmedit_footer1_headings_color', '#555454');
			Configuration::updateValue('thmedit_footer1_bgh', '#F3F3F3');
			Configuration::updateValue('thmedit_product_colors', 0);
			Configuration::updateValue('thmedit_absolute_header_padding', 0);
			Configuration::updateValue('thmedit_header_absolute', 0);
			Configuration::updateValue('thmedit_header_absolute_bg', 'transparent');
			Configuration::updateValue('thmedit_header_absolute_w_bg', 'rgba(0, 0, 0, 0.4)');

	return true;
}
