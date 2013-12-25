<?php
session_start();
$con=mysqli_connect("localhost","user","userpass","Eventstradamus");
	// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<?php
if(isset($_SESSION['logged_in'])){
	// Create connecti
	echo "Hello User " . $_SESSION['user_id'] . "  <a href=http://localhost/Eventstradamus/Log_Out.php>Log Out</a>";
}
else{
	echo "You are not logged in. Please <a href=http://localhost/Eventstradamus/Log_In.php>Log In</a> or <a href=http://localhost/Eventstradamus/Sign_Up.php>Sign Up</a>";
}
?>
<html>
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
<h2>Businesses</h2>
<?php

if(!isset($_GET['bus_id'])){
	$result = mysqli_query($con,"SELECT * FROM businesses");
	if($result != null){
		if($result->num_rows == 0){
			echo "No events are signed up.  "; 
			if(isset($_SESSION['logged_in'])) {
				echo "<a href=http://localhost/Eventstradamus/Profile/Create_Event.php>Create one here.</a>";
			}
		} 
		else {
			echo "<table>";
			while($row = mysqli_fetch_array($result))
			{
				echo "<tr><td><a href=http://localhost/Eventstradamus/Business.php?bus_id=" . $row['business_id'] . ">" . $row['title'] . "</a></td></tr>";
			}
			echo "</table>";
			print "Number of Businesses : " . $result->num_rows;
		}
	}
} else {
	$result = mysqli_query($con,"SELECT * FROM businesses WHERE business_id = {$_GET['bus_id']}");
	if($result->num_rows != 0){
		$row = mysqli_fetch_array($result);


		echo "<table>";
		echo "<tr><td>Title:</td><h4><td>" . $row['title'] . "</h4></td></tr>";
		echo "<tr><td>Description:</td><td>" . $row['description'] . "</td></tr>";
		echo "<tr><td>location:</td><td>" . $row['location'] . "</td></tr>";
		echo "</table>";

		echo "<h4>Comments</h4>";
		$result = mysqli_query($con,"SELECT * FROM business_comments WHERE business_id = {$_GET['bus_id']}");
		echo "<table>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE user_id = {$row['commenter_id']}"))['username'] . "</td>";
			echo "<td>" . $row['comment'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";

		if(isset($_SESSION['logged_in'])){
			echo "Make a comment <a href=http://localhost/Eventstradamus/Business/Create_Comment.php?bus_id=" . $_GET['bus_id'] . ">Here</a></td></tr>";
		}
		
	} else {
		echo "this business doesn't exist";
	}
}

?>