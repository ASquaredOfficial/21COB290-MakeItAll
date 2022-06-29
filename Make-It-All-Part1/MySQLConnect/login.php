<?php

//SQL MySQLi Procedural Method
include "team017-mysql-connect.php"; 
	
	$username1 = $_GET["user"];
	$password1 = $_GET["pass"];
	
//Connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

//Verify password
	$sql = "SELECT FNAME, USERNAME, employee.EMPNO AS EMPNO, JOBTITLE, HPASSWORD
		FROM employee INNER JOIN userpass
		WHERE employee.EMPNO = userpass.EMPNO AND USERNAME = '$username1'";
	
	
//Get the table via sql query
	$result = mysqli_query($conn, $sql); 
	$allDataArray = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$allDataArray[] = $row;
		$allDataArray[] = array("PASSHASH" =>  password_verify($password1, $row['HPASSWORD']) ,);
		
		if (password_verify($password1, $row['HPASSWORD'])){
			$sql2= "UPDATE `userpass` 
					SET `CONNECT`='ONLINE'
					WHERE `USERNAME` = '$username1'";
					
			mysqli_query($conn, $sql2); 
		}
			
			
	}
	$value = json_encode($allDataArray);
	echo $value;
	
	
	
mysqli_close($conn);
?>
