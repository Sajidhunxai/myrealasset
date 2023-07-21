/*Carstranfer*/
jQuery(function ($) {
    if ($('.page-template-template-transfer-search .st-style-elementor.search-result-page').length < 1) {
        var st_with_search_location_transfer = $(
            ".tab-pane.active#st_cartranfer .destination-pickup-carstranfer"
        ).outerWidth();
        $("#transfer_from")
            .select2()
            .on("select2:open", function () {
                $.fn.niceScroll && $(".select2-results__options").niceScroll({
                    cursorcolor: "#5fdfe8",
                    cursorwidth: "8px",
                    autohidemode: false,
                    cursorborder: "1px solid #5fdfe8",
                    horizrailenabled: false
                });
            });
        $("#transfer_to")
            .select2()
            .on("select2:open", function () {
                $.fn.niceScroll && $(".select2-results__options").niceScroll({
                    cursorcolor: "#5fdfe8",
                    cursorwidth: "8px",
                    autohidemode: false,
                    cursorborder: "1px solid #5fdfe8",
                    horizrailenabled: false
                });
            });

        $("#transfer_from").select2({
            tags: true,
            width: st_with_search_location_transfer + "px"
        });
        $("#transfer_to").select2({
            tags: true,
            width: st_with_search_location_transfer + "px"
        });
        $(document).on("select2:open", "select#transfer_from", function () {
            setTimeout(function () {
                if ($(".select2-result").length) {
                    $(".select2-result")
                        .getNiceScroll()
                        .resize();
                }
            }, 1000);
        });
        $(document).on("select2:open", "select#transfer_to", function () {
            var st_with_search_location_transfer = $(
                ".tab-pane.active#st_cartranfer .destination-pickup-carstranfer"
            ).outerWidth();

            setTimeout(function () {
                if ($(".select2-dropdown .select2-result").length) {}
            }, 1000);
        });
        $(".select2-result").each(function () {
            $(this).niceScroll();
        });

        $("select#transfer_from").on("change", function (e) {
            var parent_from = $(this).closest(".field-destination-carstranfer");

            var car_from_value = this.value;
            var data = $("#transfer_from").select2("data");
            if (data) {
                var car_from_name = data[0].text;
                car_from_name = $.trim(car_from_name);
            }
            console.log(car_from_name);
            var from = parent_from.find(".destination-pickup .render .destination");
            from.text(car_from_name);
        });
        $("select#transfer_to").on("change", function (e) {
            var parent_from = $(this).closest(".field-destination-carstranfer");

            var car_from_value = this.value;
            var data = $("#transfer_to").select2("data");
            if (data) {
                var car_from_name = data[0].text;
                car_from_name = String.prototype.trim(car_from_name);
            }
            console.log(car_from_name);
            var from = parent_from.find("#dropdown-dropoff .render .destination");
            from.text(car_from_name);
        });
    }


    $(
        ".search-result-page .search-form-wrapper .search-form .field-destination-carstranfer .destination-pickup"
    ).on("click", function (e) {
        console.log("close");

        // $(this).find('.select2-selection__rendered').trigger('click');
        e.preventDefault();
    });

    var modal = document.querySelector(".st-tooltip");
    //var trigger = document.querySelector(".st_click_choose_service");
    //var closeButton = document.querySelector(".close-button");

    function toggleModal() {
        modal.classList.toggle("show-modal");
    }

    function windowOnClick(event) {
        if (event.target === modal) {
            toggleModal();
        }
    }
    $(".st-search-cartransfer .modern-search-result").each(function () {
        $(this).on("click", function (e) {
            if ($(e.target).is(".st_click_choose_service")) {
                let btnClick = $(e.target);
                var st_item_modal = btnClick.closest(".item-service");
                st_item_modal
                    .find(".sroom-extra-service .st-tooltip")
                    .toggleClass("show-modal");
                var st_modal = st_item_modal.find(".sroom-extra-service .st-tooltip");
            }
            if ($(e.target).is(".st-close-button i")) {
                let btnClickClose = $(e.target);
                var st_item_modal = btnClickClose.closest(".item-service");
                st_item_modal
                    .find(".sroom-extra-service .st-tooltip")
                    .toggleClass("show-modal");
                st_item_modal
                    .find(".sroom-extra-service .st-tooltip")
                    .removeClass("show-modal");
            }
        });
        $('.toolbar-action-mobile .btn-from-to').on('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: '46',
            });
            $('.sidebar-filter').fadeIn();
            $('.top-filter').fadeIn();
            $('.sidebar-filter .sidebar-search-form').show();
            $('.sidebar-filter .sidebar-item-wrapper').hide();
            $('.sidebar-filter .form-date-search').hide();
            $('html, body').css({
                overflow: 'hidden'
            });
        });
        $('.toolbar-action-mobile .btn-filter').on('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: '46',
            });
            $('.sidebar-filter').fadeIn();
            $('.top-filter').fadeIn();
            $('.sidebar-filter .sidebar-item-wrapper').fadeIn();
            $('.sidebar-filter .sidebar-search-form').hide();
            $('html, body').css({
                overflow: 'hidden'
            });
        });
        $('.toolbar-action-mobile .btn-sort').on('click', function (e) {
            e.preventDefault();
            $('.sort-menu-mobile').fadeIn();
        });
        $('.toolbar-action-mobile .btn-map').on('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: '46',
            });
            $('.page-half-map .col-right').show();
            $('.full-map .full-map-item').show();
            $('html, body').css({
                overflow: 'hidden'
            });
        });
        $('.sidebar-filter .close-filter').on('click', function () {
            $(this).closest('.sidebar-filter').fadeOut(function () {
                $('html, body').css({
                    overflow: 'auto'
                });
            });
        });

        $('.top-filter .close-filter').on('click', function () {
            $(this).closest('.top-filter').fadeOut(function () {
                $('html, body').css({
                    overflow: 'auto'
                });
            });
        });
        $('.sort-menu-mobile .close-filter').on('click', function () {
            $(this).closest('.sort-menu-mobile').fadeOut(function () {
                $('html, body').css({
                    overflow: 'auto'
                });
            });
        });
    });

    $(".st-search-cartransfer .modern-search-result").each(function () {
        $(this).on("click", function (e) {
            if ($(e.target).is(".st_click_choose_passenger")) {
                let btnClick = $(e.target);
                var st_item_modal = btnClick.closest(".item-service");
                st_item_modal
                    .find(".sroom-passenger .st-tooltip")
                    .toggleClass("show-modal");
                var st_modal = st_item_modal.find(".sroom-passenger .st-tooltip");
            }
            if ($(e.target).is(".st-close-button i")) {
                let btnClickClose = $(e.target);
                var st_item_modal = btnClickClose.closest(".item-service");
                st_item_modal
                    .find(".sroom-passenger .st-tooltip")
                    .toggleClass("show-modal");
                st_item_modal
                    .find(".sroom-passenger .st-tooltip")
                    .removeClass("show-modal");
            }
        });
    });
    //Modtransfer
    $(".page-template-template-transfer-search .st-style-elementor.search-result-page").each(function () {
        $(this).on("click", function (e) {
            if ($(e.target).is(".st_click_choose_passenger_transfer")) {
                let btnClick = $(e.target);
                var st_item_modal = btnClick.closest(".services-item");
                st_item_modal
                    .find(".sroom-passenger .st-tooltip")
                    .toggleClass("show-modal");
                var st_modal = st_item_modal.find(".sroom-passenger .st-tooltip");
            }
            if ($(e.target).is(".st-close-button i")) {
                let btnClickClose = $(e.target);
                var st_item_modal = btnClickClose.closest(".services-item");
                st_item_modal
                    .find(".sroom-passenger .st-tooltip")
                    .toggleClass("show-modal");
                st_item_modal
                    .find(".sroom-passenger .st-tooltip")
                    .removeClass("show-modal");
            }
        });
        $(this).on("click", function (e) {
            if ($(e.target).is(".st_click_choose_service")) {
                let btnClick = $(e.target);
                var st_item_modal = btnClick.closest(".item-service");
                st_item_modal
                    .find(".sroom-extra-service .st-tooltip")
                    .toggleClass("show-modal");
                var st_modal = st_item_modal.find(".sroom-extra-service .st-tooltip");
            }
            if ($(e.target).is(".st-close-button i")) {
                let btnClickClose = $(e.target);
                var st_item_modal = btnClickClose.closest(".item-service");
                st_item_modal
                    .find(".sroom-extra-service .st-tooltip")
                    .toggleClass("show-modal");
                st_item_modal
                    .find(".sroom-extra-service .st-tooltip")
                    .removeClass("show-modal");
            }
        });
    });


    //Return
    $(".st-search-cartransfer .modern-search-result").each(function () {
        $(this).on("click", function (e) {
            if ($(e.target).is(".st_click_choose_return")) {
                let btnClick = $(e.target);
                var st_item_modal = btnClick.closest(".item-service");
                st_item_modal
                    .find(".sroom-return .st-tooltip")
                    .toggleClass("show-modal");
                var st_modal = st_item_modal.find(".sroom-return .st-tooltip");
            }
            if ($(e.target).is(".st-close-button i")) {
                let btnClickClose = $(e.target);
                var st_item_modal = btnClickClose.closest(".item-service");
                st_item_modal
                    .find(".sroom-return .st-tooltip")
                    .toggleClass("show-modal");
                st_item_modal
                    .find(".sroom-return .st-tooltip")
                    .removeClass("show-modal");
            }
        });
    });

    //Elementor mod
    $(".page-template-template-transfer-search .st-style-elementor.search-result-page").each(function () {
        $(this).on("click", function (e) {
            if ($(e.target).is(".st_click_choose_return")) {
                let btnClick = $(e.target);

                var st_item_modal = btnClick.closest(".services-item");
                st_item_modal
                    .find(".sroom-return .st-tooltip")
                    .toggleClass("show-modal");
                var st_modal = st_item_modal.find(".sroom-return .st-tooltip");
            }
            if ($(e.target).is(".st-close-button i")) {
                let btnClickClose = $(e.target);
                var st_item_modal = btnClickClose.closest(".services-item");
                st_item_modal
                    .find(".sroom-return .st-tooltip")
                    .toggleClass("show-modal");
                st_item_modal
                    .find(".sroom-return .st-tooltip")
                    .removeClass("show-modal");
            }
        });
    });

    /*Date rangpicker*/
    loadDateRangePicker()
    var body = $("body.page-template-template-transfer-search");
    $('.st-search-cartransfer .modern-search-result', body).on('change', function () {
        loadDateRangePicker()
    })
    $('.st-style-elementor.search-result-page', body).on('change', function () {
        loadDateRangePicker()
    })

    function loadDateRangePicker() {
        var body = $("body.page-template-template-transfer-search");
        $(".services-item", body).each(function () {
            var parent = $(this),
                button_date = $(".st_click_choose_datetime_transfer", parent),
                time_start = $("input[name='start-time']", parent),
                date_start = $("input[name='start']", parent);

            var options = {
                singleDatePicker: true,
                showCalendar: false,
                sameDate: true,
                autoApply: false,
                disabledPast: true,
                dateFormat: "DD/MM/YYYY",
                customClass: "popup-date-custom-cartranfer",
                enableLoading: true,
                showEventTooltip: true,
                classNotAvailable: ["disabled", "off"],
                disableHightLight: true,
                timePicker: true,
                timePicker24Hour: (st_params.time_format == '12h') ? false : true,
            };
            if (typeof locale_daterangepicker == "object") {
                options.locale = locale_daterangepicker;
            }
            button_date.on('click', function () {
                $('.page-template-template-transfer-search .st-popup.popup-date').show();
                button_date.trigger('show.daterangepicker');
            });
            console.log(parent.data('date-format'));
            button_date.daterangepicker(options, function (start, end, label) {
                $(".page-template-template-transfer-search .st-popup.popup-date").hide();
                time_start.val(start.format(parent.data('time-format')));
                button_date.html(start.format(parent.data('date-format')) + " " + start.format(parent.data('time-format')));
                date_start.val(start.format(parent.data('date-format')));
            });
        });

        $(".item-service", body).each(function () {
            var parent = $(this),
                button_date = $(".st_click_choose_datetime", parent),
                time_start = $("input[name='start-time']", parent),
                date_start = $("input[name='start']", parent);

            var options = {
                singleDatePicker: true,
                showCalendar: false,
                sameDate: true,
                autoApply: false,
                disabledPast: true,
                dateFormat: "DD/MM/YYYY",
                customClass: "popup-date-custom-cartranfer",
                enableLoading: true,
                showEventTooltip: true,
                classNotAvailable: ["disabled", "off"],
                disableHightLight: true,
                timePicker: true,
                timePicker24Hour: (st_params.time_format == '12h') ? false : true,
            };
            if (typeof locale_daterangepicker == "object") {
                options.locale = locale_daterangepicker;
            }
            button_date.on('click', function () {
                $('.page-template-template-transfer-search .st-popup.popup-date').show();
                button_date.trigger('show.daterangepicker');
            });
            button_date.daterangepicker(options, function (start, end, label) {
                $(".page-template-template-transfer-search .st-popup.popup-date").hide();
                time_start.val(start.format(parent.data('time-format')));
                button_date.html(start.format(parent.data('date-format')) + " " + start.format(parent.data('time-format')));
                date_start.val(start.format(parent.data('date-format')));
            });
        });
    }

    //Ajax booking cartranfer 
    let bookingCartransfer = {
        $body: $('body'),
        init: function () {
            let base = this;
            this.triggerBookCartransfer();
        },
        triggerBookCartransfer: function () {
            $(document).on('change', '.item-service-inner.item-car .sroom-extra-service table tr .extra-service-select', function (event) {
                $('body').trigger('cartransfer-booking-form', [$(this)]);
            });

            $(document).on('change', '.item-service-inner.item-car .sroom-passenger select[name ="passengers"]', function (event) {
                bookingCartransfer.renderHtmlCarstranfer(event, $(this));
            });

            $(document).on('change', '.item-service-inner.item-car .sroom-return  input[name ="return_car"]', function (event) {
                bookingCartransfer.renderHtmlCarstranfer(event, $(this));
            });


            $(document).on('change', '.booking-item-features .sroom-passenger select[name ="passengers"]', function (event) {
                bookingCartransfer.renderHtmlCarstranfer(event, $(this));
            });
            $(document).on('change', '.booking-item-features .sroom-return  input[name ="return_car"]', function (event) {
                bookingCartransfer.renderHtmlCarstranfer(event, $(this));
            });
            $(document).on('change', '.booking-item-features .sroom-extra-service table tr .extra-service-select', function (event) {
                bookingCartransfer.renderHtmlCarstranfer(event, $(this));
            });


            $("body").on("cartransfer-booking-form", function (event, el) {
                bookingCartransfer.renderHtmlCarstranfer(event, el);
            });
        },
        renderHtmlCarstranfer: function (event, el) {
            var form = el.closest('form.form-booking-car-transfer');
            var data = form.serializeArray();
            $('.map-content-loading').each(function () {
                $(this).fadeOut();
            });
            data.push({
                name: 'security',
                value: st_params._s
            });
            for (var i = 0; i < data.length; i++) {
                if (data[i].name === 'action') {
                    data[i]['value'] = 'st_format_cartransfer_price';
                }
            };
            jQuery.ajax({
                method: "post",
                dataType: 'json',
                data: data,
                url: st_params.ajax_url,
                beforeSend: function () {
                    jQuery('div.message-wrapper').html("");
                    $('.map-content-loading').each(function () {
                        $(this).fadeIn();
                    });
                    jQuery('.message_box').html('');
                    jQuery(form).closest('.item-service').find('.message').removeClass('mt20 alert alert-danger').hide();
                },
                success: function (response) {
                    $('.map-content-loading').each(function () {
                        $(this).fadeOut();
                    });

                    if (response) {

                        if (response.price_html) {
                            var price_wrapper = jQuery(form).closest('.item-service').find('.price-wrapper');
                            var price_booking = jQuery(form).closest('.item-service').find('.price-booking');
                            if (price_booking.length > 0) {
                                price_booking.html(response.price_html);
                            } else {
                                if (price_wrapper.length > 0) {
                                    price_wrapper.html(response.price_html);
                                }
                            }
                            jQuery('.message_box').html('');
                            jQuery('div.message-wrapper').html("");
                        } else {
                            if (response.message) {
                                jQuery(form).closest('.item-service').find('.message').addClass('mt20 alert alert-danger').show().html(response.message);
                            }
                            if (response.price_from) {
                                var price_wrapper = jQuery(form).closest('.item-service').find('.price-wrapper');
                                var price_booking = jQuery(form).closest('.item-service').find('.price-booking');
                                if (price_booking.length > 0) {
                                    price_booking.html(response.price_from);
                                } else {
                                    if (price_wrapper.length > 0) {
                                        price_wrapper.html(response.price_from);
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
    }
    bookingCartransfer.init();
    add_to_cart();

    function add_to_cart() {
        $('.form-booking-car-transfer').each(function () {
            var t = $(this),
                parent = t.closest('.booking-item'),
                overlay = $('.overlay-form', parent);
            $('.message', parent).attr('class', 'message').html('');

            t.on('submit', function (event) {
                event.preventDefault();
                var data = t.serializeArray();
                $('.message', parent).hide();
                $('.map-content-loading').each(function () {
                    $(this).fadeIn();
                });
                $.post(st_params.ajax_url, data, function (respon) {
                    if (typeof respon == 'object') {
                        if (respon.status == 0) {
                            $('.message', parent).addClass(respon.class).html(respon.message).show();
                        } else {
                            window.location.href = respon.redirect;
                        }
                    }
                    $('.map-content-loading').each(function () {
                        $(this).fadeOut();
                    });
                }, 'json');

            });
        });
    }

});

//Filter
(function ($) {
    var requestRunning = false;
    var xhr;
    var hasFilter = false;

    var data = URLToArrayNew();

    //Modactivity
    jQuery(function ($) {
        if ($('.st-style-elementor.search-result-page').length) {
            $('.show-filter-mobile .button-filter').on('click', function () {
                $('.sidebar-filter').fadeIn();
            });
            $('.sidebar-filter .close-sidebar').on('click', function () {
                $('.sidebar-filter').fadeOut();
            });
        }

        function doneResizing() {
            ajaxFilterHandler();
        }
    });
    //And modactivity
    /*Layout*/
    $('.toolbar .layout span.layout-item').on('click', function () {
        if (!$(this).hasClass('active')) {
            $(this).parent().find('span').removeClass('active');
            $(this).addClass('active');
            data['layout'] = $(this).data('value');
            ajaxFilterHandler(false);
        }
    });

    /*Sort menu*/
    $('.sort-menu input.service_order').on('change', function () {
        data['orderby'] = $(this).data('value');
        $(this).closest('.dropdown-menu').slideUp(50);
        ajaxFilterHandler();
    });

    /* Price */
    $('.btn-apply-price-range').on('click', function (e) {
        e.preventDefault();
        data['price_range'] = $(this).closest('.range-slider').find('.price_range').val();
        console.log(data['price_range']);
        $(this).closest('.dropdown-menu').slideUp(50);
        data['page'] = 1;
        ajaxFilterHandler();
    });

    /*Checkbox click*/
    var filter_checkbox = {};
    $('.filter-item').each(function () {
        if (!Object.keys(filter_checkbox).includes($(this).data('type'))) {
            filter_checkbox[$(this).data('type')] = [];
        }
    });

    $('.filter-item').on('change', function () {
        var t = $(this);
        var filter_type = t.data('type');
        if (t.is(':checked')) {
            filter_checkbox[filter_type].push(t.val());
        } else {
            var index = filter_checkbox[filter_type].indexOf(t.val());
            if (index > -1) {
                filter_checkbox[filter_type].splice(index, 1);
            }
        }
        if (filter_checkbox[filter_type].length) {
            data[filter_type] = filter_checkbox[filter_type].toString();
        } else {
            if (typeof data[filter_type] != 'undefined') {
                delete data[filter_type];
            }
        }
        data['page'] = 1;
        ajaxFilterHandler();
    });

    /*Taxnonomy*/
    var arrTax = [];
    $('.filter-tax').each(function () {
        if (!Object.keys(arrTax).includes($(this).data('type'))) {
            arrTax[$(this).data('type')] = [];
        }

        if ($(this).is(':checked')) {
            arrTax[$(this).data('type')].push($(this).val());
        }
    });

    /* Pagination */
    $(document).on('click', '.pagination a.page-numbers:not(.current, .dots)', function (e) {
        e.preventDefault();
        var t = $(this);
        var pagUrl = t.attr('href');

        pageNum = 1;

        if (typeof pagUrl !== typeof undefined && pagUrl !== false) {
            var arr = pagUrl.split('/');
            var pageNum = arr[arr.indexOf('page') + 1];
            if (isNaN(pageNum)) {
                pageNum = 1;
            }
            data['page'] = pageNum;
            ajaxFilterHandler();
            if ($('.modern-search-result-popup').length) {
                $('.col-left-map').animate({
                    scrollTop: 0
                }, 'slow');
            }

            if ($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
            return false;
        } else {
            return false;
        }
    });

    $('.filter-tax').on('change', function () {
        var t = $(this);
        var filter_type = t.data('type');

        if (t.is(':checked')) {
            arrTax[filter_type].push(t.val());
        } else {
            var index = arrTax[filter_type].indexOf(t.val());
            if (index > -1) {
                arrTax[filter_type].splice(index, 1);
            }
        }
        if (arrTax[filter_type].length) {
            if (typeof data['taxonomy'] == 'undefined')
                data['taxonomy'] = {};
            data['taxonomy[' + filter_type + ']'] = arrTax[filter_type].toString();
        } else {
            if (typeof data['taxonomy'] == 'undefined')
                data['taxonomy'] = {};
            if (typeof data['taxonomy[' + filter_type + ']'] != 'undefined') {
                delete data['taxonomy[' + filter_type + ']'];
            }
        }

        if (Object.keys(data['taxonomy']).length <= 0) {
            delete data['taxonomy'];
        }
        data['page'] = 1;
        ajaxFilterHandler();
    });

    function duplicateData(parent, parentGet) {
        if (typeof data['price_range'] != 'undefined') {
            $('input[name="price_range"]', parent).each(function () {
                var instance = $(this).data("ionRangeSlider");
                var price_range_arr = data['price_range'].split(';');
                if (price_range_arr.length) {
                    instance.update({
                        from: price_range_arr[0],
                        to: price_range_arr[1]
                    });
                }
            });
        }

        //Filter
        var dataFilterItem = [];
        parent.find('.filter-item').prop('checked', false);
        parentGet.find('.filter-item').each(function () {
            var t = $(this);
            if (t.is(':checked')) {
                if (Object.keys(dataFilterItem).includes(t.data('type'))) {
                    dataFilterItem[t.data('type')].push(t.val());
                } else {
                    dataFilterItem[t.data('type')] = [];
                    dataFilterItem[t.data('type')].push(t.val());
                }
            }
        });
        if (Object.keys(dataFilterItem).length) {
            for (var i = 0; i < Object.keys(dataFilterItem).length; i++) {
                var iD = dataFilterItem[Object.keys(dataFilterItem)[i]];
                if (iD.length) {
                    for (var j = 0; j < iD.length; j++) {
                        $('.filter-item[data-type="' + Object.keys(dataFilterItem)[i] + '"][value="' + iD[j] + '"]', parent).prop('checked', true);
                    }
                }
            }
        }

        //Tax
        var dataFilterTax = [];
        parent.find('.filter-tax').prop('checked', false);
        parentGet.find('.filter-tax').each(function () {
            var t = $(this);
            if (t.is(':checked')) {
                if (Object.keys(dataFilterTax).includes(t.data('type'))) {
                    dataFilterTax[t.data('type')].push(t.val());
                } else {
                    dataFilterTax[t.data('type')] = [];
                    dataFilterTax[t.data('type')].push(t.val());
                }
            }
        });
        if (Object.keys(dataFilterTax).length) {
            for (var i = 0; i < Object.keys(dataFilterTax).length; i++) {
                var iD = dataFilterTax[Object.keys(dataFilterTax)[i]];
                if (iD.length) {
                    for (var j = 0; j < iD.length; j++) {
                        $('.filter-tax[data-type="' + Object.keys(dataFilterTax)[i] + '"][value="' + iD[j] + '"]', parent).prop('checked', true);
                    }
                }
            }
        }
    }

    $('.toolbar-action-mobile .btn-date').on('click', function (e) {
        e.preventDefault();
        var me = $(this);
        window.scrollTo({
            top: 0,
            behavior: 'auto'
        });
        $('.popup-date').each(function () {
            var t = $(this);

            var checkinOut = t.find('.check-in-out');
            var options = {
                singleDatePicker: false,
                autoApply: true,
                disabledPast: true,
                dateFormat: 'DD/MM/YYYY',
                customClass: 'popup-date-custom-car',
                widthSingle: 500,
                onlyShowCurrentMonth: true,
                alwaysShowCalendars: true,
                timePicker: true,
                timePicker24Hour: (st_params.time_format == '12h') ? false : true,
                sameDate: true,
                sameDateMulti: true,
            };
            if (typeof locale_daterangepicker == 'object') {
                options.locale = locale_daterangepicker;
            }
            checkinOut.daterangepicker(options,
                function (start, end, label) {
                    me.text(start.format(t.data('format')) + ' - ' + end.format(t.data('format')));
                    data['pick-up-date'] = start.format(t.data('date-format'));
                    data['pick-up-time'] = start.format(t.data('time-format'));
                    data['drop-off-date'] = end.format(t.data('date-format'));
                    data['drop-off-time'] = end.format(t.data('time-format'));
                    if ($('#modern-result-string').length) {
                        window.scrollTo({
                            top: $('#modern-result-string').offset().top - 20,
                            behavior: 'smooth'
                        });
                    }
                    ajaxFilterHandler();
                    t.hide();
                });
            checkinOut.trigger('click');
            t.fadeIn();
        });
    });

    $('.popup-close').on('click', function () {
        $(this).closest('.st-popup').hide();
    });

    function ajaxFilterHandler(loadMap = true) {
        if (requestRunning) {
            xhr.abort();
        }

        if ($('#tour-top-search').length > 0) {
            data['top_search'] = 1;
        }

        hasFilter = true;

        $('html, body').css({
            'overflow': 'auto'
        });

        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.sidebar-filter').fadeOut();
            $('.top-filter').fadeOut();

            if ($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.filter-loading').show();
        var layout = $('#modern-search-result').data('layout');
        data['format'] = $('#modern-search-result').data('format');
        if ($('.modern-search-result-popup').length) {
            data['is_popup_map'] = '1';
        }

        //data['action'] = 'st_filter_cars_ajax';
        data['action'] = 'st_filter_cars_transfer_ajax';
        data['is_search_page'] = 1;
        data['_s'] = st_params._s;
        if (typeof data['page'] == 'undefined') {
            data['page'] = 1;
        }

        var divResult = $('.modern-search-result');
        var divResultString = $('.modern-result-string');
        var divPagination = $('.moderm-pagination');

        //Newlayout modtransfer
        if ($('.page-template-template-transfer-search .st-style-elementor.search-result-page').length) {
            let wrapper = $('.search-result-page');
            data['version'] = 'elementorv2';
            data['version_layout'] = wrapper.data('layout');
            data['version_format'] = wrapper.data('format');

            if (window.matchMedia('(max-width: 767px)').matches) {
                if ($('.st-style-elementor.search-result-page').length) {
                    if (data['layout'] !== 'grid') {
                        data['layout'] = 'grid';
                        data['layout_old'] = 'list';
                    }
                }
            } else {
                if ($('.st-style-elementor.search-result-page').length) {
                    if (typeof data['layout_old'] !== 'undefined' && data['layout_old'] != '') {
                        data['layout'] = data['layout_old'];
                        data['layout_old'] = '';
                    }
                }
            }

        }
        //End newlayout modtransfer

        divResult.addClass('loading');

        xhr = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            success: function (doc) {
                divResult.each(function () {
                    $(this).html(doc.content);
                    divResult.trigger('change')
                });

                divResultString.each(function () {
                    $(this).html(doc.count);
                });

                divPagination.each(function () {
                    $(this).html(doc.pag);
                });
            },
            complete: function () {
                divResult.removeClass('loading');
                $('.map-content-loading').each(function () {
                    $(this).fadeOut();
                });

                var time = 0;
                divResult.find('img').one("load", function () {
                    $(this).addClass('loaded');
                    if (divResult.find('img.loaded').length === divResult.find('img').length) {
                        if ($('.has-matchHeight').length) {
                            $('.has-matchHeight').matchHeight({
                                remove: true
                            });
                            $('.has-matchHeight').matchHeight();
                        }
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                });

                if (checkClearFilter()) {
                    $('.btn-clear-filter').fadeIn();
                } else {
                    $('.btn-clear-filter').fadeOut();
                }
                requestRunning = false;
            },
        });
        requestRunning = true;
    }

    jQuery(function ($) {
        if (checkClearFilter()) {
            $('.btn-clear-filter').fadeIn();
        } else {
            $('.btn-clear-filter').fadeOut();
        }
        $(document).on('click', '#btn-clear-filter', function () {
            var arrResetTax = [];
            $('.filter-tax').each(function () {
                if (!Object.keys(arrResetTax).includes($(this).data('type'))) {
                    arrResetTax[$(this).data('type')] = [];
                }

                if ($(this).length) {
                    $(this).prop('checked', false);
                    $(this).trigger('change');
                }
            });

            if (Object.keys(arrResetTax).length) {
                for (var i = 0; i < Object.keys(arrResetTax).length; i++) {
                    if (typeof data['taxonomy[' + Object.keys(arrResetTax)[i] + ']'] != 'undefined') {
                        delete data['taxonomy[' + Object.keys(arrResetTax)[i] + ']'];
                    }
                }
            }

            if (typeof data['price_range'] != 'undefined') {
                delete data['price_range'];
                $('input[name="price_range"]').each(function () {
                    var sliderPrice = $(this).data("ionRangeSlider");
                    sliderPrice.reset();
                });
            }

            if (typeof data['star_rate'] != 'undefined') {
                delete data['star_rate'];
            }

            if ($('.filter-item').length) {
                $('.filter-item').prop('checked', false);
            }
            if ($('.filter-tax').length) {
                $('.filter-tax').prop('checked', false);
            }

            if ($('.sort-item').length) {
                data['orderby'] = 'new';
                $('.sort-item').find('input').prop('checked', false);
                $('.sort-item').find('input[data-value="new"]').prop('checked', true);
            }

            $(this).fadeOut();
            ajaxFilterHandler();

        });
    });

    function checkClearFilter() {
        if (((typeof data['price_range'] != 'undefined' && data['price_range'].length) || (typeof data['star_rate'] != 'undefined' && data['star_rate'].length) || (typeof data['taxonomy[duration]'] != 'undefined' && data['taxonomy[duration]'].length) || (typeof data['taxonomy[st_tour_type]'] != 'undefined' && data['taxonomy[st_tour_type]'].length) || (typeof data['taxonomy[languages]'] != 'undefined' && data['taxonomy[languages]'].length) || (typeof data['orderby'] != 'undefined' && data['orderby'] != 'new')) && hasFilter) {
            return true;
        } else {
            return false;
        }
    }

    function URLToArrayNew() {
        var res = {};

        $('.toolbar .layout span').each(function () {
            if ($(this).hasClass('active')) {
                res['layout'] = $(this).data('value');
            }
        });

        res['orderby'] = 'new';

        var sPageURL = window.location.search.substring(1);
        if (sPageURL != '') {
            var sURLVariables = sPageURL.split('&');
            if (sURLVariables.length) {
                for (var i = 0; i < sURLVariables.length; i++) {
                    var sParameterName = sURLVariables[i].split('=');
                    if (sParameterName.length) {
                        let val = decodeURIComponent(sParameterName[1]);
                        res[decodeURIComponent(sParameterName[0])] = val == 'undefined' ? '' : val;
                    }
                }
            }
        }
        return res;
    }


    /*Add to cart*/
    $('.page-template-template-transfer-search .modern-search-result').on('change', function () {
        add_to_cart();
    });

    add_to_cart();

    function add_to_cart() {
        $('.form-booking-car-transfer').each(function () {
            var t = $(this),
                parent = t.closest('.booking-item'),
                overlay = $('.overlay-form', parent);
            $('.message', parent).attr('class', 'message').html('');

            t.on('submit', function (event) {
                event.preventDefault();
                var data = t.serializeArray();
                $('.message', parent).hide();
                $('.map-content-loading').each(function () {
                    $(this).fadeIn();
                });
                $.post(st_params.ajax_url, data, function (respon) {
                    if (typeof respon == 'object') {
                        if (respon.status == 0) {
                            $('.message', parent).addClass(respon.class).html(respon.message).show();
                        } else {
                            window.location.href = respon.redirect;
                        }
                    }
                    $('.map-content-loading').each(function () {
                        $(this).fadeOut();
                    });
                }, 'json');

            });
        });
    }

})(jQuery);