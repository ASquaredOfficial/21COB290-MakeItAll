<!DOCTYPE html>
<html>
<head>
<title>Technical Support</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="width=device-width" />
<link rel="shortcut icon" href="Pictures/miaLogo.png" type="image/png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
	function upperFirst(word){
		word = word.toLowerCase();
		words = word.split(" ");
						
		for (let i = 0; i < words.length; i++) {
		words[i] = words[i][0].toUpperCase() + words[i].substr(1);	
		}
		split = words.join(' ');
		return split;
	}
	
	function alterDate(date){
		var i = date.slice(0, 16).replace('T', ' ');
		
		var text = "";
		var year = date.substring(0,4);
		var month = date.substring(5,7);
		var day = date.substring(8,10);
		var hour = parseInt(date.substring(11,13));
		
		var time = date.substring(11,16);
		
		if (month == "01"){
			text += "Jan";
		}else if (month == "02"){
			text += "Feb";
		}else if (month == "03"){
			text += "Mar";
		}else if (month == "04"){
			text += "Apr";
		}else if (month == "05"){
			text += "May";
		}else if (month == "06"){
			text += "Jun";
		}else if (month == "07"){
			text += "Jul";
		}else if (month == "08"){
			text += "Aug";
		}else if (month == "09"){
			text += "Sep";
		}else if (month == "10"){
			text += "Oct";
		}else if (month == "11"){
			text += "Nov";
		}else{
			text += "Dec";
		}
		if (day < 10){
			day = day.substring(1);
		}
		if (hour < 10){
			time = time.substring(1);
		}
		if (hour > 12){
			t_hour = hour - 12;
			time = t_hour + time.substring(2);
		}
		text += " " + day + ", "+ year + " " + time;
		
		
		if (hour < 12){
			text += "am";
		}else {
			text += "pm";
		}
		
		return text;
		
		
	};
</script>
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
.txtCenter {
	text-align:center;
}
#queryTable {
	border-radius: 5px;
	border: 1px solid;
	border-color: #e0dcdc;
	padding-top: 5px;
	padding-left: 25px;
	padding-right: 25px;
	padding-bottom: 15px;
	width: 350px;
}
#subtitle {
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
.mainTable {
	padding:5px;
	width: 1050px;
	//border: 1px solid black;
	//border-collapse: collapse;
}
.widthS{
	width:262.5px;
	text-align:right;
	padding-right:10px;
	padding-left:10px;
}
.widthB{
	width:787.5px;
	text-align:left;
	padding-right:10px;
	padding-left:10px;
}

#main_problem {
	display:none;
}
#submitR{
	display:none;
}
ul {
	list-style-type: none;
	margin: 0;
	padding: 0;
	overflow: hidden;
	background-color: #333;
}
li {
	float: left;
}
li a {
	display: block;
	color: #FFFFFF;
	text-align: center;
	padding: 14px 16px;
	text-decoration: none;
}

li a:hover {
	background-color: #111;
	text-decoration: none;
	color: #edb100;
}
#myUnresolved{
	display:block;
}
#main_load{
	display:none;
}
.unresolvedTable{
	padding:5px;
	width: 1050px;
	//border: 1px solid black;
	//border-collapse: collapse;
}
#advancedOptions{
	display: none;
	position: absolute;
	top: 90px;
    left: 0;
    right: 0;
    background-color: #F6F6F6;
    width: 860px;
    margin: 0 auto;
	z-index: 1;
}
#mainUnresolved{
	display:none;
}
.buttonRed {
	cursor: pointer;
	color: #FFFFFF;
	text-align: center;
	padding: 8px;
	border-radius: 4px;
	background-color: red;
	border: 1px solid #3f0303; 
}
.buttonRed:hover {
  background-color: #940607; 
}
.advOpt{
	padding: 30px 20px;
	text-align:left;
}
button#exitButton {
  border-radius: 50%;
  top: -15px;
  right: -10px;
  padding: 0.5em;
  width: 30px;
  height: 30px;
  border: 2px solid black;
  color: blue;
  position: relative;
  background-color: #ADD8E6;
}
button#exitButton:hover {
  border: 2px solid black;
  background-color: #f5d000;
  color: #ffffff;
}

button#exitButton::before {
  content: " ";
  position: absolute;
  display: block;
  background-color: black;
  width: 2px;
  left: 12px;
  top: 5px;
  bottom: 5px;
  transform: rotate(45deg);
}
button#exitButton::after {
  content: " ";
  position: absolute;
  display: block;
  background-color: black;
  height: 2px;
  top:12px;
  left: 5px;
  right: 5px;
  transform: rotate(45deg);
}
th {
	font-size: 1.5em;
}
.tableWidth{
	width:500px;
}
.vaTOP{
	vertical-align: top;
}
#topBtn {
	cursor: pointer;
	color: #FFFFFF;
	text-align: center;
	padding: 8px;
	border-radius: 4px;
	background-color: #18a4bc;
	border: 1px solid #11505a; 
	
	display: none;
	position: fixed;
	bottom: 20px;
	right: 30px;
	z-index: 99;
	font-size: 18px;
}
#topBtn:hover {
  background-color: gray; 
}
</style>
<?php
include "team017-mysql-connect.php";
$empno = $_GET['empno'];
		
	//Connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT `EMPNO`,`FNAME`
			FROM `employee`
			WHERE EMPNO = '$empno'";
	
	
	//Get the table via sql query
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$fname = ucfirst(strtolower($row['FNAME']));
		$empno = $row['EMPNO'];
	}
?>
</head>

<body>
<div id="advancedOptions">
	<div style="text-align: right;"><button id="exitButton" onclick="exitPopUp()"></button></div>
	<script>
	function exitPopUp(){
		var advOpt = document.getElementById("advancedOptions");
		advOpt.style.display = "none";
		document.getElementById("navigation").style.pointerEvents = "auto";
		document.getElementById("btnAdvanced").style.pointerEvents = "auto";
		document.getElementById("btnUpdateProb").style.pointerEvents = "auto";
	}
	function openPopUp(){
		var advOpt = document.getElementById("advancedOptions");
		advOpt.style.display = "block";
		document.getElementById("navigation").style.pointerEvents = "none";
		document.getElementById("btnAdvanced").style.pointerEvents = "none";
		document.getElementById("btnUpdateProb").style.pointerEvents = "none";
	}
	function deleteFilters(){
		document.getElementById("fP_type").value = "fNone";
		document.getElementById("sDate").value = "";
		document.getElementById("fDate").value = "";
		document.getElementById("status").value = "Nstat";
		document.getElementById("pSort").value = "pN";
		document.getElementById("sSort").value = "DESC";
	}
	function applyFilters(){
		var fPType = document.getElementById("fP_type").value;
		var fSDate = document.getElementById("sDate").value;
		var fEDate = document.getElementById("fDate").value;
		var fStatus = document.getElementById("status").value;
		var fPrimary = document.getElementById("pSort").value;
		var fSecondary = document.getElementById("sSort").value;
		
		var x = document.getElementById("probDetails").rows.length;
		var tblStart = 3;
		var tblStop = x - 1;
		
		for (tblStart; tblStart < tblStop; tblStart++) {
			document.getElementById("probDetails").deleteRow(3);
		}
		
		if (fSDate.replace(/\s/g, "") == "" || fSDate == ""){
			document.getElementById("fDate").value = "";
		} else {
			if (fEDate.replace(/\s/g, "") == "" || fEDate == ""){
				var now = new Date();
				now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
				document.getElementById('fDate').value = now.toISOString().slice(0,16);
			}
		}
		
		fSDate = fSDate.slice(0, 16).replace('T', ' ');
		fEDate = document.getElementById("fDate").value;
		fEDate = fEDate.slice(0, 16).replace('T', ' ');
		
		
		var xmlTBLfilter = new XMLHttpRequest();
		xmlTBLfilter.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//alert(xmlTBLfilter.responseText);
				var detailsJson = JSON.parse(xmlTBLfilter.responseText);
				if (detailsJson.length > 0) {
					var tblHTML = "";
					for (var i = 0; i<detailsJson.length; i++){
						var table = document.getElementById("probDetails");
						//var lastRow = table.rows[ table.rows.length - 1 ];
						var row = table.insertRow(3 + i);
						
						var pID = String(detailsJson[i].PROBID);
						var pType = String(detailsJson[i].PROBTYPE).toLowerCase();
						const words = pType.split(" ");
			
						for (let i = 0; i < words.length; i++) {
							words[i] = words[i][0].toUpperCase() + words[i].substr(1);	
						}
						pType = words.join(' ');
						
						var software = String(detailsJson[i].SOFTWARE);
						var hardware = String(detailsJson[i].HARDWARE);
						var serialNo = String(detailsJson[i].SERIALNO);			
						var sName = String(detailsJson[i].FNAME).toLowerCase();
						sName = sName.charAt(0).toUpperCase() + sName.slice(1);
						var priority = String(detailsJson[i].PRIORITY);
						
						var cell1 = row.insertCell(0);
						var cell2 = row.insertCell(1);
						var cell3 = row.insertCell(2);
						var cell4 = row.insertCell(3);
						var cell5 = row.insertCell(4);
						var cell6 = row.insertCell(5);
						var cell7 = row.insertCell(6);
						
						cell1.innerHTML = pID;
						cell2.innerHTML = pType;
						cell3.innerHTML = software;
						cell4.innerHTML = hardware;
						cell5.innerHTML = serialNo;
						cell6.innerHTML = sName;
						cell7.innerHTML = priority;
						
						cell1.classList.add('tableWidth', 'vaTOP');
						cell2.classList.add('tableWidth', 'vaTOP');
						cell3.classList.add('tableWidth', 'vaTOP');
						cell4.classList.add('tableWidth', 'vaTOP');
						cell5.classList.add('tableWidth', 'vaTOP');
						cell6.classList.add('tableWidth', 'vaTOP');
						cell7.classList.add('tableWidth', 'vaTOP');
					};
				}						
			}
		};
		postData = "ptype="+fPType+"&sdate="+fSDate+"&fdate="+fEDate+"&status="+fStatus+"&primary="+fPrimary+"&secondary="+fSecondary;
		xmlTBLfilter.open("GET", "TBLfilter.php?"+postData, true);
		xmlTBLfilter.send();
		
		document.getElementById("advancedOptions").style.display = "none";
		document.getElementById("navigation").style.pointerEvents = "auto";
		document.getElementById("btnAdvanced").style.pointerEvents = "auto";
		document.getElementById("btnUpdateProb").style.pointerEvents = "auto";
	}
	
	</script>
	<table class="center advOpt" style="padding-bottom:0px;">
	<col style="width:20%">
	<col style="width:80%">
	<tr>
		<th style="text-align:center; padding-bottom:0px; width: 85vw" colspan="2" padding><h3><b>Advanced Options</b></h3><br></th>
	</tr>
	<tr>
		<td><h5><b>Filter</b></h5></td>
		<td>Apply one or more filters</td>
	</tr>
	<tr>
		<td colspan="2"><hr style="background-color: #d8d4d4; width"></td>
	</tr>
	<tr>
		<td><label>Problem Types</label></td>
		<td><select id = "fP_type" name = "fP_type">
			<option value="fNone" selected>Not Specified</option>
			<optgroup label = "Software">
			<option value="SOFTWARE">General Software</option>
			<option value="WORD">Word</option>
			<option value="OPERATING SYSTEM">Operating System</option>
			<option value="MICROSOFT TEAMS">Microsoft Teams</option>
			</optgroup>
			<optgroup label = "Hardware">
			<option value="HARDWARE">General Hardware</option>
			<option value="KEYBOARD ISSUES">Keyboard Issues</option>
			<option value="PC ISSUES">PC Issues</option>
			<option value="MOUSE ISSUES">Mouse Issues</option>
			<option value="PRINTER ISSUES">Printer Issues</option>
			</optgroup>
			<optgroup label = "----------------">
			<option value="NETWORK">Network</option>
			</optgroup>
		</select></td>
	</tr>
	<tr>
		<td><label>Between Dates</label></td>
		<td><label for="sDate">Start:</label><input id="sDate" type="datetime-local" name="sDate" size="18" autocomplete="on" style="width:250px;" >
		<label for="fDate">End:</label><input id="fDate" type="datetime-local" name="fDate" size="18" autocomplete="on" style="width:250px;" >
		</td>
	</tr>
	<tr>
		<td><label>Status</label></td>
		<td><select id = "status" name = "status">
			<option value="Nstat" selected>Not Specified</option>
			<option value="RESOLVED">Resolved</option>
			<option value="UNRESOLVED">Unresolved</option>
		</select></td>
	</tr>
	<tr>
		<td style="padding-top:30px;"><h5><b>Sort</b></h5></td>
		<td style="padding-top:30px;">Choose a column to be sorted in ascending or descending order</td>
	</tr>
	<tr>
		<td colspan="2"><hr style="background-color: #d8d4d4; width"></td>
	</tr>
	<tr>
		<td><label>Primary</label></td>
		<td><select id = "pSort" name = "pSort">
			<option value="pN" selected>Not Specified</option>
			<option value="PROBID">Problem ID</option>
			<option value="PROBTYPE">Problem Type</option>
			<option value="PRIORITY">Priority</option>
			<option value="FNAME">Specialist</option>
			<option value="SERIALNO">Serial Number</option>
		</select></td>
	</tr>
	<tr>
		<td><label>Secondary</label></td>
		<td><select id = "sSort" name = "sSort">
			<option value="DESC">Descending</option>
			<option value="ASC">Ascending</option>
		</select></td>
	</tr>
	<tr>
		<td colspan="2"><br><hr style="background-color: #d8d4d4; width"></td>
	</tr>
	</table>
	<table class="center" width="100px">
		<td style="text-align: center;"><button id="apply" class="button center" onclick="applyFilters()">Apply</button></td>
		<td style="text-align: center;"><button id="apply" class="buttonRed center" onclick="deleteFilters()">Clear</button></td>
	</table>
	<br>
</div>
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
	<h3 class="txtCenter" id="tech" style="color:white;">Technical Specialist - My Unresolved Problems</h3>
</div>
<div id="navigation">
	<ul>
		<li><a href="javascript:void(0)" onclick="loadQueryTable();">Load Problem</a></li>
		
		<li><a href="javascript:void(0)" onclick="unresolvedProblems();">My Unresolved Problems</a></li>
		<li><a href="javascript:void(0)" onclick="allProblems();">All Problems</a></li>
		<li style="float:right;"><a href="javascript:void(0)" onclick="signOut();">Sign out</a></li>
		<script>
			function loadQueryTable() {
				document.getElementById("main_problem").style.display = "none";
				document.getElementById("myUnresolved").style.display = "none";
				document.getElementById("mainUnresolved").style.display = "none";
				document.getElementById("main_load").style.display = "block";
				document.getElementById("tech").innerHTML = "Technical Specialist - Load Problems";
				};
			function loadMainProlem() {
				document.getElementById("main_load").style.display = "none";
				document.getElementById("myUnresolved").style.display = "none";
				document.getElementById("mainUnresolved").style.display = "none";
				document.getElementById("main_problem").style.display = "block";
				document.getElementById("tech").innerHTML = "Technical Specialist - Provide Solutions";
			};
			function unresolvedProblems(){
				document.getElementById("main_load").style.display = "none";
				document.getElementById("main_problem").style.display = "none";
				document.getElementById("mainUnresolved").style.display = "none";
				document.getElementById("myUnresolved").style.display = "block";
				document.getElementById("tech").innerHTML = "Technical Specialist - My Unresolved Problems";
			};
			function allProblems(){
				document.getElementById("main_load").style.display = "none";
				document.getElementById("main_problem").style.display = "none";
				document.getElementById("myUnresolved").style.display = "none";
				document.getElementById("mainUnresolved").style.display = "block";
				document.getElementById("tech").innerHTML = "Technical Specialist - All Problems";
			};
			function signOut(){
				var xmLogOut = new XMLHttpRequest();
				var empno = <?php echo $empno; ?>;
				xmLogOut.open("GET", "logout.php?empNo="+empno, true);
				xmLogOut.send();
				location.href = "signin.php";
			}
		</script>
	</ul>
</div>
<div id="welcome">
	<div >&nbsp;</div>
	<h2 class="txtCenter">Welcome <?php echo $fname;?></h2>
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
		  Invalid Problem ID entered, please check your problems again.
		</td></tr>
	</table>
</div>
<div id="main_load">
	<div >&nbsp;</div>
	<script>
		
	</script>
	<div >&nbsp;</div>
	<table id="queryTable" class="center">
		<tr><td id="subtitle">Load Problem</td></tr>
		
		<tr><td><b>Enter Problem ID:</b></td></tr>
		<tr><td><input id="problem_id" name="problem_id" type="number" autofocus autocomplete="off" min = "0"></td></tr>
		
		<tr><td id="button"><button class="button" onclick="loadMyProblem()" type="submit" name="submit" id="submit" style="width:300px;">Load Details</button></td></tr>
		<script type="text/javascript">
			document.getElementById("problem_id") //If enter key pressed, then run button click function
				.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
					document.getElementById("submit").click();
				}
			});
			
			function upperFirst(word){
				word = word.toLowerCase();
				words = word.split(" ");
								
				for (let i = 0; i < words.length; i++) {
				words[i] = words[i][0].toUpperCase() + words[i].substr(1);	
				}
				split = words.join(' ');
				return split;
			}
			
			function loadMyProblem() { //Load Problem function - If button clicked or enter key pressed, go to respective page
				//alert("Load Problem details");
				var p_id = document.getElementById("problem_id").value;
				var error = document.getElementById('errorMessage');
				
				var xmlLoad = new XMLHttpRequest();
				xmlLoad.onreadystatechange = function(){
					if (this.readyState == 4 && this.status == 200){
							//alert("Entered ready state change");
							var detailsJson = JSON.parse(xmlLoad.responseText);
							if (detailsJson.length > 0) {//alert("1+ rows found");
								//Caller Dartails
								var probid = detailsJson[0].PROBID;
								var intialdate = detailsJson[0].INITIALDATE;
									intialdate = alterDate(intialdate);
								
								var callname = detailsJson[0].FNAME.toLowerCase();
									callname = callname.charAt(0).toUpperCase() + callname.slice(1);
								var sname = detailsJson[0].SNAME.toLowerCase();
									sname = sname.charAt(0).toUpperCase() + sname.slice(1);
								var extno = detailsJson[0].EXTNO;
								
								//Problem Details
								var software = upperFirst(detailsJson[0].SOFTWARE);
								var hardware = upperFirst(detailsJson[0].HARDWARE);//alert(harware);
								var serialno = String(detailsJson[0].SERIALNO);//alert(serialno);
								var ptype = upperFirst(detailsJson[0].PROBTYPE);
								var pdesc = detailsJson[0].PROBDESCR;
								var notes = detailsJson[0].NOTES;
								var noteSplit = notes.split("|");
								var priority = upperFirst(detailsJson[0].PRIORITY);
								var status = upperFirst(detailsJson[0].STATUS);
								var dept = detailsJson[0].DEPT;
								
								document.getElementById("rPID").innerHTML = probid;
								document.getElementById("rCall").innerHTML = intialdate;
								document.getElementById("rDetails").innerHTML = callname + " " + sname + " from " + dept + ", ext " + extno;
								document.getElementById("rSoft").innerHTML = software;
								
								//Format Serial No and Hardware string
								if (serialno == "-"){
									document.getElementById("rHard").innerHTML = hardware;
									//alert("No serial no found");
								}else{
									document.getElementById("rHard").innerHTML = hardware + " - " + serialno;
									//alert("Serial No Inserted");
								}
								//alert("");
								document.getElementById("rPT").innerHTML = ptype;
								document.getElementById("rPri").innerHTML = priority;
								document.getElementById("rDesc").innerHTML = pdesc;
								document.getElementById("rNotes").innerHTML = noteSplit[0];
								
								var x = document.getElementById("rNotesSplit").rows.length;
								var tblStart = 1;
								var tblStop = x;
								
								for (tblStart; tblStart < tblStop; tblStart++) {
									document.getElementById("rNotesSplit").deleteRow(1);
								}
								
								for (let i = 1; i < noteSplit.length; i++) {
									var table = document.getElementById("rNotesSplit");
									var row = table.insertRow(i);
									var choice = noteSplit[i].split("~");
									
									var ndate = choice[0];
									var notee = choice[1];
									var cell1 = row.insertCell(0);
									var cell2 = row.insertCell(1);
									
									cell1.innerHTML = ndate+ " -";
									cell2.innerHTML = notee;
									
									cell1.className = "vaTOP";
									cell2.className = "vaTOP";
								}
								document.getElementById("rStat").innerHTML = status;
									
									
									
								if (status == "Unresolved"){	
									document.getElementById("probUnres").style.display = "block";	
								} else{
									document.getElementById("probUnres").style.display = "none";
									
								}
									
								document.getElementById("main_problem").style.display = "block";//unhide problem details
								document.getElementById('main_load').style.display = "none";	//hide lod problem section
								document.getElementById('main_problem').scrollIntoView({behavior: "smooth"});//scroll down to problem details
								var error = document.getElementById('errorMessage');
								error.style.display = 'none';			
								
							}else{
								document.getElementById("main_problem").style.display = "none";
								var error = document.getElementById('errorMessage');
								error.style.display = 'block';
							};
						};
				};
				xmlLoad.open("GET", "loadProb.php?id="+p_id, true);
				xmlLoad.send();
			};
		</script>
	</table>
</div>
<div id="main_problem">
	<!--Load details for Problem-->
	<table class="center mainTable">
	  <tr><!--Problem Subtitle-->
		<th class="mainTable widthS" style="font-size:23px; text-align:left; padding-bottom:0px;" colspan="2"><b>Problem Details:</b></th>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr style="background-color: #d8d4d4;"></td>
	  </tr>
	  <tr><!--Problem ID-->
		<td class="mainTable widthS">Problem ID:</td>
		<td class="mainTable widthB" id = "rPID">326</td>
	  </tr>
	  <tr><!--Call Time-->
		<td class="mainTable widthS">Call Time:</td>
		<td class="mainTable widthB" id = "rCall">Oct 3 2016,9.15am</td>
	  </tr>
	  <tr><!--Caller Details-->
		<td class="mainTable widthS">Caller Details:</td>
		<td class="mainTable widthB" id = "rDetails">Hillary C. from Legal Dept., ext 22999</td>
	  </tr>
	  <tr><!--Software-->
		<td class="mainTable widthS">Software:</td>
		<td class="mainTable widthB" id = "rSoft">Windows 10, Outlook 365</td>
	  </tr>
	  <tr><!--Hardware-->
		<td class="mainTable widthS">Hardware:</td>
		<td class="mainTable widthB" id = "rHard">-</td>
	  </tr>
	  <tr><!--Problem Type-->
		<td class="mainTable widthS">Problem Type:</td>
		<td class="mainTable widthB" id = "rPT"></td>
	  </tr>
	  <tr><!--Problem Type-->
		<td class="mainTable widthS">Priority:</td>
		<td class="mainTable widthB" id = "rPri">PC Issues</td>
	  </tr>
	  <tr><!--Hardware-->
		<td class="mainTable widthS">Problem description:</td>
		<td class="mainTable widthB" id = "rDesc">Email may have been hacked when using an external server.</td>
	  </tr>
	  <tr><!--Notes-->
		<td class="mainTable widthS" style="vertical-align: top;">Notes:</td>
		<td class="mainTable widthB"><label id = "rNotes">TBD</label>
			<table id = "rNotesSplit">
				<col style="width:30%; text-align: right">
				<col style="width:80%">
				<tr><td colspan="2" id ="firstNotes"></td></tr>
			</table>
		</td>
	  </tr>
	  <tr><!--Resolved-->
		<td class="mainTable widthS">Status:</td>
		<td class="mainTable widthB" id = "rStat"></td>  
	  </tr>
	</table>
	<div id="probUnres">
	<!--Specialist Input for problem-->
	<table class="center mainTable">
	  <tr><!--Solution Subtitle-->
		<th class="mainTable widthS" style="font-size:23px; text-align:left; padding-bottom:0px;" colspan="2"><b>Update Problem:</b></th>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr style="background-color: #d8d4d4;"></td>
	  </tr>
	  <tr><!--Problem Resolved-->
		<td class="mainTable widthS" VALIGN=TOP style="width:1050px;">Problem resolved:</td>
		<td class="mainTable widthB" style="text-align:left; width:100px;">
			<input type="checkbox" id="p_resolve" name="p_resolve" style="width:20px;"/>
			Problem has been resolved
		</td>
	  </tr>
	  <tr><!--Update Notes Input-->
		<td class="mainTable widthS" VALIGN=TOP style="width:1050px;">Add to Note:</td>
		<td class="mainTable widthB"><textarea rows="3" cols="70" id="descript" placeholder="Notes or solution."></textarea></td>
	  </tr>
	  <tr><!--Submit Button-->
		<td style="text-align:right; padding-right:39px;" colspan="2">
		<button class="button" onclick="updateProblem()" type="submit" name="submitP" id="submitP" style="width:200px;">Update Problem</button></td>
		<script>
		function updateProblem() { //Load Problem function - If button clicked or enter key pressed, go to respective page
			var checkBox = document.querySelector('input[name="p_resolve"]:checked');
			var problemID = document.getElementById("rPID").innerHTML;
			var priority = document.getElementById("rPri").innerHTML;
			
			//Get and Format Date
			var now = new Date();
			now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
			now = now.toISOString().slice(0,16);
			currentDate = now.slice(0, 16).replace('T', ' ');
			var notes_date = alterDate(currentDate);
			var specialistNotes = document.getElementById('descript').value;
			var specialist_id = <?php echo $empno ?>;
			var notes = notes_date + " ~ " +specialistNotes.trim();
			//alert(specialistNotes);
			if (checkBox.checked){
				var xmlUpdateProb = new XMLHttpRequest();
				var upStatus = "RESOLVED";
				priority = "-";
				
				xmlUpdateProb.onreadystatechange = function(){
					if (this.readyState == 4 && this.status == 200){
						//alert(this.responseText);
					}
				};
				var data = "prob="+problemID+"&s_id="+specialist_id+"&status="+upStatus+"&date="+currentDate+"&notes="+notes+"&prior="+priority;
				xmlUpdateProb.open("GET", "SPECupdateTBL.php?" + data, true);
				xmlUpdateProb.send();
			} 
			unresolvedProblems();
			//document.getElementById('header').scrollIntoView({behavior: "smooth"});//scroll back to top of page
			
		};
		
		</script>
	  </tr>
	</table>
	</div>
</div>
<div id="myUnresolved">
	<div >&nbsp;</div>
	<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		window.scrollTo(0, 0);
		var xmlTBL = new XMLHttpRequest();
		xmlTBL.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var detailsJson = JSON.parse(xmlTBL.responseText);
				if (detailsJson.length > 0) {
					var tblHTML = "";
					for (var i = 0; i<detailsJson.length; i++){
						
						var table = document.getElementById("unresolvedTable");
						//var lastRow = table.rows[ table.rows.length - 1 ];
						var row = table.insertRow(3 + i);
						
						var pID = String(detailsJson[i].PROBID);
						var pType = String(detailsJson[i].PROBTYPE).toLowerCase();
						const words = pType.split(" ");

						for (let i = 0; i < words.length; i++) {
							words[i] = words[i][0].toUpperCase() + words[i].substr(1);	
						}
						pType = words.join(' ');
			
						var sName = String(detailsJson[i].FNAME).toLowerCase();
						sName = sName.charAt(0).toUpperCase() + sName.slice(1);
						var priority = String(detailsJson[i].PRIORITY);

						var software = String(detailsJson[i].SOFTWARE);
						var hardware = String(detailsJson[i].HARDWARE);
						var serialNo = String(detailsJson[i].SERIALNO);
						
						var cell1 = row.insertCell(0);
						var cell2 = row.insertCell(1);
						var cell5 = row.insertCell(2);
						var cell6 = row.insertCell(3);
						var cell7 = row.insertCell(4);
						var cell4 = row.insertCell(5);
						
						cell1.innerHTML = pID;
						cell2.innerHTML = pType;
						cell4.innerHTML = priority;
						cell5.innerHTML = software;
						cell6.innerHTML = hardware;
						cell7.innerHTML = serialNo;
						
						cell1.classList.add('tableWidth', 'vaTOP');
						cell2.classList.add('tableWidth', 'vaTOP');
						cell4.classList.add('tableWidth', 'vaTOP');
						cell5.classList.add('tableWidth', 'vaTOP');
						cell6.classList.add('tableWidth', 'vaTOP');
						cell7.classList.add('tableWidth', 'vaTOP');
					};
				}						
			}
		};
		
		postData = <?php echo $empno; ?>;
		//alert(postData);
		xmlTBL.open("GET", "TBLmyProblems.php?empno="+postData, true);
		xmlTBL.send();
	});
	</script>
	<table class="center" style="width:85%" id = "unresolvedTable">
		<!--Consider adding a date to the unresolved problems page-->
			<tr><!--Solution Subtitle-->
				<th class="" style="font-size:23px; " colspan="11"><b>My Unresolved Problems:</b></th>
			</tr>
			<tr><!--Horizontal Rule-->
				<td colspan="11"><hr style="background-color: #d8d4d4;"></td>
			</tr>
			<tr>
				<th class="tableWidth" style="font-size: 23px;">Problem ID</th>
				<th class="tableWidth" style="font-size: 23px;">Problem Type</th>
				<th class="tableWidth" style="font-size: 23px;">Software</th>
				<th class="tableWidth" style="font-size: 23px;">Hardware</th>
				<th class="tableWidth" style="font-size: 23px;">SerialNo</th>
				<th class="tableWidth" style="font-size: 23px;">Priority</th>
			</tr>
			<tr><!--Horizontal Rule-->
				<td colspan="11"><hr class="center" style="background-color: #000000;"></td>
			</tr>
		</table>
	<div >&nbsp;</div>
	<button class="button center" type="submit" onclick="loadQueryTable()" style="width:200px;">Load Problem</button>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
</div>
<div id="mainUnresolved">
	<div >&nbsp;</div>
	<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		window.scrollTo(0, 0);
		var xmlTBL = new XMLHttpRequest();
		xmlTBL.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var detailsJson = JSON.parse(xmlTBL.responseText);
				if (detailsJson.length > 0) {
					var tblHTML = "";
					for (var i = 0; i<detailsJson.length; i++){
						
						var table = document.getElementById("probDetails");
						//var lastRow = table.rows[ table.rows.length - 1 ];
						var row = table.insertRow(3 + i);
						
						var pID = String(detailsJson[i].PROBID);
						var pType = String(detailsJson[i].PROBTYPE).toLowerCase();
						const words = pType.split(" ");

						for (let i = 0; i < words.length; i++) {
							words[i] = words[i][0].toUpperCase() + words[i].substr(1);	
						}
						pType = words.join(' ');
			
						var sName = String(detailsJson[i].FNAME).toLowerCase();
						sName = sName.charAt(0).toUpperCase() + sName.slice(1);
						var priority = String(detailsJson[i].PRIORITY);

						var software = String(detailsJson[i].SOFTWARE);
						var hardware = String(detailsJson[i].HARDWARE);
						var serialNo = String(detailsJson[i].SERIALNO);
						
						var cell1 = row.insertCell(0);
						var cell2 = row.insertCell(1);
						var cell5 = row.insertCell(2);
						var cell6 = row.insertCell(3);
						var cell7 = row.insertCell(4);
						var cell3 = row.insertCell(5);
						var cell4 = row.insertCell(6);
						
						cell1.innerHTML = pID;
						cell2.innerHTML = pType;
						cell3.innerHTML = sName;
						cell4.innerHTML = priority;
						cell5.innerHTML = software;
						cell6.innerHTML = hardware;
						cell7.innerHTML = serialNo;
						
						cell1.classList.add('tableWidth', 'vaTOP');
						cell2.classList.add('tableWidth', 'vaTOP');
						cell3.classList.add('tableWidth', 'vaTOP');
						cell4.classList.add('tableWidth', 'vaTOP');
						cell5.classList.add('tableWidth', 'vaTOP');
						cell6.classList.add('tableWidth', 'vaTOP');
						cell7.classList.add('tableWidth', 'vaTOP');
					};
				}						
			}
		};
		xmlTBL.open("GET", "TBLallProblem.php", true);
		xmlTBL.send();
	});
	</script>
	<div class="center" style="width:60%;">
		<button id="btnAdvanced" class="button center" style="" onclick="openPopUp()">Advanced Options</button>
		<div >&nbsp;</div>
	</div>
	<table class="center" style="width:85%" id = "probDetails">
		<!--Consider adding a date to the unresolved problems page-->
		<tr><!--Solution Subtitle-->
			<th class="txtCenter" style="font-size:23px; " colspan="11"><b>Problem Details:</b></th>
		</tr>
		<tr><!--Horizontal Rule-->
			<td colspan="11"><hr style="background-color: #d8d4d4;"></td>
		</tr>
		<tr>
			<th class="tableWidth" style="font-size: 23px;">Problem ID</th>
			<th class="tableWidth" style="font-size: 23px;">Problem Type</th>
			<th class="tableWidth" style="font-size: 23px;">Software</th>
			<th class="tableWidth" style="font-size: 23px;">Hardware</th>
			<th class="tableWidth" style="font-size: 23px;">SerialNo</th>
			<th class="tableWidth" style="font-size: 23px;">Specialist</th>
			<th class="tableWidth" style="font-size: 23px;">Priority</th>
		</tr>
		<tr><!--Horizontal Rule-->
			<td colspan="11"><hr class="center" style="background-color: #000000;"></td>
		</tr>
	</table>

	<div >&nbsp;</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
</div>
<div id="footer">
	<br><br><br><hr><br>
	<p class="txtCenter" style="font-size:12px;">© 1996-2021, Make-It-All, Inc. or its affiliates</p>
	<br>
</div>
<div id="topButton">
	<button onclick="topFunction()" id="topBtn" title="Go to top">Top</button>
	<script>
	mybutton = document.getElementById("topBtn");
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		// When the user scrolls down 20px from the top of the document, show the button
		mybutton.style.display = "block";
	  } else {
		mybutton.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
	  document.documentElement.scrollTo({top: 0, behavior: 'smooth'}); // For Chrome, Firefox, IE and Opera
	  
	}
	</script>
</div>
</body>


</html>