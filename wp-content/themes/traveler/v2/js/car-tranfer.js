/*Carstranfer*/
jQuery(function($) {
  var st_with_search_location_transfer = $(
    ".tab-pane.active#st_cartranfer .destination-pickup-carstranfer"
  ).outerWidth();
  $("#transfer_from")
    .select2()
    .on("select2:open", function() {
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
    .on("select2:open", function() {
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
  $(document).on("select2:open", "select#transfer_from", function() {
    setTimeout(function() {
      if ($(".select2-result").length) {
        $(".select2-result")
          .getNiceScroll()
          .resize();
      }
    }, 1000);
  });
  $(document).on("select2:open", "select#transfer_to", function() {
    var st_with_search_location_transfer = $(
      ".tab-pane.active#st_cartranfer .destination-pickup-carstranfer"
    ).outerWidth();

    setTimeout(function() {
      if ($(".select2-dropdown .select2-result").length) {
      }
    }, 1000);
  });
  $(".select2-result").each(function() {
    $(this).niceScroll();
  });

  $("select#transfer_from").on("change", function(e) {
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
  $("select#transfer_to").on("change", function(e) {
    var parent_from = $(this).closest(".field-destination-carstranfer");

    var car_from_value = this.value;
    var data = $("#transfer_to").select2("data");
    if (data) {
      var car_from_name = data[0].text;
      car_from_name = $.trim(car_from_name);
    }
    console.log(car_from_name);
    var from = parent_from.find("#dropdown-dropoff .render .destination");
    from.text(car_from_name);
  });

  $(
    ".search-result-page .search-form-wrapper .search-form .field-destination-carstranfer .destination-pickup"
  ).on("click", function(e) {
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
  $(".modern-search-result").each(function() {
    $(this).on("click", function(e) {
      if ($(e.target).is(".st_click_choose_service")) {
        let btnClick = $(e.target);
        var st_item_modal = btnClick.closest(".item-service-car");
        st_item_modal
          .find(".sroom-extra-service .st-tooltip")
          .toggleClass("show-modal");
        var st_modal = st_item_modal.find(".sroom-extra-service .st-tooltip");
      }
      if ($(e.target).is(".st-close-button i")) {
        let btnClickClose = $(e.target);
        var st_item_modal = btnClickClose.closest(".item-service-car");
        st_item_modal
          .find(".sroom-extra-service .st-tooltip")
          .toggleClass("show-modal");
        st_item_modal
          .find(".sroom-extra-service .st-tooltip")
          .removeClass("show-modal");
      }
    });
  });

  $(".modern-search-result").each(function() {
    $(this).on("click", function(e) {
      if ($(e.target).is(".st_click_choose_passenger")) {
        let btnClick = $(e.target);
        var st_item_modal = btnClick.closest(".item-service-car");
        st_item_modal
          .find(".sroom-passenger .st-tooltip")
          .toggleClass("show-modal");
        var st_modal = st_item_modal.find(".sroom-passenger .st-tooltip");
      }
      if ($(e.target).is(".st-close-button i")) {
        let btnClickClose = $(e.target);
        var st_item_modal = btnClickClose.closest(".item-service-car");
        st_item_modal
          .find(".sroom-passenger .st-tooltip")
          .toggleClass("show-modal");
        st_item_modal
          .find(".sroom-passenger .st-tooltip")
          .removeClass("show-modal");
      }
    });
  });

  //Return
  $(".modern-search-result").each(function() {
    $(this).on("click", function(e) {
      if ($(e.target).is(".st_click_choose_return")) {
        let btnClick = $(e.target);
        var st_item_modal = btnClick.closest(".item-service-car");
        st_item_modal
          .find(".sroom-return .st-tooltip")
          .toggleClass("show-modal");
        var st_modal = st_item_modal.find(".sroom-return .st-tooltip");
      }
      if ($(e.target).is(".st-close-button i")) {
        let btnClickClose = $(e.target);
        var st_item_modal = btnClickClose.closest(".item-service-car");
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
	$('.modern-search-result', body).on('change', function() {
		loadDateRangePicker()
	})

	function loadDateRangePicker() {
		var body = $("body.page-template-template-transfer-search");
		$(".item-service.item-service-car", body).each(function() {
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

      button_date.on('click',function(){
        $('.page-template-template-transfer-search .st-popup.popup-date').show();
        button_date.trigger('show.daterangepicker');
      });
      button_date.daterangepicker(options, function(start, end, label) {
        $(".page-template-template-transfer-search .st-popup.popup-date").hide();
        time_start.val(start.format(parent.data('time-format')));
        button_date.html(start.format(parent.data('date-format')) + " " + start.format(parent.data('time-format')));
        date_start.val(start.format(parent.data('date-format')));
      });
    });
  }
});
