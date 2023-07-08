<?php
include "koneksi.php";
session_start();
if(isset($_POST['menu'])){

    switch ($_REQUEST['type']) {
        case '0':
            mysqli_query($koneksi, 'INSERT INTO `menu_table`(`id`, `name`, `price`, `category`) VALUES (NULL,"'.$_REQUEST['name'].'",'.$_REQUEST['price'].', "'.$_REQUEST['category'].'")');
            break;
        case '1':
            mysqli_query($koneksi, 'UPDATE `menu_table` SET `name`="'.$_REQUEST['name'].'",`price`='.$_REQUEST['price'].', `category` ="'.$_REQUEST['category'].'" WHERE `id` = "'.$_REQUEST['id'].'"');
            break;
        
        default:
            # code...
            break;
        }
    header("Location: menu.php");
}
if(isset($_POST['category'])){

    switch ($_REQUEST['type']) {
        case '0':
            mysqli_query($koneksi, 'INSERT INTO `category_table`(`id`, `category_name`) VALUES (NULL,"'.$_REQUEST['name'].'")');
            break;
        case '1':
            mysqli_query($koneksi, 'UPDATE `category_table` SET `category_name`="'.$_REQUEST['name'].'" WHERE `id` = "'.$_REQUEST['id'].'"');
            break;
        
        default:
            # code...
            break;
        }
    header("Location: menu.php");
}

if(isset($_POST['edit'])){
    $item = mysqli_query($koneksi, 'SELECT * FROM `menu_table` WHERE `id` = '.$_REQUEST['item_id'].'')->fetch_assoc();
    $_SESSION['item'] = $item;
    $_SESSION['type'] = 'menu';
    header("Location: edit-page.php"); 
}

if(isset($_POST['edit_category'])){
    $item = mysqli_query($koneksi, 'SELECT * FROM `category_table` WHERE `id` = '.$_REQUEST['item_id'].'')->fetch_assoc();
    $_SESSION['item'] = $item;
    $_SESSION['type'] = 'category';
    header("Location: edit-page.php"); 
}

if(isset($_POST['edit-order'])){
    $order = mysqli_query($koneksi, 'SELECT * FROM `order_table` WHERE `id` = "'.$_REQUEST['order_id'].'"' )->fetch_assoc();
    $_SESSION['order'] = $order;
    header("Location: edit-order.php");
}

if(isset($_POST['close-order'])){
    $order = mysqli_query($koneksi, 'UPDATE `order_table` SET `status`="1" WHERE `id` = "'.$_REQUEST['order_id'].'"');
    header("Location: order.php");
}

if(isset($_POST['delete'])){
    mysqli_query($koneksi, 'DELETE FROM `menu_table` WHERE `id` = '.$_REQUEST['item_id'].'');
    header("Location: menu.php");
}
if(isset($_POST['delete_category'])){
    mysqli_query($koneksi, 'DELETE FROM `category_table` WHERE `id` = '.$_REQUEST['item_id'].'');
    header("Location: menu.php");
}
if(isset($_POST['detail'])){
    $order_detail = mysqli_query($koneksi, 'SELECT * FROM `order_table` WHERE `id` = '.$_REQUEST['order_id'].'')->fetch_assoc();
    $_SESSION['order_detail'] = $order_detail;
    header("Location: order-detail.php");
}