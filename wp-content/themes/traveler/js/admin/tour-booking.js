jQuery(function (t) {
    function e(e) {
        $parent = t("#form-booking-admin"), t("span.spinner", $parent).addClass("is-active"), void 0 !== e && parseInt(e) > 0 && (data = {
            action: "st_getInfoTour",
            tour_id: e
        }, t.post(ajaxurl, data, function (e, n, a) {
            t("span.spinner", $parent).removeClass("is-active"), "object" == typeof e && (t("#tour-type-wrapper", $parent).html(e.type_tour), t("input#adult_price", $parent).val(e.adult_price), t("input#child_price", $parent).val(e.child_price), t("input#infant_price", $parent).val(e.infant_price), t("input#max_people", $parent).val(e.max_people), "daily_tour" != e.tour_text ? (t("input#duration").val("").parents(".form-row").hide(), t("input#check_out").parents(".form-row").show()) : (t("input#duration").val(e.duration).parents(".form-row").show(), t("input#check_out").parents(".form-row").hide()), t("#extra-price-wrapper").html(e.extras))
        }, "json"))
    }
    if (t('#form-booking-admin input[name="item_id"]').on('change', function (n) {
            var a = t(this).val();
            e(a)
        }), "" != t('#form-booking-admin input[name="item_id"]').val() && parseInt(t('#form-booking-admin input[name="item_id"]').val()) > 0) {
        var n = t('#form-booking-admin input[name="item_id"]').val();
        e(n)
    }
    var a = function (e) {
        var n = this;
        this.container = e, this.calendar = null, this.form_container = null, this.init = function () {
            n.container = e, n.calendar = t(".calendar-content", n.container), n.form_container = t(".calendar-form", n.container), n.initCalendar()
        }, this.initCalendar = function () {
            n.calendar.fullCalendar({
                firstDay: 1,
                lang: st_params.locale,
                timezone: st_timezone.timezone_string,
                customButtons: {
                    reloadButton: {
                        text: st_params.text_refresh,
                        click: function () {
                            n.calendar.fullCalendar("refetchEvents")
                        }
                    }
                },
                header: {
                    left: "today,reloadButton",
                    center: "title",
                    right: "prev, next"
                },
                selectable: !0,
                select: function (t, e, a, i) {
                    var o = new Date(t._d).toString("MM"),
                        r = new Date(e._d).toString("MM"),
                        l = (new Date).toString("MM");
                    (o < l || r < l) && n.calendar.fullCalendar("unselect")
                },
                events: function (e, n, a, i) {
                    var o = [];
                    t.ajax({
                        url: ajaxurl,
                        dataType: "json",
                        type: "post",
                        data: {
                            action: "st_get_availability_tour_frontend",
                            tour_id: t("input#tour_id").val(),
                            start: e.unix(),
                            end: n.unix()
                        },
                        success: function (t) {
                            "object" == typeof t ? "object" == typeof t.events && (o = t.events) : console.log("Can not get data"), i(o)
                        },
                        error: function (t) {
                            alert("Can not get the availability slot. Lost connect with your sever")
                        }
                    })
                },
                eventClick: function (t, e, n) {},
                eventMouseover: function (e, n, a) {
                    t(".event-number-" + e.start.unix()).addClass("hover")
                },
                eventMouseout: function (e, n, a) {
                    t(".event-number-" + e.start.unix()).removeClass("hover")
                },
                eventRender: function (e, n, a) {
                    var i = e.day,
                        o = "none";
                    void 0 !== e.date_end && (i += " - " + e.date_end, o = "group");
                    var r = (new Date).getFullYear() + "-" + ((new Date).getMonth() + 1) + "-" + (new Date).getDate();
                    if ("available" == e.status) {
                        var l = "";
                        0 != e.adult_price && (l += st_checkout_text.adult_price + ": " + e.adult_price + " <br/>"), 0 != e.child_price && (l += st_checkout_text.child_price + ": " + e.child_price + " <br/>"), 0 != e.infant_price && (l += st_checkout_text.infant_price + ": " + e.infant_price), i = "<button data-placement='top' title  = '" + l + "' data-toggle='tooltip' class='" + o + " btn btn-available'>" + i
                    } else i = "<button disabled data-placement='top' title  = 'Disabled' data-toggle='tooltip' class='" + o + " btn btn-disabled'>" + i;
                    r === e.date && (i += "<span class='triangle'></span>"), i += "</button>", n.addClass("event-" + e.id), n.addClass("event-number-" + e.start.unix()), t(".fc-content", n).html(i), n.on("click", function () {
                        t("input#check_in").val(e.start._i), void 0 !== e.end && e.end && void 0 !== e.end._i ? (date = new Date(e.end._i), date.setDate(date.getDate() - 1), date = t.fullCalendar.moment(date).format("YYYY-MM-DD"), t("input#check_out").val(date)) : t("input#check_out").val(e.start._i), t("input#adult_price").val(e.adult_price), t("input#child_price").val(e.child_price), t("input#infant_price").val(e.infant_price), t.fn.qtip && t("#tour_time").qtip("hide")
                    })
                },
                loading: function (e, a) {
                    e ? t(".overlay", n.container).addClass("open") : t(".overlay", n.container).removeClass("open")
                }
            })
        }
    };
    t("#tour_time").on('click', function (t) {
        return !1
    }), t.fn.qtip && t("#tour_time").qtip({
        content: {
            text: t("#tour_time_content").html()
        },
        show: {
            when: "click",
            solo: !0
        },
        hide: "unfocus",
        api: {
            onShow: function () {
                t(".calendar-wrapper").each(function (e, n) {
                    var i = t(this),
                        o = new a(i);
                    o.init()
                })
            }
        }
    })
});
