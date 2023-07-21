jQuery(function (e) {
    function t() {
        switch (a) {
            case "hotel":
                return "hotel_room"
        }
    }
    var a = e("#item_type").val();
    e("#check_in").datepicker({
        language: st_params.locale || "",
        dateFormat: "yy-mm-dd",
        firstDay: 1
    }), e("#check_out").datepicker({
        language: st_params.locale || "",
        dateFormat: "yy-mm-dd",
        firstDay: 1
    }), e("#item_type").on('change', function () {
        switch (a = e("#item_type").val(), e(".form_row_spec").hide(), e(".form_row_spec." + a).show(), a) {
            case "hotel":
                e("label[for=item_id2]").html("Room")
        }
    }), e("#item_type").trigger("change"), e(".st_add_order_item").on('click', function () {
        e(".st_create_item_wrap").removeClass("hidden")
    });
    var i = !1;
    e(".st_save_new_item").on('click', function () {
        var t = e(this);
        t.next(".loading");
        if (!i) {
            e(this).next(".loading").remove(), e(this).after('<span class="loading">Saving...</span>'), i = !0;
            var a = e(".st_create_item").find("input,textarea,select").serializeArray();
            e.ajax({
                dataType: "json",
                url: ajaxurl,
                data: a,
                success: function (e) {
                    void 0 === e.message && e.message && alert(e.message), e.reload && window.location.reload(), t.next(".loading").remove(), i = !1
                },
                error: function (e) {
                    alert("Ajax Fail"), console.log(e), t.next(".loading").remove(), i = !1
                }
            })
        }
    }), e("#item_id").select2({
        minimumInputLength: 2,
        ajax: {
            url: ajaxurl,
            dataType: "json",
            quietMillis: 250,
            data: function (t, a) {
                return {
                    q: t,
                    action: "st_order_select",
                    post_type: e("#item_type").val()
                }
            },
            results: function (e, t) {
                return {
                    results: e.items
                }
            },
            cache: !0
        },
        initSelection: function (t, a) {
            var i = e(t).val();
            if ("" !== i) {
                var n = {
                    id: i,
                    name: e(t).data("pl-name"),
                    description: e(t).data("pl-desc")
                };
                a(n)
            }
        },
        formatResult: function (e) {
            return e.id ? e.name + "<p><em>" + e.description + "</em></p>" : e.name
        },
        formatSelection: function (e) {
            return e.id ? e.name + "<p><em>" + e.description + "</em></p>" : e.name
        },
        escapeMarkup: function (e) {
            return e
        }
    }), e("#item_id2").select2({
        minimumInputLength: 2,
        ajax: {
            url: ajaxurl,
            dataType: "json",
            quietMillis: 250,
            data: function (a, i) {
                return {
                    q: a,
                    action: "st_order_select",
                    post_type: t(),
                    item_id: e("#item_id").val()
                }
            },
            results: function (e, t) {
                return {
                    results: e.items
                }
            },
            cache: !0
        },
        initSelection: function (t, a) {
            var i = e(t).val();
            if ("" !== i) {
                var n = {
                    id: i,
                    name: e(t).data("pl-name"),
                    description: e(t).data("pl-desc")
                };
                a(n)
            }
        },
        formatResult: function (e) {
            return e.id ? e.name + "<p><em>" + e.description + "</em></p>" : e.name
        },
        formatSelection: function (e) {
            return e.id ? e.name + "<p><em>" + e.description + "</em></p>" : e.name
        },
        escapeMarkup: function (e) {
            return e
        }
    }), e("#item_id2").on("change", function () {}), e(".st_delete_item").on('click', function () {
        var t = e(this).data("id"),
            a = e(this);
        t && confirm("Are you sure?") && e.ajax({
            dataType: "json",
            url: ajaxurl,
            data: {
                action: "st_delete_order_item",
                id: t
            },
            success: function (e) {
                void 0 === e.message && e.message && alert(e.message), e.reload && window.location.reload(), i = !1, a.parents("tr").remove()
            },
            error: function (e) {
                alert("Ajax Fail"), console.log(e), i = !1
            }
        })
    })
});
