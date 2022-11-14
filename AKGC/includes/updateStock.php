<?php

	include('conn.php');
		//$date  = date("Y-m-d");
		//$date = '2021-02-23';
		$date = $_POST['Date'];
		$purchaseQuantity = ($_POST['Quantity']*43);
		$totalPurchasePrice = $_POST['PurchasePrice'];
		$purchasePricePerKg = $totalPurchasePrice/$purchaseQuantity;
		$purchasePricePerCommercial = $_POST['PurchasePrice']/$_POST['Quantity'];
		$expense = $_POST['expense'];
		$time = new DateTime(null, new DateTimeZone('Asia/Karachi'));
		$time =  $time->format('H:i:s a');

	$sql2 = "SELECT quantity,purchasePricePerKg FROM inventoryChanges ORDER BY id DESC LIMIT 1";
	$row2 = mysqli_query($conn,$sql2);
	while($data = mysqli_fetch_array($row2)){
		$perviousQuantity = $data['quantity'];
		
		//$purchasePricePerKg = $data['purchasePricePerKg'];
	}


	$sql = "INSERT INTO stockPurchase (date,
								purchaseQuantity,
								perviousStock,
								purchasePricePerCommercial,
								purchasePricePerKg,
								totalPurchasePrice,
								expense) 
			VALUES ( '$date',
					 '$purchaseQuantity',
					 '$perviousQuantity',
					 '$purchasePricePerCommercial',
					 '$purchasePricePerKg',
					 '$totalPurchasePrice',
					 '$expense')";
					 
	
	echo $sql;
	if($conn->query($sql)){
		echo "Done";
		$stockQuantity = $purchaseQuantity + $perviousQuantity;
		$sql2 = "INSERT INTO inventoryChanges (date,
							time,
							quantity,
							purchasePricePerKg,
							stockAppend) 
			VALUES ( '$date',
					 '$time',	
					 '$stockQuantity',
					 '$purchasePricePerKg',
					  1)";
		echo $sql2;
		if($conn->query($sql2)){
			echo "Done";
			$supplier_id = 1;
			$amount = $totalPurchasePrice;
			$date = date("Y-m-d");
			$sql3 = "INSERT INTO paymentRegister(
							supplier_id,
							get,
							date) 
					VALUES (
						'$supplier_id',
						'$amount',
						'$date')";
						
			echo $sql3;
			if($conn->query($sql3)){
				header('location: ../index.php');
			}else{
				echo "<br> ERROR : ".$sql3;
			}
			
		}else{

		}

	}
?>