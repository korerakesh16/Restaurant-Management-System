<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $adn = "DELETE FROM rpos_products WHERE prod_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id); // use 'i' for integer
  if ($stmt->execute()) {
    $stmt->close();
    $success = "Deleted Successfully";
    header("refresh:1; url=products.php");
  } else {
    $stmt->close();
    $err = "Try Again Later";
  }
}

require_once('partials/_head.php');
?>

<style>
  body {
    background-color: #f8f9fa;
  }
  .btn-custom-add {
    background-color: #28a745;
    color: white;
    border-radius: 25px;
    padding: 8px 18px;
    font-weight: 500;
  }
  .btn-custom-add:hover {
    background-color: #218838;
    color: white;
  }
  .btn-custom-action {
    border-radius: 20px;
    font-weight: 500;
  }
  .table thead th {
    background-color: #e9ecef;
    color: #495057;
  }
  .img-thumbnail {
    border-radius: 10px;
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
      <?php if (isset($success)) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $success; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } elseif (isset($err)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $err; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center border-0">
              <h3 class="mb-0">Product Management</h3>
              <a href="add_product.php" class="btn btn-custom-add">
                <i class="fas fa-utensils"></i> Add New Product
              </a>
            </div>
            <div class="table-responsive px-3 pb-4">
              <table class="table table-bordered table-hover align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_products";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td>
                        <?php
                        if ($prod->prod_img) {
                          echo "<img src='assets/img/products/$prod->prod_img' height='60' width='60' class='img-thumbnail'>";
                        } else {
                          echo "<img src='assets/img/products/default.jpg' height='60' width='60' class='img-thumbnail'>";
                        }
                        ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td><?php echo $prod->prod_name; ?></td>
                      <td>₹ <?php echo $prod->prod_price; ?></td>
                      <td>
                        <a href="products.php?delete=<?php echo $prod->prod_id; ?>" class="btn btn-sm btn-danger btn-custom-action me-2" onclick="return confirm('Are you sure you want to delete this product?');">
                          <i class="fas fa-trash"></i> Delete
                        </a>
                        <a href="update_product.php?update=<?php echo $prod->prod_id; ?>" class="btn btn-sm btn-primary btn-custom-action">
                          <i class="fas fa-edit"></i> Update
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
