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


            <!-- <div class="col-md-3 col-sm-6 col-12">
              <a href="purchase-summary.php" style="color: #212529 !important;">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fa-solid fa-cart-shopping"></i></span>
                  <?php
                  $query = "SELECT COUNT(*) AS pending_count   FROM orderproduct   WHERE status = 'Buy'";
                  $result = $conn->query($query);
                  $pendingCount = 0;

                  if ($result) {
                    $row = $result->fetch_assoc();
                    $pendingCount = $row['pending_count'];
                  }
                  ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Delivered</span>
                    <span class="info-box-number"><?php echo $pendingCount; ?></span>
                  </div>
                </div>
              </a>
            </div> -->

            <div class="col-md-3 col-sm-6 col-12">
              <a href="pending.php" style="color: #212529 !important;">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fa-solid fa-cart-plus"></i></span>
                  <?php
                  $query = "SELECT COUNT(*) AS pending_count   FROM orderproduct   WHERE status = 'Pending'";
                  $result = $conn->query($query);
                  $pendingCount = 0;

                  if ($result) {
                    $row = $result->fetch_assoc();
                    $pendingCount = $row['pending_count'];
                  }
                  ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Pending Orders</span>
                    <span class="info-box-number" style="color: red !important;"><?php echo $pendingCount; ?></span>
                  </div>
                </div>
              </a>
            </div>

          </div>

          <div class="row">
            <div class="col-md-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Orders</h3>
                  </div>

                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-ordernow">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Order Now
                  </button>


                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>
                        <th>Customer</th>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Price </th>
                        <th>Quantity</th>
                        <th>Total Price </th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Receipt</th>


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
                          <td><?php echo number_format($orderquantity); ?>pcs</td>
                          <td><?php echo number_format($orderamount, 2); ?></td>

                          <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                          <td><span class="badge badge-success" style="color: #fff;">Delived</span>
                          </td>
                          <td style="cursor: pointer;" id="orderreciept" class="orderreciept" data-order-id="<?php echo $order_id; ?>"
                            data-toggle="modal" data-target="#modal-viewinvoice"><i class="fa-solid fa-print" style="color:#007bff"></i></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>

                </div>

                <div class="modal fade" id="modal-ordernow">
                  <div class="modal-dialog" style="max-width: 525px !important;">
                    <form id="orderForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Order Now</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Product Name</label>
                                  <div class="col-sm-9">
                                    <select id="product-select" class="form-control select2bs4" data-placeholder="Select Product" name="productsupply_id" style="width: 100%;">
                                      <option selected disabled>Select one</option>
                                      <?php
                                      $query = mysqli_query($conn, "SELECT productsupply.*, product.* FROM `product` INNER JOIN `productsupply` ON product.productsupply_id = productsupply.productsupply_id WHERE product.product_status IS NULL AND product.coast IS NOT NULL AND product.quantity > 0 ORDER BY productsupply.productsupply_id");
                                      while ($result = mysqli_fetch_array($query)) {
                                        extract($result);
                                      ?>
                                        <option value="<?php echo $productsupply_id . '|' . $product_id; ?>" data-price="<?php echo $price; ?>">
                                          <?php echo $pID . ' - ' . $productname . ' - ' . $quantity .'pcs' ?>
                                        </option>

                                      <?php } ?>
                                    </select>



                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Price</label>
                                  <div class="col-sm-9">
                                    <input id="price" name="price" type="number" class="form-control" placeholder="Price" readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Quantity</label>
                                  <div class="col-sm-9">
                                    <input id="quantity-input" name="quantity" type="number" class="form-control" placeholder="Quantity" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Total Cost</label>
                                  <div class="col-sm-9">
                                    <input id="total-cost-input" name="coast" type="number" class="form-control" placeholder="Total Cost" readonly>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Name</label>
                                  <div class="col-sm-9">
                                    <input id="total-cost-input" name="ordername" type="text" class="form-control" placeholder="Enter Name">
                                  </div>
                                </div>


                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="modal fade" id="modal-editsupply">
                  <div class="modal-dialog" style="max-width: 525px !important;">
                    <form id="Editproduct" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Edit Stocks</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Product Name</label>
                                  <div class="col-sm-9">
                                    <select class="form-control select2bs4" data-placeholder="Select Product" name="productsupply_id" id="productsupply_id" style="width: 100%;">
                                      <option selected disabled>Select one</option>
                                      <?php
                                      // Creating a PHP array to hold product prices for JavaScript
                                      $productPrices = [];
                                      $query = mysqli_query($conn, "SELECT * FROM `productsupply`");
                                      while ($result = mysqli_fetch_array($query)) {
                                        extract($result);
                                        $productPrices[$productsupply_id] = $price; // Assuming $price is available in $result
                                      ?>
                                        <option value="<?php echo $productsupply_id; ?>"><?php echo $productname; ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <input type="hidden" name="product_id" id="editsupplyproduct_id">
                                  <label class="col-sm-3 col-form-label">Price</label>
                                  <div class="col-sm-9">
                                    <input name="price" id="price" type="number" class="form-control" placeholder="Price" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Date</label>
                                  <div class="col-sm-9">
                                    <input name="date" id="date" type="date" class="form-control" placeholder="Date" required>
                                  </div>
                                </div>

                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="modal fade" id="modal-product">
                  <div class="modal-dialog" style="max-width: 525px !important;">
                    <form id="addproducts" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Add Product</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Product Name</label>
                                  <div class="col-sm-9">
                                    <input name="productname" type=text" placeholder="Product Name" class="form-control" required>
                                  </div>
                                </div>

                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>


                <div class="modal fade" id="modal-plus">
                  <div class="modal-dialog" style="max-width: 380px !important;">
                    <form id="plusquantityForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Total quantity: <span id="plustotalquantitytext"></span></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pl-0 pr-0">
                              <div class="card-body">
                                <div class="form-group ">
                                  <label>Add Quantity</label>
                                  <input type="hidden" name="product_id" id="plusproduct_id">
                                  <input name="plusquantity" type="number" class="form-control" placeholder="Add new quantity" required>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Add new</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="modal fade" id="modal-minus">
                  <div class="modal-dialog" style="max-width: 380px !important;">
                    <form id="minusquantityForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Total quantity: <span id="minustotalquantitytext"></span></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pl-0 pr-0">
                              <div class="card-body">
                                <div class="form-group ">
                                  <label>Minus Quantity</label>
                                  <input type="hidden" name="product_id" id="minusproduct_id">
                                  <input name="minusquantity" type="number" class="form-control" placeholder="Minus quantity" required>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Add new</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
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

            <!-- <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Top Sales</h3>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>



              </div>
            </div> -->

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

      $('#product-select').on('change', function() {
        var price = $(this).find(':selected').data('price');
        $('#price').val(price);
        $('#total-cost-input').val('');
        $('#quantity-input').val('');
      });


      $('#quantity-input').on('input', function() {
        var quantity = $(this).val();
        var price = $('#price').val();


        if ($.isNumeric(quantity) && $.isNumeric(price)) {
          var totalCost = quantity * price;
          $('#total-cost-input').val(totalCost.toFixed(2));
        } else {
          $('#total-cost-input').val('');
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


    });
  </script>





</body>

</html>