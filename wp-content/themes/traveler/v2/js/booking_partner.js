jQuery(function($) {
    var body = $('body');
    $('.st_add_booking_tour', body).each(function () {
        var parent = $(this),
        date_wrapper = $('#tour_time', parent),
        check_in_input = $('.check-in-input', parent),
        check_out_input = $('.check-out-input', parent),
        check_in_out_input = $('.check-in-out-input', parent),
        check_in_render = $('.check-in-render', parent),
        check_out_render = $('.check-out-render', parent),
        sts_checkout_label = $('.sts-tour-checkout-label', parent);
        st_security_check = $('.st_security_check', parent);
        var options = {
            singleDatePicker: true,
            showCalendar: false,
            sameDate: true,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            enableLoading: true,
            showEventTooltip: true,
            classNotAvailable: ['disabled', 'off'],
            disableHightLight: true,
            fetchEvents: function (start, end, el, callback) {
                var events = [];
                if (el.flag_get_events) {
                    return false;
                }
                el.flag_get_events = true;
                el.container.find('.loader-wrapper').show();
                var data = {
                    action: 'st_get_availability_tour_frontend',
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    tour_id: $('input#tour_id').val(),
                    security: $('input#st_frontend_security').val(),
                };
                $.post(st_params.ajax_url, data, function (respon) {
                    if (typeof respon === 'object') {
                        if (typeof respon.events === 'object') {
                            events = respon.events;
                        }
                    } else {
                        console.log('Can not get data');
                    }
                    callback(events, el);
                    el.flag_get_events = false;
                    el.container.find('.loader-wrapper').hide();
                }, 'json');
            }
        };
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }

        check_in_out_input.daterangepicker(options,
            function (start, end, label, elmDate) {
                check_in_input.val(start.format(parent.data('format')));
                check_out_input.val(end.format(parent.data('format')));
                check_in_render.html(start.format(parent.data('format')));
                check_out_render.html(end.format(parent.data('format')));
                if (start.format(parent.data('format')).toString() == end.format(parent.data('format')).toString()) {
                    sts_checkout_label.hide();
                } else {
                    sts_checkout_label.show();
                }
                date = moment(start.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                date_end = moment(end.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                $('input#check_in_tour').val(date);
                $('input#check_out_tour').val(date_end);
                if(date != date_end){
                    $('input#check_out_tour').parents('.form-group').show();
                }
                if (typeof elmDate !== 'undefined' && elmDate !== false) {
                    if ($('.st_add_booking_tour').length > 0) {
                        
                        if (elmDate.target.classList.contains('has_starttime')) {
                            ajaxSelectStartTime(check_in_out_input.data('tour-id'), date, date_end, '', check_in_out_input.data('posttype'));
                        } else {
                            $('#starttime_tour option').remove();
                            $('#starttime_box').parent().hide();
                        }
                    }else {
                        console.log("no"); 
                    }
                }
            });
        date_wrapper.on('click',function (e) {
            check_in_out_input.trigger('click');
        });
    });

    $('.st_add_booking_activity', body).each(function () {
        var parent = $(this),
        date_wrapper = $('#activity_time', parent),
        check_in_input = $('.check-in-input', parent),
        check_out_input = $('.check-out-input', parent),
        check_in_out_input = $('.check-in-out-input', parent),
        check_in_render = $('.check-in-render', parent),
        check_out_render = $('.check-out-render', parent),
        sts_checkout_label = $('.sts-tour-checkout-label', parent);
        st_security_check = $('.st_security_check', parent);
        var options = {
            singleDatePicker: true,
            showCalendar: false,
            sameDate: true,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            enableLoading: true,
            showEventTooltip: true,
            classNotAvailable: ['disabled', 'off'],
            disableHightLight: true,
            fetchEvents: function (start, end, el, callback) {
                var events = [];
                if (el.flag_get_events) {
                    return false;
                }
                el.flag_get_events = true;
                el.container.find('.loader-wrapper').show();
                var data = {
                    action: 'st_get_availability_activity_frontend',
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    activity_id: $('input#activity_id').val(),
                    security: $('input#st_frontend_security').val(),
                };
                $.post(st_params.ajax_url, data, function (respon) {
                    if (typeof respon === 'object') {
                        callback(respon, el);
                    } else {
                        console.log('Can not get data');
                    }
                    el.flag_get_events = false;
                    el.container.find('.loader-wrapper').hide();
                }, 'json');
            }
        };
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }

        check_in_out_input.daterangepicker(options,
            function (start, end, label, elmDate) {
                check_in_input.val(start.format(parent.data('format')));
                check_out_input.val(end.format(parent.data('format')));
                check_in_render.html(start.format(parent.data('format')));
                check_out_render.html(end.format(parent.data('format')));
                if (start.format(parent.data('format')).toString() == end.format(parent.data('format')).toString()) {
                    sts_checkout_label.hide();
                } else {
                    sts_checkout_label.show();
                }
                date = moment(start.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                date_end = moment(end.format(parent.data('format'))).format(st_params.date_format.toUpperCase());
                $('input#check_in_activity').val(date);
                $('input#check_out_activity').val(date_end);
                if(date != date_end){
                    $('input#check_out_tour').parents('.form-group').show();
                }
                if (typeof elmDate !== 'undefined' && elmDate !== false) {
                    if ($('.st_add_booking_activity').length > 0) {
                        if (elmDate.target.classList.contains('has_starttime')) {
                            ajaxSelectStartTime(check_in_out_input.data('tour-id'), date, date_end, '', check_in_out_input.data('posttype'));
                        } else {
                            $('#starttime_activity option').remove();
                            $('#starttime_box').parent().hide();
                        }
                    } else {
                    }
                } else {
                }
            });
        date_wrapper.on('click',function (e) {
            check_in_out_input.trigger('click');
        });
    });
    //Time booking partner
    if ($('#starttime_hidden_load_form').length > 0) {
        $('#starttime_box').each(function () {
            var meS = $(this);
            var st_data_tour_id = $('#starttime_hidden_load_form').data('tourid');
            var st_data_starttime = $('#starttime_hidden_load_form').data('starttime');
            var st_data_checkin = $('#starttime_hidden_load_form').data('checkin');
            var st_data_checkout = $('#starttime_hidden_load_form').data('checkout');
            var st_posttype = $('#starttime_hidden_load_form').data('posttype');
            if (st_data_starttime != "" && typeof st_data_starttime !== 'undefined') {
                ajaxSelectStartTime(st_data_tour_id, st_data_checkin, st_data_checkout, st_data_starttime, st_posttype);
            }
        });
    }
    function ajaxSelectStartTime(tour_id, check_in, check_out, select_starttime, posttype = 'st_tours') {
        var parent = $('.form-add-booking-partner');
        var data = {
            check_in: check_in,
            check_out: check_out
        };
        if (posttype === 'st_activity') {
            data['action'] = 'st_get_starttime_activity_frontend';
            data['activity_id'] = tour_id;
        } else {
            data['action'] = 'st_get_starttime_tour_frontend';
            data['tour_id'] = tour_id;
        }
        $('#overlay', parent).removeClass('active');
        $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'post',
            data: data,
            beforeSend: function () {
                $('#overlay', parent).addClass('active');
            },
            success: function (doc) {
                var i = 0;
                if (doc['data'] != null && doc['data'].length > 0) {
                    $('#starttime_tour option').remove();
                    $('#starttime_box').parent().show();
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
                                        if (doc['check'][i] < 0) {
                                            te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.no_vacancy + ' )' + '</option>';
                                        } else {
                                            te += '<option value="' + doc['data'][i] + '" selected ' + op_disable + '>' + doc['data'][i] + ' ( ' + doc['check'][i] + ' ' + st_params.more_vacancy + ' )' + '</option>';
                                        }
                                    }
                                } else {
                                    if (doc['check'][i] == '1') {
                                        te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.a_vacancy + ' )' + '</option>';
                                    } else {
                                        if (doc['check'][i] < 0) {
                                            te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + st_params.no_vacancy + ' )' + '</option>';
                                        } else {
                                            te += '<option value="' + doc['data'][i] + '" ' + op_disable + '>' + doc['data'][i] + ' ( ' + doc['check'][i] + ' ' + st_params.more_vacancy + ' )' + '</option>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $('#starttime_tour option').remove();
                    $('#starttime_tour').append(te);
                    $('#overlay', parent).removeClass('active');
                } else {
                    $('#starttime_box').parent().hide();
                    $('#overlay', parent).removeClass('active');
                }
            },
        });
    }
});
