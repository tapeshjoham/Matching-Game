<?php
    include "getpath.php";

    session_start();
    $score=$_GET['score'];
	$username=$_SESSION['username'];
    $previousscore=-1;
    $gamesplayed=0;

    //creating sql un and pass
	include $localhost."Matching-Game/assets/getconfig.php";

	$conn=mysqli_connect("localhost",$sqlun,$sqlp,"matchinggame");
	if($conn->connect_error){
    	//die("Connection to database failed: ".$conn->connect_error);
    	die("105");
    }
    //checking for previous highscore
    $result=$conn->query("select * from playerprofile where username='".$username."'");
    if($result->num_rows!=0){
        $row=$result->fetch_assoc();
        $previousscore=$row['highscore'];
        $gamesplayed=$row['gamesplayed'];

        //inserting in table 
        if($score>$previousscore){
            //updating playerprofile , player made a highscore
            $result=$conn->query("update playerprofile set highscore=".$score.",gamesplayed=".($gamesplayed+1)." where username='".$username."'");
            if($result){
                die("107");
            }else{
                die("103");
            }
        }else{
            //updating playerprofile , player does not make highscore
            $result=$conn->query("update playerprofile set gamesplayed=".($gamesplayed+1)." where username='".$username."'");
            if($result){
                die("106");
            }else{
                die("103");
            }
        }
    }else{
        //inserting playerprofile , player made highscore
        $result=$conn->query("insert into playerprofile values('".$username."',".$score.",".($gamesplayed+1).")");
        if($result){
            die("107");
        }else{
            die("103");
        }
    }
?>
