<?php
	//file for deleting pair from database and deleting corresponding files

	function getextension($name){
		$name=explode(".",$name);
		return $name[1];
	}	

	function getsrno($name){
		$name=explode(".",$name);
		return (int)substr($name[0],5);
	}

	/*function for updating database and maintaining continuous file names*/
	function udpate_database($value='',$type='',$id) {
		echo "<br>[process]:update database process started<br>";

		include "getpath.php";
		$targetdir = $localhost."Matching-Game/assets/".$type."/";
		
		$srno=getsrno($value);

		include $localhost.'Matching-Game/assets/getconfig.php';
		$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error."::;;error!");
		}
		
		$query="SELECT * from pairs where id>$id ";
		$result=$conn->query($query);
		
		while ($row=mysqli_fetch_row($result)) {
			if($row[1]==$type) {
				$ext=getextension($row[0]);
				rename($targetdir.$row[0],$targetdir.$type.$srno.".".$ext);
				$query = "UPDATE pairs SET c1name='$type$srno.$ext' WHERE c1name='$row[0]'";
				$res = $conn->query($query);
				echo "<br>[process]:$row[0] renamed to $type$srno.$ext<br>";
				$srno++;
			}
			if($row[3]==$type) {
				$ext=getextension($row[2]);
				rename($targetdir.$row[2],$targetdir.$type.$srno.".".$ext);
				$query = "UPDATE pairs SET c2name='$type$srno.$ext' WHERE c2name='$row[2]'";
				$res = $conn->query($query);
				echo "<br>[process]:$row[2] renamed to $type$srno.$ext<br>";
				$srno++;
			}				
		}
	}

	/*function for maintaining continuous id*/
	function update_id($id){
		echo "<br>[process]:update id in database process started<br>";

		include "getpath.php";
		
		include $localhost.'Matching-Game/assets/getconfig.php';
		$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error."::;;error!");
		}

		$query="UPDATE pairs SET id=id-1 WHERE id>$id ";
		$result=$conn->query($query);
		if($result){
			echo "<br>[process]:id updated<br>";
		}else{
			echo "<br>[process]:error updating id<br>";
		}
	}

	echo "<br>[process]:process of deletion started<br>";

	include "getpath.php";
	include $localhost.'Matching-Game/assets/getconfig.php';

	$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
	if($conn->connect_error){
		die ("Connection Failed:".$conn->connect_error."::;;error!");
	}

	$pairid = $_POST['pairid'];
	$type1="";
	$type2="";

	$query="SELECT * FROM pairs WHERE id='$pairid'";
	$result=$conn->query($query);
	$row=mysqli_fetch_row($result);
	
	//deleting first file
	echo "<br>[process]:first file type is $row[1]<br>";

	if($row[1]!="text"){
		$path = $localhost."Matching-Game/assets/".$row[1]."/".$row[0];
		if(unlink($path)) 
			echo "<br>[process]:file deleted $path<br>"; 
		$type1 = $row[1];
		$col1=$row[0];
	}
	
	echo "<br>[process]:second file type is $row[3]<br>";

	//deleting second file
	if($row[3]!="text"){
		$path = $localhost."Matching-Game/assets/".$row[3]."/".$row[2];
		if(unlink($path)) 
			echo "<br>[process]:file deleted $path<br>";
		$type2 = $row[3];
		$col2 = $row[2];
	}

	//updating database
	echo "<br>[process]:updating database<br>";

	$query="DELETE from pairs WHERE id='$pairid'";	
	$result=$conn->query($query);

	if($type1!="")
		udpate_database($col1,$type1,$pairid);
	if(($type1!=$type2) && $type2!="")
		udpate_database($col2,$type2,$pairid);

	update_id($pairid);

	echo "::;;deletion complete";
?>

  		
