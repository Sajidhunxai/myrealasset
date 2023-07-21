(function ($) {
    var requestRunning = false;
    var xhr;
    let SingleRentalDetail = {
        
        $body: $('body'),
        renderHtmlRental() {
            var form = jQuery('form.rental-booking-form');
            var data = jQuery('form.rental-booking-form').serializeArray();
            jQuery('.loader-wrapper').hide();
            data.push({
                name: 'security',
                value: st_params._s
            });
            for (var i = 0; i < data.length; i++) {
        
                if(data[i].name === 'action'){
                    data[i]['value'] = 'st_format_rental_price';
                }
            };
            if (requestRunning) {
                xhr.abort();
            }
            xhr= jQuery.ajax({
                method: "post",
                dataType: 'json',
                data: data,
                url: st_params.ajax_url,
                beforeSend: function () {
                    jQuery('.loader-wrapper').show();
                    jQuery('div.message-wrapper').html("");
                    jQuery('.message_box').html('');
                },
                success: function (response) {
                    console.log(response);
                    jQuery('.loader-wrapper').hide();
                    if (response) {
                        if (response.price_html) {
                            if (jQuery('.form-head').length > 0) {
                                if (response.price_html) {
                                    jQuery('.form-head').html(response.price_html);
                                }
                            }
                            if (jQuery('.hotel-target-book-mobile').length > 0) {
                                jQuery('.hotel-target-book-mobile .price-wrapper').html(response.price_html);
                            }
                            jQuery('.message_box').html('');
                            jQuery('div.message-wrapper').html("");
                        } else {
                            if(priceWrapper.length) {
                                priceWrapper.hide();
                            }
                            if (response.message) {
                                jQuery('.message-wrapper').html(response.message);
                            }
                        }

                    }
                    requestRunning = false;
                }
            });
            requestRunning = true;
        },
        init: function () {
            let base = this;
            base._resize(base.$body);
            base._getAvalibility(base.$body);
            base._putGuestName();
            base._bookingRentalAjax();
            if(st_params.caculator_price_single_ajax === 'on'){
                if($('.single-st_rental .single-room-form').length > 0) {
                    base._checkBookingFormAjaxRental(base.$body);
                }
            }
            
            base._stReviewSingleRoom(base.$body);
        },
        _resize:function(body){
            
            //Slider gallery single hotel detail
            if (window.matchMedia('(min-width: 992px)').matches) {
                $('.st-gallery', body).each(function () {
                    var parent = $(this);
                    var $fotoramaDiv = $('.fotorama', parent).fotorama({
                        width: parent.data('width'),
                        nav: parent.data('nav'),
                        thumbwidth: '135',
                        thumbheight: '135',
                        allowfullscreen: parent.data('allowfullscreen')
                    });
                    parent.data('fotorama', $fotoramaDiv.data('fotorama'));
                });
            } else {
                $('.st-gallery', body).each(function () {
                    var parent = $(this);
                    if (typeof parent.data('fotorama') !== 'undefined') {
                        parent.data('fotorama').destroy();
                    }
                    var $fotoramaDiv = $('.fotorama', parent).fotorama({
                        width: parent.data('width'),
                        nav: parent.data('nav'),
                        thumbwidth: '80',
                        thumbheight: '80',
                        allowfullscreen: parent.data('allowfullscreen')
                    });
                    parent.data('fotorama', $fotoramaDiv.data('fotorama'));
                });
            }
            if (window.matchMedia('(min-width: 992px)').matches) {
                $('.full-map').show();
            } else {
                $('.full-map').hide();
            }
            if (window.matchMedia('(max-width: 991px)').matches) {
                $('.as').slideDown();
            }

        },
        _getAvalibility: function(body){
            
            $('.st-availability', body).each(function () {
                
                var t = $(this);
                var container = $('.st-calendar', t);
                var calendar = $('.calendar_input', container);
                var options = {
                    parentEl: container,
                    showCalendar: true,
                    alwaysShow: true,
                    autoUpdateInput: true,
                    singleDatePicker: false,
                    showTodayButton: false,
                    autoApply: true,
                    disabledPast: true,
                    responSingle: true,
                    widthCalendar: 750,
                    onlyShowCurrentMonth: true,
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
                            action: calendar.data('action'),
                            start: start.format('YYYY-MM-DD'),
                            end: end.format('YYYY-MM-DD'),
                            post_id: calendar.data('room-id'),
                            security: st_params._s
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
                calendar.daterangepicker(options, function (start, end, label) {
                });
                var dp = calendar.data('daterangepicker');
                dp.show();
            });
        },
        _stReviewSingleRoom: function(body){
            $('.review-form .review-items .rates .fa').each(function () {
                var list = $(this).parent(),
                        listItems = list.children(),
                        itemIndex = $(this).index(),
                        parentItem = list.parent();
        
                $(this).on('mouseenter', function () {
                    for (var i = 0; i < listItems.length; i++) {
                        if (i <= itemIndex) {
                            $(listItems[i]).addClass('hovered');
                        } else {
                            break;
                        }
                    }
                    $(this).on('click',function () {
                        for (var i = 0; i < listItems.length; i++) {
                            if (i <= itemIndex) {
                                $(listItems[i]).addClass('selected');
                            } else {
                                $(listItems[i]).removeClass('selected');
                            }
                        }
                        ;
                        parentItem.children('.st_review_stats').val(itemIndex + 1);
                    });
                });
        
                $(this).on('mouseleave', function () {
                    listItems.removeClass('hovered');
                });
            });
            $('.review-form .st-stars .fa').each(function () {
                var list = $(this).parent(),
                        listItems = list.children(),
                        itemIndex = $(this).index(),
                        parentItem = list.parent();
                $(this).on('mouseenter', function () {
                    for (var i = 0; i < listItems.length; i++) {
                        if (i <= itemIndex) {
                            $(listItems[i]).addClass('hovered');
                        } else {
                            break;
                        }
                    }
                    $(this).on('click',function () {
                        for (var i = 0; i < listItems.length; i++) {
                            if (i <= itemIndex) {
                                $(listItems[i]).addClass('selected');
                            } else {
                                $(listItems[i]).removeClass('selected');
                            }
                        }
                        parentItem.children('.st_review_stats').val(itemIndex + 1);
                    });
                });
                $(this).on('mouseleave', function () {
                    listItems.removeClass('hovered');
                });
            });
        },
        _putGuestName: function(){
            //--------------- Guest Name Inputs -------------------------

            var adultNumber = $('.form-has-guest-name input[name="adult_number"]');
            var childrenNumber = $('.form-has-guest-name input[name="child_number"]');
            var guestNameInput = $('.form-has-guest-name .guest_name_input');
            adultNumber.on('change', triggerGuestInputChange);
            childrenNumber.on('change', triggerGuestInputChange);

            function triggerGuestInputChange(e) {
                guestNameInput.trigger('guest-change', {
                    'adult': parseInt(adultNumber.val()),
                    'children': parseInt(childrenNumber.val()),
                });
            }
            ;

            guestNameInput.on('guest-change', function (e, number) {
                var adult = number.adult;
                var children = number.children;
                var hideAdult = $(this).data('hide-adult');
                var hideChildren = $(this).data('hide-children');
                var controlWraps = $(this).find('.guest_name_control');
                var controls = controlWraps.find('.control-item');
                if (isNaN(children))
                    children = 0;

                if (hideAdult == 'on') {
                    adult = 0;
                }

                if (typeof hideChildren == 'undefined' || hideChildren != 'on')
                    adult += children;
                

                //adult-=1;// Only input guest >=2 name

                if (adult <= 0) {
                    $(this).addClass('d-none');
                } else {
                    // Append
                    for (var i = controls.length ? (controls.length) : 0; i < adult; i++)
                    {
                        var div = $($('#guest_name_control_item').clone().html());
                        var p = div.find('input').attr('placeholder');
                        div.find('input').attr('placeholder', p.replace('%d', i + 1));

                        controlWraps.append(div);
                    }

                    // Remove
                    controls.each(function () {
                        if ($(this).index() > adult - 1)
                        {
                            $(this).remove();
                        }
                    });

                    $(this).removeClass('d-none');
                }
            });

            triggerGuestInputChange();
        //------------------End Guest Name Inputs -------------------
        },
        _bookingRentalAjax: function(){
            $('form.rental-booking-form').on('click', 'button.btn-book-ajax', function (e) {
                e.preventDefault();
                var form = $('form.rental-booking-form');
                var data = $('form.rental-booking-form').serializeArray();
                var loadingSubmit = form.find('button[name=submit]');
                $(loadingSubmit).find("i.fa-spin").removeClass("hide");
                data.push({
                    name: 'security',
                    value: st_params._s
                });
                $('div.message-wrapper').html("");
                $.ajax({
                    url: st_params.ajax_url,
                    method: "post",
                    dataType: 'json',
                    data: data,
                    beforeSend: function () {
                        $('div.message-wrapper').html("");
                    },
                    success: function (res) {
                        $(loadingSubmit).find('i.fa-spin').addClass("hide");
                        if (res) {
                            if (res.status) {
                                if (res.redirect) {
                                    window.location = res.redirect;
                                }
                            } else {
                                if (res.message) {
                                    $('#form-booking-inpage .message-wrapper').html(res.message);
                                }
                            }
                        }
                    },
                    error: function (err) {
                        $('div.message-wrapper').html("");
                        $(loadingSubmit).find('i.fa-spin').addClass("hide");
                    }
                });
            });
        },
        _stDateFieldCheckInCheckOut: function (body) {
            $('.form-date-hotel-room', body).each(function () {
                var parent = $(this),
                    date_wrapper = $('.date-wrapper', parent),
                    check_in_input = $('.check-in-input', parent),
                    check_out_input = $('.check-out-input', parent),
                    check_in_out = $('.check-in-out', parent),
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
                            action: check_in_out.data('action'),
                            start: start.format('YYYY-MM-DD'),
                            end: end.format('YYYY-MM-DD'),
                            post_id: check_in_out.data('room-id'),
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
        
                if (typeof availabilityDate != 'undefined') {
                    options['minDate'] = availabilityDate;
                }
        
                if (typeof locale_daterangepicker == 'object') {
                    options.locale = locale_daterangepicker;
                }
                check_in_out.daterangepicker(options,
                    function (start, end, label) {
                        check_in_input.val(start.format(parent.data('format'))).trigger('change');
                        check_in_render.html(start.format(parent.data('format'))).trigger('change');
                        check_out_input.val(end.format(parent.data('format'))).trigger('change');
                        check_out_render.html(end.format(parent.data('format'))).trigger('change');
                        if(st_params.caculator_price_single_ajax === 'on'){
                            if($('.single-st_rental .single-room-form').length > 0) {
                                date_wrapper.trigger('rental-booking-form');
                            }
                        }
                });
        
        
                date_wrapper.on('click',function (e) {
                    check_in_out.trigger('click');
        
                });
        
                
                check_in_out.on('apply.daterangepicker', function(ev, picker) {
                    if(st_params.caculator_price_single_ajax === 'on'){
                        if($('.single-hotel_room .single-room-form').length > 0) {
                            $('.hotel-room-booking-form').trigger('hotel-room-booking-form');
                        }
                    }
                    
                });
            });
        },
        _checkBookingFormAjaxRental: function(body){
            $( ".rental-booking-form" ).on( "rental-booking-form", function( event ) {
                SingleRentalDetail.renderHtmlRental();
            });
            if($('.rental-booking-form').length > 0) {
                var ci_rental = 0;
                $(' .check-in-input').on('change', function (e) {
                    if (ci_rental != 0) {
                        SingleRentalDetail.renderHtmlRental();
                    }
                    ci_rental++;
                });
                var flag = false;
                if ($('.form-date-search').length > 0) {
                    $('.form-date-search').each(function () {
                        var st_guest = $(this).closest('.form-guest-search');
                            st_guest.find('.st-input-number').on('change',function(){
                                SingleRentalDetail.renderHtmlRental();
                        })

                        $(this).find('.form-control.st-input-number').on('change',function(){
                            SingleRentalDetail.renderHtmlRental();
                        })
                    });
                }
                if ($('.form-more-extra .extras').length > 0) {
                    $('.form-more-extra .extras li').each(function () {
                        $(this).find('.extra-service-select').on('change',function(){
                            SingleRentalDetail.renderHtmlRental();
                        })
                    });
                }
                if (flag) {
                    SingleRentalDetail.renderHtmlRental();
                }

            }

            
        }
    }
    SingleRentalDetail.init();
})(jQuery);