<!DOCTYPE html>
<html>
    <head>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        <style type="text/css">
              #mapDiv { width: 800px; height: 500px; }
              .mapControl {
                  width: 165px;
                  height: 55px;
                  background-color: #FFFFFF;
                  border-style: solid;
                  border-width: 1px;
                  padding: 2px 5px;
              }
        </style>
        <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
              var customObject;

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(39.9078, 32.8252),
                          zoom: 10,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    //Creating Table of Contents Control.
                    createTOCControl();

                    //Creating custom object from Google Maps JS Base Class
                    customObject = new google.maps.MVCObject();

                    //Start listening custom object's custom event
                    google.maps.event.addListener(customObject, 'customEvent', function (e) {
                        var txt = '';
                        if(e.isChecked) {
                            txt = e.layerName + ' layer is added to the map';
                        }
                        else {
                            txt = e.layerName + ' layer is removed from the map';
                        }
                        alert(txt);
                    });
              }

              function createTOCControl () {
                    var controlDiv = document.createElement('div');
                    controlDiv.className = 'mapControl';
                    controlDiv.id = 'layerTable';
                    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
                    var html = '<b>Map Layers</b><br/>';
                    html = html + '<input type="checkbox" onclick="checkLayers(this)" value="geojson">GeoJSON Layer<br/>';
                    html = html + '<input type="checkbox" onclick="checkLayers(this)" value="marker">Marker Layer';
                    controlDiv.innerHTML = html;
              }

              function checkLayers(cb) {
                    //Firing customEvent with trigger function.
                    google.maps.event.trigger(customObject, 'customEvent', {layerName: cb.value, isChecked: cb.checked});
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 5 - Creating your own events</b>
        <div id="mapDiv"></div>
    </body>
</html>