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
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&libraries=visualization">
        </script>
		
		<script type="text/javascript" src="ch2_heatMapPoints.js">
		</script>
	
  <!-- Map creation is here -->
        <script type="text/javascript">
              var map;
              function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(41.0083746002077,28.971582399708),
                          zoom: 13,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById("mapDiv");

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);
					
					//Creating the heatmap layer
					var heatmap = new google.maps.visualization.HeatmapLayer({
						data: heatmapPoints
					});
					
					//Adding heatmap layer to the map
					heatmap.setMap(map);
              }

           
        </script>
    </head>
    <body onload="initMap()">
        <b>Heatmaps</b><br/>
        <div id="mapDiv"/>
    </body>
</html>