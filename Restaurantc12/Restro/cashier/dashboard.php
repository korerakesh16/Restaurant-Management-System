<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
require_once('partials/_analytics.php');
?>
<head>
  <meta charset="UTF-8">
  <title>My Restaurant Dashboard</title>
  ...


<body>
  <?php require_once('partials/_sidebar.php'); ?>
  <div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>

    <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
          <div class="row">
            <div class="col-xl-3 col-lg-6 mb-4">
              <div class="card card-stats shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="card-title text-muted text-uppercase mb-1">Customers</h5>
                    <span class="h3 font-weight-bold"><?php echo $customers; ?></span>
                  </div>
                  <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 mb-4">
              <div class="card card-stats shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="card-title text-muted text-uppercase mb-1">Products</h5>
                    <span class="h3 font-weight-bold"><?php echo $products; ?></span>
                  </div>
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                    <i class="fas fa-utensils"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 mb-4">
              <div class="card card-stats shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="card-title text-muted text-uppercase mb-1">Orders</h5>
                    <span class="h3 font-weight-bold"><?php echo $orders; ?></span>
                  </div>
                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 mb-4">
              <div class="card card-stats shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="card-title text-muted text-uppercase mb-1">Sales</h5>
                    <span class="h3 font-weight-bold">₹<?php echo $sales; ?></span>
                  </div>
                  <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                    <i class="fas fa-rupee-sign"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--7">
      <div class="row mt-5">
        <div class="col-xl-12 mb-5">
          <div class="card shadow">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
              <h3 class="mb-0">Recent Orders</h3>
              <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success">Code</th>
                    <th>Customer</th>
                    <th class="text-success">Product</th>
                    <th>Unit Price</th>
                    <th class="text-success">Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-success">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_orders ORDER BY created_at DESC LIMIT 7";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $total = (float)$order->prod_price * (int)$order->prod_qty;
                  ?>
                    <tr>
                      <th class="text-success"><?php echo $order->order_code; ?></th>
                      <td><?php echo $order->customer_name; ?></td>
                      <td class="text-success"><?php echo $order->prod_name; ?></td>
                      <td>₹<?php echo $order->prod_price; ?></td>
                      <td class="text-success"><?php echo $order->prod_qty; ?></td>
                      <td>₹<?php echo $total; ?></td>
                      <td>
                        <?php echo $order->order_status == ''
                          ? "<span class='badge badge-danger'>Not Paid</span>"
                          : "<span class='badge badge-success'>$order->order_status</span>"; ?>
                      </td>
                      <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
              <h3 class="mb-0">Recent Payments</h3>
              <a href="payments_reports.php" class="btn btn-sm btn-primary">See all</a>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success">Code</th>
                    <th>Amount</th>
                    <th class="text-success">Order Code</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_payments ORDER BY created_at DESC LIMIT 7";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($payment = $res->fetch_object()) {
                  ?>
                    <tr>
                      <th class="text-success"><?php echo $payment->pay_code; ?></th>
                      <td>₹<?php echo $payment->pay_amt; ?></td>
                      <td class="text-success"><?php echo $payment->order_code; ?></td>
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
