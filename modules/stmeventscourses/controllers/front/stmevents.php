<?php

if (!defined('_PS_VERSION_')){
	exit;
}

class stmeventscoursesstmeventsModuleFrontController extends ModuleFrontController{
	public function init(){
		if(!isset($_SESSION)) {
			session_start();
		}

		if(!class_exists('STMEvents'))
			include(_PS_MODULE_DIR_ . 'stmeventscourses/classes/STMEvents.php');

		$this->prefix = _DB_PREFIX_;

		$this->Event = new STMEvents(Tools::getValue('id_events'), $this->context->language->id);

		$this->display_column_right = false;

		$this->module = new stmeventscourses();

		parent::init();
	}

	public function initContent(){
		parent::initContent();
		$this->Event->price = Product::getPriceStatic((int) $this->Event->id_product);

		$id_event_category = Tools::getValue('id_event_category');

		if(Tools::isSubmit('DeleteSTMCartItem')){
			$id_item = Tools::getValue('id_item');
			$id_product = Db::getInstance()->getValue("
				SELECT id_product FROM {$this->prefix}stm_cart
				WHERE id_item = '{$id_item}'
			");

			$quantity = count(Db::getInstance()->executeS("
				SELECT id_item FROM {$this->prefix}stm_cart
				WHERE id_product = '{$id_product}' AND id_cart = '{$this->context->cart->id}'
			"));

			Db::getInstance()->Execute("
				DELETE FROM {$this->prefix}stm_cart
				WHERE id_item = '{$id_item}'
			");

			$newQuantity = $quantity - 1;

			if($newQuantity <= 0){
				Db::getInstance()->Execute("
					DELETE FROM {$this->prefix}cart_product
					WHERE id_product = '{$id_product}' AND id_cart = '{$this->context->cart->id}'
				");
			}else{
				Db::getInstance()->Execute("
					UPDATE {$this->prefix}cart_product
					SET quantity = '{$newQuantity}'
					WHERE id_product = '{$id_product}' AND id_cart = '{$this->context->cart->id}'
				");
			}

			exit;
		}

		if(Tools::isSubmit('STMReservationDate')){
			$id_product = Tools::getValue('id_product');
			$id_reservation_date = Tools::getValue('STMReservationDate');

			if(is_array($id_reservation_date)){
				$id_reservation_date = implode(',', $id_reservation_date);
			}

			Db::getInstance()->insert(
				'stm_cart',

				[
					'id_cart' => $this->context->cart->id,
					'id_product' => $id_product,
					'id_reservation_date' => $id_reservation_date
				]
			);

			exit;
		}

		if($this->Event->id){
			$id_stm_event = $this->Event->id;

			$tickets = Db::getInstance()->ExecuteS("
				SELECT * FROM {$this->prefix}stm_tickets
				WHERE id_stm_event = '{$id_stm_event}'
			");

			foreach ($tickets as $index => &$ticket) {
				$product = new Product($ticket['id_product']);

				$ticket['isReserved'] = false;
				if($this->context->customer->id <= 0){
					$ticket['isReserved'] = true;
				}

				$ticket['price'] = Product::getPriceStatic($product->id);
				$ticket['name'] = $product->name[$this->context->language->id];
				$ticket['description'] = $product->description[$this->context->language->id];
				$ticket['cover'] = '/upload/' . $ticket['cover'];

				$ticket['dates'] = Db::getInstance()->ExecuteS("
					SELECT * FROM {$this->prefix}stm_reservation_dates
					WHERE id_stm_event = '{$id_stm_event}' AND id_stm_ticket = '{$product->id}' AND deleted = 0
				");

				foreach ($ticket['dates'] as &$date) {
					$start_date = strtotime($date['start_date']);
					$start_date = date('d', $start_date) . ' ' . $this->module->l(date('F', $start_date)) . ' ' . date('Y h:i:s', $start_date);

					$date['start_date'] = $start_date;

					$end_date = strtotime($date['end_date']);
					$end_date = date('d', $end_date) . ' ' . $this->module->l(date('F', $end_date)) . ' ' . date('Y h:i:s', $end_date);

					$date['end_date'] = $end_date;
				}
			}

			// exit;

			if($this->Event->youtube_video){
				$parsed_link = parse_url($this->Event->youtube_video);
				parse_str($parsed_link['query'], $parsed_query);

				$youtube_embed = '<iframe style="width:100%;height:500px;" src="https://www.youtube.com/embed/' . $parsed_query['v'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			}else{
				$youtube_embed = '';
			}

			$this->context->smarty->assign([
				'youtube_embed' => $youtube_embed,
				'tickets' => $tickets,
				'event' => $this->Event,
				'page_title' => $this->Event->name,
				'meta_title' => $this->Event->meta_title,
				'meta_description' => $this->Event->meta_description,
				'isLoggedin' => $this->context->customer->id
			]);

			$this->setTemplate('events_page.tpl');
		}elseif($id_event_category) {
			$category = new Category($id_event_category, $this->context->language->id);

			$events = Db::getInstance()->ExecuteS("
				SELECT stm_e.id_stm_event, stm_e.id_product, stm_e.active, stm_e.start_date, stm_e.event_image, stm_el.name, stm_el.description, stm_el.link_rewrite FROM {$this->prefix}stm_events as stm_e
				INNER JOIN {$this->prefix}stm_events_lang as stm_el ON (stm_el.id_stm_event = stm_e.id_stm_event AND stm_el.id_lang = {$this->context->language->id})
				WHERE stm_e.event_categories LIKE '%{$id_event_category}%'
			");

			$this->context->smarty->assign([
				'events' => $events,
				'page_title' => $category->name
			]);

			$this->setTemplate('events_all.tpl');
		}else{
			$events = Db::getInstance()->ExecuteS("
				SELECT stm_e.id_stm_event, stm_e.id_product, stm_e.active, stm_e.start_date, stm_e.event_image, stm_el.name, stm_el.description, stm_el.link_rewrite FROM {$this->prefix}stm_events as stm_e
				INNER JOIN {$this->prefix}stm_events_lang as stm_el ON (stm_el.id_stm_event = stm_e.id_stm_event AND stm_el.id_lang = {$this->context->language->id})
			");

			$this->context->smarty->assign([
				'events' => $events,
				'page_title' => $this->module->l('All Events')
			]);

			$this->setTemplate('events_all.tpl');
		}
	}
}