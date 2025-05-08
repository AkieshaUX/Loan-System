<?php include '../inc/session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php include 'includes/link.php' ?>

</head>
<style>
  .small-box .icon>i {
    font-size: 60px !important;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: -webkit-transform .3s linear;
    transition: transform .3s linear;
    transition: transform .3s linear, -webkit-transform .3s linear;
  }

  .bg-warning,
  .bg-warning>a {
    color: #fff !important;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>
    <div class="content-wrapper">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">

            </div>
          </div>
        </div>
      </div>



      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-3 col-6">
              <?php
              $currentMonth = date('m');
              $currentYear = date('Y');

              $sql = "SELECT SUM(totalincome) AS monthly_sales 
              FROM orderproduct 
              WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear' AND status = 'Buy' ";

              $result = mysqli_query($conn, $sql);
              $row = mysqli_fetch_assoc($result);

              $monthlySales = $row['monthly_sales'] ?? 0;
              ?>
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo number_format($monthlySales, 2); ?></h3>
                  <p>SALES FOR THIS MONTH</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <a href="sold.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <div class="col-lg-3 col-6">
              <?php

              $lastMonth = date('m', strtotime('-1 month'));
              $lastMonthYear = date('Y', strtotime('-1 month'));
              $sqlLastMonth = "SELECT SUM(totalincome) AS last_month_sales 
                 FROM orderproduct 
                 WHERE MONTH(date) = '$lastMonth' AND YEAR(date) = '$lastMonthYear'AND status = 'Buy'";
              $resultLastMonth = mysqli_query($conn, $sqlLastMonth);
              $rowLastMonth = mysqli_fetch_assoc($resultLastMonth);
              $lastMonthSales = $rowLastMonth['last_month_sales'] ?? 0;
              ?>
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo number_format($lastMonthSales, 2); ?></h3>
                  <p>SALES LAST MONTH</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <a href="sold.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <div class="col-lg-3 col-6">
              <?php
              // Get the current year
              $currentYear = date('Y');

              // Query to sum all sales for years before the current year
              $sqlPreviousYears = "SELECT SUM(totalincome) AS previous_years_sales 
                          FROM orderproduct 
                          WHERE YEAR(date) < '$currentYear' AND status = 'Buy'";
              $resultPreviousYears = mysqli_query($conn, $sqlPreviousYears);
              $rowPreviousYears = mysqli_fetch_assoc($resultPreviousYears);

              // Fetch the total sales for previous years or default to 0
              $previousYearsSales = $rowPreviousYears['previous_years_sales'] ?? 0;
              ?>

              <div class="small-box bg-success">
                <div class="inner">
                  <!-- Display the formatted sales amount -->
                  <h3 style="color: #fff;"><?php echo number_format($previousYearsSales, 2); ?></h3>
                  <p style="color: #fff;">SALES FOR LAST YEARS</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <a style="color: #fff !important;" href="sold.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>



            <div class="col-lg-3 col-6">
              <?php

              $sqlOverallSales = "SELECT SUM(withdraw_income) AS overall_sales FROM orderproduct WHERE status = 'Buy'";

              $resultOverallSales = mysqli_query($conn, $sqlOverallSales);
              $rowOverallSales = mysqli_fetch_assoc($resultOverallSales);

              $overallSales = $rowOverallSales['overall_sales'] ?? 0;
              ?>

              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo number_format($overallSales, 2); ?></h3>
                  <p>Overall Sales</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <!-- <a href="purchase-summary.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                <a href="sold.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>




          </div>
          <!-- <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Loan</h1>
                </div>
                <div class="col-sm-6">

                </div>
              </div>
            </div>
          </div> -->

          <div class="row">
            <?php
            $currentYear = date("Y"); // Get the current year

            // Total Interest for the current year
            $sqlOverallSales = "SELECT SUM(interestearned) AS totalinterest FROM savings WHERE YEAR(date) = '$currentYear'";
            $resultOverallSales = mysqli_query($conn, $sqlOverallSales);
            $rowOverallSales = mysqli_fetch_assoc($resultOverallSales);
            $totalinterest = $rowOverallSales['totalinterest'] ?? 0;
            ?>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo number_format($totalinterest, 2); ?></h3>
                  <p>TOTAL INTEREST</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-chart-simple"></i>
                </div>

                <a href="#" data-toggle="modal" data-target="#modal-interestsummary" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <?php
            // Total General Fund for the current year
            $sqlOverallSales = "SELECT SUM(gfwithdraw) AS totalgenfud FROM savings";
            $resultOverallSales = mysqli_query($conn, $sqlOverallSales);
            $rowOverallSales = mysqli_fetch_assoc($resultOverallSales);
            $totalgenfud = $rowOverallSales['totalgenfud'] ?? 0;
            ?>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 style="color: #fff;"><?php echo number_format($totalgenfud, 2); ?></h3>
                  <p style="color: #fff;">TOTAL GENFUND</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-chart-simple"></i>
                </div>
                <a style="color: #fff;" href="genfund.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <?php
            // Total Capital for the current year
            $sqlOverallSales = "SELECT SUM(capitalwithdraw) AS totalcapital FROM savings WHERE YEAR(date) = '$currentYear'";
            $resultOverallSales = mysqli_query($conn, $sqlOverallSales);
            $rowOverallSales = mysqli_fetch_assoc($resultOverallSales);
            $totalcapital = $rowOverallSales['totalcapital'] ?? 0;
            ?>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 style="color: #fff;"><?php echo number_format($totalcapital, 2); ?></h3>
                  <p style="color: #fff !important;">TOTAL CAPITAL</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-chart-simple"></i>
                </div>
                <a style="color: #fff !important;" href="capital.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <?php
            // Total Profit for the current year
            $sqlOverallSales = "SELECT SUM(profitwithdraw) AS overallprofit FROM savings WHERE YEAR(date) = '$currentYear'";
            $resultOverallSales = mysqli_query($conn, $sqlOverallSales);
            $rowOverallSales = mysqli_fetch_assoc($resultOverallSales);
            $overallprofit = $rowOverallSales['overallprofit'] ?? 0;
            ?>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo number_format($overallprofit, 2); ?></h3>
                  <p>TOTAL PROFIT</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-chart-simple"></i>
                </div>
                <a href="profit.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

          </div>


          <!-- <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-primary"><i class="fa-solid fa-sack-dollar"></i></span>
                  <?php
                  $query = mysqli_query($conn, "SELECT SUM(withdraw) AS total_funds FROM funding");
                  if ($query) {
                    $result = mysqli_fetch_assoc($query);
                    $total_funds = isset($result['total_funds']) ? $result['total_funds'] : 0.00;
                  } else {
                    $total_funds = 0.00;
                  }
                  ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Available Funds</span>
                    <span class="info-box-number"><?php echo number_format($total_funds, 2); ?></span>
                  </div>
                </div>

              </div>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i style="color: #fff;" class="fa-solid fa-sack-xmark"></i></span>
                  <?php
                  $query = mysqli_query($conn, "SELECT SUM(monthlypayment) AS total_payment, SUM(monthlyinterest) AS total_interest FROM monthly_payment");

                  if ($query) {
                    $result = mysqli_fetch_assoc($query);
                    $total_payment = isset($result['total_payment']) ? $result['total_payment'] : 0.00;
                    $total_interest = isset($result['total_interest']) ? $result['total_interest'] : 0.00;
                    $net_total = $total_payment - $total_interest;
                  } else {
                    $net_total = 0.00;
                  }
                  ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Loan</span>
                    <span class="info-box-number"><?php echo number_format($net_total, 2); ?></span>
                  </div>
                </div>


              </div>


              <div class="col-md-3 col-sm-6 col-12">
                <a href="loan-list.php" style="color: black;">
                  <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fa-solid fa-user-group"></i></span>
                    <?php
                    $sql = "SELECT COUNT(*) AS total_borrower FROM `member` WHERE `mstatus` = 1";
                    $query = $conn->query($sql);
                    if ($query) {
                      $result = $query->fetch_assoc();
                      $total_borrower = $result['total_borrower'];

                    ?>
                      <div class="info-box-content">
                        <span class="info-box-text">Total Borrowers</span>
                        <span class="info-box-number"><?php echo $total_borrower ?></span>
                      </div>
                    <?php } ?>

                  </div>
                </a>

              </div>

              <div class="col-12 col-sm-6 col-md-3">
                <a href="member-list.php" style="color: black;">
                  <div class="info-box mb-3">
                    <span class="info-box-icon bg-success"><i class="fa-solid fa-user-group"></i></span>
                    <?php
                    $sql = "SELECT COUNT(*) AS total_member FROM `member` WHERE `mstatus` IN (1, 0)";
                    $query = $conn->query($sql);
                    if ($query) {
                      $result = $query->fetch_assoc();
                      $total_member = $result['total_member'];

                    ?>
                      <div class="info-box-content">
                        <span class="info-box-text">Total Members</span>
                        <span class="info-box-number"><?php echo $total_member ?></span>
                      </div>
                    <?php } ?>

                  </div>
                </a>

              </div>

            </div> -->




          <div class="row">
            <div class="col-md-7">
              <div class="card  card card-success">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Latest Order</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>
                <!-- style=" max-height: 16rem;overflow-y: scroll;" -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <!-- <th style="width: 2%;">Order ID</th> -->
                          <th>Product Name</th>
                          <th>Price </th>
                          <th>Quantity</th>
                          <th>Total Amount </th>
                          <th>Date</th>
                          <th>Status</th>


                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $displayProductBuyDashboard = displayProductBuyDashboard($conn);
                        while ($result = mysqli_fetch_array($displayProductBuyDashboard)) {
                          extract($result);
                        ?>
                          <tr>
                            <td><?php echo $ordername ?></td>
                            <!-- <td style="color: #007bff;"><?php echo $pID ?></td> -->
                            <td><?php echo $productname ?></td>
                            <td><?php echo number_format($price, 2); ?></td>
                            <td><?php echo number_format($orderquantity); ?></td>
                            <td><?php echo number_format($orderamount, 2); ?></td>

                            <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                            <td style="cursor: pointer;" id="orderreciept" class="orderreciept" data-order-id="<?php echo $order_id; ?>"
                              data-toggle="modal" data-target="#modal-viewinvoice"><span class="badge badge-success" style="color: #fff;">Delived</span>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>

                </div>

                <div class="card-footer clearfix">
                  <a href="order.php" class="btn btn-sm btn-success float-right">View All Order</a>
                </div>

              </div>
            </div>
            <div class="col-md-5">
              <div class="card card card-success">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Recently Added Stocks </h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>

                <!-- <div class="card-body">
                  <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div> -->

                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>

                          <th>Product Name</th>
                          <th>Total Qty</th>
                          <th>Date</th>

                        </tr>
                      </thead>

                      <tbody>
                        <?php



                        $query = mysqli_query($conn, "
                          SELECT product.*, productsupply.* 
                          FROM `product` 
                          INNER JOIN productsupply 
                          ON product.productsupply_id = productsupply.productsupply_id 
                          ORDER BY product.productdate DESC LIMIT 4
                        ");

                        // Check if the query returns any rows
                        if (mysqli_num_rows($query) > 0) {
                          while ($result = mysqli_fetch_array($query)) {
                            extract($result);
                        ?>
                            <tr>

                              <td><?php echo $productname; ?></td>
                              <td><?php echo $quantitytotal  . ' / ' . $quantity ?></td>
                              <td><?php echo date('M d, Y', strtotime($productdate)) ?></td>
                            </tr>
                        <?php
                          }
                        } else {
                          // Display message if no products are found for this supply
                          echo "<tr><td colspan='4'>No products found for this supply.</td></tr>";
                        }

                        ?>
                      </tbody>



                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix">
                  <a href="stocks.php" class="btn btn-sm btn-success float-right">View All Stocks</a>
                </div>

              </div>
            </div>
          </div>

          <div class="row">

            <div class="col-md-7">

              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Latest Members</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>

                <div class="card-body p-0">
                  <ul class="users-list clearfix">

                    <?php
                    $display_memberdashboard= display_memberdashboard($conn);
                    while ($result = mysqli_fetch_array($display_memberdashboard)) {
                      extract($result);

                    ?>
                      <li>
                        <a href="../image//member/PROFILE/<?php echo $mprofile ?>" class="image-popup-vertical-fit">
                          <img style="height: 7.5rem;width: 7.5rem;object-fit: cover;}" src="../image//member/PROFILE/<?php echo $mprofile ?>" alt="User Image">
                        </a>

                        <a class="users-list-name" style="font-size: 15px;" href="member-profile.php?member_id=<?php echo $member_id ?>"><?php echo $mname ?></a>
                        <span class="users-list-date"><?php echo date('M d, Y', strtotime($started)) ?></span>
                      </li>
                    <?php   } ?>


                  </ul>

                </div>

                <div class="card-footer text-center">
                  <a class="btn btn-sm btn-success float-right" href="member-list.php">View All Member</a>
                </div>

              </div>

            </div>

            <div class="col-md-5">
              <div class="card bg-gradient-success">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Calendar
                  </h3>
                  <div class="card-tools">
                  
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body pt-0">
                  <div id="calendar" style="width: 100%"></div>
                </div>
              </div>
            </div>

          </div>

          <!-- <div class="modal fade" id="modal-thismonth">
            <div class="modal-dialog" style="max-width: 670px;">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">SALES FOR THIS MONTH</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table id="example1" class="table m-0">
                    <thead>
                      <tr>
                        <th style="width: 2%;">Order ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displaySoldthismonth = displaySoldthismonth($conn);


                      $totalPrice = 0;
                      $totalQuantity = 0;
                      $totalAmount = 0;

                      while ($result = mysqli_fetch_array($displaySoldthismonth)) {
                        extract($result);


                        $totalPrice += $price;
                        $totalQuantity += $orderquantity;
                        $totalAmount += $orderamount;
                      ?>
                        <tr>
                          <td style="color: #007bff;"><?php echo $pID ?></td>
                          <td><?php echo $productname ?></td>
                          <td><?php echo number_format($price, 2); ?></td>
                          <td><?php echo number_format($orderquantity); ?></td>
                          <td><?php echo number_format($orderamount, 2); ?></td>
                          <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2">Total</th>
                        <th><?php echo number_format($totalPrice, 2); ?></th>
                        <th><?php echo number_format($totalQuantity); ?></th>
                        <th><?php echo number_format($totalAmount, 2); ?></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>

                </div>

              </div>

            </div>

          </div>

          <div class="modal fade" id="modal-lastmonth">
            <div class="modal-dialog" style="max-width: 670px;">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">SALES FOR LAST MONTH</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table id="example2" class="table m-0">
                    <thead>
                      <tr>
                        <th style="width: 2%;">Order ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displaySoldlastMonth = displaySoldlastMonth($conn);


                      $totalPrice = 0;
                      $totalQuantity = 0;
                      $totalAmount = 0;

                      while ($result = mysqli_fetch_array($displaySoldlastMonth)) {
                        extract($result);


                        $totalPrice += $price;
                        $totalQuantity += $orderquantity;
                        $totalAmount += $orderamount;
                      ?>
                        <tr>
                          <td style="color: #007bff;"><?php echo $pID ?></td>
                          <td><?php echo $productname ?></td>
                          <td><?php echo number_format($price, 2); ?></td>
                          <td><?php echo number_format($orderquantity); ?></td>
                          <td><?php echo number_format($orderamount, 2); ?></td>
                          <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2">Total</th>
                        <th><?php echo number_format($totalPrice, 2); ?></th>
                        <th><?php echo number_format($totalQuantity); ?></th>
                        <th><?php echo number_format($totalAmount, 2); ?></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>

                </div>

              </div>

            </div>

          </div>

          
          <div class="modal fade" id="modal-lastyear">
            <div class="modal-dialog" style="max-width: 670px;">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">SALES FOR LAST YEAR</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <table id="example3" class="table m-0">
                    <thead>
                      <tr>
                        <th style="width: 2%;">Order ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displaySoldlastyear = displaySoldlastyear($conn);


                      $totalPrice = 0;
                      $totalQuantity = 0;
                      $totalAmount = 0;

                      while ($result = mysqli_fetch_array($displaySoldlastyear)) {
                        extract($result);


                        $totalPrice += $price;
                        $totalQuantity += $orderquantity;
                        $totalAmount += $orderamount;
                      ?>
                        <tr>
                          <td style="color: #007bff;"><?php echo $pID ?></td>
                          <td><?php echo $productname ?></td>
                          <td><?php echo number_format($price, 2); ?></td>
                          <td><?php echo number_format($orderquantity); ?></td>
                          <td><?php echo number_format($orderamount, 2); ?></td>
                          <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2">Total</th>
                        <th><?php echo number_format($totalPrice, 2); ?></th>
                        <th><?php echo number_format($totalQuantity); ?></th>
                        <th><?php echo number_format($totalAmount, 2); ?></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>


                </div>

              </div>

            </div>

          </div> -->


          <div class="modal fade" id="modal-interestsummary">
            <div class="modal-dialog" style="max-width: 670px;">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">INTEREST EARNED SUMMARY</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table id="example4" class="table m-0">
                    <thead>
                      <tr>
                        <th>Interest Earned</th>
                        <th>GenFund</th>
                        <th>Total Capital</th>
                        <th>Total Profit</th>
                        <th>Year</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayTotalinterestSummary = displayTotalinterestSummary($conn);

                      while ($result = mysqli_fetch_array($displayTotalinterestSummary)) {
                        extract($result);
                      ?>
                        <tr>

                          <td><?php echo number_format($total_interest, 2); ?></td>
                          <td><?php echo number_format($total_general_funds, 2); ?></td>
                          <td><?php echo number_format($total_capital, 2); ?></td>
                          <td><?php echo number_format($total_profit, 2); ?></td>
                          <td><?php echo $year; ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>


                </div>

              </div>

            </div>

          </div>



        </div>
      </section>

    </div>

    <footer class="main-footer">



    </footer>


    <aside class="control-sidebar control-sidebar-dark">

    </aside>

  </div>



  <?php include 'includes/script.php' ?>

  <script>
    $("#example2").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "searching": true,
      "ordering": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

    $("#example3").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "searching": true,
      "ordering": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
    $("#example4").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "searching": true,
      "ordering": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');


    $(document).ready(function() {
      // Initialize the Tempus Dominus date picker
      $('#calendar').datetimepicker({
        inline: true,
        format: 'L',
      });
    });
  </script>

  <script>
    $('.image-popup-vertical-fit').magnificPopup({
      type: 'image',
      closeOnContentClick: true,
      mainClass: 'mfp-img-mobile',
      image: {
        verticalFit: true
      }

    });
    $(document).ready(function() {

      $.ajax({
        url: '../inc/fetchsales.php', // Adjust the path as necessary
        type: 'GET',
        data: {
          action: 'getSalesData'
        },
        dataType: 'json',
        success: function(response) {
          console.log('Response:', response); // Log the response for debugging

          // Check if response has labels and data
          if (Array.isArray(response.labels) && Array.isArray(response.data)) {
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieData = {
              labels: response.labels,
              datasets: [{
                data: response.data,
                backgroundColor: [
                  '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                ],
              }]
            };
            var pieOptions = {
              maintainAspectRatio: false,
              responsive: true,
            };

            // Create pie chart
            new Chart(pieChartCanvas, {
              type: 'pie',
              data: pieData,
              options: pieOptions
            });
          } else {
            console.error('Invalid data format:', response);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Could not fetch sales data:', textStatus, errorThrown);
          console.log('Response text:', jqXHR.responseText); // Log the raw response for debugging
        }
      });
    });

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieData = {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: [
          '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc',
          '#8e44ad', '#2ecc71', '#e67e22', '#3498db', '#c0392b'
        ], // Add more colors if needed
      }]
    };
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    };

    // Create pie chart
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });
  </script>
</body>

</html>