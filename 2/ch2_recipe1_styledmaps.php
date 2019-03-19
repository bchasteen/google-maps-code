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
              		
              		//new style array
              		var bluishStyle = [
					  {
						stylers: [
						  { hue: "#009999" },
						  { saturation: -5 },
						  { lightness: -40 }
						]
					  },{
						featureType: "road",
						elementType: "geometry",
						stylers: [
						  { lightness: 100 },
						  { visibility: "simplified" }
						]
					  },
					  {
						featureType: "water",
						elementType: "geometry",
						stylers: [
						  { hue: "#0000FF" },
						  {saturation:-40}
						]
					  },
					  {
						featureType: "administrative.neighborhood",
						elementType: "labels.text.stroke",
						stylers: [
						  { color: "#E80000" },
						  {weight: 1}
						]
					  },{
						featureType: "road",
						elementType: "labels.text",
						stylers: [
						  { visibility: "off" }
						]
					  },
					  {
						featureType: "road.highway",
						elementType: "geometry.fill",
						stylers: [
						  { color: "#FF00FF" },
						  {weight: 2}
						]
					  }
					];
					
					//create a new StyledMapType and reference it with the style array
					var bluishStyledMap = new google.maps.StyledMapType(bluishStyle,
    					{name: "Bluish Google Base Maps with Pink Highways"});
              
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map with mapTypeIds including the new style
                    var mapOptions = {
						center: new google.maps.LatLng(39.9078, 32.8252),
						zoom: 10,
						mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'new_bluish_style']}
					};
					
                    //Getting map DOM element
                    var mapElement = document.getElementById("mapDiv");

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);
                    
                    //relate new mapTypeId to the styledMapType object
					map.mapTypes.set('new_bluish_style', bluishStyledMap);
					//set this new mapTypeId to be displayed
					map.setMapTypeId('new_bluish_style');
              }

           
        </script>
    </head>
    <body onload="initMap()">
        <b>Styled Maps</b><br/>
        <div id="mapDiv"/>
    </body>
</html>