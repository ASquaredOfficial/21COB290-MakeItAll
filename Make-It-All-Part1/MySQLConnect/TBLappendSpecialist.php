<?php

//SQL MySQLi Procedural Method
include "team017-mysql-connect.php"; 

	$fName = strtoupper($_GET["fName"]);
	$sName = strtoupper($_GET["sName"]);
	$eMail = strtolower($_GET["eMail"]);
	$phoneNo = (int)($_GET["phoneNo"]);
	$specialty = $_GET["specialty"];
	$duration = $_GET["duration"];
	
// connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

//Standardise duration string to match database	
	if ($duration == "One-off"){
		$dur = "TEMP1O";
	} elseif ($duration == "3 weeks"){
		$dur = "TEMP3W";
	}
	
//Standardise the key to the DB
	if ($specialty == "soft"){
		$specialty = "SOFTWARE";
	} elseif ($specialty == "word"){
		$specialty = "MICROSOFT WORD";
	} elseif ($specialty == "os"){
		$specialty = "OPERATING SYSTEM";
	} elseif ($specialty == "mt"){
		$specialty = "MICROSOFT TEAMS";
	} elseif ($specialty == "hard"){
		$specialty = "HARDWARE";
	} elseif ($specialty == "key"){
		$specialty = "KEYBOARD ISSUES";
	} elseif ($specialty == "pc"){
		$specialty = "PC ISSUES";
	} elseif ($specialty == "mouse"){
		$specialty = "MOUSE ISSUES";
	} elseif ($specialty == "print"){
		$specialty = "PRINTER ISSUES";
	} elseif ($specialty == "net"){
		$specialty = "NETWORK";
	}

//Generate unique Temporary Employee Number
	$Tempno = 9000; //Temp EMPNOs are between 9000-9999
	while (true) {
		$sql = "SELECT TEMPNO
				FROM `extspecialist`
				WHERE TEMPNO = $Tempno";
		
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0){
			//If there exists a row where the TEMPNO matches then add 1
			$Tempno = $Tempno + 1;
			//echo $Tempno."<br>";
		}
		else {
			break;
		}
	}//echo $Tempno;

//Add new specialist to both tables using SQL statements
	//Add to EXTSPECIALIST Table
	$sql = "INSERT 
			INTO `extspecialist`(`TEMPNO`, `FNAME`, `LNAME`, `PHONENO`, `EMAIL`) 
			VALUES ('$Tempno','$fName','$sName','$phoneNo','$eMail');";
			//echo $sql."<br>";
	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully in 'extspecialist' table"."<br>";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
	}
	
	//Add to SPECIALIST Table
	$sql = "INSERT INTO `specialist`(`EMPNO`, `EXPERTISE`, `JOBSUM`, `EMPTYPE`) 
			VALUES ('$Tempno','$specialty','0','$dur');";
			//echo $sql."<br>";
	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully in 'specialist' table"."<br>";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";		
	}		
	
mysqli_close($conn);
?>
