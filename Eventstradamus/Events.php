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
<h2>Events</h2>
<a href=http://localhost/Eventstradamus/Event/Search.php>Search for an Event</a>
<?php
$con=mysqli_connect("localhost","user","userpass","Eventstradamus");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM events WHERE time_start > now()");
if($result != null){
	if(!isset($_GET['event_id'])){
		if($result != null){
			if($result->num_rows == 0){
				echo "No events are signed up.  "; 
				if(isset($_SESSION['logged_in'])) {
					echo "<a href=http://localhost/Eventstradamus/Profile/Create_Event.php>Create one here.</a>";
				}
			} 
			else {
				echo "<table>";
				echo "<tr><td>Event Name</td><td>Description</td><td>Time</td><td>Business</td><td>Time Till Start</td></tr>";
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
				print "Number of Businesses : " . $result->num_rows;
			}
		}
	} else {
		$result = mysqli_query($con,"SELECT * FROM events WHERE event_id = {$_GET['event_id']} AND time_start > now()");
		if($result->num_rows != 0){
			$row = mysqli_fetch_array($result);
				echo "<table>";
				echo "<tr><td>Title:</td><h4><td>" . $row['title'] . "</h4></td></tr>";
				echo "<tr><td>Description:</td><td>" . $row['description'] . "</td></tr>";
				echo "<tr><td>location:</td><td>" . $row['location'] . "</td></tr>";
				echo "</table>";
		} else {
			echo "this business doesn't exist";
		}
	}
}


?>