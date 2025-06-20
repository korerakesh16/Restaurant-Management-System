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
    vertical-align: middle;
  }
  .badge-success {
    background-color:rgb(11, 12, 12);
    font-size: 0.85rem;
    padding: 0.4em 0.75em;
  }
  .badge-danger {
    background-color:rgb(18, 17, 17);
    font-size: 0.85rem;
    padding: 0.4em 0.75em;
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
          <div class="card shadow">
            <div class="card-header border-0">
              Orders Records
            </div>
            <div class="table-responsive px-3 pb-4">
              <table class="table table-bordered table-hover align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success" scope="col">Code</th>
                    <th scope="col">Customer</th>
                    <th class="text-success" scope="col">Product</th>
                    <th scope="col">Unit Price</th>
                    <th class="text-success" scope="col">#</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  rpos_orders ORDER BY `created_at` DESC";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $total = ((float)$order->prod_price * (int)$order->prod_qty);

                  ?>
                    <tr>
                      <th class="text-success" scope="row"><?php echo $order->order_code; ?></th>
                      <td><?php echo $order->customer_name; ?></td>
                      <td class="text-success"><?php echo $order->prod_name; ?></td>
                      <td>₹ <?php echo $order->prod_price; ?></td>
                      <td class="text-success"><?php echo $order->prod_qty; ?></td>
                      <td>₹ <?php echo $total; ?></td>
                      <td>
                        <?php if ($order->order_status == '') {
                          echo "<span class='badge badge-danger'>Not Paid</span>";
                        } else {
                          echo "<span class='badge badge-success'>$order->order_status</span>";
                        } ?>
                      </td>
                      <td><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
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
