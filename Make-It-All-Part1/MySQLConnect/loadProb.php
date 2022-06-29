<?php


include "team017-mysql-connect.php"; 

	$id = $_GET["id"];
	
// connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
/* Task 2: Declare $sql string to select venue names and their capacity from venue table where capacity is equal or greater than the value that the user has requested, order by capacity descending */
	$sql = "SELECT PROBID,INITIALDATE, employee.FNAME, employee.SNAME, 
				employee.EXTNO, department.DEPT, SOFTWARE, HARDWARE, SERIALNO, PROBTYPE, 
				PROBDESCR, NOTES, PRIORITY, STATUS
			FROM log 
				LEFT OUTER JOIN employee ON log.EMPNO = employee.EMPNO
				LEFT OUTER JOIN department ON employee.EXTNO = department.EXTNO
			WHERE PROBID = '$id'";
 

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