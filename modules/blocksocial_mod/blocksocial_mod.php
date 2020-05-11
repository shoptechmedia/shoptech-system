<?php
/*
 * 2007-2012 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2012 PrestaShop SA
 *  @version  Release: $Revision: 6844 $
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_CAN_LOAD_FILES_'))
	exit ;

class blocksocial_mod extends Module {
	public function __construct() {
		$this->name = 'blocksocial_mod';
		$this->tab = 'front_office_features';
		$this->version = '1.1';
		$this->author = 'IQIT-COMMERCE.COM';
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Block social Mod');
		$this->description = $this->l('Allows you to add extra information about social networks');
	}

	public function install() {
		$this->_clearCache('blocksocial_mod.tpl');
		return (parent::install() AND Configuration::updateValue('bsmod_hook', 0) && Configuration::updateValue('bsmod_facebook', 'https://www.facebook.com/prestashop') && Configuration::updateValue('bsmod_twitter', 'https://twitter.com/agencja_iqit') && Configuration::updateValue('bsmod_rss', '') && Configuration::updateValue('bsmod_youtube', '') && Configuration::updateValue('bsmod_pinterest', '') && Configuration::updateValue('bsmod_google', '') && Configuration::updateValue('bsmod_vimeo', '') && Configuration::updateValue('bsmod_instagram', '') && Configuration::updateValue('bsmod_tumblr', '') && $this->registerHook('displayHeader')  && $this->registerHook('displayNav')  && $this->registerHook('displayMaintenance') && $this->registerHook('displayFooter'));
	}

	public function uninstall() {
		$this->_clearCache('blocksocial_mod.tpl');
		//Delete configuration
		return (Configuration::deleteByName('bsmod_hook') AND Configuration::deleteByName('bsmod_facebook') AND Configuration::deleteByName('bsmod_twitter') AND Configuration::deleteByName('bsmod_flickr')  AND Configuration::deleteByName('bsmod_vimeo') AND Configuration::deleteByName('bsmod_youtube') AND Configuration::deleteByName('bsmod_pinterest') AND Configuration::deleteByName('bsmod_rss') AND Configuration::deleteByName('bsmod_google') AND Configuration::deleteByName('bsmod_instagram') AND Configuration::deleteByName('bsmod_tumblr') AND parent::uninstall());
	}

	public function getContent() {
		// If we try to update the settings
		$output = '';
		if (isset($_POST['submitModule'])) {
			Configuration::updateValue('bsmod_hook', Tools::getValue('bsmod_hook'));  
			Configuration::updateValue('bsmod_facebook', Tools::getValue('bsmod_facebook', ''));  
			Configuration::updateValue('bsmod_twitter', Tools::getValue('bsmod_twitter', ''));  
			Configuration::updateValue('bsmod_rss', Tools::getValue('bsmod_rss', ''));  
			Configuration::updateValue('bsmod_vimeo', Tools::getValue('bsmod_vimeo', '')); 
			Configuration::updateValue('bsmod_youtube', Tools::getValue('bsmod_youtube', '')); 
			Configuration::updateValue('bsmod_pinterest', Tools::getValue('bsmod_pinterest', ''));
			Configuration::updateValue('bsmod_google', Tools::getValue('bsmod_google', '')); 
			Configuration::updateValue('bsmod_instagram', Tools::getValue('bsmod_instagram', '')); 
			Configuration::updateValue('bsmod_tumblr', Tools::getValue('bsmod_tumblr', ''));
			Configuration::updateValue('bsmod_flickr', Tools::getValue('bsmod_flickr', ''));    
			$this->_clearCache('blocksocial_mod.tpl');
			$this->_clearCache('blocksocial_mod_maintance.tpl');
			$this->_clearCache('blocksocial_mod_nav.tpl');
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'&conf=4&module_name='.$this->name);
		
		}

		return $output.$this->renderForm();

	}

	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'select',
						'label' => $this->l('Hook'),
						'name' => 'bsmod_hook',
						'desc' => $this->l('Select where to show module'),
						'options' => array(
							'query' => array(
							array(
								'id_option' => 0,
								'name' => $this->l('Footer')
								),
							array(
								'id_option' => 1,
								'name' => $this->l('displayNav(top bar)')
								),
							array(
								'id_option' => 2,
								'name' => $this->l('Footer & top bar')
								),
							),
							'id' => 'id_option',
							'name' => 'name'
							)
						),
					array(
						'type' => 'text',
						'label' => $this->l('Facebook URL'),
						'name' => 'bsmod_facebook',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('Your Facebook fan page.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Twitter URL'),
						'name' => 'bsmod_twitter',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('Your official Twitter accounts.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('RSS URL'),
						'name' => 'bsmod_rss',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('The RSS feed of your choice (your blog, your store, etc.).'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Vimeo URL'),
						'name' => 'bsmod_vimeo',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('Your official Vimeo account.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('YouTube URL'),
						'name' => 'bsmod_youtube',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('Your official YouTube account.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Flickr URL'),
						'name' => 'bsmod_flickr',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('Your official Flickr account.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Pinterest URL:'),
						'name' => 'bsmod_pinterest',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('Your official Pinterest account.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Google Plus URL:'),
						'name' => 'bsmod_google',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('You official Google Plus page.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Instagram URL:'),
						'name' => 'bsmod_instagram',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('You official Instagram page.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Tumblr url'),
						'name' => 'bsmod_tumblr',
						'hint' => $this->l('Please enter full url with http://'),
						'desc' => $this->l('You official Tumblr url page.'),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);
		
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}
	
	public function getConfigFieldsValues()
	{
		return array(
			'bsmod_hook' => Tools::getValue('bsmod_hook', Configuration::get('bsmod_hook')),
			'bsmod_facebook' => Tools::getValue('bsmod_facebook', Configuration::get('bsmod_facebook')),
			'bsmod_twitter' => Tools::getValue('bsmod_twitter', Configuration::get('bsmod_twitter')),
			'bsmod_rss' => Tools::getValue('bsmod_rss', Configuration::get('bsmod_rss')),
			'bsmod_vimeo' => Tools::getValue('bsmod_vimeo', Configuration::get('bsmod_vimeo')),
			'bsmod_youtube' => Tools::getValue('bsmod_youtube', Configuration::get('bsmod_youtube')),
			'bsmod_pinterest' => Tools::getValue('bsmod_pinterest', Configuration::get('bsmod_pinterest')),
			'bsmod_google' => Tools::getValue('bsmod_google', Configuration::get('bsmod_google')),
			'bsmod_flickr' => Tools::getValue('bsmod_flickr', Configuration::get('bsmod_flickr')),
			'bsmod_instagram' => Tools::getValue('bsmod_instagram', Configuration::get('bsmod_instagram')),
			'bsmod_tumblr' => Tools::getValue('bsmod_tumblr', Configuration::get('bsmod_tumblr'))
	
		);
	}

	public function hookDisplayHeader() {
		$this->context->controller->addCSS(($this->_path).'blocksocial_mod.css', 'all');
	}

	public function hookdisplayMaintenance() {

		if (!$this->isCached('blocksocial_mod_maintance.tpl', $this->getCacheId())) {
			global $smarty;

			$smarty->assign(array('facebook_url' => Configuration::get('bsmod_facebook'), 'flickr_url' => Configuration::get('bsmod_flickr'),  'twitter_url' => Configuration::get('bsmod_twitter'), 'youtube_url' => Configuration::get('bsmod_youtube'), 'pinterest_url' => Configuration::get('bsmod_pinterest'), 'google_url' => Configuration::get('bsmod_google'), 'vimeo_url' => Configuration::get('bsmod_vimeo'), 'instagram_url' => Configuration::get('bsmod_instagram'), 'tumblr_url' => Configuration::get('bsmod_tumblr'), 'rss_url' => Configuration::get('bsmod_rss')));

		}
		return $this->display(__FILE__, 'blocksocial_mod_maintance.tpl', $this->getCacheId());
	}

	public function hookDisplayLeftColumn() {
		return $this->hookDisplayFooter();
	}

	public function hookdisplayAdditionalFooter($params){
			return $this->hookDisplayFooter();
	}

	public function hookTop() {
		return $this->hookDisplayFooter();
	}

	public function hookDisplayNav($params) {
		if(Configuration::get('bsmod_hook'))
    	{
		if (!$this->isCached('blocksocial_mod_nav.tpl', $this->getCacheId())) {
			global $smarty;

			$smarty->assign(array('facebook_url' => Configuration::get('bsmod_facebook'), 'flickr_url' => Configuration::get('bsmod_flickr'), 'twitter_url' => Configuration::get('bsmod_twitter'), 'youtube_url' => Configuration::get('bsmod_youtube'), 'pinterest_url' => Configuration::get('bsmod_pinterest'), 'google_url' => Configuration::get('bsmod_google'), 'vimeo_url' => Configuration::get('bsmod_vimeo'), 'instagram_url' => Configuration::get('bsmod_instagram'), 'tumblr_url' => Configuration::get('bsmod_tumblr'), 'rss_url' => Configuration::get('bsmod_rss')));

		}
		return $this->display(__FILE__, 'blocksocial_mod_nav.tpl', $this->getCacheId());
		}
	}

	public function hookDisplayFooter() {
		
		$hook = Configuration::get('bsmod_hook');
		
		if($hook == 0 || $hook == 2)
    	{

		if (!$this->isCached('blocksocial_mod.tpl', $this->getCacheId())) {
			global $smarty;

			$smarty->assign(array('facebook_url' => Configuration::get('bsmod_facebook'), 'flickr_url' => Configuration::get('bsmod_flickr'), 'twitter_url' => Configuration::get('bsmod_twitter'), 'youtube_url' => Configuration::get('bsmod_youtube'), 'pinterest_url' => Configuration::get('bsmod_pinterest'), 'google_url' => Configuration::get('bsmod_google'), 'vimeo_url' => Configuration::get('bsmod_vimeo'), 'instagram_url' => Configuration::get('bsmod_instagram'), 'tumblr_url' => Configuration::get('bsmod_tumblr'), 'rss_url' => Configuration::get('bsmod_rss')));

		}
		return $this->display(__FILE__, 'blocksocial_mod.tpl', $this->getCacheId());
		}
	}

}
?>
