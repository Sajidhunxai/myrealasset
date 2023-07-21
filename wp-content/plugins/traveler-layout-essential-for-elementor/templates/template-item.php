<div class="traveler-essential-modal-sidebar">
    <div class="traveler-essential-modal-sidebar-inner">
        <div class="traveler-essential-categories traveler-essential-packs-categories">
            <ul class="traveler-essential-sidebar-menu">
                <li class="traveler-essential-sidebar-menu-item traveler-essential-active"  id="all"><span><?php echo __("All Categories", "traveler-layout-essential");?></span></li>
                <?php foreach ($data_items as $key => $value) {
                    $array_category[$value["cateID"]] =$value["category"];
                }
               
                foreach ($array_category as $key => $value) : ?>
                <li class="traveler-essential-sidebar-menu-item"  id="tab-<?php echo esc_attr($key);?>"><?php echo esc_html($value); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="traveler-essential-modal-content-wrapper ">
    <div class="traveler-essential-items-header-wrapper ">
        <div class="traveler-essential-items-header-wrapper-inner">
            <div class="traveler-essential-items-header">
                <?php if ($type === "page") {
                    ?><h3><?php echo __("All Pages", "traveler-layout-essential") ?></h3><?php
                } ?>
                <?php if ($type === "section") {
                    ?><h3><?php echo __("All Sections", "traveler-layout-essential") ?></h3><?php
                } ?>
                <?php if ($type === "container") {
                    ?><h3><?php echo __("All Blocks", "traveler-layout-essential") ?></h3><?php
                } ?>
            </div>
        </div>
    </div>
    <div
        class="traveler-essential-modal-content traveler-essential-blocks traveler-essential-tab-packs traveler-essential-has-pagination">
        <?php foreach ($data_items as $key => $value) { ?>
            <div class="traveler-essential-single-item traveler-essential-pack tab-<?php echo esc_attr($value["cateID"]);?>C">
                <div>
                    <div class="traveler-essential-item-image">
                        <div class="box-label"><span><?php echo esc_html('Free', 'traveler-layout-essential') ?></span></div>
                        <img
                            height="200px" width="100%" alt="<?php echo esc_attr($value["title"]);?>"
                            src="<?php echo $value["image"]?>">
                        <div class="traveler-essential-item-image-hover">
                            <span>
                                <a href="#" class="preview-icon" data-url="<?php echo esc_attr($value["live_url"]); ?>" data-id="<?php echo esc_attr($value["ID"]); ?>">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" size="20" color="#fff" height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="color: rgb(255, 255, 255);"><path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                     
                    </div>
                    <div class="traveler-essential-single-item-details">
                        <div class="traveler-essential-single-item-details-content">
                            <?php if (!empty($value["title"])) { ?>
                                <p class="item-title"><strong><?php echo esc_html($value["title"]);?></strong></p>
                            <?php } ?>
                            <button class="traveler-essential-button traveler-essential-button-downdload" data-id="<?php echo esc_attr($value["ID"]); ?>">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" color="#6072ff" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="color: rgb(96, 114, 255);">
                                    <path d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php }
            ?> 
    </div>
</div>
<script>
    //click close
    jQuery(".traveler-essential-close").click(function() {  
        jQuery("#traveler-essential-app-modal").remove();
    });
    //active li
    var btns = jQuery(".travler_nav li");
    for (var i = 0; i < btns.length; i++) {
    
        btns[i].addEventListener("click", function() {
            
            var current = document.getElementsByClassName("traveler-essential-active");
            current[0].className = current[0].className.replace("traveler-essential-active", "");
            this.className += "traveler-essential-active";
        });
    }

    //ajax tab type
        jQuery(".travler_nav li a").click(function() {  
               
            var type = jQuery(this).attr('data-type');
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
                        alert('Đã có lỗi xảy ra');
                    }
                    jQuery('.loader').hide();
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    jQuery( ".loader" ).remove();
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            })
        });
    //filter category
    jQuery('.traveler-essential-sidebar-menu li').click(function(){
        var t = jQuery(this).attr('id');
        jQuery(this).addClass('traveler-essential-active');
        if(jQuery(this).hasClass('traveler-essential-active')){ //t
            jQuery('.traveler-essential-sidebar-menu li').removeClass('traveler-essential-active'); 
            jQuery(this).addClass('traveler-essential-active');
            jQuery('.traveler-essential-single-item').hide();
            jQuery('.'+ t + 'C').fadeIn('slow');
            if(t === "all") {
                jQuery('.traveler-essential-single-item').fadeIn('slow');
            }
        }
    });
    //import template
    jQuery('.traveler-essential-button-downdload').click(function(){
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
                    alert('error');
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
                jQuery( ".loader" ).remove();
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        })
    });
    //click preview
    jQuery('.preview-icon').click(function(){
        jQuery(".traveler-essential-logo").append("<span class='traveler-essential-back-2-library'><svg stroke='currentColor' fill='currentColor' stroke-width='0' viewBox='0 0 448 512' color='#000' height='1em' width='1em' xmlns='http://www.w3.org/2000/svg' style='color: rgb(0, 0, 0);'><path d='M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z'></path></svg>Back to Library</span>");
        var url = jQuery(this).attr('data-url');
        var id = jQuery(this).attr('data-id');
        jQuery.ajax({
            type : "post", 
            dataType : "json",
            url : 'admin-ajax.php', 
            data : {
                action: "preview_template", 
                url : url,
                id : id,
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
                    alert('error');
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
               
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        })
    });
    
</script>