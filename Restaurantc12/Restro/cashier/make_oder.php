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

<style>
  label {
    font-weight: 600;
  }

  .card-header h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: bold;
  }

  .form-control {
    border-radius: 0.375rem;
  }

  .btn-success {
    padding: 8px 20px;
    font-size: 1rem;
    font-weight: 500;
  }

  .header {
    position: relative;
    background-position: center;
    background-size: cover;
  }

  .mask {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
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
          <div class="card shadow border-0">
            <div class="card-header border-0">
              <h3>Please Fill All Fields</h3>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row mb-3">
                  <div class="col-md-4">
                    <label>Customer Name</label>
                    <select class="form-control" name="customer_name" id="custName" onChange="getCustomer(this.value)">
                      <option value="">Select Customer Name</option>
                      <?php
                      $ret = "SELECT * FROM  rpos_customers ";
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
                    <label>Customer ID</label>
                    <input type="text" name="customer_id" readonly id="customerID" class="form-control">
                  </div>

                  <div class="col-md-4">
                    <label>Order Code</label>
                    <input type="text" name="order_code" value="<?php echo $alpha . '-' . $beta; ?>" class="form-control">
                  </div>
                </div>

                <?php
                $prod_id = $_GET['prod_id'];
                $ret = "SELECT * FROM  rpos_products WHERE prod_id = ?";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('s', $prod_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($prod = $res->fetch_object()) {
                ?>
                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label>Product Price (₹)</label>
                      <input type="text" readonly name="prod_price" value="₹ <?php echo $prod->prod_price; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Product Quantity</label>
                      <input type="text" name="prod_qty" class="form-control" placeholder="Enter quantity">
                    </div>
                  </div>
                <?php } ?>

                <div class="form-row mt-4">
                  <div class="col-md-6">
                    <input type="submit" name="make" value="Make Order" class="btn btn-success">
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
