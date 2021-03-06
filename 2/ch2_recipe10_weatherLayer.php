<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
              html { height: 100% }
              body { height: 100%; margin: 5; }
              #mapDiv { width: 800px; height: 500px; }
        </style>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&libraries=weather">
        </script>
        
  <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(38.0, 20.4),
                          zoom: 5,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById("mapDiv");

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);
					
					 var weatherLayer = new google.maps.weather.WeatherLayer({
						temperatureUnits: google.maps.weather.TemperatureUnit.CELCIUS
					});
					weatherLayer.setMap(map);
					
					var cloudLayer = new google.maps.weather.CloudLayer();
					cloudLayer.setMap(map);
					
           }

           
        </script>
    </head>
    <body onload="initMap()">
        <b>Weather Layers</b><br/>
        <div id="mapDiv"/>
    </body>
</html>