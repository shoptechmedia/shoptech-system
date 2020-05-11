/**
* 2013-2014 2N Technologies
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to contact@2n-tech.com so we can send you a copy immediately.
*
* @author    2N Technologies <contact@2n-tech.com>
* @copyright 2013-2014 2N Technologies
* @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

var multishop_bar_id = '.breadcrumb-multishop';
var save_btn_id = '#page-header-desc-ntreduction-save';
var check_all_categories = '#check-all-categories-treeview';
var uncheck_all_categories = '#uncheck-all-categories-treeview';

$(document).ready( function ()
{
	if($('#ntreduction_toolbar').length > 0)
		$('.breadcrumb-multishop').hide();
});