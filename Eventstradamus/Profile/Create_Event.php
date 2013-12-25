<?php
session_start();
?>

<?php
if(!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id'])){
  header("location:http://localhost/Eventstradamus/Home.php");
}
?>

<?php
if(isset($_SESSION['logged_in'])){
  // Create connection
  $con=mysqli_connect("localhost","user","userpass","Eventstradamus");
  // Check connection
  if (mysqli_connect_errno($con))
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  echo "Hello User " . $_SESSION['user_id'] . "  <a href=http://localhost/Eventstradamus/Log_Out.php>Log Out</a>";
}
else{
  echo "You are not logged in. Please <a href=http://localhost/Eventstradamus/Log_In.php>Log In</a> or <a href=http://localhost/Eventstradamus/Sign_Up.php>Sign Up</a>";
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Geocoding service</title>
    <style>
      html, body, #map-canvas {
        height: 325px;
        width: 350px;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var geocoder;
var map;
var locationvalidate;
function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var mapOptions = {
    zoom: 8,
    center: latlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function codeAddress() {
  var address = document.getElementById('location').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
      locationvalidate = google.maps.GeocoderStatus.OK;

    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);


function validate(){
  if(locationvalidate != google.maps.GeocoderStatus.OK){
    document.getElementById("locationerr").innerHTML="Not a valid location";
  } else {
    document.getElementById("locationerr").innerHTML="";
  }
  if(document.getElementById("title").value == "" ||document.getElementById("description").value == "" || document.getElementById("location").value == "" || document.getElementById("business").value == ""){
    document.getElementById("missingerr").innerHTML= "You need to have all sections filled in";
  } else {
    document.getElementById("missingerr").innerHTML="";
  }
  if((locationvalidate != google.maps.GeocoderStatus.OK) || (document.getElementById("title").value == "" ||document.getElementById("description").value == "" || document.getElementById("location").value == "" || document.getElementById("business").value == "")){
    return false;
  } else {
    return true;
  }
}

</script>


</head>

<html>
<body>
<h1>EventStradamus</h1>
<table >
<tr>
<td><a href=http://localhost/Eventstradamus/Home.php>Home</a></td>
<td><a href=http://localhost/Eventstradamus/Events.php>Events</a></td>
<td><a href=http://localhost/Eventstradamus/Business.php>Businesses</a></td>
<?php
if(isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])){
  echo "<td><a href=http://localhost/Eventstradamus/Profile.php>Profile</a></td>";
}
?>
</tr>
</table>
<h2>Create An Event</h2>

<table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="Check_Create_Event.php" onsubmit="return validate()">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
</tr>
<tr>
<h6 id="missingerr"><?php
if(isset($_GET['err'])){
  if($_GET['err'] == 1){
    echo "You need to have all sections filled in";
  }
}
?></h6>
</tr>
<tr>
<td width="78">Title</td>
<td width="6">:</td>
<td width="294"><input name="title" type="text" id="title"></td>
</tr>
<tr>
<td>Description</td>
<td>:</td>
<td><input name="description" type="text" id="description"></td>
</tr>
<tr>
<h6 id="locationerr"></h6>
</tr>
<tr>
<td>Business</td>
<td>:</td>
<td>
<select name="business" id="business" value="choose event">
  <option value=""></option>
  <?php
  $result = mysqli_query($con,"SELECT * FROM businesses WHERE user_id = " . $_SESSION['user_id']);
  while($row = mysqli_fetch_array($result))
  {
    echo "<option value=" . $row['business_id'] . ">" . $row['title'] . "</option>";
  }
  ?>
</select>
</td>
</tr>
<tr>
<td>Country</td>
<td>:</td>
<td>
<select name="country" id="country" value="">
  <option value="1">United States of America</option>
</select>
</td>
</tr>
<tr>
<td>Postal Code</td>
<td>:</td>
<td><input name="postal_code" id="postal_code" type="textbox" value=""></td>
</tr>
<tr>
<td>Location</td>
<td>:</td>
<td><input name="location" id="location" type="textbox" onchange="codeAddress()" value=""></td>
</tr>
<tr>
<td>Event Start Time</td>
<td>:</td>
<td><input type="datetime-local" id="datestarttime" name="datestarttime" onchange="test()"></td>
</tr>
<tr>
<td>Event End Time</td>
<td>:</td>
<td><input type="datetime-local" id="dateendtime" name="dateendtime" onchange="test()"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Create Event" ></td>
</tr>
</table>
<div id="map-canvas"></div>
</td>
</form>
</tr>
</table>
</body>
</html>