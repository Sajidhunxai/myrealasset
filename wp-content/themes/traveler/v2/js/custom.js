jQuery(function ($) {
    $(".hotel-room-booking-form").on("hotel-room-booking-form", function (event) {
        renderHtmlHotel();
    });
});
jQuery(function ($) {
    $(".date-wrapper").on("tours-booking-form", function (event) {
        renderHtmlTour();
    });
});

jQuery(function ($) {
    $(".date-wrapper").on("rental-booking-form", function (event) {
        renderHtmlRental();
    });
});


jQuery(function ($) {
    $("body").on("cartransfer-booking-form", function (event, el) {
        renderHtmlCarstranfer(event, el);
    });
});

jQuery(function ($) {
    $(".date-wrapper").on("car-booking-form", function (event) {
        renderHtmlCar(event);
    });
});

jQuery(function ($) {
    $("body").on("activity-booking-form", function (event, el) {
        renderHtmlActivity(event, el);
    });
});

function renderHtmlCarstranfer(event, el) {
    var form = el.closest('form.form-booking-car-transfer');
    var data = form.serializeArray();
    jQuery('.map-content-loading').hide();
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
            jQuery('.map-content-loading').show();
            jQuery('.message_box').html('');
            jQuery(form).closest('.item-service').find('.message').removeClass('mt20 alert alert-danger').hide();
        },
        success: function (response) {
            jQuery('.map-content-loading').hide();
            if (response) {
                if (response.price_html) {

                    if (jQuery(form).find('.service-price')) {
                        jQuery(form).find('.service-price .price').html(response.price_html);
                    }
                    jQuery('.message_box').html('');
                    jQuery('div.message-wrapper').html("");
                } else {
                    if (response.message) {
                        jQuery(form).closest('.item-service').find('.message').addClass('mt20 alert alert-danger').show().html(response.message);
                    }
                    if (response.price_from) {
                        if (jQuery('.form-head .price').length > 0) {
                            jQuery('.form-head .price').html(response.price_from);
                        }
                    }
                }
            }
        }
    });
}

function renderHtmlTour() {
    var form = jQuery('form.tour-booking-form');
    var data = jQuery('form.tour-booking-form').serializeArray();
    jQuery('.loader-wrapper').hide();
    data.push({
        name: 'security',
        value: st_params._s
    });
    for (var i = 0; i < data.length; i++) {
        if (data[i].name === 'action') {
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
                    if (response.message) {
                        jQuery('#form-booking-inpage .message-wrapper').html('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> ' + response.message + ' </div>');
                    }
                    if (response.price_from) {
                        if (jQuery('.form-head .price').length > 0) {
                            jQuery('.form-head .price').html(response.price_from);
                        }
                    }
                }
            }
        }
    });
}

function renderHtmlActivity() {
    var form = jQuery('form.activity-booking-form');
    var data = jQuery('form.activity-booking-form').serializeArray();
    jQuery('.loader-wrapper').hide();
    data.push({
        name: 'security',
        value: st_params._s
    });
    for (var i = 0; i < data.length; i++) {

        if (data[i].name === 'action') {
            data[i]['value'] = 'st_format_activity_price';
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
                    if (jQuery('.form-head .price').length > 0) {
                        if (response.price_html) {
                            jQuery('.form-head .price').html(response.price_html);
                        }
                    }
                    if (jQuery('.hotel-target-book-mobile').length > 0) {
                        jQuery('.hotel-target-book-mobile .price-wrapper').html(response.price_html);
                    }
                    jQuery('div.message-wrapper').html("");
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
}

function renderHtmlRental() {
    var form = jQuery('form.rental-booking-form');
    var data = jQuery('form.rental-booking-form').serializeArray();
    jQuery('.loader-wrapper').hide();
    data.push({
        name: 'security',
        value: st_params._s
    });
    for (var i = 0; i < data.length; i++) {

        if (data[i].name === 'action') {
            data[i]['value'] = 'st_format_rental_price';
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
                        if (response.price_html) {
                            jQuery('.form-head').html(response.price_html);
                        }
                    }
                    if (jQuery('.hotel-target-book-mobile').length > 0) {
                        jQuery('.hotel-target-book-mobile .price-wrapper').html(response.price_html);
                    }
                    jQuery('.message_box').html('');
                    jQuery('div.message-wrapper').html("");
                    ci = 0;
                } else {
                    if (response.message) {
                        jQuery('#form-booking-inpage .message-wrapper').html('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> ' + response.message + ' </div>');
                    }
                }
            }
        }
    });
}

function renderHtmlHotel() {
    var form = jQuery('form.hotel-room-booking-form');
    var data = jQuery('form.hotel-room-booking-form').serializeArray();
    jQuery('.loader-wrapper').hide();
    data.push({
        name: 'security',
        value: st_params._s
    });
    for (var i = 0; i < data.length; i++) {

        if (data[i].name === 'action') {
            data[i]['value'] = 'st_format_hotel_price';
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
                        if (response.price_html) {
                            jQuery('.form-head').html(response.price_html);
                        }
                    }
                    if (jQuery('.hotel-target-book-mobile').length > 0) {
                        jQuery('.hotel-target-book-mobile .price-wrapper').html(response.price_html);
                    }
                    jQuery('.message_box').html('');
                    jQuery('div.message-wrapper').html("");
                    ci = 0;
                } else {
                    if (response.message) {
                        jQuery('.message-wrapper').html('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> ' + response.message + ' </div>');
                    }
                }
            }
        }
    });
}

function renderHtmlCar() {
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
}
//caculator Booking
if (st_params.caculator_price_single_ajax && st_params.caculator_price_single_ajax === 'on') {
    //Car
    jQuery(function ($) {
        if (jQuery('.car-booking-form').length > 0) {
            if (jQuery('.form-more-extra .extras').length > 0) {
                jQuery('.form-more-extra .extras li').each(function () {
                    jQuery(this).find('.extra-service-select').on('change', function () {
                        changeServiceSelect();
                    })
                });
            }

            function changeServiceSelect() {
                renderHtmlCar();
            }

            function renderHtmlCar() {
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
            }
        }
    });

    //Tour
    jQuery(function ($) {
        if ($('.tour-booking-form').length > 0) {
            if ($('.guest-wrapper').length > 0) {
                $('.guest-wrapper').each(function () {
                    $(this).find('.form-control.st-input-number').on('change', function () {
                        renderHtmlTour();
                    })
                });
            }
            if ($('#st-package-popup').length > 0) {
                $('#st-package-popup .mfp-close').on('click', function () {
                    renderHtmlTour();
                });
            }
            if ($('.form-more-extra .extras').length > 0) {
                $('.form-more-extra .extras li').each(function () {
                    $(this).find('.extra-service-select').on('change', function () {
                        renderHtmlTour();
                    })
                });
            }
            if ($('.form-more-extra-solo').length > 0) {
                $('.st-package-popup-solo  li').each(function () {
                    $(this).find('.extra-service-select').on('change', function () {
                        renderHtmlTour();
                    })
                });
                $('.form-more-extra-solo li.item').each(function () {
                    $(this).find('.extra-service-select').on('change', function () {
                        renderHtmlTour();
                    })
                });

            }
            if ($('.st-form-starttime').length > 0) {
                $('.st_tour_starttime').each(function () {
                    $(this).on('change', function () {
                        renderHtmlTour();
                    })
                });
            }

        }
    });


    //Activity
    jQuery(function ($) {
        if ($('.activity-booking-form').length > 0) {
            var flag = false;
            if ($('.guest-wrapper').length > 0) {
                $('.guest-wrapper').each(function () {
                    $(this).find('.form-control.st-input-number').on('change', function () {
                        renderHtmlActivity();
                    })
                });
            }
            if ($('#st-package-popup').length > 0) {
                $('#st-package-popup .item').each(function () {
                    $(this).find('ul li .extra-service-select').on('change', function () {
                        renderHtmlActivity();
                    })
                });
            }
            if ($('.form-more-extra .extras').length > 0) {
                $('.form-more-extra .extras li').each(function () {
                    $(this).find('.extra-service-select').on('change', function () {
                        renderHtmlActivity();
                    })
                });
            }
            if ($('.st-form-starttime').length > 0) {
                $('.st_tour_starttime').each(function () {
                    $(this).on('change', function () {
                        renderHtmlActivity();
                    })
                });
            }
            if (flag) {
                renderHtmlActivity();
            }

        }
    });

    //Rental
    jQuery(function ($) {
        if ($('.rental-booking-form').length > 0) {
            var flag = false;
            if ($('.form-extra-field').length > 0) {
                $('.form-extra-field').each(function () {
                    var st_guest = $(this).closest('.field-guest');
                    st_guest.find('.st-input-number').on('change', function () {
                        renderHtmlRental();
                    })
                });
            }
            if ($('.form-more-extra .extras').length > 0) {
                $('.form-more-extra .extras li').each(function () {
                    $(this).find('.extra-service-select').on('change', function () {
                        renderHtmlRental();
                    })
                });
            }
            if (flag) {
                renderHtmlRental();
            }

        }
    });

    //HotelRoom
    jQuery(function ($) {
        if ($('.hotel-room-booking-form').length > 0) {
            var flag = false;
            var ci_hotel = 0;
            $('.check-in-input').on('change', function (e) {
                if (ci_hotel != 0) {
                    renderHtmlHotel();
                }
                ci_hotel++;
            });
            if ($('.form-extra-field').length > 0) {
                $('.form-extra-field').each(function () {
                    $(this).find('.form-control.st-input-number').on('change', function () {
                        renderHtmlHotel();
                    })
                });
            }
            if ($('.form-more-extra .extras').length > 0) {
                $('.form-more-extra .extras li').each(function () {
                    $(this).find('.extra-service-select').on('change', function () {
                        renderHtmlHotel();
                    })
                });
            }
            if (flag) {
                renderHtmlHotel();
            }

        }
    });
    //Car transfer
    jQuery(function ($) {
        $(document).on('change', '.item-service-car .sroom-extra-service table tr .extra-service-select', function (event) {
            $('body').trigger('cartransfer-booking-form', [$(this)]);
        });

        $(document).on('change', '.item-service-car .sroom-return  input[name ="return_car"]', function (event) {
            $('body').trigger('cartransfer-booking-form', [$(this)]);
        });
    });
}

var mapStyles = {
    'silver': [{
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f5f5"
            }]
        },
        {
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#f5f5f5"
            }]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#bdbdbd"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#eeeeee"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e5e5e5"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#ffffff"
            }]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dadada"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e5e5e5"
            }]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [{
                "color": "#eeeeee"
            }]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#c9c9c9"
            }]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        }
    ],
    'retro': [{
            "elementType": "geometry",
            "stylers": [{
                "color": "#ebe3cd"
            }]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#523735"
            }]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#f5f1e6"
            }]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#c9b2a6"
            }]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#dcd2be"
            }]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#ae9e90"
            }]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dfd2ae"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dfd2ae"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#93817c"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#a5b076"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#447530"
            }]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f1e6"
            }]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [{
                "color": "#fdfcf8"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f8c967"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#e9bc62"
            }]
        },
        {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e98d58"
            }]
        },
        {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#db8555"
            }]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#806b63"
            }]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dfd2ae"
            }]
        },
        {
            "featureType": "transit.line",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#8f7d77"
            }]
        },
        {
            "featureType": "transit.line",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#ebe3cd"
            }]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dfd2ae"
            }]
        },
        {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#b9d3c2"
            }]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#92998d"
            }]
        }
    ],
    'dark': [{
            "elementType": "geometry",
            "stylers": [{
                "color": "#212121"
            }]
        },
        {
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#212121"
            }]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [{
                "color": "#757575"
            }]
        },
        {
            "featureType": "administrative.country",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        },
        {
            "featureType": "administrative.land_parcel",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "featureType": "administrative.locality",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#bdbdbd"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{
                "color": "#181818"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#1b1b1b"
            }]
        },
        {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#2c2c2c"
            }]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#8a8a8a"
            }]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [{
                "color": "#373737"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                "color": "#3c3c3c"
            }]
        },
        {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry",
            "stylers": [{
                "color": "#4e4e4e"
            }]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        },
        {
            "featureType": "transit",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#000000"
            }]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#3d3d3d"
            }]
        }
    ],
    'night': [{
            "elementType": "geometry",
            "stylers": [{
                "color": "#242f3e"
            }]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#746855"
            }]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#242f3e"
            }]
        },
        {
            "featureType": "administrative.locality",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#d59563"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#d59563"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{
                "color": "#263c3f"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#6b9a76"
            }]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#38414e"
            }]
        },
        {
            "featureType": "road",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#212a37"
            }]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9ca5b3"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                "color": "#746855"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#1f2835"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#f3d19c"
            }]
        },
        {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [{
                "color": "#2f3948"
            }]
        },
        {
            "featureType": "transit.station",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#d59563"
            }]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#17263c"
            }]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#515c6d"
            }]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#17263c"
            }]
        }
    ],
    'aubergine': [{
            "elementType": "geometry",
            "stylers": [{
                "color": "#1d2c4d"
            }]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#8ec3b9"
            }]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#1a3646"
            }]
        },
        {
            "featureType": "administrative.country",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#4b6878"
            }]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#64779e"
            }]
        },
        {
            "featureType": "administrative.province",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#4b6878"
            }]
        },
        {
            "featureType": "landscape.man_made",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#334e87"
            }]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [{
                "color": "#023e58"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#283d6a"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#6f9ba5"
            }]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#1d2c4d"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#023e58"
            }]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#3C7680"
            }]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#304a7d"
            }]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#98a5be"
            }]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#1d2c4d"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                "color": "#2c6675"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#255763"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#b0d5ce"
            }]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#023e58"
            }]
        },
        {
            "featureType": "transit",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#98a5be"
            }]
        },
        {
            "featureType": "transit",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#1d2c4d"
            }]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#283d6a"
            }]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [{
                "color": "#3a4762"
            }]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#0e1626"
            }]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#4e6d70"
            }]
        }
    ]
};
var getHeightHiddenEl = function (el) {
    var el_style = window.getComputedStyle(el),
        el_display = el_style.display,
        el_position = el_style.position,
        el_visibility = el_style.visibility,
        el_max_height = el_style.maxHeight.replace('px', '').replace('%', ''),
        wanted_height = 0;
    // if its not hidden we just return normal height
    if (el_display !== 'none' && el_max_height !== '0') {
        return el.offsetHeight;
    }
    // the element is hidden so:
    // making the el block so we can meassure its height but still be hidden
    el.style.position = 'absolute';
    el.style.visibility = 'hidden';
    el.style.display = 'block';
    wanted_height = el.offsetHeight;
    // reverting to the original values
    el.style.display = '';
    el.style.position = 'relative';
    el.style.visibility = 'visible';
    return wanted_height;
};
(function ($) {
    'use strict';
    var body = $('body');
    if ($('.has-matchHeight', body).length) {
        $('.has-matchHeight', body).matchHeight();
    }
    if ($('.dropdown-toggle', body).length) {
        $('.dropdown-toggle', body).dropdown();
    }
    $('.open-loss-password', body).on('click', function (ev) {
        ev.preventDefault();
        $('#st-login-form', body).modal('hide');
        $('#st-register-form', body).modal('hide');
        setTimeout(function () {
            $('#st-forgot-form', body).modal('show');
        }, 500);
    });
    $('.open-login', body).on('click', function (ev) {
        ev.preventDefault();
        $('#st-register-form', body).modal('hide');
        $('#st-forgot-form', body).modal('hide');
        setTimeout(function () {
            $('#st-login-form', body).modal('show');
        }, 500);
    });
    $('.open-signup', body).on('click', function (ev) {
        ev.preventDefault();
        $('#st-forgot-form', body).modal('hide');
        $('#st-login-form', body).modal('hide');
        setTimeout(function () {
            $('#st-register-form', body).modal('show');
        }, 500);
    });
    $('[data-toggle="tooltip"]').tooltip();

    $('.toggle-menu', '.header').on('click', function (ev) {
        ev.preventDefault();
        toggleBody($('#st-main-menu'));
        $('#st-main-menu').toggleClass('open');
    });
    $('.back-menu', '.header').on('click', function (ev) {
        ev.preventDefault();
        var backmenu = $(this).closest('#st-main-menu');
        var time = setTimeout(() => {
            $('#st-main-menu').toggleClass('open', toggleBody(backmenu));
        }, 100)


    });

    function toggleBody(el) {
        if (el.hasClass('open')) {
            body.css({
                'overflow': 'auto'
            });
        } else {
            body.css({
                'overflow': 'hidden'
            });
        }
    }
    $('#st-main-menu .main-menu .menu-item-has-children .fa').on('click', function () {
        if (window.matchMedia("(max-width: 991px)").matches) {
            $(this).toggleClass('fa-angle-down fa-angle-up');
            var parent = $(this).parent();
            $('>.menu-dropdown', parent).toggle();
            if ($(this).closest('.menu-item-has-children').hasClass('has-mega-menu')) {
                $('>.mega-menu', $(this).parent().parent()).toggle();
            }
        }
    });
    body.on('click', function (ev) {
        if ($(ev.target).is('#st-main-menu')) {
            toggleBody($(ev.target));
            $('#st-main-menu').toggleClass('open');
        }
    });
    $(window).on('resize', function () {
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
    }).trigger('resize');
    if ($('.dropdown-toggle', body).length) {
        $('.dropdown-toggle', body).dropdown();
    }
    body.on('click', '.toggle-section', function (ev) {
        ev.preventDefault();
        var t = $(this);
        var target = t.data('target');
        $('.fa', t).toggleClass('fa-angle-up fa-angle-down');
        $('[data-toggle-section="' + target + '"]').slideToggle(200);
    });
    var timeout_fixed_item;
    $(window).on('resize', function () {
        clearTimeout(timeout_fixed_item);
        timeout_fixed_item = setTimeout(function () {
            $('.fixed-on-mobile', body).each(function () {
                var t = $(this);
                var screen = t.data('screen');
                var width = t.width(),
                    top = t.offset().top;
                $(window).on('scroll', function () {
                    if ($(window).scrollTop() >= top && window.matchMedia('(min-width: ' + screen + ')').matches) {
                        if (t.css('position') != 'fixed') {
                            let top = 0;
                            if ($('#wpadminbar') && $('#wpadminbar')[0]) {
                                top += $('#wpadminbar').height();
                            }
                            t.css({
                                width: width,
                                position: 'fixed',
                                top: top,
                                'z-index': 9
                            });
                        }
                        if ($('.stoped-scroll-section', body).length) {
                            var room_position = $('.stoped-scroll-section', body).offset().top;
                            if ($(window).scrollTop() + t.innerHeight() >= room_position && t.css('position') == 'fixed') {
                                t.css({
                                    width: width,
                                    position: 'fixed',
                                    top: room_position - $(window).scrollTop() - t.innerHeight(),
                                    'z-index': 9
                                });
                            } else {
                                let top = 0;
                                if ($('#wpadminbar') && $('#wpadminbar')[0]) {
                                    top += $('#wpadminbar').height();
                                }
                                t.css({
                                    width: width,
                                    position: 'fixed',
                                    top: top,
                                    'z-index': 9
                                });
                            }
                        }
                    } else {
                        t.css({
                            position: '',
                            top: '',
                            width: 'auto',
                            'z-index': ''
                        })
                    }
                });
            });
            $('.hotel-target-book-mobile', body).each(function () {
                var t = $(this);
                $(window).on('scroll', function () {
                    if ($(window).scrollTop() >= 50 && window.matchMedia('(max-width: 991px)').matches) {
                        t.css('display', 'flex');
                    } else {
                        t.css('display', 'none');
                    }
                });
            });
        }, 1000);
    }).trigger('resize');
    $('[data-show-all]', body).each(function () {
        var t = $(this);
        var height = t.data('height');
        t.css('height', height);
    });
    body.on('click', '[data-show-target]', function (ev) {
        ev.preventDefault();
        var target = $(this).data('show-target');
        $('.fa', this).toggleClass('fa-caret-up fa-caret-down');
        if ($('.fa', this).hasClass('fa-caret-up')) {
            $('.text', this).html($(this).data('text-less'));
        } else {
            $('.text', this).html($(this).data('text-more'));
        }
        if ($('[data-show-all="' + target + '"]', body).hasClass('open')) {
            $('[data-show-all="' + target + '"]', body).css({
                height: $('[data-show-all="' + target + '"]', body).data('height')
            });
        } else {
            $('[data-show-all="' + target + '"]', body).css({
                height: ''
            });
        }
        $('[data-show-all="' + target + '"]', body).toggleClass('open');
    });
    $('.hotel-target-book-mobile .btn-mpopup', body).on('click', function (ev) {
        ev.preventDefault();
        $('.fixed-on-mobile', body).toggleClass('open').fadeToggle(300);
        $(body).addClass('st_overflow');
    });
    $('.fixed-on-mobile .close-icon', body).on('click', function (ev) {
        ev.preventDefault();
        $('.fixed-on-mobile', body).toggleClass('open').fadeToggle(300);
        $(body).removeClass('st_overflow');
    });
    $('.review-list', body).on('click', '.show-more', function (ev) {
        ev.preventDefault();
        var parent = $(this).closest('.comment');
        $(this).css('display', 'none');
        $('.review', parent).slideDown(200);
        $('.show-less', parent).css('display', 'block');
    });
    $('.review-list', body).on('click', '.show-less', function (ev) {
        ev.preventDefault();
        var parent = $(this).closest('.comment');
        $(this).css('display', 'none');
        $('.review', parent).slideUp(200);
        $('.show-more', parent).css('display', 'block');
    });
    // Availability
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
        calendar.daterangepicker(options, function (start, end, label) {});
        var dp = calendar.data('daterangepicker');
        dp.show();
    });
    /* Price range */
    function format_money($money) {
        // if (!$money) {
        //     return st_params.free_text;
        // }

        $money = st_number_format($money, st_params.booking_currency_precision, st_params.decimal_separator, st_params.thousand_separator);
        var $symbol = st_params.currency_symbol;
        var $money_string = '';

        switch (st_params.currency_position) {
            case "right":
                $money_string = $money + $symbol;
                break;
            case "left_space":
                $money_string = $symbol + " " + $money;
                break;

            case "right_space":
                $money_string = $money + " " + $symbol;
                break;
            case "left":
            default:
                $money_string = $symbol + $money;
                break;
        }

        return $money_string;
    }

    function st_number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }
        return s.join(dec);
    }
    $(".price_range").each(function () {
        var t = $(this);
        var min = $(this).data('min');
        var max = $(this).data('max');
        var step = $(this).data('step');
        var value = $(this).val();
        var from = value.split(';');
        var prefix_symbol = $(this).data('symbol');
        var to = from[1];
        from = from[0];
        $(this).ionRangeSlider({
            min: min,
            max: max,
            type: 'double',
            prefix: prefix_symbol,
            prettify: false,
            step: step,
            onFinish: function (data) {
                t.trigger('st_ranger_price_change');
                set_price_range_val(data, $('input[name="price_range"]'));
                format_price_price_ranger(data);
            },
            from: from,
            to: to,
            force_edges: true,
        });
    });
    var rangeContainer = $('.sidebar-item.range-slider');

    function format_price_price_ranger(data) {


        var min = rangeContainer.find('.price_range').data('min');
        var max = rangeContainer.find('.price_range').data('max');
        var convert_price_min = format_money(data.from);
        var convert_price_max = format_money(data.to);
        rangeContainer.find('.irs-from').text(convert_price_min);
        rangeContainer.find('.irs-to').text(convert_price_max);

    }

    function set_price_range_val(data, element) {
        var exchange = 1;
        var from = Math.round(parseInt(data.from) / exchange);
        var to = Math.round(parseInt(data.to) / exchange);
        var text = from + ";" + to;
        element.val(text);
    }
    /*Sidebar toggle*/
    if ($('.sidebar-item').length) {
        $('.sidebar-item').each(function () {
            var t = $(this);
            if (t.hasClass('open')) {
                t.find('.item-content').slideUp();
            }
        });
    }
    $('.sidebar-item .item-title').on('click', function () {
        var t = $(this);
        t.parent().toggleClass('open');
        t.parent().find('.item-content').slideToggle();
    });
    /* Clear radio button */
    $('.btn-clear-review-score').on('click', function () {
        var t = $(this);
        var parent = t.closest('ul');
        parent.find('input').prop('checked', false);
    });
    /* Load more checkbox item */
    if ($('.btn-more-item').length) {
        $('.btn-more-item').each(function () {
            var t = $(this);
            var parent = t.closest('.item-content');
            if (parent.find('ul li').length > 3) {
                t.show();
            }
            t.on('click', function () {
                var countLi = parent.find('ul li.hidden').length;
                var max = 3;
                if (countLi < 3) {
                    max = countLi;
                }
                for (var i = 0; i < max; i++) {
                    parent.find('ul li.hidden').eq(0).removeClass('hidden');
                }
                var countLi = parent.find('ul li.hidden').length;
                if (countLi <= 0) {
                    t.hide();
                }
            });
        });
    }
    $('.form-date-search', body).each(function () {
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('.check-in-input', parent),
            check_out_input = $('.check-out-input', parent),
            check_in_out = $('.check-in-out', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent);
        var timepicker = parent.data('timepicker');
        if (typeof timepicker == 'undefined' || timepicker == '') {
            timepicker = false;
        } else {
            timepicker = true;
        }
        var options = {
            singleDatePicker: false,
            sameDate: false,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            customClass: '',
            widthSingle: 500,
            onlyShowCurrentMonth: true,
            timePicker: timepicker,
            timePicker24Hour: (st_params.time_format == '12h') ? false : true,
        };
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                check_in_input.val(start.format(parent.data('format'))).trigger('change');
                $('#tp_hotel .form-date-search .check-in-input').val(start.format('YYYY-MM-DD')).trigger('change');
                check_in_render.html(start.format(parent.data('format'))).trigger('change');
                check_out_input.val(end.format(parent.data('format'))).trigger('change');
                $('#tp_hotel .form-date-search .check-out-input').val(end.format('YYYY-MM-DD')).trigger('change');
                check_out_render.html(end.format(parent.data('format'))).trigger('change');
                if (timepicker) {
                    check_in_input.val(start.format(parent.data('date-format'))).trigger('change');
                    $('.check-in-input-time', parent).val(start.format(parent.data('time-format'))).trigger('change');
                    check_out_input.val(end.format(parent.data('date-format'))).trigger('change');
                    $('.check-out-input-time', parent).val(end.format(parent.data('time-format'))).trigger('change');
                    $('.check-out-input-time', parent).val(end.format(parent.data('time-format'))).trigger('change');
                }
                check_in_out.trigger('daterangepicker_change', [start, end]);
                $(body).removeClass('st_overflow');
                if (window.matchMedia('(max-width: 767px)').matches) {
                    $('label', parent).hide();
                    $('.render', parent).show();
                    $('.check-in-wrapper span', parent).show();
                }
                console.log("date");
            });
        date_wrapper.on('click', function (e) {
            check_in_out.trigger('click');
        });
    });
    $('.form-date-search.form-date-car', body).each(function () {
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('.check-in-input', parent),
            check_out_input = $('.check-out-input', parent),
            check_in_out = $('.check-in-out', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent);
        var timepicker = parent.data('timepicker');
        if (typeof timepicker == 'undefined' || timepicker == '') {
            timepicker = false;
        } else {
            timepicker = true;
        }
        var options = {
            singleDatePicker: false,
            sameDate: true,
            sameDateMulti: true,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            timeFormat: (st_params.time_format == '12h') ? 'hh:mm A' : 'HH:mm',
            customClass: '',
            widthSingle: 500,
            onlyShowCurrentMonth: true,
            timePicker: timepicker,
            timePicker24Hour: (st_params.time_format == '12h') ? false : true,
        };
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {

                $('#tp_hotel .form-date-search .check-in-input').val(start.format('YYYY-MM-DD')).trigger('change');
                $('#tp_hotel .form-date-search .check-out-input').val(end.format('YYYY-MM-DD')).trigger('change');
                check_in_input.val(start.format(parent.data('format'))).trigger('change');
                check_in_render.html(start.format(parent.data('format'))).trigger('change');
                check_out_input.val(end.format(parent.data('format'))).trigger('change');
                check_out_render.html(end.format(parent.data('format'))).trigger('change');
                if (timepicker) {
                    check_in_input.val(start.format(parent.data('date-format'))).trigger('change');
                    $('.check-in-input-time', parent).val(start.format(parent.data('time-format'))).trigger('change');
                    check_out_input.val(end.format(parent.data('date-format'))).trigger('change');
                    $('.check-out-input-time', parent).val(end.format(parent.data('time-format'))).trigger('change');
                }
                check_in_out.trigger('daterangepicker_change', [start, end]);
                $(body).removeClass('st_overflow');
                if (window.matchMedia('(max-width: 767px)').matches) {
                    $('label', parent).hide();
                    $('.render', parent).show();
                    $('.check-in-wrapper span', parent).show();
                }

                if (st_params.caculator_price_single_ajax === 'on') {
                    if ($('.single-st_cars .car-booking-form').length > 0) {
                        date_wrapper.trigger('car-booking-form');
                    }
                }
            });
        date_wrapper.on('click', function (e) {
            check_in_out.trigger('click');
        });
    });
    //form date in tour
    $('.form-date-search-new', body).each(function () {
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('.check-in-input', parent),
            check_out_input = $('.check-out-input', parent),
            check_in_out = $('.check-in-out', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent);
        var timepicker = parent.data('timepicker');
        if (typeof timepicker == 'undefined' || timepicker == '') {
            timepicker = false;
        } else {
            timepicker = true;
        }
        var customClass = parent.data('custom-class') || '';
        var options = {
            singleDatePicker: false,
            autoApply: true,
            disabledPast: true,
            dateFormat: 'DD/MM/YYYY',
            customClass: customClass,
            widthSingle: 500,
            onlyShowCurrentMonth: true,
            timePicker: timepicker,
            timePicker24Hour: (st_params.time_format == '12h') ? false : true,
        };
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                check_in_input.val(start.format(parent.data('format'))).trigger('change');
                $('#tp_hotel .form-date-search .check-in-input').val(start.format('YYYY-MM-DD')).trigger('change');
                var html = start.format(parent.data('format')) + ' - ';
                check_in_render.html(html).trigger('change');
                check_out_input.val(end.format(parent.data('format'))).trigger('change');
                $('#tp_hotel .form-date-search .check-out-input').val(end.format('YYYY-MM-DD')).trigger('change');
                check_out_render.html(end.format(parent.data('format'))).trigger('change');

                if (timepicker) {
                    check_in_input.val(start.format(parent.data('date-format'))).trigger('change');
                    $('.check-in-input-time', parent).val(start.format(parent.data('time-format'))).trigger('change');
                    check_out_input.val(end.format(parent.data('date-format'))).trigger('change');
                    $('.check-out-input-time', parent).val(end.format(parent.data('time-format'))).trigger('change');
                    $('.check-out-input-time', parent).val(end.format(parent.data('time-format'))).trigger('change');


                }
                check_in_out.trigger('daterangepicker_change', [start, end]);
                $(body).removeClass('st_overflow');
                if (window.matchMedia('(max-width: 767px)').matches) {
                    $('label', parent).hide();
                    $('.render', parent).show();
                    $('.check-in-wrapper span', parent).show();
                }
            });
        date_wrapper.on('click', function (e) {
            check_in_out.trigger('click');
        });
    });
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
                if (st_params.caculator_price_single_ajax === 'on') {
                    if ($('.single-st_rental .single-room-form').length > 0) {
                        date_wrapper.trigger('rental-booking-form');
                    }
                }
            });


        date_wrapper.on('click', function (e) {
            check_in_out.trigger('click');

        });


        check_in_out.on('apply.daterangepicker', function (ev, picker) {
            if (st_params.caculator_price_single_ajax === 'on') {
                if ($('.single-hotel_room .single-room-form').length > 0) {
                    $('.hotel-room-booking-form').trigger('hotel-room-booking-form');
                }
            }

        });
    });

    $('.form-extra-field').each(function () {
        var parent = $(this);
        $('.dropdown', parent).on('click', function (e) {
            var tab_exclude = [
                'tp_hotel',
                'bookingdc'
            ]
            if (tab_exclude.includes($(this).parents('.tab-pane').attr('id'))) {
                return;
            }
            var dropdown_menu = $('[aria-labelledby="' + $(this).attr('id') + '"]', parent);
            $('.form-extra-field').find('.dropdown-menu').not(dropdown_menu).slideUp(50);
            dropdown_menu.slideToggle(50);
            $(this).parent('.dropdown').find('.arrow').toggleClass('fa-angle-down fa-angle-up');
            if ($('.ovscroll').length) {
                $.fn.getNiceScroll && $('.ovscroll').getNiceScroll().resize();
            }
        });
        $('.arrow', parent).on('click', function (e) {
            var drop_down = $(this).closest('.dropdown');
            var dropdown_menu = $('[aria-labelledby="' + drop_down.find('.dropdown').attr('id') + '"]', parent);
            $('.form-extra-field').find('.dropdown-menu').not(dropdown_menu).slideUp(50);
            dropdown_menu.slideToggle(50);
            $(this).toggleClass('fa-angle-down fa-angle-up');
            if ($('.ovscroll').length) {
                $.fn.getNiceScroll && $('.ovscroll').getNiceScroll().resize();
            }
        });
        $('input[name="adult_number"]', parent).on('change', function () {
            var adults = parseInt($(this).val());
            var html = adults;
            if (typeof adults == 'number') {
                if (adults < 2) {
                    html = adults + ' ' + $('.render .adult', parent).data('text');
                } else {
                    html = adults + ' ' + $('.render .adult', parent).data('text-multi');
                }
            }
            $('.render .adult', parent).html(html);
        });
        $('input[name="adult_number"]', parent).trigger('change');
        $('input[name="child_number"]', parent).on('change', function () {
            var children = parseInt($(this).val());
            var html = children;
            if (typeof children == 'number') {
                if (children < 2) {
                    html = children + ' ' + $('.render .children', parent).data('text');
                } else {
                    html = children + ' ' + $('.render .children', parent).data('text-multi');
                }
            }
            $('.render .children', parent).html(html);
        });
        $('input[name="child_number"]', parent).trigger('change');
    });
    //form guest in tour
    $('.form-extra-field.field-guest-new').each(function () {
        var parent = $(this);

        $('input[name="adult_number"]', parent).on('change', function () {
            var adults = parseInt($(this).val());
            var html = adults;
            if (typeof adults == 'number') {
                if (adults < 2) {
                    html = adults + ' ' + $('.render .adult', parent).data('text');
                } else {
                    html = adults + ' ' + $('.render .adult', parent).data('text-multi');
                }
            }
            $('.render .adult', parent).html(html);
            $('.render', parent).removeClass('hide');
            parent.find('label').first().hide();
        });
        //$('input[name="adult_number"]', parent).trigger('change');
        $('input[name="child_number"]', parent).on('change', function () {
            var children = parseInt($(this).val());
            var html = children;
            if (typeof children == 'number') {
                if (children < 2) {
                    html = children + ' ' + $('.render .children', parent).data('text');
                } else {
                    html = children + ' ' + $('.render .children', parent).data('text-multi');
                }
            }
            $('.render .children', parent).html(html);
            $('.render', parent).removeClass('hide');
            parent.find('label').first().hide();
        });
        // $('input[name="child_number"]', parent).trigger('change');
    });
    body.on('click', function (ev) {
        if ($(ev.target).closest('.form-extra-field').length == 0) {
            $('.form-extra-field .dropdown-menu').slideUp(50);
            $('.form-extra-field .arrow').removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });
    $('.form-more-extra', body).each(function () {
        var t = $(this),
            parent = t.closest('.form-more-extra');
        $('.dropdown', parent).on('click', function (ev) {
            ev.preventDefault();
            $('.extras', parent).slideToggle(200);
            $('.arrow', parent).toggleClass('fa-caret-up fa-caret-down');
        });
    });
    $('a[data-toggle="tab"][href="#map-tab"]').on('click', function (e) {
        e.preventDefault();
        loadMap('.st-map');
    });

    function loadMap(el) {
        $(el, body).each(function () {
            var parent = $(this),
                mapEl = $('.google-map', parent);
            var style = mapEl.data('style');
            var data = {
                center: {
                    lat: parseFloat(mapEl.data().lat),
                    lng: parseFloat(mapEl.data().lng)
                },
                zoom: mapEl.data().zoom,
                disableDefaultUI: mapEl.data().disablecontrol,
                styles: mapStyles[style] ? mapStyles[style] : ''
            };
            var showcustomcontrol = mapEl.data('showcustomcontrol');

            if (typeof (new google.maps.Map(mapEl.get(0), data)) === "undefined") {
                var map = new google.maps.Map(mapEl.get(0), data);
                new google.maps.Marker({
                    position: new google.maps.LatLng(mapEl.data().lat, mapEl.data().lng),
                    icon: mapEl.data().icon,
                    map: map,
                });
                if (showcustomcontrol) {
                    customControlGoogleMap(mapEl, map);
                }
            }
        });
    }

    function initPanoDetal(lat_center, lng_center) {
        const panorama = new google.maps.StreetViewPanorama(
            document.getElementById("list_map"), {
                position: {
                    lat: lat_center,
                    lng: lng_center
                },
                addressControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_CENTER,
                },
                linksControl: false,
                panControl: false,
                enableCloseButton: false,
            }
        );
    }
    $('.st-map', body).each(function () {
        var parent = $(this),
            mapEl = $('.google-map', parent),
            mapData = mapEl.data('data_show'),
            lat_center = mapEl.data('lat'),
            lng_center = mapEl.data('lng'),
            data_zoom = mapEl.data('zoom'),
            mapIcon = mapEl.data('icon'),
            street_views = mapEl.data('street_views');
        if (street_views == 'on') {
            window.initPano = initPanoDetal(lat_center, lng_center);
        } else {
            initMapDetail(mapEl, mapData, lat_center, lng_center, data_zoom, mapIcon);
        }

    });


    /*Destination selection*/
    $('.field-detination').each(function () {
        var parent = $(this);
        var dropdown_menu = $('.dropdown-menu', parent);
        $('li', dropdown_menu).on('click', function () {
            var target = $(this).closest('ul.dropdown-menu').attr('aria-labelledby');
            var focus = parent.find('#' + target);
            $('.destination', focus).text($(this).find('span').text());
            $('input[name="location_name"]', focus).val($(this).find('span').text());
            $('input.location_name', focus).val($(this).find('span').text());
            $('input[name="location_id"]', focus).val($(this).data('value'));
            $('input.location_id', focus).val($(this).data('value'));
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('label', focus).hide();
                $('.render', focus).show();
            }
            dropdown_menu.slideUp(50);
        });
    });
    /*Tour type selection*/
    $('.field-tour-type').each(function () {
        var parent = $(this);
        var dropdown_menu = $('.dropdown-menu', parent);
        $('li', dropdown_menu).on('click', function () {
            var target = $(this).closest('ul.dropdown-menu').attr('aria-labelledby');
            var focus = parent.find('#' + target);
            $('.tour-type', focus).text($(this).find('span').text());
            $('input[name="taxonomy[st_tour_type]"]', focus).val($(this).data('value'));

            if (window.matchMedia('(max-width: 767px)').matches) {
                $('label', focus).hide();
                $('.render', focus).show();
            }
            dropdown_menu.slideUp(50);
        });
    });
    /*Tour Duration selection*/
    $('.field-durations').each(function () {
        var parent = $(this);
        var dropdown_menu = $('.dropdown-menu', parent);
        $('li', dropdown_menu).on('click', function () {
            var target = $(this).closest('ul.dropdown-menu').attr('aria-labelledby');
            var focus = parent.find('#' + target);
            $('.durations', focus).text($(this).find('span').text());

            $('input[name="taxonomy[durations]"]', focus).val($(this).data('value'));
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('label', focus).hide();
                $('.render', focus).show();
            }
            dropdown_menu.slideUp(50);
        });
    });
    $('.st-search-form-tour .st-price-field').each(function () {
        var parent = $(this);
        var dropdown_menu = $('.dropdown-menu', parent);
        $('.dropdown', parent).on('click', function () {
            var priceInput = parent.find('input[name="price_range"]').val();
            var arrayPrice = priceInput.split(";");
            var minPrice = arrayPrice[0];
            var maxPrice = arrayPrice[1];
            $('.render .price-min', parent).html(minPrice);
            $('.render .price-max', parent).html(maxPrice);
            $('.render', parent).removeClass('hide');
            $('.label', parent).hide();
        })
    });

    $('.st-search-form-tour .st-price-field input[name="price_range"]').on('st_ranger_price_change', function () {
        let t = $(this),
            parent = t.closest('.st-search-form-tour .st-price-field'),
            priceInput = t.val(),
            arrayPrice = priceInput.split(";"),
            minPrice = arrayPrice[0],
            maxPrice = arrayPrice[1];
        $('.render .price-min', parent).html(minPrice);
        $('.render .price-max', parent).html(maxPrice);
    });
    /* nicescroll */
    $('.ovscroll').each(function () {
        $.fn.niceScroll && $(this).niceScroll();
    });
    $('.map-view-popup .col-left-map').each(function () {
        $.fn.niceScroll && $(this).niceScroll();
    });
    /*Filter mobile click*/
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
        $(this).closest('.sort-menu-mobile').fadeOut();
    });
    $('.page-half-map .close-half-map').on('click', function () {
        $(this).closest('.col-right').hide();
        $('html, body').css({
            overflow: 'auto'
        });
        if ($('#btn-show-map-mobile').length) {
            $('#btn-show-map-mobile').prop('checked', false);
        }
    });
    $('.full-map .close-map').on('click', function () {
        $(this).closest('.full-map').hide();
        $('html, body').css({
            overflow: 'auto'
        });
    });
    $(window).on('resize', function () {
        if (window.matchMedia('(min-width: 768px)').matches) {
            if ($('.full-map-item').length) {
                if (!$('.full-map-item').is(':visible')) {
                    $('.full-map-item').attr('style', '');
                }
            }
            if ($('.st-hotel-result .sidebar-filter').length) {
                if (!$('.st-hotel-result .sidebar-filter').is(':visible')) {
                    $('.st-hotel-result .sidebar-filter').attr('style', '');
                }
            }
            if ($('.st-hotel-result .top-filter').length) {
                if (!$('.st-hotel-result .top-filter').is(':visible')) {
                    $('.st-hotel-result .top-filter').attr('style', '');
                }
            }
        }
        if (window.matchMedia('(min-width: 992px)').matches) {
            if ($('.page-half-map .col-right').length) {
                if (!$('.page-half-map .col-right').is(':visible') && $('#btn-show-map').is(':checked')) {
                    $('.page-half-map .col-right').attr('style', '');
                }
            }
        }
        if (window.matchMedia('(max-width: 991px)').matches) {
            if ($('.page-half-map .col-right').length) {
                if ($('.page-half-map .col-right').is(':visible')) {
                    $('.page-half-map .col-right').attr('style', '');
                }
            }
            if ($('.page-half-map .col-left').length) {
                if ($('.page-half-map .col-left').is(':visible')) {
                    $.fn.getNiceScroll && $('.page-half-map .col-left').getNiceScroll().remove();
                }
            }
        }
    });
    /* On/Off map */
    //Check scroll page
    /*jQuery(function($) {
     if (window.matchMedia('(min-width: 991px)').matches) {
     var c  = 0;
     var c1 = 0;
     $(window).on('scroll',function (event) {
     if ($('#btn-show-map').is(':checked') && $('.page-half-map').length) {
     var scroll = $(window).scrollTop();
     var topEl  = $('.page-half-map').offset().top;
     var colLeft = $('.page-half-map .col-left').height();
     var divResult = $('#modern-search-result').height();
     if (scroll >= topEl - 1 && scroll != 0) {
     if (c == 0) {
     if(divResult >= colLeft) {
     /!*window.scrollTo({
     top: topEl,
     behavior: 'auto'
     });*!/
     $('.page-half-map').addClass('static').find('.col-left').niceScroll();
     }
     }
     } else {
     $('.page-half-map').removeClass('static');
     if (c != 2) {
     c = 0;
     $('.page-half-map').find('.col-left').getNiceScroll().remove();
     } else {
     if (c1 == 0) {
     if (scroll < topEl - 100) {
     c = 0;
     $('.page-half-map').find('.col-left').animate({scrollTop: 0});
     c1 = 1;
     }
     }
     }
     }
     }
     });
     $('.page-half-map .col-left').on('scroll',function (event) {
     if ($('#btn-show-map').is(':checked')) {
     var t = $(this);
     if (t.scrollTop() <= 1) {
     c = 0;
     if (c == 0) {
     $('.page-half-map').removeClass('static').find('.col-left').getNiceScroll().remove();
     }
     } else if (typeof t.getNiceScroll()[0] != 'undefined') {
     if (t.getNiceScroll()[0].page.maxh <= t.scrollTop()) {
     $('.page-half-map').removeClass('static').find('.col-left').getNiceScroll().remove();
     c  = 2;
     c1 = 0;
     }
     }
     }
     });
     }
     });*/
    if ($('.payment-form .payment-item').length) {
        $('.payment-form .payment-item').eq(0).find('.st-icheck-item input[type="radio"]').prop('checked', true);
        $('.payment-form .payment-item').eq(0).find('.dropdown-menu').slideDown();
    }
    $('.payment-form .payment-item').each(function (l, i) {
        var parent = $(this);
        $('.st-icheck-item input[type="radio"]', parent).on('change', function () {
            $('.payment-form .payment-item .dropdown-menu').slideUp();
            if ($(this).is(':checked')) {
                if ($('.dropdown-menu', parent).length) {
                    $('.dropdown-menu', parent).slideDown();
                }
            }
        });
    });
    $('.info-section .detail button').on('click', function () {
        var parent = $(this).closest('.detail');
        $('.detail-list', parent).slideToggle();
    });
    /*$('#st-login-form form').on('submit',function (ev) {
     ev.preventDefault();
     var form    = $(this),
     loader  = form.closest('.modal-content').find('.loader-wrapper'),
     message = $('.message-wrapper', form);
     var data    = form.serializeArray();
     data.push({
     name : 'security',
     value: st_params._s
     });
     message.html('');
     loader.show();
     $.post(st_params.ajax_url, data, function (respon) {
     if (typeof respon == 'object') {
     message.html(respon.message);
     if (respon.status == 1) {
     setTimeout(function () {
     window.location.href = respon.redirect;
     }, 2000);
     }
     }
     loader.hide();
     }, 'json');
     });*/
    /* Taxonomy advance search */
    var advFacilities = [];
    $('.advance-item.facilities input[type="checkbox"]').each(function () {
        var t = $(this);
        if (t.is(':checked')) {
            advFacilities.push(t.val());
        }
    });
    $('.advance-item.facilities input[type="checkbox"]').on('change', function () {
        var t = $(this);
        if (t.is(':checked')) {
            advFacilities.push(t.val());
        } else {
            var index = advFacilities.indexOf(t.val());
            if (index > -1) {
                advFacilities.splice(index, 1);
            }
        }
        t.closest('.facilities').find('.data_taxonomy').val(advFacilities.join(','));
    });
    $('#st-login-form form', body).on('submit', function (ev) {
        ev.preventDefault();
        var form = $(this),
            loader = form.closest('.modal-content').find('.loader-wrapper'),
            message = $('.message-wrapper', form);
        var data = form.serializeArray();
        data.push({
            name: 'security',
            value: st_params._s
        });
        message.html('');
        loader.show();
        $.post(st_params.ajax_url, data, function (respon) {
            if (typeof respon == 'object') {
                message.html(respon.message);
                setTimeout(function () {
                    message.html('');
                }, 1000);
                if (respon.status == 1) {
                    setTimeout(function () {
                        window.location.href = respon.redirect;
                    }, 200);
                }
            }
            loader.hide();
        }, 'json');
    });
    $('#st-register-form form', body).on('submit', function (ev) {
        ev.preventDefault();
        var form = $(this),
            loader = form.closest('.modal-content').find('.loader-wrapper'),
            message = $('.message-wrapper', form);
        var data = form.serializeArray();
        data.push({
            name: 'security',
            value: st_params._s
        });
        message.html('');
        loader.show();
        $.post(st_params.ajax_url, data, function (respon) {
            loader.hide();
            if (typeof respon == 'object') {
                message.html(respon.message);
                if (respon.status == 1) {
                    swal({
                        type: 'success',
                        title: respon.message,
                        text: respon.sub_message,
                        showConfirmButton: true,
                        confirmButtonText: respon.closeText,
                        onClose: function () {
                            $('#st-login-form', body).modal('show');
                            $('#st-register-form', body).modal('hide');
                        },
                        allowOutsideClick: false
                    });
                } else {
                    message.html(respon.message);
                    setTimeout(function () {
                        message.html('');
                    }, 1000);
                }
            }
        }, 'json');
    });
    $('#st-forgot-form form', body).on('submit', function (ev) {
        ev.preventDefault();
        var form = $(this),
            loader = form.closest('.modal-content').find('.loader-wrapper'),
            message = $('.message-wrapper', form);
        var data = form.serializeArray();
        data.push({
            name: 'security',
            value: st_params._s
        });
        message.html('');
        loader.show();
        $.post(st_params.ajax_url, data, function (respon) {
            if (typeof respon == 'object') {
                message.html(respon.message);
                setTimeout(function () {
                    message.html('');
                }, 2000);
            }
            loader.hide();
        }, 'json');
    });
    $('.select2-languages', body).select2({
        minimumResultsForSearch: -1
    });
    $('.select2-languages').on('change', function () {
        var target = $('option:selected', this).data('target');
        if (target) {
            window.location.href = target;
        }
    });
    $('.select2-currencies', body).select2({
        minimumResultsForSearch: -1
    });
    $('.select2-currencies').on('change', function () {
        var target = $('option:selected', this).data('target');
        if (target) {
            window.location.href = target;
        }
    });
    $('.form-check-availability-hotel', body).on('submit', function (ev) {
        ev.preventDefault();
        var form = $(this),
            parent = form.parent(),
            loader = $('.loader-wrapper', parent),
            message = $('.message-wrapper', form);
        var has_fixed = form.closest('.fixed-on-mobile');
        if (has_fixed.hasClass('open')) {
            has_fixed.removeClass('open').hide();
            body.removeClass('st_overflow');
        }
        var data = form.serializeArray();
        data.push({
            name: 'security',
            value: st_params._s
        });
        message.html('');
        loader.show();
        $('.st-list-rooms .loader-wrapper').show();
        $.post(st_params.ajax_url, data, function (respon) {
            if (typeof respon == 'object') {
                if (respon.message) {
                    message.html(respon.message);
                }
                $('.st-list-rooms .fetch').html(respon.html);
                $('html, body').animate({
                    scrollTop: $('.st-list-rooms', body).offset().top - 150
                }, 500);
                $('[data-toggle="tooltip"]').tooltip();
            }
            $('.st-list-rooms .loader-wrapper').hide();
            loader.hide();
        }, 'json');
    });
    body.on('click', '.btn-show-price', function (ev) {
        ev.preventDefault();
        $('.form-check-availability-hotel', body).trigger('submit');
    });
    $('.shares .social-share').on('click', function (ev) {
        ev.preventDefault();
        $('.shares .share-wrapper').slideToggle(200);
    });
    $(document).on('click', '.btn_add_wishlist', function (event) {
        event.preventDefault();
        var $this = $(this);
        $.ajax({
            url: st_params.ajax_url,
            type: "POST",
            data: {
                action: "st_add_wishlist",
                data_id: $(this).data('id'),
                data_type: $(this).data('type')
            },
            dataType: "json",
        }).done(function (html) {
            $this.html(html.icon).attr("data-original-title", html.title)
        })
    });
    $('.st-like-review').on('click', function (e) {
        e.preventDefault();
        var me = $(this);
        var comment_id = me.data('id');
        $.ajax({
            url: st_params.ajax_url,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'like_review',
                comment_ID: comment_id
            },
            success: function (res) {
                if (res.status) {
                    $('i', me).toggleClass('fa-thumbs-o-up fa-thumbs-o-down');
                    if ($('.booking-item-review-rate').length) {
                        $(me).toggleClass('fa-thumbs-o-up fa-thumbs-o-down');
                    }
                    if (typeof res.data.like_count != undefined) {
                        res.data.like_count = parseInt(res.data.like_count);
                        me.parent().find('span').html(res.data.like_count);
                    }
                }
            }
        });
    });
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
            $(this).on('click', function () {
                for (var i = 0; i < listItems.length; i++) {
                    if (i <= itemIndex) {
                        $(listItems[i]).addClass('selected');
                    } else {
                        $(listItems[i]).removeClass('selected');
                    }
                };
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
            $(this).on('click', function () {
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
    /* Mobile location */
    $('.search-form-mobile .dropdown-menu li').on('click', function () {
        var t = $(this);
        var parent = t.closest('.dropdown');
        $('input[name="location_id"]', parent).val(t.data('value'));
        $('input[name="location_name"]', parent).val(t.find('span').text());
    });
    $(document).on('click', '.service-add-wishlist.login', function (event) {
        event.preventDefault();
        var t = $(this);
        t.addClass('loading');
        $.ajax({
            url: st_params.ajax_url,
            type: "POST",
            data: {
                action: "st_add_wishlist",
                data_id: t.data('id'),
                data_type: t.data('type')
            },
            dataType: "json",
        }).done(function (html) {
            if (html.status == 'true') {
                if (html.added == 'true') {
                    t.addClass('added');
                } else {
                    t.removeClass('added');
                }
                t.attr('title', html.title);
            }
            t.removeClass('loading');
        })
    });
    if ($('#contact-map-new').length) {
        initMapContactPage($('#contact-map-new'));
    }
    $('.field-detination .dropdown-menu').each(function () {
        $.fn.niceScroll && $(this).niceScroll({
            cursorcolor: "#a0a9b2",
        });
    });
    jQuery(function ($) {
        // Tour Package Popup
        if ($('.st-form-package').length) {
            $('.st-form-package').magnificPopup({
                removalDelay: 500,
                closeBtnInside: true,
                callbacks: {
                    beforeOpen: function () {
                        this.st.mainClass = this.st.el.attr('data-effect');
                    },
                    afterClose: function () {
                        if (st_params.caculator_price_single_ajax === 'on') {
                            if ($('.single-st_tours .st-form-package').length > 0) {
                                renderHtmlTour();
                            }
                            if ($('.single-st_activity .st-form-package').length > 0) {
                                renderHtmlActivity();
                            }
                        }
                    },
                },
                midClick: true,
                closeMarkup: '<button title="Close (Esc)" type="button" class="mfp-close"></button>',
            });
        }
        if (window.matchMedia('(max-width: 768px)').matches) {
            $('.as').slideDown();
        }
        if (window.matchMedia('(min-width: 991px)').matches) {
            var c = 0;
            var c1 = 0;
            $(window).on('scroll', function (event) {
                if ($('#btn-show-map').is(':checked') && $('.page-half-map').length) {
                    var scroll = $(window).scrollTop();
                    var topEl = $('.st-hotel-result').offset().top;
                    var colLeft = $('.page-half-map .col-left').height();
                    var divResult = $('#modern-search-result').height();
                    if (scroll >= topEl) {
                        if (divResult >= colLeft) {
                            if (c == 0) {
                                if ($("body").hasClass('rtl')) {
                                    if ($.fn.niceScroll) {
                                        $('.page-half-map').find('.col-left').niceScroll({
                                            railalign: 'left'
                                        });
                                    }

                                } else {
                                    if ($.fn.niceScroll) {
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
                            $.fn.getNiceScroll && $('.page-half-map').find('.col-left').animate({
                                scrollTop: 0
                            }).getNiceScroll().remove();
                            c = 0;
                        }
                    }
                }
            });
            $('.page-half-map .col-left').on('scroll', function (event) {
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
    });
    $('.coupon-section form .btn').on('click', function (e) {
        e.preventDefault();
        var sform = $(this).closest('form');
        if ($('#field-coupon_code', sform).val() === '') {
            $('#field-coupon_code', sform).addClass('error');
        } else {
            $('#field-coupon_code', sform).removeClass('error');
            $(this).append('<i class="fa fa-spinner fa-spin"></i>');
            var data = {
                'action': 'apply_mdcoupon_function',
                'code': $('#field-coupon_code', sform).val()
            };
            $.post(st_params.ajax_url, data, function (respon, textStatus, xhr) {
                if (respon.status == 1) {
                    sform.trigger('submit');
                }
            }, 'json');
        }
    });
    $('.sidebar-widget h4:first-child').each(function () {
        $(this).wrap("<div class='sidebar-title'></div>");
    });
    if ($('#sticky-nav').length && window.matchMedia('(min-width: 991px)').matches) {
        var topElSearch = $('#sticky-nav').offset().top;
        var searchFormHeight = $('#sticky-nav').closest('.search-form-wrapper').outerHeight();
        $(window).on('resize', function () {
            var topElSearch = $('#sticky-nav').offset().top;
            var searchFormHeight = $('#sticky-nav').closest('.search-form-wrapper').outerHeight();
        });
        $(window).on('scroll', function (event) {
            var scroll = $(window).scrollTop();
            var top = 0;
            if ($('#wpadminbar').length) {
                top = $('#wpadminbar').height();
            }
            if (scroll > topElSearch - top) {
                $('#sticky-nav').closest('.search-form-wrapper').css({
                    height: searchFormHeight + 'px'
                });
                $('#sticky-nav').find('form').addClass('container');
                $('#sticky-nav').css({
                    top: top + 'px',
                    'margin-top': '0px'
                });
                $('#sticky-nav').addClass('sticky');
                $.fn.getNiceScroll && $('#sticky-nav .dropdown-menu').getNiceScroll().resize();
                $('#sticky-nav').addClass('small');
            } else {
                $('#sticky-nav').closest('.search-form-wrapper').css({
                    height: 'auto'
                });
                $('#sticky-nav').find('form').removeClass('container');
                $('#sticky-nav').css({
                    top: 'auto',
                    'margin-top': '50px'
                });
                $('#sticky-nav').removeClass('sticky');
                $.fn.getNiceScroll && $('#sticky-nav .dropdown-menu').getNiceScroll().resize();
                $('#sticky-nav').removeClass('small');
            }
        })
    }
    $('.st-number-wrapper').each(function () {
        var timeOut = 0;
        var t = $(this);
        var input = t.find('.st-input-number');
        input.after('<span class="prev"><svg width="18px" height="2px" viewBox="0 0 18 2" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\n' +
            '    <!-- Generator: Sketch 49 (51002) - http://www.bohemiancoding.com/sketch -->\n' +
            '    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">\n' +
            '        <g id="Tour_Detail_1" transform="translate(-1180.000000, -1085.000000)" stroke="#5E6D77" stroke-width="1.5">\n' +
            '            <g id="check-avai" transform="translate(1034.000000, 867.000000)">\n' +
            '                <g id="adults" transform="translate(0.000000, 184.000000)">\n' +
            '                    <g id="ico_subtract" transform="translate(147.000000, 35.000000)">\n' +
            '                        <path d="M0.5,0.038 L15.5,0.038" id="Shape"></path>\n' +
            '                    </g>\n' +
            '                </g>\n' +
            '            </g>\n' +
            '        </g>\n' +
            '    </g>\n' +
            '</svg></span>');
        input.before('<span class="next"><svg width="18px" height="18px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\n' +
            '    <!-- Generator: Sketch 49 (51002) - http://www.bohemiancoding.com/sketch -->\n' +
            '    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">\n' +
            '        <g id="Tour_Detail_1" transform="translate(-1258.000000, -1077.000000)" stroke="#5E6D77" stroke-width="1.5">\n' +
            '            <g id="check-avai" transform="translate(1034.000000, 867.000000)">\n' +
            '                <g id="adults" transform="translate(0.000000, 184.000000)">\n' +
            '                    <g id="ico_add" transform="translate(225.000000, 27.000000)">\n' +
            '                        <path d="M0.5,8 L15.5,8" id="Shape"></path>\n' +
            '                        <path d="M8,0.5 L8,15.5" id="Shape"></path>\n' +
            '                    </g>\n' +
            '                </g>\n' +
            '            </g>\n' +
            '        </g>\n' +
            '    </g>\n' +
            '</svg></span>');
        var min = input.data('min');
        var max = input.data('max');
        t.find('span').on("click", function () {
            var $button = $(this);
            numberButtonFunc($button);
        });
        t.find('span').on("touchstart", function (e) {
            $(this).trigger('click');
            e.preventDefault();
            var $button = $(this);
            timeOut = setInterval(function () {
                // numberButtonFunc($button);
            }, 150);
        }).on('mouseup mouseleave touchend', function () {
            clearInterval(timeOut);
        });

        function numberButtonFunc($button) {
            var oldValue = $button.parent().find("input").val();
            var container = $button.closest('.form-guest-search');
            var total = 0;
            $('input[type="text"]', container).each(function () {
                total += parseInt($(this).val());
            });
            var newVal = oldValue;
            if ($button.hasClass('next')) {
                if (total < max) {
                    if (oldValue < max) {
                        newVal = parseFloat(oldValue) + 1;
                    } else {
                        newVal = max;
                    }
                }
            } else {
                if (oldValue > min) {
                    newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = min;
                }
            }
            $button.parent().find("input").val(newVal).trigger('change');
            $('input[name="' + $button.parent().find("input").attr('name') + '"]', '.search-form').trigger('change');
            $('input[name="' + $button.parent().find("input").attr('name') + '"]', '.form-check-availability-hotel').trigger('change');
            $('input[name="' + $button.parent().find("input").attr('name') + '"]', '.single-room-form').trigger('change');
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('#dropdown-1 label', $button.closest('.field-guest')).hide();
                $('#dropdown-1 .render', $button.closest('.field-guest')).show();
            }
        }
    });
    $('.btn-close-guest-form').on('click', function () {
        $('.field-guest  .dropdown-menu').slideUp(50);
    });
    $('.st-cut-text').each(function () {
        var t = $(this);
        if (t.text().length > 0) {
            var arr = t.text().trim().split(' ');
            console.log(arr);
        }
    });
    $('.booking-item-review-expand-more').on('click', function () {
        var t = $(this);
        t.closest('.booking-item-review-content').find('.booking-item-review-more').fadeIn();
        t.closest('.booking-item-review-content').find('.booking-item-review-expand-less').show();
        t.hide();
    });
    $('.booking-item-review-expand-less').on('click', function () {
        var t = $(this);
        t.closest('.booking-item-review-content').find('.booking-item-review-more').fadeOut();
        t.closest('.booking-item-review-content').find('.booking-item-review-expand-more').show();
        t.hide();
    });
    jQuery(function ($) {
        if (body.hasClass('rtl')) {
            var rtl_check = true;
        } else {
            var rtl_check = false;
        }
        $('.st-service-slider').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 4,
                margin: 20,
                responsiveClass: true,
                dots: false,
                rtl: rtl_check,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        margin: 15,
                        dots: true,
                    },
                    576: {
                        items: 2,
                        nav: false,
                        margin: 15,
                        dots: true,
                    },
                    992: {
                        items: 3,
                        nav: true,
                    },
                    1200: {
                        items: 4,
                        nav: true,
                    }
                }
            });
        });

        $('.list-service-style2').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 3,
                margin: 20,
                responsiveClass: true,
                dots: true,
                rtl: rtl_check,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        margin: 15,
                    },
                    576: {
                        items: 2,
                        nav: false,
                        margin: 15,
                    },
                    992: {
                        items: 3,
                        nav: true,
                    },
                    1200: {
                        items: 3,
                        nav: true,
                    }
                }
            });
        });
        $('.list-service-style3').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 3,
                margin: 30,
                responsiveClass: true,
                dots: true,
                rtl: rtl_check,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        margin: 15,
                    },
                    576: {
                        items: 2,
                        nav: false,
                        margin: 15,
                    },
                    992: {
                        items: 3,
                        nav: true,
                    },
                    1200: {
                        items: 3,
                        nav: true,
                    }
                }
            });
        });
        $('.list-service-style4').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 3,
                margin: 30,
                responsiveClass: true,
                dots: true,
                rtl: rtl_check,
                nav: false,
                responsive: {
                    0: {
                        items: 1,
                        margin: 15,
                    },
                    576: {
                        items: 2,
                        margin: 15,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 3,
                    }
                }
            });
        });
        $('.list-service-style5').each(function () {
            $(this).owlCarousel({
                loop: true,
                items: 3,
                margin: 30,
                responsiveClass: true,
                dots: false,
                nav: true,
                rtl: rtl_check,
                responsive: {
                    0: {
                        items: 1,
                        margin: 15,
                    },
                    576: {
                        items: 2,
                        margin: 15,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 3,
                    }
                }
            });
        });
        $('.list-service-style6').each(function () {
            $(this).owlCarousel({
                loop: true,
                items: 3,
                margin: 30,
                responsiveClass: true,
                dots: true,
                nav: false,
                rtl: rtl_check,
                responsive: {
                    0: {
                        items: 1,
                        margin: 15,
                    },
                    576: {
                        items: 2,
                        margin: 15,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 3,
                    }
                }
            });
        });
        $('.list-service-style7').each(function () {
            $(this).removeClass('row');
            $(this).addClass('owl-carousel');
            $(this).owlCarousel({
                loop: false,
                items: 3,
                margin: 30,
                responsiveClass: true,
                dots: false,
                rtl: rtl_check,
                nav: false,
                responsive: {
                    0: {
                        items: 1,
                        margin: 15,
                        dots: true,
                    },
                    768: {
                        items: 2,
                        margin: 30,
                        dots: true,
                    },
                    992: {
                        items: 3,
                        margin: 30,
                        dots: false,
                    },
                    1200: {
                        items: 3,
                    }
                }
            });
        });
        //Slider list of destination
        $('.list-destination-style8').each(function () {
            let t = $(this);
            var owl = $('.owl-carousel', t).owlCarousel({
                loop: true,
                margin: 30,
                items: 6,
                responsiveClass: true,
                dots: true,
                nav: true,
                rtl: rtl_check,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        margin: 15,
                    },
                    576: {
                        items: 2,
                        margin: 15,
                    },
                    767: {
                        items: 3,
                        nav: true,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 6,
                        nav: true,
                    }
                }
            });

        });

        $('.st-service-rental-slider').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 3,
                margin: 20,
                rtl: rtl_check,
                responsiveClass: true,
                dots: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        margin: 15,
                    },
                    576: {
                        items: 2,
                        margin: 15,
                    },
                    992: {
                        items: 3,
                        nav: true,
                    },
                    1200: {
                        items: 3,
                        nav: true,
                    }
                }
            });
        });

        $('.st-testimonial-new .style-3').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 4,
                rtl: rtl_check,
                margin: 30,
                responsiveClass: true,
                dots: true,
                nav: true,
                responsive: {
                    0: {
                        items: 1,
                        margin: 15,
                    },
                    767: {
                        items: 1,
                        margin: 15,
                    },
                    992: {
                        items: 2,
                    },
                    1200: {
                        items: 2,
                    }
                }
            });
        });
        $('.st-testimonial-new .style-4').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 1,
                responsiveClass: true,
                rtl: rtl_check,
                dots: true,
                responsive: {
                    0: {
                        items: 1,

                    },
                    767: {
                        items: 1,

                    },
                    992: {
                        items: 1,
                    },
                    1200: {
                        items: 1,
                    }
                }
            });
        });
        $('.st-testimonial-new .style-5').each(function () {
            $(this).owlCarousel({
                loop: false,
                rtl: rtl_check,
                items: 1,
                responsiveClass: true,
                dots: false,
                nav: true,
                responsive: {
                    0: {
                        items: 1,

                    },
                    767: {
                        items: 1,

                    },
                    992: {
                        items: 1,
                    },
                    1200: {
                        items: 1,
                    }
                }
            });

            var parent = $(this);
            var data_image = $('.owl-item.active .item', parent).data('image');
            $('.st-testimonial-image img').attr("src", data_image);

            $(this).on('translated.owl.carousel', function (event) {
                data_image = $('.owl-item.active .item', parent).data('image');
                $('.st-testimonial-image img').attr("src", data_image);
            });

            /*var parent = $(this);
             var data_image = $('.owl-item.active .item',parent).data('image');
             $('.st-testimonial-image img').attr("src",data_image);
             $('.owl-nav button ',parent).on('click',function () {
             data_image = $('.owl-item.active .item',parent).data('image');
             $('.st-testimonial-image img').attr("src",data_image);
             })*/
        });

        $(window).on('resize', function () {
            var screenWidth = $('body').width(),
                stTestimonialWidth = $('.st-testimonial-new').width(),
                leftMargin = (screenWidth - stTestimonialWidth) / 2;

            $('.st-testimonial-image').css({
                'margin-left': '-' + leftMargin + 'px'
            });

        }).trigger('resize');

        $('.st-testimonial-slider').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 4,
                margin: 30,
                responsiveClass: true,
                dots: true,
                nav: false,
                responsive: {
                    0: {
                        items: 1,
                        margin: 15,
                    },
                    575: {
                        items: 2,
                        margin: 15,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 3,
                    }
                }
            });
        });

        $('.st-testimonial-solo-slider').each(function () {
            $(this).owlCarousel({
                loop: false,
                items: 1,
                margin: 30,
                responsiveClass: true,
                dots: true,
                nav: false
            });
        });

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
            $('.next', parent).on('click', function (ev) {
                ev.preventDefault();
                owl.trigger('next.owl.carousel');
            });
            $('.prev', parent).on('click', function (ev) {
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
        $('.owl-tour-program-7').each(function () {
            var parent = $(this).parent();
            var owl = $(this);
            owl.owlCarousel({
                loop: false,
                items: 1,
                margin: 0,
                responsiveClass: true,
                dots: false,
                nav: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    992: {
                        items: 1,
                    },
                    1200: {
                        items: 1,
                    }
                }
            });
            owl.on('resized.owl.carousel', function () {
                setTimeout(function () {
                    if ($('.ovscroll').length) {
                        $.fn.getNiceScroll && $('.ovscroll').getNiceScroll().resize();
                    }
                }, 1000);
            });
        });

        /* BG Slider */
        if ($('.search-form-wrapper.slider').length) {
            var heightSlider = $('.search-form-wrapper.slider').outerHeight();
            $('.st-bg-slider').fotorama({
                height: heightSlider
            });
            $(window).on('resize', function () {
                if ($('.search-form-wrapper.slider').length) {
                    var heightSlider = $('.search-form-wrapper.slider').outerHeight();
                    $('.st-bg-slider').fotorama({
                        height: heightSlider
                    });
                }
            });
        }

    });
    var iex = 0;
    $('.st-program-list').each(function () {
        var t = $(this);
        $('.item .header', t).on('click', function () {
            $('.st-program .expand').text($('.st-program .expand').data('text-more'));
            iex = 0;
            $('.item', t).removeClass('active');
            $(this).parent().toggleClass('active');
        });
    });
    $('.st-program .expand').on('click', function () {
        var t = $(this);
        if (iex == 0) {
            $('.st-program .st-program-list .item').addClass('active');
            t.text(t.data('text-less'));
            iex = 1;
        } else {
            $('.st-program .st-program-list .item').removeClass('active');
            t.text(t.data('text-more'));
            iex = 0;
        }
    });
    $('.st-faq .item').each(function () {
        var t = $(this);
        t.find('.header').on('click', function () {
            $('.st-faq .item').not(t).removeClass('active');
            t.toggleClass('active');
        });
    });
    $(".st-video-popup").each(function () {
        $(this).magnificPopup({
            type: 'iframe'
        })
    });
    $('.st-gallery-popup').on('click', function (e) {
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
    //zzz
    $('.st-single-tour .form-date-search', body).each(function () {
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('.check-in-input', parent),
            check_out_input = $('.check-out-input', parent),
            check_in_out_input = $('.check-in-out-input', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent),
            sts_checkout_label = $('.sts-tour-checkout-label', parent),
            availabilityDate = $(this).data('availability-date');

        var customClass = $('.date-wrapper', parent).data('custom-class') || '';

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
            customClass: customClass,
            fetchEvents: function (start, end, el, callback) {
                var events = [];
                if (el.flag_get_events) {
                    return false;
                }
                el.flag_get_events = true;
                el.container.find('.loader-wrapper').show();
                var data = {
                    action: check_in_out_input.data('action'),
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    //tour_id: check_in_out_input.data('tour-id'),
                    security: st_params._s
                };
                var postType = check_in_out_input.data('posttype');
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
                            ajaxSelectStartTime(check_in_out_input.data('tour-id'), start.format(parent.data('format')), end.format(parent.data('format')), '', check_in_out_input.data('posttype'));
                        } else {
                            $('#starttime_tour option').remove();
                            $('#starttime_box').parent().hide();
                        }
                    }
                }
                if (st_params.caculator_price_single_ajax === 'on') {
                    if ($('.single-st_tours').length > 0) {
                        date_wrapper.trigger('tours-booking-form');
                    }

                    if ($('.single-st_activity').length > 0) {
                        date_wrapper.trigger('activity-booking-form');
                    }

                }

            });
        date_wrapper.on('click', function (e) {
            check_in_out_input.trigger('click');
        });
    });
    if ($('.logo').length) {
        var logoWidth = $('.logo').width();
        if ($('.has-mega-menu .mega-menu').length) {
            var stMegaWidth = $('.has-mega-menu .mega-menu .st-mega').first().outerWidth();
            $('.has-mega-menu .mega-menu').css({
                left: (logoWidth + 60) + 'px',
                width: stMegaWidth + 'px'
            });
            $('.has-mega-menu .mega-menu .st-mega').css({
                width: '100%'
            });
            $(window).on('resize', function () {
                var winDowsWidth = $('#header').width();
                if (winDowsWidth < (stMegaWidth + logoWidth + 130)) {
                    var megaWidth = winDowsWidth - (logoWidth + 130);
                    $('.has-mega-menu .mega-menu').css({
                        width: megaWidth + 'px',
                    });
                } else {
                    $('.has-mega-menu .mega-menu').css({
                        width: stMegaWidth + 'px',
                    });
                }
                if (window.matchMedia("(min-width: 992px)").matches) {
                    $('.has-mega-menu .mega-menu').show();
                } else {
                    $('.has-mega-menu .mega-menu').hide();
                }
            });
        }
    }
    var checkExWoo = 0;
    $('.booking-item-review-expand-new').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var textMore = t.data('more');
        var textLess = t.data('hide');
        if (t.hasClass('collapsed')) {
            t.html(textLess);
        } else {
            if (checkExWoo == 0) {
                t.html(textLess);
                checkExWoo++;
            } else {
                t.html(textMore);
            }
        }
        t.closest('.booking-item-review-content').find('.booking-item-review-more').slideToggle();
    });
    if (typeof $('.player').YTPlayer === 'function') {
        $('.btn-play-video').on('click', function (e) {
            e.preventDefault();
            if (typeof player == 'undefined') {
                var player = jQuery(".player").YTPlayer({
                    align: "center,center"
                });
            }
            var t = $(this);
            if (t.hasClass('play')) {
                player.YTPPlay();
                t.removeClass('play')
            } else {
                player.YTPPause();
                t.addClass('play')
            }
        });
    }
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
    }
    $('.search-form-wrapper.slider a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var slideHeight = $('.search-form-wrapper.slider').outerHeight();
        var ft = $('.st-bg-slider').data('fotorama');
        if (typeof ft !== 'undefined') {
            ft.resize({
                height: slideHeight
            });
        }

    });
    $('.st-list-of-multi-services').each(function () {
        var t = $(this);
        var dataTabShowVal = $('.st-list-dropdown .header', t).data('value');
        $('.multi-service-wrapper .tab-content.' + dataTabShowVal, t).show();
        $('.has-matchHeight', t).matchHeight({
            remove: true
        });
        $('.has-matchHeight', t).matchHeight();
    });
    $('.st-list-dropdown').each(function () {
        var t = $(this);
        var parent = t.closest('.st-list-of-multi-services');
        var currentTabList = t.find('.header').data('value');
        $('.list', t).find('li[data-value="' + currentTabList + '"]').hide();
        $('.header', t).on('click', function () {
            $('.list', t).toggle();
        });
        $('.list li', t).on('click', function () {
            var me = $(this);
            $('.list li', t).removeClass('active');
            me.addClass('active');
            var dataS = me.data('value');
            var dataArg = me.data('arg');
            var dataSName = me.text();
            $('.header span', t).text(dataSName);
            $('.header', t).attr('data-value', dataS);
            me.parent().hide();
            $.ajax({
                url: st_params.ajax_url,
                type: "GET",
                data: {
                    'action': "st_list_of_service_" + dataS,
                    'dataArg': dataArg,
                },
                dataType: "json",
                beforeSend: function () {
                    parent.find('.map-loading').html('<div class="st-loader"></div>');
                    parent.find('.map-loading').css('z-index', 99);
                    parent.find('.map-loading').show();

                },
                error: function (jqXHR, textStatus, errorThrown) {},
                success: function (res) {
                    parent.find('.map-loading').html("");
                    parent.find('.map-loading').hide();
                },
                complete: function (xhr, status) {

                    if (xhr.responseJSON) {

                        parent.find('.multi-service-wrapper').html(xhr.responseJSON.html).hide().fadeIn(1500);

                        $('.multi-service-wrapper .tab-content', parent).hide();
                        $('.multi-service-wrapper .tab-content.' + dataS, parent).show();
                        setTimeout(function () {
                            $('.multi-service-wrapper .tab-content .has-matchHeight', parent).matchHeight({
                                remove: true
                            });
                            $('.multi-service-wrapper .tab-content .has-matchHeight', parent).matchHeight();
                        }, 1000);
                        $('.list li', t).show();
                        $('.list', t).find('li[data-value="' + dataS + '"]').hide();
                    }
                    $('.st-service-slider').each(function () {
                        $(this).owlCarousel({
                            loop: false,
                            items: 4,
                            margin: 20,
                            responsiveClass: true,
                            dots: false,
                            responsive: {
                                0: {
                                    items: 1,
                                    nav: false,
                                    margin: 15,
                                    dots: true,
                                },
                                576: {
                                    items: 2,
                                    nav: false,
                                    margin: 15,
                                    dots: true,
                                },
                                992: {
                                    items: 3,
                                    nav: true,
                                },
                                1200: {
                                    items: 4,
                                    nav: true,
                                }
                            }
                        });
                    });
                }
            });
        })
        $(document).on('mouseup', function (e) {
            var container = t;
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.find('.list').hide();
            }
        });
    });
    if ($('.search-form-wrapper.mix').length > 0) {
        if (window.matchMedia("(max-width: 991px)").matches) {
            var heightTabMix = [];
            $('.search-form-wrapper.mix .tab-content .tab-pane').each(function () {
                var idNameTabMix = $(this).attr('id');
                var tabMixShowEl = document.querySelector('.search-form-wrapper.mix .tab-pane#' + idNameTabMix),
                    tabMixWantedHeight = getHeightHiddenEl(tabMixShowEl);
                heightTabMix.push(tabMixWantedHeight);
            });
            if (heightTabMix.length) {
                var maxHeightTabMix = Math.max.apply(null, heightTabMix);
                var maxHeightPos = heightTabMix.indexOf(maxHeightTabMix);
                $('.search-form-wrapper.mix .tab-content .tab-pane').each(function (i, obj) {
                    if (i === maxHeightPos)
                        $(this).css('height', (maxHeightTabMix - 1) + 'px');
                    else
                        $(this).css('height', maxHeightTabMix + 'px');
                });
            }
        }
    }
})(jQuery);

function initMapContactPage(mapEl) {
    var mapStylesContact = [{
            "elementType": "labels",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "featureType": "administrative.land_parcel",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "featureType": "administrative.neighborhood",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "featureType": "poi",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "featureType": "road",
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        },
        {
            "featureType": "transit",
            "stylers": [{
                "visibility": "off"
            }]
        }
    ];
    var mapLat = mapEl.data('lat');
    var mapLng = mapEl.data('lng');
    var map = new google.maps.Map(document.getElementById('contact-map-new'), {
        zoom: 13,
        center: {
            lat: parseFloat(mapLat),
            lng: parseFloat(mapLng)
        },
        disableDefaultUI: true,
        styles: mapStylesContact
    });
    new google.maps.Marker({
        position: new google.maps.LatLng(mapLat, mapLng),
        icon: st_params.icon_contact_map,
        map: map,
    });
}

function customControlGoogleMap(mapEl, map) {
    //==== Top Right area
    var topRightArea = document.createElement('div');
    topRightArea.className = 'google-control-top-right-area';
    var controlFullScreen = document.createElement('div');
    controlFullScreen.className = 'google-control-fullscreen google-custom-control';
    controlFullScreen.innerHTML = '<img src="' + st_list_map_params.icon_full_screen + '" alt="Full Screen"/>';
    topRightArea.appendChild(controlFullScreen);
    var controlCloseFullScreen = document.createElement('div');
    controlCloseFullScreen.className = 'google-control-closefullscreen google-custom-control hide';
    controlCloseFullScreen.innerHTML = '<img src="' + st_list_map_params.icon_close + '" alt="Full Screen"/>';
    topRightArea.appendChild(controlCloseFullScreen);
    var controlMyLocation = document.createElement('div');
    controlMyLocation.className = 'google-control-mylocation google-custom-control';
    controlMyLocation.innerHTML = '<img src="' + st_list_map_params.icon_my_location + '" alt="Full Screen"/>';
    topRightArea.appendChild(controlMyLocation);
    var controlStyles = document.createElement('div');
    controlStyles.className = 'google-control-styles google-custom-control';
    controlStyles.innerHTML = '<img src="' + st_list_map_params.icon_my_style + '" alt="Full Screen"/><div class="google-control-dropdown"><div class="item">Silver</div><div class="item">Retro</div><div class="item">Dark</div><div class="item">Night</div><div class="item">Aubergine</div></div>';
    topRightArea.appendChild(controlStyles);
    //==== Bottom Right area
    var bottomRightArea = document.createElement('div');
    bottomRightArea.className = 'google-control-bottom-right-area';
    var controlZoomIn = document.createElement('div');
    controlZoomIn.className = 'google-control-zoomin google-custom-control';
    controlZoomIn.innerHTML = '<img src="' + st_list_map_params.icon_zoom_in + '" alt="Full Screen"/>';
    bottomRightArea.appendChild(controlZoomIn);
    var controlZoomOut = document.createElement('div');
    controlZoomOut.className = 'google-control-zoomout google-custom-control';
    controlZoomOut.innerHTML = '<img src="' + st_list_map_params.icon_zoom_out + '" alt="Full Screen"/>';
    bottomRightArea.appendChild(controlZoomOut);
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(topRightArea);
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(bottomRightArea);
    controlFullScreen.addEventListener('click', function () {
        controlFullScreen.classList.add('hide');
        controlCloseFullScreen.classList.remove('hide');
        var element = map.getDiv();
        if (element.requestFullscreen) {
            element.requestFullscreen();
        }
        if (element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        }
        if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        }
    });
    controlCloseFullScreen.addEventListener('click', function () {
        controlFullScreen.classList.remove('hide');
        controlCloseFullScreen.classList.add('hide');
        if (document.exitFullscreen)
            document.exitFullscreen();
        else if (document.webkitExitFullscreen)
            document.webkitExitFullscreen();
        else if (document.mozCancelFullScreen)
            document.mozCancelFullScreen();
        else if (document.msExitFullscreen)
            document.msExitFullscreen();
    });
    controlMyLocation.addEventListener('click', function () {
        if (navigator.geolocation)
            navigator.geolocation.getCurrentPosition(function (pos) {
                var latlng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
                map.setCenter(latlng);
                new google.maps.Marker({
                    position: latlng,
                    icon: mapEl.data().icon,
                    map: map
                });
            }, function (error) {
                console.log('Can not get your Location');
            });
    });
    controlZoomIn.addEventListener('click', function () {
        var current = map.getZoom();
        map.setZoom(current + 1);
    });
    controlZoomOut.addEventListener('click', function () {
        var current = map.getZoom();
        map.setZoom(current - 1);
    });
    controlStyles.addEventListener('click', function () {
        controlStyles.querySelector('.google-control-dropdown').classList.toggle('show');
    });
    var dropdownStyles = controlStyles.querySelector('.google-control-dropdown');
    var items = dropdownStyles.querySelectorAll('.item');
    for (var i = 0; i < items.length; i++) {
        items[i].addEventListener('click', function () {
            var style = item.textContent.toLowerCase();
            if (mapStyles[style]) {
                map.setOptions({
                    styles: mapStyles[style]
                });
            }
        });
    }
}

function initMapDetail(mapEl, mapData, mapLat, mapLng, mapZoom, mapIcon) {
    // var popupPos = mapEl.data('popup-position');
    // if (mapData.length <= 0)
    mapData = mapEl.data('data_show');
    if (mapLat.length <= 0)
        mapLat = mapEl.data('lat');
    if (mapLng.length <= 0)
        mapLng = mapEl.data('lng');
    if (mapZoom.length <= 0)
        mapZoom = 16;
    if (mapIcon.length <= 0)
        mapIcon = mapEl.data('icon');
    var map = new google.maps.Map(document.getElementById('list_map'), {
        zoom: mapZoom,
        center: new google.maps.LatLng(mapLat, mapLng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var infowindow = new google.maps.InfoWindow({
        maxWidth: 400,
        maxHeight: 300
    });
    var marker, i;

    if (typeof mapData != 'undefined' && Object.keys(mapData).length) {
        var markers = jQuery.map(mapData, function (location, i) {
            var icon = {
                url: mapData[i].icon_mk,
                size: {
                    width: 40,
                    height: 50
                },
                origin: new google.maps.Point(0, 0), // origin
            };
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(mapData[i].lat), parseFloat(mapData[i].lng)),
                map: map,
                icon: icon,
                optimized: false
            });

            bounds = new google.maps.LatLngBounds();
            var loc = new google.maps.LatLng(parseFloat(mapData[i].lat), parseFloat(mapData[i].lng));
            bounds.extend(loc);
            var ibOptions = {
                content: '',
                disableAutoPan: true,
                maxWidth: 0,
                zIndex: null,
                boxStyle: {
                    padding: "0px 0px 0px 0px",
                },
                closeBoxURL: "",
                cancelBubble: true,
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: true,
                alignBottom: true
            };
            if (i < Object.keys(mapData).length) {
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(mapData[i].content_html);
                        if ((mapData[i].lat != mapLat) && (mapData[i].lng != mapLng)) {
                            infowindow.open(map, marker);
                        }

                    }
                })(marker, i));
            }

        });
    }

}

function initHalfMap(mapEl, mapData, mapLat, mapLng, mapZoom, mapIcon) {
    var popupPos = mapEl.data('popup-position');
    if (mapData.length <= 0)
        mapData = mapEl.data('data_show');
    if (mapLat.length <= 0)
        mapLat = mapEl.data('lat');
    if (mapLng.length <= 0)
        mapLng = mapEl.data('lng');
    if (mapZoom.length <= 0)
        mapZoom = mapEl.data('zoom');
    if (mapIcon.length <= 0)
        mapIcon = mapEl.data('icon');
    var map = new google.maps.Map(mapEl.get(0), {
        zoom: mapZoom,
        center: {
            lat: parseFloat(mapLat),
            lng: parseFloat(mapLng)
        },
        disableDefaultUI: true
    });
    bounds = new google.maps.LatLngBounds();
    if (typeof mapData != 'undefined' && Object.keys(mapData).length) {
        var marker = [];
        var ib = [];
        var c = {};
        var markers = jQuery.map(mapData, function (location, i) {
            marker[i] = new google.maps.Marker({
                position: {
                    lat: parseFloat(location.lat),
                    lng: parseFloat(location.lng)
                },
                options: {
                    icon: mapIcon,
                    animation: google.maps.Animation.DROP
                },
                map: map
            });
            var loc = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lng));
            bounds.extend(loc);
            var ibOptions = {
                content: '',
                disableAutoPan: true,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(-135, -55),
                zIndex: null,
                boxStyle: {
                    padding: "0px 0px 0px 0px",
                    width: "270px",
                },
                closeBoxURL: "",
                cancelBubble: true,
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: true,
                alignBottom: true
            };
            if (window.matchMedia("(min-width: 768px)").matches) {
                if (popupPos == 'right') {
                    ibOptions.pixelOffset = new google.maps.Size(35, -208);
                    ibOptions.alignBottom = false;
                }
            }
            jQuery(window).on('resize', function () {
                if (window.matchMedia("(min-width: 768px)").matches) {
                    if (popupPos == 'right') {
                        ibOptions.pixelOffset = new google.maps.Size(35, -208);
                        ibOptions.alignBottom = false;
                    }
                }
            });
            google.maps.event.addListener(marker[i], 'click', (function () {
                var source = location.content_html;
                var boxText = document.createElement("div");
                if (window.matchMedia("(min-width: 768px)").matches) {
                    if (popupPos == 'right') {
                        boxText.classList.add("right-box");
                    }
                }
                jQuery(window).on('resize', function () {
                    if (window.matchMedia("(min-width: 768px)").matches) {
                        if (popupPos == 'right') {
                            boxText.classList.add("right-box");
                        }
                    } else {
                        boxText.classList.remove("right-box");
                    }
                });
                boxText.style.cssText = "border-radius: 5px; background: #fff; padding: 0px;";
                boxText.innerHTML = source;
                ibOptions.content = boxText;
                var ks = Object.keys(c);
                if (ks.length) {
                    for (var j = 0; j < ks.length; j++) {
                        c[ks[j]].close();
                    }
                }
                ib[i] = new InfoBox(ibOptions);
                c[i] = ib[i];
                ib[i].open(map, this);
                map.panTo(ib[i].getPosition());
                google.maps.event.addListener(ib[i], 'domready', function () {
                    var closeInfoBox = document.getElementById("close-popup-on-map");
                    google.maps.event.addDomListener(closeInfoBox, 'click', function () {
                        ib[i].close();
                    });
                });
            }));
            return marker[i];
        });
        /*new MarkerClusterer(map, markers,
         {
         styles: [{
         height   : 36,
         url      : st_params.mclusmap,
         width    : 36,
         textColor: 'white',
         textSize : '16'
         }, {
         height   : 36,
         url      : st_params.mclusmap,
         width    : 36,
         textColor: 'white',
         textSize : '16'
         }, {
         height   : 36,
         url      : st_params.mclusmap,
         width    : 36,
         textColor: 'white',
         textSize : '16'
         }]
         });*/
        customControlGoogleMap(mapEl.get(0), map);
    }
    map.fitBounds(bounds);
    map.panToBounds(bounds);
    var listener = google.maps.event.addListener(map, "idle", function () {
        if (map.getZoom() > 16)
            map.setZoom(16);
        google.maps.event.removeListener(listener);
    });
}
/*Send email all in single service*/
(function ($) {
    'use strict';
    var body = $('body');
    $(".form-st-send-mail .st_send-mail-form").on('submit', function (e) {
        return false;
    });
    $('.form-st-send-mail .st_send-mail-form .sent-email-st').on('click', function (ev) {
        ev.preventDefault();
        var type_service = $("input[name=type_service]").val();
        var name_service = $("input[name=name_service]").val();
        var name_st = $("input[name=name_st]").val();
        var email_st = $("input[name=email_st]").val();
        var phone_st = $("input[name=phone_st]").val();
        var content_st = $("textarea[name=content_st]").val();
        var email_owl = $("input[name=email_owl]").val();
        $('.st-sent-mail-customer .loader-wrapper').show();
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
            beforeSend: function () {},
            error: function (jqXHR, textStatus, errorThrown) {},
            success: function (res) {

            },
            complete: function (xhr, status) {

                if (xhr.responseJSON.status != 0) {
                    var mess = '<div class="ccv-success"><div class="content-message">' + xhr.responseJSON.message + '</div></div>';
                    $('.form-st-send-mail .st_send-mail-form').html(mess);
                    $('.st-sent-mail-customer .loader-wrapper').hide();
                } else {
                    var mess = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + xhr.responseJSON.message + '</div>';
                    $('.form-st-send-mail .message-wrapper-sendemail').html(mess);
                    $('.st-sent-mail-customer .loader-wrapper').hide();
                }
            }
        });
    });
})(jQuery);

(function ($) {
    // single hotel room booking ajax
    $('form.hotel-room-booking-form').on('click', 'button.btn-book-ajax', function (e) {
        e.preventDefault();
        var form = $('form.hotel-room-booking-form');
        var data = $('form.hotel-room-booking-form').serializeArray();
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
                            $('div.message-wrapper').html(res.message);
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

    // activity booking ajax
    $('form.activity-booking-form').on('click', 'button.btn-book-ajax', function (e) {
        e.preventDefault();
        var form = $('form.activity-booking-form');
        var data = $('form.activity-booking-form').serializeArray();
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
                            $('div.message-wrapper').html(res.message);
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

    // tour booking ajax
    $('form.tour-booking-form').on('click', 'button.btn-book-ajax', function (e) {
        e.preventDefault();
        var form = $('form.tour-booking-form');
        var data = $('form.tour-booking-form').serializeArray();
        var loadingSubmit = form.find('button[name=submit]');
        $(loadingSubmit).find("i.fa-spin").removeClass("hide");
        data.push({
            name: 'security',
            value: st_params._s
        });
        $('div.message-wrapper').html("");
        if (jQuery('#st-content-wrapper').hasClass('st-content-wrapper--solo')) {
            data.push({
                name: 'disable_require_name',
                value: true
            });
        }
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

    // car booking ajax
    $('form.car-booking-form').on('click', 'button.btn-book-ajax', function (e) {
        e.preventDefault();
        var form = $('form.car-booking-form');
        var data = $('form.car-booking-form').serializeArray();
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

    // rental booking ajax
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
    if ($.fn.niceScroll) {
        jQuery(".dropdown-menu.st-icheck").niceScroll({});
    }

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
    };

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
            for (var i = controls.length ? (controls.length) : 0; i < adult; i++) {
                var div = $($('#guest_name_control_item').clone().html());
                var p = div.find('input').attr('placeholder');
                div.find('input').attr('placeholder', p.replace('%d', i + 1));

                controlWraps.append(div);
            }

            // Remove
            controls.each(function () {
                if ($(this).index() > adult - 1) {
                    $(this).remove();
                }
            });

            $(this).removeClass('hidden');
        }
    });

    triggerGuestInputChange();
    //------------------End Guest Name Inputs -------------------

})(jQuery);

function updateQueryStringParam(key, value) {
    baseUrl = [location.protocol, '//', location.host, location.pathname].join('');
    urlQueryString = document.location.search;
    var newParam = key + '=' + value,
        params = '?' + newParam;
    // If the "search" string exists, then build params from it
    if (urlQueryString) {
        keyRegex = new RegExp('([\?&])' + key + '[^&]*');
        // If param exists already, update it
        if (urlQueryString.match(keyRegex) !== null) {
            params = urlQueryString.replace(keyRegex, "$1" + newParam);
        } else { // Otherwise, add it to end of query string
            params = urlQueryString + '&' + newParam;
        }
    }
    //return baseUrl + params;
    window.history.replaceState({}, "", baseUrl + params);
}

function isMobile() {
    var isMobile = false;
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }
    return isMobile;
}

function stKeyupsmartSearch(event) {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue;
    input = event.value.toUpperCase();
    filter = event.value.toUpperCase();
    parent = event.closest(".form-extra-field");
    ul = parent.getElementsByTagName('ul')[0];
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        //a = li[i].getElementsByTagName("a")[0];
        txtValue = li[i].textContent || li[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
jQuery(function ($) {
    document.querySelectorAll(".select-number-passenger  .st-number  .plus").forEach((input) => input.addEventListener("click", calculate_add));
    document.querySelectorAll(".select-number-passenger  .st-number  .minus").forEach((input) => input.addEventListener("click", calculate_minus));

    function calculate_add() {
        var num_item = $(this).closest('.select-number-passenger');
        var num = num_item.find('.st-input-number').val();
        var max_val = num_item.find('.st-input-number').data('max');
        var value_num = parseInt(num) + 1;
        num_item.find('.st-input-number').val(value_num);
        num_item.find('strong.num').text(value_num);

    }

    function calculate_minus() {
        var num_item = $(this).closest('.select-number-passenger');
        var num = num_item.find('.st-input-number').val();
        var min_val = num_item.find('.st-input-number').data('min');
        if (parseInt(num) > min_val) {
            var value_num = parseInt(num) - 1;
            num_item.find('.st-input-number').val(value_num);
            num_item.find('strong.num').text(value_num);
        }

    }
})

jQuery(function ($) {
    var startApp = function () {
        if (typeof st_social_params != 'undefined') {
            var key = st_social_params.google_client_id;
            let r = (Math.random() + 1).toString(36).substring(7);
            gapi.load('auth2', function () {
                auth2 = gapi.auth2.init({
                    client_id: key,
                    cookiepolicy: 'single_host_origin',
                    plugin_name: 'single_host_origin' + r,
                });
                attachSignin(document.getElementById('st-google-signin2'));
                attachSignin(document.getElementById('st-google-signin3'));
            });
        }
    };

    if (typeof window.gapi != 'undefined') {
        startApp();
    }

    function attachSignin(element) {
        auth2.attachClickHandler(element, {},
            function (googleUser) {
                var profile = googleUser.getBasicProfile();
                startLoginWithGoogle(profile);

            },
            function (error) {
                console.log(JSON.stringify(error, undefined, 2));
            });
    }

    function startLoginWithGoogle(profile) {
        if (typeof window.gapi.auth2 == 'undefined')
            return;
        sendLoginData({
            'channel': 'google',
            'userid': profile.getId(),
            'username': profile.getName(),
            'useremail': profile.getEmail(),
        });
    }

    function startLoginWithFacebook(btn) {
        btn.addClass('loading');

        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                sendLoginData({
                    'channel': 'facebook',
                    'access_token': response.authResponse.accessToken
                });

            } else {
                FB.login(function (response) {
                    if (response.authResponse) {
                        sendLoginData({
                            'channel': 'facebook',
                            'access_token': response.authResponse.accessToken
                        });

                    } else {
                        alert('User cancelled login or did not fully authorize.');
                    }
                }, {
                    scope: 'email',
                    return_scopes: true
                });
            }
        });
    }

    function sendLoginData(data) {
        data._s = st_params._s;
        data.action = 'traveler.socialLogin';
        var parent_login = $(".login-regiter-popup");
        $.ajax({
            data: data,
            type: 'post',
            dataType: 'json',
            url: st_params.ajax_url,
            beforeSend: function () {
                parent_login.find('.map-loading').html('<div class="st-loader"></div>');
                parent_login.find('.map-loading').css('z-index', 99);
                parent_login.find('.map-loading').show();

            },
            success: function (rs) {
                handleSocialLoginResult(rs);
            },
            error: function (e) {

                alert('Can not login. Please try again later');
            }
        })
    }

    function handleSocialLoginResult(rs) {
        if (rs.reload)
            window.location.reload();
        if (rs.message)
            alert(rs.message);
    }

    $('.st_login_social_link').on('click', function () {
        var channel = $(this).data('channel');

        switch (channel) {
            case "facebook":
                startLoginWithFacebook($(this));
                break;
        }
    })

    /* Fix social login popup */
    function popupwindow(url, title, w, h) {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }

    $('.st_login_social_link').on('click', function () {
        var href = $(this).attr('href');
        if ($(this).hasClass('btn_login_tw_link'))
            popupwindow(href, '', 600, 450);
        return false;
    });
    /* End fix social login popup */
})
jQuery(function ($) {
    // caculator height menu
    function setHeightValueMenu(x) {
        if (tabslet.matches) { // If media query matches
            if (document.querySelector(".page-template.st-header-2 header#header")) {
                document.querySelector(".page-template.st-header-2 header#header").style.marginBottom = "-" + window.getComputedStyle(document.querySelector(".st-header-2 header#header .header")).height;
            }
        } else {}
    }

    var tabslet = window.matchMedia("(min-width: 992px)")
    setHeightValueMenu(tabslet) // Call listener function at run time
    tabslet.addListener(setHeightValueMenu) // Attach listener function on state changes
});
/*Loadmore*/
jQuery(function ($) {
    if ($('.st-loadmore.loadmore-ccv')) {
        $('.st-loadmore.loadmore-ccv').each(function () {
            st_nav_tab($(this));
        });
    }
    //Show password
    $('.field-password svg').on('click', function () {
        let t = $(this),
            parent = t.parents('.field-password');

        if (parent.hasClass('ic-view')) {
            parent.addClass('viewing').find('input').attr('type', 'text');
            parent.removeClass('ic-view');
        } else {
            parent.removeClass('viewing').find('input').attr('type', 'password');
            parent.addClass('ic-view');
        }
    });
});

function st_nav_tab(el) {
    //var append_load = '<div id="morefloatingBarsG"><div class="ngothoai-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>';
    var append_load = '<div class="loader-wrapper"><div class="st-loader"></div></div>';
    el.find(".load_more_post").on('click', function (element) {
        element.preventDefault();
        var element = jQuery(this);
        var posts_per_page = element.attr('data-posts-per-page');
        var paged = element.attr('data-paged');
        var data_id_service = element.attr('data-id_service');
        var max_num_page = element.attr('data-max-num-page');
        var check_all = element.attr('check-all');
        var type_service = element.attr('type_service');
        var dataIndex = element.attr('data-index');
        var $container = element.closest('.st_service_load');
        var offloadmore = $container.find('.loadmore');

        if (check_all === "true") {
            var append_content = $container.find('.st_all');
            var append_st = $container.find('.services-grid .row');
            var loadmore = $container.find('.st_all .load-ajax-icon .loader-wrapper');
            var offloadmore = $container.find('.st_all .loadmore ');
            var buttonloadmore = append_content.find('.st-button-loadmore');
        } else {
            var append_content = $container.find('.st_blog_' + tax_query);
            var append_st = $container.find('.services-grid .row');

            var buttonloadmore = $container.find('.st-button-loadmore');
        }
        var append_st = $container.find('.services-grid > .row');
        var loadmore = $container.find('.load-ajax-icon .loader-wrapper');
        var offloadmore = $container.find('.loadmore');
        var buttonloadmore = $container.find('.st-button-loadmore');
        console.log(append_st);
        jQuery('.st-loadmore .loader-wrapper').show();
        jQuery.ajax({
            url: st_params.ajax_url,
            type: "POST",
            data: {
                'action': "st_load_more_service_by_id",
                'posts_per_page': posts_per_page,
                'paged': paged,
                'data_id_service': data_id_service,
                'max_num_page': max_num_page,
                'check_all': check_all,
                'type_service': type_service,
                'index': dataIndex
            },
            dataType: "json",
            beforeSend: function () {
                loadmore.show();
                buttonloadmore.hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                jQuery("#aLoad").remove();
                console.log("ERRO" + jqXHR + "is" + errorThrown);
            },
            success: function (res) {
                $datxa = jQuery(res.html);
                if ($datxa.length) {
                    append_st.append(res.html);

                } else {

                }
                $container.animate({
                    scrollTop: $container.prop("scrollHeight")
                }, 1000);
            },
            complete: function (xhr, status) {

                $data = jQuery(xhr.responseJSON.html);
                if ($data.length) {
                    element.attr('data-paged', xhr.responseJSON.paged);
                    element.attr('data-index', xhr.responseJSON.index);
                    loadmore.hide();
                    buttonloadmore.show();
                } else {
                    loadmore.hide();
                    offloadmore.remove();
                }
                jQuery('.st-loadmore .loader-wrapper').hide();
            }
        });

    });
}