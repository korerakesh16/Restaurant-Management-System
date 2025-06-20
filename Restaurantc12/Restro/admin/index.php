<?php
session_start();
include('config/config.php');

if (isset($_POST['login'])) {
  $admin_email = $_POST['admin_email'];
  $admin_password = sha1(md5($_POST['admin_password']));
  $stmt = $mysqli->prepare("SELECT admin_email, admin_password, admin_id FROM rpos_admin WHERE (admin_email =? AND admin_password =?)");
  $stmt->bind_param('ss', $admin_email, $admin_password);
  $stmt->execute();
  $stmt->bind_result($admin_email, $admin_password, $admin_id);
  $rs = $stmt->fetch();
  $_SESSION['admin_id'] = $admin_id;
  if ($rs) {
    header("location:dashboard.php");
  } else {
    $err = "Incorrect Authentication Credentials";
  }
}
require_once('partials/_head.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>C12 Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600&display=swap" rel="stylesheet">
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

  <div class="header">
    <h1>C12 Restaurant Admin</h1>
  </div>

  <div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-6 col-lg-5">
      <div class="login-card">
        <h3 class="text-center mb-4 text-danger fw-bold">Admin Login</h3>
        <form method="post">
          <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="admin_email" class="form-control" placeholder="Enter your email" required>
          </div>
          <div class="form-group mb-4">
            <label>Password</label>
            <input type="password" name="admin_password" class="form-control" placeholder="Enter your password" required>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember Me</label>
          </div>
          <div class="d-grid">
            <button type="submit" name="login" class="btn btn-login py-2">Log In</button>
          </div>
          <?php if (isset($err)) echo "<p class='mt-3 error-message'>$err</p>"; ?>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
