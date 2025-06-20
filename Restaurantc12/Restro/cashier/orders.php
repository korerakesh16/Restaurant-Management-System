<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
?>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
  }

  .card-header {
    font-weight: 600;
    font-size: 1.2rem;
    background-color: #fff;
  }

  .table th,
  .table td {
    vertical-align: middle !important;
  }

  .btn-warning {
    font-weight: 500;
    border-radius: 6px;
    padding: 6px 12px;
  }

  .img-thumbnail {
    border-radius: 6px;
    object-fit: cover;
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
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
  }

  .thead-light th {
    background-color: #e9ecef;
    color: #495057;
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
            <div class="card-header">
              Select Any Product To Make An Order
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price (₹)</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_products ORDER BY `created_at` DESC";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td>
                        <?php
                        $img_path = $prod->prod_img ? $prod->prod_img : 'default.jpg';
                        echo "<img src='../admin/assets/img/products/$img_path' height='60' width='60' class='img-thumbnail'>";
                        ?>
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
