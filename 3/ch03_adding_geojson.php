<!DOCTYPE html>
<html>
    <head>
        <!-- Include JQuery Library -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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

              function drawGeometry(geom) {
                  if (geom.type == 'Point') {
                      var coordinate = new google.maps.LatLng(geom.coordinates[1], geom.coordinates[0]);
                      var marker = new google.maps.Marker({
                          position: coordinate,
                          map: map,
                          title: 'Marker'
                      });
                  }
                  else if (geom.type == 'LineString') {
                      var pointCount = geom.coordinates.length;
                      var linePath = [];
                      for (var i=0; i < pointCount; i++) {
                          var tempLatLng = new google.maps.LatLng(geom.coordinates[i][1], geom.coordinates[i][0]);
                          linePath.push(tempLatLng);
                      }

                      var lineOptions = {
                          path: linePath,
                          strokeWeight: 7,
                          strokeColor: '#19A3FF',
                          strokeOpacity: 0.8,
                          map: map
                      };
                      var polyline = new google.maps.Polyline(lineOptions);
                  }
                  else if (geom.type == 'Polygon') {
                      var pointCount = geom.coordinates[0].length;
                      var areaPath = [];
                      for (var i=0; i < pointCount; i++) {
                          var tempLatLng = new google.maps.LatLng(geom.coordinates[0][i][1], geom.coordinates[0][i][0]);
                          areaPath.push(tempLatLng);
                      }

                      var polygonOptions = {
                          paths: areaPath,
                          strokeColor: '#FF0000',
                          strokeOpacity: 0.9,
                          strokeWeight: 3,
                          fillColor: '#FFFF00',
                          fillOpacity: 0.25,
                          map: map
                      };

                      var polygon = new google.maps.Polygon(polygonOptions);
                  }
              }

              function parseGeoJSON() {
                  $.getJSON('geojson.js', function(data) {
                      $.each(data.features, function(key, val) {
                          drawGeometry(val.geometry);
                      });
                  });
              }

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(39.9078, 32.8252),
                          zoom: 6,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    parseGeoJSON();
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 3 - Adding GeoJSON to Map</b><br/>
        <div id="mapDiv"></div>
    </body>
</html>