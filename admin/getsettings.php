<?php
	//file for getting contents of config file
	session_start();

	include "getpath.php";

	include $localhost."Matching-Game/assets/getconfig.php";

	$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error);
		}
		
	$query="SELECT * from adminaccount where username='".$_SESSION['username']."'";
	$result=$conn->query($query);
	$active;

	if($row=mysqli_fetch_row($result))
		$active=$row[2];

	echo "$active::$sqlun::$sqlp::$sqld::$pno::";
?>