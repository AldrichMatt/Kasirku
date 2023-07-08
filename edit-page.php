<?php
    session_start();
    include "koneksi.php";
        $category_data = mysqli_query($koneksi, 'SELECT * FROM `category_table`')->fetch_all();

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
            <?php if($_SESSION['type'] == "menu"){
                include "menu.txt";
            }elseif($_SESSION['type'] == "category"){
                include "category.txt";
            }?>

</body>
</html>

<!-- Button trigger modal -->

<!-- Modal -->
