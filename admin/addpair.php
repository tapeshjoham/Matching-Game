
<?php
/*
Note - Command for MySQL is different for mine ...check if its working 
*/
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
	getfilename('audio');
	$c1name;$c2name;
	$c1filetype=$_POST['c1filetype'];//file types
	$c2filetype=$_POST['c2filetype'];
	$targetdir = "/var/www/html/Matching-Game/assets/";
//uploading first file	
	if($c1filetype=="text"){
		$c1name=$_POST['c1name'];
	}else{
		$targetdirc1=$targetdir.$c1filetype."/";//finding target/where-to-upload directory wrt file type and storing it in $targetfiledirc1
		
		$c1name="c111111";//file name to be modified****
		
		$targetfilec1=$targetdirc1.$c1name.".".$exts;//this is the whole path of the upload file , including the name
		
		$c1name="c111111.".$exts;//storing whole path in the filename
		$exts = pathinfo($_FILES['c1file']['name'],PATHINFO_EXTENSION); //finding the extension of file and storing it in $exts
		
		$c1name=getfilename($c1filetype);
		$c1name=$c1name.".".$exts;
		$targetfilec1=$targetdirc1.$c1name;//this is the whole path of the upload file , including the name
		echo $targetfilec1;
		
		if (move_uploaded_file($_FILES["c1file"]["tmp_name"],$targetfilec1)){
			echo "<br>The file has been uploaded , its path is :<br>$targetdirc1$targetfilec1<br>";
	    }else{
			die("<br>Sorry, there was an error uploading the file.There may be premission problems with the upload folder.<br>");
	    }
	}
//uploading second file
	if($c2filetype=="text"){
		$c2name=$_POST['c2name'];
	}else{
		
		$targetdirc2=$targetdir.$c2filetype."/";
		
		//$exts=findexts(basename($_FILES["c2file"]["name"]));
		
		$exts=pathinfo($_FILES['c2file']['name'],PATHINFO_EXTENSION);
		
		$c2name=getfilename($c2filetype);
		if($c1filetype==$c2filetype){
			$c2name=$c2filetype."".(((int)$c2name[strlen($c2filetype)])+1);	
		}
		$c2name=$c2name.".".$exts;
		$targetfilec2=$targetdirc2.$c2name;
		echo $targetfilec2;
		if (move_uploaded_file($_FILES["c2file"]["tmp_name"],$targetfilec2)){
			echo "<br>The file has been uploaded , its path is :<br>$targetdirc2$targetfilec2<br>";
	    }else{
			die("<br>Sorry, there was an error uploading the file.There may be premission problems with the upload folder.<br>");
	    }
	}
	//including this file will create two variable $sqlun,$sqlp which contain sql username and password respectively , which are stored in sqlunp.txt
	include '/var/www/html/Matching-Game/assets/getconfig.php';
	$conn = new mysqli("localhost",$sqlun,$sqlp,"matchinggame");
	if($conn->connect_error){
		die ("Connection Failed:".$conn->connect_error);
	}
	$query = "insert into pairs values('$c1name','$c1filetype','$c2name','$c2filetype','admin1')";
	$result = $conn->query($query);//running sql query
	if($result){
		echo "<br>database successfully updated<br>";
	}else{
		echo "<br>cannot update database<br>";
	}
?>