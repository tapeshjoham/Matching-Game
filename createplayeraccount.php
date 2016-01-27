<?php
    include "getpath.php";

	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);

	//creating sql un and pass
	include $localhost."Matching-Game/assets/getconfig.php";

	$conn=mysqli_connect("localhost",$sqlun,$sqlp,"matchinggame");
	if($conn->connect_error){
    	//die("Connection to database failed: ".$conn->connect_error);
    	die("105");
    }
    //checking for duplicate username
    $result=$conn->query("select * from playeraccount where username='".$username."'");
    if($result->num_rows!=0)
    	die("101");

    //inserting into playeraccount
    $result=$conn->query("insert into playeraccount values('".$username."','".$password."')");
    if($result){
    	die("102");
    }else{
    	die("103");
    }

?>
