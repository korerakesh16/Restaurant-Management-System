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

<style>
  body {
    background-color: #f5f7fa;
  }
  .btn-custom-add {
    background-color: #28a745;
    color: white;
    border-radius: 20px;
    padding: 8px 20px;
    font-weight: 500;
  }
  .btn-custom-add:hover {
    background-color: #218838;
    color: white;
  }
  .btn-custom-delete {
    border-radius: 20px;
    font-weight: 500;
  }
  .btn-custom-update {
    border-radius: 20px;
    font-weight: 500;
  }
  .table thead th {
    background-color: #e9ecef;
    color: #343a40;
  }
</style>

<body>
  <?php require_once('partials/_sidebar.php'); ?>

  <div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>

    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body"></div>
      </div>
    </div>

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center border-0">
              <h3 class="mb-0">Customer Management</h3>
              <a href="add_customer.php" class="btn btn-custom-add">
                <i class="fas fa-user-plus"></i> Add New Customer
              </a>
            </div>
            <div class="table-responsive px-3 pb-4">
              <table class="table table-hover table-bordered align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Contact Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
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
                        <a href="customes.php?delete=<?php echo $cust->customer_id; ?>" class="btn btn-sm btn-danger btn-custom-delete me-2">
                          <i class="fas fa-trash"></i> Delete
                        </a>
                        <a href="update_customer.php?update=<?php echo $cust->customer_id; ?>" class="btn btn-sm btn-primary btn-custom-update">
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
