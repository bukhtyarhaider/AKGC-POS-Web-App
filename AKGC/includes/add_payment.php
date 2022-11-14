<?php

include("session.php");
if(isset($_POST['getBtn'])){
    $supplier_id = $_POST['id'];
    $amount = $_POST['amount'];
    
    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }else{
        $date = date("Y-m-d");
    }
    $sql = "INSERT INTO paymentRegister(
                    supplier_id,
                    get,
                    date) 
            VALUES (
                '$supplier_id',
                '$amount',
                '$date')";
                
    echo $sql;
    if($conn->query($sql)){
        header('location: ../payment.php');
    }else{
        echo "<br> ERROR : ".$sql;
    }
}else{
    echo"not runing";
}
if(isset($_POST['giveBtn'])){
    $supplier_id = $_POST['id'];
    $amount = $_POST['amount'];
    
    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }else{
        $date = date("Y-m-d");
    }
    $sql = "INSERT INTO paymentRegister(
                    supplier_id,
                    give,
                    date) 
            VALUES (
                '$supplier_id',
                '$amount',
                '$date')";
                
    echo $sql;
    if($conn->query($sql)){
        header('location: ../payment.php');
    }else{
        echo "<br> ERROR : ".$sql;
    }
}else{
    echo"not runing";
}
?>