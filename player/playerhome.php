<?php
	include "getpath.php";

	session_start();
	$_SESSION['username']=htmlspecialchars($_POST['username']);
	$_SESSION['password']=htmlspecialchars($_POST['password']);
	$_SESSION['usertype']=htmlspecialchars($_POST['usertype']);
	include $localhost.'Matching-Game/assets/checkcredentials.php';
	if($output==104)
		die("invalid credentials");
	if($output==103)
		die("permission denied");
    
    //function for getting high score of player till now
	function gethighscore(){
		include "getpath.php";		
		//creating sql un and pass
		include $localhost."Matching-Game/assets/getconfig.php";
		$conn=mysqli_connect("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
	    	die("Connection to database failed: ".$conn->connect_error);
	    }
		if($result=$conn->query("select * from playerprofile where username='".$_SESSION['username']."'"))
			if($row=$result->fetch_assoc())
				return 	$row['highscore'];
		
	}

	//function for getting average score of the player till now
	function getaverage(){
		include "getpath.php";		
		//creating sql un and pass
		include $localhost."Matching-Game/assets/getconfig.php";
		$conn=mysqli_connect("localhost",$sqlun,$sqlp,$sqld);
		if($conn->connect_error){
	    	die("Connection to database failed: ".$conn->connect_error);
	    }
		if($result=$conn->query("select avg(score) from gamesplayed where playerusername='".$_SESSION['username']."'"))
			if($row=$result->fetch_assoc())
				return 	$row['avg(score)'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			player | home
		</title>
		<link type="text/css" rel="stylesheet" href="style.css"/>
 	 	<script src="/Matching-Game/assets/jquery.min.js"></script>
  		<script src="/Matching-Game/assets/jquery-ui.min.js"></script>
	</head>
	<body>
		<div id="actionbar">
			<img src="/Matching-Game/assets/admin.png" style="padding:4px;margin-right:8px;margin-left:8px;" height="26px"/>
			<?php echo $_SESSION['username'];?>
		</div>
		<div id="userinfo">
			<div class="actionbtn" id="submitbtn" style="" onclick="submitbtnclicked()">
				submit
			</div>
			<div class="vr"></div>
			<div class="actionbtn actionbarbtn" onclick="refreshpairs()">
				<img src="/Matching-Game/assets/replay.png" height="26px"/>
			</div>
			<div class="vr"></div>
			<div class="actionbtn actionbarbtn"  onclick="showmenu()">
				<img src="/Matching-Game/assets/close.png" height="26px"/>
			</div>
			<div class="vr"></div>
		</div>
		<div id="scoreoverlay" class="overlay">
			<div>
				
				<img class="transparentfab" src="/Matching-Game/assets/close.png" height="22px" onclick="$('#scoreoverlay').fadeOut('fast')"/>
				<br>
				<img src="/Matching-Game/assets/score.png" style="padding:4px;margin:0px;" height="80px"/>
				
				<br>
				<div id="score">
					
				</div>
			</div>	 
		</div>
		<div id="loading" class="overlay">
			<div id="loadingchild">
				<img src="/Matching-Game/assets/loading.gif" height="100px" />
				<br>
				<font id="loadingtext">loading</font> . . .
			</div>
		</div>
		<div id="menu" class="overlay">
			<div id="menuchild" style="text-align:center;">
				
				<img src="/Matching-Game/assets/admin.png" style="padding:4px;margin:0px;" height="26px"/>
				<br>
				<?php echo $_SESSION['username'];?>
				<br>
				<img class="transparentfab" id="play" src="/Matching-Game/assets/play.png" onclick="srbtnclick()" height="40px"/>

				<div id="fabs" style="">
					<img class="transparentfab" src="/Matching-Game/assets/back.png" onclick="history.back()" height="22px"/>
					<div class="vr"></div>
					<div id="highscorebtn" class="actionbtn" >
						<img src="/Matching-Game/assets/highscore.png"  height="22px"/>
					</div>
					<div class="vr"></div>
					<div id="rankingbtn" class="actionbtn" >
						<img src="/Matching-Game/assets/ranking.png" height="22px"/>
					</div>
					<br>	
				</div>
				<div id="actiontext" style="">
					
				</div>
			</div>
		</div>
		<script>
			//player stats button onhover listeners
			$("#highscorebtn").hover(
				function(){
					$("#actiontext").html("Highscore<br><font style='font-size:140%'>"+<?php echo gethighscore();?>+"</font>");
					$("#actiontext").css("background-color","rgba(0,0,0,0.3)");
				},function(){
					$("#actiontext").html("");
					$("#actiontext").css("background-color","rgba(0,0,0,0)");
				}
			);
			$("#rankingbtn").hover(
				function(){
					$("#actiontext").html("Average score<br><font style='font-size:140%'>"+<?php echo getaverage();?>+"</font>");
					$("#actiontext").css("background-color","rgba(0,0,0,0.3)");
				},function(){
					$("#actiontext").html("");
					$("#actiontext").css("background-color","rgba(0,0,0,0)");
				}
			);
		</script>
		<div class="settingselement">
			arrange the elements of column 2 by drag and drop vertically to match the elements in column 1
		</div>
		<br>
		<br>
		<div style="float:left;width:50%">
			column1
			<hr>
			<br>
			<ul id="c1list">
			</ul>
		</div>
		<div style="float:left;width:50%;">
			column2
			<hr>
			<br>
			<ul id="c2list">
			</ul>
		</div>
		<br>
		<br>
		<br>
		
		<script>
			function hidemenu(){$("#menu").fadeOut('slow');}
			function showmenu(){$("#menu").fadeIn('slow');}
		</script>
		<script>
			//everything related to the game , preparation to submission goes here
			var col2actual;
			
			//funciton that prepares the game or refreshes the pairs
			function refreshpairs(){
				var col1=[];
				var col2=[];
				var printed=[];
				var c1=document.getElementById('c1list');
				var c2=document.getElementById('c2list');
				c1.innerHTML="";
				c2.innerHTML="";
				var xhttp = new XMLHttpRequest();
	            xhttp.onreadystatechange = function() {
		            if(xhttp.readyState == 4 && xhttp.status == 200) {
		                var response = xhttp.responseText;
		                if(response==110){
		                	alert("not enough data in database , contact admin , you cannot play the game");
		                	$("#loading").fadeOut("fast");
		                	$("#menu").fadeIn("fast");
		                }else{
			                parseAndPrint(response,col1,col2,c1,c2,printed);
			                $("#loading").fadeOut("fast");
		            	}
		            }
	            }       
	        	xhttp.open("GET", "getPairs.php", true);
	        	xhttp.send();
	        	$("#loading").fadeIn("fast");
	        	$("#loadingtext").text("preparing game");	
			}

			//printing respective html5 media element
        	function printhtml(name,type,htmlelement,ID){
        		
        		if(type=="audio"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" class='pairelement'><"+type+" controls><source src=\"/Matching-Game/assets/"+type+"/"+name+"\" type=\""+type+"/ogg\"/></"+type+"><br></div></li>";
        		}
        		if(type=="video"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" class='pairelement'><"+type+"  controls><source src=\"/Matching-Game/assets/"+type+"/"+name+"\" type=\""+type+"/mp4\"/></"+type+"><br></div></li>";
        		}
        		if(type=="image"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" class='pairelement'><img  src=\"/Matching-Game/assets/"+type+"/"+name+"\"/><br></div></li>";
        		}
        		if(type=="text"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" class='pairelement'>"+name+"</div></li>";
        		}
        	}

        	//funciton for parsing and printing the data recieved from php file
			function parseAndPrint(response,col1,col2,c1,c2,printed){
				var pieces1 = response.split(";;;");
				var index=0;

				//parsing and making the arrays of col1 and col2 data
				
				while(index<(pieces1.length-1)){
					var pieces2=pieces1[index].split("::");
					col1.push(pieces2[0]);
					var pieces3=col1[index].split(";;");
					printhtml(pieces3[0],pieces3[1],c1,"c1"+index);
					col2.push(pieces2[1]);
					index++;
				}
				col2actual=col2;
				
				index=0;
				var count=-1;
				
				while(printed.length!=col2.length){
					var index2=Math.floor((Math.random() * col2.length) + 1)-1;
					if(!exists(index2,printed)){
						var pieces3=col2[index2].split(";;");	
						printhtml(pieces3[0],pieces3[1],c2,"c2"+(count+1));
						count++;
						printed.push(index2);
					}
					index++;
					if(index==col2.length)
						index=0;
				}
				
			}

			function exists(value,array){
				var index=0;
				var len=array.length;
				while(index<len){
					if(array[index]==value){
						return true;
					}
					index++;
				}
				return false;
			}

			//submit button onclick listeners
			function submitbtnclicked(){
				var score=0;
				var index=0;
				while(index<5){
					var onpage = $("#c2list li:nth-child("+(index+1)+") div").data("src");
					var actual=col2actual[index].split(";;");
					var actual=actual[0];
					if(actual==onpage)
						score++;
					index++;
				}
				document.getElementById('score').innerHTML="your score is<br><br><font style='font-size:140%;'>"+score+"</font><br><br>";
				updateplayerprofile(score);
				
				$("#menu").fadeIn("fast");
				$("#scoreoverlay").fadeIn("fast");
				$("#play").attr("src","/Matching-Game/assets/replay.png");
				showmenu();
			}

			//function for updating playr profile
			function updateplayerprofile(score){
				var xhttp = new XMLHttpRequest();
	            xhttp.onreadystatechange = function() {
		            if(xhttp.readyState == 4 && xhttp.status == 200) {
		                var response = xhttp.responseText;
		                $("#loading").fadeOut("fast");
		                addgametodatabase(score);

		                if(response==107){
	                       	$("#score").append("<br>you made a highscore");
	                    }
	                    if(response==106){
	                       	//$("#score").append("<br>profile updatd");
	                    }
	                    if(response==103)
	                        	alert("query returning zero , contact admin");
		            }
	            }       
	        	xhttp.open("GET", "updateplayerprofile.php?score="+score, true);
	        	xhttp.send();
	        	$("#loading").fadeIn("fast");
	        	$("#loadingtext").text("updating player profile");	
			}

			//function for adding game to database
			function addgametodatabase(score){
				var xhttp = new XMLHttpRequest();
	            xhttp.onreadystatechange = function() {
		            if(xhttp.readyState == 4 && xhttp.status == 200) {
		                var response = xhttp.responseText;
		                $("#loading").fadeOut("fast");
		                 if(response==102){
	                       	//$("#score").append("<br>game added");
	                    }
	                    if(response==103)
	                        	alert("query returning zero , contact admin");
		            }
	            }       
	        	xhttp.open("GET", "addgametodatabase.php?score="+score, true);
	        	xhttp.send();
	        	$("#loading").fadeIn("fast");
	        	$("#loadingtext").text("adding game to database");
			}

			//play button onclick listener
			function srbtnclick(){
				hidemenu();
				refreshpairs();
				$('#srbtn').attr('value','replay');
			}
		</script>
		<script>
			//initialising attributes
			$("document").ready(function(){
				$("#scoreoverlay").hide();
				$("#c2list").sortable({axis:"y"});
    			$("#c2list").disableSelection();
    			$(".overlay").css("height",$(window).height()+"px");
    			$(".dialog").css("height",$(window).height()+"px");
    			$("hr").attr("color","#fff");
    			$(".vr").css("height",$("#fabs").height()+"px");
    			$("#actiontext").css("width",$("menuchild").width()+"px");
    			$("#actionbar").css("width",$(window).width()+"px");
			});
			$(window).load(function(){
				$("#loading").fadeOut("fast");
			});
			$(window).resize(function(){
				$("#actionbar").css("width",$(window).width()+"px");
				$(".overlay").css("height",$(window).height()+"px");
			});
		</script>
	</body>
</html>