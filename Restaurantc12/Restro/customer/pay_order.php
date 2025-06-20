<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');
check_login();

if (isset($_POST['pay'])) {
    if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $pay_Code = $_POST['pay_code'];

        if (strlen($pay_Code) < 10 || strlen($pay_Code) > 10) {
            $err = "Payment Code Verification Failed, Please Try Again";
        } else {
            $pay_code = $_POST['pay_code'];
            $order_code = $_GET['order_code'];
            $customer_id = $_GET['customer_id'];
            $pay_amt = $_POST['pay_amt'];
            $pay_method = $_POST['pay_method'];
            $pay_id = $_POST['pay_id'];
            $order_status = $_GET['order_status'];

            $postQuery = "INSERT INTO rpos_payments (pay_id, pay_code, order_code, customer_id, pay_amt, pay_method) VALUES(?,?,?,?,?,?)";
            $upQry = "UPDATE rpos_orders SET order_status =? WHERE order_code =?";

            $postStmt = $mysqli->prepare($postQuery);
            $upStmt = $mysqli->prepare($upQry);

            $rc = $postStmt->bind_param('ssssss', $pay_id, $pay_code, $order_code, $customer_id, $pay_amt, $pay_method);
            $rc = $upStmt->bind_param('ss', $order_status, $order_code);

            $postStmt->execute();
            $upStmt->execute();

            if ($upStmt && $postStmt) {
                $success = "Paid" && header("refresh:1; url=payments_reports.php");
            } else {
                $err = "Please Try Again Or Try Later";
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

        $order_code = $_GET['order_code'];
        $ret = "SELECT * FROM rpos_orders WHERE order_code ='$order_code'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($order = $res->fetch_object()) {
          $total = ((float)$order->prod_price * (int)$order->prod_qty);

        ?>
            <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;">
                <span class="mask bg-gradient-dark opacity-8"></span>
                <div class="container-fluid">
                    <div class="header-body"></div>
                </div>
            </div>

            <div class="container-fluid mt--8">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header bg-white border-0">
                                <h3 class="mb-0 text-dark font-weight-bold">Please Fill All Fields</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-row mb-3">
                                        <div class="col-md-6">
                                            <label class="font-weight-bold">Payment ID</label>
                                            <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>" class="form-control shadow-sm">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="font-weight-bold">Payment Code</label>
                                            <small class="text-danger d-block">Type 10 Digits Alpha-Code If Payment Method Is In Cash</small>
                                            <input type="text" maxlength="10" name="pay_code" placeholder="<?php echo $mpesaCode; ?>" class="form-control shadow-sm">
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="col-md-6">
                                            <label class="font-weight-bold">Amount (₹)</label>
                                            <input type="text" name="pay_amt" readonly value="<?php echo number_format($total, 2); ?>" class="form-control shadow-sm">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="font-weight-bold">Payment Method</label>
                                            <select class="form-control shadow-sm" name="pay_method">
                                                <option selected>Cash</option>
                                                <option>Paypal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <input type="submit" name="pay" value="Pay Order" class="btn btn-success shadow-sm px-4">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php require_once('partials/_footer.php'); ?>
            </div>
    </div>
    <?php require_once('partials/_scripts.php');
        }
    ?>
</body>

</html>
