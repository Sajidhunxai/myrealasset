(function ($) {
  function getCenter($coord_array) {
    $i = 1;
    $center = $coord_array[0] || [0, 0];
    if ( $coord_array.length > 1 ) {
      for ($i; $i <= $coord_array.length; $i++ ) {
        $coord = $coord_array[$i];
        $plat = $coord[0];
        $plng = $coord[1];
        $clat = $center[0];
        $clng = $center[1];
        $mlat = ($plat + ($clat * $i)) / ($i + 1);
        $mlng = ($plng + ($clng * $i)) / ($i + 1);
        $center = [$mlat, $mlng];
        $i++;
      }
      return [$mlat, $mlng];
    } else {
      return $center;
    }
  }

  var initMapboxCustom = function (el) {
    if (typeof mapboxgl != 'undefined' && mapboxgl) {
      if (st_mapbox_params && st_mapbox_params.access_token) {
        mapboxgl.accessToken = st_mapbox_params.access_token;
      }
      let mapZoom = $('#' + el).data('map-zoom') || 12;
      var bounds = [];
      var arr_json_features = [];
      if (list_lnglat) {
        list_lnglat.forEach(function (item) {
          arr_json_features.push({
            "type": "Feature",
            "geometry": {
              "type": "Point",
              "coordinates": item
            }
          });
        });
      }

      var map = new mapboxgl.Map({
        container: el, // Container ID
        style: 'mapbox://styles/mapbox/streets-v11?optimize=true', // Map style to use
        center: getCenter(list_lnglat),
        zoom: mapZoom
      });

      map.on("load", function () {
        map.resize();
        map.addSource("national-park", {
          "type": "geojson",
          "data": {
            "type": "FeatureCollection",
            "features": arr_json_features
          }
        });

        map.addLayer({
          "id": "park-boundary",
          "type": "fill",
          "source": "national-park",
          "paint": {
            "fill-color": "#F9F9F9",
            "fill-opacity": 0.8
          },
          "filter": ["==", "$type", "Polygon"]
        });

        map.addLayer({
          "id": "park-volcanoes",
          "type": "circle",
          "source": "national-park",
          "paint": {
            "circle-radius": 6,
            "circle-color": "#5191FA"
          },
          "filter": ["==", "$type", "Point"],
        });
      });

      map.scrollZoom.disable();
    }
  }

  if ( st_mapbox_params && st_mapbox_params.st_googlemap_enabled == 'on' ) {
    if ($('#st-hotel-alone-googlemap').length) {
      if (typeof google != 'undefined' ) {
        var center = getCenter(list_lnglat);
        let mapZoom = $('#st-hotel-alone-googlemap').data('map-zoom') || 12;
        var map = new google.maps.Map(document.getElementById('st-hotel-alone-googlemap'), {
          zoom: mapZoom
        });
        if (center && center[0] && center[1]) {
          map.setCenter({lat: center[1], lng: center[0]});
        }
        var marker, count;
        if (list_lnglat) {
          for (count = 0; count < list_lnglat.length; count++) {
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(list_lnglat[count][1], list_lnglat[count][0]),
              map: map
            });
          }
        }
      }
    }
  } else {
    initMapboxCustom('st-hotel-alone-mapbox');
  }
})(jQuery);
