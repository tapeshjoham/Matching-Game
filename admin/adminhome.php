<?php
	include "getpath.php";

	//creating session variables
	session_start();
	$_SESSION['username']=htmlspecialchars($_POST['username']);
	$_SESSION['password']=htmlspecialchars($_POST['password']);
	$_SESSION['usertype']=htmlspecialchars($_POST['usertype']);

	include $localhost.'Matching-Game/assets/outputs.php';
	include $localhost.'Matching-Game/assets/checkcredentials.php';
	
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
		
		<link type="text/css" rel="stylesheet" href="style.css"/>
		<script src="/Matching-Game/assets/jquery.min.js">
		</script>
	</head>
	<body>
		<div id="userinfo">
			<?php echo $_SESSION['username'];?>
			<img src="/Matching-Game/assets/admin.png" style="padding:4px;margin:8px;" height="26px"/>
		</div>
		<div id="loading" class="overlay" style="">
			<div id="loadingchild" style="">
				<img src="/Matching-Game/assets/loading.gif" height="100px" />
				<br>
				<font id="loadingtext">loading</font> . . .
			</div>
		</div>

		<div id="process" class="overlay">
			<div id="processchild" class="formdialog" style="">
			<br><br><font id="processheading" style="font-size:140%;">processing...</font>
			<br><br>
			<img src="/Matching-Game/assets/loading.gif" height="80px"/>
			<br><br>
			-: PROCESS LOG :-<br>
			<div id="processtext" style="">
				
			</div>
			<br>
			<br>
			<input type="button" value="Close" class="transparentbutton" onclick="processclose()"/>
			
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
		
		<div id="actionbar">
			<img id="menubtn" class="transparentfab" src="/Matching-Game/assets/menu.png" height="26px" onclick="$('#menu').show('fast')"/>
			<font id="heading" style="">Database</font>
		</div>

		<div class="overlay" id="editpair">
			<div class="formdialog">
				<p id="formdialogheading" style="">Edit pair</p>
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
					<input type="button" value="close" class="transparentbutton" onclick="editpairclose()"/>
					
				</form>
			</div>	
		</div>

		<div class="overlay" id="addpair">
			<div class="formdialog">
				<p id="formdialogheading">Add pair</p>
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

					

				</form>
			</div>
		</div>
		<div class="dialog" id="pairclicked">
			<div class="pairelementchild" id="pairclickedchild" style="">
				<div class="editpairitem" onclick="editpairclicked()">
					<img id="editpairbtn" src="/Matching-Game/assets/edit.png" class="pairfab" style="margin-right:8px;" />
					edit
				</div>
				<br>
				<div class="editpairitem" onclick="deletepairclicked()">
					<img id="deletepairbtn" src="/Matching-Game/assets/delete.png" class="pairfab" style="margin-right:8px;" />
					delete
				</div>
				<br>
				<input class="transparentbutton" type="button" value="close" onclick="$('#pairclicked').fadeOut('fast')"/>
			</div>
		</div>
		
		<div id="database" class="maincontent">
			
		</div>

		<div id="settings" class="maincontent">
			<div class="settingselement">
				to save settings , click save at the bottom of the list
			</div>
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
				click on the button to save settings -->
				<input type="button" value="Save" class="transparentbutton" onclick="savesettings()"/>
				
			</div>
		</div>
		
		<div id="fabs">
			<img id="addpairbtn" src="/Matching-Game/assets/add.png" class="fab" onclick="$('#addpair').fadeIn('fast')"/>
		</div>
		<script>
			//functions

			function processclose(){
				$('#process').fadeOut('fast');
				$('#process img').show();
				$('#processheading').text("processing...");
			}

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

			function editpairclose(){
				$('#editpair').fadeOut('fast');
				refreshpairs();
			}

			function addpairclose(){
				$('#addpair').fadeOut('fast');
				refreshpairs();
			}

			//function for getting extension
			function getext(name){
				name=name.split('.');
				if(name[name.length-1]=="mp3")
					return "mpeg";
				return name[name.length-1];
			}

			//function returning media element
			function getmediaelement(name,type){
				var ext=getext(name);
				if(type=="audio"){
				return "<audio controls><source src=\"/Matching-Game/assets/audio/"+name+"\" type=\""+type+"/"+ext+"\"/></audio>";
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

			//function for refreshing pairs on addition or deletion
			function refreshpairs(){
				$("#loading").fadeIn(300);
				$("#loadingtext").text("refreshing pairs");
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
							
							$("#database").append("<div class=\"pairelement\" onclick=\"pairclicked('"+pieces2[2]+"')\">"+
								"<div class=\"mediaelement\"><div class=\"media\">"+getmediaelement(pieces3a[0],pieces3a[1])+
								"</div><hr>"+
								"<font class=\"medianame\">"+pieces3a[0]+"</font><br>"+
								"<font class=\"mediatype\">"+pieces3a[1]+"</font>"+"</div>"+
								"<div style='display:inline-block;margin:0;padding:0;'><div class='cmpimgdiv' style='display:flex;align-items:center;'><img class=\"compareimg\" src=\"/Matching-Game/assets/compare.png\"/></div></div>"+
								"<div class=\"mediaelement\"><div class=\"media\">"+getmediaelement(pieces3b[0],pieces3b[1])+
								"</div><hr>"+
								"<font class=\"medianame\">"+pieces3b[0]+"</font><br>"+
								"<font class=\"mediatype\">"+pieces3b[1]+"</font>"+"</div>"+"</div><hr>");

							index++;
						}
	            	$("#loading").fadeOut(300);
	            	}
	            }       
		        xhttp.open("GET","getpairs.php",true);
		        xhttp.send();
		    }
		    refreshpairs();
			
			var pairid;

			function pairclicked(id){
				$("#pairclicked").fadeIn("fast");
				pairid=id;
			}

			//add pair form submission
			document.getElementById("addpairform").onsubmit=function(e){
				e.preventDefault();

				var form=e.target,formdata=new FormData(form);
					var xhr=new XMLHttpRequest();
					
					xhr.onload=function(){
						if(xhr.status===200){
						var response=xhr.responseText;
						response=response.split("::;;");
						$('#process img').fadeOut('slow');
						$('#processheading').text(response[1]);
						document.getElementById("processtext").innerHTML+=response[0];
						}
						else
						alert('error');
					}
					xhr.open('POST',form.action,'true');
					xhr.send(formdata);
					$('#process').fadeIn('fast');
					document.getElementById("processtext").innerHTML="";
				
			}

			//delete button onclick listener
			function deletepairclicked(){
				var xhr=new XMLHttpRequest();
					
					xhr.onload=function(){
						if(xhr.status===200){
							var response=xhr.responseText;
							response=response.split("::;;");
							$('#process img').fadeOut('slow');
							$('#processheading').text(response[1]);
							document.getElementById("processtext").innerHTML+=response[0];
							refreshpairs();
						}
						else
						alert('error');
					}
					xhr.open('POST',"delete.php",'true');
					xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					xhr.send("submit=Delete&pairid="+pairid);
					$("#pairclicked").hide();
					$('#process').fadeIn("fast");
					document.getElementById("processtext").innerHTML="";
			}

			//edit button onclick listener
			function editpairclicked(){
				$("#pairclicked").fadeOut('fast');
				$('#editpair').fadeIn('fast');
			}

			//edit pair form submission
			document.getElementById("editpairform").onsubmit=function(e){
				e.preventDefault();
				$("input[name=pairid]").val(pairid);
				var form=e.target,formdata=new FormData(form);
					var xhr=new XMLHttpRequest();
					
					xhr.onload=function(){
						if(xhr.status===200){
						var response=xhr.responseText;
						response=response.split("::;;");
						$('#process img').fadeOut('slow');
						$('#processheading').text(response[1]);
						document.getElementById("processtext").innerHTML+=response[0];
						}
						else
						alert('error');
					}
					xhr.open('POST',form.action,'true');
					xhr.send(formdata);
					$('#process').fadeIn("fast");
					document.getElementById("processtext").innerHTML="";
				
			}

			//toggling inputs in add/edit pair forms
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

			//function for refreshing settings on changes
			function refreshsettings(){
				$("#loading").fadeIn("fast");
				$("#loadingtext").text("refreshing settings");
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
						$("#loading").fadeOut("fast");
					}
					else
					alert('error');
				}
				xhr.open('POST',"getsettings.php",'true');
				xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xhr.send();
			}

			//saving settings
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
		<script>
			//initialisation on page loading

			$("#actionbar").css("width",$(window).width()+"px");
			$("#actionbar").css("height","64px");

			$("#userinfo").css("height","64px");

			$(".maincontent").css('padding-top',$(window).height()*0.05+"px")
			$(".maincontent").css('padding-left',$(window).width()*0.05+"px")
			$(".maincontent").css('padding-right',$(window).width()*0.05+"px")
			$(".maincontent").css("width",$(window).width()*0.9+"px");
			$(".maincontent").css("height",($(window).height()*0.95-64)+"px");

			$("#menu").css("width","264px");
			
			$("#menu").css("height",$(window).height()*1+"px");
			$(".dialog").css("height",$(window).height()+"px");
			$(".overlay").css("height",$(window).height()+"px");

			$(".fab").css('margin',$(window).height()*0.05);

			$("#pairclicked").hide("fast");
			$("#addpair").hide("fast");
			$("#editpair").hide("fast");

			$("#menu").hide('fast');
			$("#process").hide('fast');

			$("#settings").hide();

			$(".settingselement").css("width",$(window).width()*0.78+"px");
			$(".settingselement").css("padding",$(window).width()*0.01+"px");

			$(".pairelement").css('min-width',($(".mediaelement").width()*2+$(".cmpimgdiv").width())+"px");
			$(".pairelement").css("width",$(window).width()*0.9+"px");

		</script>
		<script>

			//window resize listener
			$(window).resize(function(){
				$("#actionbar").css("width",$(window).width()+"px");
				$("#actionbar").css("height","64px");

				$("#userinfo").css("height","64px");

				$(".maincontent").css('padding-top',$(window).height()*0.05+"px")
				$(".maincontent").css('padding-left',$(window).width()*0.05+"px")
				$(".maincontent").css('padding-right',$(window).width()*0.05+"px")
				$(".maincontent").css("width",$(window).width()*0.9+"px");
				$(".maincontent").css("height",($(window).height()*0.95-64)+"px");
				$("#menu").css("height",$(window).height()*1+"px");
				$(".dialog").css("height",$(window).height()+"px");
				$(".overlay").css("height",$(window).height()+"px");

				$(".pairelement").css("width",$(window).width()*0.9+"px");

				$(".fab").css('margin',$(window).height()*0.05);
	
				$(".settingselement").css("width",$(window).width()*0.78+"px");
				$(".settingselement").css("padding",$(window).width()*0.01+"px");

				$(".pairelement").css('min-width',($(".mediaelement").width()*2+$(".cmpimgdiv").width())+"px");

			});
			
			//when the whole page loads
			$(window).load(function(){
				$("#loading").fadeOut('slow');
			});
		</script>
	</body>
</html>