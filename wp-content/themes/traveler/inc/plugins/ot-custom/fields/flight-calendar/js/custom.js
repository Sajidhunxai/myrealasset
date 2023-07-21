jQuery(function($){
    $('.date-picker').datepicker({
        language: st_params.locale || '',
        dateFormat: "mm/dd/yy",
        firstDay: 1
    });
    var FlightCalendar = function(container){
        var self = this;
        this.container = container;
        this.calendar= null;
        this.form_container = null;
        this.fullCalendar;
		this.timeOut;
        this.fullCalendarOptions = {
			initialView: 'dayGridMonth',
			firstDay: 1,
			locale: st_params.locale_fullcalendar,
			timeZone: st_timezone.timezone_string,
			customButtons: {
				reloadButton: {
					text: st_params.text_refresh,
					click: function () {
						self.fullCalendar.refetchEvents();
					}
				}
			},
			headerToolbar: {
				start: 'today,reloadButton',
				center: 'title',
				end: 'prev,next'
			},
			displayEventTime: true,
			selectable: true,
			select: function ({
				start,
				end,
				startStr,
				endStr,
				allDay,
				jsEvent,
				view,
				resource
			}) {
				/* info{start, end, startStr, endStr, allDay, jsEvent, view, resource } */
				if (moment(start).isBefore(moment(), 'day') ||
					moment(end).isBefore(moment(), 'day')
				) {
					self.fullCalendar.unselect();
					setCheckInOut("", "", self.form_container);
				} else {
					var zone = moment(start).format("Z");
					zone = zone.split(":");
					zone = "" + parseInt(zone[0]) + ":00";
					var check_in = moment(start).utcOffset(zone).format(String(st_params.dateformat || "MM/DD/YYYY").toUpperCase());
					var check_out = moment(end).utcOffset(zone).subtract(1, 'day').format(String(st_params.dateformat || "MM/DD/YYYY").toUpperCase());
					setCheckInOut(check_in, check_out, self.form_container);
				}
			},
			events: function ({
				start,
				end,
				startStr,
				endStr,
				timeZone
			}, successCallback, failureCallback) {
				$.ajax({
					url: ajaxurl,
					dataType: "json",
					type: "post",
					data: {
						action: "st_get_availability_flight",
						post_id: $(self.container).data("post-id"),
						start: moment(start).unix(),
						end: moment(end).unix()
					},
					success: function (doc) {
						if (typeof doc == "object") {
							successCallback(doc);
						}
					},
					error: function (e) {
						alert(
							"Can not get the availability slot. Lost connect with your sever"
						);
					}
				});
			},
			eventContent: function (arg) {
				/** arg{event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view} */
				let italicEl = document.createElement('i');
				let contentEl = document.createElement('div');
				let priceEl = document.createElement('div');
				let startTimeEl = document.createElement('div');
				contentEl.classList.add('fc-content');
				priceEl.classList.add('price');
				startTimeEl.classList.add('starttime');

				if (arg.event.extendedProps.status) {
					// available, unavailable
					let status = arg.event.extendedProps.status;
					if (status === 'unavailable') {
						contentEl.classList.remove('available');
						contentEl.classList.add('unavailable');
						contentEl.innerHTML = '<div class="not_available">'+st_params.text_unavailable+'</div>';
					} else {
						contentEl.classList.remove('unavailable');
						contentEl.classList.add('available');

                        if (typeof arg.event.extendedProps.eco_price != 'undefined') {
                            let ecoPriceEl = document.createElement('div');
                            ecoPriceEl.classList.add('price');
                            ecoPriceEl.innerHTML = 'Economy:' + arg.event.extendedProps.eco_price;

                            contentEl.appendChild(ecoPriceEl)
                        }

                        if (typeof arg.event.extendedProps.business_price != 'undefined') {
                            let businessPriceEl = document.createElement('div');
                            businessPriceEl.classList.add('price');
                            businessPriceEl.innerHTML = 'Business:' + arg.event.extendedProps.business_price;

                            contentEl.appendChild(businessPriceEl)
                        }
					}
				}

				let arrayOfDomNodes = [contentEl]
				return {
					domNodes: arrayOfDomNodes
				}
			},
			viewDidMount: function(arg) {
                if (arg.el) {
                    let el = arg.el;
                    if (self.timeOut) { clearTimeout(self.timeOut); }
                    self.timeOut = setTimeout(function() {
                        let viewHardnessEl = $(el).closest('.fc-view-harness.fc-view-harness-active');
                        if (viewHardnessEl && viewHardnessEl.outerHeight() == 0) {
                            viewHardnessEl.css({minHeight: '250px'});
                        }
                    }, 400);
                }
            },
			eventClick: function ({
				event,
				el,
				jsEvent,
				view
			}) {
				let startTime = moment(event.start, String(st_params.dateformat || "MM/DD/YYYY").toUpperCase())
					.format(String(st_params.dateformat || 'MM/DD/YYYY').toUpperCase());
				let endTime;
				if (event.end) {
					endTime = moment(event.end, String(st_params.dateformat || "MM/DD/YYYY").toUpperCase())
						.format(String(st_params.dateformat || 'MM/DD/YYYY').toUpperCase());
				} else {
					endTime = startTime;
				}
				setCheckInOut(
					startTime,
					endTime,
					self.form_container
				);
                if (typeof event.extendedProps.eco_price != 'undefined') {
                    $("#calendar_price_eco", self.form_container).val(event.extendedProps.eco_price);
                }

                if (typeof event.extendedProps.business_price != 'undefined') {
                    $("#calendar_price_bus", self.form_container).val(event.extendedProps.business_price);
                }

				if (event.extendedProps.status) {
					$(
						"#calendar_status option[value=" + event.extendedProps.status + "]",
						self.form_container
					).prop("selected", true);
				}
			},
			loading: function (isLoading) {
				if (isLoading) {
					$(".overlay", self.container).addClass("open");
				} else {
					$(".overlay", self.container).removeClass("open");
				}
			},
		};
        this.init = function(){
            self.container = jQuery(container);
            self.calendar = container.querySelector('.calendar-content');
            self.form_container = $('.calendar-form', self.container);
            setCheckInOut('', '', self.form_container);
            self.initCalendar();
        }
        this.initCalendar = function(){
			if (typeof FullCalendar != 'undefined') {
				self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
				self.fullCalendar.render();
			}

			self.container.on('flight.calendar.refetchEvents', function() {
				if (self.fullCalendar) {
					self.fullCalendar.refetchEvents();
				}
			});
        }
    };
    function setCheckInOut(check_in, check_out, form_container){
        $('#calendar_check_in', form_container).val(check_in);
        $('#calendar_check_out', form_container).val(check_out);
    }
    function resetForm(form_container){
        $('#calendar_check_in', form_container).val('');
        $('#calendar_check_out', form_container).val('');
        $('#calendar_price_eco', form_container).val('');
        $('#calendar_price_bus', form_container).val('');
        $('#calendar_priority', form_container).val('');
        $('#calendar_number', form_container).val('');
    }
    $(function() {
        $('.calendar-wrapper').each(function(index, el) {
            var t = $(this);
            var flight = new FlightCalendar(el);
            var flag_submit = false;
            $('#calendar_submit', t).on('click', function(event) {
                var data = $('input, select', '.calendar-form').serializeArray();
                data.push({
                    name: 'action',
                    value: 'st_add_custom_price_flight'
                });
                $('.form-message', t).attr('class', 'form-message').find('p').html('');
                $('.overlay', self.container).addClass('open');
                if(flag_submit) return false; flag_submit = true;
                $.post(ajaxurl, data, function(respon, textStatus, xhr) {
                    if(typeof respon == 'object'){
                        if(respon.status == 1){
                            resetForm(t);
                            if (flight.fullCalendar) {
                                flight.fullCalendar.refetchEvents();
                            }
                        }else{
                            $('.form-message', t).addClass(respon.type).find('p').html(respon.message);
                            $('.overlay', self.container).removeClass('open');
                        }
                    }else{
                        $('.overlay', self.container).removeClass('open');
                    }
                    flag_submit = false;
                }, 'json');
                return false;
            });
            $(document).on('click','.ui-tabs-anchor[href="#setting_tab_availability"]',function(){
                if (flight) {
                    flight.init();
                }
            });
            $('body').on('calendar.change_month', function(event, value){
                if (flight.fullCalendar) {
                    var date = flight.fullCalendar.getDate();
                    var month = date.format('M');
                    date = date.add(value-month, 'M');
                    flight.fullCalendar.gotoDate(date.format('YYYY-MM-DD'));
                }
            });
        });
    });
});
