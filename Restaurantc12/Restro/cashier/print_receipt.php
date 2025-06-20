<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Restaurant Point Of Sale Receipt">
    <meta name="author" content="Your Name">
    <title>Receipt - Restaurant POS</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery.js"></script>
    <style>
        body {
            margin-top: 40px;
            background-color: #f8f9fa;
        }
        .receipt-box {
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .btn-print {
            margin-top: 20px;
        }
    </style>
</head>

<?php
$order_code = $_GET['order_code'];
$ret = "SELECT * FROM rpos_orders WHERE order_code = '$order_code'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($order = $res->fetch_object()) {
    $total = ((float)$order->prod_price * (int)$order->prod_qty);
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div id="Receipt" class="col-md-8 receipt-box">
                <div class="row">
                    <div class="col-md-6">
                        <address>
                            <strong>C12 Restaurant</strong><br>
                            127-0-12-1<br>
                            gandimaisamma, Hyderabad, Telanaga<br>
                            91+ 9394978044
                        </address>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><em>Date: <?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></em></p>
                        <p><em class="text-success">Receipt #: <?php echo $order->order_code; ?></em></p>
                    </div>
                </div>

                <div class="text-center my-3">
                    <h2 class="fw-bold">Receipt</h2>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Unit Price (₹)</th>
                            <th class="text-center">Total (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><em><?php echo $order->prod_name; ?></em></td>
                            <td class="text-center"><?php echo $order->prod_qty; ?></td>
                            <td class="text-center">₹<?php echo number_format($order->prod_price, 2); ?></td>
                            <td class="text-center">₹<?php echo number_format($total, 2); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong>Subtotal:</strong></td>
                            <td class="text-center">₹<?php echo number_format($total, 2); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong>Tax:</strong></td>
                            <td class="text-center">14%</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-end"><h5><strong>Total:</strong></h5></td>
                            <td class="text-center text-danger"><h5><strong>₹<?php echo number_format($total, 2); ?></strong></h5></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <button id="print" onclick="printContent('Receipt');" class="btn btn-success btn-lg btn-print">
                    Print <span class="fas fa-print"></span>
                </button>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).outerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>

<?php } ?>
