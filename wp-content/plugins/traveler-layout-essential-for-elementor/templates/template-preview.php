<div class="traveler-essential-preview-html-or-image">
    <div class="traveler-essential-block-preview-header">
        <div class="ep-right">
            <button class="ep-preview-insert" data-id="<?php echo esc_attr($id);?>"><?php echo __("Insert", "traveler-layout-essential"); ?><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path></svg>
            </button>
        </div>
    </div>
    <div class="traveler-essential-preview-image-wrapper">
        <div class="traveler-essential-preview-hover">
            <button class=""><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M272 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h224c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM160 480c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm112-108c0 6.6-5.4 12-12 12H60c-6.6 0-12-5.4-12-12V60c0-6.6 5.4-12 12-12h200c6.6 0 12 5.4 12 12v312z"></path></svg>
            </button>
            <button class=""><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M400 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM224 480c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm176-108c0 6.6-5.4 12-12 12H60c-6.6 0-12-5.4-12-12V60c0-6.6 5.4-12 12-12h328c6.6 0 12 5.4 12 12v312z"></path></svg>
            </button>
            <button class="preview-active"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M528 0H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h192l-16 48h-72c-13.3 0-24 10.7-24 24s10.7 24 24 24h272c13.3 0 24-10.7 24-24s-10.7-24-24-24h-72l-16-48h192c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zm-16 352H64V64h448v288z"></path></svg></button>
        </div>
        <?php if (empty($url)) {
            echo __("No link found", "traveler-layout-essential-for-elementor");
        } else { ?>
        <iframe loading="eager" id="traveler-essential-preview-iframe" class="traveler-essential-preview-iframe traveler-essential-iframe-loaded" width="100%" height="100%" src="<?php echo esc_html($url);?>"></iframe>
        <?php } ?>
    </div>
</div>
<script>
    //click back to libary
    jQuery(".traveler-essential-back-2-library").click(function() {
        var type = jQuery(".traveler-essential-active a").attr('data-type');
    
        jQuery.ajax({
            type : "post", 
            dataType : "json",
            url : 'admin-ajax.php', 
            data : {
                action: "get_item_type", 
                value : type,
            },
            beforeSend: function(){
                jQuery('.traveler-essential-modal-body').append('<div class="loader"><div class="lds-ripple"><div></div><div></div></div></div>');
            },
            success: function(response) {
                jQuery( ".loader" ).remove();
                if(response.success) {
                    jQuery('.traveler-essential-elementor-platform').html(response.data);
                }
                else {
                    alert('Error');
                }
                
                jQuery(".traveler-essential-back-2-library").remove();
            },
            error: function( jqXHR, textStatus, errorThrown ){
            
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        })
    });
    //import template
    jQuery('.ep-preview-insert').click(function(){
        var id = jQuery(this).attr('data-id');
        jQuery.ajax({
            type : "post", 
            dataType : "json",
            url : 'admin-ajax.php', 
            data : {
                action: "import_template", 
                id : id,
            },
            beforeSend: function(){
                jQuery('.traveler-essential-modal-body').append('<div class="loader"><div class="lds-ripple"><div></div><div></div></div></div>');
            },
            success: function(e) {
                jQuery( ".loader" ).remove();
                if(e.success) {
                    if(e.data.content == null) {
                        alert(e.data.message);
                    }else {
                       
                        var t = window.TemplatelyIndex;
                        if ("undefined" != typeof $e) {
                        
                            for (var n = 0; n < e.data.content.length; n++) $e.run("document/elements/create", {
                            
                                container: elementor.getPreviewContainer(),
                                model: e.data.content[n],
                                options: t >= 0 ? {
                                    at: t++
                                } : {}
                            });
                            
                        }   
                        else {
                            var r = new Backbone.Model({
                                getTitle: function() {
                                    return "Test"
                                }
                            });
                            elementor.channels.data.trigger("template:before:insert", r);
                            for (var a = window.TemplatelyIndex, i = 0; i < e.data.content.length; i++) elementor.getPreviewView().addChildElement(e.data.content[i], a >= 0 ? {
                                at: a++
                            } : null);
                            elementor.channels.data.trigger("template:after:insert", {})
                        }
                        jQuery('.loader').hide();
                        jQuery("#traveler-essential-app-modal").remove();
                        return !0;
                    }
                }
                else {
                    alert('Error');
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
                
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        })
    });
    //click mb
    var btns = jQuery(".traveler-essential-preview-hover button");
    for (var i = 0; i < btns.length; i++) {
        
        btns[0].addEventListener("click", function() {
            jQuery("#traveler-essential-preview-iframe").css("width","480px")
        });

        btns[1].addEventListener("click", function() {
            jQuery("#traveler-essential-preview-iframe").css("width","786px")
        });

        btns[2].addEventListener("click", function() {
            jQuery("#traveler-essential-preview-iframe").css("width","100%")
        });
        
        btns[i].addEventListener("click", function() {
              
            var current = document.getElementsByClassName("preview-active");
            current[0].className = current[0].className.replace("preview-active", "");
            this.className += "preview-active";
        });
    }

</script>