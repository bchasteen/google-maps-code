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
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&libraries=drawing,geometry&sensor=false">
        </script>
        
  <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
			  
				function initMap() {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;
					
					//extend the Polygon class to have getArea() function
					google.maps.Polygon.prototype.getArea=function(){
						var area = google.maps.geometry.spherical.computeArea(this.getPath());
						return area;
					};
					
					//extend the Polygon class to have getLength() function
					google.maps.Polygon.prototype.getLength=function(){
						var length = google.maps.geometry.spherical.computeLength(this.getPath());
						return length;
					};
					
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
						//get the coordinate array of your polygon
						var path = polygon.getPath();
						//calculate area
						var area = google.maps.geometry.spherical.computeArea(path);
						//calculate length
						var length = google.maps.geometry.spherical.computeLength(path);
						//print the area & length
						console.log('Polygon Area: ' +  area/1000000 + ' km sqs');
						console.log('Polygon Length: ' +  length/1000 + ' kms');
					});
					
					//add event listener for completion of your polyline
					google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polyline) {
						//get the coordinate array of your polyline
						var path = polyline.getPath();
						//calculate length
						var length = google.maps.geometry.spherical.computeLength(path);
						//print the length
						console.log("Polyline Length: " +  length/1000 + " kms");
					});
				}
        </script>
    </head>
    <body onload="initMap()">
        <b>Calculating Length and Area</b><br/>
        <div id="mapDiv"/>
    </body>
</html>