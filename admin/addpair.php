<?php
/*
Note - Command for MySQL is different for mine ...check if its working 
*/
//including this file will create two variable $sqlun,$sqlp which contain sql username and password respectively , which are stored in sqlunp.txt
//include '/var/www/html/Matching-Game/assets/getsqlunp.php';

									//Connecting  database 
	////////////////////////////////////////////////////////////////////////////////////////////////////
	$username="root";$password="tapesh12345";$database="matchinggame";
	mysql_connect(localhost,$username,$password);//establishing sql connection
	@mysql_select_db($database) or die( "Unable to connect database");
    ////////////////////////////////////////////////////////////////////////////////////////////////////

	$c1name;$c2name;

	$c1filetype=$_POST['c1filetype'];//file types
	$c2filetype=$_POST['c2filetype'];

	$targetdir = "/var/www/html/Matching-Game/assets/";

//uploading first file	
	if($c1filetype=="text"){
		$c1name=$_POST['c1name'];
	}else{

		$targetdirc1=$targetdir.$c1filetype."/";//finding target/where-to-upload directory wrt file type and storing it in $targetfiledirc1
		
		$exts = pathinfo($_FILES['c1file']['name'],PATHINFO_EXTENSION); //finding the extension of file and storing it in $exts

		$result = mysql_query("SELECT COUNT(c1type) as cnt FROM pairs WHERE c1type='$c1filetype'");
		$out = mysql_fetch_array($result);
		$count = $out['cnt'];
		$result = mysql_query("SELECT COUNT(c2type) as cnt FROM pairs WHERE c2type='$c1filetype'");
		$out = mysql_fetch_array($result);
		$count = $count+$out['cnt'];
		$count++;	

		$c1name=$c1filetype.$count;

		$targetfilec1=$targetdirc1.$c1name.".".$exts;//this is the whole path of the upload file , including the name
		
		$c1name=$targetfilec1;//storing whole path in the filename

		echo $c1name;
		
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
		
		$exts=pathinfo($_FILES['c2file']['name'],PATHINFO_EXTENSION);

		$result = mysql_query("SELECT COUNT(c1type) as cnt FROM pairs WHERE c1type='$c2filetype'");
		$out = mysql_fetch_array($result);
		$count2 = $out['cnt'];
		$result = mysql_query("SELECT COUNT(c2type) as cnt FROM pairs WHERE c2type='$c2filetype'");
		$out = mysql_fetch_array($result);
		$count2 = $count2+$out['cnt'];	
		$count2++;
		if($c1filetype==$c2filetype)
			$count2++;
		$c2name=$c2filetype.$count2;//file name to be modified****
		
		$targetfilec2=$targetdirc2.$c2name.".".$exts;
		
		$c2name=$targetfilec2;
		
		echo $c2name;

		if (move_uploaded_file($_FILES["c2file"]["tmp_name"],$targetfilec2)){
			echo "<br>The file has been uploaded , its path is :<br>$targetdirc2$targetfilec2<br>";
	    }else{
			die("<br>Sorry, there was an error uploading the file.There may be premission problems with the upload folder.<br>");
	    }
	}
	$query = "insert into pairs values('$c1name','$c1filetype','$c2name','$c2filetype')";
	$result = mysql_query($query);//running sql query
	if($result){
		echo "<br>database successfully updated<br>";
	}else{
		echo "<br>cannot update database<br>";
	}
?>
