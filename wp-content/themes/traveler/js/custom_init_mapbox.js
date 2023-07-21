/*Mapbox detail single service*/
jQuery(function ($) {
    $(".st_list_map .div_item_map").hide();
    $(".st_list_map .div_item_map").fadeIn(1E3)
});
var icon_hotel = st_params.st_icon_mapbox;
if(typeof icon_hotel !== 'undefined' ){
    icon_map = icon_hotel;
} else {
    icon_map = "https://i.imgur.com/MK4NUzI.png";
}
jQuery(function ($) {
    if ($(".st_detailed_mapbox").length > 0) {
        var me = $(".st_detailed_mapbox");
        var my_div_map = jQuery("#list_mapbox");
        var data_show = me.data("data_show");
        var map_height = me.data("map_height");
        var style_map = me.data("style_map");
        var type_map = me.data("type_map");
        var street_views = me.data("street_views");
        var height = me.data("height");
        var location_center = me.data("location_center");
        var location_center = me.data("location_center");
        var zoom = me.data("zoom");
        if (typeof zoom === "undefined") {
            var zoom = 10;
        } else {
            var zoom = zoom;
        }
        var range = me.data("range");
        $(function () {
            init_list_mapbox(my_div_map, data_show, location_center, zoom, style_map);
            // init_list_map(my_div_map, data_show, location_center,
            //     zoom, style_map);
            $("a[data-vc-tabs],a[data-vc-accordion]").on("click", function () {
                setTimeout(function () {
                    /*var gmap_obj = my_div_map.gmap3("get");
                    google.maps.event.trigger(gmap_obj, "resize");
                    gmap_obj.setCenter(new google.maps.LatLng(location_center[0], location_center[1]))*/
                    if($('#list_map iframe').length) {
                        var iframe = $('#list_map iframe').get(0);
                        iframe.src = iframe.src;
                    }
                }, 100)
            });
            $(".single a[data-vc-tabs],.single a[data-vc-accordion]").on("click", function () {
                jQuery("#st-gmap-loading").fadeIn(100);
                jQuery(".st-gmap-loading-bg").fadeIn(100);
                init_list_mapbox(my_div_map, data_show, location_center, zoom, style_map);
            });
        });
        function init_list_mapbox(div_map, data_map, map_center, data_zoom, style_map) {
                var idmap = c = (div_map.selector).slice(1);
                var markers = [];
                data_zoom = parseInt(data_zoom);
                mapboxgl.accessToken = st_params.token_mapbox;
                if(typeof st_params.text_rtl_mapbox !== 'undefined' && typeof mapboxgl.setRTLTextPlugin == 'undefined' ){
                    mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
                }
                /* Map: This represents the map on the page. */
                var map = new mapboxgl.Map({
                    container: idmap,
                    style: "mapbox://styles/mapbox/streets-v11?optimize=true",
                    zoom: data_zoom,
                    center: [location_center[1],location_center[0]]
                });
                map.on("load", function() {
                    map.resize();
                    /* Image: An image is loaded and added to the map. */
                    map.loadImage(icon_map, function(error, image) {
                        if (error) throw error;
                        map.addImage("custom-marker", image);
                        /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                        map.addLayer({
                            id: "markers",
                            type: "symbol",
                            /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
                            source: {
                                type: "geojson",
                                data: {
                                    type: 'FeatureCollection',
                                    features: [{
                                        type: 'Feature',
                                        properties: {},
                                        geometry: {
                                            type: "Point",
                                            coordinates: [location_center[1],location_center[0]]
                                        }
                                    }]
                                }
                            },
                            layout: {
                                "icon-image": "custom-marker",
                            }
                        });
                    });
                     $('.vc_tta-tabs-list a[data-vc-container=".vc_tta"]').on('shown.bs.tab', function(){
                        map.resize();
                    });
                    if  (map.loaded()) {
                    } else {
                        map.once('load', () => {
                            jQuery("#st-gmap-loading").fadeOut(700);
                            jQuery(".st-gmap-loading-bg").fadeOut(700);
                        });
                    }
                });
            }
    }
});
jQuery(function ($) {
    if ($(".st_list_mapbox_html").length > 0) {
        var me = $(".st_list_mapbox_html");
        var my_div_map = jQuery("#list_mapbox");
        var data_show = me.data("data_show");
        var map_height = me.data("map_height");
        var style_map = me.data("style_map");
        var fit_bounds = me.data("fit_bounds");
        var location_center = me.data("location_center");
        var zoom = me.data("zoom");
        $(function () {
            var filter_search_map = $(".search_list_map .filter_search_map");
            $(".search_list_map .filter_search_map .btn_search").on('click', function () {
                var $this =
                    $(this);
                var options = {
                    url: st_params.ajax_url, dataType: "json", beforeSend: function () {
                        jQuery("#st-gmap-loading").show();
                        jQuery(".st-gmap-loading-bg").show();
                        $this.html(st_params.text_loading);
                        $(".data_list_map").css("opacity", "0.5")
                    }, success: function (data) {
                        var container = $("#list_mapbox").parent();
                        $("#list_mapbox").remove();
                        container.append('<div id="list_mapbox"></div>');
                        $("#list_mapbox").height(map_height);
                        $("#list_mapbox").attr("data-fitbounds", fit_bounds);
                        $("#list_mapbox").attr("data-fitbounds", "on");
                        location_center = [data.map_lng_center, data.map_lat_center];
                        st_list_mapbox_html($("#list_mapbox"), data.data_map, location_center, data.zoom, style_map);
                        $(".data_list_map").html("");
                        var count = 0;
                        for (var key in data.data_map) {
                            var tmp_data = data.data_map[key];
                            var res = tmp_data.content_adv_html.replace("item_price_map", "");
                            $(".data_list_map").append('<div class="col-md-3 col-sm-6">' + res + "</div>");
                            count++
                        }
                        $(".count_advan_saerch").html("(" + count + ")");
                        if (count == 0)$(".data_list_map").append('<div class="alert alert-warning"> <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">\u00d7</span> </button> <p class="text-small">' +
                            st_list_map_params.text_no_result + "</p> </div>");
                        $(".data_list_map").css("opacity", "1");
                        $this.html($this.data("title"))
                    }, complete: function () {
                        jQuery("#st-gmap-loading").fadeOut(700);
                        jQuery(".st-gmap-loading-bg").fadeOut(700);
                    }
                };
                filter_search_map.ajaxForm(options);
            });
        });
    }
});
function st_list_mapbox_html(my_div_map, data_show, location_center, zoom, style_map) {
    if(data_show.length > 0){
        if(typeof my_div_map.selector != 'undefined' ){
            var idmap = (my_div_map.selector).slice(1);
        } else {
            var idmap = (my_div_map).slice(1);
        }
        
        var markers = [];
        data_zoom = parseInt(zoom);
        if(typeof  data_show[0].icon_mk !== 'undefined'){
            var icon_map = data_show[0].icon_mk;
        } else {
            var icon_map = st_params.st_icon_mapbox
        }
        if(typeof st_params.text_rtl_mapbox !== 'undefined' && typeof mapboxgl.setRTLTextPlugin == 'undefined' ){
            mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
        }
        mapboxgl.accessToken = st_params.token_mapbox;
        var map = new mapboxgl.Map({
          container: idmap,
          style: 'mapbox://styles/mapbox/light-v10?optimize=true',
          center: location_center,
          zoom: data_zoom,
        });
        var listOfObjects = [];
        jQuery.map(data_show, function (location, i) {
            var item_map = InitItemmap(location,i);
            listOfObjects.push(item_map);
        });
        map.on("load", function() {
            map.loadImage(icon_map, function(error, image) {
                if (error) throw error;
                map.addImage("custom-marker", image);
                /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                map.addLayer({
                    id: "markers",
                    type: "symbol",
                    source: {
                        type: "geojson",
                        data: {
                            type: 'FeatureCollection',
                            features:listOfObjects
                        }
                    },
                    layout: {
                        "icon-image": "custom-marker",
                    }
                });
            });
             map.on('click', 'markers', function (e) {
                map.flyTo({center: e.features[0].geometry.coordinates});
                var coordinates = e.features[0].geometry.coordinates.slice();
                var description = e.features[0].properties.description;
                // Ensure that if the map is zoomed out such that multiple
                // copies of the feature are visible, the popup appears
                // over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                new mapboxgl.Popup({ offset: [150,150] })
                .setLngLat(coordinates)
                .setHTML(description)
                .addTo(map);
            });
        });
    }
        
}
    function InitItemmap(item_map,key){
        var singleObj = {};
        singleObj['type'] = 'Feature';
        singleObj['geometry'] = {
            type: 'Point',
            coordinates: [item_map.lng, item_map.lat]
        };
        singleObj['properties'] = {
            title: item_map.name,
            description: item_map.content_html,
            icon: item_map.icon_mk,
        };
        return singleObj;
    }
jQuery(function ($) {
    if ($(".st_list_mapbox_html").length > 0) {
         var me = $(".st_list_mapbox_html");
        var my_div_map = jQuery("#list_mapbox");
        var data_show = me.data("data_show");
        var map_height = me.data("map_height");
        var style_map = me.data("style_map");
        var fit_bounds = me.data("fit_bounds");
        var location_center = me.data("location_center");
        var zoom = me.data("zoom");
        var filter_search_map = $(".search_list_map .filter_search_map");
        var location_center = [location_center[1],location_center[0]];
        st_list_mapbox_html($("#list_mapbox"), data_show, location_center, zoom, style_map);
        jQuery("#st-gmap-loading").fadeOut(700);
        jQuery(".st-gmap-loading-bg").fadeOut(700);
    }
});
/*Halfmap*/
jQuery(function ($) {
    if ($(".st_list_half_mapbox_data").length > 0) {
        var me = $(".st_list_half_mapbox_data");
        var my_div_map = jQuery("#list_half_mapbox");
        var data_show = me.data("data_map");
        var map_height = me.data("map_height");
        var style_map = me.data("style_map");
        var fit_bounds = me.data("fit_bounds");
        var location_center = me.data("location_center");
        var zoom = me.data("zoom");
        var filter_search_map = $(".search_list_map .filter_search_map");
        var location_center = [location_center[1],location_center[0]];
        st_list_half_mapbox_data($("#list_half_mapbox"), data_show, location_center, zoom, style_map);
        jQuery("#st-gmap-loading").fadeOut(700);
        jQuery(".st-gmap-loading-bg").fadeOut(700);
    }
    function st_list_half_mapbox_data(my_div_map, data_show, location_center, zoom, style_map){
        if (data_show.length > 0) {
            if(typeof (my_div_map.selector) !='undefined' ){
                var idmap = (my_div_map.selector).slice(1);
            } else {
                var idmap = (my_div_map).slice(1);
            }
            
            var markers = [];
            data_zoom = parseInt(zoom);
            if(typeof  data_show[0].icon_mk !== 'undefined'){
                var icon_map = data_show[0].icon_mk;
            } else {
                var icon_map = st_params.st_icon_mapbox
            }
            mapboxgl.accessToken = st_params.token_mapbox;
            if(typeof  icon_map !== 'undefined'){
                icon_map = icon_map;
            } else {
                icon_map = st_params.st_icon_mapbox
            }
            if(typeof st_params.text_rtl_mapbox !== 'undefined' ){
                mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
            }
            var map = new mapboxgl.Map({
              container: idmap,
              style: 'mapbox://styles/mapbox/light-v10?optimize=true',
              center: location_center,
              zoom: data_zoom,
            });
            var listOfObjects = [];
            jQuery.map(data_show, function (location, i) {
                var item_map = InitItemmap(location,i);
                listOfObjects.push(item_map);
            });
            map.on("load", function() {
                map.loadImage(icon_map, function(error, image) {
                    if (error) throw error;
                    map.addImage("custom-marker", image);
                    /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                    map.addLayer({
                        id: "markers",
                        type: "symbol",
                        source: {
                            type: "geojson",
                            data: {
                                type: 'FeatureCollection',
                                features:listOfObjects
                            }
                        },
                        layout: {
                            "icon-image": "custom-marker",
                        }
                    });
                });
                 map.on('click', 'markers', function (e) {
                    map.flyTo({center: e.features[0].geometry.coordinates});
                    var coordinates = e.features[0].geometry.coordinates.slice();
                    var description = e.features[0].properties.description;
                    // Ensure that if the map is zoomed out such that multiple
                    // copies of the feature are visible, the popup appears
                    // over the copy being pointed to.
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                    new mapboxgl.Popup({ offset: [150,150] })
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
                });
            });
        }
    }
    /*Search half list map*/
    if ($(".st_list_half_mapbox_data").length > 0) {
        var me = $(".st_list_half_mapbox_data");
        var my_div_map = jQuery("#list_half_mapbox");
        var data_show = me.data("data_map");
        var map_height = me.data("map_height");
        var style_map = me.data("style_map");
        var fit_bounds = me.data("fit_bounds");
        var location_center = me.data("location_center");
        var zoom = me.data("zoom");
        jQuery(function ($) {
            var filter_search_map = $(".half_map_container .filter_search_map");
            $("#hotel_search_half_map.filter_search_map .btn_search").on('click', function () {
                var $this =
                    $(this);
                var options = {
                    url: st_params.ajax_url, dataType: "json", beforeSend: function () {
                        jQuery("#st-gmap-loading").show();
                        jQuery(".st-gmap-loading-bg").show();
                        $this.html(st_params.text_loading);
                        $(".data_list_map").css("opacity", "0.5")
                    }, success: function (data) {
                        // var container = $("#list_half_mapbox").parent();
                        // $("#list_half_mapbox").remove();
                        // container.append('<div id="list_half_mapbox"></div>');
                        $("#list_half_mapbox").height(map_height);
                        $("#list_half_mapbox").attr("data-fitbounds", fit_bounds);
                        $("#list_half_mapbox").attr("data-fitbounds", "on");
                        location_center = [data.map_lng_center, data.map_lat_center];
                        st_list_half_mapbox_data($("#list_half_mapbox"), data.data_map, location_center, data.zoom, style_map);
                        $(".data_list_map").html("");
                        var count = 0;
                        for (var key in data.data_map) {
                            var tmp_data = data.data_map[key];
                            var res = tmp_data.content_adv_html.replace("item_price_map", "");
                            $(".data_list_map").append('<div class="col-md-3 col-sm-6">' + res + "</div>");
                            count++
                        }
                        $(".count_advan_saerch").html("(" + count + ")");
                        if (count == 0)$(".data_list_map").append('<div class="alert alert-warning"> <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">\u00d7</span> </button> <p class="text-small">' +
                            st_list_map_params.text_no_result + "</p> </div>");
                        $(".data_list_map").css("opacity", "1");
                        $this.html($this.data("title"))
                    }, complete: function () {
                        jQuery("#st-gmap-loading").fadeOut(700);
                        jQuery(".st-gmap-loading-bg").fadeOut(700);
                    }
                };
                filter_search_map.ajaxForm(options);
            });
        });
    }
    /*Full height mapbox*/
    jQuery(function ($) {
        if ($(".st_list_half_map_before").length > 0) {
            var map_full_height = parseInt($(window).height());
            if ($("#st_header_wrap").length)map_full_height -= $("#st_header_wrap").outerHeight(!0);
            if ($("body>.global-wrap.container").length)map_full_height -= parseInt($("body>.global-wrap.container").css("margin-bottom").replace("px", ""));
            if ($("#main-footer").length) {
                map_full_height -= $("#main-footer").outerHeight();
                $("#main-footer").addClass("mt0")
            }
            if ($("#wpadminbar").length)map_full_height -= $("#wpadminbar").outerHeight(!0);
            if (map_full_height < 500)map_full_height = 480;
            var map_height = $(".st_list_half_map_before").data("map_height");
            if (map_height == "map_full_height")map_height = map_full_height;
            $(".div_half_map, .half_map_container .st_gmap , .st_list_half_map , .content_map ,#list_half_map").height(map_height)
        }
    });
});
