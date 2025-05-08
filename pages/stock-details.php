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

          <!-- <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <a href=" product-list.php">
                <div class="info-box">
                  <span class="info-box-icon bg-primary"><i class="fa-solid fa-layer-group"></i></span>
                  <?php
                  $query = mysqli_query($conn, "SELECT count(productname) AS total_categories FROM productsupply WHERE productsupply_status IS NULL");
                  if ($query) {
                    $result = mysqli_fetch_assoc($query);
                    $total_categories = isset($result['total_categories']) ? $result['total_categories'] : 0;
                  } else {
                    $total_categories = 0;
                  }
                  ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Products List</span>
                    <span class="info-box-number"><?php echo $total_categories; ?></span>
                  </div>
                </div>
              </a>

            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-chart-bar"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(quantity) AS total_quantity FROM product");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_quantity = isset($result['total_quantity']) ? $result['total_quantity'] : 0;
                } else {
                  $total_quantity = 0;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Products</span>
                  <span class="info-box-number"><?php echo number_format($total_quantity, 2); ?></span>
                </div>
              </div>


            </div>

          </div> -->

          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Stocks Details</h3>
                  </div>
                
                </div>


                <div class="card-body">
                  
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Total Qty</th>
                        <!-- <th>Available Stocks</th> -->
                        <!-- <th>Price</th> -->
                        <th>Date</th>

                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      // Check if both `productsupply_id` and `price` are passed via GET
                      if (isset($_GET['productsupply_id']) && isset($_GET['price'])) {
                        // Escape the GET values to prevent SQL injection
                        $productsupply_id = mysqli_real_escape_string($conn, $_GET['productsupply_id']);
                        $price = mysqli_real_escape_string($conn, $_GET['price']);

                        // Query to fetch products based on productsupply_id and price
                        $query = mysqli_query($conn, "
                          SELECT product.*, productsupply.* 
                          FROM `product` 
                          INNER JOIN productsupply 
                          ON product.productsupply_id = productsupply.productsupply_id 
                          WHERE productsupply.productsupply_id = '$productsupply_id' 
                          AND product.price = '$price' 
                          ORDER BY product.productdate DESC
                        ");

                        // Check if the query returns any rows
                        if (mysqli_num_rows($query) > 0) {
                          while ($result = mysqli_fetch_array($query)) {
                            extract($result);
                      ?>
                            <tr>
                              <td><?php echo $pID?></td>
                              <td><?php echo $productname; ?></td>
                              <td><?php echo number_format($total_quantity); ?></td>
                              <!-- <td><?php echo number_format($total_quantity); ?></td> -->
                              <!-- <td><?php echo number_format($price, 2); ?></td> -->
                              <td><?php echo date('M d, Y', strtotime($productdate))?></td>
                            </tr>
                      <?php
                          }
                        } else {
                          // Display message if no products are found for this supply
                          echo "<tr><td colspan='4'>No products found for this supply.</td></tr>";
                        }
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



</body>

</html>