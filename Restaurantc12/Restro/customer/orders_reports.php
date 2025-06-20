<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>

<style>
  body {
    font-family: 'Nunito', sans-serif;
    background-color: #f8f9fe;
  }

  .header {
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    z-index: 1;
  }

  .mask {
    background: rgba(0, 0, 0, 0.5);
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    z-index: 2;
  }

  .header-body {
    position: relative;
    z-index: 3;
    color: #fff;
    padding-top: 50px;
  }

  .card {
    border-radius: 10px;
    margin-top: 20px;
  }

  .table th,
  .table td {
    vertical-align: middle;
    font-size: 15px;
  }

  .table th {
    color: #2dce89;
  }

  .text-success {
    color: #2dce89 !important;
  }

  .badge-danger {
    background-color:rgb(54, 229, 245);
  }

  .badge-success {
    background-color: #2dce89;
  }

  .table thead {
    background-color: #e9ecef;
  }

  .card-header {
    background-color: #f8f9fe;
    border-bottom: 2px solid #dee2e6;
  }
</style>

<body>
  <?php require_once('partials/_sidebar.php'); ?>
  <div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>

    <div style="background-image: url(../admin/assets/img/theme/restro00.jpg);" class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body"></div>
      </div>
    </div>

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="mb-0 text-primary">Orders Records</h3>
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
                    <th>Total Price</th>
                    <th>Status</th>
                    <th class="text-success">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $customer_id = $_SESSION['customer_id'];
                  $ret = "SELECT * FROM rpos_orders WHERE customer_id ='$customer_id' ORDER BY `created_at` DESC";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $price = (float)$order->prod_price;
                    $qty = (int)$order->prod_qty;
                    $total = $price * $qty;
                  ?>
                    <tr>
                      <th class="text-success"><?php echo $order->order_code; ?></th>
                      <td><?php echo $order->customer_name; ?></td>
                      <td class="text-success"><?php echo $order->prod_name; ?></td>
                      <td>₹<?php echo number_format($price, 2); ?></td>
                      <td class="text-success"><?php echo $qty; ?></td>
                      <td>₹<?php echo number_format($total, 2); ?></td>
                      <td>
                        <?php
                        if ($order->order_status == '') {
                          echo "<span class='badge badge-danger'>Not Paid</span>";
                        } else {
                          echo "<span class='badge badge-success'>$order->order_status</span>";
                        }
                        ?>
                      </td>
                      <td class="text-success"><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
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
