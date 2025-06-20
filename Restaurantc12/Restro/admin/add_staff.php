<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['addStaff'])) {
  if (empty($_POST["staff_number"]) || empty($_POST["staff_name"]) || empty($_POST['staff_email']) || empty($_POST['staff_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $staff_number = $_POST['staff_number'];
    $staff_name = $_POST['staff_name'];
    $staff_email = $_POST['staff_email'];
    $staff_password = sha1(md5($_POST['staff_password']));

    $postQuery = "INSERT INTO rpos_staff (staff_number, staff_name, staff_email, staff_password) VALUES(?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('ssss', $staff_number, $staff_name, $staff_email, $staff_password);
    $postStmt->execute();

    if ($postStmt) {
      $success = "Staff Added" && header("refresh:1; url=hrm.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<style>
  body {
    background-color: #f8f9fa;
  }
  .card-header h3 {
    font-weight: 600;
    color: #343a40;
  }
  .form-label {
    font-weight: 500;
  }
  .form-control {
    border-radius: 0.5rem;
    border-color: #ced4da;
  }
  .btn-success {
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    border-radius: 0.5rem;
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
                    <label class="form-label">Staff Number</label>
                    <input type="text" name="staff_number" class="form-control" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Staff Name</label>
                    <input type="text" name="staff_name" class="form-control" value="">
                  </div>
                </div>
                <div class="form-row mb-3">
                  <div class="col-md-6">
                    <label class="form-label">Staff Email</label>
                    <input type="email" name="staff_email" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Staff Password</label>
                    <input type="password" name="staff_password" class="form-control" value="">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mt-3">
                    <input type="submit" name="addStaff" value="Add Staff" class="btn btn-success">
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
