<?php
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function extension($type) {
		if($type=="audio")
			$ext = ".mp3";
		if($type=="video")
			$ext = ".mp4";
		if($type=="image")
			$ext = ".png";
		return $ext;
	}	

	function udpate_database($value='',$type='') {
		$targetdir = "/var/www/html/Matching-Game/assets/".$type."/";
		$value = chop($value,extension($type));
		$cnt = substr($value,5);
		$value = $value.extension($type);
		include '/var/www/html/Matching-Game/assets/getconfig.php';
		$conn = new mysqli("localhost",$sqlun,$sqlp,"matchinggame");
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error);
		}
		$query="SELECT * from pairs where (c1name>'$value' && c1type='$type')||(c2name>'$value'&&c2type='$type') ";
		$result=$conn->query($query);
		while ($row=mysqli_fetch_row($result)) {
			if($row[1]==$type) {
				rename($targetdir.$row[0],$targetdir.$value);
				$query = "UPDATE pairs SET c1name='$value' WHERE c1name='$row[0]'";
				$res = $conn->query($query);
				$cnt++;
				$value = $type.$cnt.extension($type);
			}
			if($row[3]==$type) {
				rename($targetdir.$row[2],$targetdir.$value);
				$query = "UPDATE pairs SET c2name='$value' WHERE c2name='$row[2]'";
				$res = $conn->query($query);
				$cnt++;
				$value = $type.$cnt.extension($type);
			}				
		}
	}

	function getfilename($type){
		
		include '/var/www/html/Matching-Game/assets/getconfig.php';
		$conn = new mysqli("localhost",$sqlun,$sqlp,"matchinggame");
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error);
		}
		$query1="select max(c1name) as name from pairs where c1type='".$type."'";
		$result1=$conn->query($query1);
		$query2="select max(c2name) as name from pairs where c2type='".$type."'";
		$result2=$conn->query($query2);
		if($result1&&$result2){
			$data1=$result1->fetch_assoc();
			$data2=$result2->fetch_assoc();
			$data1=$data1['name'];
			$data2=$data2['name'];
			$data1=$data1[strlen($type)];
			$data2=$data2[strlen($type)];
			if($data1>$data2){
				echo "<br>".$type."".($data1+1)."<br>";
				return $type."".($data1+1);
			}else{
				echo "<br>".$type."".($data2+1)."<br>";
				return $type."".($data2+1);
			}
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	include '/var/www/html/Matching-Game/assets/getconfig.php';
	$conn = new mysqli("localhost",$sqlun,$sqlp,"matchinggame");
	if($conn->connect_error) die ("Connection Failed:".$conn->connect_error);
	$c1name;$c2name;
	$c1filetype=$_POST['c1filetype'];//file types
	$c2filetype=$_POST['c2filetype'];
	$key = $_POST['pair'];
	$query="SELECT * FROM pairs WHERE c1name='$key'";
	$result=$conn->query($query);
	$row=mysqli_fetch_row($result);
	$cmp = $row[0];
	$targetdir = "/var/www/html/Matching-Game/assets/";

	if($c1filetype!="same")
	{
		$first = $row[0];
		$firsttype = $row[1];
		$second = $row[2];
		$secondtype = $row[3];
		if($row[1]!="text")
		{
			$path = "/var/www/html/Matching-Game/assets/".$row[1]."/".$row[0];
			if(unlink($path)) echo "File Deleted<br><br>";	
		}
		if($second!="text")
			rename($targetdir.$secondtype."/".$second,$targetdir.$secondtype."/"."temp".extension($secondtype));
		$query="DELETE from pairs WHERE c1name='$row[0]'";
		$result=$conn->query($query);
		if($firsttype!="text")
			udpate_database($first,$firsttype);
		if(($firsttype!=$secondtype) && $secondtype!="text")
			udpate_database($second,$secondtype);	
		if($c1filetype!="text")
		{
			$c1name=getfilename($c1filetype);
			$exts = pathinfo($_FILES['c1file']['name'],PATHINFO_EXTENSION);
			$c1name=$c1name.".".$exts;
			$targetfile =$targetdir.$c1filetype."/".$c1name;
			if (move_uploaded_file($_FILES["c1file"]["tmp_name"],$targetfile))
				echo "<br>The file has been uploaded<br>";
	   		else die("<br>Sorry, there was an error uploading the file.<br>");
		}
		else $c1name = $_POST['c1name'];
		if($secondtype!="text")
		{
	    	$c2name=getfilename($secondtype);
	    	if($c1name==$c2name)
	    	{
	    		$cnt = substr($value,5);
	    		$cnt++;
	    		$c2name = $secondtype.$cnt;
	    	}
	    	$c2name=$c2name.extension($secondtype);
	    	rename($targetdir.$secondtype."/"."temp".extension($secondtype),$targetdir.$secondtype."/".$c2name);
	    	$second = $c2name;
		}
	    $query = "insert into pairs values('$c1name','$c1filetype','$second','$secondtype')";
		$result = $conn->query($query);   
		$cmp = $c1name; 
	}
	if($c2filetype!="same")
	{
		$query="SELECT * FROM pairs WHERE c1name='$cmp'";
		$result=$conn->query($query);
		if($row[3]!="text")
		{
			$path = "/var/www/html/Matching-Game/assets/".$row[3]."/".$row[2];
			if(unlink($path)) echo "File Deleted<br><br>";	
		}
		if($c2filetype!="text")
		{
			$exts=pathinfo($_FILES['c2file']['name'],PATHINFO_EXTENSION);
			$c2name=getfilename($c2filetype);
			$c2name=$c2name.".".$exts;
			$targetfile =$targetdir.$c2filetype."/".$c2name;
			if (move_uploaded_file($_FILES["c2file"]["tmp_name"],$targetfile))
				echo "<br>The file has been uploaded<br>";
	   		else die("<br>Sorry, there was an error uploading the file.<br>");
		}
		else $c2name=$_POST['c2name'];
		$query = "UPDATE pairs SET c2name='$c2name',c2type='$c2filetype' WHERE c1name='$cmp'";
		$result = $conn->query($query);
	}
	echo "Successfully Updated! <br><br>";

?>