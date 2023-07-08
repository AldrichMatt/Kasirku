<?php
    
    include "koneksi.php";
        $menu_data = mysqli_query($koneksi, 'SELECT * FROM `menu_table`')->fetch_all();
        $category_data = mysqli_query($koneksi, 'SELECT * FROM `category_table`')->fetch_all();

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
        window.onload = function cachetable(){
            window.tbodyglobal = document.getElementById('tbody').innerHTML;
            menus("menu");
        };

        function search(str) {
        if (str.length == 0) {
            tbody.innerHTML = tbodyglobal;
            return;
        } else {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbody").innerHTML = this.responseText;
            }
            };
            request.open("GET", "search-menu.php?q=" + str, true);
            request.send();
        }
        }

        function menus(str) {
            switch (str) {
                case "menu":
                        document.getElementById("menu").setAttribute('style', 'display:block')
                        document.getElementById("category").setAttribute('style', 'display:none')
                        document.getElementById("category-tab").setAttribute('class', 'nav-link')
                        document.getElementById("menu-tab").setAttribute('class', 'nav-link active')
                    break;
                    case "category":
                        document.getElementById("menu").setAttribute('style', 'display:none')
                        document.getElementById("category").setAttribute('style', 'display:block')
                        document.getElementById("category-tab").setAttribute('class', 'nav-link active')
                        document.getElementById("menu-tab").setAttribute('class', 'nav-link')
                    break;
            
            
                default:
                    break;
            }
        }
    </script>
</head>
<body>
<?php include "navbar.php"?>
    <div class="container mx-5 mt-3">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
    <a class="nav-link active" aria-current="page" id="menu-tab" onclick="menus('menu')" href="#">Menu</a>
</li>
<li class="nav-item">
      <a class="nav-link" aria-current="page" id="category-tab" onclick="menus('category')" href="#">Category</a>
    </li>
</ul>   
<div class="container mx-5 mt-3" id="menu">
    <a href="index.php" class="text-body    "><- Back</a>
        <div class="row">
            <div class="col-lg">
                <form action="controller.php" method="post">
                <div class="jumbotron h2">Menu</div>
                <label for="">Nama Menu</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="name" id="" required>
                </div>
                <label for="">Kategori Menu</label>
                <div class="input-group my-3">
                    <select class="form-select" name="category" id="" required>
                    <?php foreach ($category_data as $category) :?>
                        <option value="<?=$category[1]?>"><?=$category[1]?></option>
                    <?php endforeach;?>
                    </select>
                </div>
                <label for="">Harga</label>
                <div class="input-group my-3">
                    <input class="form-control" type="hidden" value="0" name="type" id="" required>
                    <input class="form-control" type="number" name="price" id="" required>
                    <input class="btn btn-primary" type="submit" name="menu"></input>
                    </div>
                </form>

                <label for="">Cari Menu</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="search" onkeyup="search(this.value)" id="search" placeholder="Cari : Lumpia..." required>
                </div>  
                <table class="table table-dark table-striped">
                    <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>

                    </thead>
                    <tbody id="tbody">
                    
                <?php
                
                foreach($menu_data as $item):?>
                        <tr>
                            <td class="pe-5"><?=$item[0]?></td>
                            <td class="pe-5"><?=$item[1]?></td>
                            <td class="pe-5"><?=$item[3]?></td>
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
    <div class="container mx-5 mt-3" id="category">
    <a href="index.php" class="text-body    "><- Back</a>
        <div class="row">
            <div class="col-lg">
                <form action="controller.php" method="post">
                <div class="jumbotron h2">Category</div>
                <label for="">Nama Kategori</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="name" id="" required>
                    <input class="form-control" type="hidden" value="0" name="type" id="" required>
                    <input class="btn btn-primary" type="submit" name="category"></input>
                </div>
                </form> 

                <table class="table table-dark table-striped">
                    <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Action</th>

                    </thead>
                    <tbody id="tbody">
                    
                <?php
                
                foreach($category_data as $item):?>
                        <tr>
                            <td class="pe-5"><?=$item[0]?></td>
                            <td class="pe-5"><?=$item[1]?></td>
                            
                            <td>
                                
                                <form action="controller.php" method="post">
                                    <input type="hidden" name="item_id" value="<?=$item[0]?>">
                                    <button type="submit" name="edit_category" class="btn btn-warning m-2"> Edit </button>
                                    
                                    <!-- <button type="submit" name="edit" class="btn btn-warning">Edit</button> -->
                                    <button type="submit" name="delete_category" class="btn btn-danger m-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
</table>
     
            </div>
        </div>
    </div>
    </div>
</body>
</html>
