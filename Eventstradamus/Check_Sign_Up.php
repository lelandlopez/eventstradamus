<?php
// Create connection
$con=mysqli_connect("localhost","user","userpass","Eventstradamus");

// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// username and password sent from form 
$myusername=$_POST['username']; 
$mypassword1=$_POST['password1'];
$mypassword2=$_POST['password2'];


// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword1 = stripslashes($mypassword1);
$mypassword2 = stripslashes($mypassword2);
$myusername = $con->real_escape_string($myusername);
$mypassword1 = $con->real_escape_string($mypassword1);
$mypassword2 = $con->real_escape_string($mypassword2);

if($mypassword1 != $mypassword2){
	header("location:http://localhost/Eventstradamus/Sign_Up.php?err=1");
}

else{
	$result = mysqli_query($con,"SELECT * FROM users WHERE username = '$myusername'");
	// Mysql_num_row is counting table row
	$count=$result->num_rows;
	// If result matched $myusername and $mypassword, table row must be 1 row
	echo $count;
	if($count>0){
		header("location:http://localhost/Eventstradamus/Sign_Up.php?err=2");
	}
	else{
	mysqli_query($con,"INSERT INTO users (username, password)
	VALUES ('$myusername', '$mypassword1')");

	header("location:http://localhost/Eventstradamus/Home.php");
	}
}
?>