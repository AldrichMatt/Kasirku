<?php
include "koneksi.php";
// Handling data in JSON format on the server-side using PHP
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$v = json_decode(file_get_contents("php://input"));

mysqli_query($koneksi, "UPDATE `order_table` SET `name`='".$v->name."',`date`='".$v->date."',`details`='".$v->detailsJSON."',`total`='".$v->total."',`note`='".$v->note."',`type`='".$v->type."',`status`='".$v->status."',`method`='".$v->method."' WHERE `order_id` = '".$v->order_id."'")
?>