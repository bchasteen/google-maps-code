<!DOCTYPE html>
<html>
    <head>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        <script type="text/javascript" src="lib/wms.js"></script>
        <style type="text/css">
              #mapDiv { width: 800px; height: 500px; }
        </style>
        <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(38.87, -94.63),
                          zoom: 4,
                          mapTypeId: google.maps.MapTypeId.HYBRID
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    //Creating WMS options
                    var wmsOptions = {
                        baseUrl: 'http://demo.cubewerx.com/cubewerx/cubeserv.cgi?',
                        layers: 'Foundation.gtopo30',
                        version: '1.1.1', //'1.3.0',
                        styles: 'default',
                        format: 'image/png'
                    };

                    //Creating WMS Layer
                    var wmsLayer = new WMSUntiled(map, wmsOptions);
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 8 - Adding WMS Layers</b><br/>
        <div id="mapDiv"></div>
    </body>
</html>