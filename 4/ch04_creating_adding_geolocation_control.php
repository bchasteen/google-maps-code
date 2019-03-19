<!DOCTYPE html>
<html>
    <head>
    	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        <style type="text/css">
              html { height: 100% }
              body { height: 100%; margin: 0; }
              #mapDiv { width: 100%; height: 100%; }
              .controlContainer { padding: 10px; }
              .controlButton { border-style:solid; border-color:red; border-width:3px; padding:8px; font-size:150% !important; color:red; background-color:black; font-weight:bold !important;}
        </style>
        <!-- Map creation is here -->
        <script type="text/javascript">
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
                    var map = new google.maps.Map(mapElement, mapOptions);
					
					//create div, to be used as container div for the custom control GeoLocationControl
					var geoLocationControlDiv = document.createElement('div');
					
					//instantiate the custom control object
					var geoLocationControl = new GeoLocationControl(geoLocationControlDiv, map);
					
					//place the control among other map controls in the map UI
					map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(geoLocationControlDiv);
            }
			  
			//create a JavaScript class as a custom control
			function GeoLocationControl(geoLocControlDiv, map)
			{
				//set css class of the container div
				geoLocControlDiv.className = 'controlContainer';
				
				//set css class of internal div that should look like a button
				var controlButton = document.createElement('div');
				controlButton.className = 'controlButton';
				controlButton.innerHTML = 'Geolocate';
				
				//add the internal div to the container div
				geoLocControlDiv.appendChild(controlButton);
				
				//add 'click' event listener for controlButton
				google.maps.event.addDomListener(controlButton, 'click', function() {
					//Getting coordinates from device and zoom map to that location
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function(position) {
							var lat = position.coords.latitude;
							var lng = position.coords.longitude;
							//Creating LatLng object with latitude and longitude.
							var devCenter =  new google.maps.LatLng(lat, lng);
							map.setCenter(devCenter);
							map.setZoom(15);
							
							//creating the marker with the position supplied
							var marker = new google.maps.Marker({
								position: devCenter,
								map: map,
							});
						
						});
					}
				});
			}
        </script>
    </head>
    <body onload="initMap()">
        <div id="mapDiv"/>
    </body>
</html>