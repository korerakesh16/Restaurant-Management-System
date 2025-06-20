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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt | Restaurant</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery.js"></script>
    <style>
        body {
            margin-top: 20px;
            background-color: #f8f9fa;
        }

        .receipt-box {
            background: #fff;
            border-radius: 0.5rem;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-weight: bold;
            margin-bottom: 25px;
        }

        .text-danger {
            font-weight: bold;
        }

        .btn-success {
            font-size: 18px;
        }

        .address-block strong {
            font-size: 20px;
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
    $total = ($order->prod_price * $order->prod_qty);
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div id="Receipt" class="receipt-box col-md-8">
                <div class="row mb-4">
                    <div class="col-md-6 address-block">
                        <address>
                            <strong>C12 Restaurant</strong><br>
                            127-0-2-1<br>
                            gandimaisamma, Hyderbad, Telanaga<br>
                            91+ 9394970448
                        </address>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><em>Date: <?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></em></p>
                        <p><em class="text-success">Receipt #: <?php echo $order->order_code; ?></em></p>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h2 class="text-primary">Receipt</h2>
                </div>

                <table class="table table-bordered table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price (₹)</th>
                            <th>Total (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><em><?php echo $order->prod_name; ?></em></td>
                            <td class="text-center"><?php echo $order->prod_qty; ?></td>
                            <td class="text-center">₹<?php echo $order->prod_price; ?></td>
                            <td class="text-center">₹<?php echo $total; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-end"><strong>Subtotal:</strong></td>
                            <td class="text-center">₹<?php echo $total; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-end"><strong>Tax:</strong></td>
                            <td class="text-center">14%</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-end">
                                <h4><strong>Total:</strong></h4>
                            </td>
                            <td class="text-center text-danger">
                                <h4><strong>₹<?php echo $total; ?></strong></h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-8 mt-3 text-center">
                <button id="print" onclick="printContent('Receipt');" class="btn btn-success w-100">
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>
<?php } ?>
