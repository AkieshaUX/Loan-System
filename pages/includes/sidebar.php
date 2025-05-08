<style>
  tr,
  td {
    text-transform: capitalize !important;
    white-space: nowrap !important;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  .fade-in {
    animation: fadeIn 1s ease-in-out;
  }

  .sidebar .dashboard-sidebar {
    margin: 10px 0 !important;
  }

  section.content.Pages {
    padding: 3rem 0;
  }

  label {
    color: #666 !important;
  }

  .modal-dialog.piedad {
    max-width: 400px !important;
  }
</style>
<?php
include '../inc/conn.php';
include '../inc/function.php';

?>
<div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__shake" src="../../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div>


<nav class="main-header navbar navbar-expand navbar-light">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="dashboard.php" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li>
  </ul>



</nav>



<aside class="main-sidebar sidebar-dark-primary elevation-4">


  <a href="dashboard.php" class="brand-link">
    <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 text-white" style="opacity: .8">
    <span class="brand-text font-weight-light">Pineapple Wine</span>
  </a>

  <div class="sidebar  pt-2">



    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>


    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item menu-open">
          <ul class="nav nav-treeview">
            <li class="nav-item dashboard-sidebar">
              <a href="dashboard.php" class="nav-link active">
                <i class="fa-solid fa-chart-line nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-header">LOAN</li>

        <li class="nav-item   menu-open">
          <a href="member-list.php" class="nav-link">
            <i class="fa-solid fa-user-group nav-icon"></i>
            <p> Members</p>
          </a>
        </li>

        <li class="nav-item  menu-open">
          <a href="loan-list.php" class="nav-link">
          <i class="fa-solid fa-landmark nav-icon"></i>
            <p>Loan</p>
          </a>
        </li>


        <li class="nav-item  menu-open">
          <a href="funds-list.php" class="nav-link">
          <i class="fa-solid fa-money-check-dollar nav-icon"></i>
            <p>Funds</p>
          </a>
        </li>


        <li class="nav-item  menu-open">
          <a href="paid-history.php" class="nav-link">
          <i class="fa-solid fa-money-bill nav-icon"></i>
            <p>Payment History</p>
          </a>
        </li>



        <li class="nav-header">INVENTORY</li>

        <li class="nav-item menu-open">
          <a href="product-list.php" class="nav-link">
          <i class="fa-solid fa-layer-group nav-icon"></i>
            <p>Product</p>
          </a>
        </li>



        <li class="nav-item menu-open">
          <a href="order.php" class="nav-link">
          <i class="fa-solid fa-cart-shopping nav-icon"></i>
            <p>Order</p>
          </a>
        </li>


        <li class="nav-item menu-open">
          <a href="stocks.php" class="nav-link">
          <i class="fa-solid fa-boxes-stacked nav-icon"></i>
            <p>Stocks</p>
          </a>
        </li>





        <li class="nav-item menu-open">
          <a href="miscellaneous.php" class="nav-link">
          <i class="fa-solid fa-money-bills nav-icon"></i>
            <p>Miscellaneous</p>
          </a>
        </li>

        <li class="nav-header">REPORTS</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-circle-info nav-icon"></i>
            <p>
              Reports
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="sold.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sales</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="loan.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Loan</p>
              </a>
            </li>
          </ul>
        </li>


      </ul>
    </nav>

  </div>

</aside>