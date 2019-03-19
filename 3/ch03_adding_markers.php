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
              //Defining min and max latitudes and longitudes to create random markers
              var minLat = 36,
                  maxLat = 42,
                  minLng = 25,
                  maxLng = 44,
                  markerId = 1;

              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(39.9078, 32.8252),
                          zoom: 5,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    startButtonEvents();
              }

              //Function that start listening the click events of the buttons.
              function startButtonEvents() {
                    document.getElementById('addStandardMarker').addEventListener('click', function(){
                        addStandardMarker();
                    });

                    document.getElementById('addIconMarker').addEventListener('click', function(){
                        addIconMarker();
                    });
              }

              function createRandomLatLng() {
                    var deltaLat = maxLat - minLat;
                    var deltaLng = maxLng - minLng;
                    var rndNumLat = Math.random();
                    var newLat = minLat + rndNumLat * deltaLat;
                    var rndNumLng = Math.random();
                    var newLng = minLng + rndNumLng * deltaLng;
                    return new google.maps.LatLng(newLat, newLng);
              }

              function addStandardMarker() {
                    var coordinate = createRandomLatLng();
                    var marker = new google.maps.Marker({
                        position: coordinate,
                        map: map,
                        title: 'Random Marker - ' + markerId
                    });
                    //If you don’t specify a Map during the initialization of the Marker you can add it later using the line below
                    //marker.setMap(map);
                    markerId++;
              }

              function addIconMarker() {
                    var markerIcons = ['coffee', 'restaurant_fish', 'walkingtour', 'postal', 'airport'];
                    var rndMarkerId = Math.floor(Math.random() * markerIcons.length);
                    var coordinate = createRandomLatLng();
                    var marker = new google.maps.Marker({
                      position: coordinate,
                      map: map,
                      icon: 'img/' + markerIcons[rndMarkerId] + '.png',
                      title: 'Random Marker - ' + markerId
                    });
                    markerId++;
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 3 - Adding Markers</b><br/>
        <a id="addStandardMarker" href="#">Add Standard Marker</a>
        |
        <a id="addIconMarker" href="#">Add Icon Marker</a>
        <div id="mapDiv"></div>
    </body>
</html>