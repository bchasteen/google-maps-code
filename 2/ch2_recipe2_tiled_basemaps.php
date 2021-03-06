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
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>">
        </script>
        
  <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
              function initMap() {
              		
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map with mapTypeIds including the new style
                    var mapOptions = {
						center: new google.maps.LatLng(39.9078, 32.8252),
						zoom: 10,
						mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'OSM']}
					};
					
					//Getting map DOM element
                    var mapElement = document.getElementById("mapDiv");

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);
					
					//Defining OSM Map Type
					var osmMapType = new google.maps.ImageMapType({
   			         	getTileUrl: function(coord, zoom) {
                    		return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
                		},
                		tileSize: new google.maps.Size(256, 256),
                		name: "OpenStreetMap",
                		maxZoom: 18
            		});
            		
            		//relate new mapTypeId to the ImageMapType - osmMapType object
					map.mapTypes.set('OSM', osmMapType);
					
					//set this new mapTypeId to be displayed
					map.setMapTypeId('OSM');
					
              }

           
        </script>
    </head>
    <body onload="initMap()">
        <b>Tiled Basemaps</b><br/>
        <div id="mapDiv"/>
    </body>
</html>