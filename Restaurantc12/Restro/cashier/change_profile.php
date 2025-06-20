<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['ChangeProfile'])) {
    $staff_id = $_SESSION['staff_id'];
    $staff_name = $_POST['staff_name'];
    $staff_email = $_POST['staff_email'];
    $Qry = "UPDATE rpos_staff SET staff_name =?, staff_email =? WHERE staff_id =?";
    $postStmt = $mysqli->prepare($Qry);
    $rc = $postStmt->bind_param('ssi', $staff_name, $staff_email, $staff_id);
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
        $staff_id = $_SESSION['staff_id'];
        $sql = "SELECT * FROM rpos_staff WHERE staff_id = '$staff_id'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($old_password != $row['staff_password']) {
                $err = "Please Enter Correct Old Password";
            } elseif ($new_password != $confirm_password) {
                $err = "Confirmation Password Does Not Match";
            } else {
                $new_password = sha1(md5($_POST['new_password']));
                $query = "UPDATE rpos_staff SET staff_password =? WHERE staff_id =?";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('si', $new_password, $staff_id);
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
        <?php require_once('partials/_topnav.php'); ?>
        <?php
        $staff_id = $_SESSION['staff_id'];
        $ret = "SELECT * FROM rpos_staff WHERE staff_id = '$staff_id'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($staff = $res->fetch_object()) {
        ?>
            <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
                <span class="mask bg-gradient-dark opacity-8"></span>
                <div class="container-fluid d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-7 col-md-10">
                            <h1 class="display-2 text-white">Hello <?php echo $staff->staff_name; ?></h1>
                            <p class="text-white mt-0 mb-5">This is your profile page. You can customize your profile as you want and also change password.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt--8">
                <div class="row">
                    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                        <div class="card card-profile shadow">
                            <div class="row justify-content-center">
                                <div class="col-lg-3 order-lg-2">
                                    <div class="card-profile-image">
                                        <a href="#">
                                            <img src="../admin/assets/img/theme/user-a-min.png" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div class="text-center">
                                    <h3 class="text-primary"><?php echo $staff->staff_name; ?></h3>
                                    <div class="h5 font-weight-300 text-muted">
                                        <?php echo $staff->staff_email; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 order-xl-1">
                        <div class="card bg-light shadow">
                            <div class="card-header bg-success text-white">
                                <h3 class="mb-0">My Account</h3>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <h6 class="heading-small text-muted mb-4">User Information</h6>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">User Name</label>
                                                <input type="text" name="staff_name" value="<?php echo $staff->staff_name; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Email address</label>
                                                <input type="email" name="staff_email" value="<?php echo $staff->staff_email; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="submit" name="ChangeProfile" class="btn btn-success w-100 mt-2" value="Update Profile">
                                        </div>
                                    </div>
                                </form>
                                <hr class="my-4">
                                <form method="post">
                                    <h6 class="heading-small text-muted mb-4">Change Password</h6>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Old Password</label>
                                                <input type="password" name="old_password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">New Password</label>
                                                <input type="password" name="new_password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Confirm New Password</label>
                                                <input type="password" name="confirm_password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="submit" name="changePassword" class="btn btn-success w-100 mt-2" value="Change Password">
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
  
    <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
