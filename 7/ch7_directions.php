<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
              html { height: 100% }
              body { height: 100%; margin: 5px; }
              #MapDiv { width: 100%; height: 95%; }
			  #MapContainerDiv { padding:10px; float:left; width: 55%; height: 600px;}
			  #DirectionsContainerDiv { padding:5px; float:right; width: 40%; height: 600px;}
			  #DirectionsListDiv {overflow-y: auto; max-height:300px;}
			  ul.addressList {list-style-type:circle;}
        </style>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&libraries=places&sensor=false">
        </script>
        
  <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
			  
			  //define global marker popup variable
			  var popup;
			  
			  //define global geocoder object
			  var geocoder;
			  
			  //define global markers array
			  var markers;
			  
			  //define global DirectionsService object
			  var directionsService;
			  
			  //define global DirectionsRenderer object
			  var directionsRenderer;
			  
              function initMap() {
					//initialize info popup window
					popup = new google.maps.InfoWindow();
					
					//initialize geocoder object
					geocoder = new google.maps.Geocoder();
					
					//initialize markers array
					markers = [];
					
					//initialize directionsService object
					directionsService = new google.maps.DirectionsService();
					
					//initialize directionsRenderer object
					directionsRenderer = new google.maps.DirectionsRenderer();
					
					//Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(39.9078, 32.8252),
                          zoom: 10,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById("MapDiv");

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);
					
					//directionsRenderer will draw the directions on current map
					directionsRenderer.setMap(map);
					//directionsRenderer will list the textual description of the directions 
					//on directionsDiv HTML element
					directionsRenderer.setPanel(document.getElementById('DirectionsListDiv'));			
				}
			
				//put a marker in the map and attach a infowindow to display its details
				function pinpointResult(result) {
					var marker = new google.maps.Marker({
						map: map,
						position: result.geometry.location,
						zIndex: -10
					});
					
					map.setCenter(result.geometry.location);
					map.setZoom(16);

					//infowindow stuff
					google.maps.event.addListener(marker, 'click', function() {
						//debugger;
						var popupContent = '<b>Address: </b> ' + result.formatted_address;
						popup.setContent(popupContent);
						popup.open(map, this);
					});
					
					markers.push(marker);
				}
				
				//function for listing addresses on the addressList HTML element
				function listAddresses()
				{
					//get text input handler
					var addressField = document.getElementById('addressField');
					//get addressList <ul> element handle
					var addressList = document.getElementById('addressList');
					if (addressList.children.length == 0)
					{
						var placesText = document.getElementById('placesText');
						placesText.innerHTML = 'Places You Have Visited (Click on the place name to see on map):';
					}
					//create a list item
					var listItem = document.createElement('li');
					//get the text in the input element and make it a list item
					listItem.innerHTML = addressField.value;
					listItem.addEventListener('click', function(){
						pinAddressOnMap(listItem.innerHTML);
					});
					//append it to the <ul> element
					addressList.appendChild(listItem);
					
					//call the geocoding function
					pinAddressOnMap(addressField.value);
					
					if (addressList.children.length > 1)
					{
						//get getDirectionsBtn button handler
						var getDirectionsBtn = document.getElementById('getDirectionsBtn');
						//enable the getDirectionsBtn
						getDirectionsBtn.disabled = false;
					}
					
					addressField.value = '';
				}
				
				//function for geocoding the addresses
				function pinAddressOnMap(addressText)
				{
					//real essence, send the geocoding request
					geocoder.geocode({ 'address': addressText}, function(results, status) {
      					//if the service is working properly...
      					if (status == google.maps.GeocoderStatus.OK) {
        					//show the first result on map
        					pinpointResult(results[0]);
      					} else {
        					alert('Cannot geocode because: ' + status);
      					}
    				});
				}
				
				//function for sending the request to the directionsService and making the
				//results to be drawn on map and listed:
				function getDirections()
				{
					//define an array that will hold all the waypoints
					var waypnts = [];
					//define an directionsRequest object
					var directionRequest;
					
					//debugger;
			
					//if there are stops other than the origin and the final destination
					if (markers.length > 2)
					{
						for (var i=1, l=markers.length;i<=l-2;i++)
						{
							//add them to the waypnts array
							waypnts.push({
								location: markers[i].getPosition(),
								stopover: true
							});
						}
					
						//prepare the directionsRequest by including waypoints property
						directionRequest = {
							origin:markers[0].getPosition(),
							destination:markers[markers.length-1].getPosition(),
							waypoints: waypnts,
							travelMode: google.maps.TravelMode.DRIVING
						};						
					}
					else
					{
						//this time, do not include waypoints property as there is no waypoints
						directionRequest = {
							origin:markers[0].getPosition(),
							destination: markers[markers.length-1].getPosition(),
							travelMode: google.maps.TravelMode.DRIVING
						};
					}
					
					//send the request to the directionsService
					directionsService.route(directionRequest, function(result, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsRenderer.setDirections(result);
						}
						else
						{
							alert('Cannot find directions because: ' + status);
						}
					});
				}
				
        </script>
    </head>
    <body onload="initMap()">
    	<div id="ContainerDiv">
			<div id="MapContainerDiv">
				<b>Directions</b>
				<div id="MapDiv">
				</div>
			</div>
			<div id="DirectionsContainerDiv">
				<div id="PlacesContainerDiv">
					<b>Get Directions Between your Places</b></br>
					<input id="addressField" type="text" size="30"  placeholder="Enter your Address" />
					<input type="button" id ="pinAddressOnMapBtn" value="Pin Address On Map" onclick="listAddresses()" />
					<input type="button" id = "getDirectionsBtn" disabled value="Get Directions" onclick="getDirections()" />
					<p id="placesText"></p>
					<ul id="addressList" class="addressList">
					</ul>
				</div>
				<div id="DirectionsListContainerDiv">
					<div id="DirectionsListDiv">
					</div>
				</div>
			</div>
    	</div>
    </body>
</html>