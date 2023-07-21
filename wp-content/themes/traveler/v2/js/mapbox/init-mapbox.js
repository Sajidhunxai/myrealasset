/**
 * Created by me664 on 1/20/15.
 */
jQuery(function($) {
   // $('.bt_ot_gmap_wrap').each(function(){
        var self=$(this);
        var gmap_el=$('.st-field-address_autocomplete').find('.bt_ot_gmap');
        var bt_ot_gmap_input_lat=$('.st-field-map').find('#st-map-lat');
        var bt_ot_gmap_input_lng=$('.st-field-map').find('#st-map-lng');
        var bt_ot_gmap_input_zoom=$('.st-field-map').find('#st-map-zoom');
        var st_token_mapbox =st_params.token_mapbox;
        var gmap_obj;
        var current_marker,old_lat=37,old_lng=2,old_zoom=17;
        var    markers=[];

        if(bt_ot_gmap_input_lat.val()){
            old_lat=bt_ot_gmap_input_lat.val();
            old_lat=parseFloat(old_lat);
        }
        if(bt_ot_gmap_input_lng.val()){
            old_lng=bt_ot_gmap_input_lng.val();
            old_lng=parseFloat(old_lng);
        }
        if(bt_ot_gmap_input_zoom.val()){
            old_zoom=bt_ot_gmap_input_zoom.val();
            old_zoom=parseFloat(old_zoom);
        }


        /*Resize map after popup modal*/
            var icon_mapbox = st_params.st_icon_mapbox;
            if(typeof icon_mapbox !== 'underfind' ){
                icon_map = icon_mapbox;
            } else {
                icon_map = "https://i.imgur.com/MK4NUzI.png";
            }
            mapboxgl.accessToken = st_params.token_mapbox;
            if(typeof st_params.text_rtl_mapbox !== 'underfind' ){
                mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
            }
            /*Search */
            mapboxgl.accessToken = st_token_mapbox;
            var map = new mapboxgl.Map({
                container: 'st_mapbox_custom',
                style: 'mapbox://styles/mapbox/streets-v11?optimize=true',
                center: [old_lng, old_lat],
                zoom: old_zoom,
            });
            map.on("load", function() {
                map.resize();
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
                                features: [{
                                    type: 'Feature',
                                    properties: {},
                                    geometry: {
                                        type: "Point",
                                        coordinates: [old_lng, old_lat]
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

            var geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl
            });

            document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
            geocoder.on('result', function (result) {
                new_long=parseFloat(result.result.center[0]);
                new_lat=parseFloat(result.result.center[1]);
                bt_ot_gmap_input_lat.val(new_lat);
                bt_ot_gmap_input_lng.val(new_long);
            });

            $('#st-modal-show-map').on('shown.bs.modal', function () { // chooseLocation is the id of the modal.
                map.resize();
             });

    // });

});
