(function($) {
  'use strict'
  jQuery(function($) {
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('#header-menu-left').outerHeight();
    var hasScrolled = function() {
      var st = $(window).scrollTop();
      if (Math.abs(lastScrollTop - st) <= delta) return;
      if (st > lastScrollTop && st > navbarHeight || st == 0) {
        $('header#header-menu-left').removeClass('sticky');
      } else {
        if ( st + $(window).height() < $(document).height()) {
          $("header#header-menu-left").addClass('sticky');
        }
      }
      lastScrollTop = st;
    };
    $(window).on('scroll',function(e) {
      didScroll = true;
    });
    setInterval(function() {
      if (didScroll) {
        hasScrolled();
        didScroll = false;
      }
    }, 250);
  });
  //destination form
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
    });
  });
  setTimeout(function () {
    $(window).on('resize',function () {
      $('.st-background-discount-parent').each(function () {
        var parent = $(this);
        var child = $('.st-background-discount',parent);
        var child_height = child.height();
        child.css('margin-top',-child_height/2);
        parent.css('margin-top',child_height/2);
      })
    })
  },500);
  setTimeout(function () {
      $('.st-background-discount-parent').each(function () {
        var parent = $(this);
        var child = $('.st-background-discount',parent);
        var child_height = child.height();
        child.css('margin-top',-child_height/2);
        parent.css('margin-top',child_height/2);
      })
  },500);
  jQuery(function($) {
    $('.stt-instagram-content').each(function () {
      let t = $(this),
          number = t.data('number'),
          name = t.data('name');

      var data =t.serializeArray();
      data.push({
            name: 'number',
            value: number
          }, {
            name: 'name',
            value: name
          },
          {
            name:'action',
            value: t.data('action')
          },
      );
      $.post(st_params.ajax_url, data, function (respon) {
        if (typeof respon == 'object') {
          if (respon.status === 1) {

            $('.stt-list-image',t).html(respon.html);
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
                  items: 6,

                }
              }
            });
          }
        }
      }, 'json');



    });
    $('.single-hotel-list-room.style-3 ').each(function () {
      var t = $(this);

      $('.owl-carousel', t).owlCarousel({
        loop: false,
        items: 3,
        margin: 30,
        responsiveClass: true,
        dots: true,
        nav: true,
        responsive: {
          0: {
            items: 1,

          },
          767: {
            items: 2,

          },
          992: {
            items: 2,
          },
          1200: {
            items: 3,
          }
        }
      });
    });
    $('.field-guest-new').each(function () {
        var t = $(this);

        $('.dropdown-menu',t).on('click',function (ev) {
            ev.stopPropagation();
            var c = $(this);
            var adult_number = $('input[name="adult_num_search"]',c).val();
            var child_number = $('input[name="children_num_search"]',c).val();
            var adult_html = adult_number;
            var child_html = child_number;
            if (adult_number < 2) {
                adult_html = adult_number + ' ' + $('.dropdown .render .adult', t).data('text');
            } else {
                adult_html = adult_number + ' ' + $('.dropdown .render .adult', t).data('text-multi');
            }
            if (child_number < 2) {
                child_html = child_number + ' ' + $('.dropdown .render .children', t).data('text');
            } else {
                child_html = child_number + ' ' + $('.dropdown .render .children', t).data('text-multi');
            }
            $('.dropdown .render .adult',t).html(adult_html);
            $('.dropdown .render .children',t).html(child_html);

        })
    });
  });

})(jQuery);
(function($) {
  'use strict'
  jQuery(function($) {
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('#header-style-3').outerHeight();
    var hasScrolled = function() {
      var st = $(window).scrollTop();
      if (Math.abs(lastScrollTop - st) <= delta) return;
      if (st > lastScrollTop && st > navbarHeight || st == 0) {
        $('header#header-style-3').removeClass('sticky');
      } else {
        if ( st + $(window).height() < $(document).height()) {
          $("header#header-style-3").addClass('sticky');
        }
      }
      lastScrollTop = st;
    };
    $(window).on('scroll',function(e) {
      didScroll = true;
    });
    setInterval(function() {
      if (didScroll) {
        hasScrolled();
        didScroll = false;
      }
    }, 250);
  })
})(jQuery);

(function($) {
  'use strict'
  let body = $('body');
  let divAsideMenuLeft = $('aside.aside-menu-left');
  let btnToggleMenuLeft = $('header .btn-toggle-menu-left');
  let btnToggleCloseMenuLeft = $('aside .btn-toggle-close-menu-left');

  function toggleBody(el) {
    if (! body.hasClass('overflow-visible'))
      body.toggleClass('overflow-visible');
    $('body').css({
      'overflow': 'visible'
    });
  }

  btnToggleMenuLeft.on('click', function(e) {
    e.preventDefault();
    toggleBody(divAsideMenuLeft);
    divAsideMenuLeft.toggleClass('open');
  });
  btnToggleCloseMenuLeft.on('click', function(e) {
    toggleBody(divAsideMenuLeft);
    divAsideMenuLeft.toggleClass('open');
    e.preventDefault();
  });
  body.on('click',function (ev) {
    if ($(ev.target).is('aside.aside-menu-left')) {
      toggleBody($(ev.target));
      body.addClass('overflow-visible')
      divAsideMenuLeft.removeClass('open');
    }
  });

  let hotelActivityListRoom = $('.hotel-activity-list-room.style-2');
  hotelActivityListRoom.find('.ico-next').on('click', function(e) {
    if (hotelActivityListRoom.find('.nav-tabs > li:nth-last-child(2)').hasClass('active')) {
      hotelActivityListRoom.find('.nav-tabs > li').first('li').find('a').trigger('click');
    } else {
      hotelActivityListRoom.find('.nav-tabs > .active').next('li').find('a').trigger('click');
    }
  });
})(jQuery)
