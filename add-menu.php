<?php
include "koneksi.php";
// Handling data in JSON format on the server-side using PHP
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$v = json_decode(file_get_contents("php://input"));

if(!mysqli_query($koneksi, "INSERT INTO `menu_table`(`id`, `name`, `price`) VALUES (NULL,'".$v->menu_name."',".$v->menu_price.") ")){
    echo("Error description: " . $koneksi -> error);
    var_dump($v);
};

?>