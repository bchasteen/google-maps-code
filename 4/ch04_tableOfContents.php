<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
              html { height: 100% }
              body { height: 100%; margin: 5; }
              #mapDiv { width: 800px; height: 500px; }
              .tocControl {padding:10px; border-style:solid; border-color:red; border-width:3px; background-color:rgb(220,220,220); }
              .tocLabel {font-size:14px; margin-bottom:10px; display:block;}
        </style>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        
  <!-- Map creation is here -->
        <script type="text/javascript">
				function initMap() {
              		
				//Enabling new cartography and themes
				google.maps.visualRefresh = true;

				//Setting starting options of map with mapTypeIds including 'OSM' mapTypeID
				var mapOptions = {
					center: new google.maps.LatLng(39.9078, 32.8252),
					zoom: 10,
					mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE, 'OSM']},
					mapTypeControl:false
				};
				
				//Getting map DOM element
				var mapElement = document.getElementById("mapDiv");

				//Creating a map with DOM element which is just obtained
				var map = new google.maps.Map(mapElement, mapOptions);
				
				//Defining OSM Map Type
				var osmMapType = new google.maps.ImageMapType({
					getTileUrl: function(coord, zoom) {
						return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
					},
					tileSize: new google.maps.Size(256, 256),
					name: "OpenStreetMap",
					maxZoom: 18
				});
				
				//relate new mapTypeId to the ImageMapType - osmMapType object
				map.mapTypes.set('OSM', osmMapType);
					
				//set ROADMAP mapTypeId to be displayed
				map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
				
				//create div, to be used for the custom control GeoLocationControl
				var tableOfContentsControlDiv = document.createElement('div');
				
				//instantiate the custom control object
				var tableOfContentsControl = new TableOfContentsControl(tableOfContentsControlDiv, map);
				
				//place the control among other map controls in the map UI
				map.controls[google.maps.ControlPosition.TOP_RIGHT].push(tableOfContentsControlDiv);
            }
			
			//create a JavaScript class as a custom control - TableOfContentsControl
			function TableOfContentsControl(tocControlDiv, map)
			{
				//necessary as 'this' will be out of scope in event listeners for the
				//radio buttons
				var tocControl = this;
				
				//set css class property of the container div
				tocControlDiv.className = 'tocControl';
						
				//create the title of the ToC
				var tocLabel = document.createElement('label');
				tocLabel.className = 'tocLabel';
				tocLabel.appendChild(document.createTextNode('Base Layers'));
				
				tocControlDiv.appendChild(tocLabel);
				
				//set osmStuffDiv
				var osmStuffDiv = document.createElement('div');
				
				//set OSM radio button & label
				var osmRadioButton = document.createElement('input');
				osmRadioButton.type = 'radio';
				osmRadioButton.name = 'BaseMaps';
				osmRadioButton.id = 'OSM';
				osmRadioButton.checked = false;
				
				var osmLabel = document.createElement('label');
				osmLabel.htmlFor = osmRadioButton.id;
				osmLabel.appendChild(document.createTextNode('OpenStreetMap Base Map'));
				
				
				//add radio button & label to the container div
				osmStuffDiv.appendChild(osmRadioButton);
				osmStuffDiv.appendChild(osmLabel);
				
				//set roadMapStuffDiv
				var roadmapStuffDiv = document.createElement('div');
				
				//set Google roadmap radio button
				var roadmapRadioButton = document.createElement('input');
				roadmapRadioButton.type = 'radio';
				roadmapRadioButton.name = 'BaseMaps';
				roadmapRadioButton.id = 'Roadmap';
				roadmapRadioButton.checked = true;
				
				var roadmapLabel = document.createElement('label');
				roadmapLabel.htmlFor = roadmapRadioButton.id;
				roadmapLabel.appendChild(document.createTextNode('Google Roadmap'));
				
				//add radio button & label to the container div
				roadmapStuffDiv.appendChild(roadmapRadioButton);
				roadmapStuffDiv.appendChild(roadmapLabel);
				
				//set satelliteStuffDiv
				var satelliteStuffDiv = document.createElement('div');
				
				//set Google satellite radio button
				var satelliteRadioButton = document.createElement('input');
				satelliteRadioButton.type = 'radio';
				satelliteRadioButton.name = 'BaseMaps';
				satelliteRadioButton.id = 'Satellite';
				satelliteRadioButton.checked = false;
				
				var satelliteLabel = document.createElement('label');
				satelliteLabel.htmlFor = roadmapRadioButton.id;
				satelliteLabel.appendChild(document.createTextNode('Google Satellite'));
				
				//add radio button & label to the container div
				satelliteStuffDiv.appendChild(satelliteRadioButton);
				satelliteStuffDiv.appendChild(satelliteLabel);

				//put the radio buttons & labels in parent div
				tocControlDiv.appendChild(osmStuffDiv);
				tocControlDiv.appendChild(roadmapStuffDiv);
				tocControlDiv.appendChild(satelliteStuffDiv);
				
				//add 'click' event listener for osmRadioButton
				google.maps.event.addDomListener(osmRadioButton, 'click', function() {
					//Toggle OSM Layer on and off
					if (osmRadioButton.checked) 
					{
						tocControl.setActiveBasemap('OSM');
						map.setMapTypeId(tocControl.getActiveBasemap());
					}
				});
				
				//add 'click' event listener for roadmapRadioButton
				google.maps.event.addDomListener(roadmapRadioButton, 'click', function() {
					//Toggle Roadmap Layer on and off
					if (roadmapRadioButton.checked) 
					{
						tocControl.setActiveBasemap(google.maps.MapTypeId.ROADMAP);
						map.setMapTypeId(tocControl.getActiveBasemap());
					}
				});
				
				//add 'click' event listener for satelliteRadioButton
				google.maps.event.addDomListener(satelliteRadioButton, 'click', function() {
					//Toggle Roadmap Layer on and off
					if (satelliteRadioButton.checked) 
					{
						tocControl.setActiveBasemap(google.maps.MapTypeId.SATELLITE);
						map.setMapTypeId(tocControl.getActiveBasemap());
					}
				});
			}
			
			//create an activeBasemap property for the TableOfContentsControl
			TableOfContentsControl.prototype._activeBasemap = null;
			
			//getter for activeBasemap property
			TableOfContentsControl.prototype.getActiveBasemap = function() {
				return this._activeBasemap;
			};
			
			//setter for activeBasemap property
			TableOfContentsControl.prototype.setActiveBasemap = function(basemap) {
				this._activeBasemap = basemap;
			};
           
        </script>
    </head>
    <body onload="initMap()">
        <b>TOC Control<br/>
		<div id="mapDiv"/>
    </body>
</html>