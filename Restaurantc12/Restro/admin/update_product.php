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
    move_uploaded_file($_FILES["prod_img"]["tmp_name"], "assets/img/products/" . $_FILES["prod_img"]["name"]);
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

<body>
  <?php require_once('partials/_sidebar.php'); ?>
  <div class="main-content">
    <?php
    require_once('partials/_topnav.php');
    $update = $_GET['update'];
    $ret = "SELECT * FROM rpos_products WHERE prod_id = '$update'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
    ?>
      <div class="header pb-8 pt-5 pt-md-8" style="background-image: url('assets/img/theme/restro00.jpg'); background-size: cover;">
        <span class="mask bg-gradient-dark opacity-8"></span>
        <div class="container-fluid">
          <div class="header-body"></div>
        </div>
      </div>

      <div class="container-fluid mt--8">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-12">
            <div class="card shadow border-0">
              <div class="card-header bg-transparent">
                <h3 class="mb-0 text-center">Update Product Details</h3>
              </div>
              <div class="card-body px-5 py-4">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label class="font-weight-bold">Product Name</label>
                      <input type="text" value="<?php echo $prod->prod_name; ?>" name="prod_name" class="form-control rounded">
                    </div>
                    <div class="col-md-6">
                      <label class="font-weight-bold">Product Code</label>
                      <input type="text" name="prod_code" value="<?php echo $prod->prod_code; ?>" class="form-control rounded">
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label class="font-weight-bold">Product Image</label>
                      <input type="file" name="prod_img" class="form-control-file border p-2 rounded">
                    </div>
                    <div class="col-md-6">
                      <label class="font-weight-bold">Product Price (₹)</label>
                      <input type="text" name="prod_price" class="form-control rounded" value="<?php echo $prod->prod_price; ?>">
                    </div>
                  </div>

                  <div class="form-group mb-4">
                    <label class="font-weight-bold">Product Description</label>
                    <textarea rows="5" name="prod_desc" class="form-control rounded"><?php echo $prod->prod_desc; ?></textarea>
                  </div>

                  <div class="text-center">
                    <input type="submit" name="UpdateProduct" value="Update Product" class="btn btn-success btn-lg rounded-pill px-4">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    <?php } ?> <!-- ✅ This closes the while loop -->
  </div>
  <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
