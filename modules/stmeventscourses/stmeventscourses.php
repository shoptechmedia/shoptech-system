<?php

class stmeventscourses extends Module{
	public $currentDate;

	public $language;

	public $languages;

	public function __construct(){
		$this->name = 'stmeventscourses';
		$this->tab = 'front_office_features';
		$this->version = '0.0.1';
		$this->author = 'Shoptech.media';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->templateDir = __DIR__ . '/templates';

		$this->displayName = $this->l('Shoptech.media Events and Courses');
		$this->description = $this->l('Events and Courses');

	    $this->language = $this->context->language->id;

	    $this->currentDate = $this->context->language->date_format_lite;

		$this->languages = Language::getLanguages(false);

		foreach ($this->languages as $k => $language){
			$this->languages[$k]['is_default'] = (int) ($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
		}

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		$this->prefix = _DB_PREFIX_;

		if(!Configuration::get('stmeventscourses'))
			$this->warning = $this->l('No name provided');

		if(!isset($_SESSION)) {
			session_start();
		}

		$this->l('January');
		$this->l('February');
		$this->l('March');
		$this->l('April');
		$this->l('May');
		$this->l('June');
		$this->l('July');
		$this->l('August');
		$this->l('September');
		$this->l('October');
		$this->l('November');
		$this->l('December');
		$this->l('All Events');

        // $this->registerHook('displayCustomerAccount');
		// exit;
	}

	public function install(){
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (
			!parent::install() ||
			!$this->registerHook('displayTop') ||
			!$this->registerHook('displayHeader') ||
			!$this->registerHook('displayBackOfficeHeader') ||
			!$this->registerHook('moduleRoutes') ||
			!$this->registerHook('displayLeftColumn') ||
			!$this->registerHook('displayRightColumn') ||
			!$this->registerHook('displayOverrideTemplate') ||
			!$this->registerHook('actionCartSummary') ||
			!$this->registerHook('displayOrderConfirmation')
		)
			return false;

		include(__DIR__ . '/sql/install.php');

        $new_root_category = new Category(2);

        unset($new_root_category->id);
        unset($new_root_category->id_category);
        unset($new_root_category->nleft);
        unset($new_root_category->nright);

        foreach ($this->languages as $language) {
            $new_root_category->name[ $language['id_lang'] ] = $this->l('Events Manager');
            $new_root_category->link_rewrite[ $language['id_lang'] ] = 'eventsmanager';
        }

        if(!$new_root_category->add())
            return false;

        Configuration::updateValue('EM_ROOT_CATEGORY_ID', $new_root_category->id);

		return true;
	}

	public function uninstall(){
		if (
			!parent::uninstall()
		)
			return false;

		include(__DIR__ . '/sql/uninstall.php');

		return true;
	}

	private function removeEmptyValues(array &$array){
		foreach ($array as $key => &$value) {
			if (is_array($value)) {
				$value = $this->removeEmptyValues($value);
			}

			if (empty($value)) {
				unset($array[$key]);
			}
		}

		return $array;
	}

	public function getContent(){
		$output = '';

		if(!class_exists('STMEvents'))
			include(dirname(__FILE__) . '/classes/STMEvents.php');

		if(Tools::isSubmit('deleteSTMEvent')){
			$id_stm_event = Tools::getValue('id_stm_event');

			$Event = new STMEvents($id_stm_event);
			$Event->delete();

			$tickets = Db::getInstance()->ExecuteS("
				SELECT id_product FROM {$this->prefix}stm_tickets
				WHERE id_stm_event = '{$id_stm_event}'
			");

			foreach ($tickets as &$ticket) {
				$product = new Product($ticket['id_product']);
				$product->delete();
			}

			header('Location: ?controller=AdminModules&token=' . Tools::getValue('token') . '&configure=stmeventscourses');
			exit;
		}

		if(Tools::isSubmit('deleteSTMTicket')){
			$id_product = Tools::getValue('id_product');

			Db::getInstance()->Execute("
				DELETE FROM {$this->prefix}stm_tickets
				WHERE id_product = '{$id_product}'
			");	

			$product = new Product($id_product);
			$product->delete();

			exit;
		}

		if(Tools::isSubmit('deleteSTMDate')){
			$id_reservation_date = Tools::getValue('id_reservation_date');

			Db::getInstance()->Execute("
				UPDATE {$this->prefix}stm_reservation_dates
				SET deleted = 1
				WHERE id_reservation_date = '{$id_reservation_date}'
			");

			exit;
		}

		if(Tools::isSubmit('saveSTMEvent')){
			$id_stm_event = Tools::getValue('id_stm_event');

			$Event = new STMEvents($id_stm_event);

			$langValue = [];
			foreach ($_POST as $name => $value) {
				if($name == 'submitAddconfiguration' || $name == 'id_stm_event' || $name == 'saveSTMEvent' || $name == 'tab' || $name == 'STMTickets' || $name == 'STMDates' || $name == 'categoryBox')
					continue;

				$langName = '';
				foreach($this->languages as $language){

					if(strpos($name, '_' . $language['id_lang']) !== false){
						$langName = str_replace('_' . $language['id_lang'], '', $name);

						if(!isset($langValue[$langName]))
							$langValue[$langName] = [];

						$langValue[$langName][ $language['id_lang'] ] = $value;
					}

				}

				if($langValue[$langName]){
					$Event->{$langName} = $langValue[$langName];
				}else{
					$Event->{$name} = $value;
				}

			}

			$Event->link_rewrite = [];
			foreach($Event->name as $id_lang => $name){
				$Event->link_rewrite[$id_lang] = Tools::str2url($name);
			}

			if(Tools::isSubmit('categoryBox')){
				$Event->event_categories = implode(',', Tools::getValue('categoryBox'));
			}

			// $Event->price = array_sum($_POST['STMTickets']['price']);

			if($id_stm_event){
				$Event->update();
			}else{
				$Event->add();
			}

			if(isset($Event->id) && $Event->id > 0) {
				if(isset($_FILES['event_image']) && !empty($_FILES['event_image']['name'])){
					$uploader = new Uploader('event_image');
					$ext = explode('.', $_FILES['event_image']['name']);
					$ext = $ext[count($ext) - 1];

					$dest = 'STMEvents-' . $Event->id_product . '.' . $ext; // time()

					$files = $uploader->process($dest);

					Db::getInstance()->execute("
						UPDATE {$this->prefix}stm_events SET event_image = '{$dest}'
						WHERE id_stm_event = {$Event->id}
					");
				}

				if(Tools::isSubmit('STMTickets')){
					foreach ($_POST['STMTickets']['name'] as $index => $name) {
						$price = $_POST['STMTickets']['price'][$index];
						$id_product = $_POST['STMTickets']['id_product'][$index];
						$description = $_POST['STMTickets']['description'][$index];

						$product = new Product($id_product);

						$product->id_tax_rules_group = 2;
						$product->price = $price * 0.8;
						$product->is_virtual = 1;

						$product->name = [];
						$product->link_rewrite = [];

						foreach($this->languages as $language) {
							$product->name[ $language['id_lang'] ] = $name;
							$product->link_rewrite[ $language['id_lang'] ] = Tools::str2url($name);
							$product->description[ $language['id_lang'] ] = $description;
						}

						if($id_product){
							$product->update();
						}else{
							$product->add();
						}

						if($product->id){
							$Event->addPackProduct($product->id);
							$product->addToCategories(explode(',', $Event->event_categories));

							Db::getInstance()->execute("UPDATE `pspeed_stock_available` SET `out_of_stock` = '1' WHERE `pspeed_stock_available`.`id_product` = '{$product->id}'");

							$type = $_FILES['STMTickets']['type']['cover'][$index];
							$tmp_name = $_FILES['STMTickets']['tmp_name']['cover'][$index];
							$img_name = $_FILES['STMTickets']['name']['cover'][$index];
							$error = $_FILES['STMTickets']['error']['cover'][$index];
							$size = $_FILES['STMTickets']['size']['cover'][$index];

							if($img_name){
								$ext = explode('.', $img_name);
								$ext = $ext[count($ext) - 1];

								if($ext == 'jpg' || $ext == 'gif' || $ext == 'png'){
									$ticketImageName = 'STMTickets-' . $product->id . '.' . $ext;

									$dest = _PS_UPLOAD_DIR_ . $ticketImageName;

									if(file_exists($dest)) {
										chmod($dest, 0755);

										unlink($dest); //remove the file
									}

									$upload = move_uploaded_file($tmp_name, $dest);
									Db::getInstance()->execute("
										UPDATE {$this->prefix}stm_tickets
										SET cover = '{$ticketImageName}'
										WHERE id_stm_event = '{$Event->id}' AND id_product = '{$product->id}'
									");

									$image = new Image();
									$image->id_product = $product->id;
									$image->position = Image::getHighestPosition($product->id) + 1;
									$image->cover = true;

									if (($image->validateFields(false, true)) === true && ($image->validateFieldsLang(false, true)) === true && $image->add()){
										if (!AdminImportController::copyImg($product->id_product, $image->id, 'http://' . $_SERVER['HTTP_HOST'] . '/upload/' . $ticketImageName, 'products', false)){
											$image->delete();
										}
									}
								}
							}

							if(!$id_product){
								Db::getInstance()->execute("
									INSERT INTO {$this->prefix}stm_tickets (id_stm_event, id_product, cover)
										VALUES ('{$Event->id}', '{$product->id}', '{$ticketImageName}')
								");
							}

							// Save Course Dates
							$STMDates = $_POST['STMTickets']['STMDates'][$index];

							foreach ($STMDates['reservation_start_date'] as $index => $reservation_start_date) {
								$reservation_end_date = $STMDates['reservation_end_date'][$index];
								$available_reservation = $STMDates['available_reservation'][$index];
								$id_reservation_date = $STMDates['id_reservation_date'][$index];

								if($id_reservation_date){
									Db::getInstance()->execute("
										UPDATE {$this->prefix}stm_reservation_dates 

										SET id_stm_event = '{$Event->id}',
											id_stm_ticket = '{$product->id}',
											start_date = '{$reservation_start_date}',
											end_date = '{$reservation_end_date}',
											available_reservation = {$available_reservation}

										WHERE id_reservation_date = '{$id_reservation_date}'
									");
								}else{
									Db::getInstance()->execute("
										INSERT INTO {$this->prefix}stm_reservation_dates (id_stm_event, id_stm_ticket, start_date, end_date, available_reservation)
											VALUES ('{$Event->id}', '{$product->id}', '{$reservation_start_date}', '{$reservation_end_date}', {$available_reservation})
									");
								}
							}
						}
					}
				}
			}

			if($id_stm_event){
				header('Refresh: 0');
			}else{
				header('Location: ?controller=AdminModules&token=' . Tools::getValue('token') . '&configure=stmeventscourses');
			}
			exit;

		}elseif(Tools::isSubmit('addSTMEvent') || Tools::isSubmit('editSTMEvent')){
			$id_stm_event = Tools::getValue('id_stm_event');

			if($id_stm_event){
				$Event = new STMEvents($id_stm_event);
				$tickets = Db::getInstance()->ExecuteS("
					SELECT * FROM {$this->prefix}stm_tickets
					WHERE id_stm_event = '{$id_stm_event}'
				");

				foreach ($tickets as &$ticket) {
					$product = new Product($ticket['id_product']);

					$ticket['price'] = $product->price;
					$ticket['name'] = $product->name[$this->context->language->id];
					$ticket['description'] = $product->description[$this->context->language->id];
					$ticket['cover'] = '/upload/' . $ticket['cover'];

					$ticket['dates'] = Db::getInstance()->ExecuteS("
						SELECT * FROM {$this->prefix}stm_reservation_dates
						WHERE id_stm_event = '{$id_stm_event}' AND id_stm_ticket = '{$product->id}' AND deleted = 0
					");
				}

				$reservations = Db::getInstance()->ExecuteS("
					SELECT pl.product_id, stm_rd.id_stm_ticket, c.id_customer, c.firstname, c.lastname, c.email, pl.product_name as name, stm_rd.start_date, stm_rd.end_date FROM {$this->prefix}stm_reservations as stm_r
					LEFT JOIN {$this->prefix}stm_reservation_dates as stm_rd ON (stm_r.id_reservation_date = stm_rd.id_reservation_date)
					INNER JOIN {$this->prefix}customer as c ON (c.id_customer = stm_r.id_customer)
					INNER JOIN {$this->prefix}order_detail as pl ON (pl.id_order_detail = stm_r.id_order_detail)
					WHERE stm_rd.id_stm_event = '{$id_stm_event}'
				");

				foreach ($reservations as &$reservation) {
					if(Pack::isPack($reservation['product_id'])){
						$p = new Product($reservation['id_stm_ticket']);
						$reservation['name'] = $p->name[$this->context->language->id];
					}
				}

				$this->context->smarty->assign([
					'Event' => $Event,
					'link' => $this->context->link,
					'tickets' => $tickets,
					'reservations' => $reservations
				]);
			}

			$output .= '<div class="clearfix">';

				$output .= $this->display(__FILE__, 'views/templates/admin/tabs.tpl');

				$output .= '<div class="form-horizontal">';

					$output .= '<div id="Informations" class="event-tab-content active">';
						$output .= $this->renderForm(); // configuration_form
					$output .= '</div>';

					$output .= '<div id="Tickets" class="event-tab-content">';
						$output .= $this->display(__FILE__, 'views/templates/admin/tickets.tpl');
					$output .= '</div>';

					$output .= '<div id="Reservations" class="event-tab-content">';
						$output .= $this->display(__FILE__, 'views/templates/admin/reservations.tpl');
					$output .= '</div>';

				$output .= '</div>';

			// $output .= '</div>';

		}else{
			$output .= $this->renderView();
		}

		return $output;
	}

	public function renderView(){
		$events = Db::getInstance()->ExecuteS("
			SELECT stm_e.id_stm_event, stm_e.active, stm_e.start_date, stm_el.name, stm_el.link_rewrite FROM {$this->prefix}stm_events as stm_e
			INNER JOIN {$this->prefix}stm_events_lang as stm_el ON (stm_el.id_stm_event = stm_e.id_stm_event AND stm_el.id_lang = {$this->context->language->id})
		");

		$tickets = Db::getInstance()->ExecuteS("
			SELECT * FROM {$this->prefix}stm_tickets
		");

		$EventCourses = [];
		foreach ($tickets as &$ticket) {
			$product = new Product($ticket['id_product']);

			$ticket['price'] = $product->price;
			$ticket['name'] = $product->name[$this->context->language->id];
			$ticket['cover'] = '/upload/' . $ticket['cover'];

			$ticket['dates'] = Db::getInstance()->ExecuteS("
				SELECT * FROM {$this->prefix}stm_reservation_dates
				WHERE id_stm_ticket = '{$ticket['id_product']}' AND deleted = 0
			");

			if(!$EventCourses[ $ticket['id_stm_event'] ])
				$EventCourses[ $ticket['id_stm_event'] ] = [];

			$EventCourses[ $ticket['id_stm_event'] ][] = $ticket;
		}

		foreach ($events as &$event) {
			$event['courses'] = $EventCourses[ $event['id_stm_event'] ];
		}

		$this->context->smarty->assign([
			'events' => $events
		]);

		return $this->display(__FILE__, 'views/templates/admin/form.tpl');
	}

	public function renderForm(){
        $form = $this->context->controller;
		$id_stm_event = Tools::getValue('id_stm_event');

		$input_fields = [];

        if($id_stm_event){
			$Event = new STMEvents($id_stm_event);
        }

		// custom template
		$input_fields[] = [
			'type'     => 'hidden',
			'name'     => 'id_stm_event',
			'lang'     => false,
			'required' => false
		];

		$input_fields[] = [
			'type'     => 'switch',
			'label'    => $this->l('Status'),
			'name'     => 'active',
			'values'   => [
				[
					'value' => '1'
				],

				[
					'value' => '0'
				]
			]
		];

		$input_fields[] = [
			'type'     => 'switch',
			'label'    => $this->l('Buy as pack?'),
			'name'     => 'buy_pack',
			'values'   => [
				[
					'value' => '1'
				],

				[
					'value' => '0'
				]
			]
		];

		$input_fields[] = [
			'type'     => 'switch',
			'label'    => $this->l('Buy Individually?'),
			'name'     => 'buy_one',
			'values'   => [
				[
					'value' => '1'
				],

				[
					'value' => '0'
				]
			]
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Name'),
			'name'     => 'name',
			'id'       => 'name', // for copyMeta2friendlyURL compatibility
			'lang'     => true,
			'required' => true,
			'class'    => 'copyMeta2friendlyURL',
			'hint'     => $this->l('Invalid characters:').' &lt;&gt;;=#{}',
		];

		$input_fields[] = [
			'type'         => 'textarea',
			'label'		   => $this->l('Description'),
			'name'         => 'description',
			'autoload_rte' => true,
			'lang'         => true,
			'rows'         => 5,
			'cols'         => 40,
			'hint'         => $this->l('Invalid characters:').' <>;=#{}'
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Meta Title'),
			'name'     => 'meta_title',
			'id'       => 'meta_title', // for copyMeta2friendlyURL compatibility
			'maxchar'  => 70,
			'lang'     => true,
			'rows'     => 5,
			'cols'     => 100,
			'hint'     => $this->l('Forbidden characters:').' <>;=#{}'
		];

		$input_fields[] = [
			'type'         => 'textarea',
			'label'		   => $this->l('Meta Description'),
			'name'         => 'meta_description',
			'maxchar' => 160,
			'lang'         => true,
            'rows'    	   => 5,
            'cols'	       => 100,
			'hint'         => $this->l('Invalid characters:').' <>;=#{}'
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Price'),
			'name'     => 'price',
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Venue'),
			'name'     => 'venue',
		];

		$input_fields[] = [
			'type'     => 'datetime',
			'label'    => $this->l('Start Time'),
			'name'     => 'start_date',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'datetime',
			'label'    => $this->l('End Time'),
			'name'     => 'end_date',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Cancelation Before'),
			'name'     => 'cancelation_period',
		];

		$input_fields[] = [
			'type'     => 'file',
			'label'    => $this->l('Image'),
			'name'     => 'event_image',
			'required' => true
		];

		if($Event->event_image){
			$input_fields[] = [
				'type'     => 'html',
				'html_content' => '<img id="event_image_visual_aid" src="/upload/' . $Event->event_image . '" alt="" width="150"/><a href="javascript:;" class="delete_event_image"><i class="process-icon-delete"></i></a>'
			];
		}

		$input_fields[] = [
			'type'     => 'text',
			'label'    => $this->l('Youtube Video'),
			'name'     => 'youtube_video',
		];

		$input_fields[] = [
			'type'     => 'hidden',
			'label'    => $this->l('Streaming Start Time'),
			'name'     => 'streaming_start_time',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'hidden',
			'label'    => $this->l('Streaming End Time'),
			'name'     => 'streaming_end_time',
			'required' => true
		];

		$input_fields[] = [
			'type'     => 'hidden',
			'label'    => $this->l('Live Streaming URL'),
			'name'     => 'streaming_url',
		];

		$event_categories = [];
        $form->fields_value = [];
        if($id_stm_event){
			foreach ($input_fields as $index => $input_field) {
				$name = $input_field['name'];
				$form->fields_value[$name] = $Event->{$name};
			}

        	$event_categories = explode(',', $Event->event_categories);
        	$form->fields_value['price'] = Product::getPriceStatic((int) $Event->id_product);
        }

		$input_fields[] = [
			'type'     => 'categories',
			'label'    => $this->l('Event Categories'),
			'required' => true,
			'tree'     => [
				'id' => Configuration::get('EM_ROOT_CATEGORY_ID'),
				'root_category' => Configuration::get('EM_ROOT_CATEGORY_ID'),
				'use_checkbox' => true,

				'selected_categories' => $event_categories
			]
		];

        $form->fields_form = [
            'tinymce' => true,
            'class' => 'hidden',
            'legend'  => [
                'title' => $this->l('Add / Edit Event'),
                'icon'  => 'icon-folder-close',
            ],

            'input'   => $input_fields,

            'submit'  => [
                'title' => $this->l('Save'),
                'name'  => 'saveSTMEvent'
            ]
        ];

        return $form->renderForm();
    }

	public function hookDisplayTop($params) {
		if (!$this->context->cart->id) {
			// echo $this->context->cart->id . "\n";
			// $this->context->cart->save();

			if ($this->context->cart->id){
				// $this->context->cookie->id_cart = (int) $this->context->cart->id;
			}

			// echo $this->context->cart->id;
			// exit;
		}
	}

	public function hookHeader($params){
		if($this->context->controller->php_self == 'order-opc'){
			$this->context->controller->addJS($this->_path.'js/order-opc.js');
			$this->context->controller->addCSS($this->_path.'css/order-opc.css');
		}

		if(Tools::getValue('module') != 'stmeventscourses'){

			if(Tools::getValue('controller') == 'product'){
				$id_product = Tools::getValue('id_product');

				$Event = Db::getInstance()->getRow("
					SELECT stm_e.id_stm_event, stm_el.link_rewrite FROM {$this->prefix}stm_events as stm_e
					INNER JOIN {$this->prefix}stm_tickets as stm_t ON (stm_e.id_stm_event = stm_t.id_stm_event)
					INNER JOIN {$this->prefix}stm_events_lang as stm_el ON (stm_el.id_stm_event = stm_t.id_stm_event AND stm_el.id_lang = {$this->context->language->id})
					WHERE stm_t.id_product = '{$id_product}' OR stm_e.id_product = '{$id_product}'
				");

				if(@$Event['id_stm_event']){
					header("HTTP/1.1 301 Moved Permanently");
					header('Location: /events/' . $Event['id_stm_event'] . '-' . $Event['link_rewrite']);
					exit;
				}
			}

			return false;
		}

		$this->context->controller->addJS($this->_path.'js/script.js');

		$this->context->controller->addCSS($this->_path.'css/style.css');
	}

	public function hookDisplayLeftColumn($params){
		if(Tools::getValue('controller') != 'stmevents')
			return false;

		$categories = Db::getInstance()->ExecuteS("
			SELECT stm_e.id_stm_event, stm_e.active, stm_e.start_date, stm_el.name, stm_el.link_rewrite FROM {$this->prefix}stm_events as stm_e
			INNER JOIN {$this->prefix}stm_events_lang as stm_el ON (stm_el.id_stm_event = stm_e.id_stm_event AND stm_el.id_lang = {$this->context->language->id})
		");

        $id_event_category = Tools::getValue('id_event_category');
        if(!$id_event_category){
            $id_parent = Configuration::get('EM_ROOT_CATEGORY_ID');
        }else{
            $id_parent = Db::getInstance()->getValue("
                SELECT id_parent FROM " . _DB_PREFIX_ . "category
                WHERE id_category = '" . Tools::getValue('id_event_category') . "'
            ");
        }

        $parent = new Category($id_parent, $this->context->language->id, $this->context->shop->id);
        $siblings = Category::getChildren($id_parent, $this->context->language->id);

        if($parent->id_category == 356){
        	$parent->name = $this->l('Events Manager');
        }

        $this->context->smarty->assign([
            'siblings' => $siblings,
            'parent' => $parent
        ]);

		return $this->display(__FILE__, 'views/templates/hook/leftColumn.tpl');
	}

	public function hookDisplayBackOfficeHeader($params){
        Media::addJsDef([
            'event_root_category' => Configuration::get('EM_ROOT_CATEGORY_ID')
        ]);

		$this->context->controller->addJS($this->_path.'js/tab.js');

		if(@$_GET['configure'] == 'stmeventscourses'){
			$this->context->controller->addJS($this->_path.'js/admin.js');

			$this->context->controller->addCSS($this->_path.'css/admin.css');
		}
	}

	public function hookDisplayOverrideTemplate($params){

	}

	public function hookModuleRoutes($params){
		$stmevents = array(
			'stmeventscourses_reservations' => array(
				'controller' => 'reservations',

				'rule' => 'reservations',

				'keywords' => array(
				),

				'params' => array(
					'fc' => 'module',
					'module' => 'stmeventscourses'
				)
			),

			'stmeventscourses_all' => array(
				'controller' => 'stmevents',

				'rule' => 'events',

				'keywords' => array(
				),

				'params' => array(
					'fc' => 'module',
					'module' => 'stmeventscourses'
				)
			),

			'stmeventscourses_category' => array(
				'controller' => 'stmevents',

				'rule' => 'event-category/{id}-{rewrite}',

				'keywords' => array(
					'id' => array('regexp' => '[0-9]+', 'param' => 'id_event_category'),

	                'rewrite' => [
	                    'regexp' => '[_a-zA-Z0-9\pL\pS-]*',
	                    'param' => 'link_rewrite',
	                ],
				),

				'params' => array(
					'fc' => 'module',
					'module' => 'stmeventscourses'
				)
			),

			'stmeventscourses_pages' => array(
				'controller' => 'stmevents',

				'rule' => 'events/{id}-{rewrite}',

				'keywords' => array(
					'id' => array('regexp' => '[0-9]+', 'param' => 'id_events'),

					'rewrite' => [
						'regexp' => '[_a-zA-Z0-9\pL\pS-]*',
						'param' => 'link_rewrite',
					],
				),

				'params' => array(
					'fc' => 'module',
					'module' => 'stmeventscourses'
				)
			)
		);

		return $stmevents;
	}

	public function hookDisplayOrderConfirmation($params){
		$order = $params['objOrder'];

		$products = $order->getProducts();

		$id_cart = (int) $order->id_cart;
		$id_customer = (int) $this->context->customer->id;

		$idCartReserved = (bool) Db::getInstance()->getValue("
			SELECT id_reservation FROM pspeed_stm_reservations
			WHERE id_cart = '{$id_cart}'
		");

		if($idCartReserved)
			return false;

		foreach ($products as $product) {
			$id_product = (int) $product['id_product'];

			$isTicket = (bool) Db::getInstance()->getValue("
				SELECT stm_t.id_product FROM {$this->prefix}stm_tickets as stm_t
				WHERE stm_t.id_product = '{$id_product}'
			");

			$isEvent = (bool) Db::getInstance()->getValue("
				SELECT stm_t.id_product FROM {$this->prefix}stm_events as stm_t
				WHERE stm_t.id_product = '{$id_product}'
			");

			if($isTicket || $isEvent){
				$id_order_detail = $product['id_order_detail'];

				if($id_customer){
					$items = Db::getInstance()->executeS("
						SELECT id_item, id_reservation_date FROM {$this->prefix}stm_cart
						WHERE id_cart = '{$id_cart}' AND id_product = '{$product['id_product']}'
						ORDER BY id_item DESC
					");

					foreach($items as $item){
						$split = explode(',', $item['id_reservation_date']);

						foreach($split as $id_reservation_date){

							Db::getInstance()->execute("
								INSERT INTO {$this->prefix}stm_reservations (id_cart, id_order_detail, id_reservation_date, id_customer)
									VALUES ('{$id_cart}', '{$id_order_detail}', '{$id_reservation_date}', '{$id_customer}')
							");

							$currentQuantity = (bool) Db::getInstance()->getValue("
								SELECT stm_rd.available_reservation FROM {$this->prefix}stm_reservation_dates as stm_rd
								WHERE stm_rd.id_reservation_date = '{$id_reservation_date}'
							");

							$newQuantity = $currentQuantity - $product['product_quantity'];

							Db::getInstance()->execute("
								UPDATE {$this->prefix}stm_reservation_dates
								SET available_reservation = '{$newQuantity}'
								WHERE stm_rd.id_reservation_date = '{$id_reservation_date}'
							");

						}
					}
				}
			}
		}
	}

	public function hookDisplayCustomerAccount($params){
		return $this->display(__FILE__, 'views/templates/hook/myaccount.tpl');
	}

	public function hookActionCartSummary($summary){
		$products = $summary['products'];

		$newArray = [];
		$cannotModifyProduct = [];

		foreach ($products as $id => $product) {
			$EventName = (string) Db::getInstance()->getValue("
				SELECT stm_el.name FROM {$this->prefix}stm_tickets as stm_t,
										{$this->prefix}stm_events as stm_e

				INNER JOIN {$this->prefix}stm_events_lang as stm_el ON (stm_el.id_stm_event = stm_e.id_stm_event AND stm_el.id_lang = {$this->context->language->id})

				WHERE (stm_e.id_stm_event = stm_t.id_stm_event AND stm_t.id_product = '{$product['id_product']}') OR stm_e.id_product = '{$product['id_product']}'
			");

			if(!(!$EventName)) {
				$eventImageName = 'STMEvents-' . $product['id_product'] . '.jpg';
				$eventImage = '/upload/' . $eventImageName;

				$cannotModifyProduct[ $product['id_product'] ] = [
					'q' => $product['cart_quantity'],
					'i' => (file_exists(_PS_UPLOAD_DIR_ . $eventImageName)) ? $eventImage : ''
				];

				if(!Pack::isPack($product['id_product'])) {
					$product['name'] = $EventName . ' - ' . $product['name'];
				}

				$items = Db::getInstance()->executeS("
					SELECT id_item, id_reservation_date FROM {$this->prefix}stm_cart
					WHERE id_cart = '{$this->context->cart->id}' AND id_product = '{$product['id_product']}'
					ORDER BY id_item DESC
				");

				$markup = '</a></p><div class="stm_table clearfix">';
				foreach($items as $item){
					$split = explode(',', $item['id_reservation_date']);

					$markup .= '<div class="clearfix stm_item stm_item_' . $item['id_item'] . '"><div class="col-xs-12">&nbsp;</div></div>';

					foreach($split as $i => $id_reservation_date){
						$markup .= '<div class="clearfix stm_item stm_item_' . $item['id_item'] . '">';

						$dates = Db::getInstance()->getRow("
							SELECT id_stm_ticket, start_date, end_date FROM {$this->prefix}stm_reservation_dates
							WHERE id_reservation_date = '{$id_reservation_date}'
						");

						if(Pack::isPack($product['id_product'])) {
							$ticket = new Product($dates['id_stm_ticket']);

							$markup .= '<div class="col-xs-6 col-sm-6">';
								$markup .= $ticket->name[$this->context->language->id];
							$markup .= '</div>';
						}

						$start_date = Tools::displayDate($dates['start_date']);
						$end_date = Tools::displayDate($dates['end_date']);

						$markup .= '<div class="col-xs-6 col-sm-2">';
							$markup .= $start_date;
						$markup .= '</div>';

						$markup .= '<div class="col-xs-6 col-sm-2">';
							$markup .= $end_date;
						$markup .= '</div>';

						if($i == 0){
							$markup .= '<div class="col-xs-6 col-sm-2" style="text-align: center;">';
								$markup .= '<a href="javascript:;" class="stm_hide_mobile deleteSTMCartItem" data-id_item="' . $item['id_item'] . '">' . $this->l('Slet') . '</a>';
							$markup .= '</div>';
						}else{
							$markup .= '<div class="col-xs-6 col-sm-2">&nbsp;</div>';
						}

						$markup .= '</div>';
					}

					$markup .= '<div class="text-center stm_hide_desktop stm_item stm_item_' . $item['id_item'] . '"><div><a href="javascript:;" class="deleteSTMCartItem" data-id_item="' . $item['id_item'] . '">' . $this->l('DELETE') . '</a></div></div>';
				}

				$markup .= '</div>';

				$product['name'] .= $markup;
				$product['noQuantity'] = 1;
			}

			$newArray[] = $product;
		}

		Media::addJsDef([
			'cannotModifyProduct' => $cannotModifyProduct
		]);

		return [
			'products' => $newArray
		];
	}
}