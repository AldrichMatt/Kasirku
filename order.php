<?php
     include "koneksi.php";
        $order_data = mysqli_query($koneksi, 'SELECT * FROM `order_table`')->fetch_all();

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
        
        window.onload =function(){
            document.getElementById("close").setAttribute('style', 'display:none');
            // document.getElementById("open").setAttribute('style', 'display:none')
            document.getElementById("history").setAttribute('style', 'display:none');
            getDate();
            openbill();
            closedorder();
        }

        function getDate(){
            date = new Date();
            year = date.getFullYear();
            month = parseInt(date.getMonth()) + 1;
            day = date.getDate();
            if(month < 10){
                month = 0 + month.toString();
            }
            if(day < 10){
                day = 0 + day.toString();
            }
            
            date = year+month+day;
            
            return date;
        }

        function menus(str) {
            switch (str) {
                case "open":
                        document.getElementById("open").setAttribute('style', 'display:block')
                        document.getElementById("close").setAttribute('style', 'display:none')
                        document.getElementById("history").setAttribute('style', 'display:none')
                        document.getElementById("close-tab").setAttribute('class', 'nav-link')
                        document.getElementById("history-tab").setAttribute('class', 'nav-link')
                        document.getElementById("open-tab").setAttribute('class', 'nav-link active')
                    break;
                    case "close":
                        document.getElementById("open").setAttribute('style', 'display:none')
                        document.getElementById("close").setAttribute('style', 'display:block')
                        document.getElementById("history").setAttribute('style', 'display:none')
                        document.getElementById("close-tab").setAttribute('class', 'nav-link active')
                        document.getElementById("history-tab").setAttribute('class', 'nav-link')
                        document.getElementById("open-tab").setAttribute('class', 'nav-link')
                    break;
                    case "history":
                        
                        document.getElementById("open").setAttribute('style', 'display:none')
                        document.getElementById("close").setAttribute('style', 'display:none')
                        document.getElementById("history").setAttribute('style', 'display:block')
                        document.getElementById("close-tab").setAttribute('class', 'nav-link ')
                        document.getElementById("history-tab").setAttribute('class', 'nav-link active')
                        document.getElementById("open-tab").setAttribute('class', 'nav-link')
                    break;
            
                default:
                    break;
            }
        }

        function closedorder(){
            date =getDate();
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("close-order-place").innerHTML = this.responseText;
                }
            };
            request.open("GET", "get-closed-order.php?date="+date, true);
            request.setRequestHeader("Content-Type", "application/json");
            request.send();
            
        }
        
        function openbill(){
            date =getDate();
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("open-order-place").innerHTML = this.responseText;
            }
            };
            request.open("GET", "get-open-order.php?date="+date, true);
            request.setRequestHeader("Content-Type", "application/json");
            request.send();

        }


        function orderbydate(){
            var date = document.getElementById('date').value;
            var date = date.replace(/[-]/g, '');
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("order-place").innerHTML = this.responseText;
            }
            };
            request.open("GET", "get-order.php?date="+date, true);
            request.setRequestHeader("Content-Type", "application/json");
            request.send();

        }
    </script>
</head>
<body>
    <?php include "navbar.php"?>
    <div class="container mx-5 mt-3">
        <a href="index.php" class="text-body"><- Back</a>

        <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active " aria-current="page" id="open-tab" onclick="menus('open')" href="#">Open Order</a>
</li>
<li class="nav-item">
      <a class="nav-link" aria-current="page" id="close-tab" onclick="menus('close')" href="#">Today's Order</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" aria-current="page" id="history-tab" onclick="menus('history')" href="#">History</a>
  </li>
</ul>
        <div id="close" class="my-3">
            <div class="row">
                <div class="col-lg">
                    <div class="jumbotron h2">Order</div>
                    <div class="h5">Here are all of today's paid order</div>
                    <div id="close-order-place">
                        
                        </div>
            </div>
        </div>
    </div>
    <div id="open" class="my-3">
        <div class="row">
            <div class="col-lg">
                <div class="jumbotron h2">Open Order</div>
                <div class="h5">Here are all the ongoing order</div>
                <div id="open-order-place">

                </div>
            </div>
        </div>
    </div>
    <div id="history" class="my-3">
        <div class="row">
            <div class="col-lg">
                <div class="jumbotron h2">History</div>
                <div class="h5">check past orders</div>
                <div class="h5">Date</div>
                <div class="input-group my-3">
                    <input class="form-control" type="date" name="date" id="date" required>
                    <button class="btn btn-primary" onclick="orderbydate()" >Search</button>
                </div>
                <div id="order-place">

                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>

<!-- Button trigger modal -->

<!-- Modal -->
