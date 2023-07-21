jQuery(function($) {
    if ($(".st_partner_avaiablity.edit-activity").length < 1) return;
    $('.date-picker').datepicker({
        language: st_params.locale || '',
        format: dashboard_params.dateformat_convert,
        weekStart: 1
    });
    var ActivityCalendar = function(container){
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
                start: 'prev',
                center: 'title',
                end: 'next'
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
                if (moment(start).isBefore(moment(), 'day')
                || moment(end).isBefore(moment(), 'day')
                ) {
                self.fullCalendar.unselect();
                setCheckInOut("", "", self.form_container);
                } else {
                var zone = moment(start).format("Z");
                zone = zone.split(":");
                zone = "" + parseInt(zone[0]) + ":00";
                var check_in = moment(start).utcOffset(zone).format( String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
                var	check_out = moment(end).utcOffset(zone).subtract(1, 'day').format( String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
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
                    url: st_params.ajax_url,
                    dataType: "json",
                    type: "post",
                    data: {
                        action: "st_get_availability_activity_frontend",
                        activity_id: $(self.container).data("post-id"),
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
                var hide_adult = jQuery('select[name=hide_adult_in_booking_form]').val();
                var hide_children = jQuery('select[name=hide_children_in_booking_form]').val();
                var hide_infant = jQuery('select[name=hide_infant_in_booking_form]').val();
                let contentEl = document.createElement('div');
                let priceEl = document.createElement('div');
                let startTimeEl = document.createElement('div');
                contentEl.classList.add('fc-content');
                priceEl.classList.add('price');
                startTimeEl.classList.add('starttime');

                if (arg.event.extendedProps.status) {
                    // available, unavailable
                    let status = arg.event.extendedProps.status;
                    if (status === 'not_available' || !status) {
                        contentEl.classList.remove('available');
                        contentEl.classList.add('not_available');
                        contentEl.innerHTML = '<div class="not_available">'+st_params.text_unavailable+'</div>';
                    } else {
                        contentEl.classList.remove('not_available');
                        contentEl.classList.add('available');

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
                                infantPriceEl.innerHTML = st_params.text_infant_price + arg.event.extendedProps.infant_price;

                                contentEl.appendChild(infantPriceEl);
                            }
                        }

                        if(arg.event.extendedProps.starttime) {
                            startTimeEl.innerHTML = '<i class="dashicons dashicons-clock"></i>' + arg.event.extendedProps.starttime;

                            contentEl.appendChild(startTimeEl);
                        }
                    }
                }

                let arrayOfDomNodes = [contentEl]
                return {
                    domNodes: arrayOfDomNodes
                }
            },
            eventDidMount: function( arg ) {
                $('[data-toggle="tooltip"]').tooltip({html:true});
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
                var check_in = '';
                var check_out = '';
                if (!$(el).find("button").hasClass('btn-available')) return ;
                $('.fc-event').removeClass('st-active');
                $(el).addClass('st-active');
                var checkStartTime = $(el).find('button').data('starttime');
                date = moment(event.start);
                $('input#check_in').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                check_in = date.format(st_params.date_format_calendar.toUpperCase());
                if(event.end){
                    date = new Date(event.end);
                    date.setDate(date.getDate() - 1);
                    //date = moment(date).format(st_params.date_format_calendar.toUpperCase());
                    date = moment(date);
                    check_out = date.format(st_params.date_format_calendar.toUpperCase());
                    $('input#check_out').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                }else{
                    date = moment(event.start).format(st_params.date_format_calendar.toUpperCase());
                    $('input#check_out').val(date).parent().hide();
                }
                $('input#adult_price').val(event.adult_price);
                $('input#child_price').val(event.child_price);
                $('input#infant_price').val(event.infant_price);
                if(checkStartTime == 'y'){
                    ajaxSelectStartTime(self.container.data('post-id'), check_in, check_out, '');
                }else{
                    $('.st_activity_starttime option').remove();
                    $('.activity-starttime').hide();
                }
            },
            loading: function (isLoading) {
                if (isLoading) {
                    $(".overlay-form", self.container).show();
                } else {
                    $(".overlay-form", self.container).hide();
                }
            },
        };
        this.init = function(){
            self.container = jQuery(container);
            self.calendar = container.querySelector('#calendar-content');
            self.form_container = $('.calendar-form', self.container);
            self.initCalendar();
        }
        this.initCalendar = function(){
            var hide_adult = jQuery(self.calendar).data('hide_adult');
            var hide_children = jQuery(self.calendar).data('hide_children');
            var hide_infant = jQuery(self.calendar).data('hide_infant');
            var date_start = jQuery(self.calendar).data('date-start');
            if (typeof FullCalendar) {
                self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                self.fullCalendar.render();
            }
        }
    };
    function setCheckInOut(check_in, check_out, form_container) {
        $('#calendar_check_in', form_container).val(check_in);
        $('#calendar_check_out', form_container).val(check_out)
    }
    function resetForm(form_container) {
        $('#calendar_check_in', form_container).val('');
        $('#calendar_check_out', form_container).val('');
        $('#calendar_adult_price', form_container).val('');
        $('#calendar_child_price', form_container).val('');
        $('#calendar_infant_price', form_container).val('');
        $('#calendar_number', form_container).val('')
        $('.partner-starttime .calendar-starttime-wraper.starttime-origin').hide();
        $('.partner-starttime .calendar-starttime-wraper.starttime-origin').find('select.calendar_starttime_hour').attr('name', '');
        $('.partner-starttime .calendar-starttime-wraper.starttime-origin').find('select.calendar_starttime_minute').attr('name', '');
        $('.partner-starttime .calendar-starttime-wraper').not('.starttime-origin').remove();
    }
    function cleanArray(actual) {
        var newArray = new Array();
        for (var i = 0; i < actual.length; i++) {
            if (actual[i]) {
                newArray.push(actual[i]);
            }
        }
        return newArray;
    }
    jQuery(function($) {
        if ($('#form-bulk-edit').length) {
            $('#calendar-bulk-close').on('click', function (event) {
                $(this).closest('#form-bulk-edit').fadeOut();
                $(this).closest('.calendar-wrapper').find('#calendar-content').trigger('refetchEvents')
            })
        }
        if ($('a[href="#availablility_tab"], ul li[data-step="#step_availablility"]').length) {
            $('a[href="#availablility_tab"], ul li[data-step="#step_availablility"]').on('click', function(event) {
                setTimeout(function() {
                    $('#calendar-content', '.calendar-wrapper').fullCalendar('today')
                }, 1000)
            })
        }
        $('.calendar-wrapper').each(function(index, el) {
            var t = $(this);
            var activity = new ActivityCalendar(el);
            var flag_submit = !1;
            $('#calendar_submit', t).on('click', function(event) {
                var data = $('input, select', '.calendar-form').serializeArray();
                data.push({
                    name: 'action',
                    value: 'st_add_custom_price_activity'
                });
                $('.form-message', t).attr('class', 'form-message').find('p').html('');
                $('.overlay-form', self.container).show();
                if (flag_submit) return !1;
                flag_submit = !0;
                $.post(ajaxurl, data, function(respon, textStatus, xhr) {
                    if (typeof respon == 'object') {
                        if (respon.status == 1) {
                            resetForm(t);
                            activity.init();
                            if (activity.fullCalendar) {
                                activity.fullCalendar.refetchEvents();
                            }
                        } else {
                            $('.form-message', t).addClass(respon.type).find('p').html(respon.message);
                            $('.overlay-form', self.container).hide();
                        }
                    } else {
                        $('.overlay-form', self.container).hide();
                    }
                    flag_submit = !1
                }, 'json');
                return !1
            });
            $('#calendar-content', t).on('refetchEvents', function() {
                activity.init();
                if (activity.fullCalendar) {
                    activity.fullCalendar.refetchEvents();
                }
            });
            $('body').on('calendar.change_month', function(event, value){

            	var date = activity.calendar.fullCalendar('getDate');
            	var month = date.format('M');
            	date = date.add(value-month, 'M');
            	activity.calendar.fullCalendar( 'gotoDate', date.format('YYYY-MM-DD') );
            });
            $('a[href="#availability"]').on('click',function(){
                activity.init();
                if (activity.fullCalendar) {
                    activity.fullCalendar.refetchEvents();
                }
            });
        });
        if ($('select#type_activity').length && $('select#type_activity').val() == 'daily_activity') {
            $('input#calendar_groupday').prop('checked', !1).parents('.form-group').hide()
        } else {
            $('input#calendar_groupday').parents('.form-group').show()
        }
        $('select#type_activity').on('change', function(event) {
            activity_type = $(this).val();
            if (activity_type == 'daily_activity') {
                $('input#calendar_groupday').prop('checked', !1).parents('.form-group').hide()
            } else {
                $('input#calendar_groupday').parents('.form-group').show()
            }
        });
        $(document).on('click', '.partner-starttime .calendar-add-starttime', function () {
            var sparent = $(this).closest('.partner-starttime');
            if(!$('.calendar-starttime-wraper.starttime-origin', sparent).is(":visible")) {
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_hour').attr('name', 'calendar_starttime_hour[]');
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_minute').attr('name', 'calendar_starttime_minute[]');
                if($(this).data('time-format') === '12h'){
                    $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_format').attr('name', 'calendar_starttime_format[]');
                }
            }
            $('.calendar-starttime-wraper.starttime-origin', sparent).clone(true).show().removeClass('starttime-origin').insertBefore($(this));
            if(!$('.calendar-starttime-wraper.starttime-origin', sparent).is(":visible")) {
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_hour').attr('name', '');
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_minute').attr('name', '');
                if($(this).data('time-format') === '12h'){
                    $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_format').attr('name', '');
                }
            }
        });
        $(document).on('click', '.bulk-starttime .calendar-add-starttime', function () {
            var sparent = $(this).closest('.bulk-starttime');
            if(!$('.calendar-starttime-wraper.starttime-origin', sparent).is(":visible")) {
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_hour').attr('name', 'calendar_starttime_hour[]');
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_minute').attr('name', 'calendar_starttime_minute[]');
                if($(this).data('time-format') === '12h'){
                    $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_format').attr('name', 'calendar_starttime_format[]');
                }
            }
            $('.calendar-starttime-wraper.starttime-origin', sparent).clone(true).show().removeClass('starttime-origin').insertBefore($(this));
            if(!$('.calendar-starttime-wraper.starttime-origin', sparent).is(":visible")) {
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_hour').attr('name', '');
                $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_minute').attr('name', '');
                if($(this).data('time-format') === '12h'){
                    $('.calendar-starttime-wraper.starttime-origin', sparent).find('select.calendar_starttime_format').attr('name', '');
                }
            }
        });
        $(document).on('click', '.calendar-remove-starttime', function () {
            if($(this).parent().hasClass('starttime-origin')){
                $(this).parent().hide();
                $(this).parent().find('select.calendar_starttime_hour').attr('name', '');
                $(this).parent().find('select.calendar_starttime_minute').attr('name', '');
                if($(this).data('time-format') === '12h'){
                    $(this).parent().find('select.calendar_starttime_format').attr('name', '');
                }
            }else{
                $(this).parent().remove();
            }
        });
    })
})
