jQuery(function ($) {
    $('.user-role-wrap #role').on('change', function () {
        var $value = $(this).val();
        if ($value == "partner") {
            $("#partner_service").show()
        } else {
            $("#partner_service").hide()
        }
    });
    $('.st_datepicker, .st_datepicker_withdrawal').each(function () {
        $(this).datepicker({dateFormat: 'yy/mm/dd',language: st_params.locale || '',})
    });
    if ($('.st-select-loction').length) {
        $('.st-select-loction').each(function (index, el) {
            var parent = $(this);
            var input = $('input[name="search"]', parent);
            var list = $('.list-location-wrapper', parent);
            var timeout;
            input.on('keyup', function (event) {
                clearTimeout(timeout);
                var t = $(this);
                timeout = setTimeout(function () {
                    var text = t.val().toLowerCase();
                    if (text == '') {
                        $('.item', list).show()
                    } else {
                        $('.item', list).hide();
                        $(".item", list).each(function () {
                            var name = $(this).data("name").toLowerCase();
                            var reg = new RegExp(text, "g");
                            if (reg.test(name)) {
                                $(this).show()
                            }
                        })
                    }
                }, 100)
            })
        })
    }
    $('body').on('click', '#add-destination-image', function () {
        var parent = $(this).closest('.form-field');
        var field_id = $(this).parent().find('input').attr('id'),
            btnContent = '';
        if (window.wp && wp.media) {
            window.ot_media_frame = window.ot_media_frame || new wp.media.view.MediaFrame.Select({
                title: $(this).attr('title'),
                button: {
                    text: $(this).attr('data-upload-text')
                },
                multiple: false
            });
            window.ot_media_frame.on('select', function () {
                var attachment = window.ot_media_frame.state().get('selection').first(),
                    href = attachment.attributes.url,
                    attachment_id = attachment.attributes.id,
                    mime = attachment.attributes.mime,
                    regex = /^image\/(?:jpe?g|png|gif|x-icon)$/i;
                if (mime.match(regex)) {
                    btnContent += '<img src="' + href + '" alt="" />';
                }
                $('#' + field_id).val(attachment_id);
                $('.destination-image', parent).html(btnContent).slideDown();
                window.ot_media_frame.off('select');
            }).open();
        }
        return false;
    });
    var ST_Gallery = {
        avatar:function (t) {
            if (window.wp && wp.media) {
                window.st_media_frame = window.st_media_frame || new wp.media.view.MediaFrame.Select({
                    title: t.attr('title'),
                    button: {
                        text: t.data('text')
                    },
                    multiple: false
                });
                window.st_media_frame.on('select', function () {
                    var attachment = window.st_media_frame.state().get('selection').first(),
                        attachment_id = attachment.attributes.id,
                        mime = attachment.attributes.mime,
                        regex = /^image\/(?:jpe?g|png|gif|svg\+xml|x-icon)$/i;
                    if (mime.match(regex)) {
                        parent = t.closest('form');
                        var data =parent.serializeArray();
                        data.push({
                                name: 'security',
                                value: st_params.security
                            }, {
                                name: 'attachment_id',
                                value: attachment_id
                            },
                            {
                                name:'action',
                                value:'st_dashboard_change_avatar'
                            },
                        );
                        $.post(ajaxurl, data, function (respon) {
                            if (typeof respon == 'object') {
                                if (respon.status === 1) {
                                    $('input[name="upload_value"]', parent).val(respon.avatar);
                                    $('.stt-edit-avatar', parent).html(respon.url);
                                }
                            }
                        }, 'json');
                    }
                    window.st_media_frame.off('select');
                }).open();
            }
        }
    };
    $(document).on('click.', '.stt-update-avatar', function (e) {
        e.preventDefault();
        ST_Gallery.avatar($(this))
    });

    $('.st_pt_location_2').each(function(){
        var me=$(this);
        $(this).select2({
            placeholder: me.data('placeholder'),
            minimumInputLength:2,
            allowClear: true,
            ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: term, // search term,
                    action:'st_post_select_ajax',
                    post_type:me.data('post-type'),
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                results: data.items,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
                };
            },
            cache: true
            },
            placeholder: 'Search for a repository',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    });

    function formatRepo (repo) {
        if (repo.loading) {
        return repo.text;
        }

        // var $container = $(
        //   "<div class='select2-result-repository clearfix'>" +
        //     "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
        //     "<div class='select2-result-repository__meta'>" +
        //       "<div class='select2-result-repository__title'></div>" +
        //       "<div class='select2-result-repository__description'></div>" +
        //       "<div class='select2-result-repository__statistics'>" +
        //         "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
        //         "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
        //         "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
        //       "</div>" +
        //     "</div>" +
        //   "</div>"
        // );

        // $container.find(".select2-result-repository__title").text(repo.full_name);
        // $container.find(".select2-result-repository__description").text(repo.description);
        // $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
        // $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
        // $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");

        // return $container;
    }

    function formatRepoSelection (repo) {
        return repo.full_name || repo.text;
    }
    if($.fn.tinymce && ($('#content-template-email').length)){
        tinymce.init({
            selector: 'textarea#content-template-email',
            plugins: 'code visualblocks visualchars image link media table hr anchor insertdatetime textcolor colorpicker',
            menubar: 'file edit view insert format tools table help',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            relative_urls : true,
            convert_urls: false,
            remove_script_host : false,
            theme: 'modern',
            inline: false,
            height: 500,
        });
    }
    
});
