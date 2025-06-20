<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $adn = "DELETE FROM  rpos_products  WHERE  prod_id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=products.php");
    } else {
        $err = "Try Again Later";
    }
}
require_once('partials/_head.php');
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        background-color: #f8f9fe;
        font-size: 18px;
        font-weight: bold;
        color: #34495e;
        border-bottom: 1px solid #e4e4e4;
    }

    .table th, .table td {
        vertical-align: middle !important;
        text-align: center;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 14px;
    }

    .btn-outline-success {
        font-weight: 500;
        border-radius: 5px;
    }

    .table img {
        height: 60px;
        width: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .header {
        position: relative;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .mask {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: rgba(0,0,0,0.6);
        border-radius: 0;
    }

    .main-content {
        background-color: #f4f6f9;
        min-height: 100vh;
    }
</style>

<body>
    <?php require_once('partials/_sidebar.php'); ?>

    <div class="main-content">
        <?php require_once('partials/_topnav.php'); ?>

        <div style="background-image: url(../admin/assets/img/theme/restro00.jpg);" class="header pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body"></div>
            </div>
        </div>

        <div class="container-fluid mt--8">
            <div class="row">
                <div class="col">
                    <div class="card shadow border-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Food Items</span>
                            <a href="add_product.php" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-plus"></i> Add New Product
                            </a>
                        </div>

                        <div class="table-responsive px-4 py-3">
                            <table class="table align-items-center table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Code</th>
                                        <th>Name</th>
                                        <th>Price (₹)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  rpos_products  ORDER BY `rpos_products`.`created_at` DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($prod = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="../admin/assets/img/products/<?php echo $prod->prod_img ? $prod->prod_img : 'default.jpg'; ?>">
                                            </td>
                                            <td><?php echo $prod->prod_code; ?></td>
                                            <td><?php echo $prod->prod_name; ?></td>
                                            <td>₹ <?php echo $prod->prod_price; ?></td>
                                            <td>
                                                <a href="update_product.php?update=<?php echo $prod->prod_id; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Update
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

         
        </div>
    </div>

    <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
