/**
 * Created by me664 on 3/3/15.
 */
jQuery(function($){
    var meecell;
    if ($(".st_single_rental").length <1) return;
    $('.btn_booking_modal').on('click', function(){
       var form=$(this).closest('form');
       $('.alert',form).remove();
        var validate_form=true;
        var data=[];
        $('input.required,textarea.required,select.required',form).each(function(){
            $(this).removeClass('error');
            if(!$(this).val()){
                validate_form=false;
                $(this).addClass('error');
            }
            if($(this).attr('name')){
                data.push({
                    'value':$(this).val(),
                    'name':$(this).attr('name')
                });
            }
        });
        if(!validate_form)
        {
            form.prepend('<div class="alert alert-danger">'+st_checkout_text.validate_form+'</div>');
            return false;
        }else
        {
            var tar_get=$(this).data('target');
            for(i=0;i<data.length;i++)
            {
                var val=data[i];
                $(tar_get).find('.booking_modal_form').prepend('<input type="hidden" name="'+val.name+'" value="'+val.value+'">');
            }
            $.magnificPopup.open({
                items: {
                    type: 'inline',
                    src: tar_get
                }
            });
        }
    });
    class RentalCalendar {
        constructor(container) {
            var self = this;
            this.container = container;
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
                    start: 'prev',
                    center: 'title',
                    end: 'next'
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
                    } else {
                        var zone = moment(start).format("Z");
                        zone = zone.split(":");
                        zone = "" + parseInt(zone[0]) + ":00";
                        var check_in = moment(start).utcOffset(zone).format(String(st_params.date_format_calendar || "MM/DD/YYYY").toUpperCase());
                        var check_out = moment(end).utcOffset(zone).subtract(1, 'day').format(String(st_params.date_format_calendar || "MM/DD/YYYY").toUpperCase());
                        $('input#field-rental-start').val(check_in).parent().show();
                        $('input#field-rental-end').val(check_out).parent().show();
                    }
                },
                events: function ({
                    start, end, startStr, endStr, timeZone
                }, successCallback, failureCallback) {
                    $.ajax({
                        url: st_params.ajax_url,
                        dataType: "json",
                        type: "post",
                        data: {
                            action: "st_get_availability_rental_single",
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
                    if (arg.event.end) {
                        html += ' - ' + moment(arg.event.end).subtract(1, 'd').date();
                        html_class = "group";
                    }
                    var today_y_m_d = new Date().getFullYear() + "-" + (new Date().getMonth() + 1) + "-" + new Date().getDate();
                    var month = moment(self.fullCalendar.getDate()).format("MM");
                    var month_now = moment(arg.event.start).format("MM");
                    var _class = '';
                    if (month_now != month) {
                        _class = 'next_month';
                    }


                    if (arg.event.extendedProps.status == 'available') {
                        html_class = "btn-available";
                        is_disabled = "";
                    }
                    if (arg.event.extendedProps.status == 'available_allow_fist') {
                        html_class = "btn-available btn-calendar btn-available_allow_fist available_allow_fist";
                        is_disabled = "";
                    }
                    if (arg.event.extendedProps.status == 'available_allow_last') {
                        html_class = "btn-available btn-calendar btn-available_allow_last available_allow_last";
                        is_disabled = "";
                    }
                    var class_group_day = '';
                    if (arg.event.extendedProps.date_end != 'undefined') {
                        html_class += ' is_group_day';
                    }

                    if (arg.event.extendedProps.status == 'available') {
                        var title = "";
                        if (arg.event.extendedProps.price) {
                            title += st_params.text_origin_price + ': ' + arg.event.extendedProps.price + " <br/>";
                        }
                        var dataStartTime = 'n';
                        if (arg.event.extendedProps.starttime) {
                            title += '<br /><i class="fa fa-clock-o" aria-hidden="true"></i> ' + arg.event.extendedProps.starttime;
                            dataStartTime = "data-starttime='y'";
                        }
                        html = "<button " + dataStartTime + " data-placement='top' title  = '" + title + "' data-toggle='tooltip' class='" + html_class + " " + _class + " btn btn-available'>" + html;
                    } else {
                        html = "<button disabled data-placement='top' title  = 'Disabled' data-toggle='tooltip' class='" + html_class + " btn btn-disabled'>" + html;
                    }
                    if (today_y_m_d === arg.event.start) {
                        html += "<span class='triangle'></span>";
                    }
                    html += "</button>";
                    jQuery(arg.el).addClass('event-' + arg.event.id);
                    jQuery(arg.el).addClass('event-number-' + moment(arg.event.start).unix());

                    contentEl.innerHTML = html;

                    let arrayOfDomNodes = [contentEl];
                    return {
                        domNodes: arrayOfDomNodes
                    };
                },
                eventDidMount: function (arg) {
                    $('[data-toggle="tooltip"]').tooltip({ html: true });
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
                    var check_in = '';
                    var check_out = '';
                    if (!$(el).find("button").hasClass('btn-available'))
                        return;
                    $('.fc-event').removeClass('st-active');
                    $(el).addClass('st-active');
                    var checkStartTime = $(el).find('button').data('starttime');
                    date = moment(event.start);
                    $('input#field-rental-start').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                    check_in = date.format(st_params.date_format_calendar.toUpperCase());
                    if (event.end) {
                        date = new Date(event.end);
                        date.setDate(date.getDate() - 1);
                        //date = moment(date).format(st_params.date_format_calendar.toUpperCase());
                        date = moment(date);
                        check_out = date.format(st_params.date_format_calendar.toUpperCase());
                        $('input#field-rental-end').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                    } else {
                        date = moment(event.start).format(st_params.date_format_calendar.toUpperCase());
                        $('input#field-rental-end').val(date).parent().hide();
                    }
                    $('input#adult_price').val(event.adult_price);
                    $('input#child_price').val(event.child_price);
                    $('input#infant_price').val(event.infant_price);
                    if (checkStartTime == 'y') {
                        ajaxSelectStartTime(self.container.data('post-id'), check_in, check_out, '');
                    } else {
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
            this.init = function () {
                self.container = jQuery(container);
                self.calendar = container.querySelector('.calendar-content');
                self.form_container = $('.calendar-form', self.container);
                self.initCalendar();
            };
            this.initCalendar = function () {
                var start = jQuery(self.calendar).data('start');
                if (typeof FullCalendar != 'undefined') {
                    self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                    self.fullCalendar.render();
                }
            };
        }
    }
    if($('.calendar-wrapper').length){
        $('.calendar-wrapper').each(function(index, el) {
            var t = $(this);
            var rental = new RentalCalendar(el);
            //rental.init();
            setTimeout(function(){
                rental.init();
                /* Trigger next/prev month */
                changeSelectBoxMonth(rental);
                $('.fc-next-button, .fc-prev-button').on('click', function(){
                    changeSelectBoxMonth(rental);
                });
            }, 100);
            $('body').on('calendar.change_month', function(event, value){
                if (rental.fullCalendar) {
                    var date = rental.fullCalendar.getDate();
                    var month = date.format('M');
                    date = date.add(value-month, 'M');
                    rental.fullCalendar.gotoDate( date.format('YYYY-MM-DD') );
                }
            });
            $('body').on('calendar.today', function() {
                if (rental.fullCalendar) {
                    rental.fullCalendar.today();
                }
            })
        });
    }
    function changeSelectBoxMonth(tt){
        if (tt.fullCalendar) {
            var date = tt.fullCalendar.getDate();
            var month = moment(date).format('M');
            $('.calendar_change_month').val(month);
        }
    }
    $(document).on("click",".ui-tabs-anchor",function() {
        setTimeout(function(){
            $('body').trigger('calendar.today');
        }, 1000);
    });
    var me  = $(".st_single_rental_room");
    if(me.length>0){
        var fancy_arr = me.data('fancy_arr');
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
    $(document).on('click', '#gdate-choose .gdate-choose-item' , function(){
        var data_id = $(this).attr('id');
        switch (data_id){
            case 'gdate_start_item':
                if($('input#field-rental-start').val() == '' || ($('input#field-rental-start').val() != '' && $('input#field-rental-end').val() != '')) {
                    $('input#field-rental-start').val($(this).data('date')).parent().show();
                    $('input#field-rental-end').val('');
                    $('.fc-day-grid-event').removeClass('st-active');
                    $('.fc-day-grid-event').removeClass('current-select');
                    meecell.addClass('st-active');
                    meecell.addClass('current-select');
                    var ij = 0;
                    $('.fc-day-grid-event').each(function(){
                        ij++;
                        if($(this).hasClass('current-select')){
                            return false;
                        }
                    });
                    $('.fc-day-grid-event').each(function(index){
                        if(index<ij-1){
                            if($(this).find('button').hasClass('btn-available')){
                                $(this).find('button').removeClass('btn-available').addClass('btn-disabled-gd');
                                $(this).find('button').attr('disabled', true);
                                $(this).find('.tooltip').remove();
                            }
                        }
                    });
                }else{
                    if($('input#field-rental-end').val() == '' || ($('input#field-rental-start').val() != '' && $('input#field-rental-end').val() != '')){
                        $('input#field-rental-end').val($(this).data('date')).parent().show();
                        meecell.addClass('st-active');
                    }
                }
                break;
            case 'gdate_end_item':
                if($('input#field-rental-start').val() == '' || ($('input#field-rental-start').val() != '' && $('input#field-rental-end').val() != '')) {
                    $('input#field-rental-start').val($(this).data('date')).parent().show();
                    $('input#field-rental-end').val('');
                    $('.fc-day-grid-event').removeClass('st-active');
                    $('.fc-day-grid-event').removeClass('current-select');
                    meecell.addClass('st-active');
                    meecell.addClass('current-select');
                    var ij = 0;
                    $('.fc-day-grid-event').each(function(){
                        ij++;
                        if($(this).hasClass('current-select')){
                            return false;
                        }
                    });
                    $('.fc-day-grid-event').each(function(index){
                        if(index<ij){
                            if($(this).find('button').hasClass('btn-available')){
                                $(this).find('button').removeClass('btn-available').addClass('btn-disabled-gd');
                                $(this).find('button').attr('disabled', true);
                                $(this).find('.tooltip').remove();
                            }
                        }
                    });
                }else{
                    if($('input#field-rental-end').val() == '' || ($('input#field-rental-start').val() != '' && $('input#field-rental-end').val() != '')){
                        $('input#field-rental-end').val($(this).data('date')).parent().show();
                        meecell.addClass('st-active');
                    }
                }
                break;
            case 'gdate_all_item':
                $('.fc-day-grid-event').removeClass('st-active');
                meecell.addClass('st-active');
                $('input#field-rental-start').val($(this).data('start-date')).parent().show();
                $('input#field-rental-end').val($(this).data('end-date')).parent().show();
                $('.fc-day-grid-event').removeClass('current-select');
                $('.fc-day-grid-event').each(function(index){
                    if($(this).find('button').hasClass('btn-disabled-gd')){
                        $(this).find('button').removeClass('btn-disabled-gd').addClass('btn-available');
                        $(this).find('button').prop('disabled', false);
                    }
                });
                break;
        }
        $.magnificPopup.close();
    });
    $('#clear-gdate-rental').on('click', function (e) {
        e.preventDefault();
        $('input#field-rental-start').val('');
        $('input#field-rental-end').val('');
        $('.fc-day-grid-event').removeClass('st-active');
        $('.fc-day-grid-event').removeClass('current-select');
        $('.fc-day-grid-event').each(function(index){
            if($(this).find('button').hasClass('btn-disabled-gd')){
                $(this).find('button').removeClass('btn-disabled-gd').addClass('btn-available');
                $(this).find('button').prop('disabled', false);
            }
        });
    });
});
jQuery(function($){
});
