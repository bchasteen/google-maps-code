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

              var lineCoordinates = [
                  [41.01306,29.14672],[40.8096,29.4818],
                  [40.7971,29.9761],[40.7181,30.4980],
                  [40.8429,31.0253],[40.7430,31.6241],
                  [40.7472,32.1899],[39.9097,32.8216]
              ];

              function addPolyline () {
                  //First we iterate over the coordinates array to create a
                  // new array which includes objects of LatLng class.
                  var pointCount = lineCoordinates.length;
                  var linePath = [];
                  for (var i=0; i < pointCount; i++) {
                      var tempLatLng = new google.maps.LatLng(lineCoordinates[i][0], lineCoordinates[i][1]);
                      linePath.push(tempLatLng);
                  }

                  //Polyline properties are defined below
                  var lineOptions = {
                      path: linePath,
                      strokeWeight: 7,
                      strokeColor: '#FF0000',
                      strokeOpacity: 0.8
                  }
                  var polyline = new google.maps.Polyline(lineOptions);

                  //Polyline is set to current map.
                  polyline.setMap(map);
              }

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(40.17694, 30.8806),
                          zoom: 7,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    addPolyline();
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 3 - Adding Lines</b><br/>
        <div id="mapDiv"></div>
    </body>
</html>