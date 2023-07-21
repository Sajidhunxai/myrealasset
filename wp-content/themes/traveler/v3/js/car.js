(function ($) {
    var requestRunning = false;
    var xhr;
    var hasFilter = false;

    var data = URLToArrayNew();
    /*Layout*/
    $('.toolbar .layout span.layout-item').on('click', function () {
        if (!$(this).hasClass('active')) {
            $(this).parent().find('span').removeClass('active');
            $(this).addClass('active');
            data['layout'] = $(this).data('value');
            ajaxFilterHandler(false);
        }
    });

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


        var resizeId;
        // $(window).on('resize',function() {
        //     if($('.st-style-elementor.search-result-page').length) {
        //         clearTimeout(resizeId);
        //         resizeId = setTimeout(doneResizing, 200);
        //     }
        // });

        function doneResizing() {
            ajaxFilterHandler();
        }
    });
    //And modactivity

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
            // $('.top-filter').fadeOut();

            if ($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.map-content-loading').each(function () {
            $(this).fadeIn();
        });
        var layout = $('#modern-search-result').data('layout');
        data['format'] = $('#modern-search-result').data('format');
        if ($('.modern-search-result-popup').length) {
            data['is_popup_map'] = '1';
        }

        data['action'] = 'st_filter_cars_ajax';
        data['is_search_page'] = 1;
        data['_s'] = st_params._s;
        if (typeof data['page'] == 'undefined') {
            data['page'] = 1;
        }


        //Newlayout modcar
        if ($('.search-result-page.car-layout3, .search-result-page.car-layout4').length) {
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
        //End newlayout modcar

        var divResult = $('.modern-search-result');
        var divResultString = $('.modern-result-string');
        var divPagination = $('.moderm-pagination');

        divResult.addClass('loading');

        xhr = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            success: function (doc) {
                divResult.each(function () {
                    $(this).html(doc.content);
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
        $(document).on('click', '#btn-clear-filter, .btn-clear-filter', function () {
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
            if ($('.filter-tax').length) {
                $('.filter-tax').prop('checked', false);
            }

            if ($('.sort-item').length) {
                data['orderby'] = '';
                $('.sort-item').find('input').prop('checked', false);
            }

			$(document).trigger('st_clear_filter_action');
            $(this).fadeOut();
            ajaxFilterHandler();

        });
    });

    function checkClearFilter() {
        if (
			(
				(typeof data['price_range'] != 'undefined' && data['price_range'].length) ||
				(typeof data['star_rate'] != 'undefined' && data['star_rate'].length) ||
				(typeof data['taxonomy[st_category_cars]'] != 'undefined' && data['taxonomy[st_category_cars]'].length) ||
				(typeof data['orderby'] != 'undefined' && data['orderby'] != 'new' && data['orderby'] != '')
			) && hasFilter
		) {
            return true;
        } else {
            return false;
        }
    }

    function decodeQueryParam(p) {
        return decodeURIComponent(p.replace(/\+/g, ' '));
    }

    function URLToArrayNew() {
        var res = {};

        $('.toolbar .layout span').each(function () {
            if ($(this).hasClass('active')) {
                res['layout'] = $(this).data('value');
            }
        });

        res['orderby'] = '';

        var sPageURL = window.location.search.substring(1);
        if (sPageURL != '') {
            var sURLVariables = sPageURL.split('&');
            if (sURLVariables.length) {
                for (var i = 0; i < sURLVariables.length; i++) {
                    var sParameterName = sURLVariables[i].split('=');
                    if (sParameterName.length) {
                        let val = decodeQueryParam(sParameterName[1]);
                        res[decodeURIComponent(sParameterName[0])] = val == 'undefined' ? '' : val;
                    }
                }
            }
        }
        return res;
    }

    let SingleCarDetail = {
        $body: $('body'),
        renderHtmlCar() {
            var form = jQuery('form.car-booking-form');
            var data = jQuery('form.car-booking-form').serializeArray();

            jQuery('.loader-wrapper').hide();
            data.push({
                name: 'security',
                value: st_params._s
            });
            for (var i = 0; i < data.length; i++) {

                if (data[i].name === 'action') {
                    data[i]['value'] = 'st_format_car_price';
                }
            };

            jQuery.ajax({
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
                    jQuery('.loader-wrapper').hide();
                    if (response) {
                        if (response.price_html) {
                            if (jQuery('.form-head').length > 0) {
                                jQuery('.form-head').html(response.price_html);
                            }

                            jQuery('.message_box').html('');
                            ci = 0;
                        } else {
                            if (response.message) {
                                jQuery('#form-booking-inpage .message-wrapper').html('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> ' + response.message + ' </div>');
                            }
                        }
                    }
                }
            });
        },
        init() {
            let base = this;
            base._stcheckDateCar(base.$body);
            base._gallery_sliderCarThumb(base.$body);
            base._bookingCarAjax();

        },
        _gallery_sliderCarThumb(body) {
            //Slider gallery single hotel detail
            if (window.matchMedia('(min-width: 992px)').matches) {
                $('.st-gallery-car', body).each(function () {
                    var parent = $(this);
                    var $fotoramaDiv = $('.fotorama', parent).fotorama({
                        width: parent.data('width'),
                        nav: parent.data('nav'),
                        allowfullscreen: parent.data('allowfullscreen'),
                        thumbheight: 100,
                        thumbwidth: 154,
                        thumbmargin: 20,
                        thumbborderwidth: 1
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
        },
        _bookingCarAjax() {
            $('form.car-booking-form').on('click', 'button.btn-book-ajax', function (e) {
                e.preventDefault();
                var form = $('form.car-booking-form');
                var data = $('form.car-booking-form').serializeArray();
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
        _stcheckDateCar(body) {
            // $('.st-single-car .form-date-search.form-date-car', body).each(function () {
            //     var parent = $(this),
            //             date_wrapper = $('.date-wrapper', parent),
            //             check_in_input = $('.check-in-input', parent),
            //             check_out_input = $('.check-out-input', parent),
            //             check_in_out = $('.check-in-out', parent),
            //             check_in_render = $('.check-in-render', parent),
            //             check_out_render = $('.check-out-render', parent);
            //     var timepicker = parent.data('timepicker');
            //     if (typeof timepicker == 'undefined' || timepicker == '') {
            //         timepicker = false;
            //     } else {
            //         timepicker = true;
            //     }
            //     var options = {
            //         singleDatePicker: false,
            //         sameDate: true,
            //         sameDateMulti: true,
            //         autoApply: true,
            //         disabledPast: true,
            //         dateFormat: 'DD/MM/YYYY',
            //         timeFormat: (st_params.time_format == '12h') ? 'hh:mm A' : 'HH:mm',
            //         customClass: '',
            //         widthSingle: 500,
            //         onlyShowCurrentMonth: true,
            //         timePicker: timepicker,
            //         timePicker24Hour: (st_params.time_format == '12h') ? false : true,
            //     };
            //     if (typeof locale_daterangepicker == 'object') {
            //         options.locale = locale_daterangepicker;
            //     }
            //     date_wrapper.daterangepicker(options,
            //         function (start, end, label) {

            //             $('#tp_hotel .form-date-search .check-in-input').val(start.format('YYYY-MM-DD')).trigger('change');
            //             $('#tp_hotel .form-date-search .check-out-input').val(end.format('YYYY-MM-DD')).trigger('change');
            //             check_in_input.val(start.format(parent.data('format'))).trigger('change');
            //             check_in_render.html(start.format(parent.data('format'))).trigger('change');
            //             check_out_input.val(end.format(parent.data('format'))).trigger('change');
            //             check_out_render.html(end.format(parent.data('format'))).trigger('change');
            //             if (timepicker) {
            //                 check_in_input.val(start.format(parent.data('date-format'))).trigger('change');
            //                 $('.check-in-input-time', parent).val(start.format(parent.data('time-format'))).trigger('change');
            //                 check_out_input.val(end.format(parent.data('date-format'))).trigger('change');
            //                 $('.check-out-input-time', parent).val(end.format(parent.data('time-format'))).trigger('change');
            //             }
            //             check_in_out.trigger('daterangepicker_change', [start, end]);
            //             $(body).removeClass('st_overflow');
            //             if (window.matchMedia('(max-width: 767px)').matches) {
            //                 $('label', parent).hide();
            //                 $('.render', parent).show();
            //                 $('.check-in-wrapper span', parent).show();
            //             }

            //             if(st_params.caculator_price_single_ajax === 'on'){
            //                 if($('.single-st_cars .car-booking-form').length > 0) {
            //                     date_wrapper.trigger('car-booking-form');
            //                 }
            //             }
            //      });
            //     date_wrapper.on('click',function (e) {
            //         check_in_out.trigger('click');
            //     });
            // });

            if (st_params.caculator_price_single_ajax && st_params.caculator_price_single_ajax === 'on') {
                //Car
                jQuery(function ($) {
                    if (jQuery('.car-booking-form').length > 0) {
                        if (jQuery('.form-more-extra .extras').length > 0) {
                            jQuery('.form-more-extra .extras li').each(function () {
                                jQuery(this).find('.extra-service-select').on('change', function () {
                                    SingleCarDetail.renderHtmlCar();
                                })
                            });
                        }
                        $('.car-booking-form  .check-in-out').on('apply.daterangepicker', function (event) {
                            SingleCarDetail.renderHtmlCar(event);
                        });
                    }
                });

            }
            jQuery(function ($) {
                $(".date-wrapper").on("car-booking-form", function (event) {
                    SingleCarDetail.renderHtmlCar(event);
                });

            });
        }
    }
    SingleCarDetail.init();
})(jQuery);