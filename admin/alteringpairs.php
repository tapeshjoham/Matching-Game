<!DOCTYPE html>
<html>
	<head>
		<title>
			Altering pairs
		</title>
	</head>
	<body>
		<?php
			include '/var/www/html/Matching-Game/assets/getconfig.php'; // Connecting to Database

			$conn = new mysqli("localhost",$sqlun,$sqlp,"matchinggame");
			if($conn->connect_error){
				die ("Connection Failed:".$conn->connect_error);
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
	</body>
</html>