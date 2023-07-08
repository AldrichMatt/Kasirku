<?php

include "koneksi.php";

$key = $_REQUEST['q'];

$res = mysqli_query($koneksi, "SELECT * FROM `menu_table` AS item WHERE `name` LIKE '%".$key."%'")->fetch_all();

foreach($res as $item):
    echo "<tr>";
       echo "<td class='pe-5' id='food_id'>".$item[0]."</td>";
       echo "<td class='pe-5' id='food_name'>".$item[1]."</td>";
       echo "<td class='pe-5' id='food_category'>".$item[3]."</td>";
       echo "<td class='pe-5' id='food_price'>Rp ".number_format($item[2])."</td>";
       echo "<td>";
           echo " <form action='controller.php' method='post'>
           <input type='hidden' name='item_id' value='".$item[0]."'>
           <button type='submit' name='edit' class='btn btn-warning m-2'> Edit </button>
           
           <!-- <button type='submit' name='edit' class='btn btn-warning'>Edit</button> -->
           <button type='submit' name='delete' class='btn btn-danger m-2'>Delete</button>
       </form>";
       echo "</td>";
   echo "</tr>";
endforeach;  
mysqli_close($koneksi);
?>

