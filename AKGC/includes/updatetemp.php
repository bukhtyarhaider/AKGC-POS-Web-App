<?php

include('conn.php');

if(isset($_POST['submit'])){
	if($_POST['unitprice'] == null){
		header('location: ../index.php');
	}
	$sqlquery = "SELECT purchasePricePerKg FROM inventoryChanges ORDER BY id DESC LIMIT 1";
	$row = mysqli_query($conn,$sqlquery);
	while($data = mysqli_fetch_array($row)){
		//$perviousQuantity = $data['quantity'];
		$purchasePricePerUnit= $data['purchasePricePerKg'];
	}
	//$purchasePricePerUnit = 104.375;
	$salePricePerUnit = $_POST['unitprice'];
	$revenue = $_POST['sale'];
	$quantity = $revenue/$salePricePerUnit;
	$otherProductSale = $_POST['otherproduct'];
	$totalRevenue = $revenue + $otherProductSale;
	

	$profit = (($quantity*$salePricePerUnit) - ($quantity*$purchasePricePerUnit)) + (0.5*$otherProductSale);

	echo $quantity;
	echo $profit;

	$sql = "INSERT INTO tempdata (
							Quantity,
							purchasePricePerUnit,
							salePricePerUnit,
							otherProductSale,
							revenue,
							profit) 
			VALUES ('$quantity',
					 '$purchasePricePerUnit',
					 '$salePricePerUnit',
					 '$otherProductSale',
					 '$totalRevenue'
					 ,'$profit')";
	echo $sql;
	
	if($conn->query($sql)){
		echo "Done";
		header('location: ../index.php');
	}
	

}else{
	header('location: ../index.php');
}
?>