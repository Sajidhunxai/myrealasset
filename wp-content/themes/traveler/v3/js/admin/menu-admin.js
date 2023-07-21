;(function ($) {
    'use strict';

    let TRAVELER_MEGA_MENU_ITEM = {
        init: function () {
            let base = this;
            base.megaMenuFunc();
        },
        megaMenuFunc: function () {

            $(".st-color-field").wpColorPicker();
            $("#menu-to-edit").on("click", ".item-edit", function (e) {
                var t = $(this).closest(".menu-item").find(".st-color-field");
                t.hasClass("wp-color-field") || t.wpColorPicker();
            });

            $(".remove_image_button").each(function () {
                "" != $(this).parent().find(".image_attachment_id").val() && $(this).show();
            });
            $("#menu-to-edit").on("click", ".remove_image_button", function (e) {
                $(this).parent().find(".image-preview").remove();
                $(this).parent().find(".image_attachment_id").val("");
                $(this).hide();
            });
            if ($("body").hasClass("nav-menus-php")) {
                $("#menu-to-edit").on("click", ".upload_image_button", function (e) {
                    e.preventDefault();
                    let $this = $(this);
                    let media = wp.media({multiple: !1}).open().on("select", function (e) {
                        let t = media.state().get("selection").first().toJSON();
                        $this.parent().find(".image-preview-wrapper").html('<img style="max-width:100%" class="image-preview" src="' + t.url + '" />');
                        $this.parent().find(".image_attachment_id").val(t.id);
                        $this.parent().find(".remove_image_button").show();
                    });
                });
            }
        }
    };

    TRAVELER_MEGA_MENU_ITEM.init();
    $(document).on('menu-item-added', function (ev, $menuMarkup) {
        TRAVELER_MEGA_MENU_ITEM.init();
    });

})(jQuery)