<?php
session_start();
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
$comment=$_POST['comment']; 


// To protect MySQL injection (more detail about MySQL injection)
$comment = stripslashes($comment);
$comment = $con->real_escape_string($comment);
if($comment == ""){
	header("location:http://localhost/Eventstradamus/Business/Create_Comment.php?err=1");
} else{

	mysqli_query($con,"INSERT INTO business_comments (business_id, commenter_id, comment)
	VALUES ('{$_GET['bus_id']}', '{$_SESSION['user_id']}', '{$_POST['comment']}')");
	header("location:http://localhost/Eventstradamus/Business.php?bus_id=". $_GET['bus_id']);
}
?>