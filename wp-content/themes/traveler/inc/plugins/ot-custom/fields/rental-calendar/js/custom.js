jQuery(function($) {
  $(".date-picker").datepicker({
    language: st_params.locale || "",
    dateFormat: st_params.dateformat_convert || "mm/dd/yy",
    firstDay: 1
  });

  var RentalCalendar = function(container) {
    var self = this;
    this.container = jQuery(container);
    this.calendar = null;
    this.fullCalendar;
    this.timeOut;
    this.form_container = null;
    this.fullCalendarOptions = {
      initialView: 'dayGridMonth',
      firstDay: 1,
      locale: st_params.locale_fullcalendar,
      timeZone: st_timezone.timezone_string,
      customButtons: {
        reloadButton: {
          text: st_params.text_refresh,
          click: function() {
            self.fullCalendar.refetchEvents();
          }
        }
      },
      headerToolbar: {
        start: 'today,reloadButton',
        center: 'title',
        end: 'prev,next'
      },
      displayEventTime: true,
      selectable: true,
      select: function({start, end, startStr, endStr, allDay, jsEvent, view, resource}) {/* info{start, end, startStr, endStr, allDay, jsEvent, view, resource } */
        if (moment(start).isBefore(moment(), 'day')
          || moment(end).isBefore(moment(), 'day')
        ) {
          self.fullCalendar.unselect();
          setCheckInOut("", "", self.form_container);
        } else {
          var zone = moment(start).format("Z");
          zone = zone.split(":");
          zone = "" + parseInt(zone[0]) + ":00";
          var check_in = moment(start).utcOffset(zone).format( String(st_params.dateformat || "MM/DD/YYYY").toUpperCase());
          var	check_out = moment(end).utcOffset(zone).subtract(1, 'day').format( String(st_params.dateformat || "MM/DD/YYYY").toUpperCase());
          setCheckInOut(check_in, check_out, self.form_container);
        }
      },
      events: function({start, end, startStr, endStr, timeZone}, successCallback, failureCallback) {
        $.ajax({
          url: ajaxurl,
          dataType: "json",
          type: "post",
          data: {
            action: "st_get_availability_rental",
            post_id: $(self.container).data("post-id"),
            start: moment(start).unix(),
            end: moment(end).unix()
          },
          success: function(doc) {
            if (typeof doc == "object") {
              successCallback(doc);
            }
          },
          error: function(e) {
            alert(
              "Can not get the availability slot. Lost connect with your sever"
            );
          }
        });
      },
      eventContent: function(arg) { /** arg{event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view} */
        let italicEl = document.createElement('i');
        let contentEl = document.createElement('div');
        let priceEl = document.createElement('div');
        let startTimeEl = document.createElement('div');
        contentEl.classList.add('fc-content');
        priceEl.classList.add('price');
        startTimeEl.classList.add('starttime');

        let price = 0;
        if (typeof arg.event.extendedProps.price != 'undefined') {
          price = arg.event.extendedProps.price;
        }
        priceEl.innerHTML = (st_params.text_price || 'Price: ') + price;
        contentEl.appendChild(priceEl);

        if (arg.event.extendedProps.status) {
          // available, unavailable
          let status = arg.event.extendedProps.status;
          if (status === 'unavailable') {
            contentEl.classList.remove('available');
            contentEl.classList.add('unavailable');
          } else {
            contentEl.classList.remove('unavailable');
            contentEl.classList.add('available');
          }
        }

        if (arg.event.extendedProps.starttime) {
          let arrStartTime = arg.event.extendedProps.starttime.split(',');
        }

        let arrayOfDomNodes = [ contentEl ]
        return { domNodes: arrayOfDomNodes }
      },
      viewDidMount: function(arg) {
        if (arg.el) {
          let el = arg.el;
          if (self.timeOut) { clearTimeout(self.timeOut); }
          self.timeOut = setTimeout(function() {
            let viewHardnessEl = $(el).closest('.fc-view-harness.fc-view-harness-active');
            if (viewHardnessEl && viewHardnessEl.outerHeight() == 0) {
              viewHardnessEl.css({minHeight: '250px'});
            }
          }, 400);
        }
      },
      eventClick: function({event, el, jsEvent, view}) {
        let startTime = moment(event.start, String(st_params.dateformat || "MM/DD/YYYY").toUpperCase())
          .format(String(st_params.dateformat || 'MM/DD/YYYY').toUpperCase());
        let endTime;
        if (event.end) {
          endTime = moment(event.end, String(st_params.dateformat || "MM/DD/YYYY").toUpperCase())
            .format(String(st_params.dateformat || 'MM/DD/YYYY').toUpperCase());
        } else {
          endTime = startTime;
        }
        setCheckInOut(
          startTime,
          endTime,
          self.form_container
        );
        if (typeof event.extendedProps.price != 'undefined') {
          $("#calendar_price", self.form_container).val(event.extendedProps.price);
        }
        if (event.extendedProps.status) {
          $(
            "#calendar_status option[value=" + event.extendedProps.status + "]",
            self.form_container
          ).prop("selected");
        }
      },
      loading: function(isLoading) {
        if (isLoading) {
          $(".overlay", self.container).addClass("open");
        } else {
          $(".overlay", self.container).removeClass("open");
        }
      },
    };
    this.init = function() {
      self.container = container;
      self.calendar = container.querySelector('.calendar-content');
      self.form_container = $(".calendar-form", self.container);
      setCheckInOut("", "", self.form_container);
      self.initCalendar();
    };
    this.initCalendar = function() {
      if (typeof FullCalendar != 'undefined') {
        self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
        self.fullCalendar.render();
      }
    };
  };
  function setCheckInOut(check_in, check_out, form_container) {
    $("#calendar_check_in", form_container).val(check_in);
    $("#calendar_check_out", form_container).val(check_out);
  }
  function resetForm(form_container) {
    $("#calendar_check_in", form_container).val("");
    $("#calendar_check_out", form_container).val("");
    $("#calendar_price", form_container).val("");
    $("#calendar_priority", form_container).val("");
    $("#calendar_number", form_container).val("");
  }
  $(function() {
    $(".calendar-wrapper").each(function(index, el) {
      var t = $(this);
      var rental = new RentalCalendar(el);
      var flag_submit = false;

      $("#calendar_submit", t).on('click', function(event) {
        var data = $("input, select", ".calendar-form").serializeArray();
        data.push({
          name: "action",
          value: "st_add_custom_price_rental"
        });
        $(".form-message", t)
          .attr("class", "form-message")
          .find("p")
          .html("");
        $(".overlay", self.container).addClass("open");
        if (flag_submit) return false;
        flag_submit = true;
        $.post(
          ajaxurl,
          data,
          function(respon, textStatus, xhr) {
            if (typeof respon == "object") {
              if (respon.status == 1) {
                resetForm(t);
                if (rental.fullCalendar) {
                  rental.fullCalendar.refetchEvents();
                }
              } else {
                $(".form-message", t)
                  .addClass(respon.type)
                  .find("p")
                  .html(respon.message);
                $(".overlay", self.container).removeClass("open");
              }
            } else {
              $(".overlay", self.container).removeClass("open");
            }
            flag_submit = false;
          },
          "json"
        );
        return false;
      });

      $('.calendar-content', t).on('refetchEvents', function() {
        if (rental.fullCalendar) {
          rental.fullCalendar.refetchEvents();
        }
      });

      var rental_groupday = $('input[name="allow_group_day"]:checked').val();
      if (rental_groupday == "on") {
        $(".calendar-wrapper .is_groupday").show();
      } else {
        $(".calendar-wrapper .is_groupday").hide();
      }
      $(document).on(
        "click",
        '.ui-tabs-anchor[href="#setting_availability_tab"]',
        function() {
          rental.init();
          var rental_groupday = $(
            'input[name="allow_group_day"]:checked'
          ).val();
          if (rental_groupday == "on") {
            $(".calendar-wrapper .is_groupday").show();
          } else {
            $(".calendar-wrapper .is_groupday").hide();
          }
        }
      );
      $("body").on("calendar.change_month", function(event, value) {
        var date = rental.fullCalendar.getDate();
        var month = date.format("M");
        date = date.add(value - month, "M");
        rental.fullCalendar.gotoDate(date.format('YYYY-MM-DD'));
      });
    });
  });
});
