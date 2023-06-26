<?php
// $user = "id20931034_kasirtysca";
// $pass = "KasirTyscaDB@appel01";
// $db = "id20931034_kasirku";

$user = "root";
$pass = "";
$db = "kasirku";

 $koneksi = mysqli_connect("localhost", $user , $pass , $db);

// Check connection
if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " .mysqli_connect_error();
}

?>