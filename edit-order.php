<?php
        session_start();
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
    <script>
        window.onload = function cachetable(){
            window.tbodyglobal = document.getElementById('tbody').innerHTML;
        };

        function addMenu(str,food_name,food_price, amount, category){
            tbody = document.getElementById('id');
            if(tbody.hasChildNodes()){
                i = parseInt(tbody.querySelector("#id *:last-child #item_id").textContent) + 1;
            } else {
                i = 1;
            }

            px = document.getElementById(amount).innerText;
            row = "<tr id = "+i+"><td id='item_id'>"+i+"</td><td>"+food_name+"</td><td>"+px+" pc(s)</td><td>"+category+"</td><td>Rp <span id='price"+i+"'>"+food_price*px+"<span></td><td><a onclick='remove("+i+")' class='btn btn-danger'>x</a></td></tr>";
            i++;

            qty =parseInt(px);
            price =parseInt(food_price);
            document.getElementById('id').innerHTML += row;

            // DOMtotal = document.getElementById('total').innerHTML;
            total = parseInt(document.getElementById('total').innerHTML);
            if(total > 0){
                document.getElementById('total').innerHTML = total + price * qty;
            }else{
                document.getElementById('total').innerHTML = price * qty;
            }
        }

        function addone(qty) {
            j =parseInt(document.getElementById(qty).innerHTML);
            document.getElementById(qty).innerHTML = j+1; 
        }

        function minusone(qty) {
            j =parseInt(document.getElementById(qty).innerHTML);
            if(j >= 2){
                document.getElementById(qty).innerHTML = j-1; 
            } else {

            }
        }

        function remove(i) {
            total = parseInt(document.getElementById('total').innerHTML);
            minus = parseInt(document.getElementById('price'+i).innerHTML);
            document.getElementById('total').innerHTML = total - minus;
            document.getElementById(i).remove();
        }

        function tableToJSON(table) {
            var obj = {};
            var row, rows = table.rows;
            var request = new XMLHttpRequest();
            for (var i=0, iLen=rows.length; i<iLen; i++) {
                row = rows[i];
                obj["item_"+i] = {
                    "item_id" : row.cells[0].textContent,
                        "item_name" : row.cells[1].textContent,
                        "item_amount" : row.cells[2].textContent,
                        "item_category" : row.cells[3].textContent,
                        "item_subtotal" : row.cells[4].textContent.toString().match(/\d/g).join(""),
                };
            }
            return JSON.stringify(obj);
        }
        function analysisneed(table, order_id) {
            var obj = {};
            var row, rows = table.rows;
            var request = new XMLHttpRequest();
            for (var i=0, iLen=rows.length; i<iLen; i++) {
                request.open("POST", "analytic.php", true);
                request.setRequestHeader("Content-Type", "application/json");
                row = rows[i];
                obj["item_"+i] = {
                    "item_id" : row.cells[0].textContent,
                        "item_name" : row.cells[1].textContent,
                        "item_amount" : row.cells[2].textContent,
                        "item_category" : row.cells[3].textContent,
                        "item_subtotal" : row.cells[4].textContent.toString().match(/\d/g).join(""),
                };

                var data = JSON.stringify({"order_id" : order_id, "vendor" : row.cells[3].textContent, "total" : row.cells[4].textContent.toString().match(/\d/g).join(""), "amount" : row.cells[2].textContent.toString().match(/\d/g).join(""), "menu_name" : row.cells[1].textContent});
                request.send(data);
                
            }
        }

        function dateOrder(){
            date = new Date();
            year = date.getFullYear();
            month = parseInt(date.getMonth()) + 1;
            day = date.getDate();
            hour = date.getHours(); 
            minute = date.getMinutes(); 
            second = date.getSeconds(); 
            
            if(month < 10){
                month = 0 + month.toString();
            }
            if(day < 10){
                day = 0 + day.toString();
            }
            if(hour < 10){
                hour = 0 + hour.toString();
            }

            if(minute < 10){
                minute = 0 + minute.toString();
            }
        
            if(second < 10){
                second = 0 + second.toString();
            }

            return date = year + '-' +month + '-' +day + ' ' + hour + ':' +minute + ':' +second;
        }

        function updateOrder(str){
            loading();
            // order_id, name, date, details, total, note, type
            name = document.getElementById('name').value;
            if(name == ""){

            }else{
                detailsJSON = tableToJSON(document.getElementById('id'))
                if(detailsJSON.length-2 < 0){

                } else{
                    date = dateOrder();
                    order_id = document.getElementById('order_id').value;
                    total = document.getElementById('total').innerHTML;
                    note = document.getElementById('note').value + "(updated)";
                    type = document.getElementById('type').value;
                    method = document.getElementById('method').value;
                    
                    var request = new XMLHttpRequest();
                    request.open("POST", "update-order.php", true);
                    request.setRequestHeader("Content-Type", "application/json");
                    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          window.location = "order.php"
      }
    };
                    switch (str) {
                        case 'open':
                            
                        var data = JSON.stringify({"order_id": order_id, "name": name, "date": date, "total" : total, "note" : note, "type" : type, "detailsJSON" : detailsJSON, "status" : "0", "method" : method});
                        var state = "Saved"
                        break;

                        case 'close':
                            
                        var data = JSON.stringify({"order_id": order_id, "name": name, "date": date, "total" : total, "note" : note, "type" : type, "detailsJSON" : detailsJSON,"status" : "1", "method" : method});
                        var state = "Placed"
                        analysisneed(document.getElementById('id'), order_id);
                        break;
                    
                        default:
                            break;
                    }
                    
                    request.send(data);
                    alert("Order "+state+" Succesfully!");
                }

            }

        }

        function inputMenu(){
            tbody = document.getElementById("tbody");
            if(tbody.hasChildNodes()){
                last_menu = parseInt(tbody.querySelector("#tbody *:last-child #food_id").textContent) + 1;
                
            } else {
                last_menu = 1;
                
            }
            
            name = document.getElementById('menu_name').value;
            harga = document.getElementById('menu_price').value;
            if (name != "" && harga != 0) {
            category = document.getElementById('category').value;
            tbody = document.getElementById('tbody');
            const formatter = new Intl.NumberFormat('en-US');
            var request = new XMLHttpRequest();
            request.open("POST", "add-menu.php", true);
            request.setRequestHeader("Content-Type", "application/json");
            var data = JSON.stringify({"menu_name":name, "menu_price":harga,  "menu_category":category});
            tbody.innerHTML += "<tr><td><button class='btn btn-primary rounded-circle' onclick='addMenu("+last_menu+",`"+name+"`, `"+harga+"`, `amount"+last_menu+"`, `"+category+"`)'>+</button></td><td class='pe-5' id='food_id'>"+last_menu+"</td> <td class='pe-5' id='food_name'>"+name+"</td><td class='pe-5' id='food_price'>Rp "+formatter.format(harga)+"</td><td><div class='d-flex align-items-stretch'><button class='btn btn-warning' onclick='minusone(`amount"+last_menu+"`)'>-</button><p id='amount"+last_menu+"' class='my-auto px-3'>1</p><button class='btn btn-warning' onclick='addone(`amount"+last_menu+"`)'>+</button></div></td></tr>";
            request.send(data);
            document.getElementById('menu_name').value = "";
            document.getElementById('menu_price').value = "";
            }
        }

        function search(str) {
            tbody = document.getElementById("tbody");
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
            request.open("GET", "search.php?q=" + str, true);
            request.send();
        }
        }

        function loading(){
            document.getElementById("staticBackdropLive").setAttribute("style", 'display:flex')
        }

    </script>
</head>
<body style="min-width : 576px">
<?php include "navbar.php"?>
    <div class="container px-5 mt-3">
        <a href="order.php" class="text-body"><- Back</a>
        <div class="row">
            <div class="col-lg-6">
                <div class="jumbotron h2">Kasir</div>
                <div class="jumbotron h2">Order No. <?=$_SESSION['order']['order_id']?></div>
                <input type="hidden" name="order_id" id="order_id" value="<?=$_SESSION['order']['order_id']?>">
                <input type="hidden" name="status" id="status" value="<?= $_SESSION['order']['status']?>">

                    <label for="">Nama</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="name" id="name" value="<?=$_SESSION['order']['name']?>">
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
                        <?php foreach(json_decode($_SESSION['order']['details']) as $detail):?>
                            <tr id = "<?=$detail->item_id?>">
                                <td id="item_id"><?=$detail->item_id?></td>
                                <td ><?=$detail->item_name?></td>
                                <td ><?=$detail->item_amount?></td>
                                <td ><?=$detail->item_category?></td>
                                <td >Rp <span id='price<?=$detail->item_id?>'><?=$detail->item_subtotal?><span></td>
                                <!-- <td><a onclick='remove("+i+")' class='btn btn-danger'>x</a></td> -->
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex">
                    <div class="col-6"><div class="jumbotron h5 mb-3 justify-content-start">Total</div></div>
                    <!-- <div class="col-4"></div> -->
                     
                    <div class="col-6 d-inline-flex justify-content-end">Rp<div class="jumbotron h5 px-3" id="total"><?=$_SESSION['order']['total']?></div></div>
                </div>
                <div class="jumbotron h5 mb-3">Sidenote</div>
                <textarea name="note" id="note" cols="30" rows="4" class="form-control mb-3"><?=$_SESSION['order']['note']?></textarea>
                <button class="btn btn-primary mb-3" onclick="updateOrder('close')" >Submit / Close Order</button>
                <button class="btn btn-secondary mb-3" onclick="updateOrder('open')" >Save / Open Bill</button>
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
                    <!-- <button class="btn btn-light" onclick="inputMenu()" ><img src="search.svg" alt="" srcset=""></button> -->
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
    <div class="modal fade justify-content-around show bg-dark bg-opacity-25" id="staticBackdropLive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-modal="true" role="dialog" style="display: none;">
<div class="d-flex align-items-center">
  <div class="modal-dialog ">
      <div class="spinner-border text-primary " role="status" id="spinner">
            <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>