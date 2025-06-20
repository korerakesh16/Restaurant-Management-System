<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['make'])) {
  if (empty($_POST["order_code"]) || empty($_POST["customer_name"]) || empty($_GET['prod_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $order_id = $_POST['order_id'];
    $order_code  = $_POST['order_code'];
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $prod_id  = $_GET['prod_id'];
    $prod_name = $_GET['prod_name'];
    $prod_price = $_GET['prod_price'];
    $prod_qty = $_POST['prod_qty'];

    $postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('ssssssss', $prod_qty, $order_id, $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
    $postStmt->execute();
    if ($postStmt) {
      $success = "Order Submitted" && header("refresh:1; url=payments.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}

require_once('partials/_head.php');
?>

<body>
  <?php require_once('partials/_sidebar.php'); ?>

  <div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>

    <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover; position: relative;">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid text-white">
        <h2 class="display-4">Order Details</h2>
        <p class="lead">Fill out the fields to place an order</p>
      </div>
    </div>

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-10 offset-xl-1">
          <div class="card shadow border-0">
            <div class="card-header bg-transparent">
              <h3 class="mb-0 text-primary">Please Fill All Fields</h3>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row mb-4">
                  <div class="col-md-4">
                    <label for="custName"><strong>Customer Name</strong></label>
                    <select class="form-control" name="customer_name" id="custName" onChange="getCustomer(this.value)">
                      <option value="">Select Customer Name</option>
                      <?php
                      $ret = "SELECT * FROM rpos_customers";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($cust = $res->fetch_object()) {
                      ?>
                        <option><?php echo $cust->customer_name; ?></option>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                  </div>

                  <div class="col-md-4">
                    <label for="customerID"><strong>Customer ID</strong></label>
                    <input type="text" name="customer_id" readonly id="customerID" class="form-control">
                  </div>

                  <div class="col-md-4">
                    <label for="orderCode"><strong>Order Code</strong></label>
                    <input type="text" name="order_code" id="orderCode" value="<?php echo $alpha . '-' . $beta; ?>" class="form-control">
                  </div>
                </div>

                <hr>

                <?php
                $prod_id = $_GET['prod_id'];
                $ret = "SELECT * FROM rpos_products WHERE prod_id = ?";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('s', $prod_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($prod = $res->fetch_object()) {
                ?>
                  <div class="form-row mb-4">
                    <div class="col-md-6">
                      <label><strong>Product Price (₹)</strong></label>
                      <input type="text" readonly name="prod_price" value="₹ <?php echo $prod->prod_price; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label><strong>Product Quantity</strong></label>
                      <input type="text" name="prod_qty" class="form-control" placeholder="Enter quantity">
                    </div>
                  </div>
                <?php } ?>

                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="make" value="Make Order" class="btn btn-success btn-lg">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    
    </div>
  </div>

  <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
