<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>

<body>
    <?php require_once('partials/_sidebar.php'); ?>
    <div class="main-content">
        <?php require_once('partials/_topnav.php'); ?>
        <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body"></div>
            </div>
        </div>

        <div class="container-fluid mt--8">
            <div class="row">
                <div class="col">
                    <div class="card shadow rounded">
                        <div class="card-header border-0 bg-light">
                            <h4 class="text-dark mb-0">Paid Orders</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-success">Code</th>
                                        <th>Customer</th>
                                        <th class="text-success">Product</th>
                                        <th>Unit Price (₹)</th>
                                        <th class="text-success">Qty</th>
                                        <th>Total Price (₹)</th>
                                        <th class="text-success">Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM rpos_orders WHERE order_status = 'Paid' ORDER BY created_at DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $total = ((float)$order->prod_price * (int)$order->prod_qty);
                                    ?>
                                        <tr>
                                            <th class="text-success"><?php echo $order->order_code; ?></th>
                                            <td><?php echo $order->customer_name; ?></td>
                                            <td class="text-success"><?php echo $order->prod_name; ?></td>
                                            <td>₹ <?php echo number_format($order->prod_price, 2); ?></td>
                                            <td class="text-success"><?php echo $order->prod_qty; ?></td>
                                            <td>₹ <?php echo number_format($total, 2); ?></td>
                                            <td><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
                                            <td>
                                                <a target="_blank" href="print_receipt.php?order_code=<?php echo $order->order_code; ?>">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-print"></i> Print
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
