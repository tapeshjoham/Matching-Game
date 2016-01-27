<?php
	$file=fopen("path.txt","r");
	$localhost;
	
	while($line=fgets($file)){
		$pieces=explode(":",$line);
		$localhost=$pieces[1];
	}
	fclose($file);
?>