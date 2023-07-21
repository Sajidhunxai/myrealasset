
    /* Pagination */
jQuery(function($){

    setTimeout(function () {
        $('.list_ccv .has-matchHeight').matchHeight({remove: true});
        $('.list_ccv .has-matchHeight').matchHeight();
    }, 500);
    var data = URLToArrayNew();
    var requestRunning = false;
    var xhr;
    var checkOrderBy = false;
    /*Hotel*/
    $(document).on('click', '.st-tab-service-content #st_hotel_ccv .st-pagination-ccv a.page-numbers', function (e) {
        e.preventDefault();
        if (requestRunning) {
            xhr.abort();
        }
        var posts_per_page = $('#ajax-filter-pag').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('page-numbers')) {
            $('.st-tab-service-content #st_hotel_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_hotel_ccv ul.page-numbers').length > 0) {
                $('#st_hotel_ccv  ul.page-numbers').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_hotel_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['location_id'] = id_location;
        var loadmore = $('.st-loader-ccv');
        xhr = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
                window.scrollTo({
                    top: $('.st-overview-content.st_tab_service').offset().top-30,
                    behavior: 'smooth'
                });
                loadmore.fadeIn();
            },
            success: function (doc) {
                $('#st_hotel_ccv .row-wrapper').empty();
                $('#st_hotel_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                setTimeout(function () {
                    $('.st-tab-service-content #hotel-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #hotel-search-result .has-matchHeight').matchHeight();
                }, 500);
                requestRunning = false;
            },
        });
        requestRunning = true;
    });

    if ($('#st_hotel_ccv .row-wrapper').length > 0) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('body').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        if (requestRunning) {
            xhr.abort();
        }
        var posts_per_page = $('#ajax-filter-pag').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('pagination')) {
            $('.st-tab-service-content #st_hotel_ccv .st-pagination-ccv a.pagination').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_hotel_ccv ul.pagination').length > 0) {
                $('#st_hotel_ccv ul.pagination').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_hotel_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        xhr = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
                loadmore.fadeIn();
            },
            success: function (doc) {
                $('#st_hotel_ccv .row-wrapper').empty();
                $('#st_hotel_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                requestRunning = false;
                setTimeout(function () {
                    $('.st-tab-service-content #hotel-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #hotel-search-result .has-matchHeight').matchHeight();
                }, 500);
                
            },
        });
        requestRunning = true;
    }

    /*Tour*/
    var requestRunning_to = false;
    var xhr_to;
    var checkOrderBy_to = false;
    $(document).on('click', '.st-tab-service-content #st_tours_ccv .st-pagination-ccv a.page-numbers', function (e) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('.st-overview-content.st_tab_service').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        e.preventDefault();
        if (requestRunning_to) {
            xhr_to.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-tour').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-tour').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('page-numbers')) {
            $('.st-tab-service-content #st_tours_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_tours_ccv ul.page-numbers').length > 0) {
                $('#st_tours_ccv ul.page-numbers').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_tour_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_to = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
               
            },
            success: function (doc) {
                $('#st_tours_ccv .row-wrapper').empty();
                $('#st_tours_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-tour').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                requestRunning_to = false;
                setTimeout(function () {
                    $('.st-tab-service-content #tour-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #tour-search-result .has-matchHeight').matchHeight();
                }, 500);
            },
        });
        requestRunning_to = true;
    });

    if ($('#st_tours_ccv .row-wrapper').length > 0) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('body').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        if (requestRunning_to) {
            xhr_to.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-tour').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-tour').attr('id_location');
        var pageNum_to = 1;
        if ($(this).hasClass('pagination')) {
            $('.st-tab-service-content #st_tours_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url_to = $(this).attr('href');
            if (typeof url_to !== typeof undefined && url_to !== false) {
                var arr_to = url_to.split('/');
                var pageNum_to = arr_to[arr_to.indexOf('page') + 1];

                if (isNaN(pageNum_to)) {
                    pageNum_to = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_tours_ccv ul.pagination').length > 0) {
                $('#st_tours_ccv ul.pagination').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum_to = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum_to = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_tour_ajax_location';
        data['page'] = pageNum_to;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_to = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
                loadmore.fadeIn();
            },
            success: function (doc) {
                $('#st_tours_ccv .row-wrapper').empty();
                $('#st_tours_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-tour').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                setTimeout(function () {
                    $('.st-tab-service-content #tour-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #tour-search-result .has-matchHeight').matchHeight();
                }, 500);
                requestRunning_to = false;
            },
        });
        requestRunning_to = true;
    }

    /*Rental*/
    var requestRunning_ren = false;
    var xhr_ren;
    var checkOrderBy_ren = false;
    $(document).on('click', '.st-tab-service-content #st_rental_ccv .st-pagination-ccv a.page-numbers', function (e) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('.st-overview-content.st_tab_service').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        e.preventDefault();
        if (requestRunning_ren) {
            xhr_ren.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-rental').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-rental').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('page-numbers')) {
            $('.st-tab-service-content #st_rental_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_rental_ccv ul.page-numbers').length > 0) {
                $('#st_rental_ccv ul.page-numbers').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_rental_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_ren = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
               
            },
            success: function (doc) {
                $('#st_rental_ccv .row-wrapper').empty();
                $('#st_rental_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-rental').html(doc.pag);
            },
            complete: function () {
                setTimeout(function () {
                    $('.st-tab-service-content #rental-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #rental-search-result .has-matchHeight').matchHeight();
                }, 500);
                loadmore.fadeOut();
                requestRunning_ren = false;
            },
        });
        requestRunning_ren = true;
    });

    if ($('#st_rental_ccv .row-wrapper').length > 0) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('body').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        if (requestRunning_ren) {
            xhr_ren.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-rental').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-rental').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('pagination')) {
            $('.st-tab-service-content #st_rental_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_rental_ccv ul.pagination').length > 0) {
                $('#st_rental_ccv ul.pagination').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_rental_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_ren = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
                loadmore.fadeIn();
            },
            success: function (doc) {
                $('#st_rental_ccv .row-wrapper').empty();
                $('#st_rental_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-rental').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                setTimeout(function () {
                    $('.st-tab-service-content #rental-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #rental-search-result .has-matchHeight').matchHeight();
                }, 500);
                requestRunning_ren = false;
            },
        });
        requestRunning_ren = true;
    }

    /*Activity*/
    var requestRunning_ac = false;
    var xhr_ac;
    var checkOrderBy_ac = false;
    $(document).on('click', '.st-tab-service-content #st_activity_ccv .st-pagination-ccv a.page-numbers', function (e) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('.st-overview-content.st_tab_service').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        e.preventDefault();
        if (requestRunning_ac) {
            xhr_ac.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-activity').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-activity').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('page-numbers')) {
            $('.st-tab-service-content #st_activity_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_activity_ccv ul.page-numbers').length > 0) {
                $('#st_activity_ccv ul.page-numbers').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_activity_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_ac = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
               
            },
            success: function (doc) {
                $('#st_activity_ccv .row-wrapper').empty();
                $('#st_activity_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-activity').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                setTimeout(function () {
                    $('.st-tab-service-content #activity-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #activity-search-result .has-matchHeight').matchHeight();
                }, 500);
                requestRunning_ac = false;
            },
        });
        requestRunning_ac = true;
    });
    if ($('#st_activity_ccv .row-wrapper').length > 0) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('body').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        if (requestRunning_ac) {
            xhr_ac.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-activity').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-activity').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('page-numbers')) {
            $('.st-tab-service-content #st_activity_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_activity_ccv ul.page-numbers').length > 0) {
                $('#st_activity_ccv ul.page-numbers').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_activity_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_ac = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
               loadmore.fadeIn();
            },
            success: function (doc) {
                $('#st_activity_ccv .row-wrapper').empty();
                $('#st_activity_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-activity').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                setTimeout(function () {
                    $('.st-tab-service-content #activity-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #activity-search-result .has-matchHeight').matchHeight();
                }, 500);
                requestRunning_ac = false;
            },
        });
        requestRunning_ac = true;
    }

    /*Car*/
    var requestRunning_car = false;
    var xhr_car;
    var checkOrderBy_car = false;
    $(document).on('click', '.st-tab-service-content #st_cars_ccv .st-pagination-ccv a.page-numbers', function (e) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('.st-overview-content.st_tab_service').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        e.preventDefault();
        if (requestRunning_car) {
            xhr_car.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-cars').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-cars').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('page-numbers')) {
            $('.st-tab-service-content #st_cars_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_cars_ccv ul.page-numbers').length > 0) {
                $('#st_cars_ccv ul.page-numbers').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_cars_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_car = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
               
            },
            success: function (doc) {
                $('#st_cars_ccv .row-wrapper').empty();
                $('#st_cars_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-cars').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                setTimeout(function () {
                    $('.st-tab-service-content #cars-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #cars-search-result .has-matchHeight').matchHeight();
                }, 500);
                requestRunning_car = false;
            },
        });
        requestRunning_car = true;
    });
    if ($('#st_cars_ccv .row-wrapper').length > 0) {
        var loadmore = $('.st-loader-ccv');
        window.scrollTo({
            top: $('body').offset().top-30,
            behavior: 'smooth'
        });
        loadmore.fadeIn();
        if (requestRunning_car) {
            xhr_car.abort();
        }
        var posts_per_page = $('#ajax-filter-pag-cars').attr('posts_per_page');
        var id_location = $('#ajax-filter-pag-cars').attr('id_location');
        var pageNum = 1;
        if ($(this).hasClass('page-numbers')) {
            $('.st-tab-service-content #st_cars_ccv .st-pagination-ccv a.page-numbers').removeClass('current');
            $(this).addClass('current');
            var url = $(this).attr('href');
            if (typeof url !== typeof undefined && url !== false) {
                var arr = url.split('/');
                var pageNum = arr[arr.indexOf('page') + 1];

                if (isNaN(pageNum)) {
                    pageNum = 1;
                }
            } else {
                return false;
            }
        } else {
            $(this).toggleClass('active');
            if ($('#st_cars_ccv ul.page-numbers').length > 0) {
                $('#st_cars_ccv ul.page-numbers').find('li').each(function () {
                    if ($(this).children().hasClass('current')) {
                        pageNum = $(this).children().text();
                    }
                });
            }

            if ($(this).data('type') != 'layout' && $(this).data('type') != 'order') {
                pageNum = 1;
            }
        }

        var arr_tax = [];
        data['action'] = 'st_filter_cars_ajax_location';
        data['page'] = pageNum;
        data['isajax_location'] = '1';
        data['posts_per_page'] = posts_per_page;
        data['id_location'] = id_location;
        
        xhr_car = $.ajax({
            url: st_params.ajax_url,
            dataType: 'json',
            type: 'get',
            data: data,
            beforeSend: function () {
                loadmore.fadeIn();
            },
            success: function (doc) {
                $('#st_cars_ccv .row-wrapper').empty();
                $('#st_cars_ccv .row-wrapper').append(doc.content);
                $('#ajax-filter-pag-cars').html(doc.pag);
            },
            complete: function () {
                loadmore.fadeOut();
                setTimeout(function () {
                    $('.st-tab-service-content #cars-search-result .has-matchHeight').matchHeight({remove: true});
                    $('.st-tab-service-content #cars-search-result .has-matchHeight').matchHeight();
                }, 500);
                requestRunning_car = false;
            },
        });
        requestRunning_car = true;
    }

    function URLToArrayNew() {
        var res = {};
        $('.toolbar .layout span').each(function () {
           if($(this).hasClass('active')){
               res['layout'] = $(this).data('value');
           }
        });
        res['orderby'] = 'new';
        res['check_single_location'] = 'is_location';
        var sPageURL = window.location.search.substring(1);
        if(sPageURL != '') {
            var sURLVariables = sPageURL.split('&');
            if (sURLVariables.length) {
                for (var i = 0; i < sURLVariables.length; i++) {
                    var sParameterName = sURLVariables[i].split('=');
                    if(sParameterName.length){
                        let val = decodeURIComponent(sParameterName[1]);
                        res[decodeURIComponent(sParameterName[0])] = val == 'undefined'? '': val;
                    }
                }
            }
        }
        return res;
    }
})
    
