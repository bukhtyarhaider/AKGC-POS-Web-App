<?php

include('conn.php');

if(!isset($_POST['clear'])){
	$sql = "DELETE FROM tempdata";
	echo $sql;
	
	if($conn->query($sql)){
		echo "YES";
		$sql = "ALTER TABLE tempdata AUTO_INCREMENT = 1";
		echo $sql;
		
		if($conn->query($sql)){
			echo "Done";
			header('location: ../index.php');
		}
	}
	

}else{
	header('location: ../index.php');
}
?>