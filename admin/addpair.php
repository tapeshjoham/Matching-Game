<?php
//tapesh you have to modify file names , have a look at lines 31 and 53


//function for finding extension of file
	function findexts($filename){
		$filename=strtolower($filename);
		$exts=split("[/\\.]",$filename);
		$n=count($exts)-1;
		$exts=$exts[$n];
		return $exts;
	}

	$c2name;
	$c1name;

	$c1filetype=$_POST['c1filetype'];//file types
	$c2filetype=$_POST['c2filetype'];

	$targetdir = "/var/www/html/Matching-Game/assets/";

//uploading first file	
	if($c1filetype=="text"){
		$c1name=$_POST['c1name'];
	}else{

		$targetdirc1=$targetdir.$c1filetype."/";//finding target/where-to-upload directory wrt file type and storing it in $targetfiledirc1
		
		$exts=findexts(basename($_FILES["c1file"]["name"]));//finding the extension of file and storing it in $exts
		
		$c1name="c111111";//file name to be modified****
		
		$targetfilec1=$targetdirc1.$c1name.".".$exts;//this is the whole path of the upload file , including the name
		
		$c1name="c111111.".$exts;//storing whole path in the filename
		
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
		
		$exts=findexts(basename($_FILES["c2file"]["name"]));
		
		$c2name="c222222";//file name to be modified****
		
		$targetfilec2=$targetdirc2.$c2name.".".$exts;
		
		$c2name="c222222.".$exts;
		
		if (move_uploaded_file($_FILES["c2file"]["tmp_name"],$targetfilec2)){
			echo "<br>The file has been uploaded , its path is :<br>$targetdirc2$targetfilec2<br>";
	    }else{
			die("<br>Sorry, there was an error uploading the file.There may be premission problems with the upload folder.<br>");
	    }
	}

	//including this file will create two variable $sqlun,$sqlp which contain sql username and password respectively , which are stored in sqlunp.txt
	include '/var/www/html/Matching-Game/assets/getsqlunp.php';

//updating database
	$conn=mysqli_connect("localhost",$sqlun,$sqlp,"matchthefollowinggame");//establishing sql connection
	if($conn->connect_error)
    	die("Connection to database failed: ".$conn->connect_error);

	$query = "insert into pairs values('$c1name','$c1filetype','$c2name','$c2filetype')";
	$result = $conn->query($query);//running sql query
	if($result){
		echo "<br>database successfully updated<br>";
	}else{
		echo "<br>cannot update database<br>";
	}
?>