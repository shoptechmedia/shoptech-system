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
 * Class AdminNewsletterControllerCore
 *
 * @since 1.0.0
 */
class AdminTicketingControllerCore extends AdminController
{
    /**
     * AdminNewsletterControllerCore constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';
        $this->db = Db::getInstance();
        $this->prefix = _TICKETING_PREFIX_;
        $this->shop_prefix = _DB_PREFIX_;

        $cookie = new Cookie('psAdmin');
        $this->id_agent = $cookie->id_employee;

        parent::__construct();
    }

    /**
     * @return array
     *
     * @since 1.0.0
     */
    protected function getOptionFields()
    {
        
    }

    /**
     * @since 1.0.0
     */
    public function setMedia()
    {
        parent::setMedia();

        $this->addJqueryUI('ui.datepicker');
        $this->addJS(
            [
                _PS_JS_DIR_.'vendor/d3.v3.min.js',
                __PS_BASE_URI__.$this->admin_webpath.'/themes/'.$this->bo_theme.'/js/vendor/nv.d3.min.js',
                _PS_JS_DIR_.'/admin/newsletter.js',
            ]
        );
        $this->addCSS(__PS_BASE_URI__.$this->admin_webpath.'/themes/'.$this->bo_theme.'/css/vendor/nv.d3.css');
    }

    /**
     * @since 1.0.0
     */
    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_title = $this->l('Ticketing');
        /*$this->page_header_toolbar_btn['switch_demo'] = [
            'desc' => $this->l('Demo mode', null, null, false),
            'icon' => 'process-icon-toggle-'.(Configuration::get('PS_DASHBOARD_SIMULATION') ? 'on' : 'off'),
            'help' => $this->l('This mode displays sample data so you can try your dashboard without real numbers.', null, null, false),
        ];*/

        parent::initPageHeaderToolbar();

        // Remove the last element on this controller to match the title with the rule of the others
        array_pop($this->meta_title);
    }

    public function getListAgents(){
        return $this->db->ExecuteS("
            SELECT u.id_employee as id, CONCAT(u.firstname, ' ', u.lastname) as name FROM {$this->shop_prefix}employee as u
            ORDER BY u.id_employee ASC
        ");
    }

    public function getListPriority(){
        return $this->db->ExecuteS("
            SELECT tp.id, tp.description as name FROM {$this->prefix}ticket_priority as tp
            ORDER BY tp.id ASC
        ");
    }

    public function getListStatus(){
        return $this->db->ExecuteS("
            SELECT ts.id, ts.description as name FROM {$this->prefix}ticket_status as ts
            ORDER BY ts.sort_order ASC
        ");
    }

    public function getListType(){
        return $this->db->ExecuteS("
            SELECT tt.id, tt.description as name FROM {$this->prefix}ticket_type as tt
            WHERE tt.is_active = 1
            ORDER BY tt.id ASC
        ");
    }

    public function getListGroup(){
        return $this->db->ExecuteS("
            SELECT sg.id, sg.name FROM {$this->prefix}support_group as sg
            WHERE sg.is_active = 1
            ORDER BY sg.id ASC
        ");
    }

    public function getListTeam(){
        return $this->db->ExecuteS("
            SELECT st.id, st.name FROM {$this->prefix}support_team as st
            WHERE st.is_active = 1
            ORDER BY st.id ASC
        ");
    }

    public function getCount($page, $status){
        switch ($status) {
            case 'open':
                $id_status = 1;
            break;

            case 'pending':
                $id_status = 2;
            break;

            case 'answered':
                $id_status = 3;
            break;

            case 'resolved':
                $id_status = 4;
            break;

            case 'closed':
                $id_status = 5;
            break;

            case 'spam':
                $id_status = 6;
            break;
            
            default:
                $id_status = 0;
            break;
        }

        $sql = "SELECT COUNT(*) FROM {$this->prefix}ticket\n";

        if($id_status){
            $sql .= "WHERE status_id = '{$id_status}'\n";
        }else{
            $sql .= "WHERE 1=1\n";
        }

        if($page == 'new'){
            $sql .= "AND is_new = 1";
        }

        if($page == 'unassigned'){
            $sql .= "AND agent_id = 0";
        }

        if($page == 'unanswered'){
            $sql .= "AND is_replied = 0";
        }

        if($page == 'mytickets'){
            $sql .= "AND agent_id = '{$this->id_agent}'";
        }

        if($page == 'starred'){
            $sql .= "AND is_starred = 1";
        }

        if($page == 'trashed'){
            $sql .= "AND is_trashed = 1";
        }

        return (int) $this->db->getValue($sql);
    }

    public function getCounting(){
        $counts = [];

        $counts['all'] = $this->getCount('all', 'total');
        $counts['all-open'] = $this->getCount('all', 'open');
        $counts['all-pending'] = $this->getCount('all', 'pending');
        $counts['all-answered'] = $this->getCount('all', 'answered');
        $counts['all-resolved'] = $this->getCount('all', 'resolved');
        $counts['all-closed'] = $this->getCount('all', 'closed');
        $counts['all-spam'] = $this->getCount('all', 'spam');

        $counts['new'] = $this->getCount('new', 'total');
        $counts['new-open'] = $this->getCount('new', 'open');
        $counts['new-pending'] = $this->getCount('new', 'pending');
        $counts['new-answered'] = $this->getCount('new', 'answered');
        $counts['new-resolved'] = $this->getCount('new', 'resolved');
        $counts['new-closed'] = $this->getCount('new', 'closed');
        $counts['new-spam'] = $this->getCount('new', 'spam');

        $counts['unassigned'] = $this->getCount('unassigned', 'total');
        $counts['unassigned-open'] = $this->getCount('unassigned', 'open');
        $counts['unassigned-pending'] = $this->getCount('unassigned', 'pending');
        $counts['unassigned-answered'] = $this->getCount('unassigned', 'answered');
        $counts['unassigned-resolved'] = $this->getCount('unassigned', 'resolved');
        $counts['unassigned-closed'] = $this->getCount('unassigned', 'closed');
        $counts['unassigned-spam'] = $this->getCount('unassigned', 'spam');

        $counts['unanswered'] = $this->getCount('unanswered', 'total');
        $counts['unanswered-open'] = $this->getCount('unanswered', 'open');
        $counts['unanswered-pending'] = $this->getCount('unanswered', 'pending');
        $counts['unanswered-answered'] = $this->getCount('unanswered', 'answered');
        $counts['unanswered-resolved'] = $this->getCount('unanswered', 'resolved');
        $counts['unanswered-closed'] = $this->getCount('unanswered', 'closed');
        $counts['unanswered-spam'] = $this->getCount('unanswered', 'spam');

        $counts['mytickets'] = $this->getCount('mytickets', 'total');
        $counts['mytickets-open'] = $this->getCount('mytickets', 'open');
        $counts['mytickets-pending'] = $this->getCount('mytickets', 'pending');
        $counts['mytickets-answered'] = $this->getCount('mytickets', 'answered');
        $counts['mytickets-resolved'] = $this->getCount('mytickets', 'resolved');
        $counts['mytickets-closed'] = $this->getCount('mytickets', 'closed');
        $counts['mytickets-spam'] = $this->getCount('mytickets', 'spam');

        $counts['starred'] = $this->getCount('starred', 'total');
        $counts['starred-open'] = $this->getCount('starred', 'open');
        $counts['starred-pending'] = $this->getCount('starred', 'pending');
        $counts['starred-answered'] = $this->getCount('starred', 'answered');
        $counts['starred-resolved'] = $this->getCount('starred', 'resolved');
        $counts['starred-closed'] = $this->getCount('starred', 'closed');
        $counts['starred-spam'] = $this->getCount('starred', 'spam');

        $counts['trashed'] = $this->getCount('trashed', 'total');
        $counts['trashed-open'] = $this->getCount('trashed', 'open');
        $counts['trashed-pending'] = $this->getCount('trashed', 'pending');
        $counts['trashed-answered'] = $this->getCount('trashed', 'answered');
        $counts['trashed-resolved'] = $this->getCount('trashed', 'resolved');
        $counts['trashed-closed'] = $this->getCount('trashed', 'closed');
        $counts['trashed-spam'] = $this->getCount('trashed', 'spam');

        return $counts;
    }

    /**
     * @return string
     *
     * @since 1.0.0
     */
    public function renderView()
    {
        if (Tools::isSubmit('profitability_conf')) {
            return parent::renderOptions();
        }

        $action = Tools::getValue('action', 'list');

        /** GLOBAL DATA START **/

        $agents = $this->getListAgents();
        $priorities = $this->getListPriority();
        $statuses = $this->getListStatus();
        $types = $this->getListType();
        $groups = $this->getListGroup();
        $teams = $this->getListTeam();

        $this->context->smarty->assign(
            [
                'agents' => $agents,
                'priorities' => $priorities,
                'statuses' => $statuses,
                'types' => $types,
                'groups' => $groups,
                'teams' => $teams,
            ]
        );

        /** GLOBAL DATA END **/

        switch ($action) {

            case 'forwardReply':

                $id_ticket = Tools::getValue('id_ticket');
                $id_thread = Tools::getValue('id_thread');
                $email = Tools::getValue('email');
                $subject = Tools::getValue('subject');
                $comment = addslashes(Tools::getValue('message'));

                if($email){
                    $template = 'forward_thread';
                    $from = 'support@shoptech.media';
                    $email = 'hr@prestaspeed.dk';

                    $threads = $this->db->ExecuteS("
                        SELECT thread.message FROM {$this->prefix}thread as thread
                        WHERE ticket_id = '{$id_ticket}' AND id <= '{$id_thread}'
                        ORDER BY thread.id DESC
                    ");

                    $messages = '';

                    foreach ($threads as $thread) {
                        $messages .= '<br/><br/><hr/>';

                        $messages .= $thread['message'];
                    }

                    Mail::Send(
                        $this->context->language->id,
                        $template,
                        $subject,
                        [
                            '{messages}' => $messages,
                            '{comment}' => $comment
                        ],
                        $email,
                        null,
                        $from
                    );
                }

                exit;

            break;

            case 'pinReply':
                $id_thread = Tools::getValue('id_thread');

                $isPinned = (int) $this->db->getValue("SELECT is_bookmarked FROM {$this->prefix}thread WHERE id = '{$id_thread}'");

                $new_value = !$isPinned;

                $this->db->Execute("
                    UPDATE {$this->prefix}thread
                    SET is_bookmarked = '{$new_value}'

                    WHERE id = '{$id_thread}'
                ");

                exit;
            break;

            case 'lockReply':
                $id_thread = Tools::getValue('id_thread');

                $isLocked = (int) $this->db->getValue("SELECT is_locked FROM {$this->prefix}thread WHERE id = '{$id_thread}'");

                $new_value = !$isLocked;

                $this->db->Execute("
                    UPDATE {$this->prefix}thread
                    SET is_locked = '{$new_value}'

                    WHERE id = '{$id_thread}'
                ");

                exit;
            break;

            case 'deleteReply':
                $id_thread = Tools::getValue('id_thread');

                $this->db->Execute("
                    DELETE FROM {$this->prefix}thread
                    WHERE id = '{$id_thread}'
                ");

                exit;
            break;

            case 'saveReply': 

                $id_ticket = Tools::getValue('id_ticket');
                $id_user = Tools::getValue('id_user');
                $id_thread = Tools::getValue('id_thread');
                $email = Tools::getValue('email');
                $subject = Tools::getValue('subject');
                $message = addslashes(Tools::getValue('message'));
                $date = date('Y-m-d h:m:s');

                if($id_thread){
                    $this->db->Execute("
                        UPDATE {$this->prefix}thread
                        SET message = '{$message}',
                            updated_at = '{$date}'

                        WHERE id = '{$id_thread}'
                    ");
                }else{
                    $this->db->Execute("
                        INSERT INTO {$this->prefix}thread
                        SET ticket_id = '{$id_ticket}',
                            user_id = '{$id_user}',
                            source = 'website',
                            thread_type = 'reply',
                            created_by = 'agent',
                            message = '{$message}',
                            created_at = '{$date}',
                            updated_at = '{$date}',
                            cc = 'N;',
                            bcc = 'N;',
                            reply_to = 'N;'
                    ");
                }

                if($email){
                    $template = 'forward_thread';
                    $from = 'support@shoptech.media';

                    Mail::Send(
                        $this->context->language->id,
                        $template,
                        $subject,
                        [
                            '{messages}' => '',
                            '{comment}' => $message
                        ],
                        $email,
                        null,
                        $from
                    );
                }

                exit;

            break;

            case 'saveEdit': {

                $id_ticket = Tools::getValue('id_ticket');
                $subaction = Tools::getValue('subaction');
                $value = Tools::getValue('value');

                switch ($subaction) {
                    case 'Ticket-Agent':
                        $this->db->Execute("
                            UPDATE {$this->prefix}ticket
                            SET agent_id = '{$value}'
                            WHERE id = '{$id_ticket}'
                        ");
                    break;

                    case 'Ticket-Status':
                        $this->db->Execute("
                            UPDATE {$this->prefix}ticket
                            SET status_id = '{$value}'
                            WHERE id = '{$id_ticket}'
                        ");
                    break;

                    case 'Ticket-Priority':
                        $this->db->Execute("
                            UPDATE {$this->prefix}ticket
                            SET priority_id = '{$value}'
                            WHERE id = '{$id_ticket}'
                        ");
                    break;

                    case 'Ticket-Type':
                        $this->db->Execute("
                            UPDATE {$this->prefix}ticket
                            SET type_id = '{$value}'
                            WHERE id = '{$id_ticket}'
                        ");
                    break;

                    case 'Ticket-Group':
                        $this->db->Execute("
                            UPDATE {$this->prefix}ticket
                            SET group_id = '{$value}'
                            WHERE id = '{$id_ticket}'
                        ");
                    break;

                    case 'Ticket-Team':
                        /*$this->db->Execute("
                            UPDATE {$this->prefix}ticket
                            SET agent_id = '{$value}'
                            WHERE id = '{$id_ticket}'
                        ");*/
                    break;
                }

                exit;

                break;
            }

            case 'edit':
                $template = 'edit.tpl';

                $id_ticket = Tools::getValue('id_ticket');

                /** TICKET DATA START **/

                $ticket = $this->db->getRow("
                    SELECT t.id as id_ticket, t.subject, t.created_at as date_add, tt.description as type, thread.reply_count, thread.id as id_thread, tp.color_code,
                           t.is_starred, t.source, t.customer_id as id_customer, t.agent_id as id_agent, t.priority_id, t.status_id, t.type_id, t.group_id, ust.supportTeamId as team_id

                    FROM {$this->prefix}ticket as t
                    INNER JOIN {$this->prefix}ticket_type as tt ON (tt.id = t.type_id)
                    LEFT JOIN (SELECT COUNT(id) as reply_count, ticket_id, MAX(id) as id FROM {$this->prefix}thread WHERE thread_type = 'reply' GROUP BY ticket_id) as thread ON (thread.ticket_id = t.id)

                    INNER JOIN {$this->prefix}ticket_priority as tp ON (tp.id = t.priority_id)

                    LEFT JOIN {$this->prefix}user_support_teams as ust ON (ust.userInstanceId = t.agent_id)

                    WHERE t.id = '{$id_ticket}'
                ");

                $user = $this->db->getRow("
                    SELECT *, CONCAT(u.firstname, ' ', u.lastname) as name, u.id_customer as id  FROM {$this->shop_prefix}customer as u
                    WHERE (u.id_customer = '{$ticket['id_customer']}')
                ");

                $agent = $this->db->getRow("
                    SELECT u.*, u.id_employee as id FROM {$this->shop_prefix}employee as u
                    WHERE (u.id_employee = '{$ticket['id_agent']}')
                ");

                $thread = $this->db->ExecuteS("
                    SELECT 
                        thread.id, thread.thread_type as type, thread.user_id as id_user, thread.message, thread.created_at, 
                        IF(thread.created_by = 'agent', CONCAT(e.firstname, ' ', e.lastname), CONCAT(u.firstname, ' ', u.lastname)) as user_name,
                        IF(thread.created_by = 'agent', e.email, u.email) as user_email,
                        thread.is_locked, thread.is_bookmarked FROM {$this->prefix}thread as thread
                    LEFT JOIN {$this->shop_prefix}customer as u ON (thread.user_id = u.id_customer)
                    LEFT JOIN {$this->shop_prefix}employee as e ON (thread.user_id = e.id_employee)
                    WHERE ticket_id = '{$ticket['id_ticket']}'
                    ORDER BY id ASC
                ");

                /** TICKET DATA END **/

                $this->context->smarty->assign(
                    [
                        'ticket' => $ticket,
                        'agent' => $agent,
                        'user' => $user,
                        'thread' => $thread
                    ]
                );
            break;

            case 'isStarred':

                $value = Tools::getValue('value');
                $id_ticket = Tools::getValue('id_ticket');

                $this->db->Execute("
                    UPDATE {$this->prefix}ticket SET is_starred = '{$value}'
                    WHERE id = '{$id_ticket}'
                ");

            break;

            default:
                $page = Tools::getValue('page', 'all');
                $status = Tools::getValue('status', 'open');

                $counts = $this->getCounting();

                $sql = "
                    SELECT t.id as id_ticket, t.subject, CONCAT(u.firstname, ' ', u.lastname) as name, u.email, t.created_at as date_add, tt.description as type, thread.reply_count, CONCAT(agent.firstname, ' ', agent.lastname) as agent, thread.id as id_thread, tp.color_code,
                           t.is_starred, t.source

                    FROM {$this->prefix}ticket as t
                    LEFT JOIN {$this->shop_prefix}customer as u ON (t.customer_id = u.id_customer)
                    INNER JOIN {$this->prefix}ticket_type as tt ON (tt.id = t.type_id)
                    LEFT JOIN (SELECT COUNT(id) as reply_count, ticket_id, MAX(id) as id FROM {$this->prefix}thread WHERE thread_type = 'reply' GROUP BY ticket_id) as thread ON (thread.ticket_id = t.id)

                    INNER JOIN {$this->shop_prefix}employee as agent ON (agent.id_employee = '{$this->id_agent}')

                    INNER JOIN {$this->prefix}ticket_priority as tp ON (tp.id = t.priority_id)
                \n";

                switch ($status) {
                    case 'open':
                        $id_status = 1;
                    break;

                    case 'pending':
                        $id_status = 2;
                    break;

                    case 'answered':
                        $id_status = 3;
                    break;

                    case 'resolved':
                        $id_status = 4;
                    break;

                    case 'closed':
                        $id_status = 5;
                    break;

                    case 'spam':
                        $id_status = 6;
                    break;
                    
                    default:
                        $id_status = 0;
                    break;
                }

                if($id_status){
                    $sql .= "WHERE status_id = '{$id_status}'\n";
                }else{
                    $sql .= "WHERE 1=1\n";
                }

                if($page == 'new'){
                    $sql .= "AND is_new = 1";
                }

                if($page == 'unassigned'){
                    $sql .= "AND agent_id = 0";
                }

                if($page == 'unanswered'){
                    $sql .= "AND is_replied = 0";
                }

                if($page == 'mytickets'){
                    $sql .= "AND agent_id = '{$this->id_agent}'";
                }

                if($page == 'starred'){
                    $sql .= "AND is_starred = 1";
                }

                if($page == 'trashed'){
                    $sql .= "AND is_trashed = 1";
                }

                if(Tools::isSubmit('filter')) {
                    $filter = Tools::getValue('filter');

                    $sql .= "\n";

                    if($filter['id'])
                        $sql .= "AND t.id = '{$filter['id']}'\n";

                    if($filter['subject'])
                        $sql .= "AND t.subject LIKE '%{$filter['subject']}%'\n";

                    if($filter['customer_name'])
                        $sql .= "AND CONCAT(u.firstname, ' ', u.lastname) LIKE '%{$filter['customer_name']}%'\n";

                    if($filter['customer_email'])
                        $sql .= "AND u.email LIKE '%{$filter['customer_email']}%'\n";

                    if($filter['timestamp'])
                        $sql .= "AND t.created_at >= '{$filter['timestamp']}'\n";

                    if($filter['type'])
                        $sql .= "AND tt.description LIKE '%{$filter['type']}%'\n";

                    if($filter['replies'])
                        $sql .= "AND thread.reply_count = '{$filter['replies']}'\n";

                    if($filter['agent'])
                        $sql .= "AND CONCAT(agent.firstname, ' ', agent.lastname) LIKE '%{$filter['agent']}%'\n";

                    if($filter['source'])
                        $sql .= "AND t.source LIKE '%{$filter['source']}%'\n";
                } else {
                    $filter = [
                        'id' => '',
                        'subject' => '',
                        'customer_name' => '',
                        'customer_email' => '',
                        'timestamp' => '',
                        'type' => '',
                        'replies' => '',
                        'agent' => '',
                        'source' => ''
                    ];
                }

                if(!empty($filter['timestamp']))
                    $sql .= "\nORDER BY t.created_at ASC";
                else
                    $sql .= "\nORDER BY thread.id DESC";

                $tickets = $this->db->ExecuteS($sql);

                $this->context->smarty->assign(
                    [
                        'filter' => $filter,
                        'counts' => $counts,
                        'page' => $page,
                        'status' => $status,
                        'tickets' => $tickets
                    ]
                );

                $template = 'tickets.tpl';
            break;
        }

        return $this->createTemplate('controllers/ticketing/' . $template)->fetch();
    }

    public function display()
    {
        if(Tools::isSubmit('content_only')){
            $this->display_header = false;
            // $this->display_header_javascript = false;
            $this->display_footer = false;
        }

        parent::display();
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
                _PS_JS_DIR_.'admin/products.js',
                _PS_JS_DIR_.'admin/attributes.js',
                _PS_JS_DIR_.'admin/price.js',
                _PS_JS_DIR_.'tiny_mce/tiny_mce.js',
                _PS_JS_DIR_.'admin/tinymce.inc.js',
                _PS_JS_DIR_.'admin/dnd.js',
                _PS_JS_DIR_.'jquery/ui/jquery.ui.progressbar.min.js',
                _PS_JS_DIR_.'vendor/spin.js',
                _PS_JS_DIR_.'vendor/ladda.js',
            ]
        );

        $this->addJS(_PS_JS_DIR_.'jquery/plugins/select2/select2_locale_'.$this->context->language->iso_code.'.js');
        $this->addJS(_PS_JS_DIR_.'jquery/plugins/validate/localization/messages_'.$this->context->language->iso_code.'.js');

        $this->addCSS(
            [
                _PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.css',
            ]
        );
    }
}
