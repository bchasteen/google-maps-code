<!DOCTYPE html>
<html>
    <head>
        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=<?php echo json_decode(file_get_contents("../.etc/key.json"))->key; ?>&sensor=false">
        </script>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <style type="text/css">
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
                          center: new google.maps.LatLng(46.691206, 8.180058),
                          zoom: 7,
                          mapTypeId: google.maps.MapTypeId.ROAD
                    };

                    //Getting map DOM element
                    var mapElement = document.getElementById('mapDiv');

                    //Creating a map with DOM element which is just obtained
                    map = new google.maps.Map(mapElement, mapOptions);

                    //Creating the Fusion Tables layers
                    var layer = new google.maps.FusionTablesLayer({
                          query: {
                            select: 'geometry',
                            from: '1_1TjGKCfamzW46TfqEBS7rXppOejpa6NK-FsXOg'
                          },
                          heatmap: {
                            enabled: false
                          }
                    });
                    //Adding the created Fusion Tables layer to map
                    layer.setMap(map);

                    //Start listening for click event to change map style between normal and heatmap
                    $('#status').click(function() {
                        if (this.checked) {
                            layer.setOptions({heatmap: { enabled: true } });
                        }
                        else {
                            layer.setOptions({heatmap: { enabled: false } });
                        }
                    });

                    //Start listening for click event of button to filter the Fusion Tables layers.
                    $('#search').click(function() {
                        var txtValue = $('#query').val();
                        layer.setOptions({query: { select: 'geometry', from: '1_1TjGKCfamzW46TfqEBS7rXppOejpa6NK-FsXOg', where: 'name contains "' + txtValue + '"' } });
                    });
              }

              google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    </head>
    <body>
        <b>Chapter 8 - Adding Fusion Tables Layers</b><br/>
        <input type="checkbox" id="status"/>HeatMap Enabled         |
        <input type="text" id="query"/> <input type="button" id="search" value="Search"/><br/>
        <div id="mapDiv"></div>
    </body>
</html>