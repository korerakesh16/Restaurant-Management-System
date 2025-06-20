<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['updateCustomer'])) {
  if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email']) || empty($_POST['customer_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $customer_name = $_POST['customer_name'];
    $customer_phoneno = $_POST['customer_phoneno'];
    $customer_email = $_POST['customer_email'];
    $customer_password = sha1(md5($_POST['customer_password']));
    $update = $_GET['update'];

    $postQuery = "UPDATE rpos_customers SET customer_name =?, customer_phoneno =?, customer_email =?, customer_password =? WHERE customer_id =?";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('sssss', $customer_name, $customer_phoneno, $customer_email, $customer_password, $update);
    $postStmt->execute();
    if ($postStmt) {
      $success = "Customer Updated" && header("refresh:1; url=customes.php");
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
    <?php require_once('partials/_topnav.php');
    $update = $_GET['update'];
    $ret = "SELECT * FROM rpos_customers WHERE customer_id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($cust = $res->fetch_object()) {
    ?>
      <div class="header pb-8 pt-5 pt-md-8" style="background-image: url('assets/img/theme/restro00.jpg'); background-size: cover;">
        <span class="mask bg-gradient-dark opacity-8"></span>
      </div>

      <div class="container-fluid mt--8">
        <div class="row justify-content-center">
          <div class="col-xl-8 col-lg-10">
            <div class="card shadow border-0">
              <div class="card-header bg-transparent">
                <h3 class="mb-0 text-primary text-center">Update Customer Details</h3>
              </div>
              <div class="card-body">
                <?php if (isset($err)) { ?>
                  <div class="alert alert-danger text-center"><?php echo $err; ?></div>
                <?php } ?>
                <?php if (isset($success)) { ?>
                  <div class="alert alert-success text-center"><?php echo $success; ?></div>
                <?php } ?>

                <form method="POST">
                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label for="customer_name">Customer Name</label>
                      <input type="text" name="customer_name" value="<?php echo $cust->customer_name; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label for="customer_phoneno">Phone Number</label>
                      <input type="text" name="customer_phoneno" value="<?php echo $cust->customer_phoneno; ?>" class="form-control" required>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label for="customer_email">Email</label>
                      <input type="email" name="customer_email" value="<?php echo $cust->customer_email; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label for="customer_password">Password</label>
                      <input type="password" name="customer_password" class="form-control" required>
                    </div>
                  </div>

                  <div class="form-row mt-4">
                    <div class="col text-center">
                      <button type="submit" name="updateCustomer" class="btn btn-success btn-block">Update Customer</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="text-center mt-3">
              <small class="text-muted">All amounts in ₹ Rupees</small>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    
  </div>

  <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
