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
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&libraries=drawing&sensor=false">
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
                          center: new google.maps.LatLng(39.9078, 32.8252),
                          zoom: 10,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById("mapDiv");

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);
					
					//creating drawingManager
					var drawingManager = new google.maps.drawing.DrawingManager({
						//initial drawing tool to be enabled
						drawingMode:google.maps.drawing.OverlayType.POLYGON,
						//enable the drawingControl to be seen in the UI
						drawingControl:true,
						//select which drawing modes to be seen in the drawingControl and position them
						drawingControlOptions: {
							//select a position in the UI
							position: google.maps.ControlPosition.BOTTOM_CENTER,
							//selected drawing modes to be seen in the control
							drawingModes: [
								google.maps.drawing.OverlayType.MARKER,
								google.maps.drawing.OverlayType.POLYGON,
								google.maps.drawing.OverlayType.POLYLINE,
							]
						},
						//specific drawing mode options, this one for polyline
						polylineOptions: {
							strokeColor:'red',
							strokeWeight:3
						},
						//specific drawing mode options, this one for polygon
						polygonOptions: {
							strokeColor:'blue',
							strokeWeight:3,
							fillColor:'yellow',
							fillOpacity:0.2
						}
					});
					
					//enable drawing functionality
					drawingManager.setMap(map);
					
					//add event listener for completion of your polygon
					google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
						polygon.setEditable(true);
						polygon.setDraggable(true);
					});
              }  
        </script>
    </head>
    <body onload="initMap()">
        <b>Drawing Events</b><br/>
        <div id="mapDiv"/>
    </body>
</html>