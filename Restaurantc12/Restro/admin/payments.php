<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    $adn = "DELETE FROM rpos_orders WHERE order_id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=payments.php");
    } else {
        $err = "Try Again Later";
    }
}
require_once('partials/_head.php');
?>

<style>
    .header {
        position: relative;
        background-image: url(assets/img/theme/restro00.jpg);
        background-size: cover;
        background-position: center;
    }

    .header .mask {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.6);
    }

    .table thead th {
        color: #ffffff;
        background-color: #2dce89;
        border-color: #2dce89;
    }

    .card-header .btn {
        font-size: 16px;
        font-weight: 500;
    }

    .btn i {
        margin-right: 5px;
    }
</style>

<body>
    <?php require_once('partials/_sidebar.php'); ?>

    <div class="main-content">
        <?php require_once('partials/_topnav.php'); ?>

        <div class="header pb-8 pt-5 pt-md-8">
            <span class="mask"></span>
            <div class="container-fluid">
                <div class="header-body text-white text-center">
                    <h1 class="display-4">Pending Orders</h1>
                    <p class="lead">Manage and process your restaurant orders efficiently.</p>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow border-0">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h3 class="mb-0">Order List</h3>
                            <a href="orders.php" class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> <i class="fas fa-utensils"></i> Make A New Order
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Total Price (₹)</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM rpos_orders WHERE order_status ='' ORDER BY created_at DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $total = ((float)$order->prod_price * (int)$order->prod_qty);

                                    ?>
                                        <tr>
                                            <th class="text-success"><?php echo $order->order_code; ?></th>
                                            <td><?php echo $order->customer_name; ?></td>
                                            <td><?php echo $order->prod_name; ?></td>
                                            <td>₹ <?php echo number_format($total, 2); ?></td>
                                            <td><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
                                            <td>
                                                <a href="pay_order.php?order_code=<?php echo $order->order_code; ?>&customer_id=<?php echo $order->customer_id; ?>&order_status=Paid">
                                                    <button class="btn btn-sm btn-success mb-1">
                                                        <i class="fas fa-handshake"></i> Pay Order
                                                    </button>
                                                </a>
                                                <a href="payments.php?cancel=<?php echo $order->order_id; ?>" onclick="return confirm('Are you sure you want to cancel this order?');">
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-window-close"></i> Cancel Order
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php $stmt->close(); ?>
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
