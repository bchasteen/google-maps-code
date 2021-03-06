<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
              html { height: 100% }
              body { height: 100%; margin: 5; }
			  #mapDivContainer { width: 800px; height: 500px;}
              #mapDiv { width: 100%; height: 100%; }
			  #loggingDiv { width: 800px; height: 300px;}
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
						drawingMode:null,
						//enable the drawingControl to be seen in the UI
						drawingControl:true,
						//select which drawing modes to be seen in the drawingControl and position them
						drawingControlOptions: {
							//select a position in the UI
							position: google.maps.ControlPosition.BOTTOM_CENTER,
							//selected drawing modes to be seen in the control
							drawingModes: [
								google.maps.drawing.OverlayType.POLYLINE,
								google.maps.drawing.OverlayType.POLYGON
							]
						},
						//specific drawing mode options, this one for polyline
						polylineOptions: {
							strokeColor:'red',
							strokeWeight:3
						}
					});
					
					//enable drawing functionality
					drawingManager.setMap(map);
					
					//add event listener for completion of your polygon
					google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polyline) {
						//get the coordinate array of your polyline as MVCArray object
						var path = polyline.getPath();
						//convert MVCArray object to ordinary JavaScript array
						var coords = path.getArray();
						
						var text;
						//Print the coordinate pair array as a whole
						text = '<b>Original Coordinates:</b> ' + coords;
						//encode the coordinate pairs of the polyline
						var encodedCoords = google.maps.geometry.encoding.encodePath(path);
						//Print the encoded string of the coordinate array
						text += '<br/><b>Encoded Coordinates:</b> ' + encodedCoords;
						//decode the encoded coordinates
						var decodedCoords = google.maps.geometry.encoding.decodePath(encodedCoords);
						//print the decoded coordinate array
						text += '<br/><b>Decoded Coordinates:</b> ' + decodedCoords;
						
						loggingDiv.innerHTML = text;
					});
					
					loggingDiv = document.getElementById('loggingDiv');
					
              }  
        </script>
    </head>
    <body onload="initMap()">
        <h3>Coordinate Encoding</h3>
        <div id="mapDivContainer">
			<div id="mapDiv"></div>
		</div>
		<div>
			<h3>Original, Encoded and Decoded Coordinate Pairs:</h3>
			<div id="loggingDiv"></div>
		</div>
    </body>
</html>