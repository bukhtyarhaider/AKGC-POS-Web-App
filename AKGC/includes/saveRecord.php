<?php
include ('conn.php');

if (!isset($_POST['clear']))
{
    $sql = "SELECT SUM(quantity) as totalQuantity,AVG(purchasePricePerUnit) as avgpurchasePrice  ,AVG(salePricePerUnit) as avgSalePrice ,SUM(otherProductSale) as totalOPsale ,SUM(revenue) as totalRevenue , SUM(profit) as totalProfit FROM tempdata";
    //echo $sql;
    $row = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($row))
    {
        $TQ = $data['totalQuantity'];
        $APP = $data['avgpurchasePrice'];
        $ASP = $data['avgSalePrice'];
        $TLSR = $data['totalQuantity'] * $data['avgSalePrice'];
        $TOPS = $data['totalOPsale'];
        $TR = $data['totalRevenue'];
        $TP = $data['totalProfit'];
        $EX = 0;
    }

    $sql2 = "SELECT quantity,purchasePricePerKg FROM inventoryChanges ORDER BY id DESC LIMIT 1";
    $row2 = mysqli_query($conn, $sql2);
    while ($data = mysqli_fetch_array($row2))
    {
        $perviousQuantity = $data['quantity'];
        $purchasePricePerKg = $data['purchasePricePerKg'];
    }

    $Currentdate = date("Y-m-d");

    $sql = "INSERT INTO reports (date,
								LPGSalesQuantity,
								pricePerKg,
								purchasePerKg,
								LPGSalesRevenue,
								otherProductRevenue,
								totalRevenue,
								profit,
								expense) 
			VALUES ( '$Currentdate',
					 '$TQ',
					 '$ASP',
					 '$APP',
					 '$TLSR',
					 '$TOPS',
					 '$TR',
					 '$TP',
					 '$EX')";

    echo $sql;
    $stockQuantity = $perviousQuantity - $TQ;

    $time = new DateTime(null, new DateTimeZone('Asia/Karachi'));
    $time = $time->format('H:i:s a');

    if ($conn->query($sql))
    {
        $sql2 = "INSERT INTO inventoryChanges (date,
							time,
							quantity,
							purchasePricePerKg,
							stockAppend) 
			VALUES ( '$Currentdate',
					 '$time',	
					 '$stockQuantity',
					 '$purchasePricePerKg',
					  0)";
        echo $sql2;
        if ($conn->query($sql2))
        {
            echo "Done";
            header('location: ../index.php');
        }

        header('location: ../index.php');
    }

}
else
{
    header('location: ../index.php');
}
?>
