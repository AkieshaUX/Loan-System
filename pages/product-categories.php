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
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box" data-toggle="modal" data-target="#modal-productEdit" style="cursor: pointer;">
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
                  <span class="info-box-text">Products Categories</span>
                  <span class="info-box-number"><?php echo $total_categories; ?></span>
                </div>
              </div>

            </div>
            <!-- <div class="col-md-3 col-sm-6 col-12">
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


            </div> -->

          </div>
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Products</h3>
                  </div>

                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-addsupply">
                    <i class="fa-solid fa-plus"></i>
                    Add Stocks
                  </button>
                  <button type="button" class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#modal-product">
                    <i class="fa-solid fa-plus"></i>
                    Add Product
                  </button>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $displayviewProduct = displayviewProduct($conn);
                      while ($result = mysqli_fetch_array($displayviewProduct)) {
                        extract($result);

                        $checkPendingQuery = "SELECT COUNT(*) AS count FROM orderproduct WHERE productsupply_id = $productsupply_id AND status = 'Pending'";
                        $checkResult = $conn->query($checkPendingQuery);
                        $pendingData = $checkResult->fetch_assoc();
                        $isPending = $pendingData['count'] > 0;

                      ?>
                        <tr>
                          <td><?php echo $productname ?></td>
                          <td class="text-center">
                            <button class="btn btn-info btn-sm" id="editproductLIst" data-productsupply-id="<?php echo $productsupply_id; ?>">
                              <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>

                            <!-- Conditionally disable the Delete button -->
                            <button class="btn btn-danger btn-sm deleteproductBTN" id="deleteproductBTN" data-productsupply-id="<?php echo $productsupply_id; ?>" <?php echo $isPending ? 'disabled' : ''; ?>>
                              <i class="fa-solid fa-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>



                  </table>

                </div>










                <div class="modal fade" id="modal-productEdit">
                  <div class="modal-dialog" style="max-width: 420px !important;">

                    <div class="tab-content">
                      <div class="loan-form">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Products Categories</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                            <form id="editproductForm" method="POST" action="../inc/controller.php" class="form-horizontal">
                              <div class="card-body">
                                <div class="form-group">
                                  <label>Product Name</label>
                                  <input type="hidden" class="form-control" id="productsupplyID" name="productsupply_id">
                                  <div class="piedad">
                                    <input type="text" class="form-control" id="productname" name="productname" placeholder="Update Product">
                                    <button type="submit" class="btn btn-primary mt-2" style="width: 100%;">Save Changes</button>
                                  </div>
                                </div>

                              </div>
                            </form>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>Product Name</th>
                                  <th></th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php
                                $displayviewProduct = displayviewProduct($conn);
                                while ($result = mysqli_fetch_array($displayviewProduct)) {
                                  extract($result);

                                  $checkPendingQuery = "SELECT COUNT(*) AS count FROM orderproduct WHERE productsupply_id = $productsupply_id AND status = 'Pending'";
                                  $checkResult = $conn->query($checkPendingQuery);
                                  $pendingData = $checkResult->fetch_assoc();
                                  $isPending = $pendingData['count'] > 0;

                                ?>
                                  <tr>
                                    <td><?php echo $productname ?></td>
                                    <td class="text-center">
                                      <button class="btn btn-info btn-sm" id="editproductLIst" data-productsupply-id="<?php echo $productsupply_id; ?>">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                      </button>

                                      <!-- Conditionally disable the Delete button -->
                                      <button class="btn btn-danger btn-sm deleteproductBTN" id="deleteproductBTN" data-productsupply-id="<?php echo $productsupply_id; ?>" <?php echo $isPending ? 'disabled' : ''; ?>>
                                        <i class="fa-solid fa-trash"></i> Delete
                                      </button>
                                    </td>
                                  </tr>
                                <?php
                                }
                                ?>
                              </tbody>



                            </table>
                          </div>
                          <div class="modal-footer justify-content-between">


                          </div>
                        </div>
                      </div>
                    </div>

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



</body>

</html>