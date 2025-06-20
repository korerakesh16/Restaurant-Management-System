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
    <?php
    require_once('partials/_topnav.php');
    $update = $_GET['update'];
    $ret = "SELECT * FROM rpos_customers WHERE customer_id = '$update'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($cust = $res->fetch_object()) {
    ?>
      <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
        <span class="mask bg-gradient-dark opacity-8"></span>
        <div class="container-fluid">
          <div class="header-body"></div>
        </div>
      </div>

      <div class="container-fluid mt--7">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-10">
            <div class="card shadow border-0">
              <div class="card-header bg-transparent text-center">
                <h3 class="mb-0">Update Customer Details</h3>
              </div>
              <div class="card-body px-5">
                <form method="POST">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="name">Customer Name</label>
                      <input type="text" name="customer_name" value="<?php echo $cust->customer_name; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="phone">Customer Phone Number</label>
                      <input type="text" name="customer_phoneno" value="<?php echo $cust->customer_phoneno; ?>" class="form-control" required>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="email">Customer Email</label>
                      <input type="email" name="customer_email" value="<?php echo $cust->customer_email; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="password">Customer Password</label>
                      <input type="password" name="customer_password" class="form-control" required>
                    </div>
                  </div>

                  <div class="text-center">
                    <input type="submit" name="updateCustomer" value="Update Customer" class="btn btn-success btn-lg px-5">
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
<?php } ?>
