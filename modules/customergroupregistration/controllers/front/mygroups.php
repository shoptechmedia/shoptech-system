<?php
/**
 * This file is part of module Customer Group Registration
 *
 *  @author    Bellini Services <bellini@bellini-services.com>
 *  @copyright 2007-2017 bellini-services.com
 *  @license   readme
 *
 * Your purchase grants you usage rights subject to the terms outlined by this license.
 *
 * You CAN use this module with a single, non-multi store configuration, production installation and unlimited test installations of PrestaShop.
 * You CAN make any modifications necessary to the module to make it fit your needs. However, the modified module will still remain subject to this license.
 *
 * You CANNOT redistribute the module as part of a content management system (CMS) or similar system.
 * You CANNOT resell or redistribute the module, modified, unmodified, standalone or combined with another product in any way without prior written (email) consent from bellini-services.com.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

class CustomerGroupRegistrationMyGroupsModuleFrontController extends ModuleFrontController
{
	public $display_column_left = false;
    public $display_column_right = false;

	public function initContent()
	{
		parent::initContent();

		if (!$this->context->customer->isLogged())
			Tools::redirect('index.php?controller=authentication&redirect=module&module=customergroupregistration&action=mygroups');

		$customer = $this->context->customer;
		if (!Validate::isLoadedObject($customer))
			return false;

		if (Tools::isSubmit('submit'))
		{
			$this->module->hookCreateAccount(array('newCustomer'=>$customer));
		}

		//get system groups, if there is only 1 group, then disable.
//		$isEnabled = true;
		$groups = $this->module->getValidGroups();
//		if (sizeof($groups) == 1)
//			$isEnabled = false;

//		//only allow if registered customer, if guest or not registered then disable
//		if ($customer->isGuest() or !Customer::customerIdExistsStatic($this->context->cookie->id_customer))
//			$isEnabled = false;
		
//			//PS v1.5+ includes a cache for the groups, where as v1.4 always loads them. However there is no way to clear the cache, so we created an override to clear the cache
//			Customer::resetGroupCache($this->context->cookie->id_customer);	

		$this->context->smarty->assign(array(
			'groups' => $groups,
			'customerGroup' => $customer->getGroups(),
//			'isEnabled' => $isEnabled,
			'cgr_mode' => (int)Configuration::get('CGR_GROUP_MODE'),
		));

		$this->setTemplate('mygroups.tpl');
	}
}