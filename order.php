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
        <div class="row">
            <div class="col-lg">
                <div class="jumbotron h2">Order</div>
                <label for="">Tanggal</label>
                <div class="input-group my-3">
                    <input class="form-control" type="date" name="date" id="date" required>
                    <button class="btn btn-primary" onclick="orderbydate()" >Search</button>
                </div>
                <div id="order-place">

                </div>
            </div>
        </div>
    </div>
</body>
</html>

<!-- Button trigger modal -->

<!-- Modal -->
