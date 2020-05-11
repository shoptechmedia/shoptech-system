<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class stmeventscoursesreservationsModuleFrontController extends ModuleFrontController{
	public function init(){
		if(!class_exists('STMEvents'))
			include(_PS_MODULE_DIR_ . 'stmeventscourses/classes/STMEvents.php');

		$this->prefix = _DB_PREFIX_;

		$this->display_column_left = false;
		$this->display_column_right = false;

		parent::init();
	}

	public function initContent(){
		parent::initContent();

		if(Tools::isSubmit('STMReschedule')){
			$id_reservation = Tools::getValue('id_reservation');
			$id_reservation_date = Tools::getValue('id_reservation_date');
			$available_reservation = Tools::getValue('available_reservation');

			$previous_date = Db::getInstance()->getValue("
				SELECT id_reservation_date FROM {$this->prefix}stm_reservations
				WHERE id_reservation = '{$id_reservation}'
			");

			$currentQuantity = Db::getInstance()->getValue("
				SELECT stm_rd.available_reservation FROM {$this->prefix}stm_reservation_dates as stm_rd
				WHERE stm_rd.id_reservation_date = '{$previous_date}'
			");

			$newQuantity = $currentQuantity + 1;

			Db::getInstance()->execute("
				UPDATE {$this->prefix}stm_reservation_dates
				SET available_reservation = '{$newQuantity}'
				WHERE id_reservation_date = '{$previous_date}'
			");

			$newQuantity = $available_reservation - 1;

			Db::getInstance()->execute("
				UPDATE {$this->prefix}stm_reservation_dates
				SET available_reservation = '{$newQuantity}'
				WHERE id_reservation_date = '{$id_reservation_date}'
			");

			Db::getInstance()->execute("
				UPDATE {$this->prefix}stm_reservations
				SET id_reservation_date = '{$id_reservation_date}'
				WHERE id_reservation = '{$id_reservation}'
			");

			header('Location: /reservations');
			exit;
		}

		$module = new stmeventscourses();

		$reservations = Db::getInstance()->ExecuteS("
			SELECT pl.product_id, stm_rd.id_stm_ticket, stm_r.id_reservation, stm_el.id_stm_event, stm_e.cancelation_period, stm_el.name as event, stm_el.link_rewrite, pl.product_name as name, pl.product_quantity, stm_rd.id_reservation_date, stm_rd.start_date, stm_rd.end_date FROM {$this->prefix}stm_reservations as stm_r
			INNER JOIN {$this->prefix}stm_reservation_dates as stm_rd ON (stm_r.id_reservation_date = stm_rd.id_reservation_date)
			INNER JOIN {$this->prefix}order_detail as pl ON (pl.id_order_detail = stm_r.id_order_detail)
			INNER JOIN {$this->prefix}stm_events as stm_e ON (stm_e.id_stm_event = stm_rd.id_stm_event)
			INNER JOIN {$this->prefix}stm_events_lang as stm_el ON (stm_el.id_stm_event = stm_rd.id_stm_event AND stm_el.id_lang = '{$this->context->language->id}')
			WHERE stm_r.id_customer = '{$this->context->customer->id}'
		");

		foreach ($reservations as $index => &$reservation) {
			$day = 60 * 60 * 24;
			$timeLimit = $day * $reservation['cancelation_period'];

			$reservation['cancelable'] = true;

			if(strtotime($reservation['start_date']) < time() + $timeLimit){
				$reservation['cancelable'] = false;
			}

			if(Pack::isPack($reservation['product_id'])){
				$p = new Product($reservation['id_stm_ticket']);
				$reservation['name'] = $p->name[$this->context->language->id];
			}

			$reservation['dates'] = Db::getInstance()->ExecuteS("
				SELECT * FROM {$this->prefix}stm_reservation_dates
				WHERE id_stm_event = '{$reservation['id_stm_event']}' AND id_stm_ticket = '{$reservation['id_stm_ticket']}' AND deleted = 0 AND available_reservation > 0
			");
		}

		$this->context->smarty->assign([
			'reservations' => $reservations
		]);

		$this->setTemplate('reservations.tpl');
	}
}