/**
 * Created by MSI on 23/11/2015.
 */
var package_name = '',
required_library = '',
builder = '';
jQuery(function($){
    $('.st-quick-install-demo').on('click', function(){
        $('#required_install_library').empty();
        $('.st-agree').removeAttr( 'style' );
        package_name =$(this).data('demo-id');
        required_library =$(this).data('required-library');
        builder =$(this).data('style');
       $(".st-tooltip#popup-demo-1")
          .toggleClass("show-modal");
        if(required_library == true || builder !=='elementor'){
        }else {
            console.log(window.location);
            $('#required_install_library').html(st_import_localize.check_install_library_message);
            $('.st-agree').css({'cursor': 'no-allowed', 'pointer-events': 'none' , 'opacity' : 0.6});
        }
    //    do_import(package_name);
    });
    $(".traveler-demo-themes").each(function() {
        $(this).on("click", function(e) {
            if ($(e.target).is(".st-cancel")) {
                $(e.target).closest(".st-tooltip")
                .removeClass("show-modal");
            }
            if ($(e.target).is(".st-agree")) {
                var html_content = $(e.target).closest(".st-tooltip").find("#console_iport");
                $(e.target).closest(".st-tooltip")
                .removeClass("show-modal");
                $(".st-tooltip#popup-demo-2")
                .toggleClass("show-modal");
                $('.st-package-name', '.st-tooltip#popup-demo-2').html("Install data demo: <strong>" + package_name.toUpperCase())+"</strong>";
                // $(".st-tooltip#popup-demo-2").find(".content-import").text(package_name);
                // $(e.target).closest(".st-tooltip")
                // .removeClass("show-modal");
                // $(".st-tooltip#popup-demo-3")
                // .toggleClass("show-modal");
                do_import(package_name,builder);

            }
        });
    });

    function do_import(package_name,builder)
    {
        var last_update_url;

        // start fist
        var first_loop_data={
            demo:package_name,
            builder:builder,
            percent:0,
            number:0,
            action:'quick_import_sql'
        };
        load_import_ajax( first_loop_data);
    }
    function load_import_ajax(first_loop_data){
        xhr = jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: first_loop_data,
            dataType: "json",
            success: function (doc) {
                if(doc){
                    if(doc.status == "ok"){
                        $('.loding_import').remove();
                        $('#console_iport').closest('.content-import').animate({scrollTop: $('#console_iport').closest('.content-import').prop("scrollHeight")}, 500);
                        if (doc.percent_progress) {
                            let el = $('.st-progress-bar .progress-bar', '.st-modal-content');
                            if (doc.percent_progress > 100)
                            doc.percent_progress = 100;

                            let $valuePercent = Math.abs(doc.percent_progress).toFixed(2);
                            el.attr('aria-valuenow', $valuePercent);
                            el.html($valuePercent + '%');
                            el.css('width', $valuePercent + '%');
                        }
                        if(doc.next_post_data){
                            setTimeout(function() {
                                load_import_ajax(doc.next_post_data);
                            }, 500);
                        }else{
                            const el = document.querySelector('#popup-demo-2');
                            const demo2 = document.querySelector('#popup-demo-3');
                            if (el.classList.contains("show-modal")) {
                                el.classList.remove("show-modal");
                            }

                            $('.loding_import').remove();
                            demo2.classList.toggle('show-modal');

                        }
                    } else {
                        $('.content-import-error #console_iport').html(doc.message);
                    }

                }

            },
            complete: function (xhr,stats) {

            },
        });
    }


});
