<?php 

/**
* 
*/
class testimonialfront extends ModuleFrontController
{
	
	public function initContent()
    {
        parent::initContent();
        
    	$this->context->smarty->assign([
        	'test' => 'test'
    	]);
    }

    
}