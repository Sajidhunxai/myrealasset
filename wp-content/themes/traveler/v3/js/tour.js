(function ($) {
    var requestRunning = false;
    var xhr;
    var hasFilter = false;

    var data = URLToArrayNew();
    //Search page
    jQuery(function ($) {
        if($('.st-style-elementor.search-result-page').length) {
            $('.show-filter-mobile .button-filter').on('click', function() {
                $('.sidebar-filter').fadeIn();
            });
            $('.sidebar-filter .close-sidebar').on('click', function() {
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

        function doneResizing(){
            ajaxFilterHandler();
        }
    });

    /*Layout*/
    $('.toolbar .layout span.layout-item').on('click', function () {
        if(!$(this).hasClass('active')){
            $(this).parent().find('span').removeClass('active');
            $(this).addClass('active');
            data['layout'] = $(this).data('value');
            ajaxFilterHandler(false);
        }
    });

    /*Sort menu*/
    $('.sort-menu input.service_order').on('change',function () {
        data['orderby'] = $(this).data('value');
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
        if(!Object.keys(filter_checkbox).includes($(this).data('type'))){
            filter_checkbox[$(this).data('type')] = [];
        }
    });

    $('.filter-item').on('change',function () {
       var t = $(this);
       var filter_type = t.data('type');
       if(t.is(':checked')){
           filter_checkbox[filter_type].push(t.val());
       }else{
           var index = filter_checkbox[filter_type].indexOf(t.val());
           if (index > -1) {
               filter_checkbox[filter_type].splice(index, 1);
           }
       }
       if(filter_checkbox[filter_type].length){
           data[filter_type] = filter_checkbox[filter_type].toString();
       }else{
           if(typeof data[filter_type] != 'undefined'){
               delete data[filter_type];
           }
       }
        data['page'] = 1;
        ajaxFilterHandler();
    });

    /*Taxnonomy*/
    var arrTax = [];
    $('.filter-tax').each(function () {
        if(!Object.keys(arrTax).includes($(this).data('type'))){
            arrTax[$(this).data('type')] = [];
        }

        if($(this).is(':checked')){
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
            if($('.modern-search-result-popup').length){
                $('.col-left-map').animate({scrollTop: 0}, 'slow');
            }

            if($('#modern-result-string').length) {
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

    $('.filter-tax').on('change',function () {
        var t = $(this);
        var filter_type = t.data('type');

        if(t.is(':checked')){
            arrTax[filter_type].push(t.val());
        }else{
            var index = arrTax[filter_type].indexOf(t.val());
            if (index > -1) {
                arrTax[filter_type].splice(index, 1);
            }
        }
        if(arrTax[filter_type].length){
            if(typeof data['taxonomy'] == 'undefined')
                data['taxonomy'] = {};
            data['taxonomy['+filter_type+']'] = arrTax[filter_type].toString();
        }else{
            if(typeof data['taxonomy'] == 'undefined')
                data['taxonomy'] = {};
            if(typeof data['taxonomy['+filter_type+']'] != 'undefined'){
                delete data['taxonomy['+filter_type+']'];
            }
        }

        if(Object.keys(data['taxonomy']).length <= 0){
            delete data['taxonomy'];
        }
        data['page'] = 1;
        ajaxFilterHandler();
    });

    $('.toolbar-action-mobile .btn-date').on('click',function (e) {
        e.preventDefault();
        var me = $(this);
        window.scrollTo({
            top     : 0,
            behavior: 'auto'
        });
        $('.popup-date').each(function () {
            var t = $(this);

            var checkinOut = t.find('.check-in-out');
            var options = {
                singleDatePicker: false,
                autoApply: true,
                disabledPast: true,
                dateFormat: t.data('format'),
                customClass: 'popup-date-custom',
                widthSingle: 500,
                onlyShowCurrentMonth: true,
                alwaysShowCalendars: true,
            };
            if (typeof locale_daterangepicker == 'object') {
                options.locale = locale_daterangepicker;
            }
            checkinOut.daterangepicker(options,
                function (start, end, label) {
                    me.text(start.format(t.data('format')) + ' - ' + end.format(t.data('format')));
                    data['start'] = start.format(t.data('format'));
                    data['end'] = end.format(t.data('format'));
                    if($('#modern-result-string').length) {
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

    $('.popup-close').on('click',function () {
        $(this).closest('.st-popup').hide();
    });

    function ajaxFilterHandler(loadMap = true){
        if (requestRunning) {
            xhr.abort();
        }
        data['layout'] = data['layout'] || $('.search-result-page').attr('data-style');
        if($('#tour-top-search').length > 0){
            data['top_search'] = 1;
        }

        hasFilter = true;

        $('html, body').css({'overflow': 'auto'});

        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.sidebar-filter').fadeOut();
            // $('.top-filter').fadeOut();

            if($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.filter-loading').show();
        var layout = $('#modern-search-result').data('layout');
        data['format'] = $('#modern-search-result').data('format');
        if($('.modern-search-result-popup').length){
            data['is_popup_map'] = '1';
        }

        data['action'] = 'st_filter_tour_ajax';
        data['is_search_page'] = 1;
        data['_s'] = st_params._s;
        if(typeof  data['page'] == 'undefined'){
            data['page'] = 1;
        }

        var divResult = $('.modern-search-result');
        var divResultString = $('.modern-result-string');
        var divPagination = $('.moderm-pagination');

        divResult.addClass('loading');
        $('.map-content-loading').each(function( index ) {
            $(this).fadeIn();
        });

        if ($('.search-result-page.tour-layout6, .search-result-page.tour-layout7').length) {
            let wrapper = $('.search-result-page');
            data['version'] = 'elementorv2';
            data['version_layout'] = wrapper.data('layout');
            data['version_format'] = wrapper.data('format');

            if (window.matchMedia('(max-width: 767px)').matches) {
                if($('.st-style-elementor.search-result-page').length){
                    if(data['layout'] !== 'grid'){
                        data['layout'] = 'grid';
                        data['layout_old'] = 'list';
                    }
                }
            }else{
                if($('.st-style-elementor.search-result-page').length){
                    if(typeof data['layout_old'] !== 'undefined' && data['layout_old'] != ''){
                        data['layout'] = data['layout_old'];
                        data['layout_old'] = '';
                    }
                }
            }
        }

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
                $('.map-content-loading').each(function() {
                    $(this).fadeOut();
                });


                var time = 0;
                divResult.find('img').one("load", function() {
                    $(this).addClass('loaded');
                    if(divResult.find('img.loaded').length === divResult.find('img').length) {
                        console.log("All images loaded!");
                        if($('.has-matchHeight').length){
                            $('.has-matchHeight').matchHeight({ remove: true });
                            $('.has-matchHeight').matchHeight();
                        }
                    }
                });

                if(checkClearFilter()){
                    $('.btn-clear-filter').fadeIn();
                }else{
                    $('.btn-clear-filter').fadeOut();
                }
                requestRunning = false;
            },
        });
        requestRunning = true;
    }

    jQuery(function($) {
        if(checkClearFilter()){
            $('.btn-clear-filter').fadeIn();
        }else{
            $('.btn-clear-filter').fadeOut();
        }
        $(document).on('click', '#btn-clear-filter , .btn-clear-filter', function () {
            var arrResetTax = [];
            $('.filter-tax').each(function () {
                if(!Object.keys(arrResetTax).includes($(this).data('type'))){
                    arrResetTax[$(this).data('type')] = [];
                }

                if($(this).length) {
                    $(this).prop('checked', false);
                    $(this).trigger('change');
                }
            });

            if(Object.keys(arrResetTax).length){
                for(var i = 0; i < Object.keys(arrResetTax).length; i++){
                    if(typeof data['taxonomy['+ Object.keys(arrResetTax)[i] +']'] != 'undefined'){
                        delete data['taxonomy['+ Object.keys(arrResetTax)[i] +']'];
                    }
                }
            }

            if(typeof data['price_range'] != 'undefined'){
                delete data['price_range'];
                $('input[name="price_range"]').each(function () {
                    var sliderPrice = $(this).data("ionRangeSlider");
                    sliderPrice.reset();
                });
            }

            if(typeof data['star_rate'] != 'undefined'){
                delete data['star_rate'];
            }

            if($('.filter-item').length) {
                $('.filter-item').prop('checked', false);
            }
            if($('.filter-tax').length) {
                $('.filter-tax').prop('checked', false);
            }

            if($('.sort-item').length){
                data['orderby'] = '';
                $('.sort-item').find('input').prop('checked', false);
                $('.sort-item').find('input[data-value=""]').prop('checked', true);
            }
            $(document).trigger('st_clear_filter_action');

            ajaxFilterHandler();
            hasFilter = false;
            $(this).fadeOut();

        });
    });

    function checkClearFilter(){
        if(((typeof data['price_range'] != 'undefined' && data['price_range'].length) || (typeof data['star_rate'] != 'undefined' && data['star_rate'].length )|| (typeof data['taxonomy[duration]'] != 'undefined' && data['taxonomy[duration]'].length ) || (typeof data['taxonomy[st_tour_type]'] != 'undefined' && data['taxonomy[st_tour_type]'].length ) || (typeof data['taxonomy[languages]'] != 'undefined' && data['taxonomy[languages]'].length ) || (typeof data['orderby'] != 'undefined' && data['orderby'].length &&  data['orderby'] != 'new')) && hasFilter){
            return true;
        }else{
            return false;
        }
    }

    function decodeQueryParam(p) {
        if(typeof p != 'undefined'){
            return decodeURIComponent(p.replace(/\+/g, ' '));
        }

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

})(jQuery);
