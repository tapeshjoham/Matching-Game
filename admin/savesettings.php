<?php
	session_start();

	$active=$_POST['active'];
	$sqlun=$_POST['sqlun'];
	$sqlp=$_POST['sqlp'];
	$sqld=$_POST['sqld'];
	$pno=$_POST['pno'];

	include "getpath.php";

	$file=fopen($localhost."Matching-Game/assets/config.txt","w");

	echo "<br>[process]:writing to file config.txt<br>";

	fwrite($file,"sql_username:$sqlun:\n");
	fwrite($file,"sql_password:$sqlp:\n");
	fwrite($file,"sql_database:$sqld:\n");
	fwrite($file,"pairs_no:$pno:\n");
	
	fclose($file);

	echo "<br>[process]:writing to database<br>";
	
	include $localhost."Matching-Game/assets/getconfig.php";

	$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error);
		}

	$query="update adminaccount set active=$active where username='".$_SESSION['username']."'";
	$result=$conn->query($query);

?>