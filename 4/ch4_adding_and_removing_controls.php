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
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
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
						center: new google.maps.LatLng(43.771094,11.25033),
						zoom: 13,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						panControl:true,
						scaleControl:false,
						zoomControl:true,
						zoomControlOptions: {
							style:google.maps.ZoomControlStyle.SMALL
						},
						overviewMapControl:true,
						overviewMapControlOptions: {
							opened:true
						},
						mapTypeControl:false
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById("mapDiv");

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);
              }

           
        </script>
    </head>
    <body onload="initMap()">
        <b>Changing Default UI</b><br/>
        <div id="mapDiv"/>
    </body>
</html>