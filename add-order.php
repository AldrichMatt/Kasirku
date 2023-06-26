<?php
include "koneksi.php";
// Handling data in JSON format on the server-side using PHP
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$v = json_decode(file_get_contents("php://input"));

if(!mysqli_query($koneksi, "INSERT INTO `order_table`(`id`, `order_id`, `name`, `date`, `details`, `total`, `note`, `type`) VALUES (NULL,'".$v->order_id."','".$v->name."','".$v->date."','".$v->detailsJSON."','".$v->total."','".$v->note."','".$v->type."') ")){
    echo("Error description: " . $koneksi -> error);
    var_dump($v);
};

?>