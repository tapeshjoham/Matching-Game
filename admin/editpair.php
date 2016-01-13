<!DOCTYPE html>
<html>
<head>
	<title>Update Pairs</title>
</head>
<body>
<h1 align="center">EDIT PAIRS</h1><br>
<center>
	<form id="box" action="editpair.php" method="post">
		<br>Select Type : <br><br>

		<?php

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
				$conn = new mysqli("localhost",$sqlun,$sqlp,"matchthefollowinggame");
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

			include '/var/www/html/Matching-Game/assets/getconfig.php';

			$conn = new mysqli("localhost",$sqlun,$sqlp,"matchthefollowinggame");
			if($conn->connect_error){
				die ("Connection Failed:".$conn->connect_error);
			}

			$option = $_POST['submit'];
			$col = $_POST['pair'];
			if($option=="Delete") {
					$query="SELECT * FROM pairs WHERE c1name='$col'";
					$result=$conn->query($query);
					$row=mysqli_fetch_row($result);
					if($row[1]!="text")
					{
						$path = "/var/www/html/Matching-Game/assets/".$row[1]."/".$row[0];
						//echo $path;
						if(unlink($path)) echo "File Deleted<br><br>"; 
						$type1 = $row[1];
					}
					if($row[3]!="text")
					{
						$path = "/var/www/html/Matching-Game/assets/".$row[3]."/".$row[2];
						if(unlink($path)) echo "File Deleted<br><br>"; 
						$type2 = $row[3];
						$col2 = $row[2];
					}
					$query="DELETE from pairs WHERE c1name='$col'";	
					$result=$conn->query($query);
					if($type1!="")
						udpate_database($col,$type1);
					if(($type1!=$type2) && $type2!="")
						udpate_database($col2,$type2);
			}
			if($option=="Edit")
			{
					$query="SELECT * FROM pairs WHERE c1name='$col'";
					$result=$conn->query($query);
					$row=mysqli_fetch_row($result);
					echo '<form id="update" action="editpair.php" method="post">';
					if($row[1]=="text")
						echo '<input type="text" name="edit1" value="'.$row[0].'"><br><br>';
					else echo '<input type="file" name="edit1"><br><br>';
					if($row[3]=="text")
						echo '<input type="text" name="edit2" value="'.$row[2].'"><br><br>';
					else echo '<input type="file" name="edit2"><br><br>';
					echo '<input type="hidden" name="key" value="'.$col.'"></input>';
					echo '<input type="submit" name="submit" value="Update"></input><br><br>';
					echo '</form>';					
			}
			if($option=="Update")
			{
				$key = $_POST['key'];
				$query="SELECT * FROM pairs WHERE c1name='$key'";
				$result=$conn->query($query);
				$row=mysqli_fetch_row($result);
				$cmp = $row[0];
				if($row[1]=="text")
				{
					$value = $_POST['edit1'];
					$query = "UPDATE pairs SET c1name='$value' WHERE c1name='$row[0]'";
					$res = $conn->query($query);
					$cmp = $value;
				}
				else{
					$exts=pathinfo($_FILES['edit1']['name'],PATHINFO_EXTENSION);
					echo $exts;
					if($exts!=""){
						$path = "/var/www/html/Matching-Game/assets/".$row[1]."/".$row[0];
						if (move_uploaded_file($_FILES["edit1"]["tmp_name"],$targetfilec2))
							echo "<br>The file has been uploaded.";
	    				else die("<br>Sorry, there was an error uploading the file.<br>");	
					}
				}
				if($row[3]=="text")
				{
					$value = $_POST['edit2'];
					$query = "UPDATE pairs SET c2name='$value' WHERE c1name='$cmp'";
					$res = $conn->query($query);
				}
				else{
					$exts=pathinfo($_FILES['edit2']['name'],PATHINFO_EXTENSION);
					if($exts!=""){
						$path = "/var/www/html/Matching-Game/assets/".$row[3]."/".$row[2];
						if (move_uploaded_file($_FILES["edit2"]["tmp_name"],$path))
							echo "<br>The file has been uploaded.";
	    				else die("<br>Sorry, there was an error uploading the file.<br>");	
					}
				}
				echo "Successfully Updated! <br><br>";
			}
			$query="SELECT * from pairs";
			$result=$conn->query($query);
			echo '<select name="pair">';
			while ($row=mysqli_fetch_row($result)) {
					echo'<option value="'.$row[0].'">'.$row[0].' /// '.$row[2].'<br>';
			}
			echo '</select>';
			mysqli_free_result($result);
		?>

  		<br><br><input type="submit" name="submit" value="Edit"><input type="submit" name="submit" value="Delete">
	</form>

</center>
</body>
</html>