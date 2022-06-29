<!DOCTYPE html>
<html>
<head>
<title>Sign in</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="width=device-width" />
<link rel="shortcut icon" href="Pictures/miaLogo.png" type="image/png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
body {
	font-family: monaco, monospace;
	background-color: #ffffff;
}
#header {
	background-color: #d3d3d3;
	margin-top:-5px;
	margin-bottom:-10px;
	color: #000000;
}
#subheader {
	background-color: #09070e;
	margin-top:-5px;
	margin-bottom:-10px;
}
.center {
    align-items: center;
	display: block;
	margin-left: auto;
	margin-right: auto;
}
hr.thickG {
	border: 5px solid #d3d3d3;
	background-color: #d3d3d3;
	padding:0; margin:0;
}
#mainTable {
	border-radius: 5px;
	border: 1px solid;
	border-color: #e0dcdc;
	padding-top: 5px;
	padding-left: 25px;
	padding-right: 25px;
	padding-bottom: 15px;
	width: 350px;
}
.txtCenter {
	text-align:center
}
font{
	font-family: Arial Nova;
}
#subtitle {
	font-family: Arial Nova Light; 
	font-weight: bold;
	font-size:30px;
	padding-top: 10px;
	width: 120px;
	width:100%
}
.formHeader {
	padding-top:10px;
	font-size: 13px;
	font-family: Arial Nova;
}
input {
	box-sizing: border-box;
	border: 2px solid #949494;
	border-radius: 4px;
	border-width: thin;
	width: 100%;
	padding: 8px 10px;
	outline: none;
}
input:focus {
	border: 1px solid #188494;

}
.button {
	cursor: pointer;
	color: #FFFFFF;
	text-align: center;
	padding: 8px;
	border-radius: 4px;
	background-color: #18a4bc;
	border: 1px solid #11505a; 
}
.button:hover {
  background-color: #188494; 
}
#button {
	padding-top: 15px;
	padding-bottom: 15px;
	cursor: pointer;
}
#disclaimer {
	padding-top: 15px;
	font-size: 12px;
	line-height: 1.4;
	padding-bottom: 20px;
	font-family: Arial Nova ;
}
p{
	font-size: 13px;
	text-align: center;
	font-family: Arial Nova ;
}
#errorMessage {
	display:none;
}
#alert {
	border:1px solid #dd0000; 
	background-color:#fcf4f4; 
	width:350px;
	border-radius:5px;
	font-family: Arial Nova;
	margin: 0px auto;
    width: 350px;
    height: px;
    padding: 10px;
    border-radius: 5px;
    position: relative;
    z-index: 10;
}
#alertTable {
	color:#c40000;
	background-image:url('Pictures/alert-icon.png');
	background-size: 30px 30px;
	background-repeat: no-repeat;
	background-position:10px 5px;
	width: 60px;
}
i {
	margin-left: -40px;
    cursor: pointer;
}
.txtCenter {
	text-align:center
}
</style>
</head>
<!--
//Helpdesk Operator
username:alice
password:lovetohelp
//Specialist
username:clara
password:best
-->
<body>

<div id="header">
	<div >&nbsp;</div>
	<table style="width:100%;">
		<td><img src="Pictures/miaLogo.png" style="cursor: pointer;" width="100px" height="100px" alt="Make-It-All Logo"></td>
		<td class="txtCenter" style="font-size: 65px">Make-It-All</td>
		<td style="text-align: right;"><img src="Pictures/miaLogo.png" style="cursor: pointer;" width="100px" height="100px" alt="Make-It-All Logo"></td>
	</table>
	<hr class="thickG">
</div>
<div id="subheader">
	<h3 class="txtCenter" style="color:white;">Welcome to our sign in page!</h3>
</div>
<div id="errorMessage">
	<div >&nbsp;</div>
	<table id="alert" class="center font">
		<tr><td id="alertTable" rowspan="2" style="">
		</td>
		<td style="color:#c40000; font-size:19px;">
		  There was a problem
		</td></tr>
		<tr><td style="color:#000000; font-size:14px; padding-top:6px">
		  We cannot find an account with the following details.
		</td></tr>
	</table>
</div>
<div id="main">
	<div >&nbsp;</div>
	<table id="mainTable" class="center">
		<tr><td id="subtitle">Sign-In</td></tr>
		
		<!--Username-->
		<tr><td class="formHeader"><b>Enter username</b></td></tr>
		<tr><td><input id="username" name="username" type="text"  autocomplete="off" autofocus required></td></tr>
		
		<!--Password-->
		<tr><td class="formHeader"><b>Enter password</b></td></tr>
		<tr><td><input id="pswd" name="pswd" type="password" autocomplete="off" required>
		<i class="bi bi-eye-slash" id="togglePassword"></i></td></tr>
		<script>
			//Change passowrd visibility function
			togglePassword = document.querySelector('#togglePassword');
			password = document.querySelector('#pswd');
			
			togglePassword.addEventListener('click', function (e) {
				// toggle the type attribute
				const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
				password.setAttribute('type', type);
				
				// toggle the eye / eye slash icon
				this.classList.toggle('bi-eye');
			});
		</script>
		
		<tr><td id="button"><button class="button font" onclick="signIn()" type="submit" name="submit" id="submit" style="width:100%; font-family: monaco, monospace;">Sign In</button></td></tr>
		<script type="text/javascript">
			document.getElementById("username") //If enter key pressed on username, then go to password input
				.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
					document.getElementById('pswd').focus();
				}
			});
			
			document.getElementById("pswd") //If enter key pressed, then run button click function
				.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
					document.getElementById("submit").click();
				}
			});
			
			var fname;
			function signIn() { //Sign in function - If button clicked or enter key pressed, go to respective page
				username = document.getElementById("username").value.trim();
				password = document.getElementById("pswd").value;
				
				var httpRequest = new XMLHttpRequest();
				httpRequest.onreadystatechange = function(){
						if (this.readyState == 4 && this.status == 200){
							var detailsJson = JSON.parse(httpRequest.responseText);
							if (detailsJson.length > 0) {
								//alert(detailsJson[1].PASSHASH);
								if (detailsJson[1].PASSHASH == true){
									if (detailsJson[0].JOBTITLE == "OPERATOR"){
										empno = detailsJson[0].EMPNO;
										location.href = "helpdesk.php?empno=" + empno;
									} else {
										empno = detailsJson[0].EMPNO;
										location.href = "specialist.php?empno=" + empno;
									}
								} else{
									var error = document.getElementById('errorMessage');
									error.style.display = 'block';
								}
							}else{
								var error = document.getElementById('errorMessage');
								error.style.display = 'block';
							}
							
						}
				};
				httpRequest.open("GET", "login.php?user=" + username+"&pass="+password, true);
				httpRequest.send();
				
				
			};
		</script>
		
		<tr><td id="disclaimer" class="font">By signing-in you agree to Make-It-All's Conditions. Please visit our main website 
		for more details.</td></tr>
	</table>
</div>
<div id="footer">
	<br><br><br><hr><br>
	<p class="txtCenter" style="font-size:12px;">© 1996-2021, Make-It-All, Inc. or its affiliates</p>
	<br>
</div>
</body>

</html>