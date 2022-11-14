<?php
$image = $_POST["image"];
$image = explode(";", $image)[1];
$image = explode(",", $image)[1];
$image = str_replace(" ", "+", $image);
$image = base64_decode($image);
$filename = date("Y-m-d");
file_put_contents("../DailyReport/Sale_of_$filename.jpeg", $image);
echo "Done";
?>