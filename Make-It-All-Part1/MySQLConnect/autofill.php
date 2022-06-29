<?php


include "team017-mysql-connect.php"; 

	$fname = $_GET["fname"];
	$sname = $_GET["sname"];
	$extnum = $_GET["extnum"];
	$empid = $_GET["empid"];	
	
//Connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	if ($empid != ""){
		$sql = "SELECT FNAME, SNAME, EXTNO, EMPNO 
				FROM employee 
				WHERE EMPNO = '$empid'"; 
	}
	else if ($empid == "" && $fname != "" && $sname != "" && $extnum != "") {
		$sql = "SELECT FNAME, SNAME, EXTNO, EMPNO 
				FROM employee
				WHERE FNAME = '$fname' 
				AND SNAME = '$sname' AND EXTNO = '$extnum'"; 
	}
	
	//echo $sql;

/* get all the rows and output it as a JSON */
	$result = mysqli_query($conn, $sql); 
	$allDataArray = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$allDataArray[] = $row;
	}
	$value = json_encode($allDataArray);
	echo $value;

mysqli_close($conn);
?>