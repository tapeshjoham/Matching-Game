
<?php
//file for adding pairs to database and uploading respective files
	session_start();
	include "getpath.php";

	function getextension($name){
		$name=explode(".",$name);
		return $name[1];
	}	

	function getsrno($name){
		$name=explode(".",$name);
		return (int)substr($name[0],5);
	}

	function checkfile($name,$type,$no){
		if($_FILES[$name]["size"]/(1024*1024)>10){
			echo "<br>[process]:file size is greater that allowed 10mB<br>";
			return 00;
		}

		$exts = pathinfo($_FILES[$name]['name'],PATHINFO_EXTENSION);
		
		if($type=="audio")
			if($exts=="mp3"||$exts=="wav"||$exts=="ogg"||$exts=="MP3")
				return 1;
		if($type=="video")
			if($exts=="mp4")
				return 1;
		if($type=="image")
			if($exts=="jpg"||$exts=="jpeg"||$exts=="png"||$exts=="gif")
				return 1;
		if($type=="text")
			if($_POST['c'.$no.'name']==""){
				echo "<br>[process]:text boxes are empty<br>";
				return 0;
			}
			else
				return 1;

		echo "<br>[process]:file is not of $type type<br>";
		return 00;	
	}

	function getfilename($type){
		include "getpath.php";		
		include $localhost.'Matching-Game/assets/getconfig.php';
		$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error);
		}
		$query1="select c1name as name,id from pairs where c1type='".$type."' order by id desc limit 1 ";
		$result1=$conn->query($query1);
		$query2="select c2name as name,id from pairs where c2type='".$type."' order by id desc limit 1 ";
		$result2=$conn->query($query2);
		if($result1&&$result2){
			$data1=$result1->fetch_assoc();
			$data2=$result2->fetch_assoc();
			$data1=$data1['name'];
			$data2=$data2['name'];
			$srno1=getsrno($data1);
			$srno2=getsrno($data2);
			if($srno1>$srno2){
				return $type.($srno1+1);
			}else{
				return $type.($srno2+1);
			}
		}
	}

	echo "<br>[process]:add pair process started<br>";

	$c1name;$c2name;
	$c1filetype=$_POST['c1filetype'];
	$c2filetype=$_POST['c2filetype'];
	$targetdir = $localhost."Matching-Game/assets/";
	
	//checking validity of files
	echo "<br>[process]:checking first file<br>";
	$chkf1=checkfile("c1file",$c1filetype,1);
	echo "<br>[process]:checking second file<br>";
	$chkf2=checkfile("c2file",$c2filetype,2);

	if(!($chkf1!=0&&$chkf2!=0))
		die("<br>aborting process<br>::;;error!");

	echo "<br>[process]:processing first element of pair<br>";
	echo "<br>[process]:its type is $c1filetype<br>";

	if($c1filetype=="text"){
		$c1name=$_POST['c1name'];
		echo "<br>[process]:text is $c1name<br>";
	}else{
		//uploading first file

		$targetdirc1=$targetdir.$c1filetype."/";
		
		$exts = pathinfo($_FILES['c1file']['name'],PATHINFO_EXTENSION);
		
		$c1name=getfilename($c1filetype);
		$c1name=$c1name.".".$exts;
		$targetfilec1=$targetdirc1.$c1name;

		echo "<br>[process]:uploading first file<br>";
		echo "<br>[process]:its path is $targetfilec1<br>";
		
		if (move_uploaded_file($_FILES["c1file"]["tmp_name"],$targetfilec1)){
			echo "<br>[process]:the file has been uploaded<br>";
	    }else{
			die("<br>[process]:ERROR! error uploading the file<br>::;;error!");
	    }
	}

	echo "<br>[process]:processing second element of pair<br>";
	echo "<br>[process]:its type is $c2filetype<br>";

	
	if($c2filetype=="text"){
		$c2name=$_POST['c2name'];
		echo "<br>[process]:text is $c2name<br>";
	}else{
		//uploading second file

		$targetdirc2=$targetdir.$c2filetype."/";
		
		$exts=pathinfo($_FILES['c2file']['name'],PATHINFO_EXTENSION);
		
		$c2name=getfilename($c2filetype);
		if($c1filetype==$c2filetype){
			$c2name=$c2filetype."".(getsrno($c2name.".".$exts)+1);	
		}
		$c2name=$c2name.".".$exts;
		$targetfilec2=$targetdirc2.$c2name;

		echo "<br>[process]:uploading second file<br>";
		echo "<br>[process]:its path is $targetfilec2<br>";
		
		if (move_uploaded_file($_FILES["c2file"]["tmp_name"],$targetfilec2)){
			echo "<br>[process]:the file has been uploaded<br>";
	    }else{
			die("<br>[process]:ERROR! error uploading the file<br>::;;error!");
	    }
	}

	include $localhost.'Matching-Game/assets/getconfig.php';
	$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
	if($conn->connect_error){
		die ("<br>[process]:Connection Failed:".$conn->connect_error."<br>::;;error!");
	}

	//getting id
	$id=1;
	$result=$conn->query("select max(id) from pairs");
	if($row=mysqli_fetch_row($result))
		$id=$row[0]+1;

	//updating database
	$query = "insert into pairs values('$c1name','$c1filetype','$c2name','$c2filetype','".$_SESSION['username']."',$id)";
	$result = $conn->query($query);//running sql query
	if($result){
		echo "<br>[process]:pair added to database<br>::;;pair added";
	}else{
		echo "<br>[process]:cannot update database::;;error!<br>";
	}
?>