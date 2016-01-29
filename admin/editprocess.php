<?php
	
	function getextension($name){
		echo "<br>$name<br>";
		$name=explode(".",$name);
		
		return $name[1];
	}	

	function getsrno($name){
		$name=explode(".",$name);
		return (int)substr($name[0],5);
	}

	function checkfile($name,$type){
		if($_FILES[$name]["size"]/(1024*1024)>10){
			echo "<br>[process]:file size is greater that allowed 10mB<br>";
			return 00;
		}

		$exts = pathinfo($_FILES[$name]['name'],PATHINFO_EXTENSION);
		
		if($type=="audio")
			if($exts=="mp3"||$exts=="wav"||$exts=="ogg")
				return 1;
		if($type=="video")
			if($exts=="mp4")
				return 1;
		if($type=="image")
			if($exts=="jpg"||$exts=="jpeg"||$exts=="png"||$exts=="gif")
				return 1;
		if($type=="text")
			if($_POST['c1name']==""||$_POST['c2name']==""){
				echo "<br>[process]:text boxes are empty<br>";
				return 0;
			}
			else
				return 1;
		if($type=="same")
			return 1;

		echo "<br>[process]:file is not of $type type<br>";
		return 00;	
	}

	function udpate_database($value='',$type='',$id) {
		echo "<br>[process]:update database process started<br>";

		include "getpath.php";
		$targetdir = $localhost."Matching-Game/assets/".$type."/";
		
		$srno=getsrno($value);

		include $localhost.'Matching-Game/assets/getconfig.php';
		$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error);
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

	function update_id($id){
		echo "<br>[process]:update id in database process started<br>";

		include "getpath.php";
		
		include $localhost.'Matching-Game/assets/getconfig.php';
		$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
			die ("Connection Failed:".$conn->connect_error);
		}

		$query="UPDATE pairs SET id=id-1 WHERE id>$id ";
		$result=$conn->query($query);
		if($result){
			echo "<br>[process]:id updated<br>";
		}else{
			echo "<br>[process]:error updating id<br>";
		}
	}

	session_start();
	include "getpath.php";
	
	echo "<br>[process]:edit pair process started<br>";

	$c1name;$c2name;

	$c1filetype=$_POST['c1filetype'];//file types
	$c2filetype=$_POST['c2filetype'];

	$pairid = $_POST['pairid'];

	$targetdir = $localhost."Matching-Game/assets/";
	
	echo "<br>[process]:checking first file<br>";
	$chkf1=checkfile("c1file",$c1filetype);
	echo "<br>[process]:checking second file<br>";
	$chkf2=checkfile("c2file",$c2filetype);

	if(!($chkf1!=0&&$chkf2!=0))
		die("<br>aborting process<br>::;;error!");

	include $localhost.'Matching-Game/assets/getconfig.php';
	
	$conn = new mysqli("localhost",$sqlun,$sqlp,$sqld);// Connecting to database
	if($conn->connect_error) 
		die ("Connection Failed:".$conn->connect_error."::;;error!");
	
	$query="SELECT * FROM pairs WHERE id=$pairid";
	$result=$conn->query($query);
	$row=mysqli_fetch_row($result);
	$cmp = $pairid;
	$check = 0;

	echo "<br>[process]:process started for first element<br>";
	echo "<br>[process]:first element file type is $c1filetype<br>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($c1filetype!="same")  // Executes when user changes in column I
	{
		$first = $row[0];
		$firsttype = $row[1];
		$second = $row[2];
		$secondtype = $row[3];

		echo "<br>[process]:first element previous file type is $row[1]<br>";

		if($firsttype!="text")
		{
			$path = $targetdir.$row[1]."/".$row[0];
			if(unlink($path)) 
				echo "<br>[process]:file deleted $path<br>";	
		}

		if($secondtype!="text"){
			rename($targetdir.$secondtype."/".$second,$targetdir.$secondtype."/"."temp.".getextension($second));
			echo "<br>[process]:file renamed from $second to temp<br>";
		}

		$query="DELETE from pairs WHERE id=$pairid";
		$result=$conn->query($query);
		echo "<br>[process]:pair deleted from database<br>";

		if($firsttype!="text")
			udpate_database($first,$firsttype,$pairid);
		if(($firsttype!=$secondtype) && $secondtype!="text")
			udpate_database($second,$secondtype,$pairid);

		update_id($pairid);

		echo "<br>[process]:process of uploading new file started<br>";
		echo "<br>[process]:first element file type is $c1filetype<br>";

		if($c1filetype!="text")
		{
			$c1name=getfilename($c1filetype);
			$exts = pathinfo($_FILES['c1file']['name'],PATHINFO_EXTENSION);
			$c1name=$c1name.".".$exts;
			$targetfile =$targetdir.$c1filetype."/".$c1name;
			if (move_uploaded_file($_FILES["c1file"]["tmp_name"],$targetfile))
				echo "<br>[process]:file has been uploaded $targetfile<br>";
	   		else 
	   			die("<br>[process]:there was an error uploading the file<br>::;;error!");
		}
		else 
			$c1name = $_POST['c1name'];
		
		echo "<br>[process]:second element file type is $secondtype<br>";

		if($secondtype!="text")
		{
	    	$c2name=getfilename($secondtype);

	    	if($c1filetype==$secondtype){
		    	$value = chop($c1name,getextension($c1name));
		    	
	    		$cnt = getsrno($c1name);
	    		$cnt++;
	    		$c2name = $secondtype.$cnt;

	    	}

	    	$c2name=$c2name.".".getextension($second);

	    	rename($targetdir.$secondtype."/"."temp.".getextension($second),$targetdir.$secondtype."/".$c2name);
	    	echo "<br>[process]:file renamed from temp to $c2name<br>";
	    	$second = $c2name;
		}

		$id=1;
		$result=$conn->query("select max(id) from pairs");
		if($row=mysqli_fetch_row($result))
			$id=$row[0]+1;

	    $query = "insert into pairs values('$c1name','$c1filetype','$second','$secondtype','".$_SESSION['username']."',$id)";
		$result = $conn->query($query);   
		
		echo "<br>[process]:pair inserted in database<br>";

		$cmp = $id;
		$check = 1;
	}

	echo "<br>[process]:process started for second element<br>";
	echo "<br>[process]:second element file type is $c2filetype<br>";

	if($c2filetype!="same")   // Executes when user changes in column II
	{
		
		$query="SELECT * FROM pairs WHERE id='$cmp'";  // Querying  from database
		$result=$conn->query($query);
		$row=mysqli_fetch_row($result);

		if($check==1) {  // If Upper code Executes
			echo "<br>[process]:previous element also changed<br>";

			echo "<br>[process]:old second element file type is $row[3]<br>";

			if($row[3]!="text")
			{
				$path = $targetdir.$row[3]."/".$row[2];
				if(unlink($path)) 
					echo "<br>[process]:file deleted $path<br>";
			}

			echo "<br>[process]:second element file type is $c2filetype<br>";

			if($c2filetype!="text")
			{
				$exts=pathinfo($_FILES['c2file']['name'],PATHINFO_EXTENSION);
				$c2name=getfilename($c2filetype);

				if($c2filetype==$row[3]){
					$cnt=getsrno($c2name);
					$cnt--;
					$c2name=$c2filetype.$cnt;
				}

				$c2name=$c2name.".".$exts;
				$targetfile =$targetdir.$c2filetype."/".$c2name;
				if (move_uploaded_file($_FILES["c2file"]["tmp_name"],$targetfile))
					echo "<br>[process]:file uploaded $targetfile<br>";
	   			else 
	   				die("<br>[process]:there was an error uploading the file.<br>::;;error!");
			}

			else 
				$c2name=$_POST['c2name'];

			$query = "UPDATE pairs SET c2name='$c2name',c2type='$c2filetype' WHERE id='$cmp'";
			$result = $conn->query($query);

			echo "<br>[process]:database updated<br>";
		}
		/////////////////////////////////////////////////////////////////////////////////////
		else{                         // Else this one executes

			echo "<br>[process]:previous element did not change<br>";
			
			$first = $row[0];
			$firsttype = $row[1];
			$second = $row[2];
			$secondtype = $row[3];

			echo "<br>[process]:old second element file type is $row[3]<br>";

			if($secondtype!="text")
			{
				$path = $targetdir.$row[3]."/".$row[2];
				if(unlink($path)) 
					echo "<br>[process]:file deleted $path<br>";	
			}

			if($firsttype!="text"){
				rename($targetdir.$firsttype."/".$first,$targetdir.$firsttype."/"."temp".getextension($first));
				echo "<br>[process]:file renamed from $first to temp<br>";
			}
			
			$query="DELETE from pairs WHERE id=$pairid";
			$result=$conn->query($query);

			echo "<br>[process]:pair deleted from database<br>";

			if($firsttype!="text")
				udpate_database($first,$firsttype,$pairid);
			if(($firsttype!=$secondtype) && $secondtype!="text")
				udpate_database($second,$secondtype,$pairid);

			update_id($pairid);
			
			echo "<br>[process]:first file type is $firsttype<br>";		
			if($firsttype!="text")
			{
				$c1name=getfilename($firsttype);
				$c1name=$c1name.".".getextension($first);
				rename($targetdir.$firsttype."/"."temp".getextension($first),$targetdir.$firsttype."/".$c1name);
				echo "<br>[process]:file renamed from temp to $c1name<br>";
			}
			else 
				$c1name = $first;

			echo "<br>[process]:second file type is $c2filetype<br>";	

			if($c2filetype!="text")
			{
	    		$c2name=getfilename($c2filetype);
	    		
	    		if($firsttype==$c2filetype)
	    		{
	    			$value = chop($c1name,getextension($first));
	    			$cnt = getsrno($value);
	    			$cnt++;
	    			$c2name = $c2filetype.$cnt;
	    		}

	    		$exts = pathinfo($_FILES['c2file']['name'],PATHINFO_EXTENSION);
	    		$c2name=$c2name.".".$exts;
	    		$targetfile =$targetdir.$c2filetype."/".$c2name;
				
				if (move_uploaded_file($_FILES["c2file"]["tmp_name"],$targetfile))
					echo "<br>[process]:file uploaded $targetfile<br>";	
	   			else 
	   				die("<br>[process]:there was an error uploading the file.<br>::;;error!");
			}
			else 
				$c2name = $_POST['c2name'];
	   		
			$id=1;
			$result=$conn->query("select max(id) from pairs");
			if($row=mysqli_fetch_row($result))
				$id=$row[0]+1;

	   		$query = "insert into pairs values('$c1name','$firsttype','$c2name','$c2filetype','".$_SESSION['username']."',$id)";
			$result = $conn->query($query);

			echo "<br>[process]:pair inserted into database<br>";	 
		}
	}
	echo "<br>[process]:process of editing complete<br>::;;editing complete!";	

?>