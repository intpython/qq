<?php
	$DBname = "phpmyadmin";
	$conn = mysqli_connect("localhost","phpmyadmin","12345678");

	if(!$conn) {
		die("Connection fail\n");
	}
	else
		print ("Connection successful\n");


	if(!mysqli_select_db($conn,$DBname)){
		die ("Select fail\n");
	}
	else
		print ("Select successful\n");

	$sql = "INSERT INTO test (username,passwd) VALUES ('test','test123')";
	
	if($conn->query($sql)===TRUE)
		print("inserted successful\n");
	else
		print("inserted fail\n");

	$conn->close();
?>
