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
              // Defining map as a global variable to access from other functions
              var map;
              // Defining coordinates and populations of major cities in
              // Turkey as Ankara, Istanbul and Izmir
              var cities = [
                  {
                      center: new google.maps.LatLng(39.926588, 32.854614), //Ankara
                      population: 4630000
                  },
                  {
                      center: new google.maps.LatLng(41.013066, 28.976440), //Istanbul
                      population: 13710000
                  },
                  {
                      center: new google.maps.LatLng(38.427774, 27.130737),  //Izmir
                      population: 3401000
                  }
              ];

              // Defining the corner coordinates for bounding box of
              // Turkey
              var bboxSouthWest = new google.maps.LatLng(35.817813, 26.047461);
              var bboxNorthEast = new google.maps.LatLng(42.149293, 44.774902);

              function addCircle() {
                  // Iterating over the cities array to add each of them to
                  // map
                  var citiesLen = cities.length;
                  for (var i=0; i < citiesLen; i++) {
                      var circleOptions = {
                          fillColor: '#FFFF00',
                          fillOpacity: 0.55,
                          strokeColor: '#FF0000',
                          strokeOpacity: 0.7,
                          strokeWeight: 1,
                          center: cities[i].center,
                          radius: cities[i].population / 100
                      };
                      cityCircle = new google.maps.Circle(circleOptions);
                      cityCircle.setMap(map);
                  }
              }

              function addRectangle() {
                  var bounds = new google.maps.LatLngBounds(bboxSouthWest, bboxNorthEast);

                  var rectOptions = {
                      fillColor: '#A19E98',
                      fillOpacity: 0.45,
                      strokeColor: '#FF0000',
                      strokeOpacity: 0.0,
                      strokeWeight: 1,
                      map: map,
                      bounds: bounds
                  };

                  var rectangle = new google.maps.Rectangle(rectOptions);
              }

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(39.9046, 32.75926),
                          zoom: 5,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    addRectangle();
                    addCircle();
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 3 - Adding Circles and Rectangles</b><br/>
        <div id="mapDiv"></div>
    </body>
</html>