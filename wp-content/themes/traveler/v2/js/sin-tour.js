(function ($) {
    'use strict';
    var body = $('body');

    jQuery(function($) {
        $('.stt-instagram-content').each(function () {
            let t = $(this),
                    number = t.data('number'),
                    name = t.data('name');

            var data = t.serializeArray();
            data.push({
                name: 'number',
                value: number
            }, {
                name: 'name',
                value: name
            },
                    {
                        name: 'action',
                        value: t.data('action')
                    },
                    );
            $.post(st_params.ajax_url, data, function (respon) {
                if (typeof respon == 'object') {
                    if (respon.status === 1) {

                        $('.stt-list-image', t).html(respon.html);
                        $('.stt-list-image .owl-carousel', t).owlCarousel({
                            loop: true,
                            items: 5,
                            responsiveClass: true,
                            dots: false,
                            nav: false,
                            responsive: {
                                0: {
                                    items: 2,

                                },
                                767: {
                                    items: 4,

                                },
                                1200: {
                                    items: 5,

                                }
                            }
                        });
                    }
                }
            }, 'json');

        });

        setTimeout(function () {
            $('.tour-slider-wrapper').each(function () {
                let t = $(this);
                if(body.hasClass('rtl')){
                    var rtl_check=true;
                } else {
                    var rtl_check=false;
                }
                var owl = $('.owl-carousel', t).owlCarousel({
                    center: true,
                    items: 1,
                    rtl:rtl_check,
                    loop: true,
                    autoplay: true,
                    margin: 0,
                });
                $('.st-next', t).on('click',function (ev) {
                    ev.preventDefault();
                    owl.trigger('next.owl.carousel');
                })
                $('.st-pre', t).on('click',function (ev) {
                    ev.preventDefault();
                    owl.trigger('prev.owl.carousel');
                })

            });
        }, 100);
        $('.category-slider-wrapper').each(function () {
            let t = $(this);
            $('.owl-carousel', t).owlCarousel({
                loop: true,
                margin: 30,
                items: 4,
                responsiveClass: true,
                dots: true,
                nav: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        margin: 15,
                    },
                    767: {
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



        //----------- Description Tour-------------------------------

        $('.st-description-more .stt-more').on('click', function () {

            $('.st-description-more').hide();
            $('.st-description-less').show();
        });
        $('.st-description-less .stt-less').on('click', function () {

            $('.st-description-less').hide();
            $('.st-description-more').show();
        });
        //----------- End Description Tour---------------------------
        //----------- Content Comment--------------------------------
        $('.comment-item').each(function () {
            let that = this;
            $('.st-comment-more .stt-more', that).on('click', function (e) {

                $('.st-comment-less', that).show();
                $('.st-comment-more', that).hide();
            })
        });
        $('.comment-item').each(function () {
            let that = this;
            $('.st-comment-less .stt-less', that).on('click', function (e) {

                $('.st-comment-more', that).show();
                $('.st-comment-less', that).hide();
            })
        });

        //----------- End Content Comment----------------------------
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
        $('.form-book-tour').each(function () {
            var parent = $(this);
            $('.dropdown', parent).on('click',function (e) {
                var dropdown_menu = $('[aria-labelledby="' + $(this).attr('id') + '"]', parent);
                $('.form-book--tour').find('.dropdown-menu').not(dropdown_menu).slideUp(50);
                dropdown_menu.slideToggle(50);
                if ($('.ovscroll').length) {
                    $('.ovscroll').getNiceScroll().resize();
                }
            });
            $('input[name="adult_number"]', parent).on('change',function () {

                var adults = parseInt($(this).val());
                var html = adults;
                if (typeof adults == 'number') {
                    if (adults < 1) {
                        html = $('.render .adult', parent).data('text') + ' x ' + adults;
                    } else {
                        html = $('.render .adult', parent).data('text-multi') + ' x ' + adults;
                    }
                }
                $('.render .adult', parent).html(html);
            });
            $('input[name="adult_number"]', parent).trigger('change');
            $('input[name="child_number"]', parent).on('change',function () {

                var children = parseInt($(this).val());
                var html = children;
                if (typeof children == 'number') {
                    if (children < 1) {
                        html = $('.render .children', parent).data('text') + ' x ' + children;
                    } else {
                        html = $('.render .children', parent).data('text-multi') + ' x ' + children;
                    }
                }
                $('.render .children', parent).html(html);
            });
            $('input[name="child_number"]', parent).trigger('change');
            $('input[name="infant_number"]', parent).on('change',function () {

                var infant = parseInt($(this).val());
                var html = infant;
                if (typeof infant == 'number') {
                    if (infant < 1) {
                        html = $('.render .infant', parent).data('text') + ' x ' + infant;
                    } else {
                        html = $('.render .infant', parent).data('text-multi') + ' x ' + infant;
                    }
                }
                $('.render .infant', parent).html(html);
            });
            $('input[name="infant_number"]', parent).trigger('change');
        });
        /*Scroll form book*/
        var timeout_fixed_item;
        $(window).on('resize', function () {
            clearTimeout(timeout_fixed_item);
            timeout_fixed_item = setTimeout(function () {
                $('.st-tour-booking', body).each(function () {
                    var t = $(this);
                    var screen = t.data('screen');
                    var width = t.width(),
                            top = t.offset().top;
                    $(window).on('scroll', function () {
                        if ($(window).scrollTop() >= top && window.matchMedia('(min-width: ' + screen + ')').matches) {
                            if (t.css('position') != 'fixed') {
                                if($('#wpadminbar').height()){
                                    var top_height = $('#wpadminbar').height();
                                } else {
                                    top_height = 0;
                                }
                                t.css({
                                    width: width,
                                    position: 'fixed',
                                    top: top_height + 'px',
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
                                    if($('#wpadminbar').height()){
                                        var top_height = $('#wpadminbar').height();
                                    } else {
                                        top_height = 0;
                                    }
                                    t.css({
                                        width: width,
                                        position: 'fixed',
                                        top: top_height + 'px',
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





        /*get height content testionial*/
        $('.st-testimonial-solo-slider', '.st-solo-testimonial-wrapper').each(function () {
            var parent = $(this);
            var height_content = $('.content', parent).innerHeight();
            var margin_top = $('.content', parent).position();
            var top = parseInt(height_content) + parseInt(margin_top.top);
            $('.owl-dots', parent).css("top", top);
        });
        /*popup login mobile*/
        $('.toggle-menu--user').on('click',function (ev) {
            ev.preventDefault();
            $('#st-login-form').modal('toggle');
            $('#st-login-form').modal('show');
        });
        $('.back-menu--login').on('click',function (ev) {
            ev.preventDefault();
            toggleBody($('.header-login--mobile'));
            $('.header-login--mobile').toggleClass('open');
        });
        $('.toggle-menu', '.header').on('click',function (ev) {
            ev.preventDefault();
            toggleBody($('.st-list-mobile'));
            $('.st-list-mobile').toggleClass('open');
        });
        $('.back-menu', '.header').on('click',function (ev) {
            ev.preventDefault();
            toggleBody($('.st-list-mobile'));
            $('.st-list-mobile').toggleClass('open');
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
        body.on('click',function (ev) {
            if ($(ev.target).is('#st-main-menu')) {

                $('.st-list-mobile').toggleClass('open');
            }
        });
        /**/

        $(document).on('click', '.solo-load-more-blog', function () {
            updateQueryStringParam('ppp', $('#solo_load_more_blog').val());
            location.reload();
        });
        $(document).on('change', '.search--blog-solo #cat', function () {
            var $form = $(this).closest('form');
            $form.trigger('submit');
        });
        /*Slide blog about us*/



        /*Slider blog 7*/
        $(window).on('resize',function(){
            $('.st-solo-blog-list').find('.style7').each(function () {
                let t = $(this);
                t.removeClass('row');
                t.addClass('owl-carousel');
                t.owlCarousel({
                    loop: false,
                    responsiveClass: true,
                    nav: false,
                    margin: 30,
                    responsive: {
                        0: {
                            items: 1,
                            nav: false,
                            dots: true,
                        },
                        768: {
                            items: 2,
                        },
                        992: {
                            items: 3,
                            dots:false,
                        },
                        1200: {
                            items: 3,
                        }
                    }
                });
            });
        });
        /*end*/
        /*Slide list image about us*/

        var image_aboutus = undefined;
        $(window).on('resize',function(){
            if (window.matchMedia("(max-width:767px)").matches) {
                $('.st-aboutus-solo').find('.slide-item').each(function () {
                    let t = $(this);
                    t.addClass('owl-carousel');
                    let options = {
                        loop: false,
                        responsiveClass: true,
                        dots: true,
                        nav: false,
                        margin: 15,
                        stagePadding: 40,
                        responsive: {
                            0: {
                                items: 1,
                                nav: false,

                            },
                            576: {
                                items: 1,
                            },
                            767: {
                                items: 1,
                            }
                        }
                    };
                    if(typeof image_aboutus == 'undefined'){
                        let owl = $('.owl-carousel').owlCarousel(options);
                        image_aboutus = t.data('owl.carousel');
                    }else{
                        let owl = $('.owl-carousel').owlCarousel(options);
                        image_aboutus = t.data('owl.carousel');
                    }

                });
            }else{
                $('.slide-item').removeClass('owl-carousel');
                if(typeof image_aboutus == 'object'){
                    image_aboutus.destroy();
                }

            }
        }).trigger('resize');
        /*end*/


        /*Slider Service single*/
        $('.st-list-tour--slide').each(function(){
              $(this).owlCarousel({
                  loop: false,
                  items: 3,
                  margin: 30,
                  responsiveClass: true,
                  dots: false,
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
                          dots:true,
                      },
                      992: {
                          items: 3,
                          margin: 30,
                          dots:false
                      },
                      1200: {
                          items: 3,
                      }
                  }
              });
         });;
        /*end*/
        /*Slide tour destination*/
        $('.st-solo-list-location').find('.list-destination--layout9').each(function () {
            let t = $(this);
            t.addClass('owl-carousel');
            t.removeClass('row');
            // $('.normal-item', t).removeClass('has-matchHeight');
            $('.slider-item', t).removeClass('normal-item');
            var owl = $('.owl-carousel').owlCarousel({
                loop: false,
                responsiveClass: true,
                dots: false,
                nav: false,
                margin: 30,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots: true,
                        margin: 15,
                        stagePadding: 40,
                    },
                    768: {
                        items: 3,
                    },
                    992:{
                        items:4,
                    },
                    1200: {
                        items: 4,
                    }
                }
            });
        });
        /*end*/
        $('.form-slelect-2','.form-icon-fa').select2({
        });
        $(window).on('resize', function () {
            $('.st-tour-content.style7').find('.st-tour-booking').each(function(){
                var t = $(this);
                var screen = t.data('screen');
                var width = t.width(),
                top = t.offset().top;
                $(window).on('scroll',function(){
                    if ($(window).scrollTop() >= top && window.matchMedia('(min-width: ' + screen + ')').matches) {
                        t.addClass('box-shadow-croll');
                    }
                    else{
                        t.removeClass('box-shadow-croll');
                    }
                });
            });
        }).trigger('resize');
    });
})(jQuery);

function setHeight(container, item) {
    jQuery(container).each(function () {
        // Cache the highest
        var highestBox = 0;
        // Select and loop the elements you want to equalise
        jQuery(item, this).each(function () {
            // If this box is higher than the cached highest then store it
            var itemH = jQuery(this).height();
            if (itemH > highestBox) {
                highestBox = itemH;
            }
        });
        // Set the height of all those children to whichever was highest
        jQuery(item, this).height(highestBox);
    });
}
let base = this;
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
jQuery(document.body).on('click', '.caculator-item .fa-plus, .caculator-item .fa-minus', function ($) {
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
    if (jQuery(this).is('.fa-plus')) {
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

jQuery( "body" ).on('click', function(event) {
    var target = jQuery( event.target );
    if (!target.closest(".form-more-extra-solo").length) {
        jQuery('ul#dropdown-more-extra').removeClass("dropdown-menu extras collapse in");
        jQuery('ul#dropdown-more-extra').addClass("dropdown-menu extras collapse");
        jQuery('ul#dropdown-more-extra').attr("aria-expanded",false);
        jQuery('a.dropdown-more-extra').attr("aria-expanded",false);
    }
});
//Hide Daterangepicker when scroll
jQuery(function($){
    $('body').on('mousewheel',function(){
        if($('.daterangepicker.moveleft.opensleft').length){
            $('.daterangepicker.moveleft.opensleft').hide();
        }
    });
});
