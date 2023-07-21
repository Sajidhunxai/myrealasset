;(function ($) {
    'use strict'
    $(window).on('elementor:init', () => {
        var select2AjaxItemView = elementor.modules.controls.BaseData.extend({
            ajax: null,
            ui: function () {
                var ui = elementor.modules.controls.BaseData.prototype.ui.apply(this, arguments);

                _.extend(ui, {
                    select: 'select.st-select2-control',
                });

                return ui;
            },
            events: function () {
                return {
                    'change @ui.select': 'onChange',
                    'input @ui.select': 'onChange',
                };
            },
            setInputValue: function (input, value) {
                this.setSettingsModel(value);
            },
            onChange: function (event) {
                let value = this.ui.select.val();
                let tmp = [];
                if (Array.isArray(value)) {
                    value.forEach((item, index) => {
                        let text = $('option[value="' + item + '"]', this.ui.select).text();
                        if (typeof text == 'string' && text !== '') {
                            tmp.push(item + '::' + text);
                        }
                    });
                    tmp = tmp.join(';;');
                    this.setSettingsModel(tmp);
                } else {
                    let text = $('option[value="' + value + '"]', this.ui.select).text();
                    if (typeof text == 'string' && text !== '') {
                        text = value + '::' + text;
                        this.setSettingsModel(text);
                    } else {
                        this.setSettingsModel(value);
                    }
                }
            },
            getControlValue: function () {
                return this.container.settings.get(this.model.get('name'));
            },
            onRender: function () {
                elementor.modules.controls.BaseData.prototype.onRender.apply(this, arguments);
                this.applySavedValue();
                var base = this;
                base.choose(base.ui.select);
                this.triggerMethod('ready');
            },
            choose: function ($inputs) {
                let base = this;
                let timeOut;
                $inputs.each(function () {
                    let t = $(this);
                    let select2 = t.select2({
                        allowClear: t.data('allow-clear') || true,
                        closeOnSelect: t.data('close-on-select') || true,
                        multiple: t.data('multiple'),
                        tag: true,
                        ajax: {
                            url: st_elementor_params.ajaxurl,
                            dataType: 'json',
                            method: 'GET',
                            delay: t.data('delay'),
                            data: function (params) {
                                return {
                                    s: params.term,
                                    post_type: t.data('post-type'),
                                    security: st_elementor_params.security,
                                    action: 'st_select2_ajax',
                                    callback: t.data('callback'),
                                };
                            },
                            processResults: function (data, params) {
                                return {
                                    results: data.results
                                };
                            },
                            cache: t.data('cache') || false
                        },
                        placeholder: t.data('placeholder'),
                        minimumInputLength: t.data('minimum-character'),
                    });

                    // On select, place the selected item in order
                    select2.on('select2:select', function (ev) {
                        if (ev.params && ev.params.data && ev.params.data.id != 'undefined') {
                            var id = ev.params.data.id;
                            var option = $(ev.target).children('[value=' + id + ']');

                            if (option) {
                                option.detach();
                                $(ev.target).append(option).trigger('change');
                            }
                        }
                    });

                    let old_value = base.container.settings.get(base.model.get('name'));
                    if (typeof old_value == 'string' && old_value !== '') {
                        let old_value_convert = old_value.split(';;');
                        if (Array.isArray(old_value_convert)) {
                            old_value_convert.forEach((item, index) => {
                                item = item.split("::");
                                let option = '<option selected value="' + item[0] + '">' + item[1] + '</option>';
                                t.append(option);
                            })
                        } else {
                            let item = old_value.split("::");
                            let option = '<option selected value="' + item[0] + '">' + item[1] + '</option>';
                            t.append(option);

                        }
                        t.trigger('change');
                    }
                });
            },
        });

        elementor.addControlView('select2_ajax', select2AjaxItemView);
    });

})(jQuery);
