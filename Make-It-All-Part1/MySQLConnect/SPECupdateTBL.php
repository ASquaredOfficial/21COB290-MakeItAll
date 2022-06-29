<?php


include "team017-mysql-connect.php"; 

	$p_id = $_GET["prob"];
	$s_id = $_GET["specialist"];
	$status = $_GET["status"];
	$date = $_GET["date"];
	$note = $_GET["notes"];
	$priority = $_GET["priority"];
	
// connect to database	
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT NOTES
			FROM log
			WHERE PROBID = '$p_id'";
 
	$result = mysqli_query($conn, $sql);
	$i = 0; 
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$data = implode($row); 
	}
	
	$full_notes = $data . "| ". $note;
	
	
	if ($status == "RESOLVED"){
		//If status is being updated and resolved
		$sql = "UPDATE log
				SET UPDATEDDATE = '$date', 
					NOTES = '$full_notes', 
					STATUS = '$status', 
					PRIORITY = '$priority'
				WHERE PROBID = '$p_id'";
	}else {
		//If status is being updated but not resolved
		$sql = "UPDATE log
				SET	SPECIALISTID = '$s_id', 
					UPDATEDDATE = '$date', 
					NOTES = '$full_notes', 
					PRIORITY = '$priority'
				WHERE PROBID = '$p_id'";
	}
	
	//echo $sql;
 

/* get all the rows and output it as a JSON */
	$result = mysqli_query($conn, $sql); 
	
	
	if(mysqli_query($conn, $sql)){
		echo "Successfully Updated";
	}
	
mysqli_close($conn);
?>