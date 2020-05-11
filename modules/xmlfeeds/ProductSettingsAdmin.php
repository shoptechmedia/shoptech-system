<?php
/**
 * 2010-2019 Bl Modules.
 *
 * If you wish to customize this module for your needs,
 * please contact the authors first for more information.
 *
 * It's not allowed selling, reselling or other ways to share
 * this file or any other module files without author permission.
 *
 * @author    Bl Modules
 * @copyright 2010-2019 Bl Modules
 * @license
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductSettingsAdmin extends Xmlfeeds
{
    protected $full_address_no_t = '';
    protected $token = '';
    protected $imageClassName = 'ImageCore';
    protected $langId = 1;
    protected $currentPageUrl = '';

    public function getContent($full_address_no_t = '', $token = '')
    {
        $packageIdFromSaveAction = $this->insertNewProductSettingsPackage();
        $productList = $this->getProductSettingsPackagesList();
        $packageId = !empty($packageIdFromSaveAction) ? $packageIdFromSaveAction : Tools::getValue('product_setting_package_id');
        $this->full_address_no_t = $full_address_no_t;
        $this->token = $token;
        $this->imageClassName = (!class_exists('ImageCore', false) || _PS_VERSION_ > '1.5.3') ?  'Image' : 'ImageCore';
        $this->langId = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->currentPageUrl = str_replace('&page=', '&page_old=', $_SERVER['REQUEST_URI']);
        $this->currentPageUrl = str_replace('&delete_product_setting_package=', '&delete_product_setting_package_old=', $this->currentPageUrl);

        $html = '
			<div id="content" class="bootstrap content_blmod">
                <div class="bootstrap">
                    <div class="panel">
                        <div class="panel-heading">
                            <i class="icon-cog"></i> '.$this->l('Product settings').'
                        </div>
                        <div class="row">
                            <form action="'.$this->currentPageUrl.'" method="post">
                                <input style="width: 300px;" type="text" name="product_setting_package_name" placeholder="'.$this->l('Product settings package name').'" />
                                <input style="" type="submit" name="add_product_settings_package" value="'.$this->l('Add new').'" class="button">
                                <div class="cb"><br></div>
                                <hr>
                                <input id="product_setting_package_select" style="display: none;" type="submit" name="product_setting_package_select" value="Select" class="button">
                                <select id="product_setting_package_id" style="width: 300px; float: left;" name="product_setting_package_id">
                                    <option value="0" disabled'.(empty($packageId) ? ' selected' : '').'>Select product package</option>';
                                        foreach ($productList as $p) {
                                            $selected = ($p['id'] == $packageId) ? ' selected' : '';
                                            $html .= '<option value="'.$p['id'].'"'.$selected.'>'.$p['name'].'</option>';
                                        }

                                        $html .= '</select>
                                            <input id="product_list_select" style="display: none;" type="submit" name="select_product_list" value="Select" class="button">';

                                        if (!empty($packageId)) {
                                            $html .= '<a href="' . $full_address_no_t . '&product_settings_page=1&delete_product_setting_package=' . $packageId . $token . '" onclick="return confirm(\'' . $this->l('Are you sure you want to delete?') . '\')"><span class="delete-button-link">' . $this->l('Delete') . '</span></a>';
                                        }
                                $html .= '<div class="cb"><br></div>       
                                </form>                     
                            <div style="padding-top: 10px;">'.$this->getProductsTable($packageId).'</div>
                            
                        </div>
                    </div>
                    <div class="clear_block"></div>
                </div>
		    </div>';

        return $html;
    }

    public function insertNewProductSettingsPackage()
    {
        $addNewList = Tools::getValue('add_product_settings_package');
        $listName = Tools::getValue('product_setting_package_name');

        if (empty($addNewList) || empty($listName)) {
            return false;
        }

        Db::getInstance()->Execute('
            INSERT INTO '._DB_PREFIX_.'blmod_xml_product_settings_package
            (`name`)
            VALUE
            ("'.htmlspecialchars($listName, ENT_QUOTES).'")
        ');

        $packageId = Db::getInstance()->Insert_ID();

        if (empty($packageId)) {
            return false;
        }

        Db::getInstance()->Execute('
            INSERT INTO '._DB_PREFIX_.'blmod_xml_product_settings
            (`product_id`, `package_id`)
            VALUE
            ("0", "'.htmlspecialchars($packageId, ENT_QUOTES).'")
        ');

        return $packageId;
    }

    public function deleteProductSettingsPackage()
    {
        $packageId = htmlspecialchars(Tools::getValue('delete_product_setting_package'), ENT_QUOTES);

        if (empty($packageId)) {
            return false;
        }

        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_product_settings WHERE package_id = "'.$packageId.'"');
        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_product_settings_package WHERE id = "'.$packageId.'"');

        return true;
    }

    public function getProductSettingsPackagesList()
    {
        return Db::getInstance()->executeS('
			SELECT l.id, l.name
			FROM `'._DB_PREFIX_.'blmod_xml_product_settings_package` l
			ORDER BY l.name ASC
		');
    }

    public function getProductsTable($packageId)
    {
        if (empty($packageId)) {
            return '';
        }

        $productSettings = new ProductSettings();
        $page = Tools::getValue('page');
        $searchProductId = htmlspecialchars(Tools::getValue('product_settings_search_id'), ENT_QUOTES);
        $searchProductName = htmlspecialchars(Tools::getValue('product_settings_search_name'), ENT_QUOTES);
        $whereParam = array();

        if (!empty($searchProductId)) {
            $whereParam[] = 'p.id_product = "'.$searchProductId.'"';
            $page = 1;
        }

        if (!empty($searchProductName)) {
            $whereParam[] = 'pl.name LIKE "%'.$searchProductName.'%"';
            $page = 1;
        }

        $where = !empty($whereParam) ? 'WHERE '.implode(' AND ', $whereParam) : '';
        $products = $this->getProducts($whereParam, $page, $packageId);

        $total = Db::getInstance()->getValue('
			SELECT COUNT(DISTINCT(p.id_product))
			FROM '._DB_PREFIX_.'product p
			LEFT JOIN '._DB_PREFIX_.'product_lang pl ON
			(pl.id_product = p.id_product and pl.id_lang = "'.$this->langId.'")
			'.$where
        );

        $html = '
        <div>        
            <input type="hidden" name="tab" value="'.htmlspecialchars(Tools::getValue('tab'), ENT_QUOTES).'">
            <input type="hidden" name="configure" value="'.htmlspecialchars(Tools::getValue('configure'), ENT_QUOTES).'">
            <input type="hidden" name="product_settings_page" value="'.htmlspecialchars(Tools::getValue('product_settings_page'), ENT_QUOTES).'">
            <input type="hidden" name="token" value="'.htmlspecialchars(Tools::getValue('token'), ENT_QUOTES).'">
            <input type="hidden" name="product_setting_package_id" value="'.$packageId.'">
            <input type="hidden" name="current_url" value="'.$this->currentPageUrl.'">
            <div>
                <div id="search_mask"></div>
                <div style="float: left; width: 300px; z-index: 101; position: relative;">
                    <input id="search_form_id" autocomplete="off" type="text" class="search_form" name="product" value="" size = "50" placeholder="' . $this->l('Search, enter product name or id').'"/>
                </div>
                <div class="autocomplite_clear">'.$this->l('[Clear]').'</div>
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
                    <input class="product_hidden" type="hidden" name="product_hidden" value="" />
                </div>
                <div class="cb"></div>
            </div>
        </div>
        <form action="'.$this->currentPageUrl.'" method="post">
        <input type="hidden" name="product_setting_package_id" value="'.$packageId.'">';

        $html .= '<input type="submit" name="update_product_settings" value="'.$this->l('Update').'" style="float: right;" class="button"><div class="cb"></div>';
        $html .= $this->getSettingsBox($productSettings->getByProductAndPackageId(ProductSettings::DEFAULT_SETTINGS_ID, $packageId));

        if (empty($products)) {
            return $html.$this->l('No results');
        }

        foreach ($products as $p) {
            $html .= $this->getSettingsBox($p);
        }

        $pagination = XmlFeedsTools::pagination($page, XmlFeedsTools::ITEM_IN_PAGE, $total, $this->full_address_no_t.'&product_settings_page=1&product_setting_package_id='.$packageId.$this->token.'&');

        return $html.$pagination[2].'<div class="cb"></div><input type="submit" name="update_product_settings" value="'.$this->l('Update').'" style="float: right;" class="button"><div class="cb"></div></form>';
    }

    protected function getSettingsBox($p)
    {
        $totalBudget = isset($p['total_budget']) ? $p['total_budget'] : '';
        $dailyBudget = isset($p['daily_budget']) ? $p['daily_budget'] : '';
        $cpc = isset($p['cpc']) ? $p['cpc'] : '';
        $priceType = isset($p['price_type']) ? $p['price_type'] : '';
        $xmlCustom = isset($p['xml_custom']) ? htmlspecialchars_decode($p['xml_custom'], ENT_QUOTES) : '';
        $isDefaultProduct = ($p['id_product'] == 0);
        $blockName = '#'.$p['id_product'].' '.$p['name'];
        $html = '<div style="border-bottom: 1px solid #d3d8db; padding-bottom: 10px; margin-bottom: 10px;">';

        if (!$isDefaultProduct) {
            $html .= '<div class="product-img">' . $this->getImages($p) . '</div>';
        } else {
            $blockName = $this->l('DEFAULT PRODUCT SETTINGS');
        }

        $html .= '<div class="product-settings">
                    <div style="color: #25b9d7; margin-bottom: 15px;">'.$blockName.'</div>
                    <div class="block-info">'.$this->l('Additional fields for Marktplaats').':</div>
                    <div class="product-settings-input">
                        <span>'.$this->l('Total budget').':</span> <input type="text" name="total_budget['.$p['id_product'].']" value="'.$totalBudget.'">
                    </div>
                    <div class="product-settings-input">
                        <span>'.$this->l('Daily budget').':</span> <input type="text" name="daily_budget['.$p['id_product'].']" value="'.$dailyBudget.'">
                    </div>
                    <div class="product-settings-input">
                       <span>'.$this->l('CPC').':</span> <input type="text" name="cpc['.$p['id_product'].']" value="'.$cpc.'">
                    </div>
                    <div class="product-settings-input">
                        <span>'.$this->l('Price type').':</span> 
                        <select name="price_type['.$p['id_product'].']">
                            <option value="">'.$this->l('None').'</option>';

                            foreach ($this->getPriceTypes() as $t) {
                                $html .= '<option '.($priceType == $t ? ' selected' : '').' value="'.$t.'">'.$t.'</option>';
                            }

                    $html .= '    
                        </select>
                    </div>
                    <hr>
                    <div class="block-info">'.$this->l('Fields for all feeds').':</div>
                    <div class="product-settings-input">
                       <span>'.$this->l('Custom XML').':</span> <textarea name="xml_custom['.$p['id_product'].']">'.$xmlCustom.'</textarea>
                       <div class="bl_comments_small" style="text-align: right;">'.$this->l('[Make sure that you have entered validate XML code]').'</div>
                    </div>
                </div>
                <div class="cb"></div>
            </div>';

         return $html;
    }

    protected function getImages($product)
    {
        $type = (_PS_VERSION_ >= '1.5.1') ? '-cart_default.jpg' : '-cart.jpg';
        $imageClassName = $this->imageClassName;

        $imageClass = new $imageClassName($product['id_image']);
        $name = $imageClass->getExistingImgPath();
        $url = _PS_BASE_URL_._THEME_PROD_DIR_.$name.$type;

        if (!file_exists(_PS_PROD_IMG_DIR_.$name.$type)) {
            $url = _PS_BASE_URL_._THEME_PROD_DIR_.$name.'.jpg';
        }

        return '<img style="width: 125px; padding: 0;" src = "'.$url.'"/>';
    }

    public function getProducts($whereParam, $page, $packageId)
    {
        $where = !empty($whereParam) ? 'WHERE '.implode(' AND ', $whereParam) : '';
        $limitFrom = ($page > 1) ? (($page - 1) * XmlFeedsTools::ITEM_IN_PAGE) : 0;

        return Db::getInstance()->ExecuteS('
			SELECT DISTINCT(p.id_product), pl.name, im.id_image, 
			s.total_budget, s.daily_budget, s.cpc, s.price_type, s.xml_custom
			FROM '._DB_PREFIX_.'product p
			LEFT JOIN '._DB_PREFIX_.'product_lang pl ON
			(pl.id_product = p.id_product and pl.id_lang = "'.$this->langId.'")
			LEFT JOIN '._DB_PREFIX_.'image im ON
			(im.id_product = p.id_product and im.cover = 1)
			LEFT JOIN '._DB_PREFIX_.'blmod_xml_product_settings s ON
			(s.product_id = p.id_product AND s.package_id = "'.$packageId.'")
			'.$where.'
			GROUP BY p.id_product
			ORDER BY p.id_product DESC
			LIMIT '.$limitFrom.', '.XmlFeedsTools::ITEM_IN_PAGE
        );
    }

    public function save()
    {
        $totalBudget = Tools::getValue('total_budget');
        $dailyBudget = Tools::getValue('daily_budget');
        $cpc = Tools::getValue('cpc');
        $priceType = Tools::getValue('price_type');
        $xmlCustom = Tools::getValue('xml_custom');
        $packageId = htmlspecialchars(Tools::getValue('product_setting_package_id'), ENT_QUOTES);

        foreach ($totalBudget as $id => $total) {
            $id = htmlspecialchars($id, ENT_QUOTES);
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'blmod_xml_product_settings WHERE product_id = "'.$id.'" AND package_id = "'.$packageId.'"');

            Db::getInstance()->Execute('
                INSERT INTO '._DB_PREFIX_.'blmod_xml_product_settings
                (`product_id`, `package_id`, `total_budget`, `daily_budget`, `cpc`, `price_type`, `xml_custom`, `updated_at`)
                VALUES
                ("'.$id.'", "'.$packageId.'", "'.htmlspecialchars($total, ENT_QUOTES).'", "'.htmlspecialchars($dailyBudget[$id], ENT_QUOTES).'", 
                "'.htmlspecialchars($cpc[$id], ENT_QUOTES).'", "'.htmlspecialchars($priceType[$id], ENT_QUOTES).'", "'.htmlspecialchars($xmlCustom[$id], ENT_QUOTES).'", "'.date('Y-m-d H:i:s').'")
            ');
        }

        return true;
    }

    public function getPriceTypes()
    {
        return array(
            'BIDDING',
            'BIDDING_FROM',
            'FIXED_PRICE',
            'FREE',
            'NEGOTIABLE',
            'SEE_DESCRIPTION',
            'SWAP',
            'CREDIBLE_BID',
            'ON_DEMAND',
            'RESERVED',
        );
    }
}