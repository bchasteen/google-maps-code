<!DOCTYPE html>
<html>
    <head>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        <script src="lib/wms-tiled.js"></script>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <style type="text/css">
              #mapDiv { width: 800px; height: 500px; }
        </style>
        <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
              var infowindow = null;

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(38.83577, -101.331660),
                          zoom: 4,
                          mapTypeId: google.maps.MapTypeId.ROAD
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    //Creating a tiled WMS Service and adding it to the map
                    var tiledWMS = new WMSTiled({
                        url: 'http://localhost:8080/geoserver/topp/wms?service=WMS',
                        version: '1.1.1',
                        layers: 'topp:states',
                        styles: ''
                    });
                    map.overlayMapTypes.push(tiledWMS);

                    //Creating a WMSFeatureInfo class to get info from map.
                    var WMSInfoObj = new WMSFeatureInfo(map, {
                        url: 'http://localhost:8080/geoserver/topp/wms?',
                        version: '1.1.1',
                        layers: 'topp:states',
                        callback: 'getLayerFeatures'
                    });

                    //Listening map click event to get feature info.
                    google.maps.event.addListener(map, 'click', function(e) {
                        //WMS Feature Info URL is prepared by the help of
                        //getUrl method of WMSFeatureInfo object created before
                        var url = WMSInfoObj.getUrl(e.latLng);
                        $.ajax({
                            url : url,
                            dataType: 'jsonp',
                            jsonp: false,
                            jsonpCallback: 'getLayerFeatures'
                        }).done(function(data) {
                            if (infowindow != null) {
                                infowindow.close();
                            }

                            var info = '<b>State Name : </b>' + data.features[0].properties.STATE_NAME + '<br><b>Population : </b>' + data.features[0].properties.SAMP_POP;
                            infowindow = new google.maps.InfoWindow({
                                content: info,
                                position: e.latLng
                            });

                            infowindow.open(map);
                        });
                    });
              }

              google.maps.event.addDomListener(window, 'load', initMap);

        </script>
    </head>
    <body>
        <b>Chapter 8 - Accessing GeoServer</b><br/>
        <div id="mapDiv"></div>
    </body>
</html>