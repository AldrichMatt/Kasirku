<?php
    
        include "koneksi.php";
        date_default_timezone_set('Asia/Makassar');
        $now = date('Ymd');
        $vendor_data = mysqli_query($koneksi, 'SELECT * FROM `category_table`')->fetch_all();
        $menu_data = mysqli_query($koneksi, 'SELECT * FROM `menu_table`')->fetch_all();
        $analytic_data = mysqli_query($koneksi, "SELECT * FROM `analytic_table` WHERE `order_id` LIKE '".$now."%'")->fetch_all();
        $total = mysqli_query($koneksi, "SELECT SUM(total) AS total FROM `analytic_table` WHERE `order_id` LIKE '".$now."%' ")->fetch_assoc();
        $total_yes = mysqli_query($koneksi, "SELECT SUM(total) AS total FROM `analytic_table` WHERE `order_id` LIKE '".($now-1)."%'")->fetch_assoc();

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
            menus('menu');
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
        function vendors(str){
            const page = document.getElementsByClassName('container foo');
            const tab = document.getElementsByClassName('container foo');
            
            for (let id = 0; id < page.length; id++) {
                page[id].setAttribute('style', 'display:none');
                
            }
            document.getElementById(str+"-tab").setAttribute('class', 'nav-link active');
            document.getElementById(str).setAttribute('style', 'display:block');
            
            // const page = document.querySelectorAll('.container .foo:not([id^="'+str+'"])');
            // const tab = document.querySelectorAll('.nav-item .foo:not([id^="'+str+'-tab"])');
            // tab[0] = "nav-link";
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
    <ul class="nav nav-tabs mb-3">
        <?php foreach($vendor_data as $v):
            echo "<li class='nav-item'><a class='nav-link ' aria-current='page' id='".$v[1]."-tab' onclick='vendors(`".$v[1]."`)' href='#'>".$v[1]."</a></li>";
        endforeach;?>
        <?php foreach($vendor_data as $v):
        $dataa = mysqli_query($koneksi, "SELECT *, COUNT(id) as count, vendor FROM `analytic_table` WHERE order_id LIKE '".$now."%' AND vendor = '".$v[1]."' ;")->fetch_assoc();
        $count = $dataa['count'];

        echo "<div class='container foo' style='display:none;' id='".$v[1]."'>";
        echo "<div class='jumbotron h3 mt-3'>".$v[1]."</div>";
        echo "<hr>";
        // for ($i=0; $i < $count; $i++) { 
            $data_a = mysqli_query($koneksi, "SELECT amount, menu_name, order_id FROM `analytic_table` WHERE order_id LIKE '".$now."%' AND vendor = '".$v[1]."' ")->fetch_all();
            // var_dump($data_a);

            // ec(array_unique($data_a));
            foreach($data_a as $data){
                echo "<div class='jumbotron h5 mt-3'># ".$data[2]."</div>";
                echo "<div class='jumbotron h5 mt-3'>-- ".$data[0] . " " . $data[1] ."</div>" ;
            }
            
            echo "</div>";
            echo "</div>";
 endforeach;?>
</div>
</div>


</body>
<script>
    </script>
</html>