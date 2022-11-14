<?php

include("includes/conn.php");

$currentdate = date("Y-m-d");

$query = "SELECT date from report order by id desc limit 1";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);
$lastRecord = $row['date'];
if($lastRecord < $currentdate ){
	?>
	<label>
		<input type="date" name="date" >
	</label>
	<?php
}else{
	echo "data is already in it";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	

</body>
</html>