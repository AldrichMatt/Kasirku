<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <title>Kasir Tysca</title>
</head>
<body>
<?php include "navbar.php"?>
    <div class="container mx-5 mt-3">
    <a href="order.php" class="text-body    "><- Back</a>
        <div class="row">
            <div class="col-lg">
                <div class="h2">Detail Order</div>
                <div class="h4">Order Id : <?=$_SESSION['order_detail']['order_id']?></div>
                <div class="h4">Nama Customer : <?=$_SESSION['order_detail']['name']?></div>
                <div class="h4">Order date : <?=$_SESSION['order_detail']['date']?></div>
                <div class="h4">Type : <?=$_SESSION['order_detail']['type']?></div>
                <div class="h4">Method : <?=$_SESSION['order_detail']['method']?></div>
                <div class="h5">Note:</div>
                <div class="card bg-warning bg-opacity-50 px-2 py-4"><?=$_SESSION['order_detail']['note']?></div>
                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                        <?php $details =json_decode($_SESSION['order_detail']['details'], true);
                        $i = 1;?>    
                        <?php foreach($details as $d): ?>
                            <tr>
                                <td><?=$i++;?></td>
                                <td><?=$d['item_name']?></td>
                                <td><?=$d['item_category']?></td>
                                <td><?=$d['item_amount']?></td>
                                <td>Rp <?=number_format($d['item_subtotal'])?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="jumbotron h4">Total : Rp <?=number_format($_SESSION['order_detail']['total'])?></div>
                
            </div>
        </div>
    </div>
</body>
</html>

<!-- Button trigger modal -->

<!-- Modal -->
