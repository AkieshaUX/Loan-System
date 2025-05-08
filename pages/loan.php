<?php include '../inc/session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>
<style>
  #invoiceContent p {
    margin: 0;
    font-size: 13px;
  }

  #invoiceContent h5 {
    font-size: 15px;
    font-weight: bold;
  }



  #invoiceContent th,
  #invoiceContent td {
    padding: 8px;
    text-align: left;
  }

  #invoiceContent th {
    background-color: #f8f8f8;
  }

  .text-center {
    text-align: center;
  }

  .text-right {
    text-align: right;
  }

  .border-bottom {
    border-bottom: 1px solid #e0e0e0;
  }

  .lead {
    font-size: 1.25em;
    font-weight: bold;
  }

  address {
    font-size: 13px;
  }
</style>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>


    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php include '../inc/chartloan.php'; ?>
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Loan Chart</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card-title float-left">
                        <h3>Loan Summary</h3>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card-title float-right">
                        <form method="GET" action="" style="display: flex; gap: 15px; margin-bottom: 20px;">
                          <input
                            name="date"
                            type="month"
                            id="date"
                            class="form-control"
                            value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>">
                          <div class="btn-wrap d-flex">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <button type="button" id="resetFilter" class="btn btn-danger" onclick="window.location.href='';">Reset</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card-body">

                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>
                        <th>Full Name</th>
                        <th>Purpose</th>
                        <th>Amount</th>
                        <th>Interest</th>
                        <th>T/Interest</th>
                        <th>M/Interest</th>
                        <th>T/Payment</th>
                        <th>M/Payment</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Call the function with the selected month filter
                      $filterDate = isset($_GET['date']) ? $_GET['date'] : null;
                      $displayLoanreport = displayLoanreport($conn, $filterDate);

                      // Loop through and display the filtered data
                      while ($result = mysqli_fetch_array($displayLoanreport)) {
                        extract($result);
                      ?>
                        <tr>
                          <td><?php echo $mname; ?></td>
                          <td><?php echo $purpose; ?></td>
                          <td><?php echo number_format($amount, 2); ?></td>
                          <td><?php echo $interest; ?>%</td>
                          <td><?php echo number_format($totalinterest, 2); ?></td>
                          <td><?php echo number_format($monthlyinterest, 2); ?></td>
                          <td><?php echo number_format($totalpayment, 2); ?></td>
                          <td><?php echo number_format($monthlypayment, 2); ?></td>
                          <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>




                </div>








                <div class="modal fade" id="modal-viewinvoice">
                  <div class="modal-dialog piedad" style="max-width: 365px  !important;">
                    <form id="confirmationreference">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Order Receipt</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="invoiceContent">
                          <div class="invoice p-3 mb-3">
                            <!-- Header Section -->
                            <div class="row">
                              <div class="col-12 text-left">
                                <strong>
                                  <h5>Pineapple Growers and Farmer's Association</h5>
                                </strong>
                              </div>
                            </div>

                            <!-- Invoice Details -->
                            <div class="row mt-0 mb-0">
                              <div class="col-6">
                                <p class="d-flex">Invoice Date: <span id="dates"></span></p>
                                <p>Order ID: <span id="invoice_number"></span></p>
                              </div>
                            </div>

                            <!-- Billing Information -->
                            <div class="row border-bottom pb-3 mb-3">
                              <div class="col-12">
                                <address style="margin: 0; gap: 1px;" class="d-flex">
                                  <p>Customer:</p>
                                  <p id="mname"></p>
                                </address>
                              </div>
                            </div>

                            <!-- Table Section with Product Details -->
                            <div class="row border-bottom pb-3 mb-3">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td id="productname"></td>
                                    <td id="orderquantity"></td>
                                    <td id="priceS"></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                            <!-- Amount Section Below the Table -->
                            <div class="row mb-3">
                              <div class="col-12 text-right">
                                <p><strong>Amount:</strong> <span id="totalincome"></span></p>
                              </div>
                            </div>

                            <!-- Footer Message -->
                            <div class="row mt-4">
                              <div class="col-12 text-center">
                                <p>Thank you! We appreciate your trust in us and look forward to serving you again.</p>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-default" onclick="printInvoice()">
                            <i class="fas fa-print"></i> Print
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>




              </div>

            </div>

          </div>

          <div class="row">
            <div class="col-md-12">
              <?php include '../inc/chartinterest.php'; ?>
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Interest Earned Chart</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChartinterest" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card-title float-left">
                        <h3>Interest Earned Summary</h3>
                      </div>
                    </div>

                    <!-- <div class="col-md-6">
                      <div class="card-title float-right">
                        <form method="GET" action="" style="display: flex; gap: 15px; margin-bottom: 20px;">
                          <input
                            name="date"
                            type="month"
                            id="date"
                            class="form-control"
                            value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>">
                          <div class="btn-wrap d-flex">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <button type="button" id="resetFilter" class="btn btn-danger" onclick="window.location.href='';">Reset</button>
                          </div>
                        </form>
                      </div>
                    </div> -->

                  </div>
                </div>


                <div class="card-body">

                  <table id="example2" class="table table-striped">
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








                <div class="modal fade" id="modal-viewinvoice">
                  <div class="modal-dialog piedad" style="max-width: 365px  !important;">
                    <form id="confirmationreference">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Order Receipt</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="invoiceContent">
                          <div class="invoice p-3 mb-3">
                            <!-- Header Section -->
                            <div class="row">
                              <div class="col-12 text-left">
                                <strong>
                                  <h5>Pineapple Growers and Farmer's Association</h5>
                                </strong>
                              </div>
                            </div>

                            <!-- Invoice Details -->
                            <div class="row mt-0 mb-0">
                              <div class="col-6">
                                <p class="d-flex">Invoice Date: <span id="dates"></span></p>
                                <p>Order ID: <span id="invoice_number"></span></p>
                              </div>
                            </div>

                            <!-- Billing Information -->
                            <div class="row border-bottom pb-3 mb-3">
                              <div class="col-12">
                                <address style="margin: 0; gap: 1px;" class="d-flex">
                                  <p>Customer:</p>
                                  <p id="mname"></p>
                                </address>
                              </div>
                            </div>

                            <!-- Table Section with Product Details -->
                            <div class="row border-bottom pb-3 mb-3">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td id="productname"></td>
                                    <td id="orderquantity"></td>
                                    <td id="priceS"></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                            <!-- Amount Section Below the Table -->
                            <div class="row mb-3">
                              <div class="col-12 text-right">
                                <p><strong>Amount:</strong> <span id="totalincome"></span></p>
                              </div>
                            </div>

                            <!-- Footer Message -->
                            <div class="row mt-4">
                              <div class="col-12 text-center">
                                <p>Thank you! We appreciate your trust in us and look forward to serving you again.</p>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-default" onclick="printInvoice()">
                            <i class="fas fa-print"></i> Print
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
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
    // Passing the PHP data to JavaScript
    var thisYearLoans = <?php echo json_encode($final_this_year_loans); ?>;
    var lastYearLoans = <?php echo json_encode($final_last_year_loans); ?>;

    // Getting the current year in PHP and passing it to JavaScript
    var currentYear = new Date().getFullYear(); // Get the current year using JavaScript

    console.log('This Year Loans:', thisYearLoans);
    console.log('Last Year Loans:', lastYearLoans);
    console.log('Current Year:', currentYear); // Log the current year
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var barChartCanvas = document.getElementById('barChart').getContext('2d');

      // Labels for the months
      var labelsForMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

      // Prepare datasets for each year dynamically
      var datasets = [];
      var colors = ['#28a745', '#007bff', '#ffc107', '#dc3545', '#17a2b8']; // Different colors for each year
      var colorIndex = 0;

      // Loop through the loan data to create datasets for each year
      Object.keys(loanData).forEach(function(year) {
        datasets.push({
          label: year + ' Loan Amount',
          backgroundColor: colors[colorIndex % colors.length],
          borderColor: colors[colorIndex % colors.length],
          data: loanData[year].amounts, // Loan amounts for this year
        });
        colorIndex++;
      });

      // Chart data configuration
      var barChartData = {
        labels: labelsForMonths,
        datasets: datasets
      };

      // Chart options
      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
      };

      // Create the chart
      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions,
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var barChartCanvas = document.getElementById('barChartinterest').getContext('2d');

      // Pass PHP JSON data to JavaScript
      var chartData = <?php echo $chartDataJson; ?>;

      // Extract years and data
      var years = chartData.map(data => data.year);
      var totalInterest = chartData.map(data => data.total_interest);
      var totalGeneralFunds = chartData.map(data => data.total_general_funds);
      var totalCapital = chartData.map(data => data.total_capital);
      var totalProfit = chartData.map(data => data.total_profit);

      // Chart configuration
      var barChartData = {
        labels: years, // Use years as labels
        datasets: [{
            label: 'Total Interest',
            backgroundColor: '#28a745',
            borderColor: '#28a745',
            data: totalInterest,
          },
          {
            label: 'General Funds',
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: totalGeneralFunds,
          },
          {
            label: 'Capital',
            backgroundColor: '#ffc107',
            borderColor: '#ffc107',
            data: totalCapital,
          },
          {
            label: 'Profit',
            backgroundColor: '#dc3545',
            borderColor: '#dc3545',
            data: totalProfit,
          }
        ]
      };

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            title: {
              display: true,
              text: 'Year',
            },
          },
          y: {
            title: {
              display: true,
              text: 'Amount',
            },
          },
        },
      };

      // Create the bar chart
      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions,
      });

      // Debugging logs
      console.log("Years:", years);
      console.log("Total Interest:", totalInterest);
      console.log("General Funds:", totalGeneralFunds);
      console.log("Capital:", totalCapital);
      console.log("Profit:", totalProfit);
    });
  </script>
  <script>
    document.getElementById('resetFilter').addEventListener('click', function() {
      window.location.href = window.location.pathname; // Redirect to the same page without query parameters
    });
  </script>







  <script>
    $("#example2").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "searching": true,
      "ordering": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
  </script>





</body>

</html>