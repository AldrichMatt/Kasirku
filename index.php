<?php
    
    include "koneksi.php";
        $menu_data = mysqli_query($koneksi, 'SELECT * FROM `menu_table`')->fetch_all();

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
    <div class="container">
        <div class="row d-inline-flex flex-wrap flex-row">
        <div class="col p-3">
                <div class="card shadow-lg rounded border border-0 text-center justify-content-center">
                    <a class="text-dark" href="kasir.php">
                    <div class="card-body">
                        <img src="dollar-sign.svg" class="card-img p-3" alt="" srcset="">
                       <p>Kasir</p>
                    </div>
                    </a>
                </div>
            </div>
        <div class="col p-3">
                <div class="card shadow-lg rounded border border-0 text-center justify-content-center">
                    <a class="text-dark" href="menu.php">
                    <div class="card-body">
                        <img src="file-text.svg" class="card-img p-3" alt="" srcset="">
                       <p>Menu</p>
                    </div>
                    </a>
                </div>
            </div>
        <div class="col p-3">
                <div class="card shadow-lg rounded border border-0 text-center justify-content-center">
                    <a class="text-dark" href="order.php">
                    <div class="card-body">
                        <img src="check-square.svg" class="card-img p-3" alt="" srcset="">
                       <p>Order</p>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        </div>
</body>
</html>

<!-- Button trigger modal -->

<!-- Modal -->
