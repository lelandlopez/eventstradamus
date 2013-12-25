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
$location=$_POST['location'];

$title = stripslashes($title);
$description = stripslashes($description);
$location = stripslashes($location);

$title = $con->real_escape_string($title);
$description = $con->real_escape_string($description);
$location = $con->real_escape_string($location);

if($title == "" || $description == "" || $location == ""){
	header("location:http://localhost/Eventstradamus/Profile/Create_Business.php?err=1");
} else {
	mysqli_query($con,"INSERT INTO businesses (user_id, title, description, location)
		VALUES ('{$_SESSION['user_id']}',
		 '$title', '$description', '$location')");

	header("location:http://localhost/Eventstradamus/Home.php");
}
?>