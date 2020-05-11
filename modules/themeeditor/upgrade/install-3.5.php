<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_5($object)
{


	Configuration::updateValue('thmedit_grid_size_xs', 1);
	Configuration::updateValue('thmedit_header_txt_color', Configuration::get('thmedit_header_link_color'));

	Configuration::updateValue('thmedit_btn_small_border', '1;0;#d6d4d4');
	Configuration::updateValue('thmedit_btn_medium_border', '1;0;#d6d4d4');
	Configuration::updateValue('thmedit_btn_cart_border', '1;0;#d6d4d4');
	Configuration::updateValue('thmedit_btn_cartp_border', '1;0;#d6d4d4');
	Configuration::updateValue('thmedit_top_bordert_color', '1;0;#d6d4d4');

	Configuration::updateValue('thmedit_breadcrumb_border', '1;0;#d6d4d4');

	Configuration::updateValue('thmedit_product_border_color', '1;1;'.Configuration::get('thmedit_product_border_color'));
	Configuration::updateValue('thmedit_cart_box_border', '1;1;'.Configuration::get('thmedit_cart_box_border'));

	Configuration::updateValue('thmedit_content_headings_border', '1;1;'.Configuration::get('thmedit_content_inner_border_color'));

	Configuration::updateValue('thmedit_footer1_border_title', '1;1;'.Configuration::get('thmedit_footer1_inner_border_color'));
	Configuration::updateValue('thmedit_footer_border_title', '1;1;'.Configuration::get('thmedit_footer_inner_border_color'));


	if(Configuration::get('thmedit_top_border'))
		Configuration::updateValue('thmedit_top_border_color', '1;1;'.Configuration::get('thmedit_top_border_color'));
	else
		Configuration::updateValue('thmedit_top_border_color', '1;0;'.Configuration::get('thmedit_top_border_color'));


	if(Configuration::get('thmedit_header_inner_border'))
		Configuration::updateValue('thmedit_header_inner_border_color', '1;1;'.Configuration::get('thmedit_header_inner_border_color'));
	else
		Configuration::updateValue('thmedit_header_inner_border_color', '1;0;'.Configuration::get('thmedit_header_inner_border_color'));

	if(Configuration::get('thmedit_content_block_border'))
		Configuration::updateValue('thmedit_content_block_border_c', '1;1;'.Configuration::get('thmedit_content_block_border_c'));
	else
		Configuration::updateValue('thmedit_content_block_border_c', '1;0;'.Configuration::get('thmedit_content_block_border_c'));


	if(Configuration::get('thmedit_footer1_inner_border'))
		Configuration::updateValue('thmedit_footer1_inner_border_color', '1;1;'.Configuration::get('thmedit_footer1_inner_border_color'));
	else
		Configuration::updateValue('thmedit_footer1_inner_border_color', '1;0;'.Configuration::get('thmedit_footer1_inner_border_color'));

	if(Configuration::get('thmedit_footer_inner_border'))
		Configuration::updateValue('thmedit_footer_inner_border_color', '1;1;'.Configuration::get('thmedit_footer_inner_border_color'));
	else
		Configuration::updateValue('thmedit_footer_inner_border_color', '1;0;'.Configuration::get('thmedit_footer_inner_border_color'));


	if(Configuration::get('thmedit_footer1_border'))
		Configuration::updateValue('thmedit_footer1_border_color', '1;1;'.Configuration::get('thmedit_footer1_border_color'));
	else
		Configuration::updateValue('thmedit_footer1_border_color', '1;0;'.Configuration::get('thmedit_footer1_border_color'));

	if(Configuration::get('thmedit_footer_border'))
	{
			Configuration::updateValue('thmedit_footer_border_color', '1;1;'.Configuration::get('thmedit_footer_border_color'));
			Configuration::updateValue('thmedit_footer_bordert_color', '1;1;'.Configuration::get('thmedit_footer_bordert_color'));
	}
		
	else
		{
			Configuration::updateValue('thmedit_footer_border_color', '1;0;'.Configuration::get('thmedit_footer_border_color'));
			Configuration::updateValue('thmedit_footer_bordert_color', '1;0;'.Configuration::get('thmedit_footer_bordert_color'));
	}

			
	
	$object->generateCss();

	return true;
}
