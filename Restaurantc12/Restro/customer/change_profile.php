<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['ChangeProfile'])) {
    if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $customer_name = $_POST['customer_name'];
        $customer_phoneno = $_POST['customer_phoneno'];
        $customer_email = $_POST['customer_email'];
        $customer_id = $_SESSION['customer_id'];

        $postQuery = "UPDATE rpos_customers SET customer_name =?, customer_phoneno =?, customer_email =?, customer_password =? WHERE  customer_id =?";
        $postStmt = $mysqli->prepare($postQuery);
        $rc = $postStmt->bind_param('sssss', $customer_name, $customer_phoneno, $customer_email, $customer_password, $customer_id);
        $postStmt->execute();
        if ($postStmt) {
            $success = "Profile Updated" && header("refresh:1; url=dashboard.php");
        } else {
            $err = "Please Try Again Or Try Later";
        }
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
        $customer_id = $_SESSION['customer_id'];
        $sql = "SELECT * FROM rpos_customers WHERE customer_id = '$customer_id'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($old_password != $row['customer_password']) {
                $err = "Please Enter Correct Old Password";
            } elseif ($new_password != $confirm_password) {
                $err = "Confirmation Password Does Not Match";
            } else {
                $new_password = sha1(md5($_POST['new_password']));
                $query = "UPDATE rpos_customers SET customer_password =? WHERE customer_id =?";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('si', $new_password, $customer_id);
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
        <?php require_once('partials/_topnav.php');
        $customer_id = $_SESSION['customer_id'];
        $ret = "SELECT * FROM rpos_customers WHERE customer_id = '$customer_id'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($customer = $res->fetch_object()) {
        ?>
            <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
                <span class="mask bg-gradient-default opacity-8"></span>
                <div class="container-fluid d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-7 col-md-10">
                            <h1 class="display-2 text-white">Hello <?php echo $customer->customer_name; ?></h1>
                            <p class="text-white mt-0 mb-5">This is your profile page. You can customize your profile and also change your password.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--8">
                <div class="row">
                    <div class="col-xl-4 mb-5">
                        <div class="card card-profile shadow">
                            <div class="row justify-content-center">
                                <div class="col-lg-3">
                                    <div class="card-profile-image">
                                        <a href="#"><img src="../admin/assets/img/theme/user-a-min.png" class="rounded-circle img-fluid"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-5 mt-5 text-center">
                                <h3 class="text-dark"><?php echo $customer->customer_name; ?></h3>
                                <div class="text-muted">
                                    <i class="fas fa-envelope mr-2"></i><?php echo $customer->customer_email; ?>
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-phone mr-2"></i><?php echo $customer->customer_phoneno; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card shadow">
                            <div class="card-header bg-white">
                                <h3 class="mb-0">My Account</h3>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <h6 class="heading-small text-muted mb-4">User Information</h6>
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-control-label">Full Name</label>
                                            <input type="text" name="customer_name" value="<?php echo $customer->customer_name; ?>" class="form-control">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-control-label">Phone Number</label>
                                            <input type="text" name="customer_phoneno" value="<?php echo $customer->customer_phoneno; ?>" class="form-control">
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <label class="form-control-label">Email Address</label>
                                            <input type="email" name="customer_email" value="<?php echo $customer->customer_email; ?>" class="form-control">
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="submit" name="ChangeProfile" class="btn btn-primary w-100" value="Update Profile">
                                        </div>
                                    </div>
                                </form>

                                <hr class="my-4">

                                <form method="post">
                                    <h6 class="heading-small text-muted mb-4">Change Password</h6>
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-control-label">Old Password</label>
                                            <input type="password" name="old_password" class="form-control">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-control-label">New Password</label>
                                            <input type="password" name="new_password" class="form-control">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-control-label">Confirm New Password</label>
                                            <input type="password" name="confirm_password" class="form-control">
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="submit" name="changePassword" class="btn btn-warning w-100" value="Change Password">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php require_once('partials/_footer.php');
        } ?>
            </div>
    </div>

    <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
