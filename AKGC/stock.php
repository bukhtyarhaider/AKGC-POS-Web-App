<?php include('includes/session.php');
   $login = false; ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Stock</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
      <link rel="stylesheet" type="text/css" href="style/style.css">
   </head>
   <body onload="setData();">
      <?php if(isset($_SESSION['user_login'])){
         $login = $_SESSION['user_login'];
         } ?>
      <div class="wrapper">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-4 col-4 sidebar">
                  <div class="dashboard">
                     <div class="user">
                        <img src="images/akgclogo.png" height='100px' width="100px" alt="logo">
                        <h3>AKGC</h3>
                     </div>
                     <div class="links">
                        <div class="link">
                           <h3><a href="index.php">SALE</a></h3>
                        </div>
                        <div class="link">
                           <h3><a href="Report.php">REPORT</a></h3>
                        </div>
                        <div class="link">
                           <h3><a href="stock.php">STOCKS</a></h3>
                        </div>
                        <div class="link">
                           <h3><a href="payment.php">PAYMENTS</a></h3>
                        </div>
                     </div>
                     <a href ="#" id= "login">
                        <div class="pro">
                           <?php 
                              if($login){
                              echo "<i class='fa fa-unlock-alt' aria-hidden='true'></i>";     
                              }else{
                              echo "<i class='fa fa-lock' aria-hidden='true'></i>"; 
                              }
                              ?>
                           <h2>ADMIN</h2>
                        </div>
                     </a>
                  </div>
                  <!-- <h1 class="pull-right"><?php echo date("Y-m-d"); ?> </h1> -->
               </div>
               <div class="col-md-8 col-12">
                  <div class="cards">
                     <div class="card">
                        <div class="col-md-12 cardinfo">
                           <h3>Update Stock</h3>
                           <div class="card">
                              <div class="col-md-8">
                                 <h1>
                                 Please submit to update the stock.
                                 <h1>
                                 <form action="includes/updateStock.php" method="post">
                                 <div class="form-group <?php echo (!empty($unitPrice_err)) ? 'has-error' : ''; ?>">
                                       <label>Date</label>
                                       <input type="date" name="Date" class="form-control" >
                                    </div>
                                    <div class="form-group <?php echo (!empty($unitPrice_err)) ? 'has-error' : ''; ?>">
                                       <label>Quantity</label>
                                       <input type="text" name="Quantity" class="form-control" >
                                    </div>
                                    <div class="form-group <?php echo (!empty($otherProduct_err)) ? 'has-error' : ''; ?>">
                                       <label>Purchase Price</label>
                                       <input type="text" name="PurchasePrice" class="form-control" \>
                                    </div>
                                    <div class="form-group <?php echo (!empty($sale_err)) ? 'has-error' : ''; ?>">
                                       <label>Expense</label>
                                       <input type="text" name="expense" class="form-control">
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                    <input type="submit" class="btn btn-primary"  value="Submit">
                                 </form>
                              </div>
                              <div class="col-md-4">
                                 <i class='fas fa-gas-pump fa-5x' style="color: sandybrown;"></i>
                                 <h3>Qantity in Stocks</h3>
                                 <div class="progress">
                                    <div class="innerprogress" id ='ip'></div>
                                 </div>
                                 <h2 class="percentage" style="color: sandybrown;">
                                    <?php
                                       $sql1 = "SELECT purchaseQuantity + perviousStock as currentStock from stockPurchase ORDER BY id DESC LIMIT 1";
                                       if($result = mysqli_query($conn,$sql1)){
                                       $stock = $result->fetch_array(MYSQLI_NUM);
                                       $stockQuantity = $stock[0];
                                       
                                       mysqli_free_result($result);
                                       }
                                       $sql2 = "SELECT quantity from inventoryChanges ORDER BY id DESC LIMIT 1";
                                       if($result = mysqli_query($conn,$sql2)){
                                       $stock = $result->fetch_array(MYSQLI_NUM);
                                       $inventryQuantity = $stock[0];
                                       mysqli_free_result($result);
                                       }
                                       $stockinPercentage = number_format(($inventryQuantity/$stockQuantity)*100,2)."%";
                                       echo $stockinPercentage;
                                       ?>
                                 </h2>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id= "todayReport">
                        <div class="page-header clearfix">
                           <h1 class="pull-left saletag">Current Stock</h1>
                           <h1 class="pull-left saleinfo btn-success">
                              <?php
                                 $sql2 = "SELECT Quantity from inventoryChanges ORDER BY id DESC LIMIT 1";
                                 if($result = mysqli_query($conn,$sql2)){
                                 $activeSale = $result->fetch_array(MYSQLI_NUM);
                                 $purchaseQuantity = $activeSale[0];
                                 
                                 mysqli_free_result($result);
                                 }
                                 echo "Avaliable Stock : ".number_format($purchaseQuantity ,2)." kg";
                                 ?>
                           </h1>
                           <?php
                              $currentdate = date("Y-m-d");
                              $sql3 = "SELECT SUM(purchaseQuantity) as Quantity FROM stockPurchase where MONTH(date) = MONTH('$currentdate')";
                              if($result = mysqli_query($conn,$sql3)){
                              $stockOfMonthSale = $result->fetch_array(MYSQLI_NUM);
                              $totalPurchase = $stockOfMonthSale[0];
                              mysqli_free_result($result);
                              }
                              ?>
                           <h1 class="pull-left saleinfo btn-success">
                              <?php
                                 echo "Total Purchase : ".number_format($totalPurchase,2)." kg";
                                 ?>
                           </h1>
                           <a class="btn btn-primary pull-right" onclick="doCapture();">Download</a>
                        </div>
                        <?php
                           // Include config file
                           require_once "includes/conn.php";
                           
                           $currentdate = date("Y-m-d");
                           
                           // Attempt select query execution
                           $sql = "SELECT * FROM inventoryChanges WHERE MONTH(date) = MONTH( '$currentdate' )";
                           
                           if($result = mysqli_query($conn, $sql)){
                              if(mysqli_num_rows($result) > 0){
                                 echo "<table id='rcorners' >";
                                       echo "<thead>";
                                          echo "<tr>";
                                             echo "<th>#</th>";
                                             echo "<th>Date</th>";
                                             echo "<th>Time</th>";
                                             echo "<th>Quantity</th>";
                                             echo "<th>Purchase Price</th>";
                                             echo "<th>Type</th>";
                                          echo "</tr>";
                                       echo "</thead>";
                                       echo "<tbody>";
                                       $counter=0;
                                       while($row = mysqli_fetch_array($result)){
                                          echo "<tr>";
                           
                                             echo "<td>" . ++$counter . "</td>";
                                             echo "<td>" . $row['date'] . "</td>";
                                             echo "<td>" . $row['time'] . "</td>";
                                             echo "<td>" . $row['quantity'] . " Kg";
                                             if($row['stockAppend'] == 1){
                                                echo "<a style ='color:green;' class='pull-right'><i class='fas fa-angle-double-up '></i></a>";
                                             }else if($row['stockAppend'] == 0){
                                                echo "<a style='color:red;' class='pull-right'><i class='fas fa-angle-double-down '></i></a>";
                                             }else{
                                                echo "<a style='color:red;' class='pull-right'><i class='fas fa-ban'></i></a>";
                                             }
                                             echo "</td>";
                                             echo "<td>". $row['purchasePricePerKg']."</td>";
                                             if($row['stockAppend'] == 1){
                                                echo "<td><a class='btn btn-success pull-right'>Append</a></td>";
                                             }else if($row['stockAppend'] == 0){
                                                echo "<td><a class='btn btn-danger pull-right'>Sale</a></td>";
                                             }else{
                                                echo "<td><a class='btn btn-danger pull-right'>Lose</a></td>";
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
      <!-- Modal -->
      <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered " role="document">
            <?php
               if($login){ ?>
            <div class="sidebar modal-content">
               <div class = "pro">
                  <div class="modal-header">
                     <h3 class="modal-title" id="exampleModalLongTitle">LOGOUT</h3>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     <a href ="includes/logout.php" class="btn btn-primary">Logout</a>
                  </div>
               </div>
            </div>
            <?php }else{ ?>
            <div class="sidebar modal-content">
               <div class = "pro">
                  <div class="modal-header">
                     <h3 class="modal-title" id="exampleModalLongTitle">LOGIN</h3>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="card">
                        <form method="POST" action="includes/login.php" id = "loginform" >
                           <input type="text" class="rounded-input" name="user" placeholder = "username" required>
                           <input type="password" class="rounded-input" name = "password" placeholder= "Password" required>
                           <br>
                        </form>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" id = "loginbtn">Login</button>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
   </body>
   <script type="text/javascript">
      function setData(){
        var p = '<?php echo $stockinPercentage ?>';
        var stockProgress = document.getElementById("ip").style.width = p;
        console.log(p);
      }
      $(function(){
      $('#login').on('click', function(){
        $('#loginModal').modal('show');
      });
      });
      
      $(document).ready(function () {
      $("#loginbtn").click(function () {
        $("#loginform").submit();
      });
      });
   </script>
</html>