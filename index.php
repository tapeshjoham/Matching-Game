
<!DOCTYPE html>
<html>
	<head>
		
		<title>
			Matching-Game | login
		</title>
		
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
				margin:0;
				padding:0;
				font-family:roboto-reglar;
				color:#555;
				background-color:#42a5f5;
			}
			input[type=radio]{
				display:none;
				margin:0;
				padding:0;
			}
			input[type=radio]+label{
				cursor:pointer;
				font-family:roboto-regular;
				background-color: #ccc;
				color:#999;
				margin: 0;
				transition:background-color 0.3s,color 0.3s;
				padding:6px;
				display:inline-block;
				}

			input[type=radio]:checked + label{
				background-color:#2196F3;
				color:#fff;
			}

			input[type=text],input[type=password]{
				outline:none;
				border:none;
				background:none;
				font-family:roboto-medium;
				color:#555;
				padding:8px;
				font-size:110%;
				transition:background-color 0.3s;
			}

			input[type=text]:hover,input[type=password]:hover{
				background-color:#fafafa;
			}

			input[type=text]:focus,input[type=password]:focus{
				background-color:#fafafa;
			}

			input[type="button"],input[type="submit"]{
				 font-size:100%;
				 background-color:#2196F3;
				 color: #fff;
				 -webkit-transition:background-color 0.3s;
				 transition:background-color 0.3s;
				 border:none;
				 outline:none;
				 padding:6px;
				 border-radius:0px;
				 cursor:pointer;
				 margin:0;
				 font-family:roboto-regular;
			}

			input[type=button]:disabled{
				background-color:#ccc;
				color:#999;
			}

			input[type="submit"]:hover,input[type="button"]:hover:not([disabled]){
				background-color:#1976D2;
			}

			input[type="button"]:active:not([disabled]),input[type="submit"]:active{
			    background-color:#0d47a1;
			}

			.underlay{
				width:100%;
				margin:0;
				padding:0;
				display:flex;
				align-items:center; 
			}
			.center-horizontal{
				margin-right:auto;
				margin-left:auto;
			}
			.text-center{
				text-align:center;
			}
			.login{
				background-color: #fff;
				box-shadow:0px 0px 16px rgba(0,0,0,0.3);
				z-index:10;
				min-width:400px;
			}
			.loginheading{
				font-family: roboto-medium;
				font-size:100%;
				color:#2196f3;
			}
			.paddingtb{
				padding-top:22px;
				padding-bottom:22px;
			}
			.inputerror{
				color:red;
				font-size: 80%;
				font-family:roboto-regular;
			}
		</style>

		<script src="/Matching-Game/assets/jquery.min.js">
		</script>
		<script src="/Matching-Game/assets/inputerror.js">
		</script>
	
	</head>
	<body>
		<div class="underlay">
			<div class="center-horizontal login">
				<div class="text-center loginheading paddingtb">
					<img id="imgut" src="assets/logo.png" height="26px;" style="background-color:#2196f3;padding:4px;border-radius:50%;"/>
					<br>
					login
				</div>
				<form method="post" id="loginform">
					<div class="text-center paddingtb" style="background-color:#fafafa;">
						<input type="radio" name="usertype" value="player" id="playerradiobtn" checked>
						<label for="playerradiobtn">PLAYER</label> 
						
						<input type="radio" name="usertype" value="admin" id="adminradiobtn"> 
						<label for="adminradiobtn">ADMIN</label>
					</div>
					<div class="text-center paddingtb">
						<div style="">
						<input type="text" name="username" id="username" maxlength="20" placeholder="username"/>
						<br>
						<span id="usernameerror" class="inputerror"></span>
						</div>
						<div style="">
						<input type="password" name="password" id="password" maxlength="20" placeholder="password"/>
						<br>
						<span id="passworderror" class="inputerror"></span>
						</div>
					</div>
					<div class="text-center paddingtb" style="padding-bottom:0;">
						<input type="button" name="signupbtn" id="signupbtn" value="SIGN UP" onclick="signupclicked()"/>
						<input type="button" name="signinbtn" id="signinbtn" value="SIGN IN" onclick="signinclicked()"/>
					</div>
				</form>
			</div>
		</div>
		
		<script>
			$(".underlay").css("height",$(window).height());
			$("input[type=button]").css('width',$(".login").width()/2+"px");
			$("input[type=radio]+label").css('width',$("input[type=button]").width()+"px");

			$("#playerradiobtn").click(function(){
				$("#imgut").attr("src","/Matching-Game/assets/logo.png");
				$("#signupbtn").prop("disabled",false);
			});
			$("#adminradiobtn").click(function(){
				$("#imgut").attr("src","/Matching-Game/assets/admin.png");
				$("#signupbtn").prop("disabled",true);
			});
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