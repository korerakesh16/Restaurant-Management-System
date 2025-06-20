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

<body>
    <?php require_once('partials/_sidebar.php'); ?>

    <div class="main-content">
        <?php require_once('partials/_topnav.php'); ?>

        <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body"></div>
            </div>
        </div>

        <div class="container-fluid mt--8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-4">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center bg-white">
                            <h3 class="mb-0 text-dark font-weight-bold">Pending Orders</h3>
                            <a href="orders.php" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-plus mr-1"></i> <i class="fas fa-utensils mr-1"></i>
                                Make A New Order
                            </a>
                        </div>

                        <div class="table-responsive p-3">
                            <table class="table table-hover table-striped table-bordered align-items-center text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $customer_id = $_SESSION['customer_id'];
                                    $ret = "SELECT * FROM rpos_orders WHERE order_status ='' AND customer_id = '$customer_id' ORDER BY `rpos_orders`.`created_at` DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $price = (float)$order->prod_price;
                                        $qty = (int)$order->prod_qty;
                                        $total = $price * $qty;
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $order->order_code; ?></th>
                                            <td><?php echo $order->customer_name; ?></td>
                                            <td><?php echo $order->prod_name; ?></td>
                                            <td>₹ <?php echo number_format($total, 2); ?></td>
                                            <td><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
                                            <td>
                                                <a href="pay_order.php?order_code=<?php echo $order->order_code; ?>&customer_id=<?php echo $order->customer_id; ?>&order_status=Paid">
                                                    <button class="btn btn-sm btn-success shadow-sm mb-1">
                                                        <i class="fas fa-handshake mr-1"></i> Pay Order
                                                    </button>
                                                </a>
                                                <a href="payments.php?cancel=<?php echo $order->order_id; ?>" onclick="return confirm('Are you sure you want to cancel this order?');">
                                                    <button class="btn btn-sm btn-danger shadow-sm">
                                                        <i class="fas fa-window-close mr-1"></i> Cancel Order
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($res->num_rows === 0) { ?>
                                        <tr>
                                            <td colspan="6" class="text-muted">No active orders found.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once('partials/_footer.php'); ?>
        </div>
    </div>

    <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
