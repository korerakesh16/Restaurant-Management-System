<?php
session_start();
include('config/config.php');

if (isset($_POST['addCustomer'])) {
    if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email']) || empty($_POST['customer_password'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $customer_name = $_POST['customer_name'];
        $customer_phoneno = $_POST['customer_phoneno'];
        $customer_email = $_POST['customer_email'];
        $customer_password = sha1(md5($_POST['customer_password']));
        $customer_id = $_POST['customer_id'];

        $postQuery = "INSERT INTO rpos_customers (customer_id, customer_name, customer_phoneno, customer_email, customer_password) VALUES(?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        $rc = $postStmt->bind_param('sssss', $customer_id, $customer_name, $customer_phoneno, $customer_email, $customer_password);
        $postStmt->execute();

        if ($postStmt) {
            $success = "Customer Account Created" && header("refresh:1; url=index.php");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}
require_once('partials/_head.php');
require_once('config/code-generator.php');
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
</style>

<body>
    <div class="header">
        <h1>C12 Restaurant Admin</h1>
    </div>

    <div class="container mt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="login-card">
                    <form method="post" role="form">
                        <div class="form-group">
                            <label>Full Name</label>
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" required name="customer_name" type="text">
                                <input class="form-control" type="hidden" value="<?php echo $cus_id; ?>" name="customer_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input class="form-control" required name="customer_phoneno" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" required name="customer_email" type="email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" required name="customer_password" type="password">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" name="addCustomer" class="btn btn-login btn-block">Create Account</button>
                            <a href="index.php" class="btn btn-success btn-block mt-2">Already have an account? Log In</a>
                        </div>
                    </form>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="../admin/forgot_pwd.php" target="_blank" class="text-dark">
                                <small>Forgot password?</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('partials/_footer.php'); ?>
    <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
