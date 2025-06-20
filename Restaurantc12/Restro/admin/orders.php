<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
?>

<body>
  <?php require_once('partials/_sidebar.php'); ?>

  <div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>

    <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover; position: relative;">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body text-white">
          <h2 class="display-4">Order Your Favorite Product</h2>
          <p class="lead">Click on any product to place an order</p>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
          <div class="card shadow border-0">
            <div class="card-header bg-transparent">
              <h3 class="mb-0 text-primary">Select a Product to Make an Order</h3>
            </div>
            <div class="table-responsive p-4">
              <table class="table table-hover table-striped align-items-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
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
                        <?php if ($prod->prod_img): ?>
                          <img src="assets/img/products/<?php echo $prod->prod_img; ?>" class="img-thumbnail" height="60" width="60">
                        <?php else: ?>
                          <img src="assets/img/products/default.jpg" class="img-thumbnail" height="60" width="60">
                        <?php endif; ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td><?php echo $prod->prod_name; ?></td>
                      <td>₹ <?php echo $prod->prod_price; ?></td>
                      <td>
                        <a href="make_oder.php?prod_id=<?php echo $prod->prod_id; ?>&prod_name=<?php echo $prod->prod_name; ?>&prod_price=<?php echo $prod->prod_price; ?>">
                          <button class="btn btn-sm btn-warning">
                            <i class="fas fa-cart-plus"></i> Place Order
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
