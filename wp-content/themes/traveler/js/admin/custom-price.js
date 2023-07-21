jQuery(function (e) {
    e(".btn_add_price").on('click', function () {
        var t = e(".data_price_html").html(),
            a = Math.floor(1e4 * Math.random() + 1);
        t = t.replace('id="start"', 'id="start_' + a + '"').replace('id="end"', 'id="end_' + a + '"'), t = t.replace("hasDatepicker", "").replace("hasDatepicker", ""), e(".data_price").append(t), e(".st_datepicker_price").each(function () {
            e(this).datepicker(), e(this).datepicker("option", "dateFormat", "yy-mm-dd")
        })
    }), e(document).on("click", ".btn_del_price", function () {
        e(this).parent().parent().remove()
    }), e(".st_datepicker_price").each(function () {
        e(this).datepicker({
            language: st_params.locale || "",
            dateFormat: "yy-mm-dd",
            firstDay: 1
        })
    })
});
