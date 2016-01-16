<!DOCTYPE html>
<html>
<head>
	<title>Update Pairs</title>
</head>
<body>
<h1 align="center">UPDATE PAIRS</h1><br>
<center>
	<form id="box" action="editprocess.php" method="post" enctype="multipart/form-data">
		<br>Select Type : <br><br>	

			<div style="float:left;width:50%">
				column1
				<br>
				<br>
				<input type="radio" name="c1filetype" value="text" checked/>text<br>
				<input type="radio" name="c1filetype" value="audio"/>audio<br>
				<input type="radio" name="c1filetype" value="video"/>video<br>
				<input type="radio" name="c1filetype" value="image"/>image<br>
				<input type="radio" name="c1filetype" value="same"/>Remain Same<br>
				<br>
				<br>
				<input type="file" name="c1file" id="c1file" style="width:200px;"/>
				<br>
				<br>
				<input type="text" name="c1name" id="c1text"/>
			</div>
			<div style="float:left;width:50%;">
				column2
				<br>
				<br>
				<input type="radio" name="c2filetype" value="text" checked/>text<br>
				<input type="radio" name="c2filetype" value="audio"/>audio<br>
				<input type="radio" name="c2filetype" value="video"/>video<br>
				<input type="radio" name="c2filetype" value="image"/>image<br>
				<input type="radio" name="c2filetype" value="same"/>Remain Same<br>
				<br>
				<br>
				<input type="file" name="c2file" id="c2file" style="width:200px;"/>
				<br>
				<br>
				<input type="text" name="c2name" id="c2text"/>
			</div>

	<?php
			include '/var/www/html/Matching-Game/assets/getconfig.php';

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

  		
		<br><br><input type="submit" name="submit" value="Update">
	</form>

</center>
</body>
</html>