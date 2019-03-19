<!DOCTYPE html>
<html>
    <head>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        <style type="text/css">
              html { height: 100% }
              body { height: 100%; margin: 5; }
              #mapDiv { width: 800px; height: 500px; }
        </style>
        <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;

              var areaCoordinates = [
                  [40.0192,32.6953],[39.9434,32.5854],
                  [39.7536,32.6898],[39.8465,32.8106],
                  [39.9139,33.0084],[40.0318,32.9260],
                  [40.0402,32.7832],[40.0192,32.6953]
              ];

              function addPolygon () {
                  //First we iterate over the coordinates array to create a
                  // new array which includes objects of LatLng class.
                  var pointCount = areaCoordinates.length;
                  var areaPath = [];
                  for (var i=0; i < pointCount; i++) {
                      var tempLatLng = new google.maps.LatLng(areaCoordinates[i][0], areaCoordinates[i][1]);
                      areaPath.push(tempLatLng);
                  }

                  //Polygon properties are defined below
                  var polygonOptions = {
                      paths: areaPath,
                      strokeColor: '#FF0000',
                      strokeOpacity: 0.9,
                      strokeWeight: 3,
                      fillColor: '#FFFF00',
                      fillOpacity: 0.25
                  }

                  var polygon = new google.maps.Polygon(polygonOptions);

                  //Polygon is set to current map.
                  polygon.setMap(map);
              }

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(39.9046, 32.75926),
                          zoom: 10,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    addPolygon();
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 3 - Adding Polygons</b><br/>
        <div id="mapDiv"></div>
    </body>
</html>