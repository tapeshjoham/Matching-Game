<!DOCTYPE html>
<html>
	<head>
		<title>
			Matching-Game | login
		</title>
		<style>
		</style>
		<link rel="stylesheet" type="text/css" href="/Matching-Game/assets/style.css"/>		
		<script src="/Matching-Game/assets/jquery.min.js">
		</script>
		<script src="/Matching-Game/assets/inputerror.js">
		</script>
	</head>
	<body>
		<div id="maindiv" style="margin:0;padding:0;text-align:center;width:100%;">
			<img src="assets/logo.png" style="background:#3f51b5;box-shadow:0px 2px 5px rgba(0,0,0,0.5);padding:4px;border-radius:50%;"/>
			<h1 style="color:#3f51b5;">Matching Game</h1>
		
			<div id="maindivchild" style="width:100%;display:inline-block;margin-left:auto;margin-right:auto;">
	
				<h4>login</h4>
				
				<form method="post" id="loginform">
					<input type="radio" name="usertype" value="player" id="playerradiobtn" checked>
					<label for="playerradiobtn">PLAYER</label> 
					
					<input type="radio" name="usertype" value="admin" id="adminradiobtn"> 
					<label for="adminradiobtn">ADMIN</label>
					
					<br>
					<br>

					<div class="inputdiv">
						<input type="text" name="username" id="username" maxlength="20" placeholder="username"/>
						<br>
						<span id="usernameerror" class="inputerror"></span>
					</div>
					<br>
					<div class="inputdiv">
						<input type="password" name="password" id="password" maxlength="20" placeholder="password"/>
						<br>
						<span id="passworderror" class="inputerror"></span>
					</div>
					<br>
					<br>
					<input type="button" name="signinbtn" id="signinbtn" value="sign in" onclick="signinclicked()"/>
					<input type="button" name="signupbtn" id="signupbtn" value="sign up" onclick="signupclicked()"/>
				</form>
			</div>
		</div>		
		<script>

			$("#maindiv").css('padding-top',$("#heading").height());
			//setting height of divs for proper positioning
			$("#maindiv").css('min-height',($(window).height()-$("#heading").height())+"px");
			$(".inputdiv").css('width',$("input[type=text]").width()+"px");

			//adding event listeners to radiobuttons or disabling enabling signup btn
			$("#playerradiobtn").click(function(){
				$("#signupbtn").prop("disabled",false);
			});
			$("#adminradiobtn").click(function(){
				$("#signupbtn").prop("disabled",true);
			});
			$("input[type=button]").css('width',$("#maindivchild").width()*0.103);
		</script>
		<script>
			//setting input error checks and onclick listeners
			var username=$("#username");
			var password=$("#password");
			var usernameerror=$("#usernameerror");
			var passworderror=$("#passworderror");

			username.on('input',function(){
				onInputListener(20,username,usernameerror);
			});
			password.on('input',function(){
				onInputListener(20,password,passworderror);
			});

			function signinclicked(){
				var usertype=$("input:radio[name=usertype]:checked");
				var unchk = checkInputOnSubmit(5,username,usernameerror);
				var pchk = checkInputOnSubmit(5,password,passworderror);
				var allok = (unchk&&pchk)?1:0;
				if(allok==1){
					var xhttp = new XMLHttpRequest();
	                xhttp.onreadystatechange = function() {
	                	if (xhttp.readyState == 4 && xhttp.status == 200) {
	                        var response = xhttp.responseText;
	                        if(response==104){
	                        	makeChanges(1,"invalid credentials",username,usernameerror);
	                        	makeChanges(1,"invalid credentials",password,passworderror);
	                        }
	                        if(response==103)
	                        	alert("query returning zero , contact admin");
	                        if(response==102){

	                        	$("#loginform").attr("action",usertype.val()+"/"+usertype.val()+"home.php");
	                        	$("#loginform").submit();
	                        }
	                        if(response==105)
	                        	alert("error in table transactions , contact admin");
	                	}
	                }       
			        xhttp.open("POST","checkcredentials.php",true);
			        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");		        
			        xhttp.send("username="+username.val()+"&password="+password.val()+"&usertype="+usertype.val());
				}
			}

			function signupclicked(){
				var usertype=$("input:radio[name=usertype]:checked");
				var unchk = checkInputOnSubmit(5,username,usernameerror);
				var pchk = checkInputOnSubmit(5,password,passworderror);
				var allok = (unchk&&pchk)?1:0;
				if(allok==1){
					var xhttp = new XMLHttpRequest();
	                xhttp.onreadystatechange = function() {
	                	if (xhttp.readyState == 4 && xhttp.status == 200) {
	                        var response = xhttp.responseText;
	                        if(response==101)
	                        	makeChanges(1,"username already taken , try another one",username,usernameerror);
	                        if(response==103)
	                        	alert("query returning zero , contact admin");
	                        if(response==102){
	                        	$("#loginform").attr("action",usertype.val()+"/"+usertype.val()+"home.php");
	                        	$("#loginform").submit();
	                        }
	                        if(response==105)
	                        	alert("error in table transactions , contact admin");
	                	}
	                }       
			        xhttp.open("POST","createplayeraccount.php",true);
			        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");		        
			        xhttp.send("username="+username.val()+"&password="+password.val());
				}
			}
		</script>
	</body>
</html>
