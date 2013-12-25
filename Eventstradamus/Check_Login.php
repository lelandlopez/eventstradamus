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
$mypassword=$_POST['password']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = $con->real_escape_string($myusername);
$mypassword = $con->real_escape_string($mypassword);
echo $myusername;
echo $mypassword;
$result = mysqli_query($con,"SELECT * FROM users WHERE username = '$myusername' and password = '$mypassword'");
// Mysql_num_row is counting table row
$count=$result->num_rows;
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
$user = mysqli_fetch_array($result);

session_start();
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = $user['user_id'];
header("location:http://localhost/Eventstradamus/Home.php");
}
else {
echo "Wrong Username or Password";
}
?>