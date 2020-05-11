<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_7($object)
{	
	Configuration::updateValue('thmedit_footer_ul_arrows', 1);
	Configuration::updateValue('thmedit_header_width', 1);
	Configuration::updateValue('columnadverts_slider', 0);

	Configuration::updateValue('thmedit_icon_size', 14);
	Configuration::updateValue('thmedit_thumbs_position', 0);


	Configuration::updateValue('thmedit_mh_btn_border' , '1;1;#d6d4d4');
	Configuration::updateValue('thmedit_mh_dd_input_border' ,'1;1;#d6d4d4');
	Configuration::updateValue('thmedit_mh_bg' ,'#ffffff');
	Configuration::updateValue('thmedit_mh_logo_bg' ,'#ffffff');
	Configuration::updateValue('thmedit_mh_icon_color', '#777777');
	Configuration::updateValue('thmedit_mh_icon_a_color' ,'#333');
	Configuration::updateValue('thmedit_mh_btn_a_bg' , '#F6F6F6');
	Configuration::updateValue('thmedit_mh_dd_bg' ,'#ffffff');
	Configuration::updateValue('thmedit_mh_dd_txt', '#777777');
	Configuration::updateValue('thmedit_mh_dd_input_bg','#ffffff');
	Configuration::updateValue('thmedit_mh_dd_input_txt' , '#777777');
	Configuration::updateValue('thmedit_mobile_header_style' , 0);
	Configuration::updateValue('thmedit_mobile_header_sticky' , 1);
	Configuration::updateValue('thmedit_mobile_header_search' , 0);

	return true;
}
