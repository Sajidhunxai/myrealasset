(function ($) {
    'use strict';
    window.extraServicesFunction = function(el){
        el.find('.item  .form-more-extra').each(function(){
            var t = $(this);
            t.find('.dropdown').on('click',function (e) {
                e.preventDefault();
                el.find('.item  .form-more-extra .extras').not(t.find('.extras')).hide();
                t.find('.extras').stop(true, true).slideToggle();
            })
        });

        if(el.find('.item  .form-more-extra').length){
            $(document).mouseup(function(e)
            {
                var container = el.find('.item  .form-more-extra .extras, .item  .form-more-extra .dropdown');
                if (!container.is(e.target) && container.has(e.target).length === 0)
                {
                    el.find('.item  .form-more-extra .extras').hide();
                }
            });
        }
    }

    if($('.vinhome-slider-wrapper').length > 0) {
        $('.vinhome-slider-wrapper').vinhomeSlider({
            effect: 'vinhome-slider-scale-transform',
            autoplay: true,
            interval: $(this).data('interval'),
            stopHover: true
        });
    }
})(jQuery);

jQuery(function($) {
    if($('.main-slider.slider').length) {
        var heightSlider = $('.main-slider.slider').outerHeight();
        $('.st-bg-slider').fotorama({
            height: heightSlider
        });
    }


    /*Datepicker*/
    $('.item-search-content .options').on('click',function () {
        $(this).find('.wpbooking-check-in-out').trigger('click');
        $(this).closest('.template-hotel-activity_submit').find('.wpbooking-check-in-out').trigger('click');
    })

    $('.item-search-content .wpbooking-date-start').on('change',function () {
        var parent = $(this).closest('.item-search-content');
        var day    = parent.find('.checkin_d').val();
        var month  = parent.find('.checkin_m').val();
        var year   = parent.find('.checkin_y').val();
        parent.find('.day span').html(pad(day));
        parent.find('.month-year span').html(number_to_monteh(pad(month)) +", "+year);
    });


    $('.item-search-content .wpbooking-date-end').on('change',function () {
        var parent = $(this).closest('.item-search-content');
        var day    = parent.find('.checkout_d').val();
        var month  = parent.find('.checkout_m').val();
        var year   = parent.find('.checkout_y').val();
        parent.find('.day span').html(pad(day));
        parent.find('.month-year span').html(number_to_monteh(pad(month)) +", "+year);
    });
    /**
     * Date time picker in the check available section
     */

    $('.sts-check-available-form .st-room-check-available .sts-date-start').on('change',function () {
        var parent = $(this).closest('.item');
        var day    = parent.find('.checkin_d').val();
        var month  = parent.find('.checkin_m').val();
        var year   = parent.find('.checkin_y').val();
        parent.find('.value').html(pad(day));
        parent.find('.sub-label').html(number_to_monteh(pad(month)) +", "+year);
    });


    $('.sts-check-available-form .st-room-check-available .sts-date-end').on('change',function () {
        var parent = $(this).closest('.item');
        var day    = parent.find('.checkout_d').val();
        var month  = parent.find('.checkout_m').val();
        var year   = parent.find('.checkout_y').val();
        parent.find('.value').html(pad(day));
        parent.find('.sub-label').html(number_to_monteh(pad(month)) +", "+year);
    });
    $('.sts-check-available-form-style2 .st-room-check-available .sts-date-start').on('change',function () {
        var parent = $(this).closest('.item');
        var day    = parent.find('.checkin_d').val();
        var month  = parent.find('.checkin_m').val();
        var start   = parent.find('.sts-date-start').val();
        parent.find('.value').html(start);

    });


    $('.sts-check-available-form-style2 .st-room-check-available .sts-date-end').on('change',function () {
        var parent = $(this).closest('.item');
        var day    = parent.find('.checkout_d').val();
        var month  = parent.find('.checkout_m').val();
        var end   = parent.find('.sts-date-end').val();
        parent.find('.value').html(end);

    });

    $('.sts-check-available-form .st-room-check-available').each(function () {

        var check_in     = $(this).find('.sts-date-start');
        var check_out    = $(this).find('.sts-date-end');
        var check_in_out = $(this).find('.sts-check-in-out');
        var date_group   = $(this).find('.item');

        date_group.find('.value, .sub-label').on('click',function () {
            $(this).closest('.sts-form-wrapper').find('.sts-check-in-out').trigger('click');
        });

        var dateToday = new Date();
        var options = {
            singleDatePicker: false,
            autoApply       : true,
            disabledPast    : true,
            dateFormat      : hotel_alone_params.dateformat,
            minDate: dateToday,
            customClass         : '',
            widthSingle         : 500,
            firstDay: 1
        };
        if (typeof  locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                $('.checkin_d', date_group).val(start.format('DD'));
                $('.checkin_m', date_group).val(start.format('MM'));
                $('.checkin_y', date_group).val(start.format('YYYY'));
                check_in.val(start.format(hotel_alone_params.dateformat)).trigger('change');

                $('.checkout_d', date_group).val(end.format('DD'));
                $('.checkout_m', date_group).val(end.format('MM'));
                $('.checkout_y', date_group).val(end.format('YYYY'));
                check_out.val(end.format(hotel_alone_params.dateformat)).trigger('change');
            });
        $(this).find('.sts-date-end').on('focus', function () {
            check_in_out.trigger('click');
        });
        $(this).find('.sts-date-start').on('focus', function () {
            check_in_out.trigger('click');
        });
    });
    $('.sts-check-available-form-style2 .st-room-check-available').each(function () {
        var check_in     = $(this).find('.sts-date-start');
        var check_out    = $(this).find('.sts-date-end');
        var check_in_out = $(this).find('.sts-check-in-out');
        var date_group   = $(this).find('.item');

        date_group.find('.value').on('click',function () {
            $(this).closest('.sts-form-wrapper').find('.sts-check-in-out').trigger('click');
        });

        var dateToday = new Date();
        var options = {
            singleDatePicker: false,
            autoApply       : true,
            disabledPast    : true,
            dateFormat      : hotel_alone_params.dateformat,
            minDate: dateToday,
            customClass         : 'calendar-style-2',
            widthSingle         : 500,
            firstDay: 1
        };
        if (typeof  locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                $('.checkin_d', date_group).val(start.format('DD'));
                $('.checkin_m', date_group).val(start.format('MM'));
                $('.checkin_y', date_group).val(start.format('YYYY'));
                check_in.val(start.format(hotel_alone_params.dateformat)).trigger('change');

                $('.checkout_d', date_group).val(end.format('DD'));
                $('.checkout_m', date_group).val(end.format('MM'));
                $('.checkout_y', date_group).val(end.format('YYYY'));
                check_out.val(end.format(hotel_alone_params.dateformat)).trigger('change');
            });
        $(this).find('.sts-date-end').on('focus', function () {
            check_in_out.trigger('click');
        });
        $(this).find('.sts-date-start').on('focus', function () {
            check_in_out.trigger('click');
        });
    });


    function number_to_monteh(number) {
        switch (number) {
            case"01":
                return hotel_alone_params.month_1;
                break;
            case"02":
                return hotel_alone_params.month_2;
                break;
            case"03":
                return hotel_alone_params.month_3;
                break;
            case"04":
                return hotel_alone_params.month_4;
                break;
            case"05":
                return hotel_alone_params.month_5;
                break;
            case"06":
                return hotel_alone_params.month_6;
                break;
            case"07":
                return hotel_alone_params.month_7;
                break;
            case"08":
                return hotel_alone_params.month_8;
                break;
            case"09":
                return hotel_alone_params.month_9;
                break;
            case"10":
                return hotel_alone_params.month_10;
                break;
            case"11":
                return hotel_alone_params.month_11;
                break;
            case"12":
                return hotel_alone_params.month_12;
                break;
        }
    }
    function pad(d) {
        d = parseInt(d);
        return (d < 10) ? '0' + d.toString() : d.toString();
    }

    $('.st-filter').each(function () {
        var check_in     = $(this).find('.wpbooking-date-start');
        var check_out    = $(this).find('.wpbooking-date-end');
        var check_in_out = $(this).find('.wpbooking-check-in-out');
        var date_group   = $(this).find('.item-search-content');
        var customClass  = 'single-hotel';
        console.log(customClass);
        var dateToday = new Date();
        var options = {
            singleDatePicker: false,
            autoApply       : true,
            disabledPast    : true,
            dateFormat      : hotel_alone_params.dateformat,
            customClass     : customClass,
            minDate: dateToday,
        };
        if (typeof  locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                $('.checkin_d', date_group).val(start.format('DD'));
                $('.checkin_m', date_group).val(start.format('MM'));
                $('.checkin_y', date_group).val(start.format('YYYY'));
                check_in.val(start.format(hotel_alone_params.dateformat)).trigger('change');

                $('.checkout_d', date_group).val(end.format('DD'));
                $('.checkout_m', date_group).val(end.format('MM'));
                $('.checkout_y', date_group).val(end.format('YYYY'));
                check_out.val(end.format(hotel_alone_params.dateformat)).trigger('change');
            });
        check_in.on('focus', function () {
            check_in_out.trigger('click');
        });

        check_out.on('focus', function () {
            check_in_out.trigger('click');
        });
    });


    /* Match Height Render */
    var body = $('body');
    if ($('.has-matchHeight', body).length) {
        $('.has-matchHeight', body).matchHeight();
    }
});

jQuery(function($){
    $(document).ready(function(){
        var body = $('body');
        $('.st-discover-slider').each(function () {
            $(this).owlCarousel({
                loop:true,
                items: 3,
                margin: 0,
                responsiveClass:true,
                navigation: true,
                responsive:{
                    0:{
                        items:1,
                    },
                    575:{
                        items:2,
                    },
                    992:{
                        items:3,
                    },
                    1200:{
                        items:3,
                    }
                }
            });
        });

        //Add to cart in list room page
        $(document).on('click', '.sts-room-wrapper .item .action .btn-booknow', function (e) {
            e.preventDefault();
            var t = $(this).closest('.sts-room-wrapper .item'),
                    messageBox = t.find('.action .message'),
                    loading = $(this).find('i');

            if(t.find('.action select').val() == ''){
                messageBox.text(hotel_alone_params.number_room_required).show();
                if ($('.has-matchHeight', body).length) {
                    $('.has-matchHeight', body).matchHeight();
                }
            }else{
                loading.css({display: 'inline-block'});
                messageBox.text('').hide();
                var data = t.find('.action form').serializeArray();
                $.ajax({
                    'type': 'post',
                    'dataType': 'json',
                    'url': hotel_alone_params.ajax_url,
                    'data': data,
                    success: function (data) {
                        loading.css({display: 'none'});
                        if (data.message) {
                            messageBox.text(data.message).show();
                        }
                        if (data.status) {
                            var cartLink = hotel_alone_params.add_to_cart_link;
                            window.location.href = cartLink;
                        }
                        if ($('.has-matchHeight', body).length) {
                            $('.has-matchHeight', body).matchHeight();
                        }
                    },
                    error: function (data) {
                        loading.css({display: 'none'});
                    }
                })
            }
        });

        //Check availability in single room
        $('.sts-booking-form .sts-single-room-check').on('click',function (e) {
            e.preventDefault();
            var t = $(this),
                sform = t.closest('form'),
                loading = t.find('i'),
                messageBox = sform.find('.message');

            loading.css({display: 'inline-block'});
            messageBox.text('').hide();

            var data = sform.serializeArray();

            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'url': hotel_alone_params.ajax_url,
                'data': data,
                success: function (data) {
                    loading.css({display: 'none'});
                    if (data.message) {
                        messageBox.text(data.message).show();
                    }
                    if (data.status) {
                        var cartLink = hotel_alone_params.add_to_cart_link;
                        window.location.href = cartLink;
                    }
                    if ($('.has-matchHeight', body).length) {
                        $('.has-matchHeight', body).matchHeight();
                    }
                },
                error: function (data) {
                    loading.css({display: 'none'});
                }
            })
        });

        if ($('.sts-popup').length) {
            $('.sts-popup').magnificPopup({
                removalDelay  : 500,
                closeBtnInside: true,
                callbacks     : {
                    beforeOpen: function () {
                        this.st.mainClass = this.st.el.attr('data-effect');
                    }
                },
                midClick      : true,
                closeMarkup: '<button title="Close (Esc)" type="button" class="mfp-close"></button>',
            });
        }

        if($('.sts-room-wrapper').length) {
            extraServicesFunction($('.sts-room-wrapper'));
        }
        if($('.sts-booking-form').length) {
            extraServicesFunction($('.sts-booking-form'));
        }

        // Availability
        $('.sts-booking-form .item.checkin-out', body).each(function () {
            var parent           = $(this),
                date_wrapper = $('.date-wrapper', parent),
                check_in_input   = $('.check-in-input', parent),
                check_out_input  = $('.check-out-input', parent),
                check_in_out     = $('.sts-checkin-out', parent),
                check_in_out_render  = $('.value', parent);

            var minimum = check_in_out.data('minimum-day');
            if (typeof minimum !== 'number') {
                minimum = 0;
            }
            var options = {
                singleDatePicker    : false,
                autoApply           : true,
                disabledPast        : true,
                dateFormat          : parent.data('format'),
                widthSingle         : 500,
                onlyShowCurrentMonth: true,
                minimumCheckin      : minimum,
                classNotAvailable   : ['disabled', 'off'],
                enableLoading       : true,
                showEventTooltip    : true,
                firstDay: 1,
                fetchEvents         : function (start, end, el, callback) {
                    var events = [];
                    if (el.flag_get_events) {
                        return false;
                    }
                    el.flag_get_events = true;
                    el.container.find('.loader-wrapper').show();
                    var data = {
                        action  : check_in_out.data('action'),
                        start   : start.format('YYYY-MM-DD'),
                        end     : end.format('YYYY-MM-DD'),
                        post_id : check_in_out.data('room-id'),
                        security: check_in_out.data('s')
                    };
                    $.post(hotel_alone_params.ajax_url, data, function (respon) {
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
            if (typeof  locale_daterangepicker == 'object') {
                options.locale = locale_daterangepicker;
            }

            check_in_out.daterangepicker(options,
                function (start, end, label) {
                    check_in_input.val(start.format(parent.data('format')));
                    check_out_input.val(end.format(parent.data('format')));
                    check_in_out_render.html(start.format(parent.data('format')) + ' - ' + end.format(parent.data('format')));
                });
            date_wrapper.on('click',function (e) {
                check_in_out.trigger('click');
            });
        });

        $('.info-section .detail button').on('click', function () {
            var parent = $(this).closest('.detail');
            $('.detail-list', parent).slideToggle();
        });

        if ($('.payment-form .payment-item').length) {
            $('.payment-form .payment-item').eq(0).find('.st-icheck-item input[type="radio"]').prop('checked', true);
            $('.payment-form .payment-item').eq(0).find('.dropdown-menu').slideDown();
        }
        $('.payment-form .payment-item').each(function (l, i) {
            var parent = $(this);
            $('.st-icheck-item input[type="radio"]', parent).on('change',function () {
                $('.payment-form .payment-item .dropdown-menu').slideUp();
                if ($(this).is(':checked')) {
                    if ($('.dropdown-menu', parent).length) {
                        $('.dropdown-menu', parent).slideDown();
                    }
                }
            });
        });

        $('.st-thumb-slider').each(function () {
            $(this).owlCarousel({
                items:1,
                lazyLoad:true,
                loop:true,
                nav: true,
                center:true,
                navText : ["<img src='"+ hotel_alone_params.theme_url +"/v2/images/svg/ico_pre_thumb.svg' />","<img src='"+ hotel_alone_params.theme_url +"/v2/images/svg/ico_next_thumb.svg' />"]
            });
        });

        $('.coupon-section form .btn').on('click',function(e){
            e.preventDefault();
            var sform = $(this).closest('form');
            if($('#field-coupon_code', sform).val() === ''){
                $('#field-coupon_code', sform).addClass('error');
            }else{
                $('#field-coupon_code', sform).removeClass('error');

                $(this).append(' <i class="fa fa-spinner fa-spin"></i>');
                var data = {
                    'action': 'apply_mdcoupon_function',
                    'code': $('#field-coupon_code', sform).val()
                };
                $.post(hotel_alone_params.ajax_url, data, function (respon, textStatus, xhr) {
                    if (respon.status == 1) {
                        sform.trigger('submit');
                    }
                }, 'json');
            }
        });
        /*Sent email enquiry*/
        $('.form-st-send-mail .st_send-mail-form .sent-email-st').on('click',function (ev) {
            ev.preventDefault();
            var type_service = $("input[name=type_service]").val();
            var name_service = $("input[name=name_service]").val();
            var name_st = $("input[name=name_st]").val();
            var email_st = $("input[name=email_st]").val();
            var phone_st = $("input[name=phone_st]").val();
            var content_st = $("textarea[name=content_st]").val();
            var email_owl = $("input[name=email_owl]").val();
            $('.st-sent-mail-customer .loader-wrapper').show();
            console.log(content_st);
            $.ajax({
                url: st_params.ajax_url,
                type: "GET",
                data: {
                    'action': "st_send_email_single_service",
                    'type_service': type_service,
                    'name_service': name_service,
                    'name_st': name_st,
                    'email_st': email_st,
                    'phone_st': phone_st,
                    'content_st': content_st,
                    'email_owl': email_owl
                },
                dataType: "json",
                beforeSend: function () {
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    },
                success : function(res){

                },
                complete: function (xhr, status) {

                    if(xhr.responseJSON.status != 0){
                        var mess = '<div class="ccv-success"><div class="content-message">'+xhr.responseJSON.message+'</div></div>';
                        $('.form-st-send-mail .st_send-mail-form').html(mess);
                        $('.st-sent-mail-customer .loader-wrapper').hide();
                    } else{
                        var mess = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+xhr.responseJSON.message+'</div>';
                        $('.form-st-send-mail .message-wrapper-sendemail').html(mess);
                        $('.st-sent-mail-customer .loader-wrapper').hide();
                    }
                }
            });
        });

    });
    /**
     * ST number add or minus number
     */
    document.querySelectorAll(".item-search-content  .st-number  .plus").forEach((input) => input.addEventListener("click", calculate_add));
    document.querySelectorAll(".item-search-content  .st-number  .minus").forEach((input) => input.addEventListener("click", calculate_minus));
    function calculate_add(){
        var num_item = $(this).closest('.item-search-content');
        var num = num_item.find('.st-input-number').val();
        var max_val = num_item.find('.st-input-number').data('max');
        if(parseInt(num) < max_val){
            var value_num = parseInt(num)+1;
            num_item.find('.st-input-number').val(value_num);
            num_item.find('strong.num').text(value_num);
        }

    }
    function calculate_minus(){
        var num_item = $(this).closest('.item-search-content');
        var num = num_item.find('.st-input-number').val();
        var min_val = num_item.find('.st-input-number').data('min');
        if(parseInt(num)>min_val){
            var value_num = parseInt(num)-1;
            num_item.find('.st-input-number').val(value_num);
            num_item.find('strong.num').text(value_num);
        }

    }


    /*document.getElementById('icon-new-letter').onclick = function() {
       document.getElementById('st-submit').click();
    };*/


    /*Menu sticky*/
        jQuery(function($) {
            // grab the initial top offset of the navigation
            var stickyNavTop = 0;

            // our function that decides weather the navigation bar should have "fixed" css position or not.
            var stickyNav = function(){
                var scrollTop = $(window).scrollTop(); // our current vertical position from the top
                if (scrollTop > stickyNavTop || scrollTop==0) {
                    $('#header').removeClass('sticky');
                } else {
                    $('#header').addClass('sticky');

                }
                stickyNavTop = scrollTop;

            };

            stickyNav();
            // and run it again every time you scroll
            $(window).on('scroll', function() {
                stickyNav();
            });
        });



        /*Menu sticky mobile*/
        jQuery(function($) {
            // grab the initial top offset of the navigation
            var stickyNavTopMobile = 0;

            // our function that decides weather the navigation bar should have "fixed" css position or not.
            var stickyNavMobile = function(){
                var scrollTop = $(window).scrollTop(); // our current vertical position from the top
                if (scrollTop > stickyNavTopMobile || scrollTop==0) {
                    $('.header-mobile').removeClass('sticky-mobile');
                } else {
                    $('.header-mobile').addClass('sticky-mobile');

                }
                stickyNavTopMobile = scrollTop;

            };

            stickyNavMobile();
            // and run it again every time you scroll
            $(window).on('scroll',function() {
                stickyNavMobile();
            });
        });
});

/*Ajax*/
jQuery(function($){
        $('.blog-st-single').each(function () {
            st_nav_tab($(this));
        });
        function st_nav_tab(el){
            //var append_load = '<div id="morefloatingBarsG"><div class="ngothoai-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>';
            var append_load = '<div class="loader-wrapper"><div class="st-loader"></div></div>';
            el.find(".load_more_post").on('click',function(element) {
                element.preventDefault();
                var element = $(this);
                var posts_per_page = element.attr('data-posts-per-page');
                var paged = element.attr('data-paged');
                var order = element.attr('data-order');
                var order_by = element.attr('data-order-by');
                var tax_query = element.attr('data-tax-query');
                var max_num_page = element.attr('data-max-num-page');
                var check_all = element.attr('check-all');
                var style = element.attr('data-style');
                var index = element.attr('data-index');
                var $container = element.closest('.blog-st-single');
                var tab = element.closest('li.active');
                //var offloadmore = $container.find('.loadmore');

                if(check_all === "true"){
                    var append_content = $container.find('.st_all');
                    var append_st = $container.find('.st_all .grid-st');
                    var loadmore = $container.find('.st_all .load-ajax-icon .loader-wrapper');
                    var offloadmore = $container.find('.st_all .loadmore ');
                    var buttonloadmore = append_content.find('.st-button-loadmore');
                } else {
                    var append_content = $container.find('.st_blog_'+tax_query);
                    var append_st = $container.find('.st_blog_'+tax_query+' .grid-st');
                    var loadmore = $container.find('.st_blog_'+tax_query+' .load-ajax-icon .loader-wrapper');
                    var offloadmore = $container.find('.st_blog_'+tax_query+' .loadmore');
                    var buttonloadmore = append_content.find('.st-button-loadmore');
                }
                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: {
                        'action': "st_load_post_by_cat",
                        'posts_per_page': posts_per_page,
                        'paged': paged,
                        'order': order,
                        'order_by': order_by,
                        'tax_query': tax_query,
                        'max_num_page': max_num_page,
                        'check_all': check_all,
                        'index': index
                    },
                    dataType: "json",
                    beforeSend: function () {
                        loadmore.show();
                        buttonloadmore.hide();
                    },
                    error : function(jqXHR, textStatus, errorThrown) {
                          $("#aLoad").remove();
                          alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                        },
                    success : function(res){
                        $datxa = $(res.html);
                        if($datxa.length){
                              append_st.append(res.html);

                        } else {

                        }
                        $container.animate({ scrollTop: $container.prop("scrollHeight")}, 1000);
                    },
                    complete: function (xhr, status) {

                        $data = $(xhr.responseJSON.html);
                        if($data.length){
                            element.attr('data-paged', xhr.responseJSON.paged);
                            element.attr('data-index', xhr.responseJSON.index);
                            loadmore.hide();
                            buttonloadmore.show();
                        } else {
                            loadmore.hide();
                            offloadmore.remove();
                        }

                    }
                });

            });
        }

        jQuery(window).load(function(){
            jQuery('a[href*="youtube.com/watch"]').magnificPopup({
               type: 'iframe',
                   iframe: {
                       patterns: {
                           youtube: {
                               index: 'youtube.com',
                               id: 'v=',
                               src: '//www.youtube.com/embed/%id%?rel=0&autoplay=1'
                            }
                       }
                   }
             });
        });

});


/*<!-- SMOOTH SCROLL --> */
jQuery(function($){
    // var $window = $(window);
    // var scrollTime = 0.3;
    // var scrollDistance = 50;
    // $window.on("mousewheel DOMMouseScroll", function(event){
    //     var delta = event.originalEvent.wheelDelta/120 || -event.originalEvent.detail/3;
    //     var scrollTop = $window.scrollTop();
    //     var finalScroll = scrollTop - parseInt(delta*scrollDistance);

    //     TweenMax.to($window, scrollTime, {
    //         scrollTo : { y: finalScroll, autoKill:true },
    //         ease: Power1.easeOut,
    //         autoKill: true,
    //         overwrite: 3
    //     });

    // });
});

/*menu*/
jQuery(function ($){
    'use strict';
    var body = $('body');
    $('.toggle-menu').on('click',function (ev) {
        ev.preventDefault();
        toggleBody($('#st-main-menu'));
        $('#st-main-menu').toggleClass('open');
    });
    $('.back-menu').on('click',function (ev) {
        ev.preventDefault();
        toggleBody($('#st-main-menu'));
        $('#st-main-menu').toggleClass('open');
    });

    function toggleBody(el) {
        if (el.hasClass('open')) {
            body.css({
                'overflow': ''
            });
        } else {
            body.css({
                'overflow': 'hidden'
            });
        }
    }

    $('#st-main-menu .main-menu .menu-item-has-children .fa').on('click',function () {
        if (window.matchMedia("(max-width: 768px)").matches) {
            $(this).toggleClass('fa-angle-down fa-angle-up');
            var parent = $(this).closest('.menu-item-has-children');
            $('>.menu-dropdown',parent).toggle();

        }
    });
    body.on('click',function (ev) {
        if ($(ev.target).is('#st-main-menu')) {
            toggleBody($(ev.target));
            $('#st-main-menu').toggleClass('open');
        }
    });
});

/*Scroll*/
jQuery(function($){
    /*ScrollReveal*/
    ScrollReveal().reveal('.tabbable-line .tab-content', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 500);
    ScrollReveal().reveal('.wpb_single_image img', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 500);
    ScrollReveal().reveal('.list-group', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.list-group-slider', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    //ScrollReveal().reveal('.vc_column-inner > .content-text', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.st-gallery-grid', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.item-room', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.item-table', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.page-template-template-hotel-activity .blog-item', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.full-width', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.img-time', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.logo-footer-st img  ', { origin: 'bottom', distance: '0px', duration: 0, opacity: 0 }, 750);



    ScrollReveal().reveal('.sts-banner .page-title', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.sts-toolbar', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.single-hotel_room .sts-single-room-alone .facility', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.single-hotel_room .sts-single-room-alone .desc', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.single-hotel_room .sts-single-room-alone .price-wrapper', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.single-hotel_room .sts-single-room-alone .sts-booking-form', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.single-hotel_room .service-attribute', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.single-hotel_room .sts-room-gallery', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.sts-other-rooms', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    //ScrollReveal().reveal('.sts-check-available-form', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);
    ScrollReveal().reveal('.single-hotel_room .gallery-grid-item', { origin: 'bottom', distance: '69px', duration: 750, opacity: 0 }, 750);

});

//Caculator
jQuery(function($){
    $( ".sts-booking-form" ).on( "sts-booking-form", function( event ) {
        renderHtmlSingleHotel();
    });

    //Guest Name
    //--------------- Guest Name Inputs -------------------------

    var adultNumber = $('.form-has-guest-name .adult_number');
    var childrenNumber = $('.form-has-guest-name .child_number');
    var infantNumber = $('.form-has-guest-name .infant_number');
    var guestNameInput = $('.form-has-guest-name .guest_name_input');
    adultNumber.on('change', triggerGuestInputChange);
    childrenNumber.on('change', triggerGuestInputChange);
    infantNumber.on('change', triggerGuestInputChange);

    function triggerGuestInputChange(e) {
        guestNameInput.trigger('guest-change', {
            'adult': parseInt(adultNumber.val()),
            'children': parseInt(childrenNumber.val()),
            'infant': parseInt(infantNumber.val())
        });
    }
    ;

    guestNameInput.on('guest-change', function (e, number) {
        var adult = number.adult;
        var children = number.children;
        var infant = number.infant;
        var hideAdult = $(this).data('hide-adult');
        var hideChildren = $(this).data('hide-children');
        var hideInfant = $(this).data('hide-infant');
        var controlWraps = $(this).find('.guest_name_control');
        var controls = controlWraps.find('.control-item');
        if (isNaN(infant))
            infant = 0;
        if (isNaN(children))
            children = 0;

        if (hideAdult == 'on') {
            adult = 0;
        }

        if (typeof hideChildren == 'undefined' || hideChildren != 'on')
            adult += children;
        if (typeof hideInfant == 'undefined' || hideInfant != 'on')
            adult += infant;

        //adult-=1;// Only input guest >=2 name

        if (adult <= 0) {
            $(this).addClass('hidden');
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

            $(this).removeClass('hidden');
        }
    });

    triggerGuestInputChange();
    //------------------End Guest Name Inputs -------------------
});
function renderHtmlSingleHotel(){
    var form = $('.sts-booking-form form');
    var data = form.serializeArray();
    $('.loader-wrapper').hide();
    data.push({
        name: 'security',
        value: st_params._s
    });
    for (var i = 0; i < data.length; i++) {

        if(data[i].name === 'action'){
            data[i]['value'] = 'st_format_hotel_price';
        }
    };
    $.ajax({
        method: "post",
        dataType: 'json',
        data: data,
        url: st_params.ajax_url,
        beforeSend: function () {
            $('.loader-wrapper').show();
            $('div.message-wrapper').html("");
            $('.message_box').html('');
            $('.sts-booking-form form .message').html("");
        },
        success: function (response) {
            $('.loader-wrapper').hide();
            if (response) {
                if (response.price_html) {
                    if ($('.form-head').length > 0) {
                        if(response.price_html){
                            $('.form-head').html(response.price_html);
                        }
                    }
                    if ($('.price-wrapper').length > 0) {
                        $('.price-wrapper span').html(response.price_html);
                    }
                    $('.message_box').html('');
                    $('.sts-booking-form form .message').html("");
                    ci = 0;
                } else {
                    if(response.message){
                        $('.sts-booking-form form .message').html(response.message);
                    }
                }
            }
        }
    });
}

if(st_params.caculator_price_single_ajax && st_params.caculator_price_single_ajax === 'on'){

    jQuery(function($) {
        if($('.sts-booking-form form').length > 0) {
            var hotel_count = 0;
            $(' .check-in-input').on('change', function (e) {
                if (hotel_count != 0) {
                    renderHtmlSingleHotel();
                }
                hotel_count++;
            });
            var flag = false;
            if ($('.form-more-extra .extras').length > 0) {
                $('.form-more-extra .extras li').each(function () {
                    $(this).find('.extra-service-select').on('change',function(){
                        renderHtmlSingleHotel();
                    })
                });
            }
            if ($('.sts-booking-form form .people').length > 0) {
                $('.sts-booking-form form .people').each(function () {
                    $(this).find('select').on('change',function(){
                        renderHtmlSingleHotel();
                    })
                });
            }
            if (flag) {
                renderHtmlSingleHotel();
            }

        }
    });
}
