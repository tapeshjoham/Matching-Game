
<?php
    include "getpath.php";
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
    $usertype = $_SESSION['usertype'];

    $output=0;
	//creating sql un and pass
	include $localhost."Matching-Game/assets/getconfig.php";

	$conn=mysqli_connect("localhost",$sqlun,$sqlp,"matchinggame");
	if($conn->connect_error){
        //die("Connection to database failed: ".$conn->connect_error);
        die("105");
    }

    //checking credentials
    $result=$conn->query("select * from ".$usertype."account where username='".$username."' and password='".$password."'");
    if($result){
        if($result->num_rows==0){
        	$output=104;
        }
        $output=102;
    }else{
        $output=103;
    }

?>
