<?php include '../inc/session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>


    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">
          <div class="row">


            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-solid fa-cart-shopping"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(orderamount) AS total_amount FROM orderproduct WHERE `status` = 'Buy'");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_amount = isset($result['total_amount']) ?  $result['total_amount'] : 0.00;
                } else {
                  $total_paid = 0.00;
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
                $query = mysqli_query($conn, "SELECT SUM(minuscoast) AS total_coast FROM orderproduct WHERE `status` = 'Buy'");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_coast = isset($result['total_coast']) ?  $result['total_coast'] : 0.00;
                } else {
                  $total_paid = 0.00;
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
                $query = mysqli_query($conn, "SELECT SUM(totalincome) AS total_income FROM orderproduct WHERE `status` = 'Buy'");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_income = isset($result['total_income']) ?  $result['total_income'] : 0.00;
                } else {
                  $total_paid = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Net Income</span>
                  <span class="info-box-number"><?php echo number_format($total_income, 2); ?></span>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <a href="withdraw-sales.php">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i style="color: white;" class="fa-solid fa-cash-register"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Withdraw</span>
                    <span class="info-box-number"></span>
                  </div>
                </div>
              </a>
            </div>

          </div>

          <div class="row">
            <div class="col-md-9">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Annual Sales Summary</h3>
                  </div>
                </div>


                <div class="card-body">

                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>

                        <th>Total Sales</th>
                        <th>Total Delivered</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayPurchasesummary = displayPurchasesummary($conn);
                      while ($result = mysqli_fetch_array($displayPurchasesummary)) {
                        extract($result);
                      ?>
                        <tr>

                          <td><?php echo number_format($total_orderamount, 2); ?></td>
                          <td><?php echo $total_quanitity ?></td>
                          <td><a href="purchase-summary-view.php?&year=<?php echo $year ?>">
                              <?php echo date('M Y', strtotime($min_date)) . '-' . date('M Y', strtotime($max_date)); ?>
                            </a></td>
                          <td><span class="badge badge-success" style="color: #fff;">Delivered </span></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>

                </div>
              </div>

            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Annual Sales</h3>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
    $(document).ready(function() {

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


    });
  </script>





</body>

</html>