<?php

include(__DIR__ . '/../../config/config.inc.php');

include(__DIR__ . '/customcombinations.php');

$id_product = Tools::getValue('id_product');

if(Tools::isSubmit('action')){
	function saveOptions($id_dropdown, $id_main_group, $options){
		$prefix = _DB_PREFIX_;
		Db::getInstance()->delete(
			'product_dropdown_value',

			'id_dropdown=' . $id_dropdown
		);

		foreach ($options as $value) {
			Db::getInstance()->insert(
				'product_dropdown_value',

				[
					'id_main_group' => $id_main_group,
					'id_dropdown' => $id_dropdown,
					'value' => $value
				]
			);
		}
	}

	switch (Tools::getValue('action')) {

		case 'Dropdown-New':

			$new_options = explode("\n", Tools::getValue('dropdown_options'));
			$languages = Language::getLanguages(false);
			$id_dropdown = 0;

			foreach ($languages as $language) {
				$id_lang = $language['id_lang'];

				$dropdown_label = Tools::getValue('dropdown_label_' . $id_lang);
				$dropdown_name = Tools::getValue('dropdown_name_' . $id_lang);

				$fields = [
					'id_product' => $id_product,
					'id_lang' => $id_lang,
					'label' => $dropdown_label,
					'name' => $dropdown_name,
				];

				if($id_dropdown){
					$fields['id_dropdown'] = $id_dropdown;
				}

				Db::getInstance()->insert('product_dropdown', $fields);

				if(!$id_dropdown){
					$id_dropdown = Db::getInstance()->Insert_ID();
				}
			}

			if($id_dropdown){
				saveOptions($id_dropdown, $id_product, $new_options);
			}

		break;

		case 'Dropdown-Edit':

			$new_options = explode("\n", Tools::getValue('dropdown_options'));
			$languages = Language::getLanguages(false);
			$id_dropdown = Tools::getValue('id_dropdown');

			saveOptions($id_dropdown, $id_product, $new_options);

			foreach ($languages as $language) {
				$id_lang = $language['id_lang'];

				$dropdown_label = Tools::getValue('dropdown_label_' . $id_lang);
				$dropdown_name = Tools::getValue('dropdown_name_' . $id_lang);

				$fields = [
					'label' => $dropdown_label,
					'name' => $dropdown_name
				];

				Db::getInstance()->update(
					'product_dropdown',

					$fields,

					'id_product=' . $id_product . ' AND id_dropdown=' . $id_dropdown . ' AND id_lang=' . $id_lang
				);
			}

		break;

		case 'GroupProduct-New':

			$id_main_group = $id_product;
			$id_sub_product = (int) Tools::getValue('id_sub_product');
			$id_combination = (int) Tools::getValue('id_value');
			$visibility = Tools::getValue('visibility');

			$product = new Product($id_sub_product);
			$product->visibility = $visibility;

			Db::getInstance()->update(
				'product_group',

				[
					'id_sub_product' => $id_sub_product
				],

				'id_combination=' . $id_combination
			);

			$product->update();

			echo Tools::jsonEncode($product->name);

		break;

		case 'GroupProduct-Delete':

			$id_combination = (int) Tools::getValue('id_value');

			Db::getInstance()->update(
				'product_group',

				[
					'id_sub_product' => 0
				],

				'id_combination=' . $id_combination
			);

			echo $id_combination;

		break;

		case 'Dropdown-Add-Product':

			$id_dropdown = (int) Tools::getValue('id_dropdown');
			$id_lang = (int) Tools::getValue('id_lang');

			Db::getInstance()->insert(
				'product_dropdown',

				[
					'id_dropdown' => $id_dropdown,
					'id_product' => $id_product,
					'id_lang' => $id_lang
				]
			);

		break;

		case 'Dropdown-Delete-Product':

			$id_dropdown = (int) Tools::getValue('id_dropdown');
			$id_lang = (int) Tools::getValue('id_lang');

			Db::getInstance()->delete(
				'product_dropdown',
				"id_dropdown = '{$id_dropdown}' AND id_product = '{$id_product}'"
			);

		break;

	}

}