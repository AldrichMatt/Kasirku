<?php
include "koneksi.php";
// Handling data in JSON format on the server-side using PHP
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$v = json_decode(file_get_contents("php://input"));

if($v->status == "0"){
    mysqli_query($koneksi, "INSERT INTO `order_table`(`id`, `order_id`, `name`, `date`, `details`, `total`, `note`, `type`, `status`, `method`) VALUES (NULL,'".$v->order_id."','".$v->name."','".$v->date."','".$v->detailsJSON."','".$v->total."','".$v->note."','".$v->type."', '".$v->status."','".$v->method."') ");
} else{
    mysqli_query($koneksi, "INSERT INTO `order_table`(`id`, `order_id`, `name`, `date`, `details`, `total`, `note`, `type`, `method`) VALUES (NULL,'".$v->order_id."','".$v->name."','".$v->date."','".$v->detailsJSON."','".$v->total."','".$v->note."','".$v->type."','".$v->method."') ");
}

?>