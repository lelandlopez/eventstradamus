<?php
session_start();
?>

<?php
if(!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id'])){
  header("location:http://localhost/Eventstradamus/Home.php");
}
?>

<?php
// Create connection
$con=mysqli_connect("localhost","user","userpass","Eventstradamus");

// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// username and password sent from form 
$title=$_POST['title']; 
$description=$_POST['description'];
$business=$_POST['business'];
$location=$_POST['location'];
$datestarttime=$_POST['datestarttime'];
$dateendtime=$_POST['dateendtime'];
$postal_code=$_POST['postal_code'];
$country=$_POST['country'];


$title = stripslashes($title);
$description = stripslashes($description);
$business=stripslashes($business);
$location = stripslashes($location);
$datestarttime = stripslashes($datestarttime);
$dateendtime = stripslashes($dateendtime);
$postal_code = stripslashes($postal_code);
$country = stripslashes($country);

$title = $con->real_escape_string($title);
$description = $con->real_escape_string($description);
$business = $con->real_escape_string($business);
$location = $con->real_escape_string($location);
$datestarttime = $con->real_escape_string($datestarttime);
$datestarttime = str_replace("T"," ", $datestarttime);
$datestarttime .= ":00";
$dateendtime = $con->real_escape_string($dateendtime);
$dateendtime = str_replace("T"," ", $dateendtime);
$dateendtime .= ":00";
$postal_code = $con->real_escape_string($postal_code);
$country = $con->real_escape_string($country);

echo $dateendtime;

if($title == "" || $description == "" || $location == "" || $business == "" || $datestarttime == ""){
	header("location:http://localhost/Eventstradamus/Profile/Create_Event.php?err=1");
} else {
	mysqli_query($con,"INSERT INTO events (business_id, title, description, location, time_start, time_end, country, post_code)
		VALUES ('$business', '$title', '$description','$location', '$datestarttime', '$dateendtime', '$country', '$postal_code')");

	header("location:http://localhost/Eventstradamus/Home.php");
}
?>