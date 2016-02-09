<?php
	//file for getting pairs
	
	session_start();
	include "getpath.php";

	include $localhost."Matching-Game/assets/getconfig.php";
	$conn=mysqli_connect("localhost",$sqlun,$sqlp,$sqld);
	if($conn->connect_error)
    	die("Connection to database failed: ".$conn->connect_error);

	$query = "SELECT * FROM pairs where adminusername='".$_SESSION['username']."'";
	$result = $conn->query($query);
	
	while($row=$result->fetch_assoc()){
		echo $row['c1name'].";;".$row['c1type']."::".$row['c2name'].";;".$row['c2type']."::".$row['id'].";;;";
	}
?>