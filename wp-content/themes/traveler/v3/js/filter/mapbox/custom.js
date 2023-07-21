var initRtlMapbox = null;
var markerMapBoxGolbal = [];
var mapMapboxGobal;
var ii = 0;
var mapImg;

function initHalfMapBox(mapEl, mapData, mapLat, mapLng, mapZoom, mapIcon, mapVersion, isMapMove) {
    var popupPos = mapEl.data('popup-position');
    if (mapData.length <= 0)
        mapData = mapEl.data('data_show');
    if (mapLat.length <= 0)
        mapLat = mapEl.data('lat');
    if (mapLng.length <= 0)
        mapLng = mapEl.data('lng');
    if (mapZoom.length <= 0)
        mapZoom = mapEl.data('zoom');
    if (mapIcon.length <= 0)
        mapIcon = mapEl.data('icon');
    mapboxgl.accessToken = st_params.token_mapbox;
    var icon_mapbox = st_params.st_icon_mapbox;
    if(typeof icon_mapbox !== 'underfind' ){
        icon_map = icon_mapbox;
    } else {
        icon_map = "https://i.imgur.com/MK4NUzI.png";
    }

    console.log(mapZoom);
    if(typeof isMapMove === 'undefined')
        isMapMove = false;

    if(typeof st_params.text_rtl_mapbox !== 'underfind' && initRtlMapbox == null){
        mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
        initRtlMapbox = 1;
    }

    if(!isMapMove) {
        
        if(document.getElementById("map-search-form")){
            mapMapboxGobal = new mapboxgl.Map({
                container: 'map-search-form',
                style: 'mapbox://styles/mapbox/light-v10?optimize=true',
                center: [mapLng, mapLat],
                zoom: mapZoom,
            });
        }
    }

    if(isMapMove){
        mapMapboxGobal.removeLayer('markers_' + ii);
        markerMapBoxGolbal.map((item, iii) => {
            item.remove();
        })
        ii++;
    }

    var bounds = new mapboxgl.LngLatBounds();

    var listOfObjects = [];
    jQuery.map(mapData, function (location, i) {
        var item_map = InitItemmap(location,i);
        listOfObjects.push(item_map);

        const el = document.createElement('div');
        el.innerHTML = '<div class="inner" data-marker-id="'+ location.id +'">' + jQuery(location.content_adv_html).find('.item_price_map span').text() + '</div>';
        el.className = 'stt-price-label';
        markerMapBoxGolbal[i] = new mapboxgl.Marker(el).setLngLat(item_map.geometry.coordinates).addTo(mapMapboxGobal);
        bounds.extend(item_map.geometry.coordinates);
    });

    mapMapboxGobal.addControl(new mapboxgl.NavigationControl({showCompass: false}), 'bottom-right');
    mapMapboxGobal.scrollZoom.disable();
    mapMapboxGobal.scrollZoom.setWheelZoomRate(0.02);
    mapMapboxGobal.dragRotate.disable();
    mapMapboxGobal.touchZoomRotate.disableRotation();

    if(isMapMove){
            /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
            mapMapboxGobal.addLayer({
                id: "markers_" + ii,
                type: "symbol",
                source: {
                    type: "geojson",
                    data: {
                        type: 'FeatureCollection',
                        features: listOfObjects
                    }
                },
                layout: {
                    "icon-image": "custom-marker",
                }
            });

        mapMapboxGobal.on('click', "markers_" + ii, function (e) {
            mapMapboxGobal.flyTo({center: e.features[0].geometry.coordinates});
            var coordinates = e.features[0].geometry.coordinates.slice();
            var description = e.features[0].properties.description;

            // Ensure that if the map is zoomed out such that multiple
            // copies of the feature are visible, the popup appears
            // over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            new mapboxgl.Popup({offset: [150, 150]})
                .setLngLat(coordinates)
                .setHTML(description)
                .addTo(mapMapboxGobal);
        });

        setTimeout(function() {
            let toggleMap = document.getElementById('st-toggle-map');
            toggleMap.onclick = function() {
                console.log(bounds)
                mapMapboxGobal.resize();
                mapMapboxGobal.fitBounds(bounds);
            }
        }, 2000)
    }else {
        mapMapboxGobal.on("load", function () {
            mapMapboxGobal.loadImage(icon_map, function (error, image) {
                mapImg = image;
                if (error) throw error;
                mapMapboxGobal.addImage("custom-marker", image);
                /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                mapMapboxGobal.addLayer({
                    id: "markers_" + ii,
                    type: "symbol",
                    source: {
                        type: "geojson",
                        data: {
                            type: 'FeatureCollection',
                            features: listOfObjects
                        }
                    },
                    layout: {
                        "icon-image": "custom-marker",
                    }
                });
            });
            mapMapboxGobal.on('click', "markers_" + ii, function (e) {
                mapMapboxGobal.flyTo({center: e.features[0].geometry.coordinates});
                var coordinates = e.features[0].geometry.coordinates.slice();
                var description = e.features[0].properties.description;

                // Ensure that if the map is zoomed out such that multiple
                // copies of the feature are visible, the popup appears
                // over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup({offset: [0, -30]})
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(mapMapboxGobal);
            });
        });
    }

    if(mapVersion === 'elementorv2') {

        let toggleMap = jQuery('#st-toggle-map');
        toggleMap.on('click', function() {
            if(jQuery(this).hasClass('open')){
                mapMapboxGobal.resize()
                mapMapboxGobal.fitBounds(bounds);
            }else{
                mapMapboxGobal.on('idle',function(){
                    mapMapboxGobal.resize()
                })
                mapMapboxGobal.fitBounds(bounds);
            }
        });

        mapMapboxGobal.on('dragend', (e) => {
            var moveLat = mapMapboxGobal.getCenter().lat;
            var moveLng = mapMapboxGobal.getCenter().lng;
            if (jQuery('#st-move-map').length) {
                if (jQuery('#st-move-map').is(':checked')) {
                    let distance = getMapDistanceMapbox(mapMapboxGobal);
                    jQuery('#st-map-coordinate').val(moveLat + '_' + moveLng + '_' + distance).trigger('change');
                }
            }
        });

        mapMapboxGobal.on('zoomend', (e) => {
            var moveLat = mapMapboxGobal.getCenter().lat;
            var moveLng = mapMapboxGobal.getCenter().lng;
            if (jQuery('#st-move-map').length) {
                if (jQuery('#st-move-map').is(':checked')) {
                    let distance = getMapDistanceMapbox(mapMapboxGobal);
                    jQuery('#st-map-coordinate').val(moveLat + '_' + moveLng + '_' + distance).trigger('change');
                }
            }
        });
    }


}

function getMapDistanceMapbox(map) {
    var bounds = map.getBounds();
    var center = bounds.getCenter();
    var ne = bounds.getNorthEast();
    var r = 3963.0;
    var lat1 = center.lat / 57.2958;
    var lon1 = center.lng / 57.2958;
    var lat2 = ne.lat / 57.2958;
    var lon2 = ne.lng / 57.2958;
    var dis = r * Math.acos(Math.sin(lat1) * Math.sin(lat2) +
        Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));
    return dis;
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
function clickPoup(mapLng,mapLat) {
    var map = new mapboxgl.Map({
      container: 'map-search-form',
      style: 'mapbox://styles/mapbox/light-v10?optimize=true',
      center: [mapLng, mapLat],
      zoom: 6,
    });
}
