<?php 
$DBHOST = 'localhost';
$DBDATABASE = 'laravel';
$DBUSERNAME = 'root';
$DBPASSWORD = '';

	// Create connection
	$conn = new mysqli($DBHOST, $DBUSERNAME, $DBPASSWORD);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	// Create database if it does not exist
	$sql = "CREATE DATABASE IF NOT EXISTS ".$DBDATABASE;
	if ($conn->query($sql) === TRUE) {
	  //echo "Database created successfully";
	} else {
	  echo "Error creating database: " . $conn->error;
	}
	$conn->close();
?>