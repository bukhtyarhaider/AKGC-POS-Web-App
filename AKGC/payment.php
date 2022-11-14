<?php
require_once "includes/session.php";
$currentdate = date("Y-m-d");


if(isset($_GET['supplier'])){
   $id = $_GET['supplier']; 
}else{
   $id = 1;
}
if(isset($_GET['month'])){
   $month = $_GET['month']; 
}else{
   $month = date("m",strtotime(date("Y-m-d")));
}
if(isset($_SESSION['user_login'])){
  $login = $_SESSION['user_login'];
}else{
   $login = false;
} 
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Payment</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
      <link rel="stylesheet" type="text/css" href="style/style.css">
   </head>
   <body>
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
                  <h3>Add Supplier</h3>
                  <div class="card">
                     <div class="col-md-6">
                        <h1>
                        Please submit the amount to you get or give.
                        <h1>
                        <form action="includes/add_payment.php" method="post">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="date" name="date" class="form-control" >
                           </div>
                           <div class="form-group">
                              <label>Amount</label>
                              <input type="text" name="amount" class="form-control" >
                           </div>
                           <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                           <input type="submit" class="btn btn-danger" name="getBtn" value="GET">
                           <input type="submit" class="btn btn-success" name="giveBtn" value="GIVE">
                        </form>
                     </div>
                     <div class="col-md-6">
                        <h1>
                        Please submit to add the supplier.
                        <h1>
                        <form action="includes/add_supplier.php" method="post">
                           <div class="form-group ">
                              <label>Supplier Name</label>
                              <input type="text" name="suppliername" class="form-control" >
                           </div>
                           <div class="form-group">
                              <label>Phone No</label>
                              <input type="text" name="phoneNO" class="form-control" \>                                    
                           </div>
                           <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                           <input type="submit" class="btn btn-primary" name="addSupplierBtn"  value="ADD">
                        </form>
                     </div>
                     <div class="col-4">
                     </div>
                  </div>
               </div>
               <br>
            </div>
         </div>
         <div class="col-md-12 cardinfo">
            <div class="cards">
               <div class="card">
                  <div class="col-md-8">
                     <div id= "todayReport">
                        <div class="page-header clearfix">
                           <h1 class="pull-left saletag">Payment</h1>
                           <h1 class="pull-left saleinfo btn-success">
                           <?php
                           if(isset($_GET['month'])){
                              $sql = "SELECT SUM(get) as SUMGET, SUM(give) as SUMGIVE from paymentRegister WHERE supplier_id = '$id' AND  MONTH(date) = '$month'";
                           }else{
                              $sql = "SELECT SUM(get) as SUMGET, SUM(give) as SUMGIVE from paymentRegister WHERE supplier_id = '$id'";
                           }
                           
                           if($result = mysqli_query($conn,$sql)){
                             $activeSale = $result->fetch_array(MYSQLI_NUM);
                             $totalget = $activeSale[0];
                             $totalgive = $activeSale[1];
           
                             mysqli_free_result($result);
                             }
                             echo "GIVE : ".($totalgive - 0)."rs";
                           ?>
                           
                           </h1>
                           <h1 class="pull-left saleinfo btn-danger"><? echo "GET : ".($totalget - 0)."rs"; ?></h1>
                           <h1 class="pull-right saleinfo btn-primary"><? echo "CLOSING : ".($totalgive - $totalget)."rs"; ?></h1>
                        </div>
                        <?php

                           // Include config file
                           
                           // Attempt select query execution
                        if(isset($_GET['month'])){
                           $sql = "SELECT * FROM paymentRegister WHERE MONTH(date) = '$month' AND supplier_id = '$id'";
                        }else{
                           $sql = "SELECT * FROM paymentRegister WHERE supplier_id = '$id'";
                        }
                           
                           
                           if($result = mysqli_query($conn, $sql)){
                              if(mysqli_num_rows($result) > 0){
                                 echo "<table id='rcorners' >";
                                       echo "<thead>";
                                          echo "<tr>";
                                             echo "<th>Date</th>";
                                             echo "<th>GET</th>";
                                             echo "<th>GIVE</th>";
                                          echo "</tr>";
                                       echo "</thead>";
                                       echo "<tbody>";
                                       $counter=0;
                                       while($row = mysqli_fetch_array($result)){
                                          $classget = $classgive = "";
                                          if($row['get'] > 0){
                                             $classget = "class='get'";
                                          }
                                          if($row['give'] > 0){
                                             $classgive = "class='give'";
                                          }
                                          echo "<tr>";
                                             echo "<td>" . $row['date']. "</td>";
                                             echo "<td ".$classget.">" . $row['get'] . "</td>";
                                             echo "<td ".$classgive.">". $row['give']."</td>";
                                          echo "</tr>";
                                          
                                       }
                                       echo "</tbody>";                            
                                 echo "</table>";
                                 mysqli_free_result($result);
                              } else{
                                 echo "<p class='lead'><em>No records were found.</em></p>";
                              }
                           } else{
                              echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                           }
                           //mysqli_close($conn);                  
                           ?>
                     </div>
                  </div>
                  <div class="col-md-4 col-4">
                     <div class="card input-group" style="padding:5px;">
                        <div class="col-md-4 col-4">
                           <span class="btn btn-danger">Month:</span>
                        </div>
                        <div class="col-md-8 col-8">
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
                     </div>
                     <? if(isset($_GET['month'])){?>
                     <div class="card input-group" style="padding:5px;">
                        <div class="col-md-4 col-4">
                           <span class="btn btn-danger">Supplier:</span>
                        </div>
                        <div class="col-md-8 col-8">
                           <select class="form-control" id="supplierList">
                              <option value=''>--Select Supplier--</option>
                              <?php
                                 $sql = "SELECT * FROM supplier";
                                 $query = $conn->query($sql);
                                 while($row = $query->fetch_assoc()){
                                    $selected = ($_GET['supplier'] == $row['id']) ? " selected" : "";
                                    echo "
                                       <option value='".$row['id']."' ".$selected.">".$row['Name']."</option>";
                                 }
                                 ?>
                           </select>
                        </div> 
                     </div>
                     <?}?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
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
</html>
<script>
   $(function(){
     $('#monthlist').on('change', function(){
       if($(this).val() == 0){
         window.location = 'payment.php';
       }
       else{
         window.location = 'payment.php?month='+$(this).val();
       }
       
     });
});
</script>


<script>
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

<script>
   $(function(){
  $('#supplierList').on('change', function(){
    if($(this).val() == 0){
      window.location = 'payment.php';
    }
    else{
      window.location = 'payment.php?month=<? echo $_GET['month']; ?>&supplier='+$(this).val();
    }
    
  });
});
</script>
