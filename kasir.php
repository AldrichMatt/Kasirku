<?php
    
        include "koneksi.php";
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
        i = 1;
        function addMenu(str,food_name,food_price, amount){

            px = document.getElementById(amount).innerText;
            row = "<tr id = "+i+"><td>"+i+"</td><td>"+food_name+"</td><td>"+px+" pc(s)</td><td>Rp <span id='price"+i+"'>"+food_price*px+"<span></td><td><a onclick='remove("+i+")' class='btn btn-danger'>x</a></td></tr>";
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
            for (var i=0, iLen=rows.length; i<iLen; i++) {
                row = rows[i];
                obj["item_"+i] = {
                        "item_id" : row.cells[0].textContent,
                        "item_name" : row.cells[1].textContent,
                        "item_amount" : row.cells[2].textContent,
                        "item_subtotal" : row.cells[3].textContent.toString().match(/\d/g).join(""),
                };
            }
            return JSON.stringify(obj);
        }

        function tableToJSONFormat(table) {
            var items ="";
            var row, rows = table.rows;
            for (var i=0, iLen=rows.length; i<iLen; i++) {
                row = rows[i];
                items += "no_" + row.cells[0].textContent + ': ' +row.cells[1].textContent +', '+ row.cells[2].textContent +', '+ row.cells[3].textContent + '. ';
            }
            return items
        }

        function inputOrder(){
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

            if(hour < 10){
                hour = 0 + hour.toString();
            }

            if(minute < 10){
                minute = 0 + minute.toString();
            }
        
            if(second < 10){
                second = 0 + second.toString();
            }
            // order_id, name, date, details, total, note, type
            name = document.getElementById('name').value;
            if(name == ""){

            }else{
                details = tableToJSONFormat(document.getElementById('id'))
                detailsJSON = tableToJSON(document.getElementById('id'))
                if(details.length-2 < 0){

                } else{
                    date = year + '-' +month + '-' +day + ' ' + hour + ':' +minute + ':' +second;
                    order_id = year+month+day+hour+minute+second;
                    total = document.getElementById('total').innerHTML;
                    note = document.getElementById('note').value;
                    type = document.getElementById('type').value;
                    
                    var request = new XMLHttpRequest();
                    request.open("POST", "add-order.php", true);
                    request.setRequestHeader("Content-Type", "application/json");
                    var data = JSON.stringify({"order_id": order_id, "name": name, "date": date, "details": details, "total" : total, "note" : note, "type" : type, "detailsJSON" : detailsJSON});
                    request.send(data);

                    alert("Order Placed Succesfully!");
                    location.reload();
                }

            }

        }

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
  
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function inputMenu(){
            tbody = document.getElementById("tbody");
            if(tbody.hasChildNodes()){
                last_menu = parseInt(tbody.querySelector("#tbody *:last-child #food_id").textContent) + 1;
                console.log("have child");
            } else {
                last_menu = 1;
                console.log("no child");
            }
            
            name = document.getElementById('menu_name').value;
            harga = document.getElementById('menu_price').value;
            tbody = document.getElementById('tbody');
            const formatter = new Intl.NumberFormat('en-US');
            var request = new XMLHttpRequest();
            request.open("POST", "add-menu.php", true);
            request.setRequestHeader("Content-Type", "application/json");
            var data = JSON.stringify({"menu_name":name, "menu_price":harga});
            tbody.innerHTML += "<tr><td><button class='btn btn-primary rounded-circle' onclick='addMenu("+last_menu+",`"+name+"`, `"+harga+"`, `amount"+last_menu+"`)'>+</button></td><td class='pe-5' id='food_id'>"+last_menu+"</td> <td class='pe-5' id='food_name'>"+name+"</td><td class='pe-5' id='food_price'>Rp "+formatter.format(harga)+"</td><td><div class='d-flex align-items-stretch'><button class='btn btn-warning' onclick='minusone(`amount"+last_menu+"`)'>-</button><p id='amount"+last_menu+"' class='my-auto px-3'>1</p><button class='btn btn-warning' onclick='addone(`amount"+last_menu+"`)'>+</button></div></td></tr>";
            request.send(data);
            
        }

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
            request.open("GET", "search.php?q=" + str, true);
            request.send();
        }
        }

    </script>
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
                <label for="">Details</label>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Amount</th>
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
                <button class="btn btn-primary mb-3" onclick="inputOrder()" >Submit</button>
            </div>
            <div class="col-lg-6">
                <div class="jumbotron h2">Menu</div>
                <div class="row col-12">
                <div class="col-6">
                    <label for="">Nama Menu</label>
                <div class="input-group my-3">
                    <input class="form-control" type="text" name="menu_name" id="menu_name" required>
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
                            <td><button class="btn btn-primary rounded-circle" onclick="addMenu(<?=$item[0]?>,'<?=$item[1]?>', '<?=$item[2]?>', 'amount<?=$item[0]?>')">+</button></td>
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