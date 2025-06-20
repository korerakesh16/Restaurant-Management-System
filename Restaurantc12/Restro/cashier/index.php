<?php
session_start();
include('config/config.php');
// login 
if (isset($_POST['login'])) {
  $staff_email = $_POST['staff_email'];
  $staff_password = sha1(md5($_POST['staff_password'])); // double encrypt to increase security
  $stmt = $mysqli->prepare("SELECT staff_email, staff_password, staff_id FROM rpos_staff WHERE (staff_email =? AND staff_password =?)");
  $stmt->bind_param('ss',  $staff_email, $staff_password);
  $stmt->execute();
  $stmt->bind_result($staff_email, $staff_password, $staff_id);
  $rs = $stmt->fetch();
  $_SESSION['staff_id'] = $staff_id;
  if ($rs) {
    header("location:dashboard.php");
  } else {
    $err = "Incorrect Authentication Credentials ";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Pacifico&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Nunito', sans-serif;
      min-height: 100vh;
      margin: 0;
    }

    .header {
      background: linear-gradient(135deg,rgb(32, 1, 28),rgb(159, 166, 255));
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
  </style>
</head>

<body>
  <div class="main-content">
    <div class="header">
      <div class="container">
        <div class="header-body text-center mb-4">
          <h1>C12 Restaurant</h1>
        </div>
      </div>
    </div>

    <div class="container mt-5 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card login-card border-0">
            <div class="card-body">
              <?php if (isset($err)) { echo "<p class='error-message'>$err</p>"; } ?>
              <form method="post" role="form">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" required name="staff_email" placeholder="Email" type="email">
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" required name="staff_password" placeholder="Password" type="password">
                  </div>
                </div>

                <div class="custom-control custom-checkbox mb-3">
                  <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for="customCheckLogin">
                    <span class="text-muted">Remember me</span>
                  </label>
                </div>

                <div class="text-center">
                  <button type="submit" name="login" class="btn btn-login my-3 w-100">Log In</button>
                </div>
              </form>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-6">
              <!-- <a href="forgot_pwd.php" class="text-light"><small>Forgot password?</small></a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
