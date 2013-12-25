<?php
// Create connection
$con=mysqli_connect("localhost","user","userpass","Eventstradamus");

// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 500px; width: 500px;}
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


    <?php
      $result = mysqli_query($con,"SELECT * FROM foodtrucks");
      if($result != null){
        if($result->num_rows == 0){
          echo "No foodtrucks are signed up.  Be the first. <a href=http://localhost/Eventstradamus/Sign_Up.php>Log In</a> and add your own food truck";
        } 
        else {
          print "Number of foodtrucks : " . $result->num_rows;
        }
      }

      while($row = mysqli_fetch_array($result))
      {
        echo $row['user_id'] . "<br>";
        echo $row['location'] . "<br>";
      }
    ?>







    <div id="map-canvas"/>
  
















  </body>
</html>