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
                            <h4 class="mb-0">Payment Reports</h4>
                        </div>
                        <div class="table-responsive p-3">
                            <table class="table table-hover table-striped align-items-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Payment Code</th>
                                        <th>Payment Method</th>
                                        <th>Order Code</th>
                                        <th>Amount Paid</th>
                                        <th>Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM rpos_payments ORDER BY created_at DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($payment = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td class="text-success font-weight-bold"><?php echo htmlspecialchars($payment->pay_code); ?></td>
                                            <td><?php echo htmlspecialchars($payment->pay_method); ?></td>
                                            <td class="text-success"><?php echo htmlspecialchars($payment->order_code); ?></td>
                                            <td>₹ <?php echo number_format(floatval($payment->pay_amt), 2); ?></td>
                                            <td class="text-muted"><?php echo date('d/M/Y g:i A', strtotime($payment->created_at)); ?></td>
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
