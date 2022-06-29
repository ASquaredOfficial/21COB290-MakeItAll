<?php

//SQL MySQLi Procedural Method
include "team017-mysql-connect.php"; 

	
	$empno = $_GET["empNo"];
	$operID= $_GET["operID"];
	$specNm= $_GET["spect"];
	$hardW = $_GET["hardW"];
	$serialNo = $_GET["serNo"];
	$softW = $_GET["softW"];
	$probType = $_GET["pType"];
	$probDesc = $_GET["probDesc"];
	$probNotes= $_GET["notes"];
	$probDate = $_GET["iDate"];
	$priority = $_GET["priority"];
	$status = $_GET["status"];
	
// connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
//Check if serial no was entered	
	
	
	
//Standardise empty strings to match database if nothing selected
	if ($specID == ""){
		$specID = "-";
	} if ($hardW == ""){
		$hardW = "-";
	} if ($softW == ""){
		$softW = "-";
	} if ($serialNo == ""){
		$serialNo = "-";
	} 
	
//Standardise duration string to match database	
	if ($priority == "h_pri"){
		$priority = "HIGH";
	} elseif ($priority == "m_pri"){
		$priority = "MEDIUM";
	} elseif ($priority == "l_pri"){
		$priority = "LOW";
	} else {
		$priority = "-";
	}

//Standardise resolved status to match database	
	if ($status == "true"){
		$status = "RESOLVED";
		$priority = "-";
	} elseif ($status == "false") {
		$status = "UNRESOLVED";
	}
	
//Standardise the specialty value to the DB
	if ($probType == "soft"){
		$probType = "SOFTWARE";
	} elseif ($probType == "word"){
		$probType = "MICROSOFT WORD";
	} elseif ($probType == "os"){
		$probType = "OPERATING SYSTEM";
	} elseif ($probType == "mt"){
		$probType = "MICROSOFT TEAMS";
	} elseif ($probType == "hard"){
		$probType = "HARDWARE";
	} elseif ($probType == "key"){
		$probType = "KEYBOARD ISSUES";
	} elseif ($probType == "pc"){
		$probType = "PC ISSUES";
	} elseif ($probType == "mouse"){
		$probType = "MOUSE ISSUES";
	} elseif ($probType == "print"){
		$probType = "PRINTER ISSUES";
	} elseif ($probType == "net"){
		$probType = "NETWORK";
	}
	
//Generate unique Problem ID
	$ProbID = 100; //Problem IDs start at 100
	while (true) {
		$sql = "SELECT `PROBID`
				FROM `log`
				WHERE `PROBID`= $ProbID";
		
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0){
			//If there exists a row where the ProbID exist then add 1
			$ProbID = $ProbID + 1;
			echo $ProbID."<br>";
		}
		else {
			break;
		}
	}//echo $ProbID;

//Add new specialist to both tables using SQL statements
	//Add to LOG Table
	$sql = "INSERT 
			INTO `log`(`EMPNO`, `OPERATORID`, `SPECIALISTID`, `PROBID`, `HARDWARE`, `SOFTWARE`, `SERIALNO`, `PROBTYPE`, `PROBDESCR`, `NOTES`, `INITIALDATE`, `UPDATEDDATE`, `PRIORITY`, `STATUS`) 
			VALUES ('$empno','$operID','$specID','$ProbID','$hardW','$softW','$serialNo','$probType','$probDesc','$probNotes','$probDate','$probDate','$priority','$status');";
			//echo $sql."<br>";

	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully in 'log' table"."<br>";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
	}
	
mysqli_close($conn);
?>
