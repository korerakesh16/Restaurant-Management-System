<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['ChangeProfile'])) {
  $admin_id = $_SESSION['admin_id'];
  $admin_name = $_POST['admin_name'];
  $admin_email = $_POST['admin_email'];
  $Qry = "UPDATE rpos_admin SET admin_name =?, admin_email =? WHERE admin_id =?";
  $postStmt = $mysqli->prepare($Qry);
  $rc = $postStmt->bind_param('sss', $admin_name, $admin_email, $admin_id);
  $postStmt->execute();
  if ($postStmt) {
    $success = "Account Updated" && header("refresh:1; url=dashboard.php");
  } else {
    $err = "Please Try Again Or Try Later";
  }
}

if (isset($_POST['changePassword'])) {
  $error = 0;
  if (isset($_POST['old_password']) && !empty($_POST['old_password'])) {
    $old_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['old_password']))));
  } else {
    $error = 1;
    $err = "Old Password Cannot Be Empty";
  }

  if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
    $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
  } else {
    $error = 1;
    $err = "New Password Cannot Be Empty";
  }

  if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
    $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));
  } else {
    $error = 1;
    $err = "Confirmation Password Cannot Be Empty";
  }

  if (!$error) {
    $admin_id = $_SESSION['admin_id'];
    $sql = "SELECT * FROM rpos_admin WHERE admin_id = '$admin_id'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
      $row = mysqli_fetch_assoc($res);
      if ($old_password != $row['admin_password']) {
        $err = "Please Enter Correct Old Password";
      } elseif ($new_password != $confirm_password) {
        $err = "Confirmation Password Does Not Match";
      } else {
        $new_password = sha1(md5($_POST['new_password']));
        $query = "UPDATE rpos_admin SET admin_password =? WHERE admin_id =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ss', $new_password, $admin_id);
        $stmt->execute();
        if ($stmt) {
          $success = "Password Changed" && header("refresh:1; url=dashboard.php");
        } else {
          $err = "Please Try Again Or Try Later";
        }
      }
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
    $admin_id = $_SESSION['admin_id'];
    $ret = "SELECT * FROM rpos_admin WHERE admin_id = '$admin_id'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
    ?>
      <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
        <span class="mask bg-gradient-primary opacity-8"></span>
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-12 text-white">
              <h1 class="display-3">Hello <?php echo $admin->admin_name; ?></h1>
              <p class="lead">This is your profile page. You can customize your profile and change your password here.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid mt--8">
        <div class="row">
          <div class="col-xl-4 mb-5">
            <div class="card card-profile shadow text-center">
              <div class="card-profile-image mt-3">
                <img src="assets/img/theme/user-a-min.png" class="rounded-circle img-fluid" alt="Admin profile" style="width: 120px;">
              </div>
              <div class="card-body mt-5">
                <h3 class="text-dark"><?php echo $admin->admin_name; ?></h3>
                <p class="text-muted"><?php echo $admin->admin_email; ?></p>
              </div>
            </div>
          </div>

          <div class="col-xl-8">
            <div class="card shadow">
              <div class="card-header bg-white">
                <h4 class="mb-0">My Account</h4>
              </div>
              <div class="card-body">
                <form method="post">
                  <h5 class="text-muted">User Information</h5>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label>Username</label>
                      <input type="text" name="admin_name" value="<?php echo $admin->admin_name; ?>" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label>Email Address</label>
                      <input type="email" name="admin_email" value="<?php echo $admin->admin_email; ?>" class="form-control">
                    </div>
                    <div class="col-12">
                      <input type="submit" name="ChangeProfile" class="btn btn-success w-100" value="Update Profile">
                    </div>
                  </div>
                </form>
                <hr class="my-4">
                <form method="post">
                  <h5 class="text-muted">Change Password</h5>
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <label>Old Password</label>
                      <input type="password" name="old_password" class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                      <label>New Password</label>
                      <input type="password" name="new_password" class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                      <label>Confirm New Password</label>
                      <input type="password" name="confirm_password" class="form-control">
                    </div>
                    <div class="col-12">
                      <input type="submit" name="changePassword" class="btn btn-primary w-100" value="Change Password">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

     
    <?php } ?>
    </div>
  </div>

  <?php require_once('partials/_sidebar.php'); ?>
</body>

</html>
