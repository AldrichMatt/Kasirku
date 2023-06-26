<?php

include "koneksi.php";

$key = $_REQUEST['q'];

$res = mysqli_query($koneksi, "SELECT * FROM `menu_table` AS item WHERE `name` LIKE '%".$key."%'")->fetch_all();

foreach($res as $item):
    echo "<tr>";
       echo "<td><button class='btn btn-primary rounded-circle' onclick='addMenu(".$item[0].",`".$item[1]."`, `".$item[2]."`, `amount".$item[0]."`)'>+</button></td>";
       echo "<td class='pe-5' id='food_id'>".$item[0]."</td>";
       echo "<td class='pe-5' id='food_name'>".$item[1]."</td>";
       echo "<td class='pe-5' id='food_price'>Rp ".number_format($item[2])."</td>";
       echo "<td>";
           echo "<div class='d-flex align-items-stretch'>";
               echo "<button class='btn btn-warning' onclick='minusone(`amount".$item[0]."`)'>-</button><p id='amount".$item[0]."' class='my-auto px-3'>1</p><button class='btn btn-warning' onclick='addone(`amount".$item[0]."`)'>+</button>";
           echo "</div>";
       echo "</td>";
   echo "</tr>";
endforeach;  
mysqli_close($koneksi);
?>

