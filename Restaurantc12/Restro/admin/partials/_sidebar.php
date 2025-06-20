<?php
$admin_id = $_SESSION['admin_id'];
$ret = "SELECT * FROM  rpos_admin  WHERE admin_id = '$admin_id'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($admin = $res->fetch_object()) {
?>

<!-- Custom Styling -->
<style>
  #sidenav-main {
    background-color:rgb(1, 4, 19);
    border-right: 1px solidrgb(30, 9, 9);
  }

  .navbar-brand-img {
    max-height: 60px;
  }

  .navbar-nav .nav-link {
    font-weight: 500;
    color: #5e72e4 !important;
    padding: 10px 15px;
    border-radius: 8px;
    transition: background 0.2s ease;
  }

  .navbar-nav .nav-link:hover {
    background-color:rgb(86, 204, 100);
    color: #324cdd !important;
  }

  .navbar-nav .nav-link i {
    margin-right: 8px;
  }

  .navbar-heading {
    font-size: 0.9rem;
    text-transform: uppercase;
    padding: 0 15px;
    margin-top: 15px;
    color: #8898aa;
  }

  .collapse-header {
    background-color: #fff;
    padding: 1rem;
  }

  .form-control-rounded {
    border-radius: 20px;
  }

  .input-group-text {
    background-color: transparent;
    border: none;
  }

  .nav-link-icon {
    color: #5e72e4 !important;
  }

  .dropdown-item:hover {
    background-color:rgb(13, 13, 13);
    color: #5e72e4;
  }

  hr.my-3 {
    border-top: 1px solidrgb(144, 169, 105);
    margin: 1.5rem 0;
  }
</style>

<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white shadow-sm" id="sidenav-main">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
      aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand pt-0" href="dashboard.php">
      <h1>Home</h1>
    </>
    <ul class="nav align-items-center d-md-none">
      <li class="nav-item dropdown">
        <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <i class="ni ni-bell-55"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right"></div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="media align-items-center">
            <span class="avatar avatar-sm rounded-circle">
              <img alt="Image placeholder" src="assets/img/theme/team-1-800x800.jpg">
            </span>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
          <div class="dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome!</h6>
          </div>
          <a href="change_profile.php" class="dropdown-item">
            <i class="ni ni-single-02"></i>
            <span>My profile</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item">
            <i class="ni ni-user-run"></i>
            <span>Logout</span>
          </a>
        </div>
      </li>
    </ul>
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
      <div class="navbar-collapse-header d-md-none">
        <div class="row">
          <div class="col-6 collapse-brand">
            <a href="dashboard.php">
              <img src="assets/img/brand/repos.png" style="max-height: 50px;">
            </a>
          </div>
          <div class="col-6 collapse-close">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main"
              aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>
      <form class="mt-4 mb-3 d-md-none">
        <div class="input-group input-group-rounded input-group-merge">
          <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search"
            aria-label="Search">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <span class="fa fa-search"></span>
            </div>
          </div>
        </div>
      </form>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="ni ni-tv-2 text-primary"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="hrm.php">
            <i class="fas fa-user-tie text-primary"></i> HRM
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="customes.php">
            <i class="fas fa-users text-primary"></i> Customers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">
            <i class="ni ni-bullet-list-67 text-primary"></i> Products
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="orders.php">
            <i class="ni ni-cart text-primary"></i> Orders
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="payments.php">
            <i class="ni ni-credit-card text-primary"></i> Payments
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="receipts.php">
            <i class="fas fa-file-invoice-dollar text-primary"></i> Receipts
          </a>
        </li>
      </ul>
      <hr class="my-3">
      <h6 class="navbar-heading text-muted">Reporting</h6>
      <ul class="navbar-nav mb-md-3">
        <li class="nav-item">
          <a class="nav-link" href="orders_reports.php">
            <i class="fas fa-shopping-basket"></i> Orders
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="payments_reports.php">
            <i class="fas fa-funnel-dollar"></i> Payments
          </a>
        </li>
      </ul>
      <hr class="my-3">
      <ul class="navbar-nav mb-md-3">
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt text-danger"></i> Log Out
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php } ?>
