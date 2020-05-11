<?php
class FrontController extends FrontControllerCore
{
    public function init()
    {      
        if (Module::isInstalled('lgseoredirect'))
        {
            $uri_var = $_SERVER['REQUEST_URI'];
            if ($redireccion = $this->getRedirect($uri_var))
            {
                if ($redireccion['redirect_type'] == 301)
                    $header = 'HTTP/1.1 301 Moved Permanently';
                if ($redireccion['redirect_type'] == 302)
                    $header = 'HTTP/1.1 302 Moved Temporarily';
                if ($redireccion['redirect_type'] == 303)
                    $header = 'HTTP/1.1 303 See Other';                   
                Tools::redirect($redireccion['url_new'], __PS_BASE_URI__, null, $header);
            }           
        }
        parent::init();
    }
    private function getRedirect($uri_var){
        $old_url = addslashes($uri_var);        
        $sql = "SELECT url_new, redirect_type 
                FROM "._DB_PREFIX_."lgseoredirect
                WHERE url_old = '$old_url' AND (id_shop = ".$this->context->shop->id." OR id_shop=0)";
               
        return Db::getInstance()->getRow($sql);
    }
    /*
    * module: n45xspeed
    * date: 2017-01-16 01:50:07
    * version: 2.6.4
    */
    protected function smartyOutputContent($content) {
        if (!Module::isInstalled('n45xspeed') || !Module::isEnabled('n45xspeed')) {
            parent::smartyOutputContent($content);
            return;
        }
        if(file_exists(_PS_MODULE_DIR_ . '/n45xspeed/overwrite/FrontController.php')){
            include_once(_PS_MODULE_DIR_ . '/n45xspeed/overwrite/FrontController.php');
        }
    }
	/*
    * module: canonicalheaders
    * date: 2017-10-19 10:02:32
    * version: 1
    */
    public function getSeoFields()
    {
        $content = '';
        $languages = Language::getLanguages();
        $defaultLang = Configuration::get('PS_LANG_DEFAULT');
		$id = null;
		$type = null;
		$store_id = Shop::getContextShopID();
		$base_url = $_SERVER['SERVER_NAME'];
        switch ($this->php_self) {
            case 'product': // product page
				$type = 1;
				$id = (int)Tools::getValue('id_product');
                $idProduct = (int) Tools::getValue('id_product');
                $canonical = $this->context->link->getProductLink($idProduct);
                $hreflang = $this->getHrefLang('product', $idProduct, $languages, $defaultLang);
                break;
            case 'category':
	            $type = 2;
				$id = (int)Tools::getValue('id_category');
                $idCategory = (int) Tools::getValue('id_category');
                $content .= $this->getRelPrevNext('category', $idCategory);
                $canonical = $this->context->link->getCategoryLink((int) $idCategory);
                $hreflang = $this->getHrefLang('category', $idCategory, $languages, $defaultLang);
                break;
            case 'manufacturer':
                $idManufacturer = (int) Tools::getValue('id_manufacturer');
                $content .= $this->getRelPrevNext('manufacturer', $idManufacturer);
                $hreflang = $this->getHrefLang('manufacturer', $idManufacturer, $languages, $defaultLang);
                if (!$idManufacturer) {
                    $canonical = $this->context->link->getPageLink('manufacturer');
                } else {
                    $canonical = $this->context->link->getManufacturerLink($idManufacturer);
                }
                break;
            case 'supplier':
                $idSupplier = (int) Tools::getValue('id_supplier');
                $content .= $this->getRelPrevNext('supplier', $idSupplier);
                $hreflang = $this->getHrefLang('supplier', $idSupplier, $languages, $defaultLang);
                if (!Tools::getValue('id_supplier')) {
                    $canonical = $this->context->link->getPageLink('supplier');
                } else {
                    $canonical = $this->context->link->getSupplierLink((int) Tools::getValue('id_supplier'));
                }
                break;
            case 'cms':
	            $idCms = Tools::getValue('id_cms');
	            $idCmsCategory = Tools::getValue('id_cms_category');
	            if ($idCms) {
		            $canonical = $this->context->link->getCMSLink((int) $idCms);
		            $hreflang = $this->getHrefLang('cms', (int) $idCms, $languages, $defaultLang);
	            } else {
		            $canonical = $this->context->link->getCMSCategoryLink((int) $idCmsCategory);
		            $hreflang = $this->getHrefLang('cms_category', (int) $idCmsCategory, $languages, $defaultLang);
	            }
                break;
            default:
                $canonical = $this->context->link->getPageLink($this->php_self);
                $hreflang = $this->getHrefLang($this->php_self, 0, $languages, $defaultLang);
                break;
        }
        $check_link = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."htttp_links WHERE type = '$type' AND type_id = '$id' AND store_id = '$store_id'");
        if ($check_link) {
			foreach ($check_link as $val) {
				if (substr($val['link_address'], 0, 1) == '/' ) {
					$content .= '<link rel="canonical" href="http://' .$base_url . $val['link_address'] . '">';
				} else {
					$content .= '<link rel="canonical" href="'. $val['link_address'] . '">';
				}
			}
		} else {
	        $content .= '<link rel="canonical" href="'.$canonical.'">'."\n";
	    }
        if (is_array($hreflang) && !empty($hreflang)) {
            foreach ($hreflang as $lang) {
                $content .= "$lang\n";
            }
        }
        return $content;
    }
}
