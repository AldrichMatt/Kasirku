<?php
    
        include "koneksi.php";
        $category_data = mysqli_query($koneksi, 'SELECT * FROM `category_table`')->fetch_all();
        $menu_data = mysqli_query($koneksi, 'SELECT * FROM `menu_table`')->fetch_all();
        $order_data = mysqli_query($koneksi, 'SELECT * FROM `order_table`')->fetch_all();
        $menu_last = mysqli_query($koneksi, 'SELECT id AS id FROM `menu_table` ORDER BY id DESC limit 1')->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <title>Kasir Tysca</title>
    <script src="kasir.js"></script>
</head>
<body style="min-width : 576px">
<?php include "navbar.php"?>
    <div class="container px-5 mt-3">
        <a href="index.php" class="text-body"><- Back</a>
        <div class="row">
            <div class="col-lg-6">
                <div class="jumbotron h2">Kasir</div>
                    <label for="">Nama</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="name" id="name" required>
                </div>
                <label for="">Type</label>
                <div class="input-group my-3">
                    <select class="form-select"name="type" id="type">
                    <option value="dine-in">Dine-In</option>
                    <option value="take-out">Take Out</option>
                    <option value="pick-up">Pick-Up</option>
                   </select>
                </div>
                <label for="">Method</label>
                <div class="input-group my-3">
                    <select class="form-select"name="method" id="method">
                        <option value="tunai">Cash</option>
                    <option value="transfer">Transfer - Tysca - 7970811901</option>
                   </select>
                </div>
                <label for="">Details</label>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col"><a href=""><img src="rotate-ccw.svg" alt="" srcset=""></a></th>
                        </tr>
                    </thead>
                    <tbody id='id'>
                        
                    </tbody>
                </table>
                <div class="d-flex">
                    <div class="col-6"><div class="jumbotron h5 mb-3 justify-content-start">Total</div></div>
                    <!-- <div class="col-4"></div> -->
                     
                    <div class="col-6 d-inline-flex justify-content-end">Rp<div class="jumbotron h5 px-3" id="total">0</div></div>
                </div>
                <div class="jumbotron h5 mb-3">Sidenote</div>
                <textarea name="note" id="note" cols="30" rows="4" class="form-control mb-3"></textarea>
                <button class="btn btn-primary mb-3" onclick="inputOrder('close')" >Submit / Closed Order</button>
                <button class="btn btn-secondary mb-3" onclick="inputOrder('open')" >Save / Open Bill</button>
            </div>
            <div class="col-lg-6">
                <div class="jumbotron h2">Menu</div>
                <div class="row col-12">
                <div class="col-6">
                    <label for="">Nama Menu</label>
                    <div class="input-group my-3">
                        <input class="form-control" type="text" name="menu_name" id="menu_name" required>
                    </div>  
                    <label for="">Kategori</label>
                <div class="input-group my-3">
                    <select class="form-select" name="category" id="category" required>
                    <?php foreach ($category_data as $category) :?>
                        <option value="<?=$category[1]?>"><?=$category[1]?></option>
                    <?php endforeach;?>
                    </select>
                </div>
                <label for="">Harga</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="menu_price" id="menu_price" required>
                    <button class="btn btn-primary" onclick="inputMenu()">Tambah</button>
                    
                </div>  
            </div>
            <div class="col-6">
                <label for="">Cari Menu</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="search" onkeyup="search(this.value)" id="search" placeholder="Cari : Lumpia..." required>
                </div>  
                </div>
                </div>
                <table class="table table-dark table-striped">
                    <thead>
                        <th></th>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>

                    </thead>
                    <tbody id="tbody"><?php
                foreach($menu_data as $item):?>
                        <tr>
                            <td><button class="btn btn-primary rounded-circle" onclick="addMenu(<?=$item[0]?>,'<?=$item[1]?>', '<?=$item[2]?>', 'amount<?=$item[0]?>', '<?=$item[3]?>')">+</button></td>
                            <td class="pe-5" id="food_id"><?=$item[0]?></td>
                            <td class="pe-5" id="food_name"><?=$item[1]?></td>
                            <td class="pe-5" id="food_price">Rp <?=number_format($item[2])?></td>
                            <td>
                                <div class="d-flex align-items-stretch">
                                    <button class="btn btn-warning" onclick="minusone('amount<?=$item[0]?>')">-</button><p id='amount<?=$item[0]?>' class="my-auto px-3">1</p><button class="btn btn-warning" onclick="addone('amount<?=$item[0]?>')">+</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach?></tbody></table>
     
            </div>
        </div>
    </div>
</body>
</html>