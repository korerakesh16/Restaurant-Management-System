<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['UpdateProduct'])) {
  if (empty($_POST["prod_code"]) || empty($_POST["prod_name"]) || empty($_POST['prod_desc']) || empty($_POST['prod_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $update = $_GET['update'];
    $prod_code  = $_POST['prod_code'];
    $prod_name = $_POST['prod_name'];
    $prod_img = $_FILES['prod_img']['name'];
    move_uploaded_file($_FILES["prod_img"]["tmp_name"], "../admin/assets/img/products/" . $_FILES["prod_img"]["name"]);
    $prod_desc = $_POST['prod_desc'];
    $prod_price = $_POST['prod_price'];

    $postQuery = "UPDATE rpos_products SET prod_code =?, prod_name =?, prod_img =?, prod_desc =?, prod_price =? WHERE prod_id = ?";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('ssssss', $prod_code, $prod_name, $prod_img, $prod_desc, $prod_price, $update);
    $postStmt->execute();

    if ($postStmt) {
      $success = "Product Updated" && header("refresh:1; url=products.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
  }

  .card {
    border-radius: 10px;
  }

  .card-header h3 {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
  }

  label {
    font-weight: 500;
  }

  .form-control {
    border-radius: 8px;
  }

  .btn-success {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 6px;
  }

  .header {
    position: relative;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
  }

  .mask {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.6);
  }

  textarea.form-control {
    resize: none;
  }

  .main-content {
    min-height: 100vh;
  }
</style>

<body>
  <?php require_once('partials/_sidebar.php'); ?>

  <div class="main-content">
    <?php
    require_once('partials/_topnav.php');
    $update = $_GET['update'];
    $ret = "SELECT * FROM  rpos_products WHERE prod_id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
    ?>
      <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
        <span class="mask bg-gradient-dark opacity-8"></span>
        <div class="container-fluid">
          <div class="header-body"></div>
        </div>
      </div>

      <div class="container-fluid mt--8">
        <div class="row">
          <div class="col">
            <div class="card shadow border-0">
              <div class="card-header bg-white">
                <h3 class="mb-0">Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label>Product Name</label>
                      <input type="text" value="<?php echo $prod->prod_name; ?>" name="prod_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Product Code</label>
                      <input type="text" name="prod_code" value="<?php echo $prod->prod_code; ?>" class="form-control">
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label>Product Image</label>
                      <input type="file" name="prod_img" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Product Price (₹)</label>
                      <input type="text" name="prod_price" class="form-control" value="<?php echo $prod->prod_price; ?>">
                    </div>
                  </div>

                  <div class="form-row mb-4">
                    <div class="col-md-12">
                      <label>Product Description</label>
                      <textarea rows="5" name="prod_desc" class="form-control"><?php echo $prod->prod_desc; ?></textarea>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="UpdateProduct" value="Update Product" class="btn btn-success">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    <?php } ?>
  </div>

  <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
