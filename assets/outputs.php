<?php
	function getoutput($code){
		switch($code){
			case 101:
				return "username already taken , try another one";
			case 102:
				return "everything alright , move forward";
			case 103:
				return "query returning 0 , technical problem";
			case 104:
				return "invalid credentials";
			case 105:
				return "error in table transactions , technical problem";
			case 106:
				return "current score is not greater than highscore";
			case 107:
				return "player made highscore";
		}
	}
?>