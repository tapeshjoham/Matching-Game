<?php
	include "getpath.php";

	include $localhost."Matching-Game/assets/getconfig.php";
	$conn=mysqli_connect("localhost",$sqlun,$sqlp,$sqld);
	if($conn->connect_error)
    	die("Connection to database failed: ".$conn->connect_error);

    $query = "select count(*) from pairs as t1,adminaccount as t2 where t1.adminusername=t2.username and t2.active=1";
	if($result = $conn->query($query)){
		if($row=$result->fetch_assoc())
			if($row['count(*)']<$pno)
				die("110");
	}

	$query = "select * from pairs as t1,adminaccount as t2 where t1.adminusername=t2.username and t2.active=1 ORDER BY Rand() limit $pno ";
	$result = $conn->query($query);
	$counter=0;
	$printed=array();
	
	while($row=$result->fetch_assoc()){
		echo $row['c1name'].";;".$row['c1type']."::".$row['c2name'].";;".$row['c2type'].";;;";
	}
	
?>