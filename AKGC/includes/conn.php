<?php
	$conn = new mysqli('localhost', 'root', '', 'AKGC');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}else{
		//echo"Connection is succesfully created";
	}
	
?>