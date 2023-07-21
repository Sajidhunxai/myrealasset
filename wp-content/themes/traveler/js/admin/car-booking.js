jQuery(function (e) {
    function a(a) {
        e("#item-equipment-wrapper").html(""), e("#item-price-wrapper").html(""), e("span.spinner").addClass("is-active"), void 0 !== a && a > 0 && (data = {
            action: "st_getInfoCar",
            car_id: a
        }, e.post(ajaxurl, data, function (a, t, i) {
            e("span.spinner").removeClass("is-active"), e("#item-equipment-wrapper").html(a.item_equipment), e("#item-price-wrapper").html(a.price)
        }, "json"))
    }
    e(".st_datepicker").each(function () {
        e(this).datepicker({
            language: st_params.locale || "",
            dateFormat: "yy/mm/dd"
        })
    });
    var t = e("#form-booking-admin");
    e('input[name="item_id"]', t).on('change', function (t) {
        var i = parseInt(e(this).val());
        a(i)
    })
});
