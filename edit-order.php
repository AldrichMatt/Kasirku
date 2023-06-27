<?php session_start(); ?>
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
            <div class="col-lg-6">
                <div class="jumbotron h2">Open Bill</div>
                <div class="jumbotron h5">Bill No. <?=$_SESSION['order']['order_id']?> </div>
                <div class="jumbotron h5"><?=$_SESSION['order']['name']?> </div>
                <div class="jumbotron h5">at <?=$_SESSION['order']['date']?> </div>
                <div class="jumbotron h5"> <?php var_dump(json_decode($_SESSION['order']['details']))?> </div>
                <form action="controller.php" method="post">
                   <?php var_dump($_SESSION['order']) ?>
                </form>
            </div>

</body>
</html>

<!-- Button trigger modal -->

<!-- Modal -->
