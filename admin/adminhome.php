<?php
	include "getpath.php";

	session_start();
	$_SESSION['username']=htmlspecialchars($_POST['username']);
	$_SESSION['password']=htmlspecialchars($_POST['password']);
	$_SESSION['usertype']=htmlspecialchars($_POST['usertype']);

	include $localhost.'Matching-Game/assets/outputs.php';
	include $localhost.'Matching-Game/assets/checkcredentials.php';
	if($output==104||$output==103)
		die(getoutput($output));
		
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			admin | home
		</title>
		<style>
			@font-face {
			    font-family: roboto-thin;
			    src: url('/project/assets/Roboto/Roboto-Thin.ttf');
			}
			@font-face {
			    font-family: roboto-light;
			    src: url('/project/assets/Roboto/Roboto-Light.ttf');
			}
			@font-face {
			    font-family: roboto-medium;
			    src: url('/project/assets/Roboto/Roboto-Medium.ttf');
			}
			label {
			display: inline-block;
			cursor: pointer;
			position: relative;
			font-size: 100%;
			padding-left: 25px;
			margin-right: 15px;
			font-family:roboto-medium;
			transition: color 0.2s;
			color:#555;
			}

			input[type=radio] {
			display: none;
			}

			label:before {
			content: "";
			display: inline-block;
			width: 16px;
			height: 16px;
			margin-right: 10px;
			position: absolute;
			left: 0;
			bottom: 1px;
			border-radius:3px;
			border:2px solid #2196F3;
			transition: background-color 0.4s;
			}	

			input[type=radio]:checked + label:before{
			background-color: #2196F3;
			font-size: 30px;
			text-align: center;
			line-height: 18px;
			color:#111;
			}

			input[type=radio]:checked + label{
			color:#2196F3;
			}

			input[type=checkbox]{
				display: none;
			}

			input[type=checkbox]+label{
				border-radius: 3px;
				background-color: #ccc;
				color:#999;
				margin: 0;
				padding: 0;
				transition:background-color 0.3s,color 0.3s;
				padding:6px;
				}

			input[type=checkbox]+label:before{
				display: none;
				width:0;
				height:0;
				margin: 0;
				padding: 0;
			}
			input[type=checkbox]:checked + label:before{
				display: none;
				width:0;
				height:0;
				margin: 0;
				padding: 0;
			}

			input[type=checkbox]:checked + label{
				background-color:#2196F3;
				color:#fff;
			}

			body{
				color:#fff;
				font-family: roboto-medium;
				background-color: #fafafa;
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
			}
			#menu{
				margin:0;
				padding:0;
				position: fixed;
				top:0px;
				left: 0px;
				background:#fafafa;
				z-index: 100;
				box-shadow: 2px 0px 5px rgba(0,0,0,0.3);
			}
			.maincontent{
				bottom: 0px;
				right:0px;
				margin:0;
				padding:0;
				position: fixed;
				background:#fafafa;
				overflow-y:auto; 
				color: #555;
			}
			#fabs{
				position:absolute;
				bottom:0;
				right: 0;
				margin:0;
				padding:0;
				display: flex;
				align-items:center;
			}
			.pairfab{
				background:#2196F3;
				
				padding:12px;
				
				border-radius:50%;
				width:26px;
			}
			.fab{
				background:#2196F3;
				box-shadow:0px 2px 5px rgba(0,0,0,0.5);
				padding:12px;
				
				border-radius:50%;
				width:26px;
				transition:box-shadow 0.3s,background-color 0.3s;
				cursor:pointer;
			}
			.fab:hover{
				box-shadow:0px 4px 5px rgba(0,0,0,0.5);
			}
			.fab:active{
				box-shadow:0px 2px 5px rgba(0,0,0,0.5);
				background-color: #1565C0;
			}
			.pairelement{
				height:300px;
				display:flex;
				align-items:center;
				margin:0;
				padding:0;
				transition:background-color 0.3s;
				cursor: pointer;
				border-radius: 3px;
				box-shadow: 0px 2px 4px rgba(0,0,0,0.3);
				margin-bottom: 8px;
			}
			.pairelement:hover{
				background-color: #eee;
			}
			.pairelement:active{
				background-color: #bbb;
			}
			.pairelementchild{
				display:inline-block;
				margin-left:auto;
				margin-right:auto;
				text-align: center;
				
			}
			.overlay{
				position:fixed;
				top:0;
				left:0;
				width:100%;
				
				background-color: rgba(0,0,0,0.8);
			}
			.dialog{
				position:fixed;
				top:0;
				left:0;
				width:100%;
				
				background-color: rgba(0,0,0,0.5);
				display: flex;
				align-items:center;
			}
			#pairclicked{
				z-index:20;
			}
			#addpair,#editpair{
				z-index:10;
				text-align: center;
				
				color:#000;
				display: flex;
				align-items:center;
			}
			#editpair{
				z-index: 30;
			}
			.transparentfab{
				padding:8px;
				margin:4px;
				border-radius:50%;
				transition:background-color 0.3s;
			}
			.transparentfab:hover{
				background-color: rgba(0,0,0,0.3);
			}
			.transparentfab:active{
				background-color: rgba(0,0,0,0.6);
			}
			.mediaelement{
				display: inline-block;
				width:300px;
				text-align: center;
				font-size: 160%;
				color: #2196F3;
			}
			.medianame{
				font-size: 60%;
				color: #555;
			}
			.mediatype{
				font-family: roboto-light;
				font-size: 60%;
				color:#777;
			}
			.compareimg{
				border-radius: 50%;
				height:40px;
				padding:8px;
				background-color: rgba(0,0,0,0.5);
				vertical-align: middle;
			}
			.menuitem{
				height:64px;display:flex;align-items:center;color: #555;cursor: pointer;transition:background-color 0.3s;
			}
			.menuitem:hover{
				background-color: rgba(0,0,0,0.1);
			}
			.menuitem:active{
				background-color: rgba(0,0,0,0.2);
			}
			.menuheading{
				height:64px;display:flex;align-items:center;
			}
			.menuitem img{
				padding:4px;
				margin:8px;
				border-radius:50%;
				background-color: #555;
			}
			.transparentbutton{
				outline:none;
				border:none;
				background:none;
				padding:8px;
				margin:4px;
				font-family: roboto-medium;
				cursor: pointer;
				transition:background-color 0.3s;
				border-radius: 3px;
				color:#555;
				background-color: rgba(0,0,0,0.1);
			}
			.transparentbutton:hover{
				background-color: rgba(0,0,0,0.2);
			}
			.transparentbutton:active{
				background-color: rgba(0,0,0,0.4);
			}
			.paircolumn{
				float:left;margin:8px;text-align:left;
				border-radius: 1px;
				border:1px solid rgba(0,0,0,0.1);
				padding:4px;
			}
			input[type=submit]{
				color:#2196F3;;
			}
			#process{
				z-index: 60;
				text-align: center;
				color:#555;
				font-size: 70%;
				display: flex;
				align-items:center;
			}
			.editpairitem{
				padding:16px;display:flex;align-items:center;color: #555;cursor: pointer;transition:background-color 0.3s;
			}
			.editpairitem:hover{
				background-color: rgba(0,0,0,0.1);
			}
			.editpairitem:active{
				background-color: rgba(0,0,0,0.2);
			}
			.menuitemactive{
				background-color: rgba(0,0,0,0.1);
			}
			.settingselement{
				display:flex;
				align-items:center;
				padding:0;
				transition:background-color 0.3s;
				
				border-radius: 3px;
				box-shadow: 0px 0px 2px rgba(0,0,0,0.3);
				margin-right: auto;
				margin-left: auto;
				margin-bottom: 16px;
				background-color: #fafafa;
			}
			.settingsvalue{
				font-family: roboto-medium;
				text-decoration:none;
				outline:none;
				border:none;
				font-size:120%;
			    display:inline-block;
			    border-bottom:2px solid #2196F3;
			    background: none;
			    color:#2196F3;
			    padding-top:8px;
			}
			.settingsheading{
				color: #555;
				font-size: 120%;
			}
			.settingsdescription{
				font-family: roboto-medium;
				font-size: 80%;
				color:#888;
			}
		</style>
		<script src="/Matching-Game/assets/jquery.min.js">
		</script>
	</head>
	<body>
		<div id="process" class="overlay">
			<div id="processchild" style="display:inline-block;margin-left:auto;margin-right:auto;background-color: #eee;border-radius:3px;box-shadow:0px 2px 4px rgba(0,0,0,0.3);padding:8px;">
			<br><br><font id="processheading" style="font-size:160%;">PROCESSING...</font><br><br>
			<img src="/Matching-Game/assets/loading.gif" height="100px"/><br><br>
				
			<div id="processtext" style="display:inline-block;text-align:left;overflow-y:auto;height:100px;">
				-: PROCESS LOG :-<br>
			</div>
			<br>
			<br>
			<input type="button" value="Close" class="transparentbutton" onclick="processclose()"/>
			<script>
				function processclose(){
					$('#process').hide('fast');
					$('#process img').show('fast');
					$('#processheading').text("PROCESSING...");
					refreshpairs();
				}
			</script>
			</div>
		</div>
		<div id="menu">
			<div class="menuheading" style="background-color:#2196f3;">
				<img class="transparentfab" src="/Matching-Game/assets/back.png" height="26px" onclick="$('#menu').hide('fast')"/>
				Menu
			</div>
			<div id="databasemenuitem" class="menuitem menuitemactive" onclick="menuitemclick('database')" style="">
				<img src="/Matching-Game/assets/database.png"  height="26px"/>
				Database
			</div>
			<div id="settingsmenuitem" class="menuitem" onclick="menuitemclick('settings')" style="">
				<img src="/Matching-Game/assets/settings.png" height="26px"/>
				Settings
			</div>
			<div id="logoutmenuitem" class="menuitem" onclick="history.back()">
				<img src="/Matching-Game/assets/logout.png" height="26px"/>
				Logout
			</div>
		</div>
		<script>
			function menuitemclick(name){
				if(name=="database"){
					$("#database").show();
					$("#settings").hide();
					$("#databasemenuitem").addClass("menuitemactive");
					$("#settingsmenuitem").removeClass("menuitemactive");
					$("#heading").text("Database");
					$("#addpairbtn").show();
				}
				if(name=="settings"){
					$("#database").hide();
					$("#settings").show();
					$("#databasemenuitem").removeClass("menuitemactive");
					$("#settingsmenuitem").addClass("menuitemactive");	
					$("#heading").text("Settings");
					$("#addpairbtn").hide();	
					refreshsettings();
				}
				$("#menu").hide('fast');
			}
		</script>
		<div id="actionbar">
			<img id="menubtn" class="transparentfab" src="/Matching-Game/assets/menu.png" height="26px" onclick="$('#menu').show('fast')"/>
			<font id="heading" style="font-family:roboto-medium;font-size:120%;">Database</font>
		</div>

		<div class="overlay" id="editpair">
			<div style="margin-right:auto;margin-left:auto;background-color:#fafafa;border-radius:3px;box-shadow:0px 2px 4px rgba(0,0,0,0.3);text-align:right;">
				<p style="text-align:left;padding:8px;margin:0;color:#555;">Edit pair</p>
				<form id="editpairform" action="editprocess.php" method="post" enctype="multipart/form-data">
					<input type="text" name="pairid" style="display:none"/>
					<div class="paircolumn">
						Column 1
						<hr>
						<input type="radio" name="c1filetype" value="same" id="ec1rs" checked/><label for="ec1rs">remain same</label><br><br>
						<input type="radio" name="c1filetype" value="text" id="ec1rt" /><label for="ec1rt">text</label><br><br>
						<input type="radio" name="c1filetype" value="audio" id="ec1ra"/><label for="ec1ra">audio</label><br><br>
						<input type="radio" name="c1filetype" value="video" id="ec1rv"/><label for="ec1rv">video</label><br><br>
						<input type="radio" name="c1filetype" value="image" id="ec1ri"/><label for="ec1ri">image</label>
						<hr>
						<input type="file" name="c1file" id="c1file" style="width:200px;"/>
						<br>
						<input type="text" name="c1name" id="c1text" style="width:200px;" placeholder="text here"/>
					</div>
					<div class="paircolumn">
						Column 2
						<hr>
						<input type="radio" name="c2filetype" value="same" id="ec2rs" checked/><label for="ec2rs">remain same</label><br><br>
						<input type="radio" name="c2filetype" value="text" id="ec2rt" /><label for="ec2rt">text</label><br><br>
						<input type="radio" name="c2filetype" value="audio" id="ec2ra"/><label for="ec2ra">audio</label><br><br>
						<input type="radio" name="c2filetype" value="video" id="ec2rv"/><label for="ec2rv">video</label><br><br>
						<input type="radio" name="c2filetype" value="image" id="ec2ri"/><label for="ec2ri">image</label>
						<hr>
						<input type="file" name="c2file" id="c2file" style="width:200px;"/>
						<br>
						<input type="text" name="c2name" id="c2text" style="width:200px;" placeholder="text here"/>
					</div>
					<br>
					<br>
					<br>
					<input type="submit" name="submit" class="transparentbutton" value="Update">
					<input type="button" value="close" class="transparentbutton" onclick="$('#editpair').hide('fast')"/>
				</form>
			</div>	
		</div>

		<div class="overlay" id="addpair">
			<div style="margin-right:auto;margin-left:auto;background-color:#fafafa;border-radius:3px;box-shadow:0px 2px 4px rgba(0,0,0,0.3);text-align:right;">
				<p style="text-align:left;padding:8px;margin:0;color:#555;">Add pair</p>
				<form name="addpairform" id="addpairform" method="post" action="addpair.php" enctype="multipart/form-data">
					<div class="paircolumn">
						Column 1
						<hr>
						<input type="radio" name="c1filetype" value="text" id="ac1rt" checked/><label for="ac1rt">text</label><br><br>
						<input type="radio" name="c1filetype" value="audio" id="ac1ra"/><label for="ac1ra">audio</label><br><br>
						<input type="radio" name="c1filetype" value="video" id="ac1rv"/><label for="ac1rv">video</label><br><br>
						<input type="radio" name="c1filetype" value="image" id="ac1ri"/><label for="ac1ri">image</label>
						<hr>
						<input type="file" name="c1file" id="c1file" style="width:200px;"/>
						<br>
						<input type="text" name="c1name" id="c1text" style="width:200px;" placeholder="text here"/>
					</div>
					<div class="paircolumn">
						Column 2
						<hr>
						<input type="radio" name="c2filetype" value="text" id="ac2rt" checked/><label for="ac2rt">text</label><br><br>
						<input type="radio" name="c2filetype" value="audio" id="ac2ra"/><label for="ac2ra">audio</label><br><br>
						<input type="radio" name="c2filetype" value="video" id="ac2rv"/><label for="ac2rv">video</label><br><br>
						<input type="radio" name="c2filetype" value="image" id="ac2ri"/><label for="ac2ri">image</label>
						<hr>
						<input type="file" name="c2file" id="c2file" style="width:200px;"/>
						<br>
						<input type="text" name="c2name" id="c2text" style="width:200px;" placeholder="text here"/>
					</div>
					<br>
					<br>
					<br>
					<input type="submit" id="submitbtn" class="transparentbutton" value="Submit" />
					<input type="button" value="Close" class="transparentbutton" onclick="addpairclose()"/>
					<script>function addpairclose(){$('#addpair').hide('fast');refreshpairs();}</script>
				</form>
			</div>
		</div>
		<div class="dialog" id="pairclicked">
			<div class="pairelementchild" style="color:#555;margin-right:auto;margin-left:auto;background-color:#fafafa;border-radius:3px;box-shadow:0px 2px 4px rgba(0,0,0,0.3);">
				<div class="editpairitem" onclick="editpairclicked()">
					<img id="editpairbtn" src="/Matching-Game/assets/edit.png" class="pairfab" style="margin-right:8px;" />
					EDIT
				</div>
				<br>
				<div class="editpairitem" onclick="deletepairclicked()">
					<img id="deletepairbtn" src="/Matching-Game/assets/delete.png" class="pairfab" style="margin-right:8px;" />
					DELETE
				</div>
				<br>
				<input class="transparentbutton" type="button" value="close" onclick="$('#pairclicked').hide('fast')"/>
			</div>
		</div>
		
		<div id="database" class="maincontent">
			<script>

				function getext(name){
					name=name.split('.');
					if(name[name.length-1]=="mp3")
						return "mpeg";
					return name[name.length-1];
				}

				function getmediaelement(name,type){
					var ext=getext(name);
					if(type=="audio"){
        			return "<audio width=\"100px\" controls><source src=\"/Matching-Game/assets/audio/"+name+"\" type=\""+type+"/"+ext+"\"/></audio>";
	        		}
	        		if(type=="video"){
	        			return "<video width=\"200\" height=\"200\" controls><source src=\"/Matching-Game/assets/video/"+name+"\" type=\""+type+"/"+ext+"\"/></video>";
	        		}
	        		if(type=="image"){
	        			return "<img width=\"200\" height=\"200\" src=\"/Matching-Game/assets/image/"+name+"\"/>";
	        		}
	        		if(type=="text"){
	        			return name;
	        		}
				}
				function refreshpairs(){
					$("#database").text("");
					$("#database").append("Click on the pair to edit or delete :<br><br>");
					var xhttp = new XMLHttpRequest();
	                xhttp.onreadystatechange = function() {
	                	if (xhttp.readyState == 4 && xhttp.status == 200) {
	                        var response = xhttp.responseText;
	                        var index=0;
	                        var pieces1 = response.split(";;;");
							while(index<(pieces1.length-1)){
								var pieces2=pieces1[index].split("::");
								var pieces3a=pieces2[0].split(";;");
								var pieces3b=pieces2[1].split(";;");
								
								$("#database").append("<div class=\"pairelement\" onclick=\"pairclicked('"+pieces2[2]+"')\"><div class=\"pairelementchild\">"+
									"<div class=\"mediaelement\">"+getmediaelement(pieces3a[0],pieces3a[1])+
									"<br><font class=\"medianame\">"+pieces3a[0]+"</font><br>"+
									"<font class=\"mediatype\">"+pieces3a[1]+"</font>"+"</div>"+
									"<img class=\"compareimg\" src=\"/Matching-Game/assets/compare.png\"/>"+
									"<div class=\"mediaelement\">"+getmediaelement(pieces3b[0],pieces3b[1])+
									"<br><font class=\"medianame\">"+pieces3b[0]+"</font><br>"+
									"<font class=\"mediatype\">"+pieces3b[1]+"</font>"+"</div>");

								index++;
							}
	                	}
	                }       
			        xhttp.open("GET","getpairs.php",true);
			        xhttp.send();
			    }
			    refreshpairs();
				var pairid;
				function pairclicked(id){
					$("#pairclicked").show("fast");
					pairid=id;
				}

				document.getElementById("addpairform").onsubmit=function(e){
					e.preventDefault();

					var form=e.target,formdata=new FormData(form);
						var xhr=new XMLHttpRequest();
						
						xhr.onload=function(){
							if(xhr.status===200){
							var response=xhr.responseText;
							$('#process img').hide('slow');
							$('#processheading').text("PAIR ADDED");
							document.getElementById("processtext").innerHTML="";
							document.getElementById("processtext").innerHTML+=response;
							}
							else
							alert('error');
						}
						xhr.open('POST',form.action,'true');
						xhr.send(formdata);
						$('#process').show();
					
				}

				function deletepairclicked(){
					var xhr=new XMLHttpRequest();
						
						xhr.onload=function(){
							if(xhr.status===200){
								var response=xhr.responseText;
								$('#process img').hide('slow');
								$('#processheading').text("PAIR DELETED");
								document.getElementById("processtext").innerHTML="";
								document.getElementById("processtext").innerHTML+=response;
							}
							else
							alert('error');
						}
						xhr.open('POST',"delete.php",'true');
						xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						xhr.send("submit=Delete&pairid="+pairid);
						$("#pairclicked").hide();
						$('#process').show();
				}

				function editpairclicked(){
					$('#editpair').show('fast');
					$("#pairclicked").hide();
				}

				document.getElementById("editpairform").onsubmit=function(e){
					e.preventDefault();
					$("input[name=pairid]").val(pairid);
					var form=e.target,formdata=new FormData(form);
						var xhr=new XMLHttpRequest();
						
						xhr.onload=function(){
							if(xhr.status===200){
							var response=xhr.responseText;
							$('#process img').hide('slow');
							$('#processheading').text("PAIR edited");
							document.getElementById("processtext").innerHTML="";
							document.getElementById("processtext").innerHTML+=response;
							}
							else
							alert('error');
						}
						xhr.open('POST',form.action,'true');
						xhr.send(formdata);
						$('#process').show();
					
				}

				$('input[name=c1filetype]').click(function(e){
					if(e.target.value=="text"){
						$('input[name=c1name]').show();
						$('input[name=c1file]').hide();
					}else{
						$('input[name=c1name]').hide();
						$('input[name=c1file]').show();
					}
				});$('input[name=c1file]').hide();

				$('input[name=c2filetype]').click(function(e){
					if(e.target.value=="text"){
						$('input[name=c2name]').show();
						$('input[name=c2file]').hide();
					}else{
						$('input[name=c2name]').hide();
						$('input[name=c2file]').show();
					}
				});$('input[name=c2file]').hide();

				function refreshsettings(){
					var xhr=new XMLHttpRequest();
					xhr.onload=function(){
						if(xhr.status===200){
							var response=xhr.responseText;
							response=response.split("::");
							if(response[0]=="0"){
								$("#activechkbox").prop("checked",false);
							}else{
								$("#activechkbox").prop("checked",true);
							}
							$("#sqlun").val(response[1]);
							$("#sqlp").val(response[2]);
							$("#sqld").val(response[3]);
							$("#pno").val(response[4]);
						}
						else
						alert('error');
					}
					xhr.open('POST',"getsettings.php",'true');
					xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					xhr.send();
				}
			</script>
		</div>

		<div id="settings" class="maincontent">
			<div class="settingselement">
				<div>
					<font class="settingsheading">ACTIVE/INACTIVE</font>
					<br>
					<font class="settingsdescription">Click to include/uninclude your pairs in game</font>
					<br><br>
					<input type="checkbox" id="activechkbox"/><label for="activechkbox">ACTIVE</label>
				</div>
			</div>
			<div class="settingselement">
				<div>
					<font class="settingsheading">SQL USERNAME</font>
					<br>
					<font class="settingsdescription">Click to update mysql username</font>
					<br>
					<input type="text" class="settingsvalue" id="sqlun"/>
				</div>
			</div>
			<div class="settingselement">
				<div>
					<font class="settingsheading">SQL PASSWORD</font>
					<br>
					<font class="settingsdescription">Click to update mysql password</font>
					<br>
					<input type="text" class="settingsvalue" id="sqlp"/>
				</div>
			</div>
			<div class="settingselement">
				<div>
					<font class="settingsheading">SQL DATABASE</font>
					<br>
					<font class="settingsdescription">Click to update mysql database name</font>
					<br>
					<input type="text" class="settingsvalue" id="sqld"/>
				</div>
			</div>
			<div class="settingselement">
				<div>
					<font class="settingsheading">SHOWN NUMBER OF PAIRS</font>
					<br>
					<font class="settingsdescription">Click to change number of pairs shown to player in a game</font>
					<br>
					<input type="text" class="settingsvalue" id="pno"/>
				</div>
			</div>
			<div class="settingselement" style="box-shadow:none;text-align:right;display:block;">
				<input type="button" value="Save" class="transparentbutton" onclick="savesettings()"/>
				<script>
					function savesettings(){
						var active=0;
						if($("#activechkbox").prop('checked'))
							active=1;

						var xhr=new XMLHttpRequest();
						
						xhr.onload=function(){
							if(xhr.status===200){
								var response=xhr.responseText;
								$('#process img').hide('slow');
								$('#processheading').text("SAVED!");
								document.getElementById("processtext").innerHTML="";
								document.getElementById("processtext").innerHTML+=response;
								refreshsettings();
							}
							else
							alert('error');
						}
						xhr.open('POST',"savesettings.php",'true');
						xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						xhr.send("active="+active+"&sqlun="+$("#sqlun").val()+"&sqlp="+$("#sqlp").val()+"&sqld="+$("#sqld").val()+"&pno="+$("#pno").val());
						$("#process").show();
					}
				</script>
			</div>
		</div>
		
		<div id="fabs">
			<!--<div style="display:inline-block;border-radius:3px;background-color:#555;font-size:80%;padding:4px;box-shadow:0px 2px 2px rgba(0,0,0,0.3);">Add Pair</div>-->
			<img id="addpairbtn" src="/Matching-Game/assets/add.png" class="fab" onclick="$('#addpair').show('fast')"/>
		</div>
		<script>
			$("#actionbar").css("width",$(window).width()+"px");
			$("#actionbar").css("height","64px");

			$(".maincontent").css('padding-top',$(window).height()*0.05+"px")
			$(".maincontent").css('padding-left',$(window).width()*0.05+"px")
			$(".maincontent").css('padding-right',$(window).width()*0.05+"px")
			$(".maincontent").css("width",$(window).width()*0.9+"px");
			$(".maincontent").css("height",($(window).height()*0.95-64)+"px");

			$("#menu").css("width","264px");
			
			$("#menu").css("height",$(window).height()*1+"px");
			$(".dialog").css("height",$(window).height()+"px");
			$(".overlay").css("height",$(window).height()+"px");

			$(".pairelement").css("width",$(window).width()*0.8+"px");

			$(".fab").css('margin',$(window).height()*0.05);

			$("#pairclicked").hide("fast");
			$("#addpair").hide("fast");
			$("#editpair").hide("fast");

			$("#menu").hide('fast');
			$("#process").hide('fast');

			$("#processchild").css('height',$(window).height()*0.5);
			$("#processchild").css('width',$(window).width()*0.5);

			$("#processtext").css('height',$(window).height()*0.3);

			$("#settings").hide();

			$(".settingselement").css("width",$(window).width()*0.78+"px");
			$(".settingselement").css("padding",$(window).width()*0.01+"px");
		</script>
		<script>
			$(window).resize(function(){
				$("#actionbar").css("width",$(window).width()+"px");
				$("#actionbar").css("height","64px");

				$(".maincontent").css('padding-top',$(window).height()*0.05+"px")
				$(".maincontent").css('padding-left',$(window).width()*0.05+"px")
				$(".maincontent").css('padding-right',$(window).width()*0.05+"px")
				$(".maincontent").css("width",$(window).width()*0.9+"px");
				$(".maincontent").css("height",($(window).height()*0.95-64)+"px");
				$("#menu").css("height",$(window).height()*1+"px");
				$(".dialog").css("height",$(window).height()+"px");
				$(".overlay").css("height",$(window).height()+"px");

				$(".pairelement").css("width",$(window).width()*0.8+"px");

				$(".fab").css('margin',$(window).height()*0.05);

				$("#processchild").css('height',$(window).height()*0.5);
				$("#processchild").css('width',$(window).width()*0.5);

				$("#processtext").css('height',$(window).height()*0.3);

				

				$(".settingselement").css("width",$(window).width()*0.78+"px");
				$(".settingselement").css("padding",$(window).width()*0.01+"px");
			});
		</script>
	</body>
</html>