<?php
include "session.php";
$phoneNumber = '923416924180';
$text;

$sql = "SELECT SUM(quantity) as totalQuantity,AVG(purchasePricePerUnit) as avgpurchasePrice  ,AVG(salePricePerUnit) as avgSalePrice ,SUM(otherProductSale) as totalOPsale ,SUM(revenue) as totalRevenue , SUM(profit) as totalProfit FROM tempdata";
//echo $sql;

$row = mysqli_query($conn,$sql);
while($data = mysqli_fetch_array($row)){
    $totalQuantity = $data['totalQuantity'];
    $avaragePurchasePrice = $data['avgpurchasePrice'];
    $avarageSalePrice = $data['avgSalePrice'];
    $TLSR = $data['totalQuantity']*$data['avgSalePrice'];
    $TOPS = $data['totalOPsale'];
    $TR = $data['totalRevenue'];
    $TP = $data['totalProfit'];
    $EX = 0;
}

$sql2 = "SELECT quantity,purchasePricePerKg FROM inventoryChanges ORDER BY id DESC LIMIT 1";
$row2 = mysqli_query($conn,$sql2);
while($data = mysqli_fetch_array($row2)){
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

