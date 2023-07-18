<?php
include "koneksi.php";
// Handling data in JSON format on the server-side using PHP
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$v = json_decode(file_get_contents("php://input"));
// $menu_name = mysqli_query($koneksi, "SELECT *  FROM `analytic_table` WHERE `order_id` LIKE '".$data->order_id."%' AND `menu_name` = '".$data->menu_name."'")->fetch_all();

mysqli_query($koneksi, "INSERT INTO `analytic_table`(`id`, `order_id`, `vendor`, `total`, `amount`, `menu_name`) VALUES (NULL,'".$v->order_id."','".$v->vendor."',".$v->total.",'".$v->amount."','".$v->menu_name."')");



?>