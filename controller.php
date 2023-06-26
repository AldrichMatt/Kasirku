<?php
include "koneksi.php";
session_start();
if(isset($_POST['menu'])){

    switch ($_REQUEST['type']) {
        case '0':
            mysqli_query($koneksi, 'INSERT INTO `menu_table`(`id`, `name`, `price`) VALUES (NULL,"'.$_REQUEST['name'].'",'.$_REQUEST['price'].')');
            break;
        case '1':
            mysqli_query($koneksi, 'UPDATE `menu_table` SET `name`="'.$_REQUEST['name'].'",`price`='.$_REQUEST['price'].' WHERE `id` = "'.$_REQUEST['id'].'"');
            break;
        
        default:
            # code...
            break;
        }
    header("Location: menu.php");
} else {
    
}

if(isset($_POST['edit'])){
    $item = mysqli_query($koneksi, 'SELECT * FROM `menu_table` WHERE `id` = '.$_REQUEST['item_id'].'')->fetch_assoc();
    $_SESSION['item'] = $item;
    header("Location: edit-page.php");

    
}
if(isset($_POST['delete'])){
    mysqli_query($koneksi, 'DELETE FROM `menu_table` WHERE `id` = '.$_REQUEST['item_id'].'');
    header("Location: menu.php");
}
if(isset($_POST['detail'])){
    $order_detail = mysqli_query($koneksi, 'SELECT * FROM `order_table` WHERE `id` = '.$_REQUEST['item_id'].'')->fetch_assoc();
    $_SESSION['order_detail'] = $order_detail;
    header("Location: order-detail.php");
}