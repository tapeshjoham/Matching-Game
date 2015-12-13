<?php
	$conn=mysqli_connect("localhost",root,7196,"matchthefollowinggame");
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
		if($print==1&&$row['c1']!=""&&row['c2']!=""&&(!exists($row['c1'],$printed,$counter))){
			echo $row['c1']."::".$row['c2'].";;;";
			array_push($printed,$row['c1']);
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