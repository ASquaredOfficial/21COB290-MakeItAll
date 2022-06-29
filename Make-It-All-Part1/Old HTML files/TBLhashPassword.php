<?php

//SQL MySQLi Procedural Method
include "team017-mysql-connect.php"; 
	
	$username1 = "alice101"; //$_GET["user"];
	$password1 = "lovetohelp";//$_GET["pass"];
	
// connect to database 
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

/*	
//Generate hashed passwords to database
	$sql = "SELECT PASSWORD, EMPNO
			FROM `userpass`";
	
	$result = mysqli_query($conn, $sql); 
	$allDataArray = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$allDataArray[] = $row;
		$empno = $row['EMPNO'];
		$passw = $row['PASSWORD'];
		$pass = password_hash($passw, PASSWORD_BCRYPT); //Salt and hashed password
		
		
		$sql2= "UPDATE `userpass`
				SET hashedPassword = '$pass'
				WHERE EMPNO = '$empno'";
		
		if (mysqli_query($conn, $sql2)) {
		  echo "Nice - ".$pass."<br>" ;
//		  record created successfully in 'userpass' table"."<br>";
		} else {
		  echo "Error: " . $sql2 . "<br>" . mysqli_error($conn)."<br>";
		}		
				
	}
	//$value = json_encode($allDataArray);
	//echo $value;
*/
//Verify password	
	echo "<br><br>";
	$sql = "SELECT FNAME, USERNAME, PASSWORD, employee.EMPNO, JOBTITLE, HPASSWORD
			FROM employee INNER JOIN userpass
			WHERE employee.EMPNO = userpass.EMPNO AND USERNAME = '$username1'";
	
	$result = mysqli_query($conn, $sql); 
	$allDataArray = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$allDataArray[] = $row;
		$allDataArray[] = array( password_verify($password1, $row['HPASSWORD']) =>  "PASSHASH",);
		//echo $row['FNAME']."<br>";
		//$passVerify = password_verify($password1, $row['HPASSWORD']);
	}
	//echo $passVerify."<br>";
	
	//$smth = '{"PASSHASH":$passVerify}';
	//$allDataArray[] = $smth;
	$value = json_encode($allDataArray);
	echo $value;
	
mysqli_close($conn);
?>
