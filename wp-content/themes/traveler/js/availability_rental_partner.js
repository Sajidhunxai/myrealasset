jQuery(function($) {
    if ($(".st_partner_avaiablity.edit-rental").length < 1) return;
    $('.date-picker').datepicker({
        language: st_params.locale || '',
        format: dashboard_params.dateformat_convert,
        weekStart: 1
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
            var check_in = moment(start).utcOffset(zone).format( String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
            var	check_out = moment(end).utcOffset(zone).subtract(1, 'day').format( String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase());
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
                start: moment(start.valueOf()).unix(),
                end: moment(end.valueOf()).unix()
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
            let startTime = moment(event.start, String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase())
              .format(String(dashboard_params.dateformat || 'MM/DD/YYYY').toUpperCase());
            let endTime;
            if (event.end) {
              endTime = moment(event.end, String(dashboard_params.dateformat || "MM/DD/YYYY").toUpperCase())
                .format(String(dashboard_params.dateformat || 'MM/DD/YYYY').toUpperCase());
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
              $(".overlay-form", self.container).show();
            } else {
              $(".overlay-form", self.container).hide();
            }
          },
        };
        this.init = function() {
          self.container = container;
          self.calendar = container.querySelector('#calendar-content');
          self.form_container = $(".calendar-form", self.container);
          setCheckInOut("", "", self.form_container);
          self.initCalendar();
        };
        this.initCalendar = function() {
          if (typeof FullCalendar) {
            self.fullCalendar = new FullCalendar.Calendar(self.calendar, self.fullCalendarOptions);
            self.fullCalendar.render();
          }
        };
      };
    function setCheckInOut(check_in, check_out, form_container) {
        $('#calendar_check_in', form_container).val(check_in);
        $('#calendar_check_out', form_container).val(check_out)
    }
    function resetForm(form_container) {
        $('#calendar_check_in', form_container).val('');
        $('#calendar_check_out', form_container).val('');
        $('#calendar_price', form_container).val('');
        $('#calendar_priority', form_container).val('');
        $('#calendar_number', form_container).val('')
    }
    jQuery(function($) {
        if ($('a[href="#availablility_tab"], ul li[data-step="#step_availablility"]').length) {
            $('a[href="#availablility_tab"], ul li[data-step="#step_availablility"]').on('click', function(event) {
                setTimeout(function() {
                    $('#calendar-content', '.calendar-wrapper').fullCalendar('today')
                }, 1000)
            })
        }
        if ($('#form-bulk-edit').length) {
            $('#calendar-bulk-close').on('click', function (event) {
                $(this).closest('#form-bulk-edit').fadeOut();
                $(this).closest('.calendar-wrapper').find('#calendar-content').trigger('refetchEvents')
            })
        }
        $('.calendar-wrapper').each(function(index, el) {
            var t = $(this);
            var rental = new RentalCalendar(el);

            var flag_submit = false;
            $('#calendar_submit', t).on('click', function(event) {
                var data = $('input, select', '.calendar-form').serializeArray();
                data.push({
                    name: 'action',
                    value: 'st_add_custom_price_rental'
                });
                $('.form-message', t).attr('class', 'form-message').find('p').html('');
                $('.overlay-form', self.container).show();
                if (flag_submit) return false;
                flag_submit = true;
                $.post(ajaxurl, data, function(respon, textStatus, xhr) {
                    if (typeof respon == 'object') {
                        if (respon.status == 1) {
                            resetForm(t);
                            rental.init();
                            if (rental.fullCalendar) {
                                rental.fullCalendar.refetchEvents();
                            }
                        } else {
                            $('.form-message', t).addClass(respon.type).find('p').html(respon.message);
                            $('.overlay-form', self.container).hide();
                        }
                    } else {
                        $('.overlay-form', self.container).hide();
                    }
                    flag_submit = false;
                }, 'json');
                return false;
            });
            $('#calendar-content', t).on('refetchEvents', function() {
                rental.init();
                if (rental.fullCalendar) {
                    rental.fullCalendar.refetchEvents();
                }
            });
            $('body').on('calendar.change_month', function(event, value){
                rental.init();
            	var date = rental.calendar.fullCalendar('getDate');
            	var month = date.format('M');
            	date = date.add(value-month, 'M');
            	rental.calendar.fullCalendar( 'gotoDate', date.format('YYYY-MM-DD') );
            });
            $('a[href="#availability"]').on('click',function(){
              rental.init();
              if (rental.fullCalendar) {
                rental.fullCalendar.refetchEvents();
              }
            });
        })
    });
    function get_tinymce_content(id) {
        var content = '';
        var inputid = id;
        var textArea = jQuery('textarea#' + inputid);
        if (textArea.length>0 && textArea.is(':visible')) {
            content = textArea.val();
        } else {
            if(typeof tinyMCE != 'undefined'){
                var editor = tinyMCE.get(inputid);
                content = editor.getContent();
            }
        }
        return content;
    }
    $('.st-btn-continue,.st-create-service-content.add .nav-tabs li ').on('click',function (e) {
        e.preventDefault();
        var clickTab = $(this).index();

        var currentTab = $(this).closest('.nav-tabs').find('li.active').index();

        var obj = $(this).data('obj');
        if(obj === 'button'){
            currentTab =  $('.st-create-service-content .nav-tabs li.active').index();
            clickTab = $('.st-create-service-content .nav-tabs li.active').index() + 1;
        }

        if(clickTab > currentTab) {
            e.stopPropagation();

            if(clickTab - currentTab !== 1)
                return;

            $('.tab-content, .st-partner-action').addClass('loading');

            var data = $('.st-create-service-content .tab-content .tab-pane.active .st-partner-create-form').serializeArray();

            var currentForm = $('.st-create-service-content .tab-content .tab-pane.active .st-partner-create-form');

            data.push({
                name: '_s',
                value: st_params._s
            });
            for (var i = 0; i < Object.keys(data).length; i++){
                if(data[i]['name'] === 'st_content'){
                    data[i]['value'] =  get_tinymce_content('st_content');
                    break;
                }
            }
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'url': st_params.ajax_url,
                'data': data,
                success: function (data) {
                    if (!data.status) {
                        $('.st-create-service-content .nav-tabs li.active').removeClass('success');
                        $('.st-partner-field-item').removeClass('error');
                        $('.st-partner-field-item').find('.st_field_msg').html('');
                        $.each(data.err, function (key, value) {
                            currentForm.find('.st-partner-field[name="' + key + '"]').closest('.st-partner-field-item').addClass('error');
                            currentForm.find('.st-partner-field[name="' + key + '"]').closest('.st-partner-field-item').find('.st_field_msg').html('<div class="alert alert-danger">' + value + '</div>');
                        });
                        window.scroll({
                            top: currentForm.find('.st-partner-field-item.error').first().offset().top - 50,
                            left: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        if(data.next_step != 'final') {
                            $('.st-partner-field-item').removeClass('error');
                            $('.st-partner-field-item').find('.st_field_msg').html('');
                            window.location.hash = '#post_id=' + data.post_id + '&step=' + data.next_step;
                            $('.st-partner-input-post-id').val(data.post_id);

                            //Next Tab
                            $('.st-create-service-content .nav-tabs li.active').addClass('success');
                            $('.st-create-service-content .nav-tabs li').removeClass('active').eq((data.next_step - 1)).addClass('active');
                            $('.st-create-service-content .tab-content .tab-pane').removeClass('active').eq((data.next_step - 1)).addClass('active');


                            var totalTabs = $('.st-create-service-content .nav-tabs li').length;
                            if (data.next_step > 1) {
                                $('.st-btn-back').show();
                            } else {
                                $('.st-btn-back').hide();
                            }

                            if (data.next_step == totalTabs) {
                                if($('.st-btn-continue').data('status') === 'new'){
                                    $('.st-btn-continue').find('span').text(dashboard_params.complete_registration_text);
                                }else{
                                    $('.st-btn-continue').find('span').text(dashboard_params.complete_text);
                                }
                                $('.st-btn-back').show();
                            } else {
                                $('.st-btn-continue').find('span').text(dashboard_params.continue_text);
                                $('.st-btn-back').show();
                            }

                            window.scroll({
                                top: $('.st-create-service-content .nav-tabs').first().offset().top - 50,
                                left: 0,
                                behavior: 'smooth'
                            });

                            if(data.next_step_name === 'policy'){
                                if($('.st-inventory').length) {
                                    var body = $('body');
                                    var inventory = $('.st-inventory', body).wpInventory();
                                    var inventory_data = inventory.data('Inventory');
                                    var start = moment().format();
                                    var end = moment().add(30, 'days').format();
                                    var data = {
                                        'action': 'st_fetch_inventory',
                                        'start': moment(start).format("YYYY-MM-DD"),
                                        'end': moment(end).format("YYYY-MM-DD"),
                                        'post_id': $('.st-inventory', body).data('id')
                                    };
                                    inventory_data.render(start, end, ajaxurl, data);
                                }
                            }
                            if(typeof data.sc !== 'undefined') {
                                $('.calendar-wrapper').each(function(index, el) {

                                    if($('#availability').hasClass('active')){
                                        var rental = new RentalCalendar(el);
                                        rental.init();

                                    }
                                });
                            }
                        }else{
                            window.location.href = data.linkEdit;
                        }
                    }
                },
                complete: function (xhr, status) {
                    $('.tab-content, .st-partner-action').removeClass('loading');
                },
                error: function (data) {

                }
            })
        }else if(clickTab == ($('.st-create-service-content .nav-tabs li').length - 1)){
            if($('.st-btn-continue').data('status') === 'new'){
                $('.st-btn-continue').find('span').text(dashboard_params.complete_registration_text);
            }else{
                $('.st-btn-continue').find('span').text(dashboard_params.complete_text);
            }

            $('.st-btn-back').show();
        }else{
            $('.st-btn-continue').find('span').text(dashboard_params.continue_text);
            if(clickTab == 0) {
                $('.st-btn-back').hide();
            }else{
                $('.st-btn-back').show();
            }
        }
    });
})
