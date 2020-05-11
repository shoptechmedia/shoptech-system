<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_3_6($object)
{
	Configuration::updateValue('thmedit_product_h_border_color', '1;0;#EBEBEB');
	Configuration::updateValue('thmedit_headerw_border_color', '1;0;#d6d4d4');
	Configuration::updateValue('thmedit_retina_logo', '');
	Configuration::updateValue('thmedit_cart_style', 0);
	Configuration::updateValue('thmedit_content_tab_style', 0);
	Configuration::updateValue('thmedit_show_qty_field', 0);
	Configuration::updateValue('thmedit_accesories_position', 0);
	Configuration::updateValue('thmedit_product_tabs', 1);
	Configuration::updateValue('thmedit_font_headings_namec', '\'Open Sans\', sans-serif');
	Configuration::updateValue('thmedit_font_txt_namec', '\'Open Sans\', sans-serif');
	Configuration::updateValue('thmedit_header_style', 0);
	Configuration::updateValue('thmedit_custom_font_include', '');
	Configuration::updateValue('thmedit_carousel_dots', 0);
	Configuration::updateValue('thmedit_carousel_auto', 0);
	Configuration::updateValue('thmedit_carousel_load', 1);
	Configuration::updateValue('thmedit_dot_color', '#B0B0B0');
	Configuration::updateValue('thmedit_dot_a_color', '#333333');
	Configuration::updateValue('thmedit_product_box_status', 0);
	Configuration::updateValue('thmedit_product_price_length', 0);
	Configuration::updateValue('thmedit_product_box_bg', 'transparent');
	Configuration::updateValue('thmedit_product_box_txt', '#777777');
	Configuration::updateValue('thmedit_product_box_txt_h', '#333333');
	Configuration::updateValue('thmedit_product_box_price', '#f13340');
	Configuration::updateValue('thmedit_product_box_rating', '#f13340');
	Configuration::updateValue('thmedit_product_box_h_rating', '#f13340');
	Configuration::updateValue('thmedit_show_catimage', 1);
	Configuration::updateValue('thmedit_subcats_grid_size_md', 2);
	Configuration::updateValue('thmedit_subcats_grid_size_sm', 15);
	Configuration::updateValue('thmedit_subcats_grid_size_xs', 3);

	return true;
}
