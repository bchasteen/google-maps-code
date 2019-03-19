<!DOCTYPE html>
<html>
<head>
    <!-- Include Google Maps JS API -->
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
    </script>
    <script type="text/javascript" src="keydragzoom.js"></script>
    <style type="text/css">
        html { height: 100% }
        body { height: 100%; margin: 5; }
        #mapDiv { width: 800px; height: 500px; }
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

            // Enabling the KeyDragZoom library
            // Get the latest version of library from the following address :
            // http://google-maps-utility-library-v3.googlecode.com/svn/tags/keydragzoom/
            map.enableKeyDragZoom({
                visualEnabled: true,
                visualPosition: google.maps.ControlPosition.LEFT,
                visualPositionOffset: new google.maps.Size(35, 0),
                visualPositionIndex: null,
                visualSprite: 'http://maps.gstatic.com/mapfiles/ftr/controls/dragzoom_btn.png',
                visualSize: new google.maps.Size(20,20),
                visualTips: {
                    off: "Turn on",
                    on: "Turn off"
                }
            });
        }
    </script>
</head>
<body onload="initMap()">
<b>Drag Zoom Library</b><br/>
<div id="mapDiv"/>
</body>
</html>