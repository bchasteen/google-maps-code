<!DOCTYPE html>
<html>
    <head>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
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
                          center: new google.maps.LatLng(39.9078, 32.8252),
                          zoom: 10,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    google.maps.event.addListener(map, 'click', function(e) {
                        if (infowindow != null)
                            infowindow.close();

                        infowindow = new google.maps.InfoWindow({
                            content: '<b>Mouse Coordinates : </b><br><b>Latitude : </b>' + e.latLng.lat() + '<br><b>Longitude: </b>' + e.latLng.lng(),
                            position: e.latLng
                        });
                        infowindow.open(map);
                    });
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 5 - Getting Coordinates of a mouse click</b>
        <div id="mapDiv"></div>
    </body>
</html>