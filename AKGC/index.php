<?php 
include('includes/session.php');
$login = false;
$courrnetSalePricePerUnit = '230'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sales</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<script src="script/html2canvas.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});

	function doCapture() {
		window.scrollTo(0, 0);
		html2canvas(document.getElementById("todayReport")).then(function(canvas) {
			var ajax = new XMLHttpRequest();
			ajax.open("POST", "includes/save-post.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send("image=" + canvas.toDataURL("image/jpeg", 0.9));
			ajax.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
				}
			};
		});
	}
	</script>
</head>

<body onload="setData()">
	<?php if(isset($_SESSION['user_login'])){
  $login = $_SESSION['user_login'];
} ?>
		<div class="wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4 col-4 sidebar">
						<div class="dashboard">
							<div class="user"> <img src="images/akgclogo.png" height='100px' width="100px" alt="logo">
								<h3>AKGC</h3> </div>
							<div class="links">
								<div class="link">
									<h3><a href="index.php">SALE</a></h3> </div>
								<div class="link">
									<h3><a href="Report.php">REPORT</a></h3> </div>
								<div class="link">
									<h3><a href="stock.php">STOCKS</a></h3> </div>
								<div class="link">
									<h3><a href="payment.php">PAYMENTS</a></h3> </div>
							</div>
							<a href="#" id="login">
								<div class="pro">
									<?php 
                 if($login){
                  echo "<i class='fa fa-unlock-alt' aria-hidden='true'></i>";     
                 }else{
                  echo "<i class='fa fa-lock' aria-hidden='true'></i>"; 
                 }
                  ?>
										<h2>ADMIN</h2> </div>
							</a>
						</div>
						<!-- <h1 class="pull-right"><?php echo date("Y-m-d"); ?> </h1> --></div>
					<div class="col-md-8 col-12">
						<div class="cards">
							<div class="card"> <i class='fas fa-gas-pump fa-5x' style="color: sandybrown;"></i>
								<div class="cardinfo">
									<h3>Qantity in Stocks</h3>
									<div class="col-12">
										<div class="progress">
											<div class="innerprogress" id='ip'></div>
										</div>
									</div>
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
							<div class="card">
								<div class="col-md-6">
									<form action="includes/updatetemp.php" method="post">
										<div class="form-group <?php echo (!empty($unitPrice_err)) ? 'has-error' : ''; ?>">
											<label>Per Unit</label>
											<input type="text" placeholder="Price Per Unit" value="<?php echo $courrnetSalePricePerUnit; ?>" name="unitprice" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" class="form-control"> </div>
										<div class="form-group <?php echo (!empty($otherProduct_err)) ? 'has-error' : ''; ?>">
											<label>Other Product</label>
											<input type="text" placeholder="Other Product" value="0" name="otherproduct" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" class="form-control"> </div>
										<div class="form-group <?php echo (!empty($sale_err)) ? 'has-error' : ''; ?>">
											<label>Sales</label>
											<input type="text" placeholder="Sale" name="sale" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" class="form-control" autofocus="autofocus" onfocus="this.select()"> </div>
										<!-- <input type="submit" class="btn btn-primary"  value="Submit"> -->
										<button name='submit' class="btn btn-danger btns pull-right">Submit</button>
									</form>
								</div>
                <div class="col-md-6">
                  <div class="card">
                   <div class="card-header">
                   <h1 class="pull-right">Date : <?php echo date("d-m-Y"); ?> </h1>
                   </div>
                   <div class="card-body">
                   
                   </div>
                  </div>
                </div>
							</div>
						</div>
						<div id="todayReport" style="padding-left: 50px;">
							<div class="page-header clearfix">
								<h1 class="pull-left saletag">Active Sale</h1>
								<h1 class="pull-left saleinfo btn-success">
                          <?php

                          $sql2 = "SELECT SUM(quantity) as Quantity, SUM(revenue) as totalRevenue from tempdata";
                          if($result = mysqli_query($conn,$sql2)){
                          $activeSale = $result->fetch_array(MYSQLI_NUM);
                          $totalQuantity = $activeSale[0];
                          $totalRevenue = $activeSale[1];
                          mysqli_free_result($result);
                          }
                          echo "Total Quantity : ".number_format($totalQuantity,2)." kg";
                          ?>
                        </h1>
								<h1 class="pull-left saleinfo btn-success">
                          <?php
                          echo "Total Revenue : ".number_format($totalRevenue,2)." rs";
                          ?>
                            
                        </h1> <a href="https://web.whatsapp.com/send?phone=923436845694&text=5000" class="btn btn-success pull-right"><i class="fab fa-whatsapp"></i><a>
                        <a class="btn btn-primary pull-right" onclick="doCapture();">Download</a> <a href="includes/clearEntries.php" class="btn btn-danger pull-right">Clear</a> <a href="includes/saveRecord.php" class="btn btn-success pull-right">Save</a> </div>
							<?php
                    // Include config file
                    require_once "includes/conn.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM tempdata";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table id='rcorners'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Quantity</th>";
                                        echo "<th>Unit Price</th>";
                                        echo "<th>Sale Price</th>";
                                        echo "<th colspan='2'>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $counter=0;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                      
                                        echo "<td>" . ++$counter . "</td>";
                                        echo "<td>" . $row['quantity'] . " kg</td>";
                                        echo "<td>" . $row['salePricePerUnit'] . "</td>";
                                        echo "<td>" . $row['revenue'] . "</td>";
                                        echo "<td>";
                                           
                                            echo "<a href='includes/updateRow.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='includes/deleteROW.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
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
</body>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<?php
        if($login){ ?>
			<div class="sidebar modal-content">
				<div class="pro">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLongTitle">LOGOUT</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> <a href="includes/logout.php" class="btn btn-primary">Logout</a> </div>
				</div>
			</div>
			<?php }else{ ?>
				<div class="sidebar modal-content">
					<div class="pro">
						<div class="modal-header">
							<h3 class="modal-title" id="exampleModalLongTitle">LOGIN</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
						</div>
						<div class="modal-body">
							<div class="card">
								<form method="POST" action="includes/login.php" id="loginform">
									<input type="text" class="rounded-input" name="user" placeholder="username" required>
									<input type="password" class="rounded-input" name="password" placeholder="Password" required>
									<br> </form>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="loginbtn">Login</button>
						</div>
					</div>
				</div>
				<?php } ?>
	</div>
</div>
<script type="text/javascript">
function setData() {
	var p = '<?php echo $stockinPercentage ?>';
	var stockProgress = document.getElementById("ip").style.width = p;
	console.log(p);
}
$(function() {
	$('#login').on('click', function() {
		$('#loginModal').modal('show');
	});
});
$(document).ready(function() {
	$("#loginbtn").click(function() {
		$("#loginform").submit();
	});
});
</script>

</html>