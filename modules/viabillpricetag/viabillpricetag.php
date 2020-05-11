<?php

if (!defined('_PS_VERSION_'))
	exit;


class ViaBillPriceTag extends Module
{
  public function __construct()
  {
    $this->name = 'viabillpricetag';
    $this->version = '0.8';
    $this->v14 = _PS_VERSION_ >= "1.4.0.0";
    $this->v15 = _PS_VERSION_ >= "1.5.0.0";
    $this->v16 = _PS_VERSION_ >= "1.6.0.0";
    $this->tab = 'pricing_promotion';
    $this->author = 'CM-telecom';
    parent::__construct();
    $this->displayName = $this->l('ViaBill Price Tags');
    $this->description = $this->l('Add ViaBill price tags to products');
  }

  public function install()
  {
    if (_PS_VERSION_ < '1.4')
      return false;
    return parent::install() &&
      $this->registerHook('header') &&
      $this->registerHook('footer') &&
      $this->registerHook('shoppingCart') &&
      $this->registerHook('productFooter');
  }

  public function uninstall()
  {
    $this->getSetup();
    foreach ($this->setupVars as $setupVar)
      Configuration::deleteByName($setupVar[0]);
    return parent::uninstall();
  }

  public function getSetup($doCache = true)
  {
    if ($doCache && isset($this->setup))
      return $this->setup;
    $this->setupVars = array(
	array('VIABILL_TAG_CODE', 'tagcode', '',
	  $this->l('Price tag code'),
	  $this->l('JavaScript price tag code copied from ViaBill settings')),
	array('VIABILL_TAG_LIST', 'list', 1,
	  $this->l('List'),
	  $this->l('Show price tag in list view')),
	array('VIABILL_TAG_PRODUCT', 'product', 1,
	  $this->l('Product'),
	  $this->l('Show price tag in product view')),
	array('VIABILL_TAG_CART', 'cart', 1,
	  $this->l('Cart'),
	  $this->l('Show price tag in cart view')),
	array('VIABILL_TAG_PAYMENT', 'payment', 1,
	  $this->l('Payment'),
	  $this->l('Show price tag in payment overview')),
	array('VIABILL_TAG_CSS', 'style', '',
	  $this->l('Width'),
	  $this->l('Setup width of price tag in product view')),
	);
    $setup = new StdClass();
    foreach ($this->setupVars as $setupVar) {
      $setup->{$setupVar[1]} = Configuration::get($setupVar[0]);
      if ($setup->{$setupVar[1]} === false)
	$setup->{$setupVar[1]} = $setupVar[2];
    }
    $this->setup = $setup;
    return $setup;
  }

  public function getContent()
  {
    $this->getSetup();
    $html = '';
    if (Tools::isSubmit('submitVbSave')) {
      foreach ($this->setupVars as $setupVar) {
	$value = Tools::getValue($setupVar[1], '');
	if (is_int($setupVar[2])) {
	  Configuration::updateValue($setupVar[0], $value ? 1 : 0);
	}
	else {
	  Configuration::updateValue($setupVar[0], $value, true);
	}
      }
      if (_PS_VERSION_ >= '1.5')
	Tools::clearCache(Context::getContext()->smarty);
      $html .= '
	<div class="conf confirm">
	'.$this->l('Settings updated').'
	</div>';
    }
    $html .= '<h2>'.$this->displayName.'</h2>';
    $setup = $this->getSetup(false);
    $html .= '<form id="submitVbSave" method="post"
      action="'.Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']).'">
      <fieldset><legend>'.$this->l('Settings').'</legend>';
    foreach ($this->setupVars as $setupVar) {
      $varName = $setupVar[1];
      $checked = $setup->$varName ? 'checked' : '';
      if (is_int($setupVar[2]))
	$html .= '
	  <div style="clear:both"><label>'.$setupVar[3].'</label>
	  <div class="margin-form"><input type="checkbox"
	  name="'.$setupVar[1].'"
	  id="'.$setupVar[1].'" '.$checked.'/> '.$setupVar[4].'
	  </div></div>';
      else
	if ($varName == 'style')
	  $html .= '
	    <div style="clear:both"><label>'.$setupVar[3].'</label>
	    <div class="margin-form"><input type="text" id="'.$setupVar[1].'"  name="'.$setupVar[1].'" value="'.$setup->$varName.'">
	    <br />'.$setupVar[4].'</div></div>';
	else
	$html .= '
	  <div style="clear:both"><label>'.$setupVar[3].'</label>
	  <div class="margin-form"><textarea rows="3" cols="80"
	  style="vertical-align:top"
	  name="'.$setupVar[1].'"
	  id="'.$setupVar[1].'">'.$setup->$varName.'</textarea>
	  <br />'.$setupVar[4].'</div></div>';
	
    }
    $html .= '
      <br />
      <br />
      <label></label>
      <input type="submit" name="submitVbSave"
      value="'.$this->l('Save').'" class="button" />
      </fieldset></form>';

    return $html;
  }

  public function setSmarty()
  {
    global $smarty;

    $setup = $this->getSetup();
    $tagcode = $setup->tagcode;
    $tagcode = str_replace('<script>', '', $tagcode);
    $tagcode = str_replace('</script>', '', $tagcode);
    $smarty->assign(array(
      'moduleName' => strtoupper($this->name).' header',
      'pt_tagCode' => $tagcode,    
      'pt_list' => $setup->list,
      'pt_product' => $setup->product,
      'pt_cart' => $setup->cart,
      'pt_payment' => $setup->payment,
      'pt_style' => $setup->style,
    
    ));
  }
  
  public function checkAttributes()
  {
   
    
      $productch = $this->context->controller->getProduct();
	
      $attributes_groups = $productch->getAttributesGroups($this->context->language->id);
     // print_r($attributes_groups);
     
     if ($attributes_groups){
      $child_prices     = array();
			 
		foreach ( $attributes_groups as $child_id ) {
						
						if ( $child_id['price']){
						
						$child_prices[] = $child_id['price'];
						
						
						}
										
					    }
					   
					if ( ! empty( $child_prices ) ) {
						$min_price = min( $child_prices );
						$max_price = max( $child_prices );
							if ($max_price == $min_price){
								$oneprice = 'OK';
								
							}else{
							    $oneprice = 'DIF';
							}
					}

	}else{
		$oneprice = 'OK';
		  
	}

		return $oneprice;
  }

  public function hookHeader($params)
  {
    $this->setSmarty();
    if ($this->v16)
      return $this->display(__FILE__, 'header_16.tpl');
    if ($this->v15)
      return $this->display(__FILE__, 'header_15.tpl');
    if ($this->v14)
      return $this->display(__FILE__, 'header_14.tpl');
  }

  public function hookFooter($params)
  {
    $this->setSmarty();
    if ($this->v16)
      return $this->display(__FILE__, 'footer_16.tpl').
	$this->display(__FILE__, 'cart_16.tpl');
    if ($this->v15)
      return $this->display(__FILE__, 'footer_15.tpl').
	$this->display(__FILE__, 'cart_15.tpl');
    if ($this->v14)
      return $this->display(__FILE__, 'footer_14.tpl').
	$this->display(__FILE__, 'cart_14.tpl');
  }

  public function hookProductFooter($params)
  {
      global $smarty;  
    $this->setSmarty();
    $smarty->assign('sameprice',$this->checkAttributes());
      
    if ($this->v16)
      return $this->display(__FILE__, 'product_16.tpl');
    if ($this->v15)
      return $this->display(__FILE__, 'product_15.tpl');
    if ($this->v14)
      return $this->display(__FILE__, 'product_14.tpl');
  }

  public function hookDisplayProductPriceBlock($params)
  {
    return $this->hookProductFooter($params);
  }

  /*public function hookShoppingCart($params)
  {
    $this->setSmarty();
    if ($this->v16)
      return $this->display(__FILE__, 'cart_16.tpl');
    if ($this->v15)
      return $this->display(__FILE__, 'cart_15.tpl');
    if ($this->v14)
      return $this->display(__FILE__, 'cart_14.tpl');
  }*/

  public function hookCart($params)
  {
    return $this->hookShoppingCart($params);
  }
}

?>
