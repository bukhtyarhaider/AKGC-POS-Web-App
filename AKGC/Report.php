<?php
   include('includes/session.php');
   $login = false;
 if(isset($_SESSION['user_login'])){
    $login = $_SESSION['user_login'];
  }

   if(isset($_GET['month'])){
    $currentdate = $_GET['month'];

   }else{
    $currentdate = date("m",strtotime(date("Y-m-d")));
    //$currentdate = 0;

   }
   $chartTitle = "Sale of ".date('F', mktime(0, 0, 0, $currentdate, 10));
  $query = mysqli_query($conn,"SELECT * FROM reports WHERE MONTH(date) = '$currentdate'");

   // set array
   $array = array();
   $array2 = array();

   $counter = 0;
   $x = 0;
   
   while($row = mysqli_fetch_assoc($query)){
    $array[] = $row;
   
   }

   $query2 = mysqli_query($conn,"SELECT * FROM stockPurchase WHERE MONTH(date) = '$currentdate'");
    while($row = mysqli_fetch_assoc($query2)){
    $array2[] = $row;
   
   }
   //echo date("m", strtotime(date($array[0]['date'])));
   //echo var_dump($dataPoints);
   ?>


<!DOCTYPE html>
<html>
<head>
  <title>Reports</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <script src="script/html2canvas.js"></script>
</head>
<body id= "todayReport" >
  <div class="wrapper">
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-md-12 col-12 sidebar">

          
            <div class="col-md-12 col-12">
              <a class="btn btn-danger pull-left" href="index.php"><i class='fas fa-arrow-alt-circle-left '></i> Back</a>
              <div class="input-group col-sm-5 pull-right">

                <span class="input-group-addon">Date:</span>
                <select class="form-control" id="monthlist">
                  <option value=''>--Select Month--</option>
                  <?php
                  $sql = "SELECT * FROM month";
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                              $selected = ($_GET['month'] == $row['id']) ? " selected" : "";
                              echo "
                                <option value='".$row['id']."' ".$selected.">".$row['name']."</option>
                              ";
                            }
                  ?>
                </select>
              </div>
              <div class="col-md-12 col-12 sidebar">
                      <div id="chartContainer" style="height:500px; width: 100%; padding: 0px; margin: 0px;"></div>
              </div>
             </div>
        <div class="col-md-12 col-12 sidebar">
          
          <div>
         <div class="page-header clearfix">
          <hr>
            <h1 class="pull-left saletag">Active Sale</h1>
            <h1 class="pull-left saleinfo btn-success">
               <?php
                  $sql2 = "SELECT SUM(LPGSalesQuantity) as Quantity, SUM(totalRevenue) as totalRevenue , SUM(profit) as totalProfit ,AVG(LPGSalesQuantity) as avgQuantity , SUM(expense) as totalexpense from reports WHERE MONTH(date) = '$currentdate'";
                  
                  if($result = mysqli_query($conn,$sql2)){
                  $activeSale = $result->fetch_array(MYSQLI_NUM);
                  $totalQuantity = $activeSale[0];
                  $totalRevenue = $activeSale[1];
                  $totalProfit = $activeSale[2];
                  $avgQuantity = $activeSale[3];
                  //$totalexpense = $activeSale[4];

                  mysqli_free_result($result);
                  }

                  $sql = "SELECT SUM(expense) from stockPurchase WHERE MONTH(date) = '$currentdate'";
                  if($result = mysqli_query($conn,$sql)){
                    $activeSale = $result->fetch_array(MYSQLI_NUM);
                    $totalexpense = $activeSale[0];
  
                    mysqli_free_result($result);
                    }
                  echo "Total Quantity : ".number_format($totalQuantity,2)." kg";
                  ?>
            </h1>
            <h1 class="pull-left saleinfo btn-success">
               <?php
                  echo "Total Revenue : ".number_format($totalRevenue,2)." rs";
                  ?>
            </h1>
            <?if($login){ ?>
            <h1 class="pull-left saleinfo btn-success">
               <?php
                  echo "Total Profit : ".number_format($totalProfit,2)." rs";
                  ?>
            </h1>
            <? } ?>
            <h1 class="pull-left saleinfo btn-success">
               <?php
                  echo "Total Expense : ".number_format($totalexpense,2)." rs";
                  ?>
            </h1>
            <h1 class="pull-left saleinfo btn-success">
               <?php
                  echo "Average Sale : ".number_format($avgQuantity,2)." kg";
                  ?>
            </h1>
            
            <a class="btn btn-primary pull-right" onclick="doCapture();">Download</a>
         </div>
         <?php
            // Include config file
            require_once "includes/conn.php";
            
            // Attempt select query execution
            $sql = "SELECT * FROM reports WHERE MONTH(date) = '$currentdate' ";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    echo "<table id='rcorners' >";
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Date</th>";
                                echo "<th>Quantity</th>";
                                echo "<th>Unit Price</th>";
                                echo "<th>Total Revenue</th>";
                                if($login){ 
                                echo "<th colspan='2' >Profit</th>";
                                }
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        $counter=0;
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . ++$counter . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                echo "<td>" . $row['LPGSalesQuantity'] . " kg</td>";
                                echo "<td>" . $row['pricePerKg'] . " rs</td>";
                                echo "<td>" . $row['totalRevenue'] . " rs</td>";
                                if($login){
                                echo "<td>" . $row['profit'] . " rs</td>";
                                  if(1000 > $row['profit']){
                                    echo "<td> <i class='fas fa-long-arrow-alt-down btn btn-danger '></i></td>";
                                  }else if(1500 < $row['profit']){
                                    echo "<td> <i class='fas fa-long-arrow-alt-up btn btn-success '></i> </td>";
                                  }else{
                                    echo "<td> <i class='fas fa-asterisk btn btn-warning '></i> </td>";
                                  }
                                }

                            echo "</tr>";
                        }
                        echo "</tbody>";                            
                    echo "</table>";
                    // Free result set
                    mysqli_free_result($result);
                } else{
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
            
            // Close connection
            mysqli_close($conn);
            
            ?>
      </div>
      </div>
        </div>
      </div> 
    </div>
  </div>
</body>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   <script>
      window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
          animationEnabled: true,
          theme: "light2",
          title:{
            text: "<?php echo $chartTitle ?>"
          },
          axisX:{
            valueFormatString: "DD MMM",
            crosshair: {
              enabled: true,
              snapToDataPoint: true
            }
          },
          axisY: {
            title: "Quantity",
            includeZero: true,
            crosshair: {
              enabled: true
            }
          },
          toolTip:{
            shared:true
          },  
          legend:{
            cursor:"pointer",
            verticalAlign: "bottom",
            horizontalAlign: "left",
            dockInsidePlotArea: true,
            itemclick: toogleDataSeries
          },
          data: [{
            type: "line",
            showInLegend: true,
            name: "Sale Quantity",
            markerType: "square",
            xValueFormatString: "DD MMM, YYYY",
            color: "#F08080",
            dataPoints: [
            <?php for($i = 0; $i <= count($array)-1; $i++){ ?>
              { x: new Date( <?php echo date("Y", strtotime(date($array[$i]['date']))); ?> ,<?php echo date("m", strtotime(date($array[$i]['date']))); ?> -1, <?php echo date("d", strtotime(date($array[$i]['date']))); ?> ), y: <?php echo $array[$i]['LPGSalesQuantity']; ?> }
            <?php
              if($i <= count($array)-2){
                echo ",";
              } }?>
            ]
          },
          {
            type: "line",
            showInLegend: true,
            name: "Purchase",
            lineDashType: "dash",
            dataPoints: [
              <?php for($i = 0; $i <= count($array2)-1; $i++){ ?>
              { x: new Date( <?php echo date("Y", strtotime(date($array2[$i]['date']))); ?> ,<?php echo date("m", strtotime(date($array[$i]['date']))); ?> -1 , <?php echo date("d", strtotime(date($array2[$i]['date']))); ?> ), y: <?php echo $array2[$i]['purchaseQuantity']; ?> }
            <?php
              if($i <= count($array)-2){
                echo ",";
              } }?>
            ]
          }]
        });
        chart.render();

        function toogleDataSeries(e){
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
          } else{
            e.dataSeries.visible = true;
          }
          chart.render();
        }

    }
   </script>
   <script src="script/html2canvas.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });

        function doCapture() {
        window.scrollTo(0, 0); 
        html2canvas(document.getElementById("todayReport")).then(function (canvas) {
            var ajax = new XMLHttpRequest();
            ajax.open("POST", "includes/save-post.php", true);
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send("image=" + canvas.toDataURL("image/jpeg", 0.9));
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            };
        });
    }

    </script>
<script>
$(function(){
  $('#monthlist').on('change', function(){
    if($(this).val() == 0){
      window.location = 'Report.php';
    }
    else{
      window.location = 'Report.php?month='+$(this).val();
    }
    
  });
});

</script>
</html>
