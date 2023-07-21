;(function ($) {
    "use strict";
    let SingleTourDetail = {
        $body: $('body'),
        renderHtmlTour(){
            var form = jQuery('form.tour-booking-form');
            var data = jQuery('form.tour-booking-form').serializeArray();
            jQuery('.loader-wrapper').hide();
            data.push({
                name: 'security',
                value: st_params._s
            });
            for (var i = 0; i < data.length; i++) {
                if(data[i].name === 'action'){
                    data[i]['value'] = 'st_format_tour_price';
                }
            };
            jQuery.ajax({
                method: "post",
                dataType: 'json',
                data: data,
                url: st_params.ajax_url,
                beforeSend: function () {
                    jQuery('div.message-wrapper').html("");
                    jQuery('.loader-wrapper').show();
                    jQuery('.message_box').html('');
                },
                success: function (response) {
                    jQuery('.loader-wrapper').hide();
                    if (response) {
                        console.log(response);
                        if (response.price_html) {
                            if (jQuery('.form-head .price').length > 0) {
                                jQuery('.form-head .price').html(response.price_html);
                            }
                            if (jQuery('.st-tour-booking__price--item').length > 0) {
                                jQuery('.st-tour-booking__price--item').html(response.price_html);
                            }
                            if (jQuery('.hotel-target-book-mobile').length > 0) {
                                jQuery('.hotel-target-book-mobile .price-wrapper').html(response.price_html);
                            }
                            jQuery('.message_box').html('');
                            jQuery('div.message-wrapper').html("");
                        } else {
                            if(response.message){
                                jQuery('#form-booking-inpage .message-wrapper').html('<div class="alert alert-danger"> <button type="button" class="close" data-bs-dismiss="alert" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> '+response.message+ ' </div>');
                            } else {
                                if(response.price_from){
                                    if (jQuery('.form-head .price').length >= 0) {
                                        jQuery('.form-head .price').html(response.price_from);
                                        
                                    }
                                }
                            }
                            
                        }
                    }
                }
            });
        },
        ajaxSelectStartTime: function(tour_id, check_in, check_out, select_starttime, posttype = 'st_tours') {
            var sparent = $('.fixed-on-mobile');
            var overlay = $('.loader-wrapper', sparent);
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
            overlay.hide();
            $.ajax({
                url: st_params.ajax_url,
                dataType: 'json',
                type: 'post',
                data: data,
                beforeSend: function () {
                    overlay.show();
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
                        overlay.hide();
                    } else {
                        $('#starttime_box').parent().hide();
                        overlay.hide();
                    }
                },
            });
        },
        init: function () {
            let base = this;
            let iex = 0;
            base._itinerary(iex);
            base._sliderineraryStyle2();
            base._dropDateformBooking(base.$body);
            base._popupPackage(base.$body);
            if(st_params.caculator_price_single_ajax === 'on'){
                if($('.single-st_tours .form-date-search').length > 0) {
                    base._checkBookingFormAjaxTour(base.$body);
                }
            }
            
            base._bookingTourAjax();
            base._popupGallery();
            base._putGuestName();
            
        },
        _putGuestName: function(){
            //--------------- Guest Name Inputs -------------------------

            var adultNumber = $('.form-has-guest-name input[name="adult_number"]');
            var childrenNumber = $('.form-has-guest-name input[name="child_number"]');
            var infantNumber = $('.form-has-guest-name input[name="infant_number"]');
            var guestNameInput = $('.form-has-guest-name .guest_name_input');
            adultNumber.on('change', triggerGuestInputChange);
            childrenNumber.on('change', triggerGuestInputChange);
            infantNumber.on('change', triggerGuestInputChange);

            function triggerGuestInputChange(e) {
                guestNameInput.trigger('guest-change', {
                    'adult': parseInt(adultNumber.val()),
                    'children': parseInt(childrenNumber.val()),
                    'infant': parseInt(infantNumber.val()),
                });
            }
            ;

            guestNameInput.on('guest-change', function (e, number) {
                var adult = number.adult;
                var children = number.children;
                var infant = number.infant;
                var hideAdult = $(this).data('hide-adult');
                var hideChildren = $(this).data('hide-children');
                var controlWraps = $(this).find('.guest_name_control');
                var controls = controlWraps.find('.control-item');
                if (isNaN(children)){
                    children = 0;
                }
                    
                if (isNaN(infant)){
                    infant = 0;
                }
                    
                if (hideAdult == 'on') {
                    adult = 0;
                }

                if (typeof hideChildren == 'undefined' || hideChildren != 'on'){
                    adult += children+infant;
                }
                    
                

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
        _popupGallery: function(){
            if($('.st-style-elementor').length){
                $('.st-gallery-popup').on('click', function (e) {
                    e.preventDefault();
                    var gallery = $(this).attr('href');
                    $(gallery).magnificPopup({
                        delegate: 'a',
                        type: 'image',
                        closeMarkup: '<button class="mfp-close"><i class="stt-icon-close"></i></button>',
                        gallery: {
                            enabled: true,
                            arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow stt-icon-arrow-%dir%"></button>',
                        },
                    }).magnificPopup('open');
                });

                $('.st-list-item-gallery').magnificPopup({
                    delegate: 'a', // child items selector, by clicking on it popup will open
                    type: 'image',
                    mainClass: 'stt-single-popup'
                    // other options
                });

                
            } else {
                
                
                if($('.single-st_tours').length){
                    $('.st-gallery-popup').on('click',function (e) {
                        e.preventDefault();
                        var gallery = $(this).attr('href');
                        $(gallery).magnificPopup({
                            delegate: 'a',
                            type: 'image',
                            gallery: {
                                enabled: true
                            },
                        }).magnificPopup('open');
                    });
                }
            }
            
        },
        _bookingTourAjax(){
            $('form.tour-booking-form').on('click', 'button.btn-book-ajax', function (e) {
                e.preventDefault();
                var form = $('form.tour-booking-form');
                var data = $('form.tour-booking-form').serializeArray();
                var loadingSubmit = form.find('button[name=submit]');
                $(loadingSubmit).find("i.fa-spin").removeClass("d-none");
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
                        $(loadingSubmit).find('i.fa-spin').addClass("d-none");
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
                        $(loadingSubmit).find('i.fa-spin').addClass("d-block");
                    }
                });
            });
        },
        _checkBookingFormAjaxTour(body){
            jQuery(function($){
                $( ".date-wrapper" ).on( "tours-booking-form", function( event ) {
                    SingleTourDetail.renderHtmlTour();
                });
            });
            if($('.tour-booking-form').length > 0) {
                var citour = 0;
                $(' .check-in-input').on('change', function (e) {
                    if (citour != 0) {
                        SingleTourDetail.renderHtmlTour();
                    }
                    citour++;
                });
                var flag = false;
                if ($('.guest-wrapper').length > 0) {
                    $('.guest-wrapper').each(function () {
                        $(this).find('.form-control.st-input-number').on('change',function(){
                            SingleTourDetail.renderHtmlTour();
                        })
                    });
                }
                if ($('#st-package-popup').length > 0) {
                    $('#st-package-popup .mfp-close').on('click',function(){
                        SingleTourDetail.renderHtmlTour();
                    });
                }
                if ($('.form-more-extra .extras').length > 0) {
                    $('.form-more-extra .extras li').each(function () {
                        $(this).find('.extra-service-select').on('change',function(){
                            SingleTourDetail.renderHtmlTour();
                        })
                    });
                }
                if ($('.form-more-extra-solo').length > 0) {
                    $('.st-package-popup-solo  li').each(function () {
                        $(this).find('.extra-service-select').on('change',function(){
                            SingleTourDetail.renderHtmlTour();
                        })
                    });
                    $('.form-more-extra-solo li.item').each(function () {
                        $(this).find('.extra-service-select').on('change',function(){
                            SingleTourDetail.renderHtmlTour();
                        })
                    });
                     
                }
                if($('.st-form-starttime').length > 0){
                    $('.st_tour_starttime').each(function () {
                        $(this).on('change',function(){
                            SingleTourDetail.renderHtmlTour();
                        })
                    });
                }
    
            }
        },
        _dropDateformBooking: function(body){
            
            $('.st-single-tour .form-date-search', body).each(function () {
                let parent = $(this),
                    date_wrapper = $('.date-wrapper', parent),
                    check_in_input = $('.check-in-input', parent),
                    check_out_input = $('.check-out-input', parent),
                    check_in_out_input = $('.check-in-out-input', parent),
                    check_in_render = $('.check-in-render', parent),
                    check_out_render = $('.check-out-render', parent),
                    sts_checkout_label = $('.sts-tour-checkout-label', parent),
                    availabilityDate = $(this).data('availability-date');
                    let customClass = $('.date-wrapper', parent).data('custom-class') || '';
        
                    let options = {
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
                    customClass: customClass,
                    fetchEvents: function (start, end, el, callback) {
                        let events = [];
                        if (el.flag_get_events) {
                            return false;
                        }
                        el.flag_get_events = true;
                        el.container.find('.loader-wrapper').show();
                        let data = {
                            action: check_in_out_input.data('action'),
                            start: start.format('YYYY-MM-DD'),
                            end: end.format('YYYY-MM-DD'),
                            //tour_id: check_in_out_input.data('tour-id'),
                            security: st_params._s
                        };
                        let postType = check_in_out_input.data('posttype');
                        if (typeof postType !== 'undefined' && postType === 'st_activity') {
                            data['activity_id'] = check_in_out_input.data('tour-id');
                        } else {
                            data['tour_id'] = check_in_out_input.data('tour-id');
                        }
        
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
                check_in_out_input.daterangepicker(options,
                    function (start, end, label, elmDate) {
                        check_in_input.val(start.format(parent.data('format'))).trigger('change');
                        check_out_input.val(end.format(parent.data('format'))).trigger('change');
                        check_in_render.html(start.format(parent.data('format'))).trigger('change');
                        check_out_render.html(end.format(parent.data('format'))).trigger('change');
                        if (start.format(parent.data('format')).toString() == end.format(parent.data('format')).toString()) {
                            sts_checkout_label.hide();
                        } else {
                            sts_checkout_label.show();
                        }
                        if (typeof elmDate !== 'undefined' && elmDate !== false) {
                            if ($('.st-single-tour').length > 0) {
                                if (elmDate.target.classList.contains('has_starttime')) {
                                    SingleTourDetail.ajaxSelectStartTime(check_in_out_input.data('tour-id'), start.format(parent.data('format')), end.format(parent.data('format')), '', check_in_out_input.data('posttype'));
                                } else {
                                    $('#starttime_tour option').remove();
                                    $('#starttime_box').parent().hide();
                                }
                            }
                        }
                        if(st_params.caculator_price_single_ajax === 'on'){
                            if($('.single-st_tours').length > 0) {
                                date_wrapper.trigger('tours-booking-form');
                            }
                            
                            if($('.single-st_activity').length > 0) {
                                date_wrapper.trigger('activity-booking-form');
                            }
                            
                        }
        
                    });
                date_wrapper.on('click',function (e) {
                    check_in_out_input.trigger('click');
                });
            });
        },
        _itinerary: function(iex){
            //Toggle Itinerary
            $('.st-program-list').each(function () {
                let t = $(this);
                $('.item .header', t).on('click',function () {
                    $('.st-program .expand').text($('.st-program .expand').data('text-more'));
                    iex = 0;
                    $('.item', t).removeClass('active');
                    $(this).parent().toggleClass('active');
                });
            });
        },
        _sliderineraryStyle2: function(){
            $('.owl-tour-program').each(function () {
                var parent = $(this).parent();
                var owl = $(this);
                owl.owlCarousel({
                    loop: false,
                    items: 3,
                    margin: 20,
                    responsiveClass: true,
                    dots: false,
                    nav: false,
                    responsive: {
                        0: {
                            items: 1,
                            margin: 15,
                        },
                        992: {
                            items: 2,
                        },
                        1200: {
                            items: 3,
                        }
                    }
                });
                $('.next', parent).on('click',function (ev) {
                    ev.preventDefault();
                    owl.trigger('next.owl.carousel');
                });
                $('.prev', parent).on('click',function (ev) {
                    ev.preventDefault();
                    owl.trigger('prev.owl.carousel');
                });
                owl.on('resized.owl.carousel', function () {
                    setTimeout(function () {
                        if ($('.ovscroll').length) {
                            $.fn.getNiceScroll && $('.ovscroll').getNiceScroll().resize();
                        }
                    }, 1000);
                });
            });
        },
        _popupPackage: function(body){
            if (!Number.prototype.getDecimals) {
                Number.prototype.getDecimals = function () {
                    var num = this,
                        match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                    if (!match) {
                        return 0;
                    }
                    return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
                }
            }
            $('.st-faq .item').each(function () {
                var t = $(this);
                t.find('.header').on('click',function () {
                    $('.st-faq .item').not(t).removeClass('active');
                    t.toggleClass('active');
                });
            });
            if ($('.st-form-package').length) {
                if($('.st-header-9').length){
                    var closeMarkup = '<button class="mfp-close"><i class="stt-icon-close"></i></button>';
                } else {
                    var closeMarkup = '<button title="Close (Esc)" type="button" class="mfp-close"></button>';
                }
                $('.st-form-package').magnificPopup({
                    removalDelay: 500,
                    closeBtnInside: true,
                    closeMarkup: closeMarkup,
                    alignTop:false,
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = this.st.el.attr('data-effect');
                        },
                        afterClose: function() {
                            if(st_params.caculator_price_single_ajax === 'on'){
                                if($('.single-st_tours .st-form-package').length > 0) {
                                    SingleTourDetail.renderHtmlTour();
                                }
                                if($('.single-st_activity .st-form-package').length > 0) {
                                    SingleTourDetail.renderHtmlActivity();
                                }
                            }
                        },
                    },
                    midClick: true,
                });
            }
            if (window.matchMedia('(max-width: 768px)').matches) {
                $('.as').slideDown();
            }
            if (window.matchMedia('(min-width: 991px)').matches) {
                var c = 0;
                var c1 = 0;
                $(window).on('scroll',function (event) {
                    if ($('#btn-show-map').is(':checked') && $('.page-half-map').length) {
                        var scroll = $(window).scrollTop();
                        var topEl = $('.st-hotel-result').offset().top;
                        var colLeft = $('.page-half-map .col-left').height();
                        var divResult = $('#modern-search-result').height();
                        if (scroll >= topEl) {
                            if (divResult >= colLeft) {
                                if (c == 0) {
                                    if ($("body").hasClass('rtl')) {
                                        if($.fn.niceScroll){
                                            $('.page-half-map').find('.col-left').niceScroll({railalign: 'left'});
                                        }
    
                                    } else {
                                        if($.fn.niceScroll){
                                            $('.page-half-map').find('.col-left').niceScroll();
                                        }
    
                                    }
                                    c = 1;
                                    $('.as').slideUp();
                                }
                            } else {
                                $.fn.getNiceScroll && $('.page-half-map').find('.col-left').getNiceScroll().remove();
                                $('.as').slideDown(50);
                            }
                        } else {
                            $('.as').slideUp();
                            if (c == 1) {
                                $.fn.getNiceScroll && $('.page-half-map').find('.col-left').animate({scrollTop: 0}).getNiceScroll().remove();
                                c = 0;
                            }
                        }
                    }
                });
                $('.page-half-map .col-left').on('scroll',function (event) {
                    var scroll = $(window).scrollTop();
                    var topEl = $('.st-hotel-result').offset().top;
                    if ($('#btn-show-map').is(':checked')) {
                        var t = $(this);
                        if (t.scrollTop() <= 0) {
                            if (c == 1) {
                                $.fn.getNiceScroll && $('.page-half-map').find('.col-left').getNiceScroll().remove();
                                window.scrollTo({
                                    top: topEl - 1,
                                });
                                c = 0;
                            }
                        } else if (typeof t.getNiceScroll()[0] != 'undefined') {
                            if (t.getNiceScroll()[0].page.maxh <= t.scrollTop()) {
                                $('.page-half-map').find('.col-left').getNiceScroll().remove();
                                $('.as').slideDown('slow');
                                c = 1;
                            }
                        }
                    }
                });
            }
            jQuery(document.body).on('click', '.caculator-item .fa-plus, .caculator-item .fa-minus , .caculator-item .stt-icon-add, .caculator-item .stt-icon-minus', function ($) {
                var $qty = jQuery(this).parent().find('.extra-service-select'),
                    currentVal = parseFloat($qty.val()),
                    max = parseFloat($qty.attr('max')),
                    min = parseFloat($qty.attr('min')),
                    step = parseInt($qty.attr('step'));
            
                // Format values
                if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                if (max === '' || max === 'NaN') max = '';
                if (min === '' || min === 'NaN') min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;
                
                // Change the value
                if (jQuery(this).is('.fa-plus, .stt-icon-add')) {
                    if (max && (currentVal >= max)) {
                        $qty.val(max);
                    } else {
                        $qty.val((currentVal + parseFloat(step)).toFixed(step.getDecimals()));
                    }
                } else {
                    if (min && (currentVal <= min)) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        $qty.val((currentVal - parseFloat(step)).toFixed(step.getDecimals()));
                    }
                }
            
                // Trigger change event
                $qty.trigger('change');
                $qty.trigger('tour-booking-form');
            });
        },
    }
    SingleTourDetail.init();
})(jQuery);