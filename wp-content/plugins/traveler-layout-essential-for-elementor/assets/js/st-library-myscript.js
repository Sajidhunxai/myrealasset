(function ($) {
    $("document").ready(function () {
        let templateAddSection = $("#tmpl-elementor-add-section");
        if (0 < templateAddSection.length) {
            var oldTemplateButton = templateAddSection.html();
            oldTemplateButton = oldTemplateButton.replace(
                '<div class="elementor-add-section-drag-title',
                '<div class="elementor-add-section-area-button elementor-add-traveler-essential-button"><i class="eicon-plus"></i></div><div class="elementor-add-section-drag-title'
            );
            templateAddSection.html(oldTemplateButton);
        }

        elementor.on("preview:loaded", function () {
            $(elementor.$previewContents[0].body).on("click", ".elementor-add-traveler-essential-button", function (event) {
                window.tmPromo = elementorCommon.dialogsManager.createWidget(
                    "lightbox",
                    {
                        id: "traveler-essential-app-modal",
                        headerMessage: !1,
                        message: "",
                        hide: {
                            auto: !1,
                            onClick: !1,
                            onOutsideClick: false,
                            onOutsideContextMenu: !1,
                            onBackgroundClick: !0,
                        },
                        position: {
                            my: "center",
                            at: "center",
                        },
                        onShow: function() {
                            
                                // load ajax html
                            jQuery.ajax({
                                type : "post", 
                                dataType : "json",
                                url : 'admin-ajax.php', 
                                data : {
                                    action: "get_item_template", 
                                    value : 'value',
                                },
                                beforeSend: function(){
                                    jQuery('.dialog-lightbox-message').append('<div class="loader"><div class="lds-ripple"><div></div><div></div></div></div>');
                                    
                                },
                                success: function(response) {
                                    
                                    jQuery( ".loader" ).remove();
                                    if(response.success) {
                                        jQuery('.dialog-lightbox-content').html(response.data);
                                    }
                                    else {
                                        alert('Error');
                                    }
                                },
                                error: function( jqXHR, textStatus, errorThrown ){
                                    jQuery( ".loader" ).remove();
                                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                                }
                            })
                        },
                        onHide: function () {
                            window.tmPromo.destroy();
                        }
                    }
                );
                window.tmPromo.getElements("header").remove();
                window.tmPromo.getElements("message").append(
                    window.tmPromo.addElement("content")
                );
                window.tmPromo.show();
            });
        });
    });
})(jQuery);
