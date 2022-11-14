<?php
// Include config file
require_once "includes/conn.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
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
                        <h3>Update Stock</h3>
                    </div>
                    <h1>Please submit to update the stock.<h1>
                    <form action="includes/updateStock.php" method="post">
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
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                    
                    
                </div>
            </div>        
        </div>
    </div>
</body>
</html>