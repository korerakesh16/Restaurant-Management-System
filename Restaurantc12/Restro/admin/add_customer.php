<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['addCustomer'])) {
  if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email']) || empty($_POST['customer_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $customer_name = $_POST['customer_name'];
    $customer_phoneno = $_POST['customer_phoneno'];
    $customer_email = $_POST['customer_email'];
    $customer_password = sha1(md5($_POST['customer_password']));
    $customer_id = $_POST['customer_id'];

    $postQuery = "INSERT INTO rpos_customers (customer_id, customer_name, customer_phoneno, customer_email, customer_password) VALUES(?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('sssss', $customer_id, $customer_name, $customer_phoneno, $customer_email, $customer_password);
    $postStmt->execute();

    if ($postStmt) {
      $success = "Customer Added" && header("refresh:1; url=customes.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<style>
  body {
    background-color: #f1f3f5;
  }
  .card-header h3 {
    font-weight: 600;
    color: #2f2f2f;
  }
  .form-label {
    font-weight: 500;
    font-size: 0.95rem;
  }
  .form-control {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
  }
  .btn-success {
    border-radius: 0.5rem;
    font-weight: 500;
    padding: 0.5rem 1.5rem;
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
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow">
            <div class="card-header border-0 text-center">
              <h3>Please Fill All Fields</h3>
            </div>
            <div class="card-body px-5 py-4">
              <form method="POST">
                <div class="form-row mb-3">
                  <div class="col-md-6">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control">
                    <input type="hidden" name="customer_id" value="<?php echo $cus_id; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Customer Phone Number</label>
                    <input type="text" name="customer_phoneno" class="form-control" value="">
                  </div>
                </div>
                <div class="form-row mb-3">
                  <div class="col-md-6">
                    <label class="form-label">Customer Email</label>
                    <input type="email" name="customer_email" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Customer Password</label>
                    <input type="password" name="customer_password" class="form-control" value="">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mt-3">
                    <input type="submit" name="addCustomer" value="Add Customer" class="btn btn-success">
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
