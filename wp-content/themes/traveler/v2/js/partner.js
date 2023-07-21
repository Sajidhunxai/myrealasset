jQuery(function($) {
    $(".sidebar-dropdown").on('click',function() {
        $(".sidebar-submenu").slideUp(200);
        if ($(this).hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).find(".sidebar-submenu").slideDown(200);
            $(this).addClass("active");
        }
    });
    $("#close-sidebar").on('click',function() {
        $(".page-wrapper").removeClass("toggled");
        $('body').removeClass('with-panel-right-reveal');
        $(".with-panel-right-reveal .sidenav-overlay").hide();
    });
    $(".sidenav-overlay").on('click',function() {
        $(".page-wrapper").removeClass("toggled");
        $('body').removeClass('with-panel-right-reveal');
        $(".with-panel-right-reveal .sidenav-overlay").hide();
    });
    $("#show-sidebar").on('click',function() {
        $('body').addClass('with-panel-right-reveal');
        $(".page-wrapper").addClass("toggled");
        $(".with-panel-right-reveal .sidenav-overlay").show();
    });
    /*Data chart*/
    $('#mySelect-tab').on('change', function (e) {
        // $('#myTab li a').eq($(this).val()).tab('show');
        var id = $(this).val();
        console.log(id);
        $('#myTab li a[href="#' + id + '"]').tab('show');
    });
    let partnerSearchFormInput = $('.partner-search-form input[name=_s]');
    let partnerSearchFormButton = $('.partner-search-form button[type=submit]');
    partnerSearchFormButton.prop('disabled', true);
    partnerSearchFormInput.on('keyup', function(e) {
        if ($(this).val().trim()) {
            partnerSearchFormButton.prop('disabled', false);
        } else {
            partnerSearchFormButton.prop('disabled', true);
        }
    });

    /*Wishlist*/
    /* Pagination Hotel */

    var st_loadding_wishlist = $('.infor-st-setting.st-wishlist-wrap .st-loadding-wishlist');
    var requestRunning = false;
    var xhr;
    var hasFilter = false;
    var data = URLToArrayNew();
    function URLToArrayNew() {
        var res = {};

        $('.toolbar .layout span').each(function () {
           if($(this).hasClass('active')){
               res['layout'] = $(this).data('value');
           }
        });

        res['orderby'] = '';

        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        if(sURLVariables.length){
            for (var i = 0; i < sURLVariables.length; i++){
                var sParameterName = sURLVariables[i].split('=');
                if(sParameterName.length){
                    let val = decodeURIComponent(sParameterName[1]);
                    res[decodeURIComponent(sParameterName[0])] = val == 'undefined'? '': val;
                }
            }
        }
        return res;
    }
    $(document).on('click', '#modern-pagination-hotel a.page-numbers:not(.current, .dots)', function (e) {
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
            ajaxFilterHandlerWishletHotel();
            if($('.modern-search-result-popup').length){
                $('.col-left-map').animate({scrollTop: 0}, 'slow');
            }

            if($('#modern-result-string').length) {
                    window.scrollTo({
                        top: $('#list-wishlist-hotel').offset().top - 20,
                        behavior: 'smooth'
                    });
            }
            return false;
        } else {
            return false;
        }
    });

    function ajaxFilterHandlerWishletHotel(){
        if (requestRunning) {
            xhr.abort();
        }

        hasFilter = true;
        $('html, body').css({'overflow': 'auto'});
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.sidebar-filter').fadeOut();
            $('.top-filter').fadeOut();

            if($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.filter-loading').show();
        var layout = $('#modern-search-result').data('layout');
        data['list-wishlist'] = $('.booking-list.st-wishlist-hotel').data('list-wishlist');
        data['format'] = $('#modern-search-result').data('format');
        if($('#st-layout-fullwidth').length)
            data['fullwidth'] = 1;
        if($('.modern-search-result-popup').length){
            data['is_popup_map'] = '1';
        }

        data['action'] = 'st_filter_hotel_wishlist_ajax';
        data['is_search_page'] = 1;
        data['_s'] = st_params._s;
        if(typeof  data['page'] == 'undefined'){
            data['page'] = 1;
        }

        var divResult = $('.st-wishlist-hotel .page-numbers');
        var divResultString = $('.modern-result-string');
        var divPagination = $('#modern-pagination-hotel');

        divResult.addClass('loading');
        st_loadding_wishlist.show();
        xhr = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            success: function (doc) {
                divResult.each(function () {
                    $(this).html(doc.content);
                });

                divPagination.each(function () {
                    $(this).html(doc.pag);
                });

                
            },
            complete: function () {
                st_loadding_wishlist.hide();
                requestRunning = false;
            },
        });
        requestRunning = true;
    }

    /* Pagination Tour */
    var requestRunning_Tour = false;
    var xhr_tour;
    var hasFilter_tour = false;
    var data_tour = URLToArrayNewTour();
    function URLToArrayNewTour() {
        var res = {};

        $('.toolbar .layout span').each(function () {
           if($(this).hasClass('active')){
               res['layout'] = $(this).data('value');
           }
        });

        res['orderby'] = '';

        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        if(sURLVariables.length){
            for (var i = 0; i < sURLVariables.length; i++){
                var sParameterName = sURLVariables[i].split('=');
                if(sParameterName.length){
                    let val = decodeURIComponent(sParameterName[1]);
                    res[decodeURIComponent(sParameterName[0])] = val == 'undefined'? '': val;
                }
            }
        }
        return res;
    }
    $(document).on('click', '#modern-pagination-tour a.page-numbers:not(.current, .dots)', function (e) {
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
            data_tour['page'] = pageNum;
            ajaxFilterHandlerWishletTour();
            if($('.modern-search-result-popup').length){
                $('.col-left-map').animate({scrollTop: 0}, 'slow');
            }

            if($('#modern-result-string').length) {
                    window.scrollTo({
                        top: $('#list-wishlist-hotel').offset().top - 20,
                        behavior: 'smooth'
                    });
            }
            return false;
        } else {
            return false;
        }
    });

    function ajaxFilterHandlerWishletTour(){
        if (requestRunning_Tour) {
            xhr_tour.abort();
        }

        hasFilter_tour = true;
        $('html, body').css({'overflow': 'auto'});
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.sidebar-filter').fadeOut();
            $('.top-filter').fadeOut();

            if($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.filter-loading').show();
        var layout = $('#modern-search-result').data('layout');
        data_tour['list-wishlist'] = $('.booking-list.st-wishlist-tour').data('list-wishlist-tour');
        data_tour['format'] = $('#modern-search-result').data('format');
        if($('#st-layout-fullwidth').length)
            data_tour['fullwidth'] = 1;
        if($('.modern-search-result-popup').length){
            data_tour['is_popup_map'] = '1';
        }

        data_tour['action'] = 'st_filter_tour_wishlist_ajax';
        data_tour['is_search_page'] = 1;
        data_tour['_s'] = st_params._s;
        if(typeof  data_tour['page'] == 'undefined'){
            data_tour['page'] = 1;
        }

        var divResultTour = $('.st-wishlist-tour .page-numbers');
        var divResultTourString = $('.modern-result-string');
        var divPagination = $('#modern-pagination-tour');

        divResultTour.addClass('loading');
        st_loadding_wishlist.show();
        xhr_tour = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data_tour,
            success: function (doc) {
                divResultTour.each(function () {
                    $(this).html(doc.content);
                });

                divPagination.each(function () {
                    $(this).html(doc.pag);
                });

                
            },
            complete: function () {
                st_loadding_wishlist.hide();
                requestRunning_Tour = false;
            },
        });
        requestRunning_Tour = true;
    }

    /* Pagination Activity */
    var requestRunning_activity = false;
    var xhr_activity;
    var hasFilter_activity = false;
    var data_activity = URLToArrayNewactivity();
    function URLToArrayNewactivity() {
        var res = {};

        $('.toolbar .layout span').each(function () {
           if($(this).hasClass('active')){
               res['layout'] = $(this).data('value');
           }
        });

        res['orderby'] = '';

        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        if(sURLVariables.length){
            for (var i = 0; i < sURLVariables.length; i++){
                var sParameterName = sURLVariables[i].split('=');
                if(sParameterName.length){
                    let val = decodeURIComponent(sParameterName[1]);
                    res[decodeURIComponent(sParameterName[0])] = val == 'undefined'? '': val;
                }
            }
        }
        return res;
    }
    $(document).on('click', '#modern-pagination-activity a.page-numbers:not(.current, .dots)', function (e) {
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
            data_activity['page'] = pageNum;
            ajaxFilterHandlerWishletactivity();
            if($('.modern-search-result-popup').length){
                $('.col-left-map').animate({scrollTop: 0}, 'slow');
            }

            if($('#modern-result-string').length) {
                    window.scrollTo({
                        top: $('#list-wishlist-hotel').offset().top - 20,
                        behavior: 'smooth'
                    });
            }
            return false;
        } else {
            return false;
        }
    });

    function ajaxFilterHandlerWishletactivity(){
        if (requestRunning_activity) {
            xhr_activity.abort();
        }

        hasFilter_activity = true;
        $('html, body').css({'overflow': 'auto'});
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.sidebar-filter').fadeOut();
            $('.top-filter').fadeOut();

            if($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.filter-loading').show();
        var layout = $('#modern-search-result').data('layout');
        data_activity['list-wishlist'] = $('.booking-list.st-wishlist-activity').data('list-wishlist-activity');
        data_activity['format'] = $('#modern-search-result').data('format');
        if($('#st-layout-fullwidth').length)
            data_activity['fullwidth'] = 1;
        if($('.modern-search-result-popup').length){
            data_activity['is_popup_map'] = '1';
        }

        data_activity['action'] = 'st_filter_activity_wishlist_ajax';
        data_activity['is_search_page'] = 1;
        data_activity['_s'] = st_params._s;
        if(typeof  data_activity['page'] == 'undefined'){
            data_activity['page'] = 1;
        }

        var divResultactivity = $('.st-wishlist-activity .page-numbers');
        var divResultactivityString = $('.modern-result-string');
        var divPagination = $('#modern-pagination-activity');

        divResultactivity.addClass('loading');
        st_loadding_wishlist.show();
        xhr_activity = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data_activity,
            success: function (doc) {
                divResultactivity.each(function () {
                    $(this).html(doc.content);
                });

                divPagination.each(function () {
                    $(this).html(doc.pag);
                });

                
            },
            complete: function () {
                st_loadding_wishlist.hide();
                requestRunning_activity = false;
            },
        });
        requestRunning_activity = true;
    }


    /* Pagination Rental */
    var requestRunning_rental = false;
    var xhr_rental;
    var hasFilter_rental = false;
    var data_rental = URLToArrayNewrental();
    function URLToArrayNewrental() {
        var res = {};

        $('.toolbar .layout span').each(function () {
           if($(this).hasClass('active')){
               res['layout'] = $(this).data('value');
           }
        });

        res['orderby'] = '';

        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        if(sURLVariables.length){
            for (var i = 0; i < sURLVariables.length; i++){
                var sParameterName = sURLVariables[i].split('=');
                if(sParameterName.length){
                    let val = decodeURIComponent(sParameterName[1]);
                    res[decodeURIComponent(sParameterName[0])] = val == 'undefined'? '': val;
                }
            }
        }
        return res;
    }
    $(document).on('click', '#modern-pagination-rental a.page-numbers:not(.current, .dots)', function (e) {
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
            data_rental['page'] = pageNum;
            ajaxFilterHandlerWishletrental();
            if($('.modern-search-result-popup').length){
                $('.col-left-map').animate({scrollTop: 0}, 'slow');
            }

            if($('#modern-result-string').length) {
                    window.scrollTo({
                        top: $('#list-wishlist-hotel').offset().top - 20,
                        behavior: 'smooth'
                    });
            }
            return false;
        } else {
            return false;
        }
    });

    function ajaxFilterHandlerWishletrental(){
        if (requestRunning_rental) {
            xhr_rental.abort();
        }

        hasFilter_rental = true;
        $('html, body').css({'overflow': 'auto'});
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.sidebar-filter').fadeOut();
            $('.top-filter').fadeOut();

            if($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.filter-loading').show();
        var layout = $('#modern-search-result').data('layout');
        data_rental['list-wishlist'] = $('.booking-list.st-wishlist-rental').data('list-wishlist-rental');
        data_rental['format'] = $('#modern-search-result').data('format');
        if($('#st-layout-fullwidth').length)
            data_rental['fullwidth'] = 1;
        if($('.modern-search-result-popup').length){
            data_rental['is_popup_map'] = '1';
        }

        data_rental['action'] = 'st_filter_rental_wishlist_ajax';
        data_rental['is_search_page'] = 1;
        data_rental['_s'] = st_params._s;
        if(typeof  data_rental['page'] == 'undefined'){
            data_rental['page'] = 1;
        }

        var divResultrental = $('.st-wishlist-rental .page-numbers');
        var divResultrentalString = $('.modern-result-string');
        var divPagination = $('#modern-pagination-rental');

        divResultrental.addClass('loading');
        st_loadding_wishlist.show();
        xhr_rental = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data_rental,
            success: function (doc) {
                divResultrental.each(function () {
                    $(this).html(doc.content);
                });

                divPagination.each(function () {
                    $(this).html(doc.pag);
                });

                
            },
            complete: function () {
                st_loadding_wishlist.hide();
                requestRunning_rental = false;
            },
        });
        requestRunning_rental = true;
    }
    /* Pagination Car */
    var requestRunning_car = false;
    var xhr_car;
    var hasFilter_car = false;
    var data_car = URLToArrayNewcar();
    function URLToArrayNewcar() {
        var res = {};

        $('.toolbar .layout span').each(function () {
           if($(this).hasClass('active')){
               res['layout'] = $(this).data('value');
           }
        });

        res['orderby'] = '';

        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        if(sURLVariables.length){
            for (var i = 0; i < sURLVariables.length; i++){
                var sParameterName = sURLVariables[i].split('=');
                if(sParameterName.length){
                    let val = decodeURIComponent(sParameterName[1]);
                    res[decodeURIComponent(sParameterName[0])] = val == 'undefined'? '': val;
                }
            }
        }
        return res;
    }
    $(document).on('click', '#modern-pagination-car a.page-numbers:not(.current, .dots)', function (e) {
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
            data_car['page'] = pageNum;
            ajaxFilterHandlerWishletcar();
            if($('.modern-search-result-popup').length){
                $('.col-left-map').animate({scrollTop: 0}, 'slow');
            }

            if($('#modern-result-string').length) {
                    window.scrollTo({
                        top: $('#list-wishlist-hotel').offset().top - 20,
                        behavior: 'smooth'
                    });
            }
            return false;
        } else {
            return false;
        }
    });

    function ajaxFilterHandlerWishletcar(){
        if (requestRunning_car) {
            xhr_car.abort();
        }

        hasFilter_car = true;
        $('html, body').css({'overflow': 'auto'});
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.sidebar-filter').fadeOut();
            $('.top-filter').fadeOut();

            if($('#modern-result-string').length) {
                window.scrollTo({
                    top: $('#modern-result-string').offset().top - 20,
                    behavior: 'smooth'
                });
            }
        }

        $('.filter-loading').show();
        var layout = $('#modern-search-result').data('layout');
        data_car['list-wishlist'] = $('.booking-list.st-wishlist-car').data('list-wishlist-car');
        data_car['format'] = $('#modern-search-result').data('format');
        if($('#st-layout-fullwidth').length)
            data_car['fullwidth'] = 1;
        if($('.modern-search-result-popup').length){
            data_car['is_popup_map'] = '1';
        }

        data_car['action'] = 'st_filter_car_wishlist_ajax';
        data_car['is_search_page'] = 1;
        data_car['_s'] = st_params._s;
        if(typeof  data_car['page'] == 'undefined'){
            data_car['page'] = 1;
        }

        var divResultcar = $('.st-wishlist-car .page-numbers');
        var divResultcarString = $('.modern-result-string');
        var divPagination = $('#modern-pagination-car');

        divResultcar.addClass('loading');
        st_loadding_wishlist.show();
        xhr_car = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data_car,
            success: function (doc) {
                divResultcar.each(function () {
                    $(this).html(doc.content);
                });

                divPagination.each(function () {
                    $(this).html(doc.pag);
                });

                
            },
            complete: function () {
                st_loadding_wishlist.hide();
                requestRunning_car = false;
            },
        });
        requestRunning_car = true;
    }

    //GuestName
    $(function() {
        var parent = $('.form-add-booking-partner');
        var adultNumber = $('#form-add-booking-partner select[name="adult_number"]');
        var childrenNumber = $('#form-add-booking-partner select[name="child_number"]');
        var infantNumber = $('#form-add-booking-partner select[name="infant_number"]');
        var guestNameInput = $('#form-add-booking-partner .guest_name_input');
        adultNumber.value = 1;
        childrenNumber.value = 0;
        infantNumber.value = 0;
        $("#form-add-booking-partner").on("triggerGuestPartner", function(){
            triggerGuestInputChange(adultNumber,childrenNumber,infantNumber);
        });
        if($('.form-add-booking-partner').length > 0){
            triggerGuestInputChange(adultNumber,childrenNumber,infantNumber);
            $(document).on('change', '#form-add-booking-partner select[name="adult_number"]', function() { 
                adultNumber.value = ($(this).find('option:selected').val());
                triggerGuestInputChange(adultNumber,childrenNumber,infantNumber);
            });
            $(document).on('change', '#form-add-booking-partner select[name="child_number"]', function() { 
                childrenNumber.value = ($(this).find('option:selected').val());
                triggerGuestInputChange(adultNumber,childrenNumber,infantNumber);
            });
            $(document).on('change', '#form-add-booking-partner select[name="infant_number"]', function() { 
                infantNumber.value = ($(this).find('option:selected').val());
                triggerGuestInputChange(adultNumber,childrenNumber,infantNumber);
            });
            function triggerGuestInputChange(adultNumber,childrenNumber,infantNumber) {
                var adult = parseInt(adultNumber.value);
                var children = parseInt(childrenNumber.value);
                var infant = parseInt(infantNumber.value);
                var hideAdultElement = document.querySelector("#form-add-booking-partner .guest_name_input");
                if(hideAdultElement){
                    var hideAdult = hideAdultElement.getAttribute('data-hide-adult');
                    var hideChildren = hideAdultElement.getAttribute('data-hide-children');
                    var hideInfant = hideAdultElement.getAttribute('data-hide-infant');
                }else {
                    var hideAdult = 'off';
                    var hideChildren = 'off';
                    var hideInfant = 'off';
                }
            
                var controlWraps = guestNameInput.find('.guest_name_control');
                var controls = guestNameInput.find('.control-item');
                
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
                    adult += children;
                }
                if (typeof hideInfant == 'undefined' || hideInfant != 'on'){
                    adult += infant;
                }
                //adult-=1;// Only input guest >=2 name

                if (adult <= 0) {
                    guestNameInput.addClass('d-none');
                } else {
                    // Append
                    if($('#guest_name_control_item').length > 0){
                    
                        for (var i = controls.length ? (controls.length) : 0; i < adult; i++)
                        {
                            var div = $($('#guest_name_control_item').clone().html());
                            var p = div.find('input').attr('placeholder');
                            div.find('input').attr('placeholder', p.replace('%d', i + 1));
                    
                            $('.guest_name_control').append(div);
                        }

                        // Remove
                        $('.guest_name_control .control-item').each(function () {
                            if ($(this).index() > adult - 1)
                            {
                                $(this).remove();
                            }
                        });

                        guestNameInput.removeClass('d-none');
                    }
                }
            }
        }
        
    });
});