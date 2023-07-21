jQuery(function ($) {
    var requestRunning = false;
    var xhr;
    if ($(".st_single_tour").length < 1) return;
    $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
    var listDate = [];
    if ($('input.tour_book_date').length > 0) {
        $('input.tour_book_date').each(function (index, el) {
            $(this).datepicker({
                language: st_params.locale,
                format: $(this).data('date-format'),
                todayHighlight: true,
                autoclose: true,
                startDate: 'today',
                weekStart: 1
            });
            date_start = $(this).datepicker('getDate');
            $(this).datepicker('addNewClass', 'booked');
            var $this = $(this);
            if (date_start == null)
                date_start = new Date();
            year_start = date_start.getFullYear();
            tour_id = $(this).data('tour-id');
            ajaxGetRentalOrder($this, year_start, tour_id);
        });
        $('input.tour_book_date').on('changeYear', function (e) {
            var $this = $(this);
            year = new Date(e.date).getFullYear();
            tour_id = $(this).data('tour-id');
            ajaxGetRentalOrder($this, year, tour_id);
        });
    } else {
        $('.package-info-wrapper .overlay-form').fadeOut(500);
    }
    function ajaxGetRentalOrder(me, year, tour_id) {
        var data = {
            tour_id: tour_id,
            year: year,
            action: 'st_get_disable_date_tour',
        };
        $.post(st_params.ajax_url, data, function (respon) {
            if (respon != '') {
                listDate = respon;
            }
            booking_period = me.data('booking-period');
            me.datepicker('setStartDate','+'+booking_period+'d');
            $('.overlay-form').fadeOut(500)
            // if (typeof booking_period != 'undefined' && parseInt(booking_period) > 0) {
            //     var data = {
            //         booking_period: booking_period,
            //         action: 'st_getBookingPeriod'
            //     };
            //     $.post(st_params.ajax_url, data, function (respon1) {
            //         if (respon1 != '') {
            //             listDate = listDate.concat(respon1);
            //             me.datepicker('setRefresh', true);
            //             me.datepicker('setDatesDisabled', listDate);
            //         }
            //     }, 'json');
            // } else {
            //     me.datepicker('setRefresh', true);
            //     me.datepicker('setDatesDisabled', listDate);
            //     $('.overlay-form').fadeOut(500);
            // }
        }, 'json');
    }
    $(document).ajaxStop(function () {
        $('.overlay-form').fadeOut(500);
    });
    //@since 2.0.0
    /**
     * Load select starttime ajax have post
     * */
    if($('#check_in').length) {
        var st_data_checkin = $('#check_in').val();
        var st_data_checkout = $('#check_out').val();
        if (st_data_checkin != st_data_checkout) {
            $('input#check_out').parent().show();
        } else {
            $('input#check_out').parent().hide();
        }
        var tour_type = $('input[name="type_tour"]').val();
        if (tour_type == 'daily_tour') {
            var st_data_checkout = $('#check_in').val();
            $('input#check_out').parent().hide();
        }
        if (st_data_checkin != '') {
            var st_data_tour_id = $('#starttime_hidden_load_form').data('tourid');
            var st_data_starttime = $('#starttime_hidden_load_form').data('starttime');
            if (st_data_starttime != "" && typeof st_data_starttime !== 'undefined')
                ajaxSelectStartTime(st_data_tour_id, st_data_checkin, st_data_checkout, st_data_starttime);
        }
    }
    var TourCalendar = function (container) {
        var self = this;
        this.container = container;
        this.calendar = null;
        this.form_container = null;
        this.fullCalendar = null;
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
                        if (self.fullCalendar) {
                            self.fullCalendar.refetchEvents();
                        }
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
                        action: "st_get_availability_tour_frontend",
                        tour_id: $(self.container).data("post-id"),
                        start: moment(start).unix(),
                        end: moment(end).unix()
                    },
                    success: function (doc) {
                        if (typeof doc === 'object') {
                            let events = doc;
                            if (typeof doc.events === 'object') {
                                events = doc.events;
                            }
                            successCallback(events);
                        } else {
                            console.log('Can not get data');
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
                var price_type = jQuery(self.calendar).data('price-type');
                var current_date = $('.calendar-wrapper').data('current-date');
                let contentEl = document.createElement('div');
                let priceEl = document.createElement('div');
                let startTimeEl = document.createElement('div');
                contentEl.classList.add('fc-content');
                priceEl.classList.add('price');
                startTimeEl.classList.add('starttime');

                var html = moment(arg.event.start).date();
                var html_class = "none";
                if(arg.event.end){
                    html += ' - '+moment(arg.event.end).date();
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
                    if (price_type && price_type == 'person') {
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
                    } else {
                        if (arg.event.extendedProps.base_price) {
                            title += st_checkout_text.price + ': ' + arg.event.extendedProps.base_price;
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
                    $('.st_tours_starttime option').remove();
                    $('.tour-starttime').hide();
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
        this.init = function () {
            self.container = jQuery(container);
            self.calendar = container.querySelector('.calendar-content');
            self.form_container = $('.calendar-form', self.container);
            self.initCalendar();
        }
        this.initCalendar = function () {
            var hide_adult = jQuery(self.calendar).data('hide_adult');
            var hide_children = jQuery(self.calendar).data('hide_children');
            var hide_infant = jQuery(self.calendar).data('hide_infant');
            var price_type = jQuery(self.calendar).data('price-type');
            var current_date = $('.calendar-wrapper').data('current-date');
            if (typeof FullCalendar != 'undefined') {
                self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                self.fullCalendar.render();
            }
        }
    };
    //$('input#check_out').parent().hide();
    if ($('#select-a-tour').length <= 0) {
        $('.calendar-wrapper').each(function (index, el) {
            var t = $(this);
            var tour = new TourCalendar(el);
            tour.init();
            $('body').on('calendar.change_month', function (event, value) {
                if (tour.fullCalendar) {
                    var date = tour.fullCalendar.getDate();
                    var month = date.format('M');
                    date = date.add(value - month, 'M');
                    tour.fullCalendar.gotoDate(date.format('YYYY-MM-DD'));
                }
            });
            var checked = false;
            $('body').on('click', '.st-tour-tabs-content .request', function () {
                if (!checked) {
                    var current_date = t.data('current-date');
                    if(current_date != ''){
                        setTimeout(function () {
                            if (tour.fullCalendar) {
                                tour.fullCalendar.refetchEvents();
                                tour.fullCalendar.gotoDate(current_date);

                                let view = t.find('.fc-view-harness.fc-view-harness-active');
                                if (view && view.innerHeight() == 0) {
                                    view.css({height: '380px'});
                                }
                            }
                            checked = true;
                        }, 1000);
                    }
                }
            });
            /* Trigger next/prev month */
            changeSelectBoxMonth(tour);
            $('.fc-next-button, .fc-prev-button').on('click', function(){
                changeSelectBoxMonth(tour);
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
    if ($('a.request').length > 0) {
        if (window.location.hash == '#request') {
            $("a.request").trigger('click');
        }
    }
    $(function() {
        if ($('#select-a-tour').length) {
            if ($('#select-a-tour').length) {
                if (typeof tippy != 'undefined') {
                    let selectATourEl = document.querySelector('#select-a-tour');
                    let listTourItemEl = document.querySelector('#list_tour_item');
                    tippy(selectATourEl, {
                        delay: 100,
                        allowHTML: true,
                        trigger: 'manual',
                        placement: 'auto-end',
                        hideOnClick: false,
                        interactive: true,
                        appendTo: document.body,
                        content: $('#list_tour_item').html(),
                        onClickOutside(instance, event) {
                            if (event.target != instance.reference || event.target != instance.popper) {
                                instance.hide();
                            }
                        },
                        onShow(instance) {
                            if (instance && instance.popper) {
                                $('.calendar-wrapper', instance.popper).each(function (index, el) {
                                    var t = $(this);
                                    var tour = new TourCalendar(el);
                                    tour.init();
                                    $('body').on('calendar.change_month', function (event, value) {
                                        if (tour.fullCalendar) {
                                            var date = tour.fullCalendar.getDate();
                                            var month = date.format('M');
                                            date = date.add(value - month, 'M');
                                            tour.fullCalendar.gotoDate(date.format('YYYY-MM-DD'));
                                        }
                                    });
                                    var checked = false;
                                    $('body').on('click', '.st-tour-tabs-content .request', function () {
                                        if (!checked) {
                                            var current_date = t.data('current-date');
                                            if(current_date != ''){
                                                setTimeout(function () {
                                                    if (tour.fullCalendar) {
                                                        tour.fullCalendar.gotoDate(current_date);
                                                    }
                                                    checked = true;
                                                }, 1000);
                                            }
                                        }
                                    });
                                    /* Trigger next/prev month */
                                    changeSelectBoxMonth(tour);
                                    $('.fc-next-button, .fc-prev-button').on('click', function(){
                                        changeSelectBoxMonth(tour);
                                    });
                                });
                            }
                        }
                    });

                    selectATourEl.addEventListener('click', function() {
                        if (selectATourEl._tippy) {
                            selectATourEl._tippy.show();
                        }
                    });
                }
            }
        }
    });
    function ajaxSelectStartTime(tour_id, check_in, check_out, select_starttime) {
        var sparent = $('.package-info-wrapper');
        var overlay = $('.overlay-form', sparent);
        overlay.hide();
        xhr = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'post',
            data: {
                action: 'st_get_starttime_tour_frontend',
                tour_id: tour_id,
                check_in: check_in,
                check_out: check_out
            },
            beforeSend: function () {
                overlay.show();
            },
            success: function (doc) {
                if (doc['data'] != null && doc['data'].length > 0) {
                    $('#starttime_tour option').remove();
                    $('#starttime_box').show();
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
                                        if(doc['check'][i] < 0){
                                            te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.no_vacancy + ' )' + '</option>';
                                        }else{
                                            te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + ' ( ' + doc['check'][i] + ' ' + st_params.more_vacancy + ' )' + '</option>';
                                        }
                                    }
                                } else {
                                    if (doc['check'][i] == '1') {
                                        te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.a_vacancy + ' )' + '</option>';
                                    } else {
                                        if(doc['check'][i] < 0){
                                            te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.no_vacancy + ' )' + '</option>';
                                        }else{
                                            te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + doc['check'][i] + ' ' + st_params.more_vacancy + ' )' + '</option>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $('#starttime_tour option').remove();
                    $('#starttime_tour').append(te);
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
