<?php include '../inc/session.php'?>
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

            <!-- <div class="col-md-3 col-sm-6 col-12">
              <a href="pending.php" style="color: #212529 !important;">
                <div class="info-box">
                  <span class="info-box-icon bg-danger"><i class="fa-solid fa-cart-plus"></i></span>
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
            </div> -->

          </div>
          <div class="row">
            <div class="col-md-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Pending Orders</h3>
                  </div>

                  <a href="order.php" class="btn btn-primary float-right">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Order Now
                  </a>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>
                        <th>Customer</th>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                    
                        <th>Qty</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayProductPending = displayProductPending($conn);
                      while ($result = mysqli_fetch_array($displayProductPending)) {
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
                          <td><span class="badge badge-warning" style="color: #fff;"><?php echo $status; ?></span></td>
                          <td class="text-center">
                            <button class="btn btn-info btn-sm" id="EDITpendingBTN" data-order-id="<?php echo $order_id; ?>" data-product-id="<?php echo $productsupply_id; ?>" data-toggle="modal" data-target="#modal-ordernow">
                              <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                            <button class="btn btn-success btn-sm buyBTN" id="buyBTN" data-order-id="<?php echo $order_id; ?>" data-product-id="<?php echo $product_id; ?>">
                              <i class="fa-solid fa-cart-shopping"></i> Delivered
                            </button>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

                <div class="modal fade" id="modal-ordernow">
                  <div class="modal-dialog" style="max-width: 525px !important;">
                    <form id="editorderForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                      <div class="tab-content">
                        <div class="loan-form">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Pending Order</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Product Name</label>
                                  <div class="col-sm-9">
                                    <input id="productname" type="text" class="form-control totalcost-input" readonly>

                                    <input type="hidden" id="order_id" name="order_id">
                                    <input type="hidden" id="productsupply_id" name="productsupply_id">
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
                                    <input id="quantityinput" name="quantity" type="number" class="form-control quantity-input" placeholder="Quantity" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Total Cost</label>
                                  <div class="col-sm-9">
                                    <input id="totalcostinput" name="coast" type="number" class="form-control totalcost-input" placeholder="Total Cost" readonly>
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


        if (!$('#quantityinput').val()) {
          $('#quantityinput').val('');
        }
        if (!$('#totalcostinput').val()) {
          $('#totalcostinput').val('');
        }
      });


      $('#quantityinput').on('input', function() {
        var quantity = $(this).val();
        var price = $('#price').val();

        if ($.isNumeric(quantity) && $.isNumeric(price)) {
          var totalCost = quantity * price;
          $('#totalcostinput').val(totalCost.toFixed(2));
        } else {
          $('#totalcostinput').val('');
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