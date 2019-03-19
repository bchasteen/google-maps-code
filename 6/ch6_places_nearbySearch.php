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
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&libraries=drawing,places&sensor=false">
        </script>
        
  <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
			  //define a global circles array variable, to push and pop the circle overlays
			  var circles;
			  //define a global markers array variable, to push and pop the circle overlays
			  var markers;
			  //define global marker popup variable
			  var popup;
			  
              function initMap() {
                    //initialize circles array
					circles = new Array();
					
					//initialize markers array
					markers = new Array();
					
					//initialize info popup window
					popup = new google.maps.InfoWindow();
					
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
						drawingMode:google.maps.drawing.OverlayType.CIRCLE,
						//enable the drawingControl to be seen in the UI
						drawingControl:true,
						//select which drawing modes to be seen in the drawingControl and position them
						drawingControlOptions: {
							//select a position in the UI
							position: google.maps.ControlPosition.BOTTOM_CENTER,
							//selected drawing modes to be seen in the control
							drawingModes: [
								google.maps.drawing.OverlayType.CIRCLE
							]
						}
					});
					
					//enable drawing functionality
					drawingManager.setMap(map);
					
					//add event listener for completion of your circle
					google.maps.event.addListener(drawingManager, 'circlecomplete', function(circle) {
						//exit the circle drawing mode
						drawingManager.setDrawingMode(null);
						
						//add the latest drawn circle to the circles array
						circles.push(circle);
						//reverse the circles array, to pop the previous drawn circle 
						circles.reverse();
						
						//pop the previous circle and set its map handle to null, so that only last drawn circle is shown
						while(circles[1])
						{
							circles.pop().setMap(null);
						}
						
						
						//clear all previously drawn markers
						while(markers[0])
						{
							markers.pop().setMap(null);
						}
						
						//the nearbySearchg request setting its center as the circle center and setting its radius as the circle radius
						//the keyword is 'pizza', so places having 'pizza' keyword will be returned
						var nearbyPlacesRequest = {
							location: circle.getCenter(),
							radius: circle.radius,
							keyword: 'pizza'
						};
						
						//get the handle for PlacesService service
						var placesService = new google.maps.places.PlacesService(map);
						//send the request with a callback
						placesService.nearbySearch(nearbyPlacesRequest, resultsCallback);
					});	
				}
			
				//the callback function that returns the places
				function resultsCallback(results, status) {
					//checking the service status
					if (status == google.maps.places.PlacesServiceStatus.OK) {
						//getting the results array containing the places
						for (var i = 0, l=results.length; i < l; i++) {
							//put a marker in the map and attach a infowindow to display its details
							pinpointResult(results[i]);
						}
					}
				}

				//put a marker in the map and attach a infowindow to display its details
				function pinpointResult(result) {
					//marker stuff
					var marker = new google.maps.Marker({
						map: map,
						position: result.geometry.location
					});

					//infowindow stuff
					google.maps.event.addListener(marker, 'click', function() {
						//debugger;
						var popupContent = '<b>Name: </b> ' + result.name + '<br/>' + '<b>Vicinity: </b>' + result.vicinity + '<br/><b>Rating: </b>' + result.rating; 
						popup.setContent(popupContent);
						popup.open(map, this);
					});
				
					//add the latest drawn marker to the markers array
					markers.push(marker);
				}
				
        </script>
    </head>
    <body onload="initMap()">
        <b>Places - Nearby Search</b><br/>
        <div id="mapDiv"/>
    </body>
</html>