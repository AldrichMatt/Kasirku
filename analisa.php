<?php
    
        include "koneksi.php";
        date_default_timezone_set('Asia/Makassar');
        $now = date('Ymd');
        $vendor_data = mysqli_query($koneksi, 'SELECT * FROM `category_table`')->fetch_all();
        $menu_data = mysqli_query($koneksi, 'SELECT * FROM `menu_table`')->fetch_all();
        $analytic_data = mysqli_query($koneksi, 'SELECT * FROM `analytic_table`')->fetch_all();
        $total = mysqli_query($koneksi, "SELECT SUM(total) AS total FROM `order_table` WHERE order_id LIKE '".$now."%' AND `status` = '1'")->fetch_assoc();
        $total_yes = mysqli_query($koneksi, "SELECT SUM(total) AS total FROM `order_table` WHERE order_id LIKE '".($now-1)."%' AND `status` = '1'")->fetch_assoc();

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
    <script>

        window.onload = function(){
            menus('order');
        }

        function menus(str) {
            switch (str) {
                case "order":
                        document.getElementById("order").setAttribute('style', 'display:block')
                        document.getElementById("menu").setAttribute('style', 'display:none')
                        document.getElementById("menu-tab").setAttribute('class', 'nav-link')
                        document.getElementById("order-tab").setAttribute('class', 'nav-link active')
                    break;
                    case "menu":
                        document.getElementById("order").setAttribute('style', 'display:none')
                        document.getElementById("menu").setAttribute('style', 'display:block')
                        document.getElementById("menu-tab").setAttribute('class', 'nav-link active')
                        document.getElementById("order-tab").setAttribute('class', 'nav-link')
                    break;
                    default:
                    break;
            }
        }
    </script>
</head>
<body>
<?php include "navbar.php"?>

<div class="container">
    <div class="jumbotron h2 mt-3">Analysis</div>
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link active " aria-current="page" id="order-tab" onclick="menus('order')" href="#">Order</a>
    </li>
    <li class="nav-item">
         <a class="nav-link" aria-current="page" id="menu-tab" onclick="menus('menu')" href="#">Menu</a>
    </li>
</ul>
<div id="order">
<div id="orderCarousel" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
        <div class="jumbotron h2 my-3">Order(s) Analysis</div>
    <div class="jumbotron h4">Here are today's order(s) analysis</div>
    <div class="jumbotron h2 my-3">Vendors data</div>
    <div class="jumbotron h2 my-3">Total : Rp <?=number_format($total['total']);?></div>
    <hr>
    <?php foreach($vendor_data as $v):?>
        <?php
            $total = mysqli_query($koneksi, "SELECT SUM(total) as total FROM `analytic_table` WHERE `vendor` = '".$v[1]."' AND `order_id` LIKE '".$now."%'")->fetch_assoc();
    ?>
        <div class="jumbotron h3 mb-3"><?=$v[1]?> : Rp <?=number_format($total['total'])?></div>
    <?php endforeach;?>
    <hr>

</div>
    </div>
    <div class="carousel-item">
    
    <div class="jumbotron h4">Here are yesterday's order(s) analysis</div>
    <div class="jumbotron h2 my-3">Vendors data</div>
    <div class="jumbotron h2 my-3">Total : Rp <?=number_format($total_yes['total']);?></div>
    <hr>
    <?php foreach($vendor_data as $v):?>
        <?php
            $total = mysqli_query($koneksi, "SELECT SUM(total) as total FROM `analytic_table` WHERE `vendor` = '".$v[1]."' AND `order_id` LIKE '".($now - 1)."%'")->fetch_assoc();

        ?>
        <div class="jumbotron h3 mb-3"><?=$v[1]?> : Rp <?=number_format($total['total'])?></div>
    <?php endforeach;?>
    <hr>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#orderCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"><img src="chevron-left.svg" alt="" srcset=""></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#orderCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"><img src="chevron-right.svg" alt="" srcset=""></span>
  </button>
</div>
    
<div id="menu">
   
    
    <div class="jumbotron h2">Menu Analysis</div>

    

    <?php foreach($vendor_data as $v):?>
        <?php foreach($analytic_data as $a):?>
            <?php $menu_analysis = mysqli_query($koneksi, "SELECT count(menu_name) as amount, menu_name FROM analytic_table WHERE order_id = ".$now." AND vendor = '".$v[1]."' ")->fetch_assoc();
            echo $v[1];
            echo($menu_analysis['amount'] ."pc(s) ". $menu_analysis['menu_name'] . "</br>" . "</br>");
            ?>

<?php endforeach;?>
<?php endforeach;?>
</div>
</div>


</body>
</html>