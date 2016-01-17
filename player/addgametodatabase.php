<?php
    session_start();
    $score=$_GET['score'];
	$username=$_SESSION['username'];

    //creating sql un and pass
	include "/var/www/html/Matching-Game/assets/getconfig.php";

	$conn=mysqli_connect("localhost",$sqlun,$sqlp,"matchinggame");
	if($conn->connect_error){
    	//die("Connection to database failed: ".$conn->connect_error);
    	die("105");
    }
    
    //inserting playerprofile , player made highscore
    $result=$conn->query("insert into gamesplayed values(NOW(),'".$username."',".$score.")");
    if($result){
        die("102");
    }else{
        die("103");
    }
?>
