var initRtlMapbox = null;
function initHalfMapBox(mapEl, mapData, mapLat, mapLng, mapZoom, mapIcon) {
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
    mapboxgl.accessToken = st_params.token_mapbox;
    if(typeof st_params.text_rtl_mapbox !== 'underfind' && initRtlMapbox == null){
        mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
        initRtlMapbox = 1;
    }
    var map = new mapboxgl.Map({
      container: 'map-search-form',
      style: 'mapbox://styles/mapbox/light-v10?optimize=true',
      center: [mapLng, mapLat],
      zoom: mapZoom,
    });
    var listOfObjects = [];
    jQuery.map(mapData, function (location, i) {
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

            new mapboxgl.Popup({ offset: [25 ,150] })
            .setLngLat(coordinates)
            .setHTML(description)
            .addTo(map);
        });
    });



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
