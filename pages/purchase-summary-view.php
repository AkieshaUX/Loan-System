<?php include '../inc/session.php'?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/link.php'; ?>
</head>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-solid fa-cart-shopping"></i></span>
                <?php
                $year = isset($_GET['year']) ? intval($_GET['year']) : null; // Get year from URL
                $yearCondition = $year ? "AND YEAR(date) = $year" : ""; // Conditional query part
                $query = mysqli_query($conn, "SELECT SUM(orderamount) AS total_amount FROM orderproduct WHERE status = 'Buy' $yearCondition");
                $total_amount = 0.00;
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_amount = isset($result['total_amount']) ? $result['total_amount'] : 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Sales</span>
                  <span class="info-box-number"><?php echo number_format($total_amount, 2); ?></span>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa-solid fa-question"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(minuscoast) AS total_coast FROM orderproduct WHERE status = 'Buy' $yearCondition");
                $total_coast = 0.00;
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_coast = isset($result['total_coast']) ? $result['total_coast'] : 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Miscellaneous</span>
                  <span class="info-box-number"><?php echo number_format($total_coast, 2); ?></span>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-sack-dollar"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(totalincome) AS total_income FROM orderproduct WHERE status = 'Buy' $yearCondition");
                $total_income = 0.00;
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_income = isset($result['total_income']) ? $result['total_income'] : 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Net Income</span>
                  <span class="info-box-number"><?php echo number_format($total_income, 2); ?></span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Monthly Sales Summary</h3>
                  </div>
                </div>
                <div class="card-body">
                  <?php
                  $year = isset($_GET['year']) ? $_GET['year'] : null;
                  $displayPurchasesummaryView = displayPurchasesummaryView($conn, $year);
                  ?>
                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Delivered</th>
                        <th>Sales</th>
                        <th>Miscellaneous</th>
                        <th>Net Income</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($result = mysqli_fetch_array($displayPurchasesummaryView)) { ?>
                        <tr>
                          <td style="color: #007bff;"><?php echo $result['pID']?></td>
                          <td><?php echo $result['productname']?></td>
                          <td><?php echo number_format($result['price'], 2); ?></td>
                          <td><?php echo $result['orderquantity']; ?></td>
                          <td><?php echo number_format($result['orderamount'], 2); ?></td>
                          <td><?php echo number_format($result['minuscoast'] ?? 0.00, 2); ?></td>
                          <td><?php echo number_format($result['totalincome'], 2); ?></td>
                          <td><?php echo date('M d, Y', strtotime($result['date'])); ?></td>
                          <td><span class="badge badge-success" style="color: #fff;">Delivered</span></td>
                        </tr>
                      <?php } ?>
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
  <?php include 'includes/script.php'; ?>

</body>

</html>