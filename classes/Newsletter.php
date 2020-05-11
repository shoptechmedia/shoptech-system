<?php 
/*include_once(__PS_BASE_URI__.'classes/newsletter/vendor/autoload.php');
use Mautic\MauticApi;
use Mautic\Auth\ApiAuth;*/
/**
 * 
 */
class Newsletter
{
	public function getContactLists($onlyActive = null, $is_newsletter = null, $configurationOrderby = null, $configurationOrderway = null, $filters){
		$customers = new Customer();
		$list = $customers->getCustomers($onlyActive, $is_newsletter , $configurationOrderby , $configurationOrderway, $filters);

		return $list;
		/*$settings = array(
		    'userName'   => 'nail4you',                  
		    'password'   => 'Negle4Hilfe'          
		);

		$initAuth = new ApiAuth();
		$auth = $initAuth->newAuth($settings, 'BasicAuth');

		$api = new MauticApi();
		return  "string";*/
	}
}