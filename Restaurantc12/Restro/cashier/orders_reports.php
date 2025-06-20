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

        <div class="container-fluid mt--7">
            <div class="row justify-content-center">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow border-0">
                        <div class="card-header bg-success text-white font-weight-bold">
                            <h4 class="mb-0">Orders Records</h4>
                        </div>
                        <div class="table-responsive p-3">
                            <table class="table table-hover table-striped align-items-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Code</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM rpos_orders ORDER BY created_at DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        // Convert string to float for calculation
                                        $unit_price = floatval($order->prod_price);
                                        $quantity = floatval($order->prod_qty);
                                        $total = $unit_price * $quantity;
                                    ?>
                                        <tr>
                                            <td class="text-success font-weight-bold"><?php echo htmlspecialchars($order->order_code); ?></td>
                                            <td><?php echo htmlspecialchars($order->customer_name); ?></td>
                                            <td class="text-success"><?php echo htmlspecialchars($order->prod_name); ?></td>
                                            <td>₹ <?php echo number_format($unit_price, 2); ?></td>
                                            <td class="text-success"><?php echo $quantity; ?></td>
                                            <td>₹ <?php echo number_format($total, 2); ?></td>
                                            <td>
                                                <?php if (empty($order->order_status)) { ?>
                                                    <span class="badge badge-danger">Not Paid</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-success"><?php echo htmlspecialchars($order->order_status); ?></span>
                                                <?php } ?>
                                            </td>
                                            <td class="text-muted"><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
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
