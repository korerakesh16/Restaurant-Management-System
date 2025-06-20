<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['addProduct'])) {
  if (empty($_POST["prod_code"]) || empty($_POST["prod_name"]) || empty($_POST['prod_desc']) || empty($_POST['prod_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $prod_id = $_POST['prod_id'];
    $prod_code  = $_POST['prod_code'];
    $prod_name = $_POST['prod_name'];
    $prod_img = $_FILES['prod_img']['name'];
    move_uploaded_file($_FILES["prod_img"]["tmp_name"], "assets/img/products/" . $_FILES["prod_img"]["name"]);
    $prod_desc = $_POST['prod_desc'];
    $prod_price = $_POST['prod_price'];

    $postQuery = "INSERT INTO rpos_products (prod_id, prod_code, prod_name, prod_img, prod_desc, prod_price ) VALUES(?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('ssssss', $prod_id, $prod_code, $prod_name, $prod_img, $prod_desc, $prod_price);
    $postStmt->execute();

    if ($postStmt) {
      $success = "Product Added" && header("refresh:1; url=add_product.php");
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

    <div class="header pb-8 pt-5 pt-md-8" style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover; position: relative;">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body text-white">
          <h2 class="display-4">Add New Product</h2>
          <p class="lead">Fill in the form below to add a new product to the system.</p>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
          <div class="card shadow border-0">
            <div class="card-header bg-transparent">
              <h3 class="mb-0">Please Fill All Fields</h3>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row mb-3">
                  <div class="form-group col-md-6">
                    <label for="prod_name">Product Name</label>
                    <input type="text" name="prod_name" class="form-control" required>
                    <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="prod_code">Product Code</label>
                    <input type="text" name="prod_code" value="<?php echo $alpha . '-' . $beta; ?>" class="form-control" required>
                  </div>
                </div>

                <div class="form-row mb-3">
                  <div class="form-group col-md-6">
                    <label for="prod_img">Product Image</label>
                    <input type="file" name="prod_img" class="form-control-file" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="prod_price">Product Price (₹)</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">₹</span>
                      </div>
                      <input type="text" name="prod_price" class="form-control" required>
                    </div>
                  </div>
                </div>

                <div class="form-group mb-3">
                  <label for="prod_desc">Product Description</label>
                  <textarea name="prod_desc" rows="5" class="form-control" placeholder="Enter product description here..." required></textarea>
                </div>

                <div class="form-group">
                  <input type="submit" name="addProduct" value="Add Product" class="btn btn-success px-4">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    
    </div>
  </div>

  <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
