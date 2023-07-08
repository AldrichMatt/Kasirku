
        window.onload = function cachetable(){
            window.tbodyglobal = document.getElementById('tbody').innerHTML;
            window.categoryArr = [];
            window.updateprice = [];
        };
        i = 1;
        function addMenu(str,food_name,food_price, amount, category){

            px = document.getElementById(amount).innerText;
            row = "<tr id = "+i+"><td>"+i+"</td><td>"+food_name+"</td><td>"+px+" pc(s)</td><td>"+category+"</td><td>Rp <span id='price"+i+"'>"+food_price*px+"<span></td><td><a onclick='remove("+i+")' class='btn btn-danger'>x</a></td></tr>";
            
            qty = parseInt(px);
            price = parseInt(food_price);
            document.getElementById('id').innerHTML += row;

            createCategoryArray(category,food_price);
            // DOMtotal = document.getElementById('total').innerHTML;
            total = parseInt(document.getElementById('total').innerHTML);
            if(total > 0){
                document.getElementById('total').innerHTML = total + price * qty;
            }else{
                document.getElementById('total').innerHTML = price * qty;
            }
            
            
            function createCategoryArray(category,price){
                
                categoryArr.push({"index-cat" : category,"index-price" :price});
                    categoryArr.forEach(element => {
                        if(category == element['index-cat']){
                            if(updateprice.length != 0){
                            updateprice.forEach(element => {
                                    // updateprice.push({"category":element['index-cat'],"price":parseInt(updateprice['price']) + parseInt(price)});
                                    
                                })}else{
                                    updateprice.push([{"category":element['index-cat'],"price":parseInt(element['index-price']) + parseInt(price)}]);
                                    // ['price']);
                                    // 
                                    
                                }
                                
                                // ['price']);
                            }else{
                                updateprice.push([{"category":category,"price":parseInt(element['index-price']) + parseInt(price)}]);
                        
                    };
                    // 
                });
                
            }
            i++;
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

        function remove(j) {
            total = parseInt(document.getElementById('total').innerHTML);
            minus = parseInt(document.getElementById('price'+j).innerHTML);
            document.getElementById('total').innerHTML = total - minus;
            document.getElementById(j).remove();

        }

        function tableToJSON(table, order_id) {
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

        function inputOrder(str){
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
            // order_id, name, date, details, total, note, type
            name = document.getElementById('name').value;
            order_id = year+month+day+hour+minute+second;
            if(name == ""){ 
                alert("Please enter customer's name");
            }else{
                details = tableToJSON(document.getElementById('id'), order_id)
                if(details.length-2 < 0){

                } else{
                    date = year + '-' +month + '-' +day + ' ' + hour + ':' +minute + ':' +second;
                    total = document.getElementById('total').innerHTML;
                    note = document.getElementById('note').value;
                    type = document.getElementById('type').value;
                    method = document.getElementById('method').value;
                    
                    var request = new XMLHttpRequest();
                    request.open("POST", "add-order.php", true);
                    request.setRequestHeader("Content-Type", "application/json");
                    switch (str) {
                        case 'open':
                            
                            var data = JSON.stringify({"order_id": order_id, "name": name, "date": date, "total" : total, "note" : note, "type" : type, "detailsJSON" : details, "status" : "0", "method" : method});
                            var state = "Saved"
                            break;
                           
                        case 'close':
                                
                            var data = JSON.stringify({"order_id": order_id, "name": name, "date": date, "total" : total, "note" : note, "type" : type, "detailsJSON" : details, "status" : "1", "method" : method});
                            var state = "Placed"
                            analysisneed(document.getElementById('id'), order_id);
                            break;
                        default:
                            break;
                    }
                    request.send(data);
                    alert("Order "+state+" Succesfully!");

                    document.getElementById('name').value = "";
                    document.getElementById('id').innerHTML = "";
                    document.getElementById('total').innerHTML = "";
                    
                    i = 1;
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
