<?php
	include "/var/www/html/Matching-Game/assets/getconfig.php";
	$conn=mysqli_connect("localhost",$sqlun,$sqlp,"matchinggame");
	if($conn->connect_error)
    	die("Connection to database failed: ".$conn->connect_error);

	$query = "select * from pairs";
	$result = $conn->query($query);
	$counter=0;
	$printed=array();
	while(1){
		if(!$row=$result->fetch_assoc()){
			//echo "<br>renewed<br>";
			$result = $conn->query($query);
		}
		$print=mt_rand(0,1);
		if($print==1&&$row['c1name']!=""&&row['c2name']!=""&&(!exists($row['c1name'],$printed,$counter))){
			echo $row['c1name'].";;".$row['c1type']."::".$row['c2name'].";;".$row['c2type'].";;;";
			array_push($printed,$row['c1name']);
			$counter++;
		}
		if($counter==5){
			break;
		}
	}

	function exists($value,$array,$len){
		$index=0;
		while($index<$len){
			if(strcmp($array[$index],$value)==0){
				//echo "found";
				return true;
			}
			//echo "searching";
			$index++;
		}
		return false;
	}
?>