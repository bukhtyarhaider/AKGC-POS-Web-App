<?php
// Include config file
require_once "conn.php";
 
 if(isset($_GET['id'])){
    $id =  $_GET['id'];
    $availableResult = false;

    $sql2 = "SELECT salePricePerUnit,
                    otherProductSale,
                    revenue      
            from tempdata 
            where id = $id";
            
            if($result = mysqli_query($conn,$sql2)){
                $activeSale = $result->fetch_array(MYSQLI_NUM);
                $unitPrice = $activeSale[0];
                $otherProduct = $activeSale[1];
                $sale = $activeSale[2];
                mysqli_free_result($result);
                $availableResult = true;  
              }else{
                $availableResult = false;
              }

    
 }

           
         
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <style type="text/css">
        .row{
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h3>Update Record</h3>
                    </div>
                    <?php if($availableResult){ ?>
                    <h1>Please edit the input values and submit to update the record.</h1>
                    <form action="actions/update.php" method="post">
                        



                        <div class="form-group <?php echo (!empty($unitPrice_err)) ? 'has-error' : ''; ?>">
                            <label>Unit Price</label>
                            <input type="text" name="UP" class="form-control" value="<?php echo $unitPrice; ?>">
                            
                        </div>

                        <div class="form-group <?php echo (!empty($otherProduct_err)) ? 'has-error' : ''; ?>">
                            <label>Other Product</label>
                            <input type="text" name="otherProduct" class="form-control" value="<?php echo $otherProduct; ?>">
                           
                        </div>

                        <div class="form-group <?php echo (!empty($sale_err)) ? 'has-error' : ''; ?>">
                            <label>Sale</label>
                            <input type="text" name="sale" class="form-control" value="<?php echo $sale; ?>">
                            
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary"  value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                    <?php }else{
                        echo "<h1>No Records were found</h1>";
                    }
                      ?>
                    
                </div>
            </div>        
        </div>
    </div>
</body>
</html>