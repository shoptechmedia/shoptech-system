var c = 0;
var TicketCount = 0;

var STME_Form = function(_Form){
	var that = this;

	that._fields = {};

	that._fieldValues = {};

	var configuration_form = $('#configuration_form');

	that.renderForm = function(form_id){

		var inputFields = [];

		var dateContainer = document.getElementById('start_date').parentNode.parentNode.parentNode.parentNode;

		var fieldSet = document.createElement('fieldset');

		var close = document.createElement('span');
			close.className = 'STMClose fa fa-close';

			close.onclick = function(){
				$(this.parentNode).remove();
			}

			fieldSet.appendChild(close);

		for(name in that._fields){
			c++;

			var parameters = that._fields[name];

			if(parameters.type == 'datetime'){
				var fieldContainer = dateContainer.cloneNode(1);
					fieldContainer.removeAttribute('id');
					fieldContainer.removeAttribute('style');

				var field = fieldContainer.querySelector('#start_date');
					field.id = name + c;
					field.name = name;
					field.classList.remove('hasDatepicker');

					field.name = form_id + '[' + field.name + '][]';

					if(typeof parameters.form != 'undefined'){
						field.setAttribute('form', parameters.form);
					}

				var fieldLabel = fieldContainer.querySelector('label');
					fieldLabel.textContent = parameters.label;
			}else{
				if(parameters.type == 'textarea'){
					var field = document.createElement('textarea');
						field.name = name;
						field.className = 'autoload_rte autoload_rte_2';
				}else{
					var field = document.createElement('input');
						field.type = parameters.type;
						field.name = name;
				}

					inputFields.push(field);

				var fieldInputContainer = document.createElement('div');
					fieldInputContainer.className = 'col-lg-9';
					fieldInputContainer.appendChild(field);

					if(field.type == 'file'){
						var eventImage = document.createElement('img');
							eventImage.src = that._fieldValues[field.name];

						if(typeof that._fieldValues[field.name] != 'undefined'){
							eventImage.style.maxHeight = '125px';
						}

						field.onchange = function(inputField){
							var reader = new FileReader();

								reader.onload = function(){
									eventImage.src = reader.result;
								};

								reader.readAsDataURL(inputField.target.files[0]);
						}

						fieldInputContainer.appendChild(eventImage);
					}else{
						if(typeof that._fieldValues[field.name] != 'undefined'){
							if(parameters.type == 'textarea'){
								field.innerHTML = that._fieldValues[field.name];
							}else{
								field.value = that._fieldValues[field.name];
							}
						}
					}

				field.name = form_id + '[' + field.name + '][]';

				if(typeof parameters.form != 'undefined'){
					field.setAttribute('form', parameters.form);
				}

				var fieldLabel = document.createElement('label');
					fieldLabel.textContent = parameters.label;
					fieldLabel.className = 'control-label col-lg-3 required';

				var fieldContainer = document.createElement('div');
					fieldContainer.className = 'form-group stmeField';
					fieldContainer.appendChild(fieldLabel);
					fieldContainer.appendChild(fieldInputContainer);
			}

			fieldSet.appendChild(fieldContainer);
		}

		_Form.appendChild(fieldSet);

		setTimeout(function(){
			$('.datetimepicker').datetimepicker({
				prevText: '',
				nextText: '',
				dateFormat: 'yy-mm-dd',	
				// Define a custom regional settings in order to use PrestaShop translation tools
				currentText: 'Nu',
				closeText: 'Færdig',
				ampm: false,
				amNames: ['AM', 'A'],
				pmNames: ['PM', 'P'],
				timeFormat: 'hh:mm:ss tt',
				timeSuffix: '',
				timeOnlyTitle: 'Vælg tid',
				timeText: 'Tid',
				hourText: 'Time',
				minuteText: 'Minut',
			});

			tinySetup({
				editor_selector: 'autoload_rte_2',
				setup: function(editor) {
					editor.on('init', function() {
						$('.autoload_rte_2').removeClass('autoload_rte_2');
					});
				}
			});
		}, 100);

		return fieldSet;
	};
};

window.addEventListener('load', function(){
	TicketCount = $('#ticketForm > fieldset').length;
	$('#start_date, #end_date').parent().parent().parent().parent().css({
		position: 'fixed',
		top: '-9999px'
	});

	$('.eventTabs .list-group-item').on({
		click: function(e){
			e.preventDefault();

			var that = this;
			var target = $(that).attr('href');

			$('.eventTabs .list-group-item.active').removeClass('active');
			$('.event-tab-content.active').removeClass('active');

			this.classList.add('active');
			document.querySelector(target).classList.add('active');
		}
	});

	$('#configuration_form').attr('action', window.location.href);

	$('.delete_event_image').on('click', function(){
		$('#event_image_visual_aid').remove();
		$(this).remove();

		$.ajax({
			url: window.location.href,
			type: 'POST',
			data: {
				ajax: 1,
				delete_event_image: 1
			}
		});
	});

	$('.AddDate').click(function(){
		var T = $(this).data('t');
		var _Form = this.parentNode;

		var form = new STME_Form(_Form);

			form._fields = {
				reservation_start_date: {
					type: 'datetime',
					label: 'Event Start',
					form: 'configuration_form'
				},

				reservation_end_date: {
					type: 'datetime',
					label: 'Event End',
					form: 'configuration_form'
				},

				available_reservation: {
					type: 'text',
					label: 'Available Reservations',
					form: 'configuration_form'
				}
			};

			form.renderForm('STMTickets[STMDates][' + T + ']').style.border = '1px solid';
	});

	$('#addTicket').on({
		click: function (e){
			var T = TicketCount;
			var _Form = document.getElementById('ticketForm');
			var _Add = document.getElementById('addTicket');

			var ticket = new STME_Form(_Form);

				ticket._fields = {
					name: {
						type: 'text',
						label: 'Ticket Name',
						form: 'configuration_form'
					},

					description: {
						type: 'textarea',
						label: 'Ticket Description',
						form: 'configuration_form'
					},

					price: {
						type: 'text',
						label: 'Ticket Price',
						form: 'configuration_form'
					},

					cover:  {
						type: 'file',
						label: 'Ticket Cover',
						form: 'configuration_form'
					}
				};

			var fieldset = ticket.renderForm('STMTickets');

			var DateSection = document.createElement('div');
				DateSection.className = 'DateSection';

			var addDate = document.createElement('button');
				addDate.textContent = 'Add Date';

				addDate.onclick = function (e){
					var _Form = DateSection;

					var form = new STME_Form(_Form);

						form._fields = {
							reservation_start_date: {
								type: 'datetime',
								label: 'Event Start',
								form: 'configuration_form'
							},

							reservation_end_date: {
								type: 'datetime',
								label: 'Event End',
								form: 'configuration_form'
							},

							available_reservation: {
								type: 'text',
								label: 'Available Reservations',
								form: 'configuration_form'
							}
						};

						form.renderForm('STMTickets[STMDates][' + T + ']').style.border = '1px solid';
				};

				DateSection.appendChild(addDate);

				fieldset.appendChild(DateSection);

			TicketCount++;
		}
	});

	$('.STMClose').click(function(){
		$(this).parent().remove();
	});

	$('.DeleteTicket').click(function(){
		var id_product = $(this).data('id_product');

		$.ajax({
			url: window.location.href,
			data: {
				deleteSTMTicket: 1,
				id_product: id_product
			}
		});
	});

	$('.DeleteDate').click(function(){
		var id_reservation_date = $(this).data('id_reservation_date');

		$.ajax({
			url: window.location.href,
			data: {
				deleteSTMDate: 1,
				id_reservation_date: id_reservation_date
			}
		});
	});

	$('#saveSTMEvent').click(function(){
		$('#configuration_form_submit_btn').click();
	});
});