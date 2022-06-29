<?php

//SQL MySQLi Procedural Method
include "team017-mysql-connect.php"; 
	
	$empno = $_GET["empNo"];
	
//Connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

//Verify password
	$sql = "UPDATE `userpass` 
			SET `CONNECT`='OFFLINE' 
			WHERE `EMPNO` = '$empno'";
	
	
//Get the table via sql query
	$result = mysqli_query($conn, $sql); 
	if(mysqli_query($conn, $sql)){
		echo "Successfully Signed Out";
	}
	
mysqli_close($conn);
?>
