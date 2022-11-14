<?php

include('conn.php');

$id = $_GET['id']; 

$del = mysqli_query($conn,"DELETE FROM tempdata WHERE id = '$id'"); 

if($del)
{
    mysqli_close($db); 
    header("location:../index.php"); 
    exit;	
}
else
{
    echo "Error deleting record"; 
}
?>