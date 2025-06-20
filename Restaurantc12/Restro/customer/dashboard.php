<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
require_once('partials/_analytics.php');
?>

<link rel="stylesheet" href="assets/css/custom.css">

<body>
  <?php require_once('partials/_sidebar.php'); ?>

  <div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>

    <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
          <div class="row">
            <div class="col-xl-4 col-lg-6 mb-4">
              <a href="orders.php" class="card-link">
                <div class="card card-stats shadow hover-effect">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-muted mb-0">Available Items</h5>
                        <span class="h2 font-weight-bold text-primary"><?php echo $products; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                          <i class="fas fa-utensils"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-xl-4 col-lg-6 mb-4">
              <a href="orders_reports.php" class="card-link">
                <div class="card card-stats shadow hover-effect">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-muted mb-0">Total Orders</h5>
                        <span class="h2 font-weight-bold text-warning"><?php echo $orders; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                          <i class="fas fa-shopping-cart"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-xl-4 col-lg-6 mb-4">
              <a href="payments_reports.php" class="card-link">
                <div class="card card-stats shadow hover-effect">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-muted mb-0">Total Money Spent</h5>
                        <span class="h2 font-weight-bold text-success">₹<?php echo $sales; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                          <i class="fas fa-wallet"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--7">
      <div class="row mt-5">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
              <h3 class="mb-0">Recent Orders</h3>
              <a href="orders_reports.php" class="btn btn-sm btn-outline-primary">See All</a>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success">Code</th>
                    <th>Customer</th>
                    <th class="text-success">Product</th>
                    <th>Unit Price</th>
                    <th class="text-success">Qty</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th class="text-success">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $customer_id = $_SESSION['customer_id'];
                  $ret = "SELECT * FROM  rpos_orders WHERE customer_id = '$customer_id' ORDER BY created_at DESC LIMIT 10";
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
                        <?php if ($order->order_status == '') {
                          echo "<span class='badge badge-danger'>Not Paid</span>";
                        } else {
                          echo "<span class='badge badge-success'>$order->order_status</span>";
                        } ?>
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
              <h3 class="mb-0">My Recent Payments</h3>
              <a href="payments_reports.php" class="btn btn-sm btn-outline-primary">See All</a>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success">Code</th>
                    <th>Amount</th>
                    <th class='text-success'>Order Code</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_payments WHERE customer_id ='$customer_id' ORDER BY created_at DESC LIMIT 10";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($payment = $res->fetch_object()) {
                  ?>
                    <tr>
                      <th class="text-success"><?php echo $payment->pay_code; ?></th>
                      <td>₹<?php echo $payment->pay_amt; ?></td>
                      <td class='text-success'><?php echo $payment->order_code; ?></td>
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
