/**
 * Created by me664 on 3/3/15.
 */
jQuery(function($){
    var body = $('body');
    $('.st-inbox-rental-book-js', body).each(function () {
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('#field-rental-start', parent),
            check_out_input = $('#field-rental-end', parent),
            check_in_out = $('.check-in-out-rental', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent),
            availabilityDate = $(this).data('availability-date');
        var minimum = check_in_out.data('minimum-day');
        if (typeof minimum !== 'number') {
            minimum = 0;
        }
        var options = {
            singleDatePicker: false,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            widthSingle: 500,
            onlyShowCurrentMonth: true,
            minimumCheckin: minimum,
            classNotAvailable: ['disabled', 'off'],
            enableLoading: true,
            showEventTooltip: true,
            fetchEvents: function (start, end, el, callback) {
                var events = [];
                if (el.flag_get_events) {
                    return false;
                }
                el.flag_get_events = true;
                el.container.find('.loader-wrapper').show();
                var data = {
                    action: 'st_get_availability_rental_single',
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    post_id: check_in_out.data('post-id'),
                    security: st_params._s
                };
                $.post(st_params.ajax_url, data, function (respon) {
                    if (typeof respon === 'object') {
                        if (typeof respon.events === 'object') {
                            events = respon.events;
                        } else {
                            events = respon;
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
        if(typeof availabilityDate != 'undefined'){
            options['minDate'] = availabilityDate;
        }
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                check_in_input.val(start.format(parent.data('format')));
                check_out_input.val(end.format(parent.data('format')));
            });
        date_wrapper.on('click', function (e) {
            check_in_out.trigger('click');
        });
    });
});
