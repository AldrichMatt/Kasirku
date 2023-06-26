<?php
include "koneksi.php";

$date = $_REQUEST['date'];

$order_data = mysqli_query($koneksi, "SELECT * FROM `order_table` WHERE order_id LIKE '".$date."%'")->fetch_all();
$total = mysqli_query($koneksi, "SELECT SUM(total) AS total FROM `order_table` WHERE order_id LIKE '".$date."%'")->fetch_assoc();

echo "<div class='jumbotron h2 pb-3'>Total : Rp" .number_format($total['total']) . "</div>";
echo "
<table class='table table-dark table-striped'>
<thead>
    <th>Id</th>
    <th>Order Id</th>
    <th>Name</th>
    <th>Total</th>
    <th>Action</th>

</thead>
<tbody>";
foreach($order_data as $item){
    echo "<tr>";
    echo "<td class='pe-5'>" . $item[0] . "</td>";
    echo "<td class='pe-5'>" . $item[1] . "</td>";
    echo "<td class='pe-5'>" . $item[2] . "</td>";
    echo "<td class='pe-5'> Rp" . number_format($item[5]) . "</td>";
    echo "<td class='pe-5'> <form action='controller.php' method='post'>
    <input type='hidden' name='item_id' value='".$item[0]."'>
    <button type='submit' name='detail' class='btn btn-secondary m-2'> Details </button>
</form> </td>";
    echo "</tr>";
  }
echo "</tbody>
</table>";
mysqli_close($koneksi);
?>