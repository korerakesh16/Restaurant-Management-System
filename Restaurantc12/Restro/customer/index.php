<?php
session_start();
include('config/config.php');

if (isset($_POST['login'])) {
    // Fetch input
    $input_email = $_POST['customer_email'];
    $input_password = sha1(md5($_POST['customer_password'])); // double hashed

    // Prepare SQL
    $stmt = $mysqli->prepare("SELECT customer_id FROM rpos_customers WHERE customer_email = ? AND customer_password = ?");
    $stmt->bind_param('ss', $input_email, $input_password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($customer_id);
        $stmt->fetch();
        $_SESSION['customer_id'] = $customer_id;
        header("location:dashboard.php");
        exit();
    } else {
        $err = "Incorrect Email or Password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Pacifico&display=swap" rel="stylesheet">
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

<!-- Page content -->
<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card login-card">
                <div class="card-body px-lg-5 py-lg-5">

                    <!-- Show error if any -->
                    <?php if (isset($err)) : ?>
                        <div class="alert alert-danger error-message"><?php echo $err; ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" required name="customer_email" placeholder="Email" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" required name="customer_password" placeholder="Password" type="password">
                            </div>
                        </div>
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                            <label class="custom-control-label" for="customCheckLogin">
                                <span class="text-muted">Remember me</span>
                            </label>
                        </div>
                        <div class="form-group text-left mt-3">
                            <button type="submit" name="login" class="btn btn-login text-white">Log In</button>
                            <a href="create_account.php" class="btn btn-success float-right">Create Account</a>
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

<!-- Optional JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
