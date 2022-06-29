<!DOCTYPE html>
<html>
<head>
<title>Helpdesk</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="width=device-width" />
<link rel="shortcut icon" href="Pictures/miaLogo.png" type="image/png">
<link rel="stylesheet" type="text/css" href="mystyle.css">		<!--css file-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!---
Necessary Inputs: Name, Ext, Date
Hardware or Software (at least one)
A list of problem types
Prob description

- Prob type: General Hardware or PC Issues
- Hardware: PC or Laptop or Desktop
- Prob description: includes both run and slow
- Quick Solution: reboot computer

- Prob type: General Hardware or Printer Issues
- Hardware: printer
- Prob description: includes fade or discoloured
- Quick Solution: change ink

- Prob type: General Hardware, Mouse or Keyboard Issues
- Prob description: includes wireless
- Quick Solution: change batteries

- Prob type: General Software or PC Issues
- Hardware: 
- Prob description: includes both run and slow
- Quick Solution: re install program
-->
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
	
	$sql = "SELECT l.EMPNO AS ID, EXPERTISE, JOBSUM, CASE
					WHEN (l.EMPNO > 1000 AND l.EMPNO < 1100) THEN e.FNAME
					WHEN (l.EMPNO >= 9000 AND l.EMPNO <= 9999) THEN s.FNAME
			END AS FNAME
			FROM specialist l
					LEFT OUTER JOIN employee e ON l.EMPNO = e.EMPNO
					LEFT OUTER JOIN extspecialist s ON l.EMPNO = s.TEMPNO
			WHERE (s.TEMPNO IS NOT null OR e.EMPNO IS NOT null)";
	//Get the table via sql query
	$result = mysqli_query($conn, $sql);
	$specialist_id_Array = array();
	$specialist_name_Array = array();
	$specialist_jobsum_Array = array();
	$specialist_expertise_Array = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$specialist_name_Array[] = ucfirst(strtolower($row['FNAME']));
		$specialist_id_Array[] = $row['ID'];
		$specialist_expertise_Array[] = $row['EXPERTISE'];
		$specialist_jobsum_Array[] = $row['JOBSUM'];
	}
	$specName = json_encode($specialist_name_Array);
	$specID = json_encode($specialist_id_Array);
	$specJobs = json_encode($specialist_jobsum_Array);
	$specPT = json_encode($specialist_expertise_Array);
		
?>

<script>
	var prob_id = 1;
	
	var specialist_names = JSON.parse(<?php echo json_encode($specName); ?>);
	var specialist_ids = JSON.parse(<?php echo json_encode($specID); ?>);
	var specialist_jobsum = JSON.parse(<?php echo json_encode($specJobs); ?>);
	var specialist_expertise = JSON.parse(<?php echo json_encode($specPT); ?>);
	
	var bert_jobs = 2;
	var clara_jobs = 1;
	var nick_jobs = 4;
	var external_jobs = 0;
	
	var past_log = "";
	var prev_fname;
	var prev_sname;
	var prev_ext_num;
	var prev_emp_id;
	var prev_date;
	var prev_hard;
	var prev_soft;
	var prev_type;
	var prev_description;
	var prev_sol;
	var prev_priority;
	var prev_resolved;
	
	var saved_p_id;
</script>
<script>
$(document).ready(function(){//Dropdowns for different specialist
	$("#options").change(function (){
		var chosen_type = $("#options").val();
		
		if (chosen_type == "net"){
			
			$("#n_specialist").css("display", "block");
			$("#h_specialist").css("display", "none");
			$("#s_specialist").css("display", "none");
			$("#OS_specialist").css("display", "none");
			$("#specialist").css("display", "none");
		}
		if (chosen_type == "hard" || chosen_type == "key" || chosen_type == "pc" || chosen_type == "mouse" || chosen_type == "print"){
			
			$("#n_specialist").css("display", "none");
			$("#h_specialist").css("display", "block");
			$("#s_specialist").css("display", "none");
			$("#OS_specialist").css("display", "none");
			$("#specialist").css("display", "none");
		}
		if (chosen_type == "soft"|| chosen_type == "word" || chosen_type == "mt"){
			
			$("#n_specialist").css("display", "none");
			$("#h_specialist").css("display", "none");
			$("#s_specialist").css("display", "block");
			$("#OS_specialist").css("display", "none");
			$("#specialist").css("display", "none");
		}
		if (chosen_type == "os"){
			
			$("#n_specialist").css("display", "none");
			$("#h_specialist").css("display", "none");
			$("#s_specialist").css("display", "none");
			$("#OS_specialist").css("display", "block");
			$("#specialist").css("display", "none");
		}
		if (chosen_type == "all"){
			
			$("#n_specialist").css("display", "none");
			$("#h_specialist").css("display", "none");
			$("#s_specialist").css("display", "none");
			$("#OS_specialist").css("display", "none");
			$("#specialist").css("display", "block");
		}
	});
});

$(document).ready(function(){//Give a quick solution if possible
	$('#QuickButton').click(function(){
		var text = "";
		var spec = "";
		var sol = false;
		var hardware = $("#hard").val().toLowerCase();
		var software = $("#soft").val().toLowerCase();
		var type = $("#options").val();
		var description = $("#descript").val().toLowerCase();
		var no = true;
		//alert(hardware);
		
		if (type == "pc" || type == "hard") {
			if (hardware.includes("laptop") || hardware.includes("pc") || hardware.includes("desktop")){
				if (description.includes("run") && description.includes("slow")){
					text+= "Please attempt re-booting the computer";
					sol = true;
				}
				
			}
		} else if (type == "print" || type == "hard" && hardware.includes("printer")){
			if (description.includes("fade") || description.includes("discoloured")) {
				text+= "Please change ink or toner";
				sol = true;
			}
		} else if (type == "hard" || type == "key" || type == "mouse"){
			if (description.includes("wireless")){
				text += "Try changing the batteries the device";
				sol = true;
			}
			
		} else if (type == "soft") {
			if (description.includes("program")){
				if (description.includes("not") && description.includes("run")){
					text += "Try re-installing the program";
					sol = true;
				}else if (description.includes("crash")){
					text += "Try running Troubleshoot";
					sol = true;
				}
			}
		} else if (type == "net") {
			if (description.includes("wifi") || description.includes("wi-fi")){
				if (description.includes("poor") || description.includes("bad") || description.includes("no")){
					text += "Attempt disconnecting and re-connecting Wi-Fi";
					sol = true;
				}
			}
		}
		if (type == "all"){
			text += "A problem type must be selected";
			no = false;
		}else if ((hardware.replace(/\s/g, "") == "" || hardware == "") && (software.replace(/\s/g, "") == "" || software == "")){
			text += "Please enter the software or hardware (or both) involved";
			no = false;
		}else if (description.replace(/\s/g, "") == "" || description == ""){
			text += "Please give the problem description";
			no = false;
		}
		else if (sol == false) {
			text += "No suitable solution on hand, please pass to a Techinal Specialist immediately";
			$(".specialists_area").css("display", "block");
			for (let i = 0; i < specialist_names.length; i++) {
				var line = String(specialist_names[i]) + " - Active Problems: " + String(specialist_jobsum[i]) + "<br> ";
				spec += line;
			}
			//$(".specialists_area").css("visibility", "visible");
			/*spec += "Bert - Active Problems: " + bert_jobs + "<br> ";
			spec += "Clara - Active Problems: " + clara_jobs + "<br> ";
			spec += "Nick - Active Problems: " + nick_jobs + "<br> ";
			spec += "The External Specialists (Daniel & Tara) - Active Problems: " + external_jobs;*/
			$('#SpecialistAvailability').html(spec);
		}
		alert(text);
		if (no){
			$('#QuickSolution').val(text);
		}
		//alert(prob_id);
	});
});


$(document).ready(function(){
	$('#submitP').click(function(){
		var specialists = "";
		if ($('#p_resolve').is(":checked")){
			;
		} else {
			$(".special_area").css("visibility", "visible");
			$(".special_lost").css("display", "none");
			for (let i = 0; i < specialist_names.length; i++) {
				var line = String(specialist_names[i]) + " - Active Problems: " + String(specialist_jobsum[i]) + "<br> ";
				specialists += line;
			}
			$('#special_list').html(specialists);
			
			var type = $("#rPT").text();
			//alert(type);
			
			if (type == "Pc Issues" || type == "Hardware" || type == "Keyboard Issues" || type == "Mouse Issues" || type == "Printer Issues" ){
				$("#s_specialist_").css("display", "none");
				$("#n_specialist_").css("display", "none");
				$("#OS_specialist_").css("display", "none");
				$("#h_specialist_").css("display", "block");
				
			}else if (type == "Software" || type == "Word" || type == "Hardware" || type == "Microsoft Teams") {
				$("#n_specialist_").css("display", "none");
				$("#OS_specialist_").css("display", "none");
				$("#h_specialist_").css("display", "none");
				$("#s_specialist_").css("display", "block");
				
			}
			else if (type == "Network") {
				$("#OS_specialist_").css("display", "none");
				$("#h_specialist_").css("display", "none");
				$("#s_specialist_").css("display", "none");
				$("#n_specialist_").css("display", "block");
				
			}else if (type == "Operating System") {
				$("#h_specialist_").css("display", "none");
				$("#s_specialist_").css("display", "none");
				$("#n_specialist_").css("display", "none");
				$("#OS_specialist_").css("display", "block");
				
			}
			
			
		}
		
	});
});
/*
$(document).ready(function(){
	$('#submitII').click(function(){
		var spec_text = "";
		if ($("#s_specialist_").is(':visible')){
			var spec = $("#s_specialist_").val();
			var prior = document.querySelector('input[name="pri_radio_update"]:checked').value;
			if (spec == "auto"){
				if (clara_jobs <= external_jobs){
					spec_text += "Passed straight to Clara";
					clara_jobs += 1;
				} else {
					spec_text += "Passed straight to Daniel (External Specialist)";
					external_jobs += 1;
				}
			} else if (spec == "clara"){
				spec_text += "Passed straight to Clara";
				clara_jobs += 1;
			} else {
				spec_text += "Passed straight to Daniel (External Specialist)";
				external_jobs += 1;
			}
		} else if ($("#h_specialist_").is(':visible')){
			var spec = $("#h_specialist_").val();
			
			if (spec == "auto"){
				if (bert_jobs <= external_jobs){
					spec_text += "Passed straight to Bert";
					bert_jobs += 1;
				} else {
					spec_text += "Passed straight to External Specialists";
					external_jobs += 1;
				}
			} else if (spec == "bert"){
				spec_text += "Passed straight to Bert";
				bert_jobs += 1;
			} else {
				spec_text += "Passed straight to External Specialists";
				external_jobs += 1;
			}
		} else if ($("#n_specialist_").is(':visible')){
			var spec = $("#n_specialist_").val();
			
			if (spec == "auto"){
				if (nick_jobs <= external_jobs){
					spec_text += "Passed straight to Nick";
					nick_jobs += 1;
				} else {
					spec_text += "Passed straight to Daniel (External Specialist)";
					external_jobs += 1;
				}
			} else if (spec == "nick"){
				spec_text += "Passed straight to Nick";
				nick_jobs += 1;
			} else {
				spec_text += "Passed straight to Daniel (External Specialist)";
				external_jobs += 1;
			}
		} else if ($("#OS_specialist_").is(':visible')){
			var spec = $("#OS_specialist_").val();
			
			if (spec == "auto"){
				if (clara_jobs <= external_jobs){
					spec_text += "Passed straight to Clara";
					clara_jobs += 1;
				} else {
					spec_text += "Passed straight to Tara (External Specialist)";
					external_jobs += 1;
				}
			} else if (spec == "clara"){
				spec_text += "Passed straight to Clara";
				clara_jobs += 1;
			} else {
				spec_text += "Passed straight to Tara (External Specialist)";
				external_jobs += 1;
			}
		}
		
		alert(spec_text);
			
	});
});*/

/*$(document).ready(function(){//Add new specialist to database
	$('#createButton').click(function(){
		var passed = true;
		var s_text = "";
		var l_text = "";
		var fname = $("#specName").val();
		var chose = $("#optSpec").val();
		var dur = $('input[name="optradio"]:checked').val();
		
		
		if (fname.replace(/\s/g, "") == "" || fname == ""){
			alert("Name of Specialist is empty");
			passed = false;
		} else if (chose == "all"){
			alert("Please Specify a Problem Type");
			passed = false;
		} else if ($('input[name="optradio"]').is(":checked") == false){
			alert("Please choose a duration");
			passed = false;
		}
		
		if (passed) {
			s_text += "External Specialist Made \n";
			s_text += "Name: "+fname + "\nSpeciality: " + chose + "\nDuration: " + dur;
			alert(s_text);
			l_text += "External Specialist Created <br>";
			l_text += "Name: "+fname + "<br>Speciality: " + chose + "<br>Duration: " + dur;
			$('#logSpecial').html(l_text);
		}
		
	});
});*/
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
	margin:0px;
	padding:0px
}
#subheader {
	background-color: #09070e;
	margin-top:-5px;
	margin-bottom:-10px;
}
#subtitle {
	font-weight: bold;
	font-size:30px;
	padding-top: 10px;
	width: 120px;
	width:100%
}
.center {
    align-items: center;
	display: block;
	margin-left: auto;
	margin-right: auto;
}

#specialist {
	display: block;
}
#s_specialist, #h_specialist, #n_specialist, #OS_specialist, 
#s_specialist_, #h_specialist_, #n_specialist_, #OS_specialist_, {
	display: none;
}
.specialists_area {
	display: none;
	//visibility: hidden;
}
.special_area {
	//display: none;
	visibility: hidden;
}
hr.thickG {
	border: 5px solid #d3d3d3;
	background-color: #d3d3d3;
	padding:0; margin:0;
}
.txtCenter {
	text-align:center
}
.mainTable {
	padding:5px;
	width: 1050px;
	//border: 1px solid black;
	//border-collapse: collapse;
}
.unresolvedTable {
	padding:5px;
	width: 1050px;
	font-size: 15px;
	//border: 1px solid black;
	//border-collapse: collapse;
}
.specialistTable{
	padding:5px;
	width: 1050px;
	font-size: 15px;
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

#errorMessage {
	display:none;
	z-index: 5;
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
    z-index: 2;
}
#alertTable {
	color:#c40000;
	background-image:url('Pictures/alert-icon.png');
	background-size: 30px 30px;
	background-repeat: no-repeat;
	background-position:10px 5px;
	width: 60px;
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
	display: none;
}
#submitR{
	display: block;
}
#probUnres {
	display: none;
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
#button {
	padding-top: 15px;
	padding-bottom: 15px;
	cursor: pointer;
}
.nav-template ul {
	list-style-type: none;
	margin: 0;
	padding: 0;
	overflow: hidden;
	background-color: #333;
}
.nav-template ul li {
	float: left;
}

.nav-template ul li a {
	display: block;
	background-color: #333;
	color: #FFFFFF;
	text-align: center;
	padding: 14px 16px;
	text-decoration: none;
}
.nav-template ul li a:focus,
.nav-template ul li a:hover {
	background-color: #111;
	text-decoration: none;
	color: #edb100;
	transition: linear 0.3s;
}
{
	background-color: #292929;
	text-decoration: none;
	color: #edb100;
}
#mainUnresolved, #mainExt, #main_problem{
	display:none;
}
.tableWidth{
	width:1000px;
	font-size: 18px;
	text-align: center;
}
label {
    white-space:nowrap;
	font-size: 1em;
}
.wrappable {
    white-space:normal;
}
input[type=ratio]{
	width:auto;
}
th{
	font-size: 1.5em;
}
#main, #welcome, #footer, #main_problem, #errorMessage{
	position: static;
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
	z-index: 5;
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
#main_load{
	position: static;
	background-color: white;
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
</head>

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
		
		
	}
</script>
<body>
<div id="advancedOptions">
	<div style="text-align: right;"><button id="exitButton" onclick="exitPopUp()"></button></div>
	<script>
	function exitPopUp(){
		var advOpt = document.getElementById("advancedOptions");
		advOpt.style.display = "none";
		document.getElementById("header").style.pointerEvents = "auto";
		document.getElementById("subheader").style.pointerEvents = "auto";
		document.getElementById("navigation").style.pointerEvents = "auto";
		document.getElementById("btnAdvanced").style.pointerEvents = "auto";
		document.getElementById("btnUpdateProb").style.pointerEvents = "auto";
		document.getElementById("mainUnresolved").style.pointerEvents = "auto";
	}
	function openPopUp(){
		var advOpt = document.getElementById("advancedOptions");
		advOpt.style.display = "block";
		
		//Scroll to view the advanced options pop up
		var advBody = document.getElementById("advancedOptions");
		window.scrollTo({
			top:0,
			left:advBody.offsetTop - 17,
			behavior: 'smooth'
		});
		document.getElementById("header").style.pointerEvents = "none";
		document.getElementById("subheader").style.pointerEvents = "none";
		document.getElementById("navigation").style.pointerEvents = "none";
		document.getElementById("btnAdvanced").style.pointerEvents = "none";
		document.getElementById("btnUpdateProb").style.pointerEvents = "none";
		document.getElementById("mainUnresolved").style.pointerEvents = "none";
		
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
						
						cell1.className = 'tableWidth';
						cell2.className = 'tableWidth';
						cell3.className = 'tableWidth';
						cell4.className = 'tableWidth';
						cell5.className = 'tableWidth';
						cell6.className = 'tableWidth';
						cell7.className = 'tableWidth';
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
	<h3 class="txtCenter" style="color:white;" id = "help">Helpdesk - New Problem</h3>
</div>
<div id="navigation" class="nav-template">
	<ul>
		<li><a href="javascript:void(0)" onclick="openNewProblem();" autofocus>New Problem</a></li>
		<li><a href="javascript:void(0)" onclick="unresolvedProblems();">All Unresolved Problems</a></li>
		<li><a href="javascript:void(0)" onclick="addSpecialists();">Add Specialists</a></li>
		<li style="float:right;"><a href="javascript:void(0)" onclick="signOut();">Sign out</a></li>
		<script>
			function openNewProblem(){
				document.getElementById("mainUnresolved").style.display = "none";
				document.getElementById("mainExt").style.display = "none";
				document.getElementById("main").style.display = "block";
				$("#help").text("Helpdesk - New Problem");
			};
			function unresolvedProblems(){
				document.getElementById("main").style.display = "none";
				document.getElementById("mainExt").style.display = "none";
				document.getElementById("mainUnresolved").style.display = "block";

				$("#help").text("Helpdesk - Unresolved Problems");
			};
			function addSpecialists(){
				document.getElementById("main").style.display = "none";
				document.getElementById("mainUnresolved").style.display = "none";
				document.getElementById("mainExt").style.display = "block";
				$("#help").text("Helpdesk - Add Specialists");
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
<div id="main">
	<div >&nbsp;</div>
	<script>
		function autoFill(){
			var firstname = document.getElementById("fname").value;
			var surname = document.getElementById("sname").value;
			var extno = document.getElementById("caller").value;
			var empid = document.getElementById("emp_id").value;
			
			if (((firstname.replace(/\s/g, "") == "" || firstname == "") || (surname.replace(/\s/g, "") == "" || surname == "") || (extno.replace(/\s/g, "") == "" || extno == "")) && (empid.replace(/\s/g, "") == "" || empid == "")){
				alert("Enter either EmployeeID or (Firstname, Surname & Extension Number) to auto fill");
			}else {
				var xmlFill = new XMLHttpRequest();
				xmlFill.onreadystatechange = function(){
					if (this.readyState == 4 && this.status == 200){
						//alert(xmlTBLfilter.responseText);
						var detailsJson = JSON.parse(xmlFill.responseText);
						if (detailsJson.length > 0) {
							
							var fname = String(detailsJson[0].FNAME).toLowerCase();
							fname = fname.charAt(0).toUpperCase() + fname.slice(1);
							var sname = String(detailsJson[0].SNAME).toLowerCase();
							sname = sname.charAt(0).toUpperCase() + sname.slice(1);
							var extnum = detailsJson[0].EXTNO;
							var empid = detailsJson[0].EMPNO;
							
							document.getElementById("fname").value = fname;
							document.getElementById("sname").value = sname;
							document.getElementById("caller").value = extnum;
							document.getElementById("emp_id").value = empid;
			
						}else {
							alert("Data not found! Please re-enter details");
						}
					}						
				};
				postData = "fname="+firstname+"&sname="+surname+"&extnum="+extno+"&empid="+empid;
				xmlFill.open("GET", "autofill.php?"+postData, true);
				xmlFill.send();
			}
		}
		function recentFill(){
			document.getElementById("fname").value = prev_fname;
			document.getElementById("sname").value = prev_sname;
			document.getElementById("caller").value = prev_ext_num;
			document.getElementById("emp_id").value = prev_emp_id;
			document.getElementById("date").value;
			document.getElementById("hard").value;
			document.getElementById("serNo").value;
			document.getElementById("options").value;
			document.getElementById("descript").value;
			document.getElementById("QuickSolution").value;
			document.getElementById("specialist").value = prev_;
			document.querySelector('input[name="pri_radio"]:checked').value = prev_priority;
			document.getElementById('i_resolve').value = prev_resolved;
		}
		function createLog(){
			var firstname = document.getElementById("fname").value;
			var surname = document.getElementById("sname").value;
			var ext_num = document.getElementById("caller").value;
			var empID = document.getElementById("emp_id").value;
			var initailD = document.getElementById("date").value;
			var now = new Date();
			if (initailD.replace(/\s/g, "") == "" || initailD.value == ""){
				now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
				initailD = now.toISOString().slice(0,16);
			}
				var p_date = initailD;
				p_date = p_date.slice(0, 16).replace('T', ' ');
				//alert("Date is: '" + p_date+"'");
			var hardware = document.getElementById("hard").value;
			var serialNo = document.getElementById("serNo").value;
			var software = document.getElementById("soft").value;
			var probType = document.getElementById("options").value;
			var description = document.getElementById("descript").value;
			var initialNotes = document.getElementById("QuickSolution").value;
			var specialist;
			
			var priority = document.querySelector('input[name="pri_radio"]:checked');
			var resolved = document.getElementById('i_resolve');
			
			if (document.getElementById("s_specialist").style.display == "block"){
				specialist = document.getElementById("s_specialist").value;
			}else if (document.getElementById("h_specialist").style.display == "block"){
				specialist = document.getElementById("h_specialist").value;
			}else if (document.getElementById("n_specialist").style.display == "block"){
				specialist = document.getElementById("n_specialist").value;
			}else if (document.getElementById("OS_specialist").style.display == "block"){
				specialist = document.getElementById("OS_specialist").value;
			}
			alert(specialist);
			
			//Validation of empty inputs
			var allValid = false;
			if (firstname.replace(/\s/g, "") == "" || firstname == ""){
				alert("First name field is empty");
			} else if (surname.replace(/\s/g, "") == "" || surname == ""){
				alert("Surname field is empty");
			} else if (ext_num.replace(/\s/g, "") == "" || ext_num == ""){
				alert("Extension number field is empty");
			} else if (empID.replace(/\s/g, "") == "" || empID == ""){
				alert("Employee number field is empty");
			} else if (initailD.replace(/\s/g, "") == "" || initailD == ""){
				alert("Enter a valid date");
			} else if ((serialNo != "") && (hardware.replace(/\s/g, "") == "" || hardware == "")){
				alert("Make sure the name for Hardware is entered for the correspondng Serial No.");
			} else if ((hardware.replace(/\s/g, "") == "" || hardware == "") && (software.replace(/\s/g, "") == "" || software == "")){
				alert("Please enter the software or hardware (or both) involved");
			} else if (probType == "all"){
				alert("Please Specify a Problem Type");
			} else if (description.replace(/\s/g, "") == "" || description == ""){
				alert("Please give the problem description");
			} else if (initialNotes.replace(/\s/g, "") == "" || initialNotes == ""){
				alert("Press the Quick Solution Button or Please type a solution");
			} else if (priority == null && resolved.checked == false){
				alert("Remember to Enter Priority");
			} else {
				
				if (priority == null){
					priority.value = "-";
				}
				
				/*alert("ALL GOOD" + firstname +" "+ surname +" "+ empID +" "+ p_date +" "+ hardware +" "+ software +" "+ probType +" "+ 
					initialNotes +" "+ specialist +" "+ priority +" "+ resolved);*/
					allValid = true;
					if (resolved.checked == true){
						var status = "true"
					} else {
						var status = "false"
					} 
			}
			
			if (allValid == true) {
				prev_fname = firstname;
				prev_sname = surname;
				prev_ext_num = ext_num;
				prev_emp_id = empID;
				prev_date = p_date;
				prev_hard = hardware;
				prev_soft = software;
				prev_serial = serialNo;
				prev_type = probType;
				prev_description = description;
				prev_sol = initialNotes;
				prev_priority = priority.value;
				prev_resolved = status;
				
				var xmlappendLog = new XMLHttpRequest();
				postData = "&empNo="+empID+"&iDate="+p_date+"&operID="+<?php echo $empno;?>
								+"&hardW="+hardware+"&softW="+software+"&pType="+probType+"&notes="+initialNotes+"&serNo="+serialNo
								+"&probDesc="+description+"&spect="+specialist+"&priority="+priority.value+"&status="+status;

				xmlappendLog.open("GET", "TBLappendLog.php?"+postData, true);
				xmlappendLog.send();
				alert("Done!!");
			}
		}
	</script>
	<table class="center mainTable">
	  <tr><!--Caller Subtitle-->
		<th class="mainTable widthS" style="text-align:left; padding-bottom:0px;" colspan="2"><b>Enter Caller Details:</b></th>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr style="background-color: #d8d4d4;"></td>
	  </tr>
	  <tr><!--First Name Deatils-->
		<td class="mainTable widthS"><label for="fname">First Name: </label></td>
		<td class="mainTable widthB"><input name="fname" type="text" id='fname' size="18" autocomplete="off" style="width:725px;" placeholder="First Name"/></td>
	  </tr>
	  <tr><!--Surname Details-->
		<td class="mainTable widthS"><label for="sname">Surname: </label></td>
		<td class="mainTable widthB"><input name="sname" type="text" id='sname' size="18" autocomplete="off"  style="width:725px;" placeholder="Surname"/></td>
	  </tr>
	</table>
	<table class="center mainTable" style="padding-top:0;margin-top:0;"> 
	<tr><!--Extension No and Emp ID-->
		<td class="mainTable widthS" style="width:255px;"><label for="caller">Extension Number:</label></td>
		<td class="mainTable widthS" style="text-align:left;"><input name="caller" type="number" id='caller' size="18" autocomplete="off" min="0" max="99999" style="width:250px;" placeholder="-----"/></td>
		
		<td class="mainTable widthS" style="width:257px;"><label for="emp_id">Employee No: </label></td>
		<td class="mainTable widthS" style="text-align:left;"><input name="emp_id" type="number" id='emp_id' size="18" autocomplete="off" min="1000" max="9999" style="width:202px;"  placeholder="0000"/></td>
	</tr></table>
	<table class="center mainTable" style="padding-top:0;margin-top:0;"> 
	<tr><!--Date Details-->
		<td class="mainTable widthS" style="width:255px;"><label for="date">Date: </label></td>
		<td class="mainTable widthS" style="text-align:left;"><input id="date" type="datetime-local" name="date" size="18" autocomplete="on" style="width:250px;" ></td>
		
		<td class="mainTable widthS" style="width:257px;"></td>
		<td class="mainTable widthS" style="text-align:left;">
			<button id = "autoFill" type="button" class="btn btn-info" style="width:80px; height:20px; font-size: 12px; line-height:0.6;" onclick="autoFill()">AutoFill</button>
			<button id = "recentFill" type="button" class="btn btn-info" style="width:80px; height:20px; font-size: 12px; line-height:0.6;" onclick="recentFill()">Recent</button>
		</td>
	</tr></table>
	<table class="center mainTable" style="padding-top:0;margin-top:0;">
	  <tr><!--Problem Subtitle-->
		<th class="mainTable widthS" style="text-align:left; padding-bottom:0px; padding-top:30px;" colspan="2"><b>Enter Problem Details:</b></th>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr style="background-color: #d8d4d4;"></td>
	  </tr>
	  <tr><!--Hardware Details-->
		<td class="mainTable widthS"><label for="hard">Hardware: </label></td>
		<td class="mainTable widthB"><input name="hard" type="text" id='hard' size="18" style="width:725px;"  placeholder="Name of Hardware"/></td>
	  </tr>
	  <tr><!--Serial No Details-->
		<td class="mainTable widthS"><label for="serNo">Serial No: </label></td>
		<td class="mainTable widthB"><input name="serNo" type="text" id='serNo' size="18" style="width:725px;"  placeholder="No.1234581 (Serial No)"/></td>
	  </tr>	  
	  <tr><!--Software Details-->
		<td class="mainTable widthS"><label for="soft">Software: </label></td>
		<td class="mainTable widthB"><input name="soft" type="text" id='soft' size="18" style="width:725px;" placeholder="Name of Software"/></td>
	  </tr>
	  <tr><!--List of Problems-->
		<td class="mainTable widthS"><label for="options">List of Problem Types:</label></td>
		<td class="mainTable widthB">
		<select id = "options" name = "options">
			<option value="all" selected hidden>Not Specified</option>
			<optgroup label = "Software">
			<option value="soft">General Software</option>
			<option value="word">Word</option>
			<option value="os">Operating System</option>
			<option value="mt">Microsoft Teams</option>
			</optgroup>
			<optgroup label = "Hardware">
			<option value="hard">General Hardware</option>
			<option value="key">Keyboard Issues</option>
			<option value="pc">PC Issues</option>
			<option value="mouse">Mouse Issues</option>
			<option value="print">Printer Issues</option>
			</optgroup>
			<optgroup label = "----------------">
			<option value="net">Network</option>
			</optgroup>
		</select>
		</td>
	  </tr>
	  <tr><!--Problem Description Details-->
		<td class="mainTable widthS" VALIGN=TOP><label for="descript">Problem Desciption:</label></td>
		<td class="mainTable widthB"><textarea rows="2" cols="78" id="descript" placeholder="Problem Description"></textarea></td>
	  </tr>
	  <tr><!--Solution Details-->
		<td class="mainTable widthS" VALIGN=TOP style="padding-top:12px;"><button id = "QuickButton" type="button" class="btn btn-info">Quick Solution</button></td>
		<td class="mainTable widthB"><textarea rows="2" cols="78" id="QuickSolution" autocomplete="off" placeholder="Notes for problem"></textarea></td>
		<script>
		document.getElementById("QuickSolution") //If '|' key is entered, send alert
			.addEventListener("keydown", function(event) {
			if (event.keyCode === 220) {
				alert("Unable to use the character '|', please select a different character");
				event.preventDefault();
			}
		});
		</script>
	  </tr>
	  <tr><!--List of Specialists-->
		<td class="mainTable widthS" VALIGN=TOP><label class = "specialists_area">List of Specialists:</label></td>
		<td class="mainTable widthB" placeholder="Specialists Available">
			<div class = "specialists_area">
				<div class="center">
				<select id = 'specialist' name = "specialist" class = "">
					<option value="default" disabled hidden>Select</option>
					
				</select>
				<select id = 's_specialist' name = "s_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
				<select id = 'h_specialist' name = "h_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
				<select id = 'n_specialist' name = "n_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
				<select id = 'OS_specialist' name = "n_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
				</div>
				<b>Specialists Available:</b>
				<div id = "SpecialistAvailability" class = ""></div>
			</div>

		</td>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr class="center" style="background-color: #000000; width:1000px;"></td>
	  </tr>
	  <tr><!--Priority Option-->
		<td class="specialistTable widthS" VALIGN=TOP><label for="spec">Priority: </label></td>
		<td class="specialistTable widthB">
			<table>
			<tr>
				<td style="padding:0px 10px;"><input name="pri_radio" type="radio" value="l_pri" style="padding:0;"/>⠀</td><td class="vaTOP" style="padding-right: 5em;">Low</td>
				<td style="padding:0px 10px;"><input name="pri_radio" type="radio" value="m_pri" style="padding:0;"/>⠀</td><td class="vaTOP" style="padding-right: 5em;">Medium</td>
				<td style="padding:0px 10px;"><input name="pri_radio" type="radio" value="h_pri" style="padding:0;"/>⠀</td><td class="vaTOP" style="padding-right: 5em;">High</td>
			</tr>
			</table>
		</td>
	  </tr>
	  <tr><!--Problem Resolved-->
		<td class="mainTable widthS" VALIGN=TOP style="width:1050px;">Problem resolved:</td>
		<td class="mainTable widthB" style="text-align:left; width:100px;">
			<input type="checkbox" id="i_resolve" name="i_resolve" style="width:20px;"/>
			Problem has been resolved
		</td>
	  </tr>
	  <tr><!--Create Log Button-->
		<td colspan="2" style="text-align: center; padding-top:20px;">
			<button id = "LogButton"  onclick="createLog();" type="button" class="btn btn-info">Create Log</button></td>
	  </tr>
	</table>
	
	
	<br>
	<div id = "probID" class = "txtCenter"></div>
	<div id = "tempLog" class = "txtCenter"></div>
</div>
<div id="mainUnresolved">
	<div id="errorMessage">
		<div >&nbsp;</div>
		<table id="alert" class="center font">
			<tr><td id="alertTable" rowspan="2" style="">
			</td>
			<td style="color:#c40000; font-size:19px;">
			  There was a problem
			</td></tr>
			<tr><td style="color:#000000; font-size:14px; padding-top:6px">
			  No problems with the corresponding problem ID was found.
			</td></tr>
		</table>
	</div>
	
	<div id="main_load">
		<div >&nbsp;</div>
		<button class="button center" onclick="hideButton()" type="submit" name="submitR" id="submitR" style="width:300px;">Load New Problem</button>
		<script>
			function hideButton() {
				document.getElementById("submitR").style.display = "none";
				document.getElementById("queryTable").style.display = "block";
			};
		</script>
		<div >&nbsp;</div>
		<table id="queryTable" class="center">
			<tr><td id="subtitle">Load Problem</td></tr>
			
			<tr><td><b>Enter Problem ID:</b></td></tr>
			<tr><td><input id="problem_id" name="problem_id" type="number" autofocus autocomplete="off" min = "0"></td></tr>
			
			<tr><td id="button"><button class="button" onclick="queryProblem()" type="submit" name="submit" id="submit" style="width:300px;">Load Details</button></td></tr>
			<script type="text/javascript">
				document.getElementById("problem_id") //If enter key pressed, then run button click function
					.addEventListener("keyup", function(event) {
					event.preventDefault();
					if (event.keyCode === 13) {
						document.getElementById("submit").click();
					}
				});
				

				function queryProblem() { //Load Problem function - If button clicked or enter key pressed, go to respective page
					var p_id = document.getElementById("problem_id").value;
					saved_p_id = p_id;
					//alert(p_id);
					var error = document.getElementById('errorMessage');
					
					var xmlLoad = new XMLHttpRequest();
					xmlLoad.onreadystatechange = function(){
						if (this.readyState == 4 && this.status == 200){
								
								var detailsJson = JSON.parse(xmlLoad.responseText);
								if (detailsJson.length > 0) {
									
									var test = document.getElementsByClassName("special_area")[0].style.visibility
									if (test == "visible"){
										document.getElementsByClassName("special_area")[0].style.visibility = "hidden";
										document.getElementsByClassName("special_area")[1].style.visibility = "hidden";
										document.getElementsByClassName("special_area")[2].style.visibility = "hidden";
										document.getElementsByClassName("special_area")[3].style.visibility = "hidden";
										document.getElementsByClassName("special_lost")[0].style.display = "block";
										document.getElementsByClassName("special_lost")[1].style.display = "";
									}
									
									
									var probid = detailsJson[0].PROBID;
									var intialdate = detailsJson[0].INITIALDATE;
									intialdate = alterDate(intialdate);
									var callname = detailsJson[0].FNAME.toLowerCase();
									callname = callname.charAt(0).toUpperCase() + callname.slice(1);
									
									var sname = detailsJson[0].SNAME.toLowerCase();
									sname = sname.charAt(0).toUpperCase() + sname.slice(1);
									var extno = detailsJson[0].EXTNO;
									
									var software = detailsJson[0].SOFTWARE;
									software = upperFirst(software);
									
						
									var hardware = detailsJson[0].HARDWARE;
									hardware = upperFirst(hardware);
										//alert(harware);
									var serialno = String(detailsJson[0].SERIALNO);
										//alert(serialno);
									var ptype = detailsJson[0].PROBTYPE;
									ptype = upperFirst(ptype);
									
									var pdesc = detailsJson[0].PROBDESCR;
									var notes = detailsJson[0].NOTES;
									var noteSplit = notes.split("|");
									
									var priority = detailsJson[0].PRIORITY;
									priority = upperFirst(priority);
									var status = detailsJson[0].STATUS;
									status = upperFirst(status);
									var dept = detailsJson[0].DEPT;
									
									document.getElementById("rPID").innerHTML = probid;
									document.getElementById("rCall").innerHTML = intialdate;
									document.getElementById("rDetails").innerHTML = callname + " " + sname + " from " + dept + ", ext " + extno;
									document.getElementById("rSoft").innerHTML = software;
									if (serialno == "-"){
										document.getElementById("rHard").innerHTML = hardware;
									}else{
										document.getElementById("rHard").innerHTML = hardware + " - " + serialno;
									}
									
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
									
									document.getElementById('submitR').style.display = "block";
									document.getElementById('queryTable').style.display = "none";
									document.getElementById('detailsTBL').style.display = "none";	
									document.getElementById("main_problem").style.display = "block";
									
									document.getElementById('main_problem').scrollIntoView({behavior: "smooth"});//scroll down to problem details
									error.style.display = 'none';
									
									document.getElementsByClassName("special_lost").style.display = "block";
									document.getElementsByClassName("special_area").style.visibility = "hidden";
														
									
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
	<div id="tableReload">
	<button class="button center" onclick="loadTable()" type="submit" name="btnReload" id="btnReload" style="width:300px;">Load Problem Table</button>
	</div>
	<script>
		function loadTable() {
			document.getElementById("main_problem").style.display = "none";
			document.getElementById("detailsTBL").style.display = "block";
			document.getElementById('detailsTBL').scrollIntoView({behavior: "smooth"});//scroll down to problem details
		};
	</script>
	<div >&nbsp;</div>
	<!--Load details for Problem-->
	<table class="center mainTable" id = "probTable">
	  <tr><!--Problem Subtitle-->
		<th class="mainTable widthS" style="font-size:23px; text-align:left; padding-bottom:0px;" colspan="2"><b>Problem Details:</b></th>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr style="background-color: #d8d4d4;"></td>
	  </tr>
	  <tr><!--Problem ID-->
		<td class="mainTable widthS">Problem ID:</td>
		<td class="mainTable widthB" id = "rPID">247</td>
	  </tr>
	  <tr><!--Call Time-->
		<td class="mainTable widthS">Call Time:</td>
		<td class="mainTable widthB" id = "rCall">Jan 15 2019,4.25pm</td>
	  </tr>
	  <tr><!--Caller Details-->
		<td class="mainTable widthS">Caller Details:</td>
		<td class="mainTable widthB" id = "rDetails">Alphonse E. from HR., ext 34562</td>
	  </tr>
	  <tr><!--Software-->
		<td class="mainTable widthS">Software:</td>
		<td class="mainTable widthB" id = "rSoft">Windows 10</td>
	  </tr>
	  <tr><!--Hardware-->
		<td class="mainTable widthS">Hardware:</td>
		<td class="mainTable widthB" id = "rHard">Lenovo Laptop</td>
	  </tr>
	  <tr><!--Problem Type-->
		<td class="mainTable widthS">Problem Type:</td>
		<td class="mainTable widthB" id = "rPT"></td>
	  </tr>
	  <tr><!--Problem Type-->
		<td class="mainTable widthS">Priority:</td>
		<td class="mainTable widthB" id = "rPri">PC Issues</td>
	  </tr>
	  <tr><!--Description-->
		<td class="mainTable widthS">Problem Description:</td>
		<td class="mainTable widthB" id = "rDesc">Running really slowly, not responding and often crashing</td>
	  </tr>
	  <tr><!--Notes-->
		<td class="mainTable widthS" style="vertical-align: top;">Notes:</td>
		<td class="mainTable widthB"><label id = "rNotes">TBD</label>
			<table id = "rNotesSplit">
				<col style="width:23%; text-align: right">
				<col style="width:77%">
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
	<!--Input to update unresolved problem TABLE-->
	<table class="center mainTable">
	  <tr><!--Solution Subtitle-->
		<th class="mainTable widthS" style="font-size:23px; text-align:left; padding-bottom:0px;" colspan="2"><b>Update Problem:</b></th>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr style="background-color: #d8d4d4;"></td>
	  </tr>
	  <tr class = "special_lost" style="width:1040px"><!--Problem Resolved-->
		<td class="mainTable widthS" VALIGN=TOP style="width:300px;">Problem resolved:</td>
		<td class="mainTable widthB" style="text-align:left; width:1000px;">
			<input type="checkbox" id="p_resolve" name="p_resolve" value = "RESOLVED" style="width:20px;">
			Problem has been resolved
		</td>
	  </tr>
	  <tr class = "special_lost" style="width:1040px"><!--Submit Button-->
		<td style="text-align:center; padding-right:39px;" colspan="2">
		<button class="button" type="submit" name="submitP" id="submitP" onclick = "updateProbRes()" style="width:200px;">Continue</button></td>
	  </tr>
	  <tr class = "special_area"><!--List of Specialists-->
		<td class="mainTable widthS" VALIGN=TOP>List Of Specialists:</td>
		<td class="mainTable widthB"><div id = "special_list"></div></td>
	  </tr>
	  <tr class = "special_area"><!--Choose Specialists-->
		<td class="mainTable widthS">Choose Specialist:</td>
		<td class="mainTable widthB">
			<div class="center">
				<select id = 's_specialist_' name = "s_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
				<select id = 'h_specialist_' name = "h_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
				<select id = 'n_specialist_' name = "n_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
				<select id = 'OS_specialist_' name = "n_specialist" class = "">
					<option value="auto">Auto</option>
					
				</select>
			</div>
		</td>
	  </tr>
	  <tr class = "special_area"><!--Priority Option-->
		<td class="specialistTable widthS" VALIGN=TOP><label>Priority: </label></td>
		<td class="specialistTable widthB">
			<table>
			<tr>
				<td style="padding:0px 10px;"><input name="pri_radio_update" type="radio" value="LOW" style="padding:0;"/>⠀</td><td class="vaTOP" style="padding-right: 5em;">Low</td>
				<td style="padding:0px 10px;"><input name="pri_radio_update" type="radio" value="MEDIUM" style="padding:0;"/>⠀</td><td class="vaTOP" style="padding-right: 5em;">Medium</td>
				<td style="padding:0px 10px;"><input name="pri_radio_update" type="radio" value="HIGH" style="padding:0;"/>⠀</td><td class="vaTOP">High</td>
			</tr>
			</table>
		</td>
	  </tr>
	  <tr class = "special_area"><!--Submit Button-->
		<td style="text-align:center; padding-right:39px;" colspan="2">
		<button class="button" type="submit" name="submitP" id="submitII" style="width:200px;" onclick = "updateProb()">Continue</button></td>
	  </tr>
	</table>
	</div>
	
	</div>

	<script>
	function updateProbRes(){
		var checked = document.querySelector('input[name="p_resolve"]:checked');
		
		
		if (checked.value == "RESOLVED"){
			var now = new Date();
			now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
			now = now.toISOString().slice(0,16);
			now = now.slice(0, 16).replace('T', ' ');
			var spec_id = 0;
			var problemID = saved_p_id;
			var op_id = <?php echo $empno;?>;
			var upStatus = checked.value;
			var upPriority = "-";
			var notes_date = alterDate(now);
			var notes = notes_date + " ~ After the most recent solution, the problem has been solved";
			var data = "prob=" + problemID + "&specialist=" + spec_id + "&operator=" + op_id + "&status=" + upStatus + "&date=" +
						now + "&notes=" + notes + "&priority=" + upPriority;
			
			var xmlResolvedProb = new XMLHttpRequest();
			xmlResolvedProb.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200){
					alert(this.responseText);
				}
			}
			xmlResolvedProb.open("GET", "updateTBL.php?" + data, true);
			xmlResolvedProb.send();
			
		}
			
		
		
	}
	function updateProb(){
		var prior = document.querySelector('input[name="pri_radio_update"]:checked');
		
		var s_vis = document.getElementById("s_specialist_").style.display;
		var h_vis = document.getElementById("h_specialist_").style.display;
		var n_vis = document.getElementById("n_specialist_").style.display;
		var os_vis = document.getElementById("OS_specialist_").style.display;
		var now = new Date();
		now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
		now = now.toISOString().slice(0,16);
		now = now.slice(0, 16).replace('T', ' ');
		var notes_date = alterDate(now);
		var problemID = saved_p_id;
		var op_id = <?php echo $empno;?>;
		var status = "UNRESOLVED";
		//alert(h_vis);
		if (prior == null){
			prior = "-";
		} else {
			prior = prior.value;
		}
		//alert(prior);
		if (s_vis == "block"){
			var spec = document.getElementById("s_specialist_").value;
			var sel = document.getElementById("s_specialist_");
			var text = sel.options[sel.selectedIndex].text;
			var notes = notes_date + " ~ After the most recent solution, The issue has been passed to " + text;
			if (spec == "auto"){
				<?php
					include "team017-mysql-connect.php";
					
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					$sql = "SELECT EMPNO
							FROM specialist
							WHERE JOBSUM = (SELECT MIN(JOBSUM) FROM specialist) AND EXPERTISE = 'SOFTWARE'";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$data = implode($row); 
					}			
				?>;
				spec = <?php echo $data ?>;
				alert(spec);
			}
			
			alert(notes);
		}else if (h_vis == "block"){
			var spec = document.getElementById("h_specialist_").value;
			var sel = document.getElementById("h_specialist_");
			var text = sel.options[sel.selectedIndex].text;
			var notes = notes_date + " ~ After the most recent solution, The issue has been passed to " + text;
			if (spec == "auto"){
				notes = notes_date + " ~ After the most recent solution, The issue has been automatically assigned to a specialist";
				<?php
					include "team017-mysql-connect.php";
					
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					$sql = "SELECT EMPNO
							FROM specialist
							WHERE JOBSUM = (SELECT MIN(JOBSUM) FROM specialist) AND EXPERTISE = 'HARDWARE'";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$data = implode($row); 
					}			
				?>;
				spec = <?php echo $data ?>;
				alert(spec);
			}
			alert(notes);
		}else if (n_vis == "block"){
			var spec = document.getElementById("n_specialist_").value;
			var sel = document.getElementById("n_specialist_");
			var text = sel.options[sel.selectedIndex].text;
			var notes = notes_date + " ~ After the most recent solution, The issue has been passed to " + text;
			if (spec == "auto"){
				notes = notes_date + " ~ After the most recent solution, The issue has been automatically assigned to a specialist";
				<?php
					include "team017-mysql-connect.php";
					
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					$sql = "SELECT EMPNO
							FROM specialist
							WHERE JOBSUM = (SELECT MIN(JOBSUM) FROM specialist) AND EXPERTISE = 'NETWORK'";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$data = implode($row); 
					}			
				?>;
				spec = <?php echo $data ?>;
				alert(spec);
			}
			alert(notes);
		}else {
			var spec = document.getElementById("OS_specialist_").value;
			var sel = document.getElementById("OS_specialist_");
			var text = sel.options[sel.selectedIndex].text;
			var notes = notes_date + " ~ After the most recent solution, The issue has been passed to " + text;
			if (spec == "auto"){
				notes = notes_date + " ~ After the most recent solution, The issue has been automatically assigned to a specialist";
				<?php
					include "team017-mysql-connect.php";
					
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					$sql = "SELECT EMPNO
							FROM specialist
							WHERE JOBSUM = (SELECT MIN(JOBSUM) FROM specialist) AND (EXPERTISE = 'OPERATING SYSTEM' OR EXPERTISE = 'SOFTWARE')";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$data = implode($row); 
					}			
				?>;
				spec = <?php echo $data ?>;
				alert(spec);
			}
			alert(notes);
		}
		
		var data = "prob=" + problemID + "&specialist=" + spec + "&operator=" + op_id + "&status=" + status + "&date=" +
					now + "&notes=" + notes + "&priority=" + prior;
		
		var xmlPassingProb = new XMLHttpRequest();
		xmlPassingProb.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				alert(this.responseText);
			}
		}
		xmlPassingProb.open("GET", "updateTBL.php?" + data, true);
		xmlPassingProb.send();
		

	}
	</script>
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
						//var probDesc = String(detailsJson[i].PROBDESCR);
						//var notes = String(detailsJson[i].NOTES);
						//var initialDate = String(detailsJson[i].INITIALDATE);
						//var updateDate = String(detailsJson[i].UPDATEDATE);
						
						var cell1 = row.insertCell(0);
						var cell2 = row.insertCell(1);
						var cell5 = row.insertCell(2);
						var cell6 = row.insertCell(3);
						var cell7 = row.insertCell(4);
						var cell3 = row.insertCell(5);
						var cell4 = row.insertCell(6);
						//var cell8 = row.insertCell(7);
						//var cell9 = row.insertCell(8);
						//var cell10 = row.insertCell(9);
						//var cell11 = row.insertCell(10);
						
						cell1.innerHTML = pID;
						cell2.innerHTML = pType;
						cell3.innerHTML = sName;
						cell4.innerHTML = priority;
						cell5.innerHTML = software;
						cell6.innerHTML = hardware;
						cell7.innerHTML = serialNo;
						//cell8.innerHTML = probDesc;
						//cell9.innerHTML = notes;
						//cell10.innerHTML = initialDate;
						//cell11.innerHTML = updateDate;
						
						cell1.className = 'tableWidth';
						cell2.className = 'tableWidth';
						cell3.className = 'tableWidth';
						cell4.className = 'tableWidth';
						cell5.className = 'tableWidth';
						cell6.className = 'tableWidth';
						cell7.className = 'tableWidth';
						//cell8.className = 'tableWidth';
						//cell9.className = 'tableWidth';
						//cell10.className = 'tableWidth';
						//cell11.className = 'tableWidth';
					};
				}						
			}
		};
		xmlTBL.open("GET", "TBLproblem.php", true);
		xmlTBL.send();
		
		var specialist_names = JSON.parse(<?php echo json_encode($specName); ?>);
		var specialist_ids = JSON.parse(<?php echo json_encode($specID); ?>);
		var specialist_jobsum = JSON.parse(<?php echo json_encode($specJobs); ?>);
		var specialist_expertise = JSON.parse(<?php echo json_encode($specPT); ?>);
		//var name = JSON.parse(specialist_names);
		//alert(specialist_names[0]);
		for (let i = 0; i < specialist_names.length; i++) {
			var all_s_add = document.getElementById("specialist");
			var option = document.createElement("OPTION");
			option.innerHTML = specialist_names[i];
			option.value = specialist_ids[i];
			all_s_add.options.add(option);
			if (specialist_expertise[i] == "SOFTWARE"){
				var soft_s_add = document.getElementById("s_specialist");
				//var soft_s_add1 = document.getElementById("s_specialist_");
				var soft_option = document.createElement("OPTION");
				soft_option.innerHTML = specialist_names[i];
				soft_option.value = specialist_ids[i];
				soft_s_add.options.add(soft_option);
				//soft_s_add1.options.add(soft_option);
			}
			if (specialist_expertise[i] == "HARDWARE"){
				var hard_s_add = document.getElementById("h_specialist");
				//var hard_s_add1 = document.getElementById("h_specialist_");
				var hard_option = document.createElement("OPTION");
				hard_option.innerHTML = specialist_names[i];
				hard_option.value = specialist_ids[i];
				hard_s_add.options.add(hard_option);
				//hard_s_add1.options.add(hard_option);
			}
			if (specialist_expertise[i] == "NETWORK"){
				var net_s_add = document.getElementById("n_specialist");
				//var net_s_add1 = document.getElementById("n_specialist_");
				var net_option = document.createElement("OPTION");
				net_option.innerHTML = specialist_names[i];
				net_option.value = specialist_ids[i];
				net_s_add.options.add(net_option);
				//net_s_add1.options.add(net_option);
			}
			if (specialist_expertise[i] == "OPERATING SYSTEM" || specialist_expertise[i] == "SOFTWARE"){
				var os_s_add = document.getElementById("OS_specialist");
				//var os_s_add1 = document.getElementById("OS_specialist_");
				var os_option = document.createElement("OPTION");
				os_option.innerHTML = specialist_names[i];
				os_option.value = specialist_ids[i];
				os_s_add.options.add(os_option);
				//os_s_add1.options.add(os_option);
			}
		}
		
		for (let i = 0; i < specialist_names.length; i++) {
			var all_s_add = document.getElementById("specialist");
			var option = document.createElement("OPTION");
			option.innerHTML = specialist_names[i];
			option.value = specialist_ids[i];
			all_s_add.options.add(option);
			if (specialist_expertise[i] == "SOFTWARE"){
				var soft_s_add = document.getElementById("s_specialist_");
				var soft_option = document.createElement("OPTION");
				soft_option.innerHTML = specialist_names[i];
				soft_option.value = specialist_ids[i];
				soft_s_add.options.add(soft_option);
				
			}
			if (specialist_expertise[i] == "HARDWARE"){
				var hard_s_add = document.getElementById("h_specialist_");
				var hard_option = document.createElement("OPTION");
				hard_option.innerHTML = specialist_names[i];
				hard_option.value = specialist_ids[i];
				hard_s_add.options.add(hard_option);
			}
			if (specialist_expertise[i] == "NETWORK"){
				var net_s_add = document.getElementById("n_specialist_");
				var net_option = document.createElement("OPTION");
				net_option.innerHTML = specialist_names[i];
				net_option.value = specialist_ids[i];
				net_s_add.options.add(net_option);
			}
			if (specialist_expertise[i] == "OPERATING SYSTEM" || specialist_expertise[i] == "SOFTWARE"){
				var os_s_add = document.getElementById("OS_specialist_");
				var os_option = document.createElement("OPTION");
				os_option.innerHTML = specialist_names[i];
				os_option.value = specialist_ids[i];
				os_s_add.options.add(os_option);
			}
		}
	});
	
	
	
	</script>
	<div id="detailsTBL">
		<button id="btnAdvanced" class="button center" onclick="openPopUp()">Hit Me to Add advanced options</button>
		<div >&nbsp;</div>
		<div >&nbsp;</div>
		
		<table class="center" style="width:70%" id = "probDetails">
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
	</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>
	<div >&nbsp;</div>

		
</div>
<div id="mainExt">
	<div >&nbsp;</div>
	<script>
	function addSpec2DB(){
		var specFName = document.getElementById("specfName").value;
		var specSName = document.getElementById("specsName").value;
		var specEMail = document.getElementById("email").value;
		var specPhoneNo = document.getElementById("tele").value.replaceAll(" ", "");;
		var specSpecialty = document.getElementById("optSpec").value;
		var specDur = document.querySelector('input[name="optradio"]:checked');
		var validEmail = validateEmail(specEMail);
		
		if ((specFName.replace(/\s/g, "") == "" || specFName == "")
			|| (specSName.replace(/\s/g, "") == "" || specSName == "") 
			|| (specEMail.replace(/\s/g, "") == "" || specEMail == "")
			|| (specSpecialty == "all")
			|| (validEmail == false)
			|| (specPhoneNo.replace(/\s/g, "") == "" || specPhoneNo == "" || isNaN(specPhoneNo) == true || specPhoneNo.length != 11)
			|| (specDur == null)){
			alert("Please check that all details are entered correctly!");
		} else {
			var xmlappendSpec = new XMLHttpRequest();
			postData = "fName="+specFName+"&sName="+specSName+"&eMail="+specEMail+"&phoneNo="+
							specPhoneNo+"&specialty="+specSpecialty+"&duration="+specDur.value;

			xmlappendSpec.open("GET", "TBLappendSpecialist.php?"+postData, true);
			xmlappendSpec.send();
			alert("Done!!");
		}
	}
	
	function validateEmail(email) 
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
	</script>
	<table class="center specialistTable">
	  <tr><!--Specialist Subtitle-->
		<th class="specialistTable widthS" style="text-align:left; padding-bottom:0px;" colspan="2"><b>Specialist Details:</b></th>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr style="background-color: #d8d4d4;"></td>
	  </tr>
	  <tr><!--Specialist FName Deatils-->
		<td class="specialistTable widthS"><label for="fname">External Specialist First Name: </label></td>
		<td class="specialistTable widthB"><input name="fname" class="extSpec" type="text" id='specfName' size="18" autocomplete="off" style="width:725px;" placeholder="First Name"/></td>
	  </tr>
	  <tr><!--Specialist SName Deatils-->
		<td class="specialistTable widthS"><label for="sname">External Specialist Surname: </label></td>
		<td class="specialistTable widthB"><input name="sname" class="extSpec" type="text" id='specsName' size="18" autocomplete="off" style="width:725px;" placeholder="Surname"/></td>
	  </tr>
	  <tr><!--Specialist Email-->
		<td class="specialistTable widthS"><label for="email">External Specialist Email: </label></td>
		<td class="specialistTable widthB"><input name="email" class="extSpec" type="email" id='email' size="18" autocomplete="off" style="width:725px;" placeholder="Email"/></td>
	  </tr>
	  <tr><!--Specialist Number-->
		<td class="specialistTable widthS"><label for="tele">Phone number: </label></td>
		<td class="specialistTable widthB"><input name="tele" class="extSpec" type="text" id='tele' size="18" autocomplete="off" style="width:725px;" placeholder="Number"/></td>
	  </tr>
	  <tr><!--Specialty Type-->
		<td class="specialistTable widthS"><label for="spec">Problem Specialty: </label></td>
		<td class="specialistTable widthB">
		<select id = "optSpec" name = "options" class="extSpec">
			<option value="all" selected hidden>Not Specified</option>
			<optgroup label = "Software">
			<option value="soft">General Software</option>
			<option value="word">Word</option>
			<option value="os">Operating System</option>
			<option value="mt">Microsoft Teams</option>
			</optgroup>
			<optgroup label = "Hardware">
			<option value="hard">General Hardware</option>
			<option value="key">Keyboard Issues</option>
			<option value="pc">PC Issues</option>
			<option value="mouse">Mouse Issues</option>
			<option value="print">Printer Issues</option>
			</optgroup>
			<optgroup label = "----------------">
			<option value="net">Network</option>
			</optgroup>
		</select>
		</td>
	  </tr>
	  <tr><!--Specialist Name Deatils-->
		<td class="specialistTable widthS" VALIGN=TOP><label for="spec">Duration: </label></td>
		<td class="specialistTable widthB">
			<label class="radio-inline"><input name="optradio" type="radio" value="One-off"/>One-off</label><br>
			<label class="radio-inline"><input name="optradio" type="radio" value="3 weeks"/>3 weeks</label>		
		</td>
	  </tr>
	  <tr><!--Horizontal Rule-->
		<td colspan="2"><hr class="center" style="background-color: #000000; width:1050px;"></td>
	  </tr>
	  <tr><!--Button-->
		<td class="specialistTable txtCenter" colspan="2">
		<button id = "createButton" onclick="addSpec2DB()" type="button" class="btn btn-info">Create Specialist</button>
		</td>
	  </tr>
	</table>
	<div >&nbsp;</div>
	<div id = "logSpecial" class = "txtCenter"></div>
	<div >&nbsp;</div><div >&nbsp;</div><div >&nbsp;</div><div >&nbsp;</div>
</div>
<div id="footer">
	<br><hr><br>
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
