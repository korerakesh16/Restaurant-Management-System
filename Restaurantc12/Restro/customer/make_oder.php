<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['make'])) {
    if (empty($_POST["order_code"]) || empty($_POST["customer_name"]) || empty($_GET['prod_price'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $order_id = $_POST['order_id'];
        $order_code  = $_POST['order_code'];
        $customer_id = $_SESSION['customer_id'];
        $customer_name = $_POST['customer_name'];
        $prod_id  = $_GET['prod_id'];
        $prod_name = $_GET['prod_name'];
        $prod_price = $_GET['prod_price'];
        $prod_qty = $_POST['prod_qty'];

        $postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        $rc = $postStmt->bind_param('ssssssss', $prod_qty, $order_id, $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
        $postStmt->execute();
        if ($postStmt) {
            $success = "Order Submitted" && header("refresh:1; url=payments.php");
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
        <?php require_once('partials/_topnav.php'); ?>

        <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body"></div>
            </div>
        </div>

        <div class="container-fluid mt--8">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <h3 class="mb-0 text-dark font-weight-bold">Please Fill All Fields</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Customer Name</label>
                                        <?php
                                        $customer_id = $_SESSION['customer_id'];
                                        $ret = "SELECT * FROM rpos_customers WHERE customer_id = '$customer_id'";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($cust = $res->fetch_object()) {
                                        ?>
                                            <input class="form-control" readonly name="customer_name" value="<?php echo $cust->customer_name; ?>">
                                        <?php } ?>
                                        <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Order Code</label>
                                        <input type="text" readonly name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <?php
                                $prod_id = $_GET['prod_id'];
                                $ret = "SELECT * FROM rpos_products WHERE prod_id = '$prod_id'";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($prod = $res->fetch_object()) {
                                ?>
                                    <div class="form-row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Product Price (₹)</label>
                                            <input type="text" readonly name="prod_price" value="₹ <?php echo $prod->prod_price; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Product Quantity</label>
                                            <input type="text" name="prod_qty" class="form-control" placeholder="Enter quantity">
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-row">
                                    <div class="col-md-12 text-right">
                                        <input type="submit" name="make" value="Make Order" class="btn btn-success btn-lg shadow-sm">
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
    <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
