<!DOCTYPE html>
<html>
    <head>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        <style type="text/css">
              #mapDiv { width: 800px; height: 500px; }
        </style>
        <!-- Map creation is here -->
        <script type="text/javascript">
              //Defining map as a global variable to access from other functions
              var map;
              function initMap () {
                    //Enabling new cartography and themes
                    google.maps.visualRefresh = true;

                    //Setting starting options of map
                    var mapOptions = {
                          center: new google.maps.LatLng(39.9078, 32.8252),
                          zoom: 10,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    //Start listening for button click events.
                    startButtonEvents();

              }

              //Function that start listening the click events of the buttons.
              function startButtonEvents () {
                  document.getElementById('btnZoomToIst').addEventListener('click', function(){
                      zoomToIstanbul();
                  });
                  document.getElementById('btnZoomToStr').addEventListener('click', function(){
                      zoomToStreet();
                  });
                  document.getElementById('btnDisableDrag').addEventListener('click', function(){
                      disableDrag();
                  });
                  document.getElementById('btnMaxZoom').addEventListener('click', function(){
                      setMaxZoom();
                  });
                  document.getElementById('btnMinZoom').addEventListener('click', function(){
                      setMinZoom();
                  });
                  document.getElementById('btnChangeUI').addEventListener('click', function(){
                      changeUI();
                  });
                  document.getElementById('btnDisableScroll').addEventListener('click', function(){
                      disableScroll();
                  });
              }

              //Changes the center of map to a specific point
              function zoomToIstanbul () {
                var istanbul = new google.maps.LatLng(41.057974, 29.034805);
                map.setCenter(istanbul);
              }
              
              //Changes the zoom factor of map
              function zoomToStreet () {
              	map.setZoom(18);                            
              }
              
              //Disables the drag property of map, the map is fixed
              function disableDrag () {
              	map.setOptions ({ draggable: false });
              }
              
              //Sets the maximum zoom that map will focus.
              function setMaxZoom () {
              	map.setOptions ({ maxZoom: 12 });
              }
              
              //Sets the minimum zoom that map will focus.
              function setMinZoom () {
              	map.setOptions ({ minZoom: 5 });              
              }
			  
			  //Removes the default UI components.
              function changeUI () {
              	map.setOptions ({ disableDefaultUI: true });              
              }
              
              //Disables the mouse wheel scroll in order to zoom in/out
              function disableScroll () {
              	map.setOptions ({ scrollwheel: false });              
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 1 - Interaction Map</b><br/>
        <input id="btnZoomToIst" type="button" value="Zoom To Istanbul">
        <input id="btnZoomToStr" type="button" value="Zoom To Street Level">
        <input id="btnDisableDrag" type="button" value="Disable Drag">
        <input id="btnMaxZoom" type="button" value="Set Max Zoom to 12">
        <input id="btnMinZoom" type="button" value="Set Min Zoom to 5">
        <input id="btnChangeUI" type="button" value="Change UI">
        <input id="btnDisableScroll" type="button" value="Disable Scroll Zoom">
        <div id="mapDiv"></div>
    </body>
</html>