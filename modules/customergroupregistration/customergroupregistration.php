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

if (!defined('_PS_VERSION_')) {
    exit;
}

class CustomerGroupRegistration extends Module
{
    private $_html = '';
    private $_postErrors = array();
    private $defaultCustomerGroup = 1;

    public function __construct()
    {
        $this->name = 'customergroupregistration';
        $this->tab = 'front_office_features';
        $this->version = '2.0.1';
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6.99');
        $this->author = 'Bellini Services';
        $this->need_instance = 0;

        $this->controllers = array('mygroups');

        $this->bootstrap = true;
	    $this->module_key = '6859b66f68923ce966355938da138409';
		parent::__construct();

        $this->defaultCustomerGroup = (int)Configuration::get('PS_CUSTOMER_GROUP');

        $this->displayName = 'Customer Group Registration';
        $this->description = "Allows for the customer to select a group during the registration process.";
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        Configuration::updateValue('CGR_GROUP_MODE', 0);        //0=single 1=multiple

        return (
            $this->registerHook('createAccountForm') and
            $this->registerHook('createAccount') and
            $this->registerHook('displayCustomerAccount') and
            $this->registerHook('displayMyAccountBlock') and
            $this->registerHook('displayMyAccountBlockfooter')
        );
    }

    public function uninstall()
    {
        if (!parent::uninstall() or
            !$this->unregisterHook('createAccountForm') or
            !$this->unregisterHook('createAccount') or
            !$this->unregisterHook('displayCustomerAccount') or
            !$this->unregisterHook('displayMyAccountBlock') or
            !$this->unregisterHook('displayMyAccountBlockfooter')
        ) {
            return false;
        }

        Configuration::deleteByName('CGR_GROUP_MODE');

        return true;
    }

    public function getContent()
    {
        $this->_html = '';

        if (Tools::isSubmit('btnSubmit')) {
            $this->_postValidation();
            if (!count($this->_postErrors)) {
                $this->_postProcess();
            } else {
                foreach ($this->_postErrors as $err) {
                    $this->_html .= $this->displayError($err);
                }
            }
        }

        $this->_html .= $this->_displayCheck();
        $this->_html .= $this->renderForm();

        return $this->_html;
    }

    private function _postValidation()
    {
        if (Tools::isSubmit('btnSubmit')) {
            $mode = Tools::getValue('CGR_GROUP_MODE') !== false ? (int)Tools::getValue('CGR_GROUP_MODE') : false;

            if ($mode===false) {
                $this->_postErrors[] = $this->l('The "Mode" field is required.');
            }
        }
    }

    private function _postProcess()
    {
        if (Tools::isSubmit('btnSubmit')) {
            Configuration::updateValue('CGR_GROUP_MODE', (int)Tools::getValue('CGR_GROUP_MODE'));
        }
        $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    private function _displayCheck()
    {
        return $this->display(__FILE__, './views/templates/hook/infos.tpl');
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cog'
                ),
                'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Group Selection Mode'),
                        'name' => 'CGR_GROUP_MODE',
                        'values' => array(
                            array(
                                'id' => 'multiple',
                                'value' => 1,
                                'label' => $this->l('Multiple Group Selection')
                            ),
                            array(
                                'id' => 'single',
                                'value' => 0,
                                'label' => $this->l('Single Group Selection')
                            ),
                        )
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->id = (int)Tools::getValue('id_carrier');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
        );

        $this->fields_form = array();

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'CGR_GROUP_MODE' => Tools::getValue('CGR_GROUP_MODE', Configuration::get('CGR_GROUP_MODE')),
        );
    }

    /**
     * The function is called when the my-account page is displayed.
     *
     */
    public function hookDisplayCustomerAccount()
    {
        return $this->display(__FILE__, 'my-account.tpl');
    }

    /**
     * The function is called by the blockmyaccount module.
     *
     */
    public function hookDisplayMyAccountBlockfooter()
    {
        if ($this->context->customer->isLogged()) {
            return $this->display(__FILE__, 'my-account-block.tpl');
        }
    }

    /**
     * The function is called by the blockmyaccountfooter module.
     *
     */
    public function hookDisplayMyAccountBlock()
    {
        if ($this->context->customer->isLogged()) {
            return $this->display(__FILE__, 'my-account-block.tpl');
        }
    }

    /**
     * The function is called when the create account form is displayed in the front office
     *
     */
    public function hookCreateAccountForm($params)
    {
        //sl_group is a helper variable to define a pre-selected group in the select form element.
        $sl_group = Tools::getValue('id_group', $this->defaultCustomerGroup);

        $groups = $this->getValidGroups();

        $this->context->smarty->assign(array(
            'sl_group' => $sl_group,
            'groups' => $groups,
            'cgr_mode' => (int)Configuration::get('CGR_GROUP_MODE'),
        ));
        return $this->display(__FILE__, 'customergroupregistration_auth.tpl');
    }

    /**
     * The function is called when a new customer account is created in the front office
     *
     */
    public function hookCreateAccount($params)
    {
        $customer = $params['newCustomer'];
        if (!Validate::isLoadedObject($customer)) {
            return false;
        }

        $mode = (int)Configuration::get('CGR_GROUP_MODE');

        if ($mode == 0) { //expect only a single group selected
            $id_group = Tools::getValue('id_group', $this->defaultCustomerGroup); //get the selected group, or use the default customer group
            $customer->cleanGroups();
            $customer->addGroups(array($id_group));
            $customer->id_default_group = (int)$id_group;
            $customer->update();
        } elseif ($mode == 1) {//expect 1 or more groups to be selected
            $id_group = Tools::getValue('id_group', array($this->defaultCustomerGroup)); //get the selections.  If the customer fails to select a group, then we default to id group 1

            //we need to convert id_group to an array if it is not an array
            if (!is_array($id_group)) {
                $id_group = array($id_group);
            }

            /*
            it appears during ajax account creation, the groups are submitted as a single index array, with comma separated group ids.
            So we should detect and convert to multi index array
            Array
            (
                [0] => 4,5
            )
            */
            if (sizeof($id_group) == 1) {
                $temp = $id_group[0];
                if (strpos($temp, ',') !== false) {
                    $id_group = explode(",", $temp);
                }
            }

            $customer->cleanGroups();    //remove existing groups
            $customer->addGroups($id_group);
            //determine the default group. either id group 1, or the first group selected
            if (in_array($this->defaultCustomerGroup, $id_group)) {
                $customer->id_default_group=$this->defaultCustomerGroup;
            } else {
                $customer->id_default_group=(int)$id_group[0];
            }
            $customer->update();
        }
        //since we just updated the groups, we need to reset the internal Customer group cache, otherwise a call to getGroups will return the cached results
        Customer::resetGroupCache($this->context->cookie->id_customer);
    }

    /**
     * This function returns an array of the available groups defined in the Shop.
     * It removes the Visitor and Guest groups, leaving only the default Customer group, and any custom groups
     */
    public function getValidGroups()
    {
        $groups = Group::getGroups($this->context->cookie->id_lang, $this->context->shop->id);

        foreach ($groups as $key => $group) {
            if ($group['id_group']==Configuration::get('PS_UNIDENTIFIED_GROUP')) {
                unset($groups[$key]);
            }
            if ($group['id_group']==Configuration::get('PS_GUEST_GROUP')) {
                unset($groups[$key]);
            }
        }
        return $groups;
    }
}
