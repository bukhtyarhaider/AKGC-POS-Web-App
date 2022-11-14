<?php
include 'session.php';
$id= $_POST['user'];
$password = $_POST['password'];

$sql = "SELECT * FROM login WHERE username = '$id' and password = '$password'";
echo $sql;
$query = $conn->query($sql);
if($query->num_rows > 0){
	$row = $query->fetch_assoc();
    $_SESSION['user_login'] = true;
    header('location: ../index.php');
        
}else{
    echo"error";
    //header('location: ../index.php');
}
?>