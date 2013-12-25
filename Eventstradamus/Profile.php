<?php
class business { 
    public $bus_id;
    public $bus_title;
    
    
	function __construct($bus_id, $bus_title) {
   		$this->bus_id = $bus_id;
   		$this->bus_title = $bus_title;
	}
}

class business_array {
	public $bus_array = array();

	function add($business){
		array_push($bus_array, $business);
	}

	function search_id($bus_id){
		for($x = 0; $x < count($this->bus_array); $x++){
			if($bus_id==$this->bus_array[$x]->bus_id){
				return true;
			}
		}
		return false;
	}
}
?>


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
<h2>Profile</h2>
<table>
<tr><strong>My Businesses<strong></tr>
<tr>
<td>Business Name</td>
</tr>
<?php
$business_array = new business_array();
$result = mysqli_query($con,"SELECT * FROM businesses WHERE user_id = " . $_SESSION['user_id']);
// Mysql_num_row is counting table row
// If result matched $myusername and $mypassword, table row must be 1 row
while($row = mysqli_fetch_array($result))
{
	echo "<tr><td><a href=http://localhost/Eventstradamus/Business.php?bus_id=" . $row['business_id'] . ">" . $row['title'] . "</a></td></tr>";
	array_push($business_array->bus_array,new business($row['business_id'], $row['title']));
}

?>
<tr>
<?php
echo "<tr><td>You are a part of " . count($business_array->bus_array) . " businesses</td></tr>";
echo "<tr><td><a href=http://localhost/Eventstradamus/Profile/Create_Business.php>Create a Business</a><td></tr>";
?>
</tr>

</table>
<br>

<table>
<tr><strong>My Events</strong></tr>
<tr><td>Event Name</td><td>Location</td><td>Event Time</td><td>Business</td><td>Time Till Start</td>
<?php
$events = 0;

$select = "SELECT * FROM events WHERE time_start > now() AND (business_id = ";
for ($x=0; $x<count($business_array->bus_array); $x++)
{
	if($x==0){
		$select.="'".$business_array->bus_array[$x]->bus_id."'";
	} else {
		$select.="OR business_id = '" . $business_array->bus_array[$x]->bus_id . "' ";
	}
}
$select .= ")";
$result = mysqli_query($con,$select);
// Mysql_num_row is counting table row

while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	echo "<td><a href=http://localhost/Eventstradamus/Events.php?event_id=" . $row['event_id'] . ">" . $row['title'] . "</a></td>";
	echo "<td>" . $row['location'] . "</td>";
	echo "<td>" . $row['time_start'] . "-" . $row['time_end'] . "</td>";
	for($x = 0; $x<count($business_array->bus_array); $x++){
		if($business_array->bus_array[$x]->bus_id==$row['business_id']){
			echo "<td><a href=http://localhost/Eventstradamus/Business.php?bus_id=" . $row['business_id'] . ">" . $business_array->bus_array[$x]->bus_title . "</a></td>";
			break;
		}
	}
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
	echo "<tr>";
	$events++;
}

echo "<tr><td>You have " . $events . " events</tr></td>";
// If result matched $myusername and $mypassword, table row must be 1 row
if(count($business_array->bus_array) >= 1){
	while($row = mysqli_fetch_array($result))
	{
		echo "<tr><td>" . $row['title'] . "</td></tr>";
	}
	if($events == 0){

		echo "<tr><td>You have no Events, You can create one <a href=http://localhost/Eventstradamus/Profile/Create_Event.php>Here</a></td></tr>";
	} else {
		echo "<tr><td><a href=http://localhost/Eventstradamus/Profile/Create_Event.php>Create an Event</a></td></tr>";
	}
} else {
	echo "<tr><td>You have no Businesses, You need to add or sign up a business to create an Event.</td></tr>";
}
?>

</table>

</html>