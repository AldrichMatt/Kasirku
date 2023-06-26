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
                <div class="jumbotron h2">Update Menu</div>
                <form action="controller.php" method="post">
                    <label for="">Nama Menu</label>
                    <div class="input-group my-3">
                        <input class="form-control" type="text" value="<?=$_SESSION['item']['name']?>" name="name" id="" required>
                        <input class="form-control" type="hidden" value="<?=$_SESSION['item']['id']?>" name="id" id="" required>
                        <input class="form-control" type="hidden" value="1" name="type" id="" required>
                    </div>
                    <label for="">Harga</label>
                    <div class="input-group my-3">
                        <input class="form-control" type="number" value="<?=$_SESSION['item']['price']?>" name="price" id="" required>
                        <input class="btn btn-primary" type="submit" name="menu"></button>
                    </div>
                </form>
            </div>

</body>
</html>

<!-- Button trigger modal -->

<!-- Modal -->
