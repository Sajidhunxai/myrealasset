jQuery(function($) {
    class ActivityCalendar {
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
                    if (moment(start).isBefore(moment(), 'day')
                        || moment(end).isBefore(moment(), 'day')) {
                        self.fullCalendar.unselect();
                        setCheckInOut("", "", self.form_container);
                    } else {
                        var zone = moment(start).format("Z");
                        zone = zone.split(":");
                        zone = "" + parseInt(zone[0]) + ":00";
                        var check_in = moment(start).utcOffset(zone).format(String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
                        var check_out = moment(end).utcOffset(zone).subtract(1, 'day').format(String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
                        setCheckInOut(check_in, check_out, self.form_container);
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
                        let status = arg.event.extendedProps.status;
                        if (status === 'not_available' || !status) {
                            contentEl.classList.remove('available');
                            contentEl.classList.add('not_available');
                            contentEl.innerHTML = '<div class="not_available">' + st_params.text_unavailable + '</div>';
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
                    $('input#check_in').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                    check_in = date.format(st_params.date_format_calendar.toUpperCase());
                    if (event.end) {
                        date = new Date(event.end);
                        date.setDate(date.getDate() - 1);
                        //date = moment(date).format(st_params.date_format_calendar.toUpperCase());
                        date = moment(date);
                        check_out = date.format(st_params.date_format_calendar.toUpperCase());
                        $('input#check_out').val(date.format(st_params.date_format_calendar.toUpperCase())).parent().show();
                    } else {
                        date = moment(event.start).format(st_params.date_format_calendar.toUpperCase());
                        $('input#check_out').val(date).parent().hide();
                    }
                    $('input#adult_price').val(event.adult_price);
                    $('input#child_price').val(event.child_price);
                    $('input#infant_price').val(event.infant_price);

                    if (checkStartTime == 'y') {
                        ajaxSelectStartTime(self.container.data('post-id'), check_in, check_out, '');
                    } else {
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
            this.init = function () {
                self.container = jQuery(container);
                self.calendar = container.querySelector('.calendar-content');
                self.form_container = $('.calendar-form', self.container);
                self.initCalendar();
            };
            this.initCalendar = function () {
                var hide_adult = jQuery(self.calendar).data('hide_adult');
                var hide_children = jQuery(self.calendar).data('hide_children');
                var hide_infant = jQuery(self.calendar).data('hide_infant');
                var date_start = jQuery(self.calendar).data('date-start');
                if (typeof FullCalendar != 'undefined') {
                    self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                    self.fullCalendar.render();
                }
            };
        }
    }
    $('body').on('click', '.st-upload', function(e){
        var t = $(this);
        var frame;
        var multi = t.data('multi');
        var output = t.data('output');
        e.preventDefault();

        var galleryBox = t.parent().find('.st-selection');

        if (frame) {
            frame.open();
            return;
        }
        // Create a new media frame
        frame = wp.media({
            title: st_params.text_select_image || '',
            button: {
                text: st_params.text_use_this_media || ''
            },
            multiple: multi  // Set to true to allow multiple files to be selected
        });

        frame.on('select', function () {

            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').toJSON();
            var ids = [];
            if(multi === true) {
                galleryBox.find('.del').each(function () {
                    if(output === 'url'){
                        ids.push($(this).data('url'));
                    }else{
                        ids.push($(this).data('id'));
                    }

                });
                if (attachment.length > 0) {
                    for (var i = 0; i < attachment.length; i++) {
                        if (!ids.includes(attachment[i].id)) {
                            galleryBox.append('<div class="item" style="background-image: url(' + attachment[i].url + ')"><div class="del" data-id="' + attachment[i].id + '" data-url="'+ attachment[i].url +'" data-output="'+ output +'"></div></div>');
                            if(output === 'url') {
                                ids.push(attachment[i].url);
                            }else{
                                ids.push(attachment[i].id);
                            }
                        }
                    }
                }
            }else{
                galleryBox.find('.item').remove();
                if (attachment.length > 0) {
                    for (var i = 0; i < attachment.length; i++) {
                        if (!ids.includes(attachment[i].id)) {
                            galleryBox.append('<div class="item" style="background-image: url(' + attachment[i].url + ')"><div class="del" data-id="' + attachment[i].id + '" data-url="'+ attachment[i].url +'" data-output="'+ output +'"></div></div>');
                            if(output === 'url') {
                                ids.push(attachment[i].url);
                            }else{
                                ids.push(attachment[i].id);
                            }
                        }
                    }
                }
            }
            t.find('input').val(ids.toString());
        });

        frame.open();
    })

    $('body').on('click', '.st-field-upload .st-selection .item .del', function (e) {
        var cfirm = confirm( st_params.text_confirm_delete_item || '' );
        if(cfirm) {
            var t = $(this);
            var output = t.data('output');
            var parent = t.parent().parent().parent();
            t.closest('.item').remove();
            var ids = [];
            parent.find('.st-selection .item .del').each(function () {
                if (output === 'url') {
                    ids.push($(this).data('url'));
                } else {
                    ids.push($(this).data('id'));
                }
            });
            parent.find('.st-upload input').val(ids.toString());
        }
    });

    $('body').on('focus',".partner-date", function(){
        var t = $(this);
        t.datepicker({
            language: st_params.locale || '',
            format: t.data('format'),
            autoclose: true,
            startDate: '0days'
        });
    });


    $('.st-field-list-item').each(function () {
        var t = $(this);

        t.find('.add-item').on('click', function(){
            var cl = t.find('.item.origin').clone();
            cl.removeClass('origin').addClass('active');
            $(cl).insertBefore($(this));
        });
    });

    $(document).on('click', '.st-field-list-item .item .listitem-title', function () {
        $(this).closest('.item').toggleClass('active');
    });

    $(document).on('click', '.st-field-list-item .item .del', function () {
        var cfirm = confirm( st_params.text_confirm_delete_item || '' );
        if(cfirm){
            $(this).closest('.item').remove();
        }
    })



    $('.st-partner-field').each(function(){
        var cond = $(this).data('condition');
        var oper = $(this).data('operator');
        if(typeof cond !== 'undefined' && cond !== ''){
            var t = $(this);
            var cond_arr = cond.split(',');
            var checkHide = false;
            var checkHideChange = false;
            var arrChange = [];
            var keyChange = '';

            cond_arr.forEach(function (item, index) {
                var sub_arr = item.split(':'),
                    key = keyChange = sub_arr[0],
                    val = sub_arr[1].replace('is(', '').replace(')', '');

                if($('.st-partner-field[name="'+ key +'"]').val() === val){
                    checkHide = true;
                }

                arrChange.push(val);
            });

            $('.st-partner-field[name="'+ keyChange +'"]').on('change',function () {

                var valChange = $(this).val();
                if(arrChange.includes(valChange)){
                    checkHideChange = true;
                }else{
                    checkHideChange = false;
                }
                if(checkHideChange){
                    t.closest('.st-partner-field-item').fadeIn();
                }else{
                    t.closest('.st-partner-field-item').fadeOut();
                }

            });

            if(!checkHide){
                t.closest('.st-partner-field-item').hide();
            }else{
                t.closest('.st-partner-field-item').show();
            }
        }

    });

    $('.st-field-timepicker').each(function () {
        $(this).find('input').timepicker();
    });

    $(document).on('click', '.st-btn-back', function(e){
        e.preventDefault();
        var currentTab =  $('.st-create-service-content .nav-tabs li.active').index() - 1;
        if(currentTab >=0) {
            $('.st-create-service-content .nav-tabs li').removeClass('active').eq(currentTab).addClass('active');
            $('.st-create-service-content .tab-content .tab-pane').removeClass('active').eq(currentTab).addClass('active');
            if(currentTab === 0)
                $(this).hide();
            if((currentTab + 1) === $('.st-create-service-content .nav-tabs li').length){
                if($('.st-btn-continue').data('status') === 'new'){
                    $('.st-btn-continue').find('span').text(dashboard_params.complete_registration_text);
                }else{
                    $('.st-btn-continue').find('span').text(dashboard_params.complete_text);
                }
            }else{
                $('.st-btn-continue').find('span').text(dashboard_params.continue_text);
            }
        }
    });

    $('.st-btn-continue,.st-create-service-content.add .nav-tabs li ').on('click',function (e) {
        e.preventDefault();
        var clickTab = $(this).index();

        var currentTab = $(this).closest('.nav-tabs').find('li.active').index();

        var obj = $(this).data('obj');
        if(obj === 'button'){
            currentTab =  $('.st-create-service-content .nav-tabs li.active').index();
            clickTab = $('.st-create-service-content .nav-tabs li.active').index() + 1;
        }

        if(clickTab > currentTab) {
            e.stopPropagation();

            if(clickTab - currentTab !== 1)
                return;

            $('.tab-content, .st-partner-action').addClass('loading');

            var data = $('.st-create-service-content .tab-content .tab-pane.active .st-partner-create-form').serializeArray();

            var currentForm = $('.st-create-service-content .tab-content .tab-pane.active .st-partner-create-form');

            data.push({
                name: '_s',
                value: st_params._s
            });
            for (var i = 0; i < Object.keys(data).length; i++){
                if(data[i]['name'] === 'st_content'){
                    data[i]['value'] =  get_tinymce_content('st_content');
                    break;
                }
            }
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'url': st_params.ajax_url,
                'data': data,
                success: function (data) {
                    if (!data.status) {
                        $('.st-create-service-content .nav-tabs li.active').removeClass('success');
                        $('.st-partner-field-item').removeClass('error');
                        $('.st-partner-field-item').find('.st_field_msg').html('');
                        $.each(data.err, function (key, value) {
                            currentForm.find('.st-partner-field[name="' + key + '"]').closest('.st-partner-field-item').addClass('error');
                            currentForm.find('.st-partner-field[name="' + key + '"]').closest('.st-partner-field-item').find('.st_field_msg').html('<div class="alert alert-danger">' + value + '</div>');
                        });
                        window.scroll({
                            top: currentForm.find('.st-partner-field-item.error').first().offset().top - 50,
                            left: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        if(data.next_step != 'final') {
                            $('.st-partner-field-item').removeClass('error');
                            $('.st-partner-field-item').find('.st_field_msg').html('');
                            window.location.hash = '#post_id=' + data.post_id + '&step=' + data.next_step;
                            $('.st-partner-input-post-id').val(data.post_id);

                            //Next Tab
                            $('.st-create-service-content .nav-tabs li.active').addClass('success');
                            $('.st-create-service-content .nav-tabs li').removeClass('active').eq((data.next_step - 1)).addClass('active');
                            $('.st-create-service-content .tab-content .tab-pane').removeClass('active').eq((data.next_step - 1)).addClass('active');


                            var totalTabs = $('.st-create-service-content .nav-tabs li').length;
                            if (data.next_step > 1) {
                                $('.st-btn-back').show();
                            } else {
                                $('.st-btn-back').hide();
                            }

                            if (data.next_step == totalTabs) {
                                if($('.st-btn-continue').data('status') === 'new'){
                                    $('.st-btn-continue').find('span').text(dashboard_params.complete_registration_text);
                                }else{
                                    $('.st-btn-continue').find('span').text(dashboard_params.complete_text);
                                }
                                $('.st-btn-back').show();
                            } else {
                                $('.st-btn-continue').find('span').text(dashboard_params.continue_text);
                                $('.st-btn-back').show();
                            }

                            window.scroll({
                                top: $('.st-create-service-content .nav-tabs').first().offset().top - 50,
                                left: 0,
                                behavior: 'smooth'
                            });

                            if(data.next_step_name === 'policy'){
                                if($('.st-inventory').length) {
                                    var body = $('body');
                                    var inventory = $('.st-inventory', body).wpInventory();
                                    var inventory_data = inventory.data('Inventory');
                                    var start = moment().format();
                                    var end = moment().add(30, 'days').format();
                                    var data = {
                                        'action': 'st_fetch_inventory',
                                        'start': moment(start).format("YYYY-MM-DD"),
                                        'end': moment(end).format("YYYY-MM-DD"),
                                        'post_id': $('.st-inventory', body).data('id')
                                    };
                                    inventory_data.render(start, end, ajaxurl, data);
                                }
                            }
                            if(typeof data.sc !== 'undefined') {
                                checkAvailabilityFields(data.sc);
                                setTimeout(function () {
                                    $('.calendar-wrapper').each(function(index, el) {

                                        if($('#availability').hasClass('active')){
                                            var t = $(this);
                                            if(data.sc==='edit-tours'){
                                                var tour = new TourCalendar(el);
                                                tour.init();
                                            } else if(data.sc ==='edit-activity') {
                                                var activity = new ActivityCalendar(el);
                                                activity.init();
                                            }

                                        }
                                    });
                                }, 1000)
                            }
                        }else{
                            window.location.href = data.linkEdit;
                        }
                    }
                },
                complete: function (xhr, status) {
                    $('.tab-content, .st-partner-action').removeClass('loading');
                },
                error: function (data) {

                }
            })
        }else if(clickTab == ($('.st-create-service-content .nav-tabs li').length - 1)){
            if($('.st-btn-continue').data('status') === 'new'){
                $('.st-btn-continue').find('span').text(dashboard_params.complete_registration_text);
            }else{
                $('.st-btn-continue').find('span').text(dashboard_params.complete_text);
            }

            $('.st-btn-back').show();
        }else{
            $('.st-btn-continue').find('span').text(dashboard_params.continue_text);
            if(clickTab == 0) {
                $('.st-btn-back').hide();
            }else{
                $('.st-btn-back').show();
            }
        }
    });
    function setCheckInOut(check_in, check_out, form_container) {
        $('#calendar_check_in', form_container).val(check_in);
        $('#calendar_check_out', form_container).val(check_out)
    }

    class TourCalendar {
        constructor(container) {
            
            var self = this;
            this.container = jQuery(container);
            this.calendar = null;
            this.fullCalendar;
            this.timeOut;
            this.form_container = null;
            this.fullCalendarOptions = {
                initialView: 'dayGridMonth',
                firstDay: 1,
                locale: 'ar',
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
                select: function ({ start, end, startStr, endStr, allDay, jsEvent, view, resource }) {
                    if (moment(start).isBefore(moment(), 'day')
                        || moment(end).isBefore(moment(), 'day')) {
                        self.fullCalendar.unselect();
                        setCheckInOut("", "", self.form_container);
                    } else {
                        var zone = moment(start).format("Z");
                        zone = zone.split(":");
                        zone = "" + parseInt(zone[0]) + ":00";
                        var check_in = moment(start).utcOffset(zone).format(String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
                        var check_out = moment(end).utcOffset(zone).subtract(1, 'day').format(String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
                        setCheckInOut(check_in, check_out, self.form_container);
                    }
                },
                events: function (info, successCallback, failureCallback) {
                    $.ajax({
                        url: ajaxurl,
                        dataType: "json",
                        type: "post",
                        data: {
                            action: 'st_get_availability_tour',
                            tour_id: $(self.container).data("post-id"),
                            start: moment(info.start.valueOf()).unix(),
                            end: moment(info.end.valueOf()).unix(),
                        },
                        success: function (doc) {
                            if (typeof doc == "object") {
                                successCallback(doc);
                            }
                        },
                        error: function (e) {
                            alert(
                                "Error get availability"
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
                        if (status === 'unavailable') {
                            contentEl.classList.remove('available');
                            contentEl.classList.add('unavailable');
                            contentEl.innerHTML = '<div class="not_available">' + st_params.text_unavailable + '</div>';
                        } else {
                            contentEl.classList.remove('unavailable');
                            contentEl.classList.add('available');
                            var price_type = $('select[name=tour_price_by]').val();
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
                                        infantPriceEl.innerHTML = st_params.text_infant_price + arg.event.extendedProps.infant_price;

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
                eventClick: function ({ event, el, jsEvent, view }) {
                    let startTime = moment(event.start, String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase())
                        .format(String(dashboard_params.dateformat || 'MM/DD/YYYY').toUpperCase());
                    let endTime;
                    if (event.end) {
                        endTime = moment(event.end, String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase())
                            .format(String(dashboard_params.dateformat || 'MM/DD/YYYY').toUpperCase());
                    } else {
                        endTime = startTime;
                    }
                    setCheckInOut(
                        startTime,
                        endTime,
                        self.form_container
                    );
                    if (event.extendedProps.price) {
                        $("#calendar_price", self.form_container).val(event.extendedProps.price);
                    }
                    if (event.extendedProps.status) {
                        $(
                            "#calendar_status option[value=" + event.extendedProps.status + "]",
                            self.form_container
                        ).prop("selected");
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
            this.init = function () {
                self.container = container;
                self.calendar = container.querySelector('#calendar-content');
                self.form_container = $(".calendar-form", self.container);
                setCheckInOut("", "", self.form_container);
                self.initCalendar();
            };
            this.initCalendar = function () {
                if (typeof FullCalendar != 'undefined') {
                    self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
                    self.fullCalendar.render();
                }
            };
        }
    }
    //Check availability form tour

    function checkAvailabilityFields(posttype){
        switch (posttype) {
            case 'edit-tours':
                var currentPriceType = $('.st-partner-create-form #st-field-tour_price_by').val();
                var tourType = $('.st-partner-create-form #st-field-type_tour').val();
                if(tourType === 'specific_date'){
                    $('#calendar_groupday').closest('.col-xs-6').show();
                    $('.form-bulk-edit-activity-tour #calendar_groupday').closest('div').show();
                }else{
                    $('#calendar_groupday').closest('.col-xs-6').hide();
                    $('.form-bulk-edit-activity-tour #calendar_groupday').closest('div').hide();
                }
                if(currentPriceType === 'fixed'){
                    $('.tour-calendar-price-person').hide();
                    $('.tour-calendar-price-fixed').show();
                }else{
                    $('.tour-calendar-price-person').show();
                    $('.tour-calendar-price-fixed').hide();
                }
                if(currentPriceType === 'person' || currentPriceType === 'fixed_depart'){
                    $('#calendar_price_type', '.calendar-form').val('person');
                }else{
                    $('#calendar_price_type', '.calendar-form').val('fixed');
                }
                break;
            case 'edit-activity':
                var activityType = $('.st-partner-create-form #st-field-type_activity').val();
                if(activityType === 'specific_date'){
                    $('#calendar_groupday').closest('.col-xs-6').show();
                }else{
                    $('#calendar_groupday').closest('.col-xs-6').hide();
                }
                break;
        }
    }

    /*$('.st-field-multi_location input.st-partner-field').click(function () {
        $(this).closest('.st-field-multi_location').find('.dropdown').slideToggle();
    });*/

    if ($('.st-field-multi_location').length) {
        $('.st-field-multi_location').each(function (index, el) {
            var parent = $(this);
            var input = $('input.st-partner-field', parent);
            var list = $('.dropdown', parent);
            var timeout;
            input.on('keyup', function (event) {
                clearTimeout(timeout);
                var t = $(this);
                timeout = setTimeout(function () {
                    var text = t.val().toLowerCase();
                    if (text == '') {
                        $('.item', list).show()
                    } else {
                        $('.item', list).hide();
                        $(".item", list).each(function () {
                            var name = $(this).data("name").toLowerCase();
                            var reg = new RegExp(text, "g");
                            if (reg.test(name)) {
                                $(this).show()
                            }
                        })
                    }
                }, 100)
            })
        })
    }

    //Auto complete address with map
    $('.i-check, .i-radio').iCheck({
        checkboxClass: 'i-check',
        radioClass: 'i-radio'
    });

    function get_tinymce_content(id) {
        var content = '';
        var inputid = id;
        var textArea = jQuery('textarea#' + inputid);
        if (textArea.length>0 && textArea.is(':visible')) {
            content = textArea.val();
        } else {
            if(typeof tinyMCE != 'undefined'){
                var editor = tinyMCE.get(inputid);
                content = editor.getContent();
            }
        }
        return content;
    }

    $('body').on('click', '.st-upload-avatar', function(e){
        var t = $(this);
        var frame;
        var multi = t.data('multi');
        var output = t.data('output');
        e.preventDefault();

        var galleryBox = t.closest('.setting-avatar').find('.st-selection');
        if (frame) {
            frame.open();
            return;
        }
        // Create a new media frame
        frame = wp.media({
            title: st_params.text_select_image || '',
            button: {
                text: st_params.text_use_this_media || ''
            },
            multiple: multi  // Set to true to allow multiple files to be selected
        });

        frame.on('select', function () {

            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').toJSON();
            var ids = [];
            galleryBox.find('.item').remove();
            if (attachment.length > 0) {
                for (var i = 0; i < attachment.length; i++) {
                    if (!ids.includes(attachment[i].id)) {
                        galleryBox.append('<div class="item" style="background-image: url(' + attachment[i].url + ')"><div class="del" data-id="' + attachment[i].id + '" data-url="'+ attachment[i].url +'" data-output="'+ output +'"></div></div>');
                        if(output === 'url') {
                            ids.push(attachment[i].url);
                        }else{
                            ids.push(attachment[i].id);
                        }
                        t.closest('.row').find('.st-change-avatar .img-thumbnail').attr("src" , attachment[i].url);
                    }
                }
            }
            t.closest('.setting-avatar').find('#id_avatar_user_setting').val(ids.toString());

        });

        frame.open();
    })
});
