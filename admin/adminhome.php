
<?php
	session_start();
	$_SESSION['username']=htmlspecialchars($_POST['username']);
	$_SESSION['password']=htmlspecialchars($_POST['password']);
	$_SESSION['usertype']=htmlspecialchars($_POST['usertype']);

	include '/var/www/html/Matching-Game/assets/checkcredentials.php';
	if($output==104)
		die("invalid credentials");
	if($output==103)
		die("permission denied");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			admin | home
		</title>
	</head>
	<body style="text-align:center;">
		<form name="form1" id="form1" method="post" action="addpair.php" enctype="multipart/form-data">
			<div style="float:left;width:50%">
				column1
				<br>
				<br>
				<input type="radio" name="c1filetype" value="text" checked/>text<br>
				<input type="radio" name="c1filetype" value="audio"/>audio<br>
				<input type="radio" name="c1filetype" value="video"/>video<br>
				<input type="radio" name="c1filetype" value="image"/>image<br>
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
				<br>
				<br>
				<input type="file" name="c2file" id="c2file" style="width:200px;"/>
				<br>
				<br>
				<input type="text" name="c2name" id="c2text"/>
			</div>
			<br>
			<br>
			<br>
			<input type="submit" id="submitbtn" value="submit"/>
		</form>	
		<script>
			var column1=document.getElementById('column1');
			var column2=document.getElementById('column2');
			function submitbtnclicked(){
				var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
	                if(xhttp.readyState == 4 && xhttp.status == 200) {
	                    var response = xhttp.responseText;
	                    if(response==1)
	                    	alert("success");
	                }
                }       
        		xhttp.open("GET", "addpair.php?c1="+column1.value+"&c2="+column2.value+"", true);
        		xhttp.send();
			}
		</script>
	</body>
</html>