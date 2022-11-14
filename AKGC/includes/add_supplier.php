<?php
include("session.php");
if(isset($_POST['addSupplierBtn'])){
    $name = $_POST['suppliername'];
    $phone = $_POST['phoneNO'];
    $sql = "INSERT INTO supplier(
                name,
                phone) 
            VALUES (
                '$name',
                '$phone')";
                
    if($conn->query($sql)){
        header('location: ../payment.php');
    }else{
        echo "<br> ERROR : ".$sql;
    }
}else{
    echo"not runing";
}
?>