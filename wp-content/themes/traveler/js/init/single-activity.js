jQuery(function($) {
    if ($(".st_single_activity").length <1) return;
    var listDate = [];
    if($('input.activity_book_date').length > 0){
        $('input.activity_book_date').each(function(index, el) {
            $(this).datepicker({
                language:st_params.locale,
                format: $(this).data('date-format'),
                todayHighlight: true,
                autoclose: true,
                startDate: 'today',
                weekStart: 1
            });
            date_start = $(this).datepicker('getDate');
            $(this).datepicker('addNewClass','booked');
            var $this = $(this);
            if(date_start == null)
                date_start = new Date();
            year_start = date_start.getFullYear();
            activity_id = $(this).data('activity-id');
            ajaxGetRentalOrder($this, year_start, activity_id);
        });
        $('input.activity_book_date').on('changeYear', function(e) {
            var $this = $(this);
            year =  new Date(e.date).getFullYear();
            activity_id = $(this).data('activity-id');
            ajaxGetRentalOrder( $this, year, activity_id);
        });
    }else{
        $('.overlay-form').fadeOut(500);
    }
    function ajaxGetRentalOrder(me, year, activity_id){
        var data = {
            activity_id: activity_id,
            year: year,
            action:'st_get_disable_date_activity',
        };
        $.post(st_params.ajax_url, data, function(respon) {
            if(respon!= ''){
                listDate = respon;
            }
            booking_period = me.data('booking-period');
            me.datepicker('setStartDate','+'+booking_period+'d');
            $('.overlay-form').fadeOut(500)
        },'json');
    }
    $( document ).ajaxStop(function() {
        $('.overlay-form').fadeOut(500);
    });
    $(document).on('click', '.single-st_activity .ui-state-default', function(event) {
        //var activity = new ActivityCalendar();
       // activity.init();
    });
    if($('#check_in').length) {
        var st_data_checkin = $('#starttime_hidden_load_form').data('checkin');
        var st_data_checkout = $('#starttime_hidden_load_form').data('checkout');
        if (st_data_checkin != st_data_checkout) {
            $('input#check_out').parent().show();
        }
        if (st_data_checkin != '') {
            var st_data_tour_id = $('#starttime_hidden_load_form').data('tourid');
            var st_data_starttime = $('#starttime_hidden_load_form').data('starttime');
            if (st_data_starttime != "" && typeof st_data_starttime !== 'undefined')
                ajaxSelectStartTime(st_data_tour_id, st_data_checkin, st_data_checkout, st_data_starttime);
        }
    }
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
                /* info{start, end, startStr, endStr, allDay, jsEvent, view, resource } */
                if (moment(start).isBefore(moment(), 'day') ||
                    moment(end).isBefore(moment(), 'day')
                ) {
                    self.fullCalendar.unselect();
                } else {
                    var zone = moment(start).format("Z");
                    zone = zone.split(":");
                    zone = "" + parseInt(zone[0]) + ":00";
                    var check_in = moment(start).utcOffset(zone).format(String(st_params.date_format_calendar || "MM/DD/YYYY").toUpperCase());
                    var check_out = moment(end).utcOffset(zone).subtract(1, 'day').format(String(st_params.date_format_calendar || "MM/DD/YYYY").toUpperCase());
                    $('input#check_in').val(check_in).parent().show();
                    $('input#check_out').val(check_out).parent().show();
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

                var html = moment(arg.event.start).date();
                var html_class = "none";
                if(arg.event.end){
                    html += ' - '+moment(arg.event.end).subtract(1, 'd').date();
                    html_class = "group";
                }
                var today_y_m_d = new Date().getFullYear() +"-"+(new Date().getMonth()+1)+"-"+new Date().getDate();
                var month = moment(self.fullCalendar.getDate()).format("MM");
                var month_now = moment(arg.event.start).format("MM");
                var _class = '';
                if(month_now != month){
                    _class = 'next_month';
                }
                if(arg.event.extendedProps.status == 'available'){
                    var title ="";
                    if ( hide_adult != 'on'){
                        if (arg.event.extendedProps.adult_price) {
                            title += st_checkout_text.adult_price+': '+arg.event.extendedProps.adult_price + " <br/>";
                        }
                    }
                    if ( hide_children != 'on') {
                        if (arg.event.extendedProps.child_price) {
                            title += st_checkout_text.child_price+': '+arg.event.extendedProps.child_price + " <br/>";
                        }
                    }
                    if ( hide_infant != 'on') {
                        if (arg.event.extendedProps.infant_price) {
                            title += st_checkout_text.infant_price+': '+arg.event.extendedProps.infant_price ;
                        }
                    }
                    var dataStartTime = 'n';
                    if(arg.event.extendedProps.starttime){
                        title += '<br /><i class="fa fa-clock-o" aria-hidden="true"></i> ' + arg.event.extendedProps.starttime;
                        dataStartTime = "data-starttime='y'";
                    }
                    html  = "<button "+ dataStartTime +" data-placement='top' title  = '"+title+"' data-toggle='tooltip' class='"+html_class+" "+_class+" btn btn-available'>" + html;
                }else {
                    html  = "<button disabled data-placement='top' title  = 'Disabled' data-toggle='tooltip' class='"+html_class+" btn btn-disabled'>" + html;
                }
                if (today_y_m_d === arg.event.start) {
                    html += "<span class='triangle'></span>";
                }
                html  += "</button>";
                jQuery(arg.el).addClass('event-'+arg.event.id)
                jQuery(arg.el).addClass('event-number-'+moment(arg.event.start).unix());

                contentEl.innerHTML = html;

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
            self.initCalendar();
        }
        this.initCalendar = function(){
            var hide_adult = jQuery(self.calendar).data('hide_adult');
            var hide_children = jQuery(self.calendar).data('hide_children');
            var hide_infant = jQuery(self.calendar).data('hide_infant');
            var date_start = jQuery(self.calendar).data('date-start');
            if (typeof FullCalendar != 'undefined') {
                self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                self.fullCalendar.render();
            }
        }
    };
    if($('#select-a-activity').length <= 0){
        $('.calendar-wrapper').each(function(index, el) {
            var t = $(this);
            var activity = new ActivityCalendar(el);
            activity.init();
            $('body').on('calendar.change_month', function(event, value){
                if (activity.fullCalendar) {
                    var date = activity.fullCalendar.getDate();
                    var month = date.format('M');
                    date = date.add(value-month, 'M');
                    activity.fullCalendar.gotoDate(date.format('YYYY-MM-DD'));
                }
            });
            var current_date = t.data('current-date');
            if(current_date != '') {
                if (activity.fullCalendar) {
                    activity.fullCalendar.gotoDate(current_date);
                }
            }
            /* Trigger next/prev month */
            changeSelectBoxMonth(activity);
            $('.fc-next-button, .fc-prev-button').on('click', function(){
                changeSelectBoxMonth(activity);
            });
        });
    }
    function changeSelectBoxMonth(tt){
        if (tt.fullCalendar) {
            var date = tt.fullCalendar.getDate();
            var month = moment(date).format('M');
            $('.calendar_change_month').val(month);
        }
    }
    $(function() {
        if($('#select-a-activity').length){
            if (typeof tippy != 'undefined') {
                let selectAActivityEl = document.querySelector('#select-a-activity');
                let listActivityItemEl = document.querySelector('#list_activity_item');
                tippy(selectAActivityEl, {
                    delay: 100,
                    allowHTML: true,
                    trigger: 'manual',
                    placement: 'auto-end',
                    hideOnClick: false,
                    interactive: true,
                    appendTo: document.body,
                    content: $('#list_activity_item').html(),
                    onClickOutside(instance, event) {
                        if (event.target != instance.reference || event.target != instance.popper) {
                            instance.hide();
                        }
                    },
                    onShow(instance) {
                        if (instance && instance.popper) {
                            $('.calendar-wrapper', instance.popper).each(function (index, el) {
                                var t = $(this);
                                var activity = new ActivityCalendar(el);
                                activity.init();
                                $('body').on('calendar.change_month', function (event, value) {
                                    if (activity.fullCalendar) {
                                        var date = activity.fullCalendar.getDate();
                                        var month = date.format('M');
                                        date = date.add(value - month, 'M');
                                        activity.fullCalendar.gotoDate(date.format('YYYY-MM-DD'));
                                    }
                                });
                                var checked = false;
                                $('body').on('click', '.st-activity-tabs-content .request', function () {
                                    if (!checked) {
                                        var current_date = t.data('current-date');
                                        if(current_date != ''){
                                            setTimeout(function () {
                                                if (activity.fullCalendar) {
                                                    activity.fullCalendar.gotoDate(current_date);
                                                }
                                                checked = true;
                                            }, 1000);
                                        }
                                    }
                                });
                                /* Trigger next/prev month */
                                changeSelectBoxMonth(activity);
                                $('.fc-next-button, .fc-prev-button').on('click', function(){
                                    changeSelectBoxMonth(activity);
                                });
                            });
                        }
                    }
                });

                selectAActivityEl.addEventListener('click', function() {
                    if (selectAActivityEl._tippy) {
                        selectAActivityEl._tippy.show();
                    }
                });
            }
        }
    });
    function ajaxSelectStartTime(activity_id, check_in, check_out, select_starttime) {
        var sparent = $('.package-info-wrapper');
        var overlay = $('.overlay-form', sparent);
        overlay.hide();
        xhr = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'post',
            data: {
                action: 'st_get_starttime_activity_frontend',
                activity_id: activity_id,
                check_in: check_in,
                check_out: check_out
            },
            beforeSend: function () {
                overlay.show();
            },
            success: function (doc) {
                if (doc['data'] != null && doc['data'].length > 0) {
                    $('.st_activity_starttime option', sparent).remove();
                    $('.activity-starttime', sparent).show();
                    var te = '';
                    for (i = 0; i < doc['data'].length; i++) {
                        var op_disable = '';
                        if (doc['check'][i] == '-1') {
                            if (doc['data'][i] == select_starttime) {
                                te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + '</option>';
                            } else {
                                te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + '</option>';
                            }
                        } else {
                            if (doc['check'][i] == '0') {
                                //op_disable = 'disabled="disabled"';
                                if (doc['data'][i] == select_starttime) {
                                    te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.no_vacancy + ' )' + '</option>';
                                } else {
                                    te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.no_vacancy + ' )' + '</option>';
                                }
                            } else {
                                if (doc['data'][i] == select_starttime) {
                                    if (doc['check'][i] == '1') {
                                        te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.a_vacancy + ' )' + '</option>';
                                    } else {
                                        te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + ' ( ' + doc['check'][i] + ' ' + st_params.more_vacancy + ' )' + '</option>';
                                    }
                                } else {
                                    if (doc['check'][i] == '1') {
                                        te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.a_vacancy + ' )' + '</option>';
                                    } else {
                                        te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + doc['check'][i] + ' ' + st_params.more_vacancy + ' )' + '</option>';
                                    }
                                }
                            }
                        }
                    }
                    $('.st_activity_starttime', sparent).append(te);
                    overlay.hide();
                } else {
                    $('#starttime_box').hide();
                    overlay.hide();
                }
                requestRunning = false;
            },
        });
        requestRunning = true;
    }
});
