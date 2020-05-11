<?php
/**
 * 2010-2018 Bl Modules.
 *
 * If you wish to customize this module for your needs,
 * please contact the authors first for more information.
 *
 * It's not allowed selling, reselling or other ways to share
 * this file or any other module files without author permission.
 *
 * @author    Bl Modules
 * @copyright 2010-2018 Bl Modules
 * @license
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductListAdmin extends Xmlfeeds
{
    protected $imageClassName = 'ImageCore';

    public function getContent($full_address_no_t = '', $token = '')
    {
        $productList = $this->getProductList();
        $productListId = Tools::getValue('product_list_id');
        $this->imageClassName = (!class_exists('ImageCore', false) || _PS_VERSION_ > '1.5.3') ?  'Image' : 'ImageCore';

        $html = '
			<div id="content" class="bootstrap content_blmod">
                <div class="bootstrap">
                    <div class="panel">
                        <div class="panel-heading">
                            <i class="icon-cog"></i> '.$this->l('Product list').'
                        </div>
                        <div class="row">
                            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                                <input style="width: 300px;" type="text" name="product_list_name" placeholder="'.$this->l('Product list name').'" />
                                <input style="" type="submit" name="add_product_list" value="'.$this->l('Add new').'" class="button">
                                <div class="cb"><br></div>
                                <hr>
                                <select id="product_list_menu" style="width: 300px; float: left;" name="product_list_id">
                                    <option value="0" disabled'.(empty($productListId) ? ' selected' : '').'>Select product list</option>';

                                foreach ($productList as $p) {
                                    $selected = ($p['id'] == $productListId) ? ' selected' : '';
                                    $html .= '<option value="'.$p['id'].'"'.$selected.'>'.$p['name'].'</option>';
                                }

                                $html .= '</select>
                                <input id="product_list_select" style="display: none;" type="submit" name="select_product_list" value="Select" class="button">';

                                if (!empty($productListId)) {
                                    $html .= '<a href="' . $full_address_no_t . '&product_list_page=1&delete_product_list=' . $productListId . $token . '" onclick="return confirm(\'' . $this->l('Are you sure you want to delete?') . '\')"><span class="delete-button-link">' . $this->l('Delete') . '</span></a>';
                                }

                                $html .= '<div class="cb"><br></div>
                                '.$this->getProductLisContent($productListId).'
                            </form>
                        </div>
                    </div>
                    <div class="clear_block"></div>
                </div>
		    </div>';

        return $html;
    }

    public function getProductLisContent($productListId)
    {
        if (empty($productListId)) {
            return '';
        }

        $productList = $this->getProductListProducts($productListId);
        $products = array();

        $html = '
        <div style="margin-top: 10px;">
            <div id="search_mask"></div>
            <div style="float: left; width: 300px; z-index: 101; position: relative;">
                <input id="search_form_id" autocomplete="off" type="text" class="search_form" name="product" value="" size = "50" placeholder="' . $this->l('Search, enter product name or id').'"/>
            </div>
            <div class="autocomplite_clear">' . $this->l('[Clear]') . '</div>
            <div class="cb"></div>
            <div id="search_result"></div>
            <div class="search_types">
                <label for="search_name">
                    <input id="search_name" type="radio" name="search_type" value="search_name" checked="checked"><span> ' . $this->l('Search by name') . '</span>
                </label>
                | <label for="search_id">
                    <input id="search_id" type="radio" name="search_type" value="search_id"> <span> ' . $this->l('Search by id') . '</span>
                </label>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>        
            <input style="float: right;" type="submit" name="update_product_list" value="' . $this->l('Update list').'" class="button">
            <div class="cb"></div>        
            <ul class="show_with_products">';

        foreach ($productList as $p) {
            $cat_name = '';
            $products[] = $p['id_product'];

            if (!empty($p['cat_name'])) {
                $cat_name = ', ' . $p['cat_name'];
            }

            $html .= '
                <li class="search_p_list" id="search_p-'.$p['id_product'].'">
                    <div title="' . $this->l('Remove') . '" class="search_drop_product" id="search_drop-' . $p['id_product'] . '"><img src="'.$this->moduleImgPath.'delete.gif"></div>
                    <div style="float: left;">
                        <div style="float: left; width: 30px; margin-right: 2px;">
                            '. $this->getImages(isset($p['id_image']) ? $p['id_image'] : false).'
                        </div>
                        <div style="float: left; width: 300px;" class="search_p_name">
                            '.$p['name'] .'<br/>
                            <span class="search_small_text">#'.$p['id_product'].$cat_name.'</span>
                        </div>
                    </div>
                    <div class="blmod_cb"></div>
                </li>';
        }

        $html .= '</ul>
        <input class="product_hidden" type="hidden" name="product_hidden" value=",'.implode(',', $products).'," /></div>';

        return $html;
    }

    protected function getImages($imageId)
    {
        $type = (_PS_VERSION_ >= '1.5.1') ? '-small_default.jpg' : '-small.jpg';
        $imageClassName = $this->imageClassName;

        $imageClass = new $imageClassName($imageId);
        $name = $imageClass->getExistingImgPath();
        $url = _PS_BASE_URL_._THEME_PROD_DIR_.$name.$type;

        if (!file_exists(_PS_PROD_IMG_DIR_.$name.$type)) {
            $url = _PS_BASE_URL_._THEME_PROD_DIR_.$name.'.jpg';
        }

        return '<img style="width: 25px;" src = "'.$url.'"/>';
    }

    public function getProductListSettingsPage($active)
    {
        $productList = $this->getProductList();

        $html = '<div style = "margin: 10px;">
				<table cellspacing="0" cellpadding="0" class="table" id = "radio_div">
					<tr>
						<th><input type="checkbox" name="checkme" class="noborder" onclick="checkDelBoxes(this.form, \'product_list []\', this.checked)"></th>
						<th style="width: 450px">'.$this->l('Name').'</th>
					</tr>';
        $row = 0;

        if (!empty($productList)) {
            foreach ($productList as $m) {
                $checked = false;

                if (in_array($m['id'], $active)) {
                    $checked = 'checked="yes"';
                }

                $html .= '<tr class="'.($row++ % 2 ? 'alt_row' : '').'">
					<td class="center">
						<input type="checkbox" id="product_list_'.$m['id'].'" name="product_list[]" '.$checked.' value="'.$m['id'].'" class="noborder">
					</td>
					<td>
						<label style="line-height: 26px; padding-left: 0px;" for="product_list_'.$m['id'].'" class="t">'.$m['name'].'
					</td>
				</tr>';
            }
        }

        $html .= '</table>
				<div class="product_list_button" style="cursor: pointer; color: #268CCD; text-align: left; margin-top: 10px;">'.$this->l('[Hide]').'</div>
			</div>';

        return $html;
    }

    public function insertNewProductList()
    {
        $addNewList = Tools::getValue('add_product_list');
        $listName = Tools::getValue('product_list_name');

        if (empty($addNewList) || empty($listName)) {
            return false;
        }

        Db::getInstance()->Execute('
            INSERT INTO '._DB_PREFIX_.'blmod_xml_product_list
            (`name`)
            VALUE
            ("'.htmlspecialchars($listName, ENT_QUOTES).'")
        ');

        $_POST['product_list_id'] = Db::getInstance()->Insert_ID();

        return true;
    }

    public function deleteProductList()
    {
        $id = Tools::getValue('delete_product_list');

        if (empty($id)) {
            return false;
        }

        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_product_list WHERE id = "'.htmlspecialchars($id, ENT_QUOTES).'"');
        $this->remoteProductFromList($id);

        return true;
    }

    public function getProductList()
    {
        return Db::getInstance()->executeS('
			SELECT l.id, l.name
			FROM `'._DB_PREFIX_.'blmod_xml_product_list` l
			ORDER BY l.name ASC
		');
    }

    public function updateProductList()
    {
        $updateProductList = Tools::getValue('update_product_list');
        $productListId = Tools::getValue('product_list_id');

        if (empty($productListId) || empty($updateProductList)) {
            return false;
        }

        $this->remoteProductFromList($productListId);

        $products = explode(',', trim(Tools::getValue('product_hidden'), ','));

        if (empty($products)) {
            return true;
        }

        foreach ($products as $p) {
            $p = (int)$p;

            if (empty($p)) {
                continue;
            }

            Db::getInstance()->Execute('
                INSERT INTO '._DB_PREFIX_.'blmod_xml_product_list_product
                (`product_list_id`, `product_id`)
                VALUES
                ("'.$productListId.'", "'.$p.'")
            ');
        }

        return true;
    }

    public function remoteProductFromList($productListId)
    {
        Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_product_list_product WHERE product_list_id = "'.$productListId.'"');
    }

    public function getProductListProducts($productListId)
    {
        $id_lang = (int)(Configuration::get('PS_LANG_DEFAULT'));

        return Db::getInstance()->executeS('
			SELECT DISTINCT(l.id_product), l.name, cl.name AS cat_name, i.id_image
			FROM `'._DB_PREFIX_.'blmod_xml_product_list_product` lp
			LEFT JOIN '._DB_PREFIX_.'product_lang l ON
			l.id_product = lp.product_id
            LEFT JOIN '._DB_PREFIX_.'product p ON
            l.id_product = p.id_product
            LEFT JOIN '._DB_PREFIX_.'category_lang cl ON
            (p.id_category_default = cl.id_category AND cl.id_lang = "'.$id_lang.'")
            LEFT JOIN `'._DB_PREFIX_.'image` i ON
            (p.id_product = i.id_product AND i.`cover`= "1")
			WHERE lp.product_list_id = "'.$productListId.'"
			GROUP BY l.id_product
			ORDER BY l.name ASC
		');
    }
}
