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

    <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover; background-position: center;">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body"></div>
      </div>
    </div>

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0 bg-white">
              <h3 class="mb-0 text-dark font-weight-bold">Select Any Product To Make An Order</h3>
            </div>
            <div class="table-responsive">
              <table class="table table-hover align-items-center table-bordered">
                <thead class="thead-light text-center">
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price (₹)</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php
                  $ret = "SELECT * FROM  rpos_products  ORDER BY `rpos_products`.`created_at` DESC ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td>
                        <?php
                        $img = $prod->prod_img ? $prod->prod_img : 'default.jpg';
                        echo "<img src='../admin/assets/img/products/$img' class='img-fluid rounded' height='60' width='60'>";
                        ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td><?php echo $prod->prod_name; ?></td>
                      <td><span class="text-success font-weight-bold">₹ <?php echo $prod->prod_price; ?></span></td>
                      <td>
                        <a href="make_oder.php?prod_id=<?php echo $prod->prod_id; ?>&prod_name=<?php echo $prod->prod_name; ?>&prod_price=<?php echo $prod->prod_price; ?>">
                          <button class="btn btn-sm btn-warning shadow-sm">
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

      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>
  <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
