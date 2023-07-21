jQuery(function($) {
    if ($(".st_single_hotel_room").length <1) return;
    var time;
    var scroll = '';
    var offset_form = '';
    var month_start='';
    var year_start='';
    $(window).on('resize', function(event) {
        clearTimeout(time);
        time = setTimeout(function(){
                $(window).on('scroll', function(event) {
                    if($(window).width() >= 992){
                        if(scroll == ''){
                            scroll = $(window).scrollTop();
                        }
                        var t = 0;
                        if($('#top_toolbar-sticky-wrapper').length && $('#top_toolbar-sticky-wrapper').hasClass('is-sticky')){
                            if($('#top_toolbar').length){
                                t += $('#top_toolbar').height();
                            }
                        }
                        if($('#st_header_wrap_inner-sticky-wrapper').length && $('#st_header_wrap_inner-sticky-wrapper').hasClass('is-sticky')){
                            if($('#main-header').length){
                                t += $('#main-header').height();
                            }
                            if($('#top_toolbar').length){
                                t += $('#top_toolbar').height();
                            }
                        }
                        if($('#menu1-sticky-wrapper').length && $('#menu1-sticky-wrapper').hasClass('is-sticky')){
                            if($('#menu1').length){
                                t += $('#menu1').height();
                            }
                            if($('#top_toolbar').length){
                                t += $('#top_toolbar').height();
                            }
                        }
                        var h = 0;
                        if($('.hotel-room-form').length){
                            h = $('.hotel-room-form').offset().top - $(window).scrollTop();
                            if(offset_form == ''){
                                offset_form = $('.hotel-room-form').offset().top;
                            }
                        }
                        if(h <= t){
                            w = $('.hotel-room-form').width();
                            var top_kc = t;
                            if ($('#wpadminbar').length > 0){
                                top_kc += $('#wpadminbar').height();
                            }
                            if( ! $('.hotel-room-form').hasClass('sidebar-fixed')){
                                $('.hotel-room-form').css('top', top_kc);
                                $('.hotel-room-form').addClass('sidebar-fixed').css('width', w);
                                $('.hotel-room-form').addClass('no_margin_top');
                            }
                        }
                        if($(window).scrollTop() <= offset_form && $(window).scrollTop() < scroll){
                            $('.hotel-room-form').removeClass('sidebar-fixed').css('width', 'auto');
                            $('.hotel-room-form').css('top', 0);
                            $('.hotel-room-form').removeClass('no_margin_top');
                        }
                        scroll = $(window).scrollTop();
                    }
                });
        }, 500);
    }).trigger('resize');
    var disabled_dates = [];
    var fist_half_day = [];
    var last_half_day = [];
    var checkin_checkout_input=$('input.checkin_hotel, input.checkout_hotel');
    var startDate=$('.input-daterange').data('period');
    if(!startDate){
        startDate='today';
    }
    if(checkin_checkout_input.length){
        checkin_checkout_input.each(function() {
            var $this = $(this);
            $this.datepicker({
                language:st_params.locale,
                format: $('[data-date-format]').data('date-format'),
                todayHighlight: true,
                autoclose: true,
                startDate: startDate,
                weekStart: 1,
                setRefresh: true,
                beforeShowDay: function(date){
                    var d = date;
                    var curr_date = d.getDate();
                    if(curr_date < 10){
                        curr_date = "0"+curr_date;
                    }
                    var curr_month = d.getMonth() + 1; //Months are zero based
                    if(curr_month < 10){
                        curr_month = "0"+curr_month;
                    }
                    var curr_year = d.getFullYear();
                    var key = 'st_calendar_'+curr_date + "_" + curr_month + "_" + curr_year;
                    return {
                        classes: key
                    };
                }
            });
            $this.on('click', function(){
                if(fist_half_day.length > 0){
                    for (var i = 0; i < fist_half_day.length; i++) {
                        var $key ='st_calendar_'+fist_half_day[i];
                        $('.'+$key).addClass('st_fist_half_day');
                    }
                }
                if(last_half_day.length > 0){
                    for (var i = 0; i < last_half_day.length; i++) {
                        var $key ='st_calendar_'+last_half_day[i];
                        $('.'+$key).addClass('st_last_half_day');
                    }
                }
                if(disabled_dates.length > 0){
                    for (var i = 0; i < disabled_dates.length; i++) {
                        var $key ='st_calendar_'+disabled_dates[i];
                        $('.'+$key).addClass('disabled disabled-date booked day st_booked');
                    }
                }
            });
            $('.date-overlay').addClass('open');
            var date_start = $(this).datepicker('getDate');
            if(date_start == null)
                date_start = new Date();
            year_start = date_start.getFullYear();
            month_start = date_start.getMonth() + 1;
        });
        ajaxGetHotelOrder(month_start,year_start,checkin_checkout_input);
    }
    $('input.checkin_hotel').on('changeMonth', function(e) {
        year_start =  new Date(e.date).getFullYear();
        month_start =  new Date(e.date).getMonth() + 1;
        ajaxGetHotelOrder(month_start,year_start,$(this));
    });
    $('input.checkin_hotel').on('changeDate', function (e) {
        var new_date = e.date;
        new_date.setDate(new_date.getDate() + 1);
        $('input.checkout_hotel').datepicker('setStartDate', new_date);
        //$('input.checkout_rental').datepicker('setDate', new_date);
    });
    $('input.checkin_hotel, input.checkout_hotel').on('keyup', function (e) {
        setTimeout(function(){
            if(fist_half_day.length > 0){
                for (var i = 0; i < fist_half_day.length; i++) {
                    var $key ='st_calendar_'+fist_half_day[i];
                    $('.'+$key).addClass('st_fist_half_day');
                }
            }
            if(last_half_day.length > 0){
                for (var i = 0; i < last_half_day.length; i++) {
                    var $key ='st_calendar_'+last_half_day[i];
                    $('.'+$key).addClass('st_last_half_day');
                }
            }
            if(disabled_dates.length > 0){
                for (var i = 0; i < disabled_dates.length; i++) {
                    var $key ='st_calendar_'+disabled_dates[i];
                    $('.'+$key).addClass('disabled disabled-date booked day st_booked');
                }
            }
        },200)
    });
    $('input.checkout_hotel').on('changeMonth', function(e) {
        year_start =  new Date(e.date).getFullYear();
        month_start =  new Date(e.date).getMonth() + 1;
        ajaxGetHotelOrder(month_start,year_start,$(this));
    });
    function ajaxGetHotelOrder(month, year, me){
        post_id = $(me).data('post-id');
        $('.date-overlay').addClass('open');
        if(!typeof post_id != 'undefined' || parseInt(post_id) > 0){
            var data = {
                room_id : post_id,
                month: month,
                year: year,
                security:st_params.st_search_nonce,
                action:'st_get_disable_date_hotel',
            };
            $.post(st_params.ajax_url, data, function(respon) {
                disabled_dates = Object.keys(respon.disable).map(function (key) {return respon.disable[key]});
                fist_half_day = Object.keys(respon.fist_half_day).map(function (key) {return respon.fist_half_day[key]});
                last_half_day = Object.keys(respon.last_half_day).map(function (key) {return respon.last_half_day[key]});
                if(fist_half_day.length > 0){
                    for (var i = 0; i < fist_half_day.length; i++) {
                        var $key ='st_calendar_'+fist_half_day[i];
                        $('.'+$key).addClass('st_fist_half_day');
                    }
                }
                if(last_half_day.length > 0){
                    for (var i = 0; i < last_half_day.length; i++) {
                        var $key ='st_calendar_'+last_half_day[i];
                        $('.'+$key).addClass('st_last_half_day');
                    }
                }
                if(disabled_dates.length > 0){
                    for (var i = 0; i < disabled_dates.length; i++) {
                        var $key ='st_calendar_'+disabled_dates[i];
                        $('.'+$key).addClass('disabled disabled-date booked day st_booked');
                    }
                }
                $('.date-overlay').removeClass('open');
            },'json');
        }else{
            $('.date-overlay').removeClass('open');
        }
    }
    var HotelCalendar = function(container){
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
                    $('input#field-hotelroom-checkin').val(check_in).parent().show();
                    $('input#field-hotelroom-checkout').val(check_out).parent().show();
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
                        action: "st_get_availability_hotel_room",
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
                var hide_adult = jQuery(self.calendar).data('hide_adult');
                var hide_children = jQuery(self.calendar).data('hide_children');
                var hide_infant = jQuery(self.calendar).data('hide_infant');
                let contentEl = document.createElement('div');
                let priceEl = document.createElement('div');
                let startTimeEl = document.createElement('div');
                contentEl.classList.add('fc-content');
                priceEl.classList.add('price');
                startTimeEl.classList.add('starttime');

                var title = "";
                var is_disabled = "disabled";
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
                    html_class = "btn-available";
                    is_disabled = "";
                }
                if(arg.event.extendedProps.status == 'available_allow_fist'){
                    html_class = "btn-available btn-calendar btn-available_allow_fist available_allow_fist";
                    is_disabled = "";
                }
                if(arg.event.extendedProps.status == 'available_allow_last'){
                    html_class = "btn-available btn-calendar btn-available_allow_last available_allow_last";
                    is_disabled = "";
                }
                var class_group_day = '';
                if (arg.event.extendedProps.date_end != 'undefined') {
                    html_class  += ' is_group_day';
                }

                if(arg.event.extendedProps.status == 'available'){
                    var title ="";
                    if (typeof arg.event.extendedProps.price != 'undefined') {
                        title += st_params.text_origin_price+': '+arg.event.extendedProps.price + " <br/>";
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
                $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip({html:true});
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
                if (!$(el).find("button").hasClass('btn-available')) {return;}
                $('.fc-event').removeClass('st-active');
                $(el).addClass('st-active');
                var checkStartTime = $(el).find('button').data('starttime');
                let date = moment(event.start);
                $('input#field-hotelroom-checkin').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                check_in = date.format(st_params.date_format_calendar.toUpperCase());
                if(event.end){
                    date = new Date(event.end);
                    date.setDate(date.getDate() - 1);
                    //date = moment(date).format(st_params.date_format_calendar.toUpperCase());
                    date = moment(date);
                    check_out = date.format(st_params.date_format_calendar.toUpperCase());
                    $('input#field-hotelroom-checkout').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                }else{
                    date = moment(event.start).format(st_params.date_format_calendar.toUpperCase());
                    $('input#field-hotelroom-checkout').val(date).parent().hide();
                }
                $('input#adult_price').val(event.adult_price);
                $('input#child_price').val(event.child_price);
                $('input#infant_price').val(event.infant_price);
                if(checkStartTime == 'y'){
                    ajaxSelectStartTime(self.container.data('post-id'), check_in, check_out, '');
                }else{
                    $('.st_rental_starttime option').remove();
                    $('.rental-starttime').hide();
                }
            },
            loading: function (isLoading) {
                if (isLoading) {
                    $(".overlay-form", self.container).fadeIn();
                } else {
                    $(".overlay-form", self.container).fadeOut();
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
            if (typeof FullCalendar != 'undefined') {
                self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                self.fullCalendar.render();
            }
        }
    };
    if($('.calendar-wrapper').length){
        $('.calendar-wrapper').each(function(index, el) {
            var t = $(this);
            var hotel = new HotelCalendar(el);
            hotel.init();
            $('body').on('calendar.change_month', function(event, value){
                if (hotel.fullCalendar) {
                    var date = hotel.fullCalendar.getDate();
                    var month = moment(date).format('M');
                    date = moment(date).add(value-month, 'M');
                    hotel.fullCalendar.gotoDate( date.format('YYYY-MM-DD') );
                }
            });
            changeSelectBoxMonth(hotel);
            $('.fc-next-button, .fc-prev-button').on('click', function(){
                changeSelectBoxMonth(hotel);
            });
        });
    };
    function changeSelectBoxMonth(tt){
        if (tt.fullCalendar) {
            var date = tt.fullCalendar.getDate();
            var month = moment(date).format('M');
            $('.calendar_change_month').val(month);
        }
    }
    var single_hotel_room  = $(".st_single_hotel_room");
    if(single_hotel_room.length>0){
        var fancy_arr = single_hotel_room.data('fancy_arr');
        if (fancy_arr ==1){
            $('a#fancy-gallery').on("click",function(event) {
                var list = fancy_arr;
                $.fancybox.open(list);
            });
        }
    }
    $('a.button-readmore').on('click', function(){
        if($('#read-more').length > 0){
            $('#read-more').removeClass('hidden');
            $(this).addClass('hidden');
            $('#show-description').remove();
        }
    });
});
