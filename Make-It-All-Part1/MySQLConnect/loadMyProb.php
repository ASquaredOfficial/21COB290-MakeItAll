<?php

include "team017-mysql-connect.php"; 

	$id = $_GET["id"];
	
//Connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
//Get the problem details needed for the table
	$sql = "SELECT PROBID,INITIALDATE, employee.FNAME, employee.SNAME, 
				employee.EXTNO, department.DEPT, SOFTWARE, HARDWARE, SERIALNO, PROBTYPE, 
				PROBDESCR, NOTES, PRIORITY, STATUS
			FROM log 
				LEFT OUTER JOIN employee ON log.EMPNO = employee.EMPNO
				LEFT OUTER JOIN department ON employee.EXTNO = department.EXTNO
			WHERE PROBID = '$id'
			AND STATUS = 'UNRESOLVED'";

	$result = mysqli_query($conn, $sql); 
	$allDataArray = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$allDataArray[] = $row;
	}
	$value = json_encode($allDataArray);
	echo $value;
	
mysqli_close($conn);
?>