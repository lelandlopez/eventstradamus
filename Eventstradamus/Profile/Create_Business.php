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
<form name="form1" method="post" action="Check_Create_Business.php" onsubmit="return validate()">
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
<tr>
<h6 id="locationerr"></h6>
</tr>
<td>Location</td>
<td>:</td>
<td><input name="location" id="location" type="textbox" value=""></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Create Business" ></td>
</tr>
</table>
<div id="map-canvas"></div>
</td>
</form>
</tr>
</table>
</body>
</html>