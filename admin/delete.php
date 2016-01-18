<!DOCTYPE html>
<html>
<head>
	<title>Delete Pairs</title>
</head>
<body>
<h1 align="center">DELETE PAIRS</h1><br>
<center>
	<form id="box" action="delete.php" method="post">
		<br>Select Type : <br><br>

		<?php
			////////////////////////////////////////////Functions Used ////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////////////////
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
			///////////////////////////////////////////////////////////////////////////////////////////////////////////


			include '/var/www/html/Matching-Game/assets/getconfig.php'; // Connecting to Database

			$conn = new mysqli("localhost",$sqlun,$sqlp,"matchinggame");
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
			$query="SELECT * from pairs";
			$result=$conn->query($query);
			echo '<select name="pair">';
			while ($row=mysqli_fetch_row($result)) {
					echo'<option value="'.$row[0].'">'.$row[0].' /// '.$row[2].'<br>';
			}
			echo '</select>';
			mysqli_free_result($result);
		?>

  		<br><br><input type="submit" name="submit" value="Delete">
	</form>

</center>
</body>
</html>