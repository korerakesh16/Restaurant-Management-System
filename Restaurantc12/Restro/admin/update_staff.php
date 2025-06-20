<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['UpdateStaff'])) {
  if (empty($_POST["staff_number"]) || empty($_POST["staff_name"]) || empty($_POST['staff_email']) || empty($_POST['staff_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $staff_number = $_POST['staff_number'];
    $staff_name = $_POST['staff_name'];
    $staff_email = $_POST['staff_email'];
    $staff_password = $_POST['staff_password'];
    $update = $_GET['update'];

    $postQuery = "UPDATE rpos_staff SET  staff_number =?, staff_name =?, staff_email =?, staff_password =? WHERE staff_id =?";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('ssssi', $staff_number, $staff_name, $staff_email, $staff_password, $update);
    $postStmt->execute();
    if ($postStmt) {
      $success = "Staff Updated" && header("refresh:1; url=hrm.php");
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
    $ret = "SELECT * FROM  rpos_staff WHERE staff_id = '$update'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($staff = $res->fetch_object()) {
    ?>
      <div class="header pb-8 pt-5 pt-md-8" style="background-image: url('assets/img/theme/restro00.jpg'); background-size: cover; position: relative;">
        <span class="mask bg-gradient-dark opacity-8" style="position:absolute; top:0; left:0; width:100%; height:100%;"></span>
        <div class="container-fluid position-relative text-white z-index-1">
          <h2 class="text-white">Update Staff Details</h2>
        </div>
      </div>

      <div class="container-fluid mt--7">
        <div class="row justify-content-center">
          <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card shadow border-0">
              <div class="card-header bg-transparent">
                <h3 class="mb-0">Staff Information</h3>
              </div>
              <div class="card-body px-lg-5 py-lg-5">
                <form method="POST">
                  <div class="form-group">
                    <label class="form-control-label">Staff Number</label>
                    <input type="text" name="staff_number" class="form-control" value="<?php echo $staff->staff_number; ?>" required>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Staff Name</label>
                    <input type="text" name="staff_name" class="form-control" value="<?php echo $staff->staff_name; ?>" required>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Staff Email</label>
                    <input type="email" name="staff_email" class="form-control" value="<?php echo $staff->staff_email; ?>" required>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Staff Password</label>
                    <input type="password" name="staff_password" class="form-control" placeholder="Enter new password" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" name="UpdateStaff" class="btn btn-success mt-4">Update Staff</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php
   
    }
      ?>
      </div>
  </div>
  <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
