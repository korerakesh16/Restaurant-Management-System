<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>

<style>
  body {
    background-color: #f8f9fa;
  }
  .card-header {
    font-weight: 600;
    font-size: 1.25rem;
    background-color: #fff;
    color: #343a40;
    padding: 1rem 1.5rem;
    border-bottom: 2px solid #dee2e6;
  }
  .table th, .table td {
    vertical-align: middle !important;
  }
  .table th {
    color: #495057;
  }
  .text-success {
    color: #198754 !important;
  }
</style>

<body>
    <?php require_once('partials/_sidebar.php'); ?>

    <div class="main-content">
        <?php require_once('partials/_topnav.php'); ?>

        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body"></div>
            </div>
        </div>

        <div class="container-fluid mt--8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-4">
                        <div class="card-header border-0">
                            Payment Reports
                        </div>
                        <div class="table-responsive px-3 pb-4">
                            <table class="table table-bordered table-hover align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Payment Code</th>
                                        <th scope="col">Payment Method</th>
                                        <th class="text-success" scope="col">Order Code</th>
                                        <th scope="col">Amount Paid</th>
                                        <th class="text-success" scope="col">Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM rpos_payments ORDER BY `created_at` DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($payment = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $payment->pay_code; ?></th>
                                            <td><?php echo $payment->pay_method; ?></td>
                                            <td class="text-success"><?php echo $payment->order_code; ?></td>
                                            <td>₹ <?php echo $payment->pay_amt; ?></td>
                                            <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($payment->created_at)) ?></td>
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
