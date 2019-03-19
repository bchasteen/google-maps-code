<!DOCTYPE html>
<html>
<head>
    <!-- Include Google Maps JS API -->
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
    </script>
    <script type="text/javascript" src='lib/infobox.js'></script>
    <style type="text/css">
        html { height: 100% }
        body { height: 100%; margin: 5; }
        #mapDiv { width: 800px; height: 500px; }
        .infoContent { border: 1px solid black; margin-top: 8px; background: white; padding: 5px; }
    </style>
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

            //Creating the contents for info box
            var boxText = document.createElement('div');
            boxtext.className = 'infoContent';
            boxText.innerHTML = '<b>Marker Info Box</b> <br> Gives information about marker';

            //Creating the info box options.
            var customInfoBoxOptions = {
                content: boxText,
                pixelOffset: new google.maps.Size(-100, 0),
                boxStyle: {
                    background: "url('img/tipbox2.gif') no-repeat",
                    opacity: 0.75,
                    width: '200px'
                },
                closeBoxMargin: '10px 2px 2px 2px',
                closeBoxURL: 'img/close.gif',
                pane: "floatPane"
            };

            //Initializing the info box
            var customInfoBox = new InfoBox(customInfoBoxOptions);

            //Creating the map label options.
            var customMapLabelOptions = {
                content: 'Custom Map Label',
                closeBoxURL: "",
                boxStyle: {
                    border: '1px solid black',
                    width: '110px'
                },
                position: new google.maps.LatLng(40.0678, 33.1252),
                pane: 'mapPane',
                enableEventPropagation: true
            };

            //Initializing the map label
            var customMapLabel = new InfoBox(customMapLabelOptions);

            //Showing the map label
            customMapLabel.open(map);

            //Initializing the marker for showing info box
            var marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: new google.maps.LatLng(39.9078, 32.8252),
                visible: true
            });

            //Opening the info box attached to marker
            customInfoBox.open(map, marker);

            //Listening marker to open info box again with contents related to marker
            google.maps.event.addListener(marker, 'click', function (e) {
                boxText.innerHTML = '<b>Marker Info Box</b> <br> Gives information about marker';
                customInfoBox.open(map, this);
            });

            //Listening map click to open info box again with contents related to map coordinates
            google.maps.event.addListener(map,'click', function (e) {
                boxText.innerHTML = '<b>Map Info Box</b> <br> Gives information about coordinates <br> Lat: ' + e.latLng.lat().toFixed(6) + ' - Lng: ' + e.latLng.lng().toFixed(6);
                customInfoBox.setPosition(e.latLng);
                customInfoBox.open(map);
            });

            //Listening info box for clicking close button
            google.maps.event.addListener(customInfoBox, 'closeclick', function () {
                console.log('Info Box Closed!!!');
            });
        }
    </script>
</head>
<body onload="initMap()">
<b>Chapter 6 - Creating Custom Popups / Info Boxes</b><br/>
<div id="mapDiv"/>
</body>
</html>