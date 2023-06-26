<?php
    
    include "koneksi.php";
        $menu_data = mysqli_query($koneksi, 'SELECT * FROM `menu_table`')->fetch_all();

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
    <script>
    </script>
</head>
<body>
<?php include "navbar.php"?>
    <div class="container mx-5 mt-3">
    <a href="index.php" class="text-body    "><- Back</a>
        <div class="row">
            <div class="col-lg">
                <form action="controller.php" method="post">
                <div class="jumbotron h2">Menu</div>
                <label for="">Nama Menu</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="name" id="" required>
                </div>
                <label for="">Harga</label>
                <div class="input-group my-3">
                    <input class="form-control" type="hidden" value="0" name="type" id="" required>
                    <input class="form-control" type="number" name="price" id="" required>
                    <input class="btn btn-primary" type="submit" name="menu"></button>
                    </div>
                </form>
                <table class="table table-dark table-striped">
                    <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>

                    </thead>
                    <tbody>
                    
                <?php
                
                foreach($menu_data as $item):?>
                        <tr>
                            <td class="pe-5"><?=$item[0]?></td>
                            <td class="pe-5"><?=$item[1]?></td>
                            <td class="pe-5">Rp <?=number_format($item[2])?></td>
                            
                            <td>
                                
                                <form action="controller.php" method="post">
                                    <input type="hidden" name="item_id" value="<?=$item[0]?>">
                                    <button type="submit" name="edit" class="btn btn-warning m-2"> Edit </button>
                                    
                                    <!-- <button type="submit" name="edit" class="btn btn-warning">Edit</button> -->
                                    <button type="submit" name="delete" class="btn btn-danger m-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
</table>
     
            </div>
        </div>
    </div>
</body>
</html>
