<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = "DELETE FROM  rpos_customers  WHERE  customer_id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=customes.php");
    } else {
        $err = "Try Again Later";
    }
}
require_once('partials/_head.php');
?>

<body>
    <?php require_once('partials/_sidebar.php'); ?>

    <div class="main-content">
        <?php require_once('partials/_topnav.php'); ?>

        <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h2 class="text-white d-inline-block mb-0">Customer Management</h2>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="add_customer.php" class="btn btn-sm btn-success">
                                <i class="fas fa-user-plus"></i> Add New Customer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow border-0">
                        <div class="card-header bg-transparent">
                            <h3 class="mb-0">Customer List</h3>
                        </div>
                        <div class="table-responsive p-4">
                            <table class="table align-items-center table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  rpos_customers  ORDER BY `rpos_customers`.`created_at` DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($cust = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cust->customer_name; ?></td>
                                            <td><?php echo $cust->customer_phoneno; ?></td>
                                            <td><?php echo $cust->customer_email; ?></td>
                                            <td>
                                                <a href="update_customer.php?update=<?php echo $cust->customer_id; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-user-edit"></i> Update
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
