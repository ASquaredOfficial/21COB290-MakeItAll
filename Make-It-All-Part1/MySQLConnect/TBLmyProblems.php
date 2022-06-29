<?php


include "team017-mysql-connect.php"; 

	$empno = $_GET["empno"];
	
// connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
/* Task 2: Declare $sql string to select venue names and their capacity from venue table where capacity is equal or greater than the value that the user has requested, order by capacity descending */
	$sql = "SELECT PROBID, PROBTYPE, HARDWARE, SOFTWARE, SERIALNO, CASE
				WHEN (l.SPECIALISTID > 1000 AND l.SPECIALISTID < 1100) THEN e.FNAME
				WHEN (l.SPECIALISTID > 9000 AND l.SPECIALISTID < 9999) THEN s.FNAME
			END AS FNAME, PRIORITY
			FROM log l
				LEFT OUTER JOIN employee e ON l.SPECIALISTID = e.EMPNO
				LEFT OUTER JOIN extspecialist s ON l.SPECIALISTID = s.TEMPNO
			WHERE (s.TEMPNO IS NOT null OR e.EMPNO IS NOT null)
			AND e.EMPNO = '$empno'
			AND STATUS = 'UNRESOLVED'
			ORDER BY INITIALDATE DESC";
 

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
