<?php
  include "includes/conn.php";
  $date = new DateTime(null, new DateTimeZone('Asia/Karachi'));
  echo $date->format('H:i:s a') . "\n";
  echo $date.'<br>';
?>

<!DOCTYPE html>
<html>
<head>
	<title>AKGC</title>
</head>
<body>
	<div id="chartContainer" style="height:40%; width: 60%; background-color: black;"></div>

</body>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  title: {
    text: "Sale of week"
  },
  axisY: {
    title: "Quantity"
  },
  data: [{
    type: "line",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 
}
</script>
</html>