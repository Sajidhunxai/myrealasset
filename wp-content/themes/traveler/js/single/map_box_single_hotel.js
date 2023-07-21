jQuery(function ($) {
	if ($("#st-hotel-mapbox-new").length > 0) {
		var me = $("#st-hotel-mapbox-new");
        var my_div_map = jQuery("#mapbox_single_full_map");
        var data_show = me.data("marker-data");
        var location_center = me.data("location");
        var data_zoom = location_center['zoom'];
        var idmap = (my_div_map.selector).slice(1);
        var markers = [];
        data_zoom = parseInt(data_zoom);
        mapboxgl.accessToken = st_params.token_mapbox;
        if(typeof st_params.text_rtl_mapbox !== 'underfind' ){
            mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
        }
        var map = new mapboxgl.Map({
          container: idmap,
          style: 'mapbox://styles/mapbox/light-v10?optimize=true',
          center: [location_center.lng,location_center.lat],
          zoom: data_zoom,
        });
        var listOfObjects = [];
        jQuery.map(data_show, function (location, i) {
            var item_map = InitItemmap(location,i);
            listOfObjects.push(item_map);
        });
        var icon_hotel = st_params.st_icon_mapbox;
        if(typeof icon_hotel !== 'underfind' ){
            icon_map = icon_hotel;
        } else {
            icon_map = "https://i.imgur.com/MK4NUzI.png";
        }
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
                                    coordinates: [location_center.lng,location_center.lat]
                                }
                            }]
                        }
                    },
                    layout: {
                        "icon-image": "custom-marker",
                    }
                });
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
                new mapboxgl.Popup({ offset: [160,160] })
                .setLngLat(coordinates)
                .setHTML('<div class="padding-bottom30 "><div class="large-marker-hotel "><div class="bg-thumb" style="background: url(' + data_show.thumb + ')"></div><div class="caption"><h3 class="title">' + data_show.title + '</h3><span class="location">' + data_show.in + '</span></div></div></div>')
				.addTo(map);
            });
        var popup = new mapboxgl.Popup({ offset: [160,160] })
                .setLngLat([location_center.lng,location_center.lat])
                .setHTML('<div class="padding-bottom30 "><div class="large-marker-hotel "><div class="bg-thumb" style="background: url(' + data_show.thumb + ')"></div><div class="caption"><h3 class="title">' + data_show.title + '</h3><span class="location">' + data_show.in + '</span></div></div></div>')
				.addTo(map);
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
            description: item_map.content_html
        };
        return singleObj;
    }
    /*Mapbox gallery half*/
    if ($("#st-hotelhalf-mapbox-new").length > 0) {
		var me = $("#st-hotelhalf-mapbox-new");
        var my_div_map = jQuery("#mapbox_single_full_maphalf");
        var data_show = me.data("marker-data");
        var location_center = me.data("location");
        var data_zoom = location_center['zoom'];
        
        var markers = [];
        data_zoom = parseInt(data_zoom);
        mapboxgl.accessToken = st_params.token_mapbox;
        if(typeof st_params.text_rtl_mapbox !== 'underfind' ){
            mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
        }
        var map = new mapboxgl.Map({
          container: "mapbox_single_full_maphalf",
          style: 'mapbox://styles/mapbox/light-v10?optimize=true',
          center: [location_center.lng,location_center.lat],
          zoom: data_zoom,
        });
        var listOfObjects = [];
        jQuery.map(data_show, function (location, i) {
            var item_map = InitItemmap(location,i);
            listOfObjects.push(item_map);
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
                                    coordinates: [location_center.lng,location_center.lat]
                                }
                            }]
                        }
                    },
                    layout: {
                        "icon-image": "custom-marker",
                    }
                });
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
                new mapboxgl.Popup({ offset: [160,160] })
                .setLngLat(coordinates)
                .setHTML('<div class="padding-bottom30 "><div class="large-marker-hotel "><div class="bg-thumb" style="background: url(' + data_show.thumb + ')"></div><div class="caption"><h3 class="title">' + data_show.title + '</h3><span class="location">' + data_show.in + '</span></div></div></div>')
				.addTo(map);
            });
        var popup = new mapboxgl.Popup({ offset: [160,160] })
                .setLngLat([location_center.lng,location_center.lat])
                .setHTML('<div class="padding-bottom30 "><div class="large-marker-hotel "><div class="bg-thumb" style="background: url(' + data_show.thumb + ')"></div><div class="caption"><h3 class="title">' + data_show.title + '</h3><span class="location">' + data_show.in + '</span></div></div></div>')
				.addTo(map);
	}
});
