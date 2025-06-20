<?php
session_start();
include('config/config.php');
require_once('config/code-generator.php');

if (isset($_POST['reset_pwd'])) {
  if (!filter_var($_POST['reset_email'], FILTER_VALIDATE_EMAIL)) {
    $err = 'Invalid Email';
  }
  $checkEmail = mysqli_query($mysqli, "SELECT `admin_email` FROM `rpos_admin` WHERE `admin_email` = '" . $_POST['reset_email'] . "'") or exit(mysqli_error($mysqli));
  if (mysqli_num_rows($checkEmail) > 0) {
    $reset_code = $_POST['reset_code'];
    $reset_token = sha1(md5($_POST['reset_token']));
    $reset_status = $_POST['reset_status'];
    $reset_email = $_POST['reset_email'];
    $query = "INSERT INTO rpos_pass_resets (reset_email, reset_code, reset_token, reset_status) VALUES (?,?,?,?)";
    $reset = $mysqli->prepare($query);
    $rc = $reset->bind_param('ssss', $reset_email, $reset_code, $reset_token, $reset_status);
    $reset->execute();
    if ($reset) {
      $success = "Password Reset Instructions Sent To Your Email";
    } else {
      $err = "Please Try Again Or Try Later";
    }
  } else {
    $err = "No account with that email";
  }
}
require_once('partials/_head.php');
?>

<style>
  body {
    background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Nunito', sans-serif;
    min-height: 100vh;
    margin: 0;
  }

  .header {
    background: linear-gradient(135deg, rgb(32, 1, 28), rgb(159, 166, 255));
    padding: 20px 0;
    text-align: center;
    animation: slideDown 1s ease-in-out;
  }

  .header h1 {
    font-family: 'Pacifico', cursive;
    font-size: 2.8rem;
    color: white;
    text-shadow: 2px 2px #00000033;
  }

  @keyframes slideDown {
    from {
      transform: translateY(-100%);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .login-card {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    padding: 40px;
    animation: fadeIn 1.5s ease;
  }

  @keyframes fadeIn {
    from {
      transform: translateY(30px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .btn-login {
    background: #ff6b6b;
    border: none;
    font-weight: bold;
    transition: background 0.3s;
    color: white;
  }

  .btn-login:hover {
    background: #ee5253;
  }

  .form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.4);
  }

  .error-message {
    color: #c0392b;
    font-weight: bold;
    text-align: center;
  }

  .footer-text {
    text-align: center;
    color: #fff;
    margin-top: 20px;
  }
</style>

<body>
  <div class="header">
    <h1>C12 Restaurant Admin</h1>
  </div>

  <div class="container mt-5 pb-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="login-card">
          <h4 class="text-center mb-4">Reset Your Password</h4>
          <p class="text-center text-muted">Enter your registered email to receive reset instructions.</p>

          <?php if (isset($success)) { ?>
            <div class="alert alert-success text-center"><?php echo $success; ?></div>
          <?php } ?>
          <?php if (isset($err)) { ?>
            <div class="alert alert-danger text-center"><?php echo $err; ?></div>
          <?php } ?>

          <form method="post" role="form">
            <div class="form-group mb-4">
              <label for="reset_email">Email Address</label>
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                </div>
                <input class="form-control" required name="reset_email" placeholder="Email" type="email">
              </div>
            </div>

            <div style="display:none">
              <input type="text" value="<?php echo $tk; ?>" name="reset_token">
              <input type="text" value="<?php echo $rc; ?>" name="reset_code">
              <input type="text" value="Pending" name="reset_status">
            </div>

            <div class="text-center">
              <button type="submit" name="reset_pwd" class="btn btn-login btn-block">Send Reset Link</button>
              <a href="index.php" class="btn btn-success btn-block mt-2">Back to Login</a>
            </div>
          </form>
        </div>

        <div class="footer-text mt-4">
          <small>&copy; <?php echo date('Y'); ?> C12 Restaurant  | All Rights Reserved</small>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
