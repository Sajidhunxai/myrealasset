jQuery(function($) {
    $('.pickup').on('change', function () {
        var me = $(this);
        if(!$('.drop-off-location').is(':visible')){
            $('.dropoff').val(me.val());
        }
    });
    $('.car-i-check').iCheck({
        checkboxClass: 'car-i-check',
    });
    var list_selected_equipment_load = [];
    $('.st-inbox-form-book-car-js').find('.equipment').each(function (event) {
        if ($(this)[0].checked == true) {
            var num = 1;
            var parent = $(this).closest('.equipment-list');
            if ($('select[name="number_equipment"]', parent).length) {
                num = parseInt($('select[name="number_equipment"]', parent).val());
            }
            list_selected_equipment_load.push({
                title: $(this).attr('data-title'),
                price: str2num($(this).attr('data-price')),
                price_unit: $(this).data('price-unit'),
                price_max: $(this).data('price-max'),
                number_item: num
            });
        }
    });
    $('.st_selected_equipments').val(JSON.stringify(list_selected_equipment_load));
    $('.car-equipment-list .car-equipment').on('ifChanged', function(event) {
        var list_selected_equipment = [];
        var person_ob = new Object();
        $('.st-inbox-form-book-car-js').find('.car-equipment').each(function (event) {
            if ($(this)[0].checked == true) {
                var price = str2num($(this).attr('data-price'));
                var price_max = str2num($(this).attr('data-price-max'));
                var num = 1;
                var parent = $(this).closest('.car-equipment-list');
                if ($('select[name="number_equipment"]', parent).length) {
                    num = parseInt($('select[name="number_equipment"]', parent).val());
                }
                person_ob[$(this).attr('data-title')] = str2num($(this).attr('data-price')) * num;
                list_selected_equipment.push({
                    title: $(this).attr('data-title'),
                    price: str2num($(this).attr('data-price')),
                    price_unit: $(this).data('price-unit'),
                    price_max: $(this).data('price-max'),
                    number_item: num
                });
            }
        });
        $('.data_price_items').val(JSON.stringify(person_ob));
        $('.st_selected_equipments').val(JSON.stringify(list_selected_equipment));
    });
    function str2num(val) {
        val = '0' + val;
        val = parseFloat(val);
        return val;
    }
});
jQuery(function($){
    var body = $('body');
    $('.st-inbox-form-book-car-js', body).each(function () {
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_out = $('.check-in-out', parent),
            pickUpDate = $('input[name=pick-up-date]', parent),
            pickUpTime = $('input[name=pick-up-time]', parent),
            dropOffDate = $('input[name=drop-off-date]', parent),
            dropOffTime = $('input[name=drop-off-time]', parent),
            pickUpDateRender = $('p.pick-up-date-render', parent),
            pickUpTimeRender = $('p.pick-up-time-render', parent),
            dropOffDateRender = $('p.drop-off-date-render', parent),
            dropOffTimeRender = $('p.drop-off-time-render', parent);
        var minimum = check_in_out.data('minimum-day');
        if (typeof minimum !== 'number') {
            minimum = 0;
        }
        let dateFormat = parent.data('format-date') || 'DD/MM/YYYY';
        let timeFormat = parent.data('format-time') || 'hh:mm A';
        var options = {
            timePicker: true,
            autoUpdateInput: false,
            autoApply: true,
            disabledPast: true,
            dateFormat: dateFormat,
            timeFormat: timeFormat,
            widthSingle: 500,
            onlyShowCurrentMonth: true,
            minimumCheckin: minimum,
            classNotAvailable: ['disabled', 'off'],
            enableLoading: true,
            todayHighlight: 1,
            opens: 'left',
            timePicker24Hour: (st_params.time_format == '12h') ? false : true,
        };
        if(typeof availabilityDate != 'undefined'){
            options['minDate'] = availabilityDate;
        }
        if (typeof locale_daterangepicker == 'object') {
            options.locale = locale_daterangepicker;
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                if ( start && end ) {
                    pickUpDate.val(start.format(parent.data('format-date')));
                    pickUpDateRender.html(start.format(parent.data('format-date')));
                    pickUpTime.val(start.format(parent.data('format-time')));
                    pickUpTimeRender.html(start.format(parent.data('format-time')));
                    dropOffDate.val(end.format(parent.data('format-date')));
                    dropOffDateRender.html(end.format(parent.data('format-date')));
                    dropOffTime.val(end.format(parent.data('format-time')));
                    dropOffTimeRender.html(end.format(parent.data('format-time')));
                }
            });
        date_wrapper.on('click', function (e) {
            check_in_out.trigger('click');
        });
    });
});
jQuery(function($) {
    var last_select_clicked=false;
    if ( $('body').find('.option-wrapper.st-option-wrapper-car').length == 0 )
        $('body').append('<div class="option-wrapper st-option-wrapper-car"></div>');
    var t_temp;
    $('.st-location-name-js').each(function(index, el) {
        var form = $(this).parents('form');
        var t = $(this);
        var parent = t.closest('.st-select-wrapper');
        var flag = true;
        $('.option-wrapper',parent).remove();
        t.on('keyup', function(event) {
            t_temp = t;
            last_select_clicked=t;
            if (event.which != 40 && event.which != 38 && event.which != 9) {
                val = $(this).val();
                if (event.which != 13) {
                    flag = false;
                    if( val != '' ){
                        html = '';
                        $('select option', parent).prop('selected', false);
                        $('select option', parent).each(function(index, el) {
                            var country = $(this).data('country');
                            var text = $(this).text();
                            var text_split = text.split("||");
                            text_split = text_split[0];
                            var highlight = get_highlight(text, val);
                            if (highlight.indexOf('</span>') > 0) {
                                var current_country = $(this).parent('select').attr('data-current-country');
                                if (typeof current_country != 'undefined' && current_country != '') {
                                    if (country == current_country) {
                                        html += '<div style="'+ $(this).data('style') +'" data-text="' + text + '" data-country="' + country + '" data-value="' + $(this).val() + '" class="option">' +
                                            '<span class="label"><a href="#">' + text_split + '<i class="fa fa-map-marker"></i></a>' +
                                            '</div>';
                                    }
                                } else {
                                    html += '<div style="'+ $(this).data('style') +'" data-text="' + text + '" data-country="' + country + '" data-value="' + $(this).val() + '" class="option">' +
                                        '<span class="label"><a href="#">' + text_split + '<i class="fa fa-map-marker"></i></a>' +
                                        '</div>';
                                }
                            }
                        });
                        $('.option-wrapper').html(html).show();
                        t.caculatePosition();
                    }else{
                        html = '';
                        $('select option', parent).prop('selected', false);
                        $('select option', parent).each(function(index, el) {
                            var country = $(this).data('country');
                            var text = $(this).text();
                            var text_split = text.split("||");
                            text_split = text_split[0];
                            if (text != '') {
                                var current_country = $(this).parent('select').attr('data-current-country');
                                if (typeof current_country != 'undefined' && current_country != '') {
                                    if (country == current_country) {
                                        html += '<div style="'+ $(this).data('style') +'" data-text="' + text + '" data-country="' + country + '" data-value="' + $(this).val() + '" class="option">' +
                                            '<span class="label"><a href="#">' + text_split + '<i class="fa fa-map-marker"></i></a>' +
                                            '</div>';
                                    }
                                } else {
                                    html += '<div style="'+ $(this).data('style') +'" data-text="' + text + '" data-country="' + country + '" data-value="' + $(this).val() + '" class="option">' +
                                        '<span class="label"><a href="#">' + text_split + '<i class="fa fa-map-marker"></i></a>' +
                                        '</div>';
                                }
                            }
                        });
                        $('.option-wrapper').html(html).show();
                        t.caculatePosition();
                    }
                }
                if (typeof t.data('children') != 'undefined' && t.data('children') != "") {
                    name = t.data('children');
                    $('select[name="' + name + '"]', form).attr('data-current-country', '');
                    $('input[name="drop-off"]', form).val('');
                    $('select[name="' + name + '"] option', form).prop('selected', false);
                }
            }
        });
        t.on('blur', function(event) {
            if (t.data('clear') == 'clear' && $('select option:selected', parent).val() == "") {
                t.val('');
            }
        });
        t.on("focus",function(event) {
        	if(t.data('id') != 'location_origin' && t.data('id') != 'location_destination'){
                last_select_clicked=t;
			}
            html = '';
            $('select option', parent).prop('selected', false);
            $('select option', parent).each(function(index, el) {
                var country = $(this).data('country');
                var text = $(this).text();
                var text_split = text.split("||");
                text_split = text_split[0];
                var activeOption = '';
                if (text != '') {
                    var current_country = $(this).parent('select').attr('data-current-country');
                    if (typeof current_country != 'undefined' && current_country != '') {
                        if (country == current_country) {
                            html += '<div style="'+ $(this).data('style') +'" data-text="' + text + '" data-country="' + country + '" data-value="' + $(this).val() + '" class="option '+ activeOption +'">' +
                                '' + text_split + '<i class="fa fa-map-marker"></i>' +
                                '</div>';
                        }
                    } else {
                        html += '<div  style="'+ $(this).data('style') +'" data-text="' + text + '" data-country="' + country + '" data-value="' + $(this).val() + '" class="option '+ activeOption +'">' +
                            '' + text_split + '<i class="fa fa-map-marker"></i>' +
                            '</div>';
                    }
                }
            });
            if (typeof t.data('parent') != 'undefined' && t.data('parent') != "") {
                name = t.data('parent');
                if ($('select[name="' + name + '"]', form).length) {
                    var val = $('select[name="' + name + '"]', form).parent().find('input.st-location-name-js').val();
                    if (typeof val == 'undefined' || val == '') {
                        t.val('');
                        $('select[name="' + name + '"]', form).parent().find('input.st-location-name-js').trigger('focus');
                    }else{
                        $('.option-wrapper').html(html).show();
                    }
                }
            }else{
                $('.option-wrapper').html(html).show();
            }
            t.caculatePosition();
        });
        $(document).on('click', '.option-wrapper .option', function(event) {
            event.preventDefault();
            if(last_select_clicked.length > 0) {
                var form = last_select_clicked.closest('form');
                var parent = last_select_clicked.closest('.st-select-wrapper');
                flag = true;
                var value = $(this).data('value');
                var text = $(this).text();
                var country = $(this).data('country');
                if (text != "") {
                    last_select_clicked.val(text);
                    $('select option[value="' + value + '"]', parent).prop('selected', true);
                    $('.option-wrapper').html('').hide();
                    // if (typeof t.data('children') != 'undefined' && t.data('children') != "") {
                    //     name = t.data('children');
                    //     $('select[name="' + name + '"]', form).attr('data-current-country', country);
                    // }
                }
            }
        //     last_select_clicked.focusNextInputField();
        });
        $('body').on('click', function(event) {
            if ($(event.target).is('.option-wrapper .option')) return;
            if (!$(event.target).is('.st-location-name-js')) {
                $('.option-wrapper').html('').hide();
            }
        });
        t.caculatePosition=function(){
            if(!last_select_clicked || !last_select_clicked.length) return;
            var wraper = $('.option-wrapper');
            var input_tag = last_select_clicked;
            var offset = parent.offset();
            var top = offset.top + parent.height();
            var width = parent.outerWidth();
            var left = offset.left;
            var right = width/2;
            var z_index = 99999;
            var position = 'absolute';
            if( $('#search-dialog').length ){
                position = 'fixed';
                top = top + wpadminbar - $(window).scrollTop();
                z_index = 99999;
            }
            wraper.css({
                position:position,
                top:top,
                // left:left,
                right: right,
                width:width,
                'z-index': z_index
            });
        };
        $( window ).on('resize', function() {
            t.caculatePosition();
        });
        form.on('submit', function(event) {
            if (t.val() == "" && t.hasClass('required')) {
                t.trigger('focus');
                return false;
            } else {
                if ($('input.required-field').length && $('input.required-field').prop('checked') == true) {
                    var val = $('select[name="location_id_pick_up"] option:selected', form).val();
                    var text = $('input[name="pick-up"]', form).val();
                    $('select[name="location_id_drop_off"] option[value="' + val + '"]', form).prop('selected', true);
                    $('input[name="drop-off"]', form).val(text);
                }
                if ($('input.required-field').length && $('input.required-field').prop('checked') == false && $('input[name="drop-off"]', form).val() == "") {
                    $('input[name="drop-off"]', form).trigger('focus');
                    $('select[name="location_id_drop_off"] option', form).prop('selected', false);
                    return false;
                }
            }
        });
    });
    function get_highlight(text, val) {
        var highlight = text.replace(
            new RegExp(val + '(?!([^<]+)?>)', 'gi'),
            '<span class="highlight">$&</span>'
        );
        return highlight;
    }
    $.fn.focusNextInputField = function() {
        return this.each(function() {
            var fields = $(this).parents('form:eq(0),body').find('button:visible,input:visible,textarea:visible,select:visible');
            var index = fields.index( this );
            if ( index > -1 && ( index + 1 ) < fields.length ) {
                fields.eq( index + 1 ).trigger('focus');
            }
            return false;
        });
    };
});
