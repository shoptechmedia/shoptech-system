<?php
/**
 * 2007-2016 PrestaShop
 *
 * thirty bees is an extension to the PrestaShop e-commerce software developed by PrestaShop SA
 * Copyright (C) 2017-2018 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.thirtybees.com for more information.
 *
 * @author    thirty bees <contact@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2017-2018 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  PrestaShop is an internationally registered trademark & property of PrestaShop SA
 */

/**
 * Class MyAccountControllerCore
 *
 * @since 1.0.0
 */
class MyTicketsControllerCore extends FrontController
{
    // @codingStandardsIgnoreStart
    /** @var bool $auth */
    public $auth = true;
    /** @var string $php_self */
    public $php_self = 'my-tickets';
    /** @var string $authRedirection */
    public $authRedirection = 'my-tickets';
    /** @var bool $ssl */
    public $ssl = true;
    // @codingStandardsIgnoreEnd

    public function __construct(){
        parent::__construct();

        $this->db = Db::getInstance();
        $this->ticket_prefix = _TICKETING_PREFIX_;
        $this->db_prefix = _DB_PREFIX_;
    }

    /**
     * Assign template vars related to page content
     *
     * @see   FrontController::initContent()
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function initContent()
    {
        parent::initContent();

        if(Tools::isSubmit('submitReply')){
            $id_ticket = Tools::getValue('id');
            $message = Tools::getValue('thread_reply');

            $thread = new Thread();
            $thread->ticket_id = $id_ticket;
            $thread->user_id = $this->context->customer->id;
            $thread->source = 'website';
            $thread->thread_type = 'create';
            $thread->created_by = 'customer';
            $thread->message = addslashes($message);
            $thread->created_at = date('Y-m-d h:m:s');
            $thread->updated_at = date('Y-m-d h:m:s');

            $thread->add();

            header('Refresh:0');
            exit;
        }elseif(Tools::isSubmit('id')){

            $id_ticket = Tools::getValue('id');

            $sql = "
                SELECT 
                    thread.id, thread.thread_type as type, thread.user_id as id_user, thread.message, thread.created_at, 
                    IF(thread.created_by = 'agent', CONCAT(e.firstname, ' ', e.lastname), CONCAT(u.firstname, ' ', u.lastname)) as user_name,
                    IF(thread.created_by = 'agent', e.email, u.email) as user_email,
                    thread.is_locked, thread.is_bookmarked FROM {$this->ticket_prefix}thread as thread
                LEFT JOIN {$this->db_prefix}customer as u ON (thread.user_id = u.id_customer)
                LEFT JOIN {$this->db_prefix}employee as e ON (thread.user_id = e.id_employee)
                WHERE ticket_id = '{$id_ticket}'
                ORDER BY id ASC
            ";

            $threads = $this->db->ExecuteS($sql);

            $this->context->smarty->assign([

                'threads' => $threads

            ]);

        }else{
            $sql = "
                SELECT t.id as id_ticket, t.subject, CONCAT(u.firstname, ' ', u.lastname) as name, u.email, t.created_at as date_add, tt.description as type, thread.reply_count, CONCAT(agent.firstname, ' ', agent.lastname) as agent, thread.id as id_thread, tp.color_code,
                       t.is_starred, t.source

                FROM {$this->ticket_prefix}ticket as t
                LEFT JOIN {$this->db_prefix}customer as u ON (t.customer_id = u.id_customer)

                LEFT JOIN (SELECT COUNT(id) as reply_count, ticket_id, MAX(id) as id FROM {$this->ticket_prefix}thread WHERE thread_type = 'reply' GROUP BY ticket_id) as thread ON (thread.ticket_id = t.id)

                INNER JOIN {$this->ticket_prefix}ticket_type as tt ON (tt.id = t.type_id)
                INNER JOIN {$this->db_prefix}employee as agent ON (agent.id_employee = t.agent_id)
                INNER JOIN {$this->ticket_prefix}ticket_priority as tp ON (tp.id = t.priority_id)

                WHERE u.id_customer = '{$this->context->customer->id}'
            ";

            $tickets = $this->db->ExecuteS($sql);

            $this->context->smarty->assign([

                'tickets' => $tickets

            ]);
        }

        $this->setTemplate(_PS_THEME_DIR_.'my-tickets.tpl');
    }

    /**
     * @since 1.0.0
     */
    public function postProcess()
    {
        parent::postProcess();

        $this->addJqueryUI(
            [
                'ui.core',
                'ui.widget',
            ]
        );

        $this->addjQueryPlugin(
            [
                'autocomplete',
                'tablednd',
                'thickbox',
                'ajaxfileupload',
                'date',
                'tagify',
                'select2',
                'validate',
            ]
        );

        $this->addJS(
            [
                _PS_JS_DIR_.'tiny_mce/tiny_mce.js',
                _PS_JS_DIR_.'vendor/spin.js',
                _PS_JS_DIR_.'vendor/ladda.js',
                _PS_ALL_THEMES_DIR_.'shoptech/js/tickets.js'
            ]
        );

        $this->addCSS(
            [
                _PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.css',
            ]
        );
    }
}
