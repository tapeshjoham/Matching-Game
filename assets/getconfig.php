
<?php
	
	include "getpath.php";

	$file=fopen($localhost."Matching-Game/assets/config.txt","r");
	$sqlun;
	$sqlp;
	$sqld;
	$pno;
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
		if($pieces[0]=="sql_database"){
			$sqld=$pieces[1];
			//echo $sqlp;
		}
		if($pieces[0]=="pairs_no"){
			$pno=$pieces[1];
			//echo $sqlp;
		}
	}
	fclose($file);
?>