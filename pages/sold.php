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

              <?php include '../inc/chartsales.php' ?>
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Sales Chart</h3>
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
                        <h3>Sales Summary</h3>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card-title float-right">
                        <form method="GET" action="" style="display: flex; gap: 15px;">
                          <input name="datetime" type="month" id="datetime" class="form-control" value="<?php echo isset($_GET['datetime']) ? $_GET['datetime'] : ''; ?>">
                          <div class="btn-wrap d-flex">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <button type="button" id="resetFilter" class="btn btn-danger">Reset</button>
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
                        <th>Customer</th>
                        <th style="width: 2%;">Order ID</th>
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
                      $displayProductBuy = displayProductBuy($conn);
                      while ($result = mysqli_fetch_array($displayProductBuy)) {
                        extract($result);
                      ?>
                        <tr>
                          <td><?php echo $ordername ?></td>
                          <td style="color: #007bff;"><?php echo $pID ?></td>
                          <td><?php echo $productname ?></td>
                          <td><?php echo number_format($price, 2); ?></td>
                          <td><?php echo number_format($orderquantity); ?></td>
                          <td><?php echo number_format($orderamount, 2); ?></td>
                          <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                          <td style="cursor: pointer;" id="orderreciept" class="orderreciept" data-order-id="<?php echo $order_id; ?>"
                            data-toggle="modal" data-target="#modal-viewinvoice">
                            <span class="badge badge-success" style="color: #fff;">Delivered</span>
                          </td>
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
  var salesMonths = <?php echo json_encode($final_months); ?>;
  var salesData = <?php echo $final_sales_data_json; ?>;

  // Get the list of years from the PHP data
  var years = Object.keys(salesData);

  // Define an array of colors for each year
  var colors = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#fd7e14', '#6610f2', '#e83e8c'];

  // Prepare datasets dynamically for all years
  var datasets = years.map(function(year, index) {
    return {
      label: year + ' Sales', // Dynamic label for each year
      backgroundColor: colors[index % colors.length], // Assign different color for each year, cycling through the colors array
      borderColor: colors[index % colors.length],
      data: salesData[year], // Sales data for the specific year
      datalabels: {
        align: 'top',
        color: 'white',
        font: {
          weight: 'bold',
          size: 12
        },
        formatter: function(value) {
          return value ? value.toFixed(2) : '0'; // Format the sales value to 2 decimals
        }
      }
    };
  });

  var barChartCanvas = document.getElementById('barChart').getContext('2d');

  // Bar Chart Options
  var barChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    datasetFill: false,
    plugins: {
      datalabels: {
        display: true
      }
    }
  };

  // Create the Bar Chart
  new Chart(barChartCanvas, {
    type: 'bar',
    data: {
      labels: salesMonths, // All months (January to December)
      datasets: datasets // All datasets dynamically generated for each year
    },
    options: barChartOptions
  });
</script>






  <script>
    document.getElementById('resetFilter').addEventListener('click', function() {
      // Clear the month input and reload the page
      document.getElementById('datetime').value = '';
      window.location.href = window.location.pathname;
    });
  </script>


</body>

</html>