<?php 


/**
* 
*/
class category
{
	
	public function __construct()
	{	
	}

	public function getCats() {
		include_once "../../../config/autoload.php";
		//include $_SERVER['SERVER_NAME']."/config/autoload.php";
		$output = $_SERVER['SERVER_NAME']."/config/autoload.php";
		$cats = Category::getCategories('', true, false);
		/*foreach ($cats as $cat) {
			$output .= $cat['name'];
		}*/
		return $output;
	}

}