/**
 * Created by MSI on 23/11/2015.
 */
var package_name = '';
jQuery(function($){
    $('.st-install-demo').on('click', function(){
        package_name =$(this).data('demo-id');
       $(".st-tooltip#popup-demo-1")
          .toggleClass("show-modal");
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
                $('.st-package-name', '.st-tooltip#popup-demo-2').html("Install data demo: " + package_name.toUpperCase());
                // $(".st-tooltip#popup-demo-2").find(".content-import").text(package_name);
                // $(e.target).closest(".st-tooltip")
                // .removeClass("show-modal");
                // $(".st-tooltip#popup-demo-3")
                // .toggleClass("show-modal");
                do_import(package_name);

            }
        });
    });
    // $('.st-cancel').on('click', function(){
    //     $(".st-tooltip").removeClass("show-modal");
    // });
    function do_import(package_name)
    {
        var last_update_url;
        function start_loop_import(data){
            var erorr_count=0;
            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: data,
                dataType: "json",
            }).done(function( html ) {
                if(html){
                    if(html.status == "ok"){
                        $('.loding_import').remove();
                        // document.getElementById("console_iport").innerHTML +='<img class="loding_import" src="images/wpspin_light.gif">';
                        // document.getElementById("console_iport").innerHTML +=html.messenger;
                        $('#console_iport').closest('.content-import').animate({scrollTop: $('#console_iport').closest('.content-import').prop("scrollHeight")}, 500);
                        if (html.percent_progress) {
                            let el = $('.st-progress-bar .progress-bar', '.st-modal-content');
                            if (html.percent_progress > 100)
                                html.percent_progress = 100;

                            let $valuePercent = Math.abs(html.percent_progress).toFixed(2);
                            el.attr('aria-valuenow', $valuePercent);
                            el.html($valuePercent + '%');
                            el.css('width', $valuePercent + '%');
                        }
                    }
                    if(html.next_post_data){
                        setTimeout(function() {
                            start_loop_import(html.next_post_data);
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
                }
            }).error(function(html) {
                erorr_count++;
                if(erorr_count<=6)
                {
                    document.getElementById("console_iport").innerHTML = 'Re-Import';
                    $('.content-import').show();
                    $('#console_iport').animate({scrollTop: $('#console_iport').prop("scrollHeight")}, 500);
                    setTimeout(() => {
                        start_loop_import(data);
                    }, 1000);
                }
                setTimeout(function() {
                    console.log('reimport timeout')
                    document.getElementById("console_iport").innerHTML = '';
                    $('.content-import').hide();
                }, 10000);
            });
        }
        // start fist
        var first_loop_data={
            version:package_name,
            step:1,
            action:'st_import_content'
        };
        start_loop_import( first_loop_data);

    }


});
