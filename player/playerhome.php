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
		<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
 	 	<script src="/Matching-Game/assets/jquery.min.js"></script>
  		<script src="/Matching-Game/assets/jquery-ui.min.js"></script>
  		<style>
  			@font-face {
			    font-family: roboto-thin;
			    src: url('/Matching-Game/assets/Roboto/Roboto-Thin.ttf');
			}
			@font-face {
			    font-family: roboto-light;
			    src: url('/Matching-Game/assets/Roboto/Roboto-Light.ttf');
			}
			@font-face {
			    font-family: roboto-medium;
			    src: url('/Matching-Game/assets/Roboto/Roboto-Medium.ttf');
			}
			@font-face {
			    font-family: roboto-regular;
			    src: url('/Matching-Game/assets/Roboto/Roboto-Regular.ttf');
			}
			body{
				font-family:roboto-medium;
				color:#555;
			}
  			.overlay{
  				width:100%;
  				position:fixed;
				top:0;
				left:0;
				width:100%;
				background-color:#2196F3;box-shadow:0px 2px 4px rgba(0,0,0,1);padding:16px;
  			}
  			.transparentfab{
				padding:8px;
				margin:4px;
				border-radius:50%;
				transition:background-color 0.3s;
				cursor:pointer;
			}
			.transparentfab:hover{
				background-color: rgba(0,0,0,0.3);
			}
			.transparentfab:active{
				background-color: rgba(0,0,0,0.6);
			}
  			#loading{
  				z-index:200;
  				display:flex;
  				align-items:center;
  				background-color:#ededed;
  			}
  			ul { 
  				list-style-type:none;margin:0;padding: 0;
  			}
  			li { 
  				margin:0px;padding:0;height:200px;background-color:#f0f0f0;box-shadow: 0px 2px 20px rgba(0,0,0,0.3);
  			}
  			#c2list li { 
  				margin:0px;
  				padding:0;
  				height:200px;
  				background-color:#fff;
  				cursor:pointer;
  				transition:background-color 0.3s,box-shadow 0.3s;
  				box-shadow: 0px 2px 20px rgba(0,0,0,0.3);
  			}
  			#c2list li:hover { 
  				background-color:#fafafa;
  			}
  			#c2list li:active { 
  				background-color:#f0f0f0;
  				box-shadow: 0px 2px 40px rgba(0,0,0,0.3); 
  			}
  			.vr{
  				display:inline-block;
  				width:2px;
  				background-color:rgba(255,255,255,0.2);
  			}
  			.dialog{
  				width:100%;
  				position:fixed;
				top:0;
				left:0;
				background-color:rgba(0,0,0,0.9);
				font-family:roboto-medium;
				color:#fff;
				z-index:300;
				display:flex;
				align-items:center;
				justify-content:center;
  			}
  			.actionbtn{
				transition:background-color 0.3s;
				cursor:pointer;
			}
			.actionbtn:hover{
				background-color: rgba(0,0,0,0.3);
			}
			.actionbtn:active{
				background-color: rgba(0,0,0,0.6);
			}
			.pairelement{
				display:flex;
				align-items:center;
				justify-content:center;
				height:200px;
			}
			.pairelement img{
				width:200px;
				height:200px;
			}
			.pairelement video{
				width:200px;
				height:200px;
			}
			.pairelement audio{
				width:200px;
			}
			#actionbar{
				margin:0;
				padding:0;
				position: fixed;
				top:0px;
				left:0px;
				background:#2196F3;
				display: flex;
				align-items:center;
				justify-content:end;
				height:64px;
				z-index:10;
				color:#fff;
			}
			#userinfo{
				margin:0;
				padding:0;
				position:fixed;
				top:0px;
				right:0px;
				background:none;
				display: flex;
				align-items:center;
				z-index:20;
				height:64px;
				color:#fff;
			}
			.settingselement{
				display:flex;
				align-items:center;
				padding:8px;
				transition:background-color 0.3s;
				
				border-radius: 0px;
				 	
				margin-right: auto;
				margin-left: auto;
				margin-bottom: 16px;
				background-color: #fff;
				font-family:roboto-medium;
			}
  		</style>
	</head>
	<body style="text-align:center;padding-top:64px;background-color:#f0f0f0;">
		<div id="actionbar">
			<img src="/Matching-Game/assets/admin.png" style="padding:4px;margin-right:8px;margin-left:8px;" height="26px"/>
			<?php echo $_SESSION['username'];?>
		</div>
		<div id="userinfo">
			<div class="actionbtn" style="padding-right:8px;padding-left:8px;height:64px;display:flex;align-items:center;" onclick="submitbtnclicked()">
				submit
			</div>
			<div class="vr"></div>
			<div class="actionbtn" style="height:64px;display:flex;align-items:center;" onclick="refreshpairs()">
				<img src="/Matching-Game/assets/replay.png" style="padding:4px;margin-right:8px;margin-left:8px;" height="26px"/>
			</div>
			<div class="vr"></div>
			<div class="actionbtn" style="height:64px;display:flex;align-items:center;" onclick="showmenu()">
				<img src="/Matching-Game/assets/close.png" style="padding:4px;margin-right:8px;margin-left:8px;" height="26px"/>
			</div>
			<div class="vr"></div>
		</div>
		<div id="scoreoverlay" class="overlay" style="font-family:roboto-medium;color:#fff;z-index:100;display:flex;align-items:center;justify-content:center;">
			<div>
				
				<img class="transparentfab" src="/Matching-Game/assets/close.png" height="22px" onclick="$('#scoreoverlay').fadeOut('fast')"/>
				<br>
				<img src="/Matching-Game/assets/score.png" style="padding:4px;margin:0px;" height="80px"/>
				
				<br>
				<div id="score">
					
				</div>
			</div>	 
		</div>
		<div id="loading" class="overlay" style="">
			<div style="margin-right:auto;margin-left:auto;text-align:center;color:#555;">
				<img src="/Matching-Game/assets/loading.gif" height="100px" />
				<br>
				<font id="loadingtext">loading</font> . . .
			</div>
		</div>
		<div id="menu" style="color:#fff;z-index:50;display:flex;align-items:center;justify-content:center;" class="overlay">
			<div id="menuchild" style="text-align:center;">
				
				<img src="/Matching-Game/assets/admin.png" style="padding:4px;margin:0px;" height="26px"/>
				<br>
				<?php echo $_SESSION['username'];?>
				<br>
				<img class="transparentfab" id="play" src="/Matching-Game/assets/play.png" onclick="srbtnclick()" height="40px" style="margin-bottom:16px;margin-top:16px;border:1px solid rgba(255,255,255,0.2);padding:26px;"/>

				<div id="fabs" style="display:flex;align-items:center;margin:0;">
					<img class="transparentfab" src="/Matching-Game/assets/back.png" onclick="history.back()" height="22px"/>
					<div class="vr"></div>
					<div id="highscorebtn" class="actionbtn" >
						<img src="/Matching-Game/assets/highscore.png" style="padding:8px;margin:4px;" height="22px"/>
					</div>
					<div class="vr"></div>
					<div id="rankingbtn" class="actionbtn" >
						<img src="/Matching-Game/assets/ranking.png" style="padding:8px;margin:4px;" height="22px"/>
					</div>
					<br>	
				</div>
				<div id="actiontext" style="height:54px;padding:8px;display:block;transition:background-color 0.3s;">
					
				</div>
			</div>
		</div>
		<script>
			
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
			var col2actual;
			
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

			function srbtnclick(){
				hidemenu();
				refreshpairs();
				$('#srbtn').attr('value','replay');
			}
		</script>
		<script>
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
			});
		</script>
	</body>
</html>