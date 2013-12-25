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
<h2>Events -> Search for event</h2>

<table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="Search.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>Search For Event</strong></td>
</tr>
<tr>
<tr>
<td>Country</td>
<td>:</td>
<td>
<select name="country" id="country" value="">
  <option value="1">United States of America</option>
</select>
</td>
</tr>
<td width="78">Postal Code</td>
<td width="6">:</td>
<td width="294"><input name="postal_code" type="text" id="postal_code"></td>
</tr>
<tr>
<td>Key Terms</td>
<td>:</td>
<td><input name="key_terms" type="text" id="key_terms"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>

<?php
if(isset($_POST['postal_code']) && isset($_POST['key_terms'])){
	echo "<h3>Matching Events</h3>";

	$country=$_POST['country']; 
	$postal_code=$_POST['postal_code']; 
	$key_terms=$_POST['key_terms'];

	$country = stripslashes($country);
	$postal_code = stripslashes($postal_code);
	$key_terms = stripslashes($key_terms);

	$country = $con->real_escape_string($country);
	$postal_code = $con->real_escape_string($postal_code);
	$key_terms = $con->real_escape_string($key_terms);

	$select = "SELECT * FROM events WHERE time_start > now() AND (country = '$country'";
	if($postal_code != "") $select .= " OR post_code = '$postal_code'";
	$select .= ")";

	$result = mysqli_query($con, $select);
	echo "<table>";
	echo "<tr><td>Event Name</td><td>Description</td><td>Time</td><td>Business</td><td>Time Till Start</td></tr>";
	if($result != null){
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td><a href=http://localhost/Eventstradamus/Events.php?event_id=" . $row['event_id'] . ">" . $row['title'] . "</a></td>";
			echo "<td>" . $row['description'] . "</td>";
			echo "<td>" . $row['time_start'] . "-" . $row['time_end'] . "</td>";
			echo "<td><a href=http://localhost/Eventstradamus/Business.php?bus_id=" . $row['business_id'] . ">" . mysqli_fetch_array(mysqli_query($con,"SELECT * FROM businesses WHERE business_id = {$row['business_id']}"))['title'] . "</a></td>";
			echo "<td>";
			$date1 = strtotime($row['time_start']);
			$date2 = time();
			$subTime = $date1 - $date2;
			if($subTime < 0){
				echo "This event already happened";
			} else {
				$y = ($subTime/(60*60*24*365));
				$d = ($subTime/(60*60*24))%365;
				$h = ($subTime/(60*60))%24;
				$m = ($subTime/60)%60;
				if($y == 0 && $d == 0 && $h == 0){
					echo "This event is today";
				} else {
					if($y >= 1){
					echo floor($y) ." years\n";
					}
					if($d >= 1){
					echo floor($d) ." days\n";
					}
					if($h >= 1){
					echo floor($h) ." hours\n";
					}
					if($m >= 1){
					echo floor($m)." minutes\n";
					}
				}
			}
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}
?>

</html>