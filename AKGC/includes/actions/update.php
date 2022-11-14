<?php
// Include config file
require_once "../conn.php";
 
 if(isset($_POST['id'])){
    $id =  $_POST['id'];
    //$purchasePricePerUnit = 104.375;

	$sqlquery = "SELECT purchasePricePerKg FROM inventoryChanges ORDER BY id DESC LIMIT 1";
	$row = mysqli_query($conn,$sqlquery);
	while($data = mysqli_fetch_array($row)){
		//$perviousQuantity = $data['quantity'];
		$purchasePricePerUnit= $data['purchasePricePerKg'];
	}


	$salePricePerUnit = $_POST['UP'];
	$revenue = $_POST['sale'];
	$quantity = $revenue/$salePricePerUnit;
	$otherProductSale = $_POST['otherProduct'];
	$totalRevenue = $revenue + $otherProductSale;

	$profit = (($quantity*$salePricePerUnit) - ($quantity*$purchasePricePerUnit)) + (0.5*$otherProductSale);
	 

	$sql = "UPDATE tempdata SET 
							Quantity = '$quantity',
							purchasePricePerUnit = '$purchasePricePerUnit',
							salePricePerUnit = '$salePricePerUnit',
							otherProductSale = '$otherProductSale',
							revenue = '$totalRevenue',
							profit = '$profit' 

			WHERE id = '$id'";

	echo $sql;

	if($conn->query($sql)){
		echo "Done";
		header('location: ../../index.php');
	}


    
 }else{
    header('location: ../../index.php');
}      
?> 