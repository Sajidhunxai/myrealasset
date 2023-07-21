jQuery(function($){
	$('.date-picker').datepicker({
        language: st_params.locale || '',
        dateFormat: st_params.dateformat_convert || "mm/dd/yy",
        firstDay: 1
    });
    console.log(st_params.locale_fullcalendar);
	class TourCalendar {
        constructor(container) {
            var self = this;
            this.container = jQuery(container);
            this.calendar = null;
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
                    start, end, startStr, endStr, allDay, jsEvent, view, resource
                }) {
                    /* info{start, end, startStr, endStr, allDay, jsEvent, view, resource } */
                    if (moment(start).isBefore(moment(), 'day') ||
                        moment(end).isBefore(moment(), 'day')) {
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
                    start, end, startStr, endStr, timeZone
                }, successCallback, failureCallback) {
                    $.ajax({
                        url: ajaxurl,
                        dataType: "json",
                        type: "post",
                        data: {
                            action: "st_get_availability_tour",
                            tour_id: $(self.container).data("post-id"),
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
                    var hide_adult = jQuery(self.calendar).data('hide_adult');
                    var hide_children = jQuery(self.calendar).data('hide_children');
                    var hide_infant = jQuery(self.calendar).data('hide_infant');
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
                            contentEl.innerHTML = '<div class="not_available">' + st_params.text_unavailable + '</div>';
                        } else {
                            contentEl.classList.remove('unavailable');
                            contentEl.classList.add('available');
                            var price_type = $('select#tour_price_by').val();
                            if (price_type == 'person') {
                                if (hide_adult != 'on') {
                                    if (typeof arg.event.extendedProps.adult_price != 'undefined') {
                                        let adultPriceEl = document.createElement('div');
                                        adultPriceEl.classList.add('price');
                                        adultPriceEl.innerHTML = st_params.text_adult + arg.event.extendedProps.adult_price;

                                        contentEl.appendChild(adultPriceEl);
                                    }
                                }
                                if (hide_children != 'on') {
                                    if (typeof arg.event.extendedProps.child_price != 'undefined') {
                                        let childPriceEl = document.createElement('div');
                                        childPriceEl.classList.add('price');
                                        childPriceEl.innerHTML = st_params.text_child + arg.event.extendedProps.child_price;

                                        contentEl.appendChild(childPriceEl);
                                    }
                                }
                                if (hide_infant != 'on') {
                                    if (typeof arg.event.extendedProps.infant_price != 'undefined') {
                                        let infantPriceEl = document.createElement('div');
                                        infantPriceEl.classList.add('price');
                                        infantPriceEl.innerHTML = st_params.text_infant + arg.event.extendedProps.infant_price;

                                        contentEl.appendChild(infantPriceEl);
                                    }
                                }
                            } else {
                                if (typeof arg.event.extendedProps.base_price != 'undefined') {
                                    let basePriceEl = document.createElement('div');
                                    basePriceEl.classList.add('price');
                                    basePriceEl.innerHTML = st_params.text_price + arg.event.extendedProps.base_price;

                                    contentEl.appendChild(basePriceEl);
                                }
                            }

                            if (arg.event.extendedProps.starttime) {
                                startTimeEl.innerHTML = '<span class="dashicons dashicons-clock"></span>' + arg.event.extendedProps.starttime;

                                contentEl.appendChild(startTimeEl);
                            }
                        }
                    }

                    let arrayOfDomNodes = [contentEl];
                    return {
                        domNodes: arrayOfDomNodes
                    };
                },
                viewDidMount: function (arg) {
                    if (arg.el) {
                        let el = arg.el;
                        if (self.timeOut) { clearTimeout(self.timeOut); }
                        self.timeOut = setTimeout(function () {
                            let viewHardnessEl = $(el).closest('.fc-view-harness.fc-view-harness-active');
                            if (viewHardnessEl && viewHardnessEl.outerHeight() == 0) {
                                viewHardnessEl.css({ minHeight: '250px' });
                            }
                        }, 400);
                    }
                },
                eventClick: function ({
                    event, el, jsEvent, view
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
                    var hasTimeFormat = false;
                    if ($('.calendar_starttime_format').length) {
                        hasTimeFormat = true;
                    }

                    if (event.extendedProps.starttime) {
                        var starttime_arr = event.extendedProps.starttime.split(', ');
                        starttime_arr = cleanArray(starttime_arr);
                        $('.calendar-form .calendar-starttime-wraper')
                            .not('.starttime-origin').remove();
                        $('.calendar-form .calendar-starttime-wraper.starttime-origin')
                            .find('select.calendar_starttime_hour')
                            .attr('name', 'calendar_starttime_hour[]');
                        $('.calendar-form .calendar-starttime-wraper.starttime-origin')
                            .find('select.calendar_starttime_minute')
                            .attr('name', 'calendar_starttime_minute[]');
                        if (hasTimeFormat) {
                            $('.calendar-form .calendar-starttime-wraper.starttime-origin')
                                .find('select.calendar_starttime_format')
                                .attr('name', 'calendar_starttime_format[]');
                        }
                        if (starttime_arr.length > 0) {
                            for (var i = 0; i < (starttime_arr.length - 1); i++) {
                                $('.calendar-form .calendar-starttime-wraper.starttime-origin').clone(true).show()
                                    .removeClass('starttime-origin')
                                    .insertBefore('.calendar-form #calendar-add-starttime');
                            }
                        }
                        $('.calendar-form .calendar-starttime-wraper').show();
                        $('.calendar-form .calendar-starttime-wraper').each(function (index, value) {
                            if (starttime_arr.length > 0) {
                                var starttime_string = starttime_arr[index];
                                var starttime_sub_arr = starttime_string.split(':');
                                if (hasTimeFormat) {
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_hour')
                                        .eq(index).val(starttime_sub_arr[0]);
                                    var starttime_sub_with_format_arr = starttime_sub_arr[1].split(' ');
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_minute')
                                        .eq(index).val(starttime_sub_with_format_arr[0]);
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_format')
                                        .eq(index).val(starttime_sub_with_format_arr[1]);
                                } else {
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_hour')
                                        .eq(index).val(starttime_sub_arr[0]);
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_minute')
                                        .eq(index).val(starttime_sub_arr[1]);
                                }
                            } else {
                                if (hasTimeFormat) {
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_hour')
                                        .eq(index).val('01');
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_minute')
                                        .eq(index).val('00');
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_format')
                                        .eq(index).val('AM');
                                } else {
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_hour')
                                        .eq(index).val('00');
                                    $('.calendar-form .calendar-starttime-wraper .calendar_starttime_minute')
                                        .eq(index).val('00');
                                }
                            }
                        });
                    } else {
                        $('.calendar-form .calendar-starttime-wraper')
                            .not('.starttime-origin').remove();
                        $('.calendar-form .calendar-starttime-wraper.starttime-origin').hide();
                        $('.calendar-form .calendar-starttime-wraper.starttime-origin')
                            .find('select.calendar_starttime_hour').attr('name', '');
                        $('.calendar-form .calendar-starttime-wraper.starttime-origin')
                            .find('select.calendar_starttime_minute').attr('name', '');
                        if (hasTimeFormat) {
                            $('.calendar-form .calendar-starttime-wraper.starttime-origin')
                                .find('select.calendar_starttime_format').attr('name', '');
                        }
                    }

                    var price_type = $('select#tour_price_by').val();
                    if (price_type == 'person') {
                        if (typeof event.extendedProps.adult_price != 'undefined') {
                            $('#calendar_adult_price', self.form_container).val(event.extendedProps.adult_price);
                        }
                        if (typeof event.extendedProps.child_price != 'undefined') {
                            $('#calendar_child_price', self.form_container).val(event.extendedProps.child_price);
                        }
                        if (typeof event.extendedProps.infant_price != 'undefined') {
                            $('#calendar_infant_price', self.form_container).val(event.extendedProps.infant_price);
                        }
                    } else {
                        if (typeof event.extendedProps.base_price != 'undefined') {
                            $('#calendar_base_price', self.form_container).val(event.extendedProps.base_price);
                        }
                    }
                    if (event.extendedProps.status) {
                        $('#calendar_status option[value=' + event.extenedProps.status + ']', self.form_container).prop('selected');
                    }
                    var zone = moment(event.start).format('Z');
                    zone = zone.split(':');
                    zone = "" + parseInt(zone[0]) + ":00";
                    jQuery(self.calendar).trigger('st.click.eventcalendar', [moment(event.start).utcOffset(zone), moment(event.start).utcOffset(zone), el, view]);
                },
                loading: function (isLoading) {
                    if (isLoading) {
                        $(".overlay", self.container).addClass("open");
                    } else {
                        $(".overlay", self.container).removeClass("open");
                    }
                },
            };
            this.init = function () {
                self.container = container;
                self.calendar = container.querySelector('.calendar-content');
                self.form_container = $('.calendar-form', self.container);
                setCheckInOut('', '', self.form_container);
                self.initCalendar();
            };
            this.initCalendar = function () {
                var hide_adult = jQuery(self.calendar).data('hide_adult');
                var hide_children = jQuery(self.calendar).data('hide_children');
                var hide_infant = jQuery(self.calendar).data('hide_infant');
                if (typeof FullCalendar) {
                    self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                    self.fullCalendar.render();
                }
            };
        }
    }
	function setCheckInOut(check_in, check_out, form_container){
		$('#calendar_check_in', form_container).val(check_in);
		$('#calendar_check_out', form_container).val(check_out);
	}
	function resetForm(form_container){
	}
	$(function() {
		$('.calendar-wrapper').each(function(index, el) {
			var t = $(this);
			var tour = new TourCalendar(el);
			var flag_submit = false;
			$('#calendar_submit', t).on('click', function(event) {
				var data = $('input, select', '.calendar-form').serializeArray();
					data.push({
						name: 'action',
						value: 'st_add_custom_price_tour',
					});
				$('.form-message', t).attr('class', 'form-message').find('p').html('');
				$('.overlay', self.container).addClass('open');
				if(flag_submit) return false; flag_submit = true;
				$.post(ajaxurl, data, function(respon, textStatus, xhr) {
					if(typeof respon == 'object'){
						if(respon.status == 1){
							resetForm(t);
                            if (tour.fullCalendar) {
                                tour.fullCalendar.refetchEvents();
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
            $('.calendar-content', t).on('refetchEvents', function () {
                if (tour.fullCalendar) {
                    tour.fullCalendar.refetchEvents();
                }
            });
            $(document).on('click','.ui-tabs-anchor[href="#setting_availability_tab"]',function(){
                tour.init();
            });
            $('body').on('calendar.change_month', function(event, value){
                if (tour.fullCalendar) {
                    var date = tour.fullCalendar.getDate();
                    var month = date.format('M');
                    date = date.add(value-month, 'M');
                    tour.fullCalendar.gotoDate(date.format('YYYY-MM-DD'));
                }
            });
		});
        if($('select#tour_price_by').length && $('select#tour_price_by').val() == 'person'){
            $('input#calendar_base_price').val('').parent().parent().addClass('hide');
            $('input#base-price-bulk').val('').parent().parent().addClass('hide');
            $('input#calendar_adult_price, input#calendar_child_price, input#calendar_infant_price, input#adult-price-bulk, input#children-price-bulk, input#infant-price-bulk').parent().parent().removeClass('hide');
            $('input#calendar_price_type').val('person');
        }else{
            $('input#calendar_base_price').parent().parent().removeClass('hide');
            $('input#base-price-bulk').parent().parent().removeClass('hide');
            $('input#calendar_adult_price, input#calendar_child_price, input#calendar_infant_price, input#adult-price-bulk, input#children-price-bulk, input#infant-price-bulk').val('').parent().parent().addClass('hide');
            $('input#calendar_price_type').val('fixed');
        }
        $('select#tour_price_by').on('change', function(event) {
            price_type = $(this).val();
            if(price_type == 'person'){
                $('input#calendar_base_price').val('').parent().parent().addClass('hide');
                $('input#base-price-bulk').val('').parent().parent().addClass('hide');
                $('input#calendar_adult_price, input#calendar_child_price, input#calendar_infant_price, input#adult-price-bulk, input#children-price-bulk, input#infant-price-bulk').parent().parent().removeClass('hide');
                $('input#calendar_price_type').val('person');
            }else{
                $('input#calendar_base_price').parent().parent().removeClass('hide');
                $('input#base-price-bulk').parent().parent().removeClass('hide');
                $('input#calendar_adult_price, input#calendar_child_price, input#calendar_infant_price, input#adult-price-bulk, input#children-price-bulk, input#infant-price-bulk').val('').parent().parent().addClass('hide');
                $('input#calendar_price_type').val('fixed');
            }
        });
		if($('select#type_tour').length && $('select#type_tour').val() == 'daily_tour'){
			$('input#calendar_groupday').prop('checked', false).parent().hide();
		}else{
			$('input#calendar_groupday').parent().show();
		}
		$('select#type_tour').on('change', function(event) {
			tour_type = $(this).val();
			if(tour_type == 'daily_tour'){
				$('input#calendar_groupday').prop('checked', false).parent().hide();
			}else{
				$('input#calendar_groupday').parent().show();
			}
		});
	});
    $(document).on('click', '.calendar-form .calendar-add-starttime', function () {
        var sparent = $(this).closest('.calendar-form');
        var starttime_origin = $('.calendar-starttime-wraper.starttime-origin', sparent);
        if(!starttime_origin.is(":visible")) {
            starttime_origin.find('select.calendar_starttime_hour').attr('name', 'calendar_starttime_hour[]');
            starttime_origin.find('select.calendar_starttime_minute').attr('name', 'calendar_starttime_minute[]');
            if($(this).data('time-format') === '12h'){
                starttime_origin.find('select.calendar_starttime_format').attr('name', 'calendar_starttime_format[]');
            }
        }
        starttime_origin.clone(true).show().removeClass('starttime-origin').insertBefore($(this));
        if(!starttime_origin.is(":visible")) {
            starttime_origin.find('select.calendar_starttime_hour').attr('name', '');
            starttime_origin.find('select.calendar_starttime_minute').attr('name', '');
            if($(this).data('time-format') === '12h'){
                starttime_origin.find('select.calendar_starttime_format').attr('name', '');
            }
        }
    });
    $(document).on('click', '.bulk-starttime .calendar-add-starttime', function () {
        var sparent = $(this).closest('.bulk-starttime');
        var starttime_origin = $('.calendar-starttime-wraper.starttime-origin', sparent);
        if(!starttime_origin.is(":visible")) {
            starttime_origin.find('select.calendar_starttime_hour').attr('name', 'calendar_starttime_hour[]');
            starttime_origin.find('select.calendar_starttime_minute').attr('name', 'calendar_starttime_minute[]');
            if($(this).data('time-format') === '12h'){
                starttime_origin.find('select.calendar_starttime_format').attr('name', 'calendar_starttime_format[]');
            }
        }
        starttime_origin.clone(true).show().removeClass('starttime-origin').insertBefore($(this));
        if(!starttime_origin.is(":visible")) {
            starttime_origin.find('select.calendar_starttime_hour').attr('name', '');
            starttime_origin.find('select.calendar_starttime_minute').attr('name', '');
            if($(this).data('time-format') === '12h'){
                starttime_origin.find('select.calendar_starttime_format').attr('name', '');
            }
        }
    });
    $(document).on('click', '.calendar-remove-starttime', function () {
        if($(this).parent().hasClass('starttime-origin')){
            $(this).parent().hide();
            $(this).parent().find('select.calendar_starttime_hour').attr('name', '');
            $(this).parent().find('select.calendar_starttime_minute').attr('name', '');
            if($(this).data('time-format') === '12h'){
                (this).parent().find('select.calendar_starttime_format').attr('name', '');
            }
        }else{
            $(this).parent().remove();
        }
    });
    function cleanArray(actual) {
        var newArray = new Array();
        for (var i = 0; i < actual.length; i++) {
            if (actual[i]) {
                newArray.push(actual[i]);
            }
        }
        return newArray;
    }
});
