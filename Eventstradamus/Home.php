<?php
session_start();
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

<?php
	
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

<?php
if(isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])){

	$result = mysqli_query($con,"SELECT * FROM businesses WHERE user_id = " . $_SESSION['user_id']);
	// Mysql_num_row is counting table row
	$count=$result->num_rows;
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count > 1){
		echo "<a href=http://localhost/Eventstradamus/Profile/Create_Event.php>Create an Event</a>";
	}
}
?>

</html>