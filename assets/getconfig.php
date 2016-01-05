<?php
	$file=fopen("/var/www/html/Matching-Game/assets/config.txt","r");
	$sqlun;
	$sqlp;
	while($line=fgets($file)){
		$pieces=explode(":",$line);
		if($pieces[0]=="sql_username"){
			$sqlun=$pieces[1];
			//echo $sqlun;
		}
		if($pieces[0]=="sql_password"){
			$sqlp=$pieces[1];
			//echo $sqlp;
		}
	}
	fclose($file);
?>