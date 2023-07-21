(function ($) {
    function InitItemmap(item_map, key) {
        var singleObj = {};
        singleObj['type'] = 'Feature';
        singleObj['geometry'] = {
            type: 'Point',
            coordinates: [item_map.lng, item_map.lat]
        };
        singleObj['properties'] = {
            title: item_map.name,
            description: item_map.content_html,
            icon_mk: item_map.icon_mk,
        };
        return singleObj;

    }
    var body = 'body.single';
    $('.st-map-box', body).each(function () {
        var parent = $(this),
            mapEl = $('.google-map-mapbox', parent);
            var mapData = mapEl.data('data_show');
        mapboxgl.accessToken = st_params.token_mapbox;
        if (typeof st_params.text_rtl_mapbox !== 'underfind' && st_params.text_rtl_mapbox !=="") {
            mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
        }
        var listOfObjects = [];
        jQuery.map(mapData, function (location, i) {
            var item_map = InitItemmap(location, i);
            listOfObjects.push(item_map);
        });

        const geojson = {
            'type': 'FeatureCollection',
            'features': listOfObjects
        };
        var map = new mapboxgl.Map({
            container: "st-map",
            style: "mapbox://styles/mapbox/streets-v10?optimize=true",
            zoom: mapEl.data().zoom,
            center: [mapEl.data().lng, mapEl.data().lat]
        });


        for (const marker of geojson.features) {
            
            // Create a DOM element for each marker.
            const el = document.createElement('div');
            el.className = 'marker';
            el.style.backgroundImage = `url(${marker.properties.icon_mk})`;

            el.style.backgroundSize = '100%';
            el.style.backgroundRepeat = 'no-repeat';
            el.style.width = '40px';
            el.style.height = '50px';
            el.style.objectFit = 'contain';
            el.className = 'marker';
            const description = marker.properties.description;
            // Add markers to the map.
            new mapboxgl.Marker(el)
                .setLngLat(marker.geometry.coordinates)
                .setPopup(
                    new mapboxgl.Popup({ offset: [150, 150] }) // add popups
                    .setHTML(
                    `${description}`
                    )
                    )
                .addTo(map);
        }

        /* Map: This represents the map on the page. */
        // var map = new mapboxgl.Map({
        //     container: "st-map",
        //     style: "mapbox://styles/mapbox/streets-v11?optimize=true",
        //     zoom: mapEl.data().zoom,
        //     center: [mapEl.data().lng, mapEl.data().lat]
        // });
        // var icon_hotel = st_params.st_icon_mapbox;
        // if (typeof icon_hotel !== 'underfind') {
        //     icon_map = icon_hotel;
        // } else {
        //     icon_map = "https://i.imgur.com/MK4NUzI.png";
        // }

        // var mapData = mapEl.data('data_show');

        // map.on("load", function () {
        //     map.resize();
        //     /* Image: An image is loaded and added to the map. */
        //     map.loadImage(icon_hotel, function (error, image) {
        //         if (error) throw error;
        //         map.addImage("custom-marker", image);
        //         /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
        //         map.addLayer({
        //             id: "markers",
        //             type: "symbol",
        //             /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
        //             source: {
        //                 type: "geojson",
        //                 data: {
        //                     type: 'FeatureCollection',
        //                     features: listOfObjects
        //                 }
        //             },
        //             layout: {
        //                 "icon-image": "custom-marker",
        //             }
        //         });
        //     });
        // });

        // map.on('click', 'markers', function (e) {
        //     map.flyTo({ center: e.features[0].geometry.coordinates });
        //     var coordinates = e.features[0].geometry.coordinates.slice();
        //     var description = e.features[0].properties.description;

        //     // Ensure that if the map is zoomed out such that multiple
        //     // copies of the feature are visible, the popup appears
        //     // over the copy being pointed to.
        //     while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
        //         coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
        //     }

        //     new mapboxgl.Popup({ offset: [150, 100] })
        //         .setLngLat(coordinates)
        //         .setHTML(description)
        //         .addTo(map);
        // });

        /*Resize map after popup modal*/
        $('#st-modal-show-map').on('shown.bs.modal', function () { // chooseLocation is the id of the modal.
            map.resize();
        });
    });


    /*Elemenent ST MapBox*/
    function initMapContactPage(mapEl) {
        var mapLat = mapEl.data('lat');
        var mapLng = mapEl.data('lng');
        mapboxgl.accessToken = st_params.token_mapbox;
        /* Map: This represents the map on the page. */
        var map = new mapboxgl.Map({
            container: "contact-mapbox-new",
            style: "mapbox://styles/mapbox/streets-v11?optimize=true",
            zoom: 13,
            center: [mapLng, mapLat]
        });

        map.on("load", function () {
            /* Image: An image is loaded and added to the map. */
            map.loadImage("https://i.imgur.com/MK4NUzI.png", function (error, image) {
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
                                    coordinates: [mapLng, mapLat]
                                }
                            }]
                        }
                    },
                    layout: {
                        "icon-image": "custom-marker",
                    }
                });
            });
            var mapCanvas = document.getElementsByClassName('mapboxgl-canvas')[0];
            mapCanvas.style.width = '100%';
            mapCanvas.style.height = '500px';
            map.resize();
        });

        /*Resize map after popup modal*/
        // $('#st-modal-show-map').on('shown.bs.modal', function () { // chooseLocation is the id of the modal.
        //     map.resize();
        // });
    }
    if ($('#contact-mapbox-new').length) {

        initMapContactPage($('#contact-mapbox-new'));
    }

})(jQuery);
