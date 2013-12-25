<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 500; width: 500px;}
    </style>
    






    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASdQRBw2W6NNpCDykXWmYh6QvELpb_xgY&sensor=false">
    </script>
    <script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(-34.397, 150.644),
          zoom: 8
        };
        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <h1>Food Trucks </h1>








    <div id="map-canvas"/>
  
















  </body>
</html>