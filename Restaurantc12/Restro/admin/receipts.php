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

        <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body"></div>
            </div>
        </div>

        <div class="container-fluid mt--8">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow border-0">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Paid Orders</h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center table-striped table-hover mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Unit Price (₹)</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Total Price (₹)</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
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
                                            <td class="text-success fw-bold"><?php echo $order->order_code; ?></td>
                                            <td><?php echo $order->customer_name; ?></td>
                                            <td class="text-success"><?php echo $order->prod_name; ?></td>
                                            <td>₹ <?php echo $order->prod_price; ?></td>
                                            <td class="text-success"><?php echo $order->prod_qty; ?></td>
                                            <td>₹ <?php echo $total; ?></td>
                                            <td><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
                                            <td>
                                                <a target="_blank" href="print_receipt.php?order_code=<?php echo $order->order_code; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-print me-1"></i>Print
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer text-end">
                            <small class="text-muted">Last updated: <?php echo date("d M Y h:i A"); ?></small>
                        </div>
                    </div>
                </div>
            </div>

        
        </div>
    </div>

    <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
