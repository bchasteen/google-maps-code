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
              
              //define global geocoder object
			  var geocoder;
			  
			  //define global marker popup variable
			  var popup;
              
              function initMap() {
                    //initialize geocoder object
					geocoder = new google.maps.Geocoder();
					
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
						drawingMode:null,
						//enable the drawingControl to be seen in the UI
						drawingControl:true,
						//select which drawing modes to be seen in the drawingControl and position them
						drawingControlOptions: {
							//select a position in the UI
							position: google.maps.ControlPosition.TOP_CENTER,
							//selected drawing modes to be seen in the control
							drawingModes: [
								google.maps.drawing.OverlayType.MARKER
							]
						}
					});
					
					//enable drawing functionality
					drawingManager.setMap(map);
					
					//add event listener for completion of your marker
					google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
						
						//get the LatLng object of the marker, it is necessary for the geocoder
						var markerPosition = marker.getPosition();
						
						//reverse geocode the LatLng object to return the addresses
						geocoder.geocode({'latLng': markerPosition}, function(results, status) {
      						//if the service is working properly...
      						if (status == google.maps.GeocoderStatus.OK) {
        						//Array of results will return if everything is OK
        						if (results) {
        							//infowindow stuff
        							showAddressOfResult(results[0],marker);
        						}
      						} 
      						//if the service is not working, deal with it
      						else {
        						alert("Reverse Geocoding failed because: " + status);
      						}
    					});	
					});
					
					//function for displaying the address on the infowindow
					function showAddressOfResult(result, marker) {
						map.setCenter(marker.getPosition());
						map.setZoom(13);

						var popupContent = '<b>Address: </b> ' + result.formatted_address;
						popup.setContent(popupContent);
						popup.open(map, marker);
					
					}
              }  
        </script>
    </head>
    <body onload="initMap()">
        <b>Finding Address on Map Click</b><br/>
        <div id="mapDiv"/>
    </body>
</html>